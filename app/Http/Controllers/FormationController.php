<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $formations = Formation::latest('year')->get();

        return Inertia::render('Back/Formations/Index', compact('formations'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated_data = Validator::make($request->all(), [
            'title' => 'required',
            'school' => 'required',
            'year' => 'required',
            'description' => 'required',
        ])->validate();

        Formation::updateOrCreate(['id' => $request->id], $validated_data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Formation $formation)
    {
        $formation->delete();
    }
}
