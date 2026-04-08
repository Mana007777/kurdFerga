<div class="px-8 md:px-12 py-12 max-w-7xl mx-auto w-full space-y-12">
    <!-- Header: Mission Briefing -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div class="space-y-2">
            <div class="flex items-center gap-3">
                <div class="px-2 py-0.5 rounded bg-violet-500/10 border border-violet-500/20">
                    <span class="text-[10px] font-black text-violet-500 uppercase tracking-[0.2em]">Curriculum Database</span>
                </div>
                <div class="flex items-center gap-1.5 text-[10px] font-bold text-zinc-500 uppercase tracking-widest">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.4)]"></span>
                    Live Feed
                </div>
            </div>
            <h1 class="text-4xl md:text-6xl font-black text-white tracking-tighter uppercase">Academy Deployments</h1>
            <p class="text-zinc-500 font-mono text-sm tracking-tight">Available Units: Select a syllabus for high-frequency learning integration.</p>
        </div>

        <div class="relative w-full max-w-sm group">
            <flux:input 
                wire:model.live.debounce.300ms="search" 
                icon="magnifying-glass" 
                clearable 
                placeholder="Protocol Search..." 
                class="!bg-zinc-950 !border-zinc-800 !text-white !font-mono !text-xs !py-3 tracking-widest focus:!border-violet-500/50"
            />
            <div class="absolute -bottom-1 -right-1 w-2 h-2 border-b border-r border-zinc-700"></div>
        </div>
    </div>

    <!-- Deployment Grid -->
    @if($playlists->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($playlists as $index => $playlist)
                <a
                    href="{{ route('playlists.show', $playlist) }}"
                    wire:navigate
                    class="group relative flex flex-col bg-zinc-950 border border-zinc-800 rounded-2xl overflow-hidden transition-all duration-500 hover:border-violet-500/40 hover:shadow-[0_0_40px_-12px_rgba(139,92,246,0.3)]"
                >
                    <!-- Visual Header (Thumbnail or Unit Label) -->
                    <div class="relative h-44 overflow-hidden border-b border-zinc-900 flex items-center justify-center bg-zinc-950">
                        @if($playlist->thumbnail)
                            <img src="{{ str_starts_with($playlist->thumbnail, 'http') ? $playlist->thumbnail : asset('storage/' . $playlist->thumbnail) }}" class="w-full h-full object-cover opacity-60 group-hover:opacity-80 group-hover:scale-105 transition-all duration-700" alt="{{ $playlist->title }}" />
                        @else
                             <flux:icon.command-line class="w-16 h-16 text-zinc-800" />
                        @endif
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
                        
                        <!-- Unit ID Badge -->
                        <div class="absolute top-4 left-4 flex flex-col gap-0.5">
                            <span class="text-[9px] font-black text-violet-500 uppercase tracking-[0.2em]">Unit // {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="text-[8px] font-mono text-zinc-600 uppercase">SYS-{{ strtoupper(substr($playlist->slug, 0, 4)) }}</span>
                        </div>
                        
                        <!-- Status Pulse -->
                        <div class="absolute top-4 right-4 flex items-center gap-1.5 px-2 py-0.5 rounded bg-zinc-950/80 border border-zinc-800 backdrop-blur-sm">
                            <span class="w-1 h-1 rounded-full bg-emerald-500"></span>
                            <span class="text-[8px] font-black text-zinc-400 uppercase tracking-widest">Active</span>
                        </div>
                    </div>

                    <!-- Module Content -->
                    <div class="p-6 space-y-6 flex-1 flex flex-col relative">
                        <div class="space-y-1">
                            <h3 class="text-xl font-black text-white leading-tight tracking-tight group-hover:text-violet-400 transition-colors duration-300 uppercase">
                                {{ $playlist->title }}
                            </h3>
                            <p class="text-[10px] font-mono text-zinc-500 uppercase tracking-widest">Lead: {{ $playlist->author_name ?? 'Ferga Command' }}</p>
                        </div>

                        <div class="mt-auto grid grid-cols-2 gap-2">
                            <div class="bg-zinc-950 border border-zinc-800/50 rounded-lg p-2 flex flex-col justify-center">
                                <span class="text-[8px] font-black text-zinc-600 uppercase tracking-widest mb-0.5">Integration</span>
                                <span class="text-xs font-mono text-white tracking-widest">{{ $playlist->lessons_count }} BLOCKS</span>
                            </div>
                            <div class="bg-zinc-950 border border-zinc-800/50 rounded-lg p-2 flex flex-col justify-center">
                                <span class="text-[8px] font-black text-zinc-600 uppercase tracking-widest mb-0.5">Level</span>
                                <span class="text-xs font-mono text-zinc-300 tracking-widest uppercase truncate">{{ $playlist->level ?? 'BEGINNER' }}</span>
                            </div>
                        </div>

                        <!-- Precision Hover Bracket -->
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-0.5 h-0 bg-violet-600 group-hover:h-12 transition-all duration-300"></div>
                    </div>

                    <!-- Edge Brackets -->
                    <div class="absolute top-2 left-2 w-2 h-2 border-t border-l border-white/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="absolute top-2 right-2 w-2 h-2 border-t border-r border-white/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="absolute bottom-2 left-2 w-2 h-2 border-b border-l border-white/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="absolute bottom-2 right-2 w-2 h-2 border-b border-r border-white/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </a>
            @endforeach
        </div>

        @if($playlists->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $playlists->links() }}
            </div>
        @endif
    @else
        <div class="relative overflow-hidden rounded-[2rem] bg-zinc-950 border-2 border-dashed border-zinc-800 p-24 flex flex-col items-center justify-center text-center space-y-6">
             <div class="w-16 h-16 rounded-2xl bg-zinc-950 border border-zinc-800 flex items-center justify-center text-zinc-700 mb-2">
                <flux:icon.command-line class="w-8 h-8 animate-pulse" />
            </div>
            <div class="space-y-1">
                <h3 class="text-xl font-black text-zinc-400 uppercase tracking-[0.2em]">Database Empty</h3>
                <p class="text-[10px] font-bold text-zinc-600 uppercase tracking-widest max-w-sm mx-auto">Critical Error: No curriculum deployments detected. Awaiting administrative synchronization.</p>
            </div>
        </div>
    @endif
</div>
