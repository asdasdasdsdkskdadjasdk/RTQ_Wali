<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Data Guru</title>
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
        <a href="<?php echo e(route('admin.dataguru.index')); ?>" class="active">Data Guru</a>
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
        <h1>Data Guru</h1>
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

      <!-- Tabel Guru -->
      <div class="chart-container">
        <form method="GET" action="<?php echo e(route('admin.dataguru.index')); ?>" class="table-controls"
          style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 10px; align-items: center;">
          <div>
            Show
            <select name="perPage" onchange="this.form.submit()">
              <?php $__currentLoopData = [10, 25, 50, 100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($size); ?>" <?php echo e(request('perPage', 10) == $size ? 'selected' : ''); ?>>
          <?php echo e($size); ?>

          </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
          <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 0.5rem;">
            <input type="text" name="search" id="search" placeholder="Search..." value="<?php echo e(request('search')); ?>"
              style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; width: 200px;" />
            <a href="<?php echo e(route('admin.dataguru.create')); ?>">
              <button type="button" class="add-btn"
                style="padding: 0.5rem 1rem; background-color: #a4e4b3; color: black; border: none; border-radius: 4px; cursor: pointer;">
                Tambah
              </button>
            </a>
          </div>
        </form>

        <!-- Tabel -->
        <div style="overflow-x:auto;">
          <table>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Guru</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Alamat</th>
                <th>Jumlah Hafalan</th>
                <th>Bagian</th>
                <th>Cabang</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $__empty_1 = true; $__currentLoopData = $gurus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $guru): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
          <td><?php echo e($loop->iteration + ($gurus->currentPage() - 1) * $gurus->perPage()); ?></td>
          <td><?php echo e($guru->nama_guru); ?></td>
          <td><?php echo e($guru->tempat_lahir); ?></td>
          <td><?php echo e(\Carbon\Carbon::parse($guru->tanggal_lahir)->format('d/m/Y')); ?></td>
          <td><?php echo e($guru->alamat); ?></td>
          <td><?php echo e($guru->jlh_hafalan ?? '-'); ?></td>
          <td><?php echo e($guru->bagian); ?></td>
          <td><?php echo e($guru->cabang); ?></td>
          <td class="action-buttons">
            <a href="<?php echo e(route('admin.dataguru.edit', $guru->id)); ?>">
            <button><img src="<?php echo e(asset('img/image/edit.png')); ?>" alt="edit" height="100" /></button>
            </a>
            <a href="<?php echo e(route('admin.dataguru.show', $guru->id)); ?>">
            <button class="detail"><img src="<?php echo e(asset('img/image/detail.png')); ?>" alt="detail"
              height="100" /></button>
            </a>
            <form action="<?php echo e(route('admin.dataguru.destroy', $guru->id)); ?>" method="POST"
            onsubmit="return confirm('Yakin ingin menghapus?')" style="display:inline;">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button class="delete"><img src="<?php echo e(asset('img/image/delete.png')); ?>" alt="delete"
              height="100" /></button>
            </form>
          </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
          <td colspan="9" style="text-align: center;">Data guru belum tersedia.</td>
          </tr>
        <?php endif; ?>
            </tbody>
          </table>
        </div>

        <?php if($gurus->total() > 0): ?>
      <div class="pagination">
        Showing <?php echo e($gurus->firstItem()); ?> to <?php echo e($gurus->lastItem()); ?> of <?php echo e($gurus->total()); ?> entries
      </div>
    <?php endif; ?>

        <?php if($gurus->hasPages()): ?>
        <div class="box-pagination-left">
          
          <?php if($gurus->onFirstPage()): ?>
        <span class="page-box-small disabled">«</span>
        <?php else: ?>
        <a href="<?php echo e($gurus->previousPageUrl()); ?>" class="page-box-small">«</a>
        <?php endif; ?>

          
          <?php $__currentLoopData = $gurus->getUrlRange(1, $gurus->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php if($page == $gurus->currentPage()): ?>
        <span class="page-box-small active"><?php echo e($page); ?></span>
        <?php else: ?>
        <a href="<?php echo e($url); ?>" class="page-box-small"><?php echo e($page); ?></a>
        <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

          
          <?php if($gurus->hasMorePages()): ?>
        <a href="<?php echo e($gurus->nextPageUrl()); ?>" class="page-box-small">»</a>
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

</html><?php /**PATH D:\Adel\Semester 8\TA Adel\Sistem\sistemrtq\resources\views/admin/dataguru/index.blade.php ENDPATH**/ ?>