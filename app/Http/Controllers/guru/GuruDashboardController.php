<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use App\Models\MataPelajaran;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Nilai;



use Illuminate\Http\Request;

class GuruDashboardController extends Controller
{
   public function index(Request $request)
{
    $user   = Auth::user();
    $search = $request->get('search');
    $guru   = Guru::where('user_id', $user->id)->first();
    $mapel  = MataPelajaran::where('id', $guru->mata_pelajaran_id)->get();

    $kelas = Kelas::with(['siswa' => function ($query) {
        $query->where('status', 'Verified');
    }])->get();

    $siswa = Siswa::where('status', 'Verified')->get();

    $nilai = Nilai::with(['mataPelajaran', 'siswa.kelas'])
        ->where('mata_pelajaran_id', $mapel[0]->id)
        ->when($search, function ($query) use ($search) {
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis',  'like', "%{$search}%");
            });
        })
        ->get();

    return view('guru.dashboard', compact('user', 'guru', 'siswa', 'mapel', 'nilai', 'kelas'));
}


    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required',
            'mata_pelajaran_id' => 'required',
            'nilai' => 'required|integer|min:0|max:100'
        ]);

        // Check if nilai already exists for this siswa and mata pelajaran
        $existingNilai = Nilai::where('siswa_id', $request->siswa_id)
            ->where('mata_pelajaran_id', $request->mata_pelajaran_id)
            ->first();

        if ($existingNilai) {
            return redirect()->back()->with('error', 'Nilai untuk siswa ini pada mata pelajaran tersebut sudah ada.');
        }

        Nilai::create([
            'siswa_id' => $request->siswa_id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'nilai' => $request->nilai
        ]);

        return redirect()->back()->with('success', 'Nilai berhasil disimpan.');
    }
    public function update(Request $request, $id)
    {
        $nilai = Nilai::findOrFail($id);
        $nilai->update([
            'siswa_id' => $request->siswa_id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'nilai' => $request->nilai
        ]);
        return redirect()->back()->with('success', 'Nilai berhasil diperbarui.');
    }

   public function exportPDF()
{
    $user = Auth::user();
    $guru = Guru::where('user_id', $user->id)->first();
    // Use first() to get the object directly
    $mapel = MataPelajaran::findOrFail($guru->mata_pelajaran_id);

    $nilai = Nilai::with(['siswa', 'mataPelajaran'])
                ->where('mata_pelajaran_id', $mapel->id)
                ->get();

    $pdf = Pdf::loadView('guru.pdf.export-nilai', [
        'nilai' => $nilai,
        'guru' => $guru,
        'mapel' => $mapel,
        'date' => now()->format('d F Y')
    ]);

    return $pdf->download('Data-Nilai-' . $mapel->nama . '.pdf');
}

public function jadwal()
{
    $user = Auth::user();

    $guru = Guru::where('user_id', $user->id)->firstOrFail();

    $mapel = MataPelajaran::findOrFail($guru->mata_pelajaran_id);

    $jadwal = Jadwal::with(['kelas', 'mataPelajaran'])
        ->where('guru_id', $guru->id)
        ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
        ->get()
        ->groupBy('hari');

    return view('guru.jadwal', compact('guru', 'mapel', 'jadwal'));
}


}
