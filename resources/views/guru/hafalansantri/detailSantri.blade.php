<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Detail Hafalan | {{ $santri->nama_santri }}</title>
    <link rel="shortcut icon" href="{{ asset('img/image/logortq.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gy-container { max-width: 1200px; margin: 0 auto; }
        .gy-card { border:1px solid #e5e7eb; border-radius:.75rem; background:#fff; }
        .gy-card h3 { font-weight:700; }
        .gy-table th, .gy-table td { border:1px solid #e5e7eb; padding:.5rem .625rem; }
        .gy-table th { background:#f3f4f6; font-weight:600; text-align:left; }
        @media (max-width:768px){
            .gy-head { flex-direction:column; align-items:flex-start; gap:.75rem; }
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen">
    <div class="gy-container px-4 md:px-6 py-6 md:py-10">
        <!-- Header -->
        <div class="gy-head flex items-center justify-between">
            <div class="flex items-center gap-4">
                <img src="{{ asset('img/image/logortq.png') }}" class="h-14" alt="Logo">
                <div>
                    <div class="text-xl md:text-2xl font-bold">Detail Hafalan Santri</div>
                    <div class="text-slate-600">Nama: <span class="font-semibold">{{ $santri->nama_santri }}</span></div>
                    @if(!empty($santri->kelas))
                        <div class="text-slate-600">Kelas: <span class="font-semibold">{{ $santri->kelas }}</span></div>
                    @endif
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ url()->previous() }}"
                   class="px-4 py-2 rounded-lg border bg-white hover:bg-slate-50">Kembali</a>
            </div>
        </div>

        <!-- Info jika kosong -->
        @if($groupedByJuz->isEmpty())
            <div class="mt-6 gy-card p-6 text-center text-slate-600">
                Belum ada data hafalan untuk santri ini.
            </div>
        @endif

        <!-- Loop per JUZ -->
        <div class="mt-6 space-y-6">
            @foreach($groupedByJuz->sortKeys() as $juz => $items)
                <div class="gy-card p-4 md:p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg md:text-xl">Juz {{ $juz }}</h3>
                        <div class="text-sm text-slate-500">
                            Total Catatan: {{ $items->count() }}
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full gy-table">
                            <thead>
                                <tr>
                                    <th class="w-14">No</th>
                                    <th>Tanggal</th>
                                    <th>Surah</th>
                                    <th class="w-20">Juz</th>
                                    <th class="w-28">Ayat Awal</th>
                                    <th class="w-28">Ayat Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $i => $row)
                                    <tr class="hover:bg-slate-50">
                                        <td>{{ $i + 1 }}</td>
                                        <td>
                                            @php
                                                $tgl = \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y');
                                            @endphp
                                            {{ $tgl }}
                                        </td>
                                        <td>{{ $row->surah }}</td>
                                        <td>{{ $row->juz }}</td>
                                        <td>{{ $row->ayat_awal }}</td>
                                        <td>{{ $row->ayat_akhir }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @php
                        $minAyat = $items->min('ayat_awal');
                        $maxAyat = $items->max('ayat_akhir');
                        $tanggalTerakhir = optional($items->sortByDesc('tanggal')->first())->tanggal;
                    @endphp
                    <div class="mt-3 text-sm text-slate-600">
                        <span>Rentang ayat tersimpan: {{ $minAyat }} – {{ $maxAyat }}</span>
                        @if($tanggalTerakhir)
                            <span class="mx-2">•</span>
                            <span>Pencatatan terakhir: {{ \Carbon\Carbon::parse($tanggalTerakhir)->format('d/m/Y') }}</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
