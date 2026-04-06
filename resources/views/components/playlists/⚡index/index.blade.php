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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($playlists as $index => $playlist)
                <a
                    href="{{ route('playlists.show', $playlist) }}"
                    wire:navigate
                    class="group relative pt-8 flex flex-col transition-all duration-500 hover:-translate-y-2"
                >
                    <!-- Pixel Icon Container (Centered over the top border) -->
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 z-20">
                        <div class="relative w-20 h-20 rounded-full p-1 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 shadow-[0_0_20px_rgba(99,102,241,0.5)] group-hover:shadow-[0_0_35px_rgba(99,102,241,0.8)] transition-all duration-500">
                            <div class="w-full h-full rounded-full bg-[#0F172A] p-1 overflow-hidden border-2 border-white/10">
                                @if($playlist->thumbnail)
                                    <img src="{{ str_starts_with($playlist->thumbnail, 'http') ? $playlist->thumbnail : asset('storage/' . $playlist->thumbnail) }}" class="w-full h-full object-cover rounded-full group-hover:scale-110 transition-transform duration-500" alt="{{ $playlist->title }}" />
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-900 to-slate-900 rounded-full">
                                        <flux:icon.academic-cap class="w-8 h-8 text-indigo-400" />
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="flex-1 bg-[#1E293B]/80 dark:bg-[#0F172A]/80 backdrop-blur-3xl rounded-[2.5rem] border border-white/5 p-8 pt-14 shadow-2xl relative overflow-hidden group-hover:border-indigo-500/30 transition-colors duration-500">
                        <!-- Subtle Glow Effect -->
                        <div class="absolute -top-24 -right-24 w-48 h-48 bg-indigo-500/10 rounded-full blur-[60px] group-hover:bg-indigo-500/20 transition-all duration-500"></div>
                        
                        <div class="relative z-10 flex flex-col h-full">
                            <div class="text-center mb-6">
                                <h3 class="text-xl md:text-2xl font-black text-white leading-tight mb-2 group-hover:text-indigo-400 transition-colors duration-300">
                                    {{ $playlist->title }}
                                </h3>
                                <p class="text-sm font-medium text-slate-400 truncate">
                                    With <span class="text-slate-300">{{ $playlist->author_name ?? 'Team Ferga' }}</span>
                                </p>
                            </div>

                            <div class="mt-auto pt-6 border-t border-white/5 space-y-3">
                                <div class="flex items-center gap-3 text-slate-400">
                                    <flux:icon.list-bullet class="w-4 h-4 text-indigo-400" />
                                    <span class="text-xs font-bold uppercase tracking-wider">{{ $playlist->lessons_count }} Lessons</span>
                                </div>
                                <div class="flex items-center gap-3 text-slate-400">
                                    <flux:icon.chart-bar class="w-4 h-4 text-emerald-400" />
                                    <span class="text-xs font-bold uppercase tracking-wider">{{ $playlist->level ?? 'Beginner' }}</span>
                                </div>
                                <div class="flex items-center gap-3 text-slate-400">
                                    <flux:icon.tag class="w-4 h-4 text-amber-400" />
                                    <span class="text-xs font-bold uppercase tracking-wider truncate">{{ $playlist->category ?? 'Frameworks' }}</span>
                                </div>
                            </div>
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
