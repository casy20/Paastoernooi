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
     * Admin listing for teams.
     */
    public function adminIndex()
    {
        $teams = Team::with(['school','pool'])->get();
        $schools = School::all();
        $pools = Pool::all();

        return view('admin_Teams', compact('teams','schools','pools'));
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
        // Optionally return a dedicated edit view
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        // Keep resource update if used via resource routes
        $validated = $request->validated();
        $team->update($validated);
        return redirect()->route('teams.index')->with('success', 'Team bijgewerkt!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        $team->delete();
        return redirect()->route('teams.index')->with('success', 'Team verwijderd!');
    }

    /**
     * Admin update handler.
     */
    public function adminUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'referee' => 'required|string|max:255',
            'name' => 'required|string|max:255',
        ]);

        $team = Team::findOrFail($id);
        $team->update($validated);

        return redirect()->route('admin_Teams')->with('success', 'Team bijgewerkt!');
    }

    /**
     * Admin destroy handler.
     */
    public function adminDestroy($id)
    {
        $team = Team::findOrFail($id);
        $team->delete();

        return redirect()->route('admin_Teams')->with('success', 'Team verwijderd!');
    }
}
