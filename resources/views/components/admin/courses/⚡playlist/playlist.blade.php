<div class="p-6 md:p-10 max-w-5xl mx-auto w-full">
    <div class="flex items-center gap-4 mb-8">
        <flux:button variant="ghost" icon="arrow-left" href="{{ route('admin.courses.index') }}" wire:navigate />
        <div>
            <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Manage Playlist</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Curriculum for <span class="font-bold">"{{ $course->title }}"</span>.</p>
        </div>
    </div>

    <!-- Add Section Card -->
    <div class="glass-panel p-6 rounded-2xl mb-8 flex gap-4 items-end bg-white/70 dark:bg-zinc-900/60 backdrop-blur-md border border-slate-200 dark:border-white/5 shadow-sm">
        <div class="flex-1">
            <flux:input wire:model="newSectionTitle" label="New Section Title" placeholder="e.g. Chapter 1: Introduction to Java" />
        </div>
        <flux:button variant="primary" wire:click="addSection" icon="folder-plus">Add Section</flux:button>
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
                            <flux:button size="sm" variant="subtle" icon="video-camera" wire:click="openAddLessonModal({{ $section->id }})">Add Lesson</flux:button>
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
                                <flux:button size="xs" variant="ghost" icon="trash" class="text-red-500" wire:click="deleteLesson({{ $lesson->id }})" wire:confirm="Delete this lesson?" />
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-slate-400 dark:text-zinc-500 text-sm italic">
                            No lessons in this section. Add a video to get started.
                        </div>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="text-center py-12 glass-panel rounded-2xl border border-dashed border-slate-300 dark:border-zinc-700">
                <flux:icon.folder-open class="w-12 h-12 text-slate-300 dark:text-zinc-600 mx-auto mb-3" />
                <h3 class="text-lg font-bold text-slate-700 dark:text-zinc-300">Playlist is Empty</h3>
                <p class="text-sm text-slate-500 dark:text-zinc-500 mt-1">Start by creating your first Section above.</p>
            </div>
        @endforelse
    </div>

    <!-- Add Lesson Modal -->
    <flux:modal name="add-lesson-modal" class="md:w-96" @lesson-added.window="$el.close()">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Add New Lesson</flux:heading>
                <flux:subheading>Attach a video to the selected section.</flux:subheading>
            </div>

            <div class="space-y-4">
                <flux:input wire:model="newLessonTitle" label="Lesson Title" placeholder="e.g. Installing Java JDK" />
                <flux:input wire:model="newLessonVideoUrl" type="url" label="Video URL" placeholder="https://youtube.com/..." />
                <flux:switch wire:model="newLessonIsPreview" label="Free Preview" description="Allow non-enrolled students to watch." />
            </div>

            <div class="flex flex-row-reverse gap-3 mt-6">
                <flux:button variant="primary" wire:click="addLesson">Save Lesson</flux:button>
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>
</div>