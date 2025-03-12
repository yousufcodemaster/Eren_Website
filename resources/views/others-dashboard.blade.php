@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-semibold mb-4">Others Dashboard</h1>
                
                <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg mb-6">
                    <p class="text-blue-700 dark:text-blue-300">
                        Welcome to the Others Role section. This area is specifically designed for users with the "Others" role.
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow">
                        <h3 class="text-lg font-medium mb-2">Your Status</h3>
                        <p>Role: <span class="font-semibold">Others</span></p>
                        <p>Account Created: {{ auth()->user()->created_at->format('M d, Y') }}</p>
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow">
                        <h3 class="text-lg font-medium mb-2">Available Features</h3>
                        <ul class="list-disc pl-5 space-y-1">
                            <li>View Others dashboard</li>
                            <li>Access Others-specific features</li>
                            <li>Manage Others settings</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 