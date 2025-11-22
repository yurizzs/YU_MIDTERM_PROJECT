<x-layouts.app :title="__('Trash')">
    <div class="flex flex-col gap-6 p-6">
        {{-- Success Message --}}
        @if(session('success'))
            <div class="rounded-lg bg-green-100 p-4 text-sm text-green-800 dark:bg-green-900/30 dark:text-green-200">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="text-2xl font-semibold text-neutral-900 dark:text-neutral-100">Trashed Movies</h2>

        @if($movies->isEmpty())
            <p class="text-center text-neutral-700 dark:text-neutral-300 text-xl mt-10">No trashed movies found.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($movies as $movie)
                    <div class="rounded-xl border border-neutral-200 bg-neutral-50 p-4 shadow-sm hover:shadow-md transition dark:border-neutral-700 dark:bg-neutral-900/50">
                        <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100 mb-2">{{ $movie->title }}</h3>
                        <p class="text-sm text-neutral-700 dark:text-neutral-300 mb-1"><strong>Genre:</strong> {{ $movie->genre ? $movie->genre->name : 'N/A' }}</p>
                        <p class="text-sm text-neutral-700 dark:text-neutral-300 mb-1"><strong>Duration:</strong> {{ $movie->duration_minutes }}</p>
                        <p class="text-sm text-neutral-700 dark:text-neutral-300 mb-1"><strong>Director:</strong> {{ $movie->director }}</p>
                        <p class="text-sm text-neutral-700 dark:text-neutral-300 mb-4"><strong>Description:</strong> {{ $movie->description }}</p>

                        <div class="flex gap-2">
                            <form action="{{ route('movies.restore', $movie->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to restore this movie?')">
                                @csrf
                                <button type="submit" class="w-full rounded bg-green-300 text-black hover:bg-green-200 py-2 transition restore-movie-btn">Restore</button>
                            </form>

                            <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to permanently delete this?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full rounded bg-red-400 text-black hover:bg-red-200 py-2 transition delete-movie-btn">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <h2 class="text-2xl font-semibold text-neutral-900 dark:text-neutral-100 mt-8">Trashed Genres</h2>

        @if($genres->isEmpty())
            <p class="text-center text-neutral-700 dark:text-neutral-300 text-xl mt-4">No trashed genres found</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($genres as $genre)
                        <div class="rounded-xl border border-neutral-200 bg-neutral-50 p-4 shadow-sm hover:shadow-sm transition dark:border-neutral-700 dark:bg-neutral-900/50">
                            <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100 mb-2">{{ $genre->name }}</h3>
                            <p class="text-sm text-neutral-700 dark:text-neutral-300 mb-4">{{ $genre->description ?? 'No description' }}</p>

                            <div class="flex gap-2">
                            <form action="{{ route('genres.restore', $genre->id) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full rounded bg-green-300 text-black hover:bg-green-200 hover:text-green-700 py-2 transition restore-genre-btn" onsubmit="return confirm('Are you sure you want to restore this genre?')">Restore</button>
                            </form>

                            <form action="{{ route('genres.destroy', $genre->id) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full rounded bg-red-400 text-black hover:bg-red-200 hover:text-red-700 py-2 transition delete-genre-btn" onsubmit="return confirm('Are you sure you want to permanently delete this genre?')">Delete</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
    </div>
</x-layouts.app>
