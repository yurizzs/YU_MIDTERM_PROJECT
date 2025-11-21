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
            'genre_id' => 'required|exists:genres,id',
            'duration_minutes' => 'required|string|max:10',
            'director' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);
    
        $posterPath = null;
    
        if ($request->hasFile('poster')) {
            $posterFile = $request->file('poster');

            // Get original filename (e.g., movie.jpg)
            $originalName = $posterFile->getClientOriginalName();

            // Make sure folder exists
            $posterPath = 'posters/' . $originalName;

            // Move manually
            $posterFile->move(public_path('posters'), $originalName);
        }else{
            $posterPath = null;
        }
    
        Movie::create([
            'title' => $validated['title'],
            'genre_id' => $validated['genre_id'],
            'duration_minutes' => $validated['duration_minutes'],
            'director' => $validated['director'] ?? null,
            'description' => $validated['description'] ?? null,
            'poster' => $posterPath,
        ]);
    
        return redirect()->route('dashboard')->with('success', 'Movie added successfully!');
    }

    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'duration_minutes' => 'string|max:20',
            'director' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'genre_id' => 'required|exists:genres,id',
        ]);

        $movie->update([
            'title' => $validated['title'],
            'genre_id' => $validated['genre_id'],
            'duration_minutes' => $validated['duration_minutes'],
            'director' => $validated['director'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);
        return redirect()->route('movies.store')->with('success', 'Movie updated successfully.');
    }

    public function trash()
    {   
        $genres = Genre::onlyTrashed()->latest()->get();
        $movies = Movie::onlyTrashed()->latest()->get();
        return view('trash', compact('movies', 'genres'));
    }

    public function destroy($id)
    {
        $movie = Movie::withTrashed()->findOrFail($id);

        if($movie->trashed())
        {
            $movie->forceDelete();
            return redirect()->route('dashboard')->with('success', 'Movie permanently deleted.');
        }else {
            $movie->delete();
            return redirect()->route('trash')->with('success', 'Movie moved to trash');
        }
    }

    public function restore($id)
    {
        $movies = Movie::withTrashed()->findOrFail($id);

        $movies->restore();
        return redirect()->route('dashboard')->with('success', 'Movie restored successfully.');
    }
}
