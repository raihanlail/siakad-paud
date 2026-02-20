<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Nilai - {{ $mataPelajaran->nama }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #334155; }
        .kop-surat { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop-surat h1 { margin: 0; font-size: 22px; color: #1e293b; }
        .kop-surat p { margin: 5px 0; font-size: 12px; }
        
        .title { text-align: center; text-transform: uppercase; margin-bottom: 20px; }
        .title h2 { font-size: 16px; margin: 0; text-decoration: underline; }
        
        .metadata { width: 100%; margin-bottom: 20px; font-size: 13px; }
        
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data-table th { background-color: #f1f5f9; color: #475569; padding: 10px; border: 1px solid #cbd5e1; font-size: 11px; text-transform: uppercase; }
        table.data-table td { padding: 8px 10px; border: 1px solid #cbd5e1; font-size: 12px; }
        
        .status-tuntas { color: #059669; font-weight: bold; }
        .status-remedial { color: #dc2626; font-weight: bold; }
        
        .footer { margin-top: 40px; width: 100%; }
        .ttd { float: right; width: 200px; text-align: center; font-size: 13px; }
        .spacer { height: 70px; }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h1>SIAKAD RA ALIFIA</h1>
        <p>Jl. Raya Utama No. 123, Bekasi, Jawa Barat</p>
        <p>Email: admin@raalifia.sch.id | Telp: (021) 888-8888</p>
    </div>

    <div class="title">
        <h2>REKAPITULASI NILAI AKADEMIK</h2>
    </div>

    <table class="metadata">
        <tr>
            <td width="20%">Mata Pelajaran</td>
            <td width="30%">: <strong>{{ $mataPelajaran->nama }}</strong></td>
            <td width="20%">Tanggal Cetak</td>
            <td width="30%">: {{ date('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Tahun Ajaran</td>
            <td>: 2025/2026</td>
            <td>Admin Pencetak</td>
            <td>: {{ Auth::user()->name }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">NIS</th>
                <th>Nama Lengkap Siswa</th>
                <th width="10%">Nilai</th>
                <th width="15%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($nilai as $index => $n)
                <tr>
                    <td align="center">{{ $index + 1 }}</td>
                    <td align="center">{{ $n->siswa->nis ?? '-' }}</td>
                    <td>{{ $n->siswa->nama }}</td>
                    <td align="center"><strong>{{ $n->nilai }}</strong></td>
                    <td align="center">
                        @if($n->nilai >= 75)
                            <span class="status-tuntas">Tuntas</span>
                        @else
                            <span class="status-remedial">Remedial</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" align="center">Belum ada data nilai yang diinput.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="ttd">
            <p>Bekasi, {{ date('d F Y') }}</p>
            <p>Kepala Sekolah,</p>
            <div class="spacer"></div>
            <p><strong>( ____________________ )</strong></p>
            <p>NIP. ............................</p>
        </div>
    </div>

</body>
</html>