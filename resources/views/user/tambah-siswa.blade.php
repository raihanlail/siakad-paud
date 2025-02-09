<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Form Registrasi Siswa') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Daftarkan siswa dengan informasi yang sesuai') }}
                            </p>
                        </header>



                        <form method="post" action="{{ route('user.daftar.store') }}" class="mt-6 space-y-6">
                            @csrf


                            <div>
                                <x-input-label for="nama" :value="__('Name')" />
                                <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full"
                                    required autofocus autocomplete="nama" onchange="generateNIS()" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>
                            <div>
                                <x-input-label for="orang_tua_id" :value="__('Orang Tua')" />
                                <x-text-input id="orang_tua_id" name="orang_tua_id" type="hidden"
                                    class="mt-1 block w-full" required value="{{ $user->id }}" readonly />
                                <x-text-input type="text" class="mt-1 block w-full" value="{{ $user->name }}"
                                    readonly />
                                <x-input-error class="mt-2" :messages="$errors->get('orang_tua_id')" />
                            </div>

                            <div>
                                <x-input-label for="nis" :value="__('NIS')" />
                                <x-text-input id="nis" name="nis" type="text" class="mt-1 block w-full"
                                    placeholder="{{ __('Masukkan NIS') }}" required readonly />
                                <x-input-error class="mt-2" :messages="$errors->get('nis')" />
                            </div>

                            
                            <script>
                                function generateNIS() {
                                    const randomNIS = Math.floor(100000 + Math.random() * 900000);
                                    document.getElementById('nis').value = randomNIS;
                                }
                            </script>

<div>
    <x-input-label for="jenis_kelamin" value="{{ __('Jenis Kelamin') }}" />
    <select name="jenis_kelamin" id="jenis_kelamin"
    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
    <option value="Laki-laki">Laki-laki</option>
    <option value="Perempuan">Perempuan</option>
    </select>
</div>

                            <div>
                                <x-input-label for="alamat" :value="__('Alamat')" />
                                <x-text-input id="alamat" name="alamat" type="text" class="mt-1 block w-full"
                                    placeholder="{{ __('Masukkan Alamat') }}" required />
                                <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
                            </div>

                            <div>
                                <x-input-label for="tanggal_lahir" :value="__('TTL')" />
                                <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date"
                                    class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('tanggal_lahir')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Daftar') }}</x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
