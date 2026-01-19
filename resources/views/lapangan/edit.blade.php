@extends('layouts.app')

@section('title', 'Ubah Lapangan')

@section('content')

    @section('header', 'Ubah Lapangan')

    <form action="{{ route('lapangan.update', $lapangan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Lapangan: </label>
            <input type="text" id="nama" name="nama" value="{{ old('nama', $lapangan->nama) }}" class="form-control" required>
        </div>

        <div>
            <label for="tanggal" class="form-label">Tanggal Lapangan: </label>
            <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', $lapangan->tanggal) }}" class="form-control" required>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-success btn-sm">Ubah Lapangan</button>
            <a href="{{ route('lapangan.index') }}" class="btn btn-danger btn-sm">Kembali</a>
        </div>
    </form>

@endsection