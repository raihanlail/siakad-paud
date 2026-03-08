<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Data Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Stats --}}
            @php
                $all      = $pembayaran->getCollection();
                $lunas    = $all->where('status', 'Lunas')->count();
                $belum    = $all->where('status', 'Belum')->count();
                $sebagian = $all->filter(fn($p) => !in_array($p->status, ['Lunas','Belum']))->count();
                $adaBukti = $all->whereNotNull('bukti')->where('bukti', '!=', '')->count();
            @endphp

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Lunas</p>
                        <p class="text-2xl font-black text-emerald-600">{{ $lunas }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-yellow-100 text-yellow-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Sebagian</p>
                        <p class="text-2xl font-black text-yellow-500">{{ $sebagian }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Belum Bayar</p>
                        <p class="text-2xl font-black text-rose-500">{{ $belum }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Ada Bukti</p>
                        <p class="text-2xl font-black text-blue-600">{{ $adaBukti }}</p>
                    </div>
                </div>
            </div>

            {{-- Table Card --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/40">
                    <div>
                        <h3 class="font-bold text-gray-800 text-sm">Daftar Pembayaran Siswa</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Total {{ $pembayaran->total() }} data pembayaran</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-[10px] text-gray-400 uppercase bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-4 py-3 font-black tracking-widest w-8">#</th>
                                <th class="px-4 py-3 font-black tracking-widest">Nama Siswa</th>
                                <th class="px-4 py-3 font-black tracking-widest">Jenis</th>
                                <th class="px-4 py-3 font-black tracking-widest text-right">Jumlah</th>
                                <th class="px-4 py-3 font-black tracking-widest text-center">Bukti</th>
                                <th class="px-4 py-3 font-black tracking-widest text-center">Status</th>
                                <th class="px-4 py-3 font-black tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse ($pembayaran as $index => $g)
                                @php
                                    $isLunas      = $g->status === 'Lunas';
                                    $isSebagian   = !in_array($g->status, ['Lunas', 'Belum']);
                                    $hasBukti     = !empty($g->bukti);
                                    $buktiUrl     = $hasBukti ? asset('bukti/' . $g->bukti) : '';
                                    $dispatchData = json_encode([
                                        'id'     => $g->id,
                                        'nama'   => $g->siswa->nama ?? '',
                                        'jenis'  => $g->jenis ?? '',
                                        'jumlah' => $g->jumlah ?? 0,
                                        'status' => $g->status ?? '',
                                        'bukti'  => $buktiUrl,
                                    ]);
                                    $buktiDispatch = json_encode([
                                        'src'   => $buktiUrl,
                                        'nama'  => $g->siswa->nama ?? '',
                                        'jenis' => $g->jenis ?? '',
                                    ]);
                                @endphp

                                <tr class="hover:bg-gray-50/60 transition-colors">

                                    <td class="px-4 py-3 text-gray-300 font-mono text-[10px]">
                                        {{ sprintf('%02d', $pembayaran->firstItem() + $index) }}
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-[11px] flex-shrink-0">
                                                {{ strtoupper(substr($g->siswa->nama ?? '?', 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800 text-xs leading-tight">{{ $g->siswa->nama ?? '-' }}</p>
                                                <p class="text-[10px] text-gray-400">NIS: {{ $g->siswa->nis ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3">
                                        <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-[10px] font-bold">
                                            {{ $g->jenis ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 text-right font-mono font-bold text-xs text-gray-700">
                                        Rp {{ number_format($g->jumlah ?? 0, 0, ',', '.') }}
                                    </td>

                                    {{-- Bukti --}}
                                    <td class="px-4 py-3 text-center">
                                        @if($hasBukti)
                                            <button
                                                x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'lihatBuktiModal')"
                                                @click="$dispatch('set-bukti-data', {{ $buktiDispatch }})"
                                                class="inline-flex items-center gap-1 px-2.5 py-1 bg-blue-50 text-blue-600 border border-blue-200 rounded-lg text-[10px] font-bold hover:bg-blue-100 transition-all">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                Lihat
                                            </button>
                                        @else
                                            <span class="text-[10px] text-gray-300 italic">—</span>
                                        @endif
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-4 py-3 text-center">
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $isLunas ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : ($isSebagian ? 'bg-yellow-50 text-yellow-700 border-yellow-100' : 'bg-rose-50 text-rose-700 border-rose-100') }}">
                                            {{ $g->status }}
                                        </span>
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-4 py-3 text-right">
                                        <button
                                            x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', 'editPembayaranModal')"
                                            @click="$dispatch('set-bayar-data', {{ $dispatchData }})"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[11px] font-semibold border transition-all {{ $isLunas ? 'bg-emerald-50 border-emerald-200 text-emerald-700 hover:bg-emerald-100' : 'bg-white border-gray-200 text-gray-600 hover:border-indigo-300 hover:text-indigo-600 hover:bg-indigo-50' }}">
                                            @if($isLunas)
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>
                                                Lunas
                                            @else
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                                Konfirmasi
                                            @endif
                                        </button>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
                                            </div>
                                            <p class="text-gray-400 text-sm font-medium">Tidak ada data pembayaran</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $pembayaran->links() }}
                </div>
            </div>

        </div>
    </div>

    {{-- ── Modal: Lihat Bukti ──────────────────────────────────────────── --}}
    <x-modal name="lihatBuktiModal" focusable>
        <div class="p-6" x-data="{ buktiData: { src: '', nama: '', jenis: '' } }"
             @set-bukti-data.window="buktiData = $event.detail">

            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="text-base font-bold text-gray-800">Bukti Pembayaran</h3>
                    <p class="text-xs text-gray-400 mt-0.5">
                        <span x-text="buktiData.nama"></span>
                        &nbsp;·&nbsp;
                        <span x-text="buktiData.jenis"></span>
                    </p>
                </div>
                <a :href="buktiData.src" target="_blank"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg text-xs font-semibold transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Buka Tab Baru
                </a>
            </div>

            <div class="rounded-xl overflow-hidden bg-gray-50 border border-gray-200 flex items-center justify-center min-h-64 relative">
                <img :src="buktiData.src"
                     alt="Bukti Pembayaran"
                     class="max-w-full max-h-96 object-contain"
                     x-on:error="$el.classList.add('hidden'); $refs.imgError.classList.remove('hidden')" />
                <div x-ref="imgError" class="hidden flex-col items-center gap-2 p-10 text-gray-400">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p class="text-sm font-medium">Gagal memuat gambar</p>
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <x-secondary-button x-on:click="$dispatch('close')">Tutup</x-secondary-button>
            </div>
        </div>
    </x-modal>

    {{-- ── Modal: Konfirmasi Pembayaran ────────────────────────────────── --}}
    <x-modal name="editPembayaranModal" focusable>
        <div class="p-6"
             x-data="{ bayarData: { id:'', nama:'', jenis:'', jumlah:0, status:'', bukti:'' } }"
             @set-bayar-data.window="bayarData = $event.detail">

            <h3 class="text-base font-bold text-gray-900 mb-4">Konfirmasi Pembayaran</h3>

            {{-- Bukti preview inside modal --}}
            <div x-show="bayarData.bukti"
                 class="mb-4 rounded-xl overflow-hidden border border-blue-100 bg-blue-50 p-3 flex items-center gap-3">
                <img :src="bayarData.bukti"
                     alt="Bukti"
                     class="w-16 h-16 rounded-lg object-cover border border-blue-200 flex-shrink-0 cursor-pointer"
                     @click="$dispatch('open-modal', 'lihatBuktiModal'); $dispatch('set-bukti-data', { src: bayarData.bukti, nama: bayarData.nama, jenis: bayarData.jenis })" />
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold text-blue-700">Bukti transfer tersedia</p>
                    <p class="text-[11px] text-blue-500 mt-0.5">Klik thumbnail untuk melihat ukuran penuh</p>
                </div>
                <a :href="bayarData.bukti" target="_blank"
                   class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>
            <div x-show="!bayarData.bukti"
                 class="mb-4 rounded-xl border border-dashed border-gray-200 bg-gray-50 p-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="text-[11px] text-gray-400 italic">Tidak ada bukti transfer yang dilampirkan</p>
            </div>

            <form x-bind:action="'/admin/pembayaran/' + bayarData.id" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <x-input-label value="Nama Siswa" />
                        <x-text-input type="text" class="mt-1 block w-full bg-gray-50 text-gray-500 text-sm"
                            x-bind:value="bayarData.nama" readonly />
                    </div>
                    <div>
                        <x-input-label value="Jumlah" />
                        <x-text-input type="text" class="mt-1 block w-full bg-gray-50 text-gray-500 text-sm font-mono"
                            x-bind:value="'Rp ' + Number(bayarData.jumlah).toLocaleString('id-ID')" readonly />
                    </div>
                </div>

                <div>
                    <x-input-label for="jenis" value="Jenis Pembayaran" />
                    <x-text-input id="jenis" name="jenis" type="text" class="mt-1 block w-full text-sm"
                        x-bind:value="bayarData.jenis" required />
                </div>

                <div>
                    <x-input-label for="status" value="Status Pembayaran" />
                    <select name="status" id="status" required
                        class="mt-1 p-2.5 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        <option value="Belum"                        x-bind:selected="bayarData.status === 'Belum'">Belum Bayar</option>
                        <option value="Pendaftaran Sudah, SPP belum" x-bind:selected="bayarData.status === 'Pendaftaran Sudah, SPP belum'">Pendaftaran Sudah, SPP Belum</option>
                        <option value="Lunas"                        x-bind:selected="bayarData.status === 'Lunas'">Lunas</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-gray-100">
                    <x-secondary-button type="button" x-on:click="$dispatch('close')">Batal</x-secondary-button>
                    <x-primary-button>Simpan</x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>

    @if(session('success'))
        <div class="fixed bottom-4 right-4 bg-emerald-500 text-white px-6 py-3 rounded-xl shadow-lg z-50 text-sm"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            {{ session('success') }}
        </div>
    @endif

</x-app-layout>