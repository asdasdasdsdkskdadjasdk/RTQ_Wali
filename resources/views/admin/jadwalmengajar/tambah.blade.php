<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Tambah Jadwal Mengajar</title>
  <link rel="shortcut icon" href="{{ asset('img/image/logortq.png') }}" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

  <div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Profil & Logout -->
      <div class="sidebar-header">
        <div style="display: flex; align-items: center; gap: 8px;">
          <img src="{{ asset('img/image/akun.png') }}" alt="Foto Admin"
            style="width: 40px; height: 40px; border-radius: 40%;">
          <strong>Admin</strong>
        </div>

        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" style="background: none; border: none; cursor: pointer;">
            <img src="{{ asset('img/image/logout.png') }}" alt="Logout" style="width: 18px; height: 18px;">
          </button>
        </form>
      </div>

      <!-- Menu -->
      <a href="{{ route('dashboard') }}">Dashboard</a>
      <a href="{{ route('admin.jadwalmengajar.index') }}" class="active">Jadwal Mengajar</a>
      <a href="{{ route('admin.dataguru.index') }}">Data Guru</a>
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
        <h1>Tambah Jadwal Mengajar</h1>
        <img src="{{ asset('img/image/logortq.png') }}" alt="Logo RTQ" height="100" width="100" />
      </div>

      <!-- Form Tambah Jadwal -->
      <div class="form-container">
        <form action="{{ route('admin.jadwalmengajar.store') }}" method="POST">
          @csrf

          <!--  Guru & Cabang -->
          <div style="display: flex; gap: 16px;">
            <div style="flex: 1;">
              <label style="display: block; margin-bottom: 4px;">
                <strong>Nama Guru <span style="color: red;">*</span></strong>
              </label>
              <select name="guru_id" required style="width: 100%; padding: 8px;">
                <option value="" disabled selected>Pilih Nama Guru</option>
                @foreach($gurus as $guru)
                  <option value="{{ $guru->id }}">{{ $guru->nama_guru }}</option>
                @endforeach
              </select>
            </div>
            <div style="flex: 1;">
              <label style="display: block; margin-bottom: 4px;">
                <strong>Cabang <span style="color: red;">*</span></strong>
              </label>
              <select name="cabang" required style="width: 100%; padding: 8px;">
                <option value="" disabled selected>Pilih Cabang</option>
                <option value="Sukajadi">Sukajadi</option>
                <option value="Rumbai">Rumbai</option>
                <option value="Gobah 1">Gobah 1</option>
                <option value="Gobah 2">Gobah 2</option>
                <option value="Rawa Bening">Rawa Bening</option>
              </select>
            </div>
          </div>

          <!-- Kelas & Kegiatan -->
          <div style="display: flex; gap: 16px; margin-top: 16px;">
            <div style="flex: 1;">
              <label style="display: block; margin-bottom: 4px;">
                <strong>Kelas <span style="color: red;">*</span></strong>
              </label>
              <select name="kelas" required style="width: 100%; padding: 8px;">
                <option value="" disabled selected>Pilih Kelas</option>
                <option value="Halaqah A">Halaqah A</option>
                <option value="Halaqah B">Halaqah B</option>
                <option value="Halaqah C">Halaqah C</option>
                <option value="Halaqah D">Halaqah D</option>
                <option value="Halaqah E">Halaqah E</option>
              </select>
            </div>
            <div style="flex: 1;">
              <label style="display: block; margin-bottom: 4px;">
                <strong>Kegiatan <span style="color: red;">*</span></strong>
              </label>
              <select name="kegiatan" required style="width: 100%; padding: 8px;">
                <option value="" disabled selected>Pilih Kegiatan</option>
                <option value="Tahajud">Tahajud</option>
                <option value="Subuh">Subuh</option>
                <option value="Dhuha">Dhuha</option>
                <option value="Dzuhur">Dzuhur</option>
                <option value="Ashar">Ashar</option>
                <option value="Magrib">Magrib</option>
                <option value="Isya">Isya</option>
                <option value="Hafalan">Hafalan</option>
                <option value="Murajaah">Muraja'ah</option>
              </select>
            </div>
          </div>

          <!-- Periode & Jam -->
          <div style="display: flex; gap: 16px; margin-top: 16px;">
            <!-- Periode -->
            <div style="flex: 1;">
              <label for="periode_id" style="display: block; margin-bottom: 4px;">
                <strong>Periode <span style="color: red;">*</span></strong>
              </label>
              <select name="periode_id" id="periode" required style="width: 100%; padding: 8px;">
                <option value="" disabled selected>Pilih Periode</option>
                @foreach($periodes as $p)
                  <option value="{{ $p->id }}">{{ $p->tahun_ajaran }}</option>
                @endforeach
              </select>
            </div>

            <!-- Jam -->
            <div style="flex: 1;">
              <label style="display: block; margin-bottom: 4px;">
                <strong>Jam <span style="color: red;">*</span></strong>
              </label>
              <div style="display: flex; align-items: center;">
                <input type="time" name="jam_masuk" required style="padding: 6px; flex: 1;">
                <span style="margin: 0 8px;">-</span>
                <input type="time" name="jam_keluar" required style="padding: 6px; flex: 1;">
              </div>
            </div>
          </div>

          <!-- Tombol -->
          <div style="margin-top: 20px; display: flex; gap: 10px;">
            <a href="{{ route('admin.jadwalmengajar.index') }}">
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

</body>

</html>
