
// --- DEBUG ROUTE (HAPUS NANTI) ---
Route::get('/debug-santri/{kelas}', function ($kelas) {
    if (!Auth::check()) {
        return "<h3>Silahkan Login dulu sebagai Guru!</h3>";
    }
    $user = Auth::user();
    $guru = $user->guru;

    if (!$guru) {
        return "<h3>User ini tidak terhubung ke data Guru!</h3>";
    }

    $selectedPeriode = session('periode_aktif_guru');
    
    echo "<h1>Debug Data Santri</h1>";
    echo "<p><strong>Analisa:</strong> Sistem mencari santri berdasarkan kriteria guru yang sedang login.</p>";
    echo "<ul>";
    echo "<li><strong>Guru:</strong> " . $guru->nama_guru . "</li>";
    echo "<li><strong>Cabang Guru (Filter 1):</strong> '" . $guru->cabang . "'</li>";
    echo "<li><strong>Periode Aktif (Filter 2):</strong> " . ($selectedPeriode ?? 'Tidak ada (Semua Periode)') . "</li>";
    echo "<li><strong>Mencari Kelas (Filter 3):</strong> '" . $kelas . "'</li>";
    echo "</ul>";
    echo "<hr>";

    // Query 1: Cek Kelas Saja (Case Insensitive)
    $santriKelas = \App\Models\Santri::whereRaw('LOWER(kelas) = ?', [strtolower($kelas)])->get();
    echo "<h3>1. Cek Kelas Saja</h3>";
    echo "Ditemukan <strong>" . $santriKelas->count() . " santri</strong> dengan nama kelas '$kelas'.<br>";
    if ($santriKelas->count() > 0) {
        echo "<ul>";
        foreach ($santriKelas as $s) {
            echo "<li>{$s->nama_santri} | Cabang: '{$s->cabang}' | Periode ID: {$s->periode_id}</li>";
        }
        echo "</ul>";
    } else {
        echo "<span style='color:red'>TIDAK ADA santri dengan nama kelas ini. Pastikan ejaan sama.</span><br>";
    }

    // Query 2: Tambah Filter Cabang
    $santriCabang = \App\Models\Santri::whereRaw('LOWER(kelas) = ?', [strtolower($kelas)])
                    ->where('cabang', $guru->cabang)
                    ->get();
    
    echo "<h3>2. Cek Kelas + Cabang Guru ('$guru->cabang')</h3>";
    if ($santriCabang->count() > 0) {
        echo "<span style='color:green'>LOLOS. Ada " . $santriCabang->count() . " santri cocok cabang.</span><br>";
    } else {
        echo "<span style='color:red'>GAGAL. Santri ada di kelas ini, tapi cabangnya BUKAN '$guru->cabang'.</span><br>";
    }

    // Query 3: Tambah Filter Periode
    $santriFinal = \App\Models\Santri::whereRaw('LOWER(kelas) = ?', [strtolower($kelas)])
                    ->where('cabang', $guru->cabang);
    
    if ($selectedPeriode) {
        $santriFinal->where('periode_id', $selectedPeriode);
    }
    $santriFinal = $santriFinal->get();

    echo "<h3>3. Hasil Akhir (Kelas + Cabang + Periode)</h3>";
    if ($santriFinal->count() > 0) {
        echo "<span style='color:green'>DITEMUKAN " . $santriFinal->count() . " SANTRI SIAP TAMPIL.</span>";
    } else {
        echo "<span style='color:red'>KOSONG. Kemungkinan masalahnya di filter Periode.</span>";
    }
    
    return "";
});
