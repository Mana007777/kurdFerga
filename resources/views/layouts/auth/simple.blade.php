<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-zinc-950 text-slate-400 font-sans antialiased overflow-x-hidden relative selection:bg-violet-500 selection:text-white">

        <!-- Background Infrastructure -->
        <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none bg-zinc-950">
            <div class="absolute inset-0 z-0 bg-dot-pattern opacity-10 pointer-events-none"></div>
        </div>

        <div class="relative z-10 flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-md flex-col gap-2">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    <div class="relative w-12 h-12 bg-zinc-900 border border-zinc-800 rounded-xl flex items-center justify-center transform hover:rotate-12 transition-all duration-300 shadow-2xl">
                        <flux:icon.command-line class="w-6 h-6 text-violet-500" />
                    </div>
                </a>
                <div class="flex flex-col gap-6 w-full mt-4">
                    {{ $slot }}
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
