<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Nilai Mapel ') }} {{$mataPelajaran->nama}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Tombol Tambah Siswa -->
                    <div class="flex flex-row gap-6">
                        <x-primary-button 
                        x-data=""
                         x-on:click.prevent="$dispatch('open-modal', 'tambahNilaiModal')"
                        >
                         {{ __('Tambah Nilai Siswa') }}
                        </x-primary-button>
                        <x-secondary-button onclick="window.location.href='{{route('admin.nilai.download', $mataPelajaran->id)}}'">
                            {{ __('Download Data Nilai') }}
                        </x-secondary-button>
                        
                        <a href="{{route('admin.mapel')}}">
                            <x-secondary-button>
                                {{ __('Kembali') }}
                            </x-secondary-button>
                        </a>
                    </div>

                    <!-- Tabel Data Siswa -->
                    <div class="relative overflow-x-auto pt-4">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 shadow-md sm:rounded-lg">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No</th>
                                    <th scope="col" class="px-6 py-3">Nama</th>
                                    <th scope="col" class="px-6 py-3">Mata Pelajaran</th>
                                    <th scope="col" class="px-6 py-3">Nilai</th>
                                    <th scope="col" class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($nilai as $index => $g)
                                    <tr class="bg-white border-b border-gray-200">
                                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4">{{ $g->siswa->nama ?? '-' }}</td>
                                        <td class="px-6 py-4">{{ $g->mataPelajaran->nama ?? '-' }}</td>
                                        <td class="px-6 py-4">{{ $g->nilai}}</td>
                                        <td class="px-6 py-4 flex flex-row gap-4 ">
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
                                @empty
                                    <tr class="bg-white border-b border-gray-200">
                                        <td colspan="6" class="px-6 py-4 text-center">Tidak ada data nilai siswa</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
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
                    <form action="{{ route('admin.nilai.store') }}" method="POST" class="w-full space-y-4">
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
                                value="{{ $mataPelajaran->id }}"
                            />
                            <x-text-input
                                type="text"
                                class="mt-1 block w-full"
                                value="{{ $mataPelajaran->nama }}"
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
                        x-bind:action="'/admin/nilai/' + nilaiData.id" method="POST" class="w-full space-y-4">
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