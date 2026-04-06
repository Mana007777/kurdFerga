<?php

use App\Models\Course;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component
{
    #[Validate('required|min:3')]
    public $title = '';

    #[Validate('nullable|url')]
    public $thumbnail = '';

    #[Validate('required')]
    public $description = '';

    public $is_published = false;

    public array $playlists = [];

    #[Validate('nullable|min:2', as: 'playlist name')]
    public $newPlaylistName = '';

    public function mount()
    {
        abort_if(! auth()->check() || ! auth()->user()->isAdmin(), 403);
    }

    public function addPlaylist()
    {
        $this->validateOnly('newPlaylistName');
        if (! empty($this->newPlaylistName)) {
            $this->playlists[] = $this->newPlaylistName;
            $this->newPlaylistName = '';
        }
    }

    public function removePlaylist($index)
    {
        unset($this->playlists[$index]);
        $this->playlists = array_values($this->playlists);
    }

    public function save()
    {
        $this->validate();

        $course = Course::create([
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
            'thumbnail' => $this->thumbnail,
            'is_published' => $this->is_published,
        ]);

        foreach ($this->playlists as $index => $playlistTitle) {
            $course->sections()->create([
                'title' => $playlistTitle,
                'sort_order' => $index + 1,
            ]);
        }

        return $this->redirect(route('admin.courses.index'), navigate: true);
    }
};
