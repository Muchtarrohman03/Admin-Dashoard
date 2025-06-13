<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }
    public function admin(){
        $users = User::paginate(10);
        return view('users.admin-user', compact('users'));
    }
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'id_karyawan' => 'required|string|max:255|unique:users,id_karyawan',
            'name'        => 'required|string|max:255',
            'email'       => 'required|string|email|max:255|unique:users,email',
            'password'    => 'required|string|min:6',
            'role'        => 'required|exists:roles,name',
        ]);

        // Simpan user baru
        $user = User::create([
            'id_karyawan' => $request->id_karyawan,
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
        ]);

        // Assign role dari Spatie
        $user->assignRole($request->role);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('admin.users')->with('success', 'Produk berhasil ditambahkan.');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_karyawan' => 'required|string|max:255|unique:users,id_karyawan,' . $id,
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255|unique:users,email,' . $id,
            'role'        => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($id);
        $user->id_karyawan = $request->id_karyawan;
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Sync role
        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users')->with('success', 'User berhasil diperbarui.');
    }


}
