<?php

use App\Models\Lesson;
use App\Models\Playlist;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public ?Lesson $lesson = null;

    public ?Playlist $playlist = null;

    public function mount(): void
    {
        $user = Auth::user();

        if (! $user) {
            return;
        }

        // Try to find the most recently completed lesson
        $lastCompletedLesson = $user->completedLessons()
            ->latest('lesson_user.created_at')
            ->with('section.playlist')
            ->first();

        if ($lastCompletedLesson && $lastCompletedLesson->section && $lastCompletedLesson->section->playlist) {
            $this->playlist = $lastCompletedLesson->section->playlist;

            // Find the NEXT lesson in the same section by sort_order
            $this->lesson = Lesson::where('section_id', $lastCompletedLesson->section_id)
                ->where('is_published', true)
                ->where('sort_order', '>', $lastCompletedLesson->sort_order)
                ->orderBy('sort_order')
                ->first();

            // If done with section, find first lesson in the next section
            if (! $this->lesson) {
                $nextSection = Section::where('playlist_id', $this->playlist->id)
                    ->where('sort_order', '>', $lastCompletedLesson->section->sort_order)
                    ->orderBy('sort_order')
                    ->first();

                if ($nextSection) {
                    $this->lesson = Lesson::where('section_id', $nextSection->id)
                        ->where('is_published', true)
                        ->orderBy('sort_order')
                        ->first();
                }
            }
        }

        // If still no lesson found, suggest the first published lesson in any playlist
        if (! $this->lesson) {
            $section = Section::whereHas('playlist', fn ($q) => $q->where('is_published', true))
                ->orderBy('sort_order')
                ->first();

            if ($section) {
                $this->lesson = Lesson::where('section_id', $section->id)
                    ->where('is_published', true)
                    ->orderBy('sort_order')
                    ->first();
                $this->playlist = $section->playlist;
            }
        }
    }
};
