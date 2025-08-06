<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Tambah Data Santri</title>
  <link rel="shortcut icon" href="{{ asset('img/image/logortq.png') }}" type="image/x-icon">
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
      <a href="{{ route('admin.dataguru.index') }}">Data Guru</a>
      <a href="{{ route('admin.datasantri.index') }}" class="active">Data Santri</a>
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
        <h1>Tambah Data Santri</h1>
        <img src="{{ asset('img/image/logortq.png') }}" alt="Logo RTQ" height="150" width="100" />
      </div>

      <div class="form-container">
        <form action="{{ route('admin.datasantri.store') }}" method="POST">
          @csrf

          <div style="display: grid; grid-template-columns: 1fr 1fr ; gap: 0.75rem 1.25rem;">

            <div style="display: flex; flex-direction: column;">
              <input type="text" name="nama_santri" id="nama_santri" placeholder="Masukan Nama Santri" required>
            </div>

            <div style="display: flex; flex-direction: column;">
              <input type="text" name="tempat_lahir" id="tempat_lahir" placeholder="Masukan Tempat Lahir" required>
            </div>

            <div style="display: flex; flex-direction: column;">
              <input type="date" name="tanggal_lahir" id="tanggal_lahir" required>
            </div>

            <div style="display: flex; flex-direction: column;">
              <input type="text" name="asal" id="asal" placeholder="Masukan Asal" required>
            </div>

            <div style="display: flex; flex-direction: column;">
              <input type="text" name="nis" id="nis" placeholder="Masukan NIS" required>
            </div>

            <div style="display: flex; flex-direction: column;">
              <input type="text" name="email" id="email" placeholder="Masukan Email" required>
            </div>

            <div style="display: flex; flex-direction: column;">
              <input type="text" name="asal_sekolah" id="asal_sekolah" placeholder="Masukan Asal Sekolah" required>
            </div>

            <div style="display: flex; flex-direction: column;">
              <input type="text" name="nama_ortu" id="nama_ortu" placeholder="Masukan Nama Orang Tua" required>
            </div>

            <div style="display: flex; flex-direction: column;">
              <input type="text" name="NoHP_ortu" id="NoHP_ortu" placeholder="Masukan No HP Orang Tua" required>
            </div>

            <div style="display: flex; flex-direction: column;">
              <input type="text" name="pekerjaan_ortu" id="pekerjaan_ortu" placeholder="Masukan Pekerjaan Orang Tua"
                required>
            </div>

            <div style="display: flex; flex-direction: column;">
              <select name="MK" id="MK" required>
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

            <div style="display: flex; flex-direction: column;">
              <select name="GolDar" id="GolDar" required>
                <option value="" disabled selected>Masukan Golongan Darah</option>
                <option value="A">A</option>
                <option value="AB">AB</option>
                <option value="B">B</option>
                <option value="O">O</option>
              </select>
            </div>

            <div style="display: flex; flex-direction: column;">
              <select name="jenis_kelamin" id="jenis_kelamin" required>
                <option value="" disabled selected>Masukan Jenis Kelamin</option>
                <option value="P">Perempuan</option>
                <option value="L">Laki-Laki</option>
              </select>
            </div>

            <div style="display: flex; flex-direction: column;">
              <select name="kat_masuk" id="kat_masuk" required>
                <option value="" disabled selected>Masukan Kategori Masuk</option>
                <option value="Umum">Umum</option>
                <option value="Beasiswa">Beasiswa</option>
              </select>
            </div>

            <div style="display: flex; flex-direction: column;">
              <select name="kelas" id="kelas" required>
                <option value="" disabled selected>Masukan Kelas</option>
                <option value="Halaqah A">Halaqah A</option>
                <option value="Halaqah B">Halaqah B</option>
                <option value="Halaqah C">Halaqah C</option>
                <option value="Halaqah D">Halaqah D</option>
                <option value="Halaqah E">Halaqah E</option>
              </select>
            </div>

            <div style="display: flex; flex-direction: column;">
              <select name="periode_id" id="periode" required>
                <option value="" disabled selected>Pilih Periode</option>
                @foreach($periodes as $p)
          <option value="{{ $p->id }}">{{ $p->tahun_ajaran }}</option>
        @endforeach
              </select>
            </div>

            <div style="display: flex; flex-direction: column;">
              <select name="jenis_kelas" id="jenis_kelas" required>
                <option value="" disabled selected>Jenis Kelas</option>
                <option value="1 Tahun">1 Tahun</option>
                <option value="2 Tahun">2 Tahun</option>
              </select>
            </div>

            <div style="display: flex; flex-direction: column;">
              <select name="cabang" id="cabang" required>
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
              <a href="{{ route('admin.datasantri.index') }}">
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