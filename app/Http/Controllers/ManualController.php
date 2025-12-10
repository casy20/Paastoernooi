<?php

namespace App\Http\Controllers;

use App\Models\Manual;
use Illuminate\Http\Request;

class ManualController extends Controller
{
    public function index()
    {
        return view('manuals.index', [
            'manuals' => Manual::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_id'  => 'required|exists:brands,id',
            'type_id'   => 'required|exists:types,id',
            'name'      => 'required|string|max:255',
            'originUrl' => 'nullable|url',
        ]);

        Manual::create($validated);

        return back()->with('success', 'Handleiding opgeslagen!');
    }
}
