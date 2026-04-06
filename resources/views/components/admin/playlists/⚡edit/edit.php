<?php

use App\Models\Playlist;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    public Playlist $playlist;

    #[Validate('required|min:3')]
    public $title = '';

    #[Validate('nullable|image|max:1024')]
    public $thumbnail;

    public $existingThumbnail = '';

    #[Validate('required')]
    public $description = '';

    public $is_published = false;

    public function mount(Playlist $playlist)
    {
        abort_if(! auth()->check() || ! auth()->user()->isAdmin(), 403);
        $this->playlist = $playlist;
        $this->title = $playlist->title;
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
            'is_published' => $this->is_published,
        ];

        if ($this->thumbnail) {
            $data['thumbnail'] = $this->thumbnail->store('thumbnails', 'public');
        }

        $this->playlist->update($data);

        return $this->redirect(route('admin.playlists.index'), navigate: true);
    }
};
