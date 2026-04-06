<?php

use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public Course $course;
    public bool $isStarred = false;

    public function mount(Course $course): void
    {
        $this->course = $course;
        $this->checkIfStarred();
    }

    public function checkIfStarred(): void
    {
        if (Auth::check()) {
            $this->isStarred = Auth::user()->starredCourses()->where('course_id', $this->course->id)->exists();
        }
    }

    public function toggleStar(): void
    {
        if (! Auth::check()) {
            return;
        }

        Auth::user()->starredCourses()->toggle($this->course->id);
        $this->isStarred = ! $this->isStarred;
        $this->dispatch('course-starred', isStarred: $this->isStarred);
    }
};
