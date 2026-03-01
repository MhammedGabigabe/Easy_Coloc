<section class="space-y-6">
    <header>
        <h3 class="text-xl font-black uppercase italic tracking-tighter text-red-600">Zone de danger</h3>
        <p class="mt-1 text-[10px] font-bold text-red-400/70 uppercase tracking-widest">Cette action est irréversible. Toutes vos données seront effacées.</p>
    </header>

    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="bg-white border-2 border-red-100 text-red-500 hover:bg-red-100 px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm">
        Supprimer mon compte EasyColoc
    </button>

    <!-- Modal de confirmation Breeze (stylisé EasyColoc) -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-10 bg-white">
            @csrf
            @method('delete')

            <h2 class="text-2xl font-black uppercase italic tracking-tighter text-slate-800">Êtes-vous sûr ?</h2>
            <p class="mt-2 text-sm text-slate-400">Veuillez entrer votre mot de passe pour confirmer la suppression définitive.</p>

            <div class="mt-8">
                <input type="password" name="password" placeholder="Mot de passe" class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-red-500 transition-all">
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-10 flex justify-end space-x-4">
                <button type="button" x-on:click="$dispatch('close')" class="text-[10px] font-black uppercase tracking-widest text-slate-400">Annuler</button>
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest">Confirmer la suppression</button>
            </div>
        </form>
    </x-modal>
</section>