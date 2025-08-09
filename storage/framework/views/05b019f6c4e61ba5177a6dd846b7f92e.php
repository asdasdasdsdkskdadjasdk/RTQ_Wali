<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Jadwal Mengajar</title>
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
            <button><img src="<?php echo e(asset('img/image/edit.png')); ?>" height="20" /></button>
            </a>
            <form action="<?php echo e(route('admin.jadwalmengajar.destroy', $j->id)); ?>" method="POST"
            style="display:inline-block;">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <button onclick="return confirm('Yakin hapus?')" class="delete">
              <img src="<?php echo e(asset('img/image/delete.png')); ?>" height="20" />
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

    document.addEventListener('DOMContentLoaded', function () {
      const filterForm = document.getElementById('filterForm');

      // Submit saat dropdown show per_page berubah
      document.getElementById('per_page').addEventListener('change', function () {
        filterForm.submit();
      });

      // Submit saat user mengetik search (delay 500ms)
      let debounceTimer;
      document.getElementById('search').addEventListener('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
          filterForm.submit();
        }, 500);
      });
    });
  </script>
</body>

</html><?php /**PATH D:\Adel\Semester 8\TA Adel\Sistem\sistemrtq\resources\views/admin/jadwalmengajar/index.blade.php ENDPATH**/ ?>