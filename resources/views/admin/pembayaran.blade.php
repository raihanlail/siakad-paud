<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Data Pembayaran') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 text-gray-900">
                <div class="relative overflow-x-auto pt-4">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 shadow-md sm:rounded-lg">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">No</th>
                                <th scope="col" class="px-6 py-3">Nama</th>
                                <th scope="col" class="px-6 py-3">Jenis</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Bukti</th>
                                <th scope="col" class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pembayaran as $index => $g)
                                <tr class="bg-white border-b border-gray-200">
                                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4">{{ $g->siswa->nama ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $g->jenis ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $g->status }}</td>
                                    <td class="px-6 py-4">
                                        <img src="{{ Storage::url('bukti/' . $g->bukti) }}" class="w-20 h-20 object-cover rounded" />
                                        </td>
                                    <td class="px-6 py-4 flex flex-row gap-4 ">
                                       <x-secondary-button x-data=""
                                       x-on:click.prevent="$dispatch('open-modal', 'editPembayaranModal')"
                                       @click="
                                       $dispatch('set-bayar-data', {
                                           id: '{{ $g->id }}',
                                           nama: '{{ $g->siswa->nama }}',
                                           jenis: '{{ $g->jenis }}',
                                           status: '{{ $g->status }}'
                                       })
                                   ">
                                        {{ __('Konfirmasi') }}
                                       </x-secondary-button>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white border-b border-gray-200">
                                    <td colspan="5" class="px-6 py-4 text-center">Tidak ada data nilai siswa</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $pembayaran->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

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
</x-app-layout>