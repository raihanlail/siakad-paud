<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            color: #1f2937;
            background: #fff;
        }

        /* ── Page wrapper ── */
        .page {
            padding: 32px 36px;
        }

        /* ── Letterhead ── */
        .letterhead {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 14px;
            border-bottom: 3px solid #4f46e5;
            margin-bottom: 6px;
        }
        .letterhead-left .school-name {
            font-size: 16px;
            font-weight: bold;
            color: #1e1b4b;
            letter-spacing: 0.5px;
        }
        .letterhead-left .school-sub {
            font-size: 9px;
            color: #6b7280;
            margin-top: 2px;
        }
        .letterhead-right {
            text-align: right;
        }
        .letterhead-right .doc-title {
            font-size: 13px;
            font-weight: bold;
            color: #4f46e5;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .letterhead-right .doc-meta {
            font-size: 8.5px;
            color: #9ca3af;
            margin-top: 3px;
        }

        /* ── Thin rule ── */
        .rule {
            border: none;
            border-top: 1px solid #e5e7eb;
            margin: 10px 0;
        }

        /* ── Info strip ── */
        .info-strip {
            display: flex;
            gap: 0;
            margin-bottom: 16px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            overflow: hidden;
        }
        .info-item {
            flex: 1;
            padding: 8px 12px;
            border-right: 1px solid #e5e7eb;
        }
        .info-item:last-child { border-right: none; }
        .info-item .info-label {
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #9ca3af;
            font-weight: bold;
        }
        .info-item .info-value {
            font-size: 11px;
            font-weight: bold;
            color: #111827;
            margin-top: 2px;
        }
        .info-item.highlight {
            background: #4f46e5;
        }
        .info-item.highlight .info-label { color: #c7d2fe; }
        .info-item.highlight .info-value { color: #fff; }

        /* ── Section heading ── */
        .section-title {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #6b7280;
            margin-bottom: 6px;
        }

        /* ── Table ── */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5px;
        }
        thead tr {
            background-color: #1e1b4b;
        }
        thead th {
            color: #fff;
            padding: 8px 8px;
            text-align: left;
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
        }
        tbody tr:nth-child(even) td {
            background-color: #f9fafb;
        }
        tbody td {
            padding: 7px 8px;
            border-bottom: 1px solid #f3f4f6;
            color: #374151;
            vertical-align: top;
        }
        tbody tr:last-child td {
            border-bottom: 2px solid #e5e7eb;
        }

        /* ── Badges ── */
        .badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 20px;
            font-size: 8.5px;
            font-weight: bold;
        }
        .badge-lunas    { background: #d1fae5; color: #065f46; }
        .badge-sebagian { background: #fef3c7; color: #92400e; }
        .badge-belum    { background: #fee2e2; color: #991b1b; }

        .no-cell {
            color: #9ca3af;
            font-size: 9px;
            text-align: center;
        }
        .sub-text {
            font-size: 8.5px;
            color: #9ca3af;
            margin-top: 1px;
        }

        /* ── Footer ── */
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .footer-left {
            font-size: 8.5px;
            color: #9ca3af;
            line-height: 1.6;
        }
        .signature-block {
            text-align: center;
            font-size: 9px;
        }
        .signature-block .sig-title {
            color: #374151;
            font-weight: bold;
        }
        .signature-block .sig-space {
            height: 48px;
            width: 140px;
            border-bottom: 1px solid #9ca3af;
            margin: 6px auto 4px;
        }
        .signature-block .sig-name {
            font-size: 9px;
            color: #374151;
            font-weight: bold;
        }
        .signature-block .sig-nip {
            font-size: 8px;
            color: #9ca3af;
        }
    </style>
</head>
<body>
<div class="page">

    @php
        $total     = $siswa->count();
        $laki      = $siswa->where('jenis_kelamin', 'Laki-laki')->count();
        $perempuan = $siswa->where('jenis_kelamin', 'Perempuan')->count();
        $lunas     = $siswa->filter(fn($s) => optional($s->bayar)->status === 'Lunas')->count();
        $belum     = $total - $lunas;
    @endphp

    {{-- ── Letterhead ── --}}
    <div class="letterhead">
        <div class="letterhead-left">
            <div class="school-name">SIAKAD — Sistem Informasi Akademik</div>
            <div class="school-sub">Dokumen resmi diterbitkan oleh sistem · Tidak memerlukan tanda tangan digital</div>
        </div>
        <div class="letterhead-right">
            <div class="doc-title">Laporan Data Siswa</div>
            <div class="doc-meta">
                Dicetak: {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y, HH:mm') }} WIB<br>
                No. Dok: RPT-SISWA-{{ date('Ymd') }}
            </div>
        </div>
    </div>

    {{-- ── Info strip ── --}}
    <div class="info-strip">
        <div class="info-item highlight">
            <div class="info-label">Kelas</div>
            <div class="info-value">{{ $kelasLabel }}</div>
        </div>
       
    </div>

    {{-- ── Table ── --}}
    <div class="section-title">Daftar Siswa</div>
    <table>
        <thead>
            <tr>
                <th style="width:4%">No</th>
                <th style="width:26%">Nama Siswa</th>
                <th style="width:12%">NIS</th>
                <th style="width:5%">JK</th>
                <th style="width:20%">Alamat</th>
                <th style="width:18%">Orang Tua / Wali</th>
                <th style="width:15%">Status Bayar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswa as $index => $g)
                @php
                    $bayar      = optional($g->bayar)->status;
                    $isLunas    = $bayar === 'Lunas';
                    $isSebagian = $bayar && !$isLunas && $bayar !== 'Belum';
                @endphp
                <tr>
                    <td class="no-cell">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $g->nama }}</strong>
                        <div class="sub-text">{{ \Carbon\Carbon::parse($g->tanggal_lahir)->format('d M Y') }} · {{ \Carbon\Carbon::parse($g->tanggal_lahir)->age }} th</div>
                    </td>
                    <td style="font-family: monospace; font-size: 9px;">{{ $g->nis }}</td>
                    <td style="font-weight: bold; color: {{ $g->jenis_kelamin === 'Laki-laki' ? '#2563eb' : '#db2777' }}">
                        {{ $g->jenis_kelamin  }}
                    </td>
                    <td style="font-size: 9px; color: #6b7280;">{{ $g->alamat ?? '—' }}</td>
                    <td>{{ $g->orangTua->name ?? '—' }}</td>
                    <td>
                        @if($isLunas)
                            <span class="badge badge-lunas">Lunas</span>
                        @elseif($isSebagian)
                            <span class="badge badge-sebagian">Sebagian</span>
                        @elseif($bayar)
                            <span class="badge badge-belum">{{ $bayar }}</span>
                        @else
                            <span class="badge badge-belum">Belum Bayar</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding: 24px; color: #9ca3af; font-style: italic;">
                        Tidak ada data siswa untuk {{ $kelasLabel }}.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ── Footer ── --}}
    <div class="footer">
        <div class="footer-left">
            Dokumen ini digenerate secara otomatis oleh SIAKAD.<br>
            Dicetak oleh: Administrator &nbsp;·&nbsp; {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}<br>
            <span style="color:#d1d5db">{{ $kelasLabel }} &nbsp;·&nbsp; {{ $total }} siswa terdaftar</span>
        </div>
        <div class="signature-block">
            <div class="sig-title">Mengetahui,</div>
            <div class="sig-title">Kepala Sekolah</div>
            <div class="sig-space"></div>
            <div class="sig-name">( _________________________ )</div>
            <div class="sig-nip">NIP. ___________________________</div>
        </div>
    </div>

</div>
</body>
</html>