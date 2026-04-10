<?php

use App\Models\Question;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts.app.sidebar')] #[Title('Questions')] class extends Component {
    use WithPagination;

    public $search = '';

    public function with(): array
    {
        return [
            'questions' => Question::with(['user', 'answers'])
                ->where('title', 'like', '%' . $this->search . '%')
                ->latest()
                ->paginate(10),
        ];
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
};
?>

<div class="px-8 md:px-12 py-12 max-w-7xl mx-auto w-full space-y-12">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div class="space-y-4">
            <div class="flex items-center gap-3">
                <div class="px-2 py-0.5 rounded bg-violet-500/10 border border-violet-500/20">
                    <span class="text-[10px] font-black text-violet-500 uppercase tracking-[0.2em]">{{ __('Community Q&A') }}</span>
                </div>
                <div class="flex items-center gap-1.5 text-[10px] font-bold text-zinc-500 uppercase tracking-widest">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    {{ __('Encrypted Knowledge Base') }}
                </div>
            </div>
            <h1 class="text-xl sm:text-3xl md:text-6xl font-black text-white tracking-tighter uppercase leading-tight">{{ __('Terminal Support') }}</h1>
            <p class="text-zinc-500 font-mono text-sm tracking-tight max-w-2xl">{{ __('Deploy your queries to the network. Every solution strengthens the collective intelligence.') }}</p>
        </div>

        <div class="flex items-center gap-4">
            <flux:button :href="route('questions.create')" variant="primary" icon="plus" wire:navigate>
                {{ __('Post Question') }}
            </flux:button>
        </div>
    </div>

    <!-- Search Section -->
    <div class="relative group">
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <flux:icon.magnifying-glass class="w-4 h-4 text-zinc-600 group-focus-within:text-violet-500 transition-colors" />
        </div>
        <input 
            type="text" 
            wire:model.live.debounce.300ms="search"
            placeholder="{{ __('QUERY DATABASE_') }}"
            class="w-full bg-zinc-900/50 border border-zinc-800 rounded-2xl py-4 pl-12 pr-4 text-white font-mono text-sm focus:border-violet-500/50 focus:ring-0 transition-all outline-none"
        >
    </div>

    <!-- Questions List -->
    <div class="space-y-4">
        @forelse($questions as $question)
            <a href="{{ route('questions.show', $question) }}" wire:navigate class="block group relative p-6 bg-zinc-950 border border-zinc-900 rounded-3xl hover:border-violet-500/50 hover:bg-zinc-900/30 transition-all duration-300 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-violet-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex-1 space-y-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $question->user->profilePhotoUrl() }}" class="w-8 h-8 rounded-lg object-cover border border-zinc-800" alt="{{ $question->user->name }}">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black text-white uppercase tracking-tight">{{ $question->user->name }}</span>
                                <span class="text-[8px] font-mono text-zinc-500 uppercase">{{ $question->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <h3 class="text-lg md:text-xl font-black text-white uppercase tracking-tight group-hover:text-violet-400 transition-colors">{{ $question->title }}</h3>
                        <div class="flex items-center gap-4">
                            @if($question->language)
                                <div class="px-2 py-0.5 rounded bg-zinc-900 border border-zinc-800">
                                    <span class="text-[8px] font-mono text-zinc-400 uppercase tracking-widest">{{ $question->language }}</span>
                                </div>
                            @endif
                            <div class="flex items-center gap-1.5 text-zinc-500">
                                <flux:icon.chat-bubble-bottom-center class="w-3 h-3" />
                                <span class="text-[10px] font-mono">{{ $question->answers->count() }} {{ __('Answers') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 rounded-xl bg-zinc-900 border border-zinc-800 flex items-center justify-center text-zinc-600 group-hover:text-violet-500 group-hover:border-violet-500/50 transition-all">
                            <flux:icon.chevron-right class="w-5 h-5" />
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="py-24 flex flex-col items-center justify-center space-y-6">
                <div class="w-20 h-20 rounded-3xl bg-zinc-900/50 border border-zinc-800 flex items-center justify-center text-zinc-700">
                    <flux:icon.question-mark-circle class="w-10 h-10" />
                </div>
                <div class="text-center space-y-2">
                    <h4 class="text-lg font-black text-white uppercase tracking-tight">{{ __('No Intel Found') }}</h4>
                    <p class="text-zinc-500 font-mono text-xs max-w-md">{{ __('The database is empty. Be the first to initiate a query session.') }}</p>
                </div>
                <flux:button :href="route('questions.create')" variant="primary" icon="plus" wire:navigate>
                    {{ __('Post Question') }}
                </flux:button>
            </div>
        @endforelse

        <div class="mt-8">
            {{ $questions->links() }}
        </div>
    </div>
</div>
