<?php

namespace App\Http\Controllers;
use App\Models\genres;
use Illuminate\Http\Request;
use Illuminate\Support\str;

class genresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return genres::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            "name" => "required|min:3|max:255",
            "description" => "required|min:3|max:255",
            "image" => "required|min:3|max:255"
        ]);
        $genre = genres::create([
            "name" => $validation["name"],
            "description" => $validation["description"],
            "image" => $validation["image"],
            "slug" => Str::slug($validation["name"])
        ]);
        return 1;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return genres::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validation = $request->validate([
            "name" => "required|min:3|max:255",
            "description" => "required|min:3|max:255",
            "image" => "required|min:3|max:255"
        ]);
        $genre = genres::find($id);
        $genre->name = $validation["name"];
        $genre->description = $validation["description"];
        $genre->image = $validation["image"];
        $genre->slug = Str::slug($validation["name"]);
        $genre->save();
        return 1;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $genre = genres::find($id);
        $genre->delete();
        return 1;
    }
}
