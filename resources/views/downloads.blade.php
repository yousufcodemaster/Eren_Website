@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl sm:truncate">
                        Downloads
                    </h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Access your {{ Auth::user()->premium_type }} downloads here
                    </p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700">
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Downloads Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden mb-6">
            @if(count($downloads) > 0)
                @foreach($downloads as $download)
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white flex items-center">
                            <svg class="h-6 w-6 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            {{ $download->title }}
                        </h3>
                        
                        <div class="mt-4 bg-gray-50 dark:bg-gray-900 p-4 rounded-md">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="text-md font-medium text-gray-900 dark:text-white">{{ $download->title }} v{{ $download->version }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $download->description }}</p>
                                    
                                    <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                        <p><span class="font-semibold">Last updated:</span> {{ $download->formatted_date }}</p>
                                        @if($download->release_notes)
                                        <div class="mt-1">
                                            <p class="font-semibold">What's new:</p>
                                            <div class="ml-2 mt-1">
                                                {!! nl2br(e($download->release_notes)) !!}
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <a href="{{ $download->url }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="p-6 text-center">
                    <p class="text-gray-500 dark:text-gray-400">No downloads available for your account type.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 