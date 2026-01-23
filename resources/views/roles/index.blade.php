@extends('layouts.app')

@section('title', 'Roles Management')
@section('header', 'Daftar Roles')
@section('breadcrumb', 'Roles Management')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Roles</h5>
            @can('create roles')
                <a href="{{ route('roles.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> Tambah Role
                </a>
            @endcan
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="datatablesSimple" class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th width="5%">No</th>
                        <th>Nama Role</th>
                        <th>Jumlah User</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">
                            <strong>{{ $role->name }}</strong>
                            @if(in_array($role->name, ['admin', 'user', 'manager', 'super-admin']))
                                <span class="badge bg-info">Default</span>
                            @endif
                        </td>
                        <td class="text-center">
                            {{ $role->users->count() }} user
                        </td>
                        <td class="text-center">
                            @can('edit roles')
                                <a href="{{ route('roles.edit', $role) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endcan
                            
                            @can('delete roles')
                                @if(!in_array($role->name, ['admin', 'user', 'manager', 'super-admin']))
                                    <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Hapus role {{ $role->name }}?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                @endif
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection