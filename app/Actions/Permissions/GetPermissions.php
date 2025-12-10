<?php

declare(strict_types=1);

namespace App\Actions\Permissions;

use App\DTOs\PermissionDTO;
use App\DTOs\RoleDTO;
use App\Models\Permission;

final readonly class GetPermissions
{
    public function __construct()
    {
    }

    public function handle(): array
    {
        return Permission::orderBy('name')->get()
            ->map(fn(Permission $permission): \App\Contracts\DTO\DTOInterface => PermissionDTO::fromModel($permission))
            ->toArray();
    }
}
