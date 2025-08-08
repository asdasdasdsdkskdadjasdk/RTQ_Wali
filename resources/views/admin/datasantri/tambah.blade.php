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
      <div class="sidebar-header">
        <div style="display: flex; align-items: center; gap: 8px;">
          <img src="{{ asset('img/image/akun.png') }}" alt="Foto Admin" style="width: 40px; height: 40px; border-radius: 40%;">
          <strong>Admin</strong>
        </div>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" style="background: none; border: none; cursor: pointer;">
            <img src="{{ asset('img/image/logout.png') }}" alt="Logout" style="width: 18px; height: 18px;">
          </button>
        </form>
      </div>

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

          <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 0.5rem 1rem;">

            @php
              $fields = [
                ['nama_santri', 'Nama Santri'],
                ['tempat_lahir', 'Tempat Lahir'],
                ['tanggal_lahir', 'Tanggal Lahir', 'date'],
                ['asal', 'Asal'],
                ['nis', 'NIS'],
                ['email', 'Email'],
                ['asal_sekolah', 'Asal Sekolah'],
                ['nama_ortu', 'Nama Orang Tua'],
                ['NoHP_ortu', 'No HP Orang Tua'],
                ['pekerjaan_ortu', 'Pekerjaan Orang Tua'],
              ];
            @endphp

            @foreach($fields as $f)
              <div style="display: flex; flex-direction: column;">
                <label for="{{ $f[0] }}"><strong>{{ $f[1] }} <span style="color:red;">*</span></strong></label>
                <input type="{{ $f[2] ?? 'text' }}" name="{{ $f[0] }}" id="{{ $f[0] }}" placeholder="Masukan {{ $f[1] }}" required>
              </div>
            @endforeach

            <!-- Dropdown fields with label + bintang merah -->
            <div style="display: flex; flex-direction: column;">
              <label for="MK"><strong>MK <span style="color:red;">*</span></strong></label>
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
              <label for="GolDar"><strong>Golongan Darah <span style="color:red;">*</span></strong></label>
              <select name="GolDar" id="GolDar" required>
                <option value="" disabled selected>Masukan Golongan Darah</option>
                <option value="A">A</option>
                <option value="AB">AB</option>
                <option value="B">B</option>
                <option value="O">O</option>
              </select>
            </div>

            <div style="display: flex; flex-direction: column;">
              <label for="jenis_kelamin"><strong>Jenis Kelamin <span style="color:red;">*</span></strong></label>
              <select name="jenis_kelamin" id="jenis_kelamin" required>
                <option value="" disabled selected>Masukan Jenis Kelamin</option>
                <option value="P">Perempuan</option>
                <option value="L">Laki-Laki</option>
              </select>
            </div>

            <div style="display: flex; flex-direction: column;">
              <label for="kat_masuk"><strong>Kategori Masuk <span style="color:red;">*</span></strong></label>
              <select name="kat_masuk" id="kat_masuk" required>
                <option value="" disabled selected>Masukan Kategori Masuk</option>
                <option value="Umum">Umum</option>
                <option value="Beasiswa">Beasiswa</option>
              </select>
            </div>

            <div style="display: flex; flex-direction: column;">
              <label for="kelas"><strong>Kelas <span style="color:red;">*</span></strong></label>
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
              <label for="periode"><strong>Periode <span style="color:red;">*</span></strong></label>
              <select name="periode_id" id="periode" required>
                <option value="" disabled selected>Pilih Periode</option>
                @foreach($periodes as $p)
                  <option value="{{ $p->id }}">{{ $p->tahun_ajaran }}</option>
                @endforeach
              </select>
            </div>

            <div style="display: flex; flex-direction: column;">
              <label for="jenis_kelas"><strong>Jenis Kelas <span style="color:red;">*</span></strong></label>
              <select name="jenis_kelas" id="jenis_kelas" required>
                <option value="" disabled selected>Jenis Kelas</option>
                <option value="1 Tahun">1 Tahun</option>
                <option value="2 Tahun">2 Tahun</option>
              </select>
            </div>

            <div style="display: flex; flex-direction: column;">
              <label for="cabang"><strong>Cabang <span style="color:red;">*</span></strong></label>
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
              <button type="button" style="padding: 0.5rem 1rem; background-color: #ccc; border: none;">Kembali</button>
            </a>
            <button type="submit" style="padding: 0.5rem 1rem; background-color: #a4e4b3; color: black; border: none;">Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</body>
</html>
