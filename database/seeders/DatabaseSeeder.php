<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\SchoolSeeder;
use Database\Seeders\PoolSeeder;
use Database\Seeders\TeamSeeder;
use Database\Seeders\MatcheSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            SchoolSeeder::class,
            PoolSeeder::class,
            TeamSeeder::class,
            // TeamAndMatchSeeder genereert teams en alle wedstrijden automatisch
            // MatcheSeeder::class, // Uitgecommentarieerd omdat TeamAndMatchSeeder dit doet
        ]);
    }
}
