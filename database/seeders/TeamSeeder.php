<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('teams')->insert([
            [
                'school_id' => 1,
                'referee' => 'Piet Janssen',
                'name' => 'Horizon Tigers',
                'pool_id' => 1,
            ],
            [
                'school_id' => 2,
                'referee' => 'Sara de Boer',
                'name' => 'Brug United',
                'pool_id' => 2,
            ],
            [
                'school_id' => 3,
                'referee' => 'Anouk Visser',
                'name' => 'CSG Noord Stars',
                'pool_id' => 3,
            ],
            [
                'school_id' => 4,
                'referee' => 'Mark Kuipers',
                'name' => 'Lyceum Zuid Lions',
                'pool_id' => 4,
            ],
        ]);
    }
}
