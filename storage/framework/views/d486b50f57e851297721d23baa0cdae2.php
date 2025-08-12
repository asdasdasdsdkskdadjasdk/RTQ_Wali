<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RTQ Al-Yusra | Kehadiran</title>
    <link rel="shortcut icon" href="<?php echo e(asset('img/image/logortq.png')); ?>" alt="Logo RTQ" height="100"
        type="image/x-icon">
    <!-- style css -->
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
</head>

<body>

    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar"
            style="display: flex; flex-direction: column; height: 100vh; justify-content: space-between;">

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
                            <img src="<?php echo e(asset('img/image/logout.png')); ?>" alt="Logout"
                                style="width: 18px; height: 18px;">
                        </button>
                    </form>
                </div>

                <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
                <a href="<?php echo e(route('admin.jadwalmengajar.index')); ?>">Jadwal Mengajar</a>
                <a href="<?php echo e(route('admin.dataguru.index')); ?>">Data Guru</a>
                <a href="<?php echo e(route('admin.datasantri.index')); ?>">Data Santri</a>
                <a href="<?php echo e(route('admin.kelolapengguna.index')); ?>">Kelola Pengguna</a>
                <a href="<?php echo e(route('admin.periode.index')); ?>">Periode</a>
                <a href="<?php echo e(route('admin.kategoripenilaian.index')); ?>" >Kategori Penilaian</a>
                <a href="<?php echo e(route('admin.kehadiranA.index')); ?>" class="active">Kehadiran</a>
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
                <h1>Detail Kehadiran</h1>
                <img src="<?php echo e(asset('img/image/logortq.png')); ?>" alt="Logo RTQ" height="150" width="100" />
            </div>

            <div class="ka-form-container">
                <div class="dk-form-row">
                    <label>Periode : </label>
                    <div class="dk-form-item"><?php echo e($periode->tahun_ajaran ?? '-'); ?></div>
                </div>

                <div class="dk-form-row">
                    <label>Tanggal : </label>
                    <div class="dk-form-item"><?php echo e(\Carbon\Carbon::parse($tanggal)->format('d F Y')); ?></div>
                </div>

                <div class="dk-form-row">
                    <label>Dokumentasi : </label>
                    <div class="dk-form-item">
                        <?php $__empty_1 = true; $__currentLoopData = $dokumentasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dok): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <a href="<?php echo e($dok->dokumentasi_url); ?>" target="_blank">Foto</a><br>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p>Tidak ada dokumentasi.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div id="kehadiranTableContainer">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Santri</th>
                                <th>Kelas</th>
                                <th>Guru</th>
                                <th>Kegiatan</th>
                                <th>Status Kehadiran</th>
                                <th>Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $dataKehadiran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($loop->iteration + ($dataKehadiran->currentPage() - 1) * $dataKehadiran->perPage()); ?>

                                    </td>
                                    <td><?php echo e($item->santri->nama_santri ?? '-'); ?></td>
                                    <td><?php echo e($item->jadwal->kelas ?? '-'); ?></td>
                                    <td><?php echo e($item->jadwal->guru->nama_guru ?? '-'); ?></td>
                                    <td><?php echo e($item->jadwal->kegiatan ?? '-'); ?></td>
                                    <td><?php echo e($item->status_kehadiran); ?></td>
                                    <td>
                                        <?php if($item->bukti && Storage::disk('public')->exists($item->bukti)): ?>
                                            <a href="<?php echo e(Storage::url($item->bukti)); ?>" target="_blank">Lihat Bukti</a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7">Tidak ada data kehadiran</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    
                    <?php if($dataKehadiran->total() > 0): ?>
                        <div class="pagination">
                            Showing <?php echo e($dataKehadiran->firstItem()); ?> to <?php echo e($dataKehadiran->lastItem()); ?> of
                            <?php echo e($dataKehadiran->total()); ?> entries
                        </div>
                    <?php endif; ?>

                    <?php if($dataKehadiran->hasPages()): ?>
                        <div class="box-pagination-left">
                            
                            <?php if($dataKehadiran->onFirstPage()): ?>
                                <span class="page-box-small disabled">«</span>
                            <?php else: ?>
                                <a href="<?php echo e($dataKehadiran->previousPageUrl()); ?>" class="page-box-small">«</a>
                            <?php endif; ?>

                            
                            <?php $__currentLoopData = $dataKehadiran->getUrlRange(1, $dataKehadiran->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($page == $dataKehadiran->currentPage()): ?>
                                    <span class="page-box-small active"><?php echo e($page); ?></span>
                                <?php else: ?>
                                    <a href="<?php echo e($url); ?>" class="page-box-small"><?php echo e($page); ?></a>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            
                            <?php if($dataKehadiran->hasMorePages()): ?>
                                <a href="<?php echo e($dataKehadiran->nextPageUrl()); ?>" class="page-box-small">»</a>
                            <?php else: ?>
                                <span class="page-box-small disabled">»</span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="gki-button-group">
                    <a href="<?php echo e(route('admin.kehadiranA.index')); ?>">
                        <button class="gki-input-btn">Kembali</button>
                    </a>
                </div>
            </div>
        </div>

</body>

</html><?php /**PATH D:\Sistem\sistemrtq\resources\views/admin/kehadiranA/detail.blade.php ENDPATH**/ ?>