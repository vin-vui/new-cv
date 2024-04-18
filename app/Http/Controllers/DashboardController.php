<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Skill;
use App\Models\Formation;
use App\Models\Link;
use App\Models\Project;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skills_count = Skill::all()->count();
        $formations_count = Formation::all()->count();
        $links_count = Link::all()->count();
        $projects_count = Project::all()->count();

        return Inertia::render('Back/Dashboard', compact('skills_count', 'formations_count', 'links_count', 'projects_count'));
    }

}
