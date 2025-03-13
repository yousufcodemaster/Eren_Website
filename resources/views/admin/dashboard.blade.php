@extends('layouts.admin')

@section('content')
<div class="container px-6 py-8 mx-auto">
    <!-- Welcome Section -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Welcome, {{ Auth::user()->name }}</h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Here's what's happening with your site today.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users Card -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</p>
                        <div class="flex items-baseline">
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalUsers }}</p>
                            @if(isset($userGrowth))
                            <p class="ml-2 text-sm {{ $userGrowth >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                @if($userGrowth > 0) +{{ $userGrowth }}% @else {{ $userGrowth }}% @endif
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.users') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">View all users &rarr;</a>
                </div>
            </div>
        </div>

        <!-- Premium Users Card -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Premium Users</p>
                        <div class="flex items-baseline">
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $premiumUsers }}</p>
                            <p class="ml-2 text-sm text-gray-500 dark:text-gray-400">
                                {{ round(($premiumUsers / ($totalUsers ?: 1)) * 100) }}% of total
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.users') }}?premium_type=All" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">View premium users &rarr;</a>
                </div>
            </div>
        </div>

        <!-- Reseller Users Card -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Reseller Users</p>
                        <div class="flex items-baseline">
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $resellerUsers }}</p>
                            <p class="ml-2 text-sm text-gray-500 dark:text-gray-400">
                                {{ $totalResellerClients }} clients
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.reseller-management') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">Manage resellers &rarr;</a>
                </div>
            </div>
        </div>

        <!-- Quick Actions Card -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="#" onclick="document.getElementById('addUserModal').classList.remove('hidden'); return false;" class="flex items-center text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                        <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Add New User
                    </a>
                    <a href="{{ route('admin.panel-upload') }}" class="flex items-center text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                        <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        Upload Panel File
                    </a>
                    <a href="{{ route('admin.reseller-analytics') }}" class="flex items-center text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                        <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        View Analytics
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Premium Users Breakdown & Recent Users Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Premium Users Breakdown Card -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg lg:col-span-1">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Premium Users Breakdown</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500 dark:text-gray-400">All Premium:</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $allPremiumUsers }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500 dark:text-gray-400">External:</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $externalUsers }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Streamer:</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $streamerUsers }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Bypass:</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $bypassUsers }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Reseller:</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $resellerUsers }}</span>
                    </div>
                </div>
                <div class="mt-6 h-64">
                    <canvas id="premiumChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Users Table -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg lg:col-span-2">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Recent Users</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">Latest user registrations</p>
            </div>
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Joined</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($recentUsers as $user)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    @if($user->discord_avatar)
                                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ $user->discord_avatar }}" alt="{{ $user->name }}">
                                                    @else
                                                        <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                                            <span class="text-gray-700 dark:text-gray-300 font-medium text-sm">
                                                                {{ substr($user->name, 0, 2) }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $user->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                            @if($user->premium_type)
                                            <span class="ml-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                {{ $user->premium_type }}
                                            </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $user->created_at->diffForHumans() }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.users') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Growth & Downloads Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- User Growth Chart -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">User Growth</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                    This month: <span class="font-medium text-gray-900 dark:text-white">{{ $userGrowthStats['current_month'] }}</span> new users 
                    @if($userGrowthStats['percentage_change'] != 0)
                    (<span class="{{ $userGrowthStats['percentage_change'] > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">{{ $userGrowthStats['percentage_change'] > 0 ? '+' : '' }}{{ $userGrowthStats['percentage_change'] }}%</span> from last month)
                    @endif
                </p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="h-64">
                    <canvas id="userGrowthChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Reseller Stats -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Reseller Stats</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                    Overview of reseller performance
                </p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Resellers</p>
                        <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">{{ $resellerStats['total_resellers'] }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Clients</p>
                        <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">{{ $resellerStats['total_clients'] }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Avg. Clients/Reseller</p>
                        <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">{{ $resellerStats['avg_clients'] }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">New Clients (30d)</p>
                        <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">{{ $resellerStats['new_clients'] }}</p>
                    </div>
                </div>
                <h4 class="text-base font-medium text-gray-900 dark:text-white mb-3">Top Resellers</h4>
                <div class="space-y-3">
                    @foreach($resellerStats['top_resellers'] as $reseller)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            @if($reseller->discord_avatar)
                                <img class="h-8 w-8 rounded-full object-cover" src="{{ $reseller->discord_avatar }}" alt="{{ $reseller->name }}">
                            @else
                                <div class="h-8 w-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center">
                                    <span class="text-indigo-800 dark:text-indigo-200 font-medium text-sm">
                                        {{ substr($reseller->name, 0, 2) }}
                                    </span>
                                </div>
                            @endif
                            <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white">{{ $reseller->name }}</span>
                        </div>
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $reseller->clients_count }} clients</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div id="addUserModal" class="hidden fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
            </div>
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                Add New User
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                    <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                    <input type="email" name="email" id="email" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                                    <input type="password" name="password" id="password" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                                    <select name="role" id="role" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        <option value="user">User</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="premium_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Premium Type</label>
                                    <select name="premium_type" id="premium_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        <option value="">None</option>
                                        <option value="All">All</option>
                                        <option value="External">External</option>
                                        <option value="Streamer">Streamer</option>
                                        <option value="Bypass">Bypass</option>
                                        <option value="Reseller">Reseller</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Save
                        </button>
                        <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Close modal function
        window.closeModal = function() {
            document.getElementById('addUserModal').classList.add('hidden');
        };

        // Premium Users Chart
        const premiumCtx = document.getElementById('premiumChart').getContext('2d');
        const premiumChart = new Chart(premiumCtx, {
            type: 'doughnut',
            data: {
                labels: ['All', 'External', 'Streamer', 'Bypass', 'Reseller'],
                datasets: [{
                    data: [
                        {{ $allPremiumUsers }}, 
                        {{ $externalUsers }}, 
                        {{ $streamerUsers }}, 
                        {{ $bypassUsers }}, 
                        {{ $resellerUsers }}
                    ],
                    backgroundColor: [
                        'rgba(79, 70, 229, 0.8)',  // Indigo
                        'rgba(16, 185, 129, 0.8)', // Green
                        'rgba(245, 158, 11, 0.8)', // Yellow
                        'rgba(239, 68, 68, 0.8)',  // Red
                        'rgba(59, 130, 246, 0.8)'  // Blue
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: document.documentElement.classList.contains('dark') ? 'white' : 'black'
                        }
                    }
                }
            }
        });

        // User Growth Chart
        const growthCtx = document.getElementById('userGrowthChart').getContext('2d');
        
        // Sample monthly data - this should be replaced with actual data from your controller
        const growthLabels = {!! json_encode($userGrowthStats['labels']) !!};
        const growthData = {!! json_encode($userGrowthStats['data']) !!};
        
        const growthChart = new Chart(growthCtx, {
            type: 'line',
            data: {
                labels: growthLabels,
                datasets: [{
                    label: 'New Users',
                    data: growthData,
                    backgroundColor: 'rgba(79, 70, 229, 0.2)',
                    borderColor: 'rgba(79, 70, 229, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            color: document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)',
                        },
                        ticks: {
                            color: document.documentElement.classList.contains('dark') ? 'white' : 'black'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)',
                        },
                        ticks: {
                            color: document.documentElement.classList.contains('dark') ? 'white' : 'black'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
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