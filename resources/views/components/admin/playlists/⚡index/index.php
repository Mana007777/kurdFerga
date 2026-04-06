<?php

use App\Models\Playlist;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public function mount()
    {
        abort_if(! auth()->check() || ! auth()->user()->isAdmin(), 403);
    }

    public function delete(Playlist $playlist)
    {
        abort_if(! auth()->check() || ! auth()->user()->isAdmin(), 403);
        $playlist->delete();
    }

    public function with(): array
    {
        return [
            'playlists' => Playlist::withCount('courses')->latest()->paginate(10),
        ];
    }
};
