<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Santri; // Pastikan model Santri di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SantriController extends Controller
{
    /**
     * Mengambil daftar semua santri.
     * Endpoint: GET /api/v1/santri
     */
    public function index()
    {
        // Mengambil semua data santri tanpa pagination untuk API
        $santri = Santri::all();
        return response()->json($santri);
    }

    /**
     * Menambahkan data santri baru.
     * Endpoint: POST /api/v1/santri
     */
    public function store(Request $request)
    {
        // Validasi tanpa 'unique:santri' di sini, kita cek manual nanti
        $validator = Validator::make($request->all(), [
            'nis' => 'required|string|max:255',
            'nama_santri' => 'required|string|max:255', 
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

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Cek apakah santri sudah ada (berdasarkan nama)
            // Bisa diperbaiki logikanya dengan cek NIS juga jika NIS dianggap unique key
            $santri = Santri::where('nama_santri', $request->nama_santri)->first();

            if ($santri) {
                // UPDATE data yang ada
                $santri->update($validator->validated());
                $message = 'Data santri berhasil diperbarui';
                $status = 200;
            } else {
                // CREATE data baru
                // Cek unique manual jika perlu, tapi karena logic di atas else, pasti belum ada
                $santri = Santri::create($validator->validated());
                $message = 'Data santri berhasil ditambahkan';
                $status = 201;
            }

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => $santri
            ], $status);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mengambil detail satu santri berdasarkan ID.
     * Endpoint: GET /api/v1/santri/{id}
     */
    public function show($id)
    {
        // Menggunakan findOrFail untuk otomatis handle jika data tidak ada
        $santri = Santri::findOrFail($id);
        return response()->json($santri);
    }

    /**
     * Mengambil data hafalan milik seorang santri.
     * Endpoint: GET /api/v1/santri/{id}/hafalan
     */
    public function getHafalan($id)
    {
        $santri = Santri::findOrFail($id);

        // Menggunakan relasi 'detailHafalan' yang sudah kita definisikan di Model Santri
        return response()->json($santri->detailHafalan);
    }

    /**
     * Mengambil data kehadiran milik seorang santri.
     * Endpoint: GET /api/v1/santri/{id}/kehadiran
     */
    public function getKehadiran($id)
    {
        $santri = Santri::findOrFail($id);
        
        // Menggunakan relasi 'detailKehadiran' yang sudah kita definisikan di Model Santri
        return response()->json($santri->detailKehadiran);
    }
}