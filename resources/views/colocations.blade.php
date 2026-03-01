<x-app-layout>
    <div x-data="{ openCreateModal: false }" class="px-4 py-8 sm:px-6 lg:px-8 bg-[#f8fafc] min-h-screen overflow-y-auto relative">
        
        <!-- HEADER -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
            <div>
                <h2 class="text-3xl font-black uppercase italic tracking-tighter text-slate-800">
                    Mes <span class="text-indigo-600">Colocations</span>
                </h2>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-[0.2em] mt-1 italic">Gérez vos espaces de vie commune</p>
            </div>

            <div class="flex items-center space-x-4">
                <div class="text-right leading-tight hidden sm:block">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-800 italic">{{ Auth::user()->name }}</p>
                    <p class="text-[9px] font-black text-emerald-500 uppercase tracking-tighter">En ligne</p>
                </div>
                <div class="h-10 w-10 bg-slate-900 text-white rounded-xl flex items-center justify-center font-black text-sm border-2 border-white shadow-sm italic">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </div>

        <!-- BOUTON NOUVELLE COLOC -->
        <button @click="openCreateModal = true" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-[1.5rem] text-sm font-black shadow-xl shadow-indigo-100 transition-all transform hover:scale-105 active:scale-95 flex items-center space-x-3 uppercase tracking-widest">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
            <span>Nouvelle Colocation</span>
        </button>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-8 mb-12">
            
            <!-- BOUCLE OWNER -->
            @foreach($ownedColocations as $coloc)
            <div class="bg-white rounded-[2.5rem] border-2 {{ $coloc->status === 'cancelled' ? 'border-red-50' : 'border-indigo-50' }} shadow-sm hover:shadow-xl transition-all duration-500 group overflow-hidden">
                <div class="p-8">
                    <div class="flex justify-between items-start mb-6">
                        <div class="{{ $coloc->status === 'cancelled' ? 'bg-slate-100 text-slate-400' : 'bg-indigo-600 text-white shadow-indigo-100 shadow-lg' }} p-3 rounded-2xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        </div>
                        <span class="bg-slate-900 text-white text-[9px] font-black uppercase px-3 py-1 rounded-full italic tracking-widest shadow-sm">Owner</span>
                    </div>
                    
                    <h3 class="text-xl font-black {{ $coloc->status === 'cancelled' ? 'text-slate-400 line-through' : 'text-slate-800' }} mb-2 italic tracking-tight uppercase">{{ $coloc->nom_coloc }}</h3>
                    <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">
                        {{ $coloc->status === 'cancelled' ? 'Colocation annulée' : 'Vous êtes l\'administrateur' }}
                    </p>
                </div>
                <div class="bg-slate-50 p-4 px-8 flex justify-between items-center group-hover:bg-indigo-50 transition-colors">
                    <a href="{{ route('colocations.show', $coloc->id) }}" class="text-[10px] font-black uppercase text-indigo-600 hover:text-indigo-800 tracking-widest italic">
                        {{ $coloc->status === 'cancelled' ? 'Consulter l\'archive' : 'Gérer la coloc' }} &rarr;
                    </a>
                </div>
            </div>
            @endforeach

            <!-- BOUCLE MEMBER -->
            @foreach($memberships as $membership)
                @if($membership->colocation)
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-500 group overflow-hidden opacity-90 hover:opacity-100">
                    <div class="p-8">
                        <div class="flex justify-between items-start mb-6">
                            <div class="bg-slate-100 p-3 rounded-2xl text-slate-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <span class="bg-indigo-50 text-indigo-600 text-[9px] font-black uppercase px-3 py-1 rounded-full italic tracking-widest">Membre</span>
                        </div>
                        
                        <h3 class="text-xl font-black {{ $membership->colocation->status === 'cancelled' ? 'text-slate-400' : 'text-slate-800' }} mb-2 italic tracking-tight uppercase">{{ $membership->colocation->nom_coloc }}</h3>
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">
                            {{ $membership->colocation->status === 'cancelled' ? 'Colocation fermée' : 'Membre actif' }}
                        </p>
                    </div>
                    <div class="bg-slate-50 p-4 px-8 flex justify-between items-center group-hover:bg-indigo-50 transition-colors">
                        <a href="{{ route('colocations.show', $membership->colocation->id) }}" class="text-[10px] font-black uppercase text-indigo-600 hover:text-indigo-800 tracking-widest italic">
                            Consulter &rarr;
                        </a>
                    </div>
                </div>
                @endif
            @endforeach
        </div>

        <!-- MODAL CRÉATION -->
        <div x-show="openCreateModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display: none;">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-md" @click="openCreateModal = false"></div>
            <div class="relative bg-white w-full max-w-md rounded-[3rem] p-10 shadow-2xl border border-white">
                <form action="{{ route('colocations.store') }}" method="POST" class="space-y-8">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 italic">Nom de la colocation</label>
                        <input type="text" name="nom_coloc" required placeholder="Ex: Appartement Centre" class="w-full bg-slate-50 border-none rounded-2xl py-5 px-6 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="flex flex-col items-center space-y-4 pt-2">
                        <button type="submit" class="w-full bg-indigo-600 text-white py-5 rounded-2xl text-[11px] font-black uppercase tracking-widest shadow-xl shadow-indigo-200">Créer la colocation</button>
                        <button type="button" @click="openCreateModal = false" class="text-[10px] font-black uppercase text-slate-400">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>