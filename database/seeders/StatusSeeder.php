<?php

namespace Database\Seeders;

use App\Models\Status;
use App\StatusType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     *  a list of status to seed
     */
    private const STATUS_LIST = [

        // Users
        ['name' => 'Pending', 'status_type_id' => StatusType::USERS],
        ['name' => 'Active', 'status_type_id' => StatusType::USERS],
    ];


    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect(self::STATUS_LIST)->chunk(100)->each(fn ($chuck) => Status::factory()->createMany($chuck));
    }
}
