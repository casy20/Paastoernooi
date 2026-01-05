<?php

namespace Database\Seeders;

use App\Models\Pool;
use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Verwijdert alle bestaande teams en maakt 20 nieuwe teams aan voor de 7 groepen.
     */
    public function run(): void
    {
        // Verwijder alle bestaande teams
        DB::table('teams')->truncate();
        
        // Haal alle pools op
        $pools = Pool::all()->keyBy('name');
        $schools = School::all();
        
        if ($schools->isEmpty()) {
            $this->command->warn('Geen scholen gevonden. Voer eerst SchoolSeeder uit.');
            return;
        }
        
        // Team namen en scheidsrechters
        $teamNames = [
            'Tigers', 'Lions', 'Eagles', 'Wolves', 'Bears', 
            'Sharks', 'Falcons', 'Panthers', 'Hawks', 'Ravens',
            'Thunder', 'Storm', 'Lightning', 'Fire', 'Ice',
            'Dragons', 'Warriors', 'Champions', 'Victors', 'Heroes'
        ];
        
        $referees = [
            'Piet Janssen', 'Sara de Boer', 'Anouk Visser', 'Mark Kuipers',
            'Jan van der Berg', 'Lisa Smit', 'Tom de Vries', 'Emma Bakker',
            'Daan Mulder', 'Sophie Jansen', 'Lucas de Wit', 'Eva van Dijk'
        ];
        
        // Definieer de groepen en aantal teams per groep (totaal 20 teams)
        $groups = [
            'Voetbal groep 3/4 (gemengd)' => 3,
            'Voetbal groep 5/6 (gemengd)' => 3,
            'Voetbal groep 7/8 (gemengd)' => 3,
            'Voetbal 1e klas (jongens/gemengd)' => 3,
            'Voetbal 1e klas (meiden)' => 2,
            'Lijnbal groep 7/8 (meiden)' => 3,
            'Lijnbal 1e klas (meiden)' => 3,
        ];
        
        $teamCounter = 0;
        
        foreach ($groups as $poolName => $teamsPerGroup) {
            $pool = $pools->get($poolName);
            
            if (!$pool) {
                $this->command->warn("Pool '{$poolName}' niet gevonden. Sla over.");
                continue;
            }
            
            // Maak teams aan voor deze groep
            for ($i = 0; $i < $teamsPerGroup; $i++) {
                $school = $schools->random();
                $teamName = $teamNames[$teamCounter % count($teamNames)] . ' ' . ($i + 1);
                $referee = $referees[array_rand($referees)];
                
                DB::table('teams')->insert([
                    'school_id' => $school->id,
                    'pool_id' => $pool->id,
                    'name' => $teamName,
                    'referee' => $referee,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                $teamCounter++;
            }
            
            $this->command->info("{$teamsPerGroup} teams aangemaakt voor: {$poolName}");
        }
        
        $this->command->info("\nTotaal: {$teamCounter} teams aangemaakt voor alle groepen.");
    }
}
