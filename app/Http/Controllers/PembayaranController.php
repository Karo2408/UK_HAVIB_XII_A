<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pembayaran;
use App\Penjualan;

class PembayaranController extends Controller
{
    // Tampilkan semua pembayaran
    public function index()
    {
        $pembayaran = Pembayaran::with('penjualan')->get();
        return view('pembayaran.index', compact('pembayaran'));
    }

    public function store(Request $request)
    {   
        $request->validate([
            'PenjualanID' => 'required|exists:penjualan,PenjualanID',
            'Metode' => 'required|in:cash,debit,transfer',
            'JumlahBayar' => 'required|numeric',
        ]);

        // Hitung kembalian
        $penjualan = Penjualan::findOrFail($request->PenjualanID);
        $kembalian = $request->JumlahBayar - $penjualan->TotalHarga;

        Pembayaran::create([
            'PenjualanID' => $request->PenjualanID,
            'Metode' => $request->Metode,
            'JumlahBayar' => $request->JumlahBayar,
            'Kembalian' => $kembalian > 0 ? $kembalian : 0,
            'Status' => 'selesai', // langsung selesai
        ]);

        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil ditambahkan');
    }


    // Edit pembayaran (pilih metode & jumlah bayar)
    public function edit($id)
    {
        $pembayaran = Pembayaran::with('penjualan')->findOrFail($id);
        return view('pembayaran.edit', compact('pembayaran'));
    }

    // Update pembayaran
    public function update(Request $request, $id)
    {
        $request->validate([
            'Metode' => 'required|in:cash,debit,transfer',
            'JumlahBayar' => 'required|numeric|min:0',
        ]);

        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->JumlahBayar = $request->JumlahBayar;
        $pembayaran->Metode = $request->Metode;
        $pembayaran->Kembalian = max(0, $request->JumlahBayar - $pembayaran->penjualan->TotalHarga);
        $pembayaran->Status = $request->JumlahBayar >= $pembayaran->penjualan->TotalHarga ? 'Lunas' : 'Pending';
        $pembayaran->save();

        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil diperbarui!');
    }

    // Hapus pembayaran (opsional)
    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->delete();
        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil dihapus!');
    }
}
