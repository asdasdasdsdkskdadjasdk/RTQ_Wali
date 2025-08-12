<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Tambah Data Santri</title>
  <link rel="shortcut icon" href="<?php echo e(asset('img/image/logortq.png')); ?>" type="image/x-icon">
  <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

  <div class="container">
    <!-- Bagian Sidebar -->
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

        <a href="<?php echo e(route('dashboard')); ?>"><i class="fas fa-home" style="margin-right:8px;"></i>Dashboard</a>
        <a href="<?php echo e(route('admin.jadwalmengajar.index')); ?>"><i class="fas fa-calendar-alt"
            style="margin-right:8px;"></i>Jadwal Mengajar</a>
        <a href="<?php echo e(route('admin.dataguru.index')); ?>"><i class="fas fa-chalkboard-teacher"
            style="margin-right:8px;"></i>Data Guru</a>
        <a href="<?php echo e(route('admin.datasantri.index')); ?>" class="active"><i class="fas fa-users"
            style="margin-right:8px;"></i>Data Santri</a>
        <a href="<?php echo e(route('admin.kelolapengguna.index')); ?>"><i class="fas fa-user-cog"
            style="margin-right:8px;"></i>Kelola Pengguna</a>
        <a href="<?php echo e(route('admin.periode.index')); ?>"><i class="fas fa-clock" style="margin-right:8px;"></i>Periode</a>
        <a href="<?php echo e(route('admin.kategoripenilaian.index')); ?>"><i class="fas fa-list-ul"
            style="margin-right:8px;"></i>Kategori Penilaian</a>
        <a href="<?php echo e(route('admin.kehadiranA.index')); ?>"><i class="fas fa-check-circle"
            style="margin-right:8px;"></i>Kehadiran</a>
        <a href="<?php echo e(route('admin.hafalanadmin.index')); ?>"><i class="fas fa-book" style="margin-right:8px;"></i>Hafalan
          Santri</a>
        <a href="<?php echo e(route('admin.kinerjaguru.index')); ?>"><i class="fas fa-chart-line"
            style="margin-right:8px;"></i>Kinerja Guru</a>
      </div>

      <!-- Bagian Bawah -->
      <div style="border-top: 1px solid #ddd; padding-top: 10px;">
        <a href="<?php echo e(route('password.editAdmin')); ?>"><i class="fas fa-key" style="margin-right:8px;"></i>Ubah
          Password</a>
      </div>
    </div>

    <!-- Main Content -->
    <div class="main">
      <div class="topbar">
        <h1>Tambah Data Santri</h1>
        <img src="<?php echo e(asset('img/image/logortq.png')); ?>" alt="Logo RTQ" height="150" width="100" />
      </div>

      <div class="form-container">
        <form action="<?php echo e(route('admin.datasantri.store')); ?>" method="POST">
          <?php echo csrf_field(); ?>

          <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 0.5rem 1rem;">

            <?php
        $fields = [
          ['nama_santri', 'Nama Santri'],
          ['tempat_lahir', 'Tempat Lahir'],
          ['tanggal_lahir', 'Tanggal Lahir', 'date'],
          ['asal', 'Asal'],
          ['nis', 'NIS'],
          ['email', 'Email'],
          ['asal_sekolah', 'Asal Sekolah'],
          ['nama_ortu', 'Nama Orang Tua'],
          ['NoHP_ortu', 'No HP Orang Tua'],
          ['pekerjaan_ortu', 'Pekerjaan Orang Tua'],
        ];
        ?>

            <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div style="display: flex; flex-direction: column;">
          <label for="<?php echo e($f[0]); ?>"><strong><?php echo e($f[1]); ?> <span style="color:red;">*</span></strong></label>
          <input type="<?php echo e($f[2] ?? 'text'); ?>" name="<?php echo e($f[0]); ?>" id="<?php echo e($f[0]); ?>" placeholder="Masukan <?php echo e($f[1]); ?>"
          required>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <!-- Dropdown fields with label + bintang merah -->
            <div style="display: flex; flex-direction: column;">
              <label for="MK"><strong>MK <span style="color:red;">*</span></strong></label>
              <select name="MK" id="MK" required>
                <option value="" disabled selected>Masukan MK</option>
                <option value="Si">Si</option>
                <option value="Se">Se</option>
                <option value="Ti">Ti</option>
                <option value="Te">Te</option>
                <option value="In">In</option>
                <option value="Fi">Fi</option>
                <option value="Fe">Fe</option>
                <option value="Ii">Ii</option>
                <option value="Ie">Ie</option>
              </select>
            </div>

            <div style="display: flex; flex-direction: column;">
              <label for="GolDar"><strong>Golongan Darah <span style="color:red;">*</span></strong></label>
              <select name="GolDar" id="GolDar" required>
                <option value="" disabled selected>Masukan Golongan Darah</option>
                <option value="A">A</option>
                <option value="AB">AB</option>
                <option value="B">B</option>
                <option value="O">O</option>
              </select>
            </div>

            <div style="display: flex; flex-direction: column;">
              <label for="jenis_kelamin"><strong>Jenis Kelamin <span style="color:red;">*</span></strong></label>
              <select name="jenis_kelamin" id="jenis_kelamin" required>
                <option value="" disabled selected>Masukan Jenis Kelamin</option>
                <option value="P">Perempuan</option>
                <option value="L">Laki-Laki</option>
              </select>
            </div>

            <div style="display: flex; flex-direction: column;">
              <label for="kat_masuk"><strong>Kategori Masuk <span style="color:red;">*</span></strong></label>
              <select name="kat_masuk" id="kat_masuk" required>
                <option value="" disabled selected>Masukan Kategori Masuk</option>
                <option value="Umum">Umum</option>
                <option value="Beasiswa">Beasiswa</option>
              </select>
            </div>

            <div style="display: flex; flex-direction: column;">
              <label for="kelas"><strong>Kelas <span style="color:red;">*</span></strong></label>
              <select name="kelas" id="kelas" required>
                <option value="" disabled selected>Masukan Kelas</option>
                <option value="Halaqah A">Halaqah A</option>
                <option value="Halaqah B">Halaqah B</option>
                <option value="Halaqah C">Halaqah C</option>
                <option value="Halaqah D">Halaqah D</option>
                <option value="Halaqah E">Halaqah E</option>
              </select>
            </div>

            <div style="display: flex; flex-direction: column;">
              <label for="periode"><strong>Periode <span style="color:red;">*</span></strong></label>
              <select name="periode_id" id="periode" required>
                <option value="" disabled selected>Pilih Periode</option>
                <?php $__currentLoopData = $periodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($p->id); ?>"><?php echo e($p->tahun_ajaran); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>

            <div style="display: flex; flex-direction: column;">
              <label for="jenis_kelas"><strong>Jenis Kelas <span style="color:red;">*</span></strong></label>
              <select name="jenis_kelas" id="jenis_kelas" required>
                <option value="" disabled selected>Jenis Kelas</option>
                <option value="1 Tahun">1 Tahun</option>
                <option value="2 Tahun">2 Tahun</option>
              </select>
            </div>

            <div style="display: flex; flex-direction: column;">
              <label for="cabang"><strong>Cabang <span style="color:red;">*</span></strong></label>
              <select name="cabang" id="cabang" required>
                <option value="" disabled selected>Masukan Cabang</option>
                <option value="Sukajadi">Sukajadi</option>
                <option value="Rumbai">Rumbai</option>
                <option value="Gobah 1">Gobah 1</option>
                <option value="Gobah 2">Gobah 2</option>
                <option value="Rawa Bening">Rawa Bening</option>
              </select>
            </div>

          </div>

          <!-- Tombol -->
          <div style="margin-top: 20px; display: flex; gap: 10px;">
            <a href="<?php echo e(route('admin.datasantri.index')); ?>">
              <button type="button" style="padding: 0.5rem 1rem; background-color: #ccc; border: none;">Kembali</button>
            </a>
            <button type="submit"
              style="padding: 0.5rem 1rem; background-color: #a4e4b3; color: black; border: none;">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</body>

</html><?php /**PATH D:\Adel\Semester 8\TA Adel\Sistem\sistemrtq\resources\views/admin/datasantri/tambah.blade.php ENDPATH**/ ?>