<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\School;
use App\Models\Pool;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        return view("index", compact("teams"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schools = School::all();
        $pools = Pool::all();

        return view('team_create', compact('schools', 'pools'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'school_id' => 'required|integer',
            'referee' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'pool_id' => 'required|integer',
        ]);

        $team = Team::create($validatedData);
        return redirect()->route('teams.index')->with('success', 'Team toegevoegd!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        //
    }
}
