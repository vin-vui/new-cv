<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $links = Link::orderBy('title')->get();

        return Inertia::render('Back/Links/Index', compact('links'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated_data = Validator::make($request->all(), [
            'title' => 'required',
            'url' => 'required',
            'img' => 'required',
        ])->validate();

        Link::updateOrCreate(['id' => $request->id], $validated_data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link)
    {
        $link->delete();
    }
}
