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
        $query = Movie::with('genre');

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

        $movie = $query->latest()->get();

        $filename = 'movies_export_' . date('Y-m-d_His') . '.pdf';

        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Movies Export</title>
            <style>
                body {
                    font-family: "Helvetica", Arial, sans-serif;
                    background: #f3f4f6;
                    margin: 0;
                    padding: 30px;
                    color: #111827;
                }

                .container {
                    max-width: 1100px;
                    margin: auto;
                    background: #ffffff;
                    padding: 32px;
                    border-radius: 8px;
                }

                .header {
                    text-align: center;
                    margin-bottom: 30px;
                }

                .header h1 {
                    margin: 0;
                    font-size: 26px;
                    letter-spacing: 0.5px;
                }

                .header p {
                    margin-top: 8px;
                    font-size: 14px;
                    color: #6b7280;
                }

                .divider {
                    height: 2px;
                    background: #e5e7eb;
                    margin: 25px 0;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                    font-size: 14px;
                }

                th {
                    background: #111827;
                    color: #ffffff;
                    padding: 12px 10px;
                    text-align: left;
                }

                td {
                    padding: 10px;
                    border-bottom: 1px solid #e5e7eb;
                    vertical-align: top;
                }

                tr:nth-child(even) {
                    background: #f9fafb;
                }

                .badge {
                    display: inline-block;
                    padding: 4px 8px;
                    font-size: 12px;
                    border-radius: 12px;
                    background: #e0f2fe;
                    color: #0369a1;
                    font-weight: 600;
                }

                .footer {
                    margin-top: 30px;
                    text-align: center;
                    font-size: 13px;
                    color: #6b7280;
                }

                @media print {
                    body {
                        background: white;
                        padding: 0;
                    }
                    .container {
                        border-radius: 0;
                    }
                }
            </style>
        </head>
        <body>
            <div class="container">

                <div class="header">
                    <h1>Movies Report</h1>
                    <p>
                        Exported on ' . date('F d, Y \a\t h:i A') . '<br>
                        Total Records: ' . $movie->count() . '
                    </p>
                </div>

                <div class="divider"></div>

                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Genre</th>
                            <th>Duration</th>
                            <th>Director</th>
                            <th>Description</th>
                            <th>Added</th>
                        </tr>
                    </thead>
                    <tbody>';


                $number = 1;
                foreach ($movie as $movies) {
                    $html .= '<tr>
                    <td>' . $number++ . '</td>
                    <td>' . htmlspecialchars($movies->title) . '</td>
                    <td>
                        <span class="badge">' . htmlspecialchars($movies->genre ? $movies->genre->name : 'No Genre') . '</span>
                    </td>
                    <td>' . htmlspecialchars($movies->duration_minutes) . '</td>
                    <td>' . htmlspecialchars($movies->director ?? '-') . '</td>
                    <td>' . htmlspecialchars($movies->description ?? '-') . '</td>
                    <td>' . $movies->created_at->format('Y-m-d H:i:s') . '</td>
                </tr>';
                }

                $html .= '</tbody>
                </table>

                <div class="footer">
                    Total Movies: ' . $movie->count() . ' <br/>
                    © ' . date('Y') . ' Cine-Nook. All rights reserved.
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
