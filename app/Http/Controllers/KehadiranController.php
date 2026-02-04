<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dokumentasi;
use Illuminate\Support\Facades\Auth;
use App\Models\JadwalMengajar;
use App\Models\Santri;
use App\Models\Guru;
use App\Models\Periode;
use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $guru = $user->guru;
        
        // Gunakan session periode aktif
        $selectedPeriode = session('periode_aktif_guru');
        $periodes = Periode::orderBy('tahun_awal', 'asc')->get();

        if ($guru) {
            $jadwal = JadwalMengajar::where('guru_id', $guru->id)
                ->when($selectedPeriode, fn($q) => $q->where('periode_id', $selectedPeriode))
                ->get();
            $kelasUnik = $jadwal->pluck('kelas')->unique();
        } else {
            $jadwal = collect();
            $kelasUnik = collect();
        }

        return view('guru.kehadiranG.index', compact(
            'jadwal',
            'kelasUnik',
            'periodes',
            'selectedPeriode'
        ));
    }

    public function input(Request $request, $namaKelas)
    {
        $user = Auth::user();
        $guru = $user->guru;
        // $namaKelas = ucfirst($namaKelas); // Hapus ini agar casing sesuai URL (yang seharusnya sesuai DB)
        
        // Gunakan session periode aktif
        $selectedPeriode = session('periode_aktif_guru');
        $tanggal = $request->query('tanggal') ?? now()->toDateString();
        $periodes = Periode::orderBy('tahun_awal', 'desc')->get();

        // Ambil semua jadwal untuk guru ini
        $jadwal = JadwalMengajar::where('guru_id', $guru->id)
            ->where('kelas', $namaKelas)
            ->when($selectedPeriode, fn($q) => $q->where('periode_id', $selectedPeriode))
            ->with(['guru', 'periode'])
            ->get();

        // Ambil kegiatan yang sudah pernah diinput hari ini
        $sudahInputKegiatan = Dokumentasi::whereDate('tanggal', $tanggal)
            ->whereHas('jadwal', function ($q) use ($guru, $namaKelas, $selectedPeriode) {
                $q->where('guru_id', $guru->id)
                    ->where('kelas', $namaKelas);
                if ($selectedPeriode) {
                    $q->where('periode_id', $selectedPeriode);
                }
            })
            ->with('jadwal')
            ->get()
            ->pluck('jadwal.kegiatan')
            ->unique();

        // Filter jadwal yang belum pernah diinput
        $jadwal = $jadwal->filter(function ($item) use ($sudahInputKegiatan) {
            return !$sudahInputKegiatan->contains($item->kegiatan);
        });

        // Ambil santri
        $santri = Santri::where('kelas', $namaKelas)
            ->where('cabang', $guru->cabang)
            ->when($selectedPeriode, fn($q) => $q->where('periode_id', $selectedPeriode))
            ->get();

        return view('guru.kehadiranG.input', compact(
            'namaKelas',
            'santri',
            'guru',
            'jadwal',
            'periodes',
            'selectedPeriode'
        ));
    }
}
