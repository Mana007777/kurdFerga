<div class="mt-8">
    <flux:heading size="lg" class="mb-6 flex items-center gap-2">
        <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 012 2h-5l-5 5v-5z"/></svg>
        Course Comments ({{ $comments->count() }})
    </flux:heading>

    @auth
        <form wire:submit="postComment" class="mb-10 bg-white/50 dark:bg-white/5 p-6 rounded-2xl border border-slate-200/60 dark:border-white/5">
            <flux:textarea
                wire:model="body"
                placeholder="What did you think of this course?"
                rows="3"
                required
                class="!bg-transparent border-0 ring-0 focus:ring-0 text-slate-800 dark:text-zinc-100"
            />
            <div class="mt-4 flex justify-end">
                <flux:button type="submit" variant="primary" icon="paper-airplane">Post Comment</flux:button>
            </div>
        </form>
    @else
        <div class="mb-10 p-6 rounded-2xl border border-dashed border-slate-300 dark:border-zinc-700 text-center">
            <p class="text-slate-500 dark:text-zinc-500 text-sm">Please <flux:link href="{{ route('login') }}" wire:navigate>log in</flux:link> to post a comment.</p>
        </div>
    @endauth

    <div class="space-y-6">
        @forelse($comments as $comment)
            <div class="flex gap-4 group">
                <flux:avatar src="{{ $comment->user->profilePhotoUrl() }}" size="sm" class="shrink-0" />
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-2 mb-1">
                        <flux:text weight="bold" class="text-slate-800 dark:text-zinc-100 truncate">
                            {{ $comment->user->name }}
                        </flux:text>
                        <flux:text size="xs" class="text-slate-400 dark:text-zinc-500">
                            {{ $comment->created_at->diffForHumans() }}
                        </flux:text>
                    </div>
                    <div class="text-sm text-slate-600 dark:text-zinc-400 leading-relaxed bg-slate-50 dark:bg-black/20 p-4 rounded-xl rounded-tl-none border border-slate-100 dark:border-white/5">
                        {{ $comment->body }}
                    </div>
                    
                    @if(auth()->id() === $comment->user_id)
                        <button wire:click="deleteComment({{ $comment->id }})" class="mt-2 text-[10px] uppercase tracking-widest font-bold text-red-500/60 hover:text-red-500 transition-colors flex items-center gap-1 opacity-0 group-hover:opacity-100">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Delete
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-10 text-slate-400 dark:text-zinc-600 italic text-sm">
                No comments yet. Be the first to share your thoughts!
            </div>
        @endforelse
    </div>
</div>
