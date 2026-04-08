<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\Component;
use App\Models\Playlist;

new #[Layout('layouts.base')] class extends Component
{
    #[Computed]
    public function latestSeries()
    {
        return Playlist::withCount('lessons')
            ->where('is_published', true)
            ->latest()
            ->take(6)
            ->get();
    }

    #[Computed]
    public function topics()
    {
        return Playlist::where('is_published', true)
            ->orderBy('title')
            ->get();
    }

    public function getStarted()
    {
        $this->redirectRoute('register');
    }
};
?>

<div x-data="{ mounted: false, showTopics: false, activeTopic: null }" x-init="setTimeout(() => mounted = true, 50)" class="min-h-screen bg-slate-50 dark:bg-gray-900 text-slate-800 dark:text-gray-300 font-sans selection:bg-violet-500 selection:text-white overflow-x-hidden relative">
    
    <style>
        @keyframes shine {
            0% { background-position: 200% center; }
            100% { background-position: -200% center; }
        }
        
        @keyframes shine {
            0% { background-position: 200% center; }
            100% { background-position: -200% center; }
        }
        .animate-shine {
            background: linear-gradient(
                120deg,
                rgba(255, 255, 255, 1) 30%,
                var(--color-violet) 45%,
                var(--color-plum) 50%,
                rgba(255, 255, 255, 1) 55%
            );
            background-size: 200% auto;
            color: transparent;
            -webkit-background-clip: text;
            background-clip: text;
            animation: shine 5s ease-in-out infinite;
        }
        
        @keyframes scrollGrid {
            0% { transform: translateY(0); }
            100% { transform: translateY(24px); }
        }
        .bg-dot-pattern {
            background-image: radial-gradient(rgba(255, 255, 255, 0.15) 1px, transparent 1px);
            background-size: 24px 24px;
        }
        .mask-radial-faded {
            mask-image: radial-gradient(circle at center, black 10%, transparent 80%);
            -webkit-mask-image: radial-gradient(circle at center, black 10%, transparent 80%);
        }
        .animate-scroll-grid {
            animation: scrollGrid 1.5s linear infinite;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
        .dark .glass-panel {
            background: rgba(31, 41, 55, 0.4);
            border: 1px solid rgba(230, 230, 250, 0.1);
        }
        .perspective-1000 { perspective: 1000px; }
        .transform-style-3d { transform-style: preserve-3d; }

        @keyframes scroll-left {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .animate-scroll-left {
            animation: scroll-left 7s linear infinite;
        }
        .pause-on-hover:hover {
            animation-play-state: paused;
        }
    </style>

    
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none bg-slate-50 dark:bg-gray-950">
        <div class="absolute inset-0 z-0 bg-dot-pattern opacity-5 dark:opacity-[0.03] pointer-events-none"></div>
    </div>

    
    <header 
        x-data="{ lastScrollY: 0, isHidden: false }"
        @scroll.window="isHidden = window.scrollY > lastScrollY && window.scrollY > 80; lastScrollY = window.scrollY"
        :class="(!mounted || isHidden) ? '-translate-y-[150%] opacity-0' : 'translate-y-0 opacity-100'" 
        class="fixed w-full top-0 z-50 transition-all duration-700 ease-in-out">
        <div class="glass-panel mx-4 mt-4 rounded-2xl shadow-[0_8px_32px_rgba(0,0,0,0.3)]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 sm:h-20">
                    <div class="flex items-center gap-8">
                        <a href="/" class="flex items-center gap-3 group relative">
                            <div class="absolute inset-0 bg-violet-500 rounded-lg blur opacity-40 group-hover:opacity-100 transition duration-500"></div>
                            <div class="relative w-10 h-10 bg-gradient-to-br from-violet-500 to-plum-600 rounded-lg flex items-center justify-center transform group-hover:rotate-12 transition-all duration-300 shadow-xl border border-white/20 z-10">
                                <svg class="w-6 h-6 text-white drop-shadow-md" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <span class="text-2xl tracking-tight text-zinc-900 dark:text-white font-black z-10 drop-shadow-sm">F</span>
                        </a>
                        
                        <nav class="hidden md:flex gap-8">
                            <button @click="showTopics = true" class="text-sm font-semibold text-slate-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-white hover:-translate-y-0.5 transition-all duration-300 relative group cursor-pointer">
                                Topics
                                <span class="absolute inset-x-0 -bottom-1 h-0.5 bg-gradient-to-r from-violet-500 to-violet-500 scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></span>
                            </button>
                            <a href="#latest" class="text-sm font-semibold text-slate-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-white hover:-translate-y-0.5 transition-all duration-300 relative group">
                                Playlists
                                <span class="absolute inset-x-0 -bottom-1 h-0.5 bg-gradient-to-r from-violet-500 to-violet-500 scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></span>
                            </a>
                            <a href="{{ route('paths.index') }}" wire:navigate class="text-sm font-semibold text-slate-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-white hover:-translate-y-0.5 transition-all duration-300 relative group">
                                Paths
                                <span class="absolute inset-x-0 -bottom-1 h-0.5 bg-gradient-to-r from-violet-500 to-violet-500 scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></span>
                            </a>
                        </nav>
                    </div>
                    
                    <div class="flex items-center gap-6">
                        <a href="/login" class="text-sm font-bold text-slate-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-white transition-colors dark:hover:shadow-[0_0_15px_rgba(255,255,255,0.3)] px-3 py-1.5 rounded-lg">Sign In</a>
                        <button wire:click="getStarted" class="relative group overflow-hidden rounded-full p-[1px]">
                            <span class="absolute inset-0 bg-gradient-to-r from-lavender via-violet to-plum opacity-70 group-hover:opacity-100 group-hover:rotate-180 transition-all duration-700 ease-linear rounded-full"></span>
                            <div class="relative flex items-center gap-2 bg-white dark:bg-gray-950 px-6 py-2.5 rounded-full transition-all duration-300 group-hover:bg-opacity-0">
                                <span class="text-sm font-bold text-zinc-800 dark:text-white group-hover:text-white group-hover:drop-shadow-[0_0_8px_rgba(255,255,255,0.8)] transition-all">Get Started</span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    
    <main class="relative z-10 pt-48 pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center text-center">
            
           
            <div :class="mounted ? 'scale-100 opacity-100' : 'scale-50 opacity-0'" class="transition-all duration-1000 delay-300 ease-out mb-10">
                <div class="relative group cursor-pointer inline-flex">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-plum-600 rounded-full blur opacity-40 group-hover:opacity-80 transition duration-500"></div>
                    <div class="relative inline-flex items-center gap-3 px-5 py-2 rounded-full glass-panel text-sm text-zinc-900 dark:text-white font-medium border border-zinc-200 dark:border-white/10 group-hover:border-zinc-300 dark:group-hover:border-white/30 transition-all">
                        <span class="flex h-2.5 w-2.5 rounded-full bg-violet-500 shadow-[0_0_10px_rgba(238,130,238,0.8)] animate-pulse"></span>
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-violet-600 to-plum-800 dark:from-violet-200 dark:to-white font-semibold">New</span>
                        <span class="w-px h-4 bg-zinc-300 dark:bg-white/20"></span>
                        <span class="text-slate-600 dark:text-gray-300 group-hover:text-zinc-900 dark:group-hover:text-white transition-colors">Watch the latest playlists today</span>
                        <svg class="w-4 h-4 text-slate-500 dark:text-gray-400 group-hover:translate-x-1 group-hover:text-blue-600 dark:group-hover:text-white transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </div>
            
           
            <h1 :class="mounted ? 'translate-y-0 opacity-100' : 'translate-y-12 opacity-0'" class="text-5xl md:text-7xl lg:text-8xl font-black tracking-tight leading-[1.1] mb-8 max-w-5xl transition-all duration-1000 delay-500 ease-out drop-shadow-2xl text-zinc-900 dark:text-white pb-2">
                The best way to learn <span class="text-violet-600 dark:text-violet-400">Coding</span><br class="hidden md:block" /> and modern tech.
            </h1>
            
            <p :class="mounted ? 'translate-y-0 opacity-100' : 'translate-y-8 opacity-0'" class="text-lg md:text-2xl text-slate-600 dark:text-gray-400 max-w-2xl mb-14 font-medium transition-all duration-1000 delay-700 ease-out leading-relaxed">
                The most entertaining, comprehensive, and cinematic training for modern web artisans.
            </p>
            
           
            <div :class="mounted ? 'translate-y-0 opacity-100' : 'translate-y-8 opacity-0'" class="flex flex-col sm:flex-row gap-6 items-center justify-center transition-all duration-1000 delay-1000 ease-out w-full sm:w-auto">
                <button wire:click="getStarted" class="relative w-full sm:w-auto group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-violet-600 to-plum-600 rounded-2xl blur-lg opacity-70 group-hover:opacity-100 group-hover:scale-105 transition-all duration-500"></div>
                    <div class="relative px-8 py-4 bg-gradient-to-br from-violet-500 to-plum-600 text-white font-bold rounded-2xl flex items-center justify-center gap-3 transform group-hover:-translate-y-1 transition-all overflow-hidden border border-white/20">
                        <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-out"></div>
                        <span class="relative text-lg z-10">Start Your Journey</span>
                        <svg class="w-6 h-6 relative z-10 group-hover:animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </button>
                
                <a href="#latest" class="relative px-8 py-4 w-full sm:w-auto rounded-2xl font-bold text-zinc-900 dark:text-white glass-panel hover:bg-black/5 dark:hover:bg-white/10 transform hover:-translate-y-1 transition-all flex items-center justify-center gap-2 group border border-zinc-200 dark:border-white/10 hover:border-zinc-300 dark:hover:border-white/30 dark:hover:shadow-[0_0_30px_rgba(255,255,255,0.1)]">
                    Explore the Library
                    <svg class="w-5 h-5 text-slate-500 dark:text-gray-300 group-hover:rotate-45 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </a>
            </div>
        </div>

        
        <section id="latest" class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-48 perspective-1000 z-20 pt-10">
            
            <div class="absolute top-0 inset-x-0 flex items-center justify-center opacity-50">
                <div class="h-px bg-gradient-to-r from-transparent via-white to-transparent w-full max-w-3xl"></div>
                <div class="absolute bg-white text-slate-900 rounded-full p-2 shadow-[0_0_20px_rgba(0,0,0,0.1)] dark:shadow-[0_0_20px_rgba(255,255,255,0.8)]">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>

            <div class="flex flex-col md:flex-row items-end justify-between mb-16 mt-8" x-data="{ intersecting: false }" x-intersect="intersecting = true">
                <div :class="intersecting ? 'translate-x-0 opacity-100' : '-translate-x-12 opacity-0'" class="transition-all duration-1000 ease-out">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full glass-panel border border-black/10 dark:border-white/10 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-widest mb-4">
                        <span class="w-2 h-2 rounded-full bg-violet-500 animate-pulse"></span>
                        Fresh Content
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-zinc-900 dark:text-white tracking-tight mb-2">Latest Playlists</h2>
                    <p class="text-xl text-slate-600 dark:text-gray-400 font-medium">Binge-watch our newest tech releases.</p>
                </div>
            </div>

            <div class="relative overflow-hidden -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8">
                <div class="flex animate-scroll-left pause-on-hover w-max">
                    @php
                        $colors = ['from-violet-600 to-plum-600', 'from-plum-600 to-lavender', 'from-violet-500 to-plum-500', 'from-violet-500 to-lavender'];
                        $icons = [
                            'M13 10V3L4 14h7v7l9-11h-7z',
                            'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z',
                            'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01',
                            'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'
                        ];
                    @endphp
                    
                    {{-- First Set --}}
                    <div class="flex gap-8 pr-8">
                        @foreach($this->latestSeries as $index => $series)
                        <a href="{{ route('playlists.show', $series->slug) }}" wire:navigate class="relative transform-style-3d cursor-pointer w-[320px] h-[400px] shrink-0 block">
                            <div class="absolute -inset-0.5 bg-gradient-to-br {{ $colors[$index % 4] }} rounded-[2rem] blur-xl opacity-0 hover:opacity-40 transition-opacity duration-700 ease-out"></div>
                            
                            <div class="absolute inset-0 glass-panel border border-white/10 rounded-[2rem] overflow-hidden flex flex-col transition-all duration-500 ease-out shadow-2xl hover:-translate-y-2">
                                <div class="relative h-48 w-full overflow-hidden shrink-0">
                                    <div class="absolute inset-0 bg-gradient-to-br {{ $colors[$index % 4] }} opacity-80 z-10 mix-blend-multiply transition-all duration-700"></div>
                                    <div class="absolute inset-0 z-0 opacity-30 transition-all duration-1000" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 20px 20px;"></div>
                                    <div class="absolute inset-0 flex items-center justify-center z-20">
                                        <div class="w-20 h-20 glass-panel rounded-2xl flex items-center justify-center border border-white/20 shadow-2xl transition-all duration-500">
                                            <svg class="w-10 h-10 text-white drop-shadow-md" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $icons[$index % 4] }}" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-6 flex flex-col grow bg-white/80 dark:bg-gray-900/80 backdrop-blur-md relative z-30">
                                    <div class="absolute -top-4 right-6 bg-white dark:bg-gray-900 px-3 py-1 rounded-lg border border-slate-200 dark:border-gray-700 shadow-xl flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-xs font-bold text-slate-700 dark:text-gray-300">{{ $series->lessons_count }} Videos</span>
                                    </div>

                                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-3 leading-tight">{{ $series->title }}</h3>
                                    <p class="text-sm text-slate-600 dark:text-gray-400 line-clamp-3 mb-auto leading-relaxed">{{ $series->description }}</p>
                                    
                                    <div class="mt-6 flex items-center text-sm font-bold text-slate-500">
                                        <span class="group-hover:mr-2 transition-all">Start Playlist</span>
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>

                    {{-- Second Set (Identical for seamless looping) --}}
                    <div class="flex gap-8 pr-8">
                        @foreach($this->latestSeries as $index => $series)
                        <a href="{{ route('playlists.show', $series->slug) }}" wire:navigate class="relative transform-style-3d cursor-pointer w-[320px] h-[400px] shrink-0 block">
                            <div class="absolute -inset-0.5 bg-gradient-to-br {{ $colors[$index % 4] }} rounded-[2rem] blur-xl opacity-0 hover:opacity-40 transition-opacity duration-700 ease-out"></div>
                            
                            <div class="absolute inset-0 glass-panel border border-white/10 rounded-[2rem] overflow-hidden flex flex-col transition-all duration-500 ease-out shadow-2xl hover:-translate-y-2">
                                <div class="relative h-48 w-full overflow-hidden shrink-0">
                                    <div class="absolute inset-0 bg-gradient-to-br {{ $colors[$index % 4] }} opacity-80 z-10 mix-blend-multiply transition-all duration-700"></div>
                                    <div class="absolute inset-0 z-0 opacity-30 transition-all duration-1000" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 20px 20px;"></div>
                                    <div class="absolute inset-0 flex items-center justify-center z-20">
                                        <div class="w-20 h-20 glass-panel rounded-2xl flex items-center justify-center border border-white/20 shadow-2xl transition-all duration-500">
                                            <svg class="w-10 h-10 text-white drop-shadow-md" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $icons[$index % 4] }}" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-6 flex flex-col grow bg-white/80 dark:bg-[#0A101D]/80 backdrop-blur-md relative z-30">
                                    <div class="absolute -top-4 right-6 bg-white dark:bg-gray-900 px-3 py-1 rounded-lg border border-slate-200 dark:border-gray-700 shadow-xl flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-xs font-bold text-slate-700 dark:text-gray-300">{{ $series->lessons_count }} Videos</span>
                                    </div>

                                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-3 leading-tight">{{ $series->title }}</h3>
                                    <p class="text-sm text-slate-600 dark:text-gray-400 line-clamp-3 mb-auto leading-relaxed">{{ $series->description }}</p>
                                    
                                    <div class="mt-6 flex items-center text-sm font-bold text-slate-500">
                                        <span class="group-hover:mr-2 transition-all">Start Playlist</span>
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        {{-- Topics Modal --}}
        <flux:modal x-model="showTopics" variant="flyout" class="max-w-4xl">
            <div class="space-y-6">
                <div>
                    <flux:heading size="xl">Explore Topics</flux:heading>
                    <flux:text>Choose a playlist to learn more about the topic.</flux:text>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                    <div class="space-y-2 max-h-[60vh] overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($this->topics as $topic)
                            <button 
                                @click="activeTopic = {{ json_encode($topic) }}"
                                :class="activeTopic?.id === {{ $topic->id }} ? 'bg-violet-50 dark:bg-violet-900/30 border-violet-200 dark:border-violet-700' : 'hover:bg-slate-50 dark:hover:bg-white/5 border-transparent'"
                                class="w-full text-left p-4 rounded-xl border transition-all duration-200 group flex items-center justify-between"
                            >
                                <span class="font-bold text-slate-800 dark:text-gray-200 group-hover:text-violet-600 dark:group-hover:text-violet-400" :class="activeTopic?.id === {{ $topic->id }} && 'text-violet-600 dark:text-violet-400'">
                                    {{ $topic->title }}
                                </span>
                                <flux:icon icon="chevron-right" variant="micro" class="text-slate-400 group-hover:text-violet-500" />
                            </button>
                        @endforeach
                    </div>

                    <div class="sticky top-0">
                        <div x-show="!activeTopic" class="glass-panel rounded-3xl p-8 min-h-[400px] flex flex-col items-center justify-center text-center border-dashed border-2 border-slate-200 dark:border-white/10">
                            <div class="w-16 h-16 bg-slate-100 dark:bg-white/5 rounded-full flex items-center justify-center mb-6">
                                <flux:icon icon="book-open" class="w-8 h-8 text-slate-400" />
                            </div>
                            <flux:heading>Select a Topic</flux:heading>
                            <flux:text>The introduction and overview will appear here.</flux:text>
                        </div>

                        <div x-show="activeTopic" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                            <div class="relative group">
                                <div class="absolute -inset-1 bg-gradient-to-r from-violet-600 to-plum-600 rounded-[2rem] blur opacity-25"></div>
                                <div class="relative p-8 bg-white dark:bg-gray-900 border border-slate-200 dark:border-white/10 rounded-[2rem] shadow-xl">
                                    <h3 class="text-2xl font-black text-zinc-900 dark:text-white mb-4 leading-tight" x-text="activeTopic?.title"></h3>
                                    
                                    <div class="flex items-center gap-2 mb-6">
                                        <div class="h-1 w-8 bg-violet-500 rounded-full"></div>
                                        <span class="text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-widest">Introduction</span>
                                    </div>

                                    <div class="relative">
                                        <flux:icon icon="chat-bubble-bottom-center-text" variant="micro" class="absolute -left-1 -top-1 w-12 h-12 text-violet-500/10" />
                                        <p class="text-slate-600 dark:text-gray-400 leading-relaxed font-medium text-lg relative z-10" x-text="activeTopic?.description"></p>
                                    </div>

                                    <div class="mt-8 pt-8 border-t border-slate-100 dark:border-white/5 flex items-center justify-between">
                                        <div class="flex -space-x-2">
                                            <div class="w-8 h-8 rounded-full border-2 border-white dark:border-gray-900 bg-slate-200"></div>
                                            <div class="w-8 h-8 rounded-full border-2 border-white dark:border-gray-900 bg-slate-300"></div>
                                            <div class="w-8 h-8 rounded-full border-2 border-white dark:border-gray-900 bg-slate-400 flex items-center justify-center text-[10px] font-bold text-white">+12</div>
                                        </div>
                                        <span class="text-xs font-bold text-slate-400 uppercase">Interactive Masterclass</span>
                                    </div>
                                </div>
                            </div>
                            
                            <a :href="'/playlists/' + activeTopic?.slug" class="relative group block w-full">
                                <div class="absolute -inset-0.5 bg-gradient-to-r from-violet-600 to-plum-600 rounded-2xl blur opacity-40 group-hover:opacity-100 transition duration-500"></div>
                                <div class="relative flex items-center justify-center gap-3 py-4 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 font-bold rounded-2xl hover:scale-[1.01] transition-all">
                                    <span>Start Learning Now</span>
                                    <flux:icon icon="arrow-right" variant="micro" class="w-4 h-4" />
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </flux:modal>
    </main>

    
    <footer class="mt-32 border-t border-zinc-200 dark:border-white/5 bg-slate-50 dark:bg-gray-950 py-16 relative overflow-hidden z-20">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-blue-900/10 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="flex flex-col items-center justify-center text-center">
                <div class="w-12 h-12 bg-gradient-to-br from-violet-500 to-plum-600 rounded-xl flex items-center justify-center mb-8 shadow-[0_0_30px_rgba(59,130,246,0.3)]">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6">F</h3>
                <div class="flex gap-8 mb-10">
                    <a href="https://github.com/Mana007777" class="text-slate-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-white hover:scale-110 transition-transform">GitHub</a>
                </div>
                <p class="text-slate-500 dark:text-gray-600 text-sm font-medium">© <?= date('Y') ?> Eat , Sleep , Code , Repeat.</p>
            </div>
        </div>  
    </footer>
</div>