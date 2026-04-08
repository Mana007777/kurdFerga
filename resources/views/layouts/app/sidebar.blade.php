<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-zinc-950 text-slate-300 font-sans antialiased overflow-x-hidden relative selection:bg-violet-500/30 selection:text-violet-200">
        <style>
            .glass-panel {
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(24px);
                -webkit-backdrop-filter: blur(24px);
                border: 1px solid rgba(0, 0, 0, 0.1);
            }
            .dark .glass-panel {
                background: rgba(31, 41, 55, 0.4);
                border: 1px solid rgba(255, 255, 255, 0.05);
            }

            /* Force Smooth Flux Sidebar Transitions */
            ui-sidebar, flux-sidebar, [data-flux-sidebar] {
                transition-property: width, max-width, min-width, transform, opacity !important;
                transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1) !important;
                transition-duration: 400ms !important;
            }

            /* Hide Scrollbars */
            ::-webkit-scrollbar { display: none; }
            * { -ms-overflow-style: none; scrollbar-width: none; }

            /* Premium Purple Active States */
            [data-flux-sidebar-item][data-current] {
                background-color: color-mix(in srgb, var(--color-violet-600) 20%, transparent) !important;
                color: white !important;
                border: 1px solid var(--color-violet-500/20) !important;
            }
            [data-flux-sidebar-item][data-current] [data-flux-icon] {
                color: var(--color-violet-400) !important;
            }

        </style>

        <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none bg-zinc-950">
            <div class="absolute inset-0 z-0 bg-dot-pattern opacity-5 dark:opacity-[0.03] pointer-events-none"></div>
        </div>

        <div class="relative z-10 flex min-h-screen">
            <flux:sidebar sticky stashable collapsible class="relative border-e border-zinc-800 bg-zinc-950">
                <flux:sidebar.header class="flex items-center justify-between">
                    <x-app-logo :sidebar="true" :href="auth()->check() ? route('dashboard') : route('home')" wire:navigate />
                    <flux:sidebar.toggle class="hidden lg:flex" icon="chevron-left" />
                    <flux:sidebar.collapse class="lg:hidden" />
                </flux:sidebar.header>

                <flux:sidebar.nav>
                    @auth
                        {{-- Section: Navigation --}}
                        <div class="mb-4">
                             <div class="flex items-center gap-2 px-3 mb-2">
                                <span class="text-[9px] font-mono text-zinc-600">NAV // 01</span>
                                <div class="h-[1px] flex-1 bg-zinc-800/50"></div>
                            </div>
                            <flux:sidebar.group :heading="__('Platform')" class="grid w-full !gap-1">
                                <flux:sidebar.item icon="command-line" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate class="!text-zinc-400 hover:!text-white group/item relative overflow-hidden transition-all duration-300">
                                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-0.5 h-0 bg-violet-600 group-hover/item:h-4 transition-all"></div>
                                    <span class="flex items-center justify-between w-full">
                                        {{ __('Dashboard') }}
                                        <span class="text-[8px] font-mono opacity-0 group-hover/item:opacity-50 tracking-tighter">[ID:001]</span>
                                    </span>
                                </flux:sidebar.item>
                                <flux:sidebar.item icon="chart-bar-square" :href="route('activity')" :current="request()->routeIs('activity')" wire:navigate class="!text-zinc-400 hover:!text-white group/item relative overflow-hidden transition-all duration-300">
                                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-0.5 h-0 bg-violet-600 group-hover/item:h-4 transition-all"></div>
                                    <span class="flex items-center justify-between w-full">
                                        {{ __('Activity') }}
                                        <span class="text-[8px] font-mono opacity-0 group-hover/item:opacity-50 tracking-tighter">[ID:002]</span>
                                    </span>
                                </flux:sidebar.item>
                                <flux:sidebar.item icon="user" :href="route('profile.edit')" :current="request()->requestUri === '/profile'" wire:navigate class="!text-zinc-400 hover:!text-white group/item relative overflow-hidden transition-all duration-300">
                                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-0.5 h-0 bg-violet-600 group-hover/item:h-4 transition-all"></div>
                                    <span class="flex items-center justify-between w-full">
                                        {{ __('My Profile') }}
                                        <span class="text-[8px] font-mono opacity-0 group-hover/item:opacity-50 tracking-tighter">[SYS]</span>
                                    </span>
                                </flux:sidebar.item>
                                <flux:sidebar.item icon="star" :href="route('stars.index')" :current="request()->routeIs('stars.index')" wire:navigate class="!text-zinc-400 hover:!text-white group/item relative overflow-hidden transition-all duration-300">
                                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-0.5 h-0 bg-violet-600 group-hover/item:h-4 transition-all"></div>
                                    <span class="flex items-center justify-between w-full">
                                        {{ __('Starred Videos') }}
                                        <span class="text-[8px] font-mono opacity-0 group-hover/item:opacity-50 tracking-tighter">[FAV]</span>
                                    </span>
                                </flux:sidebar.item>
                            </flux:sidebar.group>
                        </div>

                        @if(auth()->user()->isAdmin())
                             <div class="mb-4">
                                <div class="flex items-center gap-2 px-3 mb-2 mt-6">
                                    <span class="text-[9px] font-mono text-zinc-600">CMD // 02</span>
                                    <div class="h-[1px] flex-1 bg-zinc-800/50"></div>
                                </div>
                                <flux:sidebar.group :heading="__('Administration')" class="grid w-full !gap-1">
                                    <flux:sidebar.item icon="academic-cap" :href="route('admin.playlists.index')" :current="request()->routeIs('admin.playlists.*')" wire:navigate class="!text-zinc-400 hover:!text-white group/item relative overflow-hidden transition-all duration-300">
                                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-0.5 h-0 bg-violet-600 group-hover/item:h-4 transition-all"></div>
                                        <span class="flex items-center justify-between w-full">
                                            {{ __('Curriculum') }}
                                            <span class="text-[8px] font-mono opacity-0 group-hover/item:opacity-50 tracking-tighter">[ROOT]</span>
                                        </span>
                                    </flux:sidebar.item>
                                </flux:sidebar.group>
                            </div>
                        @endif

                        <div class="mb-4">
                            <div class="flex items-center gap-2 px-3 mb-2 mt-6">
                                <span class="text-[9px] font-mono text-zinc-600">NET // 03</span>
                                <div class="h-[1px] flex-1 bg-zinc-800/50"></div>
                            </div>
                            <flux:sidebar.group :heading="__('Community')" class="grid w-full !gap-1">
                                <flux:sidebar.item icon="trophy" :href="route('leaderboard')" :current="request()->routeIs('leaderboard')" wire:navigate class="!text-zinc-400 hover:!text-white group/item relative overflow-hidden transition-all duration-300">
                                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-0.5 h-0 bg-violet-600 group-hover/item:h-4 transition-all"></div>
                                    <span class="flex items-center justify-between w-full">
                                        {{ __('Leaderboard') }}
                                        <span class="text-[8px] font-mono opacity-0 group-hover/item:opacity-50 tracking-tighter">[RANK]</span>
                                    </span>
                                </flux:sidebar.item>
                            </flux:sidebar.group>
                        </div>
                    @endauth

                    <div class="px-3 mb-2 mt-8">
                         <div class="h-[1px] w-full bg-zinc-800/50"></div>
                    </div>

                    <flux:sidebar.item icon="map" :href="route('paths.index')" :current="request()->routeIs('paths.index')" wire:navigate class="!text-zinc-400 hover:!text-white group/item relative overflow-hidden transition-all duration-300">
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-0.5 h-0 bg-violet-600 group-hover/item:h-4 transition-all"></div>
                         <span class="flex items-center justify-between w-full">
                            {{ __('Learning Paths') }}
                            <span class="text-[8px] font-mono opacity-0 group-hover/item:opacity-50 tracking-tighter">[MAP]</span>
                        </span>
                    </flux:sidebar.item>

                    <flux:sidebar.item icon="squares-2x2" :href="route('playlists.index')" :current="request()->routeIs('playlists.index')" wire:navigate class="mt-2 !text-zinc-400 hover:!text-white group/item relative overflow-hidden transition-all duration-500">
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-0.5 h-0 bg-violet-600 group-hover/item:h-4 transition-all"></div>
                         <span class="flex items-center justify-between w-full">
                            {{ __('View All Playlists') }}
                             <span class="text-[8px] font-mono opacity-0 group-hover/item:opacity-50 tracking-tighter">[ALL]</span>
                        </span>
                    </flux:sidebar.item>

                    <div class="mb-4">
                        <div class="flex items-center gap-2 px-3 mb-2 mt-8">
                            <span class="text-[9px] font-mono text-zinc-600">LOC // 04</span>
                            <div class="h-[1px] flex-1 bg-zinc-800/50"></div>
                        </div>
                        <div class="px-3 flex items-center gap-2">
                            <a href="{{ route('lang.switch', 'en') }}" class="flex-1 py-2 rounded-lg text-center text-[10px] font-black uppercase tracking-widest transition-all {{ app()->getLocale() === 'en' ? 'bg-violet-600 text-white shadow-[0_0_15px_rgba(139,92,246,0.5)]' : 'bg-zinc-900 text-zinc-500 hover:bg-zinc-800' }}">
                                EN
                            </a>
                            <a href="{{ route('lang.switch', 'ckb') }}" class="flex-1 py-2 rounded-lg text-center text-[10px] font-black uppercase tracking-widest transition-all {{ app()->getLocale() === 'ckb' ? 'bg-violet-600 text-white shadow-[0_0_15px_rgba(139,92,246,0.5)]' : 'bg-zinc-900 text-zinc-500 hover:bg-zinc-800' }}">
                                KU
                            </a>
                        </div>
                    </div>
                </flux:sidebar.nav>

            <flux:spacer />


            @auth
                <flux:dropdown position="top" align="start">
                    <flux:profile
                        :name="auth()->user()->name"
                        :avatar="auth()->user()->profilePhotoUrl()"
                        :src="auth()->user()->profilePhotoUrl()"
                        icon-trailing="chevron-up"
                        class="cursor-pointer hover:bg-white/5 rounded-xl transition-colors border border-transparent hover:border-zinc-800 p-2"
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
            @else
                <div class="flex flex-col gap-2 p-2">
                    <flux:button :href="route('login')" variant="primary" size="sm" class="w-full">{{ __('Login') }}</flux:button>
                    <flux:button :href="route('register')" variant="ghost" size="sm" class="w-full">{{ __('Register') }}</flux:button>
                </div>
            @endauth
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            @auth
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
            @else
                <flux:button :href="route('login')" variant="ghost" size="sm">{{ __('Login') }}</flux:button>
            @endauth
        </flux:header>

        <div class="flex-1 flex flex-col min-h-screen">
            {{ $slot }}
        </div>

        @fluxScripts
    </body>
</html>
