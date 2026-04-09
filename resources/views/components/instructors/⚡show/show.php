<?php

use App\Models\User;
use App\Models\Playlist;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts.app.sidebar')] class extends Component
{
    use WithPagination;

    public User $user;
    public string $search = '';

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function with(): array
    {
        return [
            'playlists' => Playlist::where('user_id', $this->user->id)
                ->where('is_published', true)
                ->when($this->search, fn ($q) => $q->where('title', 'like', '%'.$this->search.'%'))
                ->withCount(['sections', 'lessons'])
                ->latest()
                ->paginate(12),
        ];
    }
};
