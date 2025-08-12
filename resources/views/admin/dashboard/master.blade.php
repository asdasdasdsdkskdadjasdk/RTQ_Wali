<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Dashboard Admin</title>
  <link rel="shortcut icon" href="{{ asset('img/image/logortq.png') }}" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
    <div class="sidebar" style="display:flex; flex-direction:column; height:100vh; justify-content:space-between;">
      <div style="flex:1; overflow-y:auto;">
        <div class="sidebar-header">
          <div style="display:flex; align-items:center; gap:8px;">
            <img src="{{ asset('img/image/akun.png') }}" alt="Foto Admin" style="width:40px; height:40px; border-radius:40%;">
            <strong>Admin</strong>
          </div>
          <form method="POST" action="{{ route('logout') }}" style="margin-right:8px;">
            @csrf
            <button type="submit" style="background:none; border:none; cursor:pointer; padding:4px;">
              <img src="{{ asset('img/image/logout.png') }}" alt="Logout" style="width:18px; height:18px;">
            </button>
          </form>
        </div>

        <a href="{{ route('dashboard') }}" class="active">
          <i class="fas fa-home"></i> Dashboard
        </a>
        <a href="{{ route('admin.jadwalmengajar.index') }}">
          <i class="fas fa-calendar-alt"></i> Jadwal Mengajar
        </a>
        <a href="{{ route('admin.dataguru.index') }}">
          <i class="fas fa-chalkboard-teacher"></i> Data Guru
        </a>
        <a href="{{ route('admin.datasantri.index') }}">
          <i class="fas fa-users"></i> Data Santri
        </a>
        <a href="{{ route('admin.kelolapengguna.index') }}">
          <i class="fas fa-user-cog"></i> Kelola Pengguna
        </a>
        <a href="{{ route('admin.periode.index') }}">
          <i class="fas fa-clock"></i> Periode
        </a>
        <a href="{{ route('admin.kategoripenilaian.index') }}">
          <i class="fas fa-list-ul"></i> Kategori Penilaian
        </a>
        <a href="{{ route('admin.kehadiranA.index') }}">
          <i class="fas fa-check-circle"></i> Kehadiran
        </a>
        <a href="{{ route('admin.hafalanadmin.index') }}">
          <i class="fas fa-book"></i> Hafalan Santri
        </a>
        <a href="{{ route('admin.kinerjaguru.index') }}">
          <i class="fas fa-chart-line"></i> Kinerja Guru
        </a>
      </div>

      <div style="border-top:1px solid #ddd; padding-top:10px;">
        <a href="{{ route('password.editAdmin') }}">
          <i class="fas fa-key"></i> Ubah Password
        </a>
      </div>
    </div>

    <!-- Main Content -->
    <div class="main">
      <div class="topbar">
        <h1>Dashboard</h1>
        <img src="{{ asset('img/image/logortq.png') }}" alt="Logo RTQ" height="150" width="100" />
      </div>

      <div class="chart-container">
        <!-- Dropdown Periode (AJAX) -->
        <div class="dropdown">
          <button type="button" class="dropdown-btn" onclick="toggleDropdown()">
            Periode: <span id="selected-year">{{ $selectedPeriodeNama }}</span>
            <span class="menu-arrow"><img src="{{ asset('img/image/arrowdown.png') }}" alt="arrowdown" height="15" /></span>
          </button>
          <div class="dropdown-content" id="dropdown-menu">
            @foreach($periodes as $p)
              <div onclick="selectYear('{{ $p->id }}', '{{ $p->tahun_ajaran }}')">
                {{ $p->tahun_ajaran }}
                @if($selectedPeriode == $p->id)
                  <span style="color:#2563eb; font-weight:600;">(Aktif)</span>
                @endif
              </div>
            @endforeach
          </div>
        </div>

        <!-- Filter Bulan & Juz -->
        <form method="GET" action="{{ url()->current() }}" style="margin:12px 0; display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
          <div>
            <label for="bulan" style="font-size:.9rem; margin-right:6px;">Bulan</label>
            <select name="dash_bulan" id="bulan" onchange="this.form.submit()" style="padding:.5rem; border:1px solid #ccc; border-radius:6px; min-width:180px;">
              @foreach($bulanList as $b)
                <option value="{{ $b['val'] }}" {{ (string)$bulanSelected === (string)$b['val'] ? 'selected' : '' }}>
                  {{ $b['label'] }}
                </option>
              @endforeach
            </select>
          </div>

          <div>
            <label for="juz" style="font-size:.9rem; margin-right:6px;">Juz Hafalan</label>
            <select name="dash_juz" id="juz" onchange="this.form.submit()" style="padding:.5rem; border:1px solid #ccc; border-radius:6px; min-width:160px;">
              @foreach($juzList as $j)
                <option value="{{ $j['val'] }}" {{ (string)$juzSelected === (string)$j['val'] ? 'selected' : '' }}>
                  {{ $j['label'] }}
                </option>
              @endforeach
            </select>
          </div>

          @if($selectedPeriodeNama && $selectedPeriode)
            <div style="font-size:.85rem; color:#555;">
              Periode Aktif: <strong>{{ $selectedPeriodeNama }}</strong>
            </div>
          @endif
        </form>

        <!-- Loading -->
        <div id="loading" style="display:none; margin-bottom:1rem;">
          <div style="display:flex; align-items:center; gap:.5rem;">
            <div style="width:1rem; height:1rem; border:2px solid #16a34a; border-top:2px solid transparent; border-radius:50%; animation:spin 1s linear infinite;"></div>
            <span style="font-size:.875rem; color:#6b7280;">Memperbarui data...</span>
          </div>
        </div>

        <!-- Cards -->
        <div class="cards">
          <div class="card"><h2>Jumlah Guru</h2><p>{{ $guruCount }} Guru</p></div>
          <div class="card"><h2>Jumlah Santri</h2><p>{{ $santriCount }} Santri</p></div>
        </div>

        <!-- Charts -->
        <div class="chart-placeholder">
          <div class="chart-box">
            <h4>
              Data Kehadiran
              @if($bulanSelected !== 'all') (Bulan: {{ $bulanSelected }}) @endif
            </h4>
            <canvas id="kehadiranChart" height="200"></canvas>
          </div>
          <div class="chart-box">
            <h4>
              Data Hafalan Santri
              @if($bulanSelected !== 'all') (Bulan: {{ $bulanSelected }}) @endif
              @if($juzSelected !== 'all') (Juz {{ $juzSelected }}) @endif
            </h4>
            <canvas id="hafalanChart" height="200"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Script Dropdown Periode (AJAX) -->
  <script>
    function toggleDropdown() {
      const menu = document.getElementById('dropdown-menu');
      menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
    }

    function selectYear(id, tahun) {
      document.getElementById('loading').style.display = 'block';
      document.getElementById('selected-year').textContent = tahun;
      document.getElementById('dropdown-menu').style.display = 'none';

      fetch('{{ route("admin.dashboard.update-periode") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ periode_id: id })
      })
      .then(r => r.json())
      .then(data => {
        if (data.success) {
          const url = new URL(window.location.href);
          window.location.href = url.pathname + (url.search || '');
        } else {
          alert('Gagal mengupdate periode: ' + data.message);
          document.getElementById('loading').style.display = 'none';
        }
      })
      .catch(err => {
        console.error(err);
        alert('Terjadi kesalahan saat mengupdate periode');
        document.getElementById('loading').style.display = 'none';
      });
    }

    window.onclick = function (e) {
      if (!e.target.closest('.dropdown-btn')) {
        const m = document.getElementById("dropdown-menu");
        if (m) m.style.display = "none";
      }
    };

    const style = document.createElement('style');
    style.textContent = `@keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }`;
    document.head.appendChild(style);
  </script>

  <!-- Script Chart -->
  <script>
    const kehadiranData = @json($kehadiranData);
    const hafalanByJuz  = @json($hafalanByJuz);

    const labelsKehadiran = kehadiranData.map(i => i.cabang);
    const hadirData = kehadiranData.map(i => i.hadir);
    const alfaData  = kehadiranData.map(i => i.alfa);

    new Chart(document.getElementById('kehadiranChart'), {
      type: 'bar',
      data: {
        labels: labelsKehadiran,
        datasets: [
          { label: 'Hadir', data: hadirData, backgroundColor: '#4CAF50' },
          { label: 'Alfa',  data: alfaData,  backgroundColor: '#F44336' }
        ]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            title: { display: true, text: 'Jumlah Kehadiran' },
            ticks: { callback: v => Number.isInteger(v) ? v : null, stepSize: 1 }
          }
        }
      }
    });

    const filteredHafalan = hafalanByJuz.filter(i => i.juz !== null && i.juz !== 0 && i.juz !== '');
    const labelsHafalan = filteredHafalan.map(i => `Juz ${i.juz}`);
    const dataHafalan   = filteredHafalan.map(i => i.total);

    new Chart(document.getElementById('hafalanChart'), {
      type: 'bar',
      data: {
        labels: labelsHafalan,
        datasets: [
          { label: 'Jumlah Santri', data: dataHafalan, backgroundColor: '#2196F3', barPercentage: 0.2, categoryPercentage: 0.4 }
        ]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            title: { display: true, text: 'Jumlah Santri' },
            ticks: { callback: v => Number.isInteger(v) ? v : null, stepSize: 1 }
          }
        }
      }
    });
  </script>
</body>
</html>
