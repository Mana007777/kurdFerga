<?php

use App\Models\Playlist;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    public Playlist $playlist;
    
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

    public $existingThumbnail = '';

    #[Validate('required')]
    public $description = '';

    public $is_published = false;

    public function mount(Playlist $playlist)
    {
        $user = auth()->user();
        abort_if(! $user || ! $user->isAdminOrInstructor(), 403);
        
        // Instructors can only edit their own
        if ($user->isInstructor()) {
            abort_if($playlist->user_id !== $user->id, 403);
        }

        $this->playlist = $playlist;
        $this->title = $playlist->title;
        $this->author_name = $playlist->author_name ?? '';
        $this->level = $playlist->level ?? 'Beginner';
        $this->category = $playlist->category ?? '';
        $this->existingThumbnail = $playlist->thumbnail;
        $this->description = $playlist->description;
        $this->is_published = $playlist->is_published;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
            'author_name' => $this->author_name,
            'level' => $this->level,
            'category' => $this->category,
            'is_published' => $this->is_published,
        ];

        if ($this->thumbnail) {
            $data['thumbnail'] = $this->thumbnail->store('thumbnails', 'public');
        }

        $this->playlist->update($data);

        return $this->redirect(route('admin.playlists.index'), navigate: true);
    }
};
