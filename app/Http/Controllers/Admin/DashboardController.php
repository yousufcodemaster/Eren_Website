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
        
        // Calculate total reseller clients
        $totalResellerClients = ResellerClient::count();
        
        // Recent users
        $recentUsers = User::latest()->take(5)->get();
        
        // Get activity stats (user growth)
        $userStats = $this->getUserGrowthStats();
        $userGrowth = $userStats['percent_change']; // Extract user growth percentage
        
        // Get reseller client stats
        $resellerStats = $this->getResellerStats();
        
        // Get download stats with error handling
        try {
            $downloadStats = $this->getDownloadStats();
        } catch (\Exception $e) {
            // If there's an error getting download stats, provide empty data
            $downloadStats = [
                'total_downloads' => 0,
                'downloads_by_type' => collect(),
                'recent_downloads' => collect()
            ];
        }
        
        // Get system health stats
        $systemStats = $this->getSystemStats();
        
        // Create simple stats for user growth chart
        $userGrowthStats = [
            'current_month' => $userStats['this_month'],
            'percentage_change' => $userStats['percent_change'],
            'labels' => $userStats['daily_growth']->pluck('date')->toArray(),
            'data' => $userStats['daily_growth']->pluck('count')->toArray(),
        ];
        
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
            'userGrowth',
            'userGrowthStats',
            'resellerStats',
            'downloadStats',
            'systemStats',
            'totalResellerClients'
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
        $dailyGrowth = User::select(DB::raw('TO_CHAR(created_at, \'YYYY-MM-DD\') as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        // Get monthly client growth
        $monthlyClientGrowth = ResellerClient::select(DB::raw('TO_CHAR(created_at, \'YYYY-MM\') as month'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
        
        return [
            'this_month' => $thisMonthUsers,
            'last_month' => $lastMonthUsers,
            'percent_change' => round($percentChange, 1),
            'daily_growth' => $dailyGrowth,
            'monthly_growth' => $monthlyClientGrowth
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
        $monthlyClientGrowth = ResellerClient::select(DB::raw('TO_CHAR(created_at, \'YYYY-MM\') as month'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
        
        return [
            'total_resellers' => $totalResellers,
            'total_clients' => $totalClients,
            'avg_clients' => $avgClientsPerReseller,
            'top_resellers' => $topResellers,
            'new_clients' => $newClientsCount,
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
        try {
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
        } catch (\Exception $e) {
            // Return empty stats if the downloads table doesn't exist yet
            return [
                'total_downloads' => 0,
                'downloads_by_type' => collect(),
                'recent_downloads' => collect()
            ];
        }
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
        try {
            $total = disk_total_space('/');
            $free = disk_free_space('/');
            
            // Check if the values are valid
            if ($total === false || $free === false) {
                throw new \Exception('Could not get disk space information');
            }
            
            $used = $total - $free;
            $percentage = round(($used / $total) * 100, 1);
            
            return [
                'total' => $this->formatBytes($total),
                'free' => $this->formatBytes($free),
                'used' => $this->formatBytes($used),
                'percentage' => $percentage
            ];
        } catch (\Exception $e) {
            // Log the error
            \Log::warning('Error getting disk usage: ' . $e->getMessage());
            
            // Return placeholder data
            return [
                'total' => 'N/A',
                'free' => 'N/A',
                'used' => 'N/A',
                'percentage' => 0
            ];
        }
    }
    
    /**
     * Get memory usage statistics
     *
     * @return array
     */
    protected function getMemoryUsage()
    {
        try {
            // Linux specific memory usage via 'free' command
            if (function_exists('exec') && PHP_OS !== 'WINNT' && PHP_OS !== 'WIN32') {
                $memory = [];
                exec('free -m 2>&1', $memory, $return_var);
                
                // Check if command executed successfully
                if ($return_var === 0 && isset($memory[1])) {
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
            
            // For Windows or if Linux command failed, try to get memory info from PHP
            $memoryLimit = ini_get('memory_limit');
            $memoryUsage = memory_get_usage(true);
            $memoryPeak = memory_get_peak_usage(true);
            
            if ($memoryLimit && $memoryUsage) {
                // Convert memory limit to bytes if it's in shorthand notation
                if (preg_match('/^(\d+)(.)$/', $memoryLimit, $matches)) {
                    $memoryLimit = $matches[1];
                    switch (strtoupper($matches[2])) {
                        case 'G': $memoryLimit *= 1024;
                        case 'M': $memoryLimit *= 1024;
                        case 'K': $memoryLimit *= 1024;
                    }
                }
                
                return [
                    'total' => $this->formatBytes((int)$memoryLimit),
                    'used' => $this->formatBytes($memoryUsage),
                    'peak' => $this->formatBytes($memoryPeak),
                    'percentage' => $memoryLimit > 0 ? round(($memoryUsage / $memoryLimit) * 100, 1) : 0
                ];
            }
            
            throw new \Exception('Could not determine memory usage');
        } catch (\Exception $e) {
            // Log the error
            \Log::warning('Error getting memory usage: ' . $e->getMessage());
            
            // Return placeholder data
            return [
                'total' => 'N/A',
                'used' => 'N/A',
                'free' => 'N/A',
                'percentage' => 0
            ];
        }
    }
    
    /**
     * Get CPU usage statistics
     *
     * @return array
     */
    protected function getCpuUsage()
    {
        // Check if both exec and sys_getloadavg functions are available
        if (function_exists('exec') && function_exists('sys_getloadavg')) {
            $load = sys_getloadavg();
            return [
                'current' => round($load[0], 1),
                'average_5min' => round($load[1], 1),
                'average_15min' => round($load[2], 1)
            ];
        }
        
        // Return placeholder values if functions are not available (e.g., on Windows)
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