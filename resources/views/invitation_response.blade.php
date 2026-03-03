<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 bg-[#f8fafc] h-screen flex items-center justify-center overflow-hidden">
        
        <div class="w-full max-w-lg bg-white rounded-[3rem] shadow-[0_40px_100px_rgba(0,0,0,0.1)] border border-white overflow-hidden transform hover:scale-[1.01] transition-transform duration-500">

            <div class="p-12 text-center">
                <p class="text-slate-400 text-xs font-black uppercase tracking-[0.2em] mb-2 italic">Vous êtes invité à rejoindre :</p>
                <h3 class="text-2xl font-black text-slate-800 uppercase italic tracking-tight mb-8">
                    "{{ $colocation->nom_coloc }}"
                </h3>

                <p class="text-slate-500 text-sm leading-relaxed mb-10">
                    En acceptant, vous pourrez partager vos dépenses, gérer les tâches communes et suivre votre réputation financière avec les autres membres.
                </p>

                <div class="flex flex-col space-y-4">
                    <form action="{{ route('invitation.accept', ['token' => $invitation->token_email]) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-5 rounded-2xl text-xs font-black uppercase tracking-[0.2em] shadow-xl shadow-indigo-100 transition-all transform active:scale-95">
                            Accepter et rejoindre
                        </button>
                    </form>

                    <form action="{{ route('invitation.refuse', ['token' => $invitation->token_email]) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-slate-400 hover:text-red-500 text-[10px] font-black uppercase tracking-widest transition-colors py-2">
                            Refuser l'invitation
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-slate-50 py-4 text-center border-t border-slate-100">
                <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest italic">Sécurisé par EasyColoc © {{ date('Y') }}</span>
            </div>
        </div>

    </div>
</x-app-layout>