@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-6">
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Panel Access Required</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Please enter your panel password to continue</p>
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

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-gray-400 dark:text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Verify Panel Password
                    </div>
                </h3>
            </div>
            <div class="px-6 py-4">
                <form action="{{ route('panel.password.verify') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="redirect_to" value="{{ request()->path() }}">
                    
                    <div>
                        <label for="panel_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Panel Password</label>
                        <input type="password" name="panel_password" id="panel_password" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Verify Password
                        </button>
                        
                        <a href="{{ route('settings') }}" class="text-sm text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                            Set or Update Panel Password
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 