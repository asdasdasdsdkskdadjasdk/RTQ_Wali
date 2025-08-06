<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Tambah Pengguna</title>
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
        <h1>Tambah Pengguna</h1>
        <img src="{{ asset('img/image/logortq.png') }}" alt="Logo RTQ" height="150" width="100" />
      </div>


      <div class="form-container">
        @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
          @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
          </ul>
        </div>
    @endif
        <form action="{{ route('admin.kelolapengguna.store') }}" method="POST">
          @csrf
          <div class="form-content">
            <div class="kpa-form-group">
              <label for="name">Nama</label>
              <input type="text" name="name" id="name" required>
            </div>
            <div class="kpa-form-group">
              <label for="email">Email</label>
              <input type="email" name="email" id="email" value="{{ old('email') }}" required>
              @error('email')
          <div style="color:red; font-size:0.9rem;">{{ $message }}</div>
        @enderror
            </div>

            <div class="kpa-form-group">
              <label for="password">Password</label>
              <input type="password" name="password" id="password" required>
              @error('password')
          <div style="color:red; font-size:0.9rem;">{{ $message }}</div>
        @enderror
            </div>

            <div class="kpa-form-group">
              <label for="password_confirmation">Konfirmasi Password</label>
              <input type="password" name="password_confirmation" id="password_confirmation" required>
            </div>
            <div class="kpa-form-group">
              <label for="role">Role</label>
              <select name="role" class="form-control" required>
                <option value="">-- Pilih Role --</option>
                @foreach ($roles as $role)
          <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
        @endforeach
              </select>
            </div>
            <div class="kpa-form-group">
              <label for="is_active">Status</label>
              <select name="is_active" id="is_active" required>
                <option value="1">Aktif</option>
                <option value="0">Nonaktif</option>
              </select>
            </div>
            <div style="margin-top: 20px; display: flex; gap: 10px;">
              <a href="{{ route('admin.kelolapengguna.index') }}">
                <button type="button"
                  style="padding: 0.5rem 1rem; background-color: #ccc; border: none;">Kembali</button>
              </a>
              <button type="submit"
                style="padding: 0.5rem 1rem; background-color: #a4e4b3; color: black; border: none;">Tambah</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    const form = document.querySelector('form');
    form.addEventListener('submit', function (e) {
      const password = document.getElementById('password').value;
      const confirmation = document.getElementById('password_confirmation').value;
      if (password !== confirmation) {
        e.preventDefault(); // hentikan form submit
        alert('Password dan konfirmasi password tidak cocok!');
      }
    });
  </script>

</body>

</html>