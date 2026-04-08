@if($lesson && $playlist)
<div class="relative w-full overflow-hidden rounded-[1.5rem] bg-zinc-950 border border-zinc-800 p-8 md:p-10 group transition-all duration-500 hover:border-violet-500/30 shadow-[0_0_50px_-12px_rgba(0,0,0,0.5)]">
    
    <!-- Background Command Interface -->
    <div class="absolute inset-x-0 top-0 h-1/2 bg-[linear-gradient(to_right,#80808008_1px,transparent_1px),linear-gradient(to_bottom,#80808008_1px,transparent_1px)] bg-[size:32px_32px]"></div>
    <div class="absolute right-0 top-0 w-1/3 h-full bg-gradient-to-l from-violet-500/5 to-transparent pointer-events-none"></div>

    <div class="relative z-10 flex flex-col md:flex-row items-center justify-between w-full gap-8">
        
        <div class="flex items-center gap-10 w-full md:w-3/4">
            <!-- Unit Icon -->
            <div class="flex-shrink-0 relative">
                <div class="w-20 h-20 md:w-24 md:h-24 rounded-2xl bg-zinc-950 border border-zinc-800 flex items-center justify-center text-violet-500 shadow-inner group-hover:border-violet-500/40 transition-all duration-500 relative z-10 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-violet-500/10 to-transparent"></div>
                    <flux:icon.play-circle class="w-12 h-12 md:w-14 md:h-14 drop-shadow-[0_0_10px_rgba(139,92,246,0.3)]" />
                </div>
                <!-- Radar Pulse -->
                <div class="absolute -inset-2 rounded-2xl border border-violet-500/20 animate-ping opacity-20"></div>
            </div>
            
            <!-- Mission Specs -->
            <div class="flex flex-col space-y-3 flex-1">
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2 px-3 py-1 rounded-md bg-violet-500/10 border border-violet-500/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-violet-500 animate-pulse"></span>
                        <span class="text-[10px] font-black text-violet-500 uppercase tracking-[0.2em]">{{ __('Active Mission') }}</span>
                    </div>
                    <div class="h-px flex-1 bg-zinc-950"></div>
                    <span class="text-[10px] font-mono text-zinc-500 uppercase tracking-widest">{{ $playlist->title }} // UNIT-{{ str_pad($playlist->id, 3, '0', STR_PAD_LEFT) }}</span>
                </div>

                <div class="space-y-1">
                    <h2 class="text-3xl md:text-4xl font-black text-white tracking-tighter drop-shadow-sm group-hover:text-violet-400 transition-colors duration-300">
                        {{ $lesson->title }}
                    </h2>
                    <p class="text-zinc-500 font-mono text-xs uppercase tracking-widest">{{ __('Protocol: Direct Learning Integration') }}</p>
                </div>

                <!-- Segmented Linear Progress (Dummy logic for visual) -->
                <div class="flex gap-1 w-full max-w-md pt-2">
                    @php $progress = 65; @endphp {{-- Placeholder for visual --}}
                    @foreach(range(1, 25) as $i)
                        <div class="h-1.5 flex-1 rounded-full {{ ($i / 25) * 100 <= $progress ? 'bg-violet-500' : 'bg-zinc-950' }} {{ ($i / 25) * 100 <= $progress ? 'shadow-[0_0_8px_rgba(139,92,246,0.5)]' : '' }}"></div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Terminal Action -->
        <div class="flex-shrink-0 flex flex-col items-end gap-3 w-full md:w-auto">
            <a href="{{ route('playlists.show', $playlist) }}" wire:navigate class="group/btn relative inline-flex items-center gap-4 px-10 py-4 font-black text-white transition-all duration-300 bg-zinc-950 border border-zinc-800 rounded-xl hover:border-violet-500/50 hover:bg-zinc-900 shadow-xl">
                <span class="text-[11px] font-black uppercase tracking-[0.3em]">{{ __('Resume Integration') }}</span>
                <flux:icon.arrow-right class="w-5 h-5 group-hover/btn:translate-x-1.5 transition-transform text-violet-500" />
            </a>
            <span class="text-[9px] font-bold text-zinc-600 uppercase tracking-widest mr-2">{{ __('Authorization: [Approved]') }}</span>
        </div>
    </div>

    <!-- Edge Brackets -->
    <div class="absolute top-6 left-6 w-3 h-3 border-t border-l border-zinc-700 opacity-50"></div>
    <div class="absolute top-6 right-6 w-3 h-3 border-t border-r border-zinc-700 opacity-50"></div>
    <div class="absolute bottom-6 left-6 w-3 h-3 border-b border-l border-zinc-700 opacity-50"></div>
    <div class="absolute bottom-6 right-6 w-3 h-3 border-b border-r border-zinc-700 opacity-50"></div>
</div>
@else
<div class="relative w-full overflow-hidden rounded-[1.5rem] bg-zinc-950 border border-zinc-800 p-12 flex items-center justify-center">
    <div class="text-center space-y-6">
        <div class="w-16 h-16 bg-zinc-950 border border-zinc-800 rounded-2xl flex items-center justify-center mx-auto text-zinc-700 shadow-inner">
             <flux:icon.command-line class="w-8 h-8" />
        </div>
        <div class="space-y-1">
            <h2 class="text-xl font-black text-white tracking-tight uppercase tracking-[0.2em]">{{ __('Queue Neutralized') }}</h2>
            <p class="text-[10px] font-bold tracking-widest text-zinc-500 uppercase">{{ __('Awaiting Next Directive') }}</p>
        </div>
        <a href="{{ route('playlists.index') }}" wire:navigate class="inline-flex items-center gap-3 px-8 py-3 rounded-xl bg-violet-600 text-white text-[11px] font-black uppercase tracking-[0.2em] hover:bg-violet-500 transition-colors shadow-lg shadow-violet-500/20">
            {{ __('Initialize New Mission') }}
        </a>
    </div>
</div>
@endif