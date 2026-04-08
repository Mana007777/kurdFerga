<section class="w-full">
    <flux:heading class="sr-only">{{ __('Appearance settings') }}</flux:heading>

    <x-pages::settings.layout :heading="__('Interface Specs')" :subheading="__('Update the visual interface parameters for your terminal.')">
        <div class="max-w-xl space-y-12">
            <div class="bg-zinc-900/50 border border-zinc-900 rounded-[2rem] p-8 md:p-12 relative overflow-hidden group">
                <div class="absolute inset-0 bg-violet-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                
                <div class="relative z-10 space-y-8">
                    <div class="flex items-center gap-3">
                        <flux:icon.swatch class="w-5 h-5 text-violet-500" />
                        <h2 class="text-xs font-black text-zinc-500 uppercase tracking-[0.2em]">Ocular Sync Mode</h2>
                    </div>

                    <div class="w-full">
                        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance" class="!bg-zinc-950 !p-1 !rounded-2xl !border-zinc-800">
                            <flux:radio value="light" icon="sun" class="!text-[10px] !font-black !uppercase !tracking-widest !py-4 !rounded-xl transition-all">{{ __('Light') }}</flux:radio>
                            <flux:radio value="dark" icon="moon" class="!text-[10px] !font-black !uppercase !tracking-widest !py-4 !rounded-xl transition-all">{{ __('Dark') }}</flux:radio>
                            <flux:radio value="system" icon="computer-desktop" class="!text-[10px] !font-black !uppercase !tracking-widest !py-4 !rounded-xl transition-all">{{ __('System') }}</flux:radio>
                        </flux:radio.group>
                    </div>

                    <p class="text-[8px] font-mono text-zinc-600 uppercase tracking-widest leading-relaxed">
                        Note: The Mission Control aesthetic is optimized for high-contrast dark environments. Switching to Light mode will maintain structural integrity but may reduce visual depth.
                    </p>
                </div>

                <!-- Corner Brackets -->
                <div class="absolute top-4 left-4 w-2 h-2 border-t border-l border-white/5"></div>
                <div class="absolute bottom-4 right-4 w-2 h-2 border-b border-r border-white/5"></div>
            </div>
        </div>
    </x-pages::settings.layout>
</section>
