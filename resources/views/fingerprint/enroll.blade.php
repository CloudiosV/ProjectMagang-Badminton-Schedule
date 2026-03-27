@extends('layouts.app')

@section('title', 'Registrasi Sidik Jari - GoBadminton')
@section('header', 'Registrasi Sidik Jari')
@section('breadcrumb', 'Fingerprint / Enroll')

@section('content')
<div class="row">
    <div class="col-xl-6 col-lg-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-fingerprint me-2"></i>
                Form Registrasi Sidik Jari Baru
            </div>
            
            <div class="card-body p-4">
                <div class="mb-4">
                    <label for="user_id" class="form-label fw-bold">Pilih Nama</label>
                    <select id="user_id" class="form-select select2">
                        <option value="">-- Ketik atau Pilih Nama --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->nama }}</option>
                        @endforeach
                    </select>
                    <div class="form-text text-muted">
                        Pastikan alat fingerprint sudah menyala dan terhubung ke komputer ini.
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button id="btn-enroll" class="btn btn-primary btn-lg">
                        <i class="fas fa-bullseye me-2"></i> 1. Mulai Scan Jari (Daftar / Enroll)
                    </button>
                    
                    <button id="btn-verify" class="btn btn-success btn-lg mt-2">
                        <i class="fas fa-check-circle me-2"></i> 2. Verifikasi Karyawan Terpilih (1:1)
                    </button>

                    <hr> <button id="btn-identify" class="btn btn-info btn-lg text-white">
                        <i class="fas fa-search me-2"></i> 3. Absen Cepat / Identifikasi (1:N)
                    </button>
                </div>

                <div class="text-center mt-4">
                    <p id="status-message-element" class="fs-5 mb-0" style="font-weight: bold; min-height: 30px;">
                        {{-- Teks status dari JS akan muncul di sini --}}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Inisialisasi library Select2 untuk fitur pencarian nama
    $(document).ready(function() {
        $('#user_id').select2({
            width: '100%',
            placeholder: "-- Ketik atau Pilih Nama Karyawan --"
        });
    });
</script>

<script src="{{ asset('js/fingerprint.js') }}"></script>
@endpush