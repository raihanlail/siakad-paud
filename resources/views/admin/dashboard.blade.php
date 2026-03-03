<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard — SIAKAD RA ALIFIA') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- ── Welcome Banner ─────────────────────────────────────────── --}}
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-800 via-slate-700 to-slate-900 px-8 py-8 shadow-xl">
                <div class="absolute -top-10 -right-10 w-56 h-56 rounded-full bg-white/5 blur-2xl"></div>
                <div class="absolute bottom-0 left-1/3 w-80 h-20 rounded-full bg-indigo-500/10 blur-3xl"></div>
                <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Selamat Datang</p>
                        <h1 class="text-white text-2xl font-extrabold tracking-tight">SIAKAD RA ALIFIA</h1>
                        <p class="text-slate-300 text-sm mt-1">Sistem Informasi Akademik — Ringkasan data hari ini</p>
                    </div>
                    <div class="text-right">
                        <p class="text-slate-400 text-xs uppercase tracking-widest">Tanggal</p>
                        <p class="text-white font-bold text-lg">{{ now()->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- ── Primary Stats ───────────────────────────────────────────── --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

                <a href="{{ route('admin.guru') }}"
                   class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 p-6 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Total Guru</p>
                        <p class="text-3xl font-black text-gray-800 leading-tight">{{ $guruCount }}</p>
                    </div>
                </a>

                <a href="{{ route('admin.siswa') }}"
                   class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 p-6 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Total Siswa</p>
                        <p class="text-3xl font-black text-gray-800 leading-tight">{{ $siswaCount }}</p>
                    </div>
                </a>

                <a href="{{ route('admin.mapel') }}"
                   class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 p-6 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0 group-hover:bg-rose-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Total Mapel</p>
                        <p class="text-3xl font-black text-gray-800 leading-tight">{{ $mapelCount }}</p>
                    </div>
                </a>

                <a href="{{ route('admin.kelas') }}"
                   class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 p-6 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center flex-shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Total Kelas</p>
                        <p class="text-3xl font-black text-gray-800 leading-tight">{{ $kelasCount }}</p>
                    </div>
                </a>

            </div>

            {{-- ── Secondary Stats Row ─────────────────────────────────────── --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                {{-- Payment status --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-4">Status Pembayaran</p>
                    <div class="flex items-end gap-6">
                        <div>
                            <p class="text-3xl font-black text-emerald-600">{{ $lunas }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">Lunas</p>
                        </div>
                        <div class="w-px h-10 bg-gray-100"></div>
                        <div>
                            <p class="text-3xl font-black text-rose-500">{{ $belumBayar }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">Belum Lunas</p>
                        </div>
                    </div>
                    {{-- Progress bar --}}
                    @php $bayarTotal = $lunas + $belumBayar; $pctBayar = $bayarTotal > 0 ? round(($lunas / $bayarTotal) * 100) : 0; @endphp
                    <div class="mt-4">
                        <div class="flex justify-between text-[10px] text-gray-400 mb-1">
                            <span>Progress Pelunasan</span>
                            <span>{{ $pctBayar }}%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="h-2 rounded-full bg-emerald-500 transition-all" style="width: {{ $pctBayar }}%"></div>
                        </div>
                    </div>
                </div>

                {{-- Nilai stats --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-4">Statistik Nilai</p>
                    <div class="flex items-end gap-6">
                        <div>
                            <p class="text-3xl font-black text-blue-600">{{ $nilaiTuntas }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">Tuntas</p>
                        </div>
                        <div class="w-px h-10 bg-gray-100"></div>
                        <div>
                            <p class="text-3xl font-black text-orange-500">{{ $nilaiRemedial }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">Remedial</p>
                        </div>
                    </div>
                    <div class="mt-4 p-3 bg-blue-50 rounded-xl flex items-center justify-between">
                        <span class="text-xs text-blue-600 font-bold uppercase tracking-wide">Rata-rata Nilai</span>
                        <span class="text-lg font-black text-blue-700">{{ $rataRata ? number_format($rataRata, 1) : '-' }}</span>
                    </div>
                </div>

                {{-- Kelas capacity --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-4">Kapasitas Kelas</p>
                    <div class="space-y-3 max-h-40 overflow-y-auto pr-1">
                        @forelse ($kelas as $k)
                            @php $pct = $k->capacity > 0 ? min(100, round(($k->siswa_count / $k->capacity) * 100)) : 0; @endphp
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="font-semibold text-gray-700">{{ $k->name }}</span>
                                    <span class="text-gray-400">{{ $k->siswa_count }}/{{ $k->capacity }}</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-1.5">
                                    <div class="h-1.5 rounded-full transition-all {{ $pct >= 100 ? 'bg-red-500' : ($pct >= 80 ? 'bg-orange-400' : 'bg-indigo-500') }}"
                                         style="width: {{ $pct }}%"></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 italic">Belum ada data kelas</p>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- ── Recent Siswa ────────────────────────────────────────────── --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-gray-800 text-sm">Siswa Terbaru Terdaftar</h3>
                        <p class="text-xs text-gray-400 mt-0.5">5 pendaftaran terakhir</p>
                    </div>
                    <a href="{{ route('admin.siswa') }}"
                       class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">
                        Lihat Semua →
                    </a>
                </div>
                <div class="divide-y divide-gray-50">
                    @forelse ($recentSiswa as $s)
                        <div class="flex items-center gap-4 px-6 py-3 hover:bg-gray-50 transition-colors">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0 font-bold text-sm
                                {{ $s->jenis_kelamin === 'Laki-laki' ? 'bg-blue-100 text-blue-600' : 'bg-pink-100 text-pink-600' }}">
                                {{ strtoupper(substr($s->nama, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $s->nama }}</p>
                                <p class="text-xs text-gray-400">NIS: {{ $s->nis }}</p>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <span class="inline-block px-2 py-0.5 bg-indigo-50 text-indigo-700 rounded text-xs font-semibold">
                                    {{ $s->kelas->name ?? 'Belum ada kelas' }}
                                </span>
                                <p class="text-[10px] text-gray-400 mt-0.5">{{ $s->orangTua->name ?? '-' }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-sm text-gray-400">Belum ada data siswa</div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>