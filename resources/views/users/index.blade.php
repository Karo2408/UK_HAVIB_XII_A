@extends('layouts.app')
@section('title','Users')

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between">
    <h5>User</h5>
    <a href="{{ route('users.create') }}" class="btn btn-primary">+ Tambah User</a>
  </div>
  <div class="card-body table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $u)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $u->Nama }}</td>
          <td>{{ $u->Email }}</td>
          <td>{{ $u->Role }}</td>
          <td>
            <a href="{{ route('users.edit',$u->UserID) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('users.destroy',$u->UserID) }}" method="POST" class="d-inline">
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
