<div class="glass-panel relative flex flex-col justify-between overflow-hidden rounded-3xl group hover:shadow-2xl hover:shadow-indigo-500/20 transition-all duration-700 p-8 shadow-xl border border-white/40 dark:border-white/10 bg-gradient-to-br from-white/90 to-white/50 dark:from-zinc-900/90 dark:to-zinc-900/50 backdrop-blur-2xl"
     x-data="{
         current: 0,
         target: @entangle('percentage'),
         animationId: null,
         init() {
            setTimeout(() => this.animateTo(this.target), 100);
            $watch('target', value => this.animateTo(value));
         },
         animateTo(val) {
            if(this.animationId) clearInterval(this.animationId);
            let start = this.current;
            let duration = 2000;
            let totalSteps = Math.round(duration / 16); 
            let currentStep = 0;
            
            this.animationId = setInterval(() => {
                currentStep++;
                let p = Math.min(currentStep / totalSteps, 1);
                let ease = 1 - Math.pow(1 - p, 4); // easeOutQuart
                this.current = Math.round(start + (val - start) * ease);
                
                if (p >= 1) {
                    this.current = val;
                    clearInterval(this.animationId);
                }
            }, 16);
         }
     }"
>
    <!-- Ambient glowing orbs -->
    <div class="absolute -right-24 -top-24 w-56 h-56 bg-gradient-to-br from-blue-400 to-indigo-500 opacity-20 blur-[60px] rounded-full group-hover:opacity-40 group-hover:scale-125 transition-all duration-1000"></div>
    <div class="absolute -left-24 -bottom-24 w-56 h-56 bg-gradient-to-tr from-purple-400 to-pink-500 opacity-20 blur-[60px] rounded-full group-hover:opacity-40 group-hover:scale-125 transition-all duration-1000"></div>
    
    <div class="relative z-10 w-full flex flex-col h-full space-y-8">
        
        {{-- Header & Select --}}
        <div class="flex items-center justify-between w-full">
            <div class="flex items-center space-x-3">
                <div class="w-1.5 h-6 rounded-full bg-gradient-to-b from-blue-500 to-indigo-500"></div>
                <h3 class="text-xs font-black tracking-widest uppercase text-slate-800 dark:text-zinc-100">Course Progress</h3>
            </div>
            
            <div class="relative w-44">
                <select wire:model.live="selectedCourseId" class="appearance-none w-full bg-white/30 dark:bg-zinc-800/40 text-slate-700 dark:text-zinc-200 text-sm font-bold tracking-wide rounded-full py-2 pl-4 pr-10 border border-slate-200/50 dark:border-white/10 focus:border-indigo-500/50 outline-none backdrop-blur-md shadow-sm transition-all duration-300 hover:bg-white/50 dark:hover:bg-zinc-700/50 cursor-pointer">
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" class="bg-white dark:bg-zinc-800 text-slate-800 dark:text-slate-200 py-2">{{ str($course->title)->limit(15) }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-600 dark:text-slate-400">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>
        </div>
        
        {{-- Circular Progress Display --}}
        <div class="flex flex-1 items-center justify-center relative py-2">
            <div class="relative w-40 h-40 flex items-center justify-center">
                <!-- Background Circle -->
                <svg class="absolute inset-0 w-full h-full transform -rotate-90 drop-shadow-xl" viewBox="0 0 100 100">
                    <!-- Subtle Track -->
                    <circle cx="50" cy="50" r="42" stroke="currentColor" stroke-width="3" fill="transparent" class="text-slate-200/60 dark:text-white/5" />
                    
                    <!-- Foreground Progress Circle with Gradient -->
                    <defs>
                        <linearGradient id="progressGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#3b82f6" /> <!-- blue-500 -->
                            <stop offset="100%" stop-color="#8b5cf6" /> <!-- violet-500 -->
                        </linearGradient>
                    </defs>
                    <circle cx="50" cy="50" r="42" stroke="url(#progressGradient)" stroke-width="7" fill="transparent"
                        stroke-dasharray="263.89"
                        :stroke-dashoffset="263.89 - (263.89 * target) / 100"
                        stroke-linecap="round"
                        class="transition-all duration-[2000ms] ease-out" 
                        style="filter: drop-shadow(0px 0px 6px rgba(99, 102, 241, 0.4));"
                    />
                </svg>
                
                {{-- Percentage Content --}}
                <div class="flex flex-col items-center justify-center z-10">
                    <span class="text-5xl font-black tracking-tighter text-slate-800 dark:text-white mt-1 drop-shadow-sm"><span x-text="current"></span><span class="text-2xl font-bold opacity-50 ml-0.5 tracking-normal">%</span></span>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="w-full text-center">
            <p class="text-[13px] font-semibold tracking-wide text-slate-500 dark:text-slate-400/80">
                Of Published Lessons Completed
            </p>
        </div>

    </div>
</div>