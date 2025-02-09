<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight tracking-wide">
            {{ __('Selamat Datang di SIAKAD RA ALIFIA!') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <!--  @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif -->

            <div class="bg-white overflow-hidden shadow-lg rounded-xl mb-6 transform hover:scale-[1.01] transition-all duration-300">
                <div class="p-8 flex flex-col sm:flex-row items-center justify-between">
                    <div class="text-gray-900 mb-4 sm:mb-0 text-center sm:text-left">
                        <span class="text-2xl font-bold">{{ __("Halo,") }} {{$user->name}}!</span>
                        <p class="text-gray-600 mt-2 text-lg">Berikut adalah nilai anak-anak anda</p>
                    </div>
                    <div class="flex space-x-4">
                        <a href="{{route('user.daftar')}}" class="transition duration-300 ease-in-out transform hover:scale-105">
                            <x-primary-button class="px-6 py-3 text-base">
                                <svg xmlns="http://www.w3.org/2000/svg" class="hidden sm:block h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                {{ __('Daftar Siswa') }}
                            </x-primary-button>
                        </a>
                    </div>
                </div>
            </div>

            @if ($siswa->isEmpty())
                <div class="bg-white shadow-lg rounded-xl p-12 mb-4 text-center transform hover:scale-[1.01] transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-gray-400 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="text-gray-500 text-xl font-medium">Tidak ada data siswa yang terdaftar.</p>
                    <p class="text-gray-400 mt-4 text-lg">Silakan klik tombol Daftar Siswa di atas untuk mendaftarkan siswa baru.</p>
                </div>
            @else
                @foreach ($siswa as $item)
                    <div class="bg-white shadow-lg rounded-xl p-8 mb-6 hover:shadow-xl transform hover:scale-[1.01] transition-all duration-300">
                        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
                            <div class="mb-4 sm:mb-0 text-center sm:text-left">
                                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">{{ $item->nama }}</h2>
                                <p class="text-lg text-gray-600">NIS: {{ $item->nis }}</p>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row gap-4 items-center">
                                <a href="{{route('user.download', $item->id)}}" class="transition duration-300 ease-in-out transform hover:scale-105">
                                    <x-secondary-button class="px-6 py-3 text-base">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="hidden sm:block h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586L7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                                        </svg>
                                        {{ __('Download') }}
                                    </x-secondary-button>
                                </a>
                           
                                <div class="text-center sm:text-right">
                                    <p class="text-base text-gray-600 mb-2">Status Pembayaran:</p>
                                    <span class="px-6 py-2 rounded-full text-base font-semibold inline-block
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
                        </div>

                        @if ($item->nilai->isEmpty())
                            <div class="text-center py-12">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-gray-500 text-lg">Belum ada data nilai.</p>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full border-collapse mt-4">
                                    <thead>
                                        <tr class="bg-gray-50">
                                            <th class="border px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Mata Pelajaran</th>
                                            <th class="border px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($item->nilai as $nilai)
                                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                                <td class="border px-6 py-4 whitespace-nowrap text-base text-gray-900">{{ $nilai->mataPelajaran->nama }}</td>
                                                <td class="border px-6 py-4 whitespace-nowrap text-base">
                                                    <span class="px-4 py-2 rounded-full inline-block
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
                            </div>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>
