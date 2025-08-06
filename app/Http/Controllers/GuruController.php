<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10);

        $query = Guru::query();

        if ($search) {
            $query->where('nama_guru', 'like', "%$search%")
                ->orWhere('tempat_lahir', 'like', "%$search%")
                ->orWhere('alamat', 'like', "%$search%")
                ->orWhere('bagian', 'like', "%$search%")
                ->orWhere('cabang', 'like', "%$search%");
        }

        $gurus = $query->latest()->paginate($perPage)->withQueryString();

        return view('admin.dataguru.index', compact('gurus', 'search', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::role('guru')->doesntHave('guru')->get();

        return view('admin.dataguru.tambah', compact('users'));
    }


    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:500',
            'no_hp' => 'required|string|max:20',
            'jlh_hafalan' => 'required|integer|min:0',
            'jenis_kelamin' => 'required|in:P,L',
            'pend_akhir' => 'required|string|max:20',
            'gol_dar' => 'required|string|max:2',
            'mk' => 'required|string|max:2',
            'status_menikah' => 'required|string|max:20',
            'bagian' => 'required|string|max:50',
            'cabang' => 'required|string|max:50',
        ]);

        $user = User::findOrFail($validatedData['user_id']);

        $guruData = array_merge($validatedData, [
            'nama_guru' => $user->name,
            'email' => $user->email
        ]);

        Guru::create($guruData);

        return redirect()->route('admin.dataguru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $guru = Guru::findOrFail($id);
        return view('admin.dataguru.detail', compact('guru'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $guru = Guru::findOrFail($id);

        $users = User::role('guru')
            ->where(function ($query) use ($guru) {
                $query->doesntHave('guru')
                    ->orWhere('id', $guru->user_id);
            })
            ->get();

        return view('admin.dataguru.edit', compact('guru', 'users'));
    }

    public function update(Request $request, string $id)
    {
        $guru = Guru::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:500',
            'no_hp' => 'required|string|max:20',
            'jlh_hafalan' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:P,L',
            'pend_akhir' => 'required|string|max:20',
            'gol_dar' => 'required|in:A,AB,B,O',
            'mk' => 'required|in:Si,Se,Ti,Te,In,Fi,Fe,Ii,Ie',
            'status_menikah' => 'required|in:Menikah,Belum Menikah',
            'bagian' => 'required|in:Admin,Yayasan,Guru Kelas',
            'cabang' => 'required|string|max:50',
        ]);

        $user = User::findOrFail($validated['user_id']);

        $guruData = array_merge($validated, [
            'nama_guru' => $user->name,
            'email' => $user->email,
        ]);

        $guru->update($guruData);

        return redirect()->route('admin.dataguru.index')->with('success', 'Data guru berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();

        return redirect()->route('admin.dataguru.index')->with('success', 'Data guru berhasil dihapus.');
    }
}
