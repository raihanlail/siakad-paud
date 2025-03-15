<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Guru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
           
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <div class="flex flex-col sm:flex-row justify-between items-center">
                    <div class="py-4 text-gray-900 mb-4 sm:mb-0">
                        <span class="text-xl font-semibold">{{ __("Halo!") }}</span>
                        <span class="text-lg text-blue-600">{{$user->name}}</span>
                    </div>
                    <div class="bg-gray-100 px-4 py-2 rounded-md">
                        <span class="text-sm text-gray-600">NIP:</span>
                        <span class="font-medium">{{$guru->nip}}</span>
                    </div>
                </div>
                <div class="mt-4 gap-4 p-4 bg-blue-50 rounded-md flex flex-col sm:flex-row justify-between">
                   <p>
                    <span class="text-blue-700">Berikut adalah nilai dari pelajaran</span>
                    <span class="font-semibold text-blue-800">{{$mapel[0]->nama}}</span>
                    
                </p> 
                <div>
                    <x-primary-button 
                    x-data=""
                     x-on:click.prevent="$dispatch('open-modal', 'tambahNilaiModal')"
                    >
                     {{ __('Tambah Nilai Siswa') }}
                    </x-primary-button>
                </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-white uppercase bg-blue-600">
                        <tr>
                            <th scope="col" class="px-6 py-4">No</th>
                            <th scope="col" class="px-6 py-4">Nama</th>
                            <th scope="col" class="px-6 py-4">Mata Pelajaran</th>
                            <th scope="col" class="px-6 py-4">Nilai</th>
                            <th scope="col" class="px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($nilai as $index => $g)
                            <tr class="bg-white hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 font-medium">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">{{ $g->siswa->nama ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $g->mataPelajaran->nama ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full">
                                        {{ $g->nilai}}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <x-secondary-button x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'editNilaiModal')"
                                    @click="
                                    $dispatch('set-nilai-data', {
                                        id: '{{ $g->id }}',
                                        nama: '{{ $g->siswa->nama }}',
                                        siswa_id: '{{ $g->siswa->id }}',
                                        mapel: '{{ $g->mataPelajaran->nama }}',
                                        mapel_id: '{{ $g->mataPelajaran->id }}',
                                        nilai: '{{ $g->nilai }}'
                                    })
                                ">
                                     {{ __('Edit') }}
                                    </x-secondary-button>
                                </td>
                            </tr>
                        @empty                            <tr class="bg-white">
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span class="font-medium">Tidak ada data nilai siswa</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <x-modal name="tambahNilaiModal" focusable>
        <div class="relative w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow-xl">
                <!-- Modal Header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Tambah Nilai Siswa
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" x-on:click="$dispatch('close')">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <form action="{{ route('guru.dashboard.store') }}" method="POST" class="w-full space-y-4">
                        @csrf
                        <!-- Input Nama -->
                        <div>
                            <x-input-label for="siswa_id" value="{{ __('Nama Siswa') }}" />
                            <select name="siswa_id" id="siswa_id" required
                                class="mt-1 p-2.5 w-full border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                <option value="">Pilih Siswa</option>
                                @foreach ($siswa as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Input Nilai -->
                        <div>
                            <x-input-label for="nilai" value="{{ __('Nilai') }}" />
                            <x-text-input
                                id="nilai"
                                name="nilai"
                                type="number"
                                class="mt-1 block w-full"
                                placeholder="{{ __('Masukkan Nilai') }}"
                                required
                            />
                        </div>

                        <div>
                            <x-input-label for="mata_pelajaran_id" value="{{ __('Mata Pelajaran') }}" />
                            <x-text-input
                                id="mata_pelajaran_id"
                                name="mata_pelajaran_id"
                                type="hidden"
                                value="{{ $mapel[0]->id }}"
                            />
                            <x-text-input
                                type="text"
                                class="mt-1 block w-full"
                                value="{{ $mapel[0]->nama }}"
                                readonly
                            />
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="flex justify-end pt-4 border-t gap-2">
                            <x-secondary-button type="button"
                                x-on:click="$dispatch('close')"
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
    <x-modal name="editNilaiModal" focusable>
        <div class="relative w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow-xl">
                <!-- Modal Header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Edit Nilai Siswa
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
                    <form x-data="{ nilaiData: {} }" @set-nilai-data.window="nilaiData = $event.detail"
                        x-bind:action="'/guru/dashboard/' + nilaiData.id" method="POST" class="w-full space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            
                            <x-text-input id="nama" type="hidden" class="mt-1 block w-full"
                                x-bind:value="nilaiData.nama" readonly />
                        </div>
                        <div>
                            
                            <x-text-input id="siswa_id" name="siswa_id" type="hidden" class="mt-1 block w-full"
                                x-bind:value="nilaiData.siswa_id" />
                        </div>

                        <div>
                            
                            <x-text-input id="mapel" type="hidden" class="mt-1 block w-full"
                                x-bind:value="nilaiData.mapel" readonly />
                        </div>
                        <div>
                            
                            <x-text-input id="mata_pelajaran_id" name="mata_pelajaran_id" type="hidden" class="mt-1 block w-full"
                                x-bind:value="nilaiData.mapel_id" />
                        </div>

                        <div>
                            <x-input-label for="nilai" value="{{ __('Nilai') }}" />
                            <x-text-input id="nilai" name="nilai" type="number" class="mt-1 block w-full"
                                x-bind:value="nilaiData.nilai" required />
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