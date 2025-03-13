@extends('layouts.admin')

@section('content')
<div class="container px-6 py-8 mx-auto">
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">User Subscription</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Subscription details for {{ $user->name }}</p>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit User
            </a>
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Users
            </a>
        </div>
    </div>

    <!-- User Info Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">User Information</h3>
                <dl class="mt-4 space-y-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Role</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ ucfirst($user->role) }}</dd>
                    </div>
                </dl>
            </div>
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Current Subscription</h3>
                <dl class="mt-4 space-y-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Premium Type</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->premium_type ?? 'None' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                        <dd class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Expires At</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->expires_at ? $user->expires_at->format('M d, Y') : 'N/A' }}</dd>
                    </div>
                </dl>
            </div>
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Subscription History</h3>
                <dl class="mt-4 space-y-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Started At</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->created_at->format('M d, Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Renewal</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->last_renewal_at ? $user->last_renewal_at->format('M d, Y') : 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Renewal Count</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->renewal_count ?? 0 }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <!-- Update Subscription Form -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Update Subscription</h3>
        
        <form action="{{ route('admin.users.subscription.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Premium Type -->
                <div>
                    <label for="premium_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Premium Type</label>
                    <select name="premium_type" id="premium_type"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Select a premium type</option>
                        <option value="All" {{ old('premium_type', $user->premium_type) == 'All' ? 'selected' : '' }}>All Premium</option>
                        <option value="External" {{ old('premium_type', $user->premium_type) == 'External' ? 'selected' : '' }}>External</option>
                        <option value="Streamer" {{ old('premium_type', $user->premium_type) == 'Streamer' ? 'selected' : '' }}>Streamer</option>
                        <option value="Bypass" {{ old('premium_type', $user->premium_type) == 'Bypass' ? 'selected' : '' }}>Bypass</option>
                        <option value="Reseller" {{ old('premium_type', $user->premium_type) == 'Reseller' ? 'selected' : '' }}>Reseller</option>
                    </select>
                    @error('premium_type')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Expires At -->
                <div>
                    <label for="expires_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Expiration Date</label>
                    <input type="date" name="expires_at" id="expires_at" value="{{ old('expires_at', $user->expires_at ? $user->expires_at->format('Y-m-d') : '') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @error('expires_at')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="is_active" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <div class="mt-1">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Active</span>
                        </label>
                    </div>
                    @error('is_active')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div class="md:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
                    <textarea name="notes" id="notes" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('notes', $user->subscription_notes) }}</textarea>
                    @error('notes')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Update Subscription
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 