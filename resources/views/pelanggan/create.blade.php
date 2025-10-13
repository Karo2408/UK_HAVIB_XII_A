@extends('layouts.app')
@section('title','Tambah Pelanggan')
@section('content')
<div class="card">
  <div class="card-header">
    <h5 class="mb-0">Tambah Pelanggan</h5>
  </div>
  <div class="card-body">
    <form action="{{ route('pelanggan.store') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label class="form-label">Nama Pelanggan</label>
        <input type="text" name="NamaPelanggan" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Alamat</label>
        <textarea name="Alamat" class="form-control" rows="3"></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Nomor Telepon</label>
        <input type="text" name="NomorTelepon" class="form-control">
      </div>

      <div class="d-flex justify-content-end">
        <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary me-2">Batal</a>
        <button type="submit" class="btn btn-success">Simpan</button>
      </div>
    </form>
  </div>
</div>
@endsection
