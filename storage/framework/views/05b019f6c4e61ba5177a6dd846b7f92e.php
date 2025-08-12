<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Jadwal Mengajar</title>
  <link rel="shortcut icon" href="<?php echo e(asset('img/image/logortq.png')); ?>" type="image/x-icon">
  <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <style>
    .sidebar a {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 8px 12px;
      text-decoration: none;
      color: inherit;
    }

    .sidebar a i {
      width: 18px;
      text-align: center;
    }
  </style>
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

        <a href="<?php echo e(route('dashboard')); ?>">
          <i class="fas fa-home"></i> Dashboard
        </a>
        <a href="<?php echo e(route('admin.jadwalmengajar.index')); ?>" class="active">
          <i class="fas fa-calendar-alt"></i> Jadwal Mengajar
        </a>
        <a href="<?php echo e(route('admin.dataguru.index')); ?>">
          <i class="fas fa-chalkboard-teacher"></i> Data Guru
        </a>
        <a href="<?php echo e(route('admin.datasantri.index')); ?>">
          <i class="fas fa-users"></i> Data Santri
        </a>
        <a href="<?php echo e(route('admin.kelolapengguna.index')); ?>">
          <i class="fas fa-user-cog"></i> Kelola Pengguna
        </a>
        <a href="<?php echo e(route('admin.periode.index')); ?>">
          <i class="fas fa-clock"></i> Periode
        </a>
        <a href="<?php echo e(route('admin.kategoripenilaian.index')); ?>">
          <i class="fas fa-list-ul"></i> Kategori Penilaian
        </a>
        <a href="<?php echo e(route('admin.kehadiranA.index')); ?>">
          <i class="fas fa-check-circle"></i> Kehadiran
        </a>
        <a href="<?php echo e(route('admin.hafalanadmin.index')); ?>">
          <i class="fas fa-book"></i> Hafalan Santri
        </a>
        <a href="<?php echo e(route('admin.kinerjaguru.index')); ?>">
          <i class="fas fa-chart-line"></i> Kinerja Guru
        </a>
      </div>

      <!-- Bagian Bawah -->
      <div style="border-top: 1px solid #ddd; padding-top: 10px;">
        <a href="<?php echo e(route('password.editAdmin')); ?>">
          <i class="fas fa-key"></i> Ubah Password
        </a>
      </div>

    </div>

    <!-- Main Content -->
    <div class="main">
      <div class="topbar">
        <h1>Jadwal Mengajar</h1>
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

      <div class="chart-container">
        
        <form method="GET" action="<?php echo e(route('admin.jadwalmengajar.index')); ?>" id="filterForm" class="table-controls"
          style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 10px; align-items: center;">
          <div>
            Show
            <select name="per_page" id="per_page">
              <?php $__currentLoopData = [10, 25, 50, 100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $limit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($limit); ?>" <?php echo e(request('per_page', 10) == $limit ? 'selected' : ''); ?>>
          <?php echo e($limit); ?>

          </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
          <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 0.5rem;">
            <input type="text" name="search" id="search" placeholder="Search..." value="<?php echo e(request('search')); ?>"
              style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; width: 200px;" />
            <a href="<?php echo e(route('admin.jadwalmengajar.create')); ?>">
              <button type="button" class="add-btn"
                style="padding: 0.5rem 1rem; background-color: #a4e4b3; color: black; border: none; border-radius: 4px; cursor: pointer;">
                Tambah
              </button>
            </a>
          </div>
        </form>

        <div style="overflow-x:auto;">
          <table>
            <thead>
              <tr>
                <th>No</th>
                <th>Guru</th>
                <th>Kelas</th>
                <th>Cabang</th>
                <th>Periode</th>
                <th>Kegiatan</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $__empty_1 = true; $__currentLoopData = $jadwals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
          <td><?php echo e(($jadwals->currentPage() - 1) * $jadwals->perPage() + $loop->iteration); ?></td>
          <td><?php echo e($j->guru->nama_guru); ?></td>
          <td><?php echo e($j->kelas); ?></td>
          <td><?php echo e($j->cabang); ?></td>
          <td><?php echo e($j->periode->tahun_ajaran); ?></td>
          <td><?php echo e($j->kegiatan); ?></td>
          <td><?php echo e(\Carbon\Carbon::parse($j->jam_masuk)->format('H:i')); ?></td>
          <td><?php echo e(\Carbon\Carbon::parse($j->jam_keluar)->format('H:i')); ?></td>
          <td class="action-buttons">
<a href="<?php echo e(route('admin.jadwalmengajar.edit', $j->id)); ?>">
    <button style="background-color: #ffc107; color: white; border: none; padding: 6px 10px; border-radius: 4px; cursor: pointer;">
        <i class="fas fa-edit"></i>
    </button>
</a>

<form action="<?php echo e(route('admin.jadwalmengajar.destroy', $j->id)); ?>" method="POST" style="display:inline-block;">
    <?php echo csrf_field(); ?> 
    <?php echo method_field('DELETE'); ?>
    <button onclick="return confirm('Yakin hapus?')" 
        style="background-color: #dc3545; color: white; border: none; padding: 6px 10px; border-radius: 2px; cursor: pointer;">
        <i class="fas fa-trash"></i>
    </button>
</form>
          </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
          <td colspan="9" style="text-align:center;">Tidak ada data</td>
          </tr>
        <?php endif; ?>
            </tbody>
          </table>
        </div>

        <?php if($jadwals->total() > 0): ?>
      <div class="pagination">
        Showing <?php echo e($jadwals->firstItem()); ?> to <?php echo e($jadwals->lastItem()); ?> of <?php echo e($jadwals->total()); ?> entries
      </div>
    <?php endif; ?>

        <?php if($jadwals->hasPages()): ?>
        <div class="box-pagination-left">
          
          <?php if($jadwals->onFirstPage()): ?>
        <span class="page-box-small disabled">«</span>
        <?php else: ?>
        <a href="<?php echo e($jadwals->previousPageUrl()); ?>" class="page-box-small">«</a>
        <?php endif; ?>

          
          <?php $__currentLoopData = $jadwals->getUrlRange(1, $jadwals->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php if($page == $jadwals->currentPage()): ?>
        <span class="page-box-small active"><?php echo e($page); ?></span>
        <?php else: ?>
        <a href="<?php echo e($url); ?>" class="page-box-small"><?php echo e($page); ?></a>
        <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

          
          <?php if($jadwals->hasMorePages()): ?>
        <a href="<?php echo e($jadwals->nextPageUrl()); ?>" class="page-box-small">»</a>
        <?php else: ?>
        <span class="page-box-small disabled">»</span>
        <?php endif; ?>
        </div>
    <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Tambahkan sebelum </body> -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  
  <?php if(session('success')): ?>
    <script>
    Swal.fire({
      icon: 'success',
      title: 'Berhasil',
      text: <?php echo json_encode(session('success'), 15, 512) ?>,
      timer: 2000,
      showConfirmButton: false
    });
    </script>
  <?php endif; ?>

  
  <?php if(session('error')): ?>
    <script>
    Swal.fire({
      icon: 'error',
      title: 'Gagal',
      text: <?php echo json_encode(session('error'), 15, 512) ?>,
      timer: 2500,
      showConfirmButton: false
    });
    </script>
  <?php endif; ?>

  <script>
    // Konfirmasi Hapus
    document.querySelectorAll('form[method="POST"][action*="destroy"]').forEach(function (form) {
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        Swal.fire({
          title: 'Yakin hapus?',
          text: 'Data ini akan dihapus permanen.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Ya, Hapus',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    });

    // Konfirmasi Logout
    const logoutForm = document.querySelector('form[action*="logout"]');
    if (logoutForm) {
      logoutForm.addEventListener('submit', function (e) {
        e.preventDefault();
        Swal.fire({
          title: 'Keluar dari akun?',
          text: 'Anda akan logout dari sistem.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Ya, Logout',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            logoutForm.submit();
          }
        });
      });
    }
  </script>

</body>

</html><?php /**PATH D:\Adel\Semester 8\TA Adel\Sistem\sistemrtq\resources\views/admin/jadwalmengajar/index.blade.php ENDPATH**/ ?>