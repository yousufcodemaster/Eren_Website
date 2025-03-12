<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Eren Regedit') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-gray-900 via-purple-900 to-gray-900">
            <div class="mb-4">
                <a href="/" class="flex flex-col items-center">
                    <x-application-logo class="w-28 h-28 fill-current text-white" />
                    <h1 class="mt-3 text-3xl font-bold text-white">Eren Regedit</h1>
                    <p class="text-purple-300 text-sm mt-1">Professional Gaming Tools</p>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-4 px-6 py-6 bg-white/10 backdrop-blur-sm dark:bg-gray-800/90 shadow-xl overflow-hidden sm:rounded-xl border border-purple-500/30">
                {{ $slot }}
            </div>
            
            <div class="mt-6 text-center text-white/70 text-sm">
                &copy; {{ date('Y') }} Eren Regedit - All Rights Reserved
            </div>
        </div>
    </body>
</html>
