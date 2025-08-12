<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Dashboard Admin</title>
  <link rel="shortcut icon" href="<?php echo e(asset('img/image/logortq.png')); ?>" type="image/x-icon">
  <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
    <div class="sidebar" style="display:flex; flex-direction:column; height:100vh; justify-content:space-between;">
      <div style="flex:1; overflow-y:auto;">
        <div class="sidebar-header">
          <div style="display:flex; align-items:center; gap:8px;">
            <img src="<?php echo e(asset('img/image/akun.png')); ?>" alt="Foto Admin" style="width:40px; height:40px; border-radius:40%;">
            <strong>Admin</strong>
          </div>
          <form method="POST" action="<?php echo e(route('logout')); ?>" style="margin-right:8px;">
            <?php echo csrf_field(); ?>
            <button type="submit" style="background:none; border:none; cursor:pointer; padding:4px;">
              <img src="<?php echo e(asset('img/image/logout.png')); ?>" alt="Logout" style="width:18px; height:18px;">
            </button>
          </form>
        </div>

        <a href="<?php echo e(route('dashboard')); ?>" class="active">Dashboard</a>
        <a href="<?php echo e(route('admin.jadwalmengajar.index')); ?>">Jadwal Mengajar</a>
        <a href="<?php echo e(route('admin.dataguru.index')); ?>">Data Guru</a>
        <a href="<?php echo e(route('admin.datasantri.index')); ?>">Data Santri</a>
        <a href="<?php echo e(route('admin.kelolapengguna.index')); ?>">Kelola Pengguna</a>
        <a href="<?php echo e(route('admin.periode.index')); ?>">Periode</a>
        <a href="<?php echo e(route('admin.kategoripenilaian.index')); ?>">Kategori Penilaian</a>
        <a href="<?php echo e(route('admin.kehadiranA.index')); ?>">Kehadiran</a>
        <a href="<?php echo e(route('admin.hafalanadmin.index')); ?>">Hafalan Santri</a>
        <a href="<?php echo e(route('admin.kinerjaguru.index')); ?>">Kinerja Guru</a>
      </div>

      <div style="border-top:1px solid #ddd; padding-top:10px;">
        <a href="<?php echo e(route('password.editAdmin')); ?>">Ubah Password</a>
      </div>
    </div>

    <!-- Main Content -->
    <div class="main">
      <div class="topbar">
        <h1>Dashboard</h1>
        <img src="<?php echo e(asset('img/image/logortq.png')); ?>" alt="Logo RTQ" height="150" width="100" />
      </div>

      <div class="chart-container">
        <!-- Dropdown Periode (AJAX) -->
        <div class="dropdown">
          <button type="button" class="dropdown-btn" onclick="toggleDropdown()">
            Periode: <span id="selected-year"><?php echo e($selectedPeriodeNama); ?></span>
            <span class="menu-arrow"><img src="<?php echo e(asset('img/image/arrowdown.png')); ?>" alt="arrowdown" height="15" /></span>
          </button>
          <div class="dropdown-content" id="dropdown-menu">
            <?php $__currentLoopData = $periodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div onclick="selectYear('<?php echo e($p->id); ?>', '<?php echo e($p->tahun_ajaran); ?>')">
                <?php echo e($p->tahun_ajaran); ?>

                <?php if($selectedPeriode == $p->id): ?>
                  <span style="color:#2563eb; font-weight:600;">(Aktif)</span>
                <?php endif; ?>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>

        <!-- Filter Bulan & Juz -->
        <form method="GET" action="<?php echo e(url()->current()); ?>" style="margin:12px 0; display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
          <div>
            <label for="bulan" style="font-size:.9rem; margin-right:6px;">Bulan</label>
            <select name="dash_bulan" id="bulan" onchange="this.form.submit()" style="padding:.5rem; border:1px solid #ccc; border-radius:6px; min-width:180px;">
              <?php $__currentLoopData = $bulanList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($b['val']); ?>" <?php echo e((string)$bulanSelected === (string)$b['val'] ? 'selected' : ''); ?>>
                  <?php echo e($b['label']); ?>

                </option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>

          <div>
            <label for="juz" style="font-size:.9rem; margin-right:6px;">Juz Hafalan</label>
            <select name="dash_juz" id="juz" onchange="this.form.submit()" style="padding:.5rem; border:1px solid #ccc; border-radius:6px; min-width:160px;">
              <?php $__currentLoopData = $juzList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($j['val']); ?>" <?php echo e((string)$juzSelected === (string)$j['val'] ? 'selected' : ''); ?>>
                  <?php echo e($j['label']); ?>

                </option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>

          <?php if($selectedPeriodeNama && $selectedPeriode): ?>
            <div style="font-size:.85rem; color:#555;">
              Periode Aktif: <strong><?php echo e($selectedPeriodeNama); ?></strong>
            </div>
          <?php endif; ?>
        </form>

        <!-- Loading -->
        <div id="loading" style="display:none; margin-bottom:1rem;">
          <div style="display:flex; align-items:center; gap:.5rem;">
            <div style="width:1rem; height:1rem; border:2px solid #16a34a; border-top:2px solid transparent; border-radius:50%; animation:spin 1s linear infinite;"></div>
            <span style="font-size:.875rem; color:#6b7280;">Memperbarui data...</span>
          </div>
        </div>

        <!-- Cards -->
        <div class="cards">
          <div class="card"><h2>Jumlah Guru</h2><p><?php echo e($guruCount); ?> Guru</p></div>
          <div class="card"><h2>Jumlah Santri</h2><p><?php echo e($santriCount); ?> Santri</p></div>
        </div>

        <!-- Charts -->
        <div class="chart-placeholder">
          <div class="chart-box">
            <h4>
              Data Kehadiran
              <?php if($bulanSelected !== 'all'): ?> (Bulan: <?php echo e($bulanSelected); ?>) <?php endif; ?>
            </h4>
            <canvas id="kehadiranChart" height="200"></canvas>
          </div>
          <div class="chart-box">
            <h4>
              Data Hafalan Santri
              <?php if($bulanSelected !== 'all'): ?> (Bulan: <?php echo e($bulanSelected); ?>) <?php endif; ?>
              <?php if($juzSelected !== 'all'): ?> (Juz <?php echo e($juzSelected); ?>) <?php endif; ?>
            </h4>
            <canvas id="hafalanChart" height="200"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Script Dropdown Periode (AJAX) -->
  <script>
    function toggleDropdown() {
      const menu = document.getElementById('dropdown-menu');
      menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
    }

    function selectYear(id, tahun) {
      // Tampilkan loading
      document.getElementById('loading').style.display = 'block';
      document.getElementById('selected-year').textContent = tahun;
      document.getElementById('dropdown-menu').style.display = 'none';

      // Simpan periode ke session
      fetch('<?php echo e(route("admin.dashboard.update-periode")); ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
        body: JSON.stringify({ periode_id: id })
      })
      .then(r => r.json())
      .then(data => {
        if (data.success) {
          // Reload halaman dengan mempertahankan query saat ini (?dash_bulan=&dash_juz=...)
          const url = new URL(window.location.href);
          window.location.href = url.pathname + (url.search || '');
        } else {
          alert('Gagal mengupdate periode: ' + data.message);
          document.getElementById('loading').style.display = 'none';
        }
      })
      .catch(err => {
        console.error(err);
        alert('Terjadi kesalahan saat mengupdate periode');
        document.getElementById('loading').style.display = 'none';
      });
    }

    window.onclick = function (e) {
      if (!e.target.closest('.dropdown-btn')) {
        const m = document.getElementById("dropdown-menu");
        if (m) m.style.display = "none";
      }
    };

    const style = document.createElement('style');
    style.textContent = `@keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }`;
    document.head.appendChild(style);
  </script>

  <!-- Script Chart -->
  <script>
    const kehadiranData = <?php echo json_encode($kehadiranData, 15, 512) ?>;
    const hafalanByJuz  = <?php echo json_encode($hafalanByJuz, 15, 512) ?>;

    // Kehadiran
    const labelsKehadiran = kehadiranData.map(i => i.cabang);
    const hadirData = kehadiranData.map(i => i.hadir);
    const alfaData  = kehadiranData.map(i => i.alfa);

    new Chart(document.getElementById('kehadiranChart'), {
      type: 'bar',
      data: {
        labels: labelsKehadiran,
        datasets: [
          { label: 'Hadir', data: hadirData, backgroundColor: '#4CAF50' },
          { label: 'Alfa',  data: alfaData,  backgroundColor: '#F44336' }
        ]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            title: { display: true, text: 'Jumlah Kehadiran' },
            ticks: { callback: v => Number.isInteger(v) ? v : null, stepSize: 1 }
          }
        }
      }
    });

    // Hafalan (sudah terfilter bulan & juz dari server)
    const filteredHafalan = hafalanByJuz.filter(i => i.juz !== null && i.juz !== 0 && i.juz !== '');
    const labelsHafalan = filteredHafalan.map(i => `Juz ${i.juz}`);
    const dataHafalan   = filteredHafalan.map(i => i.total);

    new Chart(document.getElementById('hafalanChart'), {
      type: 'bar',
      data: {
        labels: labelsHafalan,
        datasets: [
          { label: 'Jumlah Santri', data: dataHafalan, backgroundColor: '#2196F3', barPercentage: 0.2, categoryPercentage: 0.4 }
        ]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            title: { display: true, text: 'Jumlah Santri' },
            ticks: { callback: v => Number.isInteger(v) ? v : null, stepSize: 1 }
          }
        }
      }
    });
  </script>
</body>
</html>
<?php /**PATH D:\Sistem\sistemrtq\resources\views/admin/dashboard/master.blade.php ENDPATH**/ ?>