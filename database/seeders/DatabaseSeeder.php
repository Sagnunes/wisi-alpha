<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Status;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            StatusTypeSeeder::class,
            StatusSeeder::class,
        ]);

        $dev = User::factory()->create([
            'name' => 'Developer',
            'email' => 'dev@test.com',
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
            'status_id' => Status::ACTIVE,
        ]);

        $adminRole = Role::factory()->create(
            [
                'name' => 'Administrador',
                'slug' => 'administrador'
            ]
        );

        $dev->roles()->attach($adminRole);
    }
}
