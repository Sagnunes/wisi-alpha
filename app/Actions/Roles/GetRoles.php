<?php

declare(strict_types=1);

namespace App\Actions\Roles;

use App\DTOs\RoleDTO;
use App\Models\Role;

final readonly class GetRoles
{
    public function __construct()
    {
    }

    public function handle(): array
    {
        $roles = Role::with('permissions')->orderBy('name')->get();

        return $roles->map(function (Role $role) {
            return [
                ...RoleDTO::fromModel($role)->toArray(),
                'can' => [
                    'delete' => auth()->user()?->can('delete', $role) ?? false,
                ],
            ];
        })->toArray();

    }
}
