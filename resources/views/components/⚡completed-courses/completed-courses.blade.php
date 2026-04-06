<div class="glass-panel relative flex flex-col justify-between overflow-hidden rounded-3xl group hover:shadow-2xl hover:shadow-purple-500/20 transition-all duration-700 p-8 shadow-xl border border-white/40 dark:border-white/10 bg-gradient-to-br from-white/90 to-white/50 dark:from-zinc-900/90 dark:to-zinc-900/50 backdrop-blur-2xl h-full"
     x-data="{
         current: 0,
         target: @entangle('completedCoursesCount'),
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
                let ease = 1 - Math.pow(1 - p, 4); 
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
    <div class="absolute -right-24 -top-24 w-56 h-56 bg-gradient-to-bl from-purple-400 to-indigo-500 opacity-20 blur-[60px] rounded-full group-hover:opacity-40 group-hover:scale-125 transition-all duration-1000"></div>
    <div class="absolute -left-24 -bottom-24 w-56 h-56 bg-gradient-to-tr from-violet-400 to-fuchsia-500 opacity-20 blur-[60px] rounded-full group-hover:opacity-40 group-hover:scale-125 transition-all duration-1000"></div>
    
    <div class="relative z-10 w-full flex flex-col h-full space-y-8">
        
        {{-- Header --}}
        <div class="flex items-center justify-between w-full">
            <div class="flex items-center space-x-3">
                <div class="w-1.5 h-6 rounded-full bg-gradient-to-b from-purple-500 to-indigo-500"></div>
                <h3 class="text-xs font-black tracking-widest uppercase text-slate-800 dark:text-zinc-100">Milestones</h3>
            </div>
            
            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-zinc-800/40 text-indigo-500 dark:text-indigo-400 shadow-inner backdrop-blur-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 15V3m0 12l-4-4m4 4l4-4M2 17l.621 2.485A2 2 0 0 0 4.561 21h14.878a2 2 0 0 0 1.94-1.515L22 17"></path>
                </svg>
            </div>
        </div>
        
        {{-- Stats Display --}}
        <div class="flex flex-1 items-center justify-center place-content-center relative py-6">
            <div class="flex flex-col items-center justify-center animate-in fade-in zoom-in duration-500">
                <h2 class="text-7xl font-black tracking-tighter text-transparent bg-clip-text bg-gradient-to-br from-slate-800 to-slate-500 dark:from-white dark:to-slate-300 drop-shadow-sm">
                    <span x-text="current"></span>
                </h2>
                <div class="mt-4 px-4 py-1.5 rounded-full bg-green-500/10 text-green-600 dark:text-green-400 border border-green-500/20 text-xs font-bold uppercase tracking-widest">
                    Completed Playlists
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="w-full text-center">
            <p class="text-[13px] font-semibold tracking-wide text-slate-500 dark:text-slate-400/80">
                Keep up the momentum!
            </p>
        </div>

    </div>
</div>