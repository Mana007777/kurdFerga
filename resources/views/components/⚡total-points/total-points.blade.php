<div class="relative flex flex-col justify-between overflow-hidden rounded-[1.5rem] bg-zinc-950 border border-zinc-800 p-7 group transition-all duration-500 hover:border-amber-500/30 shadow-[0_0_50px_-12px_rgba(0,0,0,0.5)] h-full"
     x-data="{
         current: 0,
         target: @entangle('totalPoints'),
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
    <!-- Background Activity Grid -->
    <div class="absolute inset-0 bg-[radial-gradient(#ffffff05_1px,transparent_1px)] bg-[size:16px_16px] [mask-image:linear-gradient(to_bottom,transparent,black,transparent)]"></div>
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-amber-500/20 to-transparent animate-scan-line"></div>

    <div class="relative z-10 w-full flex flex-col h-full space-y-6">
        
        {{-- Header --}}
        <div class="flex items-center justify-between w-full">
            <div class="flex items-center gap-3">
                <div class="flex flex-col gap-0.5">
                    <div class="w-1 h-3 bg-amber-500 rounded-full"></div>
                    <div class="w-1 h-1 bg-amber-500/40 rounded-full"></div>
                </div>
                <div>
                    <h3 class="text-[10px] font-black tracking-[0.2em] uppercase text-zinc-500 leading-none mb-1">Module // 03</h3>
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider">Achievements</h4>
                </div>
            </div>
            
            <div class="w-10 h-10 rounded-lg bg-zinc-950 border border-zinc-800 flex items-center justify-center text-amber-500 shadow-inner group-hover:border-amber-500/30 transition-colors">
                <flux:icon.star class="w-5 h-5" variant="mini" />
            </div>
        </div>
        
        {{-- Stats Display --}}
        <div class="flex flex-1 items-center justify-center relative py-6">
            <div class="flex flex-col items-center justify-center text-center">
                <div class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-2 italic">Scanning Data...</div>
                <div class="font-mono text-8xl font-black text-white tracking-tighter leading-none decoration-amber-500/20 underline underline-offset-8">
                    <span x-text="current"></span>
                </div>
                <div class="mt-4 px-4 py-1.5 rounded-lg bg-amber-500/5 text-amber-500 border border-amber-500/20 text-[10px] font-black uppercase tracking-[0.2em]">
                    Total XP Accumulation
                </div>
            </div>

            <!-- Scanner Decoration -->
            <div class="absolute inset-x-8 top-12 bottom-12 border-x border-zinc-900/50 pointer-events-none"></div>
        </div>

        {{-- Footer Rank --}}
        <div class="flex justify-between items-center text-[10px] font-bold uppercase tracking-[0.15em]">
            <span class="text-zinc-500">Global Rank: [Analyzing]</span>
            <div class="flex items-center gap-1 text-amber-500">
                <span class="w-1 h-1 rounded-full bg-amber-500 animate-ping"></span>
                <span>Tier 1 Elite</span>
            </div>
        </div>

    </div>

    <!-- Edge Brackets -->
    <div class="absolute top-4 left-4 w-2 h-2 border-t border-l border-zinc-700"></div>
    <div class="absolute top-4 right-4 w-2 h-2 border-t border-r border-zinc-700"></div>
    <div class="absolute bottom-4 left-4 w-2 h-2 border-b border-l border-zinc-700"></div>
    <div class="absolute bottom-4 right-4 w-2 h-2 border-b border-r border-zinc-700"></div>
    
    <style>
        @keyframes scan-line {
            0% { transform: translateY(0); opacity: 0; }
            50% { opacity: 1; }
            100% { transform: translateY(280px); opacity: 0; }
        }
        .animate-scan-line {
            animation: scan-line 4s linear infinite;
        }
    </style>
</div>