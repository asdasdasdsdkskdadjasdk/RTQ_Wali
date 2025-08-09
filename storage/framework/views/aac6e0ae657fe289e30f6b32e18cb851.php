<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Tambah Jadwal Mengajar</title>
  <link rel="shortcut icon" href="<?php echo e(asset('img/image/logortq.png')); ?>" type="image/x-icon">
  <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
</head>

<body>

  <div class="container">
    <!-- Sidebar -->
    <div class="sidebar" style="display: flex; flex-direction: column; height: 100vh; justify-content: space-between;">

      <!-- Bagian Atas -->
      <div style="flex: 1; overflow-y: auto;">
        <div class="sidebar-header">
          <div style="display: flex; align-items: center; gap: 8px;">
            <img src="<?php echo e(asset('img/image/akun.png')); ?>" alt="Foto Admin"
              style="width: 40px; height: 40px; border-radius: 40%;">
            <strong>Admin</strong>
          </div>
          <form method="POST" action="<?php echo e(route('logout')); ?>" style="margin-right: 8px;">
            <?php echo csrf_field(); ?>
            <button type="submit" style="background: none; border: none; cursor: pointer; padding: 4px;">
              <img src="<?php echo e(asset('img/image/logout.png')); ?>" alt="Logout" style="width: 18px; height: 18px;">
            </button>
          </form>
        </div>

        <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
        <a href="<?php echo e(route('admin.jadwalmengajar.index')); ?>" class="active">Jadwal Mengajar</a>
        <a href="<?php echo e(route('admin.dataguru.index')); ?>">Data Guru</a>
        <a href="<?php echo e(route('admin.datasantri.index')); ?>">Data Santri</a>
        <a href="<?php echo e(route('admin.kelolapengguna.index')); ?>">Kelola Pengguna</a>
        <a href="<?php echo e(route('admin.periode.index')); ?>">Periode</a>
        <a href="<?php echo e(route('admin.kategoripenilaian.index')); ?>">Kategori Penilaian</a>
        <a href="<?php echo e(route('admin.kehadiranA.index')); ?>">Kehadiran</a>
        <a href="<?php echo e(route('admin.hafalanadmin.index')); ?>">Hafalan Santri</a>
        <a href="<?php echo e(route('admin.kinerjaguru.index')); ?>">Kinerja Guru</a>
      </div>

      <!-- Bagian Bawah -->
      <div style="border-top: 1px solid #ddd; padding-top: 10px;">
        <a href="<?php echo e(route('password.editAdmin')); ?>">Ubah Password</a>
      </div>

    </div>

    <!-- Main Content -->
    <div class="main">
      <div class="topbar">
        <h1>Tambah Jadwal Mengajar</h1>
        <img src="<?php echo e(asset('img/image/logortq.png')); ?>" alt="Logo RTQ" height="100" width="100" />
      </div>

      <!-- Form Tambah Jadwal -->
      <div class="form-container">
        <form action="<?php echo e(route('admin.jadwalmengajar.store')); ?>" method="POST">
          <?php echo csrf_field(); ?>

          <!--  Guru & Cabang -->
          <div style="display: flex; gap: 16px;">
            <div style="flex: 1;">
              <label style="display: block; margin-bottom: 4px;">
                <strong>Nama Guru <span style="color: red;">*</span></strong>
              </label>
              <select name="guru_id" required style="width: 100%; padding: 8px;">
                <option value="" disabled selected>Pilih Nama Guru</option>
                <?php $__currentLoopData = $gurus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $guru): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($guru->id); ?>"><?php echo e($guru->nama_guru); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
            <div style="flex: 1;">
              <label style="display: block; margin-bottom: 4px;">
                <strong>Cabang <span style="color: red;">*</span></strong>
              </label>
              <select name="cabang" required style="width: 100%; padding: 8px;">
                <option value="" disabled selected>Pilih Cabang</option>
                <option value="Sukajadi">Sukajadi</option>
                <option value="Rumbai">Rumbai</option>
                <option value="Gobah 1">Gobah 1</option>
                <option value="Gobah 2">Gobah 2</option>
                <option value="Rawa Bening">Rawa Bening</option>
              </select>
            </div>
          </div>

          <!-- Kelas & Kegiatan -->
          <div style="display: flex; gap: 16px; margin-top: 16px;">
            <div style="flex: 1;">
              <label style="display: block; margin-bottom: 4px;">
                <strong>Kelas <span style="color: red;">*</span></strong>
              </label>
              <select name="kelas" required style="width: 100%; padding: 8px;">
                <option value="" disabled selected>Pilih Kelas</option>
                <option value="Halaqah A">Halaqah A</option>
                <option value="Halaqah B">Halaqah B</option>
                <option value="Halaqah C">Halaqah C</option>
                <option value="Halaqah D">Halaqah D</option>
                <option value="Halaqah E">Halaqah E</option>
              </select>
            </div>
            <div style="flex: 1;">
              <label style="display: block; margin-bottom: 4px;">
                <strong>Kegiatan <span style="color: red;">*</span></strong>
              </label>
              <select name="kegiatan" required style="width: 100%; padding: 8px;">
                <option value="" disabled selected>Pilih Kegiatan</option>
                <option value="Tahajud">Tahajud</option>
                <option value="Subuh">Subuh</option>
                <option value="Dhuha">Dhuha</option>
                <option value="Dzuhur">Dzuhur</option>
                <option value="Ashar">Ashar</option>
                <option value="Magrib">Magrib</option>
                <option value="Isya">Isya</option>
                <option value="Hafalan">Hafalan</option>
                <option value="Murajaah">Muraja'ah</option>
              </select>
            </div>
          </div>

          <!-- Periode & Jam -->
          <div style="display: flex; gap: 16px; margin-top: 16px;">
            <!-- Periode -->
            <div style="flex: 1;">
              <label for="periode_id" style="display: block; margin-bottom: 4px;">
                <strong>Periode <span style="color: red;">*</span></strong>
              </label>
              <select name="periode_id" id="periode" required style="width: 100%; padding: 8px;">
                <option value="" disabled selected>Pilih Periode</option>
                <?php $__currentLoopData = $periodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($p->id); ?>"><?php echo e($p->tahun_ajaran); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>

            <!-- Jam -->
            <div style="flex: 1;">
              <label style="display: block; margin-bottom: 4px;">
                <strong>Jam <span style="color: red;">*</span></strong>
              </label>
              <div style="display: flex; align-items: center;">
                <input type="time" name="jam_masuk" required style="padding: 6px; flex: 1;">
                <span style="margin: 0 8px;">-</span>
                <input type="time" name="jam_keluar" required style="padding: 6px; flex: 1;">
              </div>
            </div>
          </div>

          <!-- Tombol -->
          <div style="margin-top: 20px; display: flex; gap: 10px;">
            <a href="<?php echo e(route('admin.jadwalmengajar.index')); ?>">
              <button type="button" style="padding: 0.5rem 1rem; background-color: #ccc; border: none;">Kembali</button>
            </a>
            <button type="submit"
              style="padding: 0.5rem 1rem; background-color: #a4e4b3; color: black; border: none;">Tambah</button>
          </div>
        </form>
      </div>

    </div>
  </div>

</body>

</html><?php /**PATH D:\Adel\Semester 8\TA Adel\Sistem\sistemrtq\resources\views/admin/jadwalmengajar/tambah.blade.php ENDPATH**/ ?>