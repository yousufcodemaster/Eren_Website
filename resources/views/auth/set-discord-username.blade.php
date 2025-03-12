<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Please set your Discord username to complete your registration.') }}
        </div>

        <form method="POST" action="{{ route('discord.username.store') }}">
            @csrf

            <!-- Discord Username -->
            <div>
                <x-input-label for="discord_username" :value="__('Discord Username')" />
                <x-text-input id="discord_username" class="block mt-1 w-full" type="text" name="discord_username" :value="old('discord_username')" required autofocus placeholder="username#1234" />
                <x-input-error :messages="$errors->get('discord_username')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-3">
                    {{ __('Continue') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout> 