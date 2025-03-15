<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" />
            <select id="role" name="role" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" onchange="toggleGuruFields()">
                <option value="user">Orang Tua</option>
                <option value="guru">Guru</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Guru Fields -->
        <div id="guruFields" style="display: none;">
            <!-- NIP -->
            <div class="mt-4">
                <x-input-label for="nip" :value="__('NIP')" />
                <x-text-input id="nip" class="block mt-1 w-full" type="text" name="nip" :value="old('nip')" />
                <x-input-error :messages="$errors->get('nip')" class="mt-2" />
            </div>

            <!-- No Telp -->
            <div class="mt-4">
                <x-input-label for="no_telp" :value="__('No Telepon')" />
                <x-text-input id="no_telp" class="block mt-1 w-full" type="text" name="no_telp" :value="old('no_telp')" />
                <x-input-error :messages="$errors->get('no_telp')" class="mt-2" />
            </div>

            <!-- Alamat -->
            <div class="mt-4">
                <x-input-label for="alamat" :value="__('Alamat')" />
                <x-text-input id="alamat" class="block mt-1 w-full" type="text" name="alamat" :value="old('alamat')" />
                <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
            </div>

            <!-- Mata Pelajaran -->
            <div class="mt-4">
                <x-input-label for="mata_pelajaran_id" :value="__('Mata Pelajaran')" />
                <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">Pilih Mata Pelajaran</option>
                    @foreach ($mapel as $m)
                        <option value="{{ $m->id }}">{{ $m->nama }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('mata_pelajaran_id')" class="mt-2" />
            </div>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        function toggleGuruFields() {
            var role = document.getElementById('role').value;
            var guruFields = document.getElementById('guruFields');
            if (role === 'guru') {
                guruFields.style.display = 'block';
                document.getElementById('nip').required = true;
                document.getElementById('no_telp').required = true;
                document.getElementById('alamat').required = true;
                document.getElementById('mata_pelajaran_id').required = true;
            } else {
                guruFields.style.display = 'none';
                document.getElementById('nip').required = false;
                document.getElementById('no_telp').required = false;
                document.getElementById('alamat').required = false;
                document.getElementById('mata_pelajaran_id').required = false;
            }
        }
    </script>
</x-guest-layout>
