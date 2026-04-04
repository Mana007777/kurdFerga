<?php

use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public function mount()
    {
        abort_if(! auth()->check() || ! auth()->user()->isAdmin(), 403);
    }

    public function delete(Course $course)
    {
        abort_if(! auth()->check() || ! auth()->user()->isAdmin(), 403);
        $course->delete();
    }

    public function with(): array
    {
        return [
            'courses' => Course::withCount('lessons')->latest()->paginate(10),
        ];
    }
};
