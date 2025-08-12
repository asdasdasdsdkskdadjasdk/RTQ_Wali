<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Profil Guru</title>
  <link rel="shortcut icon" href="<?php echo e(asset('img/image/logortq.png')); ?>" type="image/x-icon">
  <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .hamburger { display: none; }
    @media (max-width: 768px) {
      .gy-sidebar { position: fixed; top: 0; left: -100%; width: 240px; height: 100vh; background-color: white; z-index: 50; padding: 1rem; transition: left 0.3s ease; }
      .gy-sidebar.active { left: 0; }
      .hamburger { display: inline-flex; align-items: center; padding: 0.5rem; background-color: white; border-radius: 0.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); z-index: 50; }
      .main { margin-left: 0 !important; }
    }
  </style>
</head>

<body>
  <div class="container flex">

    <!-- Sidebar -->
    <div class="gy-sidebar" id="sidebar">
      <div class="sidebar-header flex justify-between items-center mb-4">
        <div class="flex items-center gap-2">
          <img src="<?php echo e(asset('img/image/akun.png')); ?>" alt="Foto Guru" style="width: 40px; height: 40px; border-radius: 50%;">
          <strong>Guru</strong>
        </div>
        <form method="POST" action="<?php echo e(route('logout')); ?>">
          <?php echo csrf_field(); ?>
          <button type="submit" style="background: none; border: none; cursor: pointer;">
            <img src="<?php echo e(asset('img/image/logout.png')); ?>" alt="Logout" style="width: 18px; height: 18px;">
          </button>
        </form>
      </div>
      <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
      <a href="<?php echo e(route('guru.profile.edit')); ?>">Profil Saya</a>
      <a href="<?php echo e(route('guru.kehadiranG.index')); ?>">Kehadiran</a>
      <a href="<?php echo e(route('guru.hafalansantri.index')); ?>">Hafalan Santri</a>
      <a href="<?php echo e(route('password.editGuru')); ?>">Ubah Password</a>
    </div>

    <!-- Main -->
    <div class="main flex-1">
      <div class="gy-topbar bg-white flex justify-between items-center p-4 shadow">
        <div class="flex items-center gap-4">
          <button class="hamburger" id="toggleSidebarBtn">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
          <h1 class="text-xl font-bold">Profil Saya</h1>
        </div>
        <img src="<?php echo e(asset('img/image/logortq.png')); ?>" alt="Logo" class="h-20 bg-white p-2 rounded" />
      </div>

      <div class="p-4">
        <?php if(session('success')): ?>
          <div class="mb-4 p-3 rounded bg-green-100 text-green-800 text-sm">
            <?php echo e(session('success')); ?>

          </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
          <div class="mb-4 p-3 rounded bg-red-100 text-red-800 text-sm">
            <ul class="list-disc ml-5">
              <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
          </div>
        <?php endif; ?>

        <div class="bg-white rounded-xl shadow p-4">
          <form action="<?php echo e(route('guru.profile.update')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <!-- Nama & Email (readonly mengikuti akun) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
              <div>
                <label class="block text-sm font-semibold mb-1">Nama</label>
                <input type="text" class="w-full border rounded px-3 py-2 bg-gray-100" value="<?php echo e($guru->nama_guru); ?>" readonly>
              </div>
              <div>
                <label class="block text-sm font-semibold mb-1">Email</label>
                <input type="text" class="w-full border rounded px-3 py-2 bg-gray-100" value="<?php echo e($guru->email); ?>" readonly>
              </div>
            </div>

            <!-- Tempat Lahir & Tanggal Lahir -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
              <div>
                <label class="block text-sm font-semibold mb-1">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" class="w-full border rounded px-3 py-2" required
                       value="<?php echo e(old('tempat_lahir', $guru->tempat_lahir)); ?>">
              </div>
              <div>
                <label class="block text-sm font-semibold mb-1">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="w-full border rounded px-3 py-2" required
                       value="<?php echo e(old('tanggal_lahir', $guru->tanggal_lahir)); ?>">
              </div>
            </div>

            <!-- Alamat & No HP -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
              <div>
                <label class="block text-sm font-semibold mb-1">Alamat</label>
                <input type="text" name="alamat" class="w-full border rounded px-3 py-2" required
                       value="<?php echo e(old('alamat', $guru->alamat)); ?>">
              </div>
              <div>
                <label class="block text-sm font-semibold mb-1">No HP</label>
                <input type="text" name="no_hp" class="w-full border rounded px-3 py-2" required
                       value="<?php echo e(old('no_hp', $guru->no_hp)); ?>">
              </div>
            </div>

            <!-- Hafalan & Jenis Kelamin -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
              <div>
                <label class="block text-sm font-semibold mb-1">Jumlah Hafalan</label>
                <input type="number" name="jlh_hafalan" class="w-full border rounded px-3 py-2" min="0" required
                       value="<?php echo e(old('jlh_hafalan', $guru->jlh_hafalan)); ?>">
              </div>
              <div>
                <label class="block text-sm font-semibold mb-1">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full border rounded px-3 py-2" required>
                  <option value="P" <?php echo e(old('jenis_kelamin', $guru->jenis_kelamin) == 'P' ? 'selected' : ''); ?>>Perempuan</option>
                  <option value="L" <?php echo e(old('jenis_kelamin', $guru->jenis_kelamin) == 'L' ? 'selected' : ''); ?>>Laki-laki</option>
                </select>
              </div>
            </div>

            <!-- Pendidikan & Golongan Darah -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
              <div>
                <label class="block text-sm font-semibold mb-1">Pendidikan Terakhir</label>
                <select name="pend_akhir" class="w-full border rounded px-3 py-2" required>
                  <?php $__currentLoopData = $opsiPendidikan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($p); ?>" <?php echo e(old('pend_akhir', $guru->pend_akhir) == $p ? 'selected' : ''); ?>><?php echo e($p); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
              <div>
                <label class="block text-sm font-semibold mb-1">Golongan Darah</label>
                <select name="gol_dar" class="w-full border rounded px-3 py-2" required>
                  <?php $__currentLoopData = $opsiGolDar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($g); ?>" <?php echo e(old('gol_dar', $guru->gol_dar) == $g ? 'selected' : ''); ?>><?php echo e($g); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
            </div>

            <!-- MK & Status Menikah -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
              <div>
                <label class="block text-sm font-semibold mb-1">MK</label>
                <select name="mk" class="w-full border rounded px-3 py-2" required>
                  <?php $__currentLoopData = $opsiMk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($m); ?>" <?php echo e(old('mk', $guru->mk) == $m ? 'selected' : ''); ?>><?php echo e($m); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
              <div>
                <label class="block text-sm font-semibold mb-1">Status Menikah</label>
                <select name="status_menikah" class="w-full border rounded px-3 py-2" required>
                  <?php $__currentLoopData = $opsiStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s); ?>" <?php echo e(old('status_menikah', $guru->status_menikah) == $s ? 'selected' : ''); ?>><?php echo e($s); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
            </div>

            <!-- Bagian & Cabang -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
              <div>
                <label class="block text-sm font-semibold mb-1">Bagian</label>
                <select name="bagian" class="w-full border rounded px-3 py-2" required>
                  <?php $__currentLoopData = $opsiBagian; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($b); ?>" <?php echo e(old('bagian', $guru->bagian) == $b ? 'selected' : ''); ?>><?php echo e($b); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
              <div>
                <label class="block text-sm font-semibold mb-1">Cabang</label>
                <select name="cabang" class="w-full border rounded px-3 py-2" required>
                  <?php $__currentLoopData = $opsiCabang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($c); ?>" <?php echo e(old('cabang', $guru->cabang) == $c ? 'selected' : ''); ?>><?php echo e($c); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
            </div>

            <div class="flex gap-2">
              <a href="<?php echo e(route('dashboard')); ?>">
                <button type="button" class="px-4 py-2 rounded bg-gray-200">Kembali</button>
              </a>
              <button type="submit" class="px-4 py-2 rounded bg-[#A4E4B3] font-semibold">Simpan Perubahan</button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>

  <script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebarBtn');

    if (toggleBtn) {
      toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        toggleBtn.classList.toggle('hidden');
      });

      document.addEventListener('click', function (e) {
        if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
          sidebar.classList.remove('active');
          toggleBtn.classList.remove('hidden');
        }
      });
    }
  </script>
</body>
</html>
<?php /**PATH D:\Sistem\sistemrtq\resources\views/guru/profile/edit.blade.php ENDPATH**/ ?>