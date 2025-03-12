@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Dashboard Heading -->
        <div class="text-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Admin Dashboard</h2>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div
                class="bg-white dark:bg-gradient-to-br from-gray-800 to-gray-900 shadow-md dark:shadow-gray-700 border border-gray-300 dark:border-gray-700 rounded-xl p-6 transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/50">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Total Users</h3>
                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $totalUsers }}</p>
            </div>

            <div
                class="bg-white dark:bg-gradient-to-br from-gray-800 to-gray-900 shadow-md dark:shadow-gray-700 border border-gray-300 dark:border-gray-700 rounded-xl p-6 transition-all duration-300 hover:shadow-lg hover:shadow-green-500/50">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Premium Users</h3>
                <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $premiumUsers }}</p>
            </div>

            <div
                class="bg-white dark:bg-gradient-to-br from-gray-800 to-gray-900 shadow-md dark:shadow-gray-700 border border-gray-300 dark:border-gray-700 rounded-xl p-6 transition-all duration-300 hover:shadow-lg hover:shadow-purple-500/50">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Manage Users</h3>
                <a href="{{ route('admin.users.index') }}"
                    class="mt-2 inline-block px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition duration-300">
                    Go to Users
                </a>
            </div>
        </div>

        <!-- Premium Users Breakdown -->
        <div
            class="mt-8 bg-white dark:bg-gradient-to-br from-gray-800 to-gray-900 shadow-md dark:shadow-gray-700 border border-gray-300 dark:border-gray-700 rounded-xl p-6 transition-all duration-300 hover:shadow-xl">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Premium Users Breakdown</h3>

            <ul class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <li
                    class="flex justify-between bg-gray-100 dark:bg-gray-700 p-4 rounded-lg transition-all duration-300 hover:shadow-lg hover:shadow-blue-400/50">
                    <span class="font-medium text-gray-700 dark:text-gray-300">All</span>
                    <span class="font-bold text-blue-600 dark:text-blue-400">{{ $allPremiumUsers }}</span>
                </li>
                <li
                    class="flex justify-between bg-gray-100 dark:bg-gray-700 p-4 rounded-lg transition-all duration-300 hover:shadow-lg hover:shadow-red-400/50">
                    <span class="font-medium text-gray-700 dark:text-gray-300">External</span>
                    <span class="font-bold text-red-600 dark:text-red-400">{{ $externalUsers }}</span>
                </li>
                <li
                    class="flex justify-between bg-gray-100 dark:bg-gray-700 p-4 rounded-lg transition-all duration-300 hover:shadow-lg hover:shadow-green-400/50">
                    <span class="font-medium text-gray-700 dark:text-gray-300">Streamer</span>
                    <span class="font-bold text-green-600 dark:text-green-400">{{ $streamerUsers }}</span>
                </li>
                <li
                    class="flex justify-between bg-gray-100 dark:bg-gray-700 p-4 rounded-lg transition-all duration-300 hover:shadow-lg hover:shadow-orange-400/50">
                    <span class="font-medium text-gray-700 dark:text-gray-300">Bypass</span>
                    <span class="font-bold text-orange-600 dark:text-orange-400">{{ $bypassUsers }}</span>
                </li>
                <li
                    class="flex justify-between bg-gray-100 dark:bg-gray-700 p-4 rounded-lg transition-all duration-300 hover:shadow-lg hover:shadow-purple-400/50">
                    <span class="font-medium text-gray-700 dark:text-gray-300">Reseller</span>
                    <span class="font-bold text-purple-600 dark:text-purple-400">{{ $resellerUsers }}</span>
                </li>
            </ul>
        </div>
    </div>
@endsection