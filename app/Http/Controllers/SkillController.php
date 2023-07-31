<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        // dd($request->all());
        $valid_datas = $request->validate([
            'title' => 'required',
            'img' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
            'url' => 'nullable',
            'description' => 'nullable',
            'level' => 'required',
        ]);

        $skill = new Skill;

        if($request->file()) {
            $file_name = time().'_'.$request->img->getClientOriginalName();
            $file_path = $request->file('img')->store('image', 'public');

            $skill->title = $request->title;
            $skill->url = $request->url;
            $skill->description = $request->description;
            $skill->level = $request->level;
            $skill->img = '/storage/'.$file_path;
            $skill->save();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skill $skill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        //
    }
}
