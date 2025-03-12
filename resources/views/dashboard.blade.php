@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl sm:truncate">
                        Welcome back, {{ Auth::user()->name }}!
                    </h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ Auth::user()->premium_type }} Account
                    </p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <span class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white {{ Auth::user()->premium_type === 'Streamer' ? 'bg-purple-600' : (Auth::user()->premium_type === 'External' ? 'bg-blue-600' : (Auth::user()->premium_type === 'Bypass' ? 'bg-green-600' : 'bg-red-600')) }}">
                        {{ Auth::user()->premium_type }} Plan
                    </span>
                </div>
            </div>
        </div>

        <!-- Main Action Buttons -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 mb-6">
            <!-- Account Settings Button -->
            <a href="{{ route('settings') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                <div class="p-6 flex items-center">
                    <div class="flex-shrink-0 p-3 bg-indigo-100 dark:bg-indigo-900 rounded-full">
                        <svg class="h-8 w-8 text-indigo-600 dark:text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="ml-5">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Account Settings</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Update your profile, change password, and manage preferences</p>
                    </div>
                    <div class="ml-auto">
                        <svg class="h-6 w-6 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Download Button -->
            <a href="{{ route('downloads') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                <div class="p-6 flex items-center">
                    <div class="flex-shrink-0 p-3 bg-purple-100 dark:bg-purple-900 rounded-full">
                        <svg class="h-8 w-8 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                    </div>
                    <div class="ml-5">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Downloads</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Access your {{ Auth::user()->premium_type }} downloads with the latest updates</p>
                    </div>
                    <div class="ml-auto">
                        <svg class="h-6 w-6 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </a>
        </div>

        <!-- Account Status -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg mb-6">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Account Overview</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Status -->
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-md font-medium text-gray-900 dark:text-white">Status</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Active</p>
                        </div>
                    </div>
                    
                    <!-- Member Since -->
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-md font-medium text-gray-900 dark:text-white">Member Since</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    
                    <!-- API Quota -->
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-indigo-500 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-md font-medium text-gray-900 dark:text-white">API Requests</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Unlimited</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Premium Features Summary -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                    Your {{ Auth::user()->premium_type }} Features
                </h3>
                
                <div class="mt-2 space-y-4">
                    @if(Auth::user()->premium_type === 'Streamer')
                        <!-- Streamer Features -->
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-purple-500 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">Stream Protection</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-purple-500 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">Advanced Analytics</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-purple-500 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">Custom Overlays</span>
                        </div>
                    @elseif(Auth::user()->premium_type === 'External')
                        <!-- External Features -->
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">API Access</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">Integration Tools</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">Webhooks</span>
                        </div>
                    @elseif(Auth::user()->premium_type === 'Bypass')
                        <!-- Bypass Features -->
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">Advanced Access</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">Priority Support</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">Custom Solutions</span>
                        </div>
                    @elseif(Auth::user()->premium_type === 'Reseller')
                        <!-- Reseller Features -->
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">Bulk Licensing</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">Reseller Portal</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">Commission System</span>
                        </div>
                    @elseif(Auth::user()->premium_type === 'All')
                        <!-- All Features -->
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-indigo-500 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">All Premium Features</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-indigo-500 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">Priority Support</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-indigo-500 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">Unlimited API Access</span>
                        </div>
                    @else
                        <!-- Default Features -->
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">Basic Access</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">Standard Support</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection