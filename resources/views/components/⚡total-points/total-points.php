<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    public int $totalPoints = 0;

    public function mount()
    {
        $user = Auth::user();

        if ($user) {
            $this->totalPoints = $user->pts ?? 0;
            
            // Dummy data fallback for stunning UI animation testing
            if($this->totalPoints == 0) {
                $this->totalPoints = rand(150, 450);
            }
        }
    }
};