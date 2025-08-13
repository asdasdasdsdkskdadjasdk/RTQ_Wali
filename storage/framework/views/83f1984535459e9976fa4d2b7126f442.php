<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Dashboard Yayasan</title>
  <link rel="shortcut icon" href="./img/image/logortq.png" type="image/x-icon">
  <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
    .hamburger {
      display: none;
    }

    @media (max-width: 768px) {
      .gy-sidebar {
        position: fixed;
        top: 0;
        left: -100%;
        width: 240px;
        height: 100vh;
        background-color: white;
        z-index: 50;
        padding: 1rem;
        transition: left 0.3s ease;
      }

      .gy-sidebar.active {
        left: 0;
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

      .main {
        margin-left: 0 !important;
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
          <strong>Yayasan</strong>
        </div>
        <form method="POST" action="<?php echo e(route('logout')); ?>">
          <?php echo csrf_field(); ?>
          <button type="submit" style="background: none; border: none; cursor: pointer;">
            <img src="<?php echo e(asset('img/image/logout.png')); ?>" alt="Logout" style="width: 18px; height: 18px;">
          </button>
        </form>
      </div>
      <a href="<?php echo e(route('dashboard')); ?>" class="active">
        <i class="fas fa-home"></i> Dashboard
      </a>
      <a href="<?php echo e(route('yayasan.kehadiranY.index')); ?>">
        <i class="fas fa-check-circle"></i> Kehadiran
      </a>
      <a href="<?php echo e(route('yayasan.hafalansantriY.index')); ?>">
        <i class="fas fa-book"></i> Hafalan Santri
      </a>
      <a href="<?php echo e(route('yayasan.kategorinilai.index')); ?>">
        <i class="fas fa-chalkboard-teacher"></i> Kinerja Guru
      </a>
      <a href="<?php echo e(route('password.editYayasan')); ?>">
        <i class="fas fa-key"></i> Ubah Password
      </a>
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
          <h1 class="text-xl font-bold">Dashboard</h1>
        </div>
        <img src="<?php echo e(asset('img/image/logortq.png')); ?>" alt="Logo" class="h-20 bg-white p-2 rounded" />
      </div>

      <div class="chart-container">
        <!-- Dropdown Periode -->
        <div class="dropdown relative inline-block mb-6 p-4">
          <button type="button"
            class="dropdown-btn bg-[#A4E4B3] text-black border border-gray-300 rounded px-3 py-1.5 flex items-center gap-2 font-semibold text-sm"
            onclick="toggleDropdown()">Periode:
            <span id="selected-year"><?php echo e($selectedPeriodeNama ?? 'Pilih Periode'); ?></span>
            <span class="menu-arrow">
              <img src="<?php echo e(asset('img/image/arrowdown.png')); ?>" alt="arrowdown" class="h-3" />
            </span>
          </button>
          <div
            class="dropdown-content absolute hidden bg-white mt-1 border border-gray-200 rounded shadow-lg z-10 w-full"
            id="dropdown-menu">
            <?php $__currentLoopData = $periodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div
            class="px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm <?php echo e($selectedPeriode == $p->id ? 'bg-blue-100' : ''); ?>"
            onclick="selectYear('<?php echo e($p->id); ?>', '<?php echo e($p->tahun_ajaran); ?>')">
            <?php echo e($p->tahun_ajaran); ?>

            <?php if($selectedPeriode == $p->id): ?>
          <span class="text-blue-600 font-semibold">(Aktif)</span>
        <?php endif; ?>
          </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>

        <!-- Filter Bulan & Juz -->
        <form method="GET" action="<?php echo e(url()->current()); ?>" class="px-4 mb-4 flex flex-wrap gap-4 items-end">
          <div class="flex-1 min-w-[100px]">
            <label class="block text-xs font-medium text-gray-600 mb-1">Bulan</label>
            <select name="dash_bulan" onchange="this.form.submit()"
              class="border border-gray-300 rounded px-2 py-1 text-sm w-full">
              <?php $__currentLoopData = $bulanList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($b['val']); ?>" <?php echo e($bulanSelected == $b['val'] ? 'selected' : ''); ?>>
          <?php echo e($b['label']); ?>

          </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>

          <div class="flex-1 min-w-[100px]">
            <label class="block text-xs font-medium text-gray-600 mb-1">Juz Hafalan</label>
            <select name="dash_juz" onchange="this.form.submit()"
              class="border border-gray-300 rounded px-2 py-1 text-sm w-full">
              <?php $__currentLoopData = $juzList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($j['val']); ?>" <?php echo e($juzSelected == $j['val'] ? 'selected' : ''); ?>>
          <?php echo e($j['label']); ?>

          </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
        </form>

        <!-- Loading indicator -->
        <div id="loading" class="hidden mb-4 px-4">
          <div class="flex items-center gap-2">
            <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-green-600"></div>
            <span class="text-sm text-gray-600">Memperbarui data...</span>
          </div>
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6 px-4">
          <div class="bg-white p-4 rounded shadow">
            <h4 class="font-semibold text-center mb-2">Data Kehadiran</h4>
            <canvas id="kehadiranChart" height="250"></canvas>
          </div>
          <div class="bg-white p-4 rounded shadow">
            <h4 class="font-semibold text-center mb-2">Data Hafalan Santri</h4>
            <canvas id="hafalanChart" height="250"></canvas>
          </div>
          <div class="bg-white p-4 rounded shadow">
            <h4 class="font-semibold text-center mb-2">Jumlah Keterlambatan per Guru</h4>
            <canvas id="terlambatChart" height="250"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Script Dropdown -->
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
    function toggleDropdown() {
      const menu = document.getElementById('dropdown-menu');
      menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    }
    function selectYear(id, tahun) {
      document.getElementById('loading').classList.remove('hidden');
      document.getElementById('selected-year').textContent = tahun;
      document.getElementById('dropdown-menu').style.display = 'none';
      fetch('<?php echo e(route("yayasan.dashboard.update-periode")); ?>', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },
        body: JSON.stringify({ periode_id: id })
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            window.location.reload();
          } else {
            alert('Gagal mengupdate periode: ' + data.message);
            document.getElementById('loading').classList.add('hidden');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Terjadi kesalahan saat mengupdate periode');
          document.getElementById('loading').classList.add('hidden');
        });
    }
    window.addEventListener('click', function (e) {
      if (!e.target.closest('.dropdown')) {
        document.getElementById("dropdown-menu").style.display = "none";
      }
    });
  </script>

  <!-- Script Chart -->
  <script>
    const kehadiranData = <?php echo json_encode($kehadiranData, 15, 512) ?>;
    const hafalanByJuz = <?php echo json_encode($hafalanByJuz, 15, 512) ?>;
    const labelsKehadiran = kehadiranData.map(item => item.cabang);
    const hadirData = kehadiranData.map(item => item.hadir);
    const alfaData = kehadiranData.map(item => item.alfa);
    new Chart(document.getElementById('kehadiranChart'), {
      type: 'bar',
      data: {
        labels: labelsKehadiran,
        datasets: [
          { label: 'Hadir', data: hadirData, backgroundColor: '#4CAF50' },
          { label: 'Alfa', data: alfaData, backgroundColor: '#F44336' }
        ]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            title: { display: true, text: 'Jumlah Kehadiran' },
            ticks: {
              callback: value => Number.isInteger(value) ? value : null,
              stepSize: 1
            }
          }
        }
      }
    });
    const filteredHafalan = hafalanByJuz.filter(item => item.juz !== null && item.juz !== 0 && item.juz !== '');
    const labelsHafalan = filteredHafalan.map(item => `Juz ${item.juz}`);
    const dataHafalan = filteredHafalan.map(item => item.total);
    new Chart(document.getElementById('hafalanChart'), {
      type: 'bar',
      data: {
        labels: labelsHafalan,
        datasets: [{ label: 'Jumlah Santri', data: dataHafalan, backgroundColor: '#2196F3', barPercentage: 0.2, categoryPercentage: 0.4 }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            title: { display: true, text: 'Jumlah Santri' },
            ticks: {
              callback: value => Number.isInteger(value) ? value : null,
              stepSize: 1
            }
          }
        }
      }
    });
    const terlambatData = <?php echo json_encode($chartTerlambatGuru, 15, 512) ?>;
    const labelsTerlambat = terlambatData.map(item => item.nama_guru);
    const jumlahTerlambat = terlambatData.map(item => item.jumlah);
    new Chart(document.getElementById('terlambatChart'), {
      type: 'bar',
      data: {
        labels: labelsTerlambat,
        datasets: [{ label: 'Jumlah Terlambat', data: jumlahTerlambat, backgroundColor: '#FF9800', barPercentage: 0.2, categoryPercentage: 0.4 }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            title: { display: true, text: 'Jumlah Terlambat' },
            ticks: {
              callback: value => Number.isInteger(value) ? value : null,
              stepSize: 1
            }
          }
        }
      }
    });
  </script>
</body>

</html><?php /**PATH D:\Adel\Semester 8\TA Adel\Sistem\sistemrtq\resources\views/yayasan/dashboard/master.blade.php ENDPATH**/ ?>