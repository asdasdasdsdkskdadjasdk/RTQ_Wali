<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RTQ Al-Yusra | Profil Guru</title>
  <link rel="shortcut icon" href="{{ asset('img/image/logortq.png') }}" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
          <strong>Guru</strong>
        </div>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" style="background: none; border: none; cursor: pointer;">
            <img src="{{ asset('img/image/logout.png') }}" alt="Logout" style="width: 18px; height: 18px;">
          </button>
        </form>
      </div>

      <a href="{{ route('dashboard') }}" >
        <i class="fas fa-home mr-2"></i>Dashboard
      </a>
      <a href="{{ route('guru.profile.edit') }}" class="active">
        <i class="fas fa-user mr-2"></i>Profil Saya
      </a>
      <a href="{{ route('guru.kehadiranG.index') }}">
        <i class="fas fa-check-circle mr-2"></i>Kehadiran
      </a>
      <a href="{{ route('guru.hafalansantri.index') }}">
        <i class="fas fa-book mr-2"></i>Hafalan Santri
      </a>
      <a href="{{ route('password.editGuru') }}">
        <i class="fas fa-key mr-2"></i>Ubah Password
      </a>
    </div>

    <!-- Main -->
    <div class="main flex-1">
      <div class="gy-topbar bg-white flex justify-between items-center p-4 shadow">
        <div class="flex items-center gap-4">
          <button class="hamburger" id="toggleSidebarBtn">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
          <h1 class="text-xl font-bold">Profil Saya</h1>
        </div>
        <img src="{{ asset('img/image/logortq.png') }}" alt="Logo" class="h-20 bg-white p-2 rounded" />
      </div>

      <div class="p-4">
        @if (session('success'))
      <div class="mb-4 p-3 rounded bg-green-100 text-green-800 text-sm">
        {{ session('success') }}
      </div>
    @endif

        @if ($errors->any())
        <div class="mb-4 p-3 rounded bg-red-100 text-red-800 text-sm">
          <ul class="list-disc ml-5">
          @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
          </ul>
        </div>
    @endif

        <div class="bg-white rounded-xl shadow p-4">
          <form action="{{ route('guru.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nama & Email (readonly mengikuti akun) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
              <div>
                <label class="block text-sm font-semibold mb-1">Nama</label>
                <input type="text" class="w-full border rounded px-3 py-2 bg-gray-100" value="{{ $guru->nama_guru }}"
                  readonly>
              </div>
              <div>
                <label class="block text-sm font-semibold mb-1">Email</label>
                <input type="text" class="w-full border rounded px-3 py-2 bg-gray-100" value="{{ $guru->email }}"
                  readonly>
              </div>
            </div>

            <!-- Tempat Lahir & Tanggal Lahir -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
              <div>
                <label class="block text-sm font-semibold mb-1">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" class="w-full border rounded px-3 py-2" required
                  value="{{ old('tempat_lahir', $guru->tempat_lahir) }}">
              </div>
              <div>
                <label class="block text-sm font-semibold mb-1">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="w-full border rounded px-3 py-2" required
                  value="{{ old('tanggal_lahir', $guru->tanggal_lahir) }}">
              </div>
            </div>

            <!-- Alamat & No HP -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
              <div>
                <label class="block text-sm font-semibold mb-1">Alamat</label>
                <input type="text" name="alamat" class="w-full border rounded px-3 py-2" required
                  value="{{ old('alamat', $guru->alamat) }}">
              </div>
              <div>
                <label class="block text-sm font-semibold mb-1">No HP</label>
                <input type="text" name="no_hp" class="w-full border rounded px-3 py-2" required
                  value="{{ old('no_hp', $guru->no_hp) }}">
              </div>
            </div>

            <!-- Hafalan & Jenis Kelamin -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
              <div>
                <label class="block text-sm font-semibold mb-1">Jumlah Hafalan</label>
                <input type="number" name="jlh_hafalan" class="w-full border rounded px-3 py-2" min="0" required
                  value="{{ old('jlh_hafalan', $guru->jlh_hafalan) }}">
              </div>
              <div>
                <label class="block text-sm font-semibold mb-1">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full border rounded px-3 py-2" required>
                  <option value="P" {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan
                  </option>
                  <option value="L" {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki
                  </option>
                </select>
              </div>
            </div>

            <!-- Pendidikan & Golongan Darah -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
              <div>
                <label class="block text-sm font-semibold mb-1">Pendidikan Terakhir</label>
                <select name="pend_akhir" class="w-full border rounded px-3 py-2" required>
                  @foreach ($opsiPendidikan as $p)
            <option value="{{ $p }}" {{ old('pend_akhir', $guru->pend_akhir) == $p ? 'selected' : '' }}>{{ $p }}
            </option>
          @endforeach
                </select>
              </div>
              <div>
                <label class="block text-sm font-semibold mb-1">Golongan Darah</label>
                <select name="gol_dar" class="w-full border rounded px-3 py-2" required>
                  @foreach ($opsiGolDar as $g)
            <option value="{{ $g }}" {{ old('gol_dar', $guru->gol_dar) == $g ? 'selected' : '' }}>{{ $g }}</option>
          @endforeach
                </select>
              </div>
            </div>

            <!-- MK & Status Menikah -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
              <div>
                <label class="block text-sm font-semibold mb-1">MK</label>
                <select name="mk" class="w-full border rounded px-3 py-2" required>
                  @foreach ($opsiMk as $m)
            <option value="{{ $m }}" {{ old('mk', $guru->mk) == $m ? 'selected' : '' }}>{{ $m }}</option>
          @endforeach
                </select>
              </div>
              <div>
                <label class="block text-sm font-semibold mb-1">Status Menikah</label>
                <select name="status_menikah" class="w-full border rounded px-3 py-2" required>
                  @foreach ($opsiStatus as $s)
            <option value="{{ $s }}" {{ old('status_menikah', $guru->status_menikah) == $s ? 'selected' : '' }}>
            {{ $s }}</option>
          @endforeach
                </select>
              </div>
            </div>

            <!-- Bagian & Cabang -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
              <div>
                <label class="block text-sm font-semibold mb-1">Bagian</label>
                <select name="bagian" class="w-full border rounded px-3 py-2" required>
                  @foreach ($opsiBagian as $b)
            <option value="{{ $b }}" {{ old('bagian', $guru->bagian) == $b ? 'selected' : '' }}>{{ $b }}</option>
          @endforeach
                </select>
              </div>
              <div>
                <label class="block text-sm font-semibold mb-1">Cabang</label>
                <select name="cabang" class="w-full border rounded px-3 py-2" required>
                  @foreach ($opsiCabang as $c)
            <option value="{{ $c }}" {{ old('cabang', $guru->cabang) == $c ? 'selected' : '' }}>{{ $c }}</option>
          @endforeach
                </select>
              </div>
            </div>

            <div class="flex gap-2">
              <a href="{{ route('dashboard') }}">
                <button type="button" class="px-4 py-2 rounded bg-gray-200">Kembali</button>
              </a>
              <button type="submit" class="px-4 py-2 rounded bg-[#A4E4B3] font-semibold">Simpan Perubahan</button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>

  <script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebarBtn');

    if (toggleBtn) {
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
    }
  </script>
</body>

</html>