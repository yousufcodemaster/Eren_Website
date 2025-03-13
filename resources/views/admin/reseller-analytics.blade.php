@extends('layouts.admin')

@section('content')
<div class="container px-6 py-8 mx-auto">
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Reseller Analytics</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Insights and performance data for resellers</p>
        </div>
    </div>

    <!-- Overview Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                            Total Resellers
                        </dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                                {{ $totalResellers }}
                            </div>
                        </dd>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                            Total Clients
                        </dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                                {{ $totalClients }}
                            </div>
                        </dd>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                            Avg. Clients per Reseller
                        </dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                                {{ $averageClientsPerReseller }}
                            </div>
                        </dd>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                            New Clients (30 days)
                        </dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                                {{ $newClients }}
                            </div>
                            <div class="ml-2 flex items-baseline text-sm font-semibold {{ $growthRate >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                @if ($growthRate >= 0)
                                <svg class="self-center flex-shrink-0 h-5 w-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                                @else
                                <svg class="self-center flex-shrink-0 h-5 w-5 text-red-500 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                @endif
                                <span class="sr-only">{{ $growthRate >= 0 ? 'Increased' : 'Decreased' }} by</span>
                                {{ abs($growthRate) }}%
                            </div>
                        </dd>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Performers & Activity -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Top Resellers -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Top Performing Resellers</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">Ranked by number of clients</p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <ol class="space-y-4">
                    @forelse($topResellers as $index => $reseller)
                    <li class="flex items-center">
                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center">
                            <span class="text-indigo-800 dark:text-indigo-200 font-medium text-sm">{{ $index + 1 }}</span>
                        </div>
                        <div class="ml-3 flex-1">
                            <div class="flex items-center justify-between">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $reseller->name }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $reseller->clients_count }} clients</div>
                            </div>
                            <div class="mt-1 relative pt-1">
                                <div class="overflow-hidden h-2 text-xs flex rounded bg-indigo-200 dark:bg-indigo-900">
                                    <div style="width: {{ ($reseller->clients_count / ($topResellers->first()->clients_count ?: 1)) * 100 }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-500"></div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @empty
                    <li class="text-sm text-gray-500 dark:text-gray-400">No resellers found</li>
                    @endforelse
                </ol>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Recent Activity</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">Latest client additions</p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <ul class="space-y-4">
                    @forelse($recentActivity as $activity)
                    <li class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="h-8 w-8 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                <svg class="h-5 w-5 text-blue-600 dark:text-blue-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 flex-1">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                <span class="font-semibold">{{ $activity->reseller->name }}</span> added <span class="font-semibold">{{ $activity->discord_username }}</span>
                            </div>
                            <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ $activity->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </li>
                    @empty
                    <li class="text-sm text-gray-500 dark:text-gray-400">No recent activity found</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Monthly Growth Chart -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Monthly Growth</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">New clients added per month</p>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <div class="h-72">
                <canvas id="monthlyGrowthChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Distribution by Reseller -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Client Distribution</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">Percentage of clients by top resellers</p>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <div class="h-72">
                <canvas id="distributionChart"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Monthly Growth Chart
        const monthlyGrowthCtx = document.getElementById('monthlyGrowthChart').getContext('2d');
        
        // Sample data - this would typically come from your controller
        const monthlyGrowthData = {
            labels: {!! json_encode($monthlyGrowth->pluck('month')) !!},
            datasets: [{
                label: 'New Clients',
                data: {!! json_encode($monthlyGrowth->pluck('count')) !!},
                backgroundColor: 'rgba(79, 70, 229, 0.2)',
                borderColor: 'rgba(79, 70, 229, 1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        };
        
        const monthlyGrowthChart = new Chart(monthlyGrowthCtx, {
            type: 'line',
            data: monthlyGrowthData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 12
                            },
                            color: document.documentElement.classList.contains('dark') ? 'white' : 'black'
                        }
                    },
                },
                scales: {
                    x: {
                        grid: {
                            color: document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                        },
                        ticks: {
                            color: document.documentElement.classList.contains('dark') ? 'white' : 'black'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                        },
                        ticks: {
                            color: document.documentElement.classList.contains('dark') ? 'white' : 'black'
                        }
                    }
                }
            }
        });
        
        // Distribution Chart
        const distributionCtx = document.getElementById('distributionChart').getContext('2d');
        
        // Sample data for distribution chart
        const distributionLabels = {!! json_encode($topResellers->pluck('name')) !!};
        const distributionData = {!! json_encode($topResellers->pluck('clients_count')) !!};
        
        const distributionChart = new Chart(distributionCtx, {
            type: 'doughnut',
            data: {
                labels: distributionLabels,
                datasets: [{
                    data: distributionData,
                    backgroundColor: [
                        'rgba(79, 70, 229, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(139, 92, 246, 0.8)',
                        'rgba(236, 72, 153, 0.8)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            font: {
                                size: 12
                            },
                            color: document.documentElement.classList.contains('dark') ? 'white' : 'black'
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection 