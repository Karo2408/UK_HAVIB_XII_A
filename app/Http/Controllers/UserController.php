<?php

namespace App\Http\Controllers;

use App\UserModel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = UserModel::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Nama' => 'required|max:50',
            'Email' => 'required|email|unique:user,Email',
            'Password' => 'required|min:6',
            'Role' => 'required|in:admin,kasir'
        ]);

        UserModel::create([
            'Nama' => $request->Nama,
            'Email' => $request->Email,
            'Password' => bcrypt($request->Password),
            'Role' => $request->Role,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = UserModel::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = UserModel::findOrFail($id);

        $request->validate([
            'Nama' => 'required|max:50',
            'Email' => 'required|email|unique:user,Email,' . $id . ',UserID',
            'Role' => 'required|in:admin,kasir'
        ]);

        $data = $request->only(['Nama', 'Email', 'Role']);
        if ($request->filled('Password')) {
            $data['Password'] = bcrypt($request->Password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = UserModel::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
}
