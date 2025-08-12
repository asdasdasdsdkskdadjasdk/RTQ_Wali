<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Data Santri</title>
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
    <div class="main">
      <div class="topbar">
        <h1>Data Santri</h1>
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

      <!-- Tabel Santri -->
      <div class="chart-container">
        <form method="GET" action="{{ route('admin.datasantri.index') }}" class="table-controls" id="filterForm"
          style="display: flex; flex-direction: column; gap: 10px;">

          {{-- Baris Atas: Search + Tambah (kiri) & Lihat History (kanan) --}}
          <div
            style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; width: 100%;">

            {{-- Search + Tambah --}}
            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
              <input type="text" name="search" id="search" placeholder="Search..." value="{{ request('search') }}"
                style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; width: 200px;" />

              <a href="{{ route('admin.datasantri.create') }}">
                <button type="button" class="add-btn"
                  style="padding: 0.5rem 1rem; background-color: #a4e4b3; color: black; border: none; border-radius: 4px; cursor: pointer;">
                  Tambah
                </button>
              </a>
            </div>

            {{-- Tombol Lihat Semua Data --}}
            <a href="{{ route('admin.datasantri.history') }}">
              <button type="button"
                style="padding: 0.5rem 1rem; background-color: #a4e4b3; color: black; border: none; border-radius: 4px; cursor: pointer;">
                Filter Data Santri
              </button>
            </a>
          </div>

          {{-- Show Data --}}
          <div>
            Show
            <select name="perPage" id="per_page" onchange="this.form.submit()">
              @foreach([10, 25, 50, 100] as $size)
          <option value="{{ $size }}" {{ request('perPage', 10) == $size ? 'selected' : '' }}>
          {{ $size }}
          </option>
        @endforeach
            </select>
          </div>
        </form>

        <div style="overflow-x:auto;">
          <table>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Santri</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Asal</th>
                <th>Kelas</th>
                <th>Periode</th>
                <th>Cabang</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($santris as $santri)
          <tr>
          <td>{{ $loop->iteration + ($santris->currentPage() - 1) * $santris->perPage() }}</td>
          <td>{{ $santri->nama_santri }}</td>
          <td>{{ $santri->tempat_lahir }}</td>
          <td>{{ \Carbon\Carbon::parse($santri->tanggal_lahir)->format('d/m/Y') }}</td>
          <td>{{ $santri->asal }}</td>
          <td>{{ $santri->kelas }}</td>
          <td>{{ $santri->periode->tahun_ajaran ?? '-' }}</td>
          <td>{{ $santri->cabang }}</td>
          <td class="action-buttons">
            <a href="{{ route('admin.datasantri.edit', $santri->id) }}">
            <button><img src="{{ asset('img/image/edit.png') }}" alt="edit" height="20" /></button>
            </a>
            <a href="{{ route('admin.datasantri.show', $santri->id) }}">
            <button class="detail"><img src="{{ asset('img/image/detail.png') }}" alt="detail"
              height="20" /></button>
            </a>
            <form action="{{ route('admin.datasantri.destroy', $santri->id) }}" method="POST"
            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" style="display:inline;">
            @csrf
            @method('DELETE')
            <button class="delete"><img src="{{ asset('img/image/delete.png') }}" alt="delete"
              height="20" /></button>
            </form>
          </td>
          </tr>
        @empty
          <tr>
          <td colspan="9" style="text-align: center;">Data santri belum tersedia.</td>
          </tr>
        @endforelse
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        @if ($santris->total() > 0)
      <div class="pagination">
        Showing {{ $santris->firstItem() }} to {{ $santris->lastItem() }} of {{ $santris->total() }} entries
      </div>
    @endif

        @if ($santris->hasPages())
        <div class="box-pagination-left">
          {{-- Tombol Previous --}}
          @if ($santris->onFirstPage())
        <span class="page-box-small disabled">«</span>
        @else
        <a href="{{ $santris->previousPageUrl() }}" class="page-box-small">«</a>
        @endif

          {{-- Nomor Halaman --}}
          @foreach ($santris->getUrlRange(1, $santris->lastPage()) as $page => $url)
          @if ($page == $santris->currentPage())
        <span class="page-box-small active">{{ $page }}</span>
        @else
        <a href="{{ $url }}" class="page-box-small">{{ $page }}</a>
        @endif
        @endforeach

          {{-- Tombol Next --}}
          @if ($santris->hasMorePages())
        <a href="{{ $santris->nextPageUrl() }}" class="page-box-small">»</a>
        @else
        <span class="page-box-small disabled">»</span>
        @endif
        </div>
    @endif
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

    document.addEventListener('DOMContentLoaded', function () {
      const filterForm = document.getElementById('filterForm');
      const perPage = document.getElementById('per_page');
      const search = document.getElementById('search');

      if (perPage && filterForm) {
        perPage.addEventListener('change', function () {
          filterForm.submit();
        });
      }

      // Submit saat user mengetik search (delay 500ms)
      if (search && filterForm) {
        let debounceTimer;
        search.addEventListener('input', function () {
          clearTimeout(debounceTimer);
          debounceTimer = setTimeout(() => {
            filterForm.submit();
          }, 500);
        });
      }
    });
  </script>
</body>

</html>