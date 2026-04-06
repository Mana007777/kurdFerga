<?php

use App\Models\Playlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public int $completedCoursesCount = 0;

    public function mount(): void
    {
        $user = Auth::user();

        if ($user) {
            $completedCount = 0;

            $playlists = Playlist::where('is_published', true)
                ->with(['sections.lessons' => fn ($q) => $q->where('is_published', true)])
                ->get();

            foreach ($playlists as $playlist) {
                $lessonIds = $playlist->sections
                    ->flatMap(fn ($s) => $s->lessons->pluck('id'));

                $total = $lessonIds->count();

                if ($total > 0) {
                    $completed = $user->completedLessons()
                        ->whereIn('lesson_id', $lessonIds)
                        ->count();

                    if ($completed >= $total) {
                        $completedCount++;
                    }
                }
            }

            $this->completedCoursesCount = $completedCount;
        }
    }
};
