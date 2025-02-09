<div class="relative overflow-x-auto pt-4">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 shadow-md sm:rounded-lg">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">No</th>
                <th scope="col" class="px-6 py-3">Nama</th>
                <th scope="col" class="px-6 py-3">NIS</th>
                <th scope="col" class="px-6 py-3">Alamat</th>
                <th scope="col" class="px-6 py-3">Orang Tua</th>
                <th scope="col" class="px-6 py-3">Status Pembayaran</th>
                
            </tr>
        </thead>
        <tbody>
            @forelse ($siswa as $index => $g)
                <tr class="bg-white border-b border-gray-200">
                    <td class="px-6 py-4">{{ $index + 1}}</td>
                    <td class="px-6 py-4">{{ $g->nama }}</td>
                    <td class="px-6 py-4">{{ $g->nis }}</td>
                    <td class="px-6 py-4">{{ $g->alamat }}</td>
                    <td class="px-6 py-4">{{ $g->orangTua->name ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $g->bayar->status ?? 'belum ada data' }}</td>
                    
                </tr>
            @empty
                <tr class="bg-white border-b border-gray-200">
                    <td colspan="6" class="px-6 py-4 text-center">Tidak ada data siswa</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
</div>