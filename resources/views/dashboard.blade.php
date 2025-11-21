<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="swiper mySwiper relative w-full h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="swiper-wrapper">
                @foreach ($movies as $movie)             
                    <div class="swiper-slide w-10 h-60">
                        @if($movie->poster)
                            <img src="{{ asset($movie->poster) }}"
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

        @foreach($genres as $genre)

            {{-- GENRE LABEL --}}
            <div class="w-30 flex justify-center rounded-4xl bg-[#224d4a] font-semibold text-text
                hover:bg-blue-200 hover:text-blue-700 py-2 transition">
                {{ $genre->name }}🔥
            </div>
        
            {{-- GENRE MOVIES GRID --}}
            <div class="grid auto-rows-min gap-4 md:grid-cols-3 mt-4">
            
                @php
                    $genreMovies = $movies->where('genre_id', $genre->id);
                @endphp

                @forelse($genreMovies as $movie)
            
                    <div x-data="{ open: false }" class="flex flex-col rounded-xl border border-neutral-200 dark:border-neutral-700 overflow-hidden cursor-pointer">

    {{-- POSTER --}}
    <div class="relative aspect-video" @click="open = true">
        @if($movie->poster)
            <img src="{{ asset($movie->poster) }}"
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
                    <img src="{{ asset($movie->poster) }}" alt="{{ $movie->title }}" class="w-full h-full object-cover">
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
