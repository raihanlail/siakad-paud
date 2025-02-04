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
                                <x-text-input id="bukti" name="bukti" type="file" class="mt-1 block w-full"
                                    placeholder="{{ __('upload bukti') }}" required
                                    accept="image/jpeg,image/jpg,image/png" />
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
