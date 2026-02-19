<style>
    /* Professional PDF Styling */
    .table-container {
        width: 100%;
        font-family: 'Helvetica', 'Arial', sans-serif;
    }
    .report-header {
        text-align: center;
        margin-bottom: 20px;
    }
    .report-header h2 {
        margin: 0;
        text-transform: uppercase;
        color: #333;
    }
    .report-header p {
        margin: 5px 0;
        color: #666;
        font-size: 12px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        font-size: 11px; /* Slightly smaller for PDF fitting */
    }
    th {
        background-color: #f3f4f6;
        color: #374151;
        font-weight: bold;
        text-align: left;
        padding: 10px 8px;
        border: 1px solid #e5e7eb;
        text-transform: uppercase;
    }
    td {
        padding: 8px;
        border: 1px solid #e5e7eb;
        vertical-align: top;
        color: #4b5563;
    }
    tr:nth-child(even) {
        background-color: #fafafa;
    }
    .status-badge {
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: bold;
    }
</style>

<div class="table-container">
    <div class="report-header">
        <h2>Laporan Data Siswa</h2>
        <p>Tanggal Cetak: {{ date('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 20%;">Nama</th>
                <th style="width: 15%;">NIS</th>
                <th style="width: 25%;">Alamat</th>
                <th style="width: 15%;">Orang Tua</th>
                <th style="width: 20%;">Status Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($siswa as $index => $g)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td><strong>{{ $g->nama }}</strong></td>
                    <td>{{ $g->nis }}</td>
                    <td>{{ $g->alamat }}</td>
                    <td>{{ $g->orangTua->name ?? '-' }}</td>
                    <td>
                        {{-- Optional: Add logic to change color based on status --}}
                        {{ $g->bayar->status ?? 'Belum ada data' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">
                        Tidak ada data siswa ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>