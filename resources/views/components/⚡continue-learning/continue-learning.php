<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Lesson;

new class extends Component
{
    public ?Lesson $lesson = null;
    public ?Course $course = null;

    public function mount()
    {
        $user = Auth::user();
        if (!$user) return;

        // Try to find the most recently completed lesson
        $lastCompletedLesson = $user->completedLessons()->latest('lesson_user.created_at')->first();

        if ($lastCompletedLesson) {
            $this->course = $lastCompletedLesson->course;
            
            // Find the NEXT lesson in this course by sort_order
            $this->lesson = $this->course->lessons()
                ->where('is_published', true)
                ->where('sort_order', '>', $lastCompletedLesson->sort_order)
                ->orderBy('sort_order', 'asc')
                ->first();
                
            if (!$this->lesson) {
                // If they finished this course, suggest a random published lesson from an uncompleted course
                $this->lesson = Lesson::where('is_published', true)
                     ->whereNotIn('course_id', [$this->course->id])
                     ->inRandomOrder()
                     ->first();
                if($this->lesson) {
                    $this->course = $this->lesson->course;
                }
            }
        }

        // If no lesson was ever completed, suggest the first published lesson in the system
        if (!$this->lesson) {
            $this->lesson = Lesson::where('is_published', true)->orderBy('course_id')->orderBy('sort_order')->first();
            if ($this->lesson) {
                $this->course = $this->lesson->course;
            }
        }
    }
};