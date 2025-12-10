<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Contracts\DTO\DTOInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

final readonly class RoleDTO implements DTOInterface
{
    public function __construct(public string      $name,
                                public string      $slug,
                                public ?int        $id = null,
                                public ?string     $created_at = null,
                                public ?string     $updated_at = null,
                                public ?Collection $permissions = null
    )
    {
    }

    public static function fromRequest(array $data): DTOInterface
    {
        return new self(
            name: $data['name'],
            slug: Str::slug($data['name']),

        );
    }

    public static function fromModel(Model $model): DTOInterface
    {
        return new self(
            name: $model->name,
            slug: $model->slug,
            id: $model->id,
            created_at: $model->created_at->format('Y-m-d'),
            updated_at: $model->updated_at->format('Y-m-d'),
            permissions: $model->permissions,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'permissions' => collect($this->permissions ?? [])->map(fn($permission): array => [
                'id' => $permission->id,
                'name' => $permission->name,
                'slug' => $permission->slug,
            ])->toArray(),
        ];
    }
}
