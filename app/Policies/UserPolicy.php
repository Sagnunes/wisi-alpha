<?php

namespace App\Policies;

use App\Models\User;
use App\Role;
use App\Status;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */

    public function before(User $user, $ability): ?bool
    {
        if ($user->hasRole(\App\Role::SUPER_ADMIN->getName()))
            return true;
        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view-users');
    }

    public function delete(User $currentUser, User $targetUser): bool
    {
        return $currentUser->id !== $targetUser->id && $currentUser->hasPermission('delete-users');
    }

    public function validate(User $currentUser, User $targetUser): bool
    {
        return $currentUser->id !== $targetUser->id && $targetUser->status_id !== Status::PENDING->value && $currentUser->hasPermission('validate-users');
    }
}
