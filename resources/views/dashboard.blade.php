<x-layouts.app :title="__('Dashboard')">

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

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="swiper mySwiper relative w-full h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="swiper-wrapper">
                @foreach ($movies as $movie)             
                    <div class="swiper-slide w-10 h-60">
                        @if($movie->poster)
                            <img src="{{ asset('storage/' . $movie->poster) }}"
                            alt="{{ $movie->title }}"
                            class="w-full h-75 object-cover" />
                        @else
                            <div class="flex items-center justify-center w-full h-full bg-neutral-200 text-neutral-500 dark:bg-neutral-700 dark:text-neutral-300">
                                No Poster
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Search & Filter Section -->
<div class="rounded-xl border mb-10 border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
    <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">
        Search & Filter Movies
    </h2>

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
                class="flex-1 rounded-lg bg-[#224d4a] px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-[#1b3f3c]"
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

            @foreach($genres as $genre)

            {{-- GENRE LABEL --}}
            <div class="w-30 flex justify-center rounded-4xl bg-[#224d4a] font-semibold text-text
                hover:bg-blue-200 hover:text-blue-700 py-2 transition">
                {{ $genre->name }}🔥
            </div>
        
            {{-- GENRE MOVIES GRID --}}
            <div class="flex space-x-4 mt-4 overflow-x-auto pb-4 overflow-hidden">
            
                @php
                    $genreMovies = $movies->where('genre_id', $genre->id);
                @endphp

                @forelse($genreMovies as $movie)
            
                    <div x-data="{ open: false }" class="flex-shrink-0 w-64 md:w-80 rounded-xl border border-neutral-200 dark:border-neutral-700 overflow-hidden cursor-pointer shadow-lg">

            {{-- POSTER --}}
            <div class="relative aspect-video" @click="open = true">
                @if($movie->poster)
                    <img src="{{ asset('storage/' . $movie->poster) }}"
                         alt="{{ $movie->title }}"
                         class="absolute inset-0 size-full object-cover">
                @else
                    <div class="absolute inset-0 flex items-center justify-center 
                        bg-neutral-200 text-neutral-500 dark:bg-neutral-700 dark:text-neutral-300">
                        No Poster
                    </div>
                @endif
            </div>
        
            {{-- TITLE BELOW --}}
            <div class="p-3 bg-white dark:bg-neutral-800" @click="open = true">
                <h3 class="text-md flex justify-center font-medium text-neutral-900 dark:text-neutral-100">
                    {{ $movie->title }}
                </h3>
            </div>
        
            {{-- MODAL --}}
            <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                 x-transition.opacity>
                <div class="bg-white dark:bg-neutral-900 rounded-xl shadow-lg max-w-4xl w-full mx-4 md:mx-0 flex overflow-hidden">

                    {{-- Left: Full Poster --}}
                    <div class="w-1/2 hidden md:block">
                        @if($movie->poster)
                            <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center w-full h-full bg-neutral-200 text-neutral-500 dark:bg-neutral-700 dark:text-neutral-300">
                                No Poster
                            </div>
                        @endif
                    </div>
                
                    {{-- Right: Title + Description --}}
                    <div class="w-full md:w-1/2 p-6 flex flex-col justify-center">
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100 mb-4">{{ $movie->title }}</h2>
                        <p class="text-neutral-700 dark:text-neutral-300">{{ $genre->name ?? 'No description available.' }}</p>
                        <p class="text-neutral-700 dark:text-neutral-300">{{ $movie->duration_minutes?? 'No description available.' }}</p>
                        <p class="text-neutral-700 dark:text-neutral-300">{{ $movie->director ?? 'No description available.' }}</p>
                        <p class="text-neutral-700 dark:text-neutral-300">{{ $movie->description ?? 'No description available.' }}</p>
                    
                        {{-- Close Button --}}
                        <button @click="open = false" class="mt-6 px-4 py-2 bg-[#224d4a] text-white rounded  transition self-end">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        
</div>


                
                @empty
                    {{-- IF NO MOVIES IN THIS GENRE --}}
                    <p class="text-neutral-600 dark:text-neutral-300 col-span-3">
                        No movies available for this genre.
                    </p>
                @endforelse
                
            </div>

        @endforeach


    </div>
</x-layouts.app>
