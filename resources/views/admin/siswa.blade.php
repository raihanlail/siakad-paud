<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Tombol Tambah Siswa -->
                    <div class="flex flex-row gap-6">

                        <x-primary-button x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'tambahSiswaModal')">
                            {{ __('Tambah Siswa') }}
                        </x-primary-button>
    
                        <x-secondary-button onclick="window.location.href='{{route('admin.siswa.download')}}'">
                            {{ __('Download Data Siswa') }}
                        </x-secondary-button>
                    </div>

                    <!-- Tabel Data Siswa -->
                    <div class="relative overflow-x-auto pt-4">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 shadow-md sm:rounded-lg">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No</th>
                                    <th scope="col" class="px-6 py-3">Nama</th>
                                    <th scope="col" class="px-6 py-3">NIS</th>
                                    <th scope="col" class="px-6 py-3">Jenis Kelamin</th>
                                    <th scope="col" class="px-6 py-3">Alamat</th>
                                    <th scope="col" class="px-6 py-3">Orang Tua</th>
                                    <th scope="col" class="px-6 py-3">Status Pembayaran</th>
                                    <th scope="col" class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($siswa as $index => $g)
                                    <tr class="bg-white border-b border-gray-200">
                                        <td class="px-6 py-4">{{ $index + 1}}</td>
                                        <td class="px-6 py-4">{{ $g->nama }}</td>
                                        <td class="px-6 py-4">{{ $g->nis }}</td>
                                        <td class="px-6 py-4">{{ $g->jenis_kelamin }}</td>
                                        <td class="px-6 py-4">{{ $g->alamat }}</td>
                                        <td class="px-6 py-4">{{ $g->orangTua->name ?? '-' }}</td>
                                        <td class="px-6 py-4">{{ $g->bayar->status ?? 'belum ada data' }}</td>
                                        <td class="px-6 py-4 flex flex-row gap-4 ">
                                            <x-secondary-button x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'editSiswaModal')"
                                                @click="
                                                    $dispatch('set-siswa-data', {
                                                        id: '{{ $g->id }}',
                                                        nama: '{{ $g->nama }}',
                                                        nis: '{{ $g->nis }}',
                                                        alamat: '{{ $g->alamat }}',
                                                        jenis_kelamin: '{{ $g->jenis_kelamin }}',
                                                        tanggal_lahir: '{{ $g->tanggal_lahir }}',
                                                        orang_tua_id: '{{ $g->orang_tua_id }}'
                                                    })
                                                "
                                                class="text-blue-600 hover:text-blue-900">{{ __('Edit') }}</x-secondary-button>
                                            <x-danger-button x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'deleteSiswaModal'); $dispatch('set-siswa-data', {
        id: '{{ $g->id }}',
        nama: '{{ $g->nama }}'
    })">
                                                {{ __('Delete') }}
                                            </x-danger-button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b border-gray-200">
                                        <td colspan="6" class="px-6 py-4 text-center">Tidak ada data siswa</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $siswa->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Siswa -->
    <x-modal name="tambahSiswaModal" focusable>
        <div class="relative w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow-xl">
                <!-- Modal Header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Tambah Data Siswa
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                        x-on:click="$dispatch('close')">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <form action="{{ route('admin.siswa.store') }}" method="POST" class="w-full space-y-4">
                        @csrf
                        <!-- Input Nama -->
                        <div>
                            <x-input-label for="nama" value="{{ __('Nama') }}" />
                            <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full"
                                placeholder="{{ __('Masukkan Nama') }}" required />
                        </div>

                        <!-- Input NIS -->
                        <div>
                            <x-input-label for="nis" value="{{ __('NIS') }}" />
                            <x-text-input id="nis" name="nis" type="text" class="mt-1 block w-full"
                                placeholder="{{ __('Masukkan NIS') }}" required />
                        </div>
                        <!-- Input Jenis Kelamin -->
                        <div>
                            <x-input-label for="jenis_kelamin" value="{{ __('Jenis Kelamin') }}" />
                            <select name="jenis_kelamin" id="jenis_kelamin"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div>
                            <x-input-label for="alamat" value="{{ __('Alamat') }}" />
                            <x-text-input id="alamat" name="alamat" type="text" class="mt-1 block w-full"
                                placeholder="{{ __('Masukkan Alamat') }}" required />
                        </div>

                        <div>
                            <x-input-label for="tanggal_lahir" value="{{ __('TTL') }}" />
                            <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date"
                                class="mt-1 block w-full" required />
                        </div>

                        <!-- Input Orang Tua -->
                        <div>
                            <x-input-label for="orang_tua_id" value="{{ __('Orang Tua') }}" />
                            <select name="orang_tua_id" id="orang_tua_id" required
                                class="mt-1 p-2.5 w-full border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                <option value="">Pilih Orang Tua</option>
                                @foreach ($orangTua as $ortu)
                                    <option value="{{ $ortu->id }}">{{ $ortu->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="flex justify-end pt-4 border-t gap-2">
                            <x-secondary-button type="button"
                                x-on:click="$dispatch('close')">{{ __('Batal') }}</x-secondary-button>
                            <x-primary-button>
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-modal>

    <!-- Modal Edit -->
    <x-modal name="editSiswaModal" focusable>
        <div class="relative w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow-xl">
                <!-- Modal Header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Edit Data Siswa
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                        x-on:click="$dispatch('close')">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <form x-data="{ siswaData: {} }" @set-siswa-data.window="siswaData = $event.detail"
                        x-bind:action="'/admin/siswa/' + siswaData.id" method="POST" class="w-full space-y-4">
                        @csrf
                        @method('PUT')
                        <!-- Input Nama -->
                        <div>
                            <x-input-label for="edit_nama" value="{{ __('Nama') }}" />
                            <x-text-input id="edit_nama" name="nama" type="text" class="mt-1 block w-full"
                                x-bind:value="siswaData.nama" required />
                        </div>

                        <!-- Input NIS -->
                        <div>
                            <x-input-label for="edit_nis" value="{{ __('NIS') }}" />
                            <x-text-input id="edit_nis" name="nis" type="text" class="mt-1 block w-full"
                                x-bind:value="siswaData.nis" required />
                        </div>
                        <div>
                            <x-input-label for="edit_jenis_kelamin" value="{{ __('Jenis Kelamin') }}" />
                            <select name="jenis_kelamin" id="edit_jenis_kelamin" required
                            class="mt-1 p-2.5 w-full border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" x-bind:selected="siswaData.jenis_kelamin === 'Laki-laki'">
                                Laki-laki</option>
                            <option value="Perempuan" x-bind:selected="siswaData.jenis_kelamin === 'Perempuan'">
                                Perempuan</option>
                                
                            </select>

                        </div>

                        <div>
                            <x-input-label for="edit_alamat" value="{{ __('Alamat') }}" />
                            <x-text-input id="edit_alamat" name="alamat" type="text" class="mt-1 block w-full"
                                x-bind:value="siswaData.alamat" required />
                        </div>

                        <div>
                            <x-input-label for="edit_tanggal_lahir" value="{{ __('TTL') }}" />
                            <x-text-input id="edit_tanggal_lahir" name="tanggal_lahir" type="date"
                                class="mt-1 block w-full" x-bind:value="siswaData.tanggal_lahir" required />
                        </div>

                        <!-- Input Orang Tua -->
                        <div>
                            <x-input-label for="edit_orang_tua_id" value="{{ __('Orang Tua') }}" />
                            <select name="orang_tua_id" id="edit_orang_tua_id" required
                                class="mt-1 p-2.5 w-full border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                x-bind:value="siswaData.orang_tua_id">
                                <option value="">Pilih Orang Tua</option>
                                @foreach ($orangTua as $ortu)
                                    <option value="{{ $ortu->id }}">{{ $ortu->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="flex justify-end pt-4 border-t gap-2">
                            <x-secondary-button type="button"
                                x-on:click="$dispatch('close')">{{ __('Batal') }}</x-secondary-button>
                            <x-primary-button>
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-modal>

    <!-- Modal Delete -->
    <x-modal name="deleteSiswaModal" focusable>
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-xl">
                <!-- Modal Header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Konfirmasi Hapus
                    </h3>
                </div>
                <div class="p-4">
                    <form x-data="{ siswaData: {} }" @set-siswa-data.window="siswaData = $event.detail"
                        x-bind:action="'/admin/siswa/' + siswaData.id" method="POST" class="space-y-4">
                        @csrf
                        @method('DELETE')
                        <p class="text-gray-600">Yakin menghapus siswa <span x-text="siswaData.nama"
                                class="font-semibold"></span>?</p>
                        <div class="flex justify-end gap-2">
                            <x-secondary-button type="button" x-on:click="$dispatch('close')">
                                {{ __('Batal') }}
                            </x-secondary-button>
                            <x-danger-button>
                                {{ __('Hapus') }}
                            </x-danger-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-modal>
</x-app-layout>
