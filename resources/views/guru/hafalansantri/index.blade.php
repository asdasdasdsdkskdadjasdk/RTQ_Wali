<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Hafalan Santri</title>
  <link rel="shortcut icon" href="{{ asset('img/image/logortq.png') }}" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <script src="https://cdn.tailwindcss.com"></script>[]
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <style>
    .gy-sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 240px;
      height: 100vh;
      background-color: white;
      z-index: 50;
      padding: 1rem;
      transition: left 0.3s ease;
    }

    .main {
      margin-left: 240px;
      flex: 1;
    }

    .hamburger {
      display: none;
    }

    @media (max-width: 768px) {
      .gy-sidebar {
        left: -100%;
      }

      .gy-sidebar.active {
        left: 0;
      }

      .hamburger {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem;
        background-color: white;
        border-radius: 0.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        z-index: 50;
      }

      .main {
        margin-left: 0;
      }
    }

    .gy-topbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem;
      background-color: white;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .gy-topbar img {
      height: 48px;
      width: auto;
      padding: 4px;
      background: white;
      border-radius: 0.5rem;
    }

    @media (max-width: 480px) {
      .gy-topbar h1 {
        font-size: 1rem;
      }

      .gy-topbar img {
        height: 40px;
      }
    }
  </style>
</head>

<body>
  <div class="container flex">
    <!-- Sidebar -->
    <div class="gy-sidebar" id="sidebar">
      <div class="sidebar-header flex justify-between items-center mb-4">
        <div class="flex items-center gap-2">
          <img src="{{ asset('img/image/akun.png') }}" alt="Foto Admin"
            style="width: 40px; height: 40px; border-radius: 50%;">
          <strong>{{ Auth::user()->guru->nama_guru ?? Auth::user()->name }}</strong>
        </div>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" style="background: none; border: none; cursor: pointer;">
            <img src="{{ asset('img/image/logout.png') }}" alt="Logout" style="width: 18px; height: 18px;">
          </button>
        </form>
      </div>

      <a href="{{ route('dashboard') }}">
        <i class="fas fa-home mr-2"></i>Dashboard
      </a>
      <a href="{{ route('guru.profile.edit') }}">
        <i class="fas fa-user mr-2"></i>Profil Saya
      </a>
      <a href="{{ route('guru.kehadiranG.index') }}">
        <i class="fas fa-check-circle mr-2"></i>Kehadiran
      </a>
      <a href="{{ route('guru.hafalansantri.index') }}" class="active">
        <i class="fas fa-book mr-2"></i>Hafalan Santri
      </a>
      <a href="{{ route('password.editGuru') }}">
        <i class="fas fa-key mr-2"></i>Ubah Password
      </a>
    </div>

    <!-- Main Content -->
    <div class="main flex-1">
      <div class="gy-topbar">
        <div class="flex items-center gap-4">
          <button class="hamburger" id="toggleSidebarBtn">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
          <h1 class="text-xl font-bold">Hafalan Santri</h1>
        </div>
        <img src="{{ asset('img/image/logortq.png') }}" alt="Logo" />
      </div>

      <div class="chart-container p-4">
        <!-- Dropdown Periode -->
        <div class="mb-4">
          <form method="GET" action="{{ route('guru.hafalansantri.index') }}">
            <label for="periode_id" class="mr-2 font-medium">Pilih Periode:</label>
            <select name="periode_id" id="periode_id" onchange="this.form.submit()"
              class="border border-gray-300 rounded px-2 py-1 text-sm w-44">
              <option value="">-- Semua Periode --</option>
              @foreach ($listPeriode as $periode)
          <option value="{{ $periode->id }}" {{ $selectedPeriode == $periode->id ? 'selected' : '' }}>
          {{ $periode->tahun_ajaran }}
          </option>
        @endforeach
            </select>
          </form>
        </div>

        <div class="text-xl font-semibold mb-4">Daftar Kelas Hafalan Anda</div>

        <div class="flex flex-wrap gap-4">
          @forelse ($kelasUnik as $item)
        <div
        style="background-color:#d4f5d0; padding:1rem; border-radius:1rem; box-shadow:0 2px 6px rgba(0,0,0,0.1); width:100%; max-width:200px; display:flex; flex-direction:column; align-items:center; text-align:center;">
        <div style="font-size:1.125rem; font-weight:bold; margin-bottom:0.5rem;">{{ $item }}</div>
        <div style="display:flex; gap:0.5rem;">

          <!-- Tombol Plus (Biru) -->
          <a href="{{ route('guru.hafalansantri.input', strtolower($item)) }}" title="Input Hafalan"
          style="background-color:#27ae60; color:white; padding:0.5rem; border-radius:0.375rem; box-shadow:0 2px 4px rgba(0,0,0,0.1); text-decoration:none;">
          <i class="fas fa-plus" style="font-size:1rem;"></i>
          </a>

          <!-- Tombol Detail (Kuning) -->
          <a href="{{ route('guru.hafalansantri.detail', strtolower($item)) }}" title="Lihat Detail"
          style="background-color:#3498db; color:white; padding:0.5rem; border-radius:0.375rem; box-shadow:0 2px 4px rgba(0,0,0,0.1); text-decoration:none;">
          <i class="fas fa-info-circle" style="font-size:1rem;"></i>
          </a>

        </div>
        </div>
      @empty
        <p style="color:#6b7280;">Tidak ada jadwal mengajar untuk Anda.</p>
      @endforelse
        </div>
      </div>
    </div>
  </div>

  <script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebarBtn');

    toggleBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      sidebar.classList.toggle('active');
      if (sidebar.classList.contains('active')) {
        toggleBtn.style.display = 'none';
      } else {
        toggleBtn.style.display = 'inline-flex';
      }
    });

    document.addEventListener('click', function (e) {
      if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
        sidebar.classList.remove('active');
        toggleBtn.style.display = 'inline-flex';
      }
    });
  </script>
</body>


</html>