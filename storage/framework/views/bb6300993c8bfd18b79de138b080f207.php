<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Kehadiran</title>
  <link rel="shortcut icon" href="<?php echo e(asset('img/image/logortq.png')); ?>" type="image/x-icon">
  <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
    * {
      box-sizing: border-box;
    }

    html,
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .hamburger {
      display: none;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: left;
    }

    @media (max-width: 1024px) {
      .gy-topbar {
        flex-direction: row;
        align-items: center;
      }

      .gy-topbar h1 {
        font-size: 1rem;
        white-space: nowrap;
      }

      .gy-topbar img {
        height: 48px;
      }

      .hamburger {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem;
        background-color: white;
        border-radius: 0.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        z-index: 50;
      }

      .gy-sidebar {
        position: fixed;
        top: 0;
        left: -100%;
        width: 50vw;
        height: 100vh;
        background-color: white;
        z-index: 50;
        padding: 1rem;
        transition: left 0.3s ease;
      }

      .gy-sidebar.active {
        left: 0;
      }

      .main {
        margin-left: 0 !important;
        width: 100%;
      }

      table {
        font-size: 0.875rem;
      }

      .chart-container {
        overflow-x: auto;
      }
    }
  </style>
</head>

<body>
  <div class="container flex">
    <!-- Sidebar -->
    <div class="gy-sidebar" id="sidebar">
      <div class="sidebar-header flex justify-between items-center mb-4">
        <div class="flex items-center gap-2">
          <img src="<?php echo e(asset('img/image/akun.png')); ?>" alt="Foto Admin"
            style="width: 40px; height: 40px; border-radius: 50%;">
          <strong><?php echo e(Auth::user()->guru->nama_guru ?? Auth::user()->name); ?></strong>
        </div>
        <form method="POST" action="<?php echo e(route('logout')); ?>">
          <?php echo csrf_field(); ?>
          <button type="submit" style="background: none; border: none; cursor: pointer;">
            <img src="<?php echo e(asset('img/image/logout.png')); ?>" alt="Logout" style="width: 18px; height: 18px;">
          </button>
        </form>
      </div>

      <a href="<?php echo e(route('dashboard')); ?>">
        <i class="fas fa-home mr-2"></i>Dashboard
      </a>
      <a href="<?php echo e(route('guru.profile.edit')); ?>">
        <i class="fas fa-user mr-2"></i>Profil Saya
      </a>
      <a href="<?php echo e(route('guru.kehadiranG.index')); ?>" class="active">
        <i class="fas fa-check-circle mr-2"></i>Kehadiran
      </a>
      <a href="<?php echo e(route('guru.hafalansantri.index')); ?>">
        <i class="fas fa-book mr-2"></i>Hafalan Santri
      </a>
      <a href="<?php echo e(route('password.editGuru')); ?>">
        <i class="fas fa-key mr-2"></i>Ubah Password
      </a>
    </div>

    <!-- Main Content -->
    <div class="main flex-1">
      <!-- Topbar -->
      <div class="gy-topbar bg-white flex justify-between items-center p-4 shadow">
        <div class="flex items-center gap-2">
          <button class="hamburger" id="toggleSidebarBtn">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
          <h1 class="text-xl font-bold">Input Kehadiran</h1>
        </div>
        <img src="<?php echo e(asset('img/image/logortq.png')); ?>" alt="Logo" class="h-10 w-auto bg-white p-1 rounded" />
      </div>

      <!-- Form -->
      <form action="<?php echo e(route('guru.detailKehadiran.store')); ?>" method="POST" enctype="multipart/form-data"
        id="kehadiranForm">
        <?php echo csrf_field(); ?>
        <div class="chart-container p-4">
          <!-- Kelas -->
          <div>
            <div class="bg-[#A4E4B3] text-black-800 px-4 py-2 rounded-md inline-block"><?php echo e($namaKelas ?? 'N/A'); ?></div>
            <input type="hidden" name="kelas" value="<?php echo e($namaKelas ?? 'N/A'); ?>">
          </div>

          <!-- Guru dan Periode -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
            <div>
              <div class="bg-gray-100 px-4 py-2 rounded-md"><?php echo e($guru->nama_guru ?? '-'); ?></div>
              <input type="hidden" name="guru_id" value="<?php echo e($guru->id ?? ''); ?>">
            </div>
            <div>
              <div class="bg-gray-100 px-4 py-2 rounded-md"><?php echo e($jadwal->first()->periode->tahun_ajaran ?? '-'); ?></div>
              <input type="hidden" name="periode_id" value="<?php echo e($jadwal->first()->periode_id ?? $selectedPeriode); ?>">
            </div>
          </div>

          <!-- Cabang dan Tanggal -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2 ">
            <div>
              <div class="bg-gray-100 px-4 py-2 rounded-md"><?php echo e($jadwal->first()->cabang ?? '-'); ?></div>
              <input type="hidden" name="cabang" value="<?php echo e($jadwal->first()->cabang ?? ''); ?>">
            </div>
            <div>
              <input type="date" id="tanggal" name="tanggal" value="<?php echo e(request('tanggal', now()->toDateString())); ?>"
                class="w-full border px-4 py-2 rounded-md">
            </div>
          </div>

          <!-- Kegiatan dan Jam -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
            <div>
              <?php if($jadwal->isNotEmpty()): ?>
            <select id="kategori" name="kegiatan" onchange="updateJam()" class="w-full border px-4 py-2 rounded-md">
            <?php $__currentLoopData = $jadwal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($j && isset($j->kegiatan)): ?>
            <option value="<?php echo e($j->kegiatan); ?>" data-jam-masuk="<?php echo e($j->jam_masuk ?? ''); ?>"
            data-jam-keluar="<?php echo e($j->jam_keluar ?? ''); ?>" data-id="<?php echo e($j->id ?? ''); ?>" <?php if($loop->first): ?> selected
          <?php endif; ?>>
            <?php echo e($j->kegiatan); ?>

            </option>
          <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        <?php else: ?>
          <div class="text-red-600">Semua kegiatan sudah diinput untuk tanggal ini.</div>
        <?php endif; ?>
            </div>
            <div>
              <div id="jamBox" class="bg-gray-100 px-4 py-2 rounded-md">-</div>
              <input type="hidden" name="jam_masuk" id="hidden_jam_masuk">
              <input type="hidden" name="jam_keluar" id="hidden_jam_keluar">
              <input type="hidden" name="jadwal_mengajar_id" id="hidden_jadwal_mengajar_id">
            </div>
          </div>

          <!-- Upload Dokumentasi -->
          <div class="gki-form-row mt-6">
            <div class="gki-form-item">
              <label for="dokumentasi" class="gki-custom-file-upload">
                <span class="gki-upload-label-content">
                  Upload Dokumentasi Kegiatan
                  <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 0 24 24" width="20">
                    <path d="M0 0h24v24H0V0z" fill="none" />
                    <path d="M5 20h14v-2H5v2zm7-18l-7 7h4v6h6v-6h4l-7-7z" />
                  </svg>
                </span>
              </label>
              <input type="file" id="dokumentasi" name="dokumentasi" accept="image/*" style="display: none;">
            </div>
          </div>

          <!-- Tabel Kehadiran -->
          <div class="mt-4 overflow-x-auto">
            <table class="w-full border">
              <thead>
                <tr class="bg-gray-200 text-left">
                  <th class="p-2">No</th>
                  <th class="p-2">Nama Santri</th>
                  <th class="p-2">Status Kehadiran</th>
                  <th class="p-2">Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $santri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr class="border-t">
            <td class="p-2"><?php echo e($index + 1); ?></td>
            <td class="p-2"><?php echo e($s->nama_santri); ?></td>
            <td class="p-2">
            <div class="gki-status-wrapper" data-santri-id="<?php echo e($s->id); ?>">
              <div class="gki-status-left">Hadir</div>
              <div class="gki-status-right"></div>
            </div>
            <input type="hidden" name="kehadiran[<?php echo e($s->id); ?>][status_kehadiran]" value="Hadir"
              class="status-input">
            <input type="hidden" name="kehadiran[<?php echo e($s->id); ?>][nama_santri]" value="<?php echo e($s->nama_santri); ?>">
            <input type="hidden" name="kehadiran[<?php echo e($s->id); ?>][santri_id]" value="<?php echo e($s->id); ?>">
            </td>
            <td>
            <label for="bukti<?php echo e($s->id); ?>" class="gki-custom-file-upload">
              <span class="gki-upload-label-content" id="buktiLabel<?php echo e($s->id); ?>">
              Bukti
              <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 0 24 24" width="20">
                <path d="M0 0h24v24H0V0z" fill="none" />
                <path d="M5 20h14v-2H5v2zm7-18l-7 7h4v6h6v-6h4l-7-7z" />
              </svg>
              </span>
            </label>
            <input type="file" id="bukti<?php echo e($s->id); ?>" name="kehadiran[<?php echo e($s->id); ?>][bukti]" accept="image/*"
              style="display: none;">
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="4" class="p-2 text-center">Tidak ada santri dalam kelas ini.</td>
          </tr>
        <?php endif; ?>
              </tbody>
            </table>
            <div class="w-full text-right mt-4">
              <button type="submit" class="gki-input-btn bg-[#A4E4B3] text-black px-4 py-2 rounded" <?php echo e($jadwal->isEmpty() ? 'disabled' : ''); ?>>Simpan</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- JavaScript -->
  <script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebarBtn');

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

    document.getElementById('tanggal').addEventListener('change', function () {
      const selectedDate = this.value;
      const url = new URL(window.location.href);
      url.searchParams.set('tanggal', selectedDate);
      window.location.href = url.href;
    });

    document.addEventListener('DOMContentLoaded', function () {
      // Status toggle
      document.querySelectorAll('.gki-status-wrapper').forEach(wrapper => {
        wrapper.addEventListener('click', function () {
          const statusInput = this.closest('td').querySelector('.status-input');
          const statusLeft = this.querySelector('.gki-status-left');
          const statusRight = this.querySelector('.gki-status-right');

          this.classList.toggle('alfa');
          if (this.classList.contains('alfa')) {
            statusLeft.textContent = '';
            statusRight.textContent = 'Alfa';
            if (statusInput) statusInput.value = 'Alfa';
          } else {
            statusLeft.textContent = 'Hadir';
            statusRight.textContent = '';
            if (statusInput) statusInput.value = 'Hadir';
          }
        });
      });

      // Jam update
      window.updateJam = function () {
        const kategoriSelect = document.getElementById('kategori');
        const jamBox = document.getElementById('jamBox');
        const selectedOption = kategoriSelect.options[kategoriSelect.selectedIndex];

        if (selectedOption) {
          jamBox.textContent = `${selectedOption.dataset.jamMasuk ?? ''} - ${selectedOption.dataset.jamKeluar ?? ''}`;
          document.getElementById('hidden_jam_masuk').value = selectedOption.dataset.jamMasuk ?? '';
          document.getElementById('hidden_jam_keluar').value = selectedOption.dataset.jamKeluar ?? '';
          document.getElementById('hidden_jadwal_mengajar_id').value = selectedOption.dataset.id ?? '';
        }
      };

      updateJam();

      // Logika untuk menampilkan nama file yang dipilih pada label "Dokumentasi Kegiatan"
      const dokumentasiInput = document.getElementById('dokumentasi');
      if (dokumentasiInput) {
        dokumentasiInput.addEventListener('change', function () {
          const labelContent = this.previousElementSibling.querySelector('.gki-upload-label-content');
          if (this.files.length > 0) {
            labelContent.innerHTML = `${this.files[0].name} <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 0 24 24" width="20"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 20h14v-2H5v2zm7-18l-7 7h4v6h6v-6h4l-7-7z"/></svg>`;
          } else {
            labelContent.innerHTML = `Upload Dokumentasi Kegiatan <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 0 24 24" width="20"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 20h14v-2H5v2zm7-18l-7 7h4v6h6v-6h4l-7-7z"/></svg>`;
          }
        });
      }

      // Logika untuk menampilkan nama file yang dipilih pada label "Bukti" santri
      document.querySelectorAll('input[type="file"][name^="kehadiran["]').forEach(input => {
        input.addEventListener('change', function () {
          const labelContent = this.previousElementSibling.querySelector('.gki-upload-label-content');
          if (this.files.length > 0) {
            labelContent.innerHTML = `${this.files[0].name} <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 0 24 24" width="20"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 20h14v-2H5v2zm7-18l-7 7h4v6h6v-6h4l-7-7z"/></svg>`;
          } else {
            labelContent.innerHTML = `Bukti <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 0 24 24" width="20"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 20h14v-2H5v2zm7-18l-7 7h4v6h6v-6h4l-7-7z"/></svg>`;
          }
        });
      });
    });
  </script>
</body>

</html><?php /**PATH D:\Adel\Semester 8\TA Adel\Sistem\sistemrtq\resources\views/guru/kehadiranG/input.blade.php ENDPATH**/ ?>