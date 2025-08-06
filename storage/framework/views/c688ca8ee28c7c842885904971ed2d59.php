<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Edit Data Guru</title>
  <link rel="shortcut icon" href="<?php echo e(asset('img/image/logortq.png')); ?>" type="image/x-icon">
  <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
</head>

<body>

  <div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Profil & Logout -->
      <div class="sidebar-header">
        <!-- Profil -->
        <div style="display: flex; align-items: center; gap: 8px;">
          <img src="<?php echo e(asset('img/image/akun.png')); ?>" alt="Foto Admin"
            style="width: 40px; height: 40px; border-radius: 40%;">
          <strong>Admin</strong>
        </div>

        <!-- Tombol Logout -->
        <form method="POST" action="<?php echo e(route('logout')); ?>">
          <?php echo csrf_field(); ?>
          <button type="submit" style="background: none; border: none; cursor: pointer;">
            <img src="<?php echo e(asset('img/image/logout.png')); ?>" alt="Logout" style="width: 18px; height: 18px;">
          </button>
        </form>
      </div>

      <!-- Menu -->
      <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
      <a href="<?php echo e(route('admin.jadwalmengajar.index')); ?>">Jadwal Mengajar</a>
      <a href="<?php echo e(route('admin.dataguru.index')); ?>" class="active">Data Guru</a>
      <a href="<?php echo e(route('admin.datasantri.index')); ?>">Data Santri</a>
      <a href="<?php echo e(route('admin.kelolapengguna.index')); ?>">Kelola Pengguna</a>
      <a href="<?php echo e(route('admin.periode.index')); ?>">Periode</a>
      <a href="<?php echo e(route('admin.kategoripenilaian.index')); ?>">Kategori Penilaian</a>
      <a href="<?php echo e(route('admin.kehadiranA.index')); ?>">Kehadiran</a>
      <a href="<?php echo e(route('admin.hafalanadmin.index')); ?>">Hafalan Santri</a>
      <a href="<?php echo e(route('admin.kinerjaguru.index')); ?>">Kinerja Guru</a>
    </div>

    <!-- Main Content -->
    <div class="main">
      <div class="topbar">
        <h1>Edit Data Guru</h1>
        <img src="<?php echo e(asset('img/image/logortq.png')); ?>" alt="Logo RTQ" height="150" width="100" />
      </div>

      <!-- Form Edit Data Guru -->
      <div class="form-container">
        <div class="form-content">
          <form action="<?php echo e(route('admin.dataguru.update', $guru->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="g-form-group">
              <select name="user_id" id="user_id" style="width: 49%; padding: 8px; box-sizing: border-box;" required>
                <option value="">-- Pilih User Guru --</option>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($user->id); ?>" <?php echo e(old('user_id', $guru->user_id) == $user->id ? 'selected' : ''); ?>>
            <?php echo e($user->name); ?> (<?php echo e($user->email); ?>)
          </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>

            <!-- Tempat Lahir & Tanggal Lahir -->
            <div style="display: flex; gap: 20px; margin-bottom: 15px;">
              <input type="text" name="tempat_lahir" id="tempat_lahir" placeholder="Masukan Tempat Lahir" required
                style="flex: 1; padding: 8px; box-sizing: border-box;"
                value="<?php echo e(old('tempat_lahir', $guru->tempat_lahir)); ?>">
              <input type="date" name="tanggal_lahir" id="tanggal_lahir" required
                style="flex: 1; padding: 8px; box-sizing: border-box;"
                value="<?php echo e(old('tanggal_lahir', $guru->tanggal_lahir)); ?>">
            </div>

            <!-- Alamat & No HP -->
            <div style="display: flex; gap: 20px; margin-bottom: 15px;">
              <input type="text" name="alamat" id="alamat" placeholder="Masukan Alamat" required
                style="flex: 1; padding: 8px; box-sizing: border-box;" value="<?php echo e(old('alamat', $guru->alamat)); ?>">
              <input type="text" name="no_hp" id="no_hp" placeholder="Masukan No HP" required
                style="flex: 1; padding: 8px; box-sizing: border-box;" value="<?php echo e(old('no_hp', $guru->no_hp)); ?>">
            </div>

            <!-- Jumlah Hafalan & Jenis Kelamin -->
            <div style="display: flex; gap: 20px; margin-bottom: 15px;">
              <input type="text" name="jlh_hafalan" id="jlh_hafalan" placeholder="Masukan Jumlah Hafalan" required
                style="flex: 1; padding: 8px; box-sizing: border-box;"
                value="<?php echo e(old('jlh_hafalan', $guru->jlh_hafalan)); ?>">
              <select name="jenis_kelamin" id="jenis_kelamin" required
                style="flex: 1; padding: 8px; box-sizing: border-box;">
                <option value="" disabled>Masukan Jenis Kelamin</option>
                <option value="P" <?php echo e(old('jenis_kelamin', $guru->jenis_kelamin) == 'P' ? 'selected' : ''); ?>>Perempuan
                </option>
                <option value="L" <?php echo e(old('jenis_kelamin', $guru->jenis_kelamin) == 'L' ? 'selected' : ''); ?>>Laki-laki
                </option>
              </select>
            </div>

            <!-- Pendidikan Terakhir & Golongan Darah -->
            <div style="display: flex; gap: 20px; margin-bottom: 15px;">
              <select name="pend_akhir" id="pend_akhir" required style="flex: 1; padding: 8px; box-sizing: border-box;">
                <option value="" disabled>Masukan Pendidikan Terakhir</option>
                <option value="SD" <?php echo e(old('pend_akhir', $guru->pend_akhir) == 'SD' ? 'selected' : ''); ?>>SD</option>
                <option value="SMP/Sederajat" <?php echo e(old('pend_akhir', $guru->pend_akhir) == 'SMP/Sederajat' ? 'selected' : ''); ?>>SMP/Sederajat</option>
                <option value="SMA/Sederajat" <?php echo e(old('pend_akhir', $guru->pend_akhir) == 'SMA/Sederajat' ? 'selected' : ''); ?>>SMA/Sederajat</option>
                <option value="S1" <?php echo e(old('pend_akhir', $guru->pend_akhir) == 'S1' ? 'selected' : ''); ?>>S1</option>
                <option value="S2" <?php echo e(old('pend_akhir', $guru->pend_akhir) == 'S2' ? 'selected' : ''); ?>>S2</option>
                <option value="S3" <?php echo e(old('pend_akhir', $guru->pend_akhir) == 'S3' ? 'selected' : ''); ?>>S3</option>
              </select>
              <select name="gol_dar" id="gol_dar" required style="flex: 1; padding: 8px; box-sizing: border-box;">
                <option value="" disabled>Masukan Golongan Darah</option>
                <option value="A" <?php echo e(old('gol_dar', $guru->gol_dar) == 'A' ? 'selected' : ''); ?>>A</option>
                <option value="AB" <?php echo e(old('gol_dar', $guru->gol_dar) == 'AB' ? 'selected' : ''); ?>>AB</option>
                <option value="B" <?php echo e(old('gol_dar', $guru->gol_dar) == 'B' ? 'selected' : ''); ?>>B</option>
                <option value="O" <?php echo e(old('gol_dar', $guru->gol_dar) == 'O' ? 'selected' : ''); ?>>O</option>
              </select>
            </div>

            <!-- MK & Status Menikah -->
            <div style="display: flex; gap: 20px; margin-bottom: 15px;">
              <select name="mk" id="mk" required style="flex: 1; padding: 8px; box-sizing: border-box;">
                <option value="" disabled>Masukan MK</option>
                <?php $__currentLoopData = ['Si', 'Se', 'Ti', 'Te', 'In', 'Fi', 'Fe', 'Ii', 'Ie']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($val); ?>" <?php echo e(old('mk', $guru->mk) == $val ? 'selected' : ''); ?>><?php echo e($val); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
              <select name="status_menikah" id="status_menikah" required
                style="flex: 1; padding: 8px; box-sizing: border-box;">
                <option value="" disabled>Masukan Status Menikah</option>
                <option value="Menikah" <?php echo e(old('status_menikah', $guru->status_menikah) == 'Menikah' ? 'selected' : ''); ?>>
                  Menikah</option>
                <option value="Belum Menikah" <?php echo e(old('status_menikah', $guru->status_menikah) == 'Belum Menikah' ? 'selected' : ''); ?>>Belum Menikah</option>
              </select>
            </div>

            <!-- Bagian & Cabang -->
            <div style="display: flex; gap: 20px; margin-bottom: 15px;">
              <select name="bagian" id="bagian" required style="flex: 1; padding: 8px; box-sizing: border-box;">
                <option value="" disabled>Masukan Bagian</option>
                <?php $__currentLoopData = ['Admin', 'Yayasan', 'Guru Kelas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($bag); ?>" <?php echo e(old('bagian', $guru->bagian) == $bag ? 'selected' : ''); ?>><?php echo e($bag); ?>

          </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
              <select name="cabang" id="cabang" required style="flex: 1; padding: 8px; box-sizing: border-box;">
                <option value="" disabled>Masukan Cabang</option>
                <?php $__currentLoopData = ['Sukajadi', 'Rumbai', 'Gobah 1', 'Gobah 2', 'Rawa Bening']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($cb); ?>" <?php echo e(old('cabang', $guru->cabang) == $cb ? 'selected' : ''); ?>><?php echo e($cb); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>

            <!-- Tombol -->
            <div style="margin-top: 20px; display: flex; gap: 10px;">
              <a href="<?php echo e(route('admin.dataguru.index')); ?>">
                <button type="button"
                  style="padding: 0.5rem 1rem; background-color: #ccc; border: none;">Kembali</button>
              </a>
              <button type="submit"
                style="padding: 0.5rem 1rem; background-color: #a4e4b3; color: black; border: none;">Ubah</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const input = document.getElementById('tanggal_lahir');
      const label = document.querySelector('.date-placeholder');

      function toggleLabel() {
        if (input.value) {
          label.style.opacity = '0';
          label.style.visibility = 'hidden';
        } else {
          label.style.opacity = '1';
          label.style.visibility = 'visible';
        }
      }

      input.addEventListener('input', toggleLabel);
      toggleLabel();
    });
  </script>

</body>

</html><?php /**PATH D:\Adel\Semester 8\TA Adel\Sistem\sistemrtq\resources\views/admin/dataguru/edit.blade.php ENDPATH**/ ?>