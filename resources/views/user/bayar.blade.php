<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Form Pembayaran Siswa') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Isi form untuk melakukan pembayaran. Pembayaran akan diverifikasi admin maksimal 3 hari kerja.') }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('user.bayar.store') }}" class="mt-6 space-y-6"
                            enctype="multipart/form-data">
                            @csrf

                            <div>
                                <x-input-label for="siswa_id" :value="__('Nama Siswa')" />
                                <select name="siswa_id" id="siswa_id" required
                                    class="mt-1 p-2.5 w-full border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                    <option value="">Pilih Siswa</option>
                                    @foreach ($siswa as $s)
                                        <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('siswa_id')" />
                            </div>

                            <div>
                                <x-input-label for="jenis" :value="__('Jenis Pembayaran')" />
                                <select name="jenis" id="jenis" required onchange="updateJumlah()"
                                    class="mt-1 p-2.5 w-full border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                    <option value="">Pilih Jenis Pembayaran</option>
                                    <option value="SPP">SPP</option>
                                    <option value="Uang Muka">Uang Muka</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('jenis')" />
                            </div>

                            <div>
                                <x-input-label for="jumlah" :value="__('Jumlah Pembayaran')" />
                                <x-text-input id="jumlah" name="jumlah" step="0.01" type="decimal" class="mt-1 block w-full"
                                    readonly placeholder="{{ __('Jumlah Pembayaran') }}" required />
                                <x-input-error class="mt-2" :messages="$errors->get('jumlah')" />
                            </div>
                            <input type="hidden" name="jumlah" id="jumlah_hidden">

                            <script>
                                function updateJumlah() {
                                    var jenis = document.getElementById('jenis').value;
                                    var jumlah = document.getElementById('jumlah');
                                    var jumlahHidden = document.getElementById('jumlah_hidden');

                                    if (jenis === 'SPP') {
                                        jumlah.value = '500000.00';
                                        jumlahHidden.value = '500000.00';
                                    } else if (jenis === 'Uang Muka') {
                                        jumlah.value = '5000000.00';
                                        jumlahHidden.value = '5000000.00';
                                    } else {
                                        jumlah.value = '';
                                        jumlahHidden.value = '';
                                    }
                                }
                            </script>

                            <div>
                                <x-input-label for="bukti" :value="__('Upload Bukti Pembayaran (foto)')" />
                                <div class="mt-1 flex items-center justify-center w-full">
                                    <label for="bukti" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                                            <p class="text-xs text-gray-500">JPG, JPEG, atau PNG</p>
                                        </div>
                                        <input id="bukti" name="bukti" type="file" class="hidden" required accept="image/jpeg,image/jpg,image/png" />
                                    </label>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('bukti')" />
                            </div>
                            <div>
                                <x-text-input id="status" name="status" type="hidden" value="pending"
                                    class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Bayar') }}</x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
