<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Kategori Penilaian</title>
  <link rel="shortcut icon" href="<?php echo e(asset('img/image/logortq.png')); ?>" alt="Logo RTQ" height="100" type="image/x-icon">
  <!-- style css -->
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
        <a href="<?php echo e(route('admin.datasantri.index')); ?>"><i class="fas fa-users" style="margin-right:8px;"></i>Data
          Santri</a>
        <a href="<?php echo e(route('admin.kelolapengguna.index')); ?>"><i class="fas fa-user-cog"
            style="margin-right:8px;"></i>Kelola Pengguna</a>
        <a href="<?php echo e(route('admin.periode.index')); ?>" ><i class="fas fa-clock"
            style="margin-right:8px;"></i>Periode</a>
        <a href="<?php echo e(route('admin.kategoripenilaian.index')); ?>" class="active"><i class="fas fa-list-ul"
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
        <h1>Kategori Penilaian</h1>
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

          <!-- Form and Table -->
          <div class="form-container">
            <!-- Form -->
            <form action="<?php echo e(route('admin.kategoripenilaian.store')); ?>" method="POST">
              <?php echo csrf_field(); ?>
              <div class="form-group">
                <div class="form-item">
                  <label for="kategorinilai">Kategori Penilaian</label>
                  <input type="text" name="kategori" id="kategorinilai" placeholder="Masukkan Kategori Penilaian"
                    required>
                </div>
                <div style="margin-top: 20px; display: flex; gap: 10px;">
                  <button type="submit"
                    style="padding: 0.5rem 1rem; background-color: #a4e4b3; color: black; border: none; border-radius: 2px; font-weight:">
                    Tambah
                  </button>
                </div>
              </div>
            </form>

            <!-- Table -->
            <table>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kategori Penilaian</th>
                </tr>
              </thead>
              <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $kategoris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $kategori): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td><?php echo e($index + 1); ?></td>
            <td><?php echo e($kategori->kategori); ?></td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="2">Belum ada kategori penilaian.</td>
          </tr>
        <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  
  <?php if(session('success')): ?>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
      Swal.fire({
      icon: 'success',
      title: 'Berhasil',
      text: <?php echo json_encode(session('success'), 15, 512) ?>,
      timer: 2000,
      showConfirmButton: false
      });
    });
    </script>
  <?php endif; ?>

  
  <?php if(session('error')): ?>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
      Swal.fire({
      icon: 'error',
      title: 'Gagal',
      text: <?php echo json_encode(session('error'), 15, 512) ?>,
      timer: 2500,
      showConfirmButton: false
      });
    });
    </script>
  <?php endif; ?>

  <script>
    // Konfirmasi Logout
    (function () {
      const logoutForm = document.querySelector('form[action*="logout"]');
      if (!logoutForm) return;
      logoutForm.addEventListener('submit', function (e) {
        e.preventDefault();
        Swal.fire({
          title: 'Keluar dari akun?',
          text: 'Anda akan logout dari sistem.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Ya, Logout',
          cancelButtonText: 'Batal'
        }).then((res) => res.isConfirmed && logoutForm.submit());
      });
    })();

    // Konfirmasi Tambah Kategori Penilaian
    (function () {
      const form = document.querySelector('form[action*="kategoripenilaian"][method="POST"]');
      if (!form) return;
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        const input = document.getElementById('kategorinilai')?.value.trim();
        if (!input) {
          Swal.fire({
            icon: 'warning',
            title: 'Kategori kosong',
            text: 'Harap masukkan kategori penilaian.'
          });
          return;
        }
        Swal.fire({
          title: 'Tambah kategori?',
          text: `Kategori: ${input}`,
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Simpan',
          cancelButtonText: 'Batal'
        }).then((res) => res.isConfirmed && form.submit());
      });
    })();
  </script>

</body>

</html><?php /**PATH D:\Adel\Semester 8\TA Adel\Sistem\sistemrtq\resources\views/admin/kategoripenilaian/index.blade.php ENDPATH**/ ?>