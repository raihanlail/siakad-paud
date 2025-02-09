<
@if($siswa)
<div class="bg-white shadow-md rounded-lg p-6 mb-4 hover:shadow-lg transition duration-300">
    <div class="flex flex-row justify-between items-center mb-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">{{ $siswa->nama }}</h2>
            <p class="text-gray-600">NIS: {{ $siswa->nis }}</p>
        </div>
        
        <div class="flex flex-row gap-4">
        <div class="text-right">
            <p class="text-sm text-gray-600 mb-1">Status Pembayaran:</p>
            <span class="px-4 py-2 rounded-full text-sm font-semibold
                @if(($siswa->bayar->status ?? '') === 'Lunas') 
                    bg-green-100 text-green-800
                @elseif(($siswa->bayar->status ?? '') === 'Belum Lunas')
                    bg-yellow-100 text-yellow-800
                @else
                    bg-gray-100 text-gray-800
                @endif
            ">
                {{$siswa->bayar->status ?? 'Belum ada data'}}
            </span>
        </div>
    </div>
    </div>

    @if ($siswa->nilai->isEmpty())
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
                @foreach ($siswa->nilai as $nilai)
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
@endif