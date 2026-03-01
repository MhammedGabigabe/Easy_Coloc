<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 bg-[#f8fafc] min-h-screen pb-20">
        
        <!-- HEADER -->
        <div class="flex items-center space-x-4 pt-8 mb-10">
            <div class="p-3 bg-white rounded-2xl border border-slate-100 text-indigo-600 shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <div>
                <h2 class="text-3xl font-black uppercase italic tracking-tighter text-slate-800">Mon <span class="text-indigo-600">Profil</span></h2>
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] mt-1 italic">Paramètres de compte et sécurité</p>
            </div>
        </div>

        <div class="max-w-4xl space-y-10">
            <!-- Section : Informations personnelles -->
            <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm">
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Section : Mot de passe -->
            <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm">
                @include('profile.partials.update-password-form')
            </div>

            <!-- Section : Suppression -->
            <div class="bg-red-50/30 p-10 rounded-[2.5rem] border border-red-100">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>