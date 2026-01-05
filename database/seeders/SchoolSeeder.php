<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('schools')->insert([
            [
                'name' => 'Basisschool De Horizon',
                'school_type' => 'Basisschool',
                'creator_id' => null,
            ],
            [
                'name' => 'OBS De Brug',
                'school_type' => 'Basisschool',
                'creator_id' => null,
            ],
            [
                'name' => 'CSG Noord',
                'school_type' => 'Middelbare school',
                'creator_id' => null,
            ],
            [
                'name' => 'Lyceum Zuid',
                'school_type' => 'Middelbare school',
                'creator_id' => null,
            ],
        ]);
    }
}
