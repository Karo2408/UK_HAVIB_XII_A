@extends('layouts.app')
@section('title','Tambah Kategori')
@section('content')
<div class="card">
  <div class="card-body">
    <form action="{{ route('kategori.store') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label>Nama Kategori</label>
        <input type="text" name="NamaKategori" class="form-control" required>
      </div>
    <div class="d-flex justify-content-end">
        <a href="{{ route('kategori.index') }}" class="btn btn-secondary me-2">Batal</a>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
    </form>
  </div>
</div>
@endsection
