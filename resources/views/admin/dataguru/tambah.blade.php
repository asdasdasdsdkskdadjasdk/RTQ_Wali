<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Tambah Data Guru</title>
  <link rel="shortcut icon" href="{{ asset('img/image/logortq.png') }}" alt="Logo RTQ" height="100" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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

        <a href="{{ route('dashboard') }}"><i class="fa-solid fa-house" style="margin-right:8px;"></i>Dashboard</a>
        <a href="{{ route('admin.jadwalmengajar.index') }}"><i class="fa-solid fa-calendar-days" style="margin-right:8px;"></i>Jadwal Mengajar</a>
        <a href="{{ route('admin.dataguru.index') }}" class="active"><i class="fa-solid fa-chalkboard-teacher" style="margin-right:8px;"></i>Data Guru</a>
        <a href="{{ route('admin.datasantri.index') }}"><i class="fa-solid fa-users" style="margin-right:8px;"></i>Data Santri</a>
        <a href="{{ route('admin.kelolapengguna.index') }}"><i class="fa-solid fa-user-gear" style="margin-right:8px;"></i>Kelola Pengguna</a>
        <a href="{{ route('admin.periode.index') }}"><i class="fa-solid fa-clock" style="margin-right:8px;"></i>Periode</a>
        <a href="{{ route('admin.kategoripenilaian.index') }}"><i class="fa-solid fa-list" style="margin-right:8px;"></i>Kategori Penilaian</a>
        <a href="{{ route('admin.kehadiranA.index') }}"><i class="fa-solid fa-check-circle" style="margin-right:8px;"></i>Kehadiran</a>
        <a href="{{ route('admin.hafalanadmin.index') }}"><i class="fa-solid fa-book" style="margin-right:8px;"></i>Hafalan Santri</a>
        <a href="{{ route('admin.kinerjaguru.index') }}"><i class="fa-solid fa-chart-line" style="margin-right:8px;"></i>Kinerja Guru</a>
      </div>

      <!-- Bagian Bawah -->
      <div style="border-top: 1px solid #ddd; padding-top: 10px;">
        <a href="{{ route('password.editAdmin') }}"><i class="fa-solid fa-key" style="margin-right:8px;"></i>Ubah Password</a>
      </div>

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
              <label for="user_id"><strong>User Guru <span style="color: red;">*</span></strong></label><br>
              <select name="user_id" id="user_id" style="width: 49%; padding: 8px; box-sizing: border-box;" required>
                <option value="">-- Pilih User Guru --</option>
                @foreach ($users as $user)
                  <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
              </select>
            </div>

            <!-- Tempat Lahir, Tanggal Lahir, No HP -->
            <div style="display: flex; gap: 20px; margin-bottom: 15px;">
              <div style="flex: 1;">
                <label for="tempat_lahir"><strong>Tempat Lahir <span style="color: red;">*</span></strong></label>
                <input type="text" name="tempat_lahir" id="tempat_lahir" placeholder="Masukan Tempat Lahir" required
                  style="width: 100%; padding: 8px; box-sizing: border-box;">
              </div>
              <div style="flex: 1;">
                <label for="tanggal_lahir"><strong>Tanggal Lahir <span style="color: red;">*</span></strong></label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" required
                  style="width: 100%; padding: 8px; box-sizing: border-box;">
              </div>
              <div style="flex: 1;">
                <label for="no_hp"><strong>No HP <span style="color: red;">*</span></strong></label>
                <input type="text" name="no_hp" id="no_hp" placeholder="Masukan No HP" required
                  style="width: 100%; padding: 8px; box-sizing: border-box;">
              </div>
            </div>

            <!-- Alamat, Jumlah Hafalan, Jenis Kelamin -->
            <div style="display: flex; gap: 20px; margin-bottom: 15px;">
              <div style="flex: 1;">
                <label for="alamat"><strong>Alamat <span style="color: red;">*</span></strong></label>
                <input type="text" name="alamat" id="alamat" placeholder="Masukan Alamat" required
                  style="width: 100%; padding: 8px; box-sizing: border-box;">
              </div>
              <div style="flex: 1;">
                <label for="jlh_hafalan"><strong>Jumlah Hafalan <span style="color: red;">*</span></strong></label>
                <input type="text" name="jlh_hafalan" id="jlh_hafalan" placeholder="Masukan Jumlah Hafalan" required
                  style="width: 100%; padding: 8px; box-sizing: border-box;">
              </div>
              <div style="flex: 1;">
                <label for="jenis_kelamin"><strong>Jenis Kelamin <span style="color: red;">*</span></strong></label>
                <select name="jenis_kelamin" id="jenis_kelamin" required
                  style="width: 100%; padding: 8px; box-sizing: border-box;">
                  <option value="" disabled selected>Masukan Jenis Kelamin</option>
                  <option value="P">Perempuan</option>
                  <option value="L">Laki-laki</option>
                </select>
              </div>
            </div>

            <!-- Pendidikan Terakhir, Golongan Darah, MK -->
            <div style="display: flex; gap: 20px; margin-bottom: 15px;">
              <div style="flex: 1;">
                <label for="pend_akhir"><strong>Pendidikan Terakhir <span style="color: red;">*</span></strong></label>
                <select name="pend_akhir" id="pend_akhir" required
                  style="width: 100%; padding: 8px; box-sizing: border-box;">
                  <option value="" disabled selected>Masukan Pendidikan Terakhir</option>
                  <option value="SD">SD</option>
                  <option value="SMP/Sederajat">SMP/Sederajat</option>
                  <option value="SMA/Sederajat">SMA/Sederajat</option>
                  <option value="S1">S1</option>
                  <option value="S2">S2</option>
                  <option value="S3">S3</option>
                </select>
              </div>
              <div style="flex: 1;">
                <label for="gol_dar"><strong>Golongan Darah <span style="color: red;">*</span></strong></label>
                <select name="gol_dar" id="gol_dar" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                  <option value="" disabled selected>Masukan Golongan Darah</option>
                  <option value="A">A</option>
                  <option value="AB">AB</option>
                  <option value="B">B</option>
                  <option value="O">O</option>
                </select>
              </div>
              <div style="flex: 1;">
                <label for="mk"><strong>MK <span style="color: red;">*</span></strong></label>
                <select name="mk" id="mk" required style="width: 100%; padding: 8px; box-sizing: border-box;">
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
              </div>
            </div>

            <!-- Status Menikah, Bagian, Cabang -->
            <div style="display: flex; gap: 20px; margin-bottom: 15px;">
              <div style="flex: 1;">
                <label for="status_menikah"><strong>Status Menikah <span style="color: red;">*</span></strong></label>
                <select name="status_menikah" id="status_menikah" required
                  style="width: 100%; padding: 8px; box-sizing: border-box;">
                  <option value="" disabled selected>Masukan Status Menikah</option>
                  <option value="Menikah">Menikah</option>
                  <option value="Belum Menikah">Belum Menikah</option>
                </select>
              </div>
              <div style="flex: 1;">
                <label for="bagian"><strong>Bagian <span style="color: red;">*</span></strong></label>
                <select name="bagian" id="bagian" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                  <option value="" disabled selected>Masukan Bagian</option>
                  <option value="Admin">Admin</option>
                  <option value="Yayasan">Yayasan</option>
                  <option value="Guru Kelas">Guru Kelas</option>
                </select>
              </div>
              <div style="flex: 1;">
                <label for="cabang"><strong>Cabang <span style="color: red;">*</span></strong></label>
                <select name="cabang" id="cabang" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                  <option value="" disabled selected>Masukan Cabang</option>
                  <option value="Sukajadi">Sukajadi</option>
                  <option value="Rumbai">Rumbai</option>
                  <option value="Gobah 1">Gobah 1</option>
                  <option value="Gobah 2">Gobah 2</option>
                  <option value="Rawa Bening">Rawa Bening</option>
                </select>
              </div>
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
