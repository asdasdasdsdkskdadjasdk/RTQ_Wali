<!-- resources/views/admin/datasantri/index.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>RTQ Al-Yusra | Data Keseluruhan Santri</title>
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
            <a href="<?php echo e(route('admin.datasantri.index')); ?>" class="active">Data Santri</a>
            <a href="<?php echo e(route('admin.kelolapengguna.index')); ?>">Kelola Pengguna</a>
            <a href="<?php echo e(route('admin.periode.index')); ?>">Periode</a>
            <a href="<?php echo e(route('admin.kategoripenilaian.index')); ?>">Kategori Penilaian</a>
            <a href="<?php echo e(route('admin.kehadiranA.index')); ?>">Kehadiran</a>
            <a href="<?php echo e(route('admin.hafalanadmin.index')); ?>">Hafalan Santri</a>
            <a href="<?php echo e(route('admin.kinerjaguru.index')); ?>">Kinerja Guru</a>
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
                <form method="GET" action="<?php echo e(route('admin.datasantri.index')); ?>" class="table-controls"
                    style="display: flex; justify-content: space-between; gap: 10px; align-items: center;">

                    
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
                    
                    <div>

                        
                        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                            <input type="text" name="search" id="search" placeholder="Search..."
                                value="<?php echo e(request('search')); ?>"
                                style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; width: 200px;" />
                        </div>
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
                            <?php $__currentLoopData = $santris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $santri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                            <button><img src="<?php echo e(asset('img/image/edit.png')); ?>" alt="edit"
                                                    height="20" /></button>
                                        </a>
                                        <a href="<?php echo e(route('admin.datasantri.show', $santri->id)); ?>">
                                            <button class="detail"><img src="<?php echo e(asset('img/image/detail.png')); ?>"
                                                    alt="detail" height="20" /></button>
                                        </a>
                                        <form action="<?php echo e(route('admin.datasantri.destroy', $santri->id)); ?>" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');"
                                            style="display:inline;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button class="delete"><img src="<?php echo e(asset('img/image/delete.png')); ?>"
                                                    alt="delete" height="20" /></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

</html><?php /**PATH D:\Adel\Semester 8\TA Adel\Sistem\sistemrtq\resources\views/admin/datasantri/history.blade.php ENDPATH**/ ?>