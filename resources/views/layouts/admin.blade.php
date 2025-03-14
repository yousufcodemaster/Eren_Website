<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Custom Styles -->
    <style>
        [x-cloak] { display: none !important; }
        
        .dark .dark\:divide-gray-600 > :not([hidden]) ~ :not([hidden]) {
            border-color: rgba(75, 85, 99);
        }
        
        .dark .dark\:bg-gray-900-accent {
            background-color: rgba(17, 24, 39, 0.7);
        }
        
        .fade-in-right {
            animation: fadeInRight 0.3s ease-in-out;
        }
        
        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>

<body class="font-sans antialiased h-full bg-gray-100 dark:bg-gray-900" 
      x-data="{ darkMode: localStorage.getItem('darkMode') || 'system', sidebarOpen: false }" 
      x-init="
        $watch('darkMode', value => {
            localStorage.setItem('darkMode', value);
            if (value === 'dark' || (value === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        });
        
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
        });" 
      :class="{'dark': darkMode === 'dark' || (darkMode === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)}">
    <div class="min-h-screen flex flex-col">
        <!-- Sidebar and Header -->
        <div class="flex flex-1">
            <!-- Sidebar -->
            <div x-cloak :class="{'block': sidebarOpen, 'hidden': !sidebarOpen}" @click="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>
            
            <div x-cloak :class="{'translate-x-0 ease-out': sidebarOpen, '-translate-x-full ease-in': !sidebarOpen}" class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 lg:translate-x-0 lg:static lg:inset-0">
                <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <span class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                            Eren Regedit
                        </span>
                    </div>
                    <button @click="sidebarOpen = false" class="p-2 rounded-md lg:hidden">
                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <nav class="p-4 space-y-1">
                    <!-- Dashboard Link -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-purple-100 text-purple-600 dark:bg-purple-900 dark:bg-opacity-30 dark:text-purple-300' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }} rounded-lg transition-colors duration-150">
                        <i class="fa-solid fa-gauge-high w-5 h-5 mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <!-- User Management Link -->
                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.users.*') ? 'bg-purple-100 text-purple-600 dark:bg-purple-900 dark:bg-opacity-30 dark:text-purple-300' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }} rounded-lg transition-colors duration-150">
                        <i class="fa-solid fa-users w-5 h-5 mr-3"></i>
                        <span>User Management</span>
                    </a>
                    
                    <!-- Reseller Management Link -->
                    <a href="{{ route('admin.resellers.management') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.resellers.*') ? 'bg-purple-100 text-purple-600 dark:bg-purple-900 dark:bg-opacity-30 dark:text-purple-300' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }} rounded-lg transition-colors duration-150">
                        <i class="fa-solid fa-user-tie w-5 h-5 mr-3"></i>
                        <span>Reseller Management</span>
                    </a>
                    
                    <!-- Downloads Management Link -->
                    <a href="{{ route('admin.downloads.manage') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.downloads.*') ? 'bg-purple-100 text-purple-600 dark:bg-purple-900 dark:bg-opacity-30 dark:text-purple-300' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }} rounded-lg transition-colors duration-150">
                        <i class="fa-solid fa-download w-5 h-5 mr-3"></i>
                        <span>Download Management</span>
                    </a>
                    
                    <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 rounded-lg transition-colors duration-150">
                            <i class="fa-solid fa-arrow-left w-5 h-5 mr-3"></i>
                            <span>Back to Site</span>
                        </a>
                    </div>
                </nav>
            </div>
            
            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Top Header -->
                <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
                    <div class="px-4 py-3 flex items-center justify-between">
                        <!-- Mobile menu button -->
                        <button @click="sidebarOpen = true" class="lg:hidden text-gray-500 dark:text-gray-300 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        
                        <!-- Search Bar -->
                        <div class="hidden md:flex md:flex-1 ml-4">
                            <div class="relative w-full max-w-md">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" class="block w-full pl-10 pr-3 py-2 rounded-md text-gray-900 dark:text-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-purple-500 sm:text-sm" placeholder="Search...">
                            </div>
                        </div>
                        
                        <!-- Right side header items -->
                        <div class="flex items-center space-x-4">
                            <!-- Dark mode toggle -->
                            <div class="relative">
                                <button @click="darkMode = darkMode === 'dark' ? 'light' : 'dark'" class="text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100 focus:outline-none">
                                    <svg x-show="darkMode !== 'dark'" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                    </svg>
                                    <svg x-show="darkMode === 'dark'" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            <!-- User dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center focus:outline-none">
                                    <div class="h-8 w-8 rounded-full overflow-hidden border-2 border-gray-200 dark:border-gray-700">
                                        @if(Auth::user()->discord_avatar)
                                            <img src="{{ Auth::user()->discord_avatar }}" alt="{{ Auth::user()->name }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="h-full w-full bg-purple-500 flex items-center justify-center">
                                                <span class="text-white text-xs font-bold">{{ substr(Auth::user()->name, 0, 2) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">{{ Auth::user()->name }}</span>
                                    <svg class="ml-1 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                
                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50 border border-gray-200 dark:border-gray-700" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95">
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Back to Site</a>
                                    <a href="{{ route('settings') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Settings</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Logout</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
                
                <!-- Content -->
                <main class="flex-1 overflow-y-auto bg-gray-100 dark:bg-gray-900">
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 mx-4 mt-4 rounded" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 mx-4 mt-4 rounded" role="alert">
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 mx-4 mt-4 rounded" role="alert">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    @stack('scripts')
</body>

</html>