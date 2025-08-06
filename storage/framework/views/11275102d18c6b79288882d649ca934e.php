<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RTQ Al-Yusra | Kinerja Guru</title>
  <link rel="shortcut icon" href="<?php echo e(asset('img/image/logortq.png')); ?>" alt="Logo RTQ" height="100" type="image/x-icon">
  <!-- style css -->
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
      <a href="<?php echo e(route('admin.datasantri.index')); ?>">Data Santri</a>
      <a href="<?php echo e(route('admin.kelolapengguna.index')); ?>">Kelola Pengguna</a>
      <a href="<?php echo e(route('admin.periode.index')); ?>">Periode</a>
      <a href="<?php echo e(route('admin.kategoripenilaian.index')); ?>">Kategori Penilaian</a>
      <a href="<?php echo e(route('admin.kehadiranA.index')); ?>">Kehadiran</a>
      <a href="<?php echo e(route('admin.hafalanadmin.index')); ?>">Hafalan Santri</a>
      <a href="<?php echo e(route('admin.kinerjaguru.index')); ?>" class="active">Kinerja Guru</a>
    </div>

    <!-- Main Content -->
    <div class="main">
      <div class="topbar">
        <h1>Kinerja Guru</h1>
        <img src="<?php echo e(asset('img/image/logortq.png')); ?>" alt="Logo RTQ" height="150" width="100" />
      </div>

      <div class="ka-form-container">
        <div class="kg-form-group">
          <!-- Dropdown Periode -->
          <div style="margin-bottom: 1rem;">
            <div class="dropdown" style="position: relative; display: inline-block;">
              <button type="button" class="dropdown-btn" onclick="toggleDropdown()"
                style="background-color: #A4E4B3; color: black; border: 1px solid #d1d5db; border-radius: 0.375rem; padding: 0.375rem 0.75rem; display: flex; align-items: center; gap: 0.5rem; font-weight: 600; font-size: 0.875rem;">
                Periode:
                <span id="selected-year"><?php echo e($selectedPeriodeNama); ?></span>
                <span class="menu-arrow">
                  <img src="<?php echo e(asset('img/image/arrowdown.png')); ?>" alt="arrowdown" style="height: 12px;" />
                </span>
              </button>
              <div class="dropdown-content" id="dropdown-menu"
                style="position: absolute; display: none; background-color: white; margin-top: 0.25rem; border: 1px solid #e5e7eb; border-radius: 0.375rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); z-index: 10; min-width: 100%;">
                <?php $__currentLoopData = $periodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div onclick="selectYear('<?php echo e($p->id); ?>', '<?php echo e($p->tahun_ajaran); ?>')"
                style="padding: 0.5rem 1rem; cursor: pointer; font-size: 0.875rem; <?php echo e($selectedPeriode == $p->id ? 'background-color: #dbeafe;' : ''); ?>"
                onmouseover="this.style.backgroundColor='#f3f4f6'"
                onmouseout="this.style.backgroundColor='<?php echo e($selectedPeriode == $p->id ? '#dbeafe' : 'white'); ?>'">
                <?php echo e($p->tahun_ajaran); ?>

                <?php if($selectedPeriode == $p->id): ?>
            <span style="color: #2563eb; font-weight: 600;">(Aktif)</span>
            <?php endif; ?>
              </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </div>
          </div>

          <!-- Loading indicator -->
          <div id="loading" style="display: none; margin-bottom: 1rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
              <div
                style="width: 1rem; height: 1rem; border: 2px solid #16a34a; border-top: 2px solid transparent; border-radius: 50%; animation: spin 1s linear infinite;">
              </div>
              <span style="font-size: 0.875rem; color: #6b7280;">Memperbarui data...</span>
            </div>
          </div>

          <!-- Tabel Kinerja Guru -->
          <div style="overflow-x:auto;">
            <table>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Guru</th>
                  <th>Cabang</th>
                  <th>Keterlambatan</th>
                  <?php $__currentLoopData = $kategoriList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kategori): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <th><?php echo e($kategori->kategori); ?></th>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
              </thead>
              <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $kinerjaList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <tr>
                <td><?php echo e(($kinerjaList->currentPage() - 1) * $kinerjaList->perPage() + $loop->iteration); ?></td>
                <td><?php echo e($item['nama_guru']); ?></td>
                <td><?php echo e($item['cabang']); ?></td>
                <td><?php echo e($item['jumlahTelat']); ?></td>
                <?php $__currentLoopData = $item['penilaian']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nilai): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <td><?php echo e($nilai); ?></td>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="<?php echo e(4 + count($kategoriList)); ?>" style="text-align: center;">Belum ada data untuk periode
            ini.</td>
          </tr>
        <?php endif; ?>
              </tbody>
            </table>
          </div>

          <!-- Pagination Section -->
          <?php if($kinerjaList->total() > 0): ?>
        <div class="pagination" style="margin-top: 1rem;">
        Showing <?php echo e($kinerjaList->firstItem()); ?> to <?php echo e($kinerjaList->lastItem()); ?> of <?php echo e($kinerjaList->total()); ?>

        entries
        </div>
      <?php endif; ?>
          <?php if($kinerjaList->hasPages()): ?>
          <div class="box-pagination-left">
          
          <?php if($kinerjaList->onFirstPage()): ?>
        <span class="page-box-small disabled">«</span>
        <?php else: ?>
        <a href="<?php echo e($kinerjaList->previousPageUrl()); ?>" class="page-box-small">«</a>
        <?php endif; ?>
          
          <?php $__currentLoopData = $kinerjaList->getUrlRange(1, $kinerjaList->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php if($page == $kinerjaList->currentPage()): ?>
          <span class="page-box-small active"><?php echo e($page); ?></span>
          <?php else: ?>
          <a href="<?php echo e($url); ?>" class="page-box-small"><?php echo e($page); ?></a>
          <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          
          <?php if($kinerjaList->hasMorePages()): ?>
        <a href="<?php echo e($kinerjaList->nextPageUrl()); ?>" class="page-box-small">»</a>
        <?php else: ?>
        <span class="page-box-small disabled">»</span>
        <?php endif; ?>
          </div>
      <?php endif; ?>
        </div>
      </div>
    </div>
</body>
<script>
  function toggleDropdown() {
    const menu = document.getElementById('dropdown-menu');
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
  }

  function selectYear(id, tahun) {
    // Tampilkan loading
    document.getElementById('loading').style.display = 'block';

    // Update tampilan dropdown
    document.getElementById('selected-year').textContent = tahun;
    document.getElementById('dropdown-menu').style.display = 'none';

    // Kirim request AJAX untuk update session
    fetch('<?php echo e(route("admin.dashboard.update-periode")); ?>', {
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
          document.getElementById('loading').style.display = 'none';
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengupdate periode');
        document.getElementById('loading').style.display = 'none';
      });
  }

  // Tutup dropdown saat klik di luar
  window.addEventListener('click', function (e) {
    if (!e.target.closest('.dropdown')) {
      document.getElementById("dropdown-menu").style.display = "none";
    }
  });

  // CSS untuk animasi loading
  const style = document.createElement('style');
  style.textContent = `
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
`;
  document.head.appendChild(style);
</script>


</html><?php /**PATH D:\Adel\Semester 8\TA Adel\Sistem\sistemrtq\resources\views/admin/kinerjaguru/index.blade.php ENDPATH**/ ?>