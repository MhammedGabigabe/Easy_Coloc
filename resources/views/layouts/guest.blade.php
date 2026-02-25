<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'EasyColoc') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <!-- h-screen + overflow-hidden = Zéro scroll possible -->
    <body class="font-sans antialiased bg-easy-dark text-gray-200 h-screen overflow-hidden">
        
        <div class="h-full w-full flex flex-col justify-center items-center bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-slate-800 via-easy-dark to-easy-dark">
            
            <!-- LOGO DESIGN DESKTOP -->
            <div class="mb-8 text-center animate-fade-in-down">
                <h1 class="text-6xl font-black tracking-tighter">
                    <span class="text-easy-blue">Easy</span><span class="text-white">Coloc</span>
                </h1>
                <p class="mt-1 text-gray-400 text-sm font-light tracking-[0.3em] uppercase opacity-80">
                    Vivre ensemble, simplement
                </p>
            </div>

            <!-- FORMULAIRE COMPACT (max-w-[400px]) -->
            <div class="w-full max-w-[400px] px-10 py-10 bg-white/[0.03] backdrop-blur-2xl shadow-[0_20px_50px_rgba(0,0,0,0.5)] rounded-[2.5rem] border border-white/10 ring-1 ring-white/5">
                {{ $slot }}
            </div>

            <!-- Footer discret -->
            <p class="mt-8 text-xs text-gray-600 font-medium uppercase tracking-widest pointer-events-none">
                &copy; {{ date('Y') }} EasyColoc Platform
            </p>
        </div>
    </body>
</html>