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

                    <!-- Header Actions -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Daftar Siswa</h3>
                            <p class="text-sm text-gray-500 mt-1">Pilih kelas untuk melihat siswa per kelas</p>
                        </div>
                        <div class="flex gap-3">
                            <x-secondary-button onclick="window.location.href='{{ route('admin.siswa.download') }}'">
                                ↓ {{ __('Download PDF') }}
                            </x-secondary-button>
                            <x-primary-button x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'tambahSiswaModal')">
                                + {{ __('Tambah Siswa') }}
                            </x-primary-button>
                        </div>
                    </div>

                    <!-- Kelas Tabs -->
                    <div x-data="{ activeTab: 'semua' }">

                        <!-- Tab Buttons -->
                        <div class="flex flex-wrap gap-2 mb-5 border-b border-gray-200 pb-3">
                            <button
                                @click="activeTab = 'semua'"
                                :class="activeTab === 'semua'
                                    ? 'bg-indigo-600 text-white'
                                    : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                                class="px-4 py-1.5 rounded-full text-sm font-medium transition-colors duration-150">
                                Semua
                                <span class="ml-1 text-xs opacity-75">({{ $siswa->total() }})</span>
                            </button>

                            @foreach ($kelas as $k)
                                <button
                                    @click="activeTab = '{{ $k->id }}'"
                                    :class="activeTab === '{{ $k->id }}'
                                        ? 'bg-indigo-600 text-white'
                                        : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                                    class="px-4 py-1.5 rounded-full text-sm font-medium transition-colors duration-150">
                                    {{ $k->name }}
                                    <span class="ml-1 text-xs opacity-75">({{ $k->siswa->count() }})</span>
                                </button>
                            @endforeach

                            <!-- Unassigned -->
                            @php
                                $unassigned = $siswa->getCollection()->whereNull('kelas_id');
                            @endphp
                            @if ($unassigned->count() > 0)
                                <button
                                    @click="activeTab = 'tanpa_kelas'"
                                    :class="activeTab === 'tanpa_kelas'
                                        ? 'bg-orange-500 text-white'
                                        : 'bg-orange-50 text-orange-600 hover:bg-orange-100'"
                                    class="px-4 py-1.5 rounded-full text-sm font-medium transition-colors duration-150">
                                    Tanpa Kelas
                                    <span class="ml-1 text-xs opacity-75">({{ $unassigned->count() }})</span>
                                </button>
                            @endif
                        </div>

                        <!-- Tab: Semua Siswa (paginated) -->
                        <div x-show="activeTab === 'semua'">
                            <div class="relative overflow-x-auto">
                                <table class="w-full text-sm text-left text-gray-500 shadow-sm sm:rounded-lg border border-gray-100">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3">No</th>
                                            <th class="px-6 py-3">Nama</th>
                                            <th class="px-6 py-3">NIS</th>
                                            <th class="px-6 py-3">Jenis Kelamin</th>
                                            <th class="px-6 py-3">Kelas</th>
                                            <th class="px-6 py-3">Orang Tua</th>
                                            <th class="px-6 py-3">Status Bayar</th>
                                            <th class="px-6 py-3">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($siswa as $index => $g)
                                            <tr class="bg-white border-b border-gray-100 hover:bg-gray-50">
                                                <td class="px-6 py-3 text-gray-400">{{ $siswa->firstItem() + $index }}</td>
                                                <td class="px-6 py-3 font-medium text-gray-800">{{ $g->nama }}</td>
                                                <td class="px-6 py-3">{{ $g->nis }}</td>
                                                <td class="px-6 py-3">
                                                    <span class="inline-flex items-center gap-1">
                                                        {{ $g->jenis_kelamin === 'Laki-laki' ? '♂' : '♀' }}
                                                        {{ $g->jenis_kelamin }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-3">
                                                    <span class="px-2 py-0.5 bg-indigo-50 text-indigo-700 rounded text-xs font-medium">
                                                        {{ $g->kelas->name ?? '-' }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-3">{{ $g->orangTua->name ?? '-' }}</td>
                                                <td class="px-6 py-3">
                                                    @php $status = $g->bayar->status ?? null; @endphp
                                                    <span class="px-2 py-0.5 rounded text-xs font-medium
                                                        {{ $status === 'lunas' ? 'bg-green-100 text-green-700' : ($status ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-500') }}">
                                                        {{ $status ?? 'Belum ada data' }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-3">
                                                    <div class="flex gap-2">
                                                        <x-secondary-button x-data=""
                                                            x-on:click.prevent="$dispatch('open-modal', 'editSiswaModal')"
                                                            @click="$dispatch('set-siswa-data', {
                                                                id: '{{ $g->id }}',
                                                                nama: '{{ $g->nama }}',
                                                                nis: '{{ $g->nis }}',
                                                                alamat: '{{ $g->alamat }}',
                                                                jenis_kelamin: '{{ $g->jenis_kelamin }}',
                                                                tanggal_lahir: '{{ $g->tanggal_lahir }}',
                                                                orang_tua_id: '{{ $g->orang_tua_id }}',
                                                                kelas_id: '{{ $g->kelas_id }}',
                                                            })"
                                                            class="text-xs font-medium text-indigo-600 hover:text-indigo-800">
                                                            Edit
                                                        </x-secondary-button>
                                                        <x-danger-button x-data=""
                                                            x-on:click.prevent="$dispatch('open-modal', 'deleteSiswaModal'); $dispatch('set-siswa-data', { id: '{{ $g->id }}', nama: '{{ $g->nama }}' })"
                                                            class="text-xs font-medium text-red-500 hover:text-red-700">
                                                            Hapus
                                                        </x-danger-button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="px-6 py-8 text-center text-gray-400">
                                                    Tidak ada data siswa
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="mt-4">{{ $siswa->links() }}</div>
                            </div>
                        </div>

                        <!-- Tab: Per Kelas -->
                        @foreach ($kelas as $k)
                            <div x-show="activeTab === '{{ $k->id }}'">
                                <div class="flex items-center gap-3 mb-3">
                                    <h4 class="font-semibold text-gray-700">{{ $k->name }}</h4>
                                    <span class="text-xs px-2 py-0.5 rounded-full
                                        {{ $k->siswa->count() >= $k->capacity ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                        {{ $k->siswa->count() }}/{{ $k->capacity }} siswa
                                    </span>
                                </div>

                                @if ($k->siswa->count() > 0)
                                    <div class="relative overflow-x-auto">
                                        <table class="w-full text-sm text-left text-gray-500 shadow-sm sm:rounded-lg border border-gray-100">
                                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                                <tr>
                                                    <th class="px-6 py-3">No</th>
                                                    <th class="px-6 py-3">Nama</th>
                                                    <th class="px-6 py-3">NIS</th>
                                                    <th class="px-6 py-3">Jenis Kelamin</th>
                                                    <th class="px-6 py-3">Orang Tua</th>
                                                    <th class="px-6 py-3">Status Bayar</th>
                                                    <th class="px-6 py-3">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($k->siswa as $i => $s)
                                                    <tr class="bg-white border-b border-gray-100 hover:bg-gray-50">
                                                        <td class="px-6 py-3 text-gray-400">{{ $i + 1 }}</td>
                                                        <td class="px-6 py-3 font-medium text-gray-800">{{ $s->nama }}</td>
                                                        <td class="px-6 py-3">{{ $s->nis }}</td>
                                                        <td class="px-6 py-3">
                                                            {{ $s->jenis_kelamin === 'Laki-laki' ? '♂' : '♀' }}
                                                            {{ $s->jenis_kelamin }}
                                                        </td>
                                                        <td class="px-6 py-3">{{ $s->orangTua->name ?? '-' }}</td>
                                                        <td class="px-6 py-3">
                                                            @php $status = $s->bayar->status ?? null; @endphp
                                                            <span class="px-2 py-0.5 rounded text-xs font-medium
                                                                {{ $status === 'lunas' ? 'bg-green-100 text-green-700' : ($status ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-500') }}">
                                                                {{ $status ?? 'Belum ada data' }}
                                                            </span>
                                                        </td>
                                                        <td class="px-6 py-3">
                                                            <div class="flex gap-2">
                                                                <x-secondary-button x-data=""
                                                                    x-on:click.prevent="$dispatch('open-modal', 'editSiswaModal')"
                                                                    @click="$dispatch('set-siswa-data', {
                                                                        id: '{{ $s->id }}',
                                                                        nama: '{{ $s->nama }}',
                                                                        nis: '{{ $s->nis }}',
                                                                        alamat: '{{ $s->alamat }}',
                                                                        jenis_kelamin: '{{ $s->jenis_kelamin }}',
                                                                        tanggal_lahir: '{{ $s->tanggal_lahir }}',
                                                                        orang_tua_id: '{{ $s->orang_tua_id }}',
                                                                        kelas_id: '{{ $s->kelas_id }}',
                                                                    })"
                                                                    class="text-xs font-medium text-indigo-600 hover:text-indigo-800">
                                                                    Edit
                                                                </x-secondary-button>
                                                                <x-danger-button x-data=""
                                                                    x-on:click.prevent="$dispatch('open-modal', 'deleteSiswaModal'); $dispatch('set-siswa-data', { id: '{{ $s->id }}', nama: '{{ $s->nama }}' })"
                                                                    class="text-xs font-medium text-red-500 hover:text-red-700">
                                                                    Hapus
                                                                </x-danger-button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-10 text-gray-400">
                                        <p class="text-sm">Belum ada siswa di kelas {{ $k->name }}.</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach

                        <!-- Tab: Tanpa Kelas -->
                        <div x-show="activeTab === 'tanpa_kelas'">
                            <h4 class="font-semibold text-gray-700 mb-3">Siswa Tanpa Kelas</h4>
                            <div class="relative overflow-x-auto">
                                <table class="w-full text-sm text-left text-gray-500 shadow-sm sm:rounded-lg border border-gray-100">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3">No</th>
                                            <th class="px-6 py-3">Nama</th>
                                            <th class="px-6 py-3">NIS</th>
                                            <th class="px-6 py-3">Orang Tua</th>
                                            <th class="px-6 py-3">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($unassigned as $i => $s)
                                            <tr class="bg-white border-b border-gray-100 hover:bg-gray-50">
                                                <td class="px-6 py-3 text-gray-400">{{ $i + 1 }}</td>
                                                <td class="px-6 py-3 font-medium text-gray-800">{{ $s->nama }}</td>
                                                <td class="px-6 py-3">{{ $s->nis }}</td>
                                                <td class="px-6 py-3">{{ $s->orangTua->name ?? '-' }}</td>
                                                <td class="px-6 py-3">
                                                    <div class="flex gap-2">
                                                        <button x-data=""
                                                            x-on:click.prevent="$dispatch('open-modal', 'editSiswaModal')"
                                                            @click="$dispatch('set-siswa-data', {
                                                                id: '{{ $s->id }}',
                                                                nama: '{{ $s->nama }}',
                                                                nis: '{{ $s->nis }}',
                                                                alamat: '{{ $s->alamat }}',
                                                                jenis_kelamin: '{{ $s->jenis_kelamin }}',
                                                                tanggal_lahir: '{{ $s->tanggal_lahir }}',
                                                                orang_tua_id: '{{ $s->orang_tua_id }}',
                                                                kelas_id: '{{ $s->kelas_id }}',
                                                            })"
                                                            class="text-xs font-medium text-indigo-600 hover:text-indigo-800">
                                                            Edit
                                                        </button>
                                                        <button x-data=""
                                                            x-on:click.prevent="$dispatch('open-modal', 'deleteSiswaModal'); $dispatch('set-siswa-data', { id: '{{ $s->id }}', nama: '{{ $s->nama }}' })"
                                                            class="text-xs font-medium text-red-500 hover:text-red-700">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-6 py-6 text-center text-gray-400">Semua siswa sudah memiliki kelas.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div><!-- end x-data tabs -->

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Siswa -->
    <x-modal name="tambahSiswaModal" focusable>
        <div class="relative w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow-xl">
                <div class="flex items-start justify-between p-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">Tambah Data Siswa</h3>
                    <button type="button" class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                        x-on:click="$dispatch('close')">
                        <svg class="w-3 h-3" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.siswa.store') }}" method="POST" class="w-full space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="nama" value="{{ __('Nama') }}" />
                            <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full" placeholder="Masukkan Nama" required />
                        </div>
                        <div>
                            <x-input-label for="nis" value="{{ __('NIS') }}" />
                            <x-text-input id="nis" name="nis" type="text" class="mt-1 block w-full" placeholder="Masukkan NIS" required />
                        </div>
                        <div>
                            <x-input-label for="jenis_kelamin" value="{{ __('Jenis Kelamin') }}" />
                            <select name="jenis_kelamin" id="jenis_kelamin" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="alamat" value="{{ __('Alamat') }}" />
                            <x-text-input id="alamat" name="alamat" type="text" class="mt-1 block w-full" placeholder="Masukkan Alamat" required />
                        </div>
                        <div>
                            <x-input-label for="tanggal_lahir" value="{{ __('Tanggal Lahir') }}" />
                            <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date" class="mt-1 block w-full" required />
                        </div>
                        <div>
                            <x-input-label for="orang_tua_id" value="{{ __('Orang Tua') }}" />
                            <select name="orang_tua_id" id="orang_tua_id" required
                                class="mt-1 p-2.5 w-full border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Orang Tua</option>
                                @foreach ($orangTua as $ortu)
                                    <option value="{{ $ortu->id }}">{{ $ortu->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="kelas_id" value="{{ __('Kelas') }}" />
                            <select name="kelas_id" id="kelas_id" required
                                class="mt-1 p-2.5 w-full border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Kelas</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->name }}</option>
                                @endforeach
                            </select>
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

    <!-- Modal Edit Siswa -->
    <x-modal name="editSiswaModal" focusable>
        <div class="relative w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow-xl">
                <div class="flex items-start justify-between p-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">Edit Data Siswa</h3>
                    <button type="button" class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                        x-on:click="$dispatch('close')">
                        <svg class="w-3 h-3" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
                <div class="p-6">
                    <form x-data="{ siswaData: {} }" @set-siswa-data.window="siswaData = $event.detail"
                        x-bind:action="'/admin/siswa/' + siswaData.id" method="POST" class="w-full space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <x-input-label for="edit_nama" value="{{ __('Nama') }}" />
                            <x-text-input id="edit_nama" name="nama" type="text" class="mt-1 block w-full" x-bind:value="siswaData.nama" required />
                        </div>
                        <div>
                            <x-input-label for="edit_nis" value="{{ __('NIS') }}" />
                            <x-text-input id="edit_nis" name="nis" type="text" class="mt-1 block w-full" x-bind:value="siswaData.nis" required />
                        </div>
                        <div>
                            <x-input-label for="edit_jenis_kelamin" value="{{ __('Jenis Kelamin') }}" />
                            <select name="jenis_kelamin" id="edit_jenis_kelamin" required
                                class="mt-1 p-2.5 w-full border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" x-bind:selected="siswaData.jenis_kelamin === 'Laki-laki'">Laki-laki</option>
                                <option value="Perempuan" x-bind:selected="siswaData.jenis_kelamin === 'Perempuan'">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="edit_alamat" value="{{ __('Alamat') }}" />
                            <x-text-input id="edit_alamat" name="alamat" type="text" class="mt-1 block w-full" x-bind:value="siswaData.alamat" required />
                        </div>
                        <div>
                            <x-input-label for="edit_tanggal_lahir" value="{{ __('Tanggal Lahir') }}" />
                            <x-text-input id="edit_tanggal_lahir" name="tanggal_lahir" type="date" class="mt-1 block w-full" x-bind:value="siswaData.tanggal_lahir" required />
                        </div>
                        <div>
                            <x-input-label for="edit_orang_tua_id" value="{{ __('Orang Tua') }}" />
                            <select name="orang_tua_id" id="edit_orang_tua_id" required
                                class="mt-1 p-2.5 w-full border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Orang Tua</option>
                                @foreach ($orangTua as $ortu)
                                    <option value="{{ $ortu->id }}" x-bind:selected="siswaData.orang_tua_id == '{{ $ortu->id }}'">
                                        {{ $ortu->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="edit_kelas_id" value="{{ __('Kelas') }}" />
                            <select name="kelas_id" id="edit_kelas_id" required
                                class="mt-1 p-2.5 w-full border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Kelas</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}" x-bind:selected="siswaData.kelas_id == '{{ $k->id }}'">
                                        {{ $k->name }}
                                    </option>
                                @endforeach
                            </select>
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

    <!-- Modal Delete -->
    <x-modal name="deleteSiswaModal" focusable>
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-xl">
                <div class="flex items-start justify-between p-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">Konfirmasi Hapus</h3>
                </div>
                <div class="p-4">
                    <form x-data="{ siswaData: {} }" @set-siswa-data.window="siswaData = $event.detail"
                        x-bind:action="'/admin/siswa/' + siswaData.id" method="POST" class="space-y-4">
                        @csrf
                        @method('DELETE')
                        <p class="text-gray-600">Yakin menghapus siswa <span x-text="siswaData.nama" class="font-semibold"></span>?</p>
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
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
            {{ session('error') }}
        </div>
    @endif

</x-app-layout>