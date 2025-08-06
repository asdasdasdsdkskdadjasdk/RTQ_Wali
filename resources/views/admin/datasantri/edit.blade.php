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
        <h1>Edit Data Santri</h1>
        <img src="{{ asset('img/image/logortq.png') }}" alt="Logo RTQ" height="150" width="100" />
      </div>

      <div class="form-container">
        <div class="form-content">
          <form action="{{ route('admin.datasantri.update', $santri->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Container Grid 2 Kolom -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem 1.25rem;">

              <div style="display: flex; flex-direction: column;">
                <input type="text" name="nama_santri" placeholder="Masukan Nama Santri"
                  value="{{ old('nama_santri', $santri->nama_santri) }}" required>
              </div>

              <div style="display: flex; flex-direction: column;">
                <input type="text" name="tempat_lahir" placeholder="Masukan Tempat Lahir"
                  value="{{ old('tempat_lahir', $santri->tempat_lahir) }}" required>
              </div>

              <div style="display: flex; flex-direction: column;">
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $santri->tanggal_lahir) }}"
                  required>
              </div>

              <div style="display: flex; flex-direction: column;">
                <input type="text" name="asal" placeholder="Masukan Asal" value="{{ old('asal', $santri->asal) }}"
                  required>
              </div>

              <div style="display: flex; flex-direction: column;">
                <input type="text" name="nis" placeholder="Masukan NIS" value="{{ old('nis', $santri->nis) }}" required>
              </div>

              <div style="display: flex; flex-direction: column;">
                <input type="text" name="email" placeholder="Masukan Email" value="{{ old('email', $santri->email) }}"
                  required>
              </div>

              <div style="display: flex; flex-direction: column;">
                <input type="text" name="asal_sekolah" placeholder="Masukan Asal Sekolah"
                  value="{{ old('asal_sekolah', $santri->asal_sekolah) }}" required>
              </div>

              <div style="display: flex; flex-direction: column;">
                <input type="text" name="nama_ortu" placeholder="Masukan Nama Orang Tua"
                  value="{{ old('nama_ortu', $santri->nama_ortu) }}" required>
              </div>

              <div style="display: flex; flex-direction: column;">
                <input type="text" name="NoHP_ortu" placeholder="Masukan No HP Orang Tua"
                  value="{{ old('NoHP_ortu', $santri->NoHP_ortu) }}" required>
              </div>

              <div style="display: flex; flex-direction: column;">
                <input type="text" name="pekerjaan_ortu" placeholder="Masukan Pekerjaan Orang Tua"
                  value="{{ old('pekerjaan_ortu', $santri->pekerjaan_ortu) }}" required>
              </div>

              <div style="display: flex; flex-direction: column;">
                <select name="MK" required>
                  <option value="" disabled {{ old('MK', $santri->MK) ? '' : 'selected' }}>Masukan MK</option>
                  @foreach(['Si', 'Se', 'Ti', 'Te', 'In', 'Fi', 'Fe', 'Ii', 'Ie'] as $mk)
            <option value="{{ $mk }}" {{ old('MK', $santri->MK) == $mk ? 'selected' : '' }}>{{ $mk }}</option>
          @endforeach
                </select>
              </div>

              <div style="display: flex; flex-direction: column;">
                <select name="GolDar" required>
                  <option value="" disabled {{ old('GolDar', $santri->GolDar) ? '' : 'selected' }}>Masukan Golongan
                    Darah</option>
                  @foreach(['A', 'AB', 'B', 'O'] as $gd)
            <option value="{{ $gd }}" {{ old('GolDar', $santri->GolDar) == $gd ? 'selected' : '' }}>{{ $gd }}
            </option>
          @endforeach
                </select>
              </div>

              <div style="display: flex; flex-direction: column;">
                <select name="jenis_kelamin" required>
                  <option value="" disabled {{ old('jenis_kelamin', $santri->jenis_kelamin) ? '' : 'selected' }}>Masukan
                    Jenis Kelamin</option>
                  <option value="P" {{ old('jenis_kelamin', $santri->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan
                  </option>
                  <option value="L" {{ old('jenis_kelamin', $santri->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-Laki
                  </option>
                </select>
              </div>

              <div style="display: flex; flex-direction: column;">
                <select name="kat_masuk" required>
                  <option value="" disabled {{ old('kat_masuk', $santri->kat_masuk) ? '' : 'selected' }}>Masukan
                    Kategori Masuk</option>
                  <option value="Umum" {{ old('kat_masuk', $santri->kat_masuk) == 'Umum' ? 'selected' : '' }}>Umum
                  </option>
                  <option value="Beasiswa" {{ old('kat_masuk', $santri->kat_masuk) == 'Beasiswa' ? 'selected' : '' }}>
                    Beasiswa</option>
                </select>
              </div>

              <div style="display: flex; flex-direction: column;">
                <select name="kelas" required>
                  <option value="" disabled {{ old('kelas', $santri->kelas) ? '' : 'selected' }}>Masukan Kelas</option>
                  @foreach(['Halaqah A', 'Halaqah B', 'Halaqah C', 'Halaqah D', 'Halaqah E'] as $kls)
            <option value="{{ $kls }}" {{ old('kelas', $santri->kelas) == $kls ? 'selected' : '' }}>{{ $kls }}
            </option>
          @endforeach
                </select>
              </div>

              <div style="display: flex; flex-direction: column;">
                <select name="periode_id" required>
                  <option value="" disabled {{ old('periode_id', $santri->periode_id) ? '' : 'selected' }}>Pilih Periode
                  </option>
                  @foreach($periodes as $periode)
            <option value="{{ $periode->id }}" {{ old('periode_id', $santri->periode_id) == $periode->id ? 'selected' : '' }}>
            {{ $periode->tahun_ajaran }}
            </option>
          @endforeach
                </select>
              </div>

              <div style="display: flex; flex-direction: column;">
                <select name="jenis_kelas" required>
                  <option value="" disabled {{ old('jenis_kelas', $santri->jenis_kelas) ? '' : 'selected' }}>Jenis Kelas
                  </option>
                  <option value="1 Tahun" {{ old('jenis_kelas', $santri->jenis_kelas) == '1 Tahun' ? 'selected' : '' }}>1
                    Tahun</option>
                  <option value="2 Tahun" {{ old('jenis_kelas', $santri->jenis_kelas) == '2 Tahun' ? 'selected' : '' }}>2
                    Tahun</option>
                </select>
              </div>

              <div style="display: flex; flex-direction: column;">
                <select name="cabang" required>
                  <option value="" disabled {{ old('cabang', $santri->cabang) ? '' : 'selected' }}>Masukan Cabang
                  </option>
                  @foreach(['Sukajadi', 'Rumbai', 'Gobah 1', 'Gobah 2', 'Rawa Bening'] as $cabang)
            <option value="{{ $cabang }}" {{ old('cabang', $santri->cabang) == $cabang ? 'selected' : '' }}>
            {{ $cabang }}
            </option>
          @endforeach
                </select>
              </div>

            </div>

            <!-- Tombol Aksi -->
            <div style="margin-top: 20px; display: flex; gap: 10px;">
              <a href="{{ route('admin.datasantri.index') }}">
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

</html>