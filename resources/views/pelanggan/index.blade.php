@extends('layouts.app')
@section('title','Pelanggan')

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between">
    <h5>Pelanggan</h5>
    <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">+ Tambah Pelanggan</a>
  </div>
  <div class="card-body table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Alamat</th>
          <th>Nomor Telepon</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($pelanggan as $pl)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $pl->NamaPelanggan }}</td>
          <td>{{ $pl->Alamat }}</td>
          <td>{{ $pl->NomorTelepon }}</td>
          <td>
            <a href="{{ route('pelanggan.edit',$pl->PelangganID) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('pelanggan.destroy',$pl->PelangganID) }}" method="POST" class="d-inline">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-sm">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
