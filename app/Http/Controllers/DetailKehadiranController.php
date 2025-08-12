<?php

namespace App\Http\Controllers;

use App\Models\DetailKehadiran;
use App\Models\Dokumentasi;
use App\Models\Guru;
use App\Models\JadwalMengajar;
use App\Models\Santri;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DetailKehadiranController extends Controller
{
    public function detail($kelas)
    {
        // Gunakan session periode aktif
        $selectedPeriode = session('periode_aktif_guru');
        $user = Auth::user();
        $guru = $user->guru;

        // Ambil jadwal yang sesuai kelas, guru, dan periode
        $jadwal = JadwalMengajar::where('guru_id', $guru->id)
            ->where('kelas', $kelas)
            ->when($selectedPeriode, fn($q) => $q->where('periode_id', $selectedPeriode))
            ->first();

        if (!$jadwal) {
            return redirect()->back()->with('error', 'Jadwal tidak ditemukan di periode ini.');
        }

        $santri = Santri::where('kelas', $kelas)
            ->where('periode_id', $selectedPeriode)
            ->get();

        $detail_kehadiran = DetailKehadiran::with('santri', 'jadwal')
            ->where('jadwal_mengajar_id', $jadwal->id)
            ->get();

        $listKegiatan = JadwalMengajar::where('kelas', $kelas)
            ->where('guru_id', $guru->id)
            ->whereNotNull('kegiatan')
            ->when($selectedPeriode, fn($q) => $q->where('periode_id', $selectedPeriode))
            ->distinct()
            ->pluck('kegiatan');

        return view('guru.detailKehadiran.detail', compact(
            'detail_kehadiran',
            'santri',
            'kelas',
            'listKegiatan',
            'selectedPeriode'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kelas' => 'required|string',
            'guru_id' => 'required|exists:guru,id',
            'periode_id' => 'required',
            'kegiatan' => 'required|string',
            'jam_masuk' => 'required',
            'jam_keluar' => 'required',
            'dokumentasi' => 'nullable|image|mimes:jpg,png,jpeg,jfif|max:2048',
            'jadwal_mengajar_id' => 'required|exists:jadwal_mengajar,id',
        ]);

        if (!$request->hasFile('dokumentasi')) {
            return back()->withErrors(['dokumentasi' => 'Dokumentasi kegiatan wajib diunggah.'])->withInput();
        }

        // Upload dokumentasi kegiatan
        if ($request->hasFile('dokumentasi')) {
            $dokumenPath = $request->file('dokumentasi')->store('dokumentasi_kegiatan', 'public');

            // Hitung keterlambatan
            $waktuSubmit = Carbon::now();
            $batasAbsen = Carbon::createFromFormat('H:i:s', $request->jam_masuk)->addMinutes(15);
            $statusTerlambat = $waktuSubmit->gt($batasAbsen) ? 'Terlambat' : 'Tepat Waktu';

            Dokumentasi::create([
                'dokumentasi' => $dokumenPath ?? '-',
                'jadwal_mengajar_id' => $request->jadwal_mengajar_id,
                'tanggal' => $request->tanggal,
                'waktu_submit' => $waktuSubmit->format('H:i:s'),
                'batas_absen' => $batasAbsen->format('H:i:s'),
                'status_terlambat' => $statusTerlambat,
            ]);
        }

        // Simpan data kehadiran per santri
        foreach ($request->kehadiran as $data) {
            $buktiPath = null;
            if (isset($data['bukti']) && $data['bukti']) {
                $buktiPath = $data['bukti']->store('bukti_kehadiran', 'public');
            }

            DetailKehadiran::create([
                'namasantri_id' => $data['santri_id'],
                'jadwal_mengajar_id' => $request->jadwal_mengajar_id,
                'tanggal' => $request->tanggal,
                'status_kehadiran' => $data['status_kehadiran'],
                'bukti' => $buktiPath,
            ]);
        }

        return redirect()->route('guru.detailKehadiran.detail', [
            'kelas' => $request->kelas,
            'tanggal' => $request->tanggal,
        ])->with('success', 'Kehadiran dan dokumentasi berhasil disimpan.');
    }

    public function getKehadiran($kelas, $tanggal)
    {
        $user = Auth::user();
        $guru = $user->guru;

        try {
            $parseDate = Carbon::parse($tanggal)->toDateString();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Format tanggal tidak valid.'], 400);
        }

        // Gunakan session periode aktif
        $periodeId = session('periode_aktif_guru');
        $kegiatan = request()->query('kegiatan');

        $query = JadwalMengajar::where('guru_id', $guru->id)
            ->where('kelas', $kelas)
            ->where('periode_id', $periodeId);

        if (!empty($kegiatan)) {
            $query->where('kegiatan', $kegiatan);
        }

        $jadwal = $query->first();

        if (!$jadwal) {
            return response()->json([]);
        }

        $kehadiran = DetailKehadiran::where('jadwal_mengajar_id', $jadwal->id)
            ->whereDate('tanggal', $parseDate)
            ->with(['santri' => function ($query) use ($kelas, $periodeId) {
                $query->where('kelas', $kelas)
                    ->where('periode_id', $periodeId);
            }])
            ->get();

        return response()->json($kehadiran);
    }

    public function getDokumentasi($tanggal)
    {
        try {
            $parseDate = Carbon::parse($tanggal)->toDateString();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Format tanggal tidak valid.'], 400);
        }

        // Gunakan session periode aktif
        $periodeId = session('periode_aktif_guru');
        $kegiatan = request()->query('kegiatan');

        Log::info('Filter Dokumentasi', [
            'tanggal' => $parseDate,
            'periode_id' => $periodeId,
            'kegiatan' => $kegiatan,
        ]);

        $query = Dokumentasi::whereDate('tanggal', $parseDate);

        if ($kegiatan || $periodeId) {
            $query->whereHas('jadwal', function ($q) use ($kegiatan, $periodeId) {
                if ($kegiatan) {
                    $q->where('kegiatan', $kegiatan);
                }
                if ($periodeId) {
                    $q->where('periode_id', $periodeId);
                }
            });
        }

        $dokumentasi = $query->get();
        $dokumentasiUrl = [];

        foreach ($dokumentasi as $record) {
            if (Storage::disk('public')->exists($record->dokumentasi)) {
                $dokumentasiUrl[] = Storage::url($record->dokumentasi);
            }
        }

        return response()->json(['success' => true, 'dokumentasi' => $dokumentasiUrl]);
    }

    public function cancelSingle($id, Request $request)
    {
        $user = Auth::user();
        $guru = $user->guru;

        // Cari entri kehadiran + cek kepemilikan via jadwal
        $kehadiran = DetailKehadiran::with('jadwal')
            ->where('id', $id)
            ->firstOrFail();

        // keamanan: pastikan entri ini milik guru yg login & periode aktif
        $periodeAktif = session('periode_aktif_guru');
        if (
            !$kehadiran->jadwal ||
            (int) $kehadiran->jadwal->guru_id !== (int) $guru->id ||
            ($periodeAktif && (int) $kehadiran->jadwal->periode_id !== (int) $periodeAktif)
        ) {
            return response()->json(['success' => false, 'message' => 'Tidak berhak membatalkan entri ini.'], 403);
        }

        // Hapus file bukti jika ada
        if ($kehadiran->bukti && Storage::disk('public')->exists($kehadiran->bukti)) {
            Storage::disk('public')->delete($kehadiran->bukti);
        }

        $kehadiran->delete();

        return response()->json(['success' => true, 'message' => 'Entri kehadiran dibatalkan.']);
    }

    public function cancelByDate(Request $request)
    {
        $request->validate([
            'kelas'   => 'required|string',
            'tanggal' => 'required|date',
            'kegiatan'=> 'nullable|string',
        ]);

        $user  = Auth::user();
        $guru  = $user->guru;
        $kelas = $request->kelas;
        $kegiatan = $request->kegiatan;
        $periodeId = session('periode_aktif_guru');

        $tanggal = \Carbon\Carbon::parse($request->tanggal)->toDateString();

        // Cari jadwal sesuai filter
        $jadwalQuery = JadwalMengajar::where('guru_id', $guru->id)
            ->where('kelas', $kelas);

        if ($periodeId) {
            $jadwalQuery->where('periode_id', $periodeId);
        }
        if ($kegiatan) {
            $jadwalQuery->where('kegiatan', $kegiatan);
        }

        $jadwal = $jadwalQuery->first();
        if (!$jadwal) {
            return response()->json(['success' => false, 'message' => 'Jadwal tidak ditemukan untuk filter ini.'], 404);
        }

        $list = DetailKehadiran::where('jadwal_mengajar_id', $jadwal->id)
            ->whereDate('tanggal', $tanggal)
            ->get();

        foreach ($list as $row) {
            if ($row->bukti && Storage::disk('public')->exists($row->bukti)) {
                Storage::disk('public')->delete($row->bukti);
            }
            $row->delete();
        }

        // (Opsional) Jika ingin sekalian hapus dokumentasi di tanggal tsb
        // $dok = Dokumentasi::where('jadwal_mengajar_id', $jadwal->id)
        //     ->whereDate('tanggal', $tanggal)->get();
        // foreach ($dok as $d) {
        //     if ($d->dokumentasi && \Storage::disk('public')->exists($d->dokumentasi)) {
        //         \Storage::disk('public')->delete($d->dokumentasi);
        //     }
        //     $d->delete();
        // }

        return response()->json([
            'success' => true,
            'message' => 'Semua entri kehadiran pada tanggal dipilih telah dibatalkan.'
        ]);
    }

}
