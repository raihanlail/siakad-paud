<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-8">
                    <div class="mb-8 border-b pb-4">
                        <h2 class="text-2xl font-bold text-gray-900">
                            {{ __('Konfirmasi Pembayaran') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-500 italic">
                            {{ __('Pastikan data yang Anda masukkan sesuai dengan bukti transfer.') }}
                        </p>
                    </div>

                    <form method="post" action="{{ route('user.bayar.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-8" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="space-y-6">
                            <div>
                                <x-input-label for="siswa_id" :value="__('Nama Siswa')" class="font-semibold" />
                                <select name="siswa_id" id="siswa_id" required
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm transition duration-150">
                                    <option value="" disabled selected>Pilih Siswa</option>
                                    @foreach ($siswa as $s)
                                        <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('siswa_id')" />
                            </div>

                            <div>
                                <x-input-label for="jenis" :value="__('Jenis Pembayaran')" class="font-semibold" />
                                <select name="jenis" id="jenis" required onchange="updateJumlah()"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm transition duration-150">
                                    <option value="" disabled selected>Pilih Jenis</option>
                                    <option value="SPP">SPP Bulanan</option>
                                    <option value="Uang Muka">Uang Muka / Pendaftaran</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('jenis')" />
                            </div>

                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                                <x-input-label for="jumlah_display" :value="__('Total Tagihan')" class="text-blue-700 font-bold" />
                                <div class="mt-2 flex items-center">
                                    <span class="text-xl font-extrabold text-blue-900 mr-2">Rp</span>
                                    <input type="text" id="jumlah_display" readonly 
                                        class="bg-transparent border-none p-0 text-xl font-extrabold text-blue-900 focus:ring-0 w-full"
                                        placeholder="0">
                                </div>
                                <input type="hidden" name="jumlah" id="jumlah_hidden">
                                <p class="text-xs text-blue-600 mt-1">*Nominal sudah otomatis sesuai jenis pilihan.</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <x-input-label :value="__('Bukti Transfer')" class="font-semibold" />
                            
                            <div class="flex items-center justify-center w-full">
                                <label for="bukti" class="relative flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 overflow-hidden">
                                    
                                    <div id="preview-container" class="hidden absolute inset-0 z-10 bg-white">
                                        <img id="image-preview" src="#" alt="Preview" class="w-full h-full object-contain p-2">
                                        <div class="absolute bottom-2 right-2 bg-black bg-opacity-50 text-white px-2 py-1 text-xs rounded">Ganti Gambar</div>
                                    </div>

                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload bukti</span></p>
                                        <p class="text-xs text-gray-400">PNG, JPG (Max. 2MB)</p>
                                    </div>
                                    <input id="bukti" name="bukti" type="file" class="hidden" required accept="image/*" onchange="previewImage(this)" />
                                </label>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('bukti')" />
                        </div>

                        <div class="md:col-span-2 border-t pt-6 flex justify-end">
                            <input type="hidden" name="status" value="pending">
                            <x-primary-button class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700">
                                {{ __('Kirim Konfirmasi Pembayaran') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateJumlah() {
            const jenis = document.getElementById('jenis').value;
            const display = document.getElementById('jumlah_display');
            const hidden = document.getElementById('jumlah_hidden');

            let val = 0;
            if (jenis === 'SPP') val = 500000;
            else if (jenis === 'Uang Muka') val = 5000000;

            // Format to Indonesian Rupiah style
            display.value = val.toLocaleString('id-ID');
            hidden.value = val;
        }

        function previewImage(input) {
            const container = document.getElementById('preview-container');
            const preview = document.getElementById('image-preview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>