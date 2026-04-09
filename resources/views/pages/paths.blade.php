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

<div class="px-8 md:px-12 py-12 max-w-7xl mx-auto w-full space-y-20">
    <!-- Header Section: Route Briefing -->
    <div class="text-center md:text-left space-y-4">
        <div class="inline-flex items-center gap-3">
            <div class="px-2 py-0.5 rounded bg-violet-500/10 border border-violet-500/20">
                <span class="text-[10px] font-black text-violet-500 uppercase tracking-[0.2em]">Map Navigation</span>
            </div>
            <div class="flex items-center gap-1.5 text-[10px] font-bold text-zinc-500 uppercase tracking-widest">
                <span class="w-1.5 h-1.5 rounded-full bg-violet-500 animate-pulse shadow-[0_0_8px_rgba(139,92,246,0.5)]"></span>
                Route Cache // Active
            </div>
        </div>
        <h1 class="text-xl sm:text-4xl md:text-7xl font-black text-white tracking-tighter leading-tight uppercase break-words whitespace-normal">
            Choose Your <span class="text-violet-500">{{ __('Path') }}</span>
        </h1>
        <p class="text-zinc-500 font-mono text-sm max-w-2xl">
            Protocol: Multimodal Curriculum Integration. Select a specialized sector to initialize the learning sequence.
        </p>
    </div>

    <!-- Categories & Route Modules -->
    <div class="space-y-24">
        @php $catIndex = 1; @endphp
        @foreach($categorizedPaths as $category => $paths)
            <div class="space-y-8">
                <!-- Section Header -->
                <div class="flex items-center gap-6">
                    <div class="flex items-baseline gap-2">
                        <span class="text-[10px] font-mono text-zinc-600">SEC // {{ str_pad($catIndex++, 2, '0', STR_PAD_LEFT) }}</span>
                        <h2 class="text-2xl font-black text-white uppercase tracking-tight">{{ $category }}</h2>
                    </div>
                    <div class="h-px flex-1 bg-zinc-900 border-t border-zinc-950"></div>
                </div>

                <!-- Route Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($paths as $path)
                        <a href="{{ route('paths.show', $path->slug) }}" wire:navigate class="group relative block bg-zinc-950 border border-zinc-800 rounded-2xl p-8 transition-all duration-500 hover:border-violet-500/40 hover:shadow-[0_0_40px_-12px_rgba(139,92,246,0.3)] h-full flex flex-col">
                            
                            {{-- Unit Identity --}}
                            <div class="flex items-center justify-between mb-8">
                                <div class="w-12 h-12 rounded-xl bg-zinc-950 border border-zinc-800 flex items-center justify-center text-violet-500 group-hover:bg-violet-500/10 group-hover:border-violet-500/30 transition-all duration-500">
                                    <flux:icon.map class="w-6 h-6" />
                                </div>
                                <div class="text-right">
                                    <span class="block text-[8px] font-mono text-zinc-600 uppercase">SYS-{{ strtoupper(substr($path->slug, 0, 6)) }}</span>
                                    <span class="block text-[9px] font-black text-zinc-500 uppercase tracking-widest">Unit Deployment</span>
                                </div>
                            </div>
                            
                            <h3 class="text-2xl font-black text-white leading-tight tracking-tight group-hover:text-violet-400 transition-colors duration-300 uppercase mb-4">
                                {{ $path->title }}
                            </h3>
                            
                            <p class="text-zinc-500 text-sm font-medium leading-relaxed line-clamp-3 mb-8">
                                {{ $path->description }}
                            </p>

                            <div class="mt-auto pt-6 border-t border-zinc-900 flex items-center justify-between">
                                <div class="flex items-baseline gap-2">
                                     <span class="text-[10px] font-mono text-white tracking-widest">
                                        @if($path->playlists_count > 0 || $path->playlists->isNotEmpty())
                                            {{ str_pad($path->playlists->count(), 2, '0', STR_PAD_LEFT) }} UNITS
                                        @else
                                            OFFLINE
                                        @endif
                                    </span>
                                </div>
                                <div class="flex items-center gap-1.5 px-3 py-1 rounded bg-zinc-950 border border-zinc-800">
                                    <span class="text-[8px] font-black text-zinc-400 uppercase tracking-[0.2em]">Mastery Track</span>
                                </div>
                            </div>

                            <!-- Precision Hover Bracket -->
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-0.5 h-0 bg-violet-600 group-hover:h-12 transition-all duration-300"></div>
                            
                            <!-- Corner Brackets -->
                            <div class="absolute top-4 left-4 w-2 h-2 border-t border-l border-white/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="absolute top-4 right-4 w-2 h-2 border-t border-r border-white/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="absolute bottom-4 left-4 w-2 h-2 border-b border-l border-white/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="absolute bottom-4 right-4 w-2 h-2 border-b border-r border-white/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <!-- Deployment Request: Technical CTA -->
    <div class="mt-32 relative overflow-hidden rounded-[2.5rem] bg-zinc-950 border border-zinc-800 p-12 md:p-20 group">
        <!-- Background Grid -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808008_1px,transparent_1px),linear-gradient(to_bottom,#80808008_1px,transparent_1px)] bg-[size:32px_32px]"></div>
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-violet-500/5 rounded-full blur-[100px] pointer-events-none group-hover:bg-violet-500/10 transition-colors duration-1000"></div>

        <div class="relative z-10 flex flex-col items-center text-center space-y-8">
            <div class="w-16 h-16 rounded-2xl bg-zinc-950 border border-zinc-800 flex items-center justify-center text-zinc-600 shadow-inner group-hover:border-violet-500/30 transition-all duration-500">
                <flux:icon.question-mark-circle class="w-8 h-8" />
            </div>
            
            <div class="space-y-4">
                <h2 class="text-3xl md:text-5xl font-black text-white uppercase tracking-tight">Need a custom roadmap?</h2>
                <p class="text-zinc-500 font-mono text-sm max-w-xl mx-auto">
                    The deployment team is actively curating technology tracks. If you require a specialized roadmap, initialize a protocol request.
                </p>
            </div>

            <flux:button variant="filled" size="base" class="!rounded-xl !px-12 !py-6 !font-black !text-[11px] !uppercase !tracking-[0.3em] !bg-violet-600 !hover:bg-violet-500 !shadow-xl !shadow-violet-500/20">
                Request Deployment Protocol
            </flux:button>
        </div>

        <!-- Corner Accents -->
        <div class="absolute top-8 left-8 w-4 h-4 border-t border-l border-zinc-700"></div>
        <div class="absolute top-8 right-8 w-4 h-4 border-t border-r border-zinc-700"></div>
        <div class="absolute bottom-8 left-8 w-4 h-4 border-b border-l border-zinc-700"></div>
        <div class="absolute bottom-8 right-8 w-4 h-4 border-b border-r border-zinc-700"></div>
    </div>
</div>
