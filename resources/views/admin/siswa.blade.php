<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Siswa') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @php
                $collection      = $siswa->getCollection();
                $lakiCount       = $collection->where('jenis_kelamin', 'Laki-laki')->count();
                $perempuanCount  = $collection->where('jenis_kelamin', 'Perempuan')->count();
                $lunasCount      = $collection->filter(fn($s) => optional($s->bayar)->status === 'Lunas')->count();
                $pendingCount    = \App\Models\Siswa::where('status', 'Pending')->orWhereNull('status')->count();
                $verifiedCount   = \App\Models\Siswa::where('status', 'Verified')->count();
                $rejectedCount   = \App\Models\Siswa::where('status', 'Rejected')->count();
            @endphp

            {{-- Stats --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Total</p>
                        <p class="text-xl font-black text-gray-800 leading-none">{{ $siswa->total() }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                        <span class="text-sm font-black">♂</span>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Laki-laki</p>
                        <p class="text-xl font-black text-blue-600 leading-none">{{ $lakiCount }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-pink-100 text-pink-500 flex items-center justify-center flex-shrink-0">
                        <span class="text-sm font-black">♀</span>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Perempuan</p>
                        <p class="text-xl font-black text-pink-500 leading-none">{{ $perempuanCount }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Lunas</p>
                        <p class="text-xl font-black text-emerald-600 leading-none">{{ $lunasCount }}</p>
                    </div>
                </div>
            </div>

            {{-- Registration Status --}}
            <div class="grid grid-cols-3 gap-3">
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-center gap-3 relative overflow-hidden">
                    @if($pendingCount > 0)
                        <span class="absolute top-2.5 right-2.5 flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                        </span>
                    @endif
                    <div class="w-9 h-9 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-amber-600 font-bold uppercase tracking-wider">Menunggu</p>
                        <p class="text-xl font-black text-amber-700 leading-none">{{ $pendingCount }}</p>
                    </div>
                </div>
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-wider">Terverifikasi</p>
                        <p class="text-xl font-black text-emerald-700 leading-none">{{ $verifiedCount }}</p>
                    </div>
                </div>
                <div class="bg-rose-50 border border-rose-200 rounded-xl p-4 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-rose-600 font-bold uppercase tracking-wider">Ditolak</p>
                        <p class="text-xl font-black text-rose-700 leading-none">{{ $rejectedCount }}</p>
                    </div>
                </div>
            </div>

            {{-- Main Card --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden"
                 x-data="{ activeTab: 'semua', statusFilter: 'semua' }">

                {{-- Card Header --}}
                <div class="px-5 py-3.5 border-b border-gray-100 bg-gray-50/40 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-bold text-gray-800 text-sm">Daftar Siswa</h3>
                        <p class="text-[11px] text-gray-400 mt-0.5">Filter berdasarkan kelas dan status pendaftaran</p>
                    </div>
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">

                        {{-- Search --}}
                        <form method="GET" action="{{ route('admin.siswa') }}" class="flex items-center gap-1.5">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z"/>
                                    </svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari nama atau NIS..."
                                    class="pl-8 pr-8 py-1.5 text-xs border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white w-52 transition-all" />
                                @if(request('search'))
                                    <a href="{{ route('admin.siswa') }}" class="absolute inset-y-0 right-0 flex items-center pr-2.5 text-gray-400 hover:text-gray-600">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </a>
                                @endif
                            </div>
                            <button type="submit" class="px-3 py-1.5 bg-indigo-600 text-white text-xs font-semibold rounded-lg hover:bg-indigo-700 transition-colors">Cari</button>
                        </form>

                        {{-- ── PDF Export Dropdown ────────────────────────── --}}
                        <div class="relative" x-data="{ pdfOpen: false }">
                            <button @click="pdfOpen = !pdfOpen" @click.outside="pdfOpen = false"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 border border-gray-200 bg-white text-gray-600 text-xs font-semibold rounded-lg hover:bg-red-50 hover:border-red-200 hover:text-red-600 transition-all">
                                <svg class="w-3.5 h-3.5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                Ekspor PDF
                                <svg class="w-3 h-3 text-gray-400 transition-transform duration-150" :class="pdfOpen ? 'rotate-180' : ''"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="pdfOpen"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="opacity-0 translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 translate-y-1"
                                 class="absolute right-0 mt-1.5 w-52 bg-white border border-gray-100 rounded-xl shadow-xl z-30 overflow-hidden">

                                <div class="px-3 py-2 bg-gray-50 border-b border-gray-100">
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Pilih Kelas untuk Ekspor</p>
                                </div>

                                {{-- All classes --}}
                                <a href="{{ route('admin.siswa.download') }}"
                                   class="flex items-center gap-2.5 px-3 py-2.5 text-xs font-semibold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors border-b border-gray-50">
                                    <span class="w-5 h-5 rounded-md bg-indigo-100 text-indigo-600 flex items-center justify-center flex-shrink-0 font-black text-[10px]">✦</span>
                                    Semua Kelas
                                </a>

                                {{-- Per kelas --}}
                                @foreach($kelas as $k)
                                    <a href="{{ route('admin.siswa.download', ['kelas_id' => $k->id]) }}"
                                       class="flex items-center gap-2.5 px-3 py-2.5 text-xs font-semibold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors border-b border-gray-50 last:border-0">
                                        <span class="w-5 h-5 rounded-md bg-gray-100 text-gray-500 flex items-center justify-center flex-shrink-0 font-black text-[10px]">
                                            {{ strtoupper(substr($k->name, 0, 1)) }}
                                        </span>
                                        Kelas {{ $k->name }}
                                    </a>
                                @endforeach

                            </div>
                        </div>
                        {{-- ── End PDF Dropdown ── --}}

                        <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'tambahSiswaModal')">
                            + Tambah Siswa
                        </x-primary-button>
                    </div>
                </div>

                @if(request('search'))
                    <div class="px-5 py-2 bg-indigo-50 border-b border-indigo-100 flex items-center justify-between">
                        <p class="text-xs text-indigo-700">
                            Hasil pencarian untuk <span class="font-bold">"{{ request('search') }}"</span>
                            — ditemukan <span class="font-bold">{{ $siswa->total() }}</span> siswa
                        </p>
                        <a href="{{ route('admin.siswa') }}" class="text-xs text-indigo-500 hover:text-indigo-700 font-semibold">Hapus pencarian ✕</a>
                    </div>
                @endif

                {{-- Kelas Tabs --}}
                <div class="px-5 pt-2.5 flex flex-wrap gap-0.5 border-b border-gray-100">
                    <button @click="activeTab = 'semua'"
                        :class="activeTab === 'semua' ? 'border-b-2 border-indigo-600 text-indigo-600 font-bold' : 'text-gray-400 hover:text-gray-600'"
                        class="pb-2 px-2.5 text-[11px] uppercase tracking-widest font-medium transition-colors">
                        Semua <span class="opacity-50">({{ $siswa->total() }})</span>
                    </button>
                    @foreach ($kelas as $k)
                        <button @click="activeTab = '{{ $k->id }}'"
                            :class="activeTab === '{{ $k->id }}' ? 'border-b-2 border-indigo-600 text-indigo-600 font-bold' : 'text-gray-400 hover:text-gray-600'"
                            class="pb-2 px-2.5 text-[11px] uppercase tracking-widest font-medium transition-colors">
                            {{ $k->name }} <span class="opacity-50">({{ $k->siswa->count() }})</span>
                        </button>
                    @endforeach
                </div>

                {{-- Status Filter Pills --}}
                <div class="px-5 py-2.5 flex flex-wrap gap-2 bg-gray-50/30 border-b border-gray-100">
                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest self-center mr-1">Status:</span>
                    <button @click="statusFilter = 'semua'"
                        :class="statusFilter === 'semua' ? 'bg-gray-700 text-white border-gray-700' : 'bg-white text-gray-500 border-gray-200 hover:border-gray-400'"
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold border transition-all">Semua</button>
                    <button @click="statusFilter = 'pending'"
                        :class="statusFilter === 'pending' ? 'bg-amber-500 text-white border-amber-500' : 'bg-white text-amber-600 border-amber-200 hover:border-amber-400'"
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold border transition-all">
                        <span class="w-1.5 h-1.5 rounded-full" :class="statusFilter === 'pending' ? 'bg-white' : 'bg-amber-400'"></span>
                        Menunggu <span class="opacity-70">({{ $pendingCount }})</span>
                    </button>
                    <button @click="statusFilter = 'verified'"
                        :class="statusFilter === 'verified' ? 'bg-emerald-500 text-white border-emerald-500' : 'bg-white text-emerald-600 border-emerald-200 hover:border-emerald-400'"
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold border transition-all">
                        <span class="w-1.5 h-1.5 rounded-full" :class="statusFilter === 'verified' ? 'bg-white' : 'bg-emerald-400'"></span>
                        Terverifikasi <span class="opacity-70">({{ $verifiedCount }})</span>
                    </button>
                    <button @click="statusFilter = 'rejected'"
                        :class="statusFilter === 'rejected' ? 'bg-rose-500 text-white border-rose-500' : 'bg-white text-rose-600 border-rose-200 hover:border-rose-400'"
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold border transition-all">
                        <span class="w-1.5 h-1.5 rounded-full" :class="statusFilter === 'rejected' ? 'bg-white' : 'bg-rose-400'"></span>
                        Ditolak <span class="opacity-70">({{ $rejectedCount }})</span>
                    </button>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left text-gray-500">
                        <thead class="text-[10px] text-gray-400 uppercase bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-4 py-2.5 font-black tracking-widest w-8">#</th>
                                <th class="px-4 py-2.5 font-black tracking-widest">Siswa</th>
                                <th class="px-4 py-2.5 font-black tracking-widest">Kelas</th>
                                <th class="px-4 py-2.5 font-black tracking-widest">Lahir / Umur</th>
                                <th class="px-4 py-2.5 font-black tracking-widest">Orang Tua</th>
                                <th class="px-4 py-2.5 font-black tracking-widest text-center">Bayar</th>
                                <th class="px-4 py-2.5 font-black tracking-widest text-center">Status</th>
                                <th class="px-4 py-2.5 font-black tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse ($siswa as $index => $g)
                                @php
                                    $bayarStatus   = optional($g->bayar)->status;
                                    $isLunas       = $bayarStatus === 'Lunas';
                                    $isLaki        = $g->jenis_kelamin === 'Laki-laki';
                                    $regStatus     = $g->status ?? 'Pending';
                                    $isVerified    = $regStatus === 'Verified';
                                    $isRejected    = $regStatus === 'Rejected';
                                    $siswaDispatch = json_encode([
                                        'id'            => $g->id,
                                        'nama'          => $g->nama,
                                        'nis'           => $g->nis,
                                        'alamat'        => $g->alamat,
                                        'jenis_kelamin' => $g->jenis_kelamin,
                                        'tanggal_lahir' => $g->tanggal_lahir,
                                        'orang_tua_id'  => $g->orang_tua_id,
                                        'kelas_id'      => $g->kelas_id,
                                    ]);
                                @endphp
                                <tr class="hover:bg-gray-50/70 transition-colors"
                                    x-show="
                                        (activeTab === 'semua' || activeTab === '{{ $g->kelas_id ?? '' }}') &&
                                        (statusFilter === 'semua' ||
                                         (statusFilter === 'pending'  && '{{ $regStatus }}' !== 'Verified' && '{{ $regStatus }}' !== 'Rejected') ||
                                         (statusFilter === 'verified' && '{{ $regStatus }}' === 'Verified') ||
                                         (statusFilter === 'rejected' && '{{ $regStatus }}' === 'Rejected'))
                                    ">

                                    <td class="px-4 py-2.5 text-gray-300 font-mono text-[10px]">{{ sprintf('%02d', $siswa->firstItem() + $index) }}</td>

                                    <td class="px-4 py-2.5">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-full flex items-center justify-center font-bold text-[11px] flex-shrink-0 {{ $isLaki ? 'bg-blue-100 text-blue-600' : 'bg-pink-100 text-pink-500' }}">
                                                {{ strtoupper(substr($g->nama, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800 text-xs leading-tight">{{ $g->nama }}</p>
                                                <p class="text-[10px] text-gray-400 leading-tight">
                                                    <span class="{{ $isLaki ? 'text-blue-500' : 'text-pink-400' }}">{{ $isLaki ? '♂' : '♀' }}</span>
                                                    &nbsp;{{ $g->nis }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-4 py-2.5">
                                        <span class="px-2 py-0.5 bg-indigo-50 text-indigo-700 rounded text-[10px] font-bold">{{ $g->kelas->name ?? '—' }}</span>
                                    </td>

                                    <td class="px-4 py-2.5">
                                        <p class="text-gray-600 text-[11px] leading-tight">{{ \Carbon\Carbon::parse($g->tanggal_lahir)->format('d M Y') }}</p>
                                        <p class="text-[10px] text-gray-400 leading-tight">{{ \Carbon\Carbon::parse($g->tanggal_lahir)->age }} tahun</p>
                                    </td>

                                    <td class="px-4 py-2.5">
                                        <a href="{{ route('admin.orang-tua') . '?search=' . urlencode($g->orangTua->name ?? '') }}">
                                            <p class="text-[11px] text-gray-700 font-medium leading-tight">{{ $g->orangTua->name ?? '—' }}</p>
                                        </a>
                                    </td>

                                    <td class="px-4 py-2.5 text-center">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold border
                                            @if($isLunas) bg-emerald-50 text-emerald-700 border-emerald-100
                                            @elseif($bayarStatus) bg-yellow-50 text-yellow-700 border-yellow-100
                                            @else bg-gray-100 text-gray-400 border-gray-200 @endif">
                                            {{ $isLunas ? 'Lunas' : ($bayarStatus ?? '—') }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-2.5 text-center">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold border
                                            @if($isVerified) bg-emerald-50 text-emerald-700 border-emerald-100
                                            @elseif($isRejected) bg-rose-50 text-rose-700 border-rose-100
                                            @else bg-amber-50 text-amber-700 border-amber-100 @endif">
                                            @if($isVerified) ✓ Verified
                                            @elseif($isRejected) ✕ Ditolak
                                            @else ⏳ Pending @endif
                                        </span>
                                    </td>

                                    <td class="px-4 py-2.5">
                                        <div class="flex justify-end items-center gap-1">
                                            @if(!$isVerified)
                                                <form action="{{ route('admin.siswa.verify', $g->id) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <button type="submit" title="Verifikasi"
                                                        class="w-7 h-7 flex items-center justify-center rounded-lg border border-gray-200 bg-white text-emerald-600 hover:bg-emerald-50 hover:border-emerald-300 transition-all">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                    </button>
                                                </form>
                                            @endif
                                            @if(!$isRejected)
                                                <form action="{{ route('admin.siswa.reject', $g->id) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <button type="submit" title="Tolak"
                                                        class="w-7 h-7 flex items-center justify-center rounded-lg border border-gray-200 bg-white text-rose-500 hover:bg-rose-50 hover:border-rose-300 transition-all">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                                    </button>
                                                </form>
                                            @endif
                                            <button title="Edit" x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'editSiswaModal')"
                                                @click="$dispatch('set-siswa-data', {{ $siswaDispatch }})"
                                                class="w-7 h-7 flex items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-300 transition-all">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </button>
                                            <button title="Hapus" x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'deleteSiswaModal')"
                                                @click="$dispatch('set-siswa-data', { id: {{ $g->id }}, nama: {{ json_encode($g->nama) }} })"
                                                class="w-7 h-7 flex items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-300 transition-all">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            </div>
                                            <p class="text-sm text-gray-400 font-medium">Tidak ada data siswa</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-5 py-3 border-t border-gray-100">{{ $siswa->links() }}</div>

            </div>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <x-modal name="tambahSiswaModal" focusable>
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tambah Data Siswa</h3>
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
                        <select name="jenis_kelamin" id="jenis_kelamin" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
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
                        <select name="orang_tua_id" id="orang_tua_id" required class="mt-1 p-2.5 w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 text-sm">
                            <option value="">Pilih Orang Tua</option>
                            @foreach ($orangTua as $ortu)
                                <option value="{{ $ortu->id }}">{{ $ortu->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label for="kelas_id" value="{{ __('Kelas') }}" />
                        <select name="kelas_id" id="kelas_id" required class="mt-1 p-2.5 w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 text-sm">
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
    </x-modal>

    {{-- Modal Edit --}}
    <x-modal name="editSiswaModal" focusable>
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Edit Data Siswa</h3>
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
    </x-modal>

    {{-- Modal Hapus --}}
    <x-modal name="deleteSiswaModal" focusable>
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Hapus Data Siswa</h3>
            <form x-data="{ siswaData: {} }" @set-siswa-data.window="siswaData = $event.detail"
                x-bind:action="'/admin/siswa/' + siswaData.id" method="POST" class="space-y-4">
                @csrf
                @method('DELETE')
                <div class="flex items-start gap-3 p-4 bg-rose-50 rounded-xl border border-rose-100">
                    <svg class="w-5 h-5 text-rose-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <p class="text-sm text-rose-700">Yakin ingin menghapus siswa <strong x-text="siswaData.nama"></strong>? Data tidak dapat dipulihkan.</p>
                </div>
                <div class="flex justify-end gap-2">
                    <x-secondary-button type="button" x-on:click="$dispatch('close')">Batal</x-secondary-button>
                    <x-danger-button>Hapus</x-danger-button>
                </div>
            </form>
        </div>
    </x-modal>

    @if (session('success'))
        <div class="fixed bottom-4 right-4 bg-emerald-500 text-white px-5 py-3 rounded-xl shadow-lg z-50 text-sm"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="fixed bottom-4 right-4 bg-rose-500 text-white px-5 py-3 rounded-xl shadow-lg z-50 text-sm"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">{{ session('error') }}</div>
    @endif

</x-app-layout>