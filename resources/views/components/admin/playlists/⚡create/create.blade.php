<div class="px-8 md:px-12 py-12 max-w-4xl mx-auto w-full space-y-12">
    <!-- Header: Deployment Initialization -->
    <div class="flex items-center gap-6">
        <flux:button variant="subtle" icon="arrow-left" href="{{ route('admin.playlists.index') }}" wire:navigate class="!bg-zinc-900/50 !border-zinc-800 !text-zinc-500 hover:!text-white transition-all" />
        <div class="space-y-1">
            <h1 class="text-4xl font-black text-white tracking-tighter uppercase">{{ __('Initialize Deployment') }}</h1>
            <p class="text-zinc-500 font-mono text-xs tracking-tight">{{ __('Configure new learning module for curriculum integration.') }}</p>
        </div>
    </div>

    <!-- Configuration Panel -->
    <div class="bg-zinc-900/40 backdrop-blur-sm p-10 rounded-[2.5rem] border border-zinc-800 shadow-2xl relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-violet-500/5 blur-3xl rounded-full -mr-16 -mt-16"></div>
        
        <form wire:submit="save" class="space-y-8 relative">
            <div class="space-y-6">
                <flux:input 
                    wire:model="title" 
                    label="{{ __('Operational Title') }}" 
                    placeholder="{{ __('e.g. Advanced Laravel Architecture') }}" 
                    description="{{ __('The main heading for your learning module.') }}" 
                    required 
                    class="!bg-zinc-950/50 !border-zinc-800 !text-zinc-200 !font-mono text-sm uppercase tracking-tight focus:!border-violet-500/50 !rounded-xl"
                />
                
                <div class="space-y-3">
                    <flux:label class="!text-zinc-400 font-black text-[10px] uppercase tracking-[0.2em]">{{ __('Identity Visual') }}</flux:label>
                    <div class="flex items-center gap-6 p-4 rounded-2xl bg-zinc-950/30 border border-zinc-800/50">
                        @if($thumbnail)
                            <div class="relative shrink-0 w-24 h-24 rounded-xl border border-violet-500/30 p-1 bg-zinc-950 overflow-hidden shadow-2xl">
                                <img src="{{ $thumbnail->temporaryUrl() }}" class="w-full h-full object-cover rounded-lg" />
                            </div>
                        @else
                            <div class="w-24 h-24 rounded-xl border-2 border-dashed border-zinc-800 flex flex-col items-center justify-center text-zinc-700">
                                <flux:icon.photo class="w-8 h-8 opacity-20" />
                                <span class="text-[8px] font-black uppercase mt-1">{{ __('No Signal') }}</span>
                            </div>
                        @endif
                        <div class="flex-1">
                            <flux:input 
                                wire:model="thumbnail" 
                                type="file" 
                                accept="image/*" 
                                description="{{ __('Recommended: 1280x720 (16:9). Maximum high-fidelity transmission.') }}" 
                                class="!bg-zinc-950/50 !border-zinc-800 !text-zinc-400 !font-mono text-xs"
                            />
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <flux:input 
                        wire:model="author_name" 
                        label="{{ __('Mission Lead') }}" 
                        placeholder="{{ __('e.g. Jeffrey Way') }}" 
                        class="!bg-zinc-950/50 !border-zinc-800 !text-zinc-200 !font-mono text-sm uppercase tracking-tight focus:!border-violet-500/50 !rounded-xl"
                    />
                    <flux:select 
                        wire:model="level" 
                        label="{{ __('Complexity Level') }}"
                        class="!bg-zinc-950/50 !border-zinc-800 !text-zinc-200 !font-mono text-sm uppercase tracking-tight focus:!border-violet-500/50 !rounded-xl"
                    >
                        <flux:select.option>{{ __('Beginner') }}</flux:select.option>
                        <flux:select.option>{{ __('Intermediate') }}</flux:select.option>
                        <flux:select.option>{{ __('Advanced') }}</flux:select.option>
                    </flux:select>
                </div>

                <flux:input 
                    wire:model="category" 
                    label="{{ __('Domain Sector') }}" 
                    placeholder="{{ __('e.g. Frameworks, PHP, AI...') }}" 
                    class="!bg-zinc-950/50 !border-zinc-800 !text-zinc-200 !font-mono text-sm uppercase tracking-tight focus:!border-violet-500/50 !rounded-xl"
                />

                <flux:textarea 
                    wire:model="description" 
                    label="{{ __('Mission Briefing') }}" 
                    placeholder="{{ __('Outline the technical objectives and learning outcomes...') }}" 
                    rows="4" 
                    required 
                    class="!bg-zinc-950/50 !border-zinc-800 !text-zinc-300 !font-mono text-sm uppercase tracking-tight focus:!border-violet-500/50 !rounded-xl"
                />
                
                <div class="p-6 rounded-2xl bg-zinc-950/30 border border-zinc-800/50 group/switch transition-all hover:border-violet-500/20">
                    <flux:switch 
                        wire:model="is_published" 
                        label="{{ __('Initialize Live Stream') }}" 
                        description="{{ __('If active, this unit will be visible for operational training.') }}" 
                    />
                </div>
            </div>
            
            <div class="pt-10 flex justify-end gap-6 border-t border-zinc-800/80">
                <flux:button href="{{ route('admin.playlists.index') }}" variant="ghost" wire:navigate class="!text-zinc-500 hover:!text-white uppercase font-black text-[10px] tracking-widest px-6 transition-all">
                    {{ __('Abort Mission') }}
                </flux:button>
                <div class="relative">
                    <flux:button type="submit" variant="primary" class="!bg-violet-600 hover:!bg-violet-500 !text-[11px] font-black uppercase tracking-[0.2em] px-10 py-3 rounded-xl transition-all shadow-[0_0_30px_rgba(139,92,246,0.3)]">
                        {{ __('Confirm Deployment') }}
                    </flux:button>
                    <div class="absolute -bottom-1 -right-1 w-2 h-2 border-b border-r border-violet-500/50"></div>
                </div>
            </div>
        </form>
    </div>
</div>