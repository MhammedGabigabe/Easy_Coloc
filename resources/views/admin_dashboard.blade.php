<x-app-layout>
    <div class="px-4 py-8 sm:px-6 lg:px-8 bg-[#f8fafc] min-h-screen overflow-y-auto relative">
        
        <!-- HEADER ADMIN -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
            <div>
                <h2 class="text-3xl font-black uppercase italic tracking-tighter text-slate-800 leading-none">
                    Admin <span class="text-indigo-600">Global</span>
                </h2>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-[0.2em] mt-1 italic">Contrôle et statistiques de la plateforme</p>
            </div>
        </div>

        <!-- GRILLE DE STATISTIQUES -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">

            <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-xl relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-500/10 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2 italic">Utilisateurs</p>
                <h3 class="text-4xl font-black tracking-tighter">{{ $stats['total_users'] }}</h3>
            </div>


            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm relative overflow-hidden group">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 italic">Colocations</p>
                <h3 class="text-4xl font-black tracking-tighter text-slate-800">{{ $stats['total_colocs'] }}</h3>
            </div>


            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm relative overflow-hidden group">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 italic">Volume DH</p>
                <h3 class="text-4xl font-black tracking-tighter text-indigo-600">{{ number_format($stats['total_depenses'], 0) }}</h3>
            </div>


            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm relative overflow-hidden group">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 italic">Bannis</p>
                <h3 class="text-4xl font-black tracking-tighter text-red-500">{{ $stats['banned_users'] }}</h3>
            </div>
        </div>


        <div class="bg-white rounded-[3rem] p-8 border border-slate-100 shadow-sm overflow-hidden">
            <h4 class="text-xl font-black text-slate-800 italic uppercase tracking-tight mb-8 px-2">Gestion des membres</h4>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-separate border-spacing-y-3">
                    <thead>
                        <tr class="text-[10px] font-black uppercase tracking-widest text-slate-300 italic">
                            <th class="px-6 pb-2">Utilisateur</th>
                            <th class="px-6 pb-2">Email</th>
                            <th class="px-6 pb-2">Réputation</th>
                            <th class="px-6 pb-2">Status</th>
                            <th class="px-6 pb-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="bg-slate-50/50 hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-4 rounded-l-3xl">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-slate-900 text-white rounded-xl flex items-center justify-center font-black italic text-xs">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="text-xs font-black text-slate-800 uppercase italic">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-xs font-bold text-slate-500">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                <span class="text-[10px] font-black {{ $user->reputation >= 0 ? 'text-emerald-500' : 'text-red-500' }} italic">
                                    {{ $user->reputation > 0 ? '+' : '' }}{{ $user->reputation }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->is_banned)
                                    <span class="bg-red-100 text-red-600 text-[8px] font-black uppercase px-2 py-1 rounded-md italic">Banni</span>
                                @else
                                    <span class="bg-emerald-100 text-emerald-600 text-[8px] font-black uppercase px-2 py-1 rounded-md italic">Actif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 rounded-r-3xl text-right">
                                <form action="{{ route('admin.users.toggle-ban', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-[9px] font-black uppercase tracking-widest {{ $user->is_banned ? 'text-emerald-500 hover:text-emerald-700' : 'text-red-400 hover:text-red-600' }} transition-colors">
                                        {{ $user->is_banned ? 'Débannir' : 'Bannir' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            <div class="mt-8 px-4">
                {{ $users->links() }}
            </div>
        </div>

    </div>
</x-app-layout>