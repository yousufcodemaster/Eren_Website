@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Reseller Dashboard</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Manage your client accounts</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 flex flex-col items-center justify-center">
            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $clientCount }}</div>
            <div class="text-gray-700 dark:text-gray-300 mt-2">Total Clients</div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 flex flex-col items-center justify-center">
            <div class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $activeClients }}</div>
            <div class="text-gray-700 dark:text-gray-300 mt-2">Active Clients</div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 flex flex-col items-center justify-center">
            <div class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $expiredClients }}</div>
            <div class="text-gray-700 dark:text-gray-300 mt-2">Expired Clients</div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 flex flex-col items-center justify-center">
            <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $maxClients - $clientCount }}</div>
            <div class="text-gray-700 dark:text-gray-300 mt-2">Remaining Slots</div>
        </div>
    </div>

    <!-- Client Management Card -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
        <div class="flex justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Your Clients</h2>
            <div>
                @if($user->canAddMoreClients())
                    <a href="{{ route('reseller.clients.create') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                        Add New Client
                    </a>
                @else
                    <span class="px-4 py-2 bg-gray-400 text-white rounded-lg cursor-not-allowed">
                        Client Limit Reached
                    </span>
                @endif
            </div>
        </div>

        @if($clients->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Username</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Expires</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Created</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($clients as $client)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $client->username }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($client->active && !$client->isExpired())
                                        <span class="px-2 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 rounded-full text-xs">Active</span>
                                    @elseif($client->isExpired())
                                        <span class="px-2 py-1 bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 rounded-full text-xs">Expired</span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300 rounded-full text-xs">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $client->expires_at ? $client->expires_at->format('M d, Y') : 'Never' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $client->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('reseller.clients.edit', $client) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</a>
                                        <form action="{{ route('reseller.clients.destroy', $client) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this client?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                <p>You haven't created any clients yet.</p>
                @if($user->canAddMoreClients())
                    <a href="{{ route('reseller.clients.create') }}" class="mt-4 inline-block px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                        Create Your First Client
                    </a>
                @endif
            </div>
        @endif
    </div>

    <!-- Client Limit Progress -->
    <div class="mt-8 bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Client Limit</h2>
        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 mb-2">
            <div class="bg-purple-600 h-4 rounded-full" style="width: {{ ($clientCount / $maxClients) * 100 }}%"></div>
        </div>
        <div class="text-sm text-gray-600 dark:text-gray-400">
            {{ $clientCount }} of {{ $maxClients }} clients used ({{ $maxClients - $clientCount }} remaining)
        </div>
        
        @if($clientCount >= $maxClients)
            <div class="mt-4 text-sm text-gray-700 dark:text-gray-300">
                <p>You've reached your client limit. To increase your limit, please contact an administrator.</p>
            </div>
        @endif
    </div>
</div>
@endsection 