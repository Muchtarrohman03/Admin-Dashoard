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
        $user = User::findOrFail($id);

        // Validasi
        $validated = $request->validate([
            'id_karyawan' => 'nullable|string|max:255|unique:users,id_karyawan,' . $id,
            'name'        => 'nullable|string|max:255',
            'email'       => 'nullable|email|max:255|unique:users,email,' . $id,
            'password'    => 'nullable|string|min:6',
            'role'        => 'required|exists:roles,name',
        ]);

        // Pertahankan nilai lama jika input tidak diberikan
        $validated['id_karyawan'] = $validated['id_karyawan'] ?? $user->id_karyawan;
        $validated['name'] = $validated['name'] ?? $user->name;
        $validated['email'] = $validated['email'] ?? $user->email;

        // Update field
        $user->id_karyawan = $validated['id_karyawan'];
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Update password jika diberikan
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Update role
        $user->syncRoles([$validated['role']]);

        return redirect()->route('admin.users')->with('success', 'User berhasil diperbarui.');
    }

    public function delete(){
        return view('users.partials.delete-user');
    }

    public function destroy(user $user){

        
        $user->delete();
         return redirect()->route('admin.users')->with('success', 'Data User Telah Dihapus!');
    }



}
