<div class="px-8 md:px-12 py-12 max-w-7xl mx-auto w-full space-y-12">
    <!-- Header: Operational Command -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
        <div class="space-y-3">
            <div class="flex items-center gap-3">
                <div class="px-2.5 py-1 rounded bg-violet-500/10 border border-violet-500/20">
                    <span class="text-[10px] font-black text-violet-500 uppercase tracking-[0.2em]">{{ __('Administrative Hub') }}</span>
                </div>
                <div class="flex items-center gap-1.5 text-[10px] font-bold text-zinc-500 uppercase tracking-widest">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.4)]"></span>
                    {{ __('Database Active') }}
                </div>
            </div>
            <h1 class="text-4xl md:text-6xl font-black text-white tracking-tighter uppercase">{{ __('Manage Playlists') }}</h1>
            <p class="text-zinc-500 font-mono text-sm tracking-tight max-w-2xl">{{ __('Primary Curriculum Controller: Initialize, edit, and orchestrate all syllabus deployments across the global learning grid.') }}</p>
        </div>
        
        <div class="relative group">
            <flux:button href="{{ route('admin.playlists.create') }}" variant="primary" icon="plus" wire:navigate class="!bg-violet-600 hover:!bg-violet-500 !text-[11px] font-black uppercase tracking-[0.2em] px-8 py-3 rounded-xl transition-all shadow-[0_0_30px_rgba(139,92,246,0.3)]">
                {{ __('New Deployment') }}
            </flux:button>
            <div class="absolute -bottom-1 -right-1 w-2 h-2 border-b border-r border-violet-500/50"></div>
        </div>
    </div>

    <!-- Operational List -->
    <div class="space-y-4">
        <div class="grid grid-cols-12 gap-4 px-8 pb-4 border-b border-zinc-900">
            <div class="col-span-6 text-[10px] font-black text-zinc-600 uppercase tracking-[0.3em]">{{ __('Operational Unit') }}</div>
            <div class="col-span-2 text-[10px] font-black text-zinc-600 uppercase tracking-[0.3em]">{{ __('Status') }}</div>
            <div class="col-span-1 text-[10px] font-black text-zinc-600 uppercase tracking-[0.3em]">{{ __('Load') }}</div>
            <div class="col-span-3 text-right text-[10px] font-black text-zinc-600 uppercase tracking-[0.3em]">{{ __('Directives') }}</div>
        </div>

        <div class="space-y-3">
            @foreach($playlists as $playlist)
            <div class="group relative bg-zinc-900/40 backdrop-blur-sm border border-zinc-800/60 rounded-2xl p-6 transition-all duration-500 hover:border-violet-500/40 hover:bg-zinc-900/60 hover:shadow-[0_0_40px_-15px_rgba(139,92,246,0.3)]">
                <div class="grid grid-cols-12 gap-4 items-center">
                    {{-- Unit Identity --}}
                    <div class="col-span-6 flex items-center gap-6">
                        <div class="relative shrink-0 w-16 h-16 rounded-xl bg-zinc-950 border border-zinc-800 p-1 group-hover:border-violet-500/40 transition-colors duration-500 overflow-hidden shadow-2xl">
                            @if($playlist->thumbnail)
                                <img src="{{ str_starts_with($playlist->thumbnail, 'http') ? $playlist->thumbnail : asset('storage/' . $playlist->thumbnail) }}" class="w-full h-full object-cover rounded-lg group-hover:scale-110 transition-transform duration-700" />
                            @else
                                <div class="w-full h-full rounded-lg bg-zinc-900 flex items-center justify-center text-zinc-700 group-hover:text-violet-500 transition-colors duration-500">
                                    <flux:icon.command-line class="w-8 h-8"/>
                                </div>
                            @endif
                        </div>
                        <div class="min-w-0 space-y-1">
                            <h4 class="font-black text-lg text-white uppercase tracking-tight group-hover:text-violet-400 transition-colors truncate">
                                {{ $playlist->title }}
                            </h4>
                            <div class="flex items-center gap-3">
                                <span class="font-mono text-[9px] text-zinc-600 uppercase tracking-widest">{{ __('Sector') }} // {{ $playlist->category ?? 'General' }}</span>
                                <span class="w-1 h-1 rounded-full bg-zinc-800"></span>
                                <p class="text-[10px] text-zinc-500 line-clamp-1 italic max-w-sm">{{ str($playlist->description)->limit(60) }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Status Indicator --}}
                    <div class="col-span-2">
                        <div class="flex items-center gap-2">
                            @if($playlist->is_published)
                                <div class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></div>
                                <span class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">{{ __('Active') }}</span>
                            @else
                                <div class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></div>
                                <span class="text-[10px] font-black text-amber-500 uppercase tracking-widest">{{ __('Draft') }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Operational Load --}}
                    <div class="col-span-1">
                        <div class="flex items-center gap-2 text-zinc-400">
                            <flux:icon.queue-list class="w-3.5 h-3.5 text-zinc-600" />
                            <span class="text-xs font-mono font-bold">{{ $playlist->courses_count }}</span>
                        </div>
                    </div>

                    {{-- Global Directives --}}
                    <div class="col-span-3">
                        <div class="flex items-center justify-end gap-3">
                            <flux:button size="sm" variant="subtle" href="{{ route('admin.playlists.courses', $playlist) }}" wire:navigate class="!bg-zinc-950 !border-zinc-800 !text-zinc-400 hover:!text-violet-400 hover:!border-violet-500/40 !text-[9px] font-black uppercase tracking-widest px-4 py-1.5 rounded-lg transition-all">
                                <flux:icon.list-bullet class="w-3.5 h-3.5 mr-1.5" />
                                {{ __('Manage') }}
                            </flux:button>
                            
                            <a href="{{ route('admin.playlists.edit', $playlist) }}" wire:navigate class="w-8 h-8 rounded-lg bg-zinc-950 border border-zinc-800 flex items-center justify-center text-zinc-500 hover:text-white hover:border-zinc-600 transition-all">
                                <flux:icon.pencil-square class="w-4 h-4" />
                            </a>

                            <button wire:click="delete({{ $playlist->id }})" wire:confirm="{{ __('Initialize Purge Sequence: Are you sure you want to permanently delete this operational unit?') }}" class="w-8 h-8 rounded-lg bg-zinc-950 border border-zinc-800 flex items-center justify-center text-zinc-600 hover:text-rose-500 hover:border-rose-500/30 transition-all">
                                <flux:icon.trash class="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Side Accent Brackets --}}
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-[2px] h-0 bg-violet-600 group-hover:h-12 transition-all duration-500"></div>
                <div class="absolute right-0 top-1/2 -translate-y-1/2 w-[1px] h-0 bg-zinc-800 group-hover:h-8 transition-all duration-500"></div>
            </div>
            @endforeach
        </div>
    </div>
    
    @if($playlists->hasPages())
        <div class="mt-12 flex justify-center">
            {{ $playlists->links() }}
        </div>
    @endif
</div>