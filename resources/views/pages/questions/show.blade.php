<?php

use App\Models\Question;
use App\Models\Answer;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app.sidebar')] #[Title('Question Analysis')] class extends Component {
    public Question $question;
    public $answer_body = '';
    public $reply_to_id = null;
    public $reply_body = '';

    public function mount(Question $question)
    {
        $this->question = $question;
    }

    public function with(): array
    {
        return [
            'answers' => $this->question->answers()
                ->whereNull('parent_id')
                ->with(['user', 'replies.user'])
                ->latest()
                ->get()
        ];
    }

    public function postAnswer()
    {
        $this->validate([
            'answer_body' => 'required|string|min:5',
        ]);

        Answer::create([
            'question_id' => $this->question->id,
            'user_id' => auth()->id(),
            'body' => $this->answer_body,
        ]);

        $this->answer_body = '';
        
        $this->dispatch('answer-posted');
    }

    public function setReplyTo($id)
    {
        if ($this->reply_to_id === $id) {
            $this->reply_to_id = null;
            $this->reply_body = '';
        } else {
            $this->reply_to_id = $id;
            $this->reply_body = '';
        }
    }

    public function postReply()
    {
        $this->validate([
            'reply_body' => 'required|string|min:2',
        ]);

        Answer::create([
            'question_id' => $this->question->id,
            'user_id' => auth()->id(),
            'parent_id' => $this->reply_to_id,
            'body' => $this->reply_body,
        ]);

        $this->reply_to_id = null;
        $this->reply_body = '';

        $this->dispatch('reply-posted');
    }
};
?>

