<div class="p-6 md:p-10 max-w-7xl mx-auto w-full">
    <!-- Breadcrumbs / Back -->
    <div class="mb-12">
        <flux:button variant="ghost" icon="arrow-left" href="{{ route('instructors.index') }}" wire:navigate class="!text-zinc-500 hover:!text-white">{{ __('Back to Instructors') }}</flux:button>
    </div>

    <!-- Instructor Header -->
    <div class="relative bg-zinc-900/40 backdrop-blur-sm rounded-[3rem] border border-zinc-800 p-12 shadow-2xl overflow-hidden mb-16">
        <div class="absolute -right-24 -top-24 w-96 h-96 bg-violet-600/10 rounded-full blur-3xl"></div>
        
        <div class="relative flex flex-col md:flex-row items-center gap-10">
            {{-- Avatar --}}
            <div class="relative">
                <div class="w-32 h-32 md:w-48 md:h-48 rounded-full p-1.5 bg-zinc-950 border-8 border-zinc-900 shadow-2xl overflow-hidden">
                    @if($user->profile_photo_path)
                        <img src="{{ asset('storage/' . $user->profile_photo_path) }}" class="w-full h-full object-cover rounded-full" alt="{{ $user->name }}" />
                    @else
                        <div class="w-full h-full rounded-full bg-gradient-to-br from-violet-600 to-indigo-700 flex items-center justify-center text-5xl font-black text-white uppercase tracking-tighter shadow-inner">
                            {{ $user->initials() }}
                        </div>
                    @endif
                </div>
                <div class="absolute inset-[-4px] rounded-full border border-violet-500/20 shadow-[0_0_30px_rgba(139,92,246,0.1)]"></div>
            </div>

            {{-- Info --}}
            <div class="flex-1 text-center md:text-left">
                <div class="inline-flex items-center px-4 py-1 rounded-full bg-violet-500/10 border border-violet-500/20 text-violet-400 text-[10px] font-black uppercase tracking-widest mb-6">
                    {{ __($user->role) }} // {{ __('Portfolio') }}
                </div>
                <h1 class="text-4xl md:text-7xl font-black text-white tracking-tighter uppercase mb-4">{{ $user->name }}</h1>
                <p class="text-zinc-400 font-mono text-sm md:text-base uppercase tracking-tight max-w-2xl leading-relaxed">
                    {{ __('Lead operative and curriculum architect. Specialized in high-velocity skill acquisition and platform-wide training modules.') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Search / Filter -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
        <h2 class="text-2xl font-black text-white tracking-tight uppercase">{{ __('Deployed Playlists') }}</h2>
        
        <div class="relative w-full max-w-md group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-transform group-focus-within:scale-110">
                <flux:icon.magnifying-glass class="w-5 h-5 text-zinc-500 group-focus-within:text-violet-500 transition-colors" />
            </div>
            <input 
                type="text" 
                wire:model.live.debounce.300ms="search" 
                placeholder="{{ __('Search missions...') }}"
                class="w-full bg-zinc-900/50 border border-zinc-800 text-white text-sm rounded-2xl py-3 pl-12 pr-4 focus:outline-none focus:ring-2 focus:ring-violet-500/40 focus:border-violet-500/40 transition-all placeholder:text-zinc-600 placeholder:uppercase placeholder:text-[10px] placeholder:font-black placeholder:tracking-widest"
            />
        </div>
    </div>

    <!-- Playlists Grid (Reusing index style) -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
        @forelse ($playlists as $playlist)
            <a href="{{ route('playlists.show', $playlist) }}" wire:navigate class="group relative bg-zinc-900/40 backdrop-blur-sm rounded-[2.5rem] border border-zinc-800 p-8 pt-10 transition-all duration-500 hover:border-violet-500/20 hover:bg-zinc-900/60 overflow-hidden shadow-2xl">
                <div class="flex items-center justify-between mb-8">
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-violet-500/10 border border-violet-500/20 text-violet-400 text-[9px] font-black uppercase tracking-widest transition-colors group-hover:bg-violet-500 group-hover:text-white">
                        {{ __($playlist->level ?? 'BEGINNER') }}
                    </div>
                    <div class="flex items-center gap-2 text-[9px] font-black text-zinc-600 uppercase tracking-widest">
                        <flux:icon.clock class="w-4 h-4 opacity-50" />
                        {{ $playlist->total_duration ?? '00:00' }}
                    </div>
                </div>

                <h3 class="text-2xl font-black text-white tracking-tighter uppercase mb-4 leading-none group-hover:text-violet-400 transition-colors">{{ $playlist->title }}</h3>
                <p class="text-zinc-500 text-[10px] font-mono uppercase tracking-tight mb-8 line-clamp-2 leading-relaxed">
                    {{ $playlist->description }}
                </p>

                <div class="flex items-center gap-6 mt-auto">
                    <div class="flex flex-col">
                        <span class="text-[8px] font-black text-zinc-600 uppercase tracking-widest mb-1">{{ __('Deployment') }}</span>
                        <div class="flex items-center gap-2">
                             <div class="flex -space-x-2">
                                <div class="w-6 h-6 rounded-lg bg-zinc-950 border border-zinc-800 flex items-center justify-center text-violet-500 group-hover:scale-110 transition-transform">
                                    <flux:icon.table-cells class="w-3 h-3 fill-current" />
                                </div>
                            </div>
                            <span class="text-xs font-black text-zinc-400 uppercase tracking-tighter">{{ $playlist->sections_count }} {{ __('Units') }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col">
                         <span class="text-[8px] font-black text-zinc-600 uppercase tracking-widest mb-1">{{ __('Intel') }}</span>
                         <div class="flex items-center gap-2">
                             <div class="flex -space-x-2">
                                <div class="w-6 h-6 rounded-lg bg-zinc-950 border border-zinc-800 flex items-center justify-center text-blue-500 group-hover:scale-110 transition-transform">
                                    <flux:icon.play class="w-3 h-3 fill-current" />
                                </div>
                            </div>
                            <span class="text-xs font-black text-zinc-400 uppercase tracking-tighter">{{ $playlist->lessons_count }} {{ __('Files') }}</span>
                        </div>
                    </div>
                </div>

                <div class="absolute bottom-0 right-0 p-8 opacity-0 group-hover:opacity-100 translate-x-4 group-hover:translate-x-0 transition-all duration-500">
                    <div class="w-12 h-12 rounded-2xl bg-violet-600 flex items-center justify-center text-white shadow-[0_0_30px_rgba(139,92,246,0.5)]">
                        <flux:icon.arrow-right class="w-6 h-6" />
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full py-24 text-center">
                <flux:icon.magnifying-glass class="w-12 h-12 text-zinc-800 mx-auto mb-6" />
                <p class="text-zinc-600 font-black text-[10px] uppercase tracking-[0.3em]">{{ __('No active missions found for this operative...') }}</p>
            </div>
        @endforelse
    </div>
</div>
