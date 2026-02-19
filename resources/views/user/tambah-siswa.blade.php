<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrasi Siswa Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm rounded-r-md">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 shadow-sm rounded-r-md">
                    <p class="font-bold">Terjadi Kesalahan!</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white shadow-xl sm:rounded-xl overflow-hidden border border-gray-100">
                <div class="bg-indigo-700 px-8 py-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold tracking-tight">Formulir Pendaftaran</h2>
                            <p class="text-indigo-100 text-sm mt-1">Silakan lengkapi biodata calon siswa di bawah ini.</p>
                        </div>
                        <div class="hidden md:block">
                            <svg class="w-12 h-12 opacity-20" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.435.292-3.483.804A.997.997 0 001 5.67V16c0 .554.446 1 .998 1 .215 0 .421-.068.592-.192A6.001 6.001 0 015.5 16c1.304 0 2.515.416 3.5 1.125.985-.709 2.196-1.125 3.5-1.125 1.352 0 2.6.43 3.621 1.162.171.124.377.192.592.192.552 0 1-.446 1-1V5.67a.997.997 0 00-.817-.966A7.968 7.968 0 0014.5 4c-1.255 0-2.435.292-3.483.804V4.804z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <form method="post" action="{{ route('user.daftar.store') }}" class="space-y-6">
                        @csrf

                        <input type="hidden" name="orang_tua_id" value="{{ $user->id }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                            
                            <div class="col-span-1">
                                <x-input-label for="nama" :value="__('Nama Lengkap Siswa')" class="text-gray-700 font-semibold" />
                                <x-text-input id="nama" name="nama" type="text" 
                                    class="mt-1 block w-full border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                                    :value="old('nama')" required autofocus oninput="generateNISPreview()" />
                                <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                            </div>

                            <div class="col-span-1">
                                <x-input-label for="nis_display" :value="__('Pratinjau NIS')" class="text-indigo-600 font-bold" />
                                <div class="relative mt-1">
                                    <input type="text" id="nis_display" 
                                        class="block w-full bg-indigo-50 border-indigo-100 text-indigo-900 font-mono font-bold tracking-widest rounded-md shadow-inner cursor-not-allowed"
                                        readonly placeholder="Auto-generated...">
                                    <span class="absolute right-3 top-2.5 flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                                    </span>
                                </div>
                                <p class="text-[10px] text-gray-400 mt-1 italic">*NIS akhir akan divalidasi oleh sistem saat penyimpanan.</p>
                            </div>

                            <div>
                                <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" class="text-gray-700 font-semibold" />
                                <select name="jenis_kelamin" id="jenis_kelamin" onchange="generateNISPreview()"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm transition duration-150">
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('jenis_kelamin')" />
                            </div>

                            <div>
                                <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" class="text-gray-700 font-semibold" />
                                <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date" 
                                    class="mt-1 block w-full border-gray-300" 
                                    :value="old('tanggal_lahir')" required onchange="generateNISPreview()" />
                                <x-input-error class="mt-2" :messages="$errors->get('tanggal_lahir')" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="alamat" :value="__('Alamat Lengkap')" class="text-gray-700 font-semibold" />
                                <textarea id="alamat" name="alamat" rows="3"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    placeholder="Masukkan alamat domisili saat ini..." required>{{ old('alamat') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
                            </div>
                        </div>

                        <div class="bg-blue-50 border border-blue-100 p-4 rounded-lg flex gap-3">
                            <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                            <p class="text-xs text-blue-700">
                                <strong>Informasi Wali:</strong> Siswa ini akan didaftarkan di bawah akun wali <strong>{{ $user->name }}</strong>. Pastikan data nama siswa sesuai dengan Akta Kelahiran.
                            </p>
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-gray-800 transition">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 px-8 py-3">
                                {{ __('Simpan Data Siswa') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function generateNISPreview() {
            const name = document.getElementById('nama').value.trim();
            const dob = document.getElementById('tanggal_lahir').value;
            const gender = document.getElementById('jenis_kelamin').value;
            const display = document.getElementById('nis_display');
            
            // Generate Prefix Logic: [Year][Gender][Initial][SequencePlaceholder]
            let yearPart = dob ? dob.substring(2, 4) : "??";
            let genderPart = (gender === 'Laki-laki') ? 'L' : 'P';
            let initialPart = name.length > 0 ? name.charAt(0).toUpperCase() : "?";
            
            // We show '000' as a preview because the server will calculate the real '001', '002', etc.
            if (name || dob) {
                display.value = `${yearPart}${genderPart}${initialPart}000`;
            } else {
                display.value = "";
            }
        }

        // Initialize preview if there's old input (e.g., after a validation error)
        document.addEventListener('DOMContentLoaded', generateNISPreview);
    </script>
</x-app-layout>