<div class="p-6 md:p-10 max-w-7xl mx-auto w-full">
    <!-- Header -->
    <div class="mb-10">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-200 dark:border-indigo-500/30 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest mb-4">
            <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
            Latest Content
        </div>
        <h1 class="text-4xl md:text-5xl font-black text-slate-800 dark:text-white tracking-tight mb-2">All Playlists</h1>
        <p class="text-slate-500 dark:text-slate-400 text-lg">Browse and watch all published learning playlists.</p>
    </div>

    <!-- Search -->
    <div class="mb-8 max-w-md">
        <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass" clearable placeholder="Search playlists..." />
    </div>

    <!-- Grid -->
    @if($playlists->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @php
                $gradients = [
                    'from-blue-500 to-indigo-600',
                    'from-rose-500 to-orange-500',
                    'from-cyan-500 to-teal-500',
                    'from-emerald-500 to-green-600',
                    'from-violet-500 to-purple-600',
                    'from-amber-500 to-yellow-500',
                ];
            @endphp

            @foreach($playlists as $index => $playlist)
                @php $grad = $gradients[$index % count($gradients)]; @endphp
                <a
                    href="{{ route('playlists.show', $playlist) }}"
                    wire:navigate
                    class="group relative rounded-2xl overflow-hidden border border-slate-200/60 dark:border-white/5 bg-white/70 dark:bg-zinc-900/60 backdrop-blur-xl shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col"
                >
                    <!-- Thumbnail / Gradient Banner -->
                    <div class="relative h-44 w-full overflow-hidden shrink-0">
                        @if($playlist->thumbnail)
                            <img src="{{ str_starts_with($playlist->thumbnail, 'http') ? $playlist->thumbnail : asset('storage/' . $playlist->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $playlist->title }}" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br {{ $grad }}"></div>
                            <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 18px 18px;"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-md border border-white/30 flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                        @endif

                        <!-- Sections badge -->
                        <div class="absolute top-3 right-3 bg-black/50 backdrop-blur-sm text-white text-xs font-bold px-2.5 py-1 rounded-full flex items-center gap-1.5">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                            {{ $playlist->sections_count }} {{ Str::plural('section', $playlist->sections_count) }}
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="font-bold text-slate-800 dark:text-zinc-100 text-base leading-snug mb-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                            {{ $playlist->title }}
                        </h3>
                        @if($playlist->description)
                            <p class="text-xs text-slate-500 dark:text-zinc-400 line-clamp-2 mb-4 flex-1">{{ $playlist->description }}</p>
                        @else
                            <div class="flex-1"></div>
                        @endif
                        <div class="flex items-center justify-between mt-2 pt-3 border-t border-slate-100 dark:border-white/5">
                            <span class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 group-hover:underline">Watch Now</span>
                            <svg class="w-4 h-4 text-indigo-500 -translate-x-1 group-hover:translate-x-0 opacity-0 group-hover:opacity-100 transition-all duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        @if($playlists->hasPages())
            <div class="mt-10">{{ $playlists->links() }}</div>
        @endif
    @else
        <div class="text-center py-20 rounded-2xl border border-dashed border-slate-300 dark:border-zinc-700">
            <svg class="w-14 h-14 text-slate-300 dark:text-zinc-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-lg font-bold text-slate-700 dark:text-zinc-300">No playlists published yet</h3>
            <p class="text-sm text-slate-500 dark:text-zinc-500 mt-1">Check back soon for new content!</p>
        </div>
    @endif
</div>
