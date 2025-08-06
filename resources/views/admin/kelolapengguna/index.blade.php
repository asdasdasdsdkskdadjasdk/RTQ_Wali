<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Kelola Pengguna</title>
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
      <a href="{{ route('admin.dataguru.index') }}">Data Guru</a>
      <a href="{{ route('admin.datasantri.index') }}">Data Santri</a>
      <a href="{{ route('admin.kelolapengguna.index') }}" class="active">Kelola Pengguna</a>
      <a href="{{ route('admin.periode.index') }}">Periode</a>
      <a href="{{ route('admin.kategoripenilaian.index') }}">Kategori Penilaian</a>
      <a href="{{ route('admin.kehadiranA.index') }}">Kehadiran</a>
      <a href="{{ route('admin.hafalanadmin.index') }}">Hafalan Santri</a>
      <a href="{{ route('admin.kinerjaguru.index') }}">Kinerja Guru</a>
    </div>

    <!-- Main Content -->
    <div class="main">
      <div class="topbar">
        <h1>Daftar Pengguna</h1>
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
    
      <div class="chart-container">
        <a href="{{ route('admin.kelolapengguna.create') }}">
              <button type="button" class="add-btn"
                style="padding: 0.5rem 1rem; background-color: #a4e4b3; color: black; border: none; border-radius: 4px; cursor: pointer;">
                Tambah
              </button>
            </a>

        <div style="overflow-x:auto; margin-top: 20px;">
          <table>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($users as $user)
            <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
              @foreach ($user->getRoleNames() as $role)
          <span class="badge bg-success">{{ $role }}</span>
          @endforeach
            </td>
            <td>{{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}</td>
            <td class="action-buttons">
              <a href="{{ route('admin.kelolapengguna.edit', $user->id) }}">
              <button><img src="{{ asset('img/image/edit.png') }}" alt="edit" height="100" /></button>
              </a>
            </td>
            </tr>
        @empty
          <tr>
          <td colspan="5">Belum ada pengguna.</td>
          </tr>
        @endforelse
            </tbody>
          </table>
        </div>
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
</script>
</body>

</html>