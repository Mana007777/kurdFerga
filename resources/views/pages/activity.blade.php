<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

new #[Title('Activity')] class extends Component {
    #[Computed]
    public function graphData(): array
    {
        $contributions = [];
        $startDate = Carbon::now()->subYear()->startOfWeek(Carbon::SUNDAY);
        $endDate = Carbon::now();

        $lessons = DB::table('lesson_user')
            ->where('user_id', Auth::id())
            ->where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, count(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $months = [];
        $currentDate = $startDate->copy();
        
        while ($currentDate <= $endDate) {
            $dateStr = $currentDate->format('Y-m-d');
            $contributions[$dateStr] = $lessons[$dateStr] ?? 0;
            
            if ($currentDate->day == 1 || $currentDate == $startDate) {
                $monthName = $currentDate->format('M');
                if (empty($months) || end($months)['name'] !== $monthName) {
                    $months[] = [
                        'name' => $monthName, 
                        'week_index' => floor($startDate->diffInDays($currentDate) / 7)
                    ];
                }
            }
            $currentDate->addDay();
        }

        return ['contributions' => $contributions, 'months' => $months];
    }
}; ?>

<div class="flex h-full w-full flex-1 flex-col p-6">
        <flux:heading size="xl" level="1" class="text-zinc-800 dark:text-zinc-200 mb-2">{{ __('Activity') }}</flux:heading>
        <flux:subheading size="lg" class="mb-10 text-zinc-500">{{ __('Track your daily video completion streak and learning history.') }}</flux:subheading>
        
        <!-- GitHub-Style Contribution Graph -->
        <div class="w-full max-w-5xl">
            <div class="glass-panel relative flex flex-col p-6 rounded-2xl bg-white dark:bg-zinc-900/50 border border-zinc-200 dark:border-white/10 shadow-sm overflow-x-auto w-full">
                <div class="min-w-max">
                    <!-- Months Header -->
                    <div class="relative h-[20px] ml-9 mb-1">
                        @foreach($this->graphData['months'] as $month)
                            <span class="absolute text-xs font-semibold text-zinc-500" style="left: {{ $month['week_index'] * 15 }}px">{{ $month['name'] }}</span>
                        @endforeach
                    </div>

                    <div class="flex">
                        <!-- Days Sidebar -->
                        <div class="flex flex-col gap-[3px] text-xs font-medium text-zinc-500 mr-2 justify-between py-[1px]">
                            <span class="h-[12px] text-[10px] leading-[12px] opacity-0">Sun</span>
                            <span class="h-[12px] text-[10px] leading-[12px]">Mon</span>
                            <span class="h-[12px] text-[10px] leading-[12px] opacity-0">Tue</span>
                            <span class="h-[12px] text-[10px] leading-[12px]">Wed</span>
                            <span class="h-[12px] text-[10px] leading-[12px] opacity-0">Thu</span>
                            <span class="h-[12px] text-[10px] leading-[12px]">Fri</span>
                            <span class="h-[12px] text-[10px] leading-[12px] opacity-0">Sat</span>
                        </div>
                        
                        <!-- Grid -->
                        <div class="flex gap-[3px]">
                            @php
                                $weeks = collect($this->graphData['contributions'])->chunk(7);
                            @endphp
                            
                            @foreach($weeks as $week)
                                <div class="flex flex-col gap-[3px]">
                                    @foreach($week as $date => $count)
                                        @php
                                            $bgClass = $count == 0 ? 'bg-[#ebedf0] dark:bg-[#161B22]' : 
                                                    ($count < 2 ? 'bg-[#9BE9A8] dark:bg-[#0E4429]' : 
                                                    ($count < 4 ? 'bg-[#40C463] dark:bg-[#006D32]' : 
                                                    ($count < 6 ? 'bg-[#30A14E] dark:bg-[#26A641]' : 'bg-[#216E39] dark:bg-[#39D353]')));
                                        @endphp
                                        <div 
                                            title="{{ $count }} videos watched on {{ \Carbon\Carbon::parse($date)->format('M d, Y') }}"
                                            class="w-[12px] h-[12px] rounded-sm {{ $bgClass }} transition-transform hover:scale-125 cursor-pointer ring-1 ring-black/5 dark:ring-white/5"
                                        ></div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs text-zinc-500 mt-4 px-2">
                        <span>Learn how we count contributions</span>
                        <div class="flex items-center gap-1.5 ml-4">
                            <span class="mr-1">Less</span>
                            <div class="w-[12px] h-[12px] rounded-[3px] bg-[#ebedf0] dark:bg-[#161B22] ring-1 ring-black/5 dark:ring-white/5"></div>
                            <div class="w-[12px] h-[12px] rounded-[3px] bg-[#9BE9A8] dark:bg-[#0E4429] ring-1 ring-black/5 dark:ring-white/5"></div>
                            <div class="w-[12px] h-[12px] rounded-[3px] bg-[#40C463] dark:bg-[#006D32] ring-1 ring-black/5 dark:ring-white/5"></div>
                            <div class="w-[12px] h-[12px] rounded-[3px] bg-[#30A14E] dark:bg-[#26A641] ring-1 ring-black/5 dark:ring-white/5"></div>
                            <div class="w-[12px] h-[12px] rounded-[3px] bg-[#216E39] dark:bg-[#39D353] ring-1 ring-black/5 dark:ring-white/5"></div>
                            <span class="ml-1">More</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
