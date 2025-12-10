<?php
declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\User;

final readonly class DeleteUser
{
    public function __construct()
    {
    }

    public function handle(User $user): bool
    {
        return $user->delete();
    }
}
