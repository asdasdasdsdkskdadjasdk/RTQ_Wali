<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\DetailHafalan;
use Illuminate\Http\Request;

class HafalanSantriGuruController extends Controller
{
    // ... method lain tetap

    /**
     * Halaman detail hafalan per SANTRI, dikelompokkan per JUZ
     */
    public function detailSantri(Santri $santri, Request $request)
    {
        $hafalans = DetailHafalan::where('santri_id', $santri->id)
            ->orderBy('tanggal', 'desc')
            ->orderBy('juz')
            ->get();

        // Kelompokkan berdasarkan JUZ
        $groupedByJuz = $hafalans->groupBy('juz');

        return view('guru.hafalansantri.detailSantri', [
            'santri'       => $santri,
            'groupedByJuz' => $groupedByJuz,
        ]);
    }
}
