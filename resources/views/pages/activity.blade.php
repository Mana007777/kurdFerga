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

<div class="flex h-full w-full flex-1 flex-col p-8 md:p-12 space-y-12">
    {{-- Header Section: Mission Operations --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div class="space-y-2">
            <div class="flex items-center gap-3">
                <div class="px-2 py-0.5 rounded bg-violet-500/10 border border-violet-500/20">
                    <span class="text-[10px] font-black text-violet-500 uppercase tracking-[0.2em]">System Monitoring</span>
                </div>
                <div class="flex items-center gap-1.5 text-[10px] font-bold text-zinc-500 uppercase tracking-widest">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Operational
                </div>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-white tracking-tighter uppercase">Mission Logs</h1>
            <p class="text-zinc-500 font-mono text-sm tracking-tight">Sequence Archive: Historical Data Transmission & Activity Tracking</p>
        </div>

        <div class="hidden md:flex flex-col items-end text-right">
            <span class="text-[10px] font-mono text-zinc-600 uppercase tracking-widest leading-none mb-1">Station: ORBIT-01</span>
            <span class="text-xs font-black text-zinc-400 uppercase tracking-[0.2em]">Sector // Academy</span>
        </div>
    </div>
    
    <!-- Data Grid Array (Contribution Graph) -->
    <div class="w-full">
        <div class="relative overflow-hidden rounded-[2rem] bg-zinc-950 border border-zinc-800 p-8 shadow-[0_0_50px_-12px_rgba(0,0,0,0.5)] group">
            <!-- Grid Background -->
            <div class="absolute inset-x-0 top-0 h-40 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.03] pointer-events-none"></div>
            
            <div class="relative z-10 space-y-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-1 h-4 bg-violet-600"></div>
                        <h3 class="text-xs font-black text-white uppercase tracking-[0.2em]">Learning Heatmap // Annual Cycle</h3>
                    </div>
                </div>

                <div class="overflow-x-auto pb-4 scrollbar-hide">
                    <div class="min-w-max">
                        <!-- Months Header -->
                        <div class="relative h-[24px] ml-10 mb-2">
                            @foreach($this->graphData['months'] as $month)
                                <span class="absolute text-[9px] font-black text-zinc-600 uppercase tracking-widest" style="left: {{ $month['week_index'] * 16 }}px">{{ $month['name'] }}</span>
                            @endforeach
                        </div>

                        <div class="flex">
                            <!-- Days Sidebar -->
                            <div class="flex flex-col gap-[4px] text-[9px] font-black text-zinc-700 mr-3 justify-between py-[2px] uppercase">
                                <span class="h-[12px] opacity-0">Sun</span>
                                <span class="h-[12px]">Mon</span>
                                <span class="h-[12px] opacity-0">Tue</span>
                                <span class="h-[12px]">Wed</span>
                                <span class="h-[12px] opacity-0">Thu</span>
                                <span class="h-[12px]">Fri</span>
                                <span class="h-[12px] opacity-0">Sat</span>
                            </div>
                            
                            <!-- Precision Data Grid -->
                            <div class="flex gap-[4px]">
                                @php
                                    $weeks = collect($this->graphData['contributions'])->chunk(7);
                                @endphp
                                
                                @foreach($weeks as $week)
                                    <div class="flex flex-col gap-[4px]">
                                        @foreach($week as $date => $count)
                                            @php
                                                $bgClass = $count == 0 ? 'bg-zinc-950 border-zinc-800/50' : 
                                                        ($count < 2 ? 'bg-violet-900/40 border-violet-500/20 text-violet-500' : 
                                                        ($count < 4 ? 'bg-violet-800/60 border-violet-400/30 text-violet-400' : 
                                                        ($count < 6 ? 'bg-violet-600/80 border-violet-300/40 text-violet-300' : 'bg-violet-500 border-violet-200 text-white')));
                                            @endphp
                                            <div 
                                                wire:click="selectDate('{{ $date }}')"
                                                title="{{ $count }} videos watched on {{ \Carbon\Carbon::parse($date)->format('M d, Y') }}"
                                                class="w-[12px] h-[12px] rounded-[2px] border {{ $bgClass }} transition-all hover:scale-150 cursor-pointer hover:shadow-[0_0_10px_rgba(139,92,246,0.5)] hover:z-20 {{ $selectedDate === $date ? 'ring-2 ring-violet-500 ring-offset-2 ring-offset-zinc-950 scale-150 z-20' : '' }}"
                                            ></div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-zinc-900/50">
                    <span class="text-[9px] font-bold text-zinc-600 uppercase tracking-widest">Protocol: Time-Array Sequence Analysis</span>
                    <div class="flex items-center gap-3">
                        <span class="text-[9px] font-bold text-zinc-700 uppercase tracking-widest">Minimal</span>
                        <div class="flex gap-1">
                            <div class="w-3 h-3 rounded-[1px] bg-zinc-950 border border-zinc-800/50"></div>
                            <div class="w-3 h-3 rounded-[1px] bg-violet-900/40 border border-violet-500/20"></div>
                            <div class="w-3 h-3 rounded-[1px] bg-violet-800/60 border border-violet-400/30"></div>
                            <div class="w-3 h-3 rounded-[1px] bg-violet-600/80 border border-violet-300/40"></div>
                            <div class="w-3 h-3 rounded-[1px] bg-violet-500 border border-violet-200"></div>
                        </div>
                        <span class="text-[9px] font-bold text-zinc-700 uppercase tracking-widest">Maximum</span>
                    </div>
                </div>
            </div>

            <!-- Corner Brackets -->
            <div class="absolute top-6 left-6 w-3 h-3 border-t border-l border-zinc-700"></div>
            <div class="absolute top-6 right-6 w-3 h-3 border-t border-r border-zinc-700"></div>
            <div class="absolute bottom-6 left-6 w-3 h-3 border-b border-l border-zinc-700"></div>
            <div class="absolute bottom-6 right-6 w-3 h-3 border-b border-r border-zinc-700"></div>
        </div>
    </div>

    <!-- Operation Details (Activity Log) -->
    <div class="space-y-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-zinc-950 border border-zinc-800 flex items-center justify-center text-violet-500">
                    <flux:icon.clipboard-document-list class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="text-xl font-black text-white tracking-tight uppercase">{{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}</h3>
                    <p class="text-[10px] font-mono text-zinc-500 uppercase tracking-widest">Operation: Data retrieval [{{ $this->watchedVideos->count() }} Entries Found]</p>
                </div>
            </div>
            
            <div class="h-px flex-1 bg-zinc-900 hidden md:block mx-8 opacity-50"></div>
            
            <div class="text-[10px] font-black text-zinc-600 uppercase tracking-[0.3em]">
                Status // SECURE
            </div>
        </div>

        @if($this->watchedVideos->isEmpty())
            <div class="relative overflow-hidden rounded-[1.5rem] bg-zinc-950 border-2 border-dashed border-zinc-800 p-16 flex flex-col items-center justify-center text-center space-y-4">
                 <div class="w-12 h-12 rounded-xl bg-zinc-900 border border-zinc-800 flex items-center justify-center text-zinc-700 mb-2">
                    <flux:icon.magnifying-glass class="w-6 h-6 animate-pulse" />
                </div>
                <h4 class="text-sm font-black text-zinc-400 uppercase tracking-[0.2em]">No Data Stream Detected</h4>
                <p class="text-[10px] font-bold text-zinc-600 uppercase tracking-widest max-w-xs">Initialize learning sessions to populate the historical telemetry database.</p>
            </div>
        @else
            <div class="grid gap-3">
                @foreach($this->watchedVideos as $video)
                    <div class="group relative flex items-center justify-between p-5 rounded-xl bg-zinc-900/40 border border-zinc-800/80 hover:border-violet-500/40 hover:bg-zinc-900/60 transition-all duration-300">
                        <div class="flex items-center gap-5">
                            <div class="font-mono text-[10px] text-zinc-600 group-hover:text-violet-500 transition-colors">
                                [{{ \Carbon\Carbon::parse($video->created_at)->format('H:i:s') }}]
                            </div>
                            
                            <div class="w-px h-6 bg-zinc-800"></div>

                            <div class="space-y-0.5">
                                <h4 class="font-bold text-white tracking-tight group-hover:text-violet-400 transition-colors">{{ $video->title }}</h4>
                                <div class="flex items-center gap-3">
                                    <span class="text-[9px] font-black text-zinc-500 uppercase tracking-widest">{{ $video->playlist_title ?? 'Standalone Unit' }}</span>
                                    <span class="text-zinc-800">//</span>
                                    <span class="text-[9px] font-mono text-zinc-600 uppercase tracking-tighter">ID: LSN-{{ strtoupper(substr($video->lesson_slug, 0, 8)) }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <div class="hidden md:block h-px w-24 bg-zinc-900"></div>
                            <a href="{{ route('playlists.show', $video->playlist_slug ?? '') }}" wire:navigate class="flex items-center gap-2 text-[10px] font-black text-zinc-400 hover:text-white uppercase tracking-widest transition-colors">
                                Re-Integrate
                                <flux:icon.arrow-right class="w-3 h-3 text-violet-500" />
                            </a>
                        </div>
                        
                        <!-- Hover Pulse Marker -->
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-0 bg-violet-600 group-hover:h-8 transition-all"></div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
