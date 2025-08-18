<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\JawabanKinerja;
use App\Models\Kategori;
use App\Models\KinerjaGuru;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KinerjaGuruController extends Controller
{
    public function input(Request $request)
    {
        $allPeriode = Periode::all();
        $kategoriPertanyaan = Kategori::all();

        // Gunakan session periode aktif
        $selectedPeriode = session('periode_aktif_guru');
        $availableGuru = collect();

        // Ambil guru dari jadwal_mengajar sesuai periode
        if ($selectedPeriode) {
            $guruDariJadwal = DB::table('jadwal_mengajar')
                ->where('periode_id', $selectedPeriode)
                ->join('guru', 'jadwal_mengajar.guru_id', '=', 'guru.id')
                ->where('guru.bagian', 'Guru Kelas')
                ->select('guru.id', 'guru.nama_guru')
                ->distinct()
                ->get();

            // Filter guru yang belum diisi kinerjanya
            $availableGuru = $guruDariJadwal->filter(function ($g) use ($selectedPeriode) {
                return !KinerjaGuru::where('nama_guru', $g->nama_guru)
                    ->where('periode_id', $selectedPeriode)
                    ->exists();
            });
        }

        // Ambil data guru yang sedang dipilih (kalau ada)
        $guru = null;
        $periode = null;
        $jumlahTelat = 0;

        if ($request->filled('nama_guru') && $selectedPeriode) {
            $guru = Guru::where('nama_guru', $request->nama_guru)->first();
            $periode = Periode::find($selectedPeriode);
            $jumlahTelat = $this->calculateTerlambatCount($request->nama_guru, $selectedPeriode);
        } elseif ($selectedPeriode) {
            // Supaya bisa akses periode di tampilan walaupun nama_guru belum dipilih
            $periode = Periode::find($selectedPeriode);
        }

        return view('yayasan.kategorinilai.index', [
            'allPeriode' => $allPeriode,
            'guru' => $guru,
            'periode' => $periode,
            'jumlahTelat' => $jumlahTelat,
            'kategoriPertanyaan' => $kategoriPertanyaan,
            'availableGuru' => $availableGuru,
            'selectedPeriode' => $selectedPeriode,
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'nama_guru' => 'required|exists:guru,nama_guru',
            'periode_id' => 'required|exists:periode,id',
            'jumlahTelat' => 'required|numeric|min:0',
        ];

        $kategoriIds = Kategori::pluck('id')->toArray();
        foreach ($kategoriIds as $id) {
            $rules["jawaban_kategori.$id"] = 'required|integer|min:1|max:5';
        }

        $request->validate($rules);

        DB::beginTransaction();
        try {
            $kinerja = KinerjaGuru::create([
                'nama_guru' => $request->nama_guru,
                'periode_id' => $request->periode_id,
                'jumlahTelat' => $request->jumlahTelat,
            ]);

            foreach ($request->jawaban_kategori as $kategoriId => $nilai) {
                JawabanKinerja::create([
                    'kinerja_id' => $kinerja->id,
                    'kategori_id' => $kategoriId,
                    'jawaban' => $nilai,
                ]);
            }

            DB::commit();
            return redirect()->route('yayasan.dashboard')->with('success', 'Data kinerja guru berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan kinerja guru: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all(),
                'user_id' => Auth::id(),
            ]);
            return back();
        }
    }

    public function getGuruDetail($nama_guru)
    {
        $guru = Guru::where('nama_guru', $nama_guru)->first();
        if (!$guru) {
            return response()->json(['error' => 'Guru tidak ditemukan'], 404);
        }

        return response()->json([
            'nama_guru' => $guru->nama_guru,
            'bagian' => $guru->bagian,
            'cabang' => $guru->cabang,
        ]);
    }

    public function calculateJumlahTerlambat(Request $request)
    {
        $request->validate([
            'nama_guru' => 'required|exists:guru,nama_guru',
            'periode_id' => 'required|exists:periode,id',
        ]);

        $jumlahTelat = $this->calculateTerlambatCount(
            $request->nama_guru,
            $request->periode_id
        );

        $guru = Guru::where('nama_guru', request()->nama_guru)->first();
        $jadwal = $guru->jadwalMengajar()
            ->where('periode_id', $request->periode_id)
            ->with([
                'dokumentasi' => function ($q) {
                    $q->where('status_terlambat', 'Terlambat')
                        ->orderBy('tanggal', 'desc');
                }
            ])
            ->get();

        // Flatten semua dokumentasi terlambat
        $detailTelat = [];
        foreach ($jadwal as $j) {
            foreach ($j->dokumentasi as $dok) {
                $detailTelat[] = [
                    'kegiatan' => $j->kegiatan,
                    'created_at' => $dok->tanggal,
                ];
            }
        }

        return response()->json([
            'jumlahTelat' => $jumlahTelat,
            'jadwal' => $detailTelat,
        ]);
    }

    private function calculateTerlambatCount($namaGuru, $periodeId)
    {
        $guru = Guru::where('nama_guru', $namaGuru)->first();
        if (!$guru)
            return 0;

        $jadwal = $guru->jadwalMengajar()
            ->where('periode_id', $periodeId)
            ->withCount([
                'dokumentasi' => function ($q) {
                    $q->where('status_terlambat', 'Terlambat');
                }
            ])->get();

        return $jadwal->sum('dokumentasi_count');
    }
}