<section>
    <header class="mb-8">
        <h3 class="text-xl font-black uppercase italic tracking-tighter text-slate-800">Informations personnelles</h3>
        <p class="mt-1 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Mettez à jour votre nom et votre adresse email.</p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6 max-w-xl">
        @csrf
        @method('patch')

        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-2 italic">Nom complet</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm">
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-2 italic">Adresse Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm">
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg shadow-indigo-100">
                Enregistrer les modifications
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-xs font-bold text-emerald-500 uppercase tracking-tighter italic italic">Modifications enregistrées !</p>
            @endif
        </div>
    </form>
</section>