<?php

use App\Models\Path;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app.sidebar')] class extends Component {
    public Path $path;

    public function mount(Path $path)
    {
        $this->path = $path->load('playlists.lessons');
    }

    public function rendering($view)
    {
        $view->title($this->path->title . ' Path');
    }
};
?>

<div class="px-6 py-8 md:px-10 max-w-7xl mx-auto w-full">
    <!-- Breadcrumbs -->
    <div class="mb-8">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('home') }}" icon="home" />
            <flux:breadcrumbs.item href="{{ route('paths.index') }}">Paths</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ $path->title }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <!-- Header Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-center mb-20 animate-fade-in">
        <div class="lg:col-span-2">
             <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-violet-100 dark:bg-violet-900/40 border border-violet-200 dark:border-violet-500/30 text-[10px] font-black text-violet-700 dark:text-violet-300 uppercase tracking-[0.2em] mb-6">
                <flux:icon.academic-cap class="w-3.5 h-3.5" />
                The path to mastery
            </div>
            <h1 class="text-5xl md:text-7xl font-black text-slate-900 dark:text-white tracking-tighter leading-none mb-6">
                {{ $path->title }}
            </h1>
            <p class="text-slate-500 dark:text-gray-400 text-xl font-medium max-w-2xl leading-relaxed">
                {{ $path->description }}
            </p>

            @php
                $roadmapData = is_array($path->roadmap) ? $path->roadmap : [];
                $hasRoadmapSteps = !empty($roadmapData['steps']);
                
                // Prioritize Roadmap JSON steps, then fallback to database playlists
                $steps = $hasRoadmapSteps ? collect($roadmapData['steps']) : $path->playlists;
                $isDatabaseSteps = !$hasRoadmapSteps && $path->playlists->isNotEmpty();
                
                $totalSteps = $steps->count();
                $totalLessons = $path->playlists->sum(fn($p) => $p->lessons->count());
            @endphp

            <div class="mt-10 flex flex-wrap gap-4">
                <div class="flex items-center gap-3 glass-panel rounded-2xl px-5 py-3 border border-slate-200 dark:border-white/10">
                    <span class="text-2xl font-black text-violet-600 dark:text-violet-400">
                        {{ $totalSteps }}
                    </span>
                    <span class="text-xs font-black text-slate-400 uppercase tracking-widest leading-tight">Curated<br>Steps</span>
                </div>
                <div class="flex items-center gap-3 glass-panel rounded-2xl px-5 py-3 border border-slate-200 dark:border-white/10">
                    <span class="text-2xl font-black text-violet-600 dark:text-violet-400">{{ $totalLessons > 0 ? $totalLessons : $totalSteps }}</span>
                    <span class="text-xs font-black text-slate-400 uppercase tracking-widest leading-tight">
                        {{ $path->playlists->isNotEmpty() ? 'Lessons To' : 'Milestones' }}<br>Complete
                    </span>
                </div>
            </div>
        </div>

        <div class="relative group">
            <div class="absolute -inset-4 bg-gradient-to-tr from-violet-600 to-plum-600 rounded-[3rem] blur-2xl opacity-20 group-hover:opacity-40 transition-opacity duration-700"></div>
            <div class="relative aspect-square rounded-[3rem] bg-gradient-to-br from-violet-500 to-plum-600 flex items-center justify-center p-12 shadow-2xl overflow-hidden border border-white/20">
                <flux:icon.map class="w-32 h-32 text-white/20 absolute -top-4 -right-4 rotate-12" />
                <flux:icon.command-line class="w-32 h-32 text-white drop-shadow-2xl z-10" />
                <div class="absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-black/20 to-transparent"></div>
            </div>
        </div>
    </div>

    <!-- Path Details (Objectives & Tech) -->
    @if(isset($roadmapData['objectives']) || isset($roadmapData['technologies']))
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-32 animate-fade-in-up">
            <!-- Objectives -->
            @if(isset($roadmapData['objectives']))
            <div class="glass-panel p-8 rounded-[2.5rem] border border-slate-200 dark:border-white/10 shadow-lg relative overflow-hidden group">
                <div class="absolute -top-12 -right-12 w-32 h-32 bg-violet-500/10 rounded-full blur-2xl group-hover:bg-violet-500/20 transition-colors"></div>
                <flux:heading level="2" class="mb-8 flex items-center gap-3 !text-violet-600 dark:!text-violet-400 font-extrabold tracking-tight text-2xl">
                    <flux:icon.check-badge class="w-7 h-7" variant="mini" />
                    Learning Objectives
                </flux:heading>
                <ul class="space-y-5">
                    @foreach($roadmapData['objectives'] as $objective)
                        <li class="flex gap-4 text-slate-600 dark:text-gray-400 font-semibold leading-relaxed">
                            <flux:icon.check class="w-5 h-5 text-violet-500 shrink-0 mt-0.5" />
                            {{ $objective }}
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Technologies -->
            @if(isset($roadmapData['technologies']))
            <div class="glass-panel p-8 rounded-[2.5rem] border border-slate-200 dark:border-white/10 shadow-lg relative overflow-hidden group">
                <div class="absolute -top-12 -right-12 w-32 h-32 bg-plum-500/10 rounded-full blur-2xl group-hover:bg-plum-500/20 transition-colors"></div>
                <flux:heading level="2" class="mb-8 flex items-center gap-3 !text-plum-600 dark:!text-plum-400 font-extrabold tracking-tight text-2xl">
                    <flux:icon.command-line class="w-7 h-7" variant="mini" />
                    Core Stack
                </flux:heading>
                <div class="flex flex-wrap gap-3">
                    @foreach($roadmapData['technologies'] as $tech)
                        <span class="px-5 py-3 rounded-2xl bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 text-sm font-bold text-slate-700 dark:text-gray-200 shadow-sm hover:border-plum-500/50 transition-colors">
                            {{ $tech }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    @endif

    <!-- The Roadmap Timeline -->
    <div class="relative">
        <div class="absolute left-8 lg:left-1/2 top-0 bottom-0 w-1 bg-gradient-to-b from-violet-500/50 via-plum-500/50 to-transparent rounded-full hidden md:block"></div>
        
        <div class="space-y-24">

            @foreach($steps as $index => $step)
                <div class="relative flex flex-col md:flex-row items-center gap-12 group">
                    <!-- Marker -->
                    <div class="absolute left-8 lg:left-1/2 -translate-x-1/2 w-16 h-16 rounded-[1.5rem] bg-white dark:bg-gray-900 border-4 border-violet-500 dark:border-violet-400 flex items-center justify-center text-2xl font-black text-violet-600 dark:text-violet-400 z-20 shadow-2xl group-hover:scale-110 transition-transform hidden md:flex">
                        {{ $index + 1 }}
                    </div>

                    @if($index % 2 === 0)
                        <!-- Card Left -->
                        <div class="md:w-1/2 text-start md:text-end md:pr-24 w-full">
                            <h3 class="text-3xl font-black text-slate-900 dark:text-white mb-4 group-hover:text-violet-500 transition-colors">
                                {{ $isDatabaseSteps ? $step->title : $step['title'] }}
                            </h3>
                            <p class="text-slate-500 dark:text-gray-400 text-lg mb-6 line-clamp-2 md:ml-auto md:max-w-md">
                                {{ $isDatabaseSteps ? $step->description : $step['description'] }}
                            </p>
                            <span class="px-4 py-2 rounded-lg bg-slate-100 dark:bg-white/5 text-[10px] font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest border border-slate-200 dark:border-white/10">
                                {{ $isDatabaseSteps ? $step->level : 'Professional Milestone' }}
                            </span>
                        </div>
                        <div class="md:w-1/2 md:pl-24 w-full">
                            @if($isDatabaseSteps)
                                 <a href="{{ route('playlists.show', $step->slug) }}" wire:navigate class="block relative group/img overflow-hidden rounded-[2.5rem] border border-slate-200 dark:border-white/10 shadow-xl aspect-video hover:-translate-y-2 transition-transform duration-500">
                                    <div class="absolute inset-0 bg-gradient-to-br from-violet-500 to-plum-600 opacity-60 mix-blend-multiply transition-opacity group-hover/img:opacity-40"></div>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <flux:icon.play-circle class="w-16 h-16 text-white/50 group-hover/img:scale-110 transition-transform" />
                                    </div>
                                    <img src="{{ $step->thumbnail ?? 'https://placehold.co/600x400/1e1b4b/white?text=' . urlencode($step->title) }}" class="w-full h-full object-cover" alt="">
                                </a>
                            @else
                                <div class="relative overflow-hidden rounded-[2.5rem] border border-slate-200 dark:border-white/10 shadow-xl aspect-video glass-panel flex items-center justify-center group/card">
                                    <div class="absolute inset-0 bg-gradient-to-br from-violet-500/10 to-plum-500/10 opacity-0 group-hover/card:opacity-100 transition-opacity"></div>
                                    <flux:icon.academic-cap class="w-16 h-16 text-slate-200 dark:text-white/10 group-hover/card:scale-110 transition-transform duration-700" />
                                    <div class="absolute inset-x-0 bottom-0 p-6 bg-gradient-to-t from-black/20 to-transparent">
                                        <span class="text-[10px] font-black text-white uppercase tracking-[0.2em]">Guided Instruction</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <!-- Card Right -->
                        <div class="md:w-1/2 md:pr-24 order-2 md:order-1 w-full">
                            @if($isDatabaseSteps)
                                <a href="{{ route('playlists.show', $step->slug) }}" wire:navigate class="block relative group/img overflow-hidden rounded-[2.5rem] border border-slate-200 dark:border-white/10 shadow-xl aspect-video hover:-translate-y-2 transition-transform duration-500">
                                    <div class="absolute inset-0 bg-gradient-to-br from-plum-500 to-violet-600 opacity-60 mix-blend-multiply transition-opacity group-hover/img:opacity-40"></div>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <flux:icon.play-circle class="w-16 h-16 text-white/50 group-hover/img:scale-110 transition-transform" />
                                    </div>
                                    <img src="{{ $step->thumbnail ?? 'https://placehold.co/600x400/312e81/white?text=' . urlencode($step->title) }}" class="w-full h-full object-cover" alt="">
                                </a>
                            @else
                                <div class="relative overflow-hidden rounded-[2.5rem] border border-slate-200 dark:border-white/10 shadow-xl aspect-video glass-panel flex items-center justify-center group/card text-right">
                                    <div class="absolute inset-0 bg-gradient-to-br from-plum-500/10 to-violet-500/10 opacity-0 group-hover/card:opacity-100 transition-opacity"></div>
                                    <flux:icon.academic-cap class="w-16 h-16 text-slate-200 dark:text-white/10 group-hover/card:scale-110 transition-transform duration-700" />
                                    <div class="absolute inset-x-0 bottom-0 p-6 bg-gradient-to-t from-black/20 to-transparent">
                                        <span class="text-[10px] font-black text-white uppercase tracking-[0.2em]">Guided Instruction</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="md:w-1/2 md:pl-24 order-1 md:order-2 w-full">
                            <h3 class="text-3xl font-black text-slate-900 dark:text-white mb-4 group-hover:text-violet-500 transition-colors">
                                {{ $isDatabaseSteps ? $step->title : $step['title'] }}
                            </h3>
                            <p class="text-slate-500 dark:text-gray-400 text-lg mb-6 line-clamp-2 md:max-w-md">
                                {{ $isDatabaseSteps ? $step->description : $step['description'] }}
                            </p>
                            <span class="px-4 py-2 rounded-lg bg-slate-100 dark:bg-white/5 text-[10px] font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest border border-slate-200 dark:border-white/10">
                                {{ $isDatabaseSteps ? $step->level : 'Professional Milestone' }}
                            </span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Related Playlists (only show as secondary resources if roadmap steps were primary) -->
    @if($hasRoadmapSteps && $path->playlists->isNotEmpty())
        <div class="mt-40">
            <div class="flex items-center gap-4 mb-12">
                <div class="h-10 w-2 bg-violet-600 rounded-full"></div>
                <flux:heading level="2" class="font-black !text-slate-900 dark:!text-white text-4xl tracking-tight">
                    Premium Academy Playlists
                </h4>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($path->playlists as $playlist)
                    <a href="{{ route('playlists.show', $playlist->slug) }}" wire:navigate class="glass-panel p-6 rounded-[2.5rem] border border-slate-200 dark:border-white/10 hover:-translate-y-2 transition-transform duration-500 group relative overflow-hidden">
                        <div class="absolute -top-12 -right-12 w-24 h-24 bg-violet-500/5 rounded-full blur-2xl group-hover:bg-violet-500/10 transition-colors"></div>
                        
                        <div class="aspect-video rounded-[1.5rem] overflow-hidden mb-6 relative shadow-lg">
                            <img src="{{ $playlist->thumbnail ?? 'https://placehold.co/600x400/1e1b4b/white?text=' . urlencode($playlist->title) }}" class="w-full h-full object-cover">
                            <div class="absolute inset-x-0 bottom-0 p-4 bg-gradient-to-t from-black/60 to-transparent">
                                <span class="px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-[9px] font-black text-white uppercase tracking-widest border border-white/20">
                                    {{ $playlist->lessons->count() }} Lessons
                                </span>
                            </div>
                            <div class="absolute inset-0 bg-violet-600/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <flux:icon.play class="w-12 h-12 text-white drop-shadow-2xl" variant="mini" />
                            </div>
                        </div>

                        <h4 class="text-2xl font-black text-slate-900 dark:text-white mb-3 group-hover:text-violet-500 transition-colors tracking-tight">{{ $playlist->title }}</h4>
                        <p class="text-slate-500 dark:text-gray-400 text-sm font-medium line-clamp-2 leading-relaxed mb-6">{{ $playlist->description }}</p>
                        
                        <div class="flex items-center justify-between mt-auto pt-6 border-t border-slate-100 dark:border-white/5">
                             <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $playlist->level }}</span>
                             <flux:icon.arrow-right class="w-5 h-5 text-slate-300 group-hover:text-violet-500 group-hover:translate-x-1 transition-all" />
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Final Call to Action -->
    <div class="mt-32 text-center bg-violet-600 dark:bg-violet-500 rounded-[3rem] p-12 lg:p-20 relative overflow-hidden shadow-2xl">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-plum-500/20 rounded-full blur-3xl"></div>
        
        <h2 class="text-4xl md:text-6xl font-black text-white relative z-10 mb-8 tracking-tight">Ready to begin your journey?</h2>
        <p class="text-violet-100 text-xl mb-12 relative z-10 max-w-2xl mx-auto font-medium">Start the first playlist of this path and track your progress all the way to mastery.</p>
        
        @if($path->playlists->isNotEmpty())
            @auth
               <flux:button :href="route('playlists.show', $path->playlists->first()->slug)" variant="primary" class="rounded-2xl px-12 py-5 text-xl font-black hover:scale-105 transition-transform shadow-xl !bg-white !text-violet-600 border-none">
                    Start Step 1
                </flux:button>
            @else
                <flux:button :href="route('register')" variant="primary" class="rounded-2xl px-12 py-5 text-xl font-black hover:scale-105 transition-transform shadow-xl !bg-white !text-violet-600 border-none">
                    Create Account To Track Progress
                </flux:button>
            @endauth
        @else
            <div class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-white/10 text-white font-black uppercase tracking-widest border border-white/20">
                <flux:icon.clock class="w-5 h-5" />
                Playlists coming soon
            </div>
        @endif
    </div>
</div>
