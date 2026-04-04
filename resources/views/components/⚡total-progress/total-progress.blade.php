<div class="glass-panel relative flex flex-col justify-between overflow-hidden rounded-2xl group hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-500 p-6 shadow-sm border border-slate-200/50 dark:border-white/5 bg-white/70 dark:bg-zinc-900/60 backdrop-blur-xl"
     x-data="{
         current: 0,
         target: @entangle('percentage'),
         init() {
            setTimeout(() => this.animateTo(this.target), 100);
            $watch('target', value => this.animateTo(value));
         },
         animateTo(val) {
            let start = this.current;
            let duration = 2500; // Slower duration
            let startTime = performance.now();
            let step = (currentTime) => {
                let p = Math.min((currentTime - startTime) / duration, 1);
                // easeOutCubic for a softer, slower stop
                let ease = 1 - Math.pow(1 - p, 3);
                this.current = Math.round(start + (val - start) * ease);
                if (p < 1) requestAnimationFrame(step);
            };
            requestAnimationFrame(step);
         }
     }"
>
    <div class="absolute -right-20 -top-20 w-40 h-40 bg-blue-500/20 blur-3xl rounded-full group-hover:scale-150 transition-transform duration-700"></div>
    <div class="absolute -left-20 -bottom-20 w-40 h-40 bg-indigo-500/20 blur-3xl rounded-full group-hover:scale-150 transition-transform duration-700"></div>
    
    <div class="relative z-10 w-full flex flex-col h-full space-y-6">
        
        {{-- Header & Select --}}
        <div class="flex items-center justify-between w-full">
            <h3 class="text-sm font-bold tracking-wider uppercase text-slate-500 dark:text-slate-400">Course Progress</h3>
            
            <div class="w-36 relative">
                <flux:select wire:model.live="selectedCourseId" size="sm" class="!bg-white/50 dark:!bg-zinc-800/50 border-0 focus:ring-2 focus:ring-blue-500/50 appearance-none">
                    @foreach($courses as $course)
                        <flux:select.option value="{{ $course->id }}">{{ str($course->title)->limit(15) }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
        </div>
        
        {{-- Circular Progress Display --}}
        <div class="flex flex-1 items-center justify-center relative">
            <div class="relative w-36 h-36 flex items-center justify-center">
                <!-- Background Circle -->
                <svg class="absolute inset-0 w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="42" stroke="currentColor" stroke-width="6" fill="transparent" class="text-slate-100 dark:text-white/5" />
                    <!-- Foreground Progress Circle -->
                    <circle cx="50" cy="50" r="42" stroke="currentColor" stroke-width="8" fill="transparent"
                        stroke-dasharray="263.89"
                        :stroke-dashoffset="263.89 - (263.89 * current) / 100"
                        stroke-linecap="round"
                        class="text-blue-500 dark:text-indigo-400" 
                    />
                </svg>
                
                {{-- Percentage Content --}}
                <div class="flex flex-col items-center justify-center animate-in fade-in zoom-in duration-500">
                    <span class="text-4xl font-black tracking-tighter text-slate-800 dark:text-white mt-1"><span x-text="current"></span><span class="text-lg opacity-60 ml-0.5">%</span></span>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="w-full text-center">
            <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                Of Published Lessons Completed
            </p>
        </div>

    </div>
</div>