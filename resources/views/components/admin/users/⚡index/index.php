<?php

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public function mount()
    {
        abort_if(! auth()->check() || ! auth()->user()->isAdmin(), 403);
    }

    public function deleteInstructor(User $user)
    {
        abort_if(! auth()->check() || ! auth()->user()->isAdmin(), 403);
        
        // Safety check to ensure we only delete instructors here
        if ($user->role === 'instructor') {
            $user->delete();
        }
    }

    public function with(): array
    {
        return [
            'instructors' => User::where('role', 'instructor')
                ->withCount('playlists')
                ->latest()
                ->paginate(10),
        ];
    }
};
