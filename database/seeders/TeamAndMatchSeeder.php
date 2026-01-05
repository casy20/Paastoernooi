<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\Matche;
use App\Models\Pool;
use App\Models\School;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TeamAndMatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Maakt teams aan en genereert alle wedstrijden binnen elke pool.
     */
    public function run(): void
    {
        // Verwijder bestaande wedstrijden
        DB::table('matches')->truncate();
        
        // Haal alle pools op
        $pools = Pool::all();
        
        // Haal alle scholen op
        $schools = School::all();
        
        if ($schools->isEmpty()) {
            $this->command->warn('Geen scholen gevonden. Voer eerst SchoolSeeder uit.');
            return;
        }
        
        if ($pools->isEmpty()) {
            $this->command->warn('Geen pools gevonden. Voer eerst PoolSeeder uit.');
            return;
        }
        
        $teamNames = [
            'Tigers', 'Lions', 'Eagles', 'Wolves', 'Bears', 
            'Sharks', 'Falcons', 'Panthers', 'Hawks', 'Ravens'
        ];
        
        $referees = [
            'Piet Janssen', 'Sara de Boer', 'Anouk Visser', 'Mark Kuipers',
            'Jan van der Berg', 'Lisa Smit', 'Tom de Vries', 'Emma Bakker'
        ];
        
        $teamsCreated = 0;
        $totalMatchesCreated = 0;
        
        // Voor elke pool, maak teams aan en genereer wedstrijden
        foreach ($pools as $pool) {
            $this->command->info("Bezig met pool: {$pool->name}");
            
            // Bepaal aantal teams per pool (minimaal 3, maximaal 6)
            $teamsPerPool = rand(3, 6);
            
            // Haal bestaande teams op voor deze pool
            $existingTeams = Team::where('pool_id', $pool->id)->get();
            
            // Maak nieuwe teams aan als er niet genoeg zijn
            $teamsNeeded = $teamsPerPool - $existingTeams->count();
            
            if ($teamsNeeded > 0) {
                for ($i = 0; $i < $teamsNeeded; $i++) {
                    $school = $schools->random();
                    $teamName = $teamNames[array_rand($teamNames)] . ' ' . ($existingTeams->count() + $i + 1);
                    $referee = $referees[array_rand($referees)];
                    
                    Team::create([
                        'school_id' => $school->id,
                        'pool_id' => $pool->id,
                        'name' => $teamName,
                        'referee' => $referee,
                    ]);
                    
                    $teamsCreated++;
                }
            }
            
            // Haal alle teams op voor deze pool (bestaand + nieuw)
            $poolTeams = Team::where('pool_id', $pool->id)->get();
            
            if ($poolTeams->count() < 2) {
                $this->command->warn("Pool {$pool->name} heeft minder dan 2 teams. Sla over.");
                continue;
            }
            
            // Genereer alle mogelijke wedstrijden binnen deze pool (round-robin)
            $matches = $this->generateRoundRobinMatches($poolTeams, $pool);
            
            // Maak de wedstrijden aan
            $poolMatchesCreated = 0;
            foreach ($matches as $matchData) {
                Matche::create($matchData);
                $poolMatchesCreated++;
                $totalMatchesCreated++;
            }
            
            $this->command->info("  - {$poolTeams->count()} teams, {$poolMatchesCreated} wedstrijden gegenereerd voor deze pool");
        }
        
        $this->command->info("\nKlaar! {$teamsCreated} nieuwe teams aangemaakt, {$totalMatchesCreated} wedstrijden gegenereerd.");
    }
    
    /**
     * Genereer alle round-robin wedstrijden voor een set teams binnen een pool.
     * Elk team speelt één keer tegen elk ander team.
     */
    private function generateRoundRobinMatches($teams, Pool $pool): array
    {
        $matches = [];
        $teamArray = $teams->toArray();
        $teamCount = count($teamArray);
        
        // Bepaal duur en pauze op basis van pool naam
        [$durationMinutes, $pauseMinutes] = $this->getDurationAndPauseForPool($pool->name);
        
        // Starttijd voor de eerste wedstrijd
        $currentTime = Carbon::createFromTime(9, 0, 0); // Start om 09:00
        $field = 1;
        $matchNumber = 0;
        
        // Genereer alle combinaties (elke team tegen elke andere team, maar niet tegen zichzelf)
        for ($i = 0; $i < $teamCount; $i++) {
            for ($j = $i + 1; $j < $teamCount; $j++) {
                $team1 = $teamArray[$i];
                $team2 = $teamArray[$j];
                
                $startTime = (clone $currentTime)->format('H:i:s');
                $endTime = (clone $currentTime)->addMinutes($durationMinutes)->format('H:i:s');
                
                // Wissel van veld elke 3 wedstrijden
                if ($matchNumber > 0 && $matchNumber % 3 == 0) {
                    $field = ($field == 1) ? 2 : 1;
                }
                
                $matches[] = [
                    'team_1_id' => $team1['id'],
                    'team_2_id' => $team2['id'],
                    'team_1_score' => 0,
                    'team_2_score' => 0,
                    'field' => $field,
                    'referee' => $team1['referee'] ?? 'n.n.',
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'pause_minutes' => $pauseMinutes,
                    'type' => 'Round-Robin',
                    'tournament_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                
                // Verhoog tijd voor volgende wedstrijd (duur + pauze)
                $currentTime->addMinutes($durationMinutes + $pauseMinutes);
                $matchNumber++;
            }
        }
        
        return $matches;
    }
    
    /**
     * Bepaal duur en pauze op basis van pool naam.
     */
    private function getDurationAndPauseForPool(string $poolName): array
    {
        $map = [
            'Voetbal groep 3/4 (gemengd)' => [15, 5],
            'Voetbal groep 5/6 (gemengd)' => [15, 5],
            'Voetbal groep 7/8 (gemengd)' => [15, 5],
            'Voetbal 1e klas (meiden)' => [15, 5],
            'Voetbal 1e klas (jongens/gemengd)' => [15, 5],
            'Lijnbal groep 7/8 (meiden)' => [10, 2],
            'Lijnbal 1e klas (meiden)' => [12, 2],
        ];
        
        return $map[$poolName] ?? [15, 5];
    }
}

