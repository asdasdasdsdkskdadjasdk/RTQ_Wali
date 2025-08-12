<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Detail Data Santri</title>
  <link rel="shortcut icon" href="{{ asset('img/image/logortq.png') }}" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body class="body">

  <div class="container">
    <!-- Bagian Sidebar -->
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

        <a href="{{ route('dashboard') }}"><i class="fas fa-home" style="margin-right:8px;"></i>Dashboard</a>
        <a href="{{ route('admin.jadwalmengajar.index') }}"><i class="fas fa-calendar-alt"
            style="margin-right:8px;"></i>Jadwal Mengajar</a>
        <a href="{{ route('admin.dataguru.index') }}"><i class="fas fa-chalkboard-teacher"
            style="margin-right:8px;"></i>Data Guru</a>
        <a href="{{ route('admin.datasantri.index') }}" class="active"><i class="fas fa-users"
            style="margin-right:8px;"></i>Data Santri</a>
        <a href="{{ route('admin.kelolapengguna.index') }}"><i class="fas fa-user-cog"
            style="margin-right:8px;"></i>Kelola Pengguna</a>
        <a href="{{ route('admin.periode.index') }}"><i class="fas fa-clock" style="margin-right:8px;"></i>Periode</a>
        <a href="{{ route('admin.kategoripenilaian.index') }}"><i class="fas fa-list-ul"
            style="margin-right:8px;"></i>Kategori Penilaian</a>
        <a href="{{ route('admin.kehadiranA.index') }}"><i class="fas fa-check-circle"
            style="margin-right:8px;"></i>Kehadiran</a>
        <a href="{{ route('admin.hafalanadmin.index') }}"><i class="fas fa-book" style="margin-right:8px;"></i>Hafalan
          Santri</a>
        <a href="{{ route('admin.kinerjaguru.index') }}"><i class="fas fa-chart-line"
            style="margin-right:8px;"></i>Kinerja Guru</a>
      </div>

      <!-- Bagian Bawah -->
      <div style="border-top: 1px solid #ddd; padding-top: 10px;">
        <a href="{{ route('password.editAdmin') }}"><i class="fas fa-key" style="margin-right:8px;"></i>Ubah
          Password</a>
      </div>
    </div>

    <!-- Main Content -->
    <div class="dt-card">
      <h2 class="dt-title">Detail Data Santri</h2>
      <div class="dt-content">
        <div class="dt-row">
          <div class="dt-label">Nama Santri</div>
          <div class="dt-value">{{ $santri->nama_santri }}</div>
          <div class="dt-label">Tempat Lahir</div>
          <div class="dt-value">{{ $santri->tempat_lahir }}</div>
        </div>
        <div class="dt-row">
          <div class="dt-label">Tanggal Lahir</div>
          <div class="dt-value">{{ $santri->tanggal_lahir }}</div>
          <div class="dt-label">Asal</div>
          <div class="dt-value">{{ $santri->asal }}</div>
        </div>
        <div class="dt-row">
          <div class="dt-label">NIS</div>
          <div class="dt-value">{{ $santri->nis }}</div>
          <div class="dt-label">Email</div>
          <div class="dt-value">{{ $santri->email }}</div>
        </div>
        <div class="dt-row">
          <div class="dt-label">Asal Sekolah</div>
          <div class="dt-value">{{ $santri->asal_sekolah }}</div>
          <div class="dt-label">Nama Orang Tua</div>
          <div class="dt-value">{{ $santri->nama_ortu }}</div>
        </div>
        <div class="dt-row">
          <div class="dt-label">No HP Orangtua</div>
          <div class="dt-value">{{ $santri->NoHP_ortu }}</div>
          <div class="dt-label">Pekerjaan Orang Tua</div>
          <div class="dt-value">{{ $santri->pekerjaan_ortu }}</div>
        </div>
        <div class="dt-row">
          <div class="dt-label">MK</div>
          <div class="dt-value">{{ $santri->MK }}</div>
          <div class="dt-label">Golongan Darah</div>
          <div class="dt-value">{{ $santri->GolDar }}</div>
        </div>
        <div class="dt-row">
          <div class="dt-label">Jenis Kelamin</div>
          <div class="dt-value">{{ $santri->jenis_kelamin }}</div>
          <div class="dt-label">Kategori Masuk</div>
          <div class="dt-value">{{ $santri->kat_masuk }}</div>
        </div>

        <div class="dt-row">
          <div class="dt-label">Kelas</div>
          <div class="dt-value">{{ $santri->kelas }}</div>
          <div class="dt-label">Jenis Kelas</div>
          <div class="dt-value">{{ $santri->jenis_kelas }}</div>
        </div>

        <div class="dt-row">
          <div class="dt-label">Cabang</div>
          <div class="dt-value">{{ $santri->cabang }}</div>
        </div>

        <div style="margin-top: 20px; display: flex; gap: 10px;">
          <a href="{{ route('admin.datasantri.index') }}">
            <button type="button"
              style="padding: 0.5rem 1rem; background-color: #a4e4b3; border: none;">Kembali</button>
          </a>
        </div>
      </div>
    </div>
  </div>

</body>

</html>