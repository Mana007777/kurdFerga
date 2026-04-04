<?php

use Livewire\Component;
use App\Models\Course;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;

new class extends Component
{
    #[Validate('required|min:3')]
    public $title = '';

    #[Validate('nullable|url')]
    public $thumbnail = '';

    #[Validate('required')]
    public $description = '';

    public $is_published = false;

    public function mount()
    {
        abort_if(!auth()->check() || !auth()->user()->isAdmin(), 403);
    }

    public function save()
    {
        $this->validate();

        Course::create([
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
            'thumbnail' => $this->thumbnail,
            'is_published' => $this->is_published,
        ]);

        return $this->redirect(route('admin.courses.index'), navigate: true);
    }
};