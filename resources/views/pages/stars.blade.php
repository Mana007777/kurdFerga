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

<div class="px-8 md:px-12 py-12 max-w-7xl mx-auto w-full space-y-20">
    <!-- Header Section: Priority Briefing -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div class="space-y-4">
            <div class="flex items-center gap-3">
                <div class="px-2 py-0.5 rounded bg-amber-500/10 border border-amber-500/20">
                    <span class="text-[10px] font-black text-amber-500 uppercase tracking-[0.2em]">Priority Deployments</span>
                </div>
                <div class="flex items-center gap-1.5 text-[10px] font-bold text-zinc-500 uppercase tracking-widest">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse shadow-[0_0_8px_rgba(245,158,11,0.4)]"></span>
                    Retrieval Active
                </div>
            </div>
            <h1 class="text-4xl md:text-6xl font-black text-white tracking-tighter uppercase leading-none">Priority Archive</h1>
            <p class="text-zinc-500 font-mono text-sm tracking-tight max-w-2xl leading-relaxed">
                Database Access: AUTHORIZED // High-frequency units marked for immediate operational deployment. 
            </p>
        </div>

        <div class="hidden md:flex flex-col items-end text-right">
             <span class="text-[10px] font-black text-zinc-600 uppercase tracking-[0.3em] px-4 py-2 bg-zinc-900 border border-zinc-800 rounded-xl">
                {{ count($starredLessons) }} Saved Blocks
            </span>
        </div>
    </div>

    @if($starredLessons->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($starredLessons as $lesson)
                <div class="group relative bg-zinc-950 border border-zinc-800 rounded-[2rem] p-8 transition-all duration-500 hover:border-violet-500/40 hover:shadow-[0_0_40px_-12px_rgba(139,92,246,0.3)] flex flex-col h-full">
                    
                    {{-- Module Identity --}}
                    <div class="flex items-start justify-between mb-8">
                        <div class="w-12 h-12 rounded-xl bg-zinc-900 border border-zinc-800 flex items-center justify-center text-amber-500 group-hover:bg-amber-500/10 transition-colors duration-500">
                            <flux:icon.star class="w-6 h-6 fill-current" />
                        </div>
                        <div class="text-right">
                            <span class="block text-[8px] font-mono text-zinc-600 uppercase">SYS-ACC // PRIORITY</span>
                            <span class="block text-[9px] font-black text-zinc-500 uppercase tracking-widest">{{ $lesson->playlist?->title ?? 'Academy Unit' }}</span>
                        </div>
                    </div>
                    
                    <div class="space-y-3 mb-10">
                        <h3 class="text-2xl font-black text-white leading-tight tracking-tight group-hover:text-violet-400 transition-colors duration-300 uppercase">
                            {{ $lesson->title }}
                        </h3>
                        <div class="inline-flex items-center gap-2 px-2 py-0.5 rounded bg-zinc-900/50 border border-zinc-800">
                             <span class="text-[8px] font-black text-zinc-500 uppercase tracking-widest">{{ $lesson->section?->title ?? 'Syllabus Block' }}</span>
                        </div>
                    </div>

                    <div class="mt-auto pt-6 border-t border-zinc-900 flex items-center justify-between">
                        <flux:button
                            href="{{ route('playlists.show', $lesson->playlist?->slug ?? '') }}"
                            variant="filled"
                            size="base"
                            icon="play"
                            wire:navigate
                            class="!rounded-xl !bg-zinc-900 !hover:bg-violet-500 !font-black !text-[9px] !uppercase !tracking-widest !text-zinc-400 hover:!text-white !transition-all"
                        >
                            Initialize Block
                        </flux:button>
                        
                        <div class="flex items-center gap-1.5">
                            <div class="w-1 h-1 rounded-full bg-violet-500"></div>
                            <span class="text-[8px] font-mono text-zinc-600 uppercase">Data Verified</span>
                        </div>
                    </div>

                    <!-- Edge Brackets -->
                    <div class="absolute top-4 left-4 w-2 h-2 border-t border-l border-white/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="absolute top-4 right-4 w-2 h-2 border-t border-r border-white/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="absolute bottom-4 left-4 w-2 h-2 border-b border-l border-white/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="absolute bottom-4 right-4 w-2 h-2 border-b border-r border-white/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State: Database Retrieval Failure -->
        <div class="relative overflow-hidden rounded-[3rem] bg-zinc-950 border border-zinc-800 p-24 md:p-40 group text-center space-y-8">
            <!-- Background Grid -->
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808008_1px,transparent_1px),linear-gradient(to_bottom,#80808008_1px,transparent_1px)] bg-[size:32px_32px]"></div>
            
            <div class="relative z-10 flex flex-col items-center gap-6">
                <div class="w-20 h-20 rounded-[2rem] bg-zinc-900 border border-zinc-800 flex items-center justify-center text-zinc-700">
                    <flux:icon.star class="w-10 h-10 animate-pulse" />
                </div>
                
                <div class="space-y-2">
                    <h2 class="text-3xl md:text-5xl font-black text-white uppercase tracking-tight">Priority Pool Empty</h2>
                    <p class="text-zinc-500 font-mono text-xs max-w-sm mx-auto uppercase tracking-wide">
                        No high-frequency units detected in the priority archive. Synchronize curriculum selections to populate.
                    </p>
                </div>

                <flux:button href="{{ route('playlists.index') }}" variant="filled" size="base" class="!rounded-xl !px-10 !py-5 !font-black !text-[11px] !uppercase !tracking-widest !bg-zinc-900 !hover:bg-violet-600 !transition-all">
                    Browse Curriculum
                </flux:button>
            </div>

            <!-- Corner Accents -->
            <div class="absolute top-8 left-8 w-4 h-4 border-t border-l border-zinc-800"></div>
            <div class="absolute top-8 right-8 w-4 h-4 border-t border-r border-zinc-800"></div>
            <div class="absolute bottom-8 left-8 w-4 h-4 border-b border-l border-zinc-800"></div>
            <div class="absolute bottom-8 right-8 w-4 h-4 border-b border-r border-zinc-800"></div>
        </div>
    @endif
</div>
