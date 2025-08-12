<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Data Santri</title>
  <link rel="shortcut icon" href="<?php echo e(asset('img/image/logortq.png')); ?>" type="image/x-icon">
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
        <a href="<?php echo e(route('admin.datasantri.index')); ?>" class="active"><i class="fas fa-users"
            style="margin-right:8px;"></i>Data Santri</a>
        <a href="<?php echo e(route('admin.kelolapengguna.index')); ?>"><i class="fas fa-user-cog"
            style="margin-right:8px;"></i>Kelola Pengguna</a>
        <a href="<?php echo e(route('admin.periode.index')); ?>"><i class="fas fa-clock" style="margin-right:8px;"></i>Periode</a>
        <a href="<?php echo e(route('admin.kategoripenilaian.index')); ?>"><i class="fas fa-list-ul"
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
        <h1>Data Santri</h1>
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

      <!-- Tabel Santri -->
      <div class="chart-container">
        <form method="GET" action="<?php echo e(route('admin.datasantri.index')); ?>" class="table-controls" id="filterForm"
          style="display: flex; flex-direction: column; gap: 10px;">

          
          <div
            style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; width: 100%;">

            
            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
              <input type="text" name="search" id="search" placeholder="Search..." value="<?php echo e(request('search')); ?>"
                style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; width: 200px;" />

              <a href="<?php echo e(route('admin.datasantri.create')); ?>">
                <button type="button" class="add-btn"
                  style="padding: 0.5rem 1rem; background-color: #a4e4b3; color: black; border: none; border-radius: 4px; cursor: pointer;">
                  Tambah
                </button>
              </a>
            </div>

            
            <a href="<?php echo e(route('admin.datasantri.history')); ?>">
              <button type="button"
                style="padding: 0.5rem 1rem; background-color: #a4e4b3; color: black; border: none; border-radius: 4px; cursor: pointer;">
                Filter Data Santri
              </button>
            </a>
          </div>

          
          <div>
            Show
            <select name="perPage" id="per_page" onchange="this.form.submit()">
              <?php $__currentLoopData = [10, 25, 50, 100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($size); ?>" <?php echo e(request('perPage', 10) == $size ? 'selected' : ''); ?>>
          <?php echo e($size); ?>

          </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
        </form>

        <div style="overflow-x:auto;">
          <table>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Santri</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Asal</th>
                <th>Kelas</th>
                <th>Periode</th>
                <th>Cabang</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $__empty_1 = true; $__currentLoopData = $santris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $santri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
          <td><?php echo e($loop->iteration + ($santris->currentPage() - 1) * $santris->perPage()); ?></td>
          <td><?php echo e($santri->nama_santri); ?></td>
          <td><?php echo e($santri->tempat_lahir); ?></td>
          <td><?php echo e(\Carbon\Carbon::parse($santri->tanggal_lahir)->format('d/m/Y')); ?></td>
          <td><?php echo e($santri->asal); ?></td>
          <td><?php echo e($santri->kelas); ?></td>
          <td><?php echo e($santri->periode->tahun_ajaran ?? '-'); ?></td>
          <td><?php echo e($santri->cabang); ?></td>
          <td class="action-buttons">
            <a href="<?php echo e(route('admin.datasantri.edit', $santri->id)); ?>">
            <button><img src="<?php echo e(asset('img/image/edit.png')); ?>" alt="edit" height="20" /></button>
            </a>
            <a href="<?php echo e(route('admin.datasantri.show', $santri->id)); ?>">
            <button class="detail"><img src="<?php echo e(asset('img/image/detail.png')); ?>" alt="detail"
              height="20" /></button>
            </a>
            <form action="<?php echo e(route('admin.datasantri.destroy', $santri->id)); ?>" method="POST"
            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" style="display:inline;">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button class="delete"><img src="<?php echo e(asset('img/image/delete.png')); ?>" alt="delete"
              height="20" /></button>
            </form>
          </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
          <td colspan="9" style="text-align: center;">Data santri belum tersedia.</td>
          </tr>
        <?php endif; ?>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <?php if($santris->total() > 0): ?>
      <div class="pagination">
        Showing <?php echo e($santris->firstItem()); ?> to <?php echo e($santris->lastItem()); ?> of <?php echo e($santris->total()); ?> entries
      </div>
    <?php endif; ?>

        <?php if($santris->hasPages()): ?>
        <div class="box-pagination-left">
          
          <?php if($santris->onFirstPage()): ?>
        <span class="page-box-small disabled">«</span>
        <?php else: ?>
        <a href="<?php echo e($santris->previousPageUrl()); ?>" class="page-box-small">«</a>
        <?php endif; ?>

          
          <?php $__currentLoopData = $santris->getUrlRange(1, $santris->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php if($page == $santris->currentPage()): ?>
        <span class="page-box-small active"><?php echo e($page); ?></span>
        <?php else: ?>
        <a href="<?php echo e($url); ?>" class="page-box-small"><?php echo e($page); ?></a>
        <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

          
          <?php if($santris->hasMorePages()): ?>
        <a href="<?php echo e($santris->nextPageUrl()); ?>" class="page-box-small">»</a>
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
      const perPage = document.getElementById('per_page');
      const search = document.getElementById('search');

      if (perPage && filterForm) {
        perPage.addEventListener('change', function () {
          filterForm.submit();
        });
      }

      // Submit saat user mengetik search (delay 500ms)
      if (search && filterForm) {
        let debounceTimer;
        search.addEventListener('input', function () {
          clearTimeout(debounceTimer);
          debounceTimer = setTimeout(() => {
            filterForm.submit();
          }, 500);
        });
      }
    });
  </script>
</body>

</html><?php /**PATH D:\Adel\Semester 8\TA Adel\Sistem\sistemrtq\resources\views/admin/datasantri/index.blade.php ENDPATH**/ ?>