<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Genre;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::latest()->get();
        $genres = Genre::all();

        return view('movies', compact('movies', 'genres'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'duration_minutes' => 'required|string|max:10',
            'director' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:2000',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'genre_id' => 'required|exists:genres,id',
        ]);

        if($request->hasFile('poster')) {
            $filename = time().'.'.$request->poster->extension();
            $request->poster->move(public_path('posters'), $filename);
            $validated['poster'] = $posterPath;
        }

        Movie::create($validated);
        return redirect()->back()->with('success', 'Movie added successfully.');
    }

    public function edit(Movie $movie)
    {
        return view('movies.edit', compact('movie'));
    }

    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'duration_minutes' => 'required|string|max:10',
            'director' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'genre_id' => 'required|exists:genres,id',
        ]);

        $movie->update($validated);
        return redirect()->route('dashboard')->with('success', 'Movie updated successfully.');
    }

    public function trash()
    {   
        $genres = Genre::onlyTrashed()->latest()->get();
        $movies = Movie::onlyTrashed()->latest()->get();
        return view('movies.trash', compact('movies', 'genres'));
    }

    public function destroy($id)
    {
        $movie = Movie::withTrashed()->findOrFail($id);

        if($movie->trashed())
        {
            $movie->forceDelete();
            return redirect()->route('dashboard')->with('success', 'Movie permanently deleted.');
        }else {
            $student->delete();
            return redirect()->route('movies.trash')->with('success', 'Movie moved to trash');
        }
    }

    public function restore($id)
    {
        $movies = Movie::withTrashed()->findOrFail($id);

        $movies->restore();
        return redirect()->route('dashboard')->with('success', 'Movie restored successfully.');
    }
}
