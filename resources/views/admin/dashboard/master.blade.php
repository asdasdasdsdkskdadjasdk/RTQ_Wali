<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Dashboard Admin</title>
  <link rel="shortcut icon" href="{{ asset('img/image/logortq.png') }}" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
  <div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
      <div class="sidebar-header">
        <div style="display: flex; align-items: center; gap: 8px;">
          <img src="{{ asset('img/image/akun.png') }}" alt="Foto Admin"
            style="width: 40px; height: 40px; border-radius: 40%;">
          <strong>Admin</strong>
        </div>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" style="background: none; border: none; cursor: pointer;">
            <img src="{{ asset('img/image/logout.png') }}" alt="Logout" style="width: 18px; height: 18px;">
          </button>
        </form>
      </div>
      <!-- Menu -->
      <a href="{{ route('dashboard') }}" class="active">Dashboard</a>
      <a href="{{ route('admin.jadwalmengajar.index') }}">Jadwal Mengajar</a>
      <a href="{{ route('admin.dataguru.index') }}">Data Guru</a>
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
        <h1>Dashboard</h1>
        <img src="{{ asset('img/image/logortq.png') }}" alt="Logo RTQ" height="150" width="100" />
      </div>

      <div class="chart-container">
        <!-- Dropdown Periode -->
        <div class="dropdown">
          <button type="button" class="dropdown-btn" onclick="toggleDropdown()">Periode:
            <span id="selected-year">{{ $selectedPeriodeNama }}</span>
            <span class="menu-arrow">
              <img src="{{ asset('img/image/arrowdown.png') }}" alt="arrowdown" height="15" />
            </span>
          </button>
          <div class="dropdown-content" id="dropdown-menu">
            @foreach($periodes as $p)
          <div onclick="selectYear('{{ $p->id }}', '{{ $p->tahun_ajaran }}')">
            {{ $p->tahun_ajaran }}
            @if($selectedPeriode == $p->id)
          <span style="color: #2563eb; font-weight: 600;">(Aktif)</span>
        @endif
          </div>
      @endforeach
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

        <!-- Cards -->
        <div class="cards">
          <div class="card">
            <h2>Jumlah Guru</h2>
            <p>{{ $guruCount }} Guru</p>
          </div>
          <div class="card">
            <h2>Jumlah Santri</h2>
            <p>{{ $santriCount }} Santri</p>
          </div>
        </div>

        <!-- Charts -->
        <div class="chart-placeholder">
          <div class="chart-box">
            <h4>Data Kehadiran</h4>
            <canvas id="kehadiranChart" height="200"></canvas>
          </div>
          <div class="chart-box">
            <h4>Data Hafalan Santri</h4>
            <canvas id="hafalanChart" height="200"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Script Dropdown -->
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
            // Reload halaman untuk update data dashboard
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

    window.onclick = function (e) {
      if (!e.target.closest('.dropdown-btn')) {
        document.getElementById("dropdown-menu").style.display = "none";
      }
    };

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

  <!-- Script Chart -->
  <script>
    const kehadiranData = @json($kehadiranData);
    const hafalanByJuz = @json($hafalanByJuz);

    // Kehadiran chart (per cabang: hadir & alfa)
    const labelsKehadiran = kehadiranData.map(item => item.cabang);
    const hadirData = kehadiranData.map(item => item.hadir);
    const alfaData = kehadiranData.map(item => item.alfa);

    new Chart(document.getElementById('kehadiranChart'), {
      type: 'bar',
      data: {
        labels: labelsKehadiran,
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

    // Hafalan chart
    const filteredHafalan = hafalanByJuz.filter(item => item.juz !== null && item.juz !== 0 && item.juz !== '');
    const labelsHafalan = filteredHafalan.map(item => `Juz ${item.juz}`);
    const dataHafalan = filteredHafalan.map(item => item.total);

    new Chart(document.getElementById('hafalanChart'), {
      type: 'bar',
      data: {
        labels: labelsHafalan,
        datasets: [{
          label: 'Jumlah Santri',
          data: dataHafalan,
          backgroundColor: '#2196F3'
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Jumlah Santri'
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
  </script>
</body>

</html>