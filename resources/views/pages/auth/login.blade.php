<x-layouts::auth :title="__('Log in')">
    <div class="group relative rounded-3xl p-[2px] overflow-hidden shadow-2xl transition-all duration-500">
        <!-- Neon tracking border effect -->
        <span class="absolute inset-[-200%] bg-[conic-gradient(from_90deg_at_50%_50%,#00000000_50%,#3b82f6_100%)] opacity-0 group-hover:opacity-100 group-hover:animate-[spin_2s_linear_infinite] transition-all duration-500"></span>
        <span class="absolute inset-[-200%] bg-[conic-gradient(from_270deg_at_50%_50%,#00000000_50%,#a855f7_100%)] opacity-0 group-hover:opacity-100 group-hover:animate-[spin_2s_linear_infinite] transition-all duration-500"></span>
        
        <div class="relative z-10 bg-white dark:bg-[#050B14]/90 backdrop-blur-xl flex flex-col gap-6 rounded-[22px] p-8 border border-zinc-200 dark:border-white/5">
            <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />

            <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
                @csrf

                <!-- Email Address -->
                <flux:input
                    name="email"
                    :label="__('Email address')"
                    :value="old('email')"
                    type="email"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="email@example.com"
                />

                <!-- Password -->
                <div class="flex flex-col gap-2">
                    <flux:input
                        name="password"
                        :label="__('Password')"
                        type="password"
                        required
                        autocomplete="current-password"
                        :placeholder="__('Password')"
                        viewable
                    />

                    @if (Route::has('password.request'))
                        <div class="flex justify-end">
                            <flux:link class="text-sm text-blue-500 hover:text-blue-400" :href="route('password.request')" wire:navigate>
                                {{ __('Forgot your password?') }}
                            </flux:link>
                        </div>
                    @endif
                </div>

                <!-- Remember Me -->
                <flux:checkbox name="remember" :label="__('Remember me')" :checked="old('remember')" />

                <div class="flex items-center justify-end mt-2">
                    <flux:button variant="primary" type="submit" class="w-full relative group/btn overflow-hidden" data-test="login-button">
                        <span class="relative z-10">{{ __('Log in') }}</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-600 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
                    </flux:button>
                </div>
            </form>

            @if (Route::has('register'))
                <div class="space-x-1 mt-2 text-sm text-center rtl:space-x-reverse text-zinc-600 dark:text-gray-400">
                    <span>{{ __('Don\'t have an account?') }}</span>
                    <flux:link :href="route('register')" wire:navigate class="text-blue-500 font-bold hover:text-blue-400">{{ __('Sign up') }}</flux:link>
                </div>
            @endif
        </div>
    </div>
</x-layouts::auth>
