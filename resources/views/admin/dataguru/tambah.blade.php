<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Tambah Data Guru</title>
  <link rel="shortcut icon" href="{{ asset('img/image/logortq.png') }}" alt="Logo RTQ" height="100" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

  <div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Profil & Logout -->
      <div class="sidebar-header">
        <!-- Profil -->
        <div style="display: flex; align-items: center; gap: 8px;">
          <img src="{{ asset('img/image/akun.png') }}" alt="Foto Admin"
            style="width: 40px; height: 40px; border-radius: 40%;">
          <strong>Admin</strong>
        </div>

        <!-- Tombol Logout -->
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" style="background: none; border: none; cursor: pointer;">
            <img src="{{ asset('img/image/logout.png') }}" alt="Logout" style="width: 18px; height: 18px;">
          </button>
        </form>
      </div>

      <!-- Menu -->
      <a href="{{ route('dashboard') }}">Dashboard</a>
      <a href="{{ route('admin.jadwalmengajar.index') }}">Jadwal Mengajar</a>
      <a href="{{ route('admin.dataguru.index') }}" class="active">Data Guru</a>
      <a href="{{ route('admin.datasantri.index') }}">Data Santri</a>
      <a href="{{ route('admin.kelolapengguna.index') }}">Kelola Pengguna</a>
      <a href="{{ route('admin.periode.index') }}">Periode</a>
      <a href="{{ route('admin.kategoripenilaian.index') }}">Kategori Penilaian</a>
      <a href="{{ route('admin.kehadiranA.index') }}">Kehadiran</a>
      <a href="{{ route('admin.hafalanadmin.index') }}">Hafalan Santri</a>
      <a href="{{ route('admin.kinerjaguru.index') }}">Kinerja Guru</a>
    </div>

    <!-- Main Content -->
    <div class="main">
      <div class="topbar">
        <h1>Tambah Data Guru</h1>
        <img src="{{ asset('img/image/logortq.png') }}" alt="Logo RTQ" height="150" width="100" />
      </div>

      <!-- Form Tambah Data Guru -->
      <div class="form-container">
        <div class="form-content">
          <form action="{{ route('admin.dataguru.store') }}" method="POST">
            @csrf

            <!-- Pilih User Guru -->
            <div style="margin-bottom: 15px;">
              <select name="user_id" id="user_id" style="width: 49%; padding: 8px; box-sizing: border-box;" required>
                <option value="">-- Pilih User Guru --</option>
                @foreach ($users as $user)
          <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
        @endforeach
              </select>
            </div>

            <!-- Tempat Lahir & Tanggal Lahir -->
            <div style="display: flex; gap: 20px; margin-bottom: 15px;">
              <input type="text" name="tempat_lahir" id="tempat_lahir" placeholder="Masukan Tempat Lahir" required
                style="flex: 1; padding: 8px; box-sizing: border-box;">
              <input type="date" name="tanggal_lahir" id="tanggal_lahir" required
                style="flex: 1; padding: 8px; box-sizing: border-box;">
            </div>

            <!-- Alamat & No HP -->
            <div style="display: flex; gap: 20px; margin-bottom: 15px;">
              <input type="text" name="alamat" id="alamat" placeholder="Masukan Alamat" required
                style="flex: 1; padding: 8px; box-sizing: border-box;">
              <input type="text" name="no_hp" id="no_hp" placeholder="Masukan No HP" required
                style="flex: 1; padding: 8px; box-sizing: border-box;">
            </div>

            <!-- Jumlah Hafalan & Jenis Kelamin -->
            <div style="display: flex; gap: 20px; margin-bottom: 15px;">
              <input type="text" name="jlh_hafalan" id="jlh_hafalan" placeholder="Masukan Jumlah Hafalan" required
                style="flex: 1; padding: 8px; box-sizing: border-box;">
              <select name="jenis_kelamin" id="jenis_kelamin" required
                style="flex: 1; padding: 8px; box-sizing: border-box;">
                <option value="" disabled selected>Masukan Jenis Kelamin</option>
                <option value="P">Perempuan</option>
                <option value="L">Laki-laki</option>
              </select>
            </div>

            <!-- Pendidikan Terakhir & Golongan Darah -->
            <div style="display: flex; gap: 20px; margin-bottom: 15px;">
              <select name="pend_akhir" id="pend_akhir" required style="flex: 1; padding: 8px; box-sizing: border-box;">
                <option value="" disabled selected>Masukan Pendidikan Terakhir</option>
                <option value="SD">SD</option>
                <option value="SMP/Sederajat">SMP/Sederajat</option>
                <option value="SMA/Sederajat">SMA/Sederajat</option>
                <option value="S1">S1</option>
                <option value="S2">S2</option>
                <option value="S3">S3</option>
              </select>
              <select name="gol_dar" id="gol_dar" required style="flex: 1; padding: 8px; box-sizing: border-box;">
                <option value="" disabled selected>Masukan Golongan Darah</option>
                <option value="A">A</option>
                <option value="AB">AB</option>
                <option value="B">B</option>
                <option value="O">O</option>
              </select>
            </div>

            <!-- MK & Status Menikah -->
            <div style="display: flex; gap: 20px; margin-bottom: 15px;">
              <select name="mk" id="mk" required style="flex: 1; padding: 8px; box-sizing: border-box;">
                <option value="" disabled selected>Masukan MK</option>
                <option value="Si">Si</option>
                <option value="Se">Se</option>
                <option value="Ti">Ti</option>
                <option value="Te">Te</option>
                <option value="In">In</option>
                <option value="Fi">Fi</option>
                <option value="Fe">Fe</option>
                <option value="Ii">Ii</option>
                <option value="Ie">Ie</option>
              </select>
              <select name="status_menikah" id="status_menikah" required
                style="flex: 1; padding: 8px; box-sizing: border-box;">
                <option value="" disabled selected>Masukan Status Menikah</option>
                <option value="Menikah">Menikah</option>
                <option value="Belum Menikah">Belum Menikah</option>
              </select>
            </div>

            <!-- Bagian & Cabang -->
            <div style="display: flex; gap: 20px; margin-bottom: 15px;">
              <select name="bagian" id="bagian" required style="flex: 1; padding: 8px; box-sizing: border-box;">
                <option value="" disabled selected>Masukan Bagian</option>
                <option value="Admin">Admin</option>
                <option value="Yayasan">Yayasan</option>
                <option value="Guru Kelas">Guru Kelas</option>
              </select>
              <select name="cabang" id="cabang" required style="flex: 1; padding: 8px; box-sizing: border-box;">
                <option value="" disabled selected>Masukan Cabang</option>
                <option value="Sukajadi">Sukajadi</option>
                <option value="Rumbai">Rumbai</option>
                <option value="Gobah 1">Gobah 1</option>
                <option value="Gobah 2">Gobah 2</option>
                <option value="Rawa Bening">Rawa Bening</option>
              </select>
            </div>

            <!-- Tombol -->
            <div style="margin-top: 20px; display: flex; gap: 10px;">
              <a href="{{ route('admin.dataguru.index') }}">
                <button type="button"
                  style="padding: 0.5rem 1rem; background-color: #ccc; border: none;">Kembali</button>
              </a>
              <button type="submit"
                style="padding: 0.5rem 1rem; background-color: #a4e4b3; color: black; border: none;">Tambah</button>
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

</html>