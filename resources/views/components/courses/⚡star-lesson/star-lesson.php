<?php

use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public Lesson $lesson;
    public bool $isStarred = false;

    public function mount(Lesson $lesson): void
    {
        $this->lesson = $lesson;
        $this->checkIfStarred();
    }

    public function checkIfStarred(): void
    {
        if (Auth::check()) {
            $this->isStarred = Auth::user()->starredLessons()->where('lesson_id', $this->lesson->id)->exists();
        }
    }

    public function toggleStar(): void
    {
        if (! Auth::check()) {
            return;
        }

        Auth::user()->starredLessons()->toggle($this->lesson->id);
        $this->isStarred = ! $this->isStarred;
        $this->dispatch('lesson-starred', isStarred: $this->isStarred);
    }
};
