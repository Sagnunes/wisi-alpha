<?php

namespace App\Http\Controllers;

use App\Actions\Permissions\DeletePermission;
use App\Actions\Permissions\GetPermissions;
use App\DTOs\PermissionDTO;
use App\Models\Permission;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Inertia\Inertia;

class PermissionController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(GetPermissions $action)
    {
        $this->authorize('viewAny', Permission::class);

        return Inertia::render('permissions/Index')->with('permissions', $action->handle());
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
    public function store(StorePermissionRequest $request)
    {
        $this->authorize('create', Permission::class);

        $permissionDto = PermissionDTO::fromRequest($request->validated());

        $createdPermission = Permission::create([
            'name' => $permissionDto->name,
            'slug' => $permissionDto->slug,
        ]);

        return redirect()
            ->route('permissions.index')
            ->with(['status' => 'Permission created successfully.', 'data' => $createdPermission]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission, DeletePermission $action)
    {
        $this->authorize('delete', $permission);

        $action->handle($permission);

        return redirect()->back()->with('status', 'Permission deleted successfully.');
    }
}
