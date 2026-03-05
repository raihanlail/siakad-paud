<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Jadwal Pelajaran') }}
        </h2>
    </x-slot>

    <div class="space-y-8">

        @php
            $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
            $hariMeta = [
                'Senin'  => ['color' => '#3b82f6', 'light' => '#eff6ff', 'border' => '#bfdbfe', 'badge_bg' => '#dbeafe', 'badge_text' => '#1d4ed8'],
                'Selasa' => ['color' => '#8b5cf6', 'light' => '#f5f3ff', 'border' => '#ddd6fe', 'badge_bg' => '#ede9fe', 'badge_text' => '#6d28d9'],
                'Rabu'   => ['color' => '#10b981', 'light' => '#ecfdf5', 'border' => '#a7f3d0', 'badge_bg' => '#d1fae5', 'badge_text' => '#065f46'],
                'Kamis'  => ['color' => '#f59e0b', 'light' => '#fffbeb', 'border' => '#fde68a', 'badge_bg' => '#fef3c7', 'badge_text' => '#92400e'],
                'Jumat'  => ['color' => '#f43f5e', 'light' => '#fff1f2', 'border' => '#fecdd3', 'badge_bg' => '#ffe4e6', 'badge_text' => '#9f1239'],
                'Sabtu'  => ['color' => '#64748b', 'light' => '#f8fafc', 'border' => '#e2e8f0', 'badge_bg' => '#f1f5f9', 'badge_text' => '#334155'],
            ];
        @endphp

        @forelse($siswa as $item)
            @php
                $isVerified = ($item->status ?? '') === 'Verified';
                $kelasJadwal = $jadwal[$item->kelas_id] ?? collect();
                $totalSesi = $kelasJadwal->flatten(1)->count();
                $totalHari = $kelasJadwal->keys()->count();
            @endphp

            <div class="space-y-4">

                {{-- ── Siswa header card ─────────────────────────────────── --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4
                        {{ $isVerified ? 'bg-gradient-to-r from-white to-indigo-50/40' : 'bg-gray-50/50' }}">

                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center font-extrabold text-lg flex-shrink-0
                                {{ $item->jenis_kelamin === 'Laki-laki' ? 'bg-blue-100 text-blue-600' : 'bg-pink-100 text-pink-500' }}">
                                {{ strtoupper(substr($item->nama, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="text-lg font-extrabold text-slate-800 leading-tight">{{ $item->nama }}</h3>
                                @if($isVerified)
                                    <p class="text-xs text-slate-400 font-medium mt-0.5">
                                        NIS: <span class="font-mono font-bold text-slate-600">{{ $item->nis }}</span>
                                        &nbsp;·&nbsp; Kelas: <span class="font-bold text-indigo-600">{{ $item->kelas->name ?? '—' }}</span>
                                    </p>
                                @else
                                    <p class="text-xs text-slate-400 mt-0.5">Pendaftaran belum diverifikasi</p>
                                @endif
                            </div>
                        </div>

                        @if($isVerified)
                            <div class="flex items-center gap-3 flex-shrink-0">
                                <div class="text-right">
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Total Sesi</p>
                                    <p class="text-xl font-black text-indigo-600 leading-none">{{ $totalSesi }}</p>
                                    <p class="text-[10px] text-gray-400">{{ $totalHari }} hari/minggu</p>
                                </div>
                                <div class="w-px h-10 bg-gray-100"></div>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg text-xs font-bold">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    Terverifikasi
                                </span>
                            </div>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 text-amber-700 border border-amber-200 rounded-lg text-xs font-bold">
                                <svg class="w-3 h-3 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                Menunggu Konfirmasi
                            </span>
                        @endif
                    </div>
                </div>

                {{-- ── Schedule grid / not-verified state ───────────────── --}}
                @if(!$isVerified)
                    <div class="bg-amber-50 border border-amber-200 rounded-2xl px-6 py-8 text-center">
                        <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-amber-800">Jadwal belum tersedia</p>
                        <p class="text-xs text-amber-600 mt-1">Jadwal kelas akan muncul setelah pendaftaran siswa diverifikasi oleh admin.</p>
                    </div>

                @elseif($totalSesi === 0)
                    <div class="bg-white border-2 border-dashed border-gray-200 rounded-2xl px-6 py-10 text-center">
                        <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-gray-500">Jadwal belum diatur</p>
                        <p class="text-xs text-gray-400 mt-1">Admin belum menambahkan jadwal untuk kelas {{ $item->kelas->name ?? '' }}.</p>
                    </div>

                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($hariList as $hari)
                            @php
                                $entries    = $kelasJadwal[$hari] ?? collect();
                                $meta       = $hariMeta[$hari];
                                $hasEntries = $entries->count() > 0;
                            @endphp

                            <div class="rounded-xl overflow-hidden border shadow-sm transition-all"
                                 style="border-color: {{ $meta['border'] }}; {{ !$hasEntries ? 'opacity:0.45' : '' }}">

                                {{-- Day header --}}
                                <div class="px-4 py-2.5 flex items-center justify-between"
                                     style="background: {{ $meta['color'] }}">
                                    <div class="flex items-center gap-2">
                                        <span class="w-6 h-6 rounded-md bg-white/20 flex items-center justify-center text-white font-black text-[10px]">
                                            {{ substr($hari, 0, 2) }}
                                        </span>
                                        <h4 class="text-white font-extrabold text-xs">{{ $hari }}</h4>
                                    </div>
                                    <span class="text-white/70 text-[10px] font-bold">
                                        {{ $entries->count() }} sesi
                                    </span>
                                </div>

                                {{-- Entries --}}
                                <div style="background: {{ $meta['light'] }}">
                                    @forelse($entries as $j)
                                        <div class="px-4 py-3 border-b last:border-b-0"
                                             style="border-color: {{ $meta['border'] }}">
                                            <p class="font-bold text-gray-800 text-xs leading-tight">
                                                {{ $j->mataPelajaran->nama }}
                                            </p>
                                            <p class="text-[11px] text-gray-500 mt-0.5">
                                                {{ $j->guru->nama }}
                                            </p>
                                            <div class="flex items-center gap-1.5 mt-2 flex-wrap">
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-bold"
                                                      style="background: {{ $meta['badge_bg'] }}; color: {{ $meta['badge_text'] }}">
                                                    <svg class="w-2 h-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                                                </span>
                                                @php $durasi = \Carbon\Carbon::parse($j->jam_mulai)->diffInMinutes(\Carbon\Carbon::parse($j->jam_selesai)); @endphp
                                                <span class="text-[9px] text-gray-400 font-bold">{{ $durasi }} mnt</span>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="px-4 py-5 text-center">
                                            <p class="text-[11px] text-gray-400 italic">Tidak ada kelas</p>
                                        </div>
                                    @endforelse
                                </div>

                            </div>
                        @endforeach
                    </div>
                @endif

            </div>

            {{-- Divider between children --}}
            @if(!$loop->last)
                <div class="border-t border-dashed border-gray-200"></div>
            @endif

        @empty
            <div class="bg-white rounded-2xl border-2 border-dashed border-slate-200 p-16 text-center">
                <div class="bg-slate-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h4 class="text-lg font-bold text-slate-700">Belum Ada Siswa Terdaftar</h4>
                <p class="text-slate-400 text-sm mt-1 max-w-xs mx-auto">Daftarkan siswa terlebih dahulu untuk melihat jadwal pelajaran.</p>
            </div>
        @endforelse

    </div>
</x-app-layout>