<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skills = Skill::all();

        return Inertia::render('Skills/Index', [
            'skills' => $skills,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'title' => 'required',
            'img' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
            'url' => 'nullable',
            'description' => 'nullable',
            'level' => 'required',
        ]);

        if ($request->hasFile('img')) {
            $path = Storage::disk('public')->put('image', $request->file('img'));
            $validated_data['img'] = '/storage/'.$path;
        }

        Skill::updateOrCreate(['id' => $request->id], $validated_data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        //
    }
}
