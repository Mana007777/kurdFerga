<?php

use App\Models\Playlist;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    #[Validate('required|min:3')]
    public $title = '';

    #[Validate('nullable|string|max:255')]
    public string $author_name = '';

    #[Validate('required|string|max:255')]
    public string $level = 'Beginner';

    #[Validate('nullable|string|max:255')]
    public string $category = '';

    #[Validate('nullable|image|max:1024')]
    public $thumbnail;

    #[Validate('required')]
    public $description = '';

    public $is_published = false;

    public function mount()
    {
        abort_if(! auth()->check() || ! auth()->user()->isAdmin(), 403);
    }

    public function save()
    {
        $this->validate();

        $thumbnailPath = $this->thumbnail
            ? $this->thumbnail->store('thumbnails', 'public')
            : null;

        Playlist::create([
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
            'thumbnail' => $thumbnailPath,
            'author_name' => $this->author_name,
            'level' => $this->level,
            'category' => $this->category,
            'is_published' => $this->is_published,
        ]);

        return $this->redirect(route('admin.playlists.index'), navigate: true);
    }
};
