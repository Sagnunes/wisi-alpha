<?php

namespace App;

enum Role: int
{
    case SUPER_ADMIN = 1;

    public function getName(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'Administrador'
        };
    }
}
