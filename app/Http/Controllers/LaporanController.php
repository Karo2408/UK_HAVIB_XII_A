<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    // Halaman laporan (browser)
    public function index(Request $request)
    {
        $query = Penjualan::with(['pelanggan','user','detailPenjualan.produk']);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('TanggalPenjualan', [$request->start_date, $request->end_date]);
        }

        $penjualan = $query->get();
        return view('laporan.index', compact('penjualan'));
    }

    // Export PDF
    public function exportPdf(Request $request)
    {
        $query = Penjualan::with(['pelanggan','user','detailPenjualan.produk']);

        // Filter tanggal kalau ada
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('TanggalPenjualan', [$request->start_date, $request->end_date]);
            $tanggalFilter = [
                'start' => $request->start_date,
                'end'   => $request->end_date
            ];
        } else {
            $first = Penjualan::orderBy('TanggalPenjualan', 'asc')->first();
            $last  = Penjualan::orderBy('TanggalPenjualan', 'desc')->first();
            $start = $first ? $first->TanggalPenjualan : now();
            $end   = $last  ? $last->TanggalPenjualan  : now();

            $query->whereBetween('TanggalPenjualan', [$start, $end]);
            $tanggalFilter = [
                'start' => $start,
                'end'   => $end
            ];
        }

        $penjualan = $query->get();

        // Tanggal + jam cetak
        $jamCetak = Carbon::now('Asia/Jakarta')->format('d-m-Y H:i:s');

        $pdf = Pdf::loadView('laporan.export-pdf', compact('penjualan','jamCetak','tanggalFilter'))
                ->setPaper('a4','portrait');

        return $pdf->download('laporan-penjualan.pdf');
    }
}
