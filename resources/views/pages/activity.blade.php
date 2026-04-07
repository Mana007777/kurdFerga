<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

new #[Title('Activity')] class extends Component {
    public $selectedDate = null;

    public function mount()
    {
        $this->selectedDate = Carbon::now()->format('Y-m-d');
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;
    }

    #[Computed]
    public function watchedVideos(): \Illuminate\Support\Collection
    {
        return DB::table('lesson_user')
            ->join('lessons', 'lesson_user.lesson_id', '=', 'lessons.id')
            ->leftJoin('playlists', 'lessons.playlist_id', '=', 'playlists.id')
            ->where('lesson_user.user_id', Auth::id())
            ->whereDate('lesson_user.created_at', $this->selectedDate)
            ->select(
                'lessons.title', 
                'playlists.title as playlist_title', 
                'playlists.slug as playlist_slug', 
                'lesson_user.created_at',
                'lessons.video_url',
                'lessons.slug as lesson_slug'
            )
            ->orderBy('lesson_user.created_at', 'desc')
            ->get();
    }

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
        <flux:heading size="xl" level="1" class="text-zinc-800 dark:text-gray-200 mb-2">{{ __('Activity') }}</flux:heading>
        <flux:subheading size="lg" class="mb-10 text-zinc-500">{{ __('Track your daily video completion streak and learning history.') }}</flux:subheading>
        
        <!-- GitHub-Style Contribution Graph -->
        <div class="w-full max-w-5xl">
            <div class="glass-panel relative flex flex-col p-6 rounded-2xl bg-white dark:bg-gray-900/50 border border-zinc-200 dark:border-white/10 shadow-sm overflow-x-auto w-full">
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
                                            wire:click="selectDate('{{ $date }}')"
                                            title="{{ $count }} videos watched on {{ \Carbon\Carbon::parse($date)->format('M d, Y') }}"
                                            class="w-[12px] h-[12px] rounded-sm {{ $bgClass }} transition-transform hover:scale-125 cursor-pointer ring-1 ring-zinc-950/5 dark:ring-white/5 {{ $selectedDate === $date ? 'ring-2 ring-blue-500 scale-125 z-10' : '' }}"
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

        <!-- Activity Details -->
        <div class="mt-12 w-full max-w-5xl">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center">
                        <flux:icon.calendar class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                    </div>
                    <div>
                        <flux:heading size="lg">{{ \Carbon\Carbon::parse($selectedDate)->format('F d, Y') }}</flux:heading>
                        <flux:subheading>{{ $this->watchedVideos->count() }} videos watched</flux:subheading>
                    </div>
                </div>
            </div>

            <flux:separator class="mb-6" />

            @if($this->watchedVideos->isEmpty())
                <div class="flex flex-col items-center justify-center py-12 px-6 rounded-2xl border-2 border-dashed border-zinc-200 dark:border-white/5 bg-zinc-50/50 dark:bg-white/[0.02]">
                    <flux:icon.clock class="w-12 h-12 text-zinc-300 dark:text-gray-700 mb-4" />
                    <flux:heading class="text-zinc-500">No activity recorded for this day</flux:heading>
                    <flux:subheading>Keep learning to fill your grid!</flux:subheading>
                </div>
            @else
                <div class="grid gap-4">
                    @foreach($this->watchedVideos as $video)
                        <div class="group flex items-center justify-between p-4 rounded-2xl bg-white dark:bg-gray-900/50 border border-zinc-200 dark:border-white/10 hover:border-blue-500/50 hover:shadow-lg transition-all duration-300">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500/20 to-indigo-500/20 flex items-center justify-center shrink-0">
                                    <flux:icon.play class="w-6 h-6 text-blue-600 dark:text-blue-400" variant="solid" />
                                </div>
                                <div>
                                    <h4 class="font-bold text-zinc-900 dark:text-white group-hover:text-blue-500 transition-colors">{{ $video->title }}</h4>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-xs font-medium text-zinc-500">{{ $video->playlist_title ?? 'Standalone Course' }}</span>
                                        <span class="text-zinc-300 dark:text-gray-700">•</span>
                                        <span class="text-xs text-zinc-400">{{ \Carbon\Carbon::parse($video->created_at)->format('H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <flux:button size="sm" variant="subtle" icon="arrow-right" :href="route('playlists.show', $video->playlist_slug ?? '')" wire:navigate>
                                Watch Again
                            </flux:button>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
