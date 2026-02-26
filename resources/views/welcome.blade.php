<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>EasyColoc - Vivre ensemble, simplement</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-easy-dark text-white h-screen overflow-hidden">
        
        <!-- Navigation Minimaliste -->
        <nav class="absolute top-0 w-full px-12 py-8 flex justify-between items-center z-50">
            <div class="flex items-center">
                <span class="text-2xl font-bold tracking-tighter"><span class="text-easy-blue">Easy</span>Coloc</span>
            </div>
            
            @if (Route::has('login'))
                <div class="space-x-8">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-medium hover:text-easy-blue transition">Tableau de bord</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium hover:text-easy-blue transition">Se connecter</a>
                        <a href="{{ route('register') }}" class="bg-easy-blue hover:bg-blue-500 px-6 py-2.5 rounded-full text-sm font-bold transition shadow-lg shadow-blue-500/20">Rejoindre</a>
                    @endauth
                </div>
            @endif
        </nav>

        <!-- Section Hero -->
        <main class="h-full w-full flex items-center px-12 bg-[radial-gradient(circle_at_bottom_left,_var(--tw-gradient-stops))] from-slate-800 via-easy-dark to-easy-dark">
            
            <div class="container mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <!-- Texte et Actions (Gauche) -->
                <div class="space-y-8 animate-fade-in">
                    <div>
                        <h1 class="text-6xl font-black leading-tight tracking-tighter">
                            Gérez votre coloc' <br>
                            <span class="text-easy-blue">sans prise de tête.</span>
                        </h1>
                        <p class="mt-6 text-xl text-gray-400 max-w-lg leading-relaxed font-light uppercase tracking-widest">
                            Vivre ensemble, simplement.
                        </p>
                    </div>

                    <div class="flex items-center space-x-6">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="group relative inline-flex items-center justify-center px-8 py-4 font-bold text-white transition-all duration-200 bg-easy-blue font-pj rounded-2xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 shadow-xl shadow-blue-500/20 hover:scale-105 active:scale-95" role="button">
                                Commencer l'aventure
                            </a>
                        @endif

                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white font-semibold transition-all border-b-2 border-transparent hover:border-easy-blue pb-1">
                            Se connecter &rarr;
                        </a>
                    </div>  
                </div>

                <!-- Image / Mockup (Droite) -->
                <div class="relative hidden lg:flex justify-center items-center">
                    <!-- Décoration lumineuse réduite proportionnellement -->
                    <div class="absolute w-56 h-56 bg-easy-blue/15 rounded-full blur-[70px]"></div>
                    
                    <div class="relative transform hover:rotate-1 transition-transform duration-700">
                        <!-- Taille ajustée à 280px (un peu plus petit que max-w-xs) -->
                        <img src="{{ asset('images/h.png') }}" 
                            alt="EasyColoc App Preview" 
                            class="w-[280px] h-auto drop-shadow-[0_20px_20px_rgba(0,0,0,0.5)] rounded-[2.8rem] border-[5px] border-white/5 bg-easy-dark">
                    </div>
                </div>

            </div>
        </main>

        <!-- Footer très discret -->
        <footer class="absolute bottom-8 w-full text-center text-gray-600 text-[10px] uppercase tracking-[0.4em]">
            Propulsé par la simplicité • EasyColoc © {{ date('Y') }}
        </footer>

    </body>
</html>