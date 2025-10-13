@extends('layouts.app')
@section('title', 'Data Penjualan')

@section('content')

{{-- 🔔 Notifikasi Floating Tengah --}}
@if(session('success') || session('error'))
  <div class="position-fixed top-50 start-50 translate-middle" style="z-index: 1055; min-width: 350px;">
    <div class="alert alert-{{ session('success') ? 'success' : 'danger' }} alert-dismissible fade show shadow" role="alert">
      {{ session('success') ?? session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  </div>
@endif

<div class="card shadow-sm">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Data Penjualan</h4>
    @if (Auth::user()->Role == "kasir")
    <a href="{{ route('penjualan.create') }}" class="btn btn-primary">
      + Tambah Penjualan
    </a>
    @endif
  </div>

  <div class="card-body table-responsive">
    <table class="table table-hover table-bordered align-middle">
      <thead class="table-light">
        <tr class="text-center">
          <th>No</th>
          <th>Tanggal</th>
          <th>Pelanggan</th>
          <th>Total</th>
          <th>Total Diskon</th> 
          <th>Metode</th>
          <th>Kasir</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($penjualan as $p)
          <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td>{{ $p->TanggalPenjualan }}</td>
            <td>{{ $p->pelanggan->NamaPelanggan ?? 'Umum' }}</td>
            <td>Rp {{ number_format($p->TotalHarga, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($p->TotalDiskon, 0, ',', '.') }}</td>
            <td>{{ ucfirst($p->Metode) }}</td>
            <td>{{ $p->user->Nama ?? '-' }}</td>
            <td class="text-center">
              <a href="{{ route('penjualan.show', $p->PenjualanID) }}" 
                 class="btn btn-info btn-sm">
                Detail
              </a>

              {{-- Tombol Cetak Struk --}}
              <a href="{{ route('penjualan.cetak', $p->PenjualanID) }}" target="_blank"
                 class="btn btn-success btn-sm">
                Cetak
              </a>

              {{-- Tombol Hapus --}}
              <form action="{{ route('penjualan.destroy', $p->PenjualanID) }}" 
                    method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="btn btn-danger btn-sm" 
                        onclick="return confirm('Yakin hapus data ini?')">
                  Hapus
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8" class="text-center">Belum ada data penjualan</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection

@section('scripts')
<script>
  // Auto hide notif setelah 3 detik
  setTimeout(() => {
    const alertEl = document.querySelector('.alert');
    if(alertEl){
      let fade = new bootstrap.Alert(alertEl);
      fade.close();
    }
  }, 3000);
</script>
@endsection
