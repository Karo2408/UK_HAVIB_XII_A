@extends('layouts.app')
@section('title','Edit Produk')
@section('content')
<div class="card">
  <div class="card-body">
    <form action="{{ route('produk.update',$produk->ProdukID) }}" method="POST" enctype="multipart/form-data">
      @csrf @method('PUT')

      <div class="mb-3">
        <label>Nama Produk</label>
        <input type="text" name="NamaProduk" value="{{ $produk->NamaProduk }}" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Harga</label>
        <input type="number" name="Harga" value="{{ $produk->Harga }}" class="form-control" min="0" required>
      </div>

      <div class="mb-3">
        <label>Stok</label>
        <input type="number" name="Stok" value="{{ max(0, $produk->Stok) }}" class="form-control" min="0" required>
      </div>

      <div class="mb-3">
        <label>Kategori</label>
        <select name="KategoriID" class="form-control" required>
          @foreach($kategori as $k)
            <option value="{{ $k->KategoriID }}" {{ $produk->KategoriID==$k->KategoriID?'selected':'' }}>
              {{ $k->NamaKategori }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="mb-3">
        <label>Foto</label>
        <input type="file" name="Foto" class="form-control">
        @if($produk->Foto)
          <img src="{{ asset('storage/'.$produk->Foto) }}" width="80" class="mt-2">
        @endif
      </div>

      <div class="d-flex justify-content-end">
        <a href="{{ route('produk.index') }}" class="btn btn-secondary me-2">Batal</a>
        <button type="submit" class="btn btn-success">Simpan</button>
      </div>
    </form>
  </div>
</div>
@endsection
