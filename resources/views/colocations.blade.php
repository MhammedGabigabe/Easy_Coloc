<x-app-layout>
    <!-- Initialisation d'Alpine.js pour le Popup -->
    <div x-data="{ openCreateModal: false }" class="px-4 py-8 sm:px-6 lg:px-8 bg-[#f8fafc] h-screen overflow-hidden relative">
        
        <!-- HEADER DE LA PAGE -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
            <div>
                <h2 class="text-3xl font-black uppercase italic tracking-tighter text-slate-800">
                    Mes <span class="text-indigo-600">Colocations</span>
                </h2>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-[0.2em] mt-1 italic">Gérez vos espaces de vie commune</p>
            </div>

            <!-- Profil Utilisateur -->
            <div class="flex items-center space-x-4">
                <div class="text-right leading-tight hidden sm:block">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-800 italic">{{ Auth::user()->name }}</p>
                    <p class="text-[9px] font-black text-emerald-500 uppercase tracking-tighter">En ligne</p>
                </div>
                <!-- Initiales dynamiques avec fallback si pas d'espace dans le nom -->
                <div class="h-10 w-10 bg-slate-900 text-white rounded-xl flex items-center justify-center font-black text-sm border-2 border-white shadow-sm italic transform hover:scale-105 transition-transform cursor-pointer">
                    @php
                        $name = Auth::user()->name;
                        $initials = strtoupper(substr($name, 0, 1));
                        if (strpos($name, ' ') !== false) {
                            $initials .= strtoupper(substr(strstr($name, ' '), 1, 1));
                        }
                    @endphp
                    {{ $initials }}
                </div>
            </div>
        </div>

        <!-- BOUTON CREER (Déclenche le popup) -->
        <button @click="openCreateModal = true" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-[1.5rem] text-sm font-black shadow-xl shadow-indigo-100 transition-all transform hover:scale-105 active:scale-95 flex items-center space-x-3 uppercase tracking-widest">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
            <span>Nouvelle Colocation</span>
        </button>

        <!-- GRILLE DES COLOCATIONS EXISTANTES -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-8 mb-12">
            @foreach($colocations as $coloc)
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl hover:border-indigo-100 transition-all duration-500 group overflow-hidden">
                <div class="p-8">
                    <div class="flex justify-between items-start mb-6">
                        <div class="bg-indigo-50 p-3 rounded-2xl text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        </div>
                        <span class="bg-indigo-100 text-indigo-600 text-[9px] font-black uppercase px-3 py-1 rounded-full italic tracking-widest">Owner</span>
                    </div>
                    
                    <h3 class="text-xl font-black text-slate-800 mb-2 italic tracking-tight uppercase">{{ $coloc->nom_coloc}}</h3>
                    <p class="text-slate-400 text-xs font-medium mb-6">Créée récemment • 1 membre actif</p>
                    
                    <div class="flex -space-x-3 mb-8">
                        <div class="w-10 h-10 rounded-xl bg-slate-900 border-2 border-white flex items-center justify-center text-[10px] font-black text-white italic">{{ $initials }}</div>
                    </div>
                </div>
                <div class="bg-slate-50 p-4 px-8 flex justify-between items-center group-hover:bg-indigo-50 transition-colors">
                    <a href="{{ route('colocations.show', $coloc->id) }}" class="text-[10px] font-black uppercase text-indigo-600 hover:underline tracking-widest italic">Gérer &rarr;</a>
                </div>
            
            </div>
            @endforeach

        </div>

        <!-- ========================================== -->
        <!-- POPUP (MODAL) DE CRÉATION -->
        <!-- ========================================== -->
        <div x-show="openCreateModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;">
            
            <!-- Overlay flou -->
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-md"></div>

            <div class="relative min-h-screen flex items-center justify-center p-4">
                <div @click.away="openCreateModal = false" 
                     class="relative bg-white w-full max-w-md rounded-[3rem] shadow-[0_30px_80px_rgba(0,0,0,0.4)] overflow-hidden border border-white">

                    <!-- Formulaire (Un seul input comme demandé) -->
                    <form action="{{ route('colocations.store') }}" method="POST" class="p-10 space-y-8">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-2 italic">Nom de la colocation</label>
                            <input type="text" name="nom_coloc" required placeholder="Ex: APPRT Name" 
                                   class="w-full bg-slate-50 border-none rounded-2xl py-5 px-6 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 transition-all placeholder:text-slate-300">
                        </div>

                        <div class="flex flex-col items-center space-y-4 pt-2">
                            <form action="{{ route('colocations.store') }}" method="POST">
                                <button type="submit" 
                                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-5 rounded-2xl text-[11px] font-black uppercase tracking-[0.2em] shadow-xl shadow-indigo-200 transition-all transform active:scale-95">
                                    Créer la colocation
                                </button>
                            </form>
                            <button type="button" @click="openCreateModal = false" 
                                    class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-slate-600 transition">
                                Annuler
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- FIN POPUP -->

    </div>
</x-app-layout>