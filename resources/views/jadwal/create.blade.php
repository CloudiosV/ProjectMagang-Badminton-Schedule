@extends('layouts.app')

@section('title', 'Tambah Jadwal')
@section('header', 'Tambah Jadwal')
@section('breadcrumb', 'Jadwal')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-calendar-plus me-1"></i>
        Tambah Jadwal Baru - {{ $lapangan->nama }}
    </div>
    <div class="card-body">
        <form action="{{ route('jadwal.store', $lapangan) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="jam_mulai" class="form-label">Jam Mulai</label>
                <input type="time" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai') }}" 
                       class="form-control @error('jam_mulai') is-invalid @enderror" required>
                @error('jam_mulai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jam_berhenti" class="form-label">Jam Berhenti</label>
                <input type="time" id="jam_berhenti" name="jam_berhenti" value="{{ old('jam_berhenti') }}" 
                       class="form-control @error('jam_berhenti') is-invalid @enderror" required>
                @error('jam_berhenti')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
                <a href="{{ route('lapangan.show', $lapangan) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection