<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RTQ Al-Yusra | Kehadiran</title>
  <link rel="shortcut icon" href="{{ asset('img/image/logortq.png') }}" alt="Logo RTQ" height="100" type="image/x-icon">
  <!-- style css -->
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
      <a href="{{ route('admin.datasantri.index') }}">Data Santri</a>
      <a href="{{ route('admin.kelolapengguna.index') }}">Kelola Pengguna</a>
      <a href="{{ route('admin.periode.index') }}">Periode</a>
      <a href="{{ route('admin.kategoripenilaian.index') }}">Kategori Penilaian</a>
      <a href="{{ route('admin.kehadiranA.index') }}" class="active">Kehadiran</a>
      <a href="{{ route('admin.hafalanadmin.index') }}">Hafalan Santri</a>
      <a href="{{ route('admin.kinerjaguru.index') }}">Kinerja Guru</a>
    </div>

    <!-- Main Content -->
    <div class="main">
    <div class="topbar">
        <h1>Detail Kehadiran</h1>
        <img src="{{ asset('img/image/logortq.png') }}" alt="Logo RTQ" height="150" width="100" />
    </div>

    <div class="ka-form-container">
        <div class="dk-form-row">
            <label>Periode : </label>
            <div class="dk-form-item">{{ $periode->tahun_ajaran ?? '-' }}</div>
        </div>

        <div class="dk-form-row">
            <label>Tanggal : </label>
            <div class="dk-form-item">{{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}</div>
        </div>

        <div class="dk-form-row">
            <label>Dokumentasi : </label>
            <div class="dk-form-item">
                @forelse ($dokumentasi as $dok)
                    <a href="{{ $dok->dokumentasi_url }}" target="_blank">Foto</a><br>
                @empty
                    <p>Tidak ada dokumentasi.</p>
                @endforelse
            </div>
        </div>

        <div id="kehadiranTableContainer">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Santri</th>
                        <th>Kelas</th>
                        <th>Guru</th>
                        <th>Kegiatan</th>
                        <th>Status Kehadiran</th>
                        <th>Bukti</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dataKehadiran as $index => $item)
                        <tr>
                            <td>{{ $loop->iteration + ($dataKehadiran->currentPage() - 1) * $dataKehadiran->perPage() }}</td>
                            <td>{{ $item->santri->nama_santri ?? '-' }}</td>
                            <td>{{ $item->jadwal->kelas ?? '-' }}</td>
                            <td>{{ $item->jadwal->guru->nama_guru ?? '-' }}</td>
                            <td>{{ $item->jadwal->kegiatan ?? '-' }}</td>
                            <td>{{ $item->status_kehadiran }}</td>
                            <td>
                                @if($item->bukti && Storage::disk('public')->exists($item->bukti))
                                    <a href="{{ Storage::url($item->bukti) }}" target="_blank">Lihat Bukti</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7">Tidak ada data kehadiran</td></tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Info jumlah dan navigasi --}}
            @if ($dataKehadiran->total() > 0)
                <div class="pagination">
                    Showing {{ $dataKehadiran->firstItem() }} to {{ $dataKehadiran->lastItem() }} of {{ $dataKehadiran->total() }} entries
                </div>
            @endif

            @if ($dataKehadiran->hasPages())
                <div class="box-pagination-left">
                    {{-- Tombol Previous --}}
                    @if ($dataKehadiran->onFirstPage())
                        <span class="page-box-small disabled">«</span>
                    @else
                        <a href="{{ $dataKehadiran->previousPageUrl() }}" class="page-box-small">«</a>
                    @endif

                    {{-- Nomor halaman --}}
                    @foreach ($dataKehadiran->getUrlRange(1, $dataKehadiran->lastPage()) as $page => $url)
                        @if ($page == $dataKehadiran->currentPage())
                            <span class="page-box-small active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-box-small">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Tombol Next --}}
                    @if ($dataKehadiran->hasMorePages())
                        <a href="{{ $dataKehadiran->nextPageUrl() }}" class="page-box-small">»</a>
                    @else
                        <span class="page-box-small disabled">»</span>
                    @endif
                </div>
            @endif
        </div>

        <div class="gki-button-group">
            <a href="{{ route('admin.kehadiranA.index') }}">
                <button class="gki-input-btn">Kembali</button>
            </a>
        </div>
    </div>
</div>

</body>

</html>