<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Type;
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    public function index()
    {
        return view('management.index', [
            'brands' => Brand::all(),
            'types' => Type::all(),
        ]);
    }
}
