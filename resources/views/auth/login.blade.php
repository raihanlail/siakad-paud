<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- Heading --}}
    <div class="mb-6">
        <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight">Selamat Datang</h2>
        <p class="text-sm text-gray-400 mt-1">Masuk ke akun SIAKAD RA Alifia Anda</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password"
                name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me + Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                    name="remember">
                <span class="text-sm text-gray-500">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                    class="text-sm text-indigo-600 hover:text-indigo-800 font-medium transition-colors">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <!-- Submit -->
        <x-primary-button class="w-full justify-center mt-2">
            {{ __('Masuk') }}
        </x-primary-button>

        <!-- Register link -->
        <p class="text-center text-sm text-gray-400 pt-2 border-t border-gray-100">
            Belum punya akun?
            <a href="{{ route('register') }}"
                class="text-indigo-600 hover:text-indigo-800 font-semibold transition-colors">
                Daftar sekarang
            </a>
        </p>
    </form>
</x-guest-layout>