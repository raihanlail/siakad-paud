<x-guest-layout>

    {{-- Heading --}}
    <div class="mb-6">
        <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight">Buat Akun</h2>
        <p class="text-sm text-gray-400 mt-1">Daftarkan akun Orang Tua / Wali Siswa</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="role" value="user">

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <! -- Phone -->
        <div>
            <x-input-label for="phone" :value="__('Nomor Telepon')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone"
                :value="old('phone')" required autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

            <!-- Address -->
            <div>
                <x-input-label for="alamat" :value="__('Alamat')" />
                <x-text-input id="alamat" class="block mt-1 w-full" type="text" name="alamat"
                    :value="old('alamat')" required autocomplete="street-address" />
                <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
            </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password"
                name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit -->
        <x-primary-button class="w-full justify-center mt-2">
            {{ __('Daftar') }}
        </x-primary-button>

        <!-- Login link -->
        <p class="text-center text-sm text-gray-400 pt-2 border-t border-gray-100">
            Sudah punya akun?
            <a href="{{ route('login') }}"
                class="text-indigo-600 hover:text-indigo-800 font-semibold transition-colors">
                Masuk di sini
            </a>
        </p>
    </form>
</x-guest-layout>