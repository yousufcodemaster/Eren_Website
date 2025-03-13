@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-white">Reseller Account Management</h1>
        </div>

        <!-- Search and Filter Bar -->
        <div class="bg-gray-800 shadow-md rounded-lg p-4 mb-6">
            <form action="{{ route('admin.resellers.management') }}" method="GET" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label for="search" class="sr-only">Search</label>
                    <input type="text" name="search" id="search" placeholder="Search by name or email..." 
                           value="{{ request()->search }}"
                           class="w-full rounded-md border-gray-600 bg-gray-700 text-white placeholder-gray-400 shadow-sm focus:ring-purple-500 focus:border-purple-500">
                </div>
                
                <div class="w-auto">
                    <label for="order_by" class="sr-only">Sort By</label>
                    <select name="order_by" id="order_by" 
                            class="rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:ring-purple-500 focus:border-purple-500">
                        <option value="created_at" {{ request()->order_by == 'created_at' ? 'selected' : '' }}>Date Created</option>
                        <option value="name" {{ request()->order_by == 'name' ? 'selected' : '' }}>Name</option>
                        <option value="email" {{ request()->order_by == 'email' ? 'selected' : '' }}>Email</option>
                    </select>
                </div>
                
                <div class="w-auto">
                    <label for="order_dir" class="sr-only">Order</label>
                    <select name="order_dir" id="order_dir" 
                            class="rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:ring-purple-500 focus:border-purple-500">
                        <option value="desc" {{ request()->order_dir == 'desc' ? 'selected' : '' }}>Descending</option>
                        <option value="asc" {{ request()->order_dir == 'asc' ? 'selected' : '' }}>Ascending</option>
                    </select>
                </div>
                
                <div class="w-auto">
                    <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Resellers Table -->
        <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Reseller
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Clients
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Limit
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
                        @foreach($resellers as $reseller)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($reseller->discord_avatar)
                                                <img class="h-10 w-10 rounded-full" src="{{ $reseller->discord_avatar }}" alt="{{ $reseller->name }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-purple-600 flex items-center justify-center">
                                                    <span class="text-white font-medium">{{ substr($reseller->name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-white">{{ $reseller->name }}</div>
                                            <div class="text-sm text-gray-400">ID: {{ $reseller->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-white">{{ $reseller->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-white">{{ $reseller->clients->count() }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('admin.resellers.update-limit', $reseller) }}" method="POST" class="flex items-center space-x-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="max_clients" value="{{ $reseller->max_clients }}" min="0" max="100"
                                            class="w-16 rounded-md border-gray-700 bg-gray-700 text-white text-center">
                                        <button type="submit" class="text-indigo-400 hover:text-indigo-300">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                    {{ $reseller->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="#" class="text-indigo-400 hover:text-indigo-300 mr-3" 
                                        onclick="viewReseller({{ $reseller->id }})">View Clients</a>
                                    <a href="{{ route('admin.users.edit', $reseller) }}" class="text-indigo-400 hover:text-indigo-300">Edit</a>
                                </td>
                            </tr>
                            
                            <!-- Clients Section (hidden by default) -->
                            <tr id="reseller-clients-{{ $reseller->id }}" class="hidden bg-gray-900">
                                <td colspan="6" class="px-6 py-4">
                                    <div class="mb-2">
                                        <h3 class="text-lg font-medium text-white">Clients of {{ $reseller->name }}</h3>
                                    </div>
                                    
                                    @if($reseller->clients->count() > 0)
                                        <div class="overflow-x-auto">
                                            <table class="min-w-full divide-y divide-gray-700">
                                                <thead class="bg-gray-800">
                                                    <tr>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Name</th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Email</th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Created At</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-gray-800 divide-y divide-gray-700">
                                                    @foreach($reseller->clients as $client)
                                                        <tr>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">{{ $client->username }}</td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $client->email }}</td>
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                    Active
                                                                </span>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $client->created_at->format('M d, Y') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-gray-400 text-center py-4">No clients found for this reseller.</div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-4 py-3 bg-gray-700 border-t border-gray-600 sm:px-6">
                {{ $resellers->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    function viewReseller(id) {
        const clientsRow = document.getElementById(`reseller-clients-${id}`);
        if (clientsRow.classList.contains('hidden')) {
            clientsRow.classList.remove('hidden');
        } else {
            clientsRow.classList.add('hidden');
        }
    }
</script>
@endsection 