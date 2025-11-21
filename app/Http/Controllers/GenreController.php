<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\Movie;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::latest()->get();
        return view('genre', compact('genres'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        Genre::create($validated);
        return redirect()->back()->with('success', 'Genre added successfully.');
    }

    public function edit(Genre $genre)
    {
        return view('genres.edit', compact('genre'));
    }

    public function update(Request $request, Genre $genre)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $genre->update($validated);
        return redirect()->route('genres.store')->with('success', 'Genre updated successfully.');
    }

    public function trash()
    {
        $movies = Movie::onlyTrashed()->latest()->get();
        $genres = Genre::onlyTrashed()->latest()->get();
        return view('genres.trash', compact('genres', 'movies'));
    }

    public function destroy($id)
    {
        $genre = Genre::withTrashed()->findOrFail($id);

        if($genre->trashed()){
            $genre->forceDelete();
            return redirect()->route('dashboard')->with('success', 'Genre permanently deleted.');
        } else {
            $genre->delete();
            return redirect()->route('trash')->with('success', 'Genre moved to trash.');
        }
    }

    public function restore($id)
    {
        $genre = Genre::withTrashed()->findOrFail($id);

        $genre->restore();
        return redirect()->route('dashboard')->with('success', 'Genre restored successfully.');
    }
}
