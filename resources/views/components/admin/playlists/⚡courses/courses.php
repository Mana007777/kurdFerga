<?php

use App\Models\Playlist;
use App\Models\Course;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public Playlist $playlist;

    #[Validate('required|min:3')]
    public $newTitle = '';

    #[Validate('nullable|url')]
    public $newThumbnail = '';

    #[Validate('required')]
    public $newDescription = '';

    public $newIsPublished = false;

    public function mount(Playlist $playlist)
    {
        abort_if(! auth()->check() || ! auth()->user()->isAdmin(), 403);
        $this->playlist = $playlist;
    }

    public function addCourse()
    {
        $this->validate();

        $this->playlist->courses()->create([
            'title' => $this->newTitle,
            'slug' => Str::slug($this->newTitle),
            'description' => $this->newDescription,
            'thumbnail' => $this->newThumbnail,
            'is_published' => $this->newIsPublished,
        ]);

        $this->newTitle = '';
        $this->newThumbnail = '';
        $this->newDescription = '';
        $this->newIsPublished = false;

        $this->dispatch('course-added');
        $this->playlist->refresh();
    }

    public function delete(Course $course)
    {
        abort_if(! auth()->check() || ! auth()->user()->isAdmin(), 403);
        $course->delete();
    }

    public function with(): array
    {
        return [
            'courses' => $this->playlist->courses()->withCount('lessons')->latest()->paginate(10),
        ];
    }
};
