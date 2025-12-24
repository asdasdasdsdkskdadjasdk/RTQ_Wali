<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Santri; // Pastikan model Santri di-import

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