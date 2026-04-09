<div class="min-h-screen bg-zinc-950 p-6 lg:p-12">
    <div class="max-w-3xl mx-auto">
        {{-- Header Section --}}
        <div class="flex items-center justify-between mb-12">
            <div class="space-y-1">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-violet-500/10 rounded-lg border border-violet-500/20">
                        <flux:icon.user-plus class="w-5 h-5 text-violet-400" />
                    </div>
                    <h1 class="text-3xl font-black text-white tracking-tight uppercase italic">{{ __('Enlist Instructor') }}</h1>
                </div>
                <p class="text-[10px] font-mono text-zinc-500 tracking-[0.3em] uppercase">{{ __('System // Personnel // Deployment') }}</p>
            </div>
            
            <flux:button href="{{ route('admin.playlists.index') }}" variant="ghost" wire:navigate class="!text-zinc-500 hover:!text-white uppercase font-black text-[10px] tracking-widest px-4">
                <flux:icon.arrow-left class="w-3 h-3 mr-2" />
                {{ __('Control Center') }}
            </flux:button>
        </div>

        {{-- Form Section --}}
        <form wire:submit="save" class="space-y-8 relative">
            {{-- Decorative Grid Lines --}}
            <div class="absolute -top-10 -left-10 w-40 h-40 border-t border-l border-zinc-900 pointer-events-none"></div>
            <div class="absolute -bottom-10 -right-10 w-40 h-40 border-b border-r border-zinc-900 pointer-events-none"></div>

            <div class="bg-zinc-900/40 border border-zinc-800/50 rounded-[2rem] p-8 lg:p-10 backdrop-blur-xl shadow-2xl relative overflow-hidden">
                {{-- Interior Glow --}}
                <div class="absolute inset-0 bg-gradient-to-br from-violet-500/5 to-transparent pointer-events-none"></div>
                
                <div class="space-y-8">
                    {{-- Name Field --}}
                    <flux:input 
                        wire:model="name" 
                        label="{{ __('Full Name') }}" 
                        placeholder="{{ __('The Instructor\'s designated designation...') }}"
                        class="!bg-zinc-950/50 !border-zinc-800 !text-white rounded-xl h-14 px-5"
                    />

                    {{-- Email Field --}}
                    <flux:input 
                        wire:model="email" 
                        type="email"
                        label="{{ __('Network ID (Email)') }}" 
                        placeholder="instructor@ferga.com"
                        class="!bg-zinc-950/50 !border-zinc-800 !text-white rounded-xl h-14 px-5"
                    />

                    {{-- Password Field --}}
                    <flux:input 
                        wire:model="password" 
                        type="password"
                        label="{{ __('Access Key (Password)') }}" 
                        placeholder="••••••••"
                        class="!bg-zinc-950/50 !border-zinc-800 !text-white rounded-xl h-14 px-5"
                    />

                    <div class="p-4 bg-violet-600/5 border border-violet-500/20 rounded-xl">
                        <div class="flex items-start gap-4">
                            <flux:icon.shield-check class="w-5 h-5 text-violet-400 mt-1" />
                            <div>
                                <h4 class="text-xs font-black text-violet-400 uppercase tracking-widest">{{ __('Instructor Authorization') }}</h4>
                                <p class="text-xs text-zinc-500 mt-1">{{ __('This account will be granted instructor level access to manage their own curriculum and playlists.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="pt-10 flex justify-end gap-6 border-t border-zinc-800/80">
                <flux:button href="{{ route('admin.playlists.index') }}" variant="ghost" wire:navigate class="!text-zinc-500 hover:!text-white uppercase font-black text-[10px] tracking-widest px-6 transition-all">
                    {{ __('Abort Mission') }}
                </flux:button>
                <div class="relative">
                    <flux:button type="submit" variant="primary" class="!bg-violet-600 hover:!bg-violet-500 !text-[11px] font-black uppercase tracking-[0.2em] px-10 py-3 rounded-xl transition-all shadow-[0_0_30px_rgba(139,92,246,0.3)]">
                        {{ __('Confirm Enlistment') }}
                    </flux:button>
                    <div class="absolute -bottom-1 -right-1 w-2 h-2 border-b border-r border-violet-500/50"></div>
                </div>
            </div>
        </form>
    </div>
</div>
