<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\Component;
use App\Models\Course;

new #[Layout('layouts.base')] class extends Component
{
    #[Computed]
    public function latestSeries()
    {
        return Course::withCount('lessons')
            ->where('is_published', true)
            ->latest()
            ->take(4)
            ->get();
    }

    public function getStarted()
    {
        $this->redirectRoute('register');
    }
};
?>

<div x-data="{ mounted: false }" x-init="setTimeout(() => mounted = true, 50)" class="min-h-screen bg-[#050B14] text-slate-300 font-sans selection:bg-blue-500 selection:text-white overflow-x-hidden relative">
    
    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(40px, -60px) scale(1.2); }
            66% { transform: translate(-30px, 40px) scale(0.8); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 10s infinite alternate;
        }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
        .animation-delay-6000 { animation-delay: 6s; }
        
        @keyframes shine {
            0% { background-position: 200% center; }
            100% { background-position: -200% center; }
        }
        .animate-shine {
            background: linear-gradient(
                120deg,
                rgba(255, 255, 255, 1) 30%,
                rgba(96, 165, 250, 1) 45%,
                rgba(168, 85, 247, 1) 50%,
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
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .perspective-1000 { perspective: 1000px; }
        .transform-style-3d { transform-style: preserve-3d; }
    </style>

    
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none bg-[#020617]">
       
        <div class="absolute inset-[-10%] z-0 bg-dot-pattern mask-radial-faded opacity-50 animate-scroll-grid pointer-events-none"></div>

        <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-blue-600/20 rounded-full mix-blend-screen filter blur-[100px] opacity-70 animate-blob"></div>
        <div class="absolute top-1/4 right-1/4 w-[600px] h-[600px] bg-indigo-600/20 rounded-full mix-blend-screen filter blur-[120px] opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-[-10%] left-1/3 w-[700px] h-[700px] bg-purple-600/20 rounded-full mix-blend-screen filter blur-[150px] opacity-60 animate-blob animation-delay-4000"></div>
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-overlay"></div>
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
                            <div class="absolute inset-0 bg-blue-500 rounded-lg blur opacity-40 group-hover:opacity-100 transition duration-500"></div>
                            <div class="relative w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center transform group-hover:rotate-12 transition-all duration-300 shadow-xl border border-white/20 z-10">
                                <svg class="w-6 h-6 text-white drop-shadow-md" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <span class="text-2xl tracking-tight text-white font-black z-10 drop-shadow-sm">Lara<span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">Casts</span></span>
                        </a>
                        
                        <nav class="hidden md:flex gap-8">
                            <a href="#" class="text-sm font-semibold text-slate-300 hover:text-white hover:-translate-y-0.5 transition-all duration-300 relative group">
                                Topics
                                <span class="absolute inset-x-0 -bottom-1 h-0.5 bg-gradient-to-r from-blue-500 to-indigo-500 scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></span>
                            </a>
                            <a href="#" class="text-sm font-semibold text-slate-300 hover:text-white hover:-translate-y-0.5 transition-all duration-300 relative group">
                                Series
                                <span class="absolute inset-x-0 -bottom-1 h-0.5 bg-gradient-to-r from-blue-500 to-indigo-500 scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></span>
                            </a>
                            <a href="#" class="text-sm font-semibold text-slate-300 hover:text-white hover:-translate-y-0.5 transition-all duration-300 relative group">
                                Paths
                                <span class="absolute inset-x-0 -bottom-1 h-0.5 bg-gradient-to-r from-blue-500 to-indigo-500 scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></span>
                            </a>
                        </nav>
                    </div>
                    
                    <div class="flex items-center gap-6">
                        <a href="/login" class="text-sm font-bold text-slate-300 hover:text-white transition-colors hover:shadow-[0_0_15px_rgba(255,255,255,0.3)] px-3 py-1.5 rounded-lg">Sign In</a>
                        <button wire:click="getStarted" class="relative group overflow-hidden rounded-full p-[1px]">
                            <span class="absolute inset-0 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 opacity-70 group-hover:opacity-100 group-hover:rotate-180 transition-all duration-700 ease-linear rounded-full"></span>
                            <div class="relative flex items-center gap-2 bg-[#0A101D] px-6 py-2.5 rounded-full transition-all duration-300 group-hover:bg-opacity-0">
                                <span class="text-sm font-bold text-white group-hover:drop-shadow-[0_0_8px_rgba(255,255,255,0.8)] transition-all">Get Started</span>
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
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full blur opacity-40 group-hover:opacity-80 transition duration-500"></div>
                    <div class="relative inline-flex items-center gap-3 px-5 py-2 rounded-full glass-panel text-sm text-white font-medium border border-white/10 group-hover:border-white/30 transition-all">
                        <span class="flex h-2.5 w-2.5 rounded-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.8)] animate-pulse"></span>
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-200 to-white font-semibold">New</span>
                        <span class="w-px h-4 bg-white/20"></span>
                        <span class="text-slate-300 group-hover:text-white transition-colors">Master Livewire 4 today</span>
                        <svg class="w-4 h-4 text-slate-400 group-hover:translate-x-1 group-hover:text-white transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </div>
            
           
            <h1 :class="mounted ? 'translate-y-0 opacity-100' : 'translate-y-12 opacity-0'" class="text-5xl md:text-7xl lg:text-8xl font-black tracking-tight leading-[1.1] mb-8 max-w-5xl transition-all duration-1000 delay-500 ease-out drop-shadow-2xl animate-shine pb-2">
                The best way to learn <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">Laravel</span><br class="hidden md:block" /> and modern PHP.
            </h1>
            
            <p :class="mounted ? 'translate-y-0 opacity-100' : 'translate-y-8 opacity-0'" class="text-lg md:text-2xl text-slate-400 max-w-2xl mb-14 font-medium transition-all duration-1000 delay-700 ease-out leading-relaxed">
                The most entertaining, comprehensive, and cinematic training for modern web artisans.
            </p>
            
           
            <div :class="mounted ? 'translate-y-0 opacity-100' : 'translate-y-8 opacity-0'" class="flex flex-col sm:flex-row gap-6 items-center justify-center transition-all duration-1000 delay-1000 ease-out w-full sm:w-auto">
                <button wire:click="getStarted" class="relative w-full sm:w-auto group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl blur-lg opacity-70 group-hover:opacity-100 group-hover:scale-105 transition-all duration-500"></div>
                    <div class="relative px-8 py-4 bg-gradient-to-br from-blue-500 to-indigo-600 text-white font-bold rounded-2xl flex items-center justify-center gap-3 transform group-hover:-translate-y-1 transition-all overflow-hidden border border-white/20">
                        <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-out"></div>
                        <span class="relative text-lg z-10">Start Your Journey</span>
                        <svg class="w-6 h-6 relative z-10 group-hover:animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </button>
                
                <a href="#latest" class="relative px-8 py-4 w-full sm:w-auto rounded-2xl font-bold text-white glass-panel hover:bg-white/10 transform hover:-translate-y-1 transition-all flex items-center justify-center gap-2 group border border-white/10 hover:border-white/30 hover:shadow-[0_0_30px_rgba(255,255,255,0.1)]">
                    Explore the Library
                    <svg class="w-5 h-5 text-slate-300 group-hover:rotate-45 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </a>
            </div>
        </div>

        
        <section id="latest" class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-48 perspective-1000 z-20 pt-10">
            
            <div class="absolute top-0 inset-x-0 flex items-center justify-center opacity-50">
                <div class="h-px bg-gradient-to-r from-transparent via-white to-transparent w-full max-w-3xl"></div>
                <div class="absolute bg-white text-slate-900 rounded-full p-2 shadow-[0_0_20px_rgba(255,255,255,0.8)]">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>

            <div class="flex flex-col md:flex-row items-end justify-between mb-16 mt-8" x-data="{ intersecting: false }" x-intersect="intersecting = true">
                <div :class="intersecting ? 'translate-x-0 opacity-100' : '-translate-x-12 opacity-0'" class="transition-all duration-1000 ease-out">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full glass-panel border border-white/10 text-xs font-bold text-blue-400 uppercase tracking-widest mb-4">
                        <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                        Fresh Content
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-white tracking-tight mb-2">Latest Masterclasses</h2>
                    <p class="text-xl text-slate-400 font-medium">Binge-watch our newest tech releases.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                    $colors = ['from-blue-600 to-indigo-600', 'from-rose-600 to-orange-500', 'from-cyan-500 to-teal-500', 'from-emerald-500 to-green-600'];
                    $icons = [
                        'M13 10V3L4 14h7v7l9-11h-7z',
                        'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z',
                        'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01',
                        'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'
                    ];
                    $delays = [100, 200, 300, 400];
                @endphp
                
                @foreach($this->latestSeries as $index => $series)
                <div x-data="{ isHovered: false }" 
                     class="group relative transform-style-3d cursor-pointer w-full h-[400px]"
                     @mouseenter="isHovered = true" @mouseleave="isHovered = false"
                     x-intersect="setTimeout(() => $el.classList.add('translate-y-0', 'opacity-100'), {{ $delays[$index % 4] }})"
                     class="translate-y-24 opacity-0 transition-all duration-1000 ease-out">
                    
                    
                    <div class="absolute -inset-0.5 bg-gradient-to-br {{ $colors[$index % 4] }} rounded-[2rem] blur-xl opacity-0 group-hover:opacity-40 transition-opacity duration-700 ease-out"></div>
                    
                    
                    <div class="absolute inset-0 glass-panel border border-white/10 rounded-[2rem] overflow-hidden flex flex-col transform group-hover:-translate-y-5 group-hover:rotate-y-[5deg] group-hover:rotate-x-[2deg] transition-all duration-500 ease-out shadow-2xl">
                        
                        
                        <div class="relative h-48 w-full overflow-hidden shrink-0">
                            <div class="absolute inset-0 bg-gradient-to-br {{ $colors[$index % 4] }} opacity-80 z-10 mix-blend-multiply group-hover:scale-110 group-hover:opacity-100 transition-all duration-700"></div>
                            
                           
                            <div class="absolute inset-0 z-0 opacity-30 group-hover:scale-125 group-hover:rotate-[15deg] transition-all duration-1000" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 20px 20px;"></div>
                            
                            <div class="absolute inset-0 flex items-center justify-center z-20">
                                <div class="w-20 h-20 glass-panel rounded-2xl flex items-center justify-center border border-white/20 shadow-2xl transform group-hover:scale-110 group-hover:rotate-12 transition-all duration-500">
                                    <svg class="w-10 h-10 text-white drop-shadow-md" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $icons[$index % 4] }}" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                       
                        <div class="p-6 flex flex-col grow bg-[#0A101D]/80 backdrop-blur-md relative z-30">
                           
                            <div class="absolute -top-4 right-6 bg-slate-900 px-3 py-1 rounded-lg border border-slate-700 shadow-xl flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-xs font-bold text-slate-300">{{ $series->lessons_count }} Eps</span>
                            </div>

                            <h3 class="text-xl font-bold text-white mb-3 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:{{ $colors[$index % 4] }} transition-all duration-300 leading-tight">{{ $series->title }}</h3>
                            <p class="text-sm text-slate-400 line-clamp-3 mb-auto leading-relaxed">{{ $series->description }}</p>
                            
                            
                            <div class="mt-6 flex items-center text-sm font-bold text-slate-500 group-hover:text-white transition-colors">
                                <span class="group-hover:mr-2 transition-all">Start Series</span>
                                <svg class="w-4 h-4 opacity-0 -translate-x-4 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </main>

    
    <footer class="mt-32 border-t border-white/5 bg-[#03060c] py-16 relative overflow-hidden z-20">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-blue-900/10 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="flex flex-col items-center justify-center text-center">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mb-8 shadow-[0_0_30px_rgba(59,130,246,0.3)]">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-6">Laracasts Clone</h3>
                <div class="flex gap-8 mb-10">
                    <a href="#" class="text-slate-400 hover:text-white hover:scale-110 transition-transform">Twitter</a>
                    <a href="#" class="text-slate-400 hover:text-white hover:scale-110 transition-transform">GitHub</a>
                    <a href="#" class="text-slate-400 hover:text-white hover:scale-110 transition-transform">Discord</a>
                </div>
                <p class="text-slate-600 text-sm font-medium">© <?= date('Y') ?> Eat , Sleep , Code , Repeat.</p>
            </div>
        </div>  
    </footer>
</div>