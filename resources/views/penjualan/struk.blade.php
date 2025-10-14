<style>
  body { font-family: monospace; font-size: 12px; margin:0; padding:0; }
  .center { text-align: center; }
  .line { border-top: 1px dashed #000; margin: 6px 0; }
  table { width: 100%; border-collapse: collapse; }
  td { padding: 2px 0; vertical-align: top; }
  .right-padding { padding-left: 20px; }
</style>

<div class="center">
  <h3>{{ \App\Setting::getValue('pos_name') }}</h3>
<p>{{ \App\Setting::getValue('store_address') }}</p>
<p>Telp: {{ \App\Setting::getValue('store_phone') }}</p>

</div>

<div class="line"></div>

<table style="width:100%; margin-bottom:5px;">
  <tr>
    <td style="width:80px;">Tanggal</td>
    <td style="width:10px;">:</td>
    <td>{{ \Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y H:i:s') }}</td>
  </tr>
  <tr>
    <td>Kasir</td>
    <td>:</td>
    <td>{{ $penjualan->user->Nama ?? '-' }}</td>
  </tr>
  <tr>
    <td>Pelanggan</td>
    <td>:</td>
    <td>{{ $penjualan->pelanggan->NamaPelanggan ?? 'Umum' }}</td>
  </tr>
</table>

<div class="line"></div>

<table>
  @foreach($penjualan->detailPenjualan as $d)
    @php
      $harga = $d->Harga;
      $jumlah = $d->JumlahProduk;
      $subtotal = $harga * $jumlah;
      $diskon = $d->Diskon ?? 0;
      $total = $subtotal - $diskon;
    @endphp
    <!-- Nama Produk -->
    <tr>
      <td colspan="2"><strong>{{ $d->produk->NamaProduk }}</strong></td>
    </tr>
    <!-- Harga x Jumlah -->
    <tr>
      <td style="padding-left:15px;">
        {{ number_format($harga,0,',','.') }} x {{ $jumlah }}
      </td>
      <td style="text-align:right;">
        {{ number_format($subtotal,0,',','.') }}
      </td>
    </tr>
    <!-- Diskon -->
    @if($diskon > 0)
      <tr>
        <td style="padding-left:15px;">Diskon</td>
        <td style="text-align:right;">
          -{{ number_format($diskon,0,',','.') }}
        </td>
      </tr>
    @endif
    <!-- Total Item -->
    <tr>
      <td style="padding-left:15px;"><strong>Total Item</strong></td>
      <td style="text-align:right;">
        <strong>{{ number_format($total,0,',','.') }}</strong>
      </td>
    </tr>
    <!-- Spacer antar produk -->
    <tr>
      <td colspan="2" style="height:5px;"></td>
    </tr>
  @endforeach
</table>

<div class="line"></div>

<table>
  <tr>
    <td>Total Diskon</td>
    <td style="text-align:right;">
      -{{ number_format($penjualan->TotalDiskon,0,',','.') }}
    </td>
  </tr>
  <tr>
    <td><strong>Total Belanja</strong></td>
    <td style="text-align:right;">
      <strong>{{ number_format($penjualan->TotalHarga,0,',','.') }}</strong>
    </td>
  </tr>
  <tr>
    <td>Bayar</td>
    <td style="text-align:right;">
      {{ number_format($penjualan->JumlahBayar,0,',','.') }}
    </td>
  </tr>
  <tr>
    <td>Kembali</td>
    <td style="text-align:right;">
      {{ number_format($penjualan->Kembalian,0,',','.') }}
    </td>
  </tr>
</table>

<div class="line"></div>

<div class="center">
              {!! \App\Setting::getValue('footer_note') ?? '<p><strong>--- Terima Kasih ---</strong></p><p>Barang yang sudah dibeli tidak dapat dikembalikan</p>' !!}

  <p>
    <br>
    <small>{{ \Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y H:i:s') }}</small>
  </p>
</div>
