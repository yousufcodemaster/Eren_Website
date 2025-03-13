<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ResellerClient;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Basic user counts
        $totalUsers = User::count();
        $premiumUsers = User::whereNotNull('premium_type')->count();
        
        // Premium type breakdown
        $allPremiumUsers = User::where('premium_type', 'All')->count();
        $externalUsers = User::where('premium_type', 'External')->count();
        $streamerUsers = User::where('premium_type', 'Streamer')->count();
        $bypassUsers = User::where('premium_type', 'Bypass')->count();
        $resellerUsers = User::where('premium_type', 'Reseller')->count();
        
        // Recent users
        $recentUsers = User::latest()->take(5)->get();
        
        // Get activity stats (user growth)
        $userStats = $this->getUserGrowthStats();
        
        // Get reseller client stats
        $resellerStats = $this->getResellerStats();
        
        // Get download stats
        $downloadStats = $this->getDownloadStats();
        
        // Get system health stats
        $systemStats = $this->getSystemStats();
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'premiumUsers',
            'allPremiumUsers',
            'externalUsers',
            'streamerUsers',
            'bypassUsers',
            'resellerUsers',
            'recentUsers',
            'userStats',
            'resellerStats',
            'downloadStats',
            'systemStats'
        ));
    }
    
    /**
     * Get user growth statistics
     *
     * @return array
     */
    protected function getUserGrowthStats()
    {
        $currentMonth = now()->month;
        $lastMonth = now()->subMonth()->month;
        
        $thisMonthUsers = User::whereMonth('created_at', $currentMonth)->count();
        $lastMonthUsers = User::whereMonth('created_at', $lastMonth)->count();
        
        $percentChange = 0;
        if ($lastMonthUsers > 0) {
            $percentChange = (($thisMonthUsers - $lastMonthUsers) / $lastMonthUsers) * 100;
        }
        
        // Get daily user growth for the last 30 days
        $dailyGrowth = User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        return [
            'this_month' => $thisMonthUsers,
            'last_month' => $lastMonthUsers,
            'percent_change' => round($percentChange, 1),
            'daily_growth' => $dailyGrowth
        ];
    }
    
    /**
     * Get reseller statistics
     *
     * @return array
     */
    protected function getResellerStats()
    {
        $totalResellers = User::where('premium_type', 'Reseller')->count();
        $totalClients = ResellerClient::count();
        
        $avgClientsPerReseller = $totalResellers > 0 ? round($totalClients / $totalResellers, 1) : 0;
        
        // Get resellers with the most clients
        $topResellers = User::where('premium_type', 'Reseller')
            ->withCount('clients')
            ->orderBy('clients_count', 'desc')
            ->take(5)
            ->get();
            
        // Get clients added in the last 30 days
        $newClientsCount = ResellerClient::where('created_at', '>=', now()->subDays(30))->count();
        
        // Get monthly client growth
        $monthlyClientGrowth = ResellerClient::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        return [
            'total_resellers' => $totalResellers,
            'total_clients' => $totalClients,
            'avg_clients' => $avgClientsPerReseller,
            'top_resellers' => $topResellers,
            'new_clients_count' => $newClientsCount,
            'monthly_growth' => $monthlyClientGrowth
        ];
    }
    
    /**
     * Get download statistics
     *
     * @return array
     */
    protected function getDownloadStats()
    {
        $totalDownloads = Download::count();
        $downloadsByType = Download::select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->get();
            
        $recentDownloads = Download::latest()->take(5)->get();
        
        return [
            'total_downloads' => $totalDownloads,
            'downloads_by_type' => $downloadsByType,
            'recent_downloads' => $recentDownloads
        ];
    }
    
    /**
     * Get system health statistics
     *
     * @return array
     */
    protected function getSystemStats()
    {
        $diskUsage = $this->getDiskUsage();
        $memoryUsage = $this->getMemoryUsage();
        $cpuUsage = $this->getCpuUsage();
        
        return [
            'disk_usage' => $diskUsage,
            'memory_usage' => $memoryUsage,
            'cpu_usage' => $cpuUsage
        ];
    }
    
    /**
     * Get disk usage statistics
     *
     * @return array
     */
    protected function getDiskUsage()
    {
        $total = disk_total_space('/');
        $free = disk_free_space('/');
        $used = $total - $free;
        $percentage = round(($used / $total) * 100, 1);
        
        return [
            'total' => $this->formatBytes($total),
            'free' => $this->formatBytes($free),
            'used' => $this->formatBytes($used),
            'percentage' => $percentage
        ];
    }
    
    /**
     * Get memory usage statistics
     *
     * @return array
     */
    protected function getMemoryUsage()
    {
        if (function_exists('exec')) {
            $memory = [];
            exec('free -m', $memory);
            
            if (isset($memory[1])) {
                $values = explode(' ', preg_replace('/\s+/', ' ', trim($memory[1])));
                $total = $values[1];
                $used = $values[2];
                $free = $values[3];
                $percentage = round(($used / $total) * 100, 1);
                
                return [
                    'total' => $total . ' MB',
                    'used' => $used . ' MB',
                    'free' => $free . ' MB',
                    'percentage' => $percentage
                ];
            }
        }
        
        return [
            'total' => 'N/A',
            'used' => 'N/A',
            'free' => 'N/A',
            'percentage' => 0
        ];
    }
    
    /**
     * Get CPU usage statistics
     *
     * @return array
     */
    protected function getCpuUsage()
    {
        if (function_exists('exec')) {
            $load = sys_getloadavg();
            return [
                'current' => round($load[0], 1),
                'average_5min' => round($load[1], 1),
                'average_15min' => round($load[2], 1)
            ];
        }
        
        return [
            'current' => 'N/A',
            'average_5min' => 'N/A',
            'average_15min' => 'N/A'
        ];
    }
    
    /**
     * Format bytes to human readable format
     *
     * @param int $bytes
     * @return string
     */
    protected function formatBytes($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        
        return round($bytes, 2) . ' ' . $units[$pow];
    }
} 