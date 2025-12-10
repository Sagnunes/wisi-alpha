<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RolePermissionController extends Controller
{
    public function show(Role $role)
    {
        return Inertia::render('rolePermission/Show', ['role' => $role]);
    }

    public function store()
    {
        //
    }

    public function destroy()
    {

    }
}
