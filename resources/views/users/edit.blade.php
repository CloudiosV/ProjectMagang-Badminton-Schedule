@extends('layouts.app')

@section('title', 'Edit User')
@section('header', 'Edit User')
@section('breadcrumb', 'Edit User')  

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama', $user->nama) }}" required>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">👁</button>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="roles" class="form-label">Roles</label>
                <select id="roles" name="roles[]" class="form-control" multiple required>
                    @foreach($roles as $role)                
                        <option value="{{ $role->name }}" {{ in_array($role->name, old('roles', $userRoles)) ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                <small class="text-muted">Permissions otomatis dari role</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Permissions (otomatis dari role)</label>
                <div id="permissions-box" class="border p-3" style="max-height:200px;overflow-y:auto">
                    @foreach($permissions as $permission)
                        <div class="form-check">
                            <input class="form-check-input permission-checkbox" type="checkbox" 
                                   name="permissions[]" value="{{ $permission->id }}" 
                                   id="perm_{{ $permission->id }}" disabled
                                   {{ in_array($permission->id, old('permissions', $userPermissions)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="perm_{{ $permission->id }}">
                                {{ $permission->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <button type="submit" class="btn btn-success">Ubah</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<script>
function togglePassword() {
    var passInput = document.getElementById('password');
    passInput.type = passInput.type === 'password' ? 'text' : 'password';
}

$(function(){
    $('#roles').select2({placeholder:"Pilih roles",allowClear:true,width:'100%'});

    var rolePerms = @json($rolePermissions);
    
    $('#roles').change(function(){
        var roles = $(this).val()||[];
        var allPerms = [];
        roles.forEach(r=>rolePerms[r]&&allPerms.push(...rolePerms[r]));
        allPerms = [...new Set(allPerms)];
        
        $('.permission-checkbox').each(function(){
            var permName = $(this).next('label').text().trim();
            $(this).prop('checked', allPerms.includes(permName));
        });
    });
    
    $('#roles').trigger('change');
});
</script>
</script>
@endsection