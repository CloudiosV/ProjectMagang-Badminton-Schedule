@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

    @section('header', 'Daftar User')

    <div class="mb-3">
        <a href="{{ route('lapangan.index') }}" class="btn btn-primary mb-2">Daftar Lapangan</a>
        <a href="{{ route('users.create') }}" class="btn btn-success mb-2">Tambah User</a>
        
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger mb-2">
                Logout
            </button>
        </form>
    </div>
    
    <table class="table">
        <thead class="table-dark">
            <tr class="text-center">
                <td>No</td>
                <td>Nama User</td>
                <td>Email</td>
                <td>Role</td>
                <td>Aksi</td>
            </tr>
        </thead>

        <tbody>
            @foreach ($users as $user)
                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->nama }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td class="d-flex gap-1 justify-content-center">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">Ubah</a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Anda Yakin Hapus User Ini?')" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links() }}

@endsection