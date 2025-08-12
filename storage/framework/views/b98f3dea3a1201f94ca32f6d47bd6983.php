<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Detail Hafalan | <?php echo e($santri->nama_santri); ?></title>
    <link rel="shortcut icon" href="<?php echo e(asset('img/image/logortq.png')); ?>" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gy-container { max-width: 1200px; margin: 0 auto; }
        .gy-card { border:1px solid #e5e7eb; border-radius:.75rem; background:#fff; }
        .gy-card h3 { font-weight:700; }
        .gy-table th, .gy-table td { border:1px solid #e5e7eb; padding:.5rem .625rem; }
        .gy-table th { background:#f3f4f6; font-weight:600; text-align:left; }
        @media (max-width:768px){
            .gy-head { flex-direction:column; align-items:flex-start; gap:.75rem; }
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen">
    <div class="gy-container px-4 md:px-6 py-6 md:py-10">
        <!-- Header -->
        <div class="gy-head flex items-center justify-between">
            <div class="flex items-center gap-4">
                <img src="<?php echo e(asset('img/image/logortq.png')); ?>" class="h-14" alt="Logo">
                <div>
                    <div class="text-xl md:text-2xl font-bold">Detail Hafalan Santri</div>
                    <div class="text-slate-600">Nama: <span class="font-semibold"><?php echo e($santri->nama_santri); ?></span></div>
                    <?php if(!empty($santri->kelas)): ?>
                        <div class="text-slate-600">Kelas: <span class="font-semibold"><?php echo e($santri->kelas); ?></span></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="<?php echo e(url()->previous()); ?>"
                   class="px-4 py-2 rounded-lg border bg-white hover:bg-slate-50">Kembali</a>
            </div>
        </div>

        <!-- Info jika kosong -->
        <?php if($groupedByJuz->isEmpty()): ?>
            <div class="mt-6 gy-card p-6 text-center text-slate-600">
                Belum ada data hafalan untuk santri ini.
            </div>
        <?php endif; ?>

        <!-- Loop per JUZ -->
        <div class="mt-6 space-y-6">
            <?php $__currentLoopData = $groupedByJuz->sortKeys(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $juz => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="gy-card p-4 md:p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg md:text-xl">Juz <?php echo e($juz); ?></h3>
                        <div class="text-sm text-slate-500">
                            Total Catatan: <?php echo e($items->count()); ?>

                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full gy-table">
                            <thead>
                                <tr>
                                    <th class="w-14">No</th>
                                    <th>Tanggal</th>
                                    <th>Surah</th>
                                    <th class="w-20">Juz</th>
                                    <th class="w-28">Ayat Awal</th>
                                    <th class="w-28">Ayat Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-slate-50">
                                        <td><?php echo e($i + 1); ?></td>
                                        <td>
                                            <?php
                                                $tgl = \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y');
                                            ?>
                                            <?php echo e($tgl); ?>

                                        </td>
                                        <td><?php echo e($row->surah); ?></td>
                                        <td><?php echo e($row->juz); ?></td>
                                        <td><?php echo e($row->ayat_awal); ?></td>
                                        <td><?php echo e($row->ayat_akhir); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                        $minAyat = $items->min('ayat_awal');
                        $maxAyat = $items->max('ayat_akhir');
                        $tanggalTerakhir = optional($items->sortByDesc('tanggal')->first())->tanggal;
                    ?>
                    <div class="mt-3 text-sm text-slate-600">
                        <span>Rentang ayat tersimpan: <?php echo e($minAyat); ?> – <?php echo e($maxAyat); ?></span>
                        <?php if($tanggalTerakhir): ?>
                            <span class="mx-2">•</span>
                            <span>Pencatatan terakhir: <?php echo e(\Carbon\Carbon::parse($tanggalTerakhir)->format('d/m/Y')); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</body>
</html>
<?php /**PATH D:\Adel\Semester 8\TA Adel\Sistem\sistemrtq\resources\views/guru/hafalansantri/detailSantri.blade.php ENDPATH**/ ?>