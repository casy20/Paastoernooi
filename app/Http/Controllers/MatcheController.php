<?php

namespace App\Http\Controllers;

use App\Models\Matche;
use App\Http\Requests\StoreMatcheRequest;
use App\Http\Requests\UpdateMatcheRequest;

class MatcheController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Matches = Matche::all();
        return view('index', compact('Matches'));
    }

        public function voetbal()
    {
        $Matches = Matche::all();
        return view('voetbal', compact('Matches')); 
    }

    public function lijnbal()
    {
        $Matches = Matche::all();
        return view('lijnbal', compact('Matches')); 
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
