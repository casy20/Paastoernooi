<?php

namespace App\Http\Controllers;

use App\Models\Matche;
use App\Models\Team;
use App\Models\Pool;
use App\Http\Requests\StoreMatcheRequest;
use App\Http\Requests\UpdateMatcheRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MatcheController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $Matches = Matche::all();
        return view('index', compact('Matches'));
    }

        public function voetbal(): View
    {
        $Matches = Matche::all();
        return view('voetbal', compact('Matches')); 
    }

    public function lijnbal(): View
    {
        $Matches = Matche::all();
        return view('lijnbal', compact('Matches')); 
    }

    /**
     * Toon alle gegenereerde wedstrijden (alleen lezen).
     */
    public function list(): View
    {
        $matches = Matche::with([
            'team1',
            'team1.pool',
            'team2',
            'team2.pool',
        ])->latest()->get();

        $teams = Team::with(['pool', 'school'])->orderBy('pool_id')->orderBy('name')->get();

        return view('wedstrijden', compact('matches', 'teams'));
    }

    /**
     * Toon de automatische generator.
     */
    public function generator(): View
    {
        $matches = Matche::with([
            'team1',
            'team1.pool',
            'team2',
            'team2.pool',
        ])->latest()->take(10)->get();
        
        $teams = Team::with(['pool', 'school'])->orderBy('pool_id')->orderBy('name')->get();
        
        return view('match_generen', compact('matches', 'teams'));
    }

    /**
     * Genereer alle round-robin wedstrijden voor alle pools in één keer.
     */
    public function generate(): RedirectResponse
    {
        // Verwijder eerst alle bestaande wedstrijden
        DB::table('matches')->truncate();
        
        // Haal alle pools op
        $pools = Pool::all();
        
        if ($pools->isEmpty()) {
            return back()->with('error', 'Geen pools gevonden. Voeg eerst pools toe.');
        }
        
        $totalMatchesCreated = 0;
        
        // Voor elke pool, genereer alle wedstrijden
        foreach ($pools as $pool) {
            // Haal alle teams op voor deze pool
            $poolTeams = Team::where('pool_id', $pool->id)->get();
            
            if ($poolTeams->count() < 2) {
                continue; // Sla pools over met minder dan 2 teams
            }
            
            // Genereer alle round-robin wedstrijden voor deze pool
            $matches = $this->generateRoundRobinMatches($poolTeams, $pool);
            
            // Maak de wedstrijden aan
            foreach ($matches as $matchData) {
                Matche::create($matchData);
                $totalMatchesCreated++;
            }
        }
        
        if ($totalMatchesCreated === 0) {
            return back()->with('error', 'Geen wedstrijden kunnen genereren. Zorg ervoor dat er minimaal 2 teams per pool zijn.');
        }
        
        return back()->with('success', "Alle wedstrijden gegenereerd! {$totalMatchesCreated} wedstrijden aangemaakt voor alle pools.");
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
                
                // Verhoog tijd voor volgende wedstrijd (duur + pauze)
                $currentTime->addMinutes($durationMinutes + $pauseMinutes);
                
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
                ];
                
                $matchNumber++;
            }
        }
        
        return $matches;
    }

    /**
     * Verwijder alle gegenereerde wedstrijden.
     */
    public function clear(): RedirectResponse
    {
        DB::table('matches')->truncate();
        return back()->with('success', 'Alle wedstrijden verwijderd.');
    }

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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMatcheRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Matche $matche)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Matche $matche)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMatcheRequest $request, Matche $matche)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matche $matche)
    {
        //
    }
}
