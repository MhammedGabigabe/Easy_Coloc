<x-app-layout>
    @php
        $isOwner = Auth::id() === $colocation->owner_id;
        $isCancelled = $colocation->status === 'cancelled';
    @endphp

    <div x-data="{ openInviteModal: false, openCategoryModal: false, openExpenseModal: false }" class="px-4 sm:px-6 lg:px-8 bg-[#f8fafc] min-h-screen overflow-y-auto relative pb-20">
        
        @if($isCancelled)
            <div class="mt-6 p-4 bg-red-50 border border-red-100 rounded-2xl flex items-center space-x-3">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <p class="text-red-600 text-[10px] font-black uppercase tracking-widest italic">Cette colocation est archivée. Aucune modification possible.</p>
            </div>
        @endif

        @if(session('success'))
            <div class="mt-4 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center space-x-3 shadow-sm animate-bounce">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-emerald-600 text-[10px] font-black uppercase tracking-widest italic">{{ session('success') }}</p>
            </div>
        @endif

        <!-- HEADER -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center pt-8 mb-8 gap-4 shrink-0">
            <div class="flex items-center space-x-4">
                <a href="{{ route('colocations.index') }}" class="p-2 bg-white rounded-xl border border-slate-100 text-slate-400 hover:text-indigo-600 transition shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <div>
                    <h2 class="text-3xl font-black uppercase italic tracking-tighter {{ $isCancelled ? 'text-slate-400' : 'text-slate-800' }} leading-none">
                        <span>{{ $colocation->nom_coloc }}</span>
                    </h2>
                    <p class="text-slate-400 text-[9px] font-black uppercase tracking-[0.2em] mt-1 italic">
                        {{ $isCancelled ? 'Archive' : ($isOwner ? 'Administration' : 'Espace Membre') }}
                    </p>
                </div>
            </div>

            @if(!$isCancelled)
            <div class="flex items-center space-x-3">
                @if($isOwner)
                    <button @click="openInviteModal = true" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-[1.2rem] text-[10px] font-black shadow-lg shadow-indigo-100 transition-all uppercase tracking-widest active:scale-95">
                        Inviter un membre
                    </button>
                    <form action="{{ route('colocations.destroy', $colocation->id) }}" method="POST" onsubmit="return confirm('Annuler définitivement cette colocation ?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-white border-2 border-red-50 text-red-400 px-5 py-3 rounded-[1.2rem] text-[10px] font-black uppercase tracking-widest shadow-sm hover:bg-red-50 transition-colors">
                            Annuler la colocation
                        </button>
                    </form>
                @else
                    <form action="{{ route('colocations.leave', $colocation->id) }}" method="POST" onsubmit="return confirm('Voulez-vous quitter cette colocation ?');">
                        @csrf
                        <button type="submit" class="bg-white border-2 border-orange-50 text-orange-400 px-5 py-3 rounded-[1.2rem] text-[10px] font-black uppercase tracking-widest shadow-sm hover:bg-orange-50 transition-colors">
                            Quitter la colocation
                        </button>
                    </form>
                @endif
            </div>
            @endif
        </div>


        <!-- GRILLE DES MEMBRES -->
        <div class="mb-12">
            <h4 class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-300 mb-6 italic px-2">Membres ({{ $colocation->memberships->count() }})</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($colocation->memberships as $membership)
                <div class="bg-white rounded-[2.2rem] p-6 border border-slate-100 shadow-sm flex items-center justify-between group transition-all hover:border-indigo-100">
                    <div class="flex items-center space-x-4">
                        @php
                            $userRep = $membership->user->reputation ?? 0;
                            $nameParts = explode(' ', trim($membership->user->name ?? 'User'));
                            $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
                        @endphp

                        <div class="w-12 h-12 {{ $membership->role_coloc === 'owner' ? 'bg-indigo-600 text-white' : 'bg-indigo-50 text-indigo-600' }} rounded-2xl flex items-center justify-center font-black italic shadow-lg shadow-slate-100">
                            {{ $initials }}
                        </div>
                        <div>
                            <p class="text-sm font-black text-slate-800 italic uppercase leading-tight">
                                {{ $membership->user->name ?? 'Inconnu' }}
                                @if($membership->user_id === Auth::id())
                                    <span class="text-[9px] text-indigo-500 lowercase ml-1 font-bold italic">(vous)</span>
                                @endif
                            </p>
                            <div class="flex items-center mt-1 space-x-2">
                                <span class="text-[8px] font-black text-slate-400 uppercase tracking-tighter">
                                    {{ $membership->role_coloc }}
                                </span>
                                <span class="text-[8px] font-black {{ $userRep < 0 ? 'text-red-600 bg-red-50 border border-red-100' : 'text-emerald-600 bg-emerald-50 border border-emerald-100' }} px-2 py-0.5 rounded-md italic">
                                    Rép: {{ $userRep > 0 ? '+' : '' }}{{ $userRep }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- BOUTON RETIRER : Uniquement si OWNER et si l'utilisateur sur la carte n'est pas l'OWNER connecté --}}
                    @if(!$isCancelled && $isOwner && $membership->user_id !== Auth::id())
                        <form action="{{ route('colocations.remove-member', [$colocation->id, $membership->id]) }}" method="POST" onsubmit="return confirm('Retirer ce membre ? Ses dettes vous seront réattribuées.');">
                            @csrf
                            <button type="submit" class="p-2 text-slate-200 hover:text-red-500 transition-colors" title="Retirer ce membre">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6"></path></svg>
                            </button>
                        </form>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

    <!-- SECTION FINANCIÈRE -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        
        <div class="lg:col-span-2 bg-white rounded-[3rem] p-8 border border-slate-100 shadow-sm">
            <div class="flex justify-between items-center mb-8 px-2">
                <h4 class="text-xl font-black text-slate-800 italic uppercase tracking-tight">Historique</h4>
                @if(!$isCancelled)
                <div class="flex gap-2">
                    @if($isOwner)
                    <button @click="openCategoryModal = true" class="p-2 border border-slate-100 rounded-xl hover:bg-slate-50 transition"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 11h.01M7 15h.01M13 7h.01M13 11h.01M13 15h.01M17 7h.01M17 11h.01M17 15h.01"></path></svg></button>
                    @endif
                    <button @click="openExpenseModal = true" class="bg-slate-900 text-white px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 transition">Nouvelle Dépense</button>
                </div>
                @endif
            </div>

            <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2">
                @forelse($colocation->depenses->sortByDesc('date_depense') as $depense)
                    <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 border border-slate-100 group hover:border-indigo-100 transition-all">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm text-indigo-600 font-bold text-xs">
                                {{ $depense->categorie->nom_categorie[0] ?? '?' }}
                            </div>
                            <div>
                                <p class="text-xs font-black text-slate-800 uppercase italic">{{ $depense->titre }}</p>
                                <p class="text-[9px] text-slate-400 font-bold">Payé par {{ $depense->payeur->name }} • {{ \Carbon\Carbon::parse($depense->date_depense)->format('d M') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-black text-slate-900">{{ number_format($depense->montant, 2) }} DH</p>
                            <p class="text-[8px] text-indigo-500 font-black uppercase tracking-widest">{{ $depense->categorie->nom_categorie ?? 'Dépense' }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10">
                        <p class="text-slate-400 text-sm italic font-medium">Aucune dépense pour le moment.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="bg-indigo-600 rounded-[3rem] p-8 shadow-xl shadow-indigo-100 relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-3xl"></div>
            
            <h4 class="text-white text-lg font-black italic uppercase tracking-tight mb-6 relative">Situation des dettes</h4>

            <div class="space-y-4 relative max-h-[450px] overflow-y-auto pr-2">
                @foreach($mesDettes as $dette)
                    <div class="bg-white/20 backdrop-blur-md rounded-2xl p-4 border border-white/30 shadow-sm">
                        <p class="text-[9px] text-indigo-100 font-black uppercase tracking-widest mb-1">À rembourser</p>
                        <p class="text-xs text-white font-medium">
                            {{$dette->membership->user->name}} doit payé <span class="font-black">{{$dette->montant_a_payer }} DH</span> 
                            à <span >{{ $dette->depense->payeur->name }}</span>
                        </p>
                        
                        <form action="{{ route('dettes.payer', $dette->id) }}" method="POST" class="mt-3">
                            @csrf
                            <button type="submit" class="w-full bg-white text-indigo-600 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-emerald-400 hover:text-white transition-all shadow-lg">
                                Marquer payé
                            </button>
                        </form>
                    </div>
                @endforeach

                @foreach($dettesQuOnMeDoit as $dette)
                    <div class="bg-indigo-800/40 backdrop-blur-sm rounded-2xl p-4 border border-indigo-400/30">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[9px] text-emerald-300 font-black uppercase tracking-widest mb-1">À recevoir</p>
                        <p class="text-xs text-white font-medium">
                            {{$dette->membership->user->name}} doit payé <span class="font-black">{{$dette->montant_a_payer }} DH</span> 
                            à <span >{{ $dette->depense->payeur->name }}</span>
                        </p>
                            </div>
                            <div class="bg-emerald-500/20 p-1 rounded-lg">
                                <svg class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if($mesDettes->isEmpty() && $dettesQuOnMeDoit->isEmpty())
                    <div class="text-center py-10">
                        <svg class="w-10 h-10 text-white/20 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <p class="text-indigo-100 text-xs italic font-bold uppercase">Tout est en règle !</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

        <!-- MODALS -->
        @if(!$isCancelled)
            <!-- Modal Invite -->
            <div x-show="openInviteModal" x-transition class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display: none;">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-md" @click="openInviteModal = false"></div>
                <div class="relative bg-white w-full max-w-sm rounded-[2.5rem] p-8 shadow-2xl border border-white">
                    <h3 class="text-lg font-black uppercase italic mb-6">Inviter un membre</h3>
                    <form action="{{ route('invitation.invite') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="email" name="email" required placeholder="Email" class="w-full bg-slate-50 border-none rounded-xl py-4 px-6 text-sm font-bold focus:ring-2 focus:ring-indigo-500">
                        <input type="hidden" name="coloc_id" value="{{ $colocation->id }}">       
                        <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-indigo-100">Envoyer l'invitation</button>
                    </form>
                </div>
            </div>

            <!-- Modal Categorie -->
            <div x-show="openCategoryModal" x-transition class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display: none;">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-md" @click="openCategoryModal = false"></div>
                <div class="relative bg-white w-full max-w-sm rounded-[2.5rem] p-8 shadow-2xl border border-white">
                    <h3 class="text-lg font-black uppercase italic mb-6">Nouvelle Catégorie</h3>
                    <form action="{{ route('categories.store', $colocation->id) }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="text" name="nom_categorie" required placeholder="Nom de catégorie" class="w-full bg-slate-50 border-none rounded-xl py-4 px-6 text-sm font-bold focus:ring-2 focus:ring-indigo-500">
                        <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-indigo-100">Créer la catégorie</button>
                    </form>
                </div>
            </div>

            <!-- Modal Dépense -->
            <div x-show="openExpenseModal" x-transition class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display: none;">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-md" @click="openExpenseModal = false"></div>
                <div class="relative bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl border border-white overflow-hidden">
                    <div class="bg-indigo-600 p-6 text-white"><h3 class="text-xl font-black uppercase italic">Nouvelle Dépense</h3></div>
                    <form action="{{ route('depenses.store', $colocation->id) }}" method="POST" class="p-8 space-y-5">
                        @csrf
                        <input type="text" name="titre" required placeholder="Titre" class="w-full bg-slate-50 border-none rounded-xl py-3 px-4 text-sm font-bold">
                        <div class="grid grid-cols-2 gap-4">
                            <input type="number" step="0.01" name="montant" required placeholder="Montant (DH)" class="w-full bg-slate-50 border-none rounded-xl py-3 px-4 text-sm font-bold">
                            <input type="date" name="date_depense" value="{{ date('Y-m-d') }}" required class="w-full bg-slate-50 border-none rounded-xl py-3 px-4 text-sm font-bold">
                        </div>
                        <select name="categorie_id" required class="w-full bg-slate-50 border-none rounded-xl py-3 px-4 text-sm font-bold">
                            <option value="">-- Catégorie --</option>
                            @foreach($colocation->categories as $category)
                                <option value="{{ $category->id }}">{{ $category->nom_categorie }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-xl hover:bg-indigo-600 transition-all">Enregistrer et partager</button>
                    </form>
                </div>
            </div>
        @endif

    </div>
</x-app-layout>