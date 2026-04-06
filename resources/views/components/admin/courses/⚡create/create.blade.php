<div class="p-6 md:p-10 max-w-4xl mx-auto w-full">
        <div class="flex items-center gap-4 mb-8">
            <flux:button variant="ghost" icon="arrow-left" href="{{ route('admin.courses.index') }}" wire:navigate />
            <div>
                <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Create Course</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1">Publish a new learning module to the curriculum.</p>
            </div>
        </div>

        <div class="glass-panel rounded-2xl shadow-sm border border-slate-200/50 dark:border-white/5 bg-white/70 dark:bg-zinc-900/60 backdrop-blur-xl p-8">
            <form wire:submit="save" class="space-y-6">
                
                <flux:input wire:model="title" label="Course Title" placeholder="e.g. Advanced Laravel Architecture" description="The main heading for your course." required />
                
                <flux:input wire:model="thumbnail" type="url" label="Thumbnail URL" placeholder="https://..." description="An optionally hosted image for the course banner." />
                
                <flux:textarea wire:model="description" label="Course Description" placeholder="Explain what the students will learn..." rows="4" required />
                
                <flux:switch wire:model="is_published" label="Publish Immediately" description="Draft courses are hidden from students until published." />
                
                <hr class="border-slate-200 dark:border-white/5 my-4" />
                
                <div>
                    <flux:heading size="sm" class="mb-2">Course Playlists (Sections)</flux:heading>
                    <flux:subheading class="mb-4">Optionally create some initial playlists. You can add more later.</flux:subheading>
                    
                    <div class="flex gap-2">
                        <div class="flex-1">
                            <flux:input wire:model="newPlaylistName" wire:keydown.enter.prevent="addPlaylist" placeholder="e.g. Introduction" />
                        </div>
                        <flux:button variant="subtle" wire:click="addPlaylist">Add</flux:button>
                    </div>

                    @if(count($playlists) > 0)
                        <div class="mt-4 space-y-2">
                            @foreach($playlists as $index => $playlist)
                                <div class="flex items-center justify-between p-3 rounded-xl border border-slate-200 dark:border-white/5 bg-slate-50/50 dark:bg-zinc-800/50">
                                    <span class="font-medium text-slate-700 dark:text-zinc-200 text-sm flex items-center gap-2">
                                        <flux:icon.folder class="w-4 h-4 text-indigo-500" />
                                        {{ $playlist }}
                                    </span>
                                    <flux:button size="sm" variant="ghost" icon="trash" class="text-red-500" wire:click="removePlaylist({{ $index }})" />
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="pt-4 flex justify-end gap-3 border-t border-slate-200 dark:border-zinc-700">
                    <flux:button href="{{ route('admin.courses.index') }}" variant="ghost" wire:navigate>Cancel</flux:button>
                    <flux:button type="submit" variant="primary">Create Course</flux:button>
                </div>
                
            </form>
        </div>
    </div>