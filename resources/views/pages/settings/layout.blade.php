<div class="flex items-start max-md:flex-col gap-12 p-8 md:p-12 lg:p-16 bg-black min-h-screen">
    {{-- Sidebar Navigation: Command List --}}
    <div class="w-full md:w-[280px] shrink-0">
        <div class="space-y-6">
            <div class="flex items-center gap-3 px-4">
                <div class="w-2 h-10 bg-violet-600 rounded-full"></div>
                <div>
                    <span class="block text-[8px] font-mono text-zinc-600 uppercase tracking-[0.3em]">System</span>
                    <h2 class="text-xl font-black text-white uppercase tracking-tight">Settings</h2>
                </div>
            </div>

            <nav class="space-y-1">
                @php
                    $navItems = [
                        ['route' => 'profile.edit', 'label' => 'Personnel Dossier', 'icon' => 'user-circle', 'id' => '01'],
                        ['route' => 'security.edit', 'label' => 'Security Protocol', 'icon' => 'shield-check', 'id' => '02'],
                        ['route' => 'appearance.edit', 'label' => 'Interface Specs', 'icon' => 'swatch', 'id' => '03'],
                    ];
                @endphp

                @foreach($navItems as $item)
                    <a href="{{ route($item['route']) }}" wire:navigate 
                       class="flex items-center justify-between group px-4 py-4 rounded-xl border {{ request()->routeIs($item['route']) ? 'bg-zinc-900 border-zinc-800' : 'border-transparent hover:bg-zinc-900/50 hover:border-zinc-800/50' }} transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <flux:icon :name="$item['icon']" class="w-5 h-5 {{ request()->routeIs($item['route']) ? 'text-violet-500' : 'text-zinc-600 group-hover:text-zinc-400' }} transition-colors" />
                            <span class="text-[10px] font-black uppercase tracking-widest {{ request()->routeIs($item['route']) ? 'text-white' : 'text-zinc-500 group-hover:text-zinc-300' }} transition-colors">
                                {{ $item['label'] }}
                            </span>
                        </div>
                        <span class="text-[8px] font-mono {{ request()->routeIs($item['route']) ? 'text-violet-500' : 'text-zinc-800' }}">[{{ $item['id'] }}]</span>
                    </a>
                @endforeach
            </nav>
        </div>
    </div>

    {{-- Main Content: Terminal Interface --}}
    <div class="flex-1 w-full max-w-4xl pt-4">
        <div class="relative bg-black border border-zinc-800 rounded-[3rem] p-10 md:p-16 overflow-hidden">
             <!-- Background Grid -->
             <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808008_1px,transparent_1px),linear-gradient(to_bottom,#80808008_1px,transparent_1px)] bg-[size:32px_32px]"></div>
             
             <div class="relative z-10 space-y-12">
                <div class="space-y-2">
                    <h1 class="text-4xl md:text-6xl font-black text-white uppercase tracking-tighter leading-none">{{ $heading ?? 'Configuration' }}</h1>
                    <p class="text-zinc-500 font-mono text-xs uppercase tracking-widest">{{ $subheading ?? 'Update your personnel parameters.' }}</p>
                </div>

                <div class="w-full">
                    {{ $slot }}
                </div>
             </div>

             <!-- Corner Brackets -->
             <div class="absolute top-12 left-12 w-4 h-4 border-t border-l border-zinc-800"></div>
             <div class="absolute top-12 right-12 w-4 h-4 border-t border-r border-zinc-800"></div>
             <div class="absolute bottom-12 left-12 w-4 h-4 border-b border-l border-zinc-800"></div>
             <div class="absolute bottom-12 right-12 w-4 h-4 border-b border-r border-zinc-800"></div>

             <!-- System Info -->
             <div class="absolute bottom-6 left-12 flex items-center gap-4 text-[8px] font-mono text-zinc-800 uppercase tracking-widest">
                <span>CON::SYS-77</span>
                <span class="w-1 h-3 bg-zinc-800"></span>
                <span>MODE::ADMIN</span>
             </div>
        </div>
    </div>
</div>
