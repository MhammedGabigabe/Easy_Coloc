<aside x-data="{ open: false }" class="w-64 bg-white h-screen flex flex-col border-r border-slate-100 sticky top-0 z-50">
    <!-- Logo Section -->
    <div class="p-8 flex items-center space-x-3">
        <div class="text-indigo-600 bg-indigo-50 p-2 rounded-xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
        </div>
        <span class="text-xl font-black tracking-tighter text-indigo-900 italic">EasyColoc</span>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 px-4 space-y-2 mt-4">
        <!-- Colocations -->
        <a href="{{route('colocations.index')}}" class="flex items-center space-x-3 p-3 rounded-2xl {{ request()->routeIs('colocations.*') ? 'bg-indigo-50 text-indigo-600 font-bold' : 'text-slate-400 hover:bg-slate-50' }} transition group">
            <svg class="w-5 h-5 {{ request()->routeIs('colocations.*') ? 'text-indigo-600' : 'group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            <span class="text-sm">Colocations</span>
        </a>

        <!-- Section ADMIN -->
        @can('admin-access')
            <div class="pt-6 pb-2 px-3 text-[10px] font-black uppercase tracking-[0.2em] text-slate-300 italic">Admin</div>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-2xl transition {{ request()->routeIs('admin.*') ? 'bg-indigo-50 text-indigo-600 font-bold' : 'text-slate-400 hover:bg-slate-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                <span class="text-sm tracking-tight">Admin Global</span>
            </a>
        @endcan

        <!-- Profile -->
        <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 p-3 rounded-2xl transition {{ request()->routeIs('profile.edit') ? 'bg-indigo-50 text-indigo-600 font-bold' : 'text-slate-400 hover:bg-slate-50' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            <span class="text-sm">Mon Profil</span>
        </a>

        <!-- Déconnexion -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center space-x-3 p-3 rounded-2xl text-red-400 hover:bg-red-50 transition w-full mt-2 group">
                <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                <span class="text-xs font-black uppercase tracking-widest">Déconnexion</span>
            </button>
        </form>
    </nav>

    <!-- WIDGET STATS PERSO (Bas de sidebar) -->
    <div class="p-6 space-y-3">
        @php
            $solde = Auth::user()->solde_global;
            $reputation = Auth::user()->reputation ?? 0;
        @endphp

        <!-- Bloc Réputation -->
        <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm">
            <p class="text-[8px] font-black uppercase tracking-widest text-slate-400 mb-1 italic">Votre Réputation</p>
            <div class="flex items-center justify-between">
                <span class="text-xs font-black {{ $reputation >= 0 ? 'text-emerald-500' : 'text-red-500' }} italic">
                    {{ $reputation > 0 ? '+' : '' }}{{ $reputation }}
                </span>
                <span class="text-[7px] font-bold uppercase px-2 py-0.5 rounded {{ $reputation >= 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                    {{ $reputation >= 0 ? 'Fiable' : 'Risqué' }}
                </span>
            </div>
        </div>
        

    </div>
</aside>