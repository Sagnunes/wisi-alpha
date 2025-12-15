<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\User;

final readonly class GetUsers
{

    public function __construct()
    {
    }

    public function handle(): array
    {
        $users = User::with(['roles:id,name,slug','status'])->orderBy('name')->get();

        return $users->map(function (User $user) {
            return [
                ...$user->toArray(),
                'can' => [
                    'delete' => auth()->user()?->can('delete', $user) ?? false,
                    'validate' => auth()->user()?->can('validate', $user) ?? false,
                ],
            ];
        })->toArray();
    }

}
