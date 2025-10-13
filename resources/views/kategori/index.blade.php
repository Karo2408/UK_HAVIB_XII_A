@extends('layouts.app')
@section('title','Kategori')

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between">
    <h5>Kategori</h5>
    <a href="{{ route('kategori.create') }}" class="btn btn-primary">+ Tambah Kategori</a>
  </div>
  <div class="card-body table-responsive">
    <table class="table table-hover">
      <thead><tr><th>ID</th><th>Nama Kategori</th><th>Aksi</th></tr></thead>
      <tbody>
        @foreach($kategori as $k)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $k->NamaKategori }}</td>
          <td>
            <a href="{{ route('kategori.edit',$k->KategoriID) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('kategori.destroy',$k->KategoriID) }}" method="POST" class="d-inline">
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
