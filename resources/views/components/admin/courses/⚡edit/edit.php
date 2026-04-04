<?php

use App\Models\Course;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component
{
    public Course $course;

    #[Validate('required|min:3')]
    public $title = '';

    #[Validate('nullable|url')]
    public $thumbnail = '';

    #[Validate('required')]
    public $description = '';

    public $is_published = false;

    public function mount(Course $course)
    {
        abort_if(! auth()->check() || ! auth()->user()->isAdmin(), 403);
        $this->course = $course;
        $this->title = $course->title;
        $this->thumbnail = $course->thumbnail;
        $this->description = $course->description;
        $this->is_published = $course->is_published;
    }

    public function save()
    {
        $this->validate();

        $this->course->update([
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
            'thumbnail' => $this->thumbnail,
            'is_published' => $this->is_published,
        ]);

        return $this->redirect(route('admin.courses.index'), navigate: true);
    }
};
