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
        return view("admin_Schools", compact("schools"));
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
    public function edit(string $id)
    {
        $school = School::findOrFail($id);
        return view('admin_Schools', compact('school'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, School $school)
    {
        $schools = School::findOrFail($request->id);
        $schools->name = $request->name;
        $schools->school_type = $request->school_type;
        $schools->save();
        return redirect()->route('admin_Schools')->with('success', 'School bijgewerkt!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        School::findOrFail($id)->delete();
        return redirect()->route('admin_Schools')->with('success', 'School verwijderd!');
    }
}
