<div class="p-6 md:p-10 max-w-6xl mx-auto w-full relative">
    <!-- Back Button -->
    <div class="mb-12">
        <flux:button variant="ghost" icon="arrow-left" href="{{ route('playlists.index') }}" wire:navigate>{{ __('Back to Playlists') }}</flux:button>
    </div>

    <!-- Playlist Hero (Centered Pixel Icon Style) -->
    <div class="relative pt-12 pb-16 mb-16 px-8 text-center group">

        <!-- Icon Container -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 z-20">
            <div class="relative w-32 h-32 rounded-full p-1 bg-gray-200 dark:bg-gray-700 border-8 border-gray-50 dark:border-gray-950 shadow-xl group-hover:border-violet-500/50 transition-all duration-500">
                <div class="w-full h-full rounded-full bg-gray-100 dark:bg-gray-800 overflow-hidden">
                    @if($playlist->thumbnail)
                        <img src="{{ str_starts_with($playlist->thumbnail, 'http') ? $playlist->thumbnail : asset('storage/' . $playlist->thumbnail) }}" class="w-full h-full object-cover rounded-full" alt="{{ $playlist->title }}" />
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-200 dark:bg-gray-700 rounded-full text-gray-500 dark:text-gray-400">
                            <flux:icon.academic-cap class="w-12 h-12 fill-current" />
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Hero Content -->
        <div class="bg-white dark:bg-gray-900 rounded-[3rem] border border-gray-200 dark:border-gray-800 p-12 pt-20 shadow-xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-violet-500/10 border border-violet-500/20 text-violet-600 dark:text-violet-400 text-[10px] font-bold uppercase tracking-widest mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-violet-500 shadow-[0_0_5px_rgba(139,92,246,0.5)]"></span>
                {{ __('Playlist Overview') }}
            </div>
            
            <h1 class="text-4xl md:text-6xl font-black text-slate-900 dark:text-white tracking-tight mb-4">{{ $playlist->title }}</h1>
            
            @php
                $levelColor = match(strtolower($playlist->level ?? 'beginner')) {
                    'beginner' => 'text-emerald-600 dark:text-emerald-400',
                    'intermediate' => 'text-amber-600 dark:text-amber-400',
                    'hard' => 'text-rose-600 dark:text-rose-400',
                    default => 'text-emerald-600 dark:text-emerald-400',
                };
            @endphp
            <div class="flex flex-wrap justify-center items-center gap-x-8 gap-y-4 text-sm font-medium">
                <span class="flex items-center gap-2 text-gray-500 dark:text-gray-400">{{ __('With') }} <span class="text-gray-900 dark:text-gray-200 underline decoration-violet-500/30">{{ $playlist->author_name ?? 'Team Ferga' }}</span></span>
                <span class="w-1 h-1 rounded-full bg-gray-300 dark:bg-gray-700 hidden md:block"></span>
                <span class="flex items-center gap-2 {{ $levelColor }}"><flux:icon.chart-bar class="w-4 h-4" /> {{ __($playlist->level ?? 'Beginner') }}</span>
                <span class="w-1 h-1 rounded-full bg-gray-300 dark:bg-gray-700 hidden md:block"></span>
                <span class="flex items-center gap-2 text-blue-600 dark:text-blue-400"><flux:icon.tag class="w-4 h-4" /> {{ __($playlist->category ?? 'General') }}</span>
            </div>

            @if($playlist->description)
                <p class="text-slate-600 dark:text-gray-400 text-lg max-w-3xl mx-auto mt-8 leading-relaxed font-medium">{{ $playlist->description }}</p>
            @endif

            <!-- Progress Summary -->
            @php
                $totalLessons = $sections->sum(fn($s) => $s->lessons->count());
                $done = count($completedLessonIds);
                $progressPct = $totalLessons > 0 ? min(100, (int) round(($done / $totalLessons) * 100)) : 0;
            @endphp
            <div class="mt-12 flex flex-col items-center gap-4">
                <div class="flex items-center justify-between w-full max-w-md mb-1">
                    <span class="text-xs font-bold text-violet-600/70 dark:text-violet-400/60 uppercase tracking-widest">{{ __('Platform Progress') }}</span>
                    <span class="text-xs font-bold text-violet-600 dark:text-violet-400 bg-violet-500/10 dark:bg-violet-500/20 px-2.3 py-0.5 rounded-full">{{ $progressPct }}%</span>
                </div>
                <div class="w-full max-w-md h-3 rounded-full bg-gray-100 dark:bg-gray-800 p-0.5 overflow-hidden border border-gray-200 dark:border-gray-700 shadow-inner">
                    <div class="h-full rounded-full bg-violet-600 transition-all duration-1000 shadow-[0_0_10px_rgba(139,92,246,0.2)]" style="width: {{ $progressPct }}%"></div>
                </div>
                <div class="flex items-center gap-6 mt-2">
                    <div class="flex items-center gap-2 text-xs font-bold text-violet-600/70 dark:text-violet-400/60">
                        <flux:icon.list-bullet class="w-4 h-4 text-violet-600/50 dark:text-violet-400/40" />
                        {{ $sections->count() }} {{ __('SECTIONS') }}
                    </div>
                    <div class="flex items-center gap-2 text-xs font-bold text-violet-600/70 dark:text-violet-400/60">
                        <flux:icon.play class="w-4 h-4 text-violet-600/50 dark:text-violet-400/40" />
                        {{ $totalLessons }} {{ __('LESSONS') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Sections -->
    <div class="space-y-10">
        @forelse($sections as $section)
            <div class="bg-white dark:bg-gray-900/50 rounded-[2.5rem] border border-gray-200 dark:border-gray-800 overflow-hidden shadow-lg dark:shadow-2xl transition-all duration-500 hover:border-violet-500/20">
                <!-- Section Header -->
                <div class="px-8 py-5 bg-gray-50/50 dark:bg-white/[0.02] border-b border-gray-100 dark:border-gray-800 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-violet-500/10 border border-violet-500/20 flex items-center justify-center text-violet-600 dark:text-violet-400 shadow-sm">
                        <flux:icon.folder class="w-5 h-5 fill-current opacity-80" />
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">{{ $section->title }}</h2>
                        <p class="text-[10px] font-bold text-violet-600 dark:text-violet-400 uppercase tracking-widest mt-0.5 opacity-70">
                            {{ $section->lessons->count() }} {{ __(Str::plural('video', $section->lessons->count())) }}
                        </p>
                    </div>
                </div>

                <!-- Lessons List -->
                <div class="divide-y divide-slate-100 dark:divide-white/5">
                    @forelse($section->lessons as $i => $lesson)
                        @php $isDone = in_array($lesson->id, $completedLessonIds); @endphp
                        <div class="group flex items-center gap-6 px-8 py-5 {{ $isDone ? 'bg-emerald-500/[0.03] dark:bg-emerald-500/5' : 'hover:bg-slate-50 dark:hover:bg-white/5' }} transition-all duration-300">
                            <!-- Index / Done Indicator -->
                            <div class="shrink-0">
                                @if($isDone)
                                    <div class="w-10 h-10 rounded-full bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 shadow-[0_0_15px_rgba(16,185,129,0.1)]">
                                        <flux:icon.check class="w-5 h-5 stroke-[3]" />
                                    </div>
                                @else
                                    <div class="w-10 h-10 rounded-xl bg-gray-100/50 dark:bg-gray-800/50 border border-gray-200/50 dark:border-gray-700/50 flex items-center justify-center text-sm font-black text-gray-400 dark:text-gray-500 group-hover:text-violet-600 dark:group-hover:text-violet-400 group-hover:border-violet-500/30 transition-all duration-300">
                                        {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                                    </div>
                                @endif
                            </div>

                            <!-- Lesson Info -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-1">
                                    <h4 @class(['font-bold text-lg leading-tight truncate transition-colors duration-300', 'text-slate-400 line-through decoration-emerald-500/50' => $isDone, 'text-slate-800 dark:text-white group-hover:text-violet-600 dark:group-hover:text-violet-400' => !$isDone])>
                                        {{ $lesson->title }}
                                    </h4>
                                    @if($lesson->is_preview)
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-md bg-violet-500/10 text-[9px] font-black text-violet-600 dark:text-violet-500 uppercase tracking-widest border border-violet-500/20">Free</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-4">
                                    @if($isDone)
                                        <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-500 uppercase tracking-widest flex items-center gap-1">
                                            <flux:icon.sparkles class="w-3 h-3" />
                                            {{ __('Completed') }} · +5 XP
                                        </span>
                                    @else
                                        <span class="text-[10px] font-bold text-violet-600/80 dark:text-violet-400/70 uppercase tracking-widest">{{ __('Lesson Content') }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Desktop Actions -->
                            <div class="hidden md:flex items-center gap-3 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-2 group-hover:translate-x-0">
                                @auth
                                    <livewire:courses.star-lesson :lesson="$lesson" :key="'star-lesson-'.$lesson->id" />
                                    
                                    @if($lesson->video_url)
                                        <a href="{{ $lesson->video_url }}" target="_blank">
                                            <flux:button size="sm" variant="ghost" icon="play" class="text-violet-600 dark:text-violet-400">{{ __('Watch Vid') }}</flux:button>
                                        </a>
                                    @endif
                                    
                                    @if(! $isDone)
                                        <button wire:click="completeLesson({{ $lesson->id }})" class="h-9 px-4 rounded-xl text-xs font-black bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 hover:bg-emerald-500 hover:text-white transition-all duration-200">
                                            {{ __('Complete') }}
                                        </button>
                                    @endif
                                @else
                                    <flux:button size="sm" variant="ghost" icon="lock-closed" @click="alert('Please login first')" class="text-gray-400">{{ __('Watch Vid') }}</flux:button>
                                    <flux:button size="sm" variant="ghost" icon="star" @click="alert('Please login first')" class="text-gray-400" />
                                @endauth
                            </div>

                            <!-- Right Arrow (Mobile Only / Indicator) -->
                            <div class="md:hidden">
                                <flux:icon.chevron-right class="w-5 h-5 text-slate-300 dark:text-gray-600 group-hover:text-violet-600 dark:group-hover:text-violet-500 transition-colors" />
                            </div>
                        </div>
                    @empty
                        <div class="px-8 py-10 text-center text-sm text-slate-400 italic">{{ __('No videos in this section yet.') }}</div>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="text-center py-20 rounded-[3rem] border border-dashed border-slate-200 dark:border-white/5 bg-slate-50 dark:bg-white/5">
                <p class="text-slate-400 dark:text-gray-500 font-medium tracking-wide">{{ __('Seeking content... check back soon!') }}</p>
            </div>
        @endforelse
    </div>

    <!-- Related Courses - Interaction Hub -->
    @if($playlist->courses->isNotEmpty())
        <div class="mt-24 space-y-16">
            <div class="relative py-8">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-slate-200 dark:border-white/5"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-6 bg-white dark:bg-[#050B14] text-xs font-black text-blue-600/60 dark:text-blue-400/40 uppercase tracking-[0.3em]">{{ __('Masterclass Discussion') }}</span>
                </div>
            </div>
            
            @foreach($playlist->courses as $course)
                <div class="bg-white dark:bg-gray-900 rounded-[3rem] p-10 shadow-xl border border-gray-200 dark:border-gray-800 group transition-all duration-500 hover:border-violet-500/20">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 mb-10 pb-8 border-b border-gray-100 dark:border-gray-800">
                        <div class="max-w-2xl">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-600 dark:text-blue-400 text-[10px] font-black uppercase tracking-widest mb-4">
                                {{ __('Deep Dive Module') }}
                            </div>
                            <h3 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight leading-tight group-hover:text-violet-600 dark:group-hover:text-violet-400 transition-colors">{{ $course->title }}</h3>
                            <p class="text-slate-600 dark:text-gray-400 text-base mt-2 font-medium leading-relaxed">{{ $course->description }}</p>
                        </div>
                        <div class="flex items-center gap-4">
                            @auth
                                <livewire:courses.star-course :course="$course" :key="'star-'.$course->id" />
                            @else
                                <flux:button size="sm" variant="subtle" icon="star" @click="alert('Please login first')" />
                            @endauth
                            <div class="h-10 px-4 bg-blue-500/5 dark:bg-blue-500/10 flex items-center justify-center rounded-2xl border border-blue-500/20 text-xs font-bold text-blue-600 dark:text-blue-400">
                                {{ $course->comments->count() }} {{ __('Shared Thoughts') }}
                            </div>
                        </div>
                    </div>

                    <livewire:courses.course-comments :course="$course" :key="'comments-'.$course->id" />
                </div>
            @endforeach
        </div>
    @endif
</div>
