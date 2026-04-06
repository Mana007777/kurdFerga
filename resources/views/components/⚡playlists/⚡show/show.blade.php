<?php

use App\Models\Playlist;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.app.sidebar')] class extends Component
{
    public Playlist $playlist;

    public function mount(Playlist $playlist)
    {
        abort_if(! $playlist->is_published, 404);
        $this->playlist = $playlist;
    }

    public function with(): array
    {
        return [
            'sections' => $this->playlist->sections()->with(['lessons' => fn ($q) => $q->where('is_published', true)->orderBy('sort_order')])->orderBy('sort_order')->get(),
        ];
    }
};
?>

<div class="p-6 md:p-10 max-w-5xl mx-auto w-full">
    <!-- Back -->
    <flux:button variant="ghost" icon="arrow-left" href="{{ route('playlists.index') }}" wire:navigate class="mb-6" />

    <!-- Playlist Hero -->
    <div class="relative rounded-3xl overflow-hidden mb-10 bg-gradient-to-br from-indigo-500 to-purple-600 shadow-2xl">
        @if($playlist->thumbnail)
            <img src="{{ $playlist->thumbnail }}" class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-40" alt="{{ $playlist->title }}" />
        @endif
        <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 20px 20px;"></div>
        <div class="relative z-10 px-8 py-12">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur-sm text-white text-xs font-bold uppercase tracking-widest mb-4">
                <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                Playlist
            </div>
            <h1 class="text-3xl md:text-5xl font-black text-white tracking-tight mb-3">{{ $playlist->title }}</h1>
            @if($playlist->description)
                <p class="text-white/80 text-lg max-w-2xl">{{ $playlist->description }}</p>
            @endif
            <div class="flex items-center gap-4 mt-6 text-white/70 text-sm font-medium">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                    {{ $sections->count() }} {{ Str::plural('Section', $sections->count()) }}
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $sections->sum(fn($s) => $s->lessons->count()) }} {{ Str::plural('Course', $sections->sum(fn($s) => $s->lessons->count())) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Sections & Lessons -->
    @forelse($sections as $section)
        <div class="mb-6 rounded-2xl border border-slate-200/60 dark:border-white/5 overflow-hidden bg-white/70 dark:bg-zinc-900/60 backdrop-blur-xl shadow-sm">
            <!-- Section Header -->
            <div class="px-6 py-4 bg-slate-50/80 dark:bg-black/20 border-b border-slate-200/60 dark:border-white/5 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                </div>
                <h2 class="font-bold text-slate-800 dark:text-zinc-100">{{ $section->title }}</h2>
                <span class="ml-auto text-xs text-slate-500 dark:text-zinc-500 font-medium">{{ $section->lessons->count() }} {{ Str::plural('video', $section->lessons->count()) }}</span>
            </div>

            <!-- Lessons -->
            <div class="divide-y divide-slate-100 dark:divide-white/5">
                @forelse($section->lessons as $i => $lesson)
                    <div class="group flex items-center gap-4 px-6 py-4 hover:bg-indigo-50/50 dark:hover:bg-indigo-900/10 transition-colors cursor-pointer" x-data="{ open: false }">
                        <!-- Episode Number -->
                        <div class="w-8 h-8 shrink-0 rounded-full bg-slate-100 dark:bg-zinc-800 flex items-center justify-center text-xs font-bold text-slate-500 dark:text-zinc-400 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/30 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                            {{ $i + 1 }}
                        </div>

                        <!-- Play icon -->
                        <div class="w-10 h-10 shrink-0 rounded-xl bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center group-hover:bg-indigo-500 transition-colors">
                            <svg class="w-5 h-5 text-indigo-500 group-hover:text-white ml-0.5 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </div>

                        <div class="flex-1 min-w-0">
                            <h4 class="font-semibold text-slate-800 dark:text-zinc-100 text-sm truncate group-hover:text-indigo-700 dark:group-hover:text-indigo-300 transition-colors">{{ $lesson->title }}</h4>
                            @if($lesson->is_preview)
                                <span class="inline-flex items-center text-xs font-bold text-amber-600 dark:text-amber-400 mt-0.5">Free Preview</span>
                            @endif
                        </div>

                        <!-- Video Button -->
                        @if($lesson->video_url)
                            <a href="{{ $lesson->video_url }}" target="_blank" class="shrink-0 opacity-0 group-hover:opacity-100 transition-opacity">
                                <flux:badge size="sm" color="indigo" icon="arrow-top-right-on-square">Watch</flux:badge>
                            </a>
                        @endif
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-sm text-slate-400 dark:text-zinc-600 italic">No videos in this section yet.</div>
                @endforelse
            </div>
        </div>
    @empty
        <div class="text-center py-16 rounded-2xl border border-dashed border-slate-300 dark:border-zinc-700">
            <p class="text-slate-500 dark:text-zinc-500">No content available yet for this playlist.</p>
        </div>
    @endforelse
</div>
