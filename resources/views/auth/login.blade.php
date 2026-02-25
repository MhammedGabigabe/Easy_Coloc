<x-guest-layout>
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div class="group">
            <label class="block text-[11px] text-gray-500 mb-1.5 ml-1 uppercase font-bold tracking-wider group-focus-within:text-easy-blue transition-colors">Identifiant</label>
            <x-text-input id="email" class="block w-full bg-slate-900/40 border-slate-700/50 focus:bg-slate-900 text-sm py-2.5 rounded-xl transition-all" type="email" name="email" :value="old('email')" required autofocus placeholder="nom@exemple.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-[11px]" />
        </div>

        <div class="group">
            <div class="flex justify-between items-end mb-1.5">
                <label class="block text-[11px] text-gray-500 ml-1 uppercase font-bold tracking-wider group-focus-within:text-easy-blue transition-colors">Mot de passe</label>
                @if (Route::has('password.request'))
                    <a class="text-[10px] text-gray-600 hover:text-white transition-colors" href="{{ route('password.request') }}">Oublié ?</a>
                @endif
            </div>
            <x-text-input id="password" class="block w-full bg-slate-900/40 border-slate-700/50 focus:bg-slate-900 text-sm py-2.5 rounded-xl transition-all" type="password" name="password" required placeholder="••••••••" />
        </div>

        <div class="flex items-center ml-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-slate-700 bg-slate-800 text-easy-blue focus:ring-easy-blue w-3.5 h-3.5" name="remember">
                <span class="ms-2 text-xs text-gray-500">Mémoriser ma session</span>
            </label>
        </div>

        <div class="pt-2">
            <x-primary-button class="py-3.5 rounded-xl shadow-lg shadow-easy-blue/20 hover:shadow-easy-blue/40 transform active:scale-95 transition-all text-xs">
                Connecter
            </x-primary-button>
        </div>

        <div class="text-center pt-2">
            <a href="{{ route('register') }}" class="text-[11px] text-gray-500 hover:text-easy-blue transition-colors font-medium border-b border-transparent hover:border-easy-blue pb-0.5">
                Rejoindre l'aventure &rarr;
            </a>
        </div>
    </form>
</x-guest-layout>