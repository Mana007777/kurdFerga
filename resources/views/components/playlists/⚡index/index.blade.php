<div class="px-8 md:px-12 py-12 max-w-7xl mx-auto w-full space-y-12">
    <!-- Header: Mission Briefing -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div class="space-y-2">
            <div class="flex items-center gap-3">
                <div class="px-2 py-0.5 rounded bg-violet-500/10 border border-violet-500/20">
                    <span class="text-[10px] font-black text-violet-500 uppercase tracking-[0.2em]">{{ __('Curriculum Database') }}</span>
                </div>
                <div class="flex items-center gap-1.5 text-[10px] font-bold text-zinc-500 uppercase tracking-widest">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.4)]"></span>
                    {{ __('Live Feed') }}
                </div>
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-6xl font-black text-white tracking-tighter uppercase">{{ __('Academy Deployments') }}</h1>
            <p class="text-zinc-500 font-mono text-sm tracking-tight">{{ __('Available Units: Select a syllabus for high-frequency learning integration.') }}</p>
        </div>

        <div class="relative w-full max-w-sm group">
            <flux:input 
                wire:model.live.debounce.300ms="search" 
                icon="magnifying-glass" 
                clearable 
                placeholder="{{ __('Protocol Search...') }}" 
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
                    class="group relative flex flex-col bg-zinc-950 border border-zinc-800 rounded-[2.5rem] pt-16 pb-10 px-8 transition-all duration-500 hover:border-violet-500/40 hover:shadow-[0_0_50px_-12px_rgba(139,92,246,0.5)] mt-12"
                >
                    {{-- Circular Bio-Link Icon (Overlapping Border) --}}
                    <div class="absolute -top-12 left-1/2 -translate-x-1/2 w-24 h-24 rounded-full p-1 bg-zinc-950 border border-zinc-800 shadow-xl z-20 group-hover:border-violet-500/50 transition-colors duration-500">
                        <div class="w-full h-full rounded-full border-2 border-zinc-900 overflow-hidden bg-zinc-900 flex items-center justify-center">
                            @if($playlist->thumbnail)
                                <img src="{{ str_starts_with($playlist->thumbnail, 'http') ? $playlist->thumbnail : asset('storage/' . $playlist->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $playlist->title }}" />
                            @else
                                 <flux:icon.command-line class="w-10 h-10 text-zinc-700 group-hover:text-violet-500 transition-colors duration-500" />
                            @endif
                        </div>
                        {{-- Orbital Ring --}}
                        <div class="absolute inset-[-4px] rounded-full border border-violet-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                    </div>

                    {{-- Module Header --}}
                    <div class="text-center space-y-2 mb-8">
                        <h3 class="text-2xl font-black text-white leading-tight tracking-tighter uppercase group-hover:text-violet-400 transition-colors duration-300">
                            {{ $playlist->title }}
                        </h3>
                        <p class="text-[10px] font-mono text-zinc-500 uppercase tracking-[0.3em]">{{ __('Lead') }} // {{ $playlist->author_name ?? __('Command') }}</p>
                    </div>

                    {{-- Hardware Spec List --}}

                    {{-- Hardware Spec List --}}
                    <div class="space-y-4 pt-6 border-t border-zinc-900">
                        <div class="flex items-center gap-4 text-zinc-400 group/item">
                            <flux:icon.queue-list class="w-4 h-4 text-zinc-600 group-hover/item:text-violet-500 transition-colors" />
                            <span class="text-[10px] font-black uppercase tracking-widest">{{ $playlist->lessons_count }} {{ __('Episodes') }}</span>
                        </div>
                        <div class="flex items-center gap-4 text-zinc-400 group/item">
                            <flux:icon.academic-cap class="w-4 h-4 text-zinc-600 group-hover/item:text-emerald-500 transition-colors" />
                            <span class="text-[10px] font-black uppercase tracking-widest">{{ $playlist->level ?? __('Mastery') }}</span>
                        </div>
                        <div class="flex items-center gap-4 text-zinc-400 group/item">
                            <flux:icon.tag class="w-4 h-4 text-zinc-600 group-hover/item:text-amber-500 transition-colors" />
                            <span class="text-[10px] font-black uppercase tracking-widest">{{ $playlist->category ?? __('Platform') }}</span>
                        </div>
                    </div>

                    {{-- Instructor Attribution // Bottom Right --}}
                    <div class="absolute bottom-6 right-6 z-30 group/instructor flex flex-row-reverse items-center gap-3">
                        <div class="relative">
                            <div class="w-10 h-10 rounded-full p-0.5 bg-zinc-900 border border-zinc-800 shadow-xl group-hover/instructor:border-violet-500/50 transition-all duration-500 overflow-hidden">
                                @if($playlist->user && $playlist->user->profile_photo_path)
                                    <img src="{{ asset('storage/' . $playlist->user->profile_photo_path) }}" class="w-full h-full rounded-full object-cover" alt="{{ $playlist->user->name }}" />
                                @else
                                    <div class="w-full h-full rounded-full bg-gradient-to-br from-violet-600 to-indigo-700 flex items-center justify-center text-[10px] font-black text-white uppercase tracking-tighter shadow-inner">
                                        {{ $playlist->user ? $playlist->user->initials() : '??' }}
                                    </div>
                                @endif
                            </div>
                            {{-- Instructor Orbital Glow --}}
                            <div class="absolute inset-[-2px] rounded-full border border-violet-500/20 opacity-0 group-hover/instructor:opacity-100 transition-opacity duration-500"></div>
                        </div>

                        {{-- Hover Reveal Name --}}
                        <div class="flex flex-col items-end opacity-0 group-hover/instructor:opacity-100 translate-x-2 group-hover/instructor:translate-x-0 transition-all duration-500 pointer-events-none">
                            <span class="text-[8px] font-mono text-violet-500 uppercase tracking-[0.2em] leading-none mb-0.5">{{ __('Instructor') }}</span>
                            <span class="text-[10px] font-black text-white uppercase tracking-widest whitespace-nowrap">{{ $playlist->user->name ?? __('Unknown') }}</span>
                        </div>
                    </div>

                    {{-- Side Hardware Brackets --}}
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-0 bg-violet-600 group-hover:h-16 transition-all duration-500"></div>
                    <div class="absolute right-0 top-1/2 -translate-y-1/2 w-[1px] h-0 bg-zinc-800 group-hover:h-16 transition-all duration-500"></div>
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
                <h3 class="text-xl font-black text-zinc-400 uppercase tracking-[0.2em]">{{ __('Database Empty') }}</h3>
                <p class="text-[10px] font-bold text-zinc-600 uppercase tracking-widest max-w-sm mx-auto">{{ __('Critical Error: No curriculum deployments detected. Awaiting administrative synchronization.') }}</p>
            </div>
        </div>
    @endif
</div>
