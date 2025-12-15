<?php

namespace App\Http\Controllers;

use App\DTOs\RoleDTO;
use App\Http\Requests\UpdateUserRoleRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserRoleController extends Controller
{

    public function show(User $user)
    {
        $roles = Role::all()->map(fn (Role $role): array => RoleDTO::fromModel($role)->toArray());

        $user->load('roles');

        return Inertia::render('userRole/Show')->with(['user' => $user, 'roles' => $roles]);
    }

    public function update(User $user, UpdateUserRoleRequest $request)
    {
        $user->roles()->sync($request->validated('selectedRoles'));

        return redirect()->route('user-role.show', ['user' => $user])->with('status','Roles updated!');
    }
}
