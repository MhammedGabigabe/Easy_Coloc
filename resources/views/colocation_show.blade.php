<x-app-layout>
    <div x-data="{ openInviteModal: false }" class="px-4 sm:px-6 lg:px-8 bg-[#f8fafc] h-screen overflow-hidden relative">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center pt-8 mb-8 gap-4 shrink-0">
            <div class="flex items-center space-x-4">
                <a href="{{ route('colocations.index') }}" class="p-2 bg-white rounded-xl border border-slate-100 text-slate-400 hover:text-indigo-600 transition shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <div>
                    <h2 class="text-3xl font-black uppercase italic tracking-tighter text-slate-800 leading-none">
                        <span class="text-indigo-600">{{ $colocation->nom_coloc }}</span>
                    </h2>
                    <p class="text-slate-400 text-[9px] font-black uppercase tracking-[0.2em] mt-1 italic">Gestion d'équipe</p>
                </div>
            </div>

            <div class="flex items-center space-x-3">
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
            </div>
        </div>

        <!-- SECTION MEMBRES (Grille existante) -->
        <div class="mb-6 flex-1 overflow-y-auto">
            <h4 class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-300 mb-6 italic px-2">Membres actifs (3)</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- ... Tes blocs de membres ici ... -->
                <div class="bg-white rounded-[2.2rem] p-6 border border-slate-100 shadow-sm flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-slate-900 rounded-2xl flex items-center justify-center text-white font-black italic shadow-lg shadow-slate-200">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-black text-slate-800 italic uppercase leading-tight">{{ Auth::user()->name }}</p>
                            <div class="flex items-center mt-1 space-x-2">
                                <span class="text-[8px] font-black text-slate-400 uppercase tracking-tighter">Propriétaire</span>
                                <span class="text-[8px] font-black text-emerald-500 uppercase bg-emerald-50 px-1.5 py-0.5 rounded-md italic">Rép: +150</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- POPUP (MODAL) D'INVITATION -->
        <!-- ========================================== -->
        <div x-show="openInviteModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display: none;">
            
            <!-- Overlay flou -->
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-md" @click="openInviteModal = false"></div>

            <div class="relative bg-white w-full max-w-sm rounded-[2.5rem] shadow-[0_30px_80px_rgba(0,0,0,0.4)] overflow-hidden border border-white">
                <!-- Formulaire d'invitation -->
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

    </div>
</x-app-layout>