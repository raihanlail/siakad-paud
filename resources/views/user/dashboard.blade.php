<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Dashboard Orang Tua') }}
        </h2>
    </x-slot>

    <div class="space-y-6">

        {{-- ── Welcome Banner ──────────────────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-8 flex flex-col md:flex-row items-center justify-between bg-gradient-to-r from-white to-blue-50/50">
                <div class="mb-6 md:mb-0 text-center md:text-left">
                    <h3 class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-1">Selamat Datang di SIAKAD</h3>
                    <span class="text-3xl font-extrabold text-slate-800 tracking-tight">
                        Halo, <span class="text-blue-600">{{ $user->name }}</span>!
                    </span>
                    <p class="text-slate-500 mt-2 text-base font-medium">Pantau perkembangan akademik putra-putri Anda di sini.</p>
                </div>
                <a href="{{ route('user.daftar') }}" class="group">
                    <x-primary-button class="px-8 py-4 rounded-xl shadow-lg shadow-blue-200 transition-all group-hover:-translate-y-1">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                        Daftar Siswa Baru
                    </x-primary-button>
                </a>
            </div>
        </div>

        {{-- ── Empty State ─────────────────────────────────────────────── --}}
        @if ($siswa->isEmpty())
            <div class="bg-white rounded-2xl border-2 border-dashed border-slate-200 p-16 text-center">
                <div class="bg-slate-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h4 class="text-xl font-bold text-slate-800">Belum Ada Siswa Terdaftar</h4>
                <p class="text-slate-500 mt-2 max-w-sm mx-auto font-medium">Data nilai akan muncul setelah Anda mendaftarkan siswa dan diverifikasi oleh admin.</p>
            </div>

        @else
            <div class="grid grid-cols-1 gap-6">
                @foreach ($siswa as $item)
                    @php
                        $status     = $item->status ?? 'Pending';
                        $isVerified = $status === 'Verified';
                        $isRejected = $status === 'Rejected';
                        $isPending  = !$isVerified && !$isRejected;
                        $bayar      = $item->bayar->status ?? null;
                    @endphp

                    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden transition-all hover:shadow-md
                        {{ $isPending ? 'border-amber-200' : ($isRejected ? 'border-rose-200' : 'border-slate-200') }}">

                        {{-- ── Card Header ──────────────────────────────── --}}
                        <div class="px-6 py-5 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4
                            {{ $isPending ? 'bg-amber-50/40' : ($isRejected ? 'bg-rose-50/30' : 'bg-slate-50/30') }} border-b
                            {{ $isPending ? 'border-amber-100' : ($isRejected ? 'border-rose-100' : 'border-slate-100') }}">

                            {{-- Student info --}}
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-inner flex-shrink-0
                                    {{ $isPending ? 'bg-amber-100 text-amber-500' : ($isRejected ? 'bg-rose-100 text-rose-500' : 'bg-indigo-100 text-indigo-600') }}">
                                    @if($isPending)
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @elseif($isRejected)
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @else
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <h2 class="text-xl font-extrabold text-slate-800 leading-tight">{{ $item->nama }}</h2>
                                    @if($isVerified)
                                        {{-- Only show NIS + Kelas when verified --}}
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-0.5">
                                            NIS: {{ $item->nis }}
                                            &nbsp;·&nbsp;
                                            Kelas: {{ $item->kelas->name ?? '—' }}
                                        </p>
                                    @else
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-0.5">
                                            Data pendaftaran
                                        </p>
                                    @endif
                                </div>
                            </div>

                            {{-- Status badges + actions --}}
                            <div class="flex flex-wrap items-center gap-3">

                                {{-- Registration status --}}
                                <div class="flex flex-col items-end">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Status Pendaftaran</span>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold border
                                        @if($isVerified) bg-emerald-50 text-emerald-700 border-emerald-200
                                        @elseif($isRejected) bg-rose-50 text-rose-700 border-rose-200
                                        @else bg-amber-50 text-amber-700 border-amber-200 @endif">
                                        @if($isVerified)
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                            Terverifikasi
                                        @elseif($isRejected)
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                                            Pendaftaran Ditolak
                                        @else
                                            <svg class="w-3 h-3 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                            Menunggu Konfirmasi Admin
                                        @endif
                                    </span>
                                </div>

                                {{-- Payment status — only show when verified --}}
                                @if($isVerified)
                                    <div class="flex flex-col items-end">
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Administrasi</span>
                                        <span class="px-3 py-1.5 rounded-lg text-xs font-bold border
                                            @if($bayar === 'Lunas') bg-emerald-50 text-emerald-700 border-emerald-200
                                            @elseif($bayar) bg-orange-50 text-orange-700 border-orange-200
                                            @else bg-slate-100 text-slate-500 border-slate-200 @endif">
                                            {{ $bayar ? strtoupper($bayar) : 'BELUM ADA DATA' }}
                                        </span>
                                    </div>

                                    <a href="{{ route('user.download', $item->id) }}">
                                        <x-secondary-button class="rounded-xl text-xs py-2.5">
                                            <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                                            </svg>
                                            Unduh Raport
                                        </x-secondary-button>
                                    </a>
                                @endif

                            </div>
                        </div>

                        {{-- ── Status Info Banner (Pending / Rejected) ──── --}}
                        @if($isPending)
                            <div class="px-6 py-4 bg-amber-50 border-b border-amber-100 flex items-start gap-3">
                                <div class="flex h-2.5 w-2.5 mt-1 flex-shrink-0 relative">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-amber-500"></span>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-amber-800">Pendaftaran sedang diproses</p>
                                    <p class="text-xs text-amber-600 mt-0.5">Data NIS dan kelas akan ditampilkan setelah admin memverifikasi pendaftaran ini. Harap tunggu konfirmasi.</p>
                                </div>
                            </div>
                        @elseif($isRejected)
                            <div class="px-6 py-4 bg-rose-50 border-b border-rose-100 flex items-start gap-3">
                                <svg class="w-5 h-5 text-rose-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-bold text-rose-800">Pendaftaran ditolak oleh admin</p>
                                    <p class="text-xs text-rose-600 mt-0.5">Mohon hubungi pihak sekolah untuk informasi lebih lanjut mengenai penolakan ini.</p>
                                </div>
                            </div>
                        @endif

                        {{-- ── Nilai Table — only for verified --}}
                        @if($isVerified)
                            <div class="p-0">
                                @if($item->nilai->isEmpty())
                                    <div class="py-10 text-center">
                                        <p class="text-slate-400 font-medium italic text-sm">Belum ada nilai yang diinput oleh guru.</p>
                                    </div>
                                @else
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-left border-collapse">
                                            <thead>
                                                <tr class="bg-slate-50/50">
                                                    <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Mata Pelajaran</th>
                                                    <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">Nilai Akhir</th>
                                                    <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">Predikat</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-50">
                                                @foreach ($item->nilai as $nilai)
                                                    <tr class="hover:bg-blue-50/30 transition-colors">
                                                        <td class="px-8 py-4">
                                                            <span class="text-slate-700 font-bold">{{ $nilai->mataPelajaran->nama }}</span>
                                                        </td>
                                                        <td class="px-8 py-4 text-center">
                                                            <span class="font-mono font-black text-lg {{ $nilai->nilai >= 75 ? 'text-blue-600' : 'text-rose-500' }}">
                                                                {{ $nilai->nilai }}
                                                            </span>
                                                        </td>
                                                        <td class="px-8 py-4 text-center">
                                                            <span class="px-3 py-1 rounded-md text-xs font-black
                                                                @if($nilai->nilai >= 90) bg-emerald-50 text-emerald-700
                                                                @elseif($nilai->nilai >= 80) bg-blue-50 text-blue-700
                                                                @elseif($nilai->nilai >= 70) bg-amber-50 text-amber-700
                                                                @else bg-rose-50 text-rose-700 @endif">
                                                                @if($nilai->nilai >= 90) SANGAT BAIK
                                                                @elseif($nilai->nilai >= 80) BAIK
                                                                @elseif($nilai->nilai >= 70) CUKUP
                                                                @else PERLU BIMBINGAN @endif
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>