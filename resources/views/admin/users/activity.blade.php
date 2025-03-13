@extends('layouts.admin')

@section('content')
<div class="container px-6 py-8 mx-auto">
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">User Activity</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Activity logs for {{ $user->name }}</p>
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
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Account Status</h3>
                <dl class="mt-4 space-y-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                        <dd class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Premium Type</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->premium_type ?? 'None' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Joined</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->created_at->format('M d, Y') }}</dd>
                    </div>
                </dl>
            </div>
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Activity Summary</h3>
                <dl class="mt-4 space-y-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Login</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->last_login_at ? $user->last_login_at->format('M d, Y H:i') : 'Never' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Logins</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->login_count ?? 0 }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Activity</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->last_activity_at ? $user->last_activity_at->format('M d, Y H:i') : 'Never' }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <!-- Activity Log -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Activity Log</h3>
        
        <div class="flow-root">
            <ul role="list" class="-mb-8">
                @forelse($activities as $activity)
                    <li>
                        <div class="relative pb-8">
                            @if(!$loop->last)
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700" aria-hidden="true"></span>
                            @endif
                            <div class="relative flex space-x-3">
                                <div>
                                    <span class="h-8 w-8 rounded-full bg-purple-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $activity->description }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $activity->created_at->format('M d, Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="text-center py-4">
                        <p class="text-gray-500 dark:text-gray-400">No activity logs found.</p>
                    </li>
                @endforelse
            </ul>
        </div>

        <!-- Pagination -->
        @if($activities->hasPages())
            <div class="mt-6">
                {{ $activities->links() }}
            </div>
        @endif
    </div>
</div>
@endsection 