@extends('layouts.app')

@section('title', 'Tambah User')
@section('header', 'Tambah User')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label for="roles" class="form-label">Roles</label>
                <select id="roles" name="roles[]" class="form-control" multiple required>
                    @foreach($roles as $role)                
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
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
                                   id="perm_{{ $permission->id }}" disabled>
                            <label class="form-check-label" for="perm_{{ $permission->id }}">
                                {{ $permission->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<script>
$(function(){
    $('#roles').select2({placeholder:"Pilih roles",allowClear:true,width:'100%'});

    var rolePerms = {
        admin: ['view users','create users','edit users','delete users','view lapangan','create lapangan','edit lapangan','delete lapangan','view jadwal','create jadwal','edit jadwal','delete jadwal'],
        manager: ['view lapangan','create lapangan','edit lapangan','delete lapangan','view jadwal','create jadwal','edit jadwal','delete jadwal'],
        user: ['view lapangan','view jadwal','create jadwal','edit jadwal','delete jadwal']
    };
    
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
});
</script>
@endsection