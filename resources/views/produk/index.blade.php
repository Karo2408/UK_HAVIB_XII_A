@extends('layouts.app')
@section('title','Produk')

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between">
    <h5>Produk</h5>
    <a href="{{ route('produk.create') }}" class="btn btn-primary">+ Tambah Produk</a>
  </div>
  <div class="card-body table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Harga</th>
          <th>Stok</th>
          <th>Kategori</th>
          <th>Foto</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($produk as $p)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $p->NamaProduk }}</td>
          <td>Rp {{ number_format($p->Harga,0,',','.') }}</td>
          <td>{{ max(0, $p->Stok) }}</td> {{-- Stok tidak bisa minus --}}
          <td>{{ $p->kategori->NamaKategori ?? '-' }}</td>
          <td>
            @if($p->Foto)
              <img src="{{ asset('storage/'.$p->Foto) }}" width="60" class="img-thumbnail">
            @endif
          </td>
          <td>
            <a href="{{ route('produk.edit',$p->ProdukID) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('produk.destroy',$p->ProdukID) }}" method="POST" class="d-inline">
              @csrf 
              @method('DELETE')
              <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?')">
                Hapus
              </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
