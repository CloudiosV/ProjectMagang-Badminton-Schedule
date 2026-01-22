@extends('layouts.app')

@section('title', 'Ubah Lapangan')
@section('header', 'Ubah Lapangan')
@section('breadcrumb', 'Lapangan')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-edit me-1"></i>
        Ubah Data Lapangan
    </div>
    <div class="card-body">
        <form action="{{ route('lapangan.update', $lapangan) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lapangan</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $lapangan->nama) }}" 
                       class="form-control @error('nama') is-invalid @enderror" required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal Lapangan</label>
                <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', $lapangan->tanggal) }}" 
                       class="form-control @error('tanggal') is-invalid @enderror" required>
                @error('tanggal')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i> Update
                </button>
                <a href="{{ route('lapangan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection