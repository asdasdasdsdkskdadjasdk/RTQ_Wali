<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Tambah Jadwal Mengajar</title>
  <link rel="shortcut icon" href="{{ asset('img/image/logortq.png') }}" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

  <div class="container">
    <!-- Sidebar -->
    <div class="sidebar" style="display: flex; flex-direction: column; height: 100vh; justify-content: space-between;">

      <!-- Bagian Atas -->
      <div style="flex: 1; overflow-y: auto;">
        <div class="sidebar-header">
          <div style="display: flex; align-items: center; gap: 8px;">
            <img src="{{ asset('img/image/akun.png') }}" alt="Foto Admin"
              style="width: 40px; height: 40px; border-radius: 40%;">
            <strong>Admin</strong>
          </div>
          <form method="POST" action="{{ route('logout') }}" style="margin-right: 8px;">
            @csrf
            <button type="submit" style="background: none; border: none; cursor: pointer; padding: 4px;">
              <img src="{{ asset('img/image/logout.png') }}" alt="Logout" style="width: 18px; height: 18px;">
            </button>
          </form>
        </div>

        <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
        <a href="{{ route('admin.jadwalmengajar.index') }}" class="active"><i class="fas fa-calendar-alt"></i> Jadwal Mengajar</a>
        <a href="{{ route('admin.dataguru.index') }}"><i class="fas fa-chalkboard-teacher"></i> Data Guru</a>
        <a href="{{ route('admin.datasantri.index') }}"><i class="fas fa-users"></i> Data Santri</a>
        <a href="{{ route('admin.kelolapengguna.index') }}"><i class="fas fa-users-cog"></i> Kelola Pengguna</a>
        <a href="{{ route('admin.periode.index') }}"><i class="fas fa-clock"></i> Periode</a>
        <a href="{{ route('admin.kategoripenilaian.index') }}"><i class="fas fa-list-ul"></i> Kategori Penilaian</a>
        <a href="{{ route('admin.kehadiranA.index') }}"><i class="fas fa-check-circle"></i> Kehadiran</a>
        <a href="{{ route('admin.hafalanadmin.index') }}"><i class="fas fa-book"></i> Hafalan Santri</a>
        <a href="{{ route('admin.kinerjaguru.index') }}"><i class="fas fa-chart-line"></i> Kinerja Guru</a>
      </div>

      <!-- Bagian Bawah -->
      <div style="border-top: 1px solid #ddd; padding-top: 10px;">
        <a href="{{ route('password.editAdmin') }}"><i class="fas fa-key"></i> Ubah Password</a>
      </div>

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
              <button type="button" style="padding: 0.5rem 1rem; background-color: #ccc; border: none;">Kembali</button>
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
