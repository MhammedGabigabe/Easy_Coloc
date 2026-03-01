<section>
    <header class="mb-8">
        <h3 class="text-xl font-black uppercase italic tracking-tighter text-slate-800">Sécurité du compte</h3>
        <p class="mt-1 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Utilisez un mot de passe long et complexe.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6 max-w-xl">
        @csrf
        @method('put')

        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-2 italic">Mot de passe actuel</label>
            <input type="password" name="current_password" class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 transition-all">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-2 italic">Nouveau mot de passe</label>
                <input type="password" name="password" class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 transition-all">
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-2 italic">Confirmation</label>
                <input type="password" name="password_confirmation" class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 transition-all">
            </div>
        </div>
        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all">
                Mettre à jour le mot de passe
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-xs font-bold text-emerald-500 uppercase italic">Mot de passe changé !</p>
            @endif
        </div>
    </form>
</section>