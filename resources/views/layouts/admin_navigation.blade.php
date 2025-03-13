<nav x-data="{ open: false }" class="bg-gray-800 border-b border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <span class="text-2xl font-bold text-purple-500">Eren Regedit</span>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="{{ route('admin.dashboard') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 
                        {{ request()->routeIs('admin.dashboard') ? 'border-purple-500 text-purple-400' : 'border-transparent text-gray-400 hover:text-gray-300' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.users.index') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 
                        {{ request()->routeIs('admin.users.*') ? 'border-purple-500 text-purple-400' : 'border-transparent text-gray-400 hover:text-gray-300' }}">
                        User Management
                    </a>
                    <a href="{{ route('admin.resellers.management') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 
                        {{ request()->routeIs('admin.resellers.management') || request()->routeIs('admin.resellers.show') ? 'border-purple-500 text-purple-400' : 'border-transparent text-gray-400 hover:text-gray-300' }}">
                        Reseller Management
                    </a>
                    <a href="{{ route('admin.resellers.analytics') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 
                        {{ request()->routeIs('admin.resellers.analytics') ? 'border-purple-500 text-purple-400' : 'border-transparent text-gray-400 hover:text-gray-300' }}">
                        Reseller Analytics
                    </a>
                    <a href="{{ route('settings') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 
                        {{ request()->routeIs('settings') ? 'border-purple-500 text-purple-400' : 'border-transparent text-gray-400 hover:text-gray-300' }}">
                        Settings
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="ml-3 relative">
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-300">{{ Auth::user()->name }}</span>
                        <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-300">
                            Back to Site
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-400 hover:text-gray-300">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('admin.dashboard') }}"
                class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium 
                {{ request()->routeIs('admin.dashboard') ? 'border-purple-500 text-purple-400 bg-purple-900/50' : 'border-transparent text-gray-400 hover:text-gray-300 hover:bg-gray-700' }}">
                Dashboard
            </a>
            <a href="{{ route('admin.users.index') }}"
                class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium 
                {{ request()->routeIs('admin.users.*') ? 'border-purple-500 text-purple-400 bg-purple-900/50' : 'border-transparent text-gray-400 hover:text-gray-300 hover:bg-gray-700' }}">
                User Management
            </a>
            <a href="{{ route('admin.resellers.management') }}"
                class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium 
                {{ request()->routeIs('admin.resellers.management') || request()->routeIs('admin.resellers.show') ? 'border-purple-500 text-purple-400 bg-purple-900/50' : 'border-transparent text-gray-400 hover:text-gray-300 hover:bg-gray-700' }}">
                Reseller Management
            </a>
            <a href="{{ route('admin.resellers.analytics') }}"
                class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium 
                {{ request()->routeIs('admin.resellers.analytics') ? 'border-purple-500 text-purple-400 bg-purple-900/50' : 'border-transparent text-gray-400 hover:text-gray-300 hover:bg-gray-700' }}">
                Reseller Analytics
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-700">
            <div class="px-4">
                <div class="font-medium text-base text-gray-300">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <a href="{{ route('dashboard') }}"
                    class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-400 hover:text-gray-300 hover:bg-gray-700">
                    Back to Site
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="block w-full text-left pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-400 hover:text-gray-300 hover:bg-gray-700">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
