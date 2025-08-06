<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Edit Data Santri</title>
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
        <h1>Edit Data Santri</h1>
        <img src="<?php echo e(asset('img/image/logortq.png')); ?>" alt="Logo RTQ" height="150" width="100" />
      </div>

      <div class="form-container">
        <div class="form-content">
          <form action="<?php echo e(route('admin.datasantri.update', $santri->id)); ?>" method="POST"
            enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <!-- Container Grid 2 Kolom -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem 1.25rem;">

              <div style="display: flex; flex-direction: column;">
                <input type="text" name="nama_santri" placeholder="Masukan Nama Santri"
                  value="<?php echo e(old('nama_santri', $santri->nama_santri)); ?>" required>
              </div>

              <div style="display: flex; flex-direction: column;">
                <input type="text" name="tempat_lahir" placeholder="Masukan Tempat Lahir"
                  value="<?php echo e(old('tempat_lahir', $santri->tempat_lahir)); ?>" required>
              </div>

              <div style="display: flex; flex-direction: column;">
                <input type="date" name="tanggal_lahir" value="<?php echo e(old('tanggal_lahir', $santri->tanggal_lahir)); ?>"
                  required>
              </div>

              <div style="display: flex; flex-direction: column;">
                <input type="text" name="asal" placeholder="Masukan Asal" value="<?php echo e(old('asal', $santri->asal)); ?>"
                  required>
              </div>

              <div style="display: flex; flex-direction: column;">
                <input type="text" name="nis" placeholder="Masukan NIS" value="<?php echo e(old('nis', $santri->nis)); ?>" required>
              </div>

              <div style="display: flex; flex-direction: column;">
                <input type="text" name="email" placeholder="Masukan Email" value="<?php echo e(old('email', $santri->email)); ?>"
                  required>
              </div>

              <div style="display: flex; flex-direction: column;">
                <input type="text" name="asal_sekolah" placeholder="Masukan Asal Sekolah"
                  value="<?php echo e(old('asal_sekolah', $santri->asal_sekolah)); ?>" required>
              </div>

              <div style="display: flex; flex-direction: column;">
                <input type="text" name="nama_ortu" placeholder="Masukan Nama Orang Tua"
                  value="<?php echo e(old('nama_ortu', $santri->nama_ortu)); ?>" required>
              </div>

              <div style="display: flex; flex-direction: column;">
                <input type="text" name="NoHP_ortu" placeholder="Masukan No HP Orang Tua"
                  value="<?php echo e(old('NoHP_ortu', $santri->NoHP_ortu)); ?>" required>
              </div>

              <div style="display: flex; flex-direction: column;">
                <input type="text" name="pekerjaan_ortu" placeholder="Masukan Pekerjaan Orang Tua"
                  value="<?php echo e(old('pekerjaan_ortu', $santri->pekerjaan_ortu)); ?>" required>
              </div>

              <div style="display: flex; flex-direction: column;">
                <select name="MK" required>
                  <option value="" disabled <?php echo e(old('MK', $santri->MK) ? '' : 'selected'); ?>>Masukan MK</option>
                  <?php $__currentLoopData = ['Si', 'Se', 'Ti', 'Te', 'In', 'Fi', 'Fe', 'Ii', 'Ie']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($mk); ?>" <?php echo e(old('MK', $santri->MK) == $mk ? 'selected' : ''); ?>><?php echo e($mk); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>

              <div style="display: flex; flex-direction: column;">
                <select name="GolDar" required>
                  <option value="" disabled <?php echo e(old('GolDar', $santri->GolDar) ? '' : 'selected'); ?>>Masukan Golongan
                    Darah</option>
                  <?php $__currentLoopData = ['A', 'AB', 'B', 'O']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($gd); ?>" <?php echo e(old('GolDar', $santri->GolDar) == $gd ? 'selected' : ''); ?>><?php echo e($gd); ?>

            </option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>

              <div style="display: flex; flex-direction: column;">
                <select name="jenis_kelamin" required>
                  <option value="" disabled <?php echo e(old('jenis_kelamin', $santri->jenis_kelamin) ? '' : 'selected'); ?>>Masukan
                    Jenis Kelamin</option>
                  <option value="P" <?php echo e(old('jenis_kelamin', $santri->jenis_kelamin) == 'P' ? 'selected' : ''); ?>>Perempuan
                  </option>
                  <option value="L" <?php echo e(old('jenis_kelamin', $santri->jenis_kelamin) == 'L' ? 'selected' : ''); ?>>Laki-Laki
                  </option>
                </select>
              </div>

              <div style="display: flex; flex-direction: column;">
                <select name="kat_masuk" required>
                  <option value="" disabled <?php echo e(old('kat_masuk', $santri->kat_masuk) ? '' : 'selected'); ?>>Masukan
                    Kategori Masuk</option>
                  <option value="Umum" <?php echo e(old('kat_masuk', $santri->kat_masuk) == 'Umum' ? 'selected' : ''); ?>>Umum
                  </option>
                  <option value="Beasiswa" <?php echo e(old('kat_masuk', $santri->kat_masuk) == 'Beasiswa' ? 'selected' : ''); ?>>
                    Beasiswa</option>
                </select>
              </div>

              <div style="display: flex; flex-direction: column;">
                <select name="kelas" required>
                  <option value="" disabled <?php echo e(old('kelas', $santri->kelas) ? '' : 'selected'); ?>>Masukan Kelas</option>
                  <?php $__currentLoopData = ['Halaqah A', 'Halaqah B', 'Halaqah C', 'Halaqah D', 'Halaqah E']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kls): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($kls); ?>" <?php echo e(old('kelas', $santri->kelas) == $kls ? 'selected' : ''); ?>><?php echo e($kls); ?>

            </option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>

              <div style="display: flex; flex-direction: column;">
                <select name="periode_id" required>
                  <option value="" disabled <?php echo e(old('periode_id', $santri->periode_id) ? '' : 'selected'); ?>>Pilih Periode
                  </option>
                  <?php $__currentLoopData = $periodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $periode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($periode->id); ?>" <?php echo e(old('periode_id', $santri->periode_id) == $periode->id ? 'selected' : ''); ?>>
            <?php echo e($periode->tahun_ajaran); ?>

            </option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>

              <div style="display: flex; flex-direction: column;">
                <select name="jenis_kelas" required>
                  <option value="" disabled <?php echo e(old('jenis_kelas', $santri->jenis_kelas) ? '' : 'selected'); ?>>Jenis Kelas
                  </option>
                  <option value="1 Tahun" <?php echo e(old('jenis_kelas', $santri->jenis_kelas) == '1 Tahun' ? 'selected' : ''); ?>>1
                    Tahun</option>
                  <option value="2 Tahun" <?php echo e(old('jenis_kelas', $santri->jenis_kelas) == '2 Tahun' ? 'selected' : ''); ?>>2
                    Tahun</option>
                </select>
              </div>

              <div style="display: flex; flex-direction: column;">
                <select name="cabang" required>
                  <option value="" disabled <?php echo e(old('cabang', $santri->cabang) ? '' : 'selected'); ?>>Masukan Cabang
                  </option>
                  <?php $__currentLoopData = ['Sukajadi', 'Rumbai', 'Gobah 1', 'Gobah 2', 'Rawa Bening']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cabang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($cabang); ?>" <?php echo e(old('cabang', $santri->cabang) == $cabang ? 'selected' : ''); ?>>
            <?php echo e($cabang); ?>

            </option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>

            </div>

            <!-- Tombol Aksi -->
            <div style="margin-top: 20px; display: flex; gap: 10px;">
              <a href="<?php echo e(route('admin.datasantri.index')); ?>">
                <button type="button"
                  style="padding: 0.5rem 1rem; background-color: #ccc; border: none;">Kembali</button>
              </a>
              <button type="submit"
                style="padding: 0.5rem 1rem; background-color: #a4e4b3; color: black; border: none;">Ubah</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const input = document.getElementById('tanggal_lahir');
      const label = document.querySelector('.date-placeholder');

      function toggleLabel() {
        if (input.value) {
          label.style.opacity = '0';
          label.style.visibility = 'hidden';
        } else {
          label.style.opacity = '1';
          label.style.visibility = 'visible';
        }
      }

      input.addEventListener('input', toggleLabel);
      toggleLabel();
    });
  </script>
</body>

</html><?php /**PATH D:\Adel\Semester 8\TA Adel\Sistem\sistemrtq\resources\views/admin/datasantri/edit.blade.php ENDPATH**/ ?>