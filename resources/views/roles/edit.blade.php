@extends('layouts.app')

@section('title', 'Edit Role')
@section('header', 'Edit Role')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('roles.update', $role) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="name" class="form-label">Nama Role</label>
                <input type="text" name="name" class="form-control" 
                       value="{{ old('name', $role->name) }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Permissions</label>
                <div class="border p-3" style="max-height:250px;overflow-y:auto">
                    @foreach($permissions as $permission)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                   name="permissions[]" value="{{ $permission->id }}" 
                                   id="perm_{{ $permission->id }}"
                                   {{ in_array($permission->id, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
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
            
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Update Role
            </button>
            <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </form>
    </div>
</div>
@endsection