<?php

use App\Models\Question;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app.sidebar')] #[Title('Post Question')] class extends Component {
    public $title = '';
    public $body = '';
    public $code_snippet = '';
    public $language = 'php';

    public $languages = [
        'Core' => [
            ['label' => 'Python', 'value' => 'python'],
            ['label' => 'Java', 'value' => 'java'],
            ['label' => 'C', 'value' => 'c'],
            ['label' => 'C++', 'value' => 'cpp'],
            ['label' => 'C#', 'value' => 'csharp'],
            ['label' => 'JavaScript', 'value' => 'javascript'],
            ['label' => 'TypeScript', 'value' => 'typescript'],
            ['label' => 'Go', 'value' => 'go'],
            ['label' => 'Rust', 'value' => 'rust'],
            ['label' => 'Kotlin', 'value' => 'kotlin'],
            ['label' => 'Swift', 'value' => 'swift'],
            ['label' => 'Dart', 'value' => 'dart'],
        ],
        'Web / Scripting' => [
            ['label' => 'PHP', 'value' => 'php'],
            ['label' => 'Ruby', 'value' => 'ruby'],
            ['label' => 'Perl', 'value' => 'perl'],
            ['label' => 'Lua', 'value' => 'lua'],
            ['label' => 'Groovy', 'value' => 'groovy'],
            ['label' => 'Hack', 'value' => 'hack'],
        ],
        'Functional' => [
            ['label' => 'Haskell', 'value' => 'haskell'],
            ['label' => 'Elixir', 'value' => 'elixir'],
            ['label' => 'Erlang', 'value' => 'erlang'],
            ['label' => 'F#', 'value' => 'fsharp'],
            ['label' => 'OCaml', 'value' => 'ocaml'],
            ['label' => 'Scheme', 'value' => 'scheme'],
            ['label' => 'Racket', 'value' => 'racket'],
        ],
        'Low-Level / Systems' => [
            ['label' => 'Assembly', 'value' => 'asm'],
            ['label' => 'Zig', 'value' => 'zig'],
            ['label' => 'Nim', 'value' => 'nim'],
            ['label' => 'V', 'value' => 'v'],
        ],
        'Data / Scientific' => [
            ['label' => 'R', 'value' => 'r'],
            ['label' => 'MATLAB', 'value' => 'matlab'],
            ['label' => 'Julia', 'value' => 'julia'],
            ['label' => 'SAS', 'value' => 'sas'],
        ],
        'Database / Query' => [
            ['label' => 'SQL', 'value' => 'sql'],
            ['label' => 'PL/SQL', 'value' => 'plsql'],
            ['label' => 'T-SQL', 'value' => 'tsql'],
        ],
        'Mobile Development' => [
            ['label' => 'Objective-C', 'value' => 'objectivec'],
            ['label' => 'Flutter (Dart)', 'value' => 'dart'],
            ['label' => 'React Native', 'value' => 'javascript'],
        ],
        'Game Development' => [
            ['label' => 'GDScript', 'value' => 'gdscript'],
            ['label' => 'Haxe', 'value' => 'haxe'],
        ],
        'Legacy / Classic' => [
            ['label' => 'COBOL', 'value' => 'cobol'],
            ['label' => 'Fortran', 'value' => 'fortran'],
            ['label' => 'Pascal', 'value' => 'pascal'],
            ['label' => 'Ada', 'value' => 'ada'],
            ['label' => 'BASIC', 'value' => 'basic'],
        ],
        'Other / Niche' => [
            ['label' => 'Crystal', 'value' => 'crystal'],
            ['label' => 'Red', 'value' => 'red'],
            ['label' => 'Pony', 'value' => 'pony'],
            ['label' => 'Chapel', 'value' => 'chapel'],
            ['label' => 'PureScript', 'value' => 'purescript'],
            ['label' => 'ReasonML', 'value' => 'reason'],
            ['label' => 'Idris', 'value' => 'idris'],
            ['label' => 'Agda', 'value' => 'agda'],
        ],
    ];

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'code_snippet' => 'nullable|string',
            'language' => 'nullable|string',
        ]);

        $question = Question::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'body' => $this->body,
            'code_snippet' => $this->code_snippet,
            'language' => $this->language,
        ]);

        return redirect()->route('questions.show', $question);
    }
};
?>

