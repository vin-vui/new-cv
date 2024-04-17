<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\User;
use Inertia\Inertia;
use App\Models\About;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Formation;
use Inertia\Response;

class FrontController extends Controller
{
    /**
     * Call the front page with all the data needed
     * @return \Inertia\Response
     */
    public function index(): Response
    {
        $about = About::first();
        $links = Link::all();
        $user = User::first();
        $skills = Skill::orderBy('title')->get();
        $projects = Project::with(['skills' => function ($query) {
            $query->orderBy('title');
        }])->orderBy('start_date', 'desc')->get();
        $formations = Formation::latest('year')->get();

        return Inertia::render('Front/Welcome', compact('about', 'links', 'user', 'skills', 'projects', 'formations'));
    }

}
