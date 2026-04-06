<div class="p-6 md:p-10 max-w-7xl mx-auto w-full">
    <div class="flex items-center gap-4 mb-8">
        <flux:button variant="ghost" icon="arrow-left" href="{{ route('admin.playlists.index') }}" wire:navigate />
        <div>
            <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Courses</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Manage courses in <span class="font-bold">"{{ $playlist->title }}"</span>.</p>
        </div>
        <div class="flex-1"></div>
        <flux:modal.trigger name="add-course-modal">
            <flux:button variant="primary" icon="plus">New Course</flux:button>
        </flux:modal.trigger>
    </div>

    <!-- list of courses as a table -->
    <div class="glass-panel overflow-hidden rounded-2xl shadow-sm border border-slate-200/50 dark:border-white/5 bg-white/70 dark:bg-zinc-900/60 backdrop-blur-xl">
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Course</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column>Lessons</flux:table.column>
                <flux:table.column class="text-right whitespace-nowrap">Actions</flux:table.column>
            </flux:table.columns>
            
            <flux:table.rows>
                @foreach($courses as $course)
                <flux:table.row>
                    <flux:table.cell>
                        <div class="flex items-center gap-3">
                            @if($course->thumbnail)
                                <img src="{{ $course->thumbnail }}" class="w-10 h-10 rounded-lg object-cover" />
                            @else
                                <div class="w-10 h-10 rounded-lg bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-500">
                                    <flux:icon.academic-cap class="w-5 h-5"/>
                                </div>
                            @endif
                            <div>
                                <h4 class="font-bold text-slate-800 dark:text-zinc-200">{{ str($course->title)->limit(40) }}</h4>
                                <p class="text-xs text-slate-500 line-clamp-1 max-w-sm">{{ str($course->description)->limit(50) }}</p>
                            </div>
                        </div>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:badge size="sm" :color="$course->is_published ? 'green' : 'amber'">
                            {{ $course->is_published ? 'Published' : 'Draft' }}
                        </flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        <span class="text-slate-600 dark:text-slate-400 font-medium">{{ $course->lessons_count }}</span>
                    </flux:table.cell>
                    <flux:table.cell>
                        <div class="flex gap-2 justify-end">
                            <flux:button size="sm" variant="subtle" icon="list-bullet" href="{{ route('admin.courses.playlist', $course) }}" wire:navigate>Manage Content</flux:button>
                            <flux:button size="sm" variant="danger" icon="trash" wire:click="delete({{ $course->id }})" wire:confirm="Are you sure you want to delete this course completely?" />
                        </div>
                    </flux:table.cell>
                </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>

    @if($courses->hasPages())
    <div class="mt-6">
        {{ $courses->links() }}
    </div>
    @endif

    <flux:modal name="add-course-modal" class="md:w-96" @course-added.window="$el.close()">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Add New Course</flux:heading>
                <flux:subheading>Add a new course to this playlist.</flux:subheading>
            </div>

            <div class="space-y-4">
                <flux:input wire:model="newTitle" label="Course Title" placeholder="e.g. Setting up IDE" required />
                <flux:input wire:model="newThumbnail" type="url" label="Thumbnail URL" placeholder="https://..." />
                <flux:textarea wire:model="newDescription" label="Course Description" rows="3" required />
                <flux:switch wire:model="newIsPublished" label="Publish Immediately" />
            </div>

            <div class="flex flex-row-reverse gap-3 mt-6">
                <flux:button variant="primary" wire:click="addCourse">Save Course</flux:button>
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>
</div>
