<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Data Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ── Stats Banner ──────────────────────────────────────────── --}}
            @php
                $all       = $pembayaran->getCollection();
                $lunas     = $all->where('status', 'Lunas')->count();
                $belum     = $all->where('status', 'Belum')->count();
                $sebagian  = $all->filter(fn($p) => !in_array($p->status, ['Lunas','Belum']))->count();
            @endphp
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Lunas</p>
                        <p class="text-2xl font-black text-emerald-600">{{ $lunas }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-yellow-100 text-yellow-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Sebagian</p>
                        <p class="text-2xl font-black text-yellow-500">{{ $sebagian }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Belum Bayar</p>
                        <p class="text-2xl font-black text-rose-500">{{ $belum }}</p>
                    </div>
                </div>
            </div>

            {{-- ── Table Card ─────────────────────────────────────────────── --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                {{-- Card Header --}}
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/40">
                    <div>
                        <h3 class="font-bold text-gray-800 text-sm">Daftar Pembayaran Siswa</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Total {{ $pembayaran->total() }} data pembayaran</p>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-3 font-black tracking-widest">No</th>
                                <th class="px-6 py-3 font-black tracking-widest">Nama Siswa</th>
                                <th class="px-6 py-3 font-black tracking-widest">Jenis Pembayaran</th>
                                <th class="px-6 py-3 font-black tracking-widest text-center">Status</th>
                                <th class="px-6 py-3 font-black tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse ($pembayaran as $index => $g)
                                @php
                                    $isLunas    = $g->status === 'Lunas';
                                    $isSebagian = !in_array($g->status, ['Lunas', 'Belum']);
                                    $isBelum    = $g->status === 'Belum';
                                @endphp
                                <tr class="hover:bg-gray-50/60 transition-colors">
                                    <td class="px-6 py-4 text-gray-400 font-mono text-xs">
                                        {{ sprintf('%02d', $pembayaran->firstItem() + $index) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs flex-shrink-0">
                                                {{ strtoupper(substr($g->siswa->nama ?? '?', 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800 leading-tight">{{ $g->siswa->nama ?? '-' }}</p>
                                                <p class="text-[11px] text-gray-400">NIS: {{ $g->siswa->nis ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold">
                                            {{ $g->jenis ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold border
                                            @if($isLunas) bg-emerald-50 text-emerald-700 border-emerald-100
                                            @elseif($isSebagian) bg-yellow-50 text-yellow-700 border-yellow-100
                                            @else bg-rose-50 text-rose-700 border-rose-100
                                            @endif">
                                            {{ $g->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', 'editPembayaranModal')"
                                            @click="$dispatch('set-bayar-data', {
                                                id: '{{ $g->id }}',
                                                nama: '{{ $g->siswa->nama }}',
                                                jenis: '{{ $g->jenis }}',
                                                status: '{{ $g->status }}'
                                            })"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold border transition-all
                                                @if($isLunas)
                                                    bg-emerald-50 border-emerald-200 text-emerald-700 hover:bg-emerald-100
                                                @else
                                                    bg-white border-gray-200 text-gray-600 hover:border-indigo-300 hover:text-indigo-600 hover:bg-indigo-50
                                                @endif">
                                            @if($isLunas)
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                                                </svg>
                                                Lunas
                                            @else
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                </svg>
                                                Konfirmasi
                                            @endif
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <p class="text-gray-400 text-sm font-medium">Tidak ada data pembayaran</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $pembayaran->links() }}
                </div>
            </div>

        </div>
    </div>

    {{-- ── Modal Konfirmasi ─────────────────────────────────────────────── --}}
    <x-modal name="editPembayaranModal" focusable>
        <div class="relative w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow-xl">
                <!-- Modal Header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Konfirmasi Pembayaran
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                        x-on:click="$dispatch('close')">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <form x-data="{ bayarData: {} }" @set-bayar-data.window="bayarData = $event.detail"
                        x-bind:action="'/admin/pembayaran/' + bayarData.id" method="POST" class="w-full space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <x-input-label for="jenis" value="{{ __('Jenis') }}" />
                            <x-text-input id="jenis" name="jenis" type="text" class="mt-1 block w-full"
                                x-bind:value="bayarData.jenis" required  />
                        </div>

                        <div>
                            <x-input-label for="status" value="{{ __('Status') }}" />
                            <select name="status" id="status" required
                                class="mt-1 p-2.5 w-full border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                x-bind:value="bayarData.status">
                                <option value="Belum">Belum</option>
                                <option value="Pendaftaran Sudah, SPP belum">Pendaftaran Sudah, SPP belum</option>
                                <option value="Lunas">Lunas</option>
                            </select>
                        </div>

                        <div class="flex justify-end pt-4 border-t gap-2">
                            <x-secondary-button type="button"
                                x-on:click="$dispatch('close')">{{ __('Batal') }}</x-secondary-button>
                            <x-primary-button>
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-modal>

    @if (session('success'))
        <div class="fixed bottom-4 right-4 bg-emerald-500 text-white px-6 py-3 rounded-lg shadow-lg z-50"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            {{ session('success') }}
        </div>
    @endif

</x-app-layout>