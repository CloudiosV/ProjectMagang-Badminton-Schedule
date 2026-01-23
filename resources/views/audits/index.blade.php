@extends('layouts.app')

@section('title', 'Audit Log')
@section('header', 'Audit Log System')
@section('breadcrumb', 'Audit Log')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Daftar Audit Log</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="datatablesSimple" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Event</th>
                        <th>Model</th>
                        <th>IP Address</th>
                        <th>Timestamp</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($audits as $audit)
                    <tr>
                        <td>{{ $audit->id }}</td>
                        <td>
                            @if($audit->user)
                                {{ $audit->user->nama }} ({{ $audit->user->email }})
                            @else
                                System
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $audit->event == 'created' ? 'success' : ($audit->event == 'updated' ? 'warning' : 'danger') }}">
                                {{ $audit->event }}
                            </span>
                        </td>
                        <td>{{ $audit->auditable_type }}</td>
ac --}}
                        <td>{{ $audit->ip_address }}</td>
                        <td>{{ $audit->created_at->format('Y-m-d H:i:s') }}</td>
                        <td>
                            <a href="{{ route('audits.show', $audit->id) }}" class="btn btn-sm btn-info">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection