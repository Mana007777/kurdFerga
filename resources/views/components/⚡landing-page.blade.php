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

<div x-data="{ mounted: false, showTopics: false, activeTopic: null }" x-init="setTimeout(() => mounted = true, 50)" class="min-h-screen bg-zinc-950 text-slate-400 font-sans selection:bg-violet-500 selection:text-white overflow-x-hidden relative">
    
    <style>
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
            background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 24px 24px;
        }
        .animate-scroll-grid {
            animation: scrollGrid 1.5s linear infinite;
        }

        .glass-panel {
            background: rgba(9, 9, 11, 0.6);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .perspective-1000 { perspective: 1000px; }
        .transform-style-3d { transform-style: preserve-3d; }

        @keyframes scroll-left {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .animate-scroll-left {
            animation: scroll-left 10s linear infinite;
        }
        .pause-on-hover:hover {
            animation-play-state: paused;
        }
    </style>

    
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none bg-zinc-950">
        <div class="absolute inset-0 z-0 bg-dot-pattern opacity-10 pointer-events-none"></div>
    </div>

    
    <header 
        x-data="{ lastScrollY: 0, isHidden: false }"
        @scroll.window="isHidden = window.scrollY > lastScrollY && window.scrollY > 80; lastScrollY = window.scrollY"
        :class="(!mounted || isHidden) ? '-translate-y-[150%] opacity-0' : 'translate-y-0 opacity-100'" 
        class="fixed w-full top-0 z-50 transition-all duration-700 ease-in-out">
        <div class="glass-panel mx-4 mt-4 rounded-3xl border-zinc-800 shadow-[0_8px_32px_rgba(0,0,0,0.5)] bg-zinc-950/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 sm:h-20">
                    <div class="flex items-center gap-10">
                        <a href="/" class="flex items-center gap-3 group relative">
                            <div class="absolute inset-0 bg-violet-600 rounded-xl blur-lg opacity-20 group-hover:opacity-60 transition duration-500"></div>
                            <div class="relative w-11 h-11 bg-zinc-900 border border-zinc-800 rounded-xl flex items-center justify-center transform group-hover:rotate-12 transition-all duration-300">
                                <flux:icon.command-line class="w-6 h-6 text-violet-500" />
                            </div>
                            <span class="text-3xl tracking-tighter text-white font-black z-10">F</span>
                        </a>
                        
                        <nav class="hidden md:flex gap-10 text-[10px] font-black uppercase tracking-[0.2em]">
                            <button @click="showTopics = true" class="text-zinc-500 hover:text-white transition-all duration-300 relative group cursor-pointer">
                                {{ __('Topics') }}
                                <span class="absolute inset-x-0 -bottom-1 h-[1px] bg-violet-500 scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                            </button>
                            <a href="#latest" class="text-zinc-500 hover:text-white transition-all duration-300 relative group">
                                {{ __('Playlists') }}
                                <span class="absolute inset-x-0 -bottom-1 h-[1px] bg-violet-500 scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                            </a>
                            <a href="{{ route('paths.index') }}" wire:navigate class="text-zinc-500 hover:text-white transition-all duration-300 relative group">
                                {{ __('Paths') }}
                                <span class="absolute inset-x-0 -bottom-1 h-[1px] bg-violet-500 scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                            </a>
                        </nav>
                    </div>
                    
                    <div class="flex items-center gap-8">
                        <a href="/login" class="text-[10px] font-black text-zinc-500 hover:text-white uppercase tracking-widest px-4 py-2">{{ __('Sign In') }}</a>
                        <button wire:click="getStarted" class="relative group h-10 px-6 bg-white rounded-full transition-all duration-300 transform hover:-translate-y-0.5 shadow-[0_0_20px_rgba(255,255,255,0.2)]">
                            <span class="text-[10px] font-black text-zinc-950 uppercase tracking-widest">{{ __('Get Started') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    
    <main class="relative z-10 pt-48 pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center text-center">
            
            <div :class="mounted ? 'scale-100 opacity-100' : 'scale-50 opacity-0'" class="transition-all duration-1000 delay-300 ease-out mb-12">
                <div class="inline-flex items-center gap-3 px-4 py-1.5 rounded-full bg-zinc-900 border border-zinc-800 text-[10px] font-black uppercase tracking-widest text-zinc-500">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span>
                    <span class="text-zinc-300">{{ __('Direct Feed Active') }}</span>
                    <span class="w-px h-3 bg-zinc-800 mx-1"></span>
                    <span class="text-violet-500">{{ __('Curriculum v2.4') }}</span>
                </div>
            </div>
            
            <h1 :class="mounted ? 'translate-y-0 opacity-100' : 'translate-y-12 opacity-0'" class="text-6xl md:text-8xl lg:text-9xl font-black tracking-tighter leading-[0.9] mb-10 max-w-5xl transition-all duration-1000 delay-500 ease-out text-white uppercase">
                {!! __('Artisanal <span class="text-transparent bg-clip-text bg-gradient-to-r from-violet-500 to-plum-500">Knowledge</span><br /> Deployment') !!}
            </h1>
            
            <p :class="mounted ? 'translate-y-0 opacity-100' : 'translate-y-8 opacity-0'" class="text-sm md:text-lg text-zinc-500 max-w-2xl mb-16 font-mono transition-all duration-1000 delay-700 ease-out leading-relaxed tracking-tight uppercase">
                {{ __('High-frequency, precision-engineered training for modern web architects. Cinematic curriculum for the 0.1%.') }}
            </p>
            
            <div :class="mounted ? 'translate-y-0 opacity-100' : 'translate-y-8 opacity-0'" class="flex flex-col sm:flex-row gap-6 items-center justify-center transition-all duration-1000 delay-1000 ease-out w-full sm:w-auto">
                <button wire:click="getStarted" class="relative group px-10 py-5 bg-violet-600 rounded-2xl overflow-hidden transition-all duration-500 hover:scale-105 active:scale-95 shadow-[0_0_50px_-12px_rgba(139,92,246,0.6)]">
                    <div class="absolute inset-0 bg-gradient-to-tr from-violet-400/20 to-transparent"></div>
                    <span class="relative text-[11px] font-black text-white uppercase tracking-[0.3em]">{{ __('Initialize Training') }}</span>
                </button>
                
                <a href="#latest" class="px-10 py-5 rounded-2xl bg-zinc-900 border border-zinc-800 text-[11px] font-black text-zinc-400 uppercase tracking-[0.3em] hover:bg-zinc-800 hover:text-white transition-all duration-300">
                    {{ __('System Database') }}
                </a>
            </div>
        </div>

        
        <section id="latest" class="relative max-w-[100vw] mt-48 z-20 pt-20 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20">
                <div class="flex flex-col md:flex-row items-end justify-between gap-6">
                    <div class="space-y-4">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-zinc-900 border border-zinc-800 text-[9px] font-black text-violet-500 uppercase tracking-widest">
                            <span class="w-1.5 h-1.5 rounded-full bg-violet-500"></span>
                            {{ __('Live Deployments') }}
                        </div>
                        <h2 class="text-4xl md:text-6xl font-black text-white tracking-tighter uppercase">{{ __('Latest Operations') }}</h2>
                    </div>
                </div>
            </div>

            <div class="relative overflow-hidden group/marquee">
                <div class="flex animate-scroll-left pause-on-hover w-max pt-16 pb-12">
                     @foreach($this->latestSeries as $index => $series)
                        <div class="px-4">
                            <a
                                href="{{ route('playlists.show', $series->slug) }}"
                                wire:navigate
                                class="group relative flex flex-col bg-zinc-950 border border-zinc-800 rounded-[2.5rem] overflow-hidden transition-all duration-500 hover:border-violet-500/40 hover:shadow-[0_0_50px_-12px_rgba(139,92,246,0.5)] w-[320px] h-[440px]"
                            >
                                {{-- Top Hardware Header --}}
                                <div class="relative h-48 w-full overflow-hidden shrink-0 bg-zinc-900/50">
                                    <div class="absolute inset-0 bg-gradient-to-br from-violet-600/20 to-plum-600/20 z-10 mix-blend-multiply"></div>
                                    <div class="absolute inset-0 z-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 24px 24px;"></div>
                                    
                                    <div class="absolute inset-0 flex items-center justify-center z-20">
                                        <div class="w-24 h-24 rounded-full p-1 bg-zinc-950/80 backdrop-blur-md border border-zinc-700 shadow-2xl group-hover:scale-110 group-hover:border-violet-500/50 transition-all duration-700 overflow-hidden">
                                            @if($series->thumbnail)
                                                <img src="{{ str_starts_with($series->thumbnail, 'http') ? $series->thumbnail : asset('storage/' . $series->thumbnail) }}" class="w-full h-full object-cover" alt="{{ $series->title }}" />
                                            @else
                                                 <flux:icon.command-line class="w-10 h-10 text-zinc-700 group-hover:text-violet-500 transition-colors duration-500 mx-auto mt-6" />
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Level Badge --}}
                                    <div class="absolute top-4 right-4 z-30">
                                        <div class="px-3 py-1 rounded-full bg-zinc-950/80 backdrop-blur-md border border-zinc-800 text-[8px] font-black text-violet-400 uppercase tracking-widest">
                                            {{ $series->level ?? 'Mastery' }}
                                        </div>
                                    </div>
                                </div>

                                {{-- Body Module --}}
                                <div class="p-8 flex flex-col grow bg-gradient-to-b from-zinc-950 to-zinc-950/50 relative z-30">
                                    <div class="space-y-4 grow">
                                        <div class="space-y-1">
                                            <h3 class="text-xl font-black text-white leading-[1.1] tracking-tighter uppercase group-hover:text-violet-400 transition-colors duration-300 line-clamp-2">
                                                {{ $series->title }}
                                            </h3>
                                            <p class="text-[9px] font-mono text-zinc-600 uppercase tracking-[0.2em] truncate">{{ __('Unit') }}: {{ $series->author_name ?? 'Command' }}</p>
                                        </div>

                                        {{-- Hardware Specs --}}
                                        <div class="space-y-3 pt-6 border-t border-zinc-900/50">
                                            <div class="flex items-center gap-3 text-zinc-500 group/item">
                                                <flux:icon.queue-list class="w-3.5 h-3.5 text-zinc-700 group-hover/item:text-violet-500 transition-colors" />
                                                <span class="text-[9px] font-black uppercase tracking-widest">{{ $series->lessons_count }} {{ __('Episodes') }}</span>
                                            </div>
                                            <div class="flex items-center gap-3 text-zinc-500 group/item">
                                                <flux:icon.tag class="w-3.5 h-3.5 text-zinc-700 group-hover/item:text-emerald-500 transition-colors" />
                                                <span class="text-[9px] font-black uppercase tracking-widest">{{ __($series->category ?? 'Operation') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Bottom Hardware Bar --}}
                                    <div class="mt-6 flex items-center justify-between">
                                        <div class="text-[9px] font-black text-zinc-700 uppercase tracking-widest">{{ __('Protocol') }}.0{{ $index + 1 }}</div>
                                        <div class="w-8 h-[2px] bg-zinc-800 group-hover:w-12 group-hover:bg-violet-600 transition-all duration-500"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach

                    {{-- Duplicate for Marquee --}}
                     @foreach($this->latestSeries as $index => $series)
                        <div class="px-4">
                            <a
                                href="{{ route('playlists.show', $series->slug) }}"
                                wire:navigate
                                class="group relative flex flex-col bg-zinc-950 border border-zinc-800 rounded-[2.5rem] overflow-hidden transition-all duration-500 hover:border-violet-500/40 hover:shadow-[0_0_50px_-12px_rgba(139,92,246,0.5)] w-[320px] h-[440px]"
                            >
                                <div class="relative h-48 w-full overflow-hidden shrink-0 bg-zinc-900/50">
                                    <div class="absolute inset-0 bg-gradient-to-br from-violet-600/20 to-plum-600/20 z-10 mix-blend-multiply"></div>
                                    <div class="absolute inset-0 flex items-center justify-center z-20">
                                        <div class="w-24 h-24 rounded-full p-1 bg-zinc-950/80 backdrop-blur-md border border-zinc-700 shadow-2xl group-hover:scale-110 group-hover:border-violet-500/50 transition-all duration-700 overflow-hidden">
                                            @if($series->thumbnail)
                                                <img src="{{ str_starts_with($series->thumbnail, 'http') ? $series->thumbnail : asset('storage/' . $series->thumbnail) }}" class="w-full h-full object-cover" alt="{{ $series->title }}" />
                                            @else
                                                 <flux:icon.command-line class="w-10 h-10 text-zinc-700 group-hover:text-violet-500 transition-colors duration-500 mx-auto mt-6" />
                                            @endif
                                        </div>
                                    </div>
                                    <div class="absolute top-4 right-4 z-30">
                                        <div class="px-3 py-1 rounded-full bg-zinc-950/80 backdrop-blur-md border border-zinc-800 text-[8px] font-black text-violet-400 uppercase tracking-widest">
                                            {{ __($series->level ?? 'Mastery') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="p-8 flex flex-col grow bg-gradient-to-b from-zinc-950 to-zinc-950/50 relative z-30">
                                    <div class="space-y-4 grow">
                                        <div class="space-y-1">
                                            <h3 class="text-xl font-black text-white leading-[1.1] tracking-tighter uppercase group-hover:text-violet-400 transition-colors duration-300 line-clamp-2">
                                                {{ $series->title }}
                                            </h3>
                                            <p class="text-[9px] font-mono text-zinc-600 uppercase tracking-[0.2em] truncate">{{ __('Unit') }}: {{ $series->author_name ?? 'Command' }}</p>
                                        </div>
                                        <div class="space-y-3 pt-6 border-t border-zinc-900/50">
                                            <div class="flex items-center gap-3 text-zinc-500 group/item">
                                                <flux:icon.queue-list class="w-3.5 h-3.5 text-zinc-700 group-hover/item:text-violet-500 transition-colors" />
                                                <span class="text-[9px] font-black uppercase tracking-widest">{{ $series->lessons_count }} {{ __('Episodes') }}</span>
                                            </div>
                                            <div class="flex items-center gap-3 text-zinc-500 group/item">
                                                <flux:icon.tag class="w-3.5 h-3.5 text-zinc-700 group-hover/item:text-emerald-500 transition-colors" />
                                                <span class="text-[9px] font-black uppercase tracking-widest">{{ __($series->category ?? 'Operation') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-6 flex items-center justify-between">
                                        <div class="text-[9px] font-black text-zinc-700 uppercase tracking-widest">{{ __('Protocol') }}.0{{ $index + 1 }}</div>
                                        <div class="w-8 h-[2px] bg-zinc-800 group-hover:w-12 group-hover:bg-violet-600 transition-all duration-500"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Topics Modal --}}
        <flux:modal x-model="showTopics" variant="flyout" class="max-w-4xl !bg-zinc-950">
            <div class="space-y-6">
                <div>
                    <flux:heading size="xl" class="!text-white uppercase tracking-tighter font-black">{{ __('Intell-Base Topics') }}</flux:heading>
                    <flux:text class="!text-zinc-500 !font-mono uppercase text-[10px]">{{ __('Select a branch for theoretical deep-dive.') }}</flux:text>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                    <div class="space-y-2 max-h-[60vh] overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($this->topics as $topic)
                            <button 
                                @click="activeTopic = {{ json_encode($topic) }}"
                                :class="activeTopic?.id === {{ $topic->id }} ? 'bg-zinc-900 border-violet-500/50' : 'hover:bg-zinc-900/50 border-zinc-800'"
                                class="w-full text-left p-4 rounded-xl border transition-all duration-200 group flex items-center justify-between"
                            >
                                <span class="text-xs font-black uppercase tracking-widest text-zinc-400 group-hover:text-white" :class="activeTopic?.id === {{ $topic->id }} && 'text-white'">
                                    {{ $topic->title }}
                                </span>
                                <flux:icon icon="chevron-right" variant="micro" class="text-zinc-700 group-hover:text-violet-500" />
                            </button>
                        @endforeach
                    </div>

                    <div class="sticky top-0">
                        <div x-show="!activeTopic" class="rounded-3xl p-8 min-h-[400px] flex flex-col items-center justify-center text-center border-dashed border-2 border-zinc-800">
                            <div class="w-16 h-16 bg-zinc-900 border border-zinc-800 rounded-2xl flex items-center justify-center mb-6">
                                <flux:icon icon="book-open" class="w-8 h-8 text-zinc-700" />
                            </div>
                            <flux:heading class="uppercase font-black tracking-widest text-zinc-500">{{ __('Awaiting Selection') }}</flux:heading>
                        </div>

                        <div x-show="activeTopic" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                            <div class="relative group">
                                <div class="absolute -inset-1 bg-violet-600 rounded-[2rem] blur opacity-10 group-hover:opacity-30 transition duration-500"></div>
                                <div class="relative p-8 bg-zinc-950 border border-zinc-800 rounded-[2rem] shadow-xl">
                                    <h3 class="text-2xl font-black text-white mb-4 leading-tight uppercase tracking-tighter" x-text="activeTopic?.title"></h3>
                                    
                                    <div class="flex items-center gap-2 mb-6">
                                        <div class="h-1 w-8 bg-violet-500 rounded-full"></div>
                                        <span class="text-[9px] font-black text-violet-500 uppercase tracking-widest">{{ __('Protocol Introduction') }}</span>
                                    </div>

                                    <div class="relative">
                                        <p class="text-zinc-400 leading-relaxed font-mono text-xs relative z-10" x-text="activeTopic?.description"></p>
                                    </div>
                                </div>
                            </div>
                            
                            <a :href="'/playlists/' + activeTopic?.slug" class="relative group block w-full">
                                <div class="absolute inset-0 bg-violet-600 rounded-2xl blur-lg opacity-40 group-hover:opacity-80 transition duration-500"></div>
                                <div class="relative flex items-center justify-center gap-3 py-4 bg-white text-zinc-950 font-black text-xs uppercase tracking-[0.2em] rounded-2xl hover:scale-[1.01] transition-all">
                                    <span>{{ __('Initialize Deployment') }}</span>
                                    <flux:icon icon="arrow-right" variant="micro" class="w-4 h-4" />
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </flux:modal>
    </main>

    
    <footer class="mt-32 border-t border-zinc-800 bg-zinc-950 py-16 relative overflow-hidden z-20">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-blue-900/10 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="flex flex-col items-center justify-center text-center">
                <div class="w-12 h-12 bg-zinc-900 border border-zinc-800 rounded-xl flex items-center justify-center mb-8">
                     <flux:icon.command-line class="w-6 h-6 text-violet-500" />
                </div>
                <h3 class="text-2xl font-bold text-white mb-6">F</h3>
                <div class="flex gap-8 mb-10">
                    <a href="https://github.com/Mana007777" class="text-zinc-500 hover:text-white transition-colors">GitHub</a>
                </div>
                <p class="text-zinc-600 text-sm font-medium">© <?= date('Y') ?> Eat , Sleep , Code , Repeat.</p>
            </div>
        </div>  
    </footer>
</div>