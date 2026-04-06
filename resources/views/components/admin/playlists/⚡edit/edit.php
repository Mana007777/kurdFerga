<?php

use App\Models\Playlist;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component
{
    public Playlist $playlist;

    #[Validate('required|min:3')]
    public $title = '';

    #[Validate('nullable|url')]
    public $thumbnail = '';

    #[Validate('required')]
    public $description = '';

    public $is_published = false;

    public function mount(Playlist $playlist)
    {
        abort_if(! auth()->check() || ! auth()->user()->isAdmin(), 403);
        $this->playlist = $playlist;
        $this->title = $playlist->title;
        $this->thumbnail = $playlist->thumbnail;
        $this->description = $playlist->description;
        $this->is_published = $playlist->is_published;
    }

    public function save()
    {
        $this->validate();

        $this->playlist->update([
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
            'thumbnail' => $this->thumbnail,
            'is_published' => $this->is_published,
        ]);

        return $this->redirect(route('admin.playlists.index'), navigate: true);
    }
};
