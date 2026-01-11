<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;

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

    public function export(Request $request)
    {
        $query = Movie::with('course');

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('director', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('genre_filter') && $request->genre_filter != '') {
            $query->where('genre_id', $request->genre_filter);
        }

        $movies = $query->latest()->get();

        $filename = 'movies_export_' . date('Y-m-d_His') . '.pdf';

        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Movies Export</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    padding: 20px;
                    background-color: #f5f5f5;
                }
                .container {
                    max-width: 1200px;
                    margin: 0 auto;
                    background-color: white;
                    padding: 30px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                }
                h1 {
                    color: #333;
                    text-align: center;
                    margin-bottom: 10px;
                }
                .export-info {
                    text-align: center;
                    color: #666;
                    margin-bottom: 30px;
                    font-size: 14px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                th {
                    background-color: #4472C4;
                    color: white;
                    padding: 12px;
                    text-align: left;
                    font-weight: bold;
                    border: 1px solid #2e5c9a;
                }
                td {
                    padding: 10px 12px;
                    border: 1px solid #ddd;
                }
                tr:nth-child(even) {
                    background-color: #f9f9f9;
                }
                tr:hover {
                    background-color: #f0f0f0;
                }
                .footer {
                    margin-top: 20px;
                    padding: 15px;
                    background-color: #f0f0f0;
                    border-radius: 5px;
                    text-align: center;
                    font-weight: bold;
                    color: #333;
                }
                @media print {
                    body {
                        background-color: white;
                    }
                    .container {
                        box-shadow: none;
                    }
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Movies Export Report</h1>
                <div class="export-info">
                    Exported on: ' . date('F d, Y \a\t h:i A') . '<br>
                    Total Records: ' . $movies->count() . '
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Title</th>
                            <th>Genre</th>
                            <th>Duration</th>
                            <th>Director</th>
                            <th>Description</th>
                            <th>Added Date</th>
                        </tr>
                    </thead>
                    <tbody>';

                $number = 1;
                foreach ($movies as $movie) {
                    $html .= '<tr>
                    <td>' . $number++ . '</td>
                    <td>' . htmlspecialchars($movie->title) . '</td>
                    <td>' . htmlspecialchars($movie->genre ? $movie->genre->genre_id : 'No Genre') . '</td>
                    <td>' . htmlspecialchars($movie->duration) . '</td>
                    <td>' . htmlspecialchars($movie->director) . '</td>
                    <td>' . htmlspecialchars($movie->description) . '</td>
                    <td>' . $movie->created_at->format('Y-m-d H:i:s') . '</td>
                </tr>';
                }

                $html .= '</tbody>
                </table>

                <div class="footer">
                    Total Movies: ' . $movies->count() . '
                </div>
            </div>
        </body>
        </html>';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $dompdf->stream($filename, ['Attachment' => true]);
    }
}
