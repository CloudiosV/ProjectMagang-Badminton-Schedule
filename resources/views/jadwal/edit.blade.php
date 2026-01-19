@extends('layouts.app')

@section('title', 'Ubah Jadwal')

@section('content')

    @section('header', 'Ubah Jadwal')

    <form action="{{ route('jadwal.update', [$lapangan, $jadwal]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="jam_mulai" class="form-label">Jam Mulai: </label>
            <input type="time" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai', substr($jadwal->jam_mulai, 0, 5)) }}" class="form-control" required>
        </div>

        <div>
            <label for="jam_berhenti" class="form-label">Jam Berhenti: </label>
            <input type="time" id="jam_berhenti" name="jam_berhenti" value="{{ old('jam_berhenti', substr($jadwal->jam_berhenti, 0, 5)) }}" class="form-control" required>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-success btn-sm">Ubah</button>
            <a href="{{ route('lapangan.show', $lapangan) }}" class="btn btn-danger btn-sm">Kembali</a>
        </div>
    </form>

@endsection