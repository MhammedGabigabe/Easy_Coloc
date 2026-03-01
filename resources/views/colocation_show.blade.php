<x-app-layout>
    @php
        $isOwner = Auth::id() === $colocation->owner_id;
    @endphp

    {{-- Mise à jour de x-data pour inclure openCategoryModal --}}
    <div x-data="{ openInviteModal: false, openCategoryModal: false }" class="px-4 sm:px-6 lg:px-8 bg-[#f8fafc] min-h-screen overflow-y-auto relative pb-20">
        
        <!-- HEADER DE LA COLOCATION (Inchangé) -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center pt-8 mb-8 gap-4 shrink-0">
            <div class="flex items-center space-x-4">
                <a href="{{ route('colocations.index') }}" class="p-2 bg-white rounded-xl border border-slate-100 text-slate-400 hover:text-indigo-600 transition shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <div>
                    <h2 class="text-3xl font-black uppercase italic tracking-tighter text-slate-800 leading-none">
                        <span class="text-indigo-600">{{ $colocation->nom_coloc }}</span>
                    </h2>
                    <p class="text-slate-400 text-[9px] font-black uppercase tracking-[0.2em] mt-1 italic">
                        {{ $isOwner ? 'Administration de la colocation' : 'Espace Membre' }}
                    </p>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                @if($isOwner)
                    <button @click="openInviteModal = true" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-[1.2rem] text-[10px] font-black shadow-lg shadow-indigo-100 transition-all flex items-center space-x-2 uppercase tracking-widest active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                        <span>Inviter un membre</span>
                    </button>

                    <form action="{{ route('colocations.destroy', $colocation->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement cette colocation ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-white border-2 border-red-50 text-red-400 hover:bg-red-50 px-5 py-3 rounded-[1.2rem] text-[10px] font-black shadow-sm transition-all flex items-center space-x-2 uppercase tracking-widest active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            <span>Annuler la colocation</span>
                        </button>
                    </form>
                @else
                    <form action="{{ route('colocations.leave', $colocation->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment quitter cette colocation ?');">
                        @csrf
                        <button type="submit" class="bg-white border-2 border-orange-50 text-orange-400 hover:bg-orange-50 px-5 py-3 rounded-[1.2rem] text-[10px] font-black shadow-sm transition-all flex items-center space-x-2 uppercase tracking-widest active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            <span>Quitter la colocation</span>
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- GRILLE DES MEMBRES (Inchangé) -->
        <div class="mb-12">
            <h4 class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-300 mb-6 italic px-2">
                Membres actifs ({{ $colocation->memberships->whereNull('left_at')->count() }})
            </h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($colocation->memberships->whereNull('left_at') as $membership)
                <div class="bg-white rounded-[2.2rem] p-6 border border-slate-100 shadow-sm flex items-center justify-between group hover:border-indigo-100 transition-all">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 {{ $membership->role_coloc === 'owner' ? 'bg-slate-900' : 'bg-indigo-100 text-indigo-600' }} rounded-2xl flex items-center justify-center font-black italic shadow-lg shadow-slate-100">
                            {{ strtoupper(substr($membership->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-black text-slate-800 italic uppercase leading-tight">
                                {{ $membership->user->name }}
                                @if($membership->user->id === Auth::id())
                                    <span class="text-[9px] text-indigo-500 font-bold lowercase ml-1">(vous)</span>
                                @endif
                            </p>
                            <div class="flex items-center mt-1 space-x-2">
                                <span class="text-[8px] font-black text-slate-400 uppercase tracking-tighter">
                                    {{ $membership->role_coloc === 'owner' ? 'Propriétaire' : 'Colocataire' }}
                                </span>
                                <span class="text-[8px] font-black {{ ($membership->user->reputation ?? 0) >= 0 ? 'text-emerald-500 bg-emerald-50' : 'text-red-500 bg-red-50' }} px-1.5 py-0.5 rounded-md italic">
                                    Rép: {{ ($membership->user->reputation ?? 0) >= 0 ? '+' : '' }}{{ $membership->user->reputation ?? 0 }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- SECTION RÉCAPITULATIF FINANCIER -->
        <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-sm mb-12">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <h4 class="text-xl font-black text-slate-800 italic uppercase tracking-tight">Dépenses Communes</h4>
                
                <div class="flex items-center space-x-3">
                    {{-- BOUTON AJOUTER CATEGORIE : Uniquement Owner --}}
                    @if($isOwner)
                        <button @click="openCategoryModal = true" class="bg-white border-2 border-slate-100 text-slate-600 px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:border-indigo-200 hover:text-indigo-600 transition flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M7 7h.01M7 11h.01M7 15h.01M13 7h.01M13 11h.01M13 15h.01M17 7h.01M17 11h.01M17 15h.01"></path></svg>
                            <span>Gérer Catégories</span>
                        </button>
                    @endif

                    <button class="bg-slate-900 text-white px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 transition flex items-center space-x-2 shadow-xl shadow-slate-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        <span>Nouvelle Dépense</span>
                    </button>
                </div>
            </div>
            
            <div class="text-center py-10">
                <p class="text-slate-400 text-sm italic font-medium">Aucune dépense enregistrée pour le moment.</p>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- POPUP (MODAL) D'INVITATION -->
        <!-- ========================================== -->
        @if($isOwner)
        <div x-show="openInviteModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display: none;">
            
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-md" @click="openInviteModal = false"></div>

            <div class="relative bg-white w-full max-w-sm rounded-[2.5rem] shadow-[0_30px_80px_rgba(0,0,0,0.4)] overflow-hidden border border-white">
                <form action="{{ route('invitation.invite') }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    <div>
                        <label class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1 italic">Email du futur membre</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </span>
                            <input type="email" name="email" required placeholder="nom@exemple.com" 
                                   class="w-full bg-slate-50 border-none rounded-xl py-4 pl-11 pr-6 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 transition-all placeholder:text-slate-300 italic">
                            <input type="hidden" name="coloc_id" value="{{ $colocation->id }}">       
                        </div>
                    </div>

                    <div class="flex flex-col items-center space-y-3 pt-2">
                        <button type="submit" 
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-4 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-indigo-100 transition-all transform active:scale-95 italic">
                            Envoyer l'invitation
                        </button>
                        <button type="button" @click="openInviteModal = false" class="text-[9px] font-black uppercase tracking-widest text-slate-400 hover:text-slate-600 transition">
                            Plus tard
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- POPUP (MODAL) AJOUTER CATEGORIE -->
        <!-- ========================================== -->
        <div x-show="openCategoryModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display: none;">
            
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-md" @click="openCategoryModal = false"></div>

            <div class="relative bg-white w-full max-w-sm rounded-[2.5rem] shadow-[0_30px_80px_rgba(0,0,0,0.4)] overflow-hidden border border-white">
                <form action="#" method="POST" class="p-8 space-y-6">
                    @csrf
                    <div>
                        <label class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1 italic">Nom de la nouvelle catégorie</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 11h.01M7 15h.01M13 7h.01M13 11h.01M13 15h.01M17 7h.01M17 11h.01M17 15h.01"></path></svg>
                            </span>
                            <input type="text" name="nom_categorie" required placeholder="Ex: Courses, Loyer, Internet..." 
                                   class="w-full bg-slate-50 border-none rounded-xl py-4 pl-11 pr-6 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 transition-all placeholder:text-slate-300 italic">
                        </div>
                    </div>

                    <div class="flex flex-col items-center space-y-3 pt-2">
                        <button type="submit" 
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-4 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-indigo-100 transition-all transform active:scale-95 italic">
                            Créer la catégorie
                        </button>
                        <button type="button" @click="openCategoryModal = false" class="text-[9px] font-black uppercase tracking-widest text-slate-400 hover:text-slate-600 transition">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif

    </div>
</x-app-layout>