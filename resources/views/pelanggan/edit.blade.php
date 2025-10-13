@extends('layouts.app')
@section('title','Edit Pelanggan')

@section('content')
<div class="card">
  <div class="card-header">
    <h5>Edit Pelanggan</h5>
  </div>
  <div class="card-body">
    <form action="{{ route('pelanggan.update', $pelanggan->PelangganID) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label>Nama Pelanggan</label>
        <input type="text" name="NamaPelanggan" value="{{ old('NamaPelanggan', $pelanggan->NamaPelanggan) }}" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Alamat</label>
        <textarea name="Alamat" class="form-control">{{ old('Alamat', $pelanggan->Alamat) }}</textarea>
      </div>

      <div class="mb-3">
        <label>Nomor Telepon</label>
        <input type="text" name="NomorTelepon" value="{{ old('NomorTelepon', $pelanggan->NomorTelepon) }}" class="form-control">
      </div>

      <div class="d-flex justify-content-end">
        <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary me-2">Batal</a>
        <button type="submit" class="btn btn-success">Update</button>
      </div>
    </form>
  </div>
</div>
@endsection
