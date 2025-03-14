<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ResellerClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Activity;

class ResellerManagementController extends Controller
{
    /**
     * Display a listing of resellers.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $resellers = User::where('premium_type', 'Reseller')
            ->withCount('clients')
            ->latest()
            ->paginate(10);
            
        return view('admin.resellers.index', compact('resellers'));
    }

    /**
     * Show the form for creating a new reseller.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.resellers.create');
    }

    /**
     * Store a newly created reseller.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'max_clients' => ['required', 'integer', 'min:1', 'max:100'],
            'is_active' => ['boolean'],
        ]);

        $reseller = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'reseller',
            'premium_type' => 'Reseller',
            'max_clients' => $validated['max_clients'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.resellers.index')
            ->with('success', 'Reseller created successfully.');
    }

    /**
     * Show the form for editing the specified reseller.
     *
     * @param  \App\Models\User  $reseller
     * @return \Illuminate\View\View
     */
    public function edit(User $reseller)
    {
        if ($reseller->premium_type !== 'Reseller') {
            return back()->with('error', 'Selected user is not a reseller.');
        }

        return view('admin.resellers.edit', compact('reseller'));
    }

    /**
     * Update the specified reseller.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $reseller
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $reseller)
    {
        if ($reseller->premium_type !== 'Reseller') {
            return back()->with('error', 'Selected user is not a reseller.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $reseller->id],
            'max_clients' => ['required', 'integer', 'min:' . $reseller->clients()->count(), 'max:100'],
            'is_active' => ['boolean'],
        ]);

        $reseller->update($validated);

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['required', 'string', 'min:8'],
            ]);
            $reseller->update(['password' => bcrypt($request->password)]);
        }

        return redirect()->route('admin.resellers.index')
            ->with('success', 'Reseller updated successfully.');
    }

    /**
     * Remove the specified reseller.
     *
     * @param  \App\Models\User  $reseller
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $reseller)
    {
        if ($reseller->premium_type !== 'Reseller') {
            return back()->with('error', 'Selected user is not a reseller.');
        }

        if ($reseller->clients()->exists()) {
            return back()->with('error', 'Cannot delete reseller with active clients.');
        }

        $reseller->delete();

        return redirect()->route('admin.resellers.index')
            ->with('success', 'Reseller deleted successfully.');
    }

    /**
     * Display reseller's clients.
     *
     * @param  \App\Models\User  $reseller
     * @return \Illuminate\View\View
     */
    public function clients(User $reseller)
    {
        if ($reseller->premium_type !== 'Reseller') {
            return back()->with('error', 'Selected user is not a reseller.');
        }

        $clients = $reseller->clients()->latest()->paginate(10);
        return view('admin.resellers.clients', compact('reseller', 'clients'));
    }

    /**
     * Display reseller analytics.
     *
     * @return \Illuminate\View\View
     */
    public function analytics()
    {
        try {
            // Get basic stats
            $totalResellers = User::where('premium_type', 'Reseller')->count();
            $totalClients = ResellerClient::count();
            $avgClients = $totalResellers > 0 ? round($totalClients / $totalResellers, 1) : 0;
            
            // New clients in the last 30 days
            $newClients = ResellerClient::where('created_at', '>=', now()->subDays(30))->count();
            
            // Top performing resellers
            $topResellers = User::where('premium_type', 'Reseller')
                ->withCount('clients')
                ->orderBy('clients_count', 'desc')
                ->limit(5)
                ->get();
                
            // Recent activity
            $recentActivity = ResellerClient::with(['reseller', 'client'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
                
            // Monthly growth data for chart
            $monthlyGrowth = $this->getMonthlyGrowthData();
            
            // Client distribution data for chart
            $clientDistribution = $this->getClientDistributionData();
            
            return view('admin.resellers.analytics', compact(
                'totalResellers',
                'totalClients',
                'avgClients',
                'newClients',
                'topResellers',
                'recentActivity',
                'monthlyGrowth',
                'clientDistribution'
            ));
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error in reseller analytics: ' . $e->getMessage());
            
            // Return view with empty data
            return view('admin.resellers.analytics', [
                'totalResellers' => 0,
                'totalClients' => 0,
                'avgClients' => 0,
                'newClients' => 0,
                'topResellers' => collect(),
                'recentActivity' => collect(),
                'monthlyGrowth' => collect(),
                'clientDistribution' => collect(),
                'error' => 'Could not retrieve reseller analytics. Please ensure the database is properly set up.'
            ]);
        }
    }

    /**
     * Get monthly growth data for charts.
     *
     * @return array
     */
    protected function getMonthlyGrowthData()
    {
        try {
            return ResellerClient::select(DB::raw('TO_CHAR(created_at, \'YYYY-MM\') as month'), DB::raw('count(*) as count'))
                ->where('created_at', '>=', now()->subMonths(12))
                ->groupBy('month')
                ->orderBy('month', 'asc')
                ->get();
        } catch (\Exception $e) {
            // Return empty collection if there's an error
            return collect();
        }
    }

    /**
     * Get client distribution data for charts.
     *
     * @return array
     */
    protected function getClientDistributionData()
    {
        return User::where('premium_type', 'Reseller')
            ->select('name', DB::raw('(SELECT COUNT(*) FROM reseller_clients WHERE reseller_id = users.id) as client_count'))
            ->orderBy('client_count', 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * Update reseller's client limit.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $reseller
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateClientLimit(Request $request, User $reseller)
    {
        if ($reseller->premium_type !== 'Reseller') {
            return back()->with('error', 'Selected user is not a reseller.');
        }

        $validated = $request->validate([
            'max_clients' => ['nullable', 'integer', 'min:' . $reseller->clients()->count(), 'max:100'],
        ]);

        // Update the max_clients field
        $reseller->max_clients = $request->filled('max_clients') ? $validated['max_clients'] : null;
        $reseller->save();

        // Log the action
        activity()
            ->performedOn($reseller)
            ->causedBy(auth()->user())
            ->withProperties(['max_clients' => $reseller->max_clients])
            ->log('Updated reseller client limit');

        return back()->with('success', 'Reseller client limit updated successfully.');
    }
} 