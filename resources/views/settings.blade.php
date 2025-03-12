@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Account Settings</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Manage your account preferences and security settings</p>
        </div>

        <!-- Success Message -->
        @if (session('status'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 dark:bg-green-800 dark:border-green-700 dark:text-green-300 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('status') }}</span>
            </div>
        @endif

        <!-- Error Message -->
        @if (session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 dark:bg-red-800 dark:border-red-700 dark:text-red-300 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Sidebar -->
            <div class="col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                        <!-- User Profile Info -->
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-12 w-12">
                                @if(Auth::user()->discord_avatar)
                                    <img class="h-12 w-12 rounded-full object-cover" src="{{ Auth::user()->discord_avatar }}" alt="{{ Auth::user()->name }}">
                                @else
                                    <img class="h-12 w-12 rounded-full object-cover" 
                                        src="{{ 
                                            Auth::user()->role === 'admin' 
                                                ? asset('images/avatars/admin-avatar.svg') 
                                                : (Auth::user()->premium_type === 'Streamer' 
                                                    ? asset('images/avatars/streamer-avatar.svg')
                                                    : (Auth::user()->premium_type === 'External'
                                                        ? asset('images/avatars/external-avatar.svg')
                                                        : (Auth::user()->premium_type === 'Bypass'
                                                            ? asset('images/avatars/bypass-avatar.svg')
                                                            : (Auth::user()->premium_type === 'Reseller'
                                                                ? asset('images/avatars/reseller-avatar.svg')
                                                                : (Auth::user()->premium_type === 'All'
                                                                    ? asset('images/avatars/premium-avatar.svg')
                                                                    : asset('images/avatars/user-avatar.svg')
                                                                )
                                                            )
                                                        )
                                                    )
                                                )
                                        }}" 
                                        alt="{{ Auth::user()->name }}">
                                @endif
                            </div>
                            <div class="ml-4">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-white">{{ Auth::user()->name }}</h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
                            </div>
                        </div>

                        <!-- Account Type Badge -->
                        <div class="mt-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ Auth::user()->role === 'admin' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' }}">
                                {{ ucfirst(Auth::user()->role) }}
                            </span>
                            
                            @if(Auth::user()->premium_type)
                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ 
                                    Auth::user()->premium_type === 'Streamer' 
                                        ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200'
                                        : (Auth::user()->premium_type === 'External'
                                            ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200'
                                            : (Auth::user()->premium_type === 'Bypass'
                                                ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                                : (Auth::user()->premium_type === 'Reseller'
                                                    ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                                                    : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200'
                                                )
                                            )
                                        )
                                }}">
                                    {{ Auth::user()->premium_type }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="p-4">
                        <nav class="space-y-1">
                            <!-- Settings Nav Links -->
                            <a href="#email-settings" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg class="mr-3 h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Email Settings
                            </a>
                            <a href="#password-settings" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg class="mr-3 h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Password Settings
                            </a>
                            <a href="#panel-password-settings" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg class="mr-3 h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Panel Password
                            </a>
                            <div class="px-3 py-2">
                                <hr class="border-gray-200 dark:border-gray-700">
                            </div>
                            <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg class="mr-3 h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Back to Dashboard
                            </a>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-span-2 space-y-6">
                <!-- Username Notice -->
                <div class="bg-blue-50 dark:bg-blue-900 border-l-4 border-blue-400 dark:border-blue-700 p-4 rounded-md shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700 dark:text-blue-300">
                                <strong>Note:</strong> Usernames cannot be changed. Your username is set to <strong>{{ Auth::user()->name }}</strong>.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Email Settings -->
                <div id="email-settings" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-gray-400 dark:text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Email Settings
                            </div>
                        </h3>
                    </div>
                    <div class="px-6 py-4">
                        <form action="{{ route('settings.email.update') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label for="current_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Current Email</label>
                                <div class="mt-1 text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Email</label>
                                <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Current Password</label>
                                <input type="password" name="current_password" id="current_password" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">We need your current password to confirm your identity.</p>
                            </div>
                            <div>
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Update Email
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Password Settings -->
                <div id="password-settings" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-gray-400 dark:text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Password Settings
                            </div>
                        </h3>
                    </div>
                    <div class="px-6 py-4">
                        <form action="{{ route('settings.password.update') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Current Password</label>
                                <input type="password" name="current_password" id="current_password_for_password" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Password</label>
                                <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                            <div>
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Panel Password Settings -->
                <div id="panel-password-settings" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-gray-400 dark:text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Panel Password
                            </div>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            This password is used for accessing specific panels and external integrations. It's separate from your account password.
                        </p>
                    </div>
                    <div class="px-6 py-4">
                        <form action="{{ route('settings.panel-password.update') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Current Account Password</label>
                                <input type="password" name="current_password" id="current_password_for_panel" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">We need your account password to confirm your identity.</p>
                            </div>
                            <div>
                                <label for="panel_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Panel Password</label>
                                <input type="password" name="panel_password" id="panel_password" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Choose a strong, unique password that differs from your account password.</p>
                            </div>
                            <div>
                                <label for="panel_password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm New Panel Password</label>
                                <input type="password" name="panel_password_confirmation" id="panel_password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                            <div>
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Update Panel Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 