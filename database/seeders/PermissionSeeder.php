<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        $permissions = [
            ['name' => 'view users'],
            ['name' => 'create users'],
            ['name' => 'edit users'],
            ['name' => 'delete users'],
            
            ['name' => 'view lapangan'],
            ['name' => 'create lapangan'],
            ['name' => 'edit lapangan'],
            ['name' => 'delete lapangan'],
            
            ['name' => 'view jadwal'],
            ['name' => 'create jadwal'],
            ['name' => 'edit jadwal'],
            ['name' => 'delete jadwal'],
        ];
        
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
                'guard_name' => 'web'
            ]);
        }
        
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $userRole = Role::create(['name' => 'user', 'guard_name' => 'web']);
        
        $adminRole->syncPermissions(Permission::all());
        
        \App\Models\User::create([
            'nama' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
        ])->assignRole('admin');
    }
}