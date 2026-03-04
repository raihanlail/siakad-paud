<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Siswa') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ── Stats Bar ───────────────────────────────────────────────── --}}
            @php
                $collection   = $siswa->getCollection();
                $lakiCount    = $collection->where('jenis_kelamin', 'Laki-laki')->count();
                $perempuanCount = $collection->where('jenis_kelamin', 'Perempuan')->count();
                $lunasCount   = $collection->filter(fn($s) => optional($s->bayar)->status === 'Lunas')->count();
                $belumCount   = $collection->filter(fn($s) => optional($s->bayar)->status !== 'Lunas')->count();
            @endphp

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Total Siswa</p>
                        <p class="text-2xl font-black text-gray-800">{{ $siswa->total() }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Laki-laki</p>
                        <p class="text-2xl font-black text-blue-600">{{ $lakiCount }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-pink-100 text-pink-500 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Perempuan</p>
                        <p class="text-2xl font-black text-pink-500">{{ $perempuanCount }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Lunas</p>
                        <p class="text-2xl font-black text-emerald-600">{{ $lunasCount }}</p>
                    </div>
                </div>
            </div>

            {{-- ── Main Card ───────────────────────────────────────────────── --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden"
                 x-data="{ activeTab: 'semua' }">

                {{-- Card Header --}}
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/40 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="font-bold text-gray-800 text-sm">Daftar Siswa</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Pilih tab kelas untuk menyaring data</p>
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

                {{-- Kelas Tabs --}}
                <div class="px-6 pt-3 flex flex-wrap gap-1 border-b border-gray-100">
                    <button @click="activeTab = 'semua'"
                        :class="activeTab === 'semua' ? 'border-b-2 border-indigo-600 text-indigo-600 font-bold' : 'text-gray-400 hover:text-gray-600'"
                        class="pb-2 px-3 text-xs uppercase tracking-widest font-medium transition-colors">
                        Semua <span class="ml-1 opacity-60">({{ $siswa->total() }})</span>
                    </button>
                    @foreach ($kelas as $k)
                        <button @click="activeTab = '{{ $k->id }}'"
                            :class="activeTab === '{{ $k->id }}' ? 'border-b-2 border-indigo-600 text-indigo-600 font-bold' : 'text-gray-400 hover:text-gray-600'"
                            class="pb-2 px-3 text-xs uppercase tracking-widest font-medium transition-colors">
                            {{ $k->name }} <span class="ml-1 opacity-60">({{ $k->siswa->count() }})</span>
                        </button>
                    @endforeach
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-3 font-black tracking-widest">No</th>
                                <th class="px-6 py-3 font-black tracking-widest">Siswa</th>
                                <th class="px-6 py-3 font-black tracking-widest">Kelas</th>
                                <th class="px-6 py-3 font-black tracking-widest">Kelamin</th>
                                <th class="px-6 py-3 font-black tracking-widest">Tgl Lahir</th>
                                <th class="px-6 py-3 font-black tracking-widest">Orang Tua</th>
                                <th class="px-6 py-3 font-black tracking-widest text-center">Bayar</th>
                                <th class="px-6 py-3 font-black tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse ($siswa as $index => $g)
                                @php
                                    $bayarStatus = optional($g->bayar)->status;
                                    $isLunas     = $bayarStatus === 'Lunas';
                                    $isLaki      = $g->jenis_kelamin === 'Laki-laki';
                                @endphp
                                <tr class="hover:bg-indigo-50/30 transition-colors"
                                    x-show="activeTab === 'semua' || activeTab === '{{ $g->kelas_id ?? '' }}'">

                                    <td class="px-6 py-4 text-gray-400 font-mono text-xs">
                                        {{ sprintf('%02d', $siswa->firstItem() + $index) }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0
                                                {{ $isLaki ? 'bg-blue-100 text-blue-600' : 'bg-pink-100 text-pink-500' }}">
                                                {{ strtoupper(substr($g->nama, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800 leading-tight">{{ $g->nama }}</p>
                                                <p class="text-[11px] text-gray-400 font-mono">{{ $g->nis }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 rounded-lg text-xs font-semibold">
                                            {{ $g->kelas->name ?? '—' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1 text-xs font-medium
                                            {{ $isLaki ? 'text-blue-600' : 'text-pink-500' }}">
                                            {{ $isLaki ? '♂' : '♀' }} {{ $g->jenis_kelamin }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-gray-600 text-xs">
                                        {{ \Carbon\Carbon::parse($g->tanggal_lahir)->format('d M Y') }}
                                        <p class="text-gray-400 text-[10px]">
                                            {{ \Carbon\Carbon::parse($g->tanggal_lahir)->age }} tahun
                                        </p>
                                    </td>

                                    <td class="px-6 py-4">
                                        <p class="text-sm text-gray-700 font-medium">{{ $g->orangTua->name ?? '—' }}</p>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold border
                                            @if($isLunas)
                                                bg-emerald-50 text-emerald-700 border-emerald-100
                                            @elseif($bayarStatus)
                                                bg-yellow-50 text-yellow-700 border-yellow-100
                                            @else
                                                bg-gray-100 text-gray-400 border-gray-200
                                            @endif">
                                            {{ $bayarStatus ?? 'Belum ada data' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <button x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'editSiswaModal')"
                                                @click="$dispatch('set-siswa-data', {
                                                    id: '{{ $g->id }}',
                                                    nama: '{{ $g->nama }}',
                                                    nis: '{{ $g->nis }}',
                                                    alamat: '{{ addslashes($g->alamat) }}',
                                                    jenis_kelamin: '{{ $g->jenis_kelamin }}',
                                                    tanggal_lahir: '{{ $g->tanggal_lahir }}',
                                                    orang_tua_id: '{{ $g->orang_tua_id }}',
                                                    kelas_id: '{{ $g->kelas_id }}',
                                                })"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold bg-white border border-gray-200 text-gray-600 hover:border-indigo-300 hover:text-indigo-600 hover:bg-indigo-50 transition-all shadow-sm">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Edit
                                            </button>
                                            <button x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'deleteSiswaModal'); $dispatch('set-siswa-data', { id: '{{ $g->id }}', nama: '{{ $g->nama }}' })"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold bg-white border border-gray-200 text-gray-600 hover:border-rose-300 hover:text-rose-600 hover:bg-rose-50 transition-all shadow-sm">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <div class="w-14 h-14 bg-gray-50 rounded-2xl flex items-center justify-center">
                                                <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                            </div>
                                            <p class="text-sm text-gray-400 font-medium">Tidak ada data siswa</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $siswa->links() }}
                </div>

            </div>
        </div>
    </div>

    {{-- ── Modal Tambah Siswa ───────────────────────────────────────────── --}}
    <x-modal name="tambahSiswaModal" focusable>
        <div class="relative w-full max-w-2xl">
            <div class="relative bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-blue-500 px-6 py-5">
                    <h3 class="text-lg font-bold text-white">Tambah Data Siswa</h3>
                    <p class="text-indigo-100 text-xs mt-0.5">Lengkapi semua data berikut</p>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.siswa.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="nama" value="{{ __('Nama Lengkap') }}" />
                                <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full" placeholder="Nama siswa" required />
                            </div>
                            <div>
                                <x-input-label for="nis" value="{{ __('NIS') }}" />
                                <x-text-input id="nis" name="nis" type="text" class="mt-1 block w-full" placeholder="Nomor Induk Siswa" required />
                            </div>
                            <div>
                                <x-input-label for="jenis_kelamin" value="{{ __('Jenis Kelamin') }}" />
                                <select name="jenis_kelamin" id="jenis_kelamin" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="tanggal_lahir" value="{{ __('Tanggal Lahir') }}" />
                                <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date" class="mt-1 block w-full" required />
                            </div>
                            <div class="sm:col-span-2">
                                <x-input-label for="alamat" value="{{ __('Alamat') }}" />
                                <x-text-input id="alamat" name="alamat" type="text" class="mt-1 block w-full" placeholder="Alamat lengkap" required />
                            </div>
                            <div>
                                <x-input-label for="orang_tua_id" value="{{ __('Orang Tua / Wali') }}" />
                                <select name="orang_tua_id" id="orang_tua_id" required class="mt-1 p-2.5 w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                    <option value="">Pilih Orang Tua</option>
                                    @foreach ($orangTua as $ortu)
                                        <option value="{{ $ortu->id }}">{{ $ortu->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="kelas_id" value="{{ __('Kelas') }}" />
                                <select name="kelas_id" id="kelas_id" required class="mt-1 p-2.5 w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k->id }}">{{ $k->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">
                            <x-secondary-button type="button" x-on:click="$dispatch('close')">Batal</x-secondary-button>
                            <x-primary-button>Simpan</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-modal>

    {{-- ── Modal Edit Siswa ─────────────────────────────────────────────── --}}
    <x-modal name="editSiswaModal" focusable>
        <div class="relative w-full max-w-2xl">
            <div class="relative bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-slate-700 to-slate-600 px-6 py-5">
                    <h3 class="text-lg font-bold text-white">Edit Data Siswa</h3>
                    <p class="text-slate-300 text-xs mt-0.5">Perbarui informasi siswa</p>
                </div>
                <div class="p-6">
                    <form x-data="{ siswaData: {} }" @set-siswa-data.window="siswaData = $event.detail"
                        x-bind:action="'/admin/siswa/' + siswaData.id" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="edit_nama" value="{{ __('Nama Lengkap') }}" />
                                <x-text-input id="edit_nama" name="nama" type="text" class="mt-1 block w-full" x-bind:value="siswaData.nama" required />
                            </div>
                            <div>
                                <x-input-label for="edit_nis" value="{{ __('NIS') }}" />
                                <x-text-input id="edit_nis" name="nis" type="text" class="mt-1 block w-full" x-bind:value="siswaData.nis" required />
                            </div>
                            <div>
                                <x-input-label for="edit_jenis_kelamin" value="{{ __('Jenis Kelamin') }}" />
                                <select name="jenis_kelamin" id="edit_jenis_kelamin" required class="mt-1 p-2.5 w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 text-sm">
                                    <option value="Laki-laki" x-bind:selected="siswaData.jenis_kelamin === 'Laki-laki'">Laki-laki</option>
                                    <option value="Perempuan" x-bind:selected="siswaData.jenis_kelamin === 'Perempuan'">Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="edit_tanggal_lahir" value="{{ __('Tanggal Lahir') }}" />
                                <x-text-input id="edit_tanggal_lahir" name="tanggal_lahir" type="date" class="mt-1 block w-full" x-bind:value="siswaData.tanggal_lahir" required />
                            </div>
                            <div class="sm:col-span-2">
                                <x-input-label for="edit_alamat" value="{{ __('Alamat') }}" />
                                <x-text-input id="edit_alamat" name="alamat" type="text" class="mt-1 block w-full" x-bind:value="siswaData.alamat" required />
                            </div>
                            <div>
                                <x-input-label for="edit_orang_tua_id" value="{{ __('Orang Tua / Wali') }}" />
                                <select name="orang_tua_id" id="edit_orang_tua_id" required class="mt-1 p-2.5 w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 text-sm">
                                    <option value="">Pilih Orang Tua</option>
                                    @foreach ($orangTua as $ortu)
                                        <option value="{{ $ortu->id }}" x-bind:selected="siswaData.orang_tua_id == '{{ $ortu->id }}'">{{ $ortu->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="edit_kelas_id" value="{{ __('Kelas') }}" />
                                <select name="kelas_id" id="edit_kelas_id" required class="mt-1 p-2.5 w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 text-sm">
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k->id }}" x-bind:selected="siswaData.kelas_id == '{{ $k->id }}'">{{ $k->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">
                            <x-secondary-button type="button" x-on:click="$dispatch('close')">Batal</x-secondary-button>
                            <x-primary-button>Simpan</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-modal>

    {{-- ── Modal Hapus ─────────────────────────────────────────────────── --}}
    <x-modal name="deleteSiswaModal" focusable>
        <div class="relative w-full max-w-md">
            <div class="relative bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-rose-600 to-rose-500 px-6 py-5">
                    <h3 class="text-lg font-bold text-white">Hapus Data Siswa</h3>
                    <p class="text-rose-100 text-xs mt-0.5">Tindakan ini tidak dapat dibatalkan</p>
                </div>
                <div class="p-6">
                    <form x-data="{ siswaData: {} }" @set-siswa-data.window="siswaData = $event.detail"
                        x-bind:action="'/admin/siswa/' + siswaData.id" method="POST" class="space-y-4">
                        @csrf
                        @method('DELETE')
                        <div class="flex items-center gap-3 p-4 bg-rose-50 rounded-xl border border-rose-100">
                            <svg class="w-5 h-5 text-rose-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <p class="text-sm text-rose-700">Yakin ingin menghapus siswa <strong x-text="siswaData.nama"></strong>? Data yang dihapus tidak dapat dipulihkan.</p>
                        </div>
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
        <div class="fixed bottom-4 right-4 bg-emerald-500 text-white px-6 py-3 rounded-xl shadow-lg z-50"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="fixed bottom-4 right-4 bg-rose-500 text-white px-6 py-3 rounded-xl shadow-lg z-50"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
            {{ session('error') }}
        </div>
    @endif

</x-app-layout>