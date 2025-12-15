<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateRolePermissionRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RolePermissionController extends Controller
{
    public function show(Role $role)
    {
        $permissions = Permission::all();

        $role->load('permissions');

        return Inertia::render('rolePermission/Show', ['role' => $role, 'permissions' => $permissions]);
    }

    public function update(Role $role, UpdateRolePermissionRequest $request)
    {
        $role->permissions()->sync($request->validated('selectedPermissions'));

        return redirect()->route('role-permission.show', ['role' => $role])->with('status','Permissions updated!');
    }
}
