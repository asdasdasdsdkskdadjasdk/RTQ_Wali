<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Santri;
use App\Models\Periode;
use App\Models\DetailHafalan;
use App\Models\JadwalMengajar;
use App\Models\DetailKehadiran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardAdminController extends Controller
{
    public function index(Request $request)
    {
        // Gunakan session periode aktif
        $selectedPeriode = session('periode_aktif_guru');
        $periode = $selectedPeriode ? Periode::find($selectedPeriode) : null;

        // Ambil semua periode untuk dropdown
        $periodes = Periode::orderByDesc('tahun_awal')->get();

        // Dapatkan nama tahun ajaran dari periode terpilih
        $selectedPeriodeNama = $periode?->tahun_ajaran ?? 'Pilih Periode';

        // Jumlah guru berdasarkan periode
        $guruCount = 0;
        $santriCount = 0;

        if ($periode) {
            // Guru yang terlibat di jadwal mengajar dalam periode ini
            $guruIds = JadwalMengajar::where('periode_id', $periode->id)
                ->pluck('guru_id')
                ->unique();
            $guruCount = \App\Models\Guru::whereIn('id', $guruIds)->count();

            $santriCount = \App\Models\Santri::where('periode_id', $periode->id)->count();
        }

        // Bar Chart Kehadiran berdasarkan cabang (2 bar: hadir & alfa)
        $kehadiranData = [];
        if ($periode) {
            // Daftar semua cabang (bisa juga diambil dari tabel master jika ada)
            $allCabangs = ['Sukajadi', 'Rumbai', 'Gobah 1', 'Gobah 2', 'Rawabening'];

            $jadwalIds = JadwalMengajar::where('periode_id', $periode->id)->pluck('id');

            $rawKehadiran = DetailKehadiran::whereIn('jadwal_mengajar_id', $jadwalIds)
                ->with('jadwal')
                ->get()
                ->groupBy(fn($item) => $item->jadwal->cabang ?? 'Tidak Diketahui')
                ->map(function ($items, $cabang) {
                    return [
                        'cabang' => $cabang,
                        'hadir' => $items->where('status_kehadiran', 'Hadir')->count(),
                        'alfa' => $items->where('status_kehadiran', 'Alfa')->count(),
                    ];
                });

            // Gabungkan semua cabang dengan data hasil query
            $kehadiranData = collect($allCabangs)->map(function ($cabang) use ($rawKehadiran) {
                return [
                    'cabang' => $cabang,
                    'hadir' => $rawKehadiran[$cabang]['hadir'] ?? 0,
                    'alfa' => $rawKehadiran[$cabang]['alfa'] ?? 0,
                ];
            })->values();
        }


        // Bar Chart Hafalan berdasarkan juz
        $hafalanByJuz = collect();
        if ($periode) {
            $subquery = DetailHafalan::select('santri_id', DB::raw('MAX(juz) as max_juz'))
                ->whereHas('jadwal', function ($q) use ($periode) {
                    $q->where('periode_id', $periode->id);
                })
                ->groupBy('santri_id');

            $hafalanByJuz = DB::table(DB::raw("({$subquery->toSql()}) as sub"))
                ->mergeBindings($subquery->getQuery())
                ->select('max_juz as juz', DB::raw('COUNT(*) as total'))
                ->groupBy('max_juz')
                ->orderBy('max_juz')
                ->get();
        }

        return view('admin.dashboard.master', compact(
            'guruCount',
            'santriCount',
            'kehadiranData',
            'hafalanByJuz',
            'periodes',
            'selectedPeriode',
            'selectedPeriodeNama'
        ));
    }

    // Method khusus untuk update periode via AJAX
    public function updatePeriode(Request $request)
    {
        if ($request->has('periode_id')) {
            session(['periode_aktif_guru' => $request->periode_id]);

            $selectedPeriodeNama = Periode::find($request->periode_id)?->tahun_ajaran ?? 'Pilih Periode';

            return response()->json([
                'success' => true,
                'message' => 'Periode berhasil diupdate',
                'periode_nama' => $selectedPeriodeNama
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Periode ID tidak ditemukan']);
    }
}
