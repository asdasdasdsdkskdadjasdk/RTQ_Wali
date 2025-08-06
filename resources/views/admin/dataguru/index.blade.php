<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Data Guru</title>
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
      <a href="{{ route('admin.dataguru.index') }}" class="active">Data Guru</a>
      <a href="{{ route('admin.datasantri.index') }}">Data Santri</a>
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
        <h1>Data Guru</h1>
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

      <!-- Tabel Guru -->
      <div class="chart-container">
        <form method="GET" action="{{ route('admin.dataguru.index') }}" class="table-controls"
          style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 10px; align-items: center;">
          <div>
            Show
            <select name="perPage" onchange="this.form.submit()">
              @foreach([10, 25, 50, 100] as $size)
          <option value="{{ $size }}" {{ request('perPage', 10) == $size ? 'selected' : '' }}>
          {{ $size }}
          </option>
        @endforeach
            </select>
          </div>
          <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 0.5rem;">
            <input type="text" name="search" id="search" placeholder="Search..." value="{{ request('search') }}"
              style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; width: 200px;" />
            <a href="{{ route('admin.dataguru.create') }}">
              <button type="button" class="add-btn"
                style="padding: 0.5rem 1rem; background-color: #a4e4b3; color: black; border: none; border-radius: 4px; cursor: pointer;">
                Tambah
              </button>
            </a>
          </div>
        </form>

        <!-- Tabel -->
        <div style="overflow-x:auto;">
          <table>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Guru</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Alamat</th>
                <th>Jumlah Hafalan</th>
                <th>Bagian</th>
                <th>Cabang</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($gurus as $index => $guru)
          <tr>
          <td>{{ $loop->iteration + ($gurus->currentPage() - 1) * $gurus->perPage() }}</td>
          <td>{{ $guru->nama_guru }}</td>
          <td>{{ $guru->tempat_lahir }}</td>
          <td>{{ \Carbon\Carbon::parse($guru->tanggal_lahir)->format('d/m/Y') }}</td>
          <td>{{ $guru->alamat }}</td>
          <td>{{ $guru->jlh_hafalan ?? '-' }}</td>
          <td>{{ $guru->bagian }}</td>
          <td>{{ $guru->cabang }}</td>
          <td class="action-buttons">
            <a href="{{ route('admin.dataguru.edit', $guru->id) }}">
            <button><img src="{{ asset('img/image/edit.png') }}" alt="edit" height="100" /></button>
            </a>
            <a href="{{ route('admin.dataguru.show', $guru->id) }}">
            <button class="detail"><img src="{{ asset('img/image/detail.png') }}" alt="detail"
              height="100" /></button>
            </a>
            <form action="{{ route('admin.dataguru.destroy', $guru->id) }}" method="POST"
            onsubmit="return confirm('Yakin ingin menghapus?')" style="display:inline;">
            @csrf
            @method('DELETE')
            <button class="delete"><img src="{{ asset('img/image/delete.png') }}" alt="delete"
              height="100" /></button>
            </form>
          </td>
          </tr>
        @empty
          <tr>
          <td colspan="9" style="text-align: center;">Data guru belum tersedia.</td>
          </tr>
        @endforelse
            </tbody>
          </table>
        </div>

        @if ($gurus->total() > 0)
      <div class="pagination">
        Showing {{ $gurus->firstItem() }} to {{ $gurus->lastItem() }} of {{ $gurus->total() }} entries
      </div>
    @endif

        @if ($gurus->hasPages())
        <div class="box-pagination-left">
          {{-- Tombol Previous --}}
          @if ($gurus->onFirstPage())
        <span class="page-box-small disabled">«</span>
        @else
        <a href="{{ $gurus->previousPageUrl() }}" class="page-box-small">«</a>
        @endif

          {{-- Nomor Halaman --}}
          @foreach ($gurus->getUrlRange(1, $gurus->lastPage()) as $page => $url)
          @if ($page == $gurus->currentPage())
        <span class="page-box-small active">{{ $page }}</span>
        @else
        <a href="{{ $url }}" class="page-box-small">{{ $page }}</a>
        @endif
        @endforeach

          {{-- Tombol Next --}}
          @if ($gurus->hasMorePages())
        <a href="{{ $gurus->nextPageUrl() }}" class="page-box-small">»</a>
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

      // Submit saat dropdown show per_page berubah
      document.getElementById('per_page').addEventListener('change', function () {
        filterForm.submit();
      });

      // Submit saat user mengetik search (delay 500ms)
      let debounceTimer;
      document.getElementById('search').addEventListener('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
          filterForm.submit();
        }, 500);
      });
    });
  </script>
</body>

</html>