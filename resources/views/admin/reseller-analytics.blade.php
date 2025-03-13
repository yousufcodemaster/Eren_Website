@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-white">Reseller Analytics</h1>
            <p class="mt-1 text-sm text-gray-400">Overview of all reseller accounts and their performance</p>
        </div>

        <!-- Analytics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Total Resellers Card -->
            <div class="bg-gray-800 overflow-hidden shadow-xl rounded-lg">
                <div class="px-6 py-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-400 truncate">
                                    Total Resellers
                                </dt>
                                <dd>
                                    <div class="text-lg font-medium text-white">
                                        {{ $totalResellers }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Clients Card -->
            <div class="bg-gray-800 overflow-hidden shadow-xl rounded-lg">
                <div class="px-6 py-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-400 truncate">
                                    Total Clients
                                </dt>
                                <dd>
                                    <div class="text-lg font-medium text-white">
                                        {{ $totalClients }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Average Clients Per Reseller Card -->
            <div class="bg-gray-800 overflow-hidden shadow-xl rounded-lg">
                <div class="px-6 py-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-400 truncate">
                                    Avg. Clients Per Reseller
                                </dt>
                                <dd>
                                    <div class="text-lg font-medium text-white">
                                        {{ $avgClientsPerReseller }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Resellers Table -->
        <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg mb-6">
            <div class="px-4 py-5 border-b border-gray-700 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-white">
                    Top Resellers by Client Count
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Rank
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Reseller
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Client Count
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Capacity Used
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-800 divide-y divide-gray-700">
                        @foreach($topResellers as $index => $reseller)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($reseller->discord_avatar)
                                                <img class="h-10 w-10 rounded-full" src="{{ $reseller->discord_avatar }}" alt="{{ $reseller->name }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-purple-600 flex items-center justify-center">
                                                    <span class="text-white font-medium">{{ substr($reseller->name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-white">{{ $reseller->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                    {{ $reseller->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                    {{ $reseller->clients_count }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $percentUsed = $reseller->max_clients > 0 ? min(100, round(($reseller->clients_count / $reseller->max_clients) * 100)) : 0;
                                        $barColor = $percentUsed < 50 ? 'bg-green-500' : ($percentUsed < 80 ? 'bg-yellow-500' : 'bg-red-500');
                                    @endphp
                                    <div class="flex items-center">
                                        <div class="w-full bg-gray-700 rounded-full h-2.5">
                                            <div class="{{ $barColor }} h-2.5 rounded-full" style="width: {{ $percentUsed }}%"></div>
                                        </div>
                                        <span class="ml-2 text-sm text-gray-400">{{ $percentUsed }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="px-4 py-5 border-b border-gray-700 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-white">
                    Recent Reseller Activity
                </h3>
            </div>
            <div class="p-6">
                <div class="flow-root">
                    <ul role="list" class="-mb-8">
                        @foreach($recentActivity as $activity)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-600" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-gray-600 flex items-center justify-center ring-8 ring-gray-800">
                                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-white">{{ $activity->description }}</p>
                                                <p class="text-sm text-gray-400">Performed by: {{ $activity->causer ? $activity->causer->name : 'System' }}</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-400">
                                                {{ $activity->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach

                        @if(count($recentActivity) === 0)
                            <li class="text-center text-gray-400 py-4">No recent activity found</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 