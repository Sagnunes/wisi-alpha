<?php

declare(strict_types=1);

namespace App\Actions\Permissions;

use App\Models\Permission;

final readonly class DeletePermission
{
    public function __construct()
    {
    }

    public function handle(Permission $permission): bool
    {
        return $permission->delete();
    }
}
