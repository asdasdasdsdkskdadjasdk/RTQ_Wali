<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Periode</title>
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
        <a href="<?php echo e(route('admin.jadwalmengajar.index')); ?>">Jadwal Mengajar</a>
        <a href="<?php echo e(route('admin.dataguru.index')); ?>">Data Guru</a>
        <a href="<?php echo e(route('admin.datasantri.index')); ?>">Data Santri</a>
        <a href="<?php echo e(route('admin.kelolapengguna.index')); ?>">Kelola Pengguna</a>
        <a href="<?php echo e(route('admin.periode.index')); ?>" class="active">Periode</a>
        <a href="<?php echo e(route('admin.kategoripenilaian.index')); ?>">Kategori Penilaian</a>
        <a href="<?php echo e(route('admin.kehadiranA.index')); ?>">Kehadiran</a>
        <a href="<?php echo e(route('admin.hafalanadmin.index')); ?>">Hafalan Santri</a>
        <a href="<?php echo e(route('admin.kinerjaguru.index')); ?>" >Kinerja Guru</a>
      </div>

      <!-- Bagian Bawah -->
      <div style="border-top: 1px solid #ddd; padding-top: 10px;">
        <a href="<?php echo e(route('password.editAdmin')); ?>">Ubah Password</a>
      </div>

    </div>

    <!-- Main Content -->
    <div class="main">
      <div class="topbar">
        <h1>Periode</h1>
        <img src="<?php echo e(asset('img/image/logortq.png')); ?>" alt="Logo RTQ" height="150" width="100" />
      </div>
      <?php if(session('success')): ?>
      <div class="alert-success">
      <?php echo e(session('success')); ?>

      </div>
    <?php endif; ?>

      <?php if(session('error')): ?>
      <div class="alert-error">
      <?php echo e(session('error')); ?>

      </div>
    <?php endif; ?>

      <div class="ka-form-container">
        <div class="kg-form-group">

          <!-- Form dan Tabel -->
          <div class="form-container">
            <!-- Form Tambah Periode -->
            <form action="<?php echo e(route('admin.periode.store')); ?>" method="POST" class="form-group">
              <?php echo csrf_field(); ?>
              <div class="form-row">
                <div class="form-item">
                  <label for="tahun_awal">Tahun Mulai</label>
                  <select name="tahun_awal" id="tahun_awal" required>
                    <option value="">Pilih Tahun Mulai</option>
                    <?php for($year = 2010; $year <= 2030; $year++): ?>
            <option value="<?php echo e($year); ?>"><?php echo e($year); ?></option>
          <?php endfor; ?>
                  </select>
                </div>

                <div style="padding-top: 28px;">-</div>

                <div class="form-item">
                  <label for="tahun_akhir">Tahun Akhir</label>
                  <select name="tahun_akhir" id="tahun_akhir" required>
                    <option value="">Pilih Tahun Akhir</option>
                    <?php for($year = 2010; $year <= 2030; $year++): ?>
            <option value="<?php echo e($year); ?>"><?php echo e($year); ?></option>
          <?php endfor; ?>
                  </select>
                </div>

                <div style="margin-top: 20px; display: flex; gap: 10px;">
                  <button type="submit"
                    style="padding: 0.5rem 1rem; background-color: #a4e4b3; color: black; border: none; border-radius: 2px; font-weight:">
                    Tambah
                  </button>
                </div>
              </div>
            </form>


            <!-- Tabel Daftar Periode -->
            <table>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tahun Ajaran</th>
                </tr>
              </thead>
              <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $periode; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td><?php echo e($index + 1); ?></td>
            <td><?php echo e($item->tahun_ajaran); ?></td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="2">Belum ada data.</td>
          </tr>
        <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    setTimeout(() => {
      const success = document.querySelector('.alert-success');
      const error = document.querySelector('.alert-error');

      if (success) {
        success.style.transition = 'opacity 0.5s ease-out';
        success.style.opacity = '0';
        setTimeout(() => success.remove(), 500);
      }

      if (error) {
        error.style.transition = 'opacity 0.5s ease-out';
        error.style.opacity = '0';
        setTimeout(() => error.remove(), 500);
      }
    }, 2000); 
  </script>

</body>

</html><?php /**PATH D:\Adel\Semester 8\TA Adel\Sistem\sistemrtq\resources\views/admin/periode/index.blade.php ENDPATH**/ ?>