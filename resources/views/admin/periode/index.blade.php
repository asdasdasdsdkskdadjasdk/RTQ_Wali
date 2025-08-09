<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Periode</title>
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
        <a href="{{ route('admin.datasantri.index') }}">Data Santri</a>
        <a href="{{ route('admin.kelolapengguna.index') }}">Kelola Pengguna</a>
        <a href="{{ route('admin.periode.index') }}" class="active">Periode</a>
        <a href="{{ route('admin.kategoripenilaian.index') }}">Kategori Penilaian</a>
        <a href="{{ route('admin.kehadiranA.index') }}">Kehadiran</a>
        <a href="{{ route('admin.hafalanadmin.index') }}">Hafalan Santri</a>
        <a href="{{ route('admin.kinerjaguru.index') }}" >Kinerja Guru</a>
      </div>

      <!-- Bagian Bawah -->
      <div style="border-top: 1px solid #ddd; padding-top: 10px;">
        <a href="{{ route('password.editAdmin') }}">Ubah Password</a>
      </div>

    </div>

    <!-- Main Content -->
    <div class="main">
      <div class="topbar">
        <h1>Periode</h1>
        <img src="{{ asset('img/image/logortq.png') }}" alt="Logo RTQ" height="150" width="100" />
      </div>
      @if (session('success'))
      <div class="alert-success">
      {{ session('success') }}
      </div>
    @endif

      @if (session('error'))
      <div class="alert-error">
      {{ session('error') }}
      </div>
    @endif

      <div class="ka-form-container">
        <div class="kg-form-group">

          <!-- Form dan Tabel -->
          <div class="form-container">
            <!-- Form Tambah Periode -->
            <form action="{{ route('admin.periode.store') }}" method="POST" class="form-group">
              @csrf
              <div class="form-row">
                <div class="form-item">
                  <label for="tahun_awal">Tahun Mulai</label>
                  <select name="tahun_awal" id="tahun_awal" required>
                    <option value="">Pilih Tahun Mulai</option>
                    @for ($year = 2010; $year <= 2030; $year++)
            <option value="{{ $year }}">{{ $year }}</option>
          @endfor
                  </select>
                </div>

                <div style="padding-top: 28px;">-</div>

                <div class="form-item">
                  <label for="tahun_akhir">Tahun Akhir</label>
                  <select name="tahun_akhir" id="tahun_akhir" required>
                    <option value="">Pilih Tahun Akhir</option>
                    @for ($year = 2010; $year <= 2030; $year++)
            <option value="{{ $year }}">{{ $year }}</option>
          @endfor
                  </select>
                </div>

                <div style="margin-top: 20px; display: flex; gap: 10px;">
                  <button type="submit"
                    style="padding: 0.5rem 1rem; background-color: #a4e4b3; color: black; border: none; border-radius: 2px; font-weight:">
                    Tambah
                  </button>
                </div>
              </div>
            </form>


            <!-- Tabel Daftar Periode -->
            <table>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tahun Ajaran</th>
                </tr>
              </thead>
              <tbody>
                @forelse($periode as $index => $item)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->tahun_ajaran }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="2">Belum ada data.</td>
          </tr>
        @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    setTimeout(() => {
      const success = document.querySelector('.alert-success');
      const error = document.querySelector('.alert-error');

      if (success) {
        success.style.transition = 'opacity 0.5s ease-out';
        success.style.opacity = '0';
        setTimeout(() => success.remove(), 500);
      }

      if (error) {
        error.style.transition = 'opacity 0.5s ease-out';
        error.style.opacity = '0';
        setTimeout(() => error.remove(), 500);
      }
    }, 2000); 
  </script>

</body>

</html>