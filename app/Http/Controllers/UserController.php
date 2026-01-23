<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        if(!(auth()->user()->can('view users')) || !(auth()->user()->hasRole('admin'))){
            abort(403, 'Unathorized action.');
        }

        $users = User::with('roles')->latest()->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        if(!auth()->user()->can('create users')){
            abort(403, 'Unathorized action.');
        }

        $roles = Role::all();
        $permissions = Permission::all();

        return view('users.create', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        if(!auth()->user()->can('create users')){
            abort(403, 'Unathorized action.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->syncRoles($request->roles);

        if ($request->has('permissions')) {
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $user->syncPermissions($permissions);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        if(!auth()->user()->can('edit users')){
            abort(403, 'Unathorized action.');
        }
        
        $roles = Role::all();
        $permissions = Permission::all();
        $userRoles = $user->roles->pluck('name')->toArray();
        $userPermissions = $user->permissions->pluck('id')->toArray();
        
        return view('users.edit', compact('user', 'roles', 'permissions', 'userRoles', 'userPermissions'));
    }
    
    public function update(Request $request, User $user)
    {
        if(!auth()->user()->can('edit users')){
            abort(403, 'Unathorized action.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $updateData = [
            'nama' => $request->nama,
            'email' => $request->email,
        ];

        if($request->filled('password')){
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        $user->syncRoles($request->roles);

        if ($request->has('permissions')) {
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $user->syncPermissions($permissions);
        } else {
            $user->syncPermissions([]);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        if(!auth()->user()->can('delete users')){
            abort(403, 'Unathorized action.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
}