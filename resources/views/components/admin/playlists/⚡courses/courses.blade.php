<div class="p-6 md:p-10 max-w-5xl mx-auto w-full">
    <div class="flex items-center gap-4 mb-8">
        <flux:button variant="ghost" icon="arrow-left" href="{{ route('admin.playlists.index') }}" wire:navigate />
        <div>
            <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Playlist Content</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Videos for <span class="font-bold">"{{ $playlist->title }}"</span>.</p>
        </div>
    </div>

    <!-- Top Tools: Search and Add Section -->
    <div class="glass-panel p-6 rounded-2xl mb-8 border border-slate-200 dark:border-white/5 bg-white/70 dark:bg-zinc-900/60 backdrop-blur-md shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Search -->
            <div class="flex items-end">
                <div class="w-full">
                    <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass" clearable label="Search Videos" placeholder="Search across all sections..." />
                </div>
            </div>

            <!-- Add Section -->
            <div class="flex items-end gap-3 border-t md:border-t-0 md:border-l border-slate-200 dark:border-white/5 pt-4 md:pt-0 pl-0 md:pl-4">
                <div class="flex-1">
                    <flux:input wire:model="newSectionTitle" label="New Section Title" placeholder="e.g. Chapter 1" />
                </div>
                <flux:button variant="primary" wire:click="addSection" icon="folder-plus">Add Section</flux:button>
            </div>
        </div>
    </div>

    <!-- Sections Loop -->
    <div class="space-y-6">
        @forelse($sections as $section)
            <div class="glass-panel overflow-hidden rounded-2xl border border-slate-200 dark:border-white/5 bg-white/50 dark:bg-zinc-900/40 backdrop-blur-md shadow-sm">
                <!-- Section Header -->
                <div class="px-6 py-4 border-b border-slate-200 dark:border-white/5 bg-slate-50/50 dark:bg-black/20 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-zinc-100 flex items-center gap-2">
                        <flux:icon.folder class="w-5 h-5 text-indigo-500" />
                        {{ $section->title }}
                    </h3>
                    <div class="flex gap-2">
                        <flux:modal.trigger name="add-lesson-modal">
                            <flux:button size="sm" variant="subtle" icon="video-camera" wire:click="openAddLessonModal({{ $section->id }})">Add Video</flux:button>
                        </flux:modal.trigger>
                        <flux:button size="sm" variant="danger" icon="trash" wire:click="deleteSection({{ $section->id }})" wire:confirm="Delete this entire section and all its videos?" />
                    </div>
                </div>

                <!-- Lessons List -->
                <div class="p-4 space-y-2">
                    @forelse($section->lessons as $lesson)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-white dark:bg-zinc-800/50 border border-slate-100 dark:border-white/5 hover:border-indigo-200 dark:hover:border-indigo-500/30 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center text-indigo-500">
                                    <flux:icon.play class="w-4 h-4 ml-0.5" />
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 dark:text-zinc-200 text-sm">{{ $lesson->title }}</h4>
                                    <a href="{{ $lesson->video_url }}" target="_blank" class="text-xs text-indigo-500 hover:underline line-clamp-1">{{ $lesson->video_url }}</a>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                @if($lesson->is_preview)
                                    <flux:badge size="sm" color="amber">Free Preview</flux:badge>
                                @endif
                                <flux:button size="xs" variant="ghost" icon="trash" class="text-red-500" wire:click="deleteLesson({{ $lesson->id }})" wire:confirm="Delete this video?" />
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-slate-400 dark:text-zinc-500 text-sm italic">
                            No videos in this section yet. Add a video to get started.
                        </div>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="text-center py-12 glass-panel rounded-2xl border border-dashed border-slate-300 dark:border-zinc-700">
                <flux:icon.folder-open class="w-12 h-12 text-slate-300 dark:text-zinc-600 mx-auto mb-3" />
                <h3 class="text-lg font-bold text-slate-700 dark:text-zinc-300">No Sections Yet</h3>
                <p class="text-sm text-slate-500 dark:text-zinc-500 mt-1">Start by creating your first Section above.</p>
            </div>
        @endforelse
    </div>

    <!-- Add Video (Lesson) Modal -->
    <flux:modal name="add-lesson-modal" class="md:w-96" @lesson-added.window="$el.close()">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Add New Video</flux:heading>
                <flux:subheading>Upload a video to the selected section.</flux:subheading>
            </div>

            <div class="space-y-4" x-data="{ uploading: false, progress: 0 }"
                 x-on:livewire-upload-start="uploading = true"
                 x-on:livewire-upload-finish="uploading = false; progress = 0"
                 x-on:livewire-upload-error="uploading = false"
                 x-on:livewire-upload-progress="progress = $event.detail.progress">

                <flux:input wire:model="newLessonTitle" label="Video Title" placeholder="e.g. Introduction to OOP" />

                <flux:input wire:model="newLessonVideo" type="file" accept="video/mp4,video/webm,video/ogg,video/quicktime" label="Video File (Up to 100MB)" required />

                <!-- Upload Progress Bar -->
                <div x-show="uploading" class="w-full bg-slate-200 dark:bg-zinc-800 rounded-full h-2.5 overflow-hidden">
                    <div class="bg-indigo-600 h-2.5 rounded-full transition-all duration-150" x-bind:style="'width: ' + progress + '%'"></div>
                </div>

                <flux:switch wire:model="newLessonIsPreview" label="Free Preview" description="Allow non-enrolled students to watch." />
            </div>

            <div class="flex flex-row-reverse gap-3 mt-6">
                <flux:button variant="primary" wire:click="addLesson" wire:loading.attr="disabled" wire:target="newLessonVideo, addLesson">Save Video</flux:button>
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>
</div>
