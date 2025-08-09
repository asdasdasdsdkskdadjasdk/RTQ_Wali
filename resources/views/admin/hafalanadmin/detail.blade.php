<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RTQ Al-Yusra | Hafalan Santri</title>
  <link rel="shortcut icon" href="{{ asset('img/image/logortq.png') }}" alt="Logo RTQ" height="100" type="image/x-icon">
  <!-- style css -->
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
        <a href="{{ route('admin.datasantri.index') }}" >Data Santri</a>
        <a href="{{ route('admin.kelolapengguna.index') }}">Kelola Pengguna</a>
        <a href="{{ route('admin.periode.index') }}">Periode</a>
        <a href="{{ route('admin.kategoripenilaian.index') }}">Kategori Penilaian</a>
        <a href="{{ route('admin.kehadiranA.index') }}">Kehadiran</a>
        <a href="{{ route('admin.hafalanadmin.index') }}" class="active">Hafalan Santri</a>
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
        <h1>Detail Hafalan Santri</h1>
        <img src="{{ asset('img/image/logortq.png') }}" alt="Logo RTQ" height="150" width="100" />
      </div>

      <div class="ka-form-container">
        <div class="kd-form-group">
          <div class="gki-form-row">

            {{-- tambahan tambahan tambahan --}}
            <div class="gki-form-item">
              <div class="gki-info-box">Periode {{ $periode->tahun_ajaran ?? '-' }}</div>
            </div>
            <div class="gki-form-item">
              <div class="gki-info-box">{{ ucfirst($cabang) }}</div>
            </div>
          </div>

          <div class="gki-form-row">
            <div class="gki-form-item">
              <div class="gki-info-box">{{ $guru->nama_guru ?? '-' }}</div>
            </div>
            <div class="gki-form-item">
              <div class="gki-info-box">{{ $kelas }}</div>
            </div>
          </div>

          <div class="gki-form-row">
            <div class="gki-form-item">
              <div class="gki-info-box">{{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}</div>
            </div>
          </div>

          <div style="overflow-x:auto;">
            <table>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Santri</th>
                  <th>Surah</th>
                  <th>Juz</th>
                  <th>Ayat</th>
                </tr>
              </thead>
              <tbody>
                {{-- tambahan tambahan tambahan --}}
                @foreach($hafalan as $i => $item)
          <tr>
            <td>{{ $loop->iteration + ($hafalan->currentPage() - 1) * $hafalan->perPage() }}</td>
            <td>{{ $item->santri->nama_santri ?? '-' }}</td>
            <td>{{ $item->surah }}</td>
            <td>{{ $item->juz }}</td>
            <td>{{ $item->ayat_awal }} - {{ $item->ayat_akhir }}</td>
          </tr>
        @endforeach
              </tbody>
            </table>

            @if ($hafalan->total() > 0)
        <div class="pagination">
          Showing {{ $hafalan->firstItem() }} to {{ $hafalan->lastItem() }} of {{ $hafalan->total() }} entries
        </div>
      @endif

            @if ($hafalan->hasPages())
          <div class="box-pagination-left">
            {{-- Tombol Previous --}}
            @if ($hafalan->onFirstPage())
          <span class="page-box-small disabled">«</span>
        @else
          <a href="{{ $hafalan->previousPageUrl() }}" class="page-box-small">«</a>
        @endif

            {{-- Nomor Halaman --}}
            @foreach ($hafalan->getUrlRange(1, $hafalan->lastPage()) as $page => $url)
          @if ($page == $hafalan->currentPage())
          <span class="page-box-small active">{{ $page }}</span>
        @else
          <a href="{{ $url }}" class="page-box-small">{{ $page }}</a>
        @endif
        @endforeach

            {{-- Tombol Next --}}
            @if ($hafalan->hasMorePages())
          <a href="{{ $hafalan->nextPageUrl() }}" class="page-box-small">»</a>
        @else
          <span class="page-box-small disabled">»</span>
        @endif
          </div>
      @endif

          </div>
          <div class="gki-button-group">
            <a href="{{ route('admin.hafalanadmin.index') }}">
              <button class="gki-input-btn">Kembali</button>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>