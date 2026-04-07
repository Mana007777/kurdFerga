<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app.sidebar')] #[Title('Starred Videos')] class extends Component {
    public function with(): array
    {
        return [
            'starredLessons' => Auth::user()->starredLessons()->with(['section', 'playlist'])->latest('lesson_stars.created_at')->get(),
        ];
    }
};
?>

<div class="p-6 md:p-10 max-w-7xl mx-auto w-full">
    <div class="mb-10">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-50 dark:bg-amber-900/30 border border-amber-200 dark:border-amber-500/30 text-xs font-bold text-amber-600 dark:text-amber-400 uppercase tracking-widest mb-4">
            <flux:icon.star class="w-2 h-2" />
            Your Favorites
        </div>
        <h1 class="text-4xl md:text-5xl font-black text-slate-800 dark:text-white tracking-tight mb-2">Starred Videos</h1>
        <p class="text-slate-500 dark:text-slate-400 text-lg">Quick access to all the videos you've starred.</p>
    </div>

    @if($starredLessons->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($starredLessons as $lesson)
                <div class="group relative glass-panel rounded-2xl overflow-hidden border border-slate-200/60 dark:border-white/5 p-5 flex flex-col transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-400">
                            <flux:icon.play class="w-6 h-6" />
                        </div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-100 dark:bg-zinc-800 px-2 py-1 rounded-md">
                            {{ $lesson->playlist?->title ?? 'Playlist' }}
                        </div>
                    </div>
                    
                    <h3 class="font-bold text-slate-800 dark:text-zinc-100 text-lg leading-tight mb-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                        {{ $lesson->title }}
                    </h3>
                    
                    <p class="text-xs text-slate-500 dark:text-zinc-500 mb-6 line-clamp-1">
                        {{ $lesson->section?->title ?? 'Academy Content' }}
                    </p>

                    <div class="mt-auto flex items-center justify-between pt-4 border-t border-slate-100 dark:border-white/5">
                        <flux:button
                            href="{{ route('playlists.show', $lesson->playlist?->slug ?? '') }}"
                            variant="subtle"
                            size="sm"
                            icon="play"
                            wire:navigate
                        >
                            Watch Again
                        </flux:button>
                        
                        <div class="flex items-center gap-1.5 text-amber-500">
                            <flux:icon.star class="w-4 h-4 fill-current" />
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-20 rounded-2xl border border-dashed border-slate-300 dark:border-zinc-700">
            <div class="w-16 h-16 bg-slate-100 dark:bg-zinc-800 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                <flux:icon.star class="w-8 h-8" />
            </div>
            <h3 class="text-lg font-bold text-slate-700 dark:text-zinc-300">No starred videos yet</h3>
            <p class="text-sm text-slate-500 dark:text-zinc-500 mt-1">Start starring videos as you watch them to keep track of your favorites!</p>
            <flux:button href="{{ route('playlists.index') }}" variant="primary" class="mt-8" wire:navigate>Browse Playlists</flux:button>
        </div>
    @endif
</div>
