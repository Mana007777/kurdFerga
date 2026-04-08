<div class="relative flex flex-col justify-between overflow-hidden rounded-[1.5rem] bg-zinc-950 border border-zinc-800 p-7 group transition-all duration-500 hover:border-violet-500/30 shadow-[0_0_50px_-12px_rgba(0,0,0,0.5)]"
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
    <!-- Background System Grid -->
    <div class="absolute inset-x-0 top-0 h-40 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.03] pointer-events-none"></div>
    <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)]"></div>

    <div class="relative z-10 w-full flex flex-col h-full space-y-6">
        
        {{-- Header & Select --}}
        <div class="flex items-center justify-between w-full">
            <div class="flex items-center gap-3">
                <div class="flex flex-col gap-0.5">
                    <div class="w-1 h-3 bg-violet-500 rounded-full"></div>
                    <div class="w-1 h-1 bg-violet-500/40 rounded-full"></div>
                </div>
                <div>
                    <h3 class="text-[10px] font-black tracking-[0.2em] uppercase text-zinc-500 leading-none mb-1">Module // 01</h3>
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider">Learning Progress</h4>
                </div>
            </div>
            
            <div class="relative">
                <select wire:model.live="selectedPlaylistId" class="appearance-none bg-zinc-950 text-zinc-300 text-[11px] font-bold tracking-wider rounded-lg py-2 pl-4 pr-10 border border-zinc-800 focus:border-violet-500/50 outline-none transition-all hover:bg-zinc-900 cursor-pointer uppercase">
                    @foreach($playlists as $playlist)
                        <option value="{{ $playlist->id }}">{{ str($playlist->title)->limit(12) }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-zinc-500">
                    <flux:icon.chevron-down class="w-3 h-3" variant="mini" />
                </div>
            </div>
        </div>
        
        {{-- Segmented Progress Ring --}}
        <div class="flex flex-1 items-center justify-center relative">
            <div class="relative w-44 h-44 flex items-center justify-center">
                <!-- Circular segments using SVG -->
                <svg class="absolute inset-0 w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                    <!-- Segmented Track -->
                    @foreach(range(0, 19) as $i)
                        <circle cx="50" cy="50" r="40" 
                                stroke-width="6" 
                                fill="transparent" 
                                class="text-zinc-900"
                                stroke-dasharray="10, 2.56" 
                                stroke-dashoffset="{{ 12.56 * $i }}" />
                    @endforeach
                    
                    <!-- Progress Segments -->
                    <circle cx="50" cy="50" r="40" 
                            stroke="url(#dataRingGradient)" 
                            stroke-width="8" 
                            fill="transparent"
                            stroke-dasharray="251.32"
                            :stroke-dashoffset="251.32 - (251.32 * target) / 100"
                            stroke-linecap="butt"
                            class="transition-all duration-[1.5s] ease-out"
                            style="filter: drop-shadow(0px 0px 8px rgba(139, 92, 246, 0.3));" />
                            
                    <defs>
                        <linearGradient id="dataRingGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="#8b5cf6" />
                            <stop offset="100%" stop-color="#3b82f6" />
                        </linearGradient>
                    </defs>
                </svg>
                
                {{-- Data Readout --}}
                <div class="flex flex-col items-center justify-center z-10">
                    <div class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-1">Completion</div>
                    <div class="font-mono text-5xl font-black text-white tracking-tighter leading-none">
                        <span x-text="current"></span><span class="text-xl font-normal text-zinc-600">%</span>
                    </div>
                </div>
            </div>
            
            <!-- Corner Accents -->
            <div class="absolute top-0 left-0 w-4 h-4 border-t-2 border-l-2 border-zinc-800"></div>
            <div class="absolute top-0 right-0 w-4 h-4 border-t-2 border-r-2 border-zinc-800"></div>
            <div class="absolute bottom-0 left-0 w-4 h-4 border-b-2 border-l-2 border-zinc-800"></div>
            <div class="absolute bottom-0 right-0 w-4 h-4 border-b-2 border-r-2 border-zinc-800"></div>
        </div>

        {{-- Footer Telemetry --}}
        <div class="flex justify-between items-center text-[10px] font-bold uppercase tracking-[0.15em]">
            <span class="text-zinc-500">Telemetry: [Active]</span>
            <div class="flex gap-1.5 items-center">
                <span class="text-violet-500">Live Status</span>
                <div class="w-1.5 h-1.5 rounded-full bg-violet-500 animate-pulse"></div>
            </div>
        </div>

    </div>
</div>