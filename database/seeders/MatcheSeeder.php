<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class MatcheSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('matches')->insert([
            [
                'team_1_id' => 1,
                'team_2_id' => 2,
                'team_1_score' => 3,
                'team_2_score' => 2,
                'field' => 1,
                'referee' => 'John Doe',
                'start_time' => '14:00:00',
                'type' => 'Quarterfinal',
                'tournament_id' => 1,
            ],
            [
                'team_1_id' => 3,
                'team_2_id' => 4,
                'team_1_score' => 1,
                'team_2_score' => 1,
                'field' => 2,
                'referee' => 'Jane Smith',
                'start_time' => '16:00:00',
                'type' => 'Quarterfinal',
                'tournament_id' => 1,
            ],
        ]);
    }
}
