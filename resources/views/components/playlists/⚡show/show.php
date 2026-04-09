<?php

use App\Models\Lesson;
use App\Models\Playlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.app.sidebar')] class extends Component
{
    public Playlist $playlist;

    /** @var array<int> */
    public array $completedLessonIds = [];

    /** @var array<int, int> */
    public array $lessonProgress = [];

    public ?Lesson $activeLesson = null;

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
            $completedRelation = $user->completedLessons();
            
            $this->completedLessonIds = $completedRelation->wherePivot('is_completed', true)
                ->pluck('lessons.id')
                ->toArray();

            $this->lessonProgress = $completedRelation->get()
                ->pluck('pivot.watched_seconds', 'id')
                ->toArray();
        }
    }

    public function openLesson(int $lessonId): void
    {
        $this->activeLesson = Lesson::findOrFail($lessonId);
    }

    public function updateProgress(int $lessonId, int $seconds): void
    {
        $user = Auth::user();
        if (! $user) return;

        $lesson = Lesson::findOrFail($lessonId);
        $user->completeLesson($lesson, $seconds);
        $this->loadCompletedLessons();
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
