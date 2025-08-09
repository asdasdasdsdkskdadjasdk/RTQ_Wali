<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    public function editAdmin()
    {
        return view('admin.ubahPassword.change-password');
    }
    public function editGuru()
    {
        return view('guru.ubahPassword.change-password');
    }
    public function editYayasan()
    {
        return view('yayasan.ubahPassword.change-password');
    }
    

    public function update(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Cek apakah password lama cocok
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama tidak cocok.');
        }

        // Simpan password baru
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui.');
    }
}
