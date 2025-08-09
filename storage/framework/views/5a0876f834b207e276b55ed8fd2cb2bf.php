<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Ubah Password</title>
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
        <a href="<?php echo e(route('admin.periode.index')); ?>" >Periode</a>
        <a href="<?php echo e(route('admin.kategoripenilaian.index')); ?>">Kategori Penilaian</a>
        <a href="<?php echo e(route('admin.kehadiranA.index')); ?>">Kehadiran</a>
        <a href="<?php echo e(route('admin.hafalanadmin.index')); ?>">Hafalan Santri</a>
        <a href="<?php echo e(route('admin.kinerjaguru.index')); ?>">Kinerja Guru</a>
      </div>

      <!-- Bagian Bawah -->
      <div style="border-top: 1px solid #ddd; padding-top: 10px;">
        <a href="<?php echo e(route('password.editAdmin')); ?>" class="active">Ubah Password</a>
      </div>

    </div>

    <!-- Main Content -->
    <div class="main">
      <div class="topbar">
        <h1>Ubah Password</h1>
        <img src="<?php echo e(asset('img/image/logortq.png')); ?>" alt="Logo RTQ" height="150" width="100" />
      </div>

      <div class="form-container" style="margin-top: 30px;">
        <?php if(session('success')): ?>
      <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
        <?php echo e(session('success')); ?>

      </div>
    <?php endif; ?>

        <?php if($errors->any()): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
          <ul style="margin: 0; padding-left: 20px;">
          <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
        </div>
    <?php endif; ?>

        <form action="<?php echo e(route('password.update')); ?>" method="POST">
          <?php echo csrf_field(); ?>
          <?php echo method_field('PUT'); ?>

          <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 5px;">
            <!-- Password Lama -->
            <div>
              <label for="current_password"><strong>Password Lama <span style="color: red;">*</span></strong></label>
              <input type="password" name="current_password" id="current_password" required
                style="width: 100%; padding: 8px; box-sizing: border-box;">
            </div>

            <!-- Password Baru -->
            <div>
              <label for="password"><strong>Password Baru <span style="color: red;">*</span></strong></label>
              <input type="password" name="password" id="password" required
                style="width: 100%; padding: 8px; box-sizing: border-box;">
            </div>

            <!-- Konfirmasi Password Baru -->
            <div>
              <label for="password_confirmation"><strong>Konfirmasi Password Baru <span
                    style="color: red;">*</span></strong></label>
              <input type="password" name="password_confirmation" id="password_confirmation" required
                style="width: 100%; padding: 8px; box-sizing: border-box;">
            </div>
          </div>

          <!-- Tombol -->
          <div style="margin-top: 30px; display: flex; gap: 10px;">
            <a href="<?php echo e(route('dashboard')); ?>">
              <button type="button" style="padding: 10px 20px; background-color: #ccc; border: none; cursor: pointer;">
                Kembali
              </button>
            </a>
            <button type="submit" style="padding: 10px 20px; background-color: #a4e4b3; border: none; cursor: pointer;">
              Simpan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    const form = document.querySelector('form');
    form.addEventListener('submit', function (e) {
      const password = document.getElementById('password').value;
      const confirmation = document.getElementById('password_confirmation').value;
      if (password !== confirmation) {
        e.preventDefault();
        alert('Password baru dan konfirmasi tidak cocok!');
      }
    });
  </script>

</body>

</html><?php /**PATH D:\Adel\Semester 8\TA Adel\Sistem\sistemrtq\resources\views/admin/ubahPassword/change-password.blade.php ENDPATH**/ ?>