<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-2">
        @csrf

        <div>
            <label class="block text-[11px] text-gray-500 mb-1.5 ml-1 uppercase font-bold">Votre Nom</label>
            <x-text-input id="name" class="block w-full py-2.5 text-sm" type="text" name="name" :value="old('name')" required placeholder="Prénom Nom" />
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-[10px]" />
        </div>

        <div>
            <label class="block text-[11px] text-gray-500 mb-1.5 ml-1 uppercase font-bold">Email</label>
            <x-text-input id="email" class="block w-full py-2.5 text-sm" type="email" name="email" :value="old('email')" required placeholder="contact@coloc.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-[10px]" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-[11px] text-gray-500 mb-1.5 ml-1 uppercase font-bold">Mot de passe</label>
                <x-text-input id="password" class="block w-full py-2.5 text-sm" type="password" name="password" required placeholder="••••••" />
            </div>
            <div>
                <label class="block text-[11px] text-gray-500 mb-1.5 ml-1 uppercase font-bold">Confirmation</label>
                <x-text-input id="password_confirmation" class="block w-full py-2.5 text-sm" type="password" name="password_confirmation" required placeholder="••••••" />
            </div>
        </div>
        <x-input-error :messages="$errors->get('password')" class="mt-1 text-[10px]" />

        <div class="pt-4">
            <x-primary-button class="py-3.5 text-xs">Créer mon espace</x-primary-button>
        </div>

        <div class="text-center pt-1">
            <a href="{{ route('login') }}" class="text-[11px] text-gray-600 hover:text-white transition-colors uppercase font-bold tracking-widest">
                Déjà membre ? Connexion
            </a>
        </div>
    </form>
</x-guest-layout>