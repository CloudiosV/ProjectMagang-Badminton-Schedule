@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
    @section('header', 'Tambah User')

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nama" class="form-label">Nama:</label>
            <input type="text" id="nama" name="nama" value="{{ old('nama') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="roles" class="form-label">Roles:</label>
            <select id="roles" name="roles[]" class="form-control" multiple required>
                @foreach($roles as $role)                
                    <option value="{{ $role->name }}" {{ in_array($role->name, old('roles', [])) ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Hold Ctrl untuk pilih multiple</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Permissions:</label>
            <div style="max-height:200px;overflow-y:auto;border:1px solid #ddd;padding:10px;border-radius:5px">
                @foreach($permissions as $permission)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                               id="perm_{{ $permission->id }}" {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                            {{ $permission->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-success btn-sm">Tambah</button>
            <a href="{{ route('users.index') }}" class="btn btn-danger btn-sm">Kembali</a>
        </div>
    </form>

    <script>
    $(function(){
        $('#roles').select2({placeholder:"Pilih roles",allowClear:true,width:'100%'});
    });
    </script>
@endsection