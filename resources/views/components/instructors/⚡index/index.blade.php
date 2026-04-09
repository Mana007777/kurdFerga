<div class="p-6 md:p-10 max-w-7xl mx-auto w-full">
    <div class="mb-12">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-violet-500/10 border border-violet-500/20 text-violet-400 text-[10px] font-bold uppercase tracking-widest mb-4">
            <span class="w-1.5 h-1.5 rounded-full bg-violet-500 shadow-[0_0_8px_rgba(139,92,246,0.6)]"></span>
            {{ __('Personnel Directory') }}
        </div>
        <h1 class="text-4xl md:text-6xl font-black text-white tracking-tighter uppercase mb-4">{{ __('Our Instructors') }}</h1>
        <p class="text-zinc-500 font-mono text-sm uppercase tracking-tight max-w-2xl">
            {{ __('Connect with the minds behind the curriculum. Expert-led training modules for the next generation of operatives.') }}
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @foreach($instructors as $instructor)
            <a href="{{ route('instructors.show', $instructor) }}" wire:navigate class="group relative bg-zinc-900/40 backdrop-blur-sm rounded-[2.5rem] border border-zinc-800 p-8 pt-12 transition-all duration-500 hover:border-violet-500/30 hover:bg-zinc-900/60 overflow-hidden">
                {{-- Decorative Background Elements --}}
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-violet-500/5 rounded-full blur-3xl group-hover:bg-violet-500/10 transition-colors"></div>
                
                {{-- Instructor Avatar --}}
                <div class="relative flex justify-center mb-8">
                    <div class="relative">
                        <div class="w-24 h-24 rounded-full p-1 bg-zinc-950 border-4 border-zinc-900 shadow-2xl group-hover:border-violet-500/50 transition-all duration-500 overflow-hidden">
                            @if($instructor->profile_photo_path)
                                <img src="{{ asset('storage/' . $instructor->profile_photo_path) }}" class="w-full h-full object-cover rounded-full" alt="{{ $instructor->name }}" />
                            @else
                                <div class="w-full h-full rounded-full bg-gradient-to-br from-violet-600 to-indigo-700 flex items-center justify-center text-xl font-black text-white uppercase tracking-tighter shadow-inner">
                                    {{ $instructor->initials() }}
                                </div>
                            @endif
                        </div>
                        {{-- Orbital Ring --}}
                        <div class="absolute inset-[-8px] rounded-full border border-violet-500/10 opacity-0 group-hover:opacity-100 group-hover:scale-110 transition-all duration-700"></div>
                    </div>
                </div>

                {{-- Instructor Info --}}
                <div class="text-center">
                    <div class="inline-flex items-center px-2.5 py-0.5 rounded-md bg-zinc-950 text-[9px] font-black text-zinc-500 uppercase tracking-widest border border-zinc-800 mb-4">
                        {{ __($instructor->role) }}
                    </div>
                    <h3 class="text-xl font-black text-white tracking-tight uppercase group-hover:text-violet-400 transition-colors mb-2">{{ $instructor->name }}</h3>
                    <p class="text-zinc-500 text-[10px] font-mono uppercase tracking-[0.2em] mb-8">{{ $instructor->email }}</p>

                    {{-- Stats Grid --}}
                    <div class="grid grid-cols-2 gap-4 border-t border-zinc-800/50 pt-8">
                        <div>
                            <div class="text-[10px] font-black text-zinc-600 uppercase tracking-widest mb-1">{{ __('Playlists') }}</div>
                            <div class="text-2xl font-black text-white tracking-tighter">{{ $instructor->playlists_count }}</div>
                        </div>
                        <div>
                            <div class="text-[10px] font-black text-zinc-600 uppercase tracking-widest mb-1">{{ __('XP Rank') }}</div>
                            <div class="text-2xl font-black text-violet-500 tracking-tighter">{{ $instructor->pts ?? 0 }}</div>
                        </div>
                    </div>
                </div>

                {{-- Hover Indicator --}}
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    <div class="flex items-center gap-2 text-[8px] font-black text-violet-400 uppercase tracking-[0.3em]">
                        {{ __('View Portfolio') }}
                        <flux:icon.arrow-right class="w-3 h-3" />
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
