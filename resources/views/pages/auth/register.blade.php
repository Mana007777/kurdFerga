<x-layouts::auth :title="__('Register')">
    <div class="group relative rounded-[2.5rem] p-[1.5px] overflow-hidden shadow-2xl transition-all duration-500">
        <!-- Neon tracking border effect -->
        <span class="absolute inset-[-200%] bg-[conic-gradient(from_90deg_at_50%_50%,#00000000_50%,#8b5cf6_100%)] opacity-20 group-hover:opacity-100 group-hover:animate-[spin_4s_linear_infinite] transition-all duration-700"></span>
        
        <div class="relative z-10 bg-zinc-950 flex flex-col gap-8 rounded-[2.4rem] p-10 border border-zinc-800">
            <x-auth-header :title="__('Node Initialization')" :description="__('Register a new identity on the intelligence network.')" />

            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />

            <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-8">
                @csrf
                <!-- Name -->
                <flux:input
                    name="name"
                    :label="__('Identity Alias (Name)')"
                    :value="old('name')"
                    type="text"
                    required
                    autofocus
                    autocomplete="name"
                    :placeholder="__('Operator Name')"
                    class="!bg-zinc-950 !border-zinc-800 !text-white !font-mono !text-xs tracking-widest focus:!border-violet-500/50"
                />

                <!-- Email Address -->
                <flux:input
                    name="email"
                    :label="__('Authorization Node (Email)')"
                    :value="old('email')"
                    type="email"
                    required
                    autocomplete="email"
                    placeholder="operator@intellbase.net"
                    class="!bg-zinc-950 !border-zinc-800 !text-white !font-mono !text-xs tracking-widest focus:!border-violet-500/50"
                />

                <!-- Password -->
                <flux:input
                    name="password"
                    :label="__('Access Key (Password)')"
                    type="password"
                    required
                    autocomplete="new-password"
                    :placeholder="__('Secure Sequence')"
                    viewable
                    class="!bg-zinc-950 !border-zinc-800 !text-white !font-mono !text-xs tracking-widest focus:!border-violet-500/50"
                />

                <!-- Confirm Password -->
                <flux:input
                    name="password_confirmation"
                    :label="__('Verification Sequence')"
                    type="password"
                    required
                    autocomplete="new-password"
                    :placeholder="__('Repeat Access Key')"
                    viewable
                    class="!bg-zinc-950 !border-zinc-800 !text-white !font-mono !text-xs tracking-widest focus:!border-violet-500/50"
                />

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="w-full relative group/btn h-12 bg-violet-600 rounded-2xl overflow-hidden transition-all duration-500 hover:scale-[1.02] active:scale-95 shadow-[0_0_30px_-5px_rgba(139,92,246,0.3)]">
                        <span class="relative z-10 text-[11px] font-black text-white uppercase tracking-[0.2em]">{{ __('Initialize Registration') }}</span>
                    </button>
                </div>
            </form>

            <div class="mt-4 pt-8 border-t border-zinc-800 text-center">
                <p class="text-[10px] font-black text-zinc-600 uppercase tracking-widest mb-4">Identity already exists?</p>
                <a href="{{ route('login') }}" wire:navigate class="inline-flex py-3 px-8 rounded-xl bg-zinc-900 border border-zinc-800 text-[10px] font-black text-zinc-400 uppercase tracking-widest hover:bg-zinc-800 hover:text-white transition-all duration-300">
                    {{ __('Authorize Session') }}
                </a>
            </div>
        </div>
    </div>
</x-layouts::auth>
