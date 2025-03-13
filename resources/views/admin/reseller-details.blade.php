@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-white">Reseller Details</h1>
                <p class="mt-1 text-sm text-gray-400">Detailed view of reseller account and clients</p>
            </div>
            <div>
                <a href="{{ route('admin.resellers.management') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm">
                    Back to Resellers
                </a>
            </div>
        </div>

        <!-- Reseller Profile Card -->
        <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-700">
                <h3 class="text-lg leading-6 font-medium text-white">
                    Reseller Information
                </h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1 flex justify-center">
                        <div class="flex flex-col items-center">
                            @if($reseller->discord_avatar)
                                <img class="h-36 w-36 rounded-full" src="{{ $reseller->discord_avatar }}" alt="{{ $reseller->name }}">
                            @else
                                <div class="h-36 w-36 rounded-full bg-purple-600 flex items-center justify-center">
                                    <span class="text-white text-4xl font-medium">{{ substr($reseller->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div class="mt-4 text-center">
                                <h2 class="text-xl font-bold text-white">{{ $reseller->name }}</h2>
                                <p class="text-gray-400">ID: {{ $reseller->id }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-400">Email</h4>
                                <p class="mt-1 text-sm text-white">{{ $reseller->email }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-400">Account Created</h4>
                                <p class="mt-1 text-sm text-white">{{ $reseller->created_at->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-400">Client Limit</h4>
                                <div class="mt-1 flex items-center">
                                    <form action="{{ route('admin.resellers.update-limit', $reseller) }}" method="POST" class="flex items-center space-x-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="max_clients" value="{{ $reseller->max_clients }}" min="0" max="100"
                                            class="w-20 rounded-md border-gray-700 bg-gray-700 text-white text-center">
                                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded-md text-sm">
                                            Update
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-400">Clients</h4>
                                <p class="mt-1 text-sm text-white">
                                    <span class="font-bold">{{ $reseller->clients->count() }}</span> / {{ $reseller->max_clients }}
                                    <span class="text-gray-400">({{ $reseller->max_clients > 0 ? round(($reseller->clients->count() / $reseller->max_clients) * 100) : 0 }}%)</span>
                                </p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-400">Discord ID</h4>
                                <p class="mt-1 text-sm text-white">{{ $reseller->discord_id ?? 'Not connected' }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-400">Status</h4>
                                <p class="mt-1">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clients Table -->
        <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="px-4 py-5 border-b border-gray-700 sm:px-6 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-white">
                    Client List
                </h3>
                <span class="text-sm text-gray-400">Total: {{ $reseller->clients->count() }}</span>
            </div>
            <div class="overflow-x-auto">
                @if($reseller->clients->count() > 0)
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Client
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Created At
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-800 divide-y divide-gray-700">
                            @foreach($reseller->clients as $client)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if($client->discord_avatar)
                                                    <img class="h-10 w-10 rounded-full" src="{{ $client->discord_avatar }}" alt="{{ $client->username }}">
                                                @else
                                                    <div class="h-10 w-10 rounded-full bg-gray-600 flex items-center justify-center">
                                                        <span class="text-white font-medium">{{ substr($client->username ?? 'U', 0, 1) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-white">{{ $client->username ?? $client->name }}</div>
                                                <div class="text-sm text-gray-400">ID: {{ $client->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                        {{ $client->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                        {{ $client->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <form action="{{ route('admin.resellers.remove-client', ['reseller' => $reseller->id, 'clientId' => $client->id]) }}" 
                                              method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to remove this client?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300">
                                                Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="px-6 py-10 text-center text-gray-400">
                        <p>This reseller has no clients yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 