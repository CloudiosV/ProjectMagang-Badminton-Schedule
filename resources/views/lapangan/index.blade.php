@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

    @section('header', 'Daftar Lapangan')

    @auth
        @if(auth()->user()->role == 'admin')
            <a href="{{ route('lapangan.create') }}" class="btn btn-primary mb-2">Tambah List</a>
            <a href="{{ route('users.index') }}" class="btn btn-primary mb-2">Daftar User</a>
        @endif
    @endauth
    
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-danger mb-2">
            Logout
        </button>
    </form>
    
    <table class="table">
        <thead class="table-dark">
            <tr class="text-center">
                <td>No</td>
                <td>Nama Lapangan</td>
                <td>Tanggal</td>
                <td>Aksi</td>
            </tr>
        </thead>

        <tbody>
            @foreach ($lapangan as $lap)
                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $lap->nama }}</td>
                    <td>{{ $lap->tanggal }}</td>
                    @auth
                        @if(auth()->user()->role == 'admin')
                            <td class="d-flex gap-1 justify-content-center">
                                <a href="{{ route('lapangan.edit', $lap) }}" class="btn btn-sm btn-warning">Ubah</a>
                                <form action="{{ route('lapangan.destroy', $lap) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Anda Yakin Hapus List Ini?')" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                                <a href="{{ route('lapangan.show', $lap) }}" class="btn btn-sm btn-primary">Show</a>
                            </td>
                        @else
                            <td>
                                <a href="{{ route('lapangan.show', $lap) }}" class="btn btn-sm btn-primary">Lihat Jadwal</a>
                            </td>
                        @endif
                    @endauth
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $lapangan->links() }}

@endsection