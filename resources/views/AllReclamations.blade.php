<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen font-sans text-slate-900">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Gestion des Réclamations</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Liste complète des requêtes envoyées.</p>
            </div>
            
            <button onclick="toggleModal('addReclamationModal')" class="flex items-center gap-2 bg-[#be2346] hover:bg-[#a01d3a] text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-md active:scale-95 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Nouvelle Réclamation
            </button>
        </div>

        {{-- Section des messages et erreurs --}}
        <div class="mb-6">
            @if(session('msg'))
                <div id="success-alert" class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-600 rounded-2xl font-bold text-sm flex items-center gap-3 transition-all duration-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('msg') }}
                </div>
            @endif

            @if($errors->any())
                <div id="error-alert" class="p-4 bg-red-50 border border-red-200 text-red-600 rounded-2xl font-bold text-sm transition-all duration-500">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden mb-8">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/50">
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Sujet</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Statut</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Date de création</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($Reclamations as $rec)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-slate-700">{{ $rec->titre }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $rec->status == 'resolue' ? 'bg-emerald-100 text-emerald-600' : ($rec->status == 'en_cours' ? 'bg-amber-100 text-amber-600' : 'bg-blue-100 text-blue-600') }}">
                                {{ str_replace('_', ' ', $rec->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-[12px] text-slate-500 font-medium">
                                {{ $rec->created_at ? $rec->created_at->format('d/m/Y') : 'Date inconnue' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 flex justify-end gap-3">
                            <a href="/reclamation/{{ $rec->idReclamation }}" class="p-2 rounded-lg text-slate-400 hover:bg-blue-50 hover:text-blue-600 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            </a>
                            
                            <button onclick="openDeleteModal('{{ $rec->idReclamation }}')" class="p-2 rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-600 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <p class="text-slate-400 text-sm font-medium">Aucune réclamation trouvée dans la base de données.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div id="addReclamationModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('addReclamationModal')"></div>
            <div class="relative flex items-center justify-center min-h-screen p-4">
                <div class="bg-white w-full max-w-lg rounded-[32px] shadow-2xl p-8 relative">
                    <button onclick="toggleModal('addReclamationModal')" class="absolute top-6 right-6 p-2 rounded-full hover:bg-slate-100 text-slate-400 transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>

                    <h2 class="text-xl font-black text-slate-800 mb-6">Soumettre une réclamation</h2>
                    
                    <form action="/reclamations" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        {{-- On ajoute idUser car il est requis par le contrôleur --}}
                        <input type="hidden" name="idUser" value="{{ Auth::user()->idUser }}">
                        
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Sujet de la demande (Max 20 car.)</label>
                            <input type="text" name="titre" required maxlength="20" placeholder="Ex: Problème badge" class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#be2346]/20 outline-none transition-all">
                        </div>
                        
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Priorité</label>
                            {{-- On utilise des valeurs en minuscules pour correspondre à la validation du contrôleur --}}
                            <select name="priorite" class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none">
                                <option value="basse">Basse</option>
                                <option value="moyenne">Moyenne</option>
                                <option value="haute">Haute</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Description détaillée</label>
                            <textarea name="description" rows="4" required placeholder="Expliquez votre problème ici..." class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#be2346]/20 outline-none transition-all"></textarea>
                        </div>

                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Pièce jointe (Optionnel)</label>
                            <input type="file" name="fichier" class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none">
                        </div>

                        <button type="submit" class="w-full py-4 rounded-xl bg-[#be2346] hover:bg-[#a01d3a] text-white font-black transition-all shadow-lg shadow-[#be2346]/20 mt-2">Envoyer maintenant</button>
                    </form>
                </div>
            </div>
        </div>

    <script>
        function toggleModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.toggle('hidden');
                document.body.style.overflow = modal.classList.contains('hidden') ? 'auto' : 'hidden';
            }
        }

        function openDeleteModal(id) {
            window.confirmDelete(`/reclamation/delete/${id}`, 'réclamation');
        }

        document.addEventListener('DOMContentLoaded', function() {
            function fadeAndRemove(elementId) {
                const el = document.getElementById(elementId);
                if (el) {
                    setTimeout(() => {
                        el.style.opacity = '0';
                        el.style.transform = 'translateY(-10px)';
                        setTimeout(() => el.remove(), 500);
                    }, 3000);
                }
            }
            fadeAndRemove('success-alert');
            fadeAndRemove('error-alert');
        });
    </script>
</x-app-layout>