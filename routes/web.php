<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailHafalanController;
use App\Http\Controllers\DetailKehadiranController;
use App\Http\Controllers\HafalanSantriController;
use App\Http\Controllers\KehadiranAdminController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\KinerjaGuruController;
use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardGuruController;
use App\Http\Controllers\JadwalMengajarController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardYayasanController;
use App\Http\Controllers\DetailHafalanAdminController;
use App\Http\Controllers\GuruProfileController;
use App\Http\Controllers\HafalanAdminController;
use App\Http\Controllers\HafalanSantriGuruController;
use App\Http\Controllers\HafalanYayasanController;
use App\Http\Controllers\KehadiranYayasanController;
use App\Http\Controllers\KinerjaGuruAdminController;



Route::middleware(['auth'])->group(function () {
    Route::get('/password/editAdmin', [PasswordController::class, 'editAdmin'])->name('password.editAdmin');
    Route::get('/password/editGuru', [PasswordController::class, 'editGuru'])->name('password.editGuru');
    Route::get('/password/editYayasan', [PasswordController::class, 'editYayasan'])->name('password.editYayasan');
    Route::put('/password/update', [PasswordController::class, 'update'])->name('password.update');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard-guru', [DashboardGuruController::class, 'index'])->name('dashboard-guru');
    Route::post('/guru/dashboard/update-periode', [DashboardGuruController::class, 'updatePeriode'])->name('guru.dashboard.update-periode');

    Route::get('/dashboard-admin', [DashboardAdminController::class, 'index'])->name('dashboard-admin');
    Route::post('/admin/dashboard/update-periode', [DashboardAdminController::class, 'updatePeriode'])->name('admin.dashboard.update-periode');

    Route::get('/dashboard-yayasan', [DashboardYayasanController::class, 'index'])->name('dashboard-yayasan');
    Route::post('/yayasan/dashboard/update-periode', [DashboardYayasanController::class, 'updatePeriode'])->name('yayasan.dashboard.update-periode');
});

// API - Data Kehadiran
Route::prefix('api')->name('api.')->group(function () {
    // API untuk data kehadiran santri (admin)
    Route::get('admin/kehadiran/data', [KehadiranAdminController::class, 'getKehadiranData'])->name('admin.kehadiran.data');

    // API untuk data dokumentasi kegiatan (admin)
    Route::get('admin/dokumentasi/data', [KehadiranAdminController::class, 'getDokumentasiData'])->name('admin.dokumentasi.data');
});
Route::prefix('admin')->name('admin.')->group(function () {
    // ------------------- Dashboard ------------------- //
    // Route::get('/', function () {
    //     return view('admin.dashboard.master');
    // })->name('dashboard');

    // Route::get('/', [DashboardAdminController::class, 'index'])->name('dashboard');

    // ------------------- Jadwal Mengajar ------------------- //
    Route::resource('jadwalmengajar', JadwalMengajarController::class)->names('jadwalmengajar');


    // ------------------- Data Guru ------------------- //
    Route::resource('dataguru', GuruController::class)->names('dataguru');

    // ------------------- Data Santri ------------------- //
    Route::get('datasantri/history', [SantriController::class, 'history'])
        ->name('datasantri.history');
    Route::resource('datasantri', SantriController::class)->names('datasantri');


    // ------------------- Kelola Pengguna ------------------- //
    Route::prefix('kelolapengguna')->name('kelolapengguna.')->group(function () {
        Route::get('/', [PenggunaController::class, 'index'])->name('index');
        Route::get('/create', [PenggunaController::class, 'create'])->name('create');
        Route::post('/', [PenggunaController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PenggunaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PenggunaController::class, 'update'])->name('update');
        Route::delete('/{id}', [PenggunaController::class, 'destroy'])->name('destroy');
    });

    // ------------------- Periode ------------------- //
    Route::get('periode', [PeriodeController::class, 'index'])->name('periode.index');
    Route::post('periode', [PeriodeController::class, 'store'])->name('periode.store');

    // ------------------- Kategori Penilaian ------------------- //
    Route::get('kategoripenilaian', [KategoriController::class, 'index'])->name('kategoripenilaian.index');
    Route::post('kategoripenilaian', [KategoriController::class, 'store'])->name('kategoripenilaian.store');

    // ------------------- Kehadiran Admin ------------------- //
    Route::get('/kehadiranA/index', [KehadiranAdminController::class, 'index'])->name('kehadiranA.index');
    Route::get('/kehadiranA/detail', [KehadiranAdminController::class, 'detail'])->name('kehadiranA.detail');

    //tambahan tambahan tambahan
    Route::prefix('hafalanadmin')->name('hafalanadmin.')->group(function () {
        Route::get('index', [DetailHafalanAdminController::class, 'index'])->name('index');
        Route::get('detail', [DetailHafalanAdminController::class, 'detail'])->name('detail');
    });

    // Kinerja Guru
    Route::prefix('kinerjaguru')->name('kinerjaguru.')->group(function () {
        Route::get('index', [KinerjaGuruAdminController::class, 'index'])->name('index');
    });
});

