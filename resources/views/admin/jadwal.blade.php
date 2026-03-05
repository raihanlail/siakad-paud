<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jadwal Kelas') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @php
                $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
                $hariColors = [
                    'Senin'   => ['bg' => 'bg-blue-500',   'light' => 'bg-blue-50',   'text' => 'text-gray-700',   'border' => 'border-blue-200',  'badge' => 'bg-blue-100 text-blue-700'],
                    'Selasa'  => ['bg' => 'bg-violet-500', 'light' => 'bg-violet-50', 'text' => 'text-violet-700', 'border' => 'border-violet-200','badge' => 'bg-violet-100 text-violet-700'],
                    'Rabu'    => ['bg' => 'bg-emerald-500','light' => 'bg-emerald-50','text' => 'text-emerald-700','border' => 'border-emerald-200','badge' => 'bg-emerald-100 text-emerald-700'],
                    'Kamis'   => ['bg' => 'bg-amber-500',  'light' => 'bg-amber-50',  'text' => 'text-amber-700',  'border' => 'border-amber-200', 'badge' => 'bg-amber-100 text-amber-700'],
                    'Jumat'   => ['bg' => 'bg-rose-500',   'light' => 'bg-rose-50',   'text' => 'text-rose-700',   'border' => 'border-rose-200',  'badge' => 'bg-rose-100 text-rose-700'],
                    'Sabtu'   => ['bg' => 'bg-slate-500',  'light' => 'bg-slate-50',  'text' => 'text-slate-700',  'border' => 'border-slate-200', 'badge' => 'bg-slate-100 text-slate-700'],
                ];
                $totalJadwal = collect($jadwal)->flatten(1)->count();
            @endphp

            {{-- ── Stats Row ──────────────────────────────────────────────── --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Total Jadwal</p>
                        <p class="text-xl font-black text-gray-800 leading-none">{{ $totalJadwal }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Kelas Aktif</p>
                        <p class="text-xl font-black text-blue-600 leading-none">{{ $kelas->count() }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Mata Pelajaran</p>
                        <p class="text-xl font-black text-emerald-600 leading-none">{{ $mapel->count() }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Guru Terlibat</p>
                        <p class="text-xl font-black text-amber-600 leading-none">{{ $guru->count() }}</p>
                    </div>
                </div>
            </div>

            {{-- ── Main Card ───────────────────────────────────────────────── --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" x-data="{ viewMode: 'grid', activeKelas: 'semua' }">

                {{-- Card Header --}}
                <div class="px-5 py-3.5 border-b border-gray-100 bg-gray-50/40 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-bold text-gray-800 text-sm">Jadwal Pelajaran</h3>
                        <p class="text-[11px] text-gray-400 mt-0.5">Kelola jadwal kelas mingguan</p>
                    </div>
                    <div class="flex items-center gap-2">
                        {{-- View toggle --}}
                        <div class="flex items-center bg-gray-100 rounded-lg p-0.5 gap-0.5">
                            <button @click="viewMode = 'grid'"
                                :class="viewMode === 'grid' ? 'bg-white shadow-sm text-gray-700' : 'text-gray-400 hover:text-gray-600'"
                                class="px-3 py-1.5 rounded-md text-[11px] font-semibold transition-all flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                Grid
                            </button>
                            <button @click="viewMode = 'list'"
                                :class="viewMode === 'list' ? 'bg-white shadow-sm text-gray-700' : 'text-gray-400 hover:text-gray-600'"
                                class="px-3 py-1.5 rounded-md text-[11px] font-semibold transition-all flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                                List
                            </button>
                        </div>

                        <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'tambahJadwalModal')">
                            + Tambah Jadwal
                        </x-primary-button>
                    </div>
                </div>

                {{-- Kelas filter tabs --}}
                <div class="px-5 pt-2.5 flex flex-wrap gap-0.5 border-b border-gray-100">
                    <button @click="activeKelas = 'semua'"
                        :class="activeKelas === 'semua' ? 'border-b-2 border-indigo-600 text-indigo-600 font-bold' : 'text-gray-400 hover:text-gray-600'"
                        class="pb-2 px-2.5 text-[11px] uppercase tracking-widest font-medium transition-colors">
                        Semua Kelas
                    </button>
                    @foreach($kelas as $k)
                        <button @click="activeKelas = '{{ $k->id }}'"
                            :class="activeKelas === '{{ $k->id }}' ? 'border-b-2 border-indigo-600 text-indigo-600 font-bold' : 'text-gray-400 hover:text-gray-600'"
                            class="pb-2 px-2.5 text-[11px] uppercase tracking-widest font-medium transition-colors">
                            {{ $k->name }}
                        </button>
                    @endforeach
                </div>

                {{-- ── GRID VIEW ───────────────────────────────────────────── --}}
                <div x-show="viewMode === 'grid'" class="p-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($hariList as $hari)
                            @php
                                $color    = $hariColors[$hari];
                                $entries  = $jadwal[$hari] ?? collect();
                            @endphp
                            <div class="rounded-xl border {{ $color['border'] }} overflow-hidden">
                                {{-- Day header --}}
                                <div class="{{ $color['bg'] }} px-4 py-2.5 flex items-center justify-between">
                                    <h4 class="text-white font-black text-xs uppercase tracking-widest">{{ $hari }}</h4>
                                    <span class="text-white/70 text-[10px] font-bold">{{ $entries->count() }} sesi</span>
                                </div>
                                {{-- Entries --}}
                                <div class="{{ $color['light'] }} divide-y divide-white/60 min-h-[80px]">
                                    @forelse($entries as $j)
                                        <div x-show="activeKelas === 'semua' || activeKelas === '{{ $j->kelas_id }}'"
                                             class="px-4 py-3 flex items-start justify-between gap-2 hover:brightness-95 transition-all">
                                            <div class="flex-1 min-w-0">
                                                <p class="font-bold text-xs text-gray-800 leading-tight truncate">{{ $j->mataPelajaran->nama }}</p>
                                                <p class="text-[10px] text-gray-500 mt-0.5 truncate">{{ $j->guru->nama }}</p>
                                                <div class="flex items-center gap-1.5 mt-1.5 flex-wrap">
                                                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold {{ $color['badge'] }}">
                                                        {{ $j->kelas->name }}
                                                    </span>
                                                    <span class="text-[9px] text-gray-400 font-mono">
                                                        {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                                                    </span>
                                                </div>
                                            </div>
                                            <button
                                                x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'hapusJadwalModal')"
                                                @click="$dispatch('set-jadwal-data', { id: '{{ $j->id }}', label: '{{ $j->mataPelajaran->nama }} – {{ $j->kelas->name }} ({{ $hari }})' })"
                                                class="w-6 h-6 flex-shrink-0 flex items-center justify-center rounded-lg border border-white/60 bg-white/60 text-gray-400 hover:bg-rose-50 hover:text-rose-500 hover:border-rose-200 transition-all"
                                                title="Hapus">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        </div>
                                    @empty
                                        <div class="px-4 py-6 text-center">
                                            <p class="text-[11px] text-gray-400 italic">Belum ada jadwal</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ── LIST VIEW ───────────────────────────────────────────── --}}
                <div x-show="viewMode === 'list'" class="overflow-x-auto">
                    <table class="w-full text-xs text-left text-gray-500">
                        <thead class="text-[10px] text-gray-400 uppercase bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-4 py-2.5 font-black tracking-widest w-8">#</th>
                                <th class="px-4 py-2.5 font-black tracking-widest">Hari</th>
                                <th class="px-4 py-2.5 font-black tracking-widest">Jam</th>
                                <th class="px-4 py-2.5 font-black tracking-widest">Mata Pelajaran</th>
                                <th class="px-4 py-2.5 font-black tracking-widest">Kelas</th>
                                <th class="px-4 py-2.5 font-black tracking-widest">Guru</th>
                                <th class="px-4 py-2.5 font-black tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @php $listIndex = 0; @endphp
                            @foreach($hariList as $hari)
                                @foreach($jadwal[$hari] ?? [] as $j)
                                    @php $listIndex++; $color = $hariColors[$hari]; @endphp
                                    <tr class="hover:bg-gray-50/70 transition-colors"
                                        x-show="activeKelas === 'semua' || activeKelas === '{{ $j->kelas_id }}'">
                                        <td class="px-4 py-2.5 text-gray-300 font-mono text-[10px]">{{ sprintf('%02d', $listIndex) }}</td>
                                        <td class="px-4 py-2.5">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold {{ $color['badge'] }}">
                                                {{ $hari }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2.5 font-mono text-[11px] text-gray-600">
                                            {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                                        </td>
                                        <td class="px-4 py-2.5">
                                            <p class="font-semibold text-gray-800 text-xs leading-tight">{{ $j->mataPelajaran->nama }}</p>
                                        </td>
                                        <td class="px-4 py-2.5">
                                            <span class="px-2 py-0.5 bg-indigo-50 text-indigo-700 rounded text-[10px] font-bold">
                                                {{ $j->kelas->name }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2.5">
                                            <div class="flex items-center gap-2">
                                                <div class="w-5 h-5 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-[9px] flex-shrink-0">
                                                    {{ strtoupper(substr($j->guru->nama, 0, 1)) }}
                                                </div>
                                                <p class="text-[11px] text-gray-700 font-medium">{{ $j->guru->nama }}</p>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2.5 text-right">
                                            <button
                                                x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'hapusJadwalModal')"
                                                @click="$dispatch('set-jadwal-data', { id: '{{ $j->id }}', label: '{{ $j->mataPelajaran->nama }} – {{ $j->kelas->name }} ({{ $hari }})' })"
                                                class="w-7 h-7 flex items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-400 hover:bg-rose-50 hover:text-rose-500 hover:border-rose-200 transition-all"
                                                title="Hapus Jadwal">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                            @if($totalJadwal === 0)
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                            <p class="text-sm text-gray-400 font-medium">Belum ada jadwal</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    {{-- ── Modal Tambah Jadwal ─────────────────────────────────────────── --}}
    <x-modal name="tambahJadwalModal" focusable>
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tambah Jadwal Kelas</h3>
            <form action="{{ route('admin.jadwal.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div>
                        <x-input-label for="kelas_id" value="Kelas" />
                        <select name="kelas_id" id="kelas_id" required
                            class="mt-1 p-2.5 w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 text-sm">
                            <option value="">Pilih Kelas</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="mata_pelajaran_id" value="Mata Pelajaran" />
                        <select name="mata_pelajaran_id" id="mata_pelajaran_id" required
                            class="mt-1 p-2.5 w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 text-sm">
                            <option value="">Pilih Mata Pelajaran</option>
                            @foreach($mapel as $m)
                                <option value="{{ $m->id }}">{{ $m->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <x-input-label for="guru_id" value="Guru Pengampu" />
                        <select name="guru_id" id="guru_id" required
                            class="mt-1 p-2.5 w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 text-sm">
                            <option value="">Pilih Guru</option>
                            @foreach($guru as $g)
                                <option value="{{ $g->id }}">{{ $g->nama }} — {{ $g->mapel->nama ?? '—' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="hari" value="Hari" />
                        <select name="hari" id="hari" required
                            class="mt-1 p-2.5 w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 text-sm">
                            <option value="">Pilih Hari</option>
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $h)
                                <option value="{{ $h }}">{{ $h }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <x-input-label for="jam_mulai" value="Jam Mulai" />
                            <x-text-input id="jam_mulai" name="jam_mulai" type="time" class="mt-1 block w-full" required />
                        </div>
                        <div>
                            <x-input-label for="jam_selesai" value="Jam Selesai" />
                            <x-text-input id="jam_selesai" name="jam_selesai" type="time" class="mt-1 block w-full" required />
                        </div>
                    </div>

                </div>
                <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">
                    <x-secondary-button type="button" x-on:click="$dispatch('close')">Batal</x-secondary-button>
                    <x-primary-button>Simpan Jadwal</x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>

    {{-- ── Modal Hapus Jadwal ──────────────────────────────────────────── --}}
    <x-modal name="hapusJadwalModal" focusable>
        <div class="p-6" x-data="{ jadwalData: {} }" @set-jadwal-data.window="jadwalData = $event.detail">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Hapus Jadwal</h3>
            <form x-bind:action="'/admin/jadwal/' + jadwalData.id" method="POST" class="space-y-4">
                @csrf
                @method('DELETE')
                <div class="flex items-start gap-3 p-4 bg-rose-50 rounded-xl border border-rose-100">
                    <svg class="w-5 h-5 text-rose-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <p class="text-sm text-rose-700">
                        Yakin ingin menghapus jadwal <strong x-text="jadwalData.label"></strong>? Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
                <div class="flex justify-end gap-2">
                    <x-secondary-button type="button" x-on:click="$dispatch('close')">Batal</x-secondary-button>
                    <x-danger-button>Hapus</x-danger-button>
                </div>
            </form>
        </div>
    </x-modal>

    @if(session('success'))
        <div class="fixed bottom-4 right-4 bg-emerald-500 text-white px-5 py-3 rounded-xl shadow-lg z-50 text-sm"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="fixed bottom-4 right-4 bg-rose-500 text-white px-5 py-3 rounded-xl shadow-lg z-50 text-sm"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
            {{ session('error') }}
        </div>
    @endif

</x-app-layout>