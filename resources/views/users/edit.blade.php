@extends('layouts.app')

@section('title', 'Edit User')
@section('header', 'Edit User')
@section('breadcrumb', 'User Management')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-user-edit me-1"></i>
        Edit User
    </div>
    <div class="card-body">
        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama" class="form-label">Nama User</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama', $user->nama) }}" 
                           class="form-control @error('nama') is-invalid @enderror" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                           class="form-control @error('email') is-invalid @enderror" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" 
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Kosongkan jika tidak ingin mengubah password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah password</small>
            </div>

            <div class="mb-3">
                <label for="roles" class="form-label">Roles</label>
                <select id="roles" name="roles[]" 
                        class="form-control @error('roles') is-invalid @enderror" multiple required>
                    @foreach($roles as $role)                
                        <option value="{{ $role->name }}" {{ in_array($role->name, old('roles', $userRoles)) ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                @error('roles')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Gunakan Ctrl untuk memilih multiple roles</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Permissions</label>
                <div class="border rounded p-3" style="max-height:200px; overflow-y:auto">
                    @foreach($permissions as $permission)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="permissions[]" 
                                   value="{{ $permission->id }}" 
                                   id="perm_{{ $permission->id }}" 
                                   {{ in_array($permission->id, old('permissions', $userPermissions)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="perm_{{ $permission->id }}">
                                {{ $permission->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('permissions')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i> Update
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#roles').select2({
        placeholder: "Pilih roles",
        allowClear: true,
        width: '100%'
    });
});
</script>
@endpush
@endsection