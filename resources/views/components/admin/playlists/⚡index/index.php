<?php

use App\Models\Playlist;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public function mount()
    {
        abort_if(! auth()->check() || ! auth()->user()->isAdminOrInstructor(), 403);
    }

    public function delete(Playlist $playlist)
    {
        $user = auth()->user();
        abort_if(! $user || ! $user->isAdminOrInstructor(), 403);
        
        // Instructors can only delete their own
        if ($user->isInstructor()) {
            abort_if($playlist->user_id !== $user->id, 403);
        }
        
        $playlist->delete();
    }

    public function with(): array
    {
        $query = Playlist::withCount('courses')->latest();
        
        if (auth()->user()->isInstructor()) {
            $query->where('user_id', auth()->id());
        }

        return [
            'playlists' => $query->paginate(10),
        ];
    }
};
