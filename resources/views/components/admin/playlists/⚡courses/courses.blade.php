<div class="px-8 md:px-12 py-12 max-w-5xl mx-auto w-full space-y-12">
    <!-- Header: Operational Content Matrix -->
    <div class="flex items-center gap-6">
        <flux:button variant="subtle" icon="arrow-left" href="{{ route('admin.playlists.index') }}" wire:navigate class="!bg-zinc-900/50 !border-zinc-800 !text-zinc-500 hover:!text-white transition-all" />
        <div class="space-y-1">
            <h1 class="text-4xl font-black text-white tracking-tighter uppercase">{{ __('Content Matrix') }}</h1>
            <p class="text-zinc-500 font-mono text-xs tracking-tight">{{ __('Orchestrating segments for') }} // <span class="bg-emerald-500/10 text-emerald-400 px-1.5 py-0.5 rounded border border-emerald-500/20">"{{ $playlist->title }}"</span></p>
        </div>
    </div>

    <!-- Top Tools: Signal Search and Module Addition -->
    <div class="bg-zinc-900/40 backdrop-blur-sm p-8 rounded-[2.5rem] border border-zinc-800 shadow-xl group">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Search -->
            <div class="relative space-y-2">
                <flux:input 
                    wire:model.live.debounce.300ms="search" 
                    icon="magnifying-glass" 
                    clearable 
                    label="{{ __('Operational Search') }}" 
                    placeholder="{{ __('Search across curriculum signals...') }}" 
                    class="!bg-zinc-950/50 !border-zinc-800 !text-zinc-200 !font-mono text-xs uppercase focus:!border-violet-500/50 !rounded-xl"
                />
            </div>

            <!-- Add Section -->
            <div class="flex items-end gap-3 border-t md:border-t-0 md:border-l border-zinc-800 pt-6 md:pt-0 pl-0 md:pl-10">
                <div class="flex-1">
                    <flux:input 
                        wire:model="newSectionTitle" 
                        label="{{ __('New Module Title') }}" 
                        placeholder="{{ __('e.g. Chapter 1: Foundations') }}" 
                        class="!bg-zinc-950/50 !border-zinc-800 !text-zinc-200 !font-mono text-xs uppercase focus:!border-violet-500/30 !rounded-xl"
                    />
                </div>
                <div class="relative">
                    <flux:button variant="primary" wire:click="addSection" icon="folder-plus" class="!bg-violet-600 hover:!bg-violet-500 !text-[9px] font-black uppercase tracking-widest px-6 rounded-lg transition-all shadow-[0_0_20px_rgba(139,92,246,0.2)]">
                        {{ __('Add Module') }}
                    </flux:button>
                    <div class="absolute -bottom-0.5 -right-0.5 w-1.5 h-1.5 border-b border-r border-violet-500/50"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sections Loop -->
    <div class="space-y-8">
        @forelse($sections as $section)
            <div class="bg-zinc-900/40 backdrop-blur-md overflow-hidden rounded-[2.5rem] border border-zinc-800/80 shadow-2xl group/section">
                <!-- Section Header -->
                <div class="px-8 py-5 border-b border-zinc-900 bg-zinc-950/40 flex justify-between items-center transition-colors group-hover/section:bg-zinc-950/60">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-violet-500/10 border border-violet-500/20 flex items-center justify-center text-violet-500">
                            <flux:icon.folder class="w-5 h-5" />
                        </div>
                        <h3 class="text-lg font-black text-white uppercase tracking-tight group-hover/section:text-violet-400 transition-colors">
                            {{ $section->title }}
                        </h3>
                    </div>
                    <div class="flex gap-4">
                        <flux:modal.trigger name="add-lesson-modal">
                            <flux:button size="sm" variant="subtle" wire:click="openAddLessonModal({{ $section->id }})" class="!bg-zinc-900 !border-zinc-800 !text-zinc-400 hover:!text-white !text-[9px] font-black uppercase tracking-widest px-4 rounded-lg">
                                <flux:icon.video-camera class="w-3.5 h-3.5 mr-1.5 text-zinc-600" />
                                {{ __('Add Signal') }}
                            </flux:button>
                        </flux:modal.trigger>
                        <flux:button size="sm" variant="danger" icon="trash" wire:click="deleteSection({{ $section->id }})" wire:confirm="{{ __('Initialize Purge Sequence: Remove entire module and all associated signal data?') }}" class="!text-zinc-600 hover:!text-rose-500 !bg-transparent border-0" />
                    </div>
                </div>

                <!-- Lessons List -->
                <div class="p-6 space-y-3">
                    @forelse($section->lessons as $lesson)
                        <div class="flex items-center justify-between p-4 rounded-2xl bg-zinc-950/40 border border-zinc-800/50 hover:border-violet-500/30 hover:bg-zinc-950/60 transition-all group/item">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-zinc-900 border border-zinc-800 flex items-center justify-center text-zinc-700 group-hover/item:text-emerald-500 transition-all">
                                    <flux:icon.play class="w-4 h-4 ml-0.5" />
                                </div>
                                <div>
                                    <h4 class="font-bold text-zinc-100 uppercase tracking-tight text-sm group-hover/item:text-white transition-colors">{{ $lesson->title }}</h4>
                                    <a href="{{ $lesson->video_url }}" target="_blank" class="text-[9px] font-mono text-zinc-600 hover:text-violet-400 hover:underline line-clamp-1 transition-colors uppercase tracking-widest">{{ $lesson->video_url }}</a>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                @if($lesson->is_preview)
                                    <div class="px-2 py-0.5 rounded bg-amber-500/10 border border-amber-500/20">
                                        <span class="text-[8px] font-black text-amber-500 uppercase tracking-widest">{{ __('Open Signal') }}</span>
                                    </div>
                                @endif
                                <button wire:click="deleteLesson({{ $lesson->id }})" wire:confirm="{{ __('Purge Signal Data?') }}" class="text-zinc-700 hover:text-rose-500 transition-colors p-2">
                                    <flux:icon.trash class="w-4 h-4" />
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 rounded-2xl border border-dashed border-zinc-900 bg-zinc-950/20">
                            <p class="text-[10px] font-black text-zinc-700 uppercase tracking-[0.3em] font-mono">
                                {{ __('Null Signal Detected // Awaiting Input') }}
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="text-center py-24 bg-zinc-900/10 rounded-[2.5rem] border-2 border-dashed border-zinc-800">
                <flux:icon.folder-open class="w-16 h-16 text-zinc-800 mx-auto mb-4 opacity-50" />
                <h3 class="text-xl font-black text-zinc-600 uppercase tracking-widest">{{ __('No Matrix Segments Identified') }}</h3>
                <p class="text-[10px] text-zinc-700 font-mono uppercase tracking-widest mt-2">{{ __('Initialize the first module using the command block above.') }}</p>
            </div>
        @endforelse
    </div>

    <!-- Add Video (Lesson) Modal -->
    <flux:modal name="add-lesson-modal" class="!bg-zinc-950 !border-zinc-800 rounded-[2rem] p-0 overflow-hidden" @lesson-added.window="$el.close()">
        <div class="p-8 space-y-8 relative">
            <div class="absolute top-0 right-0 w-32 h-32 bg-violet-500/5 blur-3xl rounded-full -mr-16 -mt-16"></div>
            
            <div class="relative space-y-1">
                <flux:heading size="lg" class="!text-white font-black uppercase tracking-tighter">{{ __('Initialize New Signal') }}</flux:heading>
                <flux:subheading class="!text-zinc-500 font-mono text-xs uppercase tracking-tight">{{ __('Upload high-fidelity data to specific module.') }}</flux:subheading>
            </div>

            <div class="space-y-6 relative" x-data="{ uploading: false, progress: 0 }"
                 x-on:livewire-upload-start="uploading = true"
                 x-on:livewire-upload-finish="uploading = false; progress = 0"
                 x-on:livewire-upload-error="uploading = false"
                 x-on:livewire-upload-progress="progress = $event.detail.progress">

                <flux:input wire:model="newLessonTitle" label="{{ __('Signal Designation') }}" placeholder="{{ __('e.g. Introduction to OOP') }}" class="!bg-zinc-900/60 !border-zinc-800 !text-zinc-200 !font-mono text-xs uppercase tracking-tight focus:!border-violet-500/50 !rounded-xl" />

                <div class="space-y-3">
                    <flux:label class="!text-zinc-400 font-black text-[9px] uppercase tracking-[0.2em]">{{ __('Data Payload') }}</flux:label>
                    <div class="p-4 rounded-xl bg-zinc-900/40 border border-zinc-800/60">
                        <flux:input wire:model="newLessonVideo" type="file" accept="video/mp4,video/webm,video/ogg,video/quicktime" required class="!bg-transparent !border-0 !text-zinc-400 !font-mono text-xs" />
                    </div>
                </div>

                <!-- Upload Progress Bar -->
                <div x-show="uploading" class="w-full bg-zinc-900 rounded-full h-1.5 overflow-hidden shadow-inner">
                    <div class="bg-violet-600 h-1.5 rounded-full transition-all duration-150 shadow-[0_0_10px_rgba(139,92,246,0.5)]" x-bind:style="'width: ' + progress + '%'"></div>
                </div>

                <div class="p-4 rounded-xl bg-zinc-900/20 border border-zinc-800/40">
                    <flux:switch wire:model="newLessonIsPreview" label="{{ __('Open Encryption') }}" description="{{ __('Allow non-authorized personnel access.') }}" />
                </div>
            </div>

            <div class="flex flex-row-reverse gap-4 relative">
                <div class="relative">
                    <flux:button variant="primary" wire:click="addLesson" wire:loading.attr="disabled" wire:target="newLessonVideo, addLesson" class="!bg-violet-600 hover:!bg-violet-500 !text-[11px] font-black uppercase tracking-widest px-8 py-2.5 rounded-xl transition-all shadow-[0_0_20px_rgba(139,92,246,0.3)]">
                        {{ __('Confirm Upload') }}
                    </flux:button>
                    <div class="absolute -bottom-0.5 -right-0.5 w-1.5 h-1.5 border-b border-r border-violet-500/50"></div>
                </div>
                <flux:modal.close>
                    <flux:button variant="ghost" class="!text-zinc-600 hover:!text-white uppercase font-black text-[10px] tracking-widest">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>
</div>
