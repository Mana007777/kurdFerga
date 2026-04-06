<?php

use App\Models\Playlist;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts.app.sidebar')] class extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function with(): array
    {
        return [
            'playlists' => Playlist::where('is_published', true)
                ->when($this->search, fn ($q) => $q->where('title', 'like', '%'.$this->search.'%'))
                ->withCount(['sections', 'lessons'])
                ->latest()
                ->paginate(12),
        ];
    }
};
