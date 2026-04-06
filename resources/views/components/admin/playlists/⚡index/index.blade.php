<div class="p-6 md:p-10 max-w-7xl mx-auto w-full">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Manage Playlists</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1">Create, edit, and organize all playlists across the platform.</p>
            </div>
            
            <flux:button href="{{ route('admin.playlists.create') }}" variant="primary" icon="plus" wire:navigate>
                New Playlist
            </flux:button>
        </div>

        <div class="glass-panel overflow-hidden rounded-2xl shadow-sm border border-slate-200/50 dark:border-white/5 bg-white/70 dark:bg-zinc-900/60 backdrop-blur-xl">
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Playlist</flux:table.column>
                    <flux:table.column>Status</flux:table.column>
                    <flux:table.column>Videos</flux:table.column>
                    <flux:table.column class="text-right whitespace-nowrap">Actions</flux:table.column>
                </flux:table.columns>
                
                <flux:table.rows>
                    @foreach($playlists as $playlist)
                    <flux:table.row>
                        <flux:table.cell>
                            <div class="flex items-center gap-3">
                                @if($playlist->thumbnail)
                                    <img src="{{ $playlist->thumbnail }}" class="w-10 h-10 rounded-lg object-cover" />
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-500">
                                        <flux:icon.academic-cap class="w-5 h-5"/>
                                    </div>
                                @endif
                                <div>
                                    <h4 class="font-bold text-slate-800 dark:text-zinc-200">{{ str($playlist->title)->limit(40) }}</h4>
                                    <p class="text-xs text-slate-500 line-clamp-1 max-w-sm">{{ str($playlist->description)->limit(50) }}</p>
                                </div>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:badge size="sm" :color="$playlist->is_published ? 'green' : 'amber'">
                                {{ $playlist->is_published ? 'Published' : 'Draft' }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>
                            <span class="text-slate-600 dark:text-slate-400 font-medium">{{ $playlist->courses_count }}</span>
                        </flux:table.cell>
                        <flux:table.cell>
                            <div class="flex gap-2 justify-end">
                                <flux:button size="sm" variant="subtle" icon="list-bullet" href="{{ route('admin.playlists.courses', $playlist) }}" wire:navigate>Manage Content</flux:button>
                                <flux:button size="sm" variant="ghost" icon="pencil-square" href="{{ route('admin.playlists.edit', $playlist) }}" wire:navigate />
                                <flux:button size="sm" variant="danger" icon="trash" wire:click="delete({{ $playlist->id }})" wire:confirm="Are you sure you want to delete this completely?" />
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        </div>
        
        @if($playlists->hasPages())
        <div class="mt-6">
            {{ $playlists->links() }}
        </div>
        @endif
    </div>