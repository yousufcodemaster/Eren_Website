<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full" x-data="{ darkMode: localStorage.getItem('darkMode') || 'system' }" x-init="
    if (darkMode === 'dark' || (darkMode === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
    
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
        if (darkMode !== 'system') return;
        if (e.matches) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    });
" :class="{ 'dark': darkMode === 'dark' || (darkMode === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches) }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js CDN (add this if you're not already loading Alpine via your build system) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
</head>

<body class="font-sans antialiased h-full">
    <div class="min-h-screen flex flex-col bg-gray-100 dark:bg-gray-900">
        <!-- Navigation Bar -->
        <div class="bg-white dark:bg-gray-800 shadow-md fixed w-full z-50">
            @include('layouts.navigation')
        </div>

        <!-- Page Wrapper -->
        <div class="flex-grow pt-16">
            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow-md mb-6">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-center">
                        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $header }}</h1>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6">
                    @yield('content')
                </div>
            </main>
        </div>

        <!-- Footer -->
        <footer class="mt-6 bg-gray-200 dark:bg-gray-800 text-center py-4 text-gray-600 dark:text-gray-300">
            © {{ date('Y') }} Insane Regedit. All rights reserved.
        </footer>
    </div>

</body>

</html>