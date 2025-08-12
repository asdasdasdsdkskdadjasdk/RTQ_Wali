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
    /**
     * Ambil nilai filter dari query (GET) atau session agar persist.
     */
    private function qOrSession(Request $request, string $key, $default = 'all')
    {
        $val = $request->query($key, session($key, $default));
        session([$key => $val]);
        return $val;
    }

    public function index(Request $request)
    {
        $selectedPeriode = session('periode_aktif_guru');
        $periode = $selectedPeriode ? Periode::find($selectedPeriode) : null;

        $periodes = Periode::orderByDesc('tahun_awal')->get();
        $selectedPeriodeNama = $periode?->tahun_ajaran ?? 'Pilih Periode';

        $bulanSelected = $this->qOrSession($request, 'dash_bulan', 'all');
        $juzSelected   = $this->qOrSession($request, 'dash_juz',   'all');

        // Daftar bulan & juz (pakai string agar selected() konsisten)
        $bulanList = [
            ['val' => 'all', 'label' => 'Semua Bulan'],
            ['val' => '1', 'label' => 'Januari'],
            ['val' => '2', 'label' => 'Februari'],
            ['val' => '3', 'label' => 'Maret'],
            ['val' => '4', 'label' => 'April'],
            ['val' => '5', 'label' => 'Mei'],
            ['val' => '6', 'label' => 'Juni'],
            ['val' => '7', 'label' => 'Juli'],
            ['val' => '8', 'label' => 'Agustus'],
            ['val' => '9', 'label' => 'September'],
            ['val' => '10', 'label' => 'Oktober'],
            ['val' => '11', 'label' => 'November'],
            ['val' => '12', 'label' => 'Desember'],
        ];
        $juzList = collect(range(1, 30))
            ->map(fn($n) => ['val' => (string)$n, 'label' => "Juz $n"])
            ->prepend(['val' => 'all', 'label' => 'Semua Juz'])
            ->values();

        // Kartu ringkas
        $guruCount = 0;
        $santriCount = 0;
        if ($periode) {
            $guruIds    = JadwalMengajar::where('periode_id', $periode->id)->pluck('guru_id')->unique();
            $guruCount  = Guru::whereIn('id', $guruIds)->count();
            $santriCount= Santri::where('periode_id', $periode->id)->count();
        }

        // ===== Chart Kehadiran (per cabang) =====
        $kehadiranData = collect();
        if ($periode) {
            $allCabangs = ['Sukajadi', 'Rumbai', 'Gobah 1', 'Gobah 2', 'Rawabening'];
            $jadwalIds  = JadwalMengajar::where('periode_id', $periode->id)->pluck('id');

            // Ganti ke 'tanggal' kalau tabel kehadiranmu punya kolom tanggal sendiri.
            $DATE_COLUMN_KEHADIRAN = 'tanggal';

            $rawKehadiran = DetailKehadiran::whereIn('jadwal_mengajar_id', $jadwalIds)
                ->when($bulanSelected !== 'all', function ($q) use ($bulanSelected, $DATE_COLUMN_KEHADIRAN) {
                    $q->whereMonth($DATE_COLUMN_KEHADIRAN, (int)$bulanSelected);
                })
                ->with('jadwal')
                ->get()
                ->groupBy(fn($item) => $item->jadwal->cabang ?? 'Tidak Diketahui')
                ->map(function ($items, $cabang) {
                    return [
                        'cabang' => $cabang,
                        'hadir'  => $items->where('status_kehadiran', 'Hadir')->count(),
                        'alfa'   => $items->where('status_kehadiran', 'Alfa')->count(),
                    ];
                });

            $kehadiranData = collect($allCabangs)->map(function ($cabang) use ($rawKehadiran) {
                return [
                    'cabang' => $cabang,
                    'hadir'  => data_get($rawKehadiran, "$cabang.hadir", 0),
                    'alfa'   => data_get($rawKehadiran, "$cabang.alfa", 0),
                ];
            })->values();
        }

        // ===== Chart Hafalan (by MAX juz per santri, terfilter bulan) =====
        $hafalanByJuz = collect();
        if ($periode) {
            // Penting: kolom 'juz' bertipe varchar di DB dump.
            // Kita cast ke UNSIGNED agar MAX() numerik bukan leksikal.
            $subquery = DetailHafalan::select(
                    'santri_id',
                    DB::raw('MAX(CAST(juz AS UNSIGNED)) as max_juz')
                )
                ->whereHas('jadwal', fn($q) => $q->where('periode_id', $periode->id))
                // Filter BULAN untuk hafalan pakai kolom 'tanggal' (ada di dump)
                ->when($bulanSelected !== 'all', fn($q) => $q->whereMonth('tanggal', (int)$bulanSelected))
                ->groupBy('santri_id');

            $builder = DB::table(DB::raw("({$subquery->toSql()}) as sub"))
                ->mergeBindings($subquery->getQuery())
                ->when($juzSelected !== 'all', fn($q) => $q->where('max_juz', (int)$juzSelected))
                ->select('max_juz as juz', DB::raw('COUNT(*) as total'))
                ->groupBy('max_juz')
                ->orderBy('max_juz');

            $hafalanByJuz = $builder->get();
        }

        return view('admin.dashboard.master', compact(
            'guruCount',
            'santriCount',
            'kehadiranData',
            'hafalanByJuz',
            'periodes',
            'selectedPeriode',
            'selectedPeriodeNama',
            'bulanList',
            'bulanSelected',
            'juzList',
            'juzSelected'
        ));
    }

    /**
     * AJAX update periode aktif (persist ke session).
     */
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
