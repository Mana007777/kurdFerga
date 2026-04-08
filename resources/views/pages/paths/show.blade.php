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

            <div class="mt-10 flex flex-wrap gap-4">
                <div class="flex items-center gap-3 glass-panel rounded-2xl px-5 py-3 border border-slate-200 dark:border-white/10">
                    <span class="text-2xl font-black text-violet-600 dark:text-violet-400">{{ $path->playlists->count() }}</span>
                    <span class="text-xs font-black text-slate-400 uppercase tracking-widest leading-tight">Curated<br>Playlists</span>
                </div>
                <div class="flex items-center gap-3 glass-panel rounded-2xl px-5 py-3 border border-slate-200 dark:border-white/10">
                    @php $totalLessons = $path->playlists->sum(fn($p) => $p->lessons->count()); @endphp
                    <span class="text-2xl font-black text-violet-600 dark:text-violet-400">{{ $totalLessons }}</span>
                    <span class="text-xs font-black text-slate-400 uppercase tracking-widest leading-tight">Lessons To<br>Complete</span>
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

    <!-- The Roadmap Timeline -->
    <div class="relative">
        <div class="absolute left-8 lg:left-1/2 top-0 bottom-0 w-1 bg-gradient-to-b from-violet-500/50 via-plum-500/50 to-transparent rounded-full hidden md:block"></div>
        
        <div class="space-y-24">
            @foreach($path->playlists as $index => $playlist)
                <div class="relative flex flex-col md:flex-row items-center gap-12 group">
                    <!-- Marker -->
                    <div class="absolute left-8 lg:left-1/2 -translate-x-1/2 w-16 h-16 rounded-[1.5rem] bg-white dark:bg-gray-900 border-4 border-violet-500 dark:border-violet-400 flex items-center justify-center text-2xl font-black text-violet-600 dark:text-violet-400 z-20 shadow-2xl group-hover:scale-110 transition-transform hidden md:flex">
                        {{ $index + 1 }}
                    </div>

                    @if($index % 2 === 0)
                        <!-- Card Left -->
                        <div class="md:w-1/2 text-start md:text-end md:pr-24 w-full">
                            <h3 class="text-3xl font-black text-slate-900 dark:text-white mb-4 group-hover:text-violet-500 transition-colors">{{ $playlist->title }}</h3>
                            <p class="text-slate-500 dark:text-gray-400 text-lg mb-6 line-clamp-2 md:ml-auto md:max-w-md">{{ $playlist->description }}</p>
                            <span class="px-4 py-2 rounded-lg bg-slate-100 dark:bg-white/5 text-[10px] font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest border border-slate-200 dark:border-white/10">{{ $playlist->level }}</span>
                        </div>
                        <div class="md:w-1/2 md:pl-24 w-full">
                             <a href="{{ route('playlists.show', $playlist->slug) }}" wire:navigate class="block relative group/img overflow-hidden rounded-[2.5rem] border border-slate-200 dark:border-white/10 shadow-xl aspect-video hover:-translate-y-2 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-br from-violet-500 to-plum-600 opacity-60 mix-blend-multiply transition-opacity group-hover/img:opacity-40"></div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <flux:icon.play-circle class="w-16 h-16 text-white/50 group-hover/img:scale-110 transition-transform" />
                                </div>
                                <img src="{{ $playlist->thumbnail ?? 'https://placehold.co/600x400/1e1b4b/white?text=' . urlencode($playlist->title) }}" class="w-full h-full object-cover" alt="">
                            </a>
                        </div>
                    @else
                        <!-- Card Right -->
                        <div class="md:w-1/2 md:pr-24 order-2 md:order-1 w-full">
                            <a href="{{ route('playlists.show', $playlist->slug) }}" wire:navigate class="block relative group/img overflow-hidden rounded-[2.5rem] border border-slate-200 dark:border-white/10 shadow-xl aspect-video hover:-translate-y-2 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-br from-plum-500 to-violet-600 opacity-60 mix-blend-multiply transition-opacity group-hover/img:opacity-40"></div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <flux:icon.play-circle class="w-16 h-16 text-white/50 group-hover/img:scale-110 transition-transform" />
                                </div>
                                <img src="{{ $playlist->thumbnail ?? 'https://placehold.co/600x400/312e81/white?text=' . urlencode($playlist->title) }}" class="w-full h-full object-cover" alt="">
                            </a>
                        </div>
                        <div class="md:w-1/2 md:pl-24 order-1 md:order-2 w-full">
                            <h3 class="text-3xl font-black text-slate-900 dark:text-white mb-4 group-hover:text-violet-500 transition-colors">{{ $playlist->title }}</h3>
                            <p class="text-slate-500 dark:text-gray-400 text-lg mb-6 line-clamp-2 md:max-w-md">{{ $playlist->description }}</p>
                            <span class="px-4 py-2 rounded-lg bg-slate-100 dark:bg-white/5 text-[10px] font-black text-slate-500 dark:text-gray-400 uppercase tracking-widest border border-slate-200 dark:border-white/10">{{ $playlist->level }}</span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Final Call to Action -->
    <div class="mt-32 text-center bg-violet-600 dark:bg-violet-500 rounded-[3rem] p-12 lg:p-20 relative overflow-hidden shadow-2xl">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-plum-500/20 rounded-full blur-3xl"></div>
        
        <h2 class="text-4xl md:text-6xl font-black text-white relative z-10 mb-8 tracking-tight">Ready to begin your journey?</h2>
        <p class="text-violet-100 text-xl mb-12 relative z-10 max-w-2xl mx-auto font-medium">Start the first playlist of this path and track your progress all the way to mastery.</p>
        
        @auth
           <flux:button :href="route('playlists.show', $path->playlists->first()->slug)" variant="primary" class="rounded-2xl px-12 py-5 text-xl font-black hover:scale-105 transition-transform shadow-xl !bg-white !text-violet-600 border-none">
                Start Step 1
            </flux:button>
        @else
            <flux:button :href="route('register')" variant="primary" class="rounded-2xl px-12 py-5 text-xl font-black hover:scale-105 transition-transform shadow-xl !bg-white !text-violet-600 border-none">
                Create Account To Track Progress
            </flux:button>
        @endauth
    </div>
</div>
