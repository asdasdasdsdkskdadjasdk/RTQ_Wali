<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruProfileController extends Controller
{
    public function edit()
    {
        $userId = Auth::id();

        $guru = Guru::where('user_id', $userId)->first();

        if (!$guru) {
            // Jika record guru belum ada, buatkan dari data user untuk pertama kali
            $user = User::findOrFail($userId);
            $guru = Guru::create([
                'user_id'        => $user->id,
                'nama_guru'      => $user->name,
                'email'          => $user->email,
                'tempat_lahir'   => '',
                'tanggal_lahir'  => now()->toDateString(),
                'jenis_kelamin'  => 'L',
                'pend_akhir'     => 'SMA/Sederajat',
                'gol_dar'        => 'O',
                'mk'             => 'Si',
                'bagian'         => 'Guru Kelas',
                'cabang'         => 'Sukajadi',
                'alamat'         => '',
                'no_hp'          => '',
                'status_menikah' => 'Belum Menikah',
                'jlh_hafalan'    => 0,
            ]);
        }

        // Opsi dropdown (harus sama dengan aturan validasi & view admin)
        $opsiPendidikan = ['SD','SMP/Sederajat','SMA/Sederajat','S1','S2','S3'];
        $opsiGolDar     = ['A','AB','B','O'];
        $opsiMk         = ['Si','Se','Ti','Te','In','Fi','Fe','Ii','Ie'];
        $opsiStatus     = ['Menikah','Belum Menikah'];
        $opsiBagian     = ['Admin','Yayasan','Guru Kelas'];
        $opsiCabang     = ['Sukajadi','Rumbai','Gobah 1','Gobah 2','Rawa Bening'];

        return view('guru.profile.edit', compact(
            'guru',
            'opsiPendidikan',
            'opsiGolDar',
            'opsiMk',
            'opsiStatus',
            'opsiBagian',
            'opsiCabang'
        ));
    }

    public function update(Request $request)
    {
        $userId = Auth::id();
        $guru = Guru::where('user_id', $userId)->firstOrFail();

        // Validasi—selaraskan dengan aturan pada Admin, tapi tanpa user_id (tidak boleh ganti user)
        $validated = $request->validate([
            'tempat_lahir'   => 'required|string|max:255',
            'tanggal_lahir'  => 'required|date',
            'alamat'         => 'required|string|max:500',
            'no_hp'          => 'required|string|max:20',
            'jlh_hafalan'    => 'required|integer|min:0',
            'jenis_kelamin'  => 'required|in:P,L',
            'pend_akhir'     => 'required|in:SD,SMP/Sederajat,SMA/Sederajat,S1,S2,S3',
            'gol_dar'        => 'required|in:A,AB,B,O',
            'mk'             => 'required|in:Si,Se,Ti,Te,In,Fi,Fe,Ii,Ie',
            'status_menikah' => 'required|in:Menikah,Belum Menikah',
            'bagian'         => 'required|in:Admin,Yayasan,Guru Kelas',
            'cabang'         => 'required|string|max:50',
        ]);

        // Nama & email mengikuti akun user (opsional bisa ditampilkan readonly di form)
        $user = User::findOrFail($userId);

        $dataUpdate = array_merge($validated, [
            'nama_guru' => $user->name,
            'email'     => $user->email,
        ]);

        $guru->update($dataUpdate);

        return redirect()->route('guru.profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}
