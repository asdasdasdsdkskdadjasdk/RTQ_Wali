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


      <div class="form-container" style="margin-top: 30px;">
        @if ($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
          <ul style="margin: 0; padding-left: 20px;">
          @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
          </ul>
        </div>
    @endif

        <form action="{{ route('admin.kelolapengguna.store') }}" method="POST">
          @csrf

          <div class="form-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 5px;">

            <!-- Nama -->
            <div>
              <label for="name"><strong>Nama <span style="color: red;">*</span></strong></label>
              <input type="text" name="name" id="name" required
                style="width: 100%; padding: 8px; box-sizing: border-box;">
            </div>

            <!-- Email -->
            <div>
              <label for="email"><strong>Email <span style="color: red;">*</span></strong></label>
              <input type="email" name="email" id="email" value="{{ old('email') }}" required
                style="width: 100%; padding: 8px; box-sizing: border-box;">
              @error('email')
          <div style="color:red; font-size:0.9rem;">{{ $message }}</div>
        @enderror
            </div>

            <!-- Password -->
            <div>
              <label for="password"><strong>Password <span style="color: red;">*</span></strong></label>
              <input type="password" name="password" id="password" required
                style="width: 100%; padding: 8px; box-sizing: border-box;">
              @error('password')
          <div style="color:red; font-size:0.9rem;">{{ $message }}</div>
        @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div>
              <label for="password_confirmation"><strong>Konfirmasi Password <span
                    style="color: red;">*</span></strong></label>
              <input type="password" name="password_confirmation" id="password_confirmation" required
                style="width: 100%; padding: 8px; box-sizing: border-box;">
            </div>

            <!-- Role -->
            <div>
              <label for="role"><strong>Role <span style="color: red;">*</span></strong></label>
              <select name="role" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                <option value="">-- Pilih Role --</option>
                @foreach ($roles as $role)
          <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
        @endforeach
              </select>
            </div>

            <!-- Status -->
            <div>
              <label for="is_active"><strong>Status <span style="color: red;">*</span></strong></label>
              <select name="is_active" id="is_active" required
                style="width: 100%; padding: 8px; box-sizing: border-box;">
                <option value="1">Aktif</option>
                <option value="0">Nonaktif</option>
              </select>
            </div>
          </div>

          <!-- Tombol -->
          <div style="margin-top: 30px; display: flex; gap: 10px;">
            <a href="{{ route('admin.kelolapengguna.index') }}">
              <button type="button" style="padding: 10px 20px; background-color: #ccc; border: none; cursor: pointer;">
                Kembali
              </button>
            </a>
            <button type="submit" style="padding: 10px 20px; background-color: #a4e4b3; border: none; cursor: pointer;">
              Tambah
            </button>
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