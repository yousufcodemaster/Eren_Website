<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        $resellers = User::where('premium_type', 'Reseller')->with('clients')->get();
        return view('admin.users', compact('users', 'resellers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', Rule::in(['user', 'admin'])],
            'premium_type' => ['required', Rule::in(['All', 'External', 'Streamer', 'Bypass', 'Reseller'])]
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'premium_type' => $request->premium_type,
            'email_verified_at' => now()
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in(['user', 'admin'])],
            'premium_type' => ['required', Rule::in(['All', 'External', 'Streamer', 'Bypass', 'Reseller'])],
            'password' => ['nullable', 'string', 'min:8']
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'premium_type' => $request->premium_type
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete your own account.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function resellerManagement(Request $request)
    {
        // Get base query for resellers
        $resellersQuery = User::where('premium_type', 'Reseller')
                          ->where('is_reseller', true);
        
        // Apply filters if provided
        if ($request->has('search')) {
            $search = $request->search;
            $resellersQuery->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Order results
        $orderBy = $request->order_by ?? 'created_at';
        $orderDir = $request->order_dir ?? 'desc';
        $resellersQuery->orderBy($orderBy, $orderDir);
        
        // Get paginated results with client relationship
        $resellers = $resellersQuery->with('clients')->paginate(10);
        
        return view('admin.reseller-management', compact('resellers'));
    }
    
    /**
     * Display the reseller analytics page
     */
    public function resellerAnalytics()
    {
        // Get all resellers
        $resellers = User::where('premium_type', 'Reseller')->get();
        
        // Calculate total resellers
        $totalResellers = $resellers->count();
        
        // Calculate total clients
        $totalClients = 0;
        foreach ($resellers as $reseller) {
            $totalClients += $reseller->clients()->count();
        }
        
        // Calculate average clients per reseller
        $avgClientsPerReseller = $totalResellers > 0 ? round($totalClients / $totalResellers, 1) : 0;
        
        // Get top resellers by client count
        $topResellers = User::where('premium_type', 'Reseller')
            ->withCount('clients')
            ->orderBy('clients_count', 'desc')
            ->take(10)
            ->get();
            
        // Get recent activity related to resellers
        $recentActivity = \Spatie\Activitylog\Models\Activity::where('subject_type', User::class)
            ->whereHasMorph('subject', User::class, function ($query) {
                $query->where('premium_type', 'Reseller');
            })
            ->orWhere('description', 'like', '%reseller%')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        return view('admin.reseller-analytics', [
            'totalResellers' => $totalResellers,
            'totalClients' => $totalClients,
            'avgClientsPerReseller' => $avgClientsPerReseller,
            'topResellers' => $topResellers,
            'recentActivity' => $recentActivity,
        ]);
    }
} 