<?php

namespace App\Http\Controllers;

use App\Models\DetailHafalan;
use App\Models\JadwalMengajar;
use App\Models\Periode;
use App\Models\Santri;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class DetailHafalanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $guru = $user->guru;
        $listPeriode = Periode::orderBy('tahun_awal', 'asc')->get();

        // Gunakan session periode aktif
        $selectedPeriode = session('periode_aktif_guru');

        if ($guru) {
            $jadwal = JadwalMengajar::where('guru_id', $guru->id)
                ->when($selectedPeriode, fn($q) => $q->where('periode_id', $selectedPeriode))
                ->get();
            $kelasUnik = $jadwal->pluck('kelas')->unique();
        } else {
            $jadwal = collect();
            $kelasUnik = collect();
        }

        return view('guru.hafalansantri.index', compact('jadwal', 'kelasUnik', 'listPeriode', 'selectedPeriode'));
    }

    public function input($namaKelas)
    {
        $user = Auth::user();
        $guru = $user->guru;

        // Gunakan session periode aktif
        $periodeId = session('periode_aktif_guru');
        $tanggal = request('tanggal') ?? Carbon::now()->toDateString();
        $namaKelas = ucfirst($namaKelas);

        $surahList = json_decode(File::get(resource_path('data/surah.json')), true);
        $juzList = json_decode(File::get(resource_path('data/juz.json')), true);

        $jadwal = JadwalMengajar::where('guru_id', $guru->id)
            ->where('kelas', $namaKelas)
            ->when($periodeId, fn($q) => $q->where('periode_id', $periodeId))
            ->with(['guru', 'periode'])
            ->get();

        if (!$jadwal || $jadwal->isEmpty()) {
            return redirect()->route('guru.hafalansantri.index')->with('error', 'Jadwal mengajar tidak ditemukan.');
        }

        $santri = Santri::where('kelas', $namaKelas)
            ->where('cabang', $guru->cabang)
            ->when($periodeId, fn($q) => $q->where('periode_id', $periodeId))
            ->get();

        $jadwalId = $jadwal->first()?->id;
        $draftHafalan = DetailHafalan::where('jadwal_mengajar_id', $jadwalId)
            ->whereDate('tanggal', $tanggal)
            ->where('is_draft', true)
            ->get()
            ->keyBy('santri_id');

        return view('guru.hafalansantri.input', [
            'namaKelas' => $namaKelas,
            'santri' => $santri,
            'guru' => $guru,
            'jadwal' => $jadwal,
            'listSurah' => $surahList,
            'listJuz' => $juzList,
            'draftHafalan' => $draftHafalan,
            'tanggal' => $tanggal
        ]);
    }

    public function detail($kelas)
    {
        $surahList = json_decode(File::get(resource_path('data/surah.json')), true);
        $juzList = json_decode(File::get(resource_path('data/juz.json')), true);

        // Gunakan periode aktif dari session
        $selectedPeriode = session('periode_aktif_guru');

        // Ambil data guru login
        $guru = Auth::user()->guru;

        // Ambil santri sesuai kriteria
        $santri = Santri::where('kelas', 'like', '%' . $kelas . '%')
            ->where('periode_id', $selectedPeriode) // sesuai periode aktif
            ->where('cabang', $guru->cabang)        // sesuai cabang guru
            ->get();

        return view('guru.hafalansantri.detail', [
            'santri' => $santri,
        ]);
    }


    public function store(Request $request)
    {
        $rawSurah = json_decode(File::get(resource_path('data/surah.json')), true);
        $rawJuz = json_decode(File::get(resource_path('data/juz.json')), true);

        $surahList = collect($rawSurah['data'])->pluck('name.transliteration.id')->toArray();
        $juzList = collect($rawJuz['data'])->pluck('juz')->map(fn($val) => (string) $val)->toArray();

        $request->validate([
            'tanggal' => 'required|date',
            'jadwal_mengajar_id' => 'required|integer|exists:jadwal_mengajar,id',
            'hafalan' => 'required|array',
            'hafalan.*.santri_id' => 'required|exists:santri,id',
            'hafalan.*.surah' => ['nullable', 'string', Rule::in($surahList)],
            'hafalan.*.juz' => ['nullable', 'string', Rule::in($juzList)],
            'hafalan.*.ayat_awal' => 'nullable|string',
            'hafalan.*.ayat_akhir' => 'nullable|string',
        ]);

        foreach ($request->hafalan as $data) {
            DetailHafalan::updateOrCreate(
                [
                    'santri_id' => $data['santri_id'],
                    'jadwal_mengajar_id' => $request->jadwal_mengajar_id,
                    'tanggal' => $request->tanggal,
                ],
                [
                    'surah' => $data['surah'],
                    'juz' => $data['juz'],
                    'ayat_awal' => $data['ayat_awal'],
                    'ayat_akhir' => $data['ayat_akhir'],
                    'is_draft' => false
                ]
            );
        }

        return redirect()->route('guru.hafalansantri.detail', [
            'kelas' => $request->kelas,
            'tanggal' => $request->tanggal,
        ])->with('success', 'Hafalan Santri berhasil disimpan.');
    }

    public function simpanDraft(Request $request)
    {
        foreach ($request->hafalan as $data) {
            if (!empty($data['surah']) || !empty($data['juz']) || !empty($data['ayat_awal']) || !empty($data['ayat_akhir'])) {
                DetailHafalan::updateOrCreate(
                    [
                        'santri_id' => $data['santri_id'],
                        'jadwal_mengajar_id' => $request->jadwal_mengajar_id,
                        'tanggal' => $request->tanggal,
                    ],
                    [
                        'surah' => $data['surah'] ?? null,
                        'juz' => $data['juz'] ?? null,
                        'ayat_awal' => $data['ayat_awal'] ?? null,
                        'ayat_akhir' => $data['ayat_akhir'] ?? null,
                        'is_draft' => true
                    ]
                );
            }
        }

        $kelas = $request->kelas;
        $tanggal = $request->tanggal;

        return redirect()->route('guru.hafalansantri.input', [
            'kelas' => $kelas,
            'tanggal' => $tanggal
        ])->with('success', 'Draft berhasil disimpan.');
    }

    public function getHafalanByDate($kelas, $tanggal)
    {
        $user = Auth::user();
        $guru = $user->guru;

        // Gunakan session periode aktif
        $periodeId = session('periode_aktif_guru');
        $page = request('page', 1);
        $perPage = 10;

        try {
            $parseDate = Carbon::parse($tanggal)->toDateString();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Format tanggal tidak valid.'], 400);
        }

        $jadwal = JadwalMengajar::where('guru_id', $guru->id)
            ->where('kelas', $kelas)
            ->when($periodeId, fn($q) => $q->where('periode_id', $periodeId))
            ->first();

        if (!$jadwal) {
            return response()->json([]);
        }

        $query = DetailHafalan::where('jadwal_mengajar_id', $jadwal->id)
            ->whereDate('tanggal', $parseDate)
            ->with('santri');

        $total = $query->count();
        $items = Santri::where('kelas', 'like', '%' . $kelas . '%')
            // ->when($selectedPeriode, fn($q) => $q->where('periode_id', $selectedPeriode))
            ->get();

        return response()->json([
            'data' => $items,
            'pagination' => [
                'total' => $total,
                'per_page' => $perPage,
                'current_page' => $page,
            ]
        ]);
    }
}
