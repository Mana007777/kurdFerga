<div class="p-6 md:p-10 max-w-7xl mx-auto w-full">
    <!-- Header -->
    <div class="mb-10">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-violet-500/10 border border-violet-500/20 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-widest mb-4">
            <span class="w-2 h-2 rounded-full bg-violet-500 shadow-[0_0_8px_rgba(139,92,246,0.5)]"></span>
            Latest Content
        </div>
        <h1 class="text-4xl md:text-5xl font-black text-slate-800 dark:text-white tracking-tight mb-2">All Playlists</h1>
        <p class="text-slate-500 dark:text-gray-400 text-lg">Browse and watch all published learning playlists.</p>
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
                    <!-- Icon Container (Clean & Professional) -->
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 z-20">
                        <div class="relative w-20 h-20 rounded-full p-0.5 bg-gray-200 dark:bg-gray-700 border-4 border-gray-100 dark:border-gray-900 shadow-md group-hover:border-violet-500/50 transition-all duration-500">
                            <div class="w-full h-full rounded-full bg-gray-100 dark:bg-gray-800 overflow-hidden">
                                @if($playlist->thumbnail)
                                    <img src="{{ str_starts_with($playlist->thumbnail, 'http') ? $playlist->thumbnail : asset('storage/' . $playlist->thumbnail) }}" class="w-full h-full object-cover rounded-full group-hover:scale-110 transition-transform duration-500" alt="{{ $playlist->title }}" />
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-200 dark:bg-gray-700 rounded-full">
                                        <flux:icon.academic-cap class="w-8 h-8 text-gray-500 dark:text-gray-400" />
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="flex-1 bg-white dark:bg-gray-900 rounded-[2.5rem] border border-gray-200 dark:border-gray-800 p-8 pt-14 shadow-lg relative overflow-hidden group-hover:border-violet-500/30 transition-all duration-500">
                        
                        <div class="relative z-10 flex flex-col h-full">
                            <div class="text-center mb-6">
                                <h3 class="text-xl md:text-2xl font-black text-gray-900 dark:text-white leading-tight mb-2 group-hover:text-violet-600 dark:group-hover:text-violet-400 transition-colors duration-300">
                                    {{ $playlist->title }}
                                </h3>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                    With <span class="text-gray-700 dark:text-gray-300">{{ $playlist->author_name ?? 'Team Ferga' }}</span>
                                </p>
                            </div>

                            <div class="mt-auto pt-6 border-t border-gray-100 dark:border-gray-800 space-y-3">
                                <div class="flex items-center gap-3 text-violet-600 dark:text-violet-400">
                                    <flux:icon.list-bullet class="w-4 h-4" />
                                    <span class="text-xs font-bold uppercase tracking-wider">{{ $playlist->lessons_count }} Lessons</span>
                                </div>
                                @php
                                    $levelColor = match(strtolower($playlist->level ?? 'beginner')) {
                                        'beginner' => 'text-emerald-600 dark:text-emerald-400',
                                        'intermediate' => 'text-amber-600 dark:text-amber-400',
                                        'hard' => 'text-rose-600 dark:text-rose-400',
                                        default => 'text-emerald-600 dark:text-emerald-400',
                                    };
                                @endphp
                                <div class="flex items-center gap-3 {{ $levelColor }}">
                                    <flux:icon.chart-bar class="w-4 h-4" />
                                    <span class="text-xs font-bold uppercase tracking-wider">{{ $playlist->level ?? 'Beginner' }}</span>
                                </div>
                                <div class="flex items-center gap-3 text-blue-600 dark:text-blue-400">
                                    <flux:icon.tag class="w-4 h-4" />
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
        <div class="text-center py-20 rounded-2xl border border-dashed border-slate-300 dark:border-gray-700">
            <svg class="w-14 h-14 text-slate-300 dark:text-gray-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-lg font-bold text-slate-700 dark:text-gray-300">No playlists published yet</h3>
            <p class="text-sm text-slate-500 dark:text-gray-500 mt-1">Check back soon for new content!</p>
        </div>
    @endif
</div>