//GURU//
Route::prefix('guru')->name('guru.')->group(function () {
    // Dashboard Guru
    // Route::get('/', [DashboardGuruController::class, 'index'])->name('dashboard');

    Route::prefix('kehadiranG')->name('kehadiranG.')->group(function () {
        // Input Kehadiran
        Route::get('/index', [KehadiranController::class, 'index'])->name('index');
        Route::get('/input/{namaKelas}', [KehadiranController::class, 'input'])->name('input');
    });

    Route::prefix('detailKehadiran')->name('detailKehadiran.')->group(function () {

        Route::get('/item/{id}', [DetailKehadiranController::class, 'showSingle'])
            ->whereNumber('id')
            ->name('item.show');

        Route::put('/item/{id}', [DetailKehadiranController::class, 'updateSingle'])
            ->whereNumber('id')
            ->name('item.update');

        Route::get('/dokumentasi/{tanggal}', [DetailKehadiranController::class, 'getDokumentasi'])->name('dokumentasi');
        Route::get('/{kelas}', [DetailKehadiranController::class, 'detail'])->name('detail');
        Route::post('/store', [DetailKehadiranController::class, 'store'])->name('store');
        Route::get('/{kelas}/{tanggal}', [DetailKehadiranController::class, 'getKehadiran'])->name('data');
    });

    Route::prefix('hafalansantri')->name('hafalansantri.')->group(function () {
        Route::get('/index', [DetailHafalanController::class, 'index'])->name('index');
        Route::get('/input/{kelas}', [DetailHafalanController::class, 'input'])->name('input');
        Route::get('/detail/{kelas}', [DetailHafalanController::class, 'detail'])->name('detail');
        Route::post('/store', [DetailHafalanController::class, 'store'])->name('store');
        Route::post('/draft', [DetailHafalanController::class, 'simpanDraft'])->name('draft');

        // Pindahkan route ini ke dalam group
        // Route::get('/detail/{kelas}/{tanggal}', [DetailHafalanController::class, 'getHafalanByDate'])->name('data');
    });
});

Route::get('/api/guru/{id}', [KinerjaGuruController::class, 'getGuruDetail'])->name('api.guru.detail');
Route::get('/api/kinerja/calculate-terlambat', [KinerjaGuruController::class, 'calculateJumlahTerlambat'])->name('api.kinerja.calculateTerlambat');
// In web.php (for the view)
// Route::get('/dashboard-yayasan', [App\Http\Controllers\DashboardYayasanController::class, 'index'])->name('yayasan.dashboard');

// In api.php (or web.php if you don't mind exposing these directly)
Route::get('/api/periodes', [App\Http\Controllers\DashboardYayasanController::class, 'getAllPeriode'])->name('api.getAllPeriode');
Route::get('/api/kehadiran-santri', [App\Http\Controllers\DashboardYayasanController::class, 'getKehadiranSantriData'])->name('api.getKehadiranSantriData');
Route::get('/api/hafalan-santri', [App\Http\Controllers\DashboardYayasanController::class, 'getHafalanSantriData'])->name('api.getHafalanSantriData');
Route::get('/api/penilaian-guru', [App\Http\Controllers\DashboardYayasanController::class, 'getPenilaianGuruData'])->name('api.getPenilaianGuruData');
Route::get('/api/terlambat-guru', [App\Http\Controllers\DashboardYayasanController::class, 'getJumlahTerlambatPerGuru'])->name('api.getJumlahTerlambatPerGuru');

//YAYASAN//
Route::prefix('yayasan')->name('yayasan.')->group(function () {
    // Dashboard yayasan
    // Route::get('/', function () {
    //     return view('yayasan.dashboard.master');
    // })->name('dashboard');
    // Route::get('/', [DashboardYayasanController::class, 'index'])->name('dashboard');


    Route::prefix('kehadiranY')->name('kehadiranY.')->group(function () {
        // Halaman memilih cabang
        Route::get('/index', [KehadiranYayasanController::class, 'index'])->name('index');

        // Halaman detail grafik berdasarkan cabang dan filter periode
        Route::get('/{cabang}', [KehadiranYayasanController::class, 'detail'])->name('detail');
    });

    Route::prefix('hafalansantriY')->name('hafalansantriY.')->group(function () {
        Route::get('/index', [HafalanYayasanController::class, 'index'])->name('index');
        Route::get('/detail/{cabang}', [HafalanYayasanController::class, 'detail'])->name('detail');
    });

    Route::get('/kategorinilai', [KinerjaGuruController::class, 'input'])->name('kategorinilai.index');
    Route::post('/kategorinilai/store', [KinerjaGuruController::class, 'store'])->name('kategorinilai.store');
});

Route::get('/hafalansantri/santri/{santri}/detail',
  [HafalanSantriGuruController::class, 'detailSantri'])
  ->whereNumber('santri')
  ->name('hafalansantri.detailSantri');

Route::get('/guru/profil', [GuruProfileController::class, 'edit'])->name('guru.profile.edit');
Route::put('/guru/profil', [GuruProfileController::class, 'update'])->name('guru.profile.update');
Route::delete('/guru/detailKehadiran/{id}/cancel', [DetailKehadiranController::class, 'cancelSingle'])
        ->name('guru.detailKehadiran.cancelSingle');
Route::delete('/guru/detailKehadiran/cancel-by-date', [DetailKehadiranController::class, 'cancelByDate'])
        ->name('guru.detailKehadiran.cancelByDate');

Route::get('/guru/detailKehadiran/{id}', [\App\Http\Controllers\DetailKehadiranController::class, 'showSingle']);

Route::put('/guru/detailKehadiran/{id}', [\App\Http\Controllers\DetailKehadiranController::class, 'updateSingle']);
