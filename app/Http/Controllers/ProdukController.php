<?php

namespace App\Http\Controllers;

use App\Produk;
use App\Kategori;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::with('kategori')->get();
        return view('produk.index', compact('produk'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('produk.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'NamaProduk' => 'required|max:100',
            'KategoriID' => 'required|exists:kategori,KategoriID',
            'Harga' => 'required|numeric',
            'Stok' => 'required|integer|min:0', // ✅ tidak bisa minus
            'Foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('Foto')) {
            $path = $request->file('Foto')->store('produk', 'public');
            $data['Foto'] = $path;
        }

        Produk::create($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategori = Kategori::all();
        return view('produk.edit', compact('produk', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'NamaProduk' => 'required|max:100',
            'KategoriID' => 'required|exists:kategori,KategoriID',
            'Harga' => 'required|numeric',
            'Stok' => 'required|integer|min:0', // ✅ tidak bisa minus
            'Foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('Foto')) {
            $path = $request->file('Foto')->store('produk', 'public');
            $data['Foto'] = $path;
        }

        $produk->update($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus');
    }
}
