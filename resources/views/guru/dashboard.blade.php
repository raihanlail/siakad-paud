<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Dashboard Guru') }}
        </h2>
    </x-slot>

    <div class="space-y-6">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex flex-col justify-between relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 text-blue-50 opacity-10 group-hover:scale-110 transition-transform duration-500">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-slate-500 text-sm font-bold uppercase tracking-widest">{{ __("Selamat Datang") }}</h3>
                            <p class="text-2xl font-extrabold text-slate-800 mt-1">{{ $user->name }}</p>
                        </div>
                        <div class="bg-blue-50 border border-blue-100 px-4 py-2 rounded-xl text-right">
                            <span class="block text-[10px] font-bold text-blue-400 uppercase tracking-tighter">NIP Guru</span>
                            <span class="text-blue-700 font-mono font-bold">{{ $guru->nip }}</span>
                        </div>
                    </div>
                    <div class="mt-8 flex items-center p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <div class="p-3 bg-blue-600 rounded-lg text-white mr-4 shadow-md shadow-blue-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <div>
                            <p class="text-sm text-slate-600">Mata Pelajaran Aktif:</p>
                            <p class="font-bold text-slate-800">{{ $mapel[0]->nama }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl shadow-lg shadow-blue-200 p-6 text-white flex flex-col justify-center items-center text-center">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mb-4 backdrop-blur-md">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </div>
                <h4 class="font-bold text-lg leading-tight mb-2">Manajemen Nilai</h4>
                <p class="text-blue-100 text-xs mb-6 px-4">Input nilai siswa terbaru untuk mata pelajaran {{ $mapel[0]->nama }} secara instan.</p>
                <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'tambahNilaiModal')"
                    class="w-full py-3 bg-white text-blue-700 rounded-xl font-bold text-sm shadow-sm hover:bg-blue-50 transition active:scale-95">
                    {{ __('Tambah Nilai Siswa') }}
                </button>
            </div>
        </div>

        {{-- Nilai Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden" x-data="{ activeTab: 'semua' }">

            {{-- Table Header --}}
            <div class="px-8 py-5 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center bg-slate-50/30 gap-4">
                <div>
                    <h3 class="font-bold text-slate-800 text-base">{{ __('Daftar Nilai Siswa') }}</h3>
                    <p class="text-xs text-slate-500 font-medium">Pengelolaan nilai akademik siswa per mata pelajaran</p>
                </div>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">

                    {{-- Search --}}
                    <form method="GET" action="{{ route('guru.dashboard') }}" class="flex items-center gap-1.5">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z"/>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari nama atau NIS..."
                                class="pl-8 pr-8 py-1.5 text-xs border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white w-48 transition-all"/>
                            @if(request('search'))
                                <a href="{{ route('guru.dashboard') }}" class="absolute inset-y-0 right-0 flex items-center pr-2.5 text-slate-400 hover:text-slate-600">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                        <button type="submit" class="px-3 py-1.5 bg-blue-600 text-white text-xs font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                            Cari
                        </button>
                    </form>

                    <div class="hidden md:flex flex-col items-end">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Populasi Data</span>
                        <span class="text-blue-600 font-bold text-sm">{{ count($nilai) }} Siswa</span>
                    </div>

                    <a href="{{ route('guru.download') }}" class="group">
                        <x-secondary-button class="rounded-xl border-slate-200 hover:bg-slate-50 font-bold text-xs py-2.5 shadow-sm transition-all group-hover:border-blue-300 group-hover:text-blue-600">
                            <svg class="h-4 w-4 mr-2 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                            </svg>
                            {{ __('Unduh PDF') }}
                        </x-secondary-button>
                    </a>
                </div>
            </div>

            {{-- Search result notice --}}
            @if(request('search'))
                <div class="px-8 py-2 bg-blue-50 border-b border-blue-100 flex items-center justify-between">
                    <p class="text-xs text-blue-700">
                        Hasil pencarian untuk <span class="font-bold">"{{ request('search') }}"</span>
                        — ditemukan <span class="font-bold">{{ count($nilai) }}</span> data nilai
                    </p>
                    <a href="{{ route('guru.dashboard') }}" class="text-xs text-blue-500 hover:text-blue-700 font-semibold">
                        Hapus pencarian ✕
                    </a>
                </div>
            @endif

            {{-- Kelas Tab Buttons --}}
            <div class="px-8 pt-4 pb-0 flex flex-wrap gap-2 border-b border-slate-100">
                <button @click="activeTab = 'semua'"
                    :class="activeTab === 'semua' ? 'border-b-2 border-blue-600 text-blue-600 font-black' : 'text-slate-400 hover:text-slate-600'"
                    class="pb-3 px-1 text-xs uppercase tracking-widest font-bold transition-colors duration-150">
                    Semua <span class="ml-1 text-[10px] opacity-60">({{ count($nilai) }})</span>
                </button>
                @foreach ($kelas as $k)
                    @php $kelasNilaiCount = $nilai->filter(fn($n) => $n->siswa && $n->siswa->kelas_id == $k->id)->count(); @endphp
                    <button @click="activeTab = '{{ $k->id }}'"
                        :class="activeTab === '{{ $k->id }}' ? 'border-b-2 border-blue-600 text-blue-600 font-black' : 'text-slate-400 hover:text-slate-600'"
                        class="pb-3 px-1 text-xs uppercase tracking-widest font-bold transition-colors duration-150">
                        {{ $k->name }} <span class="ml-1 text-[10px] opacity-60">({{ $kelasNilaiCount }})</span>
                    </button>
                @endforeach
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">No</th>
                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Informasi Siswa</th>
                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Kelas</th>
                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">Nilai</th>
                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">Status</th>
                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($nilai as $index => $g)
                            <tr class="hover:bg-blue-50/30 transition-colors group"
                                x-show="activeTab === 'semua' || activeTab === '{{ $g->siswa->kelas_id ?? '' }}'">
                                <td class="px-8 py-5">
                                    <span class="text-slate-400 font-mono text-xs">{{ sprintf('%02d', $index + 1) }}</span>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="font-bold text-slate-700 leading-tight">
                                        @if(request('search'))
                                            {!! preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<mark class="bg-yellow-100 text-yellow-800 rounded px-0.5">$1</mark>', e($g->siswa->nama ?? '-')) !!}
                                        @else
                                            {{ $g->siswa->nama ?? '-' }}
                                        @endif
                                    </div>
                                    <div class="flex items-center mt-1">
                                        <span class="text-[10px] bg-slate-100 text-slate-500 px-1.5 py-0.5 rounded font-bold uppercase mr-2">
                                            NIS: @if(request('search')){!! preg_replace('/(' . preg_quote(request('search'), '/') . ')/i', '<mark class="bg-yellow-100 text-yellow-800 rounded px-0.5">$1</mark>', e($g->siswa->nis ?? '-')) !!}@else{{ $g->siswa->nis ?? '-' }}@endif
                                        </span>
                                        <span class="text-[10px] text-blue-500 font-bold uppercase tracking-tighter">{{ $g->mataPelajaran->nama ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 rounded text-[10px] font-bold uppercase tracking-wide">
                                        {{ $g->siswa->kelas->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <span class="text-base font-black {{ $g->nilai >= 75 ? 'text-blue-600' : 'text-rose-500' }}">
                                        {{ $g->nilai }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider
                                        {{ $g->nilai >= 75 ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-rose-50 text-rose-600 border border-rose-100' }}">
                                        {{ $g->nilai >= 75 ? 'Tuntas' : 'Remedial' }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'editNilaiModal')"
                                        @click="$dispatch('set-nilai-data', {
                                            id: '{{ $g->id }}',
                                            nama: '{{ $g->siswa->nama }}',
                                            siswa_id: '{{ $g->siswa->id }}',
                                            mapel: '{{ $g->mataPelajaran->nama }}',
                                            mapel_id: '{{ $g->mataPelajaran->id }}',
                                            nilai: '{{ $g->nilai }}'
                                        })"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-blue-600 hover:border-blue-200 hover:shadow-sm transition-all"
                                        title="Edit Nilai">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                        </div>
                                        <p class="font-bold text-slate-400 uppercase tracking-widest text-[10px]">
                                            @if(request('search'))
                                                Tidak ada nilai untuk "{{ request('search') }}"
                                            @else
                                                {{ __('Belum Ada Data Nilai Masuk') }}
                                            @endif
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Nilai --}}
    <x-modal name="tambahNilaiModal" focusable>
        <div class="p-8">
            <h3 class="text-xl font-bold text-slate-800 mb-6">{{ __('Tambah Nilai Siswa') }}</h3>
            <form action="{{ route('guru.dashboard.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <x-input-label for="siswa_id" value="{{ __('Nama Siswa') }}" class="font-bold text-xs uppercase text-slate-500" />
                    <select name="siswa_id" id="siswa_id" required class="mt-1 block w-full rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        <option value="">{{ __('Pilih Siswa...') }}</option>
                        @foreach ($kelas as $k)
                            <optgroup label="{{ $k->name }}">
                                @foreach ($k->siswa as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="nilai" value="{{ __('Nilai') }}" class="font-bold text-xs uppercase text-slate-500" />
                        <x-text-input id="nilai" name="nilai" type="number" class="mt-1 block w-full rounded-xl shadow-sm" placeholder="0-100" required />
                    </div>
                    <div>
                        <x-input-label value="{{ __('Mata Pelajaran') }}" class="font-bold text-xs uppercase text-slate-500" />
                        <input type="hidden" name="mata_pelajaran_id" value="{{ $mapel[0]->id }}">
                        <x-text-input type="text" class="mt-1 block w-full bg-slate-50 rounded-xl text-slate-500 font-bold" value="{{ $mapel[0]->nama }}" readonly />
                    </div>
                </div>
                <div class="flex justify-end space-x-3 pt-6 border-t border-slate-100">
                    <x-secondary-button x-on:click="$dispatch('close')" class="rounded-xl border-none shadow-none uppercase font-bold text-xs tracking-widest">{{ __('Batal') }}</x-secondary-button>
                    <x-primary-button class="rounded-xl bg-blue-600 hover:bg-blue-700 px-8 py-3 shadow-lg shadow-blue-200 uppercase font-bold text-xs tracking-widest">{{ __('Simpan') }}</x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>

    {{-- Modal Edit Nilai --}}
    <x-modal name="editNilaiModal" focusable>
        <div class="p-8">
            <h3 class="text-xl font-bold text-slate-800 mb-6">{{ __('Edit Nilai Siswa') }}</h3>
            <form x-data="{ nilaiData: {} }" @set-nilai-data.window="nilaiData = $event.detail" x-bind:action="'/guru/dashboard/' + nilaiData.id" method="POST" class="space-y-5">
                @csrf @method('PUT')
                <div>
                    <x-input-label value="{{ __('Nama Siswa') }}" class="font-bold text-xs uppercase text-slate-500" />
                    <x-text-input x-bind:value="nilaiData.nama" class="mt-1 block w-full bg-slate-50 text-slate-500 font-bold rounded-xl" readonly />
                    <input type="hidden" name="siswa_id" x-bind:value="nilaiData.siswa_id">
                </div>
                <div>
                    <x-input-label for="nilai_edit" value="{{ __('Update Nilai') }}" class="font-bold text-xs uppercase text-slate-500" />
                    <x-text-input id="nilai_edit" name="nilai" type="number" x-bind:value="nilaiData.nilai" class="mt-1 block w-full rounded-xl" required />
                </div>
                <input type="hidden" name="mata_pelajaran_id" x-bind:value="nilaiData.mapel_id">
                <div class="flex justify-end space-x-3 pt-6 border-t border-slate-100">
                    <x-secondary-button x-on:click="$dispatch('close')" class="rounded-xl border-none uppercase font-bold text-xs tracking-widest">{{ __('Batal') }}</x-secondary-button>
                    <x-primary-button class="rounded-xl bg-indigo-600 hover:bg-indigo-700 px-8 py-3 uppercase font-bold text-xs tracking-widest">{{ __('Update') }}</x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>

</x-app-layout>