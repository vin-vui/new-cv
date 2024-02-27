<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\User;
use Inertia\Inertia;
use App\Models\About;
use App\Models\Skill;
use App\Models\Project;

class FrontController extends Controller
{
    /**
     * Call the front page with the about and links
     */
    public function index()
    {
        $about = About::first();
        $links = Link::all();
        $user = User::first();
        $skills = Skill::all();
        $projects = Project::all();

        return Inertia::render('Front/Welcome', compact('about', 'links', 'user', 'skills', 'projects'));
    }

}