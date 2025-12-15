<?php

declare(strict_types=1);

namespace App\Actions\Roles;

use App\Models\Role;

final readonly class DeleteRole
{
    public function __construct()
    {
    }

    public function handle(Role $role): bool
    {
        return $role->delete();
    }
}
