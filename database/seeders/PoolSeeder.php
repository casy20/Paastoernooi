<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class PoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("pools")->insert([
            [
                'toernament_id' => 1,
                'name' => 'Voetbal groep 3/4 (gemengd)',
            ],
            [
                'toernament_id' => 1,
                'name' => 'Voetbal groep 5/6 (gemengd)',
            ],
            [
                'toernament_id' => 1,
                'name' => 'Voetbal groep 7/8 (gemengd)',
            ],
            [
                'toernament_id' => 1,
                'name' => 'Voetbal 1e klas (jongens/gemengd)',
            ],
            [
                'toernament_id' => 1,
                'name' => 'Voetbal 1e klas (meiden)',
            ],
            [
                'toernament_id' => 1,
                'name' => 'Lijnbal groep 7/8 (meiden)',
            ],
            [
                'toernament_id' => 1,
                'name' => 'Lijnbal 1e klas (meiden)',
            ],
        ]);
    }
}
