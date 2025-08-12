<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Periode</title>
  <link rel="shortcut icon" href="{{ asset('img/image/logortq.png') }}" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

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
        <a href="{{ route('admin.datasantri.index') }}"><i class="fas fa-users" style="margin-right:8px;"></i>Data
          Santri</a>
        <a href="{{ route('admin.kelolapengguna.index') }}"><i class="fas fa-user-cog"
            style="margin-right:8px;"></i>Kelola Pengguna</a>
        <a href="{{ route('admin.periode.index') }}" class="active"><i class="fas fa-clock"
            style="margin-right:8px;"></i>Periode</a>
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

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  {{-- Notifikasi sukses --}}
  @if (session('success'))
    <script>
    document.addEventListener('DOMContentLoaded', () => {
      Swal.fire({
      icon: 'success',
      title: 'Berhasil',
      text: @json(session('success')),
      timer: 2000,
      showConfirmButton: false
      });
    });
    </script>
  @endif

  {{-- Notifikasi error --}}
  @if (session('error'))
    <script>
    document.addEventListener('DOMContentLoaded', () => {
      Swal.fire({
      icon: 'error',
      title: 'Gagal',
      text: @json(session('error')),
      timer: 2500,
      showConfirmButton: false
      });
    });
    </script>
  @endif

  <script>
    // Konfirmasi Logout
    (function () {
      const logoutForm = document.querySelector('form[action*="logout"]');
      if (!logoutForm) return;
      logoutForm.addEventListener('submit', function (e) {
        e.preventDefault();
        Swal.fire({
          title: 'Keluar dari akun?',
          text: 'Anda akan logout dari sistem.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Ya, Logout',
          cancelButtonText: 'Batal'
        }).then((res) => res.isConfirmed && logoutForm.submit());
      });
    })();

    // SweetAlert untuk Tambah Periode (validasi + konfirmasi)
    (function () {
      const form = document.querySelector('form[action*="admin/periode"][method="POST"]');
      if (!form) return;

      form.addEventListener('submit', function (e) {
        e.preventDefault();

        const start = document.getElementById('tahun_awal')?.value;
        const end = document.getElementById('tahun_akhir')?.value;

        // Validasi sederhana
        if (!start || !end) {
          Swal.fire({ icon: 'warning', title: 'Lengkapi data', text: 'Pilih tahun mulai dan tahun akhir.' });
          return;
        }
        if (Number(end) <= Number(start)) {
          Swal.fire({ icon: 'error', title: 'Rentang tahun tidak valid', text: 'Tahun akhir harus lebih besar dari tahun mulai.' });
          return;
        }

        // Konfirmasi submit
        Swal.fire({
          title: 'Tambah Periode?',
          text: `Tahun ajaran ${start}/${end}`,
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Simpan',
          cancelButtonText: 'Batal'
        }).then((res) => res.isConfirmed && form.submit());
      });
    })();
  </script>

</body>

</html>