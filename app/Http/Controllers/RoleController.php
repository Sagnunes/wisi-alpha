<?php

namespace App\Http\Controllers;

use App\Actions\Roles\DeleteRole;
use App\Actions\Roles\GetRoles;
use App\DTOs\RoleDTO;
use App\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Inertia\Inertia;

class RoleController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(GetRoles $action)
    {
        $this->authorize('viewAny', Role::class);

        return Inertia::render('roles/Index')->with('roles', $action->handle());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $this->authorize('create', Role::class);

        $roleDto = RoleDTO::fromRequest($request->validated());

        $createdRole = Role::create([
            'name' => $roleDto->name,
            'slug' => $roleDto->slug,
        ]);

        return redirect()
            ->route('roles.index')
            ->with(['status' => 'Role created successfully.', 'data' => $createdRole]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role, DeleteRole $action)
    {
        $this->authorize('delete', $role);

        $action->handle($role);

        return redirect()->back()->with('status', 'Role deleted successfully.');
    }
}
