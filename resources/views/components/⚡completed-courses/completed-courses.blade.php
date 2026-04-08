<div class="relative flex flex-col justify-between overflow-hidden rounded-[1.5rem] bg-zinc-950 border border-zinc-800 p-7 group transition-all duration-500 hover:border-emerald-500/30 shadow-[0_0_50px_-12px_rgba(0,0,0,0.5)] h-full"
     x-data="{
         current: 0,
         target: @entangle('completedPlaylistsCount'),
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
    <!-- Background System Grid -->
    <div class="absolute inset-x-0 bottom-0 h-40 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.03] pointer-events-none rotate-180"></div>
    <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_100%,#000_70%,transparent_100%)]"></div>

    <div class="relative z-10 w-full flex flex-col h-full space-y-6">
        
        {{-- Header --}}
        <div class="flex items-center justify-between w-full">
            <div class="flex items-center gap-3">
                <div class="flex flex-col gap-0.5">
                    <div class="w-1 h-3 bg-emerald-500 rounded-full"></div>
                    <div class="w-1 h-1 bg-emerald-500/40 rounded-full"></div>
                </div>
                <div>
                    <h3 class="text-[10px] font-black tracking-[0.2em] uppercase text-zinc-500 leading-none mb-1">{{ __('Module') }} // 02</h3>
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider">{{ __('Milestones') }}</h4>
                </div>
            </div>
            
            <div class="w-10 h-10 rounded-lg bg-zinc-950 border border-zinc-800 flex items-center justify-center text-emerald-500 shadow-inner group-hover:border-emerald-500/30 transition-colors">
                <flux:icon.check-circle class="w-5 h-5" variant="mini" />
            </div>
        </div>
        
        {{-- Stats Display --}}
        <div class="flex flex-1 items-center justify-center relative py-6">
            <div class="flex flex-col items-center justify-center text-center">
                <div class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-2">{{ __('Authenticated') }}</div>
                <div class="font-mono text-8xl font-black text-white tracking-tighter leading-none drop-shadow-[0_0_15px_rgba(255,255,255,0.1)]">
                    <span x-text="current"></span>
                </div>
                <div class="mt-4 px-4 py-1.5 rounded-lg bg-emerald-500/5 text-emerald-500 border border-emerald-500/20 text-[10px] font-black uppercase tracking-[0.2em]">
                    {{ __('Playlists Mastered') }}
                </div>
            </div>

            <!-- Precision Crosshairs -->
            <div class="absolute top-1/2 left-0 w-6 h-px bg-zinc-800 -translate-y-1/2"></div>
            <div class="absolute top-1/2 right-0 w-6 h-px bg-zinc-800 -translate-y-1/2"></div>
            <div class="absolute top-0 left-1/2 w-px h-6 bg-zinc-800 -translate-x-1/2"></div>
            <div class="absolute bottom-0 left-1/2 w-px h-6 bg-zinc-800 -translate-x-1/2"></div>
        </div>

        {{-- Footer Status --}}
        <div class="flex justify-between items-center text-[10px] font-bold uppercase tracking-[0.15em]">
            <span class="text-zinc-500">{{ __('Sector') }}: 7G</span>
            <span class="text-zinc-600 font-mono">ID: SEC-2938-X</span>
        </div>

    </div>

    <!-- Edge Brackets -->
    <div class="absolute top-4 left-4 w-2 h-2 border-t border-l border-zinc-700"></div>
    <div class="absolute top-4 right-4 w-2 h-2 border-t border-r border-zinc-700"></div>
    <div class="absolute bottom-4 left-4 w-2 h-2 border-b border-l border-zinc-700"></div>
    <div class="absolute bottom-4 right-4 w-2 h-2 border-b border-r border-zinc-700"></div>
</div>