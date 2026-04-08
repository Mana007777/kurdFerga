<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>
    {{ filled($title ?? null) ? $title.' - '.config('app.name', 'Laravel') : config('app.name', 'Laravel') }}
</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
    /* 🚀 Universal "Freaking Dark" System Overrides */
    
    /* Force Flux Input & Control Internals to be Dark */
    [data-flux-input] input, 
    [data-flux-input] textarea,
    [data-flux-control] input,
    [data-flux-control] textarea,
    [data-flux-select] select {
        background-color: transparent !important;
        color: white !important;
    }

    [data-flux-input], 
    [data-flux-control],
    [data-flux-select] {
        background-color: #09090b !important; /* zinc-950 */
        border-color: #27272a !important; /* zinc-800 */
    }

    /* Global Scrollbar Removal */
    ::-webkit-scrollbar { display: none !important; }
    * { -ms-overflow-style: none !important; scrollbar-width: none !important; }

    /* Handle Browser Autofill across all pages */
    input:-webkit-autofill,
    input:-webkit-autofill:hover, 
    input:-webkit-autofill:focus, 
    input:-webkit-autofill:active {
        -webkit-box-shadow: 0 0 0 30px #09090b inset !important;
        -webkit-text-fill-color: white !important;
        transition: background-color 5000s ease-in-out 0s;
    }

    /* Premium Active States for Sidebar & Navigation */
    [data-flux-sidebar-item][data-current] {
        background-color: rgba(139, 92, 246, 0.2) !important;
        color: white !important;
        border: 1px solid rgba(139, 92, 246, 0.2) !important;
    }
</style>
