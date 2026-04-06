<?php

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app.sidebar')] #[Title('Leaderboard')] class extends Component {
    public function with(): array
    {
        return [
            'topUsers' => User::orderByDesc('pts')->limit(3)->get(),
            'otherUsers' => User::orderByDesc('pts')->skip(3)->limit(97)->get(),
        ];
    }
};
?>

<div class="p-6 md:p-10 max-w-7xl mx-auto w-full">
    <!-- Header Section -->
    <div class="text-center mb-16 relative">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-50 dark:bg-amber-900/30 border border-amber-200 dark:border-amber-500/30 text-xs font-black text-amber-600 dark:text-amber-400 uppercase tracking-[0.2em] mb-6">
            <flux:icon.trophy class="w-3 h-3 animate-bounce" />
            Academy Hall of Fame
        </div>
        <h1 class="text-5xl md:text-7xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-6">
            The <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">Leaderboard</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 text-lg md:text-xl max-w-2xl mx-auto">
            Celebrating our top contributors and most dedicated learners. Climb the ranks by completing lessons and engaging with the community.
        </p>
    </div>

    <!-- Podium Section -->
    @if($topUsers->isNotEmpty())
        <div class="flex flex-col md:flex-row items-end justify-center gap-6 mb-20 px-4">
            <!-- Rank 2 -->
            @if(isset($topUsers[1]))
                <div class="order-2 md:order-1 flex flex-col items-center w-full md:w-64">
                    <div class="relative mb-4 group">
                        <div class="w-24 h-24 rounded-full p-1 bg-gradient-to-br from-slate-300 to-slate-500 shadow-xl transition-transform group-hover:scale-105 duration-500">
                            <div class="w-full h-full rounded-full bg-white dark:bg-[#0F172A] p-1 overflow-hidden">
                                <img src="{{ $topUsers[1]->profilePhotoUrl() }}" class="w-full h-full object-cover rounded-full" alt="{{ $topUsers[1]->name }}">
                            </div>
                        </div>
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 rounded-full bg-slate-300 border-4 border-white dark:border-[#0F172A] flex items-center justify-center text-slate-800 font-black text-sm shadow-lg">2</div>
                    </div>
                    <div class="text-center mb-4 min-h-[60px]">
                        <h3 class="font-black text-slate-800 dark:text-white text-lg truncate w-48">{{ $topUsers[1]->name }}</h3>
                        <p class="text-indigo-500 dark:text-indigo-400 font-bold text-sm uppercase tracking-widest">{{ $topUsers[1]->pts }} PTS</p>
                    </div>
                    <div class="w-full h-32 md:h-40 bg-gradient-to-t from-slate-200/50 to-slate-100/50 dark:from-white/10 dark:to-white/5 rounded-t-3xl border-x border-t border-slate-200 dark:border-white/10 flex items-center justify-center">
                        <flux:icon.sparkles class="w-10 h-10 text-slate-400 opacity-30" />
                    </div>
                </div>
            @endif

            <!-- Rank 1 -->
            @if(isset($topUsers[0]))
                <div class="order-1 md:order-2 flex flex-col items-center w-full md:w-72">
                    <div class="relative mb-6 group">
                        <!-- Crown Animation -->
                        <div class="absolute -top-10 left-1/2 -translate-x-1/2 z-20">
                            <flux:icon.trophy class="w-12 h-12 text-amber-400 drop-shadow-[0_0_15px_rgba(251,191,36,0.5)] animate-bounce" />
                        </div>
                        
                        <!-- Glowing Ring -->
                        <div class="absolute inset-[-8px] rounded-full bg-gradient-to-r from-amber-400 via-yellow-300 to-amber-500 animate-spin-slow opacity-70 blur-md"></div>
                        
                        <div class="relative w-32 h-32 rounded-full p-1.5 bg-gradient-to-br from-amber-400 to-orange-500 shadow-2xl transition-transform group-hover:scale-110 duration-500 z-10">
                            <div class="w-full h-full rounded-full bg-white dark:bg-[#0F172A] p-1 overflow-hidden">
                                <img src="{{ $topUsers[0]->profilePhotoUrl() }}" class="w-full h-full object-cover rounded-full" alt="{{ $topUsers[0]->name }}">
                            </div>
                        </div>
                        <div class="absolute -bottom-2 -right-2 w-10 h-10 rounded-full bg-amber-400 border-4 border-white dark:border-[#0F172A] flex items-center justify-center text-amber-900 font-black text-lg shadow-lg z-20">1</div>
                    </div>
                    <div class="text-center mb-6 min-h-[80px]">
                        <h3 class="font-black text-slate-900 dark:text-white text-2xl truncate w-56">{{ $topUsers[0]->name }}</h3>
                        <div class="flex items-center justify-center gap-2">
                             <p class="text-amber-500 font-black text-lg uppercase tracking-[0.2em]">{{ $topUsers[0]->pts }} PTS</p>
                             <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                        </div>
                    </div>
                    <div class="w-full h-48 md:h-64 bg-gradient-to-t from-amber-500/20 to-amber-400/10 dark:from-amber-400/20 dark:to-amber-400/5 rounded-t-3xl border-x border-t border-amber-400/30 dark:border-amber-400/20 flex flex-col items-center justify-center shadow-[0_-20px_50px_rgba(251,191,36,0.1)]">
                        <flux:icon.star class="w-14 h-14 text-amber-500 opacity-40 mb-2 fill-current" />
                        <span class="text-[10px] font-black text-amber-600/60 dark:text-amber-400/60 uppercase tracking-[0.3em]">Champion</span>
                    </div>
                </div>
            @endif

            <!-- Rank 3 -->
            @if(isset($topUsers[2]))
                <div class="order-3 md:order-3 flex flex-col items-center w-full md:w-64">
                    <div class="relative mb-4 group">
                        <div class="w-24 h-24 rounded-full p-1 bg-gradient-to-br from-orange-400 to-amber-700 shadow-lg transition-transform group-hover:scale-105 duration-500">
                            <div class="w-full h-full rounded-full bg-white dark:bg-[#0F172A] p-1 overflow-hidden">
                                <img src="{{ $topUsers[2]->profilePhotoUrl() }}" class="w-full h-full object-cover rounded-full" alt="{{ $topUsers[2]->name }}">
                            </div>
                        </div>
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 rounded-full bg-orange-600 border-4 border-white dark:border-[#0F172A] flex items-center justify-center text-white font-black text-sm shadow-lg">3</div>
                    </div>
                    <div class="text-center mb-4 min-h-[60px]">
                        <h3 class="font-black text-slate-800 dark:text-white text-lg truncate w-48">{{ $topUsers[2]->name }}</h3>
                        <p class="text-indigo-500 dark:text-indigo-400 font-bold text-sm uppercase tracking-widest">{{ $topUsers[2]->pts }} PTS</p>
                    </div>
                    <div class="w-full h-24 md:h-32 bg-gradient-to-t from-slate-200/50 to-slate-100/50 dark:from-white/10 dark:to-white/5 rounded-t-3xl border-x border-t border-slate-200 dark:border-white/10 flex items-center justify-center">
                        <flux:icon.gift class="w-8 h-8 text-orange-600 opacity-30" />
                    </div>
                </div>
            @endif
        </div>
    @endif

    <!-- Ranking List Section -->
    <div class="glass-panel rounded-[2.5rem] border border-slate-200 dark:border-white/10 overflow-hidden shadow-2xl">
        <div class="px-8 py-6 border-b border-slate-200 dark:border-white/10 bg-white/50 dark:bg-white/[0.02] flex items-center justify-between">
            <h2 class="text-xl font-black text-slate-800 dark:text-white uppercase tracking-tight">Full Rankings</h2>
            <div class="flex items-center gap-4">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ count($otherUsers) + count($topUsers) }} Users Tracked</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-white/[0.01]">
                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] w-24">Rank</th>
                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Contributor</th>
                        <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Points</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                    @foreach($otherUsers as $index => $user)
                        <tr class="group hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors duration-200">
                            <td class="px-8 py-5">
                                <span class="inline-flex w-8 h-8 items-center justify-center rounded-lg bg-slate-100 dark:bg-white/5 text-xs font-black text-slate-500 dark:text-slate-400 group-hover:bg-indigo-500 group-hover:text-white transition-all duration-300">
                                    {{ $index + 4 }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="relative shrink-0">
                                        <div class="w-10 h-10 rounded-full border-2 border-slate-200 dark:border-white/10 p-0.5 group-hover:border-indigo-500 transition-colors">
                                            <img src="{{ $user->profilePhotoUrl() }}" class="w-full h-full object-cover rounded-full" alt="{{ $user->name }}">
                                        </div>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-800 dark:text-slate-200 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $user->name }}</span>
                                        <span class="text-[10px] text-slate-400 font-medium truncate max-w-[120px]">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex flex-col items-end">
                                    <span class="text-sm font-black text-slate-700 dark:text-white group-hover:text-indigo-500 transition-colors">{{ number_format($user->pts) }}</span>
                                    <span class="text-[9px] font-black text-slate-400 tracking-tighter uppercase">XP Gained</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($otherUsers->isEmpty())
            <div class="py-20 text-center">
                <flux:icon.users class="w-12 h-12 text-slate-300 dark:text-white/10 mx-auto mb-4" />
                <p class="text-slate-500 dark:text-slate-400 font-medium italic">No other ranked users yet. Be the first to join the full list!</p>
            </div>
        @endif
    </div>
</div>

<style>
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin-slow {
        animation: spin-slow 8s linear infinite;
    }
</style>
