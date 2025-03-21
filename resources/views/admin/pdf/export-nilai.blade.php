<div class="relative overflow-x-auto pt-4">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 shadow-md sm:rounded-lg">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">No</th>
                <th scope="col" class="px-6 py-3">Nama</th>
                <th scope="col" class="px-6 py-3">Mata Pelajaran</th>
                <th scope="col" class="px-6 py-3">Nilai</th>
                
            </tr>
        </thead>
        <tbody>
            @forelse ($nilai as $index => $g)
                <tr class="bg-white border-b border-gray-200">
                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">{{ $g->siswa->nama ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $g->mataPelajaran->nama ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $g->nilai}}</td>
                   
                </tr>
            @empty
                <tr class="bg-white border-b border-gray-200">
                    <td colspan="6" class="px-6 py-4 text-center">Tidak ada data nilai siswa</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>