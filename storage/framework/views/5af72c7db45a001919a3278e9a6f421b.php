<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Hafalan Santri</title>
  <link rel="shortcut icon" href="<?php echo e(asset('img/image/logortq.png')); ?>" type="image/x-icon">
  <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    .gy-sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 240px;
      height: 100vh;
      background-color: white;
      z-index: 50;
      padding: 1rem;
      transition: left 0.3s ease;
      overflow-y: auto;
    }

    .main {
      margin-left: 240px;
      flex: 1;
    }

    .hamburger {
      display: none;
    }

    @media (max-width: 768px) {
      .gy-sidebar {
        left: -100%;
      }

      .gy-sidebar.active {
        left: 0;
      }

      .hamburger {
        display: inline-flex;
      }

      .main {
        margin-left: 0 !important;
      }
    }

    th,
    td {
      white-space: nowrap;
      padding: 8px;
    }

    @media (max-width: 640px) {
      table {
        font-size: 12px;
      }

      select,
      input {
        padding: 4px !important;
        font-size: 12px !important;
      }
    }
  </style>
</head>

<body>
  <div class="flex">
    <!-- Sidebar -->
    <div class="gy-sidebar" id="sidebar">
      <div class="sidebar-header flex justify-between items-center mb-4">
        <div class="flex items-center gap-2">
          <img src="<?php echo e(asset('img/image/akun.png')); ?>" alt="Foto Admin" class="w-10 h-10 rounded-full">
          <strong>Guru</strong>
        </div>
        <form method="POST" action="<?php echo e(route('logout')); ?>">
          <?php echo csrf_field(); ?>
          <button type="submit" style="background: none; border: none; cursor: pointer;">
            <img src="<?php echo e(asset('img/image/logout.png')); ?>" alt="Logout" class="w-4 h-4">
          </button>
        </form>
      </div>
      <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
      <a href="<?php echo e(route('guru.kehadiranG.index')); ?>">Kehadiran</a>
      <a href="<?php echo e(route('guru.hafalansantri.index')); ?>" class="active">Hafalan Santri</a>
    </div>

    <!-- Main Content -->
    <div class="main flex-1">
      <div class="gy-topbar bg-white flex justify-between items-center p-4 shadow">
        <div class="flex items-center gap-4">
          <button class="hamburger" id="toggleSidebarBtn">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
          <h1 class="text-lg md:text-xl font-bold">Input Hafalan Santri</h1>
        </div>
        <img src="<?php echo e(asset('img/image/logortq.png')); ?>" alt="Logo" class="h-14 md:h-20 bg-white p-2 rounded" />
      </div>

      <form action="<?php echo e(route('guru.hafalansantri.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <input type="hidden" name="kelas" value="<?php echo e($namaKelas ?? 'N/A'); ?>">
        <input type="hidden" name="guru_id" value="<?php echo e($guru->id ?? ''); ?>">
        <input type="hidden" name="periode_id" value="<?php echo e($jadwal->first()?->periode?->id ?? ''); ?>">
        <input type="hidden" name="jadwal_mengajar_id" value="<?php echo e($jadwal->first()?->id ?? ''); ?>">
        <input type="hidden" name="cabang" value="<?php echo e($jadwal->first()->cabang ?? ''); ?>">
        

        <div class="chart-container p-4 space-y-4">
          <div class="inline-block bg-[#A4E4B3] text-black px-3 py-1.5 rounded font-semibold">
            <?php echo e($namaKelas ?? 'N/A'); ?>

          </div>

          <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
            <div class="bg-gray-100 px-3 py-1.5 rounded text-xs sm:text-sm"><?php echo e($guru->nama_guru ?? '-'); ?></div>
            <div class="bg-gray-100 px-3 py-1.5 rounded text-xs sm:text-sm">
              <?php echo e($jadwal->first()?->periode?->tahun_ajaran ?? '-'); ?>

            </div>
            <div class="bg-gray-100 px-3 py-1.5 rounded text-xs sm:text-sm"><?php echo e($jadwal->first()->cabang ?? '-'); ?></div>
            <input type="date" name="tanggal" value="<?php echo e($tanggal); ?>"
              class="w-full border border-gray-300 px-3 py-1.5 rounded text-xs sm:text-sm" required>
          </div>

          <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
            <?php $__currentLoopData = $santri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="border rounded p-3 bg-white shadow-sm">
            <p class="font-semibold text-sm mb-2"><?php echo e($index + 1); ?>. <?php echo e($s->nama_santri); ?></p>
            <?php
          $hafalanSantri = $draftHafalan[$s->id] ?? null;
        ?>

            <input type="hidden" name="hafalan[<?php echo e($s->id); ?>][santri_id]" value="<?php echo e($s->id); ?>">

            <!-- Surah -->
            <div class="mb-2">
            <label class="text-xs">Surah</label>
            <select name="hafalan[<?php echo e($s->id); ?>][surah]" class="border rounded px-2 py-1 w-full text-xs surah-field">
              <option value="">Pilih Surah</option>
              <?php $__currentLoopData = $listSurah['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $surah): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($surah['name']['transliteration']['id']); ?>" <?php echo e(($hafalanSantri && $hafalanSantri->surah === $surah['name']['transliteration']['id']) ? 'selected' : ''); ?>>
          <?php echo e($surah['name']['transliteration']['id']); ?>

          </option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            </div>

            <!-- Juz -->
            <div class="mb-2">
            <label class="text-xs">Juz</label>
            <select name="hafalan[<?php echo e($s->id); ?>][juz]" class="border rounded px-2 py-1 w-full text-xs juz-field">
              <option value="">Pilih Juz</option>
              <?php $__currentLoopData = $listJuz['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $juz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($juz['juz']); ?>" <?php echo e(($hafalanSantri && $hafalanSantri->juz === (string) $juz['juz']) ? 'selected' : ''); ?>>
          Juz <?php echo e($juz['juz']); ?>

          </option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            </div>

            <!-- Ayat -->
            <div>
            <label class="text-xs">Ayat</label>
            <div class="flex gap-1">
              <input type="text" name="hafalan[<?php echo e($s->id); ?>][ayat_awal]"
              value="<?php echo e($hafalanSantri->ayat_awal ?? ''); ?>"
              class="w-full border rounded px-2 py-1 text-xs ayat-awal-field">
              <span class="self-center">-</span>
              <input type="text" name="hafalan[<?php echo e($s->id); ?>][ayat_akhir]"
              value="<?php echo e($hafalanSantri->ayat_akhir ?? ''); ?>"
              class="w-full border rounded px-2 py-1 text-xs ayat-akhir-field">
            </div>
            </div>
            <div class="flex justify-end gap-2 mt-3">
            <button type="submit" formaction="<?php echo e(route('guru.hafalansantri.draft')); ?>"
              class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold text-xs sm:text-sm py-2 px-5 rounded shadow">
              Simpan Draft
            </button>
            <button type="submit" id="btnSimpanFinal"
              class="bg-[#A4E4B3] hover:bg-green-600 text-black font-semibold text-xs sm:text-sm py-2 px-5 rounded shadow">
              Simpan
            </button>
            </div>
          </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebarBtn');

    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('active');
      toggleBtn.style.display = sidebar.classList.contains('active') ? 'none' : 'inline-flex';
    });

    document.addEventListener('click', function (e) {
      if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
        sidebar.classList.remove('active');
        toggleBtn.style.display = 'inline-flex';
      }
    });

    document.getElementById('btnSimpanFinal').addEventListener('click', function () {
      document.querySelectorAll('[data-santri]').forEach(container => {
        const surah = container.querySelector('.surah-field');
        const juz = container.querySelector('.juz-field');
        const awal = container.querySelector('.ayat-awal-field');
        const akhir = container.querySelector('.ayat-akhir-field');

        const isAnyFilled = surah.value || juz.value || awal.value || akhir.value;

        surah.required = isAnyFilled;
        juz.required = isAnyFilled;
        awal.required = isAnyFilled;
        akhir.required = isAnyFilled;
      });
    });

    document.querySelector('input[name="tanggal"]').addEventListener('change', function () {
      const selectedDate = this.value;
      const url = new URL(window.location.href);
      url.searchParams.set('tanggal', selectedDate);
      window.location.href = url.toString();
    });
  </script>
</body>

</html><?php /**PATH D:\Adel\Semester 8\TA Adel\Sistem\sistemrtq\resources\views/guru/hafalansantri/input.blade.php ENDPATH**/ ?>