<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      class="dark scroll-smooth">
    <head>
        @include('partials.head')
    </head>
    <body class="antialiased font-sans">
        {{ $slot }}
        @fluxScripts
    </body>
</html>
