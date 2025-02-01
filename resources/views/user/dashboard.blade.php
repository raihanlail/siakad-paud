<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Selamat Datang di SIAKAD RA ALIFIA!') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Halo,") }} {{$user->name}}!, Berikut adalah nilai anak-anak anda
                </div>
            </div>
            @if ($siswa->isEmpty())
                <div class="bg-white shadow-md rounded p-4 mb-4">
                    <p class="text-gray-500">Tidak ada data siswa yang terdaftar. Daftar Sekarang</p>
                </div>
            @else
                @foreach ($siswa as $item)
                    <div class="bg-white shadow-md rounded p-4 mb-4">
                        <h2 class="text-xl font-semibold">{{ $item->nama }} (NIS: {{ $item->nis }})</h2>

                        @if ($item->nilai->isEmpty())
                            <p class="text-gray-500">Belum ada data nilai.</p>
                        @else
                            <table class="w-full border mt-2">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="border px-4 py-2">Mata Pelajaran</th>
                                        <th class="border px-4 py-2">Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($item->nilai as $nilai)
                                        <tr>
                                            <td class="border px-4 py-2">{{ $nilai->mataPelajaran->nama }}</td>
                                            <td class="border px-4 py-2">{{ $nilai->nilai }}</td>
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
