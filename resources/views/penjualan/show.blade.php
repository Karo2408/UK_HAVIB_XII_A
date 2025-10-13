@extends('layouts.app')
@section('title', 'Detail Penjualan')

@section('content')
<div class="card shadow-sm">
  <div class="card-body">
    <h4 class="mb-4">Detail Penjualan</h4>

    {{-- Info Umum --}}
    <div class="row mb-3">
      <div class="col-md-6">
        <p><strong>Tanggal:</strong> {{ $penjualan->TanggalPenjualan }}</p>
        <p><strong>Pelanggan:</strong> {{ $penjualan->pelanggan->NamaPelanggan ?? 'Umum' }}</p>
      </div>
      <div class="col-md-6">
        <p><strong>Kasir:</strong> {{ $penjualan->user->Nama ?? '-' }}</p>
        <p><strong>Metode Pembayaran:</strong> {{ ucfirst($penjualan->Metode) }}</p>
      </div>
    </div>

    <hr>

    {{-- Daftar Produk --}}
    <h5 class="mb-3">Produk Dibeli</h5>
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="table-light">
          <tr>
            <th>Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
            <th>Diskon</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($penjualan->detailPenjualan as $detail)
            @php
              $harga    = $detail->Harga;
              $subtotal = $detail->Subtotal;
              $diskon   = $detail->Diskon ?? 0;
              $total    = $subtotal - $diskon;
            @endphp
            <tr>
              <td>{{ $detail->produk->NamaProduk }}</td>
              <td>Rp {{ number_format($harga, 0, ',', '.') }}</td>
              <td>{{ $detail->JumlahProduk }}</td>
              <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
              <td>-Rp {{ number_format($diskon, 0, ',', '.') }}</td>
              <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    {{-- Ringkasan --}}
    <div class="row justify-content-end mt-4">
      <div class="col-md-4">
        <div class="card bg-light p-3">
          <p class="d-flex justify-content-between mb-2">
            <span><strong>Total Diskon:</strong></span>
            <span>-Rp {{ number_format($penjualan->TotalDiskon, 0, ',', '.') }}</span>
          </p>
          <p class="d-flex justify-content-between mb-2">
            <span><strong>Total Belanja:</strong></span>
            <span>Rp {{ number_format($penjualan->TotalHarga, 0, ',', '.') }}</span>
          </p>
          <p class="d-flex justify-content-between mb-2">
            <span><strong>Jumlah Bayar:</strong></span>
            <span>Rp {{ number_format($penjualan->JumlahBayar, 0, ',', '.') }}</span>
          </p>
          <p class="d-flex justify-content-between mb-0">
            <span><strong>Kembalian:</strong></span>
            <span>Rp {{ number_format($penjualan->Kembalian, 0, ',', '.') }}</span>
          </p>
        </div>
      </div>
    </div>

    {{-- Tombol Kembali --}}
    <div class="d-flex justify-content-end mt-3">
      <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>
  </div>
</div>
@endsection
