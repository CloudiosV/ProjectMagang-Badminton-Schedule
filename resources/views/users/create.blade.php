@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')

    @section('header', 'Tambah User')

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nama" class="form-label">Nama: </label>
            <input type="text" id="nama" name="nama" value="{{ old('nama') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email: </label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password: </label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Role: </label>
            <select id="role" name="role" class="form-control" required>
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-success btn-sm">Tambah</button>
            <a href="{{ route('users.index') }}" class="btn btn-danger btn-sm">Kembali</a>
        </div>
    </form>

@endsection