@if($lesson && $course)
<div class="relative w-full overflow-hidden rounded-3xl group shadow-xl border border-white/40 dark:border-white/10 bg-white/60 dark:bg-zinc-900/60 backdrop-blur-2xl transition-all duration-500 hover:shadow-indigo-500/20">
    
    <!-- Background abstract image / gradients -->
    <div class="absolute inset-0 z-0 overflow-hidden rounded-3xl">
        @if($course->thumbnail)
            <img src="{{ $course->thumbnail }}" class="w-full h-full object-cover opacity-10 dark:opacity-[0.03] blur-sm group-hover:blur-md transition-all duration-700" alt="Course Background">
        @else
            <div class="absolute -right-20 -top-20 w-96 h-96 bg-gradient-to-br from-indigo-500 to-purple-600 opacity-20 dark:opacity-10 blur-[100px] rounded-full group-hover:opacity-30 group-hover:scale-110 transition-all duration-1000"></div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-r from-white/95 via-white/80 to-transparent dark:from-zinc-900/95 dark:via-zinc-900/80 dark:to-transparent"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 flex flex-col md:flex-row items-center justify-between p-8 md:p-10 w-full gap-8">
        
        <div class="flex items-center gap-8 w-full md:w-2/3">
            <!-- Icon/Artwork -->
            <div class="flex-shrink-0 w-20 h-20 md:w-24 md:h-24 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 shadow-lg shadow-indigo-500/30 flex items-center justify-center text-white rotate-3 group-hover:rotate-0 group-hover:scale-105 transition-all duration-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 md:h-12 md:w-12 drop-shadow-md" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            
            <!-- Text content -->
            <div class="flex flex-col space-y-2">
                <div class="inline-flex items-center space-x-3">
                    <span class="px-3.5 py-1 rounded-full bg-indigo-100 dark:bg-indigo-500/20 text-indigo-700 dark:text-indigo-300 text-[10px] font-black uppercase tracking-widest border border-indigo-200 dark:border-indigo-500/30 shadow-sm">Up Next</span>
                    <span class="text-sm font-bold text-slate-500 dark:text-slate-400 tracking-wider uppercase">{{ $course->title }}</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-black text-slate-800 dark:text-white tracking-tight drop-shadow-sm group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-300 mt-1">
                    {{ $lesson->title }}
                </h2>
            </div>
        </div>

        <!-- Action Button -->
        <div class="flex-shrink-0 flex items-center justify-end w-full md:w-auto mt-4 md:mt-0">
            <a href="#" class="relative group/btn inline-flex items-center justify-center px-10 py-4 font-black text-white transition-all duration-300 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full hover:shadow-xl hover:shadow-indigo-500/40 focus:outline-none focus:ring-4 focus:ring-indigo-500/50">
                <span class="absolute inset-0 w-full h-full rounded-full transition-all duration-500 ease-out opacity-0 bg-gradient-to-r from-purple-600 to-indigo-500 group-hover/btn:opacity-100"></span>
                <span class="relative flex items-center gap-3">
                    <span class="tracking-widest uppercase text-sm">Resume</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transform group-hover/btn:translate-x-1.5 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </span>
            </a>
        </div>
        
    </div>
</div>
@else
<div class="glass-panel relative w-full overflow-hidden rounded-3xl flex items-center justify-center p-12 bg-white/50 dark:bg-zinc-900/50 backdrop-blur-xl border border-white/20 dark:border-white/10 shadow-lg">
    <div class="text-center space-y-4">
        <div class="w-16 h-16 bg-slate-200 dark:bg-zinc-800 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400 dark:text-slate-500 shadow-inner">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h2 class="text-xl font-black text-slate-700 dark:text-slate-200 tracking-tight">You're all caught up!</h2>
        <p class="text-sm font-semibold tracking-wide text-slate-500 dark:text-slate-400">Head over to the catalog to start a new course.</p>
    </div>
</div>
@endif