<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Guru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-primary-button
                        x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'tambahGuruModal')">
                        {{ __('Tambah Guru') }}
                    </x-primary-button>

                    <div class="relative overflow-x-auto pt-4">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 shadow-md sm:rounded-lg">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No</th>
                                    <th scope="col" class="px-6 py-3">Nama</th>
                                    <th scope="col" class="px-6 py-3">NIP</th>
                                    <th scope="col" class="px-6 py-3">Mata Pelajaran</th>
                                    <th scope="col" class="px-6 py-3">Nomor Telepon</th>
                                    <th scope="col" class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($gurus as $index => $g)
                                    <tr class="bg-white border-b border-gray-200">
                                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4">{{ $g->nama }}</td>
                                        <td class="px-6 py-4">{{ $g->nip }}</td>
                                        <td class="px-6 py-4">{{ $g->mapel->nama ?? '-' }}</td>
                                        <td class="px-6 py-4">{{ $g->no_telp }}</td>
                                        <td class="px-6 py-4 flex flex-row gap-4">
                                            <x-secondary-button
                                                x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'editGuruModal')"
                                                @click="
                                                    $dispatch('set-guru-data', {
                                                        id: '{{ $g->id }}',
                                                        nama: '{{ $g->nama }}',
                                                        nip: '{{ $g->nip }}',
                                                        alamat: '{{ $g->alamat }}',
                                                        no_telp: '{{ $g->no_telp }}',
                                                        mata_pelajaran_id: '{{ $g->mata_pelajaran_id }}'
                                                    })
                                                "
                                                class="text-blue-600 hover:text-blue-900"
                                            >{{ __('Edit') }}</x-secondary-button>
                                            <x-danger-button x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'deleteGuruModal'); $dispatch('set-guru-data', {
                                                    id: '{{ $g->id }}',
                                                    nama: '{{ $g->nama }}'
                                                })">
                                                {{ __('Delete') }}
                                            </x-danger-button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b border-gray-200">
                                        <td colspan="6" class="px-6 py-4 text-center">Tidak ada data guru</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Modal Tambah Guru ────────────────────────────────────────────── --}}
    <x-modal name="tambahGuruModal" tabindex="-1" aria-hidden="true">
        <div class="relative w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <div class="flex items-start justify-between p-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">Tambah Data Guru</h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                        x-on:click="$dispatch('close')">
                        <svg class="w-3 h-3" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.guru.store') }}" method="POST" class="w-full space-y-4">
                        @csrf

                        <div>
                            <x-input-label for="nama" value="{{ __('Nama') }}" />
                            <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full"
                                placeholder="Masukkan Nama" required />
                        </div>

                        <div>
                            <x-input-label for="nip" value="{{ __('NIP') }}" />
                            <x-text-input id="nip" name="nip" type="text" class="mt-1 block w-full"
                                placeholder="Masukkan NIP" required />
                        </div>

                        <div>
                            <x-input-label for="no_telp" value="{{ __('Nomor Telepon') }}" />
                            <x-text-input id="no_telp" name="no_telp" type="text" class="mt-1 block w-full"
                                placeholder="Masukkan Nomor Telepon" required />
                        </div>

                        <div>
                            <x-input-label for="alamat" value="{{ __('Alamat') }}" />
                            <x-text-input id="alamat" name="alamat" type="text" class="mt-1 block w-full"
                                placeholder="Masukkan Alamat" required />
                        </div>

                        <div>
                            <x-input-label for="mata_pelajaran_id" value="{{ __('Mata Pelajaran') }}" />
                            <select name="mata_pelajaran_id" id="mata_pelajaran_id" required
                                class="mt-1 p-2.5 w-full border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                <option value="">Pilih Mata Pelajaran</option>
                                @foreach ($mapel as $m)
                                    <option value="{{ $m->id }}">{{ $m->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Login credentials section --}}
                        <div class="pt-2 border-t border-gray-100">
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">
                                Akun Login Guru
                            </p>

                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="email" value="{{ __('Email') }}" />
                                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                        placeholder="email@sekolah.com" required />
                                    <p class="text-xs text-gray-400 mt-1">Guru akan login menggunakan email ini.</p>
                                </div>

                                <div>
                                    <x-input-label for="password" value="{{ __('Password') }}" />
                                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"
                                        placeholder="Minimal 6 karakter" required />
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end pt-4 border-t gap-2">
                            <x-secondary-button type="button" x-on:click="$dispatch('close')">Batal</x-secondary-button>
                            <x-primary-button>Simpan</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-modal>

    {{-- ── Modal Edit Guru ──────────────────────────────────────────────── --}}
    <x-modal name="editGuruModal" focusable>
        <div class="relative w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow-xl">
                <div class="flex items-start justify-between p-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">Edit Data Guru</h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                        x-on:click="$dispatch('close')">
                        <svg class="w-3 h-3" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
                <div class="p-6">
                    <form x-data="{ guruData: {} }"
                          @set-guru-data.window="guruData = $event.detail"
                          x-bind:action="'/admin/guru/' + guruData.id"
                          method="POST"
                          class="w-full space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="edit_nama" value="{{ __('Nama') }}" />
                            <x-text-input id="edit_nama" name="nama" type="text" class="mt-1 block w-full"
                                x-bind:value="guruData.nama" required />
                        </div>

                        <div>
                            <x-input-label for="edit_nip" value="{{ __('NIP') }}" />
                            <x-text-input id="edit_nip" name="nip" type="text" class="mt-1 block w-full"
                                x-bind:value="guruData.nip" required />
                        </div>

                        <div>
                            <x-input-label for="edit_no_telp" value="{{ __('Nomor Telepon') }}" />
                            <x-text-input id="edit_no_telp" name="no_telp" type="text" class="mt-1 block w-full"
                                x-bind:value="guruData.no_telp" required />
                        </div>

                        <div>
                            <x-input-label for="edit_alamat" value="{{ __('Alamat') }}" />
                            <x-text-input id="edit_alamat" name="alamat" type="text" class="mt-1 block w-full"
                                x-bind:value="guruData.alamat" required />
                        </div>

                        <div>
                            <x-input-label for="edit_mata_pelajaran_id" value="{{ __('Mata Pelajaran') }}" />
                            <select name="mata_pelajaran_id" id="edit_mata_pelajaran_id" required
                                class="mt-1 p-2.5 w-full border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                <option value="">Pilih Mata Pelajaran</option>
                                @foreach ($mapel as $m)
                                    <option value="{{ $m->id }}"
                                        x-bind:selected="guruData.mata_pelajaran_id == '{{ $m->id }}'">
                                        {{ $m->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Optional password reset section --}}
                        <div class="pt-2 border-t border-gray-100">
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">
                                Ganti Password
                            </p>
                            <p class="text-xs text-gray-400 mb-3">Kosongkan jika tidak ingin mengubah password.</p>
                            <div>
                                <x-input-label for="edit_password" value="{{ __('Password Baru') }}" />
                                <x-text-input id="edit_password" name="password" type="password" class="mt-1 block w-full"
                                    placeholder="Minimal 6 karakter (opsional)" />
                            </div>
                        </div>

                        <div class="flex justify-end pt-4 border-t gap-2">
                            <x-secondary-button type="button" x-on:click="$dispatch('close')">Batal</x-secondary-button>
                            <x-primary-button>Simpan</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-modal>

    {{-- ── Modal Hapus Guru ─────────────────────────────────────────────── --}}
    <x-modal name="deleteGuruModal" focusable>
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-xl">
                <div class="flex items-start justify-between p-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">Konfirmasi Hapus</h3>
                </div>
                <div class="p-4">
                    <form x-data="{ guruData: {} }" @set-guru-data.window="guruData = $event.detail"
                        x-bind:action="'/admin/guru/' + guruData.id" method="POST" class="space-y-4">
                        @csrf
                        @method('DELETE')
                        <p class="text-gray-600">
                            Yakin menghapus guru <span x-text="guruData.nama" class="font-semibold"></span>?
                            <span class="block text-xs text-red-500 mt-1">Akun login guru ini juga akan dihapus.</span>
                        </p>
                        <div class="flex justify-end gap-2">
                            <x-secondary-button type="button" x-on:click="$dispatch('close')">Batal</x-secondary-button>
                            <x-danger-button>Hapus</x-danger-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-modal>

    @if (session('success'))
        <div class="fixed top-12  bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
            {{ session('success') }}
        </div>
    @endif

</x-app-layout>