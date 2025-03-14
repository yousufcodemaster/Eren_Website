<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-white">Welcome Back</h2>
        <p class="text-purple-200 mt-1">Sign in to your account</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-purple-100 mb-1">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                class="w-full px-4 py-2 bg-white/10 border border-purple-300/30 rounded-lg text-white placeholder-purple-200/50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                placeholder="your@email.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-purple-100 mb-1">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full px-4 py-2 bg-white/10 border border-purple-300/30 rounded-lg text-white placeholder-purple-200/50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mb-6">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded bg-white/10 border-purple-300/30 text-purple-600 shadow-sm focus:ring-purple-500 focus:ring-offset-0" name="remember">
                <span class="ms-2 text-sm text-purple-200">Remember me</span>
            </label>
            
            @if (Route::has('password.request'))
                <a class="text-sm text-purple-300 hover:text-white transition-colors duration-200" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <button type="submit" class="w-full py-2.5 px-4 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-medium rounded-lg shadow-lg hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition-all duration-200">
            Sign In
        </button>
    </form>

    <div class="mt-6 text-center">
        <p class="text-purple-200">
            Don't have an account? 
            <a href="{{ route('register') }}" class="text-white font-medium hover:underline">Sign up</a>
        </p>
    </div>
</x-guest-layout>
