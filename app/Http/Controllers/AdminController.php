<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'isAdmin']);
    }

    public function dashboard()
    {
        $totalUsers = User::count();
        $allUsers = User::all();
        $premiumUsers = User::whereNotNull('premium_type')->count();
        $allPremiumUsers = User::where('premium_type', 'All')->count();
        $externalUsers = User::where('premium_type', 'External')->count();
        $streamerUsers = User::where('premium_type', 'Streamer')->count();
        $bypassUsers = User::where('premium_type', 'Bypass')->count();
        $resellerUsers = User::where('premium_type', 'Reseller')->count();
        $othersUsers = User::where('role', 'others')->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'premiumUsers',
            'allUsers',
            'allPremiumUsers',
            'externalUsers',
            'streamerUsers',
            'bypassUsers',
            'resellerUsers',
            'othersUsers'
        ));
    }

    // Display Users Management Page
    public function manageUsers()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users', compact('users'));
    }


    // Create User
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:user,admin',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->back()->with('success', 'User created successfully!');
    }


    // Edit User
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-user', compact('user'));
    }

    // Update User
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
            'premium_type' => 'nullable|in:All,External,Streamer,Bypass,Reseller',
            'is_reseller' => 'sometimes|boolean',
            'max_clients' => 'nullable|integer|min:1|max:100',
        ]);
        
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->premium_type = $validated['premium_type'] ?? null;
        
        if ($request->has('is_reseller')) {
            $user->is_reseller = $validated['is_reseller'];
            
            // If user is a reseller, ensure they have a max_clients value
            if ($user->is_reseller) {
                $user->max_clients = $validated['max_clients'] ?? 10;
            }
        }
        
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8',
            ]);
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Update the maximum number of clients for a reseller.
     */
    public function updateResellerLimit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        if (!$user->is_reseller) {
            return redirect()->back()->with('error', 'This user is not a reseller.');
        }
        
        $validated = $request->validate([
            'max_clients' => 'required|integer|min:' . $user->clients()->count() . '|max:100',
        ]);
        
        $user->max_clients = $validated['max_clients'];
        $user->save();
        
        return redirect()->back()->with('success', 'Reseller client limit updated successfully.');
    }

    /**
     * Show reseller analytics.
     */
    public function resellerAnalytics()
    {
        $resellers = User::where('is_reseller', true)->get();
        $totalResellers = $resellers->count();
        $totalClients = 0;
        
        foreach ($resellers as $reseller) {
            $totalClients += $reseller->clients()->count();
        }
        
        $resellersAtLimit = $resellers->filter(function ($reseller) {
            return $reseller->clients()->count() >= $reseller->max_clients;
        })->count();
        
        return view('admin.reseller-analytics', compact(
            'resellers',
            'totalResellers',
            'totalClients',
            'resellersAtLimit'
        ));
    }

    // Delete User
    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'User deleted successfully!');
    }

    /**
     * Display the download management page.
     */
    public function manageDownloads()
    {
        $downloads = \App\Models\Download::all();
        return view('admin.downloads.manage', compact('downloads'));
    }

    /**
     * Store a new download link.
     */
    public function storeDownload(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'required|url',
            'version' => 'required|string|max:50',
            'type' => 'required|string|in:All,External,Streamer,Bypass,Reseller',
            'release_notes' => 'nullable|string',
        ]);

        $download = \App\Models\Download::create($validated);

        return redirect()->route('admin.downloads.manage')
            ->with('status', 'Download link added successfully.');
    }

    /**
     * Update an existing download link.
     */
    public function updateDownload(Request $request, \App\Models\Download $download)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'required|url',
            'version' => 'required|string|max:50',
            'type' => 'required|string|in:All,External,Streamer,Bypass,Reseller',
            'release_notes' => 'nullable|string',
        ]);

        $download->update($validated);

        return redirect()->route('admin.downloads.manage')
            ->with('status', 'Download link updated successfully.');
    }

    /**
     * Delete a download link.
     */
    public function destroyDownload(\App\Models\Download $download)
    {
        $download->delete();

        return redirect()->route('admin.downloads.manage')
            ->with('status', 'Download link deleted successfully.');
    }
}
