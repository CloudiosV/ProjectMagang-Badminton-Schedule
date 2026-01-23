<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        if(!auth()->user()->can('view roles')){
            abort(403, 'Unauthorized action.');
        }

        $roles = Role::get();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        if(!auth()->user()->can('create roles')){
            abort(403, 'Unauthorized action.');
        }

        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        if(!auth()->user()->can('create roles')){
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')->with('success', 'Role berhasil dibuat');
    }

    public function edit(Role $role)
    {
        if(!auth()->user()->can('edit roles')){
            abort(403, 'Unauthorized action.');
        }

        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        if(!auth()->user()->can('edit roles')){
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.index')->with('success', 'Role berhasil diupdate');
    }

    public function destroy(Role $role)
    {
        if(!auth()->user()->can('delete roles')){
            abort(403, 'Unauthorized action.');
        }

        if(in_array($role->name, ['admin', 'user', 'manager'])) {
            return redirect()->route('roles.index')->with('error', 'Tidak dapat menghapus role default');
        }

        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus');
    }
}