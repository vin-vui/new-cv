<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $about = About::first();

        return Inertia::render('About/Index', compact('about'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated_data = Validator::make($request->all(),[
            'title' => 'required',
            'img' => [Rule::requiredIf($request->hasFile('img')), 'image', 'mimes:jpeg,jpg,png,gif,svg', 'max:2048'],
            'subtitle' => 'nullable',
            'description' => 'nullable',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ])->valid();

        if ($request->hasFile('img')) {
            $path = Storage::disk('public')->put('image', $request->file('img'));
            $validated_data['img'] = '/storage/'.$path;
        }

        About::updateOrCreate(['id' => $request->id], $validated_data);
    }

}
