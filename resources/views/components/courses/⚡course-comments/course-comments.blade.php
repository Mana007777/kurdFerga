<div class="mt-12 space-y-10">
    <div class="flex items-center justify-between">
        <flux:heading size="lg" class="flex items-center gap-3 !text-white uppercase tracking-tighter font-black">
            <div class="w-10 h-10 rounded-xl bg-violet-500/10 border border-violet-500/20 flex items-center justify-center text-violet-500 shadow-sm">
                <flux:icon.chat-bubble-left-right class="w-5 h-5 fill-current opacity-80" />
            </div>
            {{ __('Personnel Intel') }} ({{ $comments->count() }})
        </flux:heading>
    </div>

    @auth
        <form wire:submit="postComment" class="mb-12 bg-zinc-900/40 backdrop-blur-sm p-8 rounded-[2.5rem] border border-zinc-800 shadow-2xl group transition-all duration-500 hover:border-violet-500/20">
            <div class="relative">
                <flux:textarea
                    wire:model="body"
                    placeholder="{{ __('What did you think of this course?') }}"
                    rows="3"
                    required
                    class="!bg-zinc-950/50 !border-zinc-800 !text-zinc-200 !font-mono text-sm uppercase tracking-tight focus:!border-violet-500/50 !rounded-2xl"
                />
                <div class="absolute -bottom-1 -right-1 w-2 h-2 border-b border-r border-zinc-700"></div>
            </div>
            <div class="mt-6 flex justify-end">
                <flux:button type="submit" variant="primary" icon="paper-airplane" class="!bg-violet-600 hover:!bg-violet-500 !text-[10px] font-black uppercase tracking-[0.2em] px-6 py-2 rounded-xl transition-all shadow-[0_0_20px_rgba(139,92,246,0.3)]">
                    {{ __('Post Intel') }}
                </flux:button>
            </div>
        </form>
    @else
        <div class="mb-12 p-10 rounded-[2.5rem] border-2 border-dashed border-zinc-800 bg-zinc-900/10 text-center">
            <p class="text-zinc-500 font-black text-[10px] uppercase tracking-[0.3em]">
                {{ __('Critical Error: Authentication Required.') }} 
                <flux:link href="{{ route('login') }}" wire:navigate class="!text-violet-500 hover:underline">{{ __('Initialize Session') }}</flux:link>
            </p>
        </div>
    @endauth

    <div class="space-y-10">
        @forelse($comments as $comment)
            <div class="space-y-6">
                <div class="flex gap-6 group">
                    <div class="relative shrink-0">
                        <div class="w-12 h-12 rounded-xl bg-zinc-900 border border-zinc-800 p-1 group-hover:border-violet-500/50 transition-all duration-500 overflow-hidden shadow-lg">
                            <img src="{{ $comment->user->profilePhotoUrl() }}" class="w-full h-full object-cover rounded-lg" alt="{{ $comment->user->name }}">
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-zinc-950 border border-zinc-800 rounded-full flex items-center justify-center">
                            <div class="w-1 h-1 rounded-full bg-emerald-500"></div>
                        </div>
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-4 mb-2">
                            <div class="flex flex-col">
                                <span class="font-black text-white tracking-tight uppercase group-hover:text-violet-400 transition-colors">{{ $comment->user->name }}</span>
                                <span class="font-mono text-[9px] text-zinc-600 uppercase tracking-widest">{{ __('Contributor ID') }} // #{{ str_pad($comment->user->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <span class="text-[9px] font-mono text-zinc-600 uppercase tracking-widest">
                                {{ $comment->created_at->diffForHumans() }}
                            </span>
                        </div>
                        
                        <div class="relative">
                            <div class="text-sm text-zinc-300 leading-relaxed bg-zinc-900/60 backdrop-blur-md p-6 rounded-3xl rounded-tl-none border border-zinc-800 shadow-xl font-medium">
                                {{ $comment->body }}
                            </div>
                            <div class="absolute -left-1.5 top-0 w-3 h-3 bg-zinc-900/60 border-l border-t border-zinc-800 transform -rotate-45"></div>
                        </div>
                        
                        <div class="mt-3 flex items-center gap-6">
                            @auth
                                <button wire:click="setReply({{ $comment->id }})" class="text-[9px] uppercase tracking-[0.2em] font-black text-zinc-500 hover:text-violet-400 transition-all flex items-center gap-2 group/btn">
                                    <flux:icon.chat-bubble-left-right class="w-3.5 h-3.5 text-zinc-600 group-hover/btn:text-violet-500 transition-colors" />
                                    {{ __('Transmit Reply') }}
                                </button>
                            @endauth

                            @if(auth()->id() === $comment->user_id)
                                <button wire:click="deleteComment({{ $comment->id }})" class="text-[9px] uppercase tracking-[0.2em] font-black text-zinc-600 hover:text-rose-500 transition-all flex items-center gap-2 group/del opacity-0 group-hover:opacity-100">
                                    <flux:icon.trash class="w-3.5 h-3.5 text-zinc-700 group-hover/del:text-rose-500/50 transition-colors" />
                                    {{ __('Purge Intel') }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Replies -->
                @if($comment->replies->isNotEmpty())
                    <div class="ml-16 space-y-6 border-l-2 border-zinc-800/50 pl-10 relative">
                        @foreach($comment->replies as $reply)
                            <div class="flex gap-4 group/reply">
                                <div class="w-10 h-10 rounded-xl bg-zinc-950 border border-zinc-800 p-1 group-hover/reply:border-blue-500/50 transition-all duration-500 overflow-hidden shadow-inner shrink-0">
                                    <img src="{{ $reply->user->profilePhotoUrl() }}" class="w-full h-full object-cover rounded-lg" alt="{{ $reply->user->name }}">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-2 mb-1">
                                        <span class="font-black text-xs text-zinc-200 uppercase tracking-tight group-hover/reply:text-blue-400 transition-colors">{{ $reply->user->name }}</span>
                                        <span class="text-[8px] font-mono text-zinc-700 uppercase tracking-widest">{{ $reply->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="text-xs text-zinc-400 leading-relaxed font-medium">
                                        {{ $reply->body }}
                                    </div>
                                    
                                    @if(auth()->id() === $reply->user_id)
                                        <button wire:click="deleteComment({{ $reply->id }})" class="mt-2 text-[8px] uppercase tracking-widest font-black text-zinc-700 hover:text-rose-500 transition-all flex items-center gap-1 opacity-0 group-hover/reply:opacity-100">
                                            <flux:icon.trash class="w-3 h-3" />
                                            {{ __('Purge') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Reply Form -->
                @if($replyingTo === $comment->id)
                    <div class="ml-16 mt-6 bg-violet-500/[0.03] p-6 rounded-[2rem] border border-violet-500/20 shadow-inner relative">
                        <div class="absolute -left-1.5 top-6 w-3 h-3 bg-violet-500/[0.03] border-l border-t border-violet-500/20 transform -rotate-45"></div>
                        
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-violet-500 animate-pulse"></div>
                                <span class="text-[9px] font-black text-violet-400 uppercase tracking-widest">{{ __('Replying to Personnel') }} // {{ $comment->user->name }}</span>
                            </div>
                            <button wire:click="cancelReply" class="text-zinc-600 hover:text-white transition-colors">
                                <flux:icon.x-mark class="w-4 h-4" />
                            </button>
                        </div>
                        
                        <div class="relative">
                            <flux:textarea
                                wire:model="body"
                                placeholder="{{ __('Initiate reply sequence...') }}"
                                rows="2"
                                required
                                class="!bg-zinc-950/50 !border-zinc-800 !text-zinc-300 !font-mono text-xs uppercase tracking-tight focus:!border-violet-500/30 !rounded-xl"
                            />
                        </div>
                        
                        <div class="mt-4 flex justify-end">
                            <flux:button wire:click="postComment" size="sm" variant="primary" class="!bg-violet-600/80 hover:!bg-violet-500 !text-[9px] font-black uppercase tracking-widest px-4 py-1.5 rounded-lg transition-all">
                                {{ __('Post Reply') }}
                            </flux:button>
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center py-20 rounded-[2.5rem] border border-dashed border-zinc-800 bg-zinc-900/10">
                <flux:icon.chat-bubble-bottom-center-text class="w-10 h-10 text-zinc-800 mx-auto mb-4" />
                <p class="text-zinc-600 font-black text-[9px] uppercase tracking-[0.3em] font-mono">
                    {{ __('Database Silent // No contributor intel detected.') }}
                </p>
            </div>
        @endforelse
    </div>
</div>
