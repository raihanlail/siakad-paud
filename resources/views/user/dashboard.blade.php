<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Selamat Datang di SIAKAD RA ALIFIA!') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 flex items-center justify-between">
                    <div class="text-gray-900">
                        <span class="text-xl font-semibold">{{ __("Halo,") }} {{$user->name}}!</span>
                        <p class="text-gray-600 mt-2">Berikut adalah nilai anak-anak anda</p>
                    </div>
                    <a href="{{route('user.daftar')}}" class="transition duration-150 ease-in-out">
                        <x-primary-button class="hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            {{ __('Daftar Siswa') }}
                        </x-primary-button>
                    </a>
                </div>
            </div>

            @if ($siswa->isEmpty())
                <div class="bg-white shadow-md rounded-lg p-8 mb-4 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="text-gray-500 text-lg">Tidak ada data siswa yang terdaftar.</p>
                    <p class="text-gray-400 mt-2">Silakan klik tombol Daftar Siswa di atas untuk mendaftarkan siswa baru.</p>
                </div>
            @else
                @foreach ($siswa as $item)
                    <div class="bg-white shadow-md rounded-lg p-6 mb-4 hover:shadow-lg transition duration-300">
                        <div class="flex flex-row justify-between items-center mb-4">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800">{{ $item->nama }}</h2>
                                <p class="text-gray-600">NIS: {{ $item->nis }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600 mb-1">Status Pembayaran:</p>
                                <span class="px-4 py-2 rounded-full text-sm font-semibold
                                    @if(($item->bayar->status ?? '') === 'Lunas') 
                                        bg-green-100 text-green-800
                                    @elseif(($item->bayar->status ?? '') === 'Belum Lunas')
                                        bg-yellow-100 text-yellow-800
                                    @else
                                        bg-gray-100 text-gray-800
                                    @endif
                                ">
                                    {{$item->bayar->status ?? 'Belum ada data'}}
                                </span>
                            </div>
                        </div>

                        @if ($item->nilai->isEmpty())
                            <div class="text-center py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-gray-500">Belum ada data nilai.</p>
                            </div>
                        @else
                            <table class="w-full border-collapse mt-2">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="border px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                                        <th class="border px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($item->nilai as $nilai)
                                        <tr class="hover:bg-gray-50">
                                            <td class="border px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $nilai->mataPelajaran->nama }}</td>
                                            <td class="border px-6 py-4 whitespace-nowrap text-sm">
                                                <span class="px-3 py-1 rounded-full
                                                    @if($nilai->nilai >= 90)
                                                        bg-green-100 text-green-800
                                                    @elseif($nilai->nilai >= 80)
                                                        bg-blue-100 text-blue-800
                                                    @elseif($nilai->nilai >= 70)
                                                        bg-yellow-100 text-yellow-800
                                                    @else
                                                        bg-red-100 text-red-800
                                                    @endif
                                                ">
                                                    {{ $nilai->nilai }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>
