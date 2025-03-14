@extends('layouts.admin')

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header with breadcrumbs -->
        <div class="mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2">
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">Dashboard</a>
                            </li>
                            <li>
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </li>
                            <li>
                                <a href="{{ route('admin.resellers.management') }}" class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">Resellers</a>
                            </li>
                            <li>
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </li>
                            <li>
                                <span class="text-sm font-medium text-purple-500">{{ $reseller->name }}</span>
                            </li>
                        </ol>
                    </nav>
                    <h2 class="mt-2 text-2xl font-bold text-gray-900 dark:text-white sm:text-3xl sm:truncate">
                        Reseller Profile
                    </h2>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <a href="{{ route('admin.resellers.management') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 dark:focus:ring-offset-gray-800">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Back to Resellers
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Reseller Profile Card -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 shadow overflow-hidden rounded-lg">
                    <!-- Profile Header -->
                    <div class="relative">
                        <div class="h-32 w-full bg-gradient-to-r from-purple-500 to-indigo-600"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="relative">
                                @if($reseller->discord_avatar)
                                    <img src="{{ $reseller->discord_avatar }}" alt="{{ $reseller->name }}" class="h-24 w-24 rounded-full ring-4 ring-white dark:ring-gray-800">
                                @else
                                    <div class="h-24 w-24 rounded-full ring-4 ring-white dark:ring-gray-800 bg-gradient-to-br from-purple-400 to-indigo-500 flex items-center justify-center">
                                        <span class="text-3xl font-bold text-white">{{ substr($reseller->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div class="absolute bottom-0 right-0 h-6 w-6 rounded-full bg-green-500 border-2 border-white dark:border-gray-800"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Profile Details -->
                    <div class="px-6 pt-16 pb-6">
                        <div class="text-center">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $reseller->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">ID: {{ $reseller->id }}</p>
                            <div class="mt-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100">
                                    Reseller
                                </span>
                            </div>
                        </div>
                        
                        <dl class="mt-6 space-y-4">
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 items-center">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2 break-all">{{ $reseller->email }}</dd>
                            </div>
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 items-center">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Joined</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">{{ $reseller->created_at->format('M d, Y') }}</dd>
                            </div>
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 items-center">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Discord ID</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">
                                    {{ $reseller->discord_id ?? 'Not connected' }}
                                </dd>
                            </div>
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Client Limit</dt>
                                <dd class="mt-2">
                                    <form action="{{ route('admin.resellers.update-limit', $reseller) }}" method="POST" class="flex items-start space-x-2">
                                        @csrf
                                        @method('PUT')
                                        <div class="relative rounded-md shadow-sm flex-1">
                                            <input type="number" name="max_clients" value="{{ $reseller->max_clients }}" min="{{ $reseller->clients->count() }}" max="100"
                                                placeholder="Unlimited"
                                                class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-3 pr-12 sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                <span class="text-gray-500 dark:text-gray-400 sm:text-sm">max</span>
                                            </div>
                                        </div>
                                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 dark:focus:ring-offset-gray-800">
                                            Update
                                        </button>
                                    </form>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
            
            <!-- Stats and Client Management -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                    <!-- Total Clients Card -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-purple-100 dark:bg-purple-900 rounded-md p-3">
                                    <svg class="h-6 w-6 text-purple-600 dark:text-purple-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Clients</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                            {{ $reseller->clients->count() }}
                                        </div>
                                    </dd>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Capacity Usage Card -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900 rounded-md p-3">
                                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Capacity Usage</dt>
                                    <dd class="flex items-baseline">
                                        @if($reseller->max_clients)
                                            @php
                                                $percentUsed = round(($reseller->clients->count() / $reseller->max_clients) * 100);
                                                $colorClass = $percentUsed < 50 ? 'text-green-600 dark:text-green-400' : 
                                                             ($percentUsed < 80 ? 'text-yellow-600 dark:text-yellow-400' : 
                                                             'text-red-600 dark:text-red-400');
                                            @endphp
                                            <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                                {{ $percentUsed }}%
                                            </div>
                                            <span class="ml-2 text-sm {{ $colorClass }}">
                                                {{ $reseller->clients->count() }}/{{ $reseller->max_clients }}
                                            </span>
                                        @else
                                            <div class="text-lg font-bold text-gray-900 dark:text-white">
                                                Unlimited
                                            </div>
                                        @endif
                                    </dd>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Latest Client Card -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-green-100 dark:bg-green-900 rounded-md p-3">
                                    <svg class="h-6 w-6 text-green-600 dark:text-green-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Latest Client</dt>
                                    <dd class="flex items-baseline">
                                        @if($reseller->clients->count() > 0)
                                            @php
                                                $latestClient = $reseller->clients->sortByDesc('created_at')->first();
                                            @endphp
                                            <div class="text-lg font-medium text-gray-900 dark:text-white truncate">
                                                {{ $latestClient->username ?? $latestClient->name ?? 'Unknown' }}
                                            </div>
                                            <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">
                                                {{ $latestClient->created_at->diffForHumans() }}
                                            </span>
                                        @else
                                            <div class="text-lg font-medium text-gray-500 dark:text-gray-400">
                                                No clients yet
                                            </div>
                                        @endif
                                    </dd>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Client Management Section -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                    <div class="px-4 py-5 border-b border-gray-200 dark:border-gray-700 sm:px-6 flex flex-wrap items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Client Management</h3>
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                Total: {{ $reseller->clients->count() }}
                            </span>
                            <!-- Add client button could go here if needed -->
                        </div>
                    </div>
                    
                    @if($reseller->clients->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Client
                                        </th>
                                        <th scope="col" class="hidden lg:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Email
                                        </th>
                                        <th scope="col" class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Added
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($reseller->clients->sortByDesc('created_at') as $client)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        @if($client->discord_avatar)
                                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $client->discord_avatar }}" alt="{{ $client->username }}">
                                                        @else
                                                            <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                                                <span class="text-gray-700 dark:text-gray-300 font-medium">{{ substr($client->username ?? $client->name ?? 'U', 0, 1) }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $client->username ?? $client->name ?? 'Unknown' }}</div>
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">ID: {{ $client->id }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="hidden lg:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $client->email ?? 'No email' }}
                                            </td>
                                            <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-white">{{ $client->created_at->format('M d, Y') }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $client->created_at->format('g:i A') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <form action="{{ route('admin.resellers.remove-client', ['reseller' => $reseller->id, 'clientId' => $client->id]) }}" 
                                                      method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to remove this client? This action cannot be undone.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-red-700 dark:text-red-400 bg-red-100 dark:bg-red-900/30 hover:bg-red-200 dark:hover:bg-red-900/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800">
                                                        <svg class="-ml-0.5 mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                        </svg>
                                                        Remove
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="py-12">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No clients</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    This reseller hasn't added any clients yet.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 