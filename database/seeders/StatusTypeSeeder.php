<?php

namespace Database\Seeders;

use App\Models\StatusType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusTypeSeeder extends Seeder
{
    /**
     *  a list of a status type to seed
     */
    private const STATUS_TYPE = [
        ['name' => 'Autenticação'],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect(self::STATUS_TYPE)->chunk(100)->each(fn($chunk) => StatusType::factory()->createMany($chunk));
    }
}
