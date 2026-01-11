<x-layouts.app :title="__('Movie Lists')">
	<div class="space-y-6">
         @if(session('success'))
            <div 
                x-data="{ show: true }" 
                x-show="show"
                x-init="setTimeout(() => show = false, 3000)" 
                class="rounded-lg bg-green-100 p-4 text-green-700 dark:bg-green-900/30 dark:text-green-300 transition-all duration-500"
            >
                {{ session('success') }}
            </div>
        @endif
		<!-- Top 3 cards -->
		<div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Total Movies</p>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $movies->count() }}</h3>
                    </div>
                    <div class="rounded-full bg-blue-100 p-3 dark:bg-blue-900/30">
                        <svg width="38px" height="38px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M861.9 383.8H218.1c-36.4 0-66.1-29.8-66.1-66.1V288c0-36.4 29.8-66.1 66.1-66.1h643.8c36.4 0 66.1 29.8 66.1 66.1v29.7c0 36.3-29.8 66.1-66.1 66.1z" fill="#FFB89A"></path><path d="M822.9 129.2H199.8c-77.2 0-140.4 63.2-140.4 140.4v487.2c0 77.2 63.2 140.4 140.4 140.4h623.1c77.2 0 140.4-63.2 140.4-140.4V269.6c0-77.2-63.2-140.4-140.4-140.4z m80.4 177H760.4L864.6 201c5.4 3.3 10.4 7.3 15 11.8 15.3 15.3 23.7 35.4 23.7 56.8v36.6z m-673.3 0l104-117h61.3l-109.1 117H230z m247.4-117h169.2L532 306.2H368.3l109.1-117z m248.8 0h65.6L676 306.2h-60l112.5-114.8-2.3-2.2zM143 212.9c15.3-15.3 35.4-23.7 56.8-23.7h53.9l-104 117h-30.4v-36.5c0.1-21.4 8.5-41.5 23.7-56.8z m736.6 600.7c-15.3 15.3-35.4 23.7-56.8 23.7h-623c-21.3 0-41.5-8.4-56.8-23.7-15.3-15.3-23.7-35.4-23.7-56.8V366.2h783.9v390.6c0.1 21.3-8.3 41.5-23.6 56.8z" fill="#45484C"></path><path d="M400.5 770.6V430.9L534.1 508c14.3 8.3 19.3 26.6 11 41-8.3 14.3-26.6 19.3-41 11l-43.6-25.2v131.8l114.1-65.9-7.5-4.3c-14.3-8.3-19.3-26.6-11-41 8.3-14.3 26.6-19.3 41-11l97.5 56.3-294.1 169.9z" fill="#33CC99"></path></g></svg>
                    </div>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Total Genres</p>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $genres->count() }}</h3>
                    </div>
                    <div class="rounded-full bg-green-100 p-3 dark:bg-green-500/30">
                        <svg width="38px" height="38px" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M5 1H8V15H5V1Z" fill="#a32424"></path> <path d="M0 3H3V15H0V3Z" fill="#a32424"></path> <path d="M12.167 3L9.34302 3.7041L12.1594 15L14.9834 14.2959L12.167 3Z" fill="#a32424"></path> </g></svg>
                    </div>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Most Viewed</p>
                        <h3 class="mt-2 text-xl font-bold text-neutral-900 dark:text-neutral-100">Twinkling Watermelon</h3>
                    </div>
                    <div class="rounded-full bg-purple-100 p-3 dark:bg-purple-900/30">
                        <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-800">
            <div class="flex h-full flex-col p-6">

                <div class="flex h-full flex-col p-6">
                <!-- Add New Movie Form -->
                <div class="mb-6 rounded-lg border border-neutral-200 bg-neutral-50 p-6 dark:border-neutral-700 dark:bg-neutral-900/50">
                    <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Add New Movie</h2>
                    
                    <form action="{{ route('movies.store') }}" method="POST" class="grid gap-4 md:grid-cols-2" enctype="multipart/form-data">
                        @csrf
                        
                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Title</label>
                            <input type="text" name="title" value="{{ old('title') }}" placeholder="Enter movie name" required class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            @error('title')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Genre
                            <select id="edit_genre_id" name="genre_id" required
                                    class="w-full rounded-lg mt-2 border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                                <option value="">Select a genre</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                @endforeach
                            </select>
                        </label>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Duration</label>
                            <input type="text" name="duration_minutes" value="{{ old('duration_minutes') }}" placeholder="Enter duration minutes" required class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            @error('duration_minutes')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Director</label>
                            <input type="text" name="director" value="{{ old('director') }}" placeholder="Enter directors name" class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            @error('director')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Description</label>
                            <textarea name="description" rows="1" placeholder="Enter description" class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                       <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Poster</label>

                            <!-- Custom file input -->
                            <label class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100 flex items-center justify-left cursor-pointer hover:bg-neutral-50 dark:hover:bg-neutral-700">
                                <span id="choosePosterLabel" class="text-sm text-neutral-700 dark:text-neutral-300">Choose a poster</span>
                                <input type="file" name="poster" id="posterInput" class="hidden" accept="image/*" onchange="previewPoster(this)">
                            </label>
                        
                            <!-- Display image preview -->
                            <img id="posterPreview" class="mt-2 w-120 h-32 object-cover hidden rounded-lg border border-neutral-300 dark:border-neutral-600" />
                            
                            <!-- Display selected file name -->
                            <p id="posterFileName" class="mt-2 flex justify-center text-sm text-neutral-600 dark:text-neutral-400"></p>
                        
                            @error('poster')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <button type="submit" class="rounded-lg bg-blue-600 px-6 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                                Add Movie
                            </button>
                        </div>
                    </form>
                </div>

        <div class="rounded-xl border mb-10 border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
            <div class="flex justify-between">
                <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">
                    Search & Export Movies
                </h2>
    
                <div class="mb-4 flex justify-end">
                        <form method="GET" action="{{ route('students.export') }}" class="inline">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="course_filter" value="{{ request('course_filter') }}">
    
                            <button type="submit"
                                    class="flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-green-700">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Export to PDF
                            </button>
                        </form>
                    </div>
            </div>

            <form action="{{ route('dashboard') }}" method="GET" class="grid gap-4 md:grid-cols-3">

                <!-- Search Input -->
                <div class="md:col-span-1">
                    <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                        Search
                    </label>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search by movie title"
                        class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm
                            focus:border-[#224d4a] focus:outline-none focus:ring-2 focus:ring-[#224d4a]/20
                            dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100"
                    >
                </div>

                <!-- Genre Filter Dropdown -->
                <div class="md:col-span-1">
                    <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                        Filter by Genre
                    </label>
                    <select
                        name="genre_filter"
                        class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm
                            focus:border-[#224d4a] focus:outline-none focus:ring-2 focus:ring-[#224d4a]/20
                            dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100"
                    >
                        <option value="">All Genres</option>
                        @foreach($genres as $genre)
                            <option
                                value="{{ $genre->id }}"
                                {{ request('genre_filter') == $genre->id ? 'selected' : '' }}
                            >
                                {{ $genre->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-end gap-2 md:col-span-1">
                    <button
                        type="submit"
                        class="flex-1 rounded-lg bg-blue-700 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-800"
                    >
                        Apply Filters
                    </button>

                    <a
                        href="{{ route('dashboard') }}"
                        class="rounded-lg border border-neutral-300 px-4 py-2 text-sm font-medium text-neutral-700
                            transition-colors hover:bg-neutral-100
                            dark:border-neutral-600 dark:text-neutral-300 dark:hover:bg-neutral-700"
                    >
                        Clear
                    </a>
                </div>
            </form>
        </div>

		<!-- Movie List Table -->
                <div class="flex-1 overflow-auto">
                    <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Movie List</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full">
                            <thead>
                                <tr class="border-b border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900/50">
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-neutral-700 dark:text-neutral-300">#</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-neutral-700 dark:text-neutral-300">Movie Name</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-neutral-700 dark:text-neutral-300">Genre</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-neutral-700 dark:text-neutral-300">Duration</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-neutral-700 dark:text-neutral-300">Director</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-neutral-700 dark:text-neutral-300">Description</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-neutral-700 dark:text-neutral-300">Poster</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-neutral-700 dark:text-neutral-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                                @forelse($movies as $movie)
                                    <tr class="transition-colors hover:bg-neutral-50 dark:hover:bg-neutral-800/50" id="movie-row-{{ $movie->id }}">
                                        <td class="px-4 py-3 text-center text-sm text-neutral-600 dark:text-neutral-400">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-neutral-900 dark:text-neutral-100">
                                            <span class="movie-name-display">{{ $movie->title }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm text-neutral-600 dark:text-neutral-400">
                                            {{ $movie->genre ? $movie->genre->name : 'N/A' }}
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm text-neutral-900 dark:text-neutral-100">
                                            <span class="movie-duration-display">{{ $movie->duration_minutes }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm text-neutral-900 dark:text-neutral-100">
                                            <span class="movie-director-display">{{ $movie->director }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm text-neutral-600 dark:text-neutral-400">
                                            <span class="movie-description-display">{{ Str::limit($movie->description, 50) ?? 'N/A' }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm text-neutral-600 dark:text-neutral-400">
                                            <span class="movie-poster-display">{{ $movie->poster ? basename($movie->poster) : 'N/A' }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm inline-flex">
                                            <button onclick="editMovie(
                                                {{ $movie->id }},
                                                '{{ addslashes($movie->title) }}',
                                                '{{ $movie->genre_id }}',
                                                '{{ $movie->duration_minutes }}',
                                                '{{ addslashes($movie->director) }}',
                                                '{{ addslashes($movie->description) }}', '{{  $movie->poster}}'
                                            ); event.stopPropagation();" class="text-blue-600 transition-colors hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                                Edit
                                            </button>

                                            <span class="mx-1 text-neutral-400">|</span>
                                           
                                            <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to move this movie to trash?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="delete-btn text-red-600 transition-colors hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class=" px-4 py-8 text-center text-sm text-neutral-500 dark:text-neutral-400">
                                            No movies found. Add your first movie above!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="editMovieModal" class="fixed inset-0 hidden flex
            items-center justify-center
            bg-black/50 z-[9999]
            p-4 sm:p-6">
        <div class="w-full max-w-md sm:max-w-2xl
            max-h-[90vh]
            overflow-y-auto
            rounded-xl
            border border-neutral-200
            bg-white
            p-4 sm:p-6
            dark:border-neutral-700 dark:bg-neutral-800">
            <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Edit Movie</h2>

            <form id="editMovieForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid gap-4 grid-cols-1 sm:grid-cols-2">

                    <!-- Movie Name -->
                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Movie Name</label>
                        <input type="text" id="edit_movie_name" name="title"
                               class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                    </div>
                
                    <!-- Genre -->
                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Genre</label>
                        <select id="edit_genre_select" name="genre_id" required
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            <option value="">Select a genre</option>
                            @foreach($genres as $genre)
                                <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                            @endforeach
                        </select>
                    </div>
                
                    <!-- Duration -->
                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Duration</label>
                        <input type="text" id="edit_duration" name="duration_minutes"
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                    </div>
                
                    <!-- Director -->
                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Director</label>
                        <input type="text" id="edit_director" name="director"
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                    </div>
                
                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Description</label>
                        <textarea id="edit_description" name="description" rows="1"
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100"></textarea>
                    </div>

                    <!-- Current Poster Preview -->
                    <div class="md:col-span-2">
                        <label class="mb-2 flex text-sm font-medium text-neutral-700 dark:text-neutral-300">
                            Current Poster
                        </label>

                        <div class="flex flex-col items-center gap-4">
                            <div class="h-48 sm:h-40 w-full overflow-hidden rounded-lg border border-neutral-300 dark:border-neutral-600">
                                <img
                                    id="edit_poster_preview"
                                    src=""
                                    alt="Movie Poster"
                                    class="h-full w-full object-cover hidden"
                                >

                                <div
                                    id="edit_no_poster"
                                    class="flex h-full w-full items-center justify-center text-sm text-neutral-500 dark:text-neutral-400"
                                >
                                    No Poster
                                </div>
                            </div>

                            <!-- Upload New Poster -->
                            <div class="flex-1">
                                <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                    Change Poster
                                </label>
                                <input
                                    type="file"
                                    name="poster"
                                    accept="image/*"
                                    onchange="previewEditPoster(event)"
                                    class="w-full text-sm text-neutral-700 dark:text-neutral-300
                                        file:mr-4 file:rounded-lg file:border-0
                                        file:bg-blue-600 file:px-4 file:py-2
                                        file:text-white hover:file:bg-blue-700"
                                >
                            </div>
                        </div>
                    </div>
                </div>


                <div class="md:col-span-2 mt-6 flex flex-col sm:flex-row
            gap-3 sm:justify-end">
                    <button type="button" onclick="closeEditModal()"
                            class="rounded-lg border border-neutral-300 px-4 py-2 text-sm font-medium text-neutral-700 transition-colors hover:bg-neutral-100 dark:border-neutral-600 dark:text-neutral-300 dark:hover:bg-neutral-700">
                        Cancel
                    </button>
                    <button type="submit"
                            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700">
                        Update Movie
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewPoster(input) {
            const file = input.files[0];
            const fileNameEl = document.getElementById('posterFileName');
            const previewEl = document.getElementById('posterPreview');
            const labelEl = document.getElementById('choosePosterLabel');

            if(file){
                fileNameEl.textContent = file.name;
                previewEl.src = URL.createObjectURL(file);
                previewEl.classList.remove('hidden');
                labelEl.textContent = "Change poster"; // 🔥 change text instead of hiding
            } else {
                fileNameEl.textContent = '';
                previewEl.classList.add('hidden');
                labelEl.textContent = "Choose a poster"; // reset back
            }
        }

        function editMovie(id, name, genre_id, duration_minutes, director, description, poster) {
            document.getElementById('editMovieModal').classList.remove('hidden');
            document.getElementById('editMovieModal').classList.add('flex');
            document.getElementById('editMovieForm').action = `/movies/${id}`;
                
            // Set form fields
            document.getElementById('edit_movie_name').value = name;
            document.getElementById('edit_genre_select').value = genre_id;
            document.getElementById('edit_duration').value = duration_minutes;
            document.getElementById('edit_director').value = director;
            document.getElementById('edit_description').value = description || '';

            const posterImg = document.getElementById('edit_poster_preview');
            const noPoster = document.getElementById('edit_no_poster');

            if (poster) {
                posterImg.src = `/storage/${poster}`;
                posterImg.classList.remove('hidden');
                noPoster.classList.add('hidden');
            } else {
                posterImg.classList.add('hidden');
                noPoster.classList.remove('hidden');
            }
        }

        function previewEditPoster(event) {
            const file = event.target.files[0];
            if (!file) return;

            const posterImg = document.getElementById('edit_poster_preview');
            const noPoster = document.getElementById('edit_no_poster');

            posterImg.src = URL.createObjectURL(file);
            posterImg.classList.remove('hidden');
            noPoster.classList.add('hidden');
        }
        
        function closeEditModal() {
            document.getElementById('editMovieModal').classList.add('hidden');
            document.getElementById('editMovieModal').classList.remove('flex');
        
            // Clear form fields
            document.getElementById('editMovieForm').reset();
        }

    </script>
</x-layouts.app>

