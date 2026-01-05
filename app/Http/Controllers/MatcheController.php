<?php

namespace App\Http\Controllers;

use App\Models\Matche;
use App\Models\Team;
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

        return view('wedstrijden', compact('matches'));
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
        return view('match_generen', compact('matches'));
    }

    /**
     * Genereer een wedstrijd op basis van 2 willekeurige teams.
     */
    public function generate(): RedirectResponse
    {
        $teams = Team::with('pool')->inRandomOrder()->take(2)->get();

        if ($teams->count() < 2) {
            return back()->with('error', 'Niet genoeg teams om een wedstrijd te maken.');
        }

        $poolName = $teams[0]->pool->name ?? '';
        [$durationMinutes, $pauseMinutes] = $this->getDurationAndPauseForPool($poolName);

        $start = Carbon::now();
        $end = (clone $start)->addMinutes($durationMinutes);

        $match = Matche::create([
            'team_1_id' => $teams[0]->id,
            'team_2_id' => $teams[1]->id,
            'team_1_score' => 0,
            'team_2_score' => 0,
            'field' => 1,
            'referee' => $teams[0]->referee ?? 'n.n.',
            'start_time' => $start->format('H:i:s'),
            'end_time' => $end->format('H:i:s'),
            'pause_minutes' => $pauseMinutes,
            'type' => 'Automatisch',
            'tournament_id' => 1,
        ]);

        return back()->with('success', "Wedstrijd {$match->id} gegenereerd: {$teams[0]->name} vs {$teams[1]->name}");
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
