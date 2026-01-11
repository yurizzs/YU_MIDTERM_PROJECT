<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Support\Facades\Storage;

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
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('poster')){
            $originalName = pathinfo($request->file('poster')->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $request->file('poster')->getClientOriginalExtension();
            $fileName = $originalName . '_' . time() . '.' . $extension;
            $posterPath = $request->file('poster')->storeAs('posters', $fileName, 'public');
            $validated['poster'] = $posterPath;
            $validated['poster_original_name'] = $request->file('poster')->getClientOriginalName();
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
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('poster')) {
            if($movie->poster) {
                Storage::disk('public')->delete($movie->poster);
            }

            $originalName = pathInfo($request->file('poster')->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $request->file('poster')->getClientOriginalExtension();
            $fileName = $originalName . '_' . time() . '.' . $extension;
            $posterPath = $request->file('poster')->storeAs('posters', $fileName, 'public');
            $validated['poster'] = $posterPath;
            $validated['poster_original_name'] = $request->file('poster')->getClientOriginalName();
        }

        $movie->update($validated);
        return redirect()->route('movies.index')->with('success', 'Movie updated successfully.');
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

        if($movie->poster) {
            Storage::disk('public')->delete($movie->poster);
        }
        
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
