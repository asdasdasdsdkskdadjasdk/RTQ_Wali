<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Detail Data Guru</title>
  <link rel="shortcut icon" href="{{ asset('img/image/logortq.png') }}" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="body">

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

        <a href="{{ route('dashboard') }}"><i class="fas fa-home" style="margin-right: 8px;"></i>Dashboard</a>
        <a href="{{ route('admin.jadwalmengajar.index') }}"><i class="fas fa-calendar-alt" style="margin-right: 8px;"></i>Jadwal Mengajar</a>
        <a href="{{ route('admin.dataguru.index') }}" class="active"><i class="fas fa-chalkboard-teacher" style="margin-right: 8px;"></i>Data Guru</a>
        <a href="{{ route('admin.datasantri.index') }}"><i class="fas fa-users" style="margin-right: 8px;"></i>Data Santri</a>
        <a href="{{ route('admin.kelolapengguna.index') }}"><i class="fas fa-users-cog" style="margin-right: 8px;"></i>Kelola Pengguna</a>
        <a href="{{ route('admin.periode.index') }}"><i class="fas fa-clock" style="margin-right: 8px;"></i>Periode</a>
        <a href="{{ route('admin.kategoripenilaian.index') }}"><i class="fas fa-list-ul" style="margin-right: 8px;"></i>Kategori Penilaian</a>
        <a href="{{ route('admin.kehadiranA.index') }}"><i class="fas fa-check-circle" style="margin-right: 8px;"></i>Kehadiran</a>
        <a href="{{ route('admin.hafalanadmin.index') }}"><i class="fas fa-book" style="margin-right: 8px;"></i>Hafalan Santri</a>
        <a href="{{ route('admin.kinerjaguru.index') }}"><i class="fas fa-chart-line" style="margin-right: 8px;"></i>Kinerja Guru</a>
      </div>

      <!-- Bagian Bawah -->
      <div style="border-top: 1px solid #ddd; padding-top: 10px;">
        <a href="{{ route('password.editAdmin') }}"><i class="fas fa-key" style="margin-right: 8px;"></i>Ubah Password</a>
      </div>

    </div>

    <!-- Main Content -->
    <div class="dt-card">
      <h2 class="dt-title">Detail Data Guru</h2>
      <div class="dt-content">
        <div class="dt-row">
          <div class="dt-label">Nama Guru</div>
          <div class="dt-value">{{ $guru->nama_guru }}</div>
          <div class="dt-label">Tempat Lahir</div>
          <div class="dt-value">{{ $guru->tempat_lahir }}</div>
        </div>
        <div class="dt-row">
          <div class="dt-label">Tanggal Lahir</div>
          <div class="dt-value">{{ \Carbon\Carbon::parse($guru->tanggal_lahir)->format('d/m/Y') }}</div>
          <div class="dt-label">Alamat</div>
          <div class="dt-value">{{ $guru->alamat }}</div>
        </div>
        <div class="dt-row">
          <div class="dt-label">No HP</div>
          <div class="dt-value">{{ $guru->no_hp }}</div>
          <div class="dt-label">Email</div>
          <div class="dt-value">{{ $guru->email }}</div>
        </div>
        <div class="dt-row">
          <div class="dt-label">Jumlah Hafalan</div>
          <div class="dt-value">{{ $guru->jlh_hafalan }}</div>
          <div class="dt-label">Jenis Kelamin</div>
          <div class="dt-value">{{ $guru->jenis_kelamin }}</div>
        </div>
        <div class="dt-row">
          <div class="dt-label">Pendidikan Terakhir</div>
          <div class="dt-value">{{ $guru->pend_akhir }}</div>
          <div class="dt-label">Golongan Darah</div>
          <div class="dt-value">{{ $guru->gol_dar }}</div>
        </div>
        <div class="dt-row">
          <div class="dt-label">MK</div>
          <div class="dt-value">{{ $guru->mk }}</div>
          <div class="dt-label">Status Menikah</div>
          <div class="dt-value">{{ $guru->status_menikah }}</div>
        </div>
        <div class="dt-row">
          <div class="dt-label">Bagian</div>
          <div class="dt-value">{{ $guru->bagian }}</div>
          <div class="dt-label">Cabang</div>
          <div class="dt-value">{{ $guru->cabang }}</div>
        </div>

        <div style="margin-top: 20px; display: flex; gap: 10px;">
          <a href="{{ route('admin.dataguru.index') }}">
            <button type="button"
              style="padding: 0.5rem 1rem; background-color: #a4e4b3; border: none;">Kembali</button>
          </a>
        </div>
      </div>
    </div>
  </div>

</body>

</html>
