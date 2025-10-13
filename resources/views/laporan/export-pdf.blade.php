```html
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 11px; 
            margin: 15px; 
            color: #333; 
        }
        header { 
            text-align: center; 
            margin-bottom: 15px; 
        }
        header h2 { 
            margin: 2px 0; 
            font-size: 16px; 
            color: #1a7f37; /* hijau tua */
        }
        header p { 
            margin: 2px 0; 
            font-size: 11px; 
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
            font-size: 10px; 
        }
        th, td { 
            border: 1px solid #444; 
            padding: 4px 6px; 
            vertical-align: top; 
        }
        th { 
            background: #1a7f37; /* hijau tua */
            color: #fff; 
            text-align: center; 
            font-weight: bold; 
        }
        tr:nth-child(even) { 
            background: #f3fdf5; /* hijau muda */
        }
        tfoot td { 
            font-weight: bold; 
            text-align: right; 
            background: #e0f5e8; /* hijau soft */
        }

        .right { text-align: right; }
        .center { text-align: center; }
    </style>
</head>
<body>

<header>
    <h2>Laporan Penjualan SS Mart</h2>
    <p>
        Periode: {{ \Carbon\Carbon::parse($tanggalFilter['start'])->format('d-m-Y') }}
        s/d {{ \Carbon\Carbon::parse($tanggalFilter['end'])->format('d-m-Y') }}
    </p>
</header>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>ID Transaksi</th>
            <th>Tanggal</th>
            <th>Produk</th>
            <th>Diskon</th>
            <th>Pelanggan</th>
            <th>Kasir</th>
            <th>Total Harga</th>
        </tr>
    </thead>
    <tbody>
        @php $totalAll = 0; @endphp
        @foreach($penjualan as $p)
            @php
                $totalDiskon = 0;
                foreach($p->detailPenjualan as $d) {
                    $totalDiskon += $d->Diskon ?? 0;
                }
            @endphp
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td class="center">{{ $p->PenjualanID }}</td>
                <td class="center">{{ \Carbon\Carbon::parse($p->TanggalPenjualan)->format('d-m-Y H:i') }}</td>
                <td>
                    @foreach($p->detailPenjualan as $d)
                        - {{ $d->produk->NamaProduk ?? '-' }} (x{{ $d->JumlahProduk }}),
                        Rp {{ number_format($d->Harga,0,',','.') }}
                        <br>
                    @endforeach
                </td>
                <td class="right">Rp {{ number_format($totalDiskon,0,',','.') }}</td>
                <td>{{ $p->pelanggan->NamaPelanggan ?? 'Umum' }}</td>
                <td>{{ $p->user->Nama ?? '-' }}</td>
                <td class="right">Rp {{ number_format($p->TotalHarga,0,',','.') }}</td>
            </tr>
            @php $totalAll += $p->TotalHarga; @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7" class="center">Total Penjualan</td>
            <td class="right">Rp {{ number_format($totalAll,0,',','.') }}</td>
        </tr>
    </tfoot>
</table>

<p style="font-size:10px; text-align:right; margin-top:15px;">
    Dicetak: {{ $jamCetak }}
</p>

</body>
</html>
