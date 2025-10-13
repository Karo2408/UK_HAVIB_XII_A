<?php

namespace App\Http\Controllers;

use App\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::all();
        return view('pelanggan.index', compact('pelanggan'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'NamaPelanggan' => 'required|string|max:20',
            'Alamat' => 'nullable|string',
            'NomorTelepon' => 'nullable|string|max:15',
        ]);

        Pelanggan::create([
            'NamaPelanggan' => $request->NamaPelanggan,
            'Alamat' => $request->Alamat,
            'NomorTelepon' => $request->NomorTelepon, // pastikan ini ada
        ]);

        return redirect()->route('pelanggan.index')->with('success','Pelanggan berhasil ditambah');
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'NamaPelanggan' => 'required|max:100',
            'Alamat' => 'nullable|max:255',
            'NomorTelepon' => 'nullable|max:20',
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update($request->all());

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus');
    }
}
