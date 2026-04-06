<?php

use App\Models\Playlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public int $completedPlaylistsCount = 0;

    public function mount(): void
    {
        $user = Auth::user();

        if (! $user) {
            return;
        }

        $completedCount = 0;

        $playlists = Playlist::where('is_published', true)
            ->with('sections.lessons')
            ->get();

        foreach ($playlists as $playlist) {
            $lessonIds = $playlist->sections
                ->flatMap(fn ($s) => $s->lessons->where('is_published', true)->pluck('id'));

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

        $this->completedPlaylistsCount = $completedCount;
    }
};
