@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold">Manage Downloads</h1>
                    <button type="button" onclick="document.getElementById('add-download-modal').classList.remove('hidden')" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                        Add New Download
                    </button>
                </div>

                @if (session('status'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('status') }}</span>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white dark:bg-gray-700 rounded-lg overflow-hidden">
                        <thead class="bg-gray-100 dark:bg-gray-600 text-gray-900 dark:text-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Version</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Date Added</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-500">
                            @forelse ($downloads as $download)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $download->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $download->version }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $download->type }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $download->formatted_date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button type="button" onclick="openEditModal({{ $download->id }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">Edit</button>
                                        
                                        <form method="POST" action="{{ route('admin.downloads.delete', $download) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('Are you sure you want to delete this download?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No downloads available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Download Modal -->
<div id="add-download-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-8 max-w-2xl w-full">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Add New Download</h2>
            <button type="button" onclick="document.getElementById('add-download-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <form method="POST" action="{{ route('admin.downloads.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                    <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
                
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Download URL</label>
                        <input type="url" name="url" id="url" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Enter a URL or upload a file below</p>
                    </div>
                    
                    <div>
                        <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Upload File</label>
                        <input type="file" name="file" id="file" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-medium
                            file:bg-purple-50 file:text-purple-700
                            dark:file:bg-purple-900 dark:file:text-purple-200
                            hover:file:bg-purple-100 dark:hover:file:bg-purple-800">
                    </div>
                </div>
                
                <div>
                    <label for="version" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Version</label>
                    <input type="text" name="version" id="version" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
                
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">User Type</label>
                    <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="All">All Users</option>
                        <option value="External">External</option>
                        <option value="Streamer">Streamer</option>
                        <option value="Bypass">Bypass</option>
                        <option value="Reseller">Reseller</option>
                    </select>
                </div>
                
                <div>
                    <label for="release_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Release Notes</label>
                    <textarea name="release_notes" id="release_notes" rows="4" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                </div>
                
                <div class="flex justify-end pt-4">
                    <button type="button" onclick="document.getElementById('add-download-modal').classList.add('hidden')" class="bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-md mr-2">Cancel</button>
                    <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700">Add Download</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Download Modal -->
<div id="edit-download-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-8 max-w-2xl w-full">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Edit Download</h2>
            <button type="button" onclick="document.getElementById('edit-download-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <form id="edit-download-form" method="POST" action="" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label for="edit_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                    <input type="text" name="title" id="edit_title" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
                
                <div>
                    <label for="edit_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <textarea name="description" id="edit_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="edit_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Download URL</label>
                        <input type="url" name="url" id="edit_url" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Current URL or upload a new file below</p>
                    </div>
                    
                    <div>
                        <label for="edit_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Upload New File</label>
                        <input type="file" name="file" id="edit_file" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-medium
                            file:bg-purple-50 file:text-purple-700
                            dark:file:bg-purple-900 dark:file:text-purple-200
                            hover:file:bg-purple-100 dark:hover:file:bg-purple-800">
                    </div>
                </div>
                
                <div>
                    <label for="edit_version" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Version</label>
                    <input type="text" name="version" id="edit_version" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
                
                <div>
                    <label for="edit_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">User Type</label>
                    <select name="type" id="edit_type" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="All">All Users</option>
                        <option value="External">External</option>
                        <option value="Streamer">Streamer</option>
                        <option value="Bypass">Bypass</option>
                        <option value="Reseller">Reseller</option>
                    </select>
                </div>
                
                <div>
                    <label for="edit_release_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Release Notes</label>
                    <textarea name="release_notes" id="edit_release_notes" rows="4" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                </div>
                
                <div class="flex justify-end pt-4">
                    <button type="button" onclick="document.getElementById('edit-download-modal').classList.add('hidden')" class="bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-md mr-2">Cancel</button>
                    <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700">Update Download</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id) {
        // Fetch download details via AJAX
        fetch(`/admin/downloads/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                // Populate the form with download data
                document.getElementById('edit_title').value = data.title;
                document.getElementById('edit_description').value = data.description;
                document.getElementById('edit_url').value = data.url;
                document.getElementById('edit_version').value = data.version;
                document.getElementById('edit_type').value = data.type;
                document.getElementById('edit_release_notes').value = data.release_notes || '';
                
                // Set form action URL
                document.getElementById('edit-download-form').action = `/admin/downloads/${id}`;
                
                // Show the modal
                document.getElementById('edit-download-modal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error fetching download details:', error);
                alert('Failed to load download details. Please try again.');
            });
    }
</script>
@endsection 