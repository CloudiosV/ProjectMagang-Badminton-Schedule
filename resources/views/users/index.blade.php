@extends('layouts.app')

@section('title', 'Daftar User')
@section('header', 'Daftar User')
@section('breadcrumb', 'User Management')

@section('content')
<div class="row mb-4">
    @can('create users')
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <a href="{{ route('users.create') }}" class="card-body text-decoration-none text-light d-block">
                    <div class="text-center">
                        <i class="fas fa-user-plus fa-2x mb-2"></i>
                        <h5>Tambah User</h5>
                    </div>
                </a>
            </div>
        </div>
    @endcan
</div>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-users me-1"></i>
            Daftar User
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="datatablesSimple" class="table table-bordered table-hover">
                <thead>
                    <tr class="text-center">
                        <th width="5%">No</th>
                        <th>Nama User</th>
                        <th>Email</th>
                        <th width="15%">Roles</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="text-center align-middle">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->nama }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    <span class="badge bg-primary">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <div class="d-flex gap-1 justify-content-center">
                                    @can('edit users')
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan

                                    @can('delete users')
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('Apakah Anda yakin menghapus user ini?')" 
                                                    class="btn btn-sm btn-danger" 
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endcan

                                    @if (!(auth()->user()->can('edit users')) && !(auth()->user()->can('delete users')))
                                        <span class="text-muted">Tidak bisa edit</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection