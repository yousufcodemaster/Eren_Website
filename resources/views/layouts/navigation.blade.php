<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('pricing')" :active="request()->routeIs('pricing')">
                        {{ __('Pricing') }}
                    </x-nav-link>

                    @if(Auth::check() && Auth::user()->is_reseller)
                        <x-nav-link :href="route('reseller.dashboard')" :active="request()->routeIs('reseller.*')">
                            {{ __('Reseller Dashboard') }}
                        </x-nav-link>
                    @endif

                    @if(Auth::check() && Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">
                            {{ __('Admin Dashboard') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <!-- User Avatar -->
                            <div class="flex-shrink-0 h-8 w-8 mr-2">
                                @if(Auth::user()->discord_avatar)
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->discord_avatar }}" alt="{{ Auth::user()->name }}">
                                @else
                                    <img class="h-8 w-8 rounded-full object-cover" 
                                        src="{{ 
                                            Auth::user()->role === 'admin' 
                                                ? asset('images/avatars/admin-avatar.svg') 
                                                : (Auth::user()->premium_type === 'Streamer' 
                                                    ? asset('images/avatars/streamer-avatar.svg')
                                                    : (Auth::user()->premium_type === 'External'
                                                        ? asset('images/avatars/external-avatar.svg')
                                                        : (Auth::user()->premium_type === 'Bypass'
                                                            ? asset('images/avatars/bypass-avatar.svg')
                                                            : (Auth::user()->premium_type === 'Reseller'
                                                                ? asset('images/avatars/reseller-avatar.svg')
                                                                : (Auth::user()->premium_type === 'All'
                                                                    ? asset('images/avatars/premium-avatar.svg')
                                                                    : asset('images/avatars/user-avatar.svg')
                                                                )
                                                            )
                                                        )
                                                    )
                                                )
                                        }}" 
                                        alt="{{ Auth::user()->name }}">
                                @endif
                            </div>
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Theme Toggle -->
                        <div class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300">
                            <div class="flex items-center justify-between">
                                <span>Theme</span>
                                <div class="flex items-center space-x-2">
                                    <!-- Light Mode -->
                                    <button @click="darkMode = 'light'; localStorage.setItem('darkMode', 'light')" 
                                        class="p-1.5 rounded-md" 
                                        :class="{ 'bg-gray-200 dark:bg-gray-700': darkMode === 'light' }">
                                        <svg class="h-5 w-5 text-gray-700 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </button>
                                    
                                    <!-- System Mode -->
                                    <button @click="darkMode = 'system'; localStorage.setItem('darkMode', 'system')" 
                                        class="p-1.5 rounded-md" 
                                        :class="{ 'bg-gray-200 dark:bg-gray-700': darkMode === 'system' }">
                                        <svg class="h-5 w-5 text-gray-700 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </button>
                                    
                                    <!-- Dark Mode -->
                                    <button @click="darkMode = 'dark'; localStorage.setItem('darkMode', 'dark')" 
                                        class="p-1.5 rounded-md" 
                                        :class="{ 'bg-gray-200 dark:bg-gray-700': darkMode === 'dark' }">
                                        <svg class="h-5 w-5 text-gray-700 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 dark:border-gray-600"></div>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('pricing')" :active="request()->routeIs('pricing')">
                {{ __('Pricing') }}
            </x-responsive-nav-link>

            @if(Auth::check() && Auth::user()->is_reseller)
                <x-responsive-nav-link :href="route('reseller.dashboard')" :active="request()->routeIs('reseller.*')">
                    {{ __('Reseller Dashboard') }}
                </x-responsive-nav-link>
            @endif
            
            @if(Auth::check() && Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">
                    {{ __('Admin Dashboard') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4 flex items-center">
                <!-- User Avatar for Mobile -->
                <div class="flex-shrink-0 h-10 w-10 mr-3">
                    @if(Auth::user()->discord_avatar)
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->discord_avatar }}" alt="{{ Auth::user()->name }}">
                    @else
                        <img class="h-10 w-10 rounded-full object-cover" 
                            src="{{ 
                                Auth::user()->role === 'admin' 
                                    ? asset('images/avatars/admin-avatar.svg') 
                                    : (Auth::user()->premium_type === 'Streamer' 
                                        ? asset('images/avatars/streamer-avatar.svg')
                                        : (Auth::user()->premium_type === 'External'
                                            ? asset('images/avatars/external-avatar.svg')
                                            : (Auth::user()->premium_type === 'Bypass'
                                                ? asset('images/avatars/bypass-avatar.svg')
                                                : (Auth::user()->premium_type === 'Reseller'
                                                    ? asset('images/avatars/reseller-avatar.svg')
                                                    : (Auth::user()->premium_type === 'All'
                                                        ? asset('images/avatars/premium-avatar.svg')
                                                        : asset('images/avatars/user-avatar.svg')
                                                    )
                                                )
                                            )
                                        )
                                    )
                            }}" 
                            alt="{{ Auth::user()->name }}">
                    @endif
                </div>
                <div>
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Theme Toggle -->
                <div class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-600 pb-2 mb-2">
                    <div class="flex items-center justify-between">
                        <span>Theme</span>
                        <div class="flex items-center space-x-3">
                            <!-- Light Mode -->
                            <button @click="darkMode = 'light'; localStorage.setItem('darkMode', 'light')" 
                                class="p-1.5 rounded-md" 
                                :class="{ 'bg-gray-200 dark:bg-gray-700': darkMode === 'light' }">
                                <svg class="h-5 w-5 text-gray-700 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </button>
                            
                            <!-- System Mode -->
                            <button @click="darkMode = 'system'; localStorage.setItem('darkMode', 'system')" 
                                class="p-1.5 rounded-md" 
                                :class="{ 'bg-gray-200 dark:bg-gray-700': darkMode === 'system' }">
                                <svg class="h-5 w-5 text-gray-700 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </button>
                            
                            <!-- Dark Mode -->
                            <button @click="darkMode = 'dark'; localStorage.setItem('darkMode', 'dark')" 
                                class="p-1.5 rounded-md" 
                                :class="{ 'bg-gray-200 dark:bg-gray-700': darkMode === 'dark' }">
                                <svg class="h-5 w-5 text-gray-700 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
