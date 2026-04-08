<div class="px-8 md:px-12 py-12 max-w-7xl mx-auto w-full space-y-20">
    <!-- Header Section: Mission Briefing -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div class="space-y-2">
            <div class="flex items-center gap-3">
                <div class="px-2 py-0.5 rounded bg-violet-500/10 border border-violet-500/20">
                    <span class="text-[10px] font-black text-violet-500 uppercase tracking-[0.2em]">Personnel Ranking</span>
                </div>
                <div class="flex items-center gap-1.5 text-[10px] font-bold text-zinc-500 uppercase tracking-widest">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse shadow-[0_0_8px_rgba(245,158,11,0.4)]"></span>
                    Operational
                </div>
            </div>
            <h1 class="text-4xl md:text-6xl font-black text-white tracking-tighter uppercase">Global Personnel Rankings</h1>
            <p class="text-zinc-500 font-mono text-sm tracking-tight">Database integrity: SECURE // Analyzing contributor telemetry and XP distribution.</p>
        </div>

        <div class="hidden md:flex flex-col items-end text-right">
            <span class="text-[10px] font-mono text-zinc-600 uppercase tracking-widest leading-none mb-1">STATION // LEADERSHIP</span>
            <span class="text-xs font-black text-zinc-400 uppercase tracking-[0.2em]">Sector // Academy</span>
        </div>
    </div>

    <!-- Podium Section: Top Deployments -->
    @if($topUsers->isNotEmpty())
        <div class="flex flex-col md:flex-row items-end justify-center gap-8 mb-20 px-4">
            <!-- Rank 2: Delta -->
            @if(isset($topUsers[1]))
                <div class="order-2 md:order-1 flex flex-col items-center w-full md:w-64 group">
                    <div class="relative mb-6">
                        <div class="w-24 h-24 rounded-full p-1 bg-zinc-800 border border-zinc-700 shadow-xl group-hover:border-zinc-500 transition-all duration-500">
                            <div class="w-full h-full rounded-full bg-zinc-900 p-1 overflow-hidden">
                                <img src="{{ $topUsers[1]->profilePhotoUrl() }}" class="w-full h-full object-cover rounded-full group-hover:scale-105 transition-transform" alt="{{ $topUsers[1]->name }}">
                            </div>
                        </div>
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 rounded-lg bg-zinc-800 border border-zinc-700 flex items-center justify-center text-zinc-400 font-mono font-black text-xs shadow-lg">02</div>
                    </div>
                    <div class="text-center mb-6 min-h-[60px]">
                        <h3 class="font-black text-white text-lg truncate w-48 uppercase tracking-tight">{{ $topUsers[1]->name }}</h3>
                        <p class="text-zinc-500 font-mono text-[10px] uppercase tracking-widest">{{ $topUsers[1]->pts }} XP-UNIT</p>
                    </div>
                    <div class="w-full h-32 md:h-40 bg-zinc-900/50 border-x border-t border-zinc-800 rounded-t-2xl flex flex-col items-center justify-center space-y-2 group-hover:bg-zinc-900 transition-colors">
                        <div class="w-8 h-px bg-zinc-800"></div>
                        <span class="text-[9px] font-black text-zinc-600 uppercase tracking-[0.3em]">Sector Alpha</span>
                    </div>
                </div>
            @endif

            <!-- Rank 1: Prime -->
            @if(isset($topUsers[0]))
                <div class="order-1 md:order-2 flex flex-col items-center w-full md:w-80 group">
                    <div class="relative mb-8">
                        <div class="absolute inset-[-12px] rounded-full bg-violet-500/10 animate-pulse blur-xl"></div>
                        <div class="relative w-36 h-36 rounded-full p-2 bg-zinc-800 border-2 border-violet-500/50 shadow-[0_0_50px_-12px_rgba(139,92,246,0.3)] group-hover:border-violet-400 transition-all duration-500 z-10">
                            <div class="w-full h-full rounded-full bg-zinc-900 p-1.5 overflow-hidden">
                                <img src="{{ $topUsers[0]->profilePhotoUrl() }}" class="w-full h-full object-cover rounded-full group-hover:scale-110 transition-transform" alt="{{ $topUsers[0]->name }}">
                            </div>
                        </div>
                        <div class="absolute -bottom-2 -right-2 w-12 h-12 rounded-xl bg-violet-600 border-2 border-violet-400 flex items-center justify-center text-white font-mono font-black text-xl shadow-lg z-20">01</div>
                    </div>
                    <div class="text-center mb-8 min-h-[80px]">
                        <h3 class="font-black text-white text-3xl truncate w-64 uppercase tracking-tighter">{{ $topUsers[0]->name }}</h3>
                        <div class="flex items-center justify-center gap-3">
                             <p class="text-violet-400 font-mono text-lg font-black tracking-widest">{{ $topUsers[0]->pts }} XP-UNIT</p>
                             <span class="w-1.5 h-1.5 rounded-full bg-violet-500 animate-ping"></span>
                        </div>
                    </div>
                    <div class="w-full h-48 md:h-64 bg-violet-500/5 border-x border-t border-violet-500/30 rounded-t-[2.5rem] flex flex-col items-center justify-center space-y-4 group-hover:bg-violet-500/10 transition-all duration-500 relative overflow-hidden">
                        <div class="absolute inset-x-0 top-0 h-2 bg-violet-500/20"></div>
                        <flux:icon.bolt class="w-16 h-16 text-violet-500/40 animate-pulse" />
                        <span class="text-[10px] font-black text-violet-500 uppercase tracking-[0.4em]">Prime Contributor</span>
                    </div>
                </div>
            @endif

            <!-- Rank 3: Gamma -->
            @if(isset($topUsers[2]))
                <div class="order-3 md:order-3 flex flex-col items-center w-full md:w-64 group">
                    <div class="relative mb-6">
                        <div class="w-24 h-24 rounded-full p-1 bg-zinc-800 border border-zinc-700 shadow-xl group-hover:border-zinc-500 transition-all duration-500">
                            <div class="w-full h-full rounded-full bg-zinc-900 p-1 overflow-hidden">
                                <img src="{{ $topUsers[2]->profilePhotoUrl() }}" class="w-full h-full object-cover rounded-full group-hover:scale-105 transition-transform" alt="{{ $topUsers[2]->name }}">
                            </div>
                        </div>
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 rounded-lg bg-zinc-800 border border-zinc-700 flex items-center justify-center text-zinc-400 font-mono font-black text-xs shadow-lg">03</div>
                    </div>
                    <div class="text-center mb-6 min-h-[60px]">
                        <h3 class="font-black text-white text-lg truncate w-48 uppercase tracking-tight">{{ $topUsers[2]->name }}</h3>
                        <p class="text-zinc-500 font-mono text-[10px] uppercase tracking-widest">{{ $topUsers[2]->pts }} XP-UNIT</p>
                    </div>
                    <div class="w-full h-24 md:h-32 bg-zinc-900/50 border-x border-t border-zinc-800 rounded-t-2xl flex flex-col items-center justify-center space-y-2 group-hover:bg-zinc-900 transition-colors">
                        <div class="w-8 h-px bg-zinc-800"></div>
                        <span class="text-[9px] font-black text-zinc-600 uppercase tracking-[0.3em]">Sector Gamma</span>
                    </div>
                </div>
            @endif
        </div>
    @endif

    <!-- Ranking Archive Section -->
    <div class="bg-zinc-950 border border-zinc-800 rounded-[2.5rem] overflow-hidden shadow-[0_0_50px_-12px_rgba(0,0,0,0.5)]">
        <div class="px-8 py-8 border-b border-zinc-900 bg-zinc-900/40 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-black text-white uppercase tracking-tight">Personnel Archive</h2>
                <p class="text-[10px] font-mono text-zinc-500 uppercase tracking-widest mt-1">Status: Historical telemetry retrieval active</p>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-[10px] font-black text-zinc-600 uppercase tracking-[0.3em] px-4 py-2 bg-zinc-950 border border-zinc-800 rounded-xl">
                    {{ count($otherUsers) + count($topUsers) }} Identified Units
                </span>
            </div>
        </div>

        <div class="overflow-x-auto overflow-y-auto no-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-zinc-900/50 border-b border-zinc-900">
                        <th class="px-8 py-5 text-[10px] font-black text-zinc-600 uppercase tracking-[0.3em] w-32 border-r border-zinc-900/50">Sequence</th>
                        <th class="px-8 py-5 text-[10px] font-black text-zinc-600 uppercase tracking-[0.3em]">Contributor ID // Profile</th>
                        <th class="px-8 py-5 text-[10px] font-black text-zinc-600 uppercase tracking-[0.3em] text-right">XP Unit Accumulation</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-900">
                    @foreach($otherUsers as $index => $user)
                        <tr class="group hover:bg-zinc-900/40 transition-all duration-300">
                            <td class="px-8 py-6 border-r border-zinc-900/50">
                                <span class="font-mono text-xs text-zinc-600 group-hover:text-violet-500 transition-colors">
                                    [DEPL: {{ str_pad($index + 4, 3, '0', STR_PAD_LEFT) }}]
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-5">
                                    <div class="relative shrink-0">
                                        <div class="w-12 h-12 rounded-xl bg-zinc-900 border border-zinc-800 p-1 group-hover:border-violet-500/50 transition-all duration-500 overflow-hidden">
                                            <img src="{{ $user->profilePhotoUrl() }}" class="w-full h-full object-cover rounded-lg group-hover:scale-110 transition-transform" alt="{{ $user->name }}">
                                        </div>
                                    </div>
                                    <div class="flex flex-col space-y-0.5">
                                        <span class="font-bold text-white tracking-tight uppercase group-hover:text-violet-400 transition-colors">{{ $user->name }}</span>
                                        <span class="font-mono text-[10px] text-zinc-600 uppercase tracking-tighter">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right relative">
                                <div class="flex flex-col items-end">
                                    <span class="text-lg font-mono font-black text-white group-hover:text-violet-500 transition-colors">{{ number_format($user->pts) }}</span>
                                    <span class="text-[8px] font-black text-zinc-700 uppercase tracking-[0.2em] group-hover:text-zinc-500">Telemetry Verified</span>
                                </div>
                                <div class="absolute right-0 top-1/2 -translate-y-1/2 w-1 h-0 bg-violet-600 group-hover:h-12 transition-all"></div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($otherUsers->isEmpty())
            <div class="py-32 flex flex-col items-center justify-center space-y-6">
                <div class="w-16 h-16 rounded-2xl bg-zinc-900 border border-zinc-800 flex items-center justify-center text-zinc-700">
                    <flux:icon.users class="w-8 h-8 animate-pulse" />
                </div>
                <div class="space-y-1 text-center">
                    <h4 class="text-sm font-black text-zinc-400 uppercase tracking-[0.2em]">Personnel Pool Empty</h4>
                    <p class="text-[10px] font-bold text-zinc-600 uppercase tracking-widest">Awaiting new deployments to populate the global ranking database.</p>
                </div>
            </div>
        @endif
        
        <!-- Bottom Brackets -->
        <div class="absolute bottom-8 left-8 w-4 h-4 border-b border-l border-white/5"></div>
        <div class="absolute bottom-8 right-8 w-4 h-4 border-b border-r border-white/5"></div>
    </div>
</div>
