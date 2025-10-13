@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="card shadow-sm border-0 rounded-3">
  {{-- Header --}}
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Laporan Penjualan</h5>
    <div>
      <a href="{{ route('laporan.exportPDF', request()->all()) }}" 
         class="btn btn-danger btn-sm px-3 py-2 fw-semibold">
        <i class="ti ti-file-text"></i> Export PDF
      </a>
    </div>
  </div>

  {{-- Filter --}}
  <div class="card-body border-bottom pb-3">
    <form method="GET" action="{{ route('laporan.index') }}" class="row g-2 align-items-end">
      <div class="col-md-3">
        <label class="form-label small fw-bold text-muted">Dari Tanggal</label>
        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
      </div>
      <div class="col-md-3">
        <label class="form-label small fw-bold text-muted">Sampai Tanggal</label>
        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
      </div>
      <div class="col-md-6 d-flex gap-2 mt-3 mt-md-0">
        <button type="submit" class="btn btn-primary">
          <i class="ti ti-filter"></i> Filter
        </button>
        <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
          <i class="ti ti-refresh"></i> Reset
        </a>
      </div>
    </form>
  </div>

  {{-- Tabel --}}
  <div class="card-body table-responsive">
    <table class="table table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th width="5%">ID</th>
          <th width="20%">Tanggal</th>
          <th width="20%">Total Harga</th>
          <th width="25%">Pelanggan</th>
          <th width="25%">Kasir</th>
        </tr>
      </thead>
      <tbody>
        @forelse($penjualan as $p)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ \Carbon\Carbon::parse($p->TanggalPenjualan)->format('d M Y') }}</td>
            <td>Rp {{ number_format($p->TotalHarga, 0, ',', '.') }}</td>
            <td>{{ $p->pelanggan->NamaPelanggan ?? 'Umum' }}</td>
            <td>{{ $p->user->Nama ?? '-' }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center text-muted py-4">
              <i class="ti ti-info-circle"></i> Tidak ada data penjualan
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
