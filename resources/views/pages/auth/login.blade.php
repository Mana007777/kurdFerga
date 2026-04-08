<x-layouts::auth :title="__('Log in')">
    <div class="group relative rounded-[2.5rem] p-[1.5px] overflow-hidden shadow-2xl transition-all duration-500">
        <!-- Neon tracking border effect -->
        <span class="absolute inset-[-200%] bg-[conic-gradient(from_90deg_at_50%_50%,#00000000_50%,#8b5cf6_100%)] opacity-20 group-hover:opacity-100 group-hover:animate-[spin_4s_linear_infinite] transition-all duration-700"></span>
        
        <div class="relative z-10 bg-zinc-950 flex flex-col gap-8 rounded-[2.4rem] p-10 border border-zinc-800">
            <x-auth-header :title="__('Access Protocol')" :description="__('Enter credentials for system authorization.')" />

            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />

            <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-8">
                @csrf

                <!-- Email Address -->
                <flux:input
                    name="email"
                    :label="__('Authorization Node (Email)')"
                    :value="old('email')"
                    type="email"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="operator@intellbase.net"
                    class="!bg-zinc-900/50 !border-zinc-800 !text-white !font-mono !text-xs tracking-widest"
                />

                <!-- Password -->
                <div class="flex flex-col gap-3">
                    <flux:input
                        name="password"
                        :label="__('Access Key (Password)')"
                        type="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                        viewable
                        class="!bg-zinc-900/50 !border-zinc-800 !text-white !font-mono !text-xs tracking-widest"
                    />

                    @if (Route::has('password.request'))
                        <div class="flex justify-end">
                            <flux:link class="text-[10px] font-black uppercase tracking-widest text-zinc-500 hover:text-violet-500 transition-colors" :href="route('password.request')" wire:navigate>
                                {{ __('Request Reset') }}
                            </flux:link>
                        </div>
                    @endif
                </div>

                <!-- Remember Me -->
                <flux:checkbox name="remember" :label="__('Maintain Persistence')" :checked="old('remember')" class="!text-zinc-500 !text-[10px] font-black uppercase tracking-widest" />

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="w-full relative group/btn h-12 bg-white rounded-2xl overflow-hidden transition-all duration-500 hover:scale-[1.02] active:scale-95 shadow-[0_0_30px_-5px_rgba(255,255,255,0.2)]">
                        <span class="relative z-10 text-[11px] font-black text-zinc-950 uppercase tracking-[0.2em]">{{ __('Initialize Session') }}</span>
                    </button>
                </div>
            </form>

            @if (Route::has('register'))
                <div class="mt-4 pt-8 border-t border-zinc-800 text-center">
                    <p class="text-[10px] font-black text-zinc-600 uppercase tracking-widest mb-4">No active credentials?</p>
                    <a href="{{ route('register') }}" wire:navigate class="inline-flex py-3 px-8 rounded-xl bg-zinc-900 border border-zinc-800 text-[10px] font-black text-zinc-400 uppercase tracking-widest hover:bg-zinc-800 hover:text-white transition-all duration-300">
                        {{ __('Register New Node') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-layouts::auth>
