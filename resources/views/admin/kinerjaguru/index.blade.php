<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RTQ Al-Yusra | Kinerja Guru</title>
  <link rel="shortcut icon" href="{{ asset('img/image/logortq.png') }}" alt="Logo RTQ" height="100" type="image/x-icon">
  <!-- style css -->
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
        <a href="{{ route('admin.periode.index') }}"><i class="fas fa-clock" style="margin-right:8px;"></i>Periode</a>
        <a href="{{ route('admin.kategoripenilaian.index') }}"><i class="fas fa-list-ul"
            style="margin-right:8px;"></i>Kategori Penilaian</a>
        <a href="{{ route('admin.kehadiranA.index') }}"><i class="fas fa-check-circle"
            style="margin-right:8px;"></i>Kehadiran</a>
        <a href="{{ route('admin.hafalanadmin.index') }}" ><i class="fas fa-book"
            style="margin-right:8px;"></i>Hafalan
          Santri</a>
        <a href="{{ route('admin.kinerjaguru.index') }}" class="active"><i class="fas fa-chart-line"
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
        <h1>Kinerja Guru</h1>
        <img src="{{ asset('img/image/logortq.png') }}" alt="Logo RTQ" height="150" width="100" />
      </div>

      <div class="ka-form-container">
        <div class="kg-form-group">
          <!-- Dropdown Periode -->
          <div style="margin-bottom: 1rem;">
            <div class="dropdown" style="position: relative; display: inline-block;">
              <button type="button" class="dropdown-btn" onclick="toggleDropdown()"
                style="background-color: #A4E4B3; color: black; border: 1px solid #d1d5db; border-radius: 0.375rem; padding: 0.375rem 0.75rem; display: flex; align-items: center; gap: 0.5rem; font-weight: 600; font-size: 0.875rem;">
                Periode:
                <span id="selected-year">{{ $selectedPeriodeNama }}</span>
                <span class="menu-arrow">
                  <img src="{{ asset('img/image/arrowdown.png') }}" alt="arrowdown" style="height: 12px;" />
                </span>
              </button>
              <div class="dropdown-content" id="dropdown-menu"
                style="position: absolute; display: none; background-color: white; margin-top: 0.25rem; border: 1px solid #e5e7eb; border-radius: 0.375rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); z-index: 10; min-width: 100%;">
                @foreach($periodes as $p)
              <div onclick="selectYear('{{ $p->id }}', '{{ $p->tahun_ajaran }}')"
                style="padding: 0.5rem 1rem; cursor: pointer; font-size: 0.875rem; {{ $selectedPeriode == $p->id ? 'background-color: #dbeafe;' : '' }}"
                onmouseover="this.style.backgroundColor='#f3f4f6'"
                onmouseout="this.style.backgroundColor='{{ $selectedPeriode == $p->id ? '#dbeafe' : 'white' }}'">
                {{ $p->tahun_ajaran }}
                @if($selectedPeriode == $p->id)
            <span style="color: #2563eb; font-weight: 600;">(Aktif)</span>
            @endif
              </div>
        @endforeach
              </div>
            </div>
          </div>

          <!-- Loading indicator -->
          <div id="loading" style="display: none; margin-bottom: 1rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
              <div
                style="width: 1rem; height: 1rem; border: 2px solid #16a34a; border-top: 2px solid transparent; border-radius: 50%; animation: spin 1s linear infinite;">
              </div>
              <span style="font-size: 0.875rem; color: #6b7280;">Memperbarui data...</span>
            </div>
          </div>

          <!-- Tabel Kinerja Guru -->
          <div style="overflow-x:auto;">
            <table>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Guru</th>
                  <th>Cabang</th>
                  <th>Keterlambatan</th>
                  @foreach($kategoriList as $kategori)
            <th>{{ $kategori->kategori }}</th>
          @endforeach
                </tr>
              </thead>
              <tbody>
                @forelse($kinerjaList as $index => $item)
              <tr>
                <td>{{ ($kinerjaList->currentPage() - 1) * $kinerjaList->perPage() + $loop->iteration }}</td>
                <td>{{ $item['nama_guru'] }}</td>
                <td>{{ $item['cabang'] }}</td>
                <td>{{ $item['jumlahTelat'] }}</td>
                @foreach($item['penilaian'] as $nilai)
            <td>{{ $nilai }}</td>
            @endforeach
              </tr>
        @empty
          <tr>
            <td colspan="{{ 4 + count($kategoriList) }}" style="text-align: center;">Belum ada data untuk periode
            ini.</td>
          </tr>
        @endforelse
              </tbody>
            </table>
          </div>

          <!-- Pagination Section -->
          @if ($kinerjaList->total() > 0)
        <div class="pagination" style="margin-top: 1rem;">
        Showing {{ $kinerjaList->firstItem() }} to {{ $kinerjaList->lastItem() }} of {{ $kinerjaList->total() }}
        entries
        </div>
      @endif
          @if ($kinerjaList->hasPages())
          <div class="box-pagination-left">
          {{-- Tombol Previous --}}
          @if ($kinerjaList->onFirstPage())
        <span class="page-box-small disabled">«</span>
        @else
        <a href="{{ $kinerjaList->previousPageUrl() }}" class="page-box-small">«</a>
        @endif
          {{-- Nomor Halaman --}}
          @foreach ($kinerjaList->getUrlRange(1, $kinerjaList->lastPage()) as $page => $url)
          @if ($page == $kinerjaList->currentPage())
          <span class="page-box-small active">{{ $page }}</span>
          @else
          <a href="{{ $url }}" class="page-box-small">{{ $page }}</a>
          @endif
        @endforeach
          {{-- Tombol Next --}}
          @if ($kinerjaList->hasMorePages())
        <a href="{{ $kinerjaList->nextPageUrl() }}" class="page-box-small">»</a>
        @else
        <span class="page-box-small disabled">»</span>
        @endif
          </div>
      @endif
        </div>
      </div>
    </div>
</body>
<script>
  function toggleDropdown() {
    const menu = document.getElementById('dropdown-menu');
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
  }

  function selectYear(id, tahun) {
    // Tampilkan loading
    document.getElementById('loading').style.display = 'block';

    // Update tampilan dropdown
    document.getElementById('selected-year').textContent = tahun;
    document.getElementById('dropdown-menu').style.display = 'none';

    // Kirim request AJAX untuk update session
    fetch('{{ route("admin.dashboard.update-periode") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({
        periode_id: id
      })
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Reload halaman untuk update data
          window.location.reload();
        } else {
          alert('Gagal mengupdate periode: ' + data.message);
          document.getElementById('loading').style.display = 'none';
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengupdate periode');
        document.getElementById('loading').style.display = 'none';
      });
  }

  // Tutup dropdown saat klik di luar
  window.addEventListener('click', function (e) {
    if (!e.target.closest('.dropdown')) {
      document.getElementById("dropdown-menu").style.display = "none";
    }
  });

  // CSS untuk animasi loading
  const style = document.createElement('style');
  style.textContent = `
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
`;
  document.head.appendChild(style);
</script>


</html>