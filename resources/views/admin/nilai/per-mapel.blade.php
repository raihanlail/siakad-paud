<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Nilai') }} &mdash; {{ $mataPelajaran->nama }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ── Hero Info Card ──────────────────────────────────────────── --}}
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-700 via-indigo-600 to-blue-500 shadow-xl shadow-indigo-200 px-8 py-7">
                {{-- decorative blobs --}}
                <div class="absolute -top-8 -right-8 w-40 h-40 rounded-full bg-white/5"></div>
                <div class="absolute bottom-0 left-1/2 w-64 h-24 rounded-full bg-white/5 blur-2xl"></div>

                <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-6">

                    {{-- Left: subject + guru --}}
                    <div>
                        <p class="text-indigo-200 text-xs font-bold uppercase tracking-widest mb-1">Mata Pelajaran</p>
                        <h2 class="text-white text-2xl font-extrabold tracking-tight leading-tight">
                            {{ $mataPelajaran->nama }}
                        </h2>
                        <div class="mt-3 flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                {{ strtoupper(substr($guru->nama ?? 'G', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-white font-semibold text-sm leading-tight">{{ $guru->nama ?? 'Guru Tidak Ditemukan' }}</p>
                                <p class="text-indigo-200 text-xs">Pengampu Mata Pelajaran</p>
                            </div>
                        </div>
                    </div>

                    {{-- Right: stats --}}
                    <div class="flex gap-4 sm:gap-6 flex-wrap">
                        @php
                            $total     = count($nilai);
                            $tuntas    = $nilai->where('nilai', '>=', 75)->count();
                            $remedial  = $total - $tuntas;
                            $rata      = $total > 0 ? round($nilai->avg('nilai'), 1) : '-';
                        @endphp
                        <div class="bg-white/15 backdrop-blur-sm rounded-xl px-5 py-3 text-center min-w-[72px]">
                            <p class="text-white text-2xl font-black">{{ $total }}</p>
                            <p class="text-indigo-100 text-[10px] uppercase font-bold tracking-wider mt-0.5">Siswa</p>
                        </div>
                        <div class="bg-white/15 backdrop-blur-sm rounded-xl px-5 py-3 text-center min-w-[72px]">
                            <p class="text-emerald-300 text-2xl font-black">{{ $tuntas }}</p>
                            <p class="text-indigo-100 text-[10px] uppercase font-bold tracking-wider mt-0.5">Tuntas</p>
                        </div>
                        <div class="bg-white/15 backdrop-blur-sm rounded-xl px-5 py-3 text-center min-w-[72px]">
                            <p class="text-rose-300 text-2xl font-black">{{ $remedial }}</p>
                            <p class="text-indigo-100 text-[10px] uppercase font-bold tracking-wider mt-0.5">Remedial</p>
                        </div>
                        <div class="bg-white/15 backdrop-blur-sm rounded-xl px-5 py-3 text-center min-w-[72px]">
                            <p class="text-yellow-300 text-2xl font-black">{{ $rata }}</p>
                            <p class="text-indigo-100 text-[10px] uppercase font-bold tracking-wider mt-0.5">Rata-rata</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Main Card ───────────────────────────────────────────────── --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                <div class="p-6">

                    {{-- Actions --}}
                    <div class="flex flex-wrap items-center gap-3 mb-6">
                        <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'tambahNilaiModal')">
                            + {{ __('Tambah Nilai') }}
                        </x-primary-button>
                        <x-secondary-button onclick="window.location.href='{{ route('admin.nilai.download', $mataPelajaran->id) }}'">
                            ↓ {{ __('Download PDF') }}
                        </x-secondary-button>
                        <a href="{{ route('admin.mapel') }}">
                            <x-secondary-button>← {{ __('Kembali') }}</x-secondary-button>
                        </a>
                    </div>

                    {{-- Tabs + Table --}}
                    <div x-data="{ activeTab: 'semua' }">

                        {{-- Tab Buttons --}}
                        <div class="flex flex-wrap gap-1 border-b border-gray-200 mb-4">
                            <button
                                @click="activeTab = 'semua'"
                                :class="activeTab === 'semua'
                                    ? 'border-b-2 border-indigo-600 text-indigo-600 font-bold'
                                    : 'text-gray-400 hover:text-gray-600'"
                                class="pb-2 px-3 text-xs uppercase tracking-widest font-medium transition-colors">
                                Semua
                                <span class="ml-1 opacity-60">({{ count($nilai) }})</span>
                            </button>

                            @foreach ($kelas as $k)
                                @php
                                    $count = $nilai->filter(fn($n) => $n->siswa && $n->siswa->kelas_id == $k->id)->count();
                                @endphp
                                <button
                                    @click="activeTab = '{{ $k->id }}'"
                                    :class="activeTab === '{{ $k->id }}'
                                        ? 'border-b-2 border-indigo-600 text-indigo-600 font-bold'
                                        : 'text-gray-400 hover:text-gray-600'"
                                    class="pb-2 px-3 text-xs uppercase tracking-widest font-medium transition-colors">
                                    {{ $k->name }}
                                    <span class="ml-1 opacity-60">({{ $count }})</span>
                                </button>
                            @endforeach
                        </div>

                        {{-- Table --}}
                        <div class="relative overflow-x-auto rounded-xl border border-gray-100">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 font-black tracking-widest">No</th>
                                        <th class="px-6 py-3 font-black tracking-widest">Nama Siswa</th>
                                        <th class="px-6 py-3 font-black tracking-widest">Kelas</th>
                                        <th class="px-6 py-3 font-black tracking-widest">Mata Pelajaran</th>
                                        <th class="px-6 py-3 font-black tracking-widest text-center">Nilai</th>
                                        <th class="px-6 py-3 font-black tracking-widest text-center">Status</th>
                                        <th class="px-6 py-3 font-black tracking-widest text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse ($nilai as $index => $g)
                                        <tr class="hover:bg-indigo-50/40 transition-colors"
                                            x-show="activeTab === 'semua' || activeTab === '{{ $g->siswa->kelas_id ?? '' }}'">
                                            <td class="px-6 py-4 text-gray-400 font-mono text-xs">
                                                {{ sprintf('%02d', $index + 1) }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <p class="font-semibold text-gray-800 leading-tight">{{ $g->siswa->nama ?? '-' }}</p>
                                                <p class="text-[11px] text-gray-400 mt-0.5">NIS: {{ $g->siswa->nis ?? '-' }}</p>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 rounded-lg text-xs font-semibold">
                                                    {{ $g->siswa->kelas->name ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">{{ $g->mataPelajaran->nama ?? '-' }}</td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="text-lg font-black {{ $g->nilai >= 75 ? 'text-emerald-600' : 'text-rose-500' }}">
                                                    {{ $g->nilai }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="px-3 py-1 rounded-full text-[11px] font-bold
                                                    {{ $g->nilai >= 75
                                                        ? 'bg-emerald-50 text-emerald-700 border border-emerald-100'
                                                        : 'bg-rose-50 text-rose-700 border border-rose-100' }}">
                                                    {{ $g->nilai >= 75 ? 'Tuntas' : 'Remedial' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <button x-data=""
                                                    x-on:click.prevent="$dispatch('open-modal', 'editNilaiModal')"
                                                    @click="$dispatch('set-nilai-data', {
                                                        id: '{{ $g->id }}',
                                                        nama: '{{ $g->siswa->nama }}',
                                                        siswa_id: '{{ $g->siswa->id }}',
                                                        mapel: '{{ $g->mataPelajaran->nama }}',
                                                        mapel_id: '{{ $g->mataPelajaran->id }}',
                                                        nilai: '{{ $g->nilai }}'
                                                    })"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-white border border-gray-200 text-gray-600 hover:border-indigo-300 hover:text-indigo-600 hover:bg-indigo-50 transition-all shadow-sm">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    Edit
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-16 text-center">
                                                <div class="flex flex-col items-center gap-2">
                                                    <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                        </svg>
                                                    </div>
                                                    <p class="text-gray-400 text-sm font-medium">Belum ada data nilai siswa</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>{{-- end tabs --}}
                </div>
            </div>
        </div>
    </div>

    {{-- ── Modal Tambah Nilai ───────────────────────────────────────────── --}}
    <x-modal name="tambahNilaiModal" focusable>
        <div class="relative w-full max-w-lg">
            <div class="relative bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-blue-500 px-6 py-5">
                    <h3 class="text-lg font-bold text-white">Tambah Nilai Siswa</h3>
                    <p class="text-indigo-100 text-xs mt-0.5">{{ $mataPelajaran->nama }}</p>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.nilai.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="siswa_id" value="{{ __('Nama Siswa') }}" />
                            <select name="siswa_id" id="siswa_id" required
                                class="mt-1 p-2.5 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                <option value="">Pilih Siswa</option>
                                @foreach ($kelas as $k)
                                    <optgroup label="{{ $k->name }}">
                                        @foreach ($k->siswa as $s)
                                            <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="add_nilai" value="{{ __('Nilai') }}" />
                            <x-text-input id="add_nilai" name="nilai" type="number" min="0" max="100"
                                class="mt-1 block w-full" placeholder="0 – 100" required />
                        </div>
                        <div>
                            <x-input-label value="{{ __('Mata Pelajaran') }}" />
                            <input type="hidden" name="mata_pelajaran_id" value="{{ $mataPelajaran->id }}">
                            <x-text-input type="text" class="mt-1 block w-full bg-gray-50 text-gray-500"
                                value="{{ $mataPelajaran->nama }}" readonly />
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

    {{-- ── Modal Edit Nilai ─────────────────────────────────────────────── --}}
    <x-modal name="editNilaiModal" focusable>
        <div class="relative w-full max-w-lg">
            <div class="relative bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-slate-700 to-slate-600 px-6 py-5">
                    <h3 class="text-lg font-bold text-white">Edit Nilai Siswa</h3>
                    <p class="text-slate-300 text-xs mt-0.5">{{ $mataPelajaran->nama }}</p>
                </div>
                <div class="p-6">
                    <form x-data="{ nilaiData: {} }" @set-nilai-data.window="nilaiData = $event.detail"
                        x-bind:action="'/admin/nilai/' + nilaiData.id" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="siswa_id" x-bind:value="nilaiData.siswa_id">
                        <input type="hidden" name="mata_pelajaran_id" x-bind:value="nilaiData.mapel_id">
                        <div>
                            <x-input-label value="{{ __('Nama Siswa') }}" />
                            <x-text-input type="text" class="mt-1 block w-full bg-gray-50 text-gray-500 font-semibold"
                                x-bind:value="nilaiData.nama" readonly />
                        </div>
                        <div>
                            <x-input-label value="{{ __('Mata Pelajaran') }}" />
                            <x-text-input type="text" class="mt-1 block w-full bg-gray-50 text-gray-500"
                                x-bind:value="nilaiData.mapel" readonly />
                        </div>
                        <div>
                            <x-input-label for="edit_nilai" value="{{ __('Nilai Baru') }}" />
                            <x-text-input id="edit_nilai" name="nilai" type="number" min="0" max="100"
                                class="mt-1 block w-full" x-bind:value="nilaiData.nilai" required />
                        </div>
                        <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">
                            <x-secondary-button type="button" x-on:click="$dispatch('close')">Batal</x-secondary-button>
                            <x-primary-button>Update</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-modal>

</x-app-layout>