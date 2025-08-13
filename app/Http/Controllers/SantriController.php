<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\Santri;
use Illuminate\Http\Request;

class SantriController extends Controller
{
    public function index(Request $request)
    {
        $search           = $request->input('search');
        $perPage          = $request->input('perPage', 10);
        $selectedPeriode  = session('periode_aktif_guru');

        // ==== FILTER BARU ====
        $filterPeriodeId  = $request->input('periode_id');   // opsional, intersect dgn session bila ada
        $filterKelas      = $request->input('kelas');
        $filterJenisKelas = $request->input('jenis_kelas');
        $filterCabang     = $request->input('cabang');
        $filterJK         = $request->input('jenis_kelamin'); // L/P

        $query = Santri::with('periode');

        if ($selectedPeriode !== null) {
            $query->where('periode_id', $selectedPeriode);
        }

        // Terapkan filter tambahan (semua bersifat AND)
        if (!empty($filterPeriodeId)) {
            $query->where('periode_id', $filterPeriodeId);
        }

        if (!empty($filterKelas)) {
            $query->where('kelas', $filterKelas);
        }

        if (!empty($filterJenisKelas)) {
            $query->where('jenis_kelas', $filterJenisKelas);
        }

        if (!empty($filterCabang)) {
            $query->where('cabang', $filterCabang);
        }

        if (!empty($filterJK) && in_array($filterJK, ['L','P'], true)) {
            $query->where('jenis_kelamin', $filterJK);
        }

        // Perbaiki pencarian agar OR dikelompokkan (tidak merusak where lain)
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_santri', 'like', "%{$search}%")
                  ->orWhere('tempat_lahir', 'like', "%{$search}%")
                  ->orWhere('tanggal_lahir', 'like', "%{$search}%")
                  ->orWhere('asal', 'like', "%{$search}%")
                  ->orWhere('kelas', 'like', "%{$search}%")
                  ->orWhere('jenis_kelas', 'like', "%{$search}%")
                  ->orWhere('cabang', 'like', "%{$search}%");
            });
        }

        $santris = $query->latest()->paginate($perPage)->withQueryString();

        // Data untuk pilihan filter (distinct)
        $periodes        = Periode::orderBy('tahun_ajaran', 'desc')->get();
        $kelasList       = Santri::select('kelas')->whereNotNull('kelas')->distinct()->orderBy('kelas')->pluck('kelas');
        $jenisKelasList  = Santri::select('jenis_kelas')->whereNotNull('jenis_kelas')->distinct()->orderBy('jenis_kelas')->pluck('jenis_kelas');
        $cabangList      = Santri::select('cabang')->whereNotNull('cabang')->distinct()->orderBy('cabang')->pluck('cabang');

        return view('admin.datasantri.index', compact(
            'santris', 'search', 'perPage',
            'periodes', 'kelasList', 'jenisKelasList', 'cabangList',
            'filterPeriodeId', 'filterKelas', 'filterJenisKelas', 'filterCabang', 'filterJK'
        ));
    }

    public function create()
    {
        $periodes = Periode::all();
        return view('admin.datasantri.tambah', compact('periodes'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nis' => 'required|string|max:255',
            'nama_santri' => 'required|string|max:255|unique:santri',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'GolDar' => 'required|string|max:2',
            'MK' => 'required|string|max:2',
            'email' => 'required|email|max:255',
            'NoHP_ortu' => 'required|string|max:20',
            'asal_sekolah' => 'required|string|max:255',
            'pekerjaan_ortu' => 'required|string|max:255',
            'nama_ortu' => 'required|string|max:255',
            'kat_masuk' => 'required|string|max:100',
            'asal' => 'required|string|max:255',
            'kelas' => 'required|string|max:100',
            'jenis_kelas' => 'required|string|max:100',
            'cabang' => 'required|string|max:100',
            'periode_id' => 'required|exists:periode,id',
        ]);

        Santri::create($validatedData);

        return redirect()->route('admin.datasantri.index')->with('success', 'Data santri berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $santri = Santri::findOrFail($id);
        return view('admin.datasantri.detail', compact('santri'));
    }

    public function edit(string $id)
    {
        $santri = Santri::findOrFail($id);
        $periodes = Periode::all();
        return view('admin.datasantri.edit', compact('santri', 'periodes'));
    }

    public function update(Request $request, string $id)
    {
        $santri = Santri::findOrFail($id);

        $validated = $request->validate([
            'nis' => 'required|string|max:255',
            'nama_santri' => 'required|string|max:255|unique:santri,nama_santri,' . $id,
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'GolDar' => 'required|string|max:2',
            'MK' => 'required|string|max:2',
            'email' => 'required|email|max:255',
            'NoHP_ortu' => 'required|string|max:20',
            'asal_sekolah' => 'required|string|max:255',
            'pekerjaan_ortu' => 'required|string|max:255',
            'nama_ortu' => 'required|string|max:255',
            'kat_masuk' => 'required|string|max:100',
            'asal' => 'required|string|max:255',
            'kelas' => 'required|string|max:100',
            'jenis_kelas' => 'required|string|max:100',
            'cabang' => 'required|string|max:100',
            'periode_id' => 'required|exists:periode,id',
        ]);

        $santri->update($validated);

        return redirect()->route('admin.datasantri.index')->with('success', 'Data santri berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $santri = Santri::findOrFail($id);
        $santri->delete();

        return redirect()->route('admin.datasantri.index')->with('success', 'Data santri berhasil dihapus.');
    }

    public function history(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10);

        $query = Santri::with('periode');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_santri', 'like', "%{$search}%")
                  ->orWhere('tempat_lahir', 'like', "%{$search}%")
                  ->orWhere('tanggal_lahir', 'like', "%{$search}%")
                  ->orWhere('asal', 'like', "%{$search}%")
                  ->orWhere('kelas', 'like', "%{$search}%")
                  ->orWhere('jenis_kelas', 'like', "%{$search}%")
                  ->orWhere('cabang', 'like', "%{$search}%");
            });
        }

        $santris = $query->latest()->paginate($perPage)->withQueryString();

        return view('admin.datasantri.history', compact('santris', 'search', 'perPage'));
    }
}
