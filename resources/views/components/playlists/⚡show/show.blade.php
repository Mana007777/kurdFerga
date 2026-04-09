<div class="p-6 md:p-10 max-w-6xl mx-auto w-full relative">
    <!-- Back Button -->
    <div class="mb-12">
        <flux:button variant="ghost" icon="arrow-left" href="{{ route('playlists.index') }}" wire:navigate class="!text-zinc-500 hover:!text-white">{{ __('Back to Playlists') }}</flux:button>
    </div>

    <!-- Playlist Hero (Centered Pixel Icon Style) -->
    <div class="relative pt-12 pb-16 mb-16 px-8 text-center group">

        <!-- Icon Container -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 z-20">
            <div class="relative w-32 h-32 rounded-full p-1 bg-zinc-900 border-8 border-zinc-950 shadow-2xl group-hover:border-violet-500/50 transition-all duration-500">
                <div class="w-full h-full rounded-full bg-zinc-950 overflow-hidden flex items-center justify-center border border-zinc-800">
                    @if($playlist->thumbnail)
                        <img src="{{ str_starts_with($playlist->thumbnail, 'http') ? $playlist->thumbnail : asset('storage/' . $playlist->thumbnail) }}" class="w-full h-full object-cover rounded-full" alt="{{ $playlist->title }}" />
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-zinc-900 rounded-full text-zinc-600">
                            <flux:icon.academic-cap class="w-12 h-12 fill-current" />
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Hero Content -->
        <div class="bg-zinc-900/40 backdrop-blur-sm rounded-[3rem] border border-zinc-800 p-12 pt-20 shadow-[-20px_0_80px_-20px_rgba(0,0,0,0.5)]">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-violet-500/10 border border-violet-500/20 text-violet-400 text-[10px] font-bold uppercase tracking-widest mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-violet-500 shadow-[0_0_8px_rgba(139,92,246,0.6)]"></span>
                {{ __('Playlist Overview') }}
            </div>
            
            <h1 class="text-4xl md:text-7xl font-black text-white tracking-tighter mb-4 uppercase">{{ $playlist->title }}</h1>
            
            @php
                $levelColor = match(strtolower($playlist->level ?? 'beginner')) {
                    'beginner' => 'text-emerald-400',
                    'intermediate' => 'text-amber-400',
                    'hard' => 'text-rose-400',
                    default => 'text-emerald-400',
                };
            @endphp
            <div class="flex flex-wrap justify-center items-center gap-x-8 gap-y-4 text-xs font-black uppercase tracking-widest text-zinc-500">
                <span class="flex items-center gap-2">{{ __('With') }} <span class="text-zinc-200 underline decoration-violet-500/30">{{ $playlist->author_name ?? 'Team Ferga' }}</span></span>
                <span class="w-1 h-1 rounded-full bg-zinc-800 hidden md:block"></span>
                <span class="flex items-center gap-2 {{ $levelColor }} font-black"><flux:icon.chart-bar class="w-4 h-4" /> {{ __($playlist->level ?? 'Beginner') }}</span>
                <span class="w-1 h-1 rounded-full bg-zinc-800 hidden md:block"></span>
                <span class="flex items-center gap-2 text-blue-400 font-black"><flux:icon.tag class="w-4 h-4" /> {{ __($playlist->category ?? 'General') }}</span>
            </div>

            @if($playlist->description)
                <p class="text-zinc-400 text-sm md:text-base max-w-3xl mx-auto mt-8 leading-relaxed font-mono uppercase tracking-tight">{{ $playlist->description }}</p>
            @endif

            <!-- Progress Summary -->
            @php
                $totalLessons = $sections->sum(fn($s) => $s->lessons->count());
                $done = count($completedLessonIds);
                $progressPct = $totalLessons > 0 ? min(100, (int) round(($done / $totalLessons) * 100)) : 0;
            @endphp
            <div class="mt-12 flex flex-col items-center gap-4">
                <div class="flex items-center justify-between w-full max-w-md mb-1">
                    <span class="text-[10px] font-black text-zinc-500 uppercase tracking-widest">{{ __('Platform Progress') }}</span>
                    <span class="text-[10px] font-black text-violet-400 bg-violet-500/10 px-2.5 py-0.5 rounded-full border border-violet-500/20">{{ $progressPct }}%</span>
                </div>
                <div class="w-full max-w-md h-2 rounded-full bg-zinc-950 p-0.5 overflow-hidden border border-zinc-800 shadow-inner">
                    <div class="h-full rounded-full bg-violet-600 transition-all duration-1000 shadow-[0_0_15px_rgba(139,92,246,0.4)]" style="width: {{ $progressPct }}%"></div>
                </div>
                <div class="flex items-center gap-6 mt-2">
                    <div class="flex items-center gap-2 text-[10px] font-black text-zinc-600 uppercase tracking-widest">
                        <flux:icon.list-bullet class="w-4 h-4 text-zinc-700" />
                        {{ $sections->count() }} {{ __('SECTIONS') }}
                    </div>
                    <div class="flex items-center gap-2 text-[10px] font-black text-zinc-600 uppercase tracking-widest">
                        <flux:icon.play class="w-4 h-4 text-zinc-700" />
                        {{ $totalLessons }} {{ __('LESSONS') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Sections -->
    <div class="space-y-12">
        @forelse($sections as $section)
            <div class="bg-zinc-900/40 backdrop-blur-sm rounded-[2.5rem] border border-zinc-800 overflow-hidden shadow-2xl transition-all duration-500 hover:border-violet-500/20">
                <!-- Section Header -->
                <div class="px-8 py-6 bg-zinc-900/50 border-b border-zinc-800 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-zinc-950 border border-zinc-800 flex items-center justify-center text-violet-500 shadow-sm">
                        <flux:icon.folder class="w-5 h-5 fill-current opacity-80" />
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-white tracking-tighter uppercase">{{ $section->title }}</h2>
                        <p class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mt-0.5">
                            {{ $section->lessons->count() }} {{ __(Str::plural('video', $section->lessons->count())) }}
                        </p>
                    </div>
                </div>

                <!-- Lessons List -->
                <div class="divide-y divide-zinc-800/50">
                    @forelse($section->lessons as $i => $lesson)
                        @php $isDone = in_array($lesson->id, $completedLessonIds); @endphp
                        
                        <flux:modal.trigger name="video-modal">
                            <div class="flex items-center justify-between p-6 cursor-pointer group {{ $isDone ? 'bg-emerald-500/[0.02]' : 'hover:bg-zinc-800/40' }}" wire:click="openLesson({{ $lesson->id }})">
                                <!-- Lesson Identity -->
                                <div class="flex items-center gap-5 flex-1 min-w-0">
                                    <div class="relative">
                                        @if($isDone)
                                            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-500 shadow-[0_0_15px_rgba(16,185,129,0.2)]">
                                                <flux:icon.check class="w-5 h-5" />
                                            </div>
                                        @else
                                            <div class="w-10 h-10 rounded-xl bg-zinc-950 border border-zinc-800 flex items-center justify-center text-[10px] font-black text-zinc-600 group-hover:text-violet-400 group-hover:border-violet-500/30 transition-all duration-300">
                                                {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Lesson Info -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-3 mb-1">
                                            <h4 @class(['font-black text-lg tracking-tight truncate transition-colors duration-300 uppercase', 'text-zinc-600 line-through decoration-emerald-500/50' => $isDone, 'text-white group-hover:text-violet-400' => !$isDone])>
                                                {{ $lesson->title }}
                                            </h4>
                                            @if($lesson->is_preview)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-violet-500/10 text-[9px] font-black text-violet-500 uppercase tracking-widest border border-violet-500/20">Free</span>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-4">
                                            @if($isDone)
                                                @php
                                                    $duration = $lesson->duration_seconds > 0 ? $lesson->duration_seconds : 1;
                                                    $watched = $lessonProgress[$lesson->id] ?? 0;
                                                    $earnedXP = (int) floor(($watched / $duration) * 5);
                                                @endphp
                                                
                                                @if($earnedXP > 0)
                                                    <span class="text-[10px] font-black text-emerald-500 uppercase tracking-widest flex items-center gap-1">
                                                        <flux:icon.sparkles class="w-3 h-3" />
                                                        {{ __('Completed') }} · +{{ $earnedXP }} XP
                                                    </span>
                                                @else
                                                    <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest flex items-center gap-1">
                                                        <flux:icon.exclamation-triangle class="w-3 h-3" />
                                                        {{ __('Completed') }} · +0 XP ({{ __('please watch the videos to get XP') }})
                                                    </span>
                                                @endif
                                            @elseif(($lessonProgress[$lesson->id] ?? 0) > 0)
                                                @php
                                                    $duration = $lesson->duration_seconds > 0 ? $lesson->duration_seconds : 1;
                                                    $percent = (int) floor(($lessonProgress[$lesson->id] / $duration) * 100);
                                                    $currentXP = (int) floor(($lessonProgress[$lesson->id] / $duration) * 5);
                                                @endphp
                                                <span class="text-[10px] font-black text-violet-400 uppercase tracking-widest flex items-center gap-1">
                                                    <flux:icon.bolt class="w-3 h-3" />
                                                    {{ __('Progress') }} {{ $percent }}% · +{{ $currentXP }} XP
                                                </span>
                                            @else
                                                <span class="text-[10px] font-black text-zinc-500 uppercase tracking-widest">{{ __('Instructional Content') }} // {{ str_pad($i + 1, 3, '0', STR_PAD_LEFT) }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Desktop Actions -->
                                    <div class="hidden md:flex items-center gap-3 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-2 group-hover:translate-x-0" @click.stop>
                                        @auth
                                            <livewire:courses.star-lesson :lesson="$lesson" :key="'star-lesson-'.$lesson->id" />
                                            
                                            @if($lesson->video_url)
                                                <flux:modal.trigger name="video-modal">
                                                    <flux:button size="sm" variant="ghost" icon="play" wire:click="openLesson({{ $lesson->id }})" class="!text-violet-400 hover:!text-white">{{ __('Watch') }}</flux:button>
                                                </flux:modal.trigger>
                                            @endif
                                            
                                            @if(! $isDone)
                                                <button wire:click="completeLesson({{ $lesson->id }})" class="h-9 px-5 rounded-xl text-[10px] font-black uppercase tracking-widest bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 hover:bg-emerald-500 hover:text-white transition-all duration-200 shadow-[0_4px_12px_rgba(16,185,129,0.1)]">
                                                    {{ __('Complete') }}
                                                </button>
                                            @endif
                                        @else
                                            <flux:button size="sm" variant="ghost" icon="lock-closed" @click="alert('Please login first')" class="text-zinc-600">{{ __('Watch') }}</flux:button>
                                            <flux:button size="sm" variant="ghost" icon="star" @click="alert('Please login first')" class="text-zinc-600" />
                                        @endauth
                                    </div>

                                    <!-- Right Arrow (Mobile Only / Indicator) -->
                                    <div class="md:hidden">
                                        <flux:icon.chevron-right class="w-5 h-5 text-zinc-700 group-hover:text-violet-500 transition-colors" />
                                    </div>
                                </div>
                            </div>
                        </flux:modal.trigger>

                        <!-- Mini Progress Bar -->
                        @if(!$isDone && isset($lessonProgress[$lesson->id]) && $lesson->duration_seconds > 0)
                            <div class="px-8 pb-4">
                                <div class="w-full h-1 bg-zinc-900 rounded-full overflow-hidden">
                                    <div class="bg-violet-500 h-full transition-all duration-500" style="width: {{ ($lessonProgress[$lesson->id] / $lesson->duration_seconds) * 100 }}%"></div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="px-8 py-12 text-center text-xs font-black text-zinc-600 uppercase tracking-widest italic">{{ __('No personnel files found in this section.') }}</div>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="text-center py-24 rounded-[3rem] border-2 border-dashed border-zinc-800 bg-zinc-900/20">
                <flux:icon.magnifying-glass class="w-12 h-12 text-zinc-800 mx-auto mb-6" />
                <p class="text-zinc-600 font-black text-[10px] uppercase tracking-[0.3em]">{{ __('Awaiting Content Deployment...') }}</p>
            </div>
        @endforelse
    </div>

    <!-- Related Courses - Interaction Hub -->
    @if($playlist->courses->isNotEmpty())
        <div class="mt-32 space-y-16">
            <div class="relative py-8">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-zinc-800"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-8 bg-zinc-950 text-[10px] font-black text-blue-400 uppercase tracking-[0.4em]">{{ __('Module Deep Dive') }}</span>
                </div>
            </div>
            
            @foreach($playlist->courses as $course)
                <div class="bg-zinc-900/40 backdrop-blur-sm rounded-[3rem] p-12 shadow-2xl border border-zinc-800 group transition-all duration-500 hover:border-violet-500/20">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-10 mb-12 pb-10 border-b border-zinc-800">
                        <div class="max-w-2xl">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[10px] font-black uppercase tracking-widest mb-6">
                                <span class="w-1 h-1 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.6)]"></span>
                                {{ __('Technical Module') }}
                            </div>
                            <h3 class="text-3xl md:text-5xl font-black text-white tracking-tighter uppercase leading-none group-hover:text-violet-400 transition-colors">{{ $course->title }}</h3>
                            <p class="text-zinc-500 text-sm md:text-base mt-4 font-mono uppercase tracking-tight leading-relaxed line-clamp-2">{{ $course->description }}</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-4">
                            @auth
                                <livewire:courses.star-course :course="$course" :key="'star-'.$course->id" />
                            @else
                                <flux:button size="sm" variant="subtle" icon="star" @click="alert('Please login first')" class="text-zinc-600" />
                            @endauth
                            <div class="h-10 px-6 bg-zinc-950 flex items-center justify-center rounded-2xl border border-zinc-800 text-[10px] font-black text-blue-400 uppercase tracking-widest">
                                {{ $course->comments->count() }} {{ __('Intel Logs') }}
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="absolute -left-12 top-0 bottom-0 w-1 bg-gradient-to-b from-blue-500/50 to-transparent rounded-full opacity-0 group-hover:opacity-100 transition-all"></div>
                        <livewire:courses.course-comments :course="$course" :key="'comments-'.$course->id" />
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Video Signal Modal -->
    <flux:modal name="video-modal" 
                class="!bg-zinc-950 !border-zinc-800 rounded-[3rem] p-0 w-full max-w-5xl overflow-hidden" 
                x-data="{ 
                    lastBoundTime: 0,
                    trackClosing() {
                        if (this.lastBoundTime > 0) {
                            $wire.updateProgress($wire.activeLesson.id, Math.floor(this.lastBoundTime));
                        }
                    }
                }"
                @close="if($wire.activeLesson) { trackClosing(); } $wire.set('activeLesson', null)">
        @if($activeLesson)
                @php 
                    $watched = ($activeLesson && $activeLesson->pivot) ? $activeLesson->pivot->watched_seconds : 0;
                @endphp
                <div class="relative w-full aspect-video bg-black group" 
                     x-data="{ 
                        lastPing: {{ $watched }},
                        currentTime: {{ $watched }},
                        duration: {{ $activeLesson->duration_seconds > 0 ? $activeLesson->duration_seconds : 1 }},
                        formatTime(seconds) {
                            if (isNaN(seconds)) return '00:00';
                            const m = Math.floor(seconds / 60);
                            const s = Math.floor(seconds % 60);
                            return m.toString().padStart(2, '0') + ':' + s.toString().padStart(2, '0');
                        },
                        track(el) {
                            this.currentTime = el.currentTime;
                            $data.lastBoundTime = el.currentTime;
                            const now = el.currentTime;
                            if (now - this.lastPing >= 5 || el.ended) {
                                this.lastPing = now;
                                $wire.updateProgress({{ $activeLesson->id }}, Math.floor(now));
                            }
                        }
                     }"
                     x-init="$data.lastBoundTime = {{ $watched }}">
                    <video 
                        src="{{ $activeLesson->video_url }}#t={{ $watched }}" 
                        class="w-full h-full" 
                        controls 
                        autoplay
                        x-on:timeupdate="track($el)"
                        x-on:ended="track($el)"
                    ></video>

                    <!-- Modal Header Overlay -->
                    <div class="absolute top-0 left-0 right-0 p-8 flex justify-between items-start pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="bg-zinc-950/80 backdrop-blur-md px-6 py-4 rounded-3xl border border-zinc-800 flex items-center gap-6 shadow-2xl pointer-events-auto">
                            <div class="space-y-1">
                                <h3 class="text-white font-black uppercase tracking-tight text-sm">{{ $activeLesson->title }}</h3>
                                <div class="flex items-center gap-4 text-[10px] font-mono font-black uppercase tracking-widest text-zinc-500">
                                    <span class="flex items-center gap-1.5"><flux:icon.clock class="w-3 h-3" /> <span x-text="formatTime(currentTime)"></span> / <span x-text="formatTime(duration)"></span></span>
                                    <span class="w-1 h-1 rounded-full bg-zinc-800"></span>
                                    <span class="text-violet-400" x-text="Math.floor((currentTime / duration) * 100) + '%'"></span>
                                </div>
                            </div>
                            <div class="h-8 w-px bg-zinc-800"></div>
                            <div class="text-center">
                                <div class="text-[9px] font-black text-zinc-500 uppercase tracking-widest mb-0.5">{{ __('Points Earned') }}</div>
                                <div class="text-lg font-black text-emerald-500 tracking-tighter" x-text="'+' + Math.floor((currentTime / duration) * 5) + ' XP'"></div>
                            </div>
                        </div>
                        <flux:modal.close class="pointer-events-auto">
                            <flux:button variant="ghost" icon="x-mark" class="!bg-zinc-950/80 !backdrop-blur-md !border-zinc-800 !text-white !rounded-2xl" />
                        </flux:modal.close>
                    </div>

                    <!-- Bottom Progress Bar Overlay -->
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-zinc-900 pointer-events-none">
                        <div class="h-full bg-violet-600 shadow-[0_0_15px_rgba(139,92,246,0.5)] transition-all duration-300" x-bind:style="'width: ' + (currentTime / duration * 100) + '%'"></div>
                    </div>
                </div>
        @endif
    </flux:modal>
