<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Mata Pelajaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Tombol Tambah Siswa -->
                    <x-primary-button 
                    x-data=""
                     x-on:click.prevent="$dispatch('open-modal', 'tambahMapelModal')"
                    
                     >
                     {{ __('Tambah Mapel') }}

                    </x-primary-button>

                    <!-- Tabel Data Siswa -->
                    <div class="relative overflow-x-auto pt-4">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 shadow-md sm:rounded-lg">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No</th>
                                    <th scope="col" class="px-6 py-3">Nama Mapel</th>
                                    <th scope="col" class="px-6 py-3">Kode</th>
                                    <th scope="col" class="px-6 py-3">Data Nilai</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($mapel as $index => $g)
                                    <tr class="bg-white border-b border-gray-200">
                                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4">{{ $g->nama }}</td>
                                        <td class="px-6 py-4">{{ $g->kode }}</td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('admin.nilai.perMapel', ['mata_pelajaran_id' => $g->id]) }}" class="text-blue-600 hover:text-blue-900">
                                                <x-secondary-button>
                                                    Lihat Nilai
                                                </x-secondary-button>
                                            </a>
                                        </td>
                                       
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b border-gray-200">
                                        <td colspan="5" class="px-6 py-4 text-center">Tidak ada data mapel</td>
                                    </tr>
                                @endforelse
                            </tbody>                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Siswa -->
    <x-modal name="tambahMapelModal" tabindex="-1" aria-hidden="true"
        >
        <div class="relative w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow-xl">
                <!-- Modal Header -->
                <div class="flex items-start justify-between p-6 border-b rounded-t bg-gray-50">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Tambah Data Mapel
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center transition-colors duration-200"
                        data-modal-hide="tambahSiswaModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <form action="{{ route('admin.mapel.store') }}" method="POST" class="w-full space-y-4">
                        @csrf
                        <!-- Input Nama -->
                        <div>
                            <x-input-label for="nama" value="{{ __('Nama') }}" />
                            <x-text-input
                                id="nama"
                                name="nama"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="{{ __('Masukkan Nama') }}"
                                required
                            />
                        </div>

                        <!-- Input NIS -->
                        <div>
                            <x-input-label for="kode" value="{{ __('Kode') }}" />
                            <x-text-input
                                id="kode"
                                name="kode"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="{{ __('Masukkan Kode') }}"
                                required
                            />
                        </div>

                        

                        <!-- Tombol Simpan -->
                        <div class="flex justify-end pt-4 border-t gap-2">
                            <x-secondary-button type="button"
                                x-on:click.prevent="$dispatch('close')"
                                >{{ __('Batal') }}</x-secondary-button>
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
        <div class="fixed bottom-4 right-4 bg-green-500 text-black px-6 py-3 rounded-lg shadow-lg"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            {{ session('success') }}
        </div>
    @endif

</x-app-layout>
