<x-guest-layout>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- S-Number -->
        <div>
            <x-input-label for="s_number" :value="__('S-Number')" />
            <x-text-input id="s_number" class="block mt-1 w-full" type="text" name="s_number" :value="old('s_number')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('s_number')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
