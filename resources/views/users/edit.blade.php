@extends('layouts.app')
@section('title','Edit User')

@section('content')
<div class="card">
  <div class="card-body">
    <form action="{{ route('users.update',$user->UserID) }}" method="POST">
      @csrf @method('PUT')
      <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="Nama" value="{{ $user->Nama }}" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="Email" value="{{ $user->Email }}" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Role</label>
        <select name="Role" class="form-control">
          <option value="admin" {{ $user->Role=='admin'?'selected':'' }}>Admin</option>
          <option value="kasir" {{ $user->Role=='kasir'?'selected':'' }}>Kasir</option>
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
