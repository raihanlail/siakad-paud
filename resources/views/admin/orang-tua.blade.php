<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Orang Tua') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                {{-- Card Header --}}
                <div class="px-5 py-3.5 border-b border-gray-100 bg-gray-50/40 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-bold text-gray-800 text-sm">Daftar Orang Tua / Wali</h3>
                        <p class="text-[11px] text-gray-400 mt-0.5">
                            Total <span class="font-bold text-gray-600">{{ $orangTua->total() }}</span> orang tua terdaftar
                        </p>
                    </div>

                    {{-- Search --}}
                    <form method="GET" action="{{ route('admin.orang-tua') }}" class="flex items-center gap-1.5">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z"/>
                                </svg>
                            </div>
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari nama, email, atau no. telp..."
                                class="pl-8 pr-8 py-1.5 text-xs border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white w-60 transition-all"
                            />
                            @if(request('search'))
                                <a href="{{ route('admin.orang-tua') }}" class="absolute inset-y-0 right-0 flex items-center pr-2.5 text-gray-400 hover:text-gray-600">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                        <button type="submit" class="px-3 py-1.5 bg-indigo-600 text-white text-xs font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                            Cari
                        </button>
                    </form>
                </div>

                {{-- Search result notice --}}
                @if(request('search'))
                    <div class="px-5 py-2 bg-indigo-50 border-b border-indigo-100 flex items-center justify-between">
                        <p class="text-xs text-indigo-700">
                            Hasil pencarian untuk <span class="font-bold">"{{ request('search') }}"</span>
                            — ditemukan <span class="font-bold">{{ $orangTua->total() }}</span> orang tua
                        </p>
                        <a href="{{ route('admin.orang-tua') }}" class="text-xs text-indigo-500 hover:text-indigo-700 font-semibold">
                            Hapus pencarian ✕
                        </a>
                    </div>
                @endif

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left text-gray-500">
                        <thead class="text-[10px] text-gray-400 uppercase bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-4 py-2.5 font-black tracking-widest w-8">#</th>
                                <th class="px-4 py-2.5 font-black tracking-widest">Nama</th>
                                <th class="px-4 py-2.5 font-black tracking-widest">Email</th>
                                <th class="px-4 py-2.5 font-black tracking-widest">No. Telepon</th>
                                <th class="px-4 py-2.5 font-black tracking-widest">Alamat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse ($orangTua as $index => $g)
                                <tr class="hover:bg-gray-50/70 transition-colors">
                                    <td class="px-4 py-2.5 text-gray-300 font-mono text-[10px]">
                                        {{ sprintf('%02d', $orangTua->firstItem() + $index) }}
                                    </td>
                                    <td class="px-4 py-2.5">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-[11px] flex-shrink-0">
                                                {{ strtoupper(substr($g->nama, 0, 1)) }}
                                            </div>
                                            <p class="font-semibold text-gray-800 text-xs leading-tight">{{ $g->nama }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2.5 text-gray-600">{{ $g->email }}</td>
                                    <td class="px-4 py-2.5 text-gray-600">{{ $g->phone ?? '—' }}</td>
                                    <td class="px-4 py-2.5 text-gray-600 max-w-xs truncate">{{ $g->alamat ?? '—' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                            </div>
                                            <p class="text-sm text-gray-400 font-medium">
                                                @if(request('search'))
                                                    Tidak ada orang tua yang cocok dengan "{{ request('search') }}"
                                                @else
                                                    Tidak ada data orang tua
                                                @endif
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-5 py-3 border-t border-gray-100">
                    {{ $orangTua->links() }}
                </div>

            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="fixed bottom-4 right-4 bg-emerald-500 text-white px-5 py-3 rounded-xl shadow-lg z-50 text-sm"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
            {{ session('success') }}
        </div>
    @endif

</x-app-layout>