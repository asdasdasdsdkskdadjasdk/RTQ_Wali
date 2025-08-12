<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Jadwal Mengajar</title>
  <link rel="shortcut icon" href="{{ asset('img/image/logortq.png') }}" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <style>
    .sidebar a {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 8px 12px;
      text-decoration: none;
      color: inherit;
    }

    .sidebar a i {
      width: 18px;
      text-align: center;
    }
  </style>
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
          <i class="fas fa-home"></i> Dashboard
        </a>
        <a href="{{ route('admin.jadwalmengajar.index') }}" class="active">
          <i class="fas fa-calendar-alt"></i> Jadwal Mengajar
        </a>
        <a href="{{ route('admin.dataguru.index') }}">
          <i class="fas fa-chalkboard-teacher"></i> Data Guru
        </a>
        <a href="{{ route('admin.datasantri.index') }}">
          <i class="fas fa-users"></i> Data Santri
        </a>
        <a href="{{ route('admin.kelolapengguna.index') }}">
          <i class="fas fa-user-cog"></i> Kelola Pengguna
        </a>
        <a href="{{ route('admin.periode.index') }}">
          <i class="fas fa-clock"></i> Periode
        </a>
        <a href="{{ route('admin.kategoripenilaian.index') }}">
          <i class="fas fa-list-ul"></i> Kategori Penilaian
        </a>
        <a href="{{ route('admin.kehadiranA.index') }}">
          <i class="fas fa-check-circle"></i> Kehadiran
        </a>
        <a href="{{ route('admin.hafalanadmin.index') }}">
          <i class="fas fa-book"></i> Hafalan Santri
        </a>
        <a href="{{ route('admin.kinerjaguru.index') }}">
          <i class="fas fa-chart-line"></i> Kinerja Guru
        </a>
      </div>

      <!-- Bagian Bawah -->
      <div style="border-top: 1px solid #ddd; padding-top: 10px;">
        <a href="{{ route('password.editAdmin') }}">
          <i class="fas fa-key"></i> Ubah Password
        </a>
      </div>

    </div>

    <!-- Main Content -->
    <div class="main">
      <div class="topbar">
        <h1>Jadwal Mengajar</h1>
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

      <div class="chart-container">
        {{-- Filter Form --}}
        <form method="GET" action="{{ route('admin.jadwalmengajar.index') }}" id="filterForm" class="table-controls"
          style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 10px; align-items: center;">
          <div>
            Show
            <select name="per_page" id="per_page">
              @foreach([10, 25, 50, 100] as $limit)
              <option value="{{ $limit }}" {{ request('per_page', 10) == $limit ? 'selected' : '' }}>
                {{ $limit }}
              </option>
              @endforeach
            </select>
          </div>
          <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 0.5rem;">
            <input type="text" name="search" id="search" placeholder="Search..." value="{{ request('search') }}"
              style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; width: 200px;" />
            <a href="{{ route('admin.jadwalmengajar.create') }}">
              <button type="button" class="add-btn"
                style="padding: 0.5rem 1rem; background-color: #a4e4b3; color: black; border: none; border-radius: 4px; cursor: pointer;">
                Tambah
              </button>
            </a>
          </div>
        </form>

        <div style="overflow-x:auto;">
          <table>
            <thead>
              <tr>
                <th>No</th>
                <th>Guru</th>
                <th>Kelas</th>
                <th>Cabang</th>
                <th>Periode</th>
                <th>Kegiatan</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($jadwals as $j)
              <tr>
                <td>{{ ($jadwals->currentPage() - 1) * $jadwals->perPage() + $loop->iteration }}</td>
                <td>{{ $j->guru->nama_guru }}</td>
                <td>{{ $j->kelas }}</td>
                <td>{{ $j->cabang }}</td>
                <td>{{ $j->periode->tahun_ajaran }}</td>
                <td>{{ $j->kegiatan }}</td>
                <td>{{ \Carbon\Carbon::parse($j->jam_masuk)->format('H:i') }}</td>
                <td>{{ \Carbon\Carbon::parse($j->jam_keluar)->format('H:i') }}</td>
                <td class="action-buttons">
                  <a href="{{ route('admin.jadwalmengajar.edit', $j->id) }}">
                    <button><img src="{{ asset('img/image/edit.png') }}" height="20" /></button>
                  </a>
                  <form action="{{ route('admin.jadwalmengajar.destroy', $j->id) }}" method="POST"
                    style="display:inline-block;">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Yakin hapus?')" class="delete">
                      <img src="{{ asset('img/image/delete.png') }}" height="20" />
                    </button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="9" style="text-align:center;">Tidak ada data</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        @if ($jadwals->total() > 0)
        <div class="pagination">
          Showing {{ $jadwals->firstItem() }} to {{ $jadwals->lastItem() }} of {{ $jadwals->total() }} entries
        </div>
        @endif

        @if ($jadwals->hasPages())
        <div class="box-pagination-left">
          {{-- Tombol Previous --}}
          @if ($jadwals->onFirstPage())
          <span class="page-box-small disabled">«</span>
          @else
          <a href="{{ $jadwals->previousPageUrl() }}" class="page-box-small">«</a>
          @endif

          {{-- Nomor Halaman --}}
          @foreach ($jadwals->getUrlRange(1, $jadwals->lastPage()) as $page => $url)
          @if ($page == $jadwals->currentPage())
          <span class="page-box-small active">{{ $page }}</span>
          @else
          <a href="{{ $url }}" class="page-box-small">{{ $page }}</a>
          @endif
          @endforeach

          {{-- Tombol Next --}}
          @if ($jadwals->hasMorePages())
          <a href="{{ $jadwals->nextPageUrl() }}" class="page-box-small">»</a>
          @else
          <span class="page-box-small disabled">»</span>
          @endif
        </div>
        @endif
      </div>
    </div>
  </div>

  <!-- Tambahkan sebelum </body> -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  {{-- SweetAlert untuk pesan sukses --}}
  @if (session('success'))
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Berhasil',
      text: @json(session('success')),
      timer: 2000,
      showConfirmButton: false
    });
  </script>
  @endif

  {{-- SweetAlert untuk pesan error --}}
  @if (session('error'))
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Gagal',
      text: @json(session('error')),
      timer: 2500,
      showConfirmButton: false
    });
  </script>
  @endif

  <script>
    // Konfirmasi Hapus
    document.querySelectorAll('form[method="POST"][action*="destroy"]').forEach(function (form) {
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        Swal.fire({
          title: 'Yakin hapus?',
          text: 'Data ini akan dihapus permanen.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Ya, Hapus',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    });

    // Konfirmasi Logout
    const logoutForm = document.querySelector('form[action*="logout"]');
    if (logoutForm) {
      logoutForm.addEventListener('submit', function (e) {
        e.preventDefault();
        Swal.fire({
          title: 'Keluar dari akun?',
          text: 'Anda akan logout dari sistem.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Ya, Logout',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            logoutForm.submit();
          }
        });
      });
    }
  </script>

</body>

</html>
