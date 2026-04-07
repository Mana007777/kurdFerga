<x-layouts::auth :title="__('Register')">
    <div class="group relative rounded-3xl p-[2px] overflow-hidden shadow-2xl transition-all duration-500">
        <!-- Neon tracking border effect -->
        <span class="absolute inset-[-200%] bg-[conic-gradient(from_90deg_at_50%_50%,#00000000_50%,#3b82f6_100%)] opacity-0 group-hover:opacity-100 group-hover:animate-[spin_2s_linear_infinite] transition-all duration-500"></span>
        <span class="absolute inset-[-200%] bg-[conic-gradient(from_270deg_at_50%_50%,#00000000_50%,#a855f7_100%)] opacity-0 group-hover:opacity-100 group-hover:animate-[spin_2s_linear_infinite] transition-all duration-500"></span>
        
        <div class="relative z-10 bg-white dark:bg-[#050B14]/90 backdrop-blur-xl flex flex-col gap-6 rounded-[22px] p-8 border border-zinc-200 dark:border-white/5">
            <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />

            <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
                @csrf
                <!-- Name -->
                <flux:input
                    name="name"
                    :label="__('Name')"
                    :value="old('name')"
                    type="text"
                    required
                    autofocus
                    autocomplete="name"
                    :placeholder="__('Full name')"
                />

                <!-- Email Address -->
                <flux:input
                    name="email"
                    :label="__('Email address')"
                    :value="old('email')"
                    type="email"
                    required
                    autocomplete="email"
                    placeholder="email@example.com"
                />

                <!-- Password -->
                <flux:input
                    name="password"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="new-password"
                    :placeholder="__('Password')"
                    viewable
                />

                <!-- Confirm Password -->
                <flux:input
                    name="password_confirmation"
                    :label="__('Confirm password')"
                    type="password"
                    required
                    autocomplete="new-password"
                    :placeholder="__('Confirm password')"
                    viewable
                />

                <div class="flex items-center justify-end mt-2">
                    <flux:button type="submit" variant="primary" class="w-full relative group/btn overflow-hidden" data-test="register-user-button">
                        <span class="relative z-10">{{ __('Create account') }}</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-600 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
                    </flux:button>
                </div>
            </form>

            <div class="space-x-1 mt-2 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-gray-400">
                <span>{{ __('Already have an account?') }}</span>
                <flux:link :href="route('login')" wire:navigate class="text-blue-500 font-bold hover:text-blue-400">{{ __('Log in') }}</flux:link>
            </div>
        </div>
    </div>
</x-layouts::auth>
