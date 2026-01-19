@extends('layouts.app')

@section('title', 'Tambah Jadwal')

@section('content')

    @section('header', 'Tambah Jadwal')

    <form action="{{ route('jadwal.store', $lapangan) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="jam_mulai" class="form-label">Jam Mulai: </label>
            <input type="time" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai') }}" class="form-control" required>
        </div>

        <div>
            <label for="jam_berhenti" class="form-label">Jam Berhenti: </label>
            <input type="time" id="jam_berhenti" name="jam_berhenti" value="{{ old('jam_berhenti') }}" class="form-control" required>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-success btn-sm">Tambah</button>
            <a href="{{ route('lapangan.show', $lapangan) }}" class="btn btn-danger btn-sm">Kembali</a>
        </div>
    </form>

@endsection