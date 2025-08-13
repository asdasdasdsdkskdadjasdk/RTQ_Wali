`
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>RTQ Al-Yusra | Kehadiran</title>
    <link rel="shortcut icon" href="{{ asset('img/image/logortq.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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

        /* tombol kecil */
        .btn-xs {
            padding: 0.25rem 0.5rem;
            font-size: 12px;
            border-radius: 6px;
        }

        .btn-cancel {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .btn-cancel:hover {
            background: #fecaca;
        }

        .btn-edit {
            background: #e0f2fe;
            color: #075985;
            border: 1px solid #bae6fd;
        }

        .btn-edit:hover {
            background: #bae6fd;
        }

        .disabled {
            pointer-events: none;
            opacity: .5;
        }

        /* Modal */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .4);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 80;
        }

        .modal-backdrop.show {
            display: flex;
        }

        .modal-card {
            background: white;
            width: 95%;
            max-width: 520px;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .2);
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .modal-title {
            font-weight: 700;
            font-size: 18px;
        }

        .modal-close {
            background: transparent;
            border: none;
            font-size: 20px;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 12px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .form-control,
        .form-select {
            width: 100%;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 8px 10px;
        }

        .help {
            font-size: 12px;
            color: #6b7280;
        }

        .actions {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
            margin-top: 12px;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 12px;
        }

        .btn-outline {
            background: white;
            color: #111827;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 8px 12px;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="container flex">
        <!-- Sidebar -->
        <div class="gy-sidebar" id="sidebar">
            <div class="sidebar-header flex justify-between items-center mb-4">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('img/image/akun.png') }}" alt="Foto Admin"
                        style="width: 40px; height: 40px; border-radius: 50%;">
                    <strong>{{ Auth::user()->guru->nama_guru ?? Auth::user()->name }}</strong>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="background: none; border: none; cursor: pointer;">
                        <img src="{{ asset('img/image/logout.png') }}" alt="Logout" style="width: 18px; height: 18px;">
                    </button>
                </form>
            </div>

            <a href="{{ route('dashboard') }}">
                <i class="fas fa-home mr-2"></i>Dashboard
            </a>
            <a href="{{ route('guru.profile.edit') }}">
                <i class="fas fa-user mr-2"></i>Profil Saya
            </a>
            <a href="{{ route('guru.kehadiranG.index') }}" class="active">
                <i class="fas fa-check-circle mr-2"></i>Kehadiran
            </a>
            <a href="{{ route('guru.hafalansantri.index') }}">
                <i class="fas fa-book mr-2"></i>Hafalan Santri
            </a>
            <a href="{{ route('password.editGuru') }}">
                <i class="fas fa-key mr-2"></i>Ubah Password
            </a>
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
                    <h1 class="text-xl font-bold">Detail Kehadiran</h1>
                </div>
                <img src="{{ asset('img/image/logortq.png') }}" alt="Logo" class="h-20 bg-white p-2 rounded" />
            </div>

            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded mb-4 alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 text-red-700 p-4 rounded mb-4 alert-error">{{ session('error') }}</div>
            @endif

            <div class="ka-form-container p-4">
                <div class="dkk-form-row">
                    <label>Pilih Tanggal</label>
                    <div class="dkk-form-item">
                        <input type="date" id="tanggalFilter" name="tanggalFilter" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
                <input type="hidden" id="periodeId" value="{{ $selectedPeriode }}">
                <div class="dkk-form-row">
                    <label>Pilih Kegiatan</label>
                    <div class="dkk-form-item">
                        <select id="kegiatanFilter" name="kegiatanFilter">
                            <option value="">-- Pilih Kegiatan --</option>
                            @foreach($listKegiatan as $kegiatan)
                                <option value="{{ $kegiatan }}">{{ $kegiatan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="dkk-form-row">
                    <label>Dokumentasi</label>
                    <div class="dkk-form-item" id="dokumentasiContainer">
                        <p id="noDokumentasiMessage" style="display: none;">Tidak ada dokumentasi untuk tanggal ini.</p>
                    </div>
                </div>

                <div id="kehadiranTableContainer">
                    <div class="loading-indicator" id="loadingIndicator">Memuat data...</div>
                    <div class="alert alert-info" id="noDataMessage" style="display: none;">Tidak ada data kehadiran
                        untuk tanggal ini.</div>
                    <table id="kehadiranTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Santri</th>
                                <th>Status Kehadiran</th>
                                <th>Bukti</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <div id="paginationContainer" class="box-pagination-left"></div>
                </div>

                <!-- Batalkan semua pada tanggal -->
                <div class="mt-4">
                    <button id="btnCancelAll" class="btn-xs btn-cancel">Batalkan Semua Entri Tanggal Ini</button>
                </div>

                <div class="gki-button-group mt-6">
                    <a href="{{ route('guru.kehadiranG.index') }}">
                        <button class="gki-input-btn">Kembali</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT -->
    <div id="editModal" class="modal-backdrop">
        <div class="modal-card">
            <div class="modal-header">
                <div class="modal-title">Edit Kehadiran</div>
                <button type="button" class="modal-close" id="btnCloseModal">&times;</button>
            </div>
            <form id="editForm">
                <input type="hidden" id="editId">
                <div class="form-group">
                    <label class="form-label">Nama Santri</label>
                    <input type="text" id="editNamaSantri" class="form-control" disabled>
                </div>
                <div class="form-group">
                    <label for="editStatus" class="form-label">Status Kehadiran</label>
                    <select id="editStatus" class="form-select" required>
                        <option value="Hadir">Hadir</option>
                        <option value="Alpha">Alpha</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Bukti Saat Ini</label>
                    <div id="editBuktiNow" class="help">-</div>
                </div>
                <div class="form-group">
                    <label for="editBukti" class="form-label">Ganti / Tambah Bukti (opsional)</label>
                    <input type="file" id="editBukti" class="form-control" accept=".jpg,.jpeg,.png,.jfif">
                    <div class="help">Ukuran maks 2MB. Kosongkan jika tidak ingin mengubah.</div>
                </div>
                <div class="form-group">
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" id="hapusBukti">
                        <span>Hapus bukti lama</span>
                    </label>
                </div>
                <div class="actions">
                    <button type="button" class="btn-outline" id="btnCancelModal">Batal</button>
                    <button type="submit" class="btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebarBtn');

        toggleBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.toggle('active');
            if (sidebar.classList.contains('active')) {
                toggleBtn.style.display = 'none';
            } else {
                toggleBtn.style.display = 'inline-flex';
            }
        });
        document.addEventListener('click', function (e) {
            if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                sidebar.classList.remove('active');
                toggleBtn.style.display = 'inline-flex';
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            const tanggalFilterInput = document.getElementById('tanggalFilter');
            const kegiatanFilterInput = document.getElementById('kegiatanFilter');
            const kehadiranTableBody = document.querySelector('#kehadiranTable tbody');
            const loadingIndicator = document.getElementById('loadingIndicator');
            const noDataMessage = document.getElementById('noDataMessage');
            const dokumentasiContainer = document.getElementById('dokumentasiContainer');
            const noDokumentasiMessage = document.getElementById('noDokumentasiMessage');
            const btnCancelAll = document.getElementById('btnCancelAll');

            const kelas = "{{ $kelas }}";
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            function loadKehadiranData(tanggal, kegiatan = '') {
                kehadiranTableBody.innerHTML = '';
                noDataMessage.style.display = 'none';
                loadingIndicator.style.display = 'block';

                const periodeId = document.getElementById('periodeId')?.value ?? '';

                const params = new URLSearchParams({
                    kegiatan: kegiatan,
                    periode_id: periodeId
                });
                const url = `/guru/detailKehadiran/${kelas}/${tanggal}?${params}`;

                fetch(url)
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok ' + response.statusText);
                        return response.json();
                    })
                    .then(data => {
                        loadingIndicator.style.display = 'none';
                        if (Array.isArray(data) && data.length > 0) {
                            paginateData(data, 10);
                        } else {
                            noDataMessage.style.display = 'block';
                        }
                    })
                    .catch(error => {
                        loadingIndicator.style.display = 'none';
                        console.error('Ada masalah dengan operasi fetch:', error);
                        kehadiranTableBody.innerHTML = `<tr><td colspan="5" style="color: red; text-align: center;">Gagal memuat data kehadiran.</td></tr>`;
                    });
            }

            function actionButton(id) {
                return `<button class="btn-xs btn-edit" data-id="${id}" onclick="openEdit(${id})">Edit</button>`;
            }

            function paginateData(data, itemsPerPage = 10) {
                const paginationContainer = document.getElementById('paginationContainer');
                const kehadiranTableBody = document.querySelector('#kehadiranTable tbody');

                let currentPage = 1;
                const totalPages = Math.ceil(data.length / itemsPerPage);

                function renderPage(page) {
                    kehadiranTableBody.innerHTML = '';
                    const start = (page - 1) * itemsPerPage;
                    const end = start + itemsPerPage;
                    const paginatedItems = data.slice(start, end);

                    paginatedItems.forEach((kehadiran, index) => {
                        const buktiHtml = kehadiran.bukti
                            ? `<a href="/storage/${kehadiran.bukti}" target="_blank" style="color: blue;">Lihat Bukti</a>`
                            : '-';

                        const row = `
                            <tr>
                                <td>${start + index + 1}</td>
                                <td>${kehadiran.santri ? (kehadiran.santri.nama_santri ?? '-') : '-'}</td>
                                <td>${kehadiran.status_kehadiran ?? '-'}</td>
                                <td>${buktiHtml}</td>
                                <td>${actionButton(kehadiran.id)}</td>
                            </tr>
                        `;
                        kehadiranTableBody.insertAdjacentHTML('beforeend', row);
                    });

                    renderPaginationControls();
                }

                function renderPaginationControls() {
                    paginationContainer.innerHTML = '';

                    const prevBtn = document.createElement('a');
                    prevBtn.textContent = '«';
                    prevBtn.href = '#';
                    prevBtn.className = 'page-box-small' + (currentPage === 1 ? ' disabled' : '');
                    prevBtn.addEventListener('click', function (e) {
                        e.preventDefault();
                        if (currentPage > 1) { currentPage--; renderPage(currentPage); }
                    });
                    paginationContainer.appendChild(prevBtn);

                    for (let i = 1; i <= totalPages; i++) {
                        const btn = document.createElement('a');
                        btn.textContent = i;
                        btn.href = '#';
                        btn.classList.add('page-box-small');
                        if (i === currentPage) btn.classList.add('active');

                        btn.addEventListener('click', function (e) {
                            e.preventDefault();
                            currentPage = i;
                            renderPage(currentPage);
                        });

                        paginationContainer.appendChild(btn);
                    }

                    const nextBtn = document.createElement('a');
                    nextBtn.textContent = '»';
                    nextBtn.href = '#';
                    nextBtn.className = 'page-box-small' + (currentPage === totalPages ? ' disabled' : '');
                    nextBtn.addEventListener('click', function (e) {
                        e.preventDefault();
                        if (currentPage < totalPages) { currentPage++; renderPage(currentPage); }
                    });
                    paginationContainer.appendChild(nextBtn);
                }

                renderPage(currentPage);
            }

            async function loadDokumentasi(selectedDate, kegiatan = '') {
                dokumentasiContainer.innerHTML = '';
                noDokumentasiMessage.style.display = 'none';

                if (!selectedDate) {
                    noDokumentasiMessage.textContent = 'Silakan pilih tanggal.';
                    noDokumentasiMessage.style.display = 'block';
                    return;
                }

                const periodeId = document.getElementById('periodeId')?.value ?? '';
                const url = `/guru/detailKehadiran/dokumentasi/${selectedDate}?kegiatan=${encodeURIComponent(kegiatan)}&periode_id=${periodeId}`;

                try {
                    const response = await fetch(url);
                    const data = await response.json();

                    if (data.success && data.dokumentasi.length > 0) {
                        const fileUrl = data.dokumentasi[0];
                        const linkWrapper = document.createElement('div');
                        linkWrapper.style.marginBottom = '10px';

                        const link = document.createElement('a');
                        link.href = fileUrl;
                        link.target = '_blank';
                        link.textContent = 'Lihat Dokumentasi';
                        link.style.color = '#007bff';
                        link.style.textDecoration = 'none';

                        linkWrapper.appendChild(link);
                        dokumentasiContainer.appendChild(linkWrapper);
                    } else {
                        noDokumentasiMessage.textContent = 'Tidak ada dokumentasi untuk tanggal ini.';
                        noDokumentasiMessage.style.display = 'block';
                    }
                } catch (error) {
                    console.error('Gagal memuat dokumentasi:', error);
                    dokumentasiContainer.innerHTML = '<p style="color: red;">Gagal memuat dokumentasi.</p>';
                }
            }

            // Trigger awal
            loadKehadiranData(tanggalFilterInput.value, kegiatanFilterInput.value);
            loadDokumentasi(tanggalFilterInput.value, kegiatanFilterInput.value);

            // Filter tanggal berubah
            tanggalFilterInput.addEventListener('change', function () {
                loadKehadiranData(this.value, kegiatanFilterInput.value);
                loadDokumentasi(this.value, kegiatanFilterInput.value);
            });

            // Filter kegiatan berubah
            kegiatanFilterInput.addEventListener('change', function () {
                loadKehadiranData(tanggalFilterInput.value, this.value);
                loadDokumentasi(tanggalFilterInput.value, this.value);
            });

            // Batalkan semua pada tanggal
            btnCancelAll.addEventListener('click', async function () {
                const tanggal = tanggalFilterInput.value;
                const kegiatan = kegiatanFilterInput.value;
                if (!tanggal) { alert('Pilih tanggal terlebih dahulu.'); return; }

                if (!confirm('Batalkan SEMUA entri kehadiran pada tanggal ini?')) return;

                try {
                    const res = await fetch(`{{ route('guru.detailKehadiran.cancelByDate') }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf
                        },
                        body: JSON.stringify({
                            _method: 'DELETE',
                            kelas: "{{ $kelas }}",
                            tanggal,
                            kegiatan
                        })
                    });
                    const data = await res.json();
                    if (data.success) {
                        alert(data.message || 'Berhasil dibatalkan.');
                        loadKehadiranData(tanggal, kegiatan);
                    } else {
                        alert(data.message || 'Gagal membatalkan.');
                    }
                } catch (e) {
                    console.error(e);
                    alert('Terjadi kesalahan jaringan.');
                }
            });

            // auto dismiss alert
            setTimeout(() => {
                const success = document.querySelector('.alert-success');
                const error = document.querySelector('.alert-error');
                if (success) { success.style.transition = 'opacity 0.5s'; success.style.opacity = '0'; setTimeout(() => success.remove(), 500); }
                if (error) { error.style.transition = 'opacity 0.5s'; error.style.opacity = '0'; setTimeout(() => error.remove(), 500); }
            }, 2000);
        });

        // ==== Modal Edit Logic ====
        const modal = document.getElementById('editModal');
        const btnCloseModal = document.getElementById('btnCloseModal');
        const btnCancelModal = document.getElementById('btnCancelModal');
        const editForm = document.getElementById('editForm');

        function showModal() { modal.classList.add('show'); }
        function hideModal() { modal.classList.remove('show'); editForm.reset(); document.getElementById('editBuktiNow').innerHTML = '-'; document.getElementById('hapusBukti').checked = false; }

        btnCloseModal.addEventListener('click', hideModal);
        btnCancelModal.addEventListener('click', hideModal);
        window.addEventListener('keydown', (e) => { if (e.key === 'Escape') { hideModal(); } });

        async function openEdit(id) {
            try {
                const res = await fetch(`/guru/detailKehadiran/item/${id}`, {
                    headers: { 'Accept': 'application/json' }
                });
                if (!res.ok) {
                    const text = await res.text();
                    throw new Error(`Gagal memuat data (HTTP ${res.status}). ${text.slice(0, 200)}`);
                }
                const data = await res.json();
                document.getElementById('editId').value = data.id;
                document.getElementById('editNamaSantri').value = data.santri?.nama_santri || '-';
                document.getElementById('editStatus').value = data.status_kehadiran || 'Hadir';

                const buktiNow = document.getElementById('editBuktiNow');
                if (data.bukti) {
                    buktiNow.innerHTML = `<a href="/storage/${data.bukti}" target="_blank" style="color:blue">Lihat Bukti</a>`;
                } else {
                    buktiNow.textContent = '-';
                }

                showModal();
            } catch (e) {
                console.error(e);
                alert('Tidak dapat memuat detail entri. Cek rute & auth.');
            }
        }
        window.openEdit = openEdit;

        editForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const id = document.getElementById('editId').value;
            const status = document.getElementById('editStatus').value;
            const hapusBukti = document.getElementById('hapusBukti').checked;
            const buktiFile = document.getElementById('editBukti').files[0] || null;

            const formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('status_kehadiran', status);
            formData.append('hapus_bukti', hapusBukti ? '1' : '0');
            if (buktiFile) formData.append('bukti', buktiFile);

            try {
                const res = await fetch(`/guru/detailKehadiran/item/${id}`, {
                    method: 'POST', // spoof PUT
                    headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                    body: formData
                });
                const contentType = res.headers.get('content-type') || '';
                if (!res.ok) {
                    const text = await res.text();
                    throw new Error(`Gagal simpan (HTTP ${res.status}). ${text.slice(0, 200)}`);
                }
                const data = contentType.includes('application/json') ? await res.json() : { success: true };

                if (data.success) {
                    hideModal();
                    // reload tabel sesuai filter aktif
                    const tanggal = document.getElementById('tanggalFilter').value;
                    const kegiatan = document.getElementById('kegiatanFilter').value;
                    // trigger reload
                    const evt = new Event('change');
                    document.getElementById('tanggalFilter').dispatchEvent(evt);
                    alert(data.message || 'Perubahan tersimpan.');
                } else {
                    alert(data.message || 'Gagal menyimpan perubahan.');
                }
            } catch (e) {
                console.error(e);
                alert('Terjadi kesalahan saat menyimpan perubahan.');
            }
        });
    </script>

</body>

</html>