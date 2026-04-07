<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-slate-50 dark:bg-gray-900 text-slate-800 dark:text-gray-300 font-sans antialiased overflow-x-hidden relative selection:bg-violet-500 selection:text-white">

        <!-- Animated Background Orbs -->
        <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none bg-slate-50 dark:bg-gray-950">
            <div class="absolute inset-0 z-0 bg-dot-pattern opacity-5 dark:opacity-[0.03] pointer-events-none"></div>
        </div>

        <div class="relative z-10 flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-md flex-col gap-2">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    <div class="relative w-12 h-12 bg-gradient-to-br from-violet-500 to-plum-600 rounded-lg flex items-center justify-center shadow-[0_0_20px_rgba(238,130,238,0.4)] border border-white/20 mb-2">
                        <svg class="w-7 h-7 text-white drop-shadow-md" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </a>
                <div class="flex flex-col gap-6 w-full">
                    {{ $slot }}
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
