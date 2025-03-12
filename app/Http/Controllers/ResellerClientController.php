<?php

namespace App\Http\Controllers;

use App\Models\ResellerClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class ResellerClientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('is.reseller')->except(['login']);
    }

    /**
     * Display the reseller dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $user = Auth::user();
        $clients = $user->clients()->latest()->get();
        $clientCount = $clients->count();
        $maxClients = $user->max_clients;
        $activeClients = $clients->where('active', true)->count();
        $expiredClients = $clients->filter->isExpired()->count();

        return view('reseller.dashboard', compact(
            'user',
            'clients',
            'clientCount',
            'maxClients',
            'activeClients',
            'expiredClients'
        ));
    }

    /**
     * Display a listing of the clients.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Auth::user()->clients()->latest()->paginate(10);
        return view('reseller.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new client.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        
        if (!$user->canAddMoreClients()) {
            return redirect()->route('reseller.clients.index')
                ->with('error', 'You have reached your maximum client limit. Please contact an administrator to increase your limit.');
        }
        
        return view('reseller.clients.create');
    }

    /**
     * Store a newly created client in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->authorize('create', ResellerClient::class);
            
            $validated = $request->validate([
                'username' => 'required|string|max:255',
                'password' => 'required|string|min:8',
                'active' => 'sometimes|boolean',
                'expires_at' => 'nullable|date',
                'can_be_reseller' => 'sometimes|boolean',
            ]);
            
            if (!Auth::user()->canAddMoreClients()) {
                return back()->with('error', 'You have reached your maximum client limit.');
            }
            
            $client = new ResellerClient();
            $client->reseller_id = Auth::id();
            $client->username = $validated['username'];
            $client->password = Hash::make($validated['password']);
            $client->active = $request->has('active') ? $validated['active'] : true;
            $client->expires_at = $validated['expires_at'] ?? null;
            $client->can_be_reseller = $request->has('can_be_reseller') ? $validated['can_be_reseller'] : false;
            $client->save();
            
            return redirect()->route('reseller.clients.index')
                ->with('status', 'Client created successfully.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create client: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified client.
     *
     * @param  \App\Models\ResellerClient  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(ResellerClient $client)
    {
        $this->authorize('update', $client);
        
        return view('reseller.clients.edit', compact('client'));
    }

    /**
     * Update the specified client in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ResellerClient  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ResellerClient $client)
    {
        try {
            $this->authorize('update', $client);
            
            $validated = $request->validate([
                'username' => 'required|string|max:255|unique:reseller.reseller_clients,username,' . $client->id,
                'password' => 'sometimes|nullable|string|min:6',
                'active' => 'sometimes|boolean',
                'expires_at' => 'nullable|date|after:today',
            ]);
            
            $client->username = $validated['username'];
            
            if ($request->filled('password')) {
                $client->password = $validated['password'];
            }
            
            $client->active = $request->has('active');
            $client->expires_at = $validated['expires_at'] ?? null;
            $client->save();
            
            return redirect()->route('reseller.clients.index')
                ->with('success', "Client '{$client->username}' updated successfully.");
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error updating reseller client: ' . $e->getMessage());
            
            return redirect()->route('reseller.clients.index')
                ->with('error', 'An error occurred while updating the client. Please try again or contact support.');
        }
    }

    /**
     * Remove the specified client from storage.
     *
     * @param  \App\Models\ResellerClient  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResellerClient $client)
    {
        try {
            $this->authorize('delete', $client);
            
            $username = $client->username;
            $client->delete();
            
            return redirect()->route('reseller.clients.index')
                ->with('success', "Client '{$username}' deleted successfully.");
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error deleting reseller client: ' . $e->getMessage());
            
            return redirect()->route('reseller.clients.index')
                ->with('error', 'An error occurred while deleting the client. Please try again or contact support.');
        }
    }

    /**
     * Handle client login authentication.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
            ]);
            
            $client = ResellerClient::where('username', $request->username)
                                    ->where('active', true)
                                    ->first();
            
            if (!$client || !Hash::check($request->password, $client->password)) {
                throw ValidationException::withMessages([
                    'username' => ['The provided credentials are incorrect.'],
                ]);
            }
            
            if ($client->isExpired()) {
                throw ValidationException::withMessages([
                    'username' => ['Your account has expired. Please contact your reseller.'],
                ]);
            }
            
            // Create a client session token
            $token = Str::random(60);
            session(['client_id' => $client->id, 'client_token' => $token]);
            
            return redirect()->route('client.dashboard')
                ->with('success', 'Login successful.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error during client login: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'An error occurred during login. Please try again or contact support.');
        }
    }
}