<div class="px-8 md:px-12 py-12 max-w-5xl mx-auto w-full space-y-12">
    <!-- Header/Breadcrumb -->
    <div class="flex items-center gap-4">
        <a href="{{ route('questions.index') }}" wire:navigate class="w-10 h-10 rounded-xl bg-zinc-900 border border-zinc-800 flex items-center justify-center text-zinc-500 hover:text-white transition-colors">
            <flux:icon.chevron-left class="w-5 h-5" />
        </a>
        <div class="flex flex-col">
            <span class="text-[10px] font-black text-violet-500 uppercase tracking-[0.2em]">{{ __('Terminal Insight') }}</span>
            <div class="flex items-center gap-2 text-zinc-500 font-mono text-[10px] uppercase">
                <span>{{ __('Path:') }}</span>
                <span class="text-zinc-300">/root/questions/{{ $question->id }}</span>
            </div>
        </div>
    </div>

    <!-- Question Core -->
    <div class="space-y-8">
        <div class="space-y-4">
            <h1 class="text-2xl sm:text-4xl md:text-5xl font-black text-white tracking-tighter uppercase leading-tight">{{ $question->title }}</h1>
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-3">
                    <img src="{{ $question->user->profilePhotoUrl() }}" class="w-10 h-10 rounded-xl object-cover border border-zinc-800" alt="{{ $question->user->name }}">
                    <div class="flex flex-col">
                        <span class="text-xs font-black text-white uppercase">{{ $question->user->name }}</span>
                        <span class="text-[9px] font-mono text-zinc-600 uppercase">{{ __('Operator Status: Active') }}</span>
                    </div>
                </div>
                <div class="h-8 w-px bg-zinc-800/50"></div>
                <div class="flex flex-col">
                    <span class="text-[10px] font-black text-zinc-500 uppercase tracking-widest">{{ __('Timeline') }}</span>
                    <span class="text-[10px] font-mono text-zinc-400">{{ $question->created_at->format('Y.m.d H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Question Body -->
        <div class="bg-zinc-950 border border-zinc-900 rounded-[2rem] p-8 md:p-10 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-6 opacity-10">
                <flux:icon.chat-bubble-left-right class="w-24 h-24 text-zinc-600" />
            </div>
            <div class="relative prose prose-invert max-w-none prose-sm sm:prose-base leading-relaxed text-zinc-300">
                {!! nl2br(e($question->body)) !!}
            </div>

            @if($question->code_snippet)
                <div class="mt-8 space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                             <div class="w-2 h-2 rounded-full bg-violet-500"></div>
                             <span class="text-[10px] font-black text-zinc-500 uppercase tracking-widest">{{ __('Code Telemetry: ' . strtoupper($question->language)) }}</span>
                        </div>
                        <button class="text-[10px] font-mono text-zinc-600 hover:text-violet-400 uppercase transition-colors">{{ __('Copy to Clipboard') }}</button>
                    </div>
                    
                    <div class="relative group/code">
                        <!-- Code Brackets -->
                         <div class="absolute top-0 left-0 w-6 h-6 border-t-2 border-l-2 border-violet-500/20 rounded-tl-2xl"></div>
                         <div class="absolute bottom-0 right-0 w-6 h-6 border-b-2 border-r-2 border-violet-500/20 rounded-br-2xl"></div>

                         <div class="bg-zinc-900/50 border border-zinc-800 rounded-2xl overflow-hidden shadow-2xl">
                             <div class="px-4 py-2 bg-zinc-900 border-b border-zinc-800 flex items-center gap-2">
                                 <div class="flex gap-1.5">
                                     <div class="w-2.5 h-2.5 rounded-full bg-red-500/20"></div>
                                     <div class="w-2.5 h-2.5 rounded-full bg-amber-500/20"></div>
                                     <div class="w-2.5 h-2.5 rounded-full bg-emerald-500/20"></div>
                                 </div>
                                 <span class="text-[9px] font-mono text-zinc-600 ml-2 uppercase">{{ $question->language }}_source</span>
                             </div>
                             <pre class="p-6 overflow-x-auto no-scrollbar font-mono text-xs leading-relaxed text-emerald-400/90 whitespace-pre"><code>{{ $question->code_snippet }}</code></pre>
                         </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Answers Component -->
    <div class="space-y-10 pt-12 border-t border-zinc-900">
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <h2 class="text-xl font-black text-white uppercase tracking-tight">{{ __('Counterintelligence') }}</h2>
                <p class="text-[10px] font-mono text-zinc-600 uppercase tracking-widest">{{ __('Identified Solutions: ' . $question->answers->count()) }}</p>
            </div>
            <div class="h-px flex-1 mx-8 bg-zinc-900/50"></div>
        </div>

        <!-- Answer List -->
        <div class="space-y-6">
            @foreach($answers as $answer)
                <div class="flex gap-4 md:gap-6 group">
                    <div class="shrink-0 flex flex-col items-center gap-4">
                        <img src="{{ $answer->user->profilePhotoUrl() }}" class="w-12 h-12 rounded-2xl object-cover border-2 border-zinc-900 group-hover:border-violet-500/30 transition-all shadow-lg" alt="{{ $answer->user->name }}">
                        <div class="w-px flex-1 bg-gradient-to-b from-zinc-800 to-transparent"></div>
                    </div>
                    <div class="flex-1 space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-black text-white uppercase">{{ $answer->user->name }}</span>
                                <span class="px-1.5 py-0.5 rounded bg-zinc-900 border border-zinc-800 text-[8px] font-mono text-zinc-500 uppercase">{{ $answer->created_at->diffForHumans() }}</span>
                            </div>
                            <button 
                                wire:click="setReplyTo({{ $answer->id }})"
                                class="text-[9px] font-black text-zinc-600 hover:text-violet-400 uppercase tracking-widest transition-colors flex items-center gap-1.5"
                            >
                                <flux:icon.arrow-uturn-left class="w-3 h-3" />
                                {{ __('Reply') }}
                            </button>
                        </div>
                        <div class="text-zinc-400 text-sm leading-relaxed sm:text-base">
                            {!! nl2br(e($answer->body)) !!}
                        </div>

                        <!-- Reply Form (Conditional) -->
                        @if($reply_to_id === $answer->id)
                            <div class="mt-4 bg-zinc-900/50 border border-zinc-800 rounded-2xl p-4 space-y-4 animate-in fade-in slide-in-from-top-2">
                                <textarea 
                                    wire:model="reply_body"
                                    rows="3"
                                    placeholder="{{ __('Draft your target response...') }}"
                                    class="w-full bg-transparent text-zinc-300 text-xs outline-none resize-none placeholder:text-zinc-700 border-none focus:ring-0 p-0"
                                ></textarea>
                                <div class="flex items-center justify-between pt-2 border-t border-zinc-800/50">
                                    <span class="text-[8px] font-mono text-zinc-700 uppercase tracking-tighter">{{ __('Replying to ' . $answer->user->name) }}</span>
                                    <div class="flex items-center gap-2">
                                        <button wire:click="setReplyTo(null)" class="px-3 py-1 text-[8px] font-black text-zinc-600 uppercase tracking-widest hover:text-white transition-colors">{{ __('Cancel') }}</button>
                                        <button 
                                            wire:click="postReply"
                                            class="px-4 py-1.5 bg-violet-600 hover:bg-violet-500 text-white text-[9px] font-black uppercase tracking-widest rounded-lg transition-all"
                                        >
                                            {{ __('Transmit') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Nested Replies -->
                        @if($answer->replies->isNotEmpty())
                            <div class="mt-6 space-y-6 pl-4 md:pl-8 border-l border-zinc-900">
                                @foreach($answer->replies as $reply)
                                    <div class="flex gap-4 group/reply">
                                        <img src="{{ $reply->user->profilePhotoUrl() }}" class="w-8 h-8 rounded-lg object-cover border border-zinc-800 group-hover/reply:border-violet-500/30 transition-all" alt="{{ $reply->user->name }}">
                                        <div class="flex-1 space-y-2">
                                            <div class="flex items-center gap-3">
                                                <span class="text-[10px] font-black text-zinc-300 uppercase tracking-tight">{{ $reply->user->name }}</span>
                                                <span class="text-[7px] font-mono text-zinc-600 uppercase tracking-tighter">{{ $reply->created_at->diffForHumans() }}</span>
                                            </div>
                                            <div class="text-zinc-500 text-xs leading-relaxed">
                                                {!! nl2br(e($reply->body)) !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
            
            @if($answers->isEmpty())
                <div class="py-12 px-8 bg-zinc-900/20 border border-dashed border-zinc-800 rounded-3xl flex flex-col items-center justify-center text-center space-y-4">
                    <flux:icon.chat-bubble-bottom-center-text class="w-10 h-10 text-zinc-700" />
                    <p class="text-xs font-mono text-zinc-600 uppercase tracking-widest">{{ __('Awaiting Transmission...') }}</p>
                </div>
            @endif
        </div>

        <!-- Post Answer Form -->
        <div class="mt-12">
            <div class="bg-zinc-950 border border-zinc-900 rounded-[2.5rem] p-1 shadow-2xl overflow-hidden group focus-within:border-violet-500/30 transition-all">
                <div class="px-6 pt-6 pb-2">
                    <label class="text-[10px] font-black text-zinc-600 uppercase tracking-widest mb-4 block">{{ __('Deployment Interface') }}</label>
                    <textarea 
                        wire:model="answer_body"
                        rows="4"
                        placeholder="{{ __('Draft your solution sequence...') }}"
                        class="w-full bg-transparent text-zinc-300 text-sm outline-none resize-none placeholder:text-zinc-800 border-none focus:ring-0 p-0"
                    ></textarea>
                </div>
                <div class="bg-zinc-900/40 px-6 py-4 flex items-center justify-between">
                    <span class="text-[9px] font-mono text-zinc-600 uppercase tracking-tighter">{{ __('Formatting: Markdown Enabled_') }}</span>
                    <button 
                        wire:click="postAnswer"
                        class="px-6 py-2 bg-violet-600 hover:bg-violet-500 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all shadow-[0_0_15px_rgba(139,92,246,0.2)]"
                    >
                        {{ __('Post Solution') }}
                    </button>
                </div>
            </div>
            @error('answer_body') <span class="text-[10px] font-mono text-red-500 uppercase tracking-tighter mt-2 block">{{ $message }}</span> @enderror
        </div>
    </div>
</div>
