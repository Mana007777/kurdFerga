<?php

use App\Models\Path;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app.sidebar')] #[Title('Academy Roadmaps')] class extends Component {
    public function with(): array
    {
        return [
            'categorizedPaths' => Path::query()
                ->where('is_published', true)
                ->get()
                ->groupBy('category'),
        ];
    }
};
?>

<div class="px-6 py-12 md:px-10 max-w-7xl mx-auto w-full">
    <!-- Header Section -->
    <div class="text-center mb-20 relative">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-violet-50 dark:bg-violet-900/30 border border-violet-200 dark:border-violet-500/30 text-[10px] font-black text-violet-600 dark:text-violet-400 uppercase tracking-[0.2em] mb-6">
            <flux:icon.map class="w-3.5 h-3.5" />
            Academy Roadmaps
        </div>
        <h1 class="text-5xl md:text-7xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-6">
            Choose Your <span class="text-violet-600 dark:text-violet-400">Path</span>
        </h1>
        <p class="text-slate-500 dark:text-gray-400 text-lg md:text-xl max-w-2xl mx-auto">
            Select a specialized field to view curated learning journeys designed to take you from beginner to professional.
        </p>
    </div>

    <!-- Categories & Paths -->
    <div class="space-y-24">
        @foreach($categorizedPaths as $category => $paths)
            <div class="relative">
                <!-- Category Heading -->
                <div class="flex items-center gap-4 mb-10">
                    <h2 class="text-2xl font-black text-slate-800 dark:text-white uppercase tracking-tight">
                        {{ $category }}
                    </h2>
                    <div class="h-px flex-1 bg-gradient-to-r from-slate-200 to-transparent dark:from-white/10 dark:to-transparent"></div>
                </div>

                <!-- Paths Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($paths as $path)
                        <a href="{{ route('paths.show', $path->slug) }}" wire:navigate class="group block relative">
                            <div class="glass-panel h-full rounded-3xl border border-slate-200 dark:border-white/10 p-8 hover:border-violet-500/50 hover:shadow-2xl hover:shadow-violet-500/10 transition-all duration-500 flex flex-col">
                                <div class="mb-6 flex items-center justify-between">
                                    <div class="w-12 h-12 rounded-2xl bg-violet-500/10 flex items-center justify-center text-violet-600 transition-colors group-hover:bg-violet-500 group-hover:text-white">
                                        <flux:icon.academic-cap class="w-6 h-6" />
                                    </div>
                                    <flux:icon.arrow-right class="w-4 h-4 text-slate-300 group-hover:text-violet-500 transition-all group-hover:translate-x-1" />
                                </div>
                                
                                <h3 class="text-xl font-black text-slate-900 dark:text-white mb-3 group-hover:text-violet-600 dark:group-hover:text-violet-400 transition-colors">
                                    {{ $path->title }}
                                </h3>
                                
                                <p class="text-slate-500 dark:text-gray-400 text-sm leading-relaxed mb-6 line-clamp-3">
                                    {{ $path->description }}
                                </p>

                                <div class="mt-auto pt-6 border-t border-slate-100 dark:border-white/5 flex items-center justify-between">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                        @if($path->playlists_count > 0 || $path->playlists->isNotEmpty())
                                            {{ $path->playlists->count() }} Playlists
                                        @else
                                            Curating Content
                                        @endif
                                    </span>
                                    <span class="px-2 py-1 rounded-md bg-slate-50 dark:bg-white/5 text-[9px] font-black text-slate-500 dark:text-gray-400 uppercase tracking-tighter">
                                        Mastery Track
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <!-- Support Section -->
    <div class="mt-32 glass-panel rounded-[3rem] p-12 lg:p-16 border border-slate-200 dark:border-white/10 text-center relative overflow-hidden">
        <div class="absolute -top-12 -right-12 w-64 h-64 bg-violet-500/5 rounded-full blur-3xl"></div>
        <div class="relative z-10">
            <h2 class="text-3xl font-black text-slate-900 dark:text-white mb-4 uppercase tracking-tight">Need a custom path?</h2>
            <p class="text-slate-500 dark:text-gray-400 text-lg max-w-xl mx-auto mb-8">
                Our curriculum team is constantly adding new tracks. If you have a specific technology in mind, let us know.
            </p>
            <flux:button variant="primary" class="rounded-2xl px-10 py-4 font-black">
                Request a Technology
            </flux:button>
        </div>
    </div>
</div>
