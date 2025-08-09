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
        <a href="{{ route('admin.datasantri.index') }}">Data Santri</a>
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
        <h1>Hafalan Santri</h1>
        <img src="{{ asset('img/image/logortq.png') }}" alt="Logo RTQ" height="150" width="100" />
      </div>

      <!-- Dropdown Periode -->
      <div style="margin: 1rem 0;">
        <div class="dropdown" style="position: relative; display: inline-block;">
          <button type="button" class="dropdown-btn" onclick="toggleDropdown()"
            style="background-color: #A4E4B3; color: black; border: 1px solid #d1d5db; border-radius: 0.375rem; padding: 0.375rem 0.75rem; display: flex; align-items: center; gap: 0.5rem; font-weight: 600; font-size: 0.875rem;">
            Periode:
            <span id="selected-year">
              @if($selectedPeriode)
          {{ \App\Models\Periode::find($selectedPeriode)?->tahun_ajaran ?? 'Tidak ditemukan' }}
        @else
          Pilih Periode
        @endif
            </span>
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

      <!-- Form Filter -->
      <form method="GET" action="{{ route('admin.hafalanadmin.detail') }}">
        <div class="ka-form-container">
          <div class="ka-form-group">
            <!-- Cabang -->
            <div class="ka-form-row">
              <div class="ka-form-item">
                <select name="cabang" id="cabang">
                  <option value="">Pilih Cabang</option>
                  <option value="Sukajadi">Sukajadi</option>
                  <option value="Rumbai">Rumbai</option>
                  <option value="Gobah 1">Gobah 1</option>
                  <option value="Gobah 2">Gobah 2</option>
                  <option value="Rawa Bening">Rawa Bening</option>
                </select>
              </div>
              <div class="ka-form-item">
                <select name="guru_id" id="guru_id">
                  <option value="">Pilih Nama Guru</option>
                  @foreach($gurus as $guru)
            <option value="{{ $guru->id }}">{{ $guru->nama_guru }}</option>
          @endforeach
                </select>
              </div>
            </div>
            <!-- Kelas dan Tanggal -->
            <div class="ka-form-row">
              <div class="ka-form-item">
                <select name="kelas" id="kelas">
                  <option value="">Pilih Kelas</option>
                  <option value="Halaqah A">Halaqah A</option>
                  <option value="Halaqah B">Halaqah B</option>
                  <option value="Halaqah C">Halaqah C</option>
                  <option value="Halaqah D">Halaqah D</option>
                  <option value="Halaqah E">Halaqah E</option>
                </select>
              </div>
              <div class="ka-form-item">
                <input type="date" name="tanggal" id="tanggal">
              </div>
            </div>
            <!-- Button -->
            <div class="ka-button-row">
              <button type="submit" class="ka-add-btn">Lihat Detail</button>
            </div>
          </div>
        </div>
      </form>
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