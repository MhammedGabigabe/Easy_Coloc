<x-app-layout>
    <div class=" px-2 sm:px-6 lg:px-8 bg-[#f8fafc] min-h-screen">
        
        <!-- EN-TETE : GESTION PLATEFORME -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
            <!-- Titre à gauche -->
            <div>
                <h2 class="text-3xl font-black uppercase italic tracking-tighter text-slate-800">
                    Console <span class="text-indigo-600">Admin</span>
                </h2>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-[0.2em] mt-1 italic">Surveillance plateforme</p>
            </div>
            
            <!-- Profil à droite (Style Photo) -->
            <div class="flex items-center space-x-4">
                <div class="text-right leading-tight hidden sm:block">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-800 italic">Admin</p>
                    <p class="text-[9px] font-black text-emerald-500 uppercase tracking-tighter">En ligne</p>
                </div>
                <!-- Note : Quand tu passeras en dynamique, remplace 'A' par {{ substr(Auth::user()->name, 0, 1) }} -->
                <div class="h-10 w-10 bg-slate-900 text-white rounded-xl flex items-center justify-center font-black text-sm border-2 border-white shadow-sm italic transform hover:scale-105 transition-transform cursor-pointer">
                    A 
                </div>
            </div>
        </div>

        <!-- STATISTIQUES GLOBALES (STATIQUES) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <!-- Carte 1 -->
            <div class="bg-white p-7 rounded-[2.5rem] shadow-sm border border-slate-100">
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-3">Utilisateurs Total</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-4xl font-black text-slate-800 tracking-tighter">24</h3>
                    <span class="text-emerald-500 text-[10px] font-bold">+2 ce jour</span>
                </div>
            </div>

            <!-- Carte 2 -->
            <div class="bg-white p-7 rounded-[2.5rem] shadow-sm border border-slate-100">
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-3">Colocations</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-4xl font-black text-slate-800 tracking-tighter">8</h3>
                    <span class="text-blue-500 text-[10px] font-bold italic">En ligne</span>
                </div>
            </div>

            <!-- Carte 3 -->
            <div class="bg-white p-7 rounded-[2.5rem] shadow-sm border border-slate-100">
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-3">Flux Dépenses</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-4xl font-black text-slate-800 tracking-tighter">1,240 €</h3>
                    <span class="text-slate-400 text-[10px] font-bold">Mois en cours</span>
                </div>
            </div>

            <!-- Carte 4 -->
            <div class="bg-white p-7 rounded-[2.5rem] shadow-sm border border-slate-100">
                <p class="text-red-400 text-[10px] font-black uppercase tracking-widest mb-3">Utilisateurs Bannis</p>
                <div class="flex items-end justify-between">
                    <h3 class="text-4xl font-black text-slate-800 tracking-tighter">0</h3>
                    <span class="text-slate-300 text-[10px] font-bold italic underline cursor-help">Historique</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <!-- TABLEAU DES UTILISATEURS (STATIQUE) -->
            <div class="lg:col-span-2 bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center">
                    <h4 class="font-black text-slate-700 uppercase tracking-tight text-sm italic">Annuaire des membres</h4>
                    <button class="text-[10px] font-black uppercase tracking-widest text-indigo-600 hover:underline">Voir tout l'annuaire</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-none">
                        <thead>
                            <tr class="bg-slate-50/50 text-slate-400 text-[10px] uppercase font-black tracking-widest">
                                <th class="px-8 py-5">Membre</th>
                                <th class="px-8 py-5">Rôle Système</th>
                                <th class="px-8 py-5">Position Coloc</th>
                                <th class="px-8 py-5 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <!-- Utilisateur 1 (Admin) -->
                            <tr class="hover:bg-slate-50/30 transition group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-2xl bg-indigo-600 text-white flex items-center justify-center font-black text-xs italic">ME</div>
                                        <div>
                                            <p class="text-sm font-black text-slate-800 tracking-tight italic">Moi (Admin)</p>
                                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter tracking-widest">admin@easycoloc.com</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="px-3 py-1 rounded-lg bg-indigo-100 text-indigo-600 font-black uppercase text-[9px]">Admin</span>
                                </td>
                                <td class="px-8 py-5 text-[10px] font-bold uppercase text-slate-500">
                                    Owner : <span class="text-indigo-500 italic font-black">Appart Paris 11</span>
                                </td>
                                <td class="px-8 py-5 text-right italic text-[10px] font-black text-slate-300 uppercase">Protégé</td>
                            </tr>

                            <!-- Utilisateur 2 (Standard User) -->
                            <tr class="hover:bg-slate-50/30 transition group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center font-black text-xs">SM</div>
                                        <div>
                                            <p class="text-sm font-black text-slate-700 tracking-tight">Sophie Martin</p>
                                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">sophie.m@gmail.com</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="px-3 py-1 rounded-lg bg-slate-100 text-slate-400 font-black uppercase text-[9px]">User</span>
                                </td>
                                <td class="px-8 py-5 text-[10px] font-bold uppercase text-slate-500">
                                    Member : <span class="text-slate-800">Villa du Sud</span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <button class="text-[10px] font-black text-red-400 uppercase tracking-widest hover:text-red-600 hover:underline">Désactiver</button>
                                </td>
                            </tr>

                            <!-- Utilisateur 3 (Banni ou à problème) -->
                            <tr class="hover:bg-slate-50/30 transition group bg-red-50/20">
                                <td class="px-8 py-5">
                                    <div class="flex items-center space-x-3 opacity-60">
                                        <div class="w-10 h-10 rounded-2xl bg-slate-200 text-slate-500 flex items-center justify-center font-black text-xs">KD</div>
                                        <div>
                                            <p class="text-sm font-black text-slate-700 tracking-tight">Kevin Durand</p>
                                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">k.durand@outlook.fr</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="px-3 py-1 rounded-lg bg-red-100 text-red-500 font-black uppercase text-[9px]">Banni</span>
                                </td>
                                <td class="px-8 py-5 text-[10px] font-bold uppercase text-slate-300 italic">Sans colocation active</td>
                                <td class="px-8 py-5 text-right">
                                    <button class="text-[10px] font-black text-emerald-500 uppercase tracking-widest hover:underline">Débloquer</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- WIDGET ROLE ET ACTIVITE -->
            <div class="space-y-8">
                <!-- Recap Droit Admin -->
                <div class="bg-indigo-600 rounded-[2.5rem] p-8 text-white shadow-xl shadow-indigo-100 transform hover:-translate-y-1 transition duration-500">
                    <h4 class="text-xs font-black uppercase tracking-[0.2em] text-indigo-200 mb-6 italic underline">Rôle Double Casquette</h4>
                    <p class="text-sm font-medium leading-relaxed opacity-90">
                        En tant que **Super-Admin**, vous contrôlez la plateforme, mais vous restez un membre actif.
                    </p>
                    <ul class="mt-6 space-y-4">
                        <li class="flex items-center space-x-3 text-xs font-bold bg-indigo-700/50 p-3 rounded-2xl">
                            <span class="p-1 bg-white rounded-lg text-indigo-600 italic">Admin</span>
                            <span>Accès statistiques & Modération</span>
                        </li>
                        <li class="flex items-center space-x-3 text-xs font-bold bg-indigo-700/50 p-3 rounded-2xl opacity-70">
                            <span class="p-1 bg-white rounded-lg text-slate-600 italic">User</span>
                            <span>Peut créer ou rejoindre des colocs</span>
                        </li>
                    </ul>
                </div>

                <!-- Activité Système (Dark) -->
                <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-2xl">
                    <div class="flex items-center justify-between mb-8">
                        <h4 class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 italic">Logs Système</h4>
                        <div class="flex space-x-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-700"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-700"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="mt-1 w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.6)]"></div>
                            <div>
                                <p class="text-[11px] font-black tracking-tight leading-none uppercase">Nouvelle Coloc : "Appart Nantes"</p>
                                <p class="text-[9px] text-slate-500 mt-1 uppercase font-bold tracking-widest">Il y a 4h • Par S. Martin</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="mt-1 w-2 h-2 rounded-full bg-indigo-500"></div>
                            <div>
                                <p class="text-[11px] font-black tracking-tight leading-none uppercase">Profil Admin mis à jour</p>
                                <p class="text-[9px] text-slate-500 mt-1 uppercase font-bold tracking-widest">Il y a 6h • Par Moi</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4 opacity-50">
                            <div class="mt-1 w-2 h-2 rounded-full bg-slate-600"></div>
                            <div>
                                <p class="text-[11px] font-black tracking-tight leading-none uppercase">Rapport hebdomadaire généré</p>
                                <p class="text-[9px] text-slate-500 mt-1 uppercase font-bold tracking-widest">Hier • Système</p>
                            </div>
                        </div>
                    </div>

                    <button class="w-full mt-10 py-3.5 rounded-2xl bg-slate-800 text-[9px] font-black uppercase tracking-[0.2em] hover:bg-slate-700 transition border border-white/5">
                        Consulter tous les rapports
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>