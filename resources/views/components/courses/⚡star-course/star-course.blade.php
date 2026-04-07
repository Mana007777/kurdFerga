<div class="inline-flex items-center">
    <button
        wire:click="toggleStar"
        @class([
            'flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold transition-all duration-300 border',
            'bg-amber-500/10 text-amber-600 border-amber-500/30 hover:bg-amber-500 hover:text-white' => $isStarred,
            'bg-slate-100 text-slate-500 border-slate-200 dark:bg-gray-800 dark:text-gray-400 dark:border-white/5 hover:bg-indigo-500 hover:text-white hover:border-indigo-500' => ! $isStarred,
        ])
    >
        <svg
            @class([
                'w-4 h-4',
                'fill-current' => $isStarred,
                'fill-none' => ! $isStarred,
            ])
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
        </svg>
        {{ $isStarred ? 'Starred' : 'Star Course' }}
    </button>
</div>
