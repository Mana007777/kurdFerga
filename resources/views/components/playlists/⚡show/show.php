<?php

use App\Models\Playlist;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.app.sidebar')] class extends Component
{
    public Playlist $playlist;

    public function mount(Playlist $playlist)
    {
        abort_if(! $playlist->is_published, 404);
        $this->playlist = $playlist;
    }

    public function with(): array
    {
        return [
            'sections' => $this->playlist->sections()->with(['lessons' => fn ($q) => $q->where('is_published', true)->orderBy('sort_order')])->orderBy('sort_order')->get(),
        ];
    }
};
