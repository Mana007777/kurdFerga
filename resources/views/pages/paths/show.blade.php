<div class="px-8 md:px-12 py-12 max-w-7xl mx-auto w-full space-y-20">
    <!-- Breadcrumbs -->
    <div class="flex items-center gap-4">
        <a href="{{ route('paths.index') }}" wire:navigate class="px-3 py-1.5 rounded-lg bg-zinc-900 border border-zinc-800 text-[10px] font-black text-zinc-500 uppercase tracking-widest hover:border-violet-500/50 hover:text-violet-400 transition-all">
            [SYS::PATHS]
        </a>
        <div class="h-px w-4 bg-zinc-800"></div>
        <span class="text-[10px] font-mono text-zinc-600 uppercase tracking-widest">{{ $path->title }}</span>
    </div>

    @php
        $roadmapData = is_array($path->roadmap) ? $path->roadmap : [];
        $hasRoadmapSteps = !empty($roadmapData['steps']);
        $steps = $hasRoadmapSteps ? collect($roadmapData['steps']) : $path->playlists;
        $isDatabaseSteps = !$hasRoadmapSteps && $path->playlists->isNotEmpty();
        $totalSteps = $steps->count();
        $totalLessons = $path->playlists->sum(fn($p) => $p->lessons->count());
    @endphp

    <!-- Header Section: Deployment Briefing -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-16 items-center">
        <div class="lg:col-span-2 space-y-8">
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="px-2 py-0.5 rounded bg-violet-500/10 border border-violet-500/20">
                        <span class="text-[10px] font-black text-violet-500 uppercase tracking-[0.2em]">Curriculum Deployment</span>
                    </div>
                    <div class="flex items-center gap-1.5 text-[10px] font-bold text-zinc-500 uppercase tracking-widest">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Status: Active
                    </div>
                </div>
                <h1 class="text-5xl md:text-8xl font-black text-white tracking-tighter leading-none uppercase">
                   {{ $path->title }}
                </h1>
                <p class="text-zinc-500 font-mono text-sm max-w-2xl leading-relaxed">
                    Protocol: {{ $path->description }}
                </p>
            </div>

            <div class="flex flex-wrap gap-6 pt-4">
                <div class="bg-zinc-950 border border-zinc-800 rounded-2xl p-6 min-w-[160px] relative group overflow-hidden">
                    <div class="absolute inset-0 bg-violet-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <span class="block text-[8px] font-black text-zinc-600 uppercase tracking-[0.3em] mb-2">Unit Modules</span>
                    <span class="text-4xl font-mono font-black text-white tracking-tighter">{{ str_pad($totalSteps, 2, '0', STR_PAD_LEFT) }}</span>
                    <div class="absolute bottom-2 right-2 w-1 h-1 bg-zinc-700"></div>
                </div>
                <div class="bg-zinc-950 border border-zinc-800 rounded-2xl p-6 min-w-[160px] relative group overflow-hidden">
                     <div class="absolute inset-0 bg-emerald-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <span class="block text-[8px] font-black text-zinc-600 uppercase tracking-[0.3em] mb-2">Total Blocks</span>
                    <span class="text-4xl font-mono font-black text-white tracking-tighter">{{ str_pad($totalLessons > 0 ? $totalLessons : $totalSteps, 2, '0', STR_PAD_LEFT) }}</span>
                    <div class="absolute bottom-2 right-2 w-1 h-1 bg-zinc-700"></div>
                </div>
                <div class="bg-zinc-950 border border-zinc-800 rounded-2xl p-6 min-w-[160px] relative group overflow-hidden">
                     <div class="absolute inset-0 bg-amber-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <span class="block text-[8px] font-black text-zinc-600 uppercase tracking-[0.3em] mb-2">Security ID</span>
                    <span class="text-4xl font-mono font-black text-white tracking-tighter italic">#{{ strtoupper(substr($path->slug, 0, 4)) }}</span>
                    <div class="absolute bottom-2 right-2 w-1 h-1 bg-zinc-700"></div>
                </div>
            </div>
        </div>

        <div class="relative hidden lg:block">
            <!-- Hardware Interface Aesthetic -->
            <div class="aspect-square bg-zinc-950 border border-zinc-800 rounded-[3rem] p-12 relative group overflow-hidden">
                <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808008_1px,transparent_1px),linear-gradient(to_bottom,#80808008_1px,transparent_1px)] bg-[size:24px_24px]"></div>
                <div class="relative z-10 w-full h-full border border-zinc-800/50 rounded-full flex items-center justify-center">
                    <flux:icon.command-line class="w-32 h-32 text-zinc-800 group-hover:text-violet-500 transition-colors duration-700" />
                    <div class="absolute inset-0 rounded-full border border-violet-500/10 group-hover:inset-[-20px] transition-all duration-700"></div>
                </div>
                <!-- Corner Markers -->
                <div class="absolute top-8 left-8 w-4 h-4 border-t border-l border-zinc-800"></div>
                <div class="absolute top-8 right-8 w-4 h-4 border-t border-r border-zinc-800"></div>
                <div class="absolute bottom-8 left-8 w-4 h-4 border-b border-l border-zinc-800"></div>
                <div class="absolute bottom-8 right-8 w-4 h-4 border-b border-r border-zinc-800"></div>
            </div>
        </div>
    </div>

    <!-- Mission Parameters & Tech Specs -->
    @if(isset($roadmapData['objectives']) || isset($roadmapData['technologies']))
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Parameters -->
            @if(isset($roadmapData['objectives']))
                <div class="bg-zinc-950 border border-zinc-800 rounded-[2.5rem] p-10 relative group overflow-hidden">
                    <div class="absolute top-0 right-0 p-4">
                        <span class="text-[8px] font-mono text-zinc-700 uppercase">SYS-PRM // 01</span>
                    </div>
                    <h2 class="text-xl font-black text-white uppercase tracking-tight mb-8 flex items-center gap-3">
                        <flux:icon.check-badge class="w-6 h-6 text-violet-500" />
                        Mission Objectives
                    </h2>
                    <ul class="space-y-4">
                        @foreach($roadmapData['objectives'] as $objective)
                            <li class="flex gap-4 text-zinc-400 font-mono text-xs uppercase tracking-tight leading-relaxed group/item">
                                <span class="text-violet-500 group-hover/item:translate-x-1 transition-transform">>>></span>
                                {{ $objective }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Hardware Stack -->
            @if(isset($roadmapData['technologies']))
                <div class="bg-zinc-950 border border-zinc-800 rounded-[2.5rem] p-10 relative group overflow-hidden">
                    <div class="absolute top-0 right-0 p-4">
                        <span class="text-[8px] font-mono text-zinc-700 uppercase">SYS-HW // 02</span>
                    </div>
                    <h2 class="text-xl font-black text-white uppercase tracking-tight mb-8 flex items-center gap-3">
                        <flux:icon.cpu-chip class="w-6 h-6 text-emerald-500" />
                        Hardware Spec Stack
                    </h2>
                    <div class="flex flex-wrap gap-3">
                        @foreach($roadmapData['technologies'] as $tech)
                            <span class="px-4 py-2 rounded-xl bg-zinc-900 border border-zinc-800 text-[10px] font-black text-zinc-400 uppercase tracking-widest hover:border-emerald-500/50 hover:text-emerald-400 transition-all">
                                {{ $tech }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    @endif

    <!-- Learning Circuit Timeline -->
    <div class="relative pt-20">
        <!-- Central Data Conduit -->
        <div class="absolute left-10 lg:left-1/2 top-0 bottom-0 w-px bg-zinc-900 hidden md:block">
            <div class="absolute inset-0 bg-gradient-to-b from-violet-500/40 via-violet-500/20 to-transparent"></div>
        </div>
        
        <div class="space-y-32">
            @foreach($steps as $index => $step)
                <div class="relative flex flex-col md:flex-row items-start lg:items-center gap-16 group">
                    <!-- Data Link Marker -->
                    <div class="absolute left-10 lg:left-1/2 -translate-x-1/2 w-16 h-16 rounded-[1.5rem] bg-zinc-950 border-2 border-zinc-800 flex items-center justify-center z-20 shadow-2xl group-hover:border-violet-500 transition-all duration-500 hidden md:flex">
                        <span class="text-xs font-mono font-black text-zinc-600 group-hover:text-violet-500">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>

                    @if($index % 2 === 0)
                        <!-- Module Left -->
                        <div class="md:w-1/2 md:pr-24 w-full md:text-right space-y-4">
                            <h3 class="text-3xl font-black text-white uppercase tracking-tighter group-hover:text-violet-400 transition-colors">
                                {{ $isDatabaseSteps ? $step->title : $step['title'] }}
                            </h3>
                            <p class="text-zinc-500 font-mono text-[10px] uppercase tracking-widest max-w-md md:ml-auto">
                                {{ $isDatabaseSteps ? $step->description : $step['description'] }}
                            </p>
                            <div class="flex items-center gap-2 justify-start md:justify-end">
                                <span class="px-3 py-1 rounded bg-zinc-900 border border-zinc-800 text-[8px] font-black text-zinc-400 uppercase tracking-[0.2em]">
                                    {{ $isDatabaseSteps ? $step->level : 'Mastery Block' }}
                                </span>
                            </div>
                        </div>
                        <div class="md:w-1/2 md:pl-24 w-full">
                            @if($isDatabaseSteps)
                                <a href="{{ route('playlists.show', $step->slug) }}" wire:navigate class="block relative aspect-video rounded-[2.5rem] border border-zinc-800 bg-zinc-900/50 overflow-hidden group/img transition-all duration-500 hover:border-violet-500/50 hover:shadow-[0_0_40px_-12px_rgba(139,92,246,0.2)]">
                                    <img src="{{ $playlist->thumbnail ?? 'https://placehold.co/600x400/09090b/71717a?text=' . urlencode($step->title) }}" class="w-full h-full object-cover opacity-60 group-hover/img:scale-105 transition-transform duration-1000" alt="">
                                    <div class="absolute inset-x-0 bottom-0 p-6 bg-gradient-to-t from-zinc-950 to-transparent">
                                        <flux:icon.play-circle class="w-12 h-12 text-white/20 group-hover/img:text-violet-500 transition-all duration-500" />
                                    </div>
                                    @if($playlist->thumbnail)
                                        <img src="{{ str_starts_with($playlist->thumbnail, 'http') ? $playlist->thumbnail : asset('storage/' . $playlist->thumbnail) }}" class="w-full h-full object-cover opacity-60 group-hover/img:scale-105 transition-transform duration-1000" alt="{{ $playlist->title }}">
                                    @endif
                                </a>
                            @else
                                <div class="relative aspect-video rounded-[2.5rem] border border-zinc-800 bg-zinc-900/40 p-12 flex items-center justify-center group/card overflow-hidden transition-all duration-500 hover:border-zinc-700">
                                    <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808008_1px,transparent_1px),linear-gradient(to_bottom,#80808008_1px,transparent_1px)] bg-[size:16px_16px]"></div>
                                    <flux:icon.academic-cap class="w-16 h-16 text-zinc-800 group-hover:text-violet-500/40 transition-all duration-1000 group-hover:scale-110" />
                                </div>
                            @endif
                        </div>
                    @else
                        <!-- Module Right -->
                        <div class="md:w-1/2 md:pr-24 order-2 md:order-1 w-full">
                            @if($isDatabaseSteps)
                                <a href="{{ route('playlists.show', $step->slug) }}" wire:navigate class="block relative aspect-video rounded-[2.5rem] border border-zinc-800 bg-zinc-900/50 overflow-hidden group/img transition-all duration-500 hover:border-violet-500/50 hover:shadow-[0_0_40px_-12px_rgba(139,92,246,0.2)]">
                                    <img src="{{ urlencode($step->title) }}" class="w-full h-full object-cover opacity-60 group-hover/img:scale-105 transition-transform duration-1000" alt="">
                                    <div class="absolute inset-x-0 bottom-0 p-6 bg-gradient-to-t from-zinc-950 to-transparent">
                                        <flux:icon.play-circle class="w-12 h-12 text-white/20 group-hover/img:text-violet-500 transition-all duration-500" />
                                    </div>
                                </a>
                            @else
                                <div class="relative aspect-video rounded-[2.5rem] border border-zinc-800 bg-zinc-900/40 p-12 flex items-center justify-center group/card overflow-hidden transition-all duration-500 hover:border-zinc-700">
                                    <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808008_1px,transparent_1px),linear-gradient(to_bottom,#80808008_1px,transparent_1px)] bg-[size:16px_16px]"></div>
                                    <flux:icon.academic-cap class="w-16 h-16 text-zinc-800 group-hover:text-violet-500/40 transition-all duration-1000 group-hover:scale-110" />
                                </div>
                            @endif
                        </div>
                        <div class="md:w-1/2 md:pl-24 order-1 md:order-2 w-full space-y-4">
                            <h3 class="text-3xl font-black text-white uppercase tracking-tighter group-hover:text-violet-400 transition-colors">
                                {{ $isDatabaseSteps ? $step->title : $step['title'] }}
                            </h3>
                            <p class="text-zinc-500 font-mono text-[10px] uppercase tracking-widest max-w-md">
                                {{ $isDatabaseSteps ? $step->description : $step['description'] }}
                            </p>
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1 rounded bg-zinc-900 border border-zinc-800 text-[8px] font-black text-zinc-400 uppercase tracking-[0.2em]">
                                    {{ $isDatabaseSteps ? $step->level : 'Mastery Block' }}
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Initialization Protocol: Final CTA -->
    <div class="mt-40 relative overflow-hidden rounded-[3rem] bg-zinc-950 border border-zinc-800 p-16 md:p-32 group text-center">
        <!-- Background Accents -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808008_1px,transparent_1px),linear-gradient(to_bottom,#80808008_1px,transparent_1px)] bg-[size:48px_48px]"></div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-violet-500/5 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-violet-500/5 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="relative z-10 space-y-10">
            <h2 class="text-4xl md:text-7xl font-black text-white uppercase tracking-tighter leading-none">Initialize <span class="text-violet-500">Protocol</span></h2>
            <p class="text-zinc-500 font-mono text-sm max-w-2xl mx-auto leading-relaxed uppercase tracking-wide">
                Hardware check: READY // Connection: STABLE // Syllabus: VERIFIED. Initialize the first deployment block to begin your mastery sequence.
            </p>
            
            <div class="flex flex-col md:flex-row items-center justify-center gap-6">
                @if($path->playlists->isNotEmpty())
                    @auth
                        <flux:button :href="route('playlists.show', $path->playlists->first()->slug)" variant="filled" class="!rounded-2xl !px-16 !py-8 !font-black !text-[12px] !uppercase !tracking-[0.4em] !bg-violet-600 !hover:bg-violet-500 !shadow-[0_0_50px_-12px_rgba(139,92,246,0.5)]">
                            Initialize Step 01
                        </flux:button>
                    @else
                        <flux:button :href="route('register')" variant="filled" class="!rounded-2xl !px-16 !py-8 !font-black !text-[12px] !uppercase !tracking-[0.4em] !bg-zinc-800 !hover:bg-zinc-700">
                             Authenticate Account
                        </flux:button>
                    @endauth
                @else
                    <div class="flex items-center gap-3 px-8 py-4 rounded-2xl bg-zinc-900 border border-zinc-800 text-[10px] font-black text-zinc-600 uppercase tracking-widest">
                        <flux:icon.clock class="w-5 h-5 animate-pulse" />
                        Awaiting Unit Deployment
                    </div>
                @endif
            </div>
        </div>

        <!-- System Markers -->
        <div class="absolute top-8 left-8 text-[8px] font-mono text-zinc-800 uppercase tracking-widest">SYS-CTL // AUTH</div>
        <div class="absolute bottom-8 right-8 text-[8px] font-mono text-zinc-800 uppercase tracking-widest">SECURE-CON // ACTIVE</div>
    </div>
</div>
