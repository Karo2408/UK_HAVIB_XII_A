<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Penjualan;
use App\Pelanggan;
use App\Produk;
use App\DetailPenjualan;
use Barryvdh\DomPDF\Facade\Pdf;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::with(['pelanggan', 'user', 'detailPenjualan.produk'])
            ->orderBy('PenjualanID', 'desc')
            ->get();

        return view('penjualan.index', compact('penjualan'));
    }

    public function create()
    {
        $produk = Produk::where('Stok', '>', 0)->get();
        $pelanggan = Pelanggan::all();
        return view('penjualan.create', compact('produk', 'pelanggan'));
    }
        
    public function store(Request $request)
    {
        $request->validate([
            'TanggalPenjualan' => 'required|date',
            'ProdukID'         => 'required|array',
            'ProdukID.*'       => 'exists:produk,ProdukID',
            'JumlahProduk'     => 'required|array',
            'JumlahProduk.*'   => 'integer|min:1',
            'Metode'           => 'required|in:cash,transfer,debit',
            'JumlahBayar'      => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $penjualan = Penjualan::create([
                'TanggalPenjualan' => $request->TanggalPenjualan,
                'PelangganID'      => $request->PelangganID,
                'TotalHarga'       => 0,
                'TotalDiskon'      => 0,    
                'UserID'           => 1,
                'Metode'           => $request->Metode,
                'Status'           => 'selesai',
            ]);

            $total = 0;
            $totalDiskon = 0;
            $isMember = !empty($request->PelangganID); // true kalau pelanggan, false kalau umum

            foreach ($request->ProdukID as $i => $produkId) {
                $produk   = Produk::findOrFail($produkId);
                $jumlah   = $request->JumlahProduk[$i];
                $harga    = $produk->Harga;
                $subtotal = $harga * $jumlah;

                // 💡 Diskon 5% hanya untuk pelanggan yang beli >= 5 item
                $diskon = ($isMember && $jumlah >= 5) ? $subtotal * 0.05 : 0;

                $total       += $subtotal - $diskon;
                $totalDiskon += $diskon;

                DetailPenjualan::create([
                    'PenjualanID'  => $penjualan->PenjualanID,
                    'ProdukID'     => $produk->ProdukID,
                    'JumlahProduk' => $jumlah,
                    'Harga'        => $harga,
                    'Subtotal'     => $subtotal,
                    'Diskon'       => $diskon,
                ]);

                $produk->decrement('Stok', $jumlah);
            }

            // 🔥 Validasi jumlah bayar
            $jumlahBayar = $request->JumlahBayar ?? 0;
            $kembalian   = 0;

            if ($request->Metode === 'cash') {
                if ($jumlahBayar < $total) {
                    DB::rollBack();
                    return back()
                        ->withInput()
                        ->with('error', 'Jumlah bayar kurang dari total belanja!');
                }
                $kembalian = $jumlahBayar - $total;
            } else {
                // metode selain cash otomatis harus sesuai total
                $jumlahBayar = $total;
            }

            $penjualan->update([
                'TotalHarga'  => $total,
                'TotalDiskon' => $totalDiskon,
                'JumlahBayar' => $jumlahBayar,
                'Kembalian'   => $kembalian,
            ]);

            DB::commit();
            return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $penjualan = Penjualan::with(['pelanggan', 'user', 'detailPenjualan.produk'])->findOrFail($id);
        return view('penjualan.show', compact('penjualan'));
    }
    
    public function cetak($id)
    {
        $penjualan = Penjualan::with('detailPenjualan.produk')->findOrFail($id);
        $pdf = Pdf::loadView('penjualan.struk', compact('penjualan'))
            ->setPaper([0, 0, 226.77, 600], 'portrait');
        return $pdf->stream('struk-' . $penjualan->PenjualanID . '.pdf');
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $penjualan = Penjualan::findOrFail($id);

            // Hapus detail dulu
            DetailPenjualan::where('PenjualanID', $penjualan->PenjualanID)->delete();

            // Hapus penjualan
            $penjualan->delete();

            DB::commit();
            return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal hapus: ' . $e->getMessage());
        }
    }
}
