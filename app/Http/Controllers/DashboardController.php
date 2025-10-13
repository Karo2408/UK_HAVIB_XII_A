<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produk;
use App\Penjualan;
use App\UserModel; 
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->input('tahun', Carbon::now()->year);

        // Total data
        $totalProduk = Produk::count();
        $totalPenjualan = Penjualan::count();
        $totalUser = UserModel::count(); 
        $totalPemasukan = Penjualan::whereYear('TanggalPenjualan', $tahun)->sum('TotalHarga');

        // Grafik penjualan bulanan (isi 0 kalau gak ada data)
        $chartData = [];
        $chartLabels = range(1, 12); // bulan 1-12

        foreach ($chartLabels as $bulan) {
            $total = Penjualan::whereYear('TanggalPenjualan', $tahun)
                ->whereMonth('TanggalPenjualan', $bulan)
                ->sum('TotalHarga');
            $chartData[] = $total;
        }

        return view('dashboard.index', compact(
            'totalProduk',
            'totalPenjualan',
            'totalUser',
            'totalPemasukan',
            'chartLabels',
            'chartData',
            'tahun'
        ));
    }
}
