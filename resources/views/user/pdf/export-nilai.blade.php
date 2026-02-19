<style>
    .report-card {
        font-family: 'Helvetica', sans-serif;
        color: #333;
        border: 1px solid #e5e7eb;
        padding: 25px;
        background-color: #fff;
    }
    .header-table {
        width: 100%;
        border-bottom: 2px solid #444;
        margin-bottom: 20px;
        padding-bottom: 10px;
    }
    .student-info h2 {
        margin: 0;
        font-size: 22px;
        color: #1a202c;
    }
    .student-info p {
        margin: 2px 0;
        color: #64748b;
        font-size: 13px;
    }
    .status-box {
        text-align: right;
        vertical-align: top;
    }
    .badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: bold;
        text-transform: uppercase;
    }
    /* Status Colors */
    .bg-lunas { background-color: #dcfce7; color: #166534; }
    .bg-belum { background-color: #fef9c3; color: #854d0e; }
    .bg-none { background-color: #f1f5f9; color: #475569; }

    /* Grades Table */
    .grade-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }
    .grade-table th {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 10px;
        text-align: left;
        font-size: 12px;
        color: #64748b;
    }
    .grade-table td {
        border: 1px solid #e2e8f0;
        padding: 10px;
        font-size: 13px;
    }
    
    /* Grade Color Indicators */
    .grade-high { color: #16a34a; font-weight: bold; }
    .grade-mid { color: #2563eb; font-weight: bold; }
    .grade-low { color: #dc2626; font-weight: bold; }

    .empty-state {
        text-align: center;
        padding: 40px;
        color: #94a3b8;
        font-style: italic;
    }
</style>

@if($siswa)
<div class="report-card">
    <table class="header-table">
        <tr>
            <td class="student-info">
                <h2>{{ $siswa->nama }}</h2>
                <p>Nomor Induk Siswa: <strong>{{ $siswa->nis }}</strong></p>
                <p>Tahun Ajaran: {{ date('Y') }}/{{ date('Y') + 1 }}</p>
            </td>
            <td class="status-box">
                <p style="font-size: 11px; margin-bottom: 5px; color: #64748b;">Status Pembayaran</p>
                <span class="badge 
                    @if(($siswa->bayar->status ?? '') === 'Lunas') bg-lunas 
                    @elseif(($siswa->bayar->status ?? '') === 'Belum Lunas') bg-belum 
                    @else bg-none @endif">
                    {{ $siswa->bayar->status ?? 'No Data' }}
                </span>
            </td>
        </tr>
    </table>

    <h3 style="font-size: 14px; text-transform: uppercase; color: #475569; margin-bottom: 10px;">Capaian Akademik</h3>

    @if ($siswa->nilai->isEmpty())
        <div class="empty-state">
            <p>Belum ada data nilai yang diinput untuk siswa ini.</p>
        </div>
    @else
        <table class="grade-table">
            <thead>
                <tr>
                    <th style="width: 70%;">Mata Pelajaran</th>
                    <th style="width: 30%; text-align: center;">Nilai Akhir</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($siswa->nilai as $nilai)
                    <tr>
                        <td>{{ $nilai->mataPelajaran->nama }}</td>
                        <td style="text-align: center;">
                            <span class="
                                @if($nilai->nilai >= 90) grade-high 
                                @elseif($nilai->nilai >= 75) grade-mid 
                                @else grade-low @endif">
                                {{ $nilai->nilai }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div style="margin-top: 20px; font-size: 11px; color: #94a3b8;">
            <p>* Nilai ini merupakan hasil akumulasi penilaian formatif dan sumatif.</p>
        </div>
    @endif
</div>
@endif