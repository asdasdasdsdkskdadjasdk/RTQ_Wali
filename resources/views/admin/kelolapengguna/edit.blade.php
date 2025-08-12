<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Edit Pengguna</title>
  <link rel="shortcut icon" href="{{ asset('img/image/logortq.png') }}" type="image/x-icon">
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
        <a href="{{ route('admin.kelolapengguna.index') }}" class="active"><i class="fas fa-user-cog"
            style="margin-right:8px;"></i>Kelola Pengguna</a>
        <a href="{{ route('admin.periode.index') }}"><i class="fas fa-clock" style="margin-right:8px;"></i>Periode</a>
        <a href="{{ route('admin.kategoripenilaian.index') }}"><i class="fas fa-list-ul"
            style="margin-right:8px;"></i>Kategori Penilaian</a>
        <a href="{{ route('admin.kehadiranA.index') }}"><i class="fas fa-check-circle"
            style="margin-right:8px;"></i>Kehadiran</a>
        <a href="{{ route('admin.hafalanadmin.index') }}"><i class="fas fa-book" style="margin-right:8px;"></i>Hafalan
          Santri</a>
        <a href="{{ route('admin.kinerjaguru.index') }}"><i class="fas fa-chart-line"
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
        <h1>Edit Pengguna</h1>
        <img src="{{ asset('img/image/logortq.png') }}" alt="Logo RTQ" height="150" width="100" />
      </div>

      <div class="form-container">
        @if ($errors->any())
        <div class="alert alert-error">
          <ul>
          @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
          </ul>
        </div>
    @endif

        <form action="{{ route('admin.kelolapengguna.update', $pengguna->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="form-content">
            <div class="kpa-form-group">
              <label for="name">Nama</label>
              <input type="text" name="name" id="name" value="{{ old('name', $pengguna->name) }}" required>
            </div>

            <div class="kpa-form-group">
              <label for="email">Email</label>
              <input type="email" name="email" id="email" value="{{ old('email', $pengguna->email) }}" required>
              @error('email')
          <div style="color:red; font-size:0.9rem;">{{ $message }}</div>
        @enderror
            </div>

            <div class="kpa-form-group">
              <label for="password">Password (kosongkan jika tidak diubah)</label>
              <input type="password" name="password" id="password">
              @error('password')
          <div style="color:red; font-size:0.9rem;">{{ $message }}</div>
        @enderror
            </div>

            <div class="kpa-form-group">
              <label for="password_confirmation">Konfirmasi Password</label>
              <input type="password" name="password_confirmation" id="password_confirmation">
            </div>

            <div class="kpa-form-group">
              <label for="role">Role</label>
              <select name="role" class="form-control" required>
                <option value="">-- Pilih Role --</option>
                @foreach ($roles as $role)
          <option value="{{ $role->name }}" {{ $pengguna->roles->pluck('name')->contains($role->name) ? 'selected' : '' }}>
            {{ ucfirst($role->name) }}
          </option>
        @endforeach
              </select>
            </div>

            <div class="kpa-form-group">
              <label for="is_active">Status</label>
              <select name="is_active" id="is_active" required>
                <option value="1" {{ $pengguna->is_active == '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ $pengguna->is_active == '0' ? 'selected' : '' }}>Nonaktif</option>
              </select>
            </div>

            <div class="button-group">
              <a href="{{ route('admin.kelolapengguna.index') }}">
                <button type="button" class="cancel-btn">Cancel</button>
              </a>
              <button type="submit" class="add-btn">Update</button>
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
      if (password && password !== confirmation) {
        e.preventDefault();
        alert('Password dan konfirmasi password tidak cocok!');
      }
    });
  </script>

</body>

</html>