<!DOCTYPE html>
<html>
<head>
    <title>Laporan Nilai Siswa</title>
    <style>
        body { font-family: sans-serif; color: #333; line-height: 1.5; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #444; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; color: #1e40af; }
        .info { margin-bottom: 20px; font-size: 14px; }
        .info table { width: 100%; }
        
        table.main-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.main-table th { background-color: #1e40af; color: white; padding: 10px; text-align: left; font-size: 12px; }
        table.main-table td { padding: 8px; border: 1px solid #ddd; font-size: 12px; }
        table.main-table tr:nth-child(even) { background-color: #f9fafb; }
        
        .footer { margin-top: 50px; text-align: right; font-size: 14px; }
        .signature-space { margin-top: 60px; font-weight: bold; text-decoration: underline; }
        .badge { padding: 4px 8px; border-radius: 4px; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h2>RA ALIFIA</h2>
        <p>Laporan Hasil Belajar Siswa - {{ $mapel->nama }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="15%"><strong>Guru Pengampu</strong></td>
                <td>: {{ Auth::user()->name }}</td>
                <td width="15%"><strong>NIP</strong></td>
                <td>: {{ $guru->nip }}</td>
            </tr>
            <tr>
                <td><strong>Mata Pelajaran</strong></td>
                <td>: {{ $mapel->nama }}</td>
                <td><strong>Tanggal Cetak</strong></td>
                <td>: {{ $date }}</td>
            </tr>
        </table>
    </div>

    <table class="main-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">NIS</th>
                <th>Nama Siswa</th>
                <th width="15%" style="text-align: center;">Nilai</th>
                <th width="20%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nilai as $index => $n)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $n->siswa->nis ?? '-' }}</td>
                <td>{{ $n->siswa->nama }}</td>
                <td style="text-align: center; font-weight: bold;">{{ $n->nilai }}</td>
                <td>
                    @if($n->nilai >= 75)
                        Tuntas
                    @else
                        Remedial
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Bekasi, {{ $date }}</p>
        <p>Guru Mata Pelajaran,</p>
        <div class="signature-space"></div>
        <p>{{ Auth::user()->name }}</p>
    </div>

</body>
</html>