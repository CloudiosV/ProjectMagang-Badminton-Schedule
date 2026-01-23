@extends('layouts.app')

@section('title', 'Tambah Role')
@section('header', 'Tambah Role Baru')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="name" class="form-label">Nama Role</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                <small class="text-muted">Contoh: supervisor, finance, staff</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Permissions</label>
                <div class="border p-3" style="max-height:250px;overflow-y:auto">
                    @foreach($permissions as $permission)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                   name="permissions[]" value="{{ $permission->id }}" 
                                   id="perm_{{ $permission->id }}"
                                   {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
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
                <i class="fas fa-save"></i> Simpan Role
            </button>
            <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </form>
    </div>
</div>
@endsection