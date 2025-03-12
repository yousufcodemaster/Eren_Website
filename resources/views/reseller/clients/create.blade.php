@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-md mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Create New Client</h1>
            <a href="{{ route('reseller.clients.index') }}" class="text-purple-600 dark:text-purple-400 hover:underline">
                Back to Clients
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
            <form action="{{ route('reseller.clients.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="username" class="block text-gray-700 dark:text-gray-300 mb-2">Username</label>
                    <input type="text" name="username" id="username" value="{{ old('username') }}" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-white @error('username') border-red-500 @enderror" 
                        required autofocus>
                    @error('username')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 dark:text-gray-300 mb-2">Password</label>
                    <input type="password" name="password" id="password" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-white @error('password') border-red-500 @enderror" 
                        required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="expires_at" class="block text-gray-700 dark:text-gray-300 mb-2">Expiration Date (Optional)</label>
                    <input type="date" name="expires_at" id="expires_at" value="{{ old('expires_at') }}" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-white @error('expires_at') border-red-500 @enderror">
                    @error('expires_at')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="active" class="flex items-center text-gray-700 dark:text-gray-300">
                        <input type="checkbox" name="active" id="active" value="1" class="mr-2 rounded border-gray-300 dark:border-gray-700 text-purple-600 focus:ring-purple-500 dark:bg-gray-700" checked>
                        Active
                    </label>
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                        Create Client
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 