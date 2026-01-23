@extends('layouts.app')

@section('title', 'Audit Detail')
@section('header', 'Audit Log Detail')
@section('breadcrumb', 'Audit Detail')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Audit Log Detail</h5>
            <a href="{{ route('audits.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5>Audit #{{ $audit->id }}</h5>
        <p><strong>User:</strong> {{ $audit->user->nama ?? 'System' }}</p>
        <p><strong>Event:</strong> {{ $audit->event }}</p>
        <p><strong>Model:</strong> {{ $audit->auditable_type }}</p>
        
        <h6 class="mt-4">Changes:</h6>
        <div class="row">
            <div class="col-md-6">
                <strong>Old Values:</strong>
                <pre>{{ json_encode($audit->old_values, JSON_PRETTY_PRINT) }}</pre>
            </div>
            <div class="col-md-6">
                <strong>New Values:</strong>
                <pre>{{ json_encode($audit->new_values, JSON_PRETTY_PRINT) }}</pre>
            </div>
        </div>
    </div>
</div>

<style>
    pre {
    white-space: pre-wrap;
    word-break: break-word;
    overflow-x: hidden;
    overflow-y: auto;
}
</style>
@endsection