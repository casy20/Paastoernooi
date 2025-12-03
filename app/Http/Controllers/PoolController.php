<?php

namespace App\Http\Controllers;

use App\Models\Pool;
use App\Http\Requests\StorePoolRequest;
use App\Http\Requests\UpdatePoolRequest;
use Illuminate\Http\Request;

class PoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pool = Pool::all();
        return view("team_create", compact("pools"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'toernament_id' => 'required|integer',
            'name' => 'required|string|max:255',
        ]);

        $pool = Pool::create($validatedData);
        return redirect()->route('paastoernoois.index')->with('success', 'Team toegevoegd!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pool $pool)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pool $pool)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePoolRequest $request, Pool $pool)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pool $pool)
    {
        //
    }
}
