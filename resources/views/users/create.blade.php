@extends('layouts.app')
@section('title','Tambah User')

@section('content')
<div class="card">
  <div class="card-body">
    <form action="{{ route('users.store') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="Nama" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="Email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="password" name="Password" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Role</label>
        <select name="Role" class="form-control">
          <option value="admin">Admin</option>
          <option value="kasir">Kasir</option>
        </select>
      </div>
      <div class="d-flex justify-content-end">
        <a href="{{ route('users.index') }}" class="btn btn-secondary me-2">Batal</a>
        <button type="submit" class="btn btn-success">Simpan</button>
      </div>
    </form>
  </div>
</div>
@endsection
