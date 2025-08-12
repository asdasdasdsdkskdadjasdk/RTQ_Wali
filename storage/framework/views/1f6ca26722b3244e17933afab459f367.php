<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Grafik Hafalan Santri</title>
  <link rel="shortcut icon" href="<?php echo e(asset('img/image/logortq.png')); ?>" type="image/x-icon">
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
      <a href="<?php echo e(route('dashboard')); ?>">
        <i class="fas fa-home"></i> Dashboard
      </a>
      <a href="<?php echo e(route('yayasan.kehadiranY.index')); ?>">
        <i class="fas fa-check-circle"></i> Kehadiran
      </a>
      <a href="<?php echo e(route('yayasan.hafalansantriY.index')); ?>" class="active">
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
          <h1 class="text-xl font-bold">Hafalan Santri - <?php echo e($cabang); ?></h1>
        </div>
        <img src="<?php echo e(asset('img/image/logortq.png')); ?>" alt="Logo" class="h-20 bg-white p-2 rounded" />
      </div>

      <div class="chart-container p-4">
        <!-- Dropdown Periode -->
        <div class="dropdown relative inline-block">
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

        <!-- Loading indicator -->
        <div id="loading" class="hidden mb-4">
          <div class="flex items-center gap-2">
            <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-green-600"></div>
            <span class="text-sm text-gray-600">Memperbarui data...</span>
          </div>
        </div>

        <!-- Chart -->
        <div class="bg-white p-4 rounded shadow">
          <h4 class="font-semibold text-center mb-4">
            Data Hafalan Santri Cabang <?php echo e($cabang); ?>

          </h4>

          <!-- Wrapper responsif -->
          <div style="position: relative; min-height: 300px; height: 50vh;">
            <canvas id="hafalanChart"></canvas>
          </div>
        </div>

        <!-- Back Button -->
        <div class="mt-4">
          <a href="<?php echo e(route('yayasan.hafalansantriY.index')); ?>"
            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            ← Kembali ke Daftar Cabang
          </a>
        </div>
      </div>
    </div>
  </div>

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

    // Chart
    const chartData = <?php echo json_encode($chartData, 15, 512) ?>;
    const labels = chartData.map(item => item.kelas);

    new Chart(document.getElementById('hafalanChart'), {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [
          { label: 'Juz 1-5', data: chartData.map(item => item.juz_1_5), backgroundColor: '#FF6384', maxBarThickness: 40 },
          { label: 'Juz 6-10', data: chartData.map(item => item.juz_6_10), backgroundColor: '#36A2EB', maxBarThickness: 40 },
          { label: 'Juz 11-15', data: chartData.map(item => item.juz_11_15), backgroundColor: '#FFCE56', maxBarThickness: 40 },
          { label: 'Juz 16-20', data: chartData.map(item => item.juz_16_20), backgroundColor: '#4BC0C0', maxBarThickness: 40 },
          { label: 'Juz 21-25', data: chartData.map(item => item.juz_21_25), backgroundColor: '#9966FF', maxBarThickness: 40 },
          { label: 'Juz 26-30', data: chartData.map(item => item.juz_26_30), backgroundColor: '#FF9F40', maxBarThickness: 40 }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false, // penting supaya tinggi bisa diatur fleksibel
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Jumlah Santri'
            },
            ticks: {
              callback: function (value) {
                return Number.isInteger(value) ? value : null;
              },
              stepSize: 1
            }
          }
        }
      }
    });

    function toggleDropdown() {
      const menu = document.getElementById('dropdown-menu');
      menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    }

    function selectYear(id, tahun) {
      // Tampilkan loading
      document.getElementById('loading').classList.remove('hidden');

      // Update tampilan dropdown
      document.getElementById('selected-year').textContent = tahun;
      document.getElementById('dropdown-menu').style.display = 'none';

      // Kirim request AJAX untuk update session
      fetch('<?php echo e(route("yayasan.dashboard.update-periode")); ?>', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },
        body: JSON.stringify({
          periode_id: id
        })
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Reload halaman untuk update data
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

    // Tutup dropdown saat klik di luar
    window.addEventListener('click', function (e) {
      if (!e.target.closest('.dropdown')) {
        document.getElementById("dropdown-menu").style.display = "none";
      }
    });
  </script>
</body>


</html><?php /**PATH D:\Adel\Semester 8\TA Adel\Sistem\sistemrtq\resources\views/yayasan/hafalansantriY/detail.blade.php ENDPATH**/ ?>