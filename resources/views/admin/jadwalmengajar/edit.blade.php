<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Edit Jadwal Mengajar</title>
  <link rel="shortcut icon" href="{{ asset('img/image/logortq.png') }}" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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

        <a href="{{ route('dashboard') }}">
          <i class="fas fa-home" style="margin-right: 8px;"></i> Dashboard
        </a>
        <a href="{{ route('admin.jadwalmengajar.index') }}" class="active">
          <i class="fas fa-calendar-alt" style="margin-right: 8px;"></i> Jadwal Mengajar
        </a>
        <a href="{{ route('admin.dataguru.index') }}">
          <i class="fas fa-chalkboard-teacher" style="margin-right: 8px;"></i> Data Guru
        </a>
        <a href="{{ route('admin.datasantri.index') }}">
          <i class="fas fa-users" style="margin-right: 8px;"></i> Data Santri
        </a>
        <a href="{{ route('admin.kelolapengguna.index') }}">
          <i class="fas fa-users-cog" style="margin-right: 8px;"></i> Kelola Pengguna
        </a>
        <a href="{{ route('admin.periode.index') }}">
          <i class="fas fa-clock" style="margin-right: 8px;"></i> Periode
        </a>
        <a href="{{ route('admin.kategoripenilaian.index') }}">
          <i class="fas fa-list-ul" style="margin-right: 8px;"></i> Kategori Penilaian
        </a>
        <a href="{{ route('admin.kehadiranA.index') }}">
          <i class="fas fa-check-circle" style="margin-right: 8px;"></i> Kehadiran
        </a>
        <a href="{{ route('admin.hafalanadmin.index') }}">
          <i class="fas fa-book" style="margin-right: 8px;"></i> Hafalan Santri
        </a>
        <a href="{{ route('admin.kinerjaguru.index') }}">
          <i class="fas fa-chart-line" style="margin-right: 8px;"></i> Kinerja Guru
        </a>
      </div>

      <!-- Bagian Bawah -->
      <div style="border-top: 1px solid #ddd; padding-top: 10px;">
        <a href="{{ route('password.editAdmin') }}">
          <i class="fas fa-key" style="margin-right: 8px;"></i> Ubah Password
        </a>
      </div>

    </div>

    <!-- Main Content -->
    <div class="main">
      <div class="topbar">
        <h1>Edit Jadwal Mengajar</h1>
        <img src="{{ asset('img/image/logortq.png') }}" alt="Logo RTQ" height="150" width="100" />
      </div>

      <!-- Form Edit Jadwal -->
      <form action="{{ route('admin.jadwalmengajar.update', $jadwal->id) }}" method="POST" class="form-container">
        @csrf
        @method('PUT')

        <!-- Guru & Cabang -->
        <div style="display: flex; gap: 16px;">
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 4px;"><strong>Nama Guru</strong></label>
            <select name="guru_id" required style="width: 100%; padding: 8px;">
              <option value="" disabled>Pilih Nama Guru</option>
              @foreach ($gurus as $guru)
                <option value="{{ $guru->id }}" {{ $jadwal->guru_id == $guru->id ? 'selected' : '' }}>
                  {{ $guru->nama_guru }}
                </option>
              @endforeach
            </select>
          </div>

          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 4px;"><strong>Cabang</strong></label>
            <select name="cabang" required style="width: 100%; padding: 8px;">
              <option value="" disabled>Pilih Cabang</option>
              <option value="Sukajadi" {{ $jadwal->cabang == 'Sukajadi' ? 'selected' : '' }}>Sukajadi</option>
              <option value="Rumbai" {{ $jadwal->cabang == 'Rumbai' ? 'selected' : '' }}>Rumbai</option>
              <option value="Gobah 1" {{ $jadwal->cabang == 'Gobah 1' ? 'selected' : '' }}>Gobah 1</option>
              <option value="Gobah 2" {{ $jadwal->cabang == 'Gobah 2' ? 'selected' : '' }}>Gobah 2</option>
              <option value="Rawa Bening" {{ $jadwal->cabang == 'Rawa Bening' ? 'selected' : '' }}>Rawa Bening</option>
            </select>
          </div>
        </div>

        <!-- Kelas & Kegiatan -->
        <div style="display: flex; gap: 16px; margin-top: 16px;">
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 4px;"><strong>Kelas</strong></label>
            <select name="kelas" required style="width: 100%; padding: 8px;">
              <option value="" disabled>Pilih Kelas</option>
              <option value="Halaqah A" {{ $jadwal->kelas == 'Halaqah A' ? 'selected' : '' }}>Halaqah A</option>
              <option value="Halaqah B" {{ $jadwal->kelas == 'Halaqah B' ? 'selected' : '' }}>Halaqah B</option>
              <option value="Halaqah C" {{ $jadwal->kelas == 'Halaqah C' ? 'selected' : '' }}>Halaqah C</option>
              <option value="Halaqah D" {{ $jadwal->kelas == 'Halaqah D' ? 'selected' : '' }}>Halaqah D</option>
              <option value="Halaqah E" {{ $jadwal->kelas == 'Halaqah E' ? 'selected' : '' }}>Halaqah E</option>
            </select>
          </div>

          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 4px;"><strong>Kegiatan</strong></label>
            <select name="kegiatan" required style="width: 100%; padding: 8px;">
              <option value="" disabled>Pilih Kegiatan</option>
              <option value="Tahajud" {{ $jadwal->kegiatan == 'Tahajud' ? 'selected' : '' }}>Tahajud</option>
              <option value="Subuh" {{ $jadwal->kegiatan == 'Subuh' ? 'selected' : '' }}>Subuh</option>
              <option value="Dhuha" {{ $jadwal->kegiatan == 'Dhuha' ? 'selected' : '' }}>Dhuha</option>
              <option value="Dzuhur" {{ $jadwal->kegiatan == 'Dzuhur' ? 'selected' : '' }}>Dzuhur</option>
              <option value="Ashar" {{ $jadwal->kegiatan == 'Ashar' ? 'selected' : '' }}>Ashar</option>
              <option value="Magrib" {{ $jadwal->kegiatan == 'Magrib' ? 'selected' : '' }}>Magrib</option>
              <option value="Isya" {{ $jadwal->kegiatan == 'Isya' ? 'selected' : '' }}>Isya</option>
              <option value="Hafalan" {{ $jadwal->kegiatan == 'Hafalan' ? 'selected' : '' }}>Hafalan</option>
              <option value="Murajaah" {{ $jadwal->kegiatan == 'Murajaah' ? 'selected' : '' }}>Muraja'ah</option>
            </select>
          </div>
        </div>

        <!-- Periode & Jam -->
        <div style="display: flex; gap: 16px; margin-top: 16px;">
          <!-- Periode -->
          <div style="flex: 1;">
            <label for="periode_id" style="display: block; margin-bottom: 4px;"><strong>Periode</strong></label>
            <select name="periode_id" id="periode_id" required style="width: 100%; padding: 8px;">
              <option value="" disabled>Pilih Periode</option>
              @foreach ($periodes as $periode)
                <option value="{{ $periode->id }}" {{ $jadwal->periode_id == $periode->id ? 'selected' : '' }}>
                  {{ $periode->tahun_ajaran }}
                </option>
              @endforeach
            </select>
          </div>

          <!-- Jam -->
          <div style="flex: 1;">
            <label style="display: block; margin-bottom: 4px;"><strong>Jam</strong></label>
            <div style="display: flex; align-items: center;">
              <input type="time" name="jam_masuk" value="{{ \Carbon\Carbon::parse($jadwal->jam_masuk)->format('H:i') }}"
                required style="padding: 6px; flex: 1;">
              <span style="margin: 0 8px;">-</span>
              <input type="time" name="jam_keluar"
                value="{{ \Carbon\Carbon::parse($jadwal->jam_keluar)->format('H:i') }}" required
                style="padding: 6px; flex: 1;">
            </div>
          </div>
        </div>

        <!-- Tombol Aksi -->
        <div style="margin-top: 20px; display: flex; gap: 10px;">
          <a href="{{ route('admin.jadwalmengajar.index') }}">
            <button type="button" style="padding: 0.5rem 1rem; background-color: #ccc; border: none;">Kembali</button>
          </a>
          <button type="submit"
            style="padding: 0.5rem 1rem; background-color: #a4e4b3; color: black; border: none;">Ubah</button>
        </div>
      </form>

    </div>
  </div>

</body>

</html>
