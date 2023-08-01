<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Skill;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with('skills')->get();
        $skills = Skill::all();

        return Inertia::render('Projects/Index', compact('projects', 'skills'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validated_data = Validator::make($request->all(),[
            'title' => 'required',
            'client' => 'required',
            'job' => 'required',
            'logo' => [Rule::requiredIf($request->hasFile('logo')), 'image', 'mimes:jpeg,jpg,png,gif,svg', 'max:2048'],
            'url' => 'nullable',
            'github' => 'nullable',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'nullable',
            'illustration_1' => 'nullable',
            'illustration_2' => 'nullable',
            'illustration_3' => 'nullable',
            'illustration_4' => 'nullable',
            'is_printable' => 'required',
        ])->valid();

        if ($request->hasFile('logo')) {
            $path = Storage::disk('public')->put('image', $request->file('logo'));
            $validated_data['logo'] = '/storage/'.$path;
        }

        if ($request->hasFile('illustration_1')) {
            $path = Storage::disk('public')->put('image', $request->file('illustration_1'));
            $validated_data['illustration_1'] = '/storage/'.$path;
        }

        if ($request->hasFile('illustration_2')) {
            $path = Storage::disk('public')->put('image', $request->file('illustration_2'));
            $validated_data['illustration_2'] = '/storage/'.$path;
        }

        if ($request->hasFile('illustration_3')) {
            $path = Storage::disk('public')->put('image', $request->file('illustration_3'));
            $validated_data['illustration_3'] = '/storage/'.$path;
        }

        if ($request->hasFile('illustration_4')) {
            $path = Storage::disk('public')->put('image', $request->file('illustration_4'));
            $validated_data['illustration_4'] = '/storage/'.$path;
        }

        $project = Project::updateOrCreate(['id' => $request->id], $validated_data);
        $project->skills()->sync($request->skills);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
    }
}
