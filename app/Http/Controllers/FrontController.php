<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\User;
use Inertia\Inertia;
use App\Models\About;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Formation;

class FrontController extends Controller
{
    /**
     * Call the front page with the about and links
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        $about = About::first();
        $links = Link::all();
        $user = User::first();
        $skills = Skill::orderBy('title')->get();
        $projects = Project::with(['skills' => function ($query) {
            $query->orderBy('title');
        }])->orderBy('end_date')->get();
        $formations = Formation::latest('year')->get();

        return Inertia::render('Front/Welcome', compact('about', 'links', 'user', 'skills', 'projects', 'formations'));
    }

}
