<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public int $totalPoints = 0;

    public function mount(): void
    {
        $user = Auth::user();

        if ($user) {
            $this->totalPoints = $user->pts ?? 0;
        }
    }
};
