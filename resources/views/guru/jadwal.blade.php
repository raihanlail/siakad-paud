<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Jadwal Mengajar') }}
        </h2>
    </x-slot>

    <div class="space-y-6">

        @php
            $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
            $hariMeta = [
                'Senin'  => ['color' => '#3b82f6', 'light' => '#eff6ff', 'border' => '#bfdbfe', 'badge_bg' => '#dbeafe', 'badge_text' => '#1d4ed8', 'label_bg' => 'background:#3b82f6'],
                'Selasa' => ['color' => '#8b5cf6', 'light' => '#f5f3ff', 'border' => '#ddd6fe', 'badge_bg' => '#ede9fe', 'badge_text' => '#6d28d9'],
                'Rabu'   => ['color' => '#10b981', 'light' => '#ecfdf5', 'border' => '#a7f3d0', 'badge_bg' => '#d1fae5', 'badge_text' => '#065f46'],
                'Kamis'  => ['color' => '#f59e0b', 'light' => '#fffbeb', 'border' => '#fde68a', 'badge_bg' => '#fef3c7', 'badge_text' => '#92400e'],
                'Jumat'  => ['color' => '#f43f5e', 'light' => '#fff1f2', 'border' => '#fecdd3', 'badge_bg' => '#ffe4e6', 'badge_text' => '#9f1239'],
                'Sabtu'  => ['color' => '#64748b', 'light' => '#f8fafc', 'border' => '#e2e8f0', 'badge_bg' => '#f1f5f9', 'badge_text' => '#334155'],
            ];
            $totalJadwal   = collect($jadwal)->flatten(1)->count();
            $totalKelas    = collect($jadwal)->flatten(1)->pluck('kelas_id')->unique()->count();
            $totalHari     = collect($jadwal)->keys()->count();
            $earliestJam   = collect($jadwal)->flatten(1)->min('jam_mulai');
        @endphp

        {{-- ── Welcome + Stats ────────────────────────────────────────── --}}
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">

            {{-- Welcome card --}}
            <div class="lg:col-span-2 bg-gradient-to-br from-indigo-600 via-indigo-700 to-blue-800 rounded-2xl p-6 text-white relative overflow-hidden">
                <div class="absolute -top-6 -right-6 w-32 h-32 rounded-full bg-white/5"></div>
                <div class="absolute bottom-0 left-1/2 w-48 h-12 rounded-full bg-blue-400/10 blur-2xl"></div>
                <div class="relative z-10">
                    <p class="text-indigo-300 text-xs font-bold uppercase tracking-widest mb-1">Jadwal Mengajar</p>
                    <h2 class="text-xl font-extrabold leading-tight">{{ $guru->nama }}</h2>
                    <p class="text-indigo-200 text-sm mt-0.5">{{ $mapel->nama }}</p>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="px-2.5 py-1 bg-white/15 rounded-lg text-xs font-bold">NIP: {{ $guru->nip }}</span>
                    </div>
                </div>
            </div>

            {{-- Stat: total sesi --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Total Sesi</p>
                    <p class="text-2xl font-black text-gray-800 leading-none">{{ $totalJadwal }}</p>
                    <p class="text-[10px] text-gray-400 mt-0.5">{{ $totalHari }} hari per minggu</p>
                </div>
            </div>

            {{-- Stat: kelas diampu --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Kelas Diampu</p>
                    <p class="text-2xl font-black text-emerald-600 leading-none">{{ $totalKelas }}</p>
                    <p class="text-[10px] text-gray-400 mt-0.5">kelas berbeda</p>
                </div>
            </div>

        </div>

        {{-- ── Schedule ─────────────────────────────────────────────────── --}}
        @if($totalJadwal === 0)
            <div class="bg-white rounded-2xl border-2 border-dashed border-gray-200 p-16 text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h4 class="text-lg font-bold text-gray-700">Belum Ada Jadwal</h4>
                <p class="text-gray-400 text-sm mt-1">Jadwal mengajar Anda belum diatur oleh admin.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($hariList as $hari)
                    @php
                        $entries = $jadwal[$hari] ?? collect();
                        $meta    = $hariMeta[$hari];
                        $hasEntries = $entries->count() > 0;
                    @endphp

                    <div class="rounded-2xl overflow-hidden border shadow-sm transition-all hover:shadow-md"
                         style="border-color: {{ $meta['border'] }}; {{ !$hasEntries ? 'opacity:0.55' : '' }}">

                        {{-- Day header --}}
                        <div class="px-5 py-3.5 flex items-center justify-between"
                             style="background: {{ $meta['color'] }}">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                                    <span class="text-white font-black text-xs">{{ substr($hari, 0, 2) }}</span>
                                </div>
                                <h4 class="text-white font-extrabold text-sm">{{ $hari }}</h4>
                            </div>
                            <span class="px-2 py-0.5 bg-white/20 rounded-full text-white text-[10px] font-bold">
                                {{ $entries->count() }} sesi
                            </span>
                        </div>

                        {{-- Entries --}}
                        <div style="background: {{ $meta['light'] }}">
                            @forelse($entries as $j)
                                <div class="px-5 py-4 border-b last:border-b-0" style="border-color: {{ $meta['border'] }}">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex-1 min-w-0">
                                            <p class="font-bold text-gray-800 text-sm leading-tight truncate">
                                                {{ $j->mataPelajaran->nama }}
                                            </p>
                                            <div class="flex items-center gap-2 mt-2 flex-wrap">
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold"
                                                      style="background: {{ $meta['badge_bg'] }}; color: {{ $meta['badge_text'] }}">
                                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>
                                                    {{ $j->kelas->name }}
                                                </span>
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-white rounded-full text-[10px] font-mono font-bold text-gray-600 border border-gray-200">
                                                    <svg class="w-2.5 h-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                                                </span>
                                            </div>
                                        </div>
                                        {{-- Duration chip --}}
                                        @php
                                            $durasi = \Carbon\Carbon::parse($j->jam_mulai)->diffInMinutes(\Carbon\Carbon::parse($j->jam_selesai));
                                        @endphp
                                        <div class="flex-shrink-0 text-right">
                                            <span class="text-[10px] font-bold text-gray-400">{{ $durasi }} mnt</span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="px-5 py-6 text-center">
                                    <p class="text-xs text-gray-400 italic">Tidak ada kelas</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</x-app-layout>