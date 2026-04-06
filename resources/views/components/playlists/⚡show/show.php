<?php

use App\Models\Playlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.app.sidebar')] class extends Component
{
    public Playlist $playlist;

    /** @var array<int> */
    public array $completedLessonIds = [];

    public function mount(Playlist $playlist): void
    {
        abort_if(! $playlist->is_published, 404);
        $this->playlist = $playlist;
        $this->loadCompletedLessons();
    }

    public function loadCompletedLessons(): void
    {
        $user = Auth::user();

        if ($user) {
            $this->completedLessonIds = $user->completedLessons()
                ->pluck('lessons.id')
                ->toArray();
        }
    }

    public function completeLesson(int $lessonId): void
    {
        $user = Auth::user();

        if (! $user) {
            return;
        }

        $lesson = $this->playlist->sections()
            ->with('lessons')
            ->get()
            ->flatMap(fn ($s) => $s->lessons)
            ->firstWhere('id', $lessonId);

        if ($lesson) {
            $user->completeLesson($lesson);
            $this->loadCompletedLessons();
        }
    }

    public function with(): array
    {
        return [
            'sections' => $this->playlist->sections()
                ->with(['lessons' => fn ($q) => $q->where('is_published', true)->orderBy('sort_order')])
                ->orderBy('sort_order')
                ->get(),
        ];
    }
};
