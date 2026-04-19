<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen font-sans text-slate-900">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Ressources Humaines</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Gestion des effectifs et des talents Access Morocco.</p>
            </div>
            
            <button onclick="toggleModal()" class="flex items-center gap-2 bg-[#be2346] hover:bg-[#a01d3a] text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-md shadow-[#be2346]/10 active:scale-95 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter un Employé
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-slate-400 text-[10px] uppercase font-black tracking-widest">Effectif Total</p>
                    <span class="p-2 bg-slate-50 rounded-lg text-slate-400">
                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </span>
                </div>
                <h3 class="text-3xl font-bold mt-2 text-slate-800">{{ $users->count() }}</h3>
            </div>

            <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm border-l-4 border-l-[#be2346]">
                <p class="text-slate-400 text-[10px] uppercase font-black tracking-widest">En Congé</p>
                <h3 class="text-3xl font-bold mt-2 text-[#be2346]">{{ $users->where('status', 'conge')->count() }}</h3>
            </div>

            <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm">
                <p class="text-slate-400 text-[10px] uppercase font-black tracking-widest">Consultants</p>
                <h3 class="text-3xl font-bold mt-2 text-blue-600">{{ $users->where('typeContrat', 'freelance')->count() }}</h3>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/50">
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Collaborateur</th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Poste</th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Statut</th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Contrat</th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($users as $user)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-[#be2346]/10 flex items-center justify-center font-bold text-xs text-[#be2346]">
                                        {{ strtoupper(substr($user->firstName, 0, 1)) }}{{ strtoupper(substr($user->lastName, 0, 1)) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-slate-700">{{ $user->firstName }} {{ $user->lastName }}</span>
                                        <span class="text-[11px] text-slate-400">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-600 font-medium">{{ $user->post ?? 'Collaborateur' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = [
                                        'active' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'conge' => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'desactive' => 'bg-slate-50 text-slate-400 border-slate-100'
                                    ];
                                    $currentClass = $statusClasses[$user->status] ?? $statusClasses['desactive'];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[10px] font-bold border uppercase {{ $currentClass }}">
                                    {{ $user->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">{{ $user->typeContrat }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ url('/users/' . $user->id) }}" class="p-2 rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-all">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    </a>
                                    <a href="{{ url('/users/edit/' . $user->id) }}" class="p-2 rounded-lg text-slate-400 hover:bg-[#be2346]/10 hover:text-[#be2346] transition-all">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z" /></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div id="addUserModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal()"></div>
            <div class="relative flex items-center justify-center min-h-screen p-4">
                <div class="bg-white w-full max-w-2xl rounded-[32px] shadow-2xl overflow-hidden border border-slate-200">
                    
                    <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <div>
                            <h2 class="text-xl font-black text-slate-800">Ajouter un collaborateur</h2>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Fiche d'enregistrement Access Morocco</p>
                        </div>
                        <button onclick="toggleModal()" class="w-8 h-8 flex items-center justify-center rounded-full bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form action="{{ url('/users') }}" method="POST" class="p-8">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Prénom</label>
                                <input type="text" name="firstName" required placeholder="Ex: Karim" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5 outline-none transition-all">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Nom</label>
                                <input type="text" name="lastName" required placeholder="Ex: Bennani" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5 outline-none transition-all">
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Email Professionnel</label>
                                <input type="email" name="email" required placeholder="k.bennani@access.ma" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5 outline-none transition-all">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Mot de Passe par défaut</label>
                                <input type="password" name="password" required value="12345678" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5 outline-none transition-all">
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Numéro CIN</label>
                                <input type="text" name="cin" required placeholder="Ex: BH123456" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5 outline-none transition-all">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Téléphone</label>
                                <input type="text" name="phoneNumber" required placeholder="06 00 00 00 00" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5 outline-none transition-all">
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Poste Occupé</label>
                                <input type="text" name="post" required placeholder="Ex: Lead Developer" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5 outline-none transition-all">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Salaire Mensuel (DH)</label>
                                <input type="number" name="salaire" required placeholder="Ex: 8000" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5 outline-none transition-all">
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Type de Contrat</label>
                               <select name="typeContrat" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none">
    <option value="CD">CDI (Contrat Durée Indéterminée)</option> <option value="CI">CI (Contrat d'Insertion)</option>       <option value="freelance">Freelance</option>
</select>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Date de Naissance</label>
                                <input type="date" name="birthday" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5 outline-none transition-all">
                            </div>
                        </div>

                        <div class="mt-10 flex gap-4">
                            <button type="button" onclick="toggleModal()" class="flex-1 py-3.5 rounded-xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition-all">Annuler</button>
                            <button type="submit" class="flex-1 py-3.5 rounded-xl bg-[#be2346] font-extrabold text-white hover:bg-[#a01d3a] transition-all shadow-lg shadow-[#be2346]/20 active:scale-95">
                                Confirmer l'ajout
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleModal() {
            const modal = document.getElementById('addUserModal');
            modal.classList.toggle('hidden');
            // Prevent scrolling when modal is open
            if (!modal.classList.contains('hidden')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = 'auto';
            }
        }
    </script>
</x-app-layout>