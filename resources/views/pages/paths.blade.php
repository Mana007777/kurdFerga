<?php

use App\Models\Path;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app.sidebar')] #[Title('Learning Paths')] class extends Component {
    public function with(): array
    {
        return [
            'paths' => Path::with('playlists')->where('is_published', true)->get(),
        ];
    }
};
?>

<div class="px-6 py-8 md:px-10 max-w-7xl mx-auto w-full">
    <!-- Header Section -->
    <div class="mb-12">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-violet-50 dark:bg-violet-900/30 border border-violet-200 dark:border-violet-500/30 text-[10px] font-black text-violet-600 dark:text-violet-400 uppercase tracking-[0.2em] mb-4">
            <flux:icon.map class="w-3 h-3" />
            Structured Learning
        </div>
        <h1 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white tracking-tight mb-4">
            Curated <span class="text-violet-600 dark:text-violet-400">Paths</span>
        </h1>
        <p class="text-slate-500 dark:text-gray-400 text-lg max-w-2xl">
            Don't know where to start? Follow these hand-picked learning journeys to master specific technologies from scratch.
        </p>
    </div>

    <!-- Paths Grid -->
    <div class="grid grid-cols-1 gap-12">
        @foreach($paths as $path)
            <div class="group relative">
                <!-- Path Card -->
                <div class="glass-panel rounded-[2.5rem] border border-slate-200 dark:border-white/10 overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500">
                    <div class="flex flex-col lg:flex-row">
                        <!-- Left: Info -->
                        <div class="p-8 lg:p-12 lg:w-1/2 flex flex-col justify-center">
                            <h2 class="text-3xl font-black text-slate-900 dark:text-white mb-6 group-hover:text-violet-600 dark:group-hover:text-violet-400 transition-colors">
                                {{ $path->title }}
                            </h2>
                            <p class="text-slate-600 dark:text-gray-400 text-lg leading-relaxed mb-8">
                                {{ $path->description }}
                            </p>
                            
                            <div class="flex items-center gap-6">
                                <flux:button :href="route('paths.show', $path->slug)" variant="primary" class="rounded-xl px-8 py-3">
                                    View Full Path
                                </flux:button>
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-slate-800 dark:text-gray-300">{{ $path->playlists->count() }} Playlists</span>
                                    <span class="text-[10px] text-slate-400 font-black uppercase tracking-widest">In sequence</span>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Steps Visualization -->
                        <div class="bg-slate-50 dark:bg-white/[0.02] p-8 lg:p-12 lg:w-1/2 flex flex-col justify-center border-t lg:border-t-0 lg:border-s border-slate-200 dark:border-white/10">
                            <h3 class="text-xs font-black text-slate-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-8">The Roadmap</h3>
                            
                            <div class="space-y-6 relative">
                                <!-- Connector Line -->
                                <div class="absolute left-6 top-8 bottom-8 w-px bg-dashed bg-gradient-to-b from-violet-500/50 to-plum-500/50 hidden md:block border-s border-dashed border-slate-300 dark:border-white/10"></div>

                                @foreach($path->playlists as $index => $playlist)
                                    <div class="flex items-center gap-6 relative group/step">
                                        <!-- Step Number -->
                                        <div class="w-12 h-12 shrink-0 rounded-2xl bg-white dark:bg-gray-800 border-2 border-slate-200 dark:border-white/10 flex items-center justify-center text-xl font-black text-slate-400 dark:text-gray-600 group-hover/step:border-violet-500 group-hover/step:text-violet-500 transition-all duration-300 z-10 shadow-sm">
                                            {{ $index + 1 }}
                                        </div>
                                        
                                        <!-- Playlist Info -->
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-800 dark:text-gray-200 group-hover/step:text-violet-600 dark:group-hover/step:text-violet-400 transition-colors">{{ $playlist->title }}</span>
                                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest underline decoration-violet-500/30">{{ $playlist->level }} Playlist</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
