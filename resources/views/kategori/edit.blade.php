@extends('layouts.app')
@section('title','Edit Kategori')
@section('content')
<div class="card">
  <div class="card-body">
    <form action="{{ route('kategori.update',$kategori->KategoriID) }}" method="POST">
      @csrf @method('PUT')
      <div class="mb-3">
        <label>Nama Kategori</label>
        <input type="text" name="NamaKategori" value="{{ $kategori->NamaKategori }}" class="form-control" required>
      </div>
    <div class="d-flex justify-content-end">
        <a href="{{ route('kategori.index') }}" class="btn btn-secondary me-2">Batal</a>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
    </form>
  </div>
</div>
@endsection
