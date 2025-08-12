<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Ubah Password</title>
  <link rel="shortcut icon" href="<?php echo e(asset('img/image/logortq.png')); ?>" type="image/x-icon">
  <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
    .hamburger {
      display: none;
    }

    @media (max-width: 768px) {
      .gy-sidebar {
        position: fixed;
        top: 0;
        left: -100%;
        width: 240px;
        height: 100vh;
        background-color: white;
        z-index: 50;
        padding: 1rem;
        transition: left 0.3s ease;
      }

      .gy-sidebar.active {
        left: 0;
      }

      .hamburger {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem;
        background-color: white;
        border-radius: 0.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        z-index: 50;
      }

      .main {
        margin-left: 0 !important;
      }
    }
  </style>
</head>

<body>
  <div class="container flex">
    <!-- Sidebar -->
    <div class="gy-sidebar" id="sidebar">
      <div class="sidebar-header flex justify-between items-center mb-4">
        <div class="flex items-center gap-2">
          <img src="<?php echo e(asset('img/image/akun.png')); ?>" alt="Foto Admin"
            style="width: 40px; height: 40px; border-radius: 50%;">
          <strong>Yayasan</strong>
        </div>
        <form method="POST" action="<?php echo e(route('logout')); ?>">
          <?php echo csrf_field(); ?>
          <button type="submit" style="background: none; border: none; cursor: pointer;">
            <img src="<?php echo e(asset('img/image/logout.png')); ?>" alt="Logout" style="width: 18px; height: 18px;">
          </button>
        </form>
      </div>
      <a href="<?php echo e(route('dashboard')); ?>">
        <i class="fas fa-home"></i> Dashboard
      </a>
      <a href="<?php echo e(route('yayasan.kehadiranY.index')); ?>">
        <i class="fas fa-check-circle"></i> Kehadiran
      </a>
      <a href="<?php echo e(route('yayasan.hafalansantriY.index')); ?>">
        <i class="fas fa-book"></i> Hafalan Santri
      </a>
      <a href="<?php echo e(route('yayasan.kategorinilai.index')); ?>" >
        <i class="fas fa-chalkboard-teacher"></i> Kinerja Guru
      </a>
      <a href="<?php echo e(route('password.editYayasan')); ?>" class="active">
        <i class="fas fa-key"></i> Ubah Password
      </a>
    </div>

    <!-- Main Content -->
    <div class="main flex-1">
      <div class="gy-topbar bg-white flex justify-between items-center p-4 shadow">
        <div class="flex items-center gap-4">
          <button class="hamburger" id="toggleSidebarBtn">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
          <h1 class="text-xl font-bold">Ubah Password</h1>
        </div>
        <img src="<?php echo e(asset('img/image/logortq.png')); ?>" alt="Logo" class="h-20 bg-white p-2 rounded" />
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

          <div class="form-grid" style="max-width: 400px; margin-left: 0; gap: 15px;">
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

</html><?php /**PATH D:\Adel\Semester 8\TA Adel\Sistem\sistemrtq\resources\views/yayasan/ubahPassword/change-password.blade.php ENDPATH**/ ?>