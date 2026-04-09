<div class="min-h-screen bg-zinc-950 p-6 lg:p-12 relative">
    {{-- Background Decorative Grid --}}
    <div class="absolute inset-0 z-0 pointer-events-none opacity-20 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:40px_40px]"></div>

    <div class="max-w-6xl mx-auto relative z-10">
        {{-- Header Section --}}
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 mb-16">
            <div class="space-y-2">
                <div class="flex items-center gap-3 mb-1">
                    <div class="p-2 bg-violet-600/10 rounded-lg border border-violet-500/20">
                        <flux:icon.users class="w-5 h-5 text-violet-400" />
                    </div>
                    <span class="text-[10px] font-mono text-zinc-500 tracking-[0.4em] uppercase">{{ __('Intelligence // Assets') }}</span>
                </div>
                <h1 class="text-4xl lg:text-5xl font-black text-white tracking-tighter uppercase italic">
                    {{ __('Instructors') }}<span class="text-violet-600 text-6xl leading-[0] inline-block -ml-1">.</span>
                </h1>
                <p class="text-sm text-zinc-500 max-w-md">{{ __('Manage your network of specialized instructors and oversee curriculum deployment.') }}</p>
            </div>
            
            <div class="flex items-center gap-4">
                <flux:button :href="route('admin.users.create')" variant="primary" icon="plus" class="!bg-violet-600 hover:!bg-violet-500 !text-[10px] font-black uppercase tracking-widest px-8 h-12 rounded-xl transition-all shadow-[0_0_30px_rgba(139,92,246,0.3)]" wire:navigate>
                    {{ __('Enlist New Asset') }}
                </flux:button>
            </div>
        </div>

        {{-- Stats HUD --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-zinc-900/40 border border-zinc-800/50 rounded-2xl p-6 backdrop-blur-xl relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-br from-violet-500/5 to-transparent pointer-events-none"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[9px] font-mono text-zinc-500 uppercase tracking-widest">{{ __('Total Instructors') }}</span>
                        <flux:icon.users class="w-4 h-4 text-violet-500/50" />
                    </div>
                    <div class="text-3xl font-black text-white italic group-hover:scale-110 transition-transform origin-left duration-500">
                        {{ $instructors->total() }}
                    </div>
                </div>
            </div>
            {{-- Extra slots for future stats like "Total Playlists" --}}
        </div>

        {{-- Assets List --}}
        <div class="space-y-4">
            @foreach($instructors as $instructor)
            <div class="group relative bg-zinc-900/20 hover:bg-zinc-800/30 border border-zinc-800/50 hover:border-violet-500/30 rounded-2xl p-6 transition-all duration-500 backdrop-blur-sm overflow-hidden">
                {{-- Animated Interior Glow --}}
                <div class="absolute inset-0 bg-gradient-to-r from-violet-600/0 via-violet-600/0 to-violet-600/0 group-hover:via-violet-600/[0.03] transition-all duration-700"></div>
                
                <div class="relative z-10 flex flex-col lg:flex-row lg:items-center gap-8">
                    {{-- User Identity --}}
                    <div class="flex items-center gap-5 flex-1 min-w-0">
                        <div class="relative">
                            <flux:avatar src="{{ $instructor->profilePhotoUrl() }}" class="w-14 h-14 rounded-xl border-2 border-zinc-800 group-hover:border-violet-500/50 transition-colors shadow-2xl" />
                            <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-violet-600 rounded-full border-2 border-zinc-900 shadow-[0_0_10px_rgba(139,92,246,0.5)]"></div>
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-xl font-black text-white tracking-tight uppercase group-hover:text-violet-400 transition-colors truncate">
                                {{ $instructor->name }}
                            </h3>
                            <div class="flex items-center gap-4 mt-1">
                                <span class="text-[10px] font-mono text-zinc-500 uppercase tracking-widest flex items-center gap-1.5">
                                    <flux:icon.envelope class="w-3 h-3" />
                                    {{ $instructor->email }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Portfolio Info --}}
                    <div class="flex flex-wrap items-center gap-6 lg:gap-12">
                        <div class="space-y-1">
                            <span class="text-[9px] font-mono text-zinc-600 uppercase tracking-widest block">{{ __('Deployed Playlists') }}</span>
                            <div class="flex items-baseline gap-2">
                                <span class="text-2xl font-black text-white italic">{{ $instructor->playlists_count }}</span>
                                <span class="text-[10px] text-zinc-500 uppercase font-black tracking-tighter">{{ __('Assets') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-3 lg:ml-auto">
                        <div class="h-8 w-[1px] bg-zinc-800 hidden lg:block mr-3"></div>
                        
                        <div class="relative group/btn">
                            <button 
                                wire:click="deleteInstructor({{ $instructor->id }})" 
                                wire:confirm="{{ __('Are you absolutely sure about decommissioning this instructor? Their access will be revoked immediately.') }}"
                                class="p-3 bg-zinc-950/50 hover:bg-rose-500/10 border border-zinc-800 hover:border-rose-500/50 text-zinc-500 hover:text-rose-400 rounded-xl transition-all duration-300"
                            >
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
    
    @if($instructors->hasPages())
        <div class="mt-12 flex justify-center">
            {{ $instructors->links() }}
        </div>
    @endif
</div>
