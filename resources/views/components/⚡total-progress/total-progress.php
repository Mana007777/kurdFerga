<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

new class extends Component
{
    public ?int $selectedCourseId = null;
    public int $percentage = 0;

    public function mount()
    {
        // Try to pre-select the first published course by default
        $this->selectedCourseId = Course::where('is_published', true)->first()?->id;
        $this->updatePercentage();
    }

    public function updatedSelectedCourseId()
    {
        $this->updatePercentage();
    }

    public function updatePercentage()
    {
        $this->percentage = 0;
        $user = Auth::user();

        if ($user && $this->selectedCourseId) {
            $selectedCourse = Course::find($this->selectedCourseId);

            if ($selectedCourse) {
                // Count published lessons in this course
                $totalLessons = $selectedCourse->lessons()->where('is_published', true)->count();
                
                if ($totalLessons > 0) {
                    $completedLessons = $user->completedLessons()
                        ->where('course_id', $selectedCourse->id)
                        ->count();
                        
                    $this->percentage = min(100, round(($completedLessons / $totalLessons) * 100));
                }
            }
        }
    }

    public function with(): array
    {
        return [
            'courses' => Course::where('is_published', true)->get(),
        ];
    }
};