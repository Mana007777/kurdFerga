<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      class="dark scroll-smooth">
    <head>
        @include('partials.head')
    </head>
    <body class="antialiased font-sans bg-zinc-950 overflow-x-hidden">
        {{ $slot }}
        @fluxScripts
    </body>
</html>
