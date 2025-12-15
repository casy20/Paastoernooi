<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Http\Requests\StoreSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;
use App\Models\Team;
use App\Models\Pool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schools = School::all();
        return view("schools.index", compact("schools"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("Create_school");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'school_type' => 'required|string|max:255',
        ]);

        $validated['creator_id'] = Auth::id();

        School::create($validated);

        return redirect()->route('home')->with('success', 'School toegevoegd!');
    }

    /**
     * Display the specified resource.
     */
    public function show(School $school)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(School $school)
    {
        return view('create_school', compact('school'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, School $school)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'school_type' => 'required|string|max:255',
        ]);

        $school->update($validated);

        return redirect()->route('home')->with('success', 'School bijgewerkt!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $school)
    {
        //
        school :: findOrFail()->delete();
        return redirect()->route('festival.index');
    }
}
