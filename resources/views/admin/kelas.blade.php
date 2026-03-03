<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Kelas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Tombol Tambah Kelas -->
                    <x-primary-button
                        x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'tambahKelasModal')">
                        {{ __('Tambah Kelas') }}
                    </x-primary-button>

                    <!-- Tabel Data Kelas -->
                    <div class="relative overflow-x-auto pt-4">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 shadow-md sm:rounded-lg">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No</th>
                                    <th scope="col" class="px-6 py-3">Nama Kelas</th>
                                    <th scope="col" class="px-6 py-3">Kapasitas</th>
                                    <th scope="col" class="px-6 py-3">Jumlah Siswa</th>
                                    <th scope="col" class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kelas as $index => $g)
                                    <!-- Kelas Row -->
                                    <tr class="bg-white border-b border-gray-200 cursor-pointer hover:bg-gray-50"
                                        x-data="{ open: false }"
                                        @click="open = !open">
                                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 font-medium text-gray-900 flex items-center gap-2">
                                            <svg x-bind:class="open ? 'rotate-90' : ''"
                                                class="w-4 h-4 text-gray-400 transition-transform duration-200"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                            {{ $g->name }}
                                        </td>
                                        <td class="px-6 py-4">{{ $g->capacity }}</td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $g->siswa->count() >= $g->capacity ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                {{ $g->siswa->count() }} / {{ $g->capacity }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4" @click.stop>
                                            <div class="flex gap-2">
                                                <!-- Edit Button -->
                                                <x-secondary-button
                                                    x-data=""
                                                    x-on:click.prevent="$dispatch('open-modal', 'editKelasModal-{{ $g->id }}')"
                                                    class="text-blue-600 hover:text-blue-900 text-xs font-medium">
                                                    Edit
                                                </x-secondary-button>
                                                <!-- Delete Button -->
                                                <form action="{{ route('admin.kelas.destroy', $g->id) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-danger-button type="submit"
                                                        class="text-red-600 hover:text-red-900 text-xs font-medium">
                                                        Hapus
                                                    </x-danger-button>
                                                </form>
                                            </div>
                                        </td>

                                        <!-- Siswa Sub-Table (expandable) -->
                                        <td colspan="5" class="p-0 border-0" x-show="open" x-collapse>
                                            <!-- This td won't work in a tr click setup, see below -->
                                        </td>
                                    </tr>

                                    <!-- Siswa Sub-Row -->
                                    <tr x-data="{ open: false }"
                                        x-show="$el.previousElementSibling.__x && $el.previousElementSibling.__x.$data.open"
                                        class="bg-gray-50">
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b border-gray-200">
                                        <td colspan="5" class="px-6 py-4 text-center">Tidak ada data kelas</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Better approach: accordion cards below the table --}}
                    <div class="mt-8 space-y-4">
                        <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Detail Siswa per Kelas</h3>

                        @forelse ($kelas as $g)
                            <div x-data="{ open: false }" class="border border-gray-200 rounded-lg shadow-sm">
                                <!-- Accordion Header -->
                                <button @click="open = !open"
                                    class="w-full flex items-center justify-between px-5 py-4 bg-white hover:bg-gray-50 rounded-lg transition-colors duration-150">
                                    <div class="flex items-center gap-3">
                                        <span class="text-sm font-semibold text-gray-800">{{ $g->name }}</span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $g->siswa->count() >= $g->capacity ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ $g->siswa->count() }} Siswa
                                        </span>
                                        <span class="text-xs text-gray-400">Kapasitas: {{ $g->capacity }}</span>
                                    </div>
                                    <svg :class="open ? 'rotate-180' : ''"
                                        class="w-5 h-5 text-gray-400 transition-transform duration-200"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <!-- Accordion Body: Siswa Table -->
                                <div x-show="open" x-collapse class="border-t border-gray-100">
                                    @if ($g->siswa->count() > 0)
                                        <table class="w-full text-sm text-left text-gray-600">
                                            <thead class="text-xs text-gray-500 uppercase bg-gray-100">
                                                <tr>
                                                    <th class="px-6 py-2">No</th>
                                                    <th class="px-6 py-2">Nama Siswa</th>
                                                    <th class="px-6 py-2">NIS</th>
                                                    {{-- Add more columns as needed based on your Siswa model --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($g->siswa as $i => $siswa)
                                                    <tr class="border-t border-gray-100 hover:bg-gray-50">
                                                        <td class="px-6 py-3">{{ $i + 1 }}</td>
                                                        <td class="px-6 py-3 font-medium text-gray-800">{{ $siswa->nama }}</td>
                                                        <td class="px-6 py-3">{{ $siswa->nis ?? '-' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <div class="px-6 py-4 text-sm text-gray-400 italic text-center">
                                            Belum ada siswa di kelas ini.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-400 text-sm text-center py-4">Tidak ada data kelas.</p>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Kelas -->
    <x-modal name="tambahKelasModal" tabindex="-1" aria-hidden="true">
        <div class="relative w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow-xl">
                <div class="flex items-start justify-between p-6 border-b rounded-t bg-gray-50">
                    <h3 class="text-xl font-semibold text-gray-900">Tambah Data Kelas</h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center transition-colors duration-200"
                        x-on:click.prevent="$dispatch('close')">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.kelas.store') }}" method="POST" class="w-full space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="name" value="{{ __('Nama Kelas') }}" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                placeholder="{{ __('Masukkan Nama Kelas') }}" required />
                        </div>
                        <div>
                            <x-input-label for="capacity" value="{{ __('Kapasitas') }}" />
                            <x-text-input id="capacity" name="capacity" type="number" class="mt-1 block w-full"
                                placeholder="{{ __('Masukkan Kapasitas Kelas') }}" required />
                        </div>
                        <div class="flex justify-end pt-4 border-t gap-2">
                            <x-secondary-button type="button"
                                x-on:click.prevent="$dispatch('close')">{{ __('Batal') }}</x-secondary-button>
                            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-modal>

    <!-- Modal Edit Kelas (per kelas) -->
    @foreach ($kelas as $g)
        <x-modal name="editKelasModal-{{ $g->id }}" tabindex="-1" aria-hidden="true">
            <div class="relative w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow-xl">
                    <div class="flex items-start justify-between p-6 border-b rounded-t bg-gray-50">
                        <h3 class="text-xl font-semibold text-gray-900">Edit Data Kelas</h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center transition-colors duration-200"
                            x-on:click.prevent="$dispatch('close')">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.kelas.update', $g->id) }}" method="POST" class="w-full space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <x-input-label for="edit_name_{{ $g->id }}" value="{{ __('Nama Kelas') }}" />
                                <x-text-input id="edit_name_{{ $g->id }}" name="name" type="text"
                                    class="mt-1 block w-full" value="{{ $g->name }}" required />
                            </div>
                            <div>
                                <x-input-label for="edit_capacity_{{ $g->id }}" value="{{ __('Kapasitas') }}" />
                                <x-text-input id="edit_capacity_{{ $g->id }}" name="capacity" type="number"
                                    class="mt-1 block w-full" value="{{ $g->capacity }}" required />
                            </div>
                            <div class="flex justify-end pt-4 border-t gap-2">
                                <x-secondary-button type="button"
                                    x-on:click.prevent="$dispatch('close')">{{ __('Batal') }}</x-secondary-button>
                                <x-primary-button>{{ __('Update') }}</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </x-modal>
    @endforeach

    @if (session('success'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            {{ session('success') }}
        </div>
    @endif

</x-app-layout>