<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skills = Skill::orderBy('title')->get();

        return Inertia::render('Skills/Index', compact('skills'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated_data = Validator::make($request->all(),[
            'title' => 'required',
            'img' => [Rule::requiredIf($request->hasFile('img')), 'image', 'mimes:jpeg,jpg,png,gif,svg', 'max:2048'],
            'url' => 'nullable',
            'description' => 'nullable',
            'level' => 'required',
        ])->valid();

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
        $skill->delete();
    }
}
