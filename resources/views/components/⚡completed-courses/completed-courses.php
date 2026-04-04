<?php

use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public int $completedCoursesCount = 0;

    public function mount()
    {
        // Dummy data explicitly to demonstrate the UI animations correctly!
        $this->completedCoursesCount = rand(2, 14);

        /*
        $user = Auth::user();

        if ($user) {
            $courses = Course::where('is_published', true)->withCount(['lessons' => function ($query) {
                $query->where('is_published', true);
            }])->get();

            $completedCount = 0;

            foreach ($courses as $course) {
                if ($course->lessons_count > 0) {
                    $completedLessonsCount = $user->completedLessons()->where('course_id', $course->id)->count();

                    if ($completedLessonsCount === $course->lessons_count) {
                        $completedCount++;
                    }
                }
            }
            $this->completedCoursesCount = $completedCount;
        }
        */
    }
};
