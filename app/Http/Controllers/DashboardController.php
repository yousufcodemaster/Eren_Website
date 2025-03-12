<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Apply middleware to restrict access.
     */
    public function __construct()
    {
        $this->middleware('auth'); // Ensures only authenticated users can access the dashboard
    }

    /**
     * Show the dashboard page.
     */
    public function index()
    {
        return view('dashboard');
    }

    /**
     * Display the downloads page.
     */
    public function downloads()
    {
        $userType = auth()->user()->premium_type;
        
        // Get downloads for the user's type or 'All' type
        $downloads = \App\Models\Download::where('type', $userType)
            ->orWhere('type', 'All')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('downloads', compact('downloads'));
    }
}
