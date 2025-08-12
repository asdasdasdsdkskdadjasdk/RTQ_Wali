<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Kehadiran</title>
  <link rel="shortcut icon" href="{{ asset('img/image/logortq.png') }}" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
    .hamburger {
      display: none;
    }

    @media (max-width: 768px) {
      .gy-sidebar {
        position: fixed;
        top: 0;
        left: -100%;
        width: 240px;
        height: 100vh;
        background-color: white;
        z-index: 50;
        padding: 1rem;
        transition: left 0.3s ease;
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
        margin-left: 0 !important;
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
          <strong>Yayasan</strong>
        </div>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" style="background: none; border: none; cursor: pointer;">
            <img src="{{ asset('img/image/logout.png') }}" alt="Logout" style="width: 18px; height: 18px;">
          </button>
        </form>
      </div>
      <a href="{{ route('dashboard') }}" >
        <i class="fas fa-home"></i> Dashboard
      </a>
      <a href="{{ route('yayasan.kehadiranY.index') }}" class="active">
        <i class="fas fa-check-circle"></i> Kehadiran
      </a>
      <a href="{{ route('yayasan.hafalansantriY.index') }}">
        <i class="fas fa-book"></i> Hafalan Santri
      </a>
      <a href="{{ route('yayasan.kategorinilai.index') }}">
        <i class="fas fa-chalkboard-teacher"></i> Kinerja Guru
      </a>
      <a href="{{ route('password.editYayasan') }}">
        <i class="fas fa-key"></i> Ubah Password
      </a>
    </div>

    <!-- Main Content -->
    <div class="main flex-1">
      <div class="gy-topbar bg-white flex justify-between items-center p-4 shadow">
        <div class="flex items-center gap-4">
          <button class="hamburger" id="toggleSidebarBtn">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
          <h1 class="text-xl font-bold">Kehadiran</h1>
        </div>
        <img src="{{ asset('img/image/logortq.png') }}" alt="Logo" class="h-20 bg-white p-2 rounded" />
      </div>

      <div class="chart-container">
        <!-- Baris label dan dropdown -->
        <div class="y-form-group header-row">
          <div class="y-label">Cabang RTQ Al-Yusra</div>
        </div>

        <!-- Tombol cabang -->
        <div class="p-4">
          <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
            <button onclick="window.location.href='{{ route('yayasan.kehadiranY.detail', ['cabang' => 'Sukajadi']) }}'"
              class="bg-[#A4E4B3] text-black font-semibold py-2 rounded shadow hover:bg-green-200 transition">Sukajadi</button>

            <button onclick="window.location.href='{{ route('yayasan.kehadiranY.detail', ['cabang' => 'Rumbai']) }}'"
              class="bg-[#A4E4B3] text-black font-semibold py-2 rounded shadow hover:bg-green-200 transition">Rumbai</button>

            <button onclick="window.location.href='{{ route('yayasan.kehadiranY.detail', ['cabang' => 'Gobah 1']) }}'"
              class="bg-[#A4E4B3] text-black font-semibold py-2 rounded shadow hover:bg-green-200 transition">Gobah
              1</button>

            <button onclick="window.location.href='{{ route('yayasan.kehadiranY.detail', ['cabang' => 'Gobah 2']) }}'"
              class="bg-[#A4E4B3] text-black font-semibold py-2 rounded shadow hover:bg-green-200 transition">Gobah
              2</button>

            <button
              onclick="window.location.href='{{ route('yayasan.kehadiranY.detail', ['cabang' => 'Rawa Bening']) }}'"
              class="bg-[#A4E4B3] text-black font-semibold py-2 rounded shadow hover:bg-green-200 transition">Rawa
              Bening</button>
          </div>
        </div>
      </div>
    </div>

    <!-- JS Dropdown Logic -->
    <script>
      const sidebar = document.getElementById('sidebar');
      const toggleBtn = document.getElementById('toggleSidebarBtn');

      toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        toggleBtn.classList.toggle('hidden');
      });

      document.addEventListener('click', function (e) {
        if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
          sidebar.classList.remove('active');
          toggleBtn.classList.remove('hidden');
        }
      });
      function toggleDropdown() {
        const menu = document.getElementById('dropdown-menu');
        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
      }

      function selectYear(year) {
        document.getElementById('selected-year').textContent = year;
        document.getElementById('dropdown-menu').style.display = 'none';
      }

      window.onclick = function (e) {
        if (!e.target.closest('.dropdown')) {
          const dropdowns = document.getElementsByClassName("dropdown-content");
          for (let i = 0; i < dropdowns.length; i++) {
            dropdowns[i].style.display = "none";
          }
        }
      }
    </script>
</body>

</html>