<div class="px-8 md:px-12 py-12 max-w-4xl mx-auto w-full space-y-12">
    <!-- Header Section -->
    <div class="space-y-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('questions.index') }}" wire:navigate class="w-8 h-8 rounded-lg bg-zinc-900 border border-zinc-800 flex items-center justify-center text-zinc-500 hover:text-white transition-colors">
                <flux:icon.chevron-left class="w-4 h-4" />
            </a>
            <div class="px-2 py-0.5 rounded bg-violet-500/10 border border-violet-500/20">
                <span class="text-[10px] font-black text-violet-500 uppercase tracking-[0.2em]">{{ __('New Sequence') }}</span>
            </div>
        </div>
        <h1 class="text-xl sm:text-3xl md:text-5xl font-black text-white tracking-tighter uppercase leading-tight">{{ __('Deploy Intel Request') }}</h1>
        <p class="text-zinc-500 font-mono text-sm tracking-tight">{{ __('Structure your query with precision. Include code telemetry for rapid analysis.') }}</p>
    </div>

    <form wire:submit="save" class="space-y-8">
        <!-- Title -->
        <div class="space-y-2">
            <label class="text-[10px] font-black text-zinc-500 uppercase tracking-widest">{{ __('Subject Line') }}</label>
            <input 
                type="text" 
                wire:model="title"
                placeholder="{{ __('Summarize your issue...') }}"
                class="w-full bg-zinc-950 border border-zinc-800 rounded-2xl py-4 px-6 text-white text-lg font-bold focus:border-violet-500/50 focus:ring-0 transition-all outline-none"
            >
            @error('title') <span class="text-[10px] font-mono text-red-500 uppercase tracking-tighter">{{ $message }}</span> @enderror
        </div>

        <!-- Body -->
        <div class="space-y-2">
            <label class="text-[10px] font-black text-zinc-500 uppercase tracking-widest">{{ __('Operational Details') }}</label>
            <textarea 
                wire:model="body"
                rows="6"
                placeholder="{{ __('Describe the context and what you have attempted...') }}"
                class="w-full bg-zinc-950 border border-zinc-800 rounded-3xl py-4 px-6 text-zinc-300 text-sm focus:border-violet-500/50 focus:ring-0 transition-all outline-none resize-none"
            ></textarea>
            @error('body') <span class="text-[10px] font-mono text-red-500 uppercase tracking-tighter">{{ $message }}</span> @enderror
        </div>

        <!-- Code Snippet Area: Editor Feel -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <label class="text-[10px] font-black text-zinc-500 uppercase tracking-widest">{{ __('Code Telemetry (Optional)') }}</label>
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-mono text-zinc-600 uppercase tracking-tighter">{{ __('Syntax:') }}</span>
                    <select wire:model="language" class="bg-zinc-900 border border-zinc-800 rounded-lg py-1 px-3 text-[10px] font-black text-violet-400 uppercase tracking-widest outline-none cursor-pointer">
                        @foreach($languages as $category => $options)
                            <optgroup label="{{ $category }}" class="bg-zinc-950 text-zinc-500 font-black text-[9px] uppercase tracking-widest">
                                @foreach($options as $lang)
                                    <option value="{{ $lang['value'] }}" class="text-zinc-300">{{ $lang['label'] }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="relative group">
                <!-- Editor Brackets -->
                <div class="absolute top-0 left-0 w-4 h-4 border-t border-l border-violet-500/20 rounded-tl-xl transition-colors group-focus-within:border-violet-500/50"></div>
                <div class="absolute top-0 right-0 w-4 h-4 border-t border-r border-violet-500/20 rounded-tr-xl transition-colors group-focus-within:border-violet-500/50"></div>
                <div class="absolute bottom-0 left-0 w-4 h-4 border-b border-l border-violet-500/20 rounded-bl-xl transition-colors group-focus-within:border-violet-500/50"></div>
                <div class="absolute bottom-0 right-0 w-4 h-4 border-b border-r border-violet-500/20 rounded-br-xl transition-colors group-focus-within:border-violet-500/50"></div>

                <div class="flex bg-zinc-950 border border-zinc-900 rounded-2xl overflow-hidden min-h-[300px] shadow-2xl transition-all group-focus-within:border-violet-500/30">
                    <div class="w-12 bg-zinc-900/50 border-r border-zinc-800 py-4 flex flex-col items-center gap-1.5 select-none">
                        @for($i = 1; $i <= 15; $i++)
                            <span class="text-[9px] font-mono text-zinc-700">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</span>
                        @endfor
                    </div>
                    <textarea 
                        wire:model="code_snippet"
                        spellcheck="false"
                        placeholder="{{ __('Paste your code block here...') }}"
                        class="flex-1 bg-transparent p-4 text-emerald-400/90 font-mono text-xs leading-relaxed outline-none resize-none placeholder:text-zinc-800"
                    ></textarea>
                </div>
            </div>
            @error('code_snippet') <span class="text-[10px] font-mono text-red-500 uppercase tracking-tighter">{{ $message }}</span> @enderror
        </div>

        <!-- Submit -->
        <div class="flex justify-end pt-4">
            <flux:button type="submit" variant="primary" size="base" class="px-12 rounded-2xl">
                {{ __('Transmit Sequence') }}
            </flux:button>
        </div>
    </form>
</div>
