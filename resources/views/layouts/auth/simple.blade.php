<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
        <style>
            /* Force Flux Input Internals to be Dark */
            [data-flux-input] input {
                background-color: transparent !important;
                color: white !important;
            }
            [data-flux-input] {
                background-color: #09090b !important; /* zinc-950 */
                border-color: #27272a !important; /* zinc-800 */
            }
            /* Handle Browser Autofill */
            input:-webkit-autofill,
            input:-webkit-autofill:hover, 
            input:-webkit-autofill:focus, 
            input:-webkit-autofill:active {
                -webkit-box-shadow: 0 0 0 30px #09090b inset !important;
                -webkit-text-fill-color: white !important;
                transition: background-color 5000s ease-in-out 0s;
            }
        </style>
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
