<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>RTQ Al-Yusra | Daftar Santri</title>
    <link rel="shortcut icon" href="{{ asset('img/image/logortq.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gy-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 240px;
            height: 100%;
            background-color: white;
            z-index: 50;
            padding: 1rem;
            transition: transform 0.3s ease;
            overflow-y: auto;
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
                transform: translateX(-100%);
            }

            .gy-sidebar.active {
                transform: translateX(0);
            }

            .hamburger {
                display: inline-flex;
                align-items: center;
                padding: 0.5rem;
                background-color: white;
                border-radius: 0.25rem;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                z-index: 60;
            }

            .main {
                margin-left: 0;
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
                    <img src="{{ asset('img/image/akun.png') }}" alt="Foto Admin" class="w-10 h-10 rounded-full">
                    <strong>Guru</strong>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="background: none; border: none; cursor: pointer;">
                        <img src="{{ asset('img/image/logout.png') }}" alt="Logout" class="w-4 h-4">
                    </button>
                </form>
            </div>
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('guru.kehadiranG.index') }}">Kehadiran</a>
            <a href="{{ route('guru.hafalansantri.index') }}" class="active">Hafalan Santri</a>
            <a href="{{ route('password.editGuru') }}">Ubah Password</a>
        </div>

        <!-- Main Content -->
        <div class="main flex-1">
            <div class="gy-topbar bg-white flex justify-between items-center p-4 shadow">
                <div class="flex items-center gap-4">
                    <button class="hamburger" id="toggleSidebarBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h1 class="text-xl font-bold">Daftar Santri</h1>
                </div>
                <img src="{{ asset('img/image/logortq.png') }}" alt="Logo" class="h-20 bg-white p-2 rounded" />
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

            <div class="ka-form-container p-4">
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-2 py-1">No</th>
                            <th class="border border-gray-300 px-2 py-1">Nama Santri</th>
                            <th class="border border-gray-300 px-2 py-1">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($santri as $index => $s)
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">{{ $index + 1 }}</td>
                                <td class="border border-gray-300 px-2 py-1">{{ $s->nama_santri }}</td>
                                <td class="border border-gray-300 px-2 py-1">
                                    <a href="{{ route('guru.hafalansantri.detail', $s->kelas) }}"
                                        class="bg-blue-500 text-white px-2 py-1 rounded">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-gray-500 py-2">Tidak ada santri</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    <a href="{{ route('guru.hafalansantri.index') }}">
                        <button class="bg-gray-300 px-4 py-2 rounded">Kembali</button>
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