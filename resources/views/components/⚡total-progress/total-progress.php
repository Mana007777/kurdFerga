<?php

use App\Models\Playlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public ?int $selectedPlaylistId = null;

    public int $percentage = 0;

    public function mount(): void
    {
        $user = Auth::user();

        if ($user) {
            $this->selectedPlaylistId = $user->enrolledPlaylists()
                ->where('is_published', true)
                ->first()?->id;
        } else {
            $this->selectedPlaylistId = Playlist::where('is_published', true)->first()?->id;
        }

        $this->updatePercentage();
    }

    public function updatedSelectedPlaylistId(): void
    {
        $this->updatePercentage();
    }

    public function updatePercentage(): void
    {
        $this->percentage = 0;
        $user = Auth::user();

        if (! $user || ! $this->selectedPlaylistId) {
            return;
        }

        $playlist = Playlist::with('sections.lessons')->find($this->selectedPlaylistId);

        if (! $playlist) {
            return;
        }

        $lessonIds = $playlist->sections
            ->flatMap(fn ($s) => $s->lessons->where('is_published', true)->pluck('id'));

        $total = $lessonIds->count();

        if ($total > 0) {
            $completed = $user->completedLessons()
                ->whereIn('lesson_id', $lessonIds)
                ->count();

            $this->percentage = min(100, (int) round(($completed / $total) * 100));
        }
    }

    public function with(): array
    {
        $user = Auth::user();

        return [
            'playlists' => $user 
                ? $user->enrolledPlaylists()->where('is_published', true)->get()
                : Playlist::where('is_published', true)->get(),
        ];
    }
};
