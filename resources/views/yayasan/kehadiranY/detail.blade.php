<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Grafik Kehadiran</title>
  <link rel="shortcut icon" href="{{ asset('img/image/logortq.png') }}" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
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
      <a href="{{ route('dashboard') }}">Dashboard</a>
      <a href="{{ route('yayasan.kehadiranY.index') }}" class="active">Kehadiran</a>
      <a href="{{ route('yayasan.hafalansantriY.index') }}">Hafalan Santri</a>
      <a href="{{ route('yayasan.kategorinilai.index') }}">Kinerja Guru</a>
      <a href="{{ route('password.editYayasan') }}" >Ubah Password</a>
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
          <h1 class="text-xl font-bold">Kehadiran - {{ $cabang }}</h1>
        </div>
        <img src="{{ asset('img/image/logortq.png') }}" alt="Logo" class="h-20 bg-white p-2 rounded" />
      </div>

      <div class="chart-container p-4">
        <!-- Dropdown Periode -->
        <div class="dropdown relative inline-block">
          <button type="button"
            class="dropdown-btn bg-[#A4E4B3] text-black border border-gray-300 rounded px-3 py-1.5 flex items-center gap-2 font-semibold text-sm"
            onclick="toggleDropdown()">Periode:
            <span id="selected-year">{{ $selectedPeriodeNama ?? 'Pilih Periode' }}</span>
            <span class="menu-arrow">
              <img src="{{ asset('img/image/arrowdown.png') }}" alt="arrowdown" class="h-3" />
            </span>
          </button>
          <div
            class="dropdown-content absolute hidden bg-white mt-1 border border-gray-200 rounded shadow-lg z-10 w-full"
            id="dropdown-menu">
            @foreach($periodes as $p)
          <div
            class="px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm {{ $selectedPeriode == $p->id ? 'bg-blue-100' : '' }}"
            onclick="selectYear('{{ $p->id }}', '{{ $p->tahun_ajaran }}')">
            {{ $p->tahun_ajaran }}
            @if($selectedPeriode == $p->id)
          <span class="text-blue-600 font-semibold">(Aktif)</span>
        @endif
          </div>
      @endforeach
          </div>
        </div>

        <!-- Loading indicator -->
        <div id="loading" class="hidden mb-4">
          <div class="flex items-center gap-2">
            <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-green-600"></div>
            <span class="text-sm text-gray-600">Memperbarui data...</span>
          </div>
        </div>

        <!-- Chart -->
        <div class="bg-white p-4 rounded shadow">
          <h4 class="font-semibold text-center mb-4">Data Kehadiran Cabang {{ $cabang }}</h4>
          <canvas id="kehadiranChart" height="300"></canvas>
        </div>

        <!-- Back Button -->
        <div class="mt-4">
          <a href="{{ route('yayasan.kehadiranY.index') }}"
            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            ← Kembali ke Daftar Cabang
          </a>
        </div>
      </div>
    </div>
  </div>

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

    // Chart
    const chartData = @json($chartData);
    const labels = chartData.map(item => item.kelas);
    const hadirData = chartData.map(item => item.hadir);
    const alfaData = chartData.map(item => item.alfa);

    new Chart(document.getElementById('kehadiranChart'), {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [
          {
            label: 'Hadir',
            data: hadirData,
            backgroundColor: '#4CAF50'
          },
          {
            label: 'Alfa',
            data: alfaData,
            backgroundColor: '#F44336'
          }
        ]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Jumlah Kehadiran'
            },
            ticks: {
              callback: function (value) {
                return Number.isInteger(value) ? value : null;
              },
              stepSize: 1
            }
          }
        }
      }
    });

    function toggleDropdown() {
      const menu = document.getElementById('dropdown-menu');
      menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    }

    function selectYear(id, tahun) {
      // Tampilkan loading
      document.getElementById('loading').classList.remove('hidden');

      // Update tampilan dropdown
      document.getElementById('selected-year').textContent = tahun;
      document.getElementById('dropdown-menu').style.display = 'none';

      // Kirim request AJAX untuk update session
      fetch('{{ route("yayasan.dashboard.update-periode") }}', {
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
            document.getElementById('loading').classList.add('hidden');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Terjadi kesalahan saat mengupdate periode');
          document.getElementById('loading').classList.add('hidden');
        });
    }

    // Tutup dropdown saat klik di luar
    window.addEventListener('click', function (e) {
      if (!e.target.closest('.dropdown')) {
        document.getElementById("dropdown-menu").style.display = "none";
      }
    });
  </script>
</body>


</html>