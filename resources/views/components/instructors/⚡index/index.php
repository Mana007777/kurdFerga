<?php

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.app.sidebar')] class extends Component
{
    public function with(): array
    {
        return [
            'instructors' => User::whereIn('role', ['instructor', 'admin'])
                ->withCount(['playlists' => fn($q) => $q->where('is_published', true)])
                ->latest()
                ->get(),
        ];
    }
};
