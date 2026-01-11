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
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MatcheController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $Matches = Matche::all();
        
        // Check of er voltooide wedstrijden zijn (met scores, inclusief 0-0 als geldige uitslag)
        $hasCompletedMatches = Matche::whereNotNull('team_1_score')
            ->whereNotNull('team_2_score')
            ->exists();
        
        return view('index', compact('Matches', 'hasCompletedMatches'));
    }
    
    /**
     * Toon alle voltooide wedstrijden met scores (scorebord).
     */
    public function scores(): View
    {
        // Haal alle voltooide wedstrijden op (met scores, inclusief 0-0 als geldige uitslag)
        // Haal alle voltooide wedstrijden op (met scores, inclusief 0-0 als geldige uitslag)
        // Exclusief wedstrijden van "Poule A" pools
        $completedMatches = Matche::with([
            'team1',
            'team1.pool',
            'team1.school',
            'team2',
            'team2.pool',
            'team2.school',
        ])->whereNotNull('team_1_score')
          ->whereNotNull('team_2_score')
          ->whereHas('team1.pool', function($query) {
              $query->where('name', 'not like', 'Poule A%');
          })
          ->orderBy('start_time', 'asc')
          ->get();
        
        return view('scores', compact('completedMatches'));
    }
    
    /**
     * Bereken standen voor een set wedstrijden.
     */
    private function calculateStandings($matches)
    {
        $teams = [];
        
        foreach ($matches as $match) {
            $team1Id = $match->team_1_id;
            $team2Id = $match->team_2_id;
            
            // Initialiseer team 1
            if (!isset($teams[$team1Id])) {
                $teams[$team1Id] = [
                    'team' => $match->team1,
                    'points' => 0,
                    'wins' => 0,
                    'draws' => 0,
                    'losses' => 0,
                    'goalsFor' => 0,
                    'goalsAgainst' => 0,
                    'goalDifference' => 0,
                ];
            }
            
            // Initialiseer team 2
            if (!isset($teams[$team2Id])) {
                $teams[$team2Id] = [
                    'team' => $match->team2,
                    'points' => 0,
                    'wins' => 0,
                    'draws' => 0,
                    'losses' => 0,
                    'goalsFor' => 0,
                    'goalsAgainst' => 0,
                    'goalDifference' => 0,
                ];
            }
            
            // Update statistieken team 1
            $teams[$team1Id]['goalsFor'] += $match->team_1_score ?? 0;
            $teams[$team1Id]['goalsAgainst'] += $match->team_2_score ?? 0;
            
            if ($match->team_1_score > $match->team_2_score) {
                $teams[$team1Id]['wins']++;
                $teams[$team1Id]['points'] += 3;
            } elseif ($match->team_1_score == $match->team_2_score) {
                $teams[$team1Id]['draws']++;
                $teams[$team1Id]['points'] += 1;
            } else {
                $teams[$team1Id]['losses']++;
            }
            
            // Update statistieken team 2
            $teams[$team2Id]['goalsFor'] += $match->team_2_score ?? 0;
            $teams[$team2Id]['goalsAgainst'] += $match->team_1_score ?? 0;
            
            if ($match->team_2_score > $match->team_1_score) {
                $teams[$team2Id]['wins']++;
                $teams[$team2Id]['points'] += 3;
            } elseif ($match->team_2_score == $match->team_1_score) {
                $teams[$team2Id]['draws']++;
                $teams[$team2Id]['points'] += 1;
            } else {
                $teams[$team2Id]['losses']++;
            }
        }
        
        // Bereken doelsaldo
        foreach ($teams as &$team) {
            $team['goalDifference'] = $team['goalsFor'] - $team['goalsAgainst'];
        }
        
        // Sorteer op punten, doelsaldo, goals voor
        usort($teams, function($a, $b) {
            if ($a['points'] != $b['points']) {
                return $b['points'] - $a['points'];
            }
            if ($a['goalDifference'] != $b['goalDifference']) {
                return $b['goalDifference'] - $a['goalDifference'];
            }
            return $b['goalsFor'] - $a['goalsFor'];
        });
        
        return $teams;
    }

        public function voetbal(): View
    {
        // Haal alleen voetbal wedstrijden op (pools die "Voetbal" bevatten, exclusief "Poule A")
        $matches = Matche::with([
            'team1',
            'team1.pool',
            'team2',
            'team2.pool',
        ])->whereHas('team1.pool', function($query) {
            $query->where('name', 'like', 'Voetbal%')
                  ->where('name', 'not like', 'Poule A%');
        })->orderBy('start_time', 'asc')->get();

        return view('voetbal', compact('matches')); 
    }

    public function lijnbal(): View
    {
        // Haal alleen lijnbal wedstrijden op (pools die "Lijnbal" bevatten, exclusief "Poule A")
        $matches = Matche::with([
            'team1',
            'team1.pool',
            'team2',
            'team2.pool',
        ])->whereHas('team1.pool', function($query) {
            $query->where('name', 'like', 'Lijnbal%')
                  ->where('name', 'not like', 'Poule A%');
        })->orderBy('start_time', 'asc')->get();

        return view('lijnbal', compact('matches')); 
    }

    /**
     * Toon alle gegenereerde wedstrijden (voor iedereen, maar alleen admins kunnen sorteren en scores bewerken).
     * Toont alleen niet-voltooide wedstrijden (zonder scores).
     */
    public function list(): View
    {
        // Alleen admins kunnen sorteren
        $sortBy = 'time'; // Standaard sortering
        if (Auth::check() && Auth::user()->admin == 1) {
            $sortBy = request()->get('sort', 'time'); // time, score, pool
        }
        
        $matches = Matche::with([
            'team1',
            'team1.pool',
            'team2',
            'team2.pool',
        ])->whereHas('team1.pool', function($query) {
            // Exclusief "Poule A" pools
            $query->where('name', 'not like', 'Poule A%');
        })->where(function($query) {
            // Toon alleen wedstrijden die nog niet voltooid zijn (geen scores of één score ontbreekt)
            $query->whereNull('team_1_score')
                  ->orWhereNull('team_2_score');
        });
        
        // Sorteer op basis van parameter
        switch ($sortBy) {
            case 'score':
                // Sorteer op totaal aantal goals (team_1_score + team_2_score)
                $matches = $matches->orderByRaw('(COALESCE(team_1_score, 0) + COALESCE(team_2_score, 0)) DESC')
                                   ->orderBy('start_time', 'asc');
                break;
            case 'pool':
                $matches = $matches->join('teams', 'matches.team_1_id', '=', 'teams.id')
                                   ->join('pools', 'teams.pool_id', '=', 'pools.id')
                                   ->where('pools.name', 'not like', 'Poule A%')
                                   ->orderBy('pools.name')
                                   ->orderBy('matches.start_time')
                                   ->select('matches.*');
                break;
            case 'time':
            default:
                $matches = $matches->orderBy('start_time', 'asc');
                break;
        }
        
        $matches = $matches->get();

        // Filter teams: alleen teams uit echte pools (niet "Poule A")
        $teams = Team::with(['pool', 'school'])
            ->whereHas('pool', function($query) {
                $query->where('name', 'not like', 'Poule A%');
            })
            ->orderBy('pool_id')
            ->orderBy('name')
            ->get();

        return view('wedstrijden', compact('matches', 'teams', 'sortBy'));
    }
    
    /**
     * Update score van een wedstrijd (alleen voor admins).
     */
    public function updateScore($id)
    {
        // Check of gebruiker admin is
        if (!Auth::check() || Auth::user()->admin != 1) {
            if (request()->expectsJson()) {
                return response()->json(['error' => 'Toegang geweigerd'], 403);
            }
            abort(403, 'Toegang geweigerd. Alleen admins kunnen scores bijwerken.');
        }
        
        $match = Matche::findOrFail($id);
        
        $match->team_1_score = request()->input('team_1_score', 0);
        $match->team_2_score = request()->input('team_2_score', 0);
        $match->save();
        
        // Automatische generatie van volgende ronde is uitgeschakeld
        // Admin kan handmatig volgende ronde genereren via de knop
        
        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Score bijgewerkt!']);
        }
        
        return back()->with('success', 'Score bijgewerkt!');
    }
    
    /**
     * Genereer volgende ronde wedstrijden handmatig (alleen voor admins).
     */
    public function generateNextRound(): RedirectResponse
    {
        // Check of gebruiker admin is
        if (!Auth::check() || Auth::user()->admin != 1) {
            abort(403, 'Toegang geweigerd. Alleen admins kunnen volgende ronde genereren.');
        }
        
        // Haal alle pools op (exclusief "Poule A")
        $pools = Pool::where('name', 'not like', 'Poule A%')->get();
        $roundsGenerated = 0;
        $errorMessages = [];
        
        if ($pools->isEmpty()) {
            return back()->with('error', 'Geen pools gevonden.');
        }
        
        foreach ($pools as $pool) {
            // Haal alle teams in deze pool op
            $poolTeams = Team::where('pool_id', $pool->id)->get();
            
            if ($poolTeams->count() < 2) {
                continue; // Sla pools over met minder dan 2 teams
            }
            
            // Haal alle eerste ronde wedstrijden op voor deze pool
            // Check zowel team1 als team2 omdat een wedstrijd beide teams kan hebben in dezelfde pool
            $roundRobinMatches = Matche::whereIn('type', ['Eerste ronde', 'Round-Robin'])
                ->where(function($query) use ($pool) {
                    $query->whereHas('team1', function($q) use ($pool) {
                        $q->where('pool_id', $pool->id);
                    })->orWhereHas('team2', function($q) use ($pool) {
                        $q->where('pool_id', $pool->id);
                    });
                })->get();
            
            if ($roundRobinMatches->isEmpty()) {
                continue; // Geen eerste ronde wedstrijden gevonden
            }
            
            // Check of alle eerste ronde wedstrijden zijn voltooid
            $incompleteMatches = $roundRobinMatches->filter(function($m) {
                return $m->team_1_score === null || $m->team_2_score === null;
            });
            
            if ($incompleteMatches->count() > 0) {
                $errorMessages[] = "Pool '{$pool->name}': {$incompleteMatches->count()} wedstrijden nog niet voltooid.";
                continue;
            }
            
            // Check of er al volgende ronde wedstrijden zijn en verwijder deze
            $nextRoundExists = Matche::whereIn('type', ['Halve Finale', 'Finale', 'Kwartfinale'])
                ->where(function($query) use ($pool) {
                    $query->whereHas('team1', function($q) use ($pool) {
                        $q->where('pool_id', $pool->id);
                    })->orWhereHas('team2', function($q) use ($pool) {
                        $q->where('pool_id', $pool->id);
                    });
                })->exists();
            
            // Als volgende ronde al bestaat, verwijder deze eerst
            if ($nextRoundExists) {
                Matche::whereIn('type', ['Halve Finale', 'Finale', 'Kwartfinale'])
                    ->where(function($query) use ($pool) {
                        $query->whereHas('team1', function($q) use ($pool) {
                            $q->where('pool_id', $pool->id);
                        })->orWhereHas('team2', function($q) use ($pool) {
                            $q->where('pool_id', $pool->id);
                        });
                    })->delete();
            }
            
            // Genereer volgende ronde voor deze pool
            try {
                $this->generateNextRoundForPool($pool, $poolTeams, $roundRobinMatches);
                $roundsGenerated++;
            } catch (\Exception $e) {
                $errorMessages[] = "Pool '{$pool->name}': " . $e->getMessage();
            }
        }
        
        if ($roundsGenerated > 0) {
            $message = "Volgende ronde wedstrijden zijn aangemaakt voor {$roundsGenerated} pool(s)!";
            if (!empty($errorMessages)) {
                $message .= "\n\nLet op: " . implode(" ", $errorMessages);
            }
            return back()->with('success', $message);
        } else {
            $errorMessage = "Geen volgende ronde kunnen genereren.";
            if (!empty($errorMessages)) {
                $errorMessage .= " " . implode(" ", $errorMessages);
            } else {
                $errorMessage .= " Controleer of alle eerste ronde wedstrijden voltooid zijn.";
            }
            return back()->with('error', $errorMessage);
        }
    }
    
    /**
     * Check of alle eerste ronde wedstrijden in een pool voltooid zijn en genereer volgende ronde.
     */
    private function checkAndGenerateNextRound(Matche $match): void
    {
        // Haal de pool op van team1
        $pool = $match->team1->pool;
        if (!$pool) {
            return;
        }
        
        // Haal alle teams in deze pool op
        $poolTeams = Team::where('pool_id', $pool->id)->get();
        
        // Haal alle eerste ronde wedstrijden op voor deze pool
        $roundRobinMatches = Matche::whereHas('team1', function($query) use ($pool) {
            $query->where('pool_id', $pool->id);
        })->whereIn('type', ['Eerste ronde', 'Round-Robin'])->get();
        
        // Check of alle eerste ronde wedstrijden zijn voltooid (hebben scores)
        $allCompleted = $roundRobinMatches->every(function($m) {
            return $m->team_1_score !== null && $m->team_2_score !== null;
        });
        
        if (!$allCompleted || $roundRobinMatches->isEmpty()) {
            return; // Nog niet alle wedstrijden voltooid
        }
        
        // Check of er al volgende ronde wedstrijden zijn
        $nextRoundExists = Matche::whereHas('team1', function($query) use ($pool) {
            $query->where('pool_id', $pool->id);
        })->whereIn('type', ['Halve Finale', 'Finale', 'Kwartfinale'])->exists();
        
        if ($nextRoundExists) {
            return; // Volgende ronde bestaat al
        }
        
        // Bereken de stand en genereer volgende ronde
        $this->generateNextRoundForPool($pool, $poolTeams, $roundRobinMatches);
    }
    
    /**
     * Genereer volgende ronde wedstrijden op basis van de stand.
     */
    private function generateNextRoundForPool(Pool $pool, $teams, $roundRobinMatches): void
    {
        // Bereken stand voor elk team
        $standings = [];
        
        foreach ($teams as $team) {
            $wins = 0;
            $draws = 0;
            $losses = 0;
            $goalsFor = 0;
            $goalsAgainst = 0;
            $points = 0;
            
            // Bereken statistieken voor dit team
            foreach ($roundRobinMatches as $m) {
                if ($m->team_1_id == $team->id) {
                    $goalsFor += $m->team_1_score ?? 0;
                    $goalsAgainst += $m->team_2_score ?? 0;
                    if ($m->team_1_score > $m->team_2_score) {
                        $wins++;
                        $points += 3;
                    } elseif ($m->team_1_score == $m->team_2_score) {
                        $draws++;
                        $points += 1;
                    } else {
                        $losses++;
                    }
                } elseif ($m->team_2_id == $team->id) {
                    $goalsFor += $m->team_2_score ?? 0;
                    $goalsAgainst += $m->team_1_score ?? 0;
                    if ($m->team_2_score > $m->team_1_score) {
                        $wins++;
                        $points += 3;
                    } elseif ($m->team_2_score == $m->team_1_score) {
                        $draws++;
                        $points += 1;
                    } else {
                        $losses++;
                    }
                }
            }
            
            $standings[] = [
                'team' => $team,
                'points' => $points,
                'wins' => $wins,
                'draws' => $draws,
                'losses' => $losses,
                'goalsFor' => $goalsFor,
                'goalsAgainst' => $goalsAgainst,
                'goalDifference' => $goalsFor - $goalsAgainst,
            ];
        }
        
        // Sorteer op punten, dan doelsaldo, dan goals voor
        usort($standings, function($a, $b) {
            if ($a['points'] != $b['points']) {
                return $b['points'] - $a['points'];
            }
            if ($a['goalDifference'] != $b['goalDifference']) {
                return $b['goalDifference'] - $a['goalDifference'];
            }
            return $b['goalsFor'] - $a['goalsFor'];
        });
        
        // Bepaal aantal teams dat doorgaat (top 2, 4 of 8)
        $teamCount = count($standings);
        $teamsToAdvance = min(4, $teamCount); // Top 4 teams gaan door (of minder als er minder teams zijn)
        
        if ($teamsToAdvance < 2) {
            return; // Niet genoeg teams voor volgende ronde
        }
        
        // Haal de beste teams op
        $advancingTeams = array_slice($standings, 0, $teamsToAdvance);
        
        // Bepaal type volgende ronde
        $nextRoundType = 'Halve Finale';
        if ($teamsToAdvance == 2) {
            $nextRoundType = 'Finale';
        } elseif ($teamsToAdvance == 4) {
            $nextRoundType = 'Halve Finale';
        } elseif ($teamsToAdvance >= 8) {
            $nextRoundType = 'Kwartfinale';
        }
        
        // Genereer wedstrijden voor volgende ronde
        $this->generateKnockoutMatches($advancingTeams, $pool, $nextRoundType);
    }
    
    /**
     * Genereer knock-out wedstrijden voor de volgende ronde.
     */
    private function generateKnockoutMatches(array $teams, Pool $pool, string $roundType): void
    {
        [$durationMinutes, $pauseMinutes] = $this->getDurationAndPauseForPool($pool->name);
        
        // Bepaal starttijd (na laatste eerste ronde wedstrijd)
        $lastMatch = Matche::whereHas('team1', function($query) use ($pool) {
            $query->where('pool_id', $pool->id);
        })->whereIn('type', ['Eerste ronde', 'Round-Robin'])->orderBy('end_time', 'desc')->first();
        
        $startTime = $lastMatch ? Carbon::parse($lastMatch->end_time)->addMinutes($pauseMinutes) : Carbon::createFromTime(14, 0, 0);
        
        $field = 1;
        $matchNumber = 0;
        
        // Genereer wedstrijden: beste vs slechtste, 2e beste vs 2e slechtste, etc.
        for ($i = 0; $i < count($teams) / 2; $i++) {
            $team1 = $teams[$i]['team'];
            $team2 = $teams[count($teams) - 1 - $i]['team'];
            
            $currentStartTime = (clone $startTime)->addMinutes($matchNumber * ($durationMinutes + $pauseMinutes));
            
            Matche::create([
                'team_1_id' => $team1->id,
                'team_2_id' => $team2->id,
                'team_1_score' => null,
                'team_2_score' => null,
                'field' => $field,
                'referee' => $team1->referee ?? 'n.n.',
                'start_time' => $currentStartTime->format('H:i:s'),
                'end_time' => $currentStartTime->copy()->addMinutes($durationMinutes)->format('H:i:s'),
                'pause_minutes' => $pauseMinutes,
                'type' => $roundType,
                'tournament_id' => 1,
            ]);
            
            $matchNumber++;
            if ($matchNumber % 2 == 0) {
                $field = ($field == 1) ? 2 : 1;
            }
        }
    }

    /**
     * Genereer alleen eerste ronde wedstrijden voor alle pools (begin van toernooi).
     * Verwijdert alleen bestaande eerste ronde wedstrijden, behoudt volgende rondes.
     */
    public function generate(): RedirectResponse
    {
        // Check of gebruiker admin is
        if (!Auth::check() || Auth::user()->admin != 1) {
            abort(403, 'Toegang geweigerd. Alleen admins hebben toegang tot deze pagina.');
        }
        
        // Verwijder alleen bestaande eerste ronde wedstrijden, behoud volgende rondes
        Matche::where('type', 'Eerste ronde')->orWhere('type', 'Round-Robin')->delete();
        
        // Haal alle pools op (exclusief "Poule A")
        $pools = Pool::where('name', 'not like', 'Poule A%')->get();
        
        if ($pools->isEmpty()) {
            return back()->with('error', 'Geen pools gevonden. Voeg eerst pools toe.');
        }
        
        // Verzamel alle matches van alle pools eerst (zonder tijd/veld)
        $allMatches = [];
        foreach ($pools as $pool) {
            // Haal alle teams op voor deze pool
            $poolTeams = Team::where('pool_id', $pool->id)->get();

            if ($poolTeams->count() < 2) {
                continue; // Sla pools over met minder dan 2 teams
            }
            
            // Genereer alleen eerste ronde wedstrijden voor deze pool (zonder tijd/veld)
            $matches = $this->generateRoundRobinMatches($poolTeams, $pool);
            $allMatches = array_merge($allMatches, $matches);
        }
        
        if (empty($allMatches)) {
            return back()->with('error', 'Geen wedstrijden kunnen genereren. Zorg ervoor dat er minimaal 2 teams per pool zijn.');
        }
        
        // Plan alle wedstrijden sequentieel met correcte veldverdeling
        $this->scheduleMatches($allMatches);
        
        $totalMatchesCreated = count($allMatches);
        return back()->with('success', "Eerste ronde wedstrijden gegenereerd! {$totalMatchesCreated} wedstrijden aangemaakt.");
    }

    /**
     * Genereer alle eerste ronde wedstrijden voor een set teams binnen een pool.
     * Elk team speelt één keer tegen elk ander team.
     * Retourneert matches zonder tijd/veld (wordt later toegewezen).
     */
    private function generateRoundRobinMatches($teams, Pool $pool): array
    {
        $matches = [];
        $teamArray = $teams->toArray();
        $teamCount = count($teamArray);
        
        // Bepaal duur en pauze op basis van pool naam
        [$durationMinutes, $pauseMinutes] = $this->getDurationAndPauseForPool($pool->name);
        
        // Genereer alle combinaties (elke team tegen elke andere team, maar niet tegen zichzelf)
        for ($i = 0; $i < $teamCount; $i++) {
            for ($j = $i + 1; $j < $teamCount; $j++) {
                $team1 = $teamArray[$i];
                $team2 = $teamArray[$j];
                
                $matches[] = [
                    'team_1_id' => $team1['id'],
                    'team_2_id' => $team2['id'],
                    'team_1_score' => null,
                    'team_2_score' => null,
                    'referee' => $team1['referee'] ?? 'n.n.',
                    'pause_minutes' => $pauseMinutes,
                    'duration_minutes' => $durationMinutes, // Sla duur op voor later gebruik
                    'type' => 'Eerste ronde',
                    'tournament_id' => 1,
                ];
            }
        }
        
        return $matches;
    }
    
    /**
     * Plan alle wedstrijden sequentieel met correcte veldverdeling.
     * Veld 1 en 2 worden afwisselend gebruikt.
     */
    private function scheduleMatches(array $matches): void
    {
        // Start om 09:00
        $currentTime = Carbon::createFromTime(9, 0, 0);
        $field = 1; // Begin met veld 1
        
        foreach ($matches as $match) {
            $durationMinutes = $match['duration_minutes'] ?? 15;
            $pauseMinutes = $match['pause_minutes'] ?? 5;
            
            $startTime = (clone $currentTime)->format('H:i:s');
            $endTime = (clone $currentTime)->addMinutes($durationMinutes)->format('H:i:s');
            
            // Maak de wedstrijd aan met toegewezen tijd en veld
            Matche::create([
                'team_1_id' => $match['team_1_id'],
                'team_2_id' => $match['team_2_id'],
                'team_1_score' => $match['team_1_score'],
                'team_2_score' => $match['team_2_score'],
                'field' => $field,
                'referee' => $match['referee'],
                'start_time' => $startTime,
                'end_time' => $endTime,
            'pause_minutes' => $pauseMinutes,
                'type' => $match['type'],
                'tournament_id' => $match['tournament_id'],
            ]);
            
            // Verhoog tijd voor volgende wedstrijd (duur + pauze)
            $currentTime->addMinutes($durationMinutes + $pauseMinutes);
            
            // Wissel veld af (1 -> 2 -> 1 -> 2, etc.)
            $field = ($field == 1) ? 2 : 1;
        }
    }

    /**
     * Toon formulier voor handmatig volgende ronde wedstrijd aanmaken.
     */
    public function manualNextRound(): View
    {
        // Check of gebruiker admin is
        if (!Auth::check() || Auth::user()->admin != 1) {
            abort(403, 'Toegang geweigerd. Alleen admins hebben toegang tot deze pagina.');
        }
        
        // Filter teams: alleen teams uit echte pools (niet "Poule A")
        $teams = Team::with(['pool', 'school'])
            ->whereHas('pool', function($query) {
                $query->where('name', 'not like', 'Poule A%');
            })
            ->orderBy('pool_id')
            ->orderBy('name')
            ->get();
        
        // Filter pools: alleen echte pools (niet "Poule A")
        $pools = Pool::where('name', 'not like', 'Poule A%')->get();
        
        // Haal alle unieke scheidsrechters op uit teams
        $referees = Team::whereHas('pool', function($query) {
                $query->where('name', 'not like', 'Poule A%');
            })
            ->distinct()
            ->orderBy('referee')
            ->pluck('referee')
            ->filter()
            ->values();
        
        return view('match_handmatig', compact('teams', 'pools', 'referees'));
    }
    
    /**
     * Sla handmatig gemaakte wedstrijd op.
     */
    public function storeManualMatch(): RedirectResponse
    {
        // Check of gebruiker admin is
        if (!Auth::check() || Auth::user()->admin != 1) {
            abort(403, 'Toegang geweigerd. Alleen admins kunnen wedstrijden aanmaken.');
        }
        
        $validated = request()->validate([
            'team_1_id' => 'required|exists:teams,id',
            'team_2_id' => 'required|exists:teams,id|different:team_1_id',
            'field' => 'required|integer|min:1|max:10',
            'referee' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'pause_minutes' => 'nullable|integer|min:0',
            'type' => 'required|string|in:Halve Finale,Finale,Kwartfinale,Eerste ronde,Round-Robin',
        ]);
        
        Matche::create([
            'team_1_id' => $validated['team_1_id'],
            'team_2_id' => $validated['team_2_id'],
            'team_1_score' => null,
            'team_2_score' => null,
            'field' => $validated['field'],
            'referee' => $validated['referee'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'pause_minutes' => $validated['pause_minutes'] ?? 0,
            'type' => $validated['type'],
            'tournament_id' => 1,
        ]);

        return back()->with('success', 'Wedstrijd handmatig aangemaakt!');
    }

    /**
     * Verwijder alle gegenereerde wedstrijden.
     */
    /**
     * Verwijder alleen volgende ronde wedstrijden (Halve Finale, Finale, Kwartfinale).
     */
    public function clearNextRound(): RedirectResponse
    {
        // Check of gebruiker admin is
        if (!Auth::check() || Auth::user()->admin != 1) {
            abort(403, 'Toegang geweigerd. Alleen admins kunnen wedstrijden verwijderen.');
        }
        
        $deleted = Matche::whereIn('type', ['Halve Finale', 'Finale', 'Kwartfinale'])->delete();
        
        return back()->with('success', "{$deleted} volgende ronde wedstrijden verwijderd.");
    }
    
    public function clear(): RedirectResponse
    {
        // Check of gebruiker admin is
        if (!Auth::check() || Auth::user()->admin != 1) {
            abort(403, 'Toegang geweigerd. Alleen admins hebben toegang tot deze pagina.');
        }
        
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
    public function destroy($id)
    {
        // Check of gebruiker admin is
        if (!Auth::check() || Auth::user()->admin != 1) {
            abort(403, 'Toegang geweigerd. Alleen admins kunnen wedstrijden verwijderen.');
        }
        
        $match = Matche::findOrFail($id);
        $match->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Wedstrijd verwijderd.'
        ]);
    }
}
