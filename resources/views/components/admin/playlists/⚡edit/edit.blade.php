<div class="p-6 md:p-10 max-w-4xl mx-auto w-full">
        <div class="flex items-center gap-4 mb-8">
            <flux:button variant="ghost" icon="arrow-left" href="{{ route('admin.playlists.index') }}" wire:navigate />
            <div>
                <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Edit Playlist</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1">Update details for <span class="font-bold">"{{ $playlist->title }}"</span>.</p>
            </div>
        </div>

        <div class="glass-panel rounded-2xl shadow-sm border border-slate-200/50 dark:border-white/5 bg-white/70 dark:bg-zinc-900/60 backdrop-blur-xl p-8">
            <form wire:submit="save" class="space-y-6">
                
                <flux:input wire:model="title" label="Playlist Title" required />
                
                <div class="space-y-2">
                    <flux:label>Thumbnail Image</flux:label>
                    <div class="flex items-center gap-4">
                        @if($thumbnail)
                            <img src="{{ $thumbnail->temporaryUrl() }}" class="w-20 h-20 rounded-xl object-cover border border-slate-200 dark:border-white/10" />
                        @elseif($existingThumbnail)
                            <img src="{{ str_starts_with($existingThumbnail, 'http') ? $existingThumbnail : asset('storage/' . $existingThumbnail) }}" class="w-20 h-20 rounded-xl object-cover border border-slate-200 dark:border-white/10" />
                        @endif
                        <flux:input wire:model="thumbnail" type="file" accept="image/*" description="Recommended size: 1280x720 (16:9). Leave empty to keep existing." />
                    </div>
                </div>
                
                <flux:textarea wire:model="description" label="Playlist Description" rows="4" required />
                
                <flux:switch wire:model="is_published" label="Publish State" description="Toggle course visibility." />
                
                <div class="pt-4 flex justify-end gap-3 border-t border-slate-200 dark:border-zinc-700">
                    <flux:button href="{{ route('admin.playlists.index') }}" variant="ghost" wire:navigate>Cancel</flux:button>
                    <flux:button type="submit" variant="primary">Save Changes</flux:button>
                </div>
                
            </form>
        </div>
    </div>