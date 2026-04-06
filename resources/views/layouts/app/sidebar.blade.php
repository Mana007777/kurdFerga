<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-slate-50 dark:bg-[#050B14] text-slate-800 dark:text-slate-300 font-sans antialiased overflow-x-hidden relative selection:bg-blue-500 selection:text-white">
        <style>
            @keyframes blob {
                0% { transform: translate(0px, 0px) scale(1); }
                33% { transform: translate(40px, -60px) scale(1.2); }
                66% { transform: translate(-30px, 40px) scale(0.8); }
                100% { transform: translate(0px, 0px) scale(1); }
            }
            .animate-blob { animation: blob 10s infinite alternate; }
            .animation-delay-2000 { animation-delay: 2s; }
            .animation-delay-4000 { animation-delay: 4s; }

            @keyframes scrollGrid {
                0% { transform: translateY(0); }
                100% { transform: translateY(24px); }
            }
            .bg-dot-pattern {
                background-image: radial-gradient(rgba(0, 0, 0, 0.1) 1px, transparent 1px);
                background-size: 24px 24px;
            }
            .dark .bg-dot-pattern {
                background-image: radial-gradient(rgba(255, 255, 255, 0.15) 1px, transparent 1px);
            }
            .mask-radial-faded {
                mask-image: radial-gradient(circle at center, black 10%, transparent 80%);
                -webkit-mask-image: radial-gradient(circle at center, black 10%, transparent 80%);
            }
            .animate-scroll-grid {
                animation: scrollGrid 1.5s linear infinite;
            }
            .glass-panel {
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(24px);
                -webkit-backdrop-filter: blur(24px);
                border: 1px solid rgba(0, 0, 0, 0.1);
            }
            .dark .glass-panel {
                background: rgba(15, 23, 42, 0.4);
                border: 1px solid rgba(255, 255, 255, 0.05);
            }

            /* Force Smooth Flux Sidebar Transitions */
            ui-sidebar, flux-sidebar, [data-flux-sidebar] {
                transition-property: width, max-width, min-width, transform, opacity !important;
                transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1) !important;
                transition-duration: 400ms !important;
            }

            @keyframes border-flow {
                0% { background-position: 0% 0%; }
                100% { background-position: 0% 200%; }
            }
            .animate-border-flow {
                background: linear-gradient(to bottom, transparent, #3b82f6, #6366f1, #a855f7, #6366f1, #3b82f6, transparent);
                background-size: 100% 200%;
                animation: border-flow 2s linear infinite;
            }
        </style>

        <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none bg-slate-50 dark:bg-[#020617]">
            <div class="absolute inset-[-10%] z-0 bg-dot-pattern mask-radial-faded opacity-50 animate-scroll-grid pointer-events-none"></div>
            <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-blue-600/10 dark:bg-blue-600/20 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-[100px] opacity-70 animate-blob"></div>
            <div class="absolute top-1/4 right-1/4 w-[600px] h-[600px] bg-indigo-600/10 dark:bg-indigo-600/20 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-[120px] opacity-70 animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-[-10%] left-1/3 w-[700px] h-[700px] bg-purple-600/10 dark:bg-purple-600/20 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-[150px] opacity-60 animate-blob animation-delay-4000"></div>
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-overlay hidden dark:block"></div>
        </div>

        <div class="relative z-10 flex min-h-screen">
            <flux:sidebar sticky stashable collapsible class="relative border-e border-slate-200 dark:border-white/5 bg-white/90 dark:bg-[#050B14]/90 backdrop-blur-3xl">
                <!-- Animated Right Glow Border -->
                <div class="absolute right-0 top-0 bottom-0 w-[2px] animate-border-flow z-[100] pointer-events-none shadow-[-2px_0_15px_rgba(59,130,246,0.5)] opacity-100"></div>
                <flux:sidebar.header class="flex items-center justify-between">
                    <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                    <flux:sidebar.toggle class="hidden lg:flex" icon="chevron-left" />
                    <flux:sidebar.collapse class="lg:hidden" />
                </flux:sidebar.header>

                <flux:sidebar.nav>
                    <flux:sidebar.group :heading="__('Platform')" class="grid w-full">
                        <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                            {{ __('Dashboard') }}
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="chart-bar" :href="route('activity')" :current="request()->routeIs('activity')" wire:navigate>
                            {{ __('Activity') }}
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="user" :href="route('profile.edit')" :current="request()->requestUri === '/profile'" wire:navigate>
                            {{ __('My Profile') }}
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="star" :href="route('stars.index')" :current="request()->routeIs('stars.index')" wire:navigate>
                            {{ __('Starred Videos') }}
                        </flux:sidebar.item>
                    </flux:sidebar.group>

                    @if(auth()->check() && auth()->user()->isAdmin())
                        <flux:sidebar.group :heading="__('Administration')" class="grid w-full mt-4">
                            <flux:sidebar.item icon="academic-cap" :href="route('admin.playlists.index')" :current="request()->routeIs('admin.playlists.*')" wire:navigate>
                                {{ __('Curriculum') }}
                            </flux:sidebar.item>
                        </flux:sidebar.group>
                    @endif

                    <flux:sidebar.item icon="squares-2x2" :href="route('playlists.index')" :current="request()->routeIs('playlists.index')" wire:navigate class="mt-4">
                        View All Playlists
                    </flux:sidebar.item>
                </flux:sidebar.nav>

            <flux:spacer />


            <flux:dropdown position="top" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :avatar="auth()->user()->profilePhotoUrl()"
                    :src="auth()->user()->profilePhotoUrl()"
                    icon-trailing="chevron-up"
                    class="cursor-pointer hover:bg-white/5 rounded-xl transition-colors"
                />

                <flux:menu>
                    <flux:menu.item :href="route('profile.edit')" icon="user" wire:navigate>
                        {{ __('My Profile') }}
                    </flux:menu.item>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer text-red-500 hover:bg-red-500/10"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :avatar="auth()->user()->profilePhotoUrl()"
                    :src="auth()->user()->profilePhotoUrl()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :src="auth()->user()->profilePhotoUrl()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        <div class="flex-1 flex flex-col min-h-screen">
            {{ $slot }}
        </div>

        @fluxScripts
    </body>
</html>
