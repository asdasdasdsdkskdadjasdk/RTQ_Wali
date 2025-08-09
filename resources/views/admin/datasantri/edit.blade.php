<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Edit Data Santri</title>
  <link rel="shortcut icon" href="{{ asset('img/image/logortq.png') }}" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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

      <!-- Bagian Bawah -->
      <div style="border-top: 1px solid #ddd; padding-top: 10px;">
        <a href="{{ route('password.editAdmin') }}">Ubah Password</a>
      </div>
    </div>

    <!-- Main Content -->
    <div class="main">
      <div class="topbar">
        <h1>Edit Data Santri</h1>
        <img src="{{ asset('img/image/logortq.png') }}" alt="Logo RTQ" height="150" width="100" />
      </div>

      <div class="form-container">
        <form action="{{ route('admin.datasantri.update', $santri->id) }}" method="POST">
          @csrf
          @method('PUT')

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
                <input type="{{ $f[2] ?? 'text' }}" name="{{ $f[0] }}" id="{{ $f[0] }}"
                  placeholder="Masukan {{ $f[1] }}"
                  value="{{ old($f[0], $santri->{$f[0]}) }}" required>
              </div>
            @endforeach

            <!-- Dropdown MK -->
            <div style="display: flex; flex-direction: column;">
              <label for="MK"><strong>MK <span style="color:red;">*</span></strong></label>
              <select name="MK" id="MK" required>
                <option value="" disabled {{ old('MK', $santri->MK) ? '' : 'selected' }}>Masukan MK</option>
                @foreach(['Si','Se','Ti','Te','In','Fi','Fe','Ii','Ie'] as $mk)
                  <option value="{{ $mk }}" {{ old('MK', $santri->MK) == $mk ? 'selected' : '' }}>{{ $mk }}</option>
                @endforeach
              </select>
            </div>

            <!-- Dropdown Golongan Darah -->
            <div style="display: flex; flex-direction: column;">
              <label for="GolDar"><strong>Golongan Darah <span style="color:red;">*</span></strong></label>
              <select name="GolDar" id="GolDar" required>
                <option value="" disabled {{ old('GolDar', $santri->GolDar) ? '' : 'selected' }}>Masukan Golongan Darah</option>
                @foreach(['A','AB','B','O'] as $gd)
                  <option value="{{ $gd }}" {{ old('GolDar', $santri->GolDar) == $gd ? 'selected' : '' }}>{{ $gd }}</option>
                @endforeach
              </select>
            </div>

            <!-- Dropdown Jenis Kelamin -->
            <div style="display: flex; flex-direction: column;">
              <label for="jenis_kelamin"><strong>Jenis Kelamin <span style="color:red;">*</span></strong></label>
              <select name="jenis_kelamin" id="jenis_kelamin" required>
                <option value="" disabled {{ old('jenis_kelamin', $santri->jenis_kelamin) ? '' : 'selected' }}>Masukan Jenis Kelamin</option>
                <option value="P" {{ old('jenis_kelamin', $santri->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                <option value="L" {{ old('jenis_kelamin', $santri->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-Laki</option>
              </select>
            </div>

            <!-- Dropdown Kategori Masuk -->
            <div style="display: flex; flex-direction: column;">
              <label for="kat_masuk"><strong>Kategori Masuk <span style="color:red;">*</span></strong></label>
              <select name="kat_masuk" id="kat_masuk" required>
                <option value="" disabled {{ old('kat_masuk', $santri->kat_masuk) ? '' : 'selected' }}>Masukan Kategori Masuk</option>
                <option value="Umum" {{ old('kat_masuk', $santri->kat_masuk) == 'Umum' ? 'selected' : '' }}>Umum</option>
                <option value="Beasiswa" {{ old('kat_masuk', $santri->kat_masuk) == 'Beasiswa' ? 'selected' : '' }}>Beasiswa</option>
              </select>
            </div>

            <!-- Dropdown Kelas -->
            <div style="display: flex; flex-direction: column;">
              <label for="kelas"><strong>Kelas <span style="color:red;">*</span></strong></label>
              <select name="kelas" id="kelas" required>
                <option value="" disabled {{ old('kelas', $santri->kelas) ? '' : 'selected' }}>Masukan Kelas</option>
                @foreach(['Halaqah A','Halaqah B','Halaqah C','Halaqah D','Halaqah E'] as $kls)
                  <option value="{{ $kls }}" {{ old('kelas', $santri->kelas) == $kls ? 'selected' : '' }}>{{ $kls }}</option>
                @endforeach
              </select>
            </div>

            <!-- Dropdown Periode -->
            <div style="display: flex; flex-direction: column;">
              <label for="periode"><strong>Periode <span style="color:red;">*</span></strong></label>
              <select name="periode_id" id="periode" required>
                <option value="" disabled {{ old('periode_id', $santri->periode_id) ? '' : 'selected' }}>Pilih Periode</option>
                @foreach($periodes as $p)
                  <option value="{{ $p->id }}" {{ old('periode_id', $santri->periode_id) == $p->id ? 'selected' : '' }}>
                    {{ $p->tahun_ajaran }}
                  </option>
                @endforeach
              </select>
            </div>

            <!-- Dropdown Jenis Kelas -->
            <div style="display: flex; flex-direction: column;">
              <label for="jenis_kelas"><strong>Jenis Kelas <span style="color:red;">*</span></strong></label>
              <select name="jenis_kelas" id="jenis_kelas" required>
                <option value="" disabled {{ old('jenis_kelas', $santri->jenis_kelas) ? '' : 'selected' }}>Jenis Kelas</option>
                <option value="1 Tahun" {{ old('jenis_kelas', $santri->jenis_kelas) == '1 Tahun' ? 'selected' : '' }}>1 Tahun</option>
                <option value="2 Tahun" {{ old('jenis_kelas', $santri->jenis_kelas) == '2 Tahun' ? 'selected' : '' }}>2 Tahun</option>
              </select>
            </div>

            <!-- Dropdown Cabang -->
            <div style="display: flex; flex-direction: column;">
              <label for="cabang"><strong>Cabang <span style="color:red;">*</span></strong></label>
              <select name="cabang" id="cabang" required>
                <option value="" disabled {{ old('cabang', $santri->cabang) ? '' : 'selected' }}>Masukan Cabang</option>
                @foreach(['Sukajadi','Rumbai','Gobah 1','Gobah 2','Rawa Bening'] as $cb)
                  <option value="{{ $cb }}" {{ old('cabang', $santri->cabang) == $cb ? 'selected' : '' }}>{{ $cb }}</option>
                @endforeach
              </select>
            </div>

          </div>

          <!-- Tombol -->
          <div style="margin-top: 20px; display: flex; gap: 10px;">
            <a href="{{ route('admin.datasantri.index') }}">
              <button type="button" style="padding: 0.5rem 1rem; background-color: #ccc; border: none;">Kembali</button>
            </a>
            <button type="submit" style="padding: 0.5rem 1rem; background-color: #a4e4b3; color: black; border: none;">Ubah</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>
