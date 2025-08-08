<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Tambah Pengguna</title>
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
      <a href="<?php echo e(route('admin.dataguru.index')); ?>">Data Guru</a>
      <a href="<?php echo e(route('admin.datasantri.index')); ?>">Data Santri</a>
      <a href="<?php echo e(route('admin.kelolapengguna.index')); ?>" class="active">Kelola Pengguna</a>
      <a href="<?php echo e(route('admin.periode.index')); ?>">Periode</a>
      <a href="<?php echo e(route('admin.kategoripenilaian.index')); ?>">Kategori Penilaian</a>
      <a href="<?php echo e(route('admin.kehadiranA.index')); ?>">Kehadiran</a>
      <a href="<?php echo e(route('admin.hafalanadmin.index')); ?>">Hafalan Santri</a>
      <a href="<?php echo e(route('admin.kinerjaguru.index')); ?>">Kinerja Guru</a>
    </div>

    <!-- Main Content -->
    <div class="main">
      <div class="topbar">
        <h1>Tambah Pengguna</h1>
        <img src="<?php echo e(asset('img/image/logortq.png')); ?>" alt="Logo RTQ" height="150" width="100" />
      </div>


      <div class="form-container" style="margin-top: 30px;">
        <?php if($errors->any()): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
          <ul style="margin: 0; padding-left: 20px;">
          <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
        </div>
    <?php endif; ?>

        <form action="<?php echo e(route('admin.kelolapengguna.store')); ?>" method="POST">
          <?php echo csrf_field(); ?>

          <div class="form-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 5px;">

            <!-- Nama -->
            <div>
              <label for="name"><strong>Nama <span style="color: red;">*</span></strong></label>
              <input type="text" name="name" id="name" required
                style="width: 100%; padding: 8px; box-sizing: border-box;">
            </div>

            <!-- Email -->
            <div>
              <label for="email"><strong>Email <span style="color: red;">*</span></strong></label>
              <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" required
                style="width: 100%; padding: 8px; box-sizing: border-box;">
              <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <div style="color:red; font-size:0.9rem;"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Password -->
            <div>
              <label for="password"><strong>Password <span style="color: red;">*</span></strong></label>
              <input type="password" name="password" id="password" required
                style="width: 100%; padding: 8px; box-sizing: border-box;">
              <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <div style="color:red; font-size:0.9rem;"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Konfirmasi Password -->
            <div>
              <label for="password_confirmation"><strong>Konfirmasi Password <span
                    style="color: red;">*</span></strong></label>
              <input type="password" name="password_confirmation" id="password_confirmation" required
                style="width: 100%; padding: 8px; box-sizing: border-box;">
            </div>

            <!-- Role -->
            <div>
              <label for="role"><strong>Role <span style="color: red;">*</span></strong></label>
              <select name="role" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                <option value="">-- Pilih Role --</option>
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($role->name); ?>"><?php echo e(ucfirst($role->name)); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>

            <!-- Status -->
            <div>
              <label for="is_active"><strong>Status <span style="color: red;">*</span></strong></label>
              <select name="is_active" id="is_active" required
                style="width: 100%; padding: 8px; box-sizing: border-box;">
                <option value="1">Aktif</option>
                <option value="0">Nonaktif</option>
              </select>
            </div>
          </div>

          <!-- Tombol -->
          <div style="margin-top: 30px; display: flex; gap: 10px;">
            <a href="<?php echo e(route('admin.kelolapengguna.index')); ?>">
              <button type="button" style="padding: 10px 20px; background-color: #ccc; border: none; cursor: pointer;">
                Kembali
              </button>
            </a>
            <button type="submit" style="padding: 10px 20px; background-color: #a4e4b3; border: none; cursor: pointer;">
              Tambah
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
        e.preventDefault(); // hentikan form submit
        alert('Password dan konfirmasi password tidak cocok!');
      }
    });
  </script>

</body>

</html><?php /**PATH D:\Adel\Semester 8\TA Adel\Sistem\sistemrtq\resources\views/admin/kelolapengguna/tambah.blade.php ENDPATH**/ ?>