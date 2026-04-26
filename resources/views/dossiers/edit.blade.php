<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen">

        <div class="mb-8">
            <a href="{{ route('dossiers.show', $dossier->idDossier) }}"
               class="inline-flex items-center gap-2 text-slate-400 hover:text-[#b11d40] text-sm font-bold mb-3 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Retour au dossier
            </a>
            <h1 class="text-2xl font-extrabold text-slate-800">Modifier le Dossier</h1>
            <p class="text-slate-500 text-sm">{{ $dossier->reference }}</p>
        </div>

        <form method="POST" action="{{ route('dossiers.update', $dossier->idDossier) }}">
            @csrf @method('PUT')

            <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden mb-6">
                <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                <div class="p-6">
                    <h3 class="text-sm font-black text-slate-400 uppercase tracking-wider mb-5">Informations du dossier</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Client *</label>
                            <select name="idClient" required
                                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                                @foreach($clients as $client)
                                    <option value="{{ $client->idClient }}" {{ old('idClient', $dossier->idClient) == $client->idClient ? 'selected' : '' }}>
                                        {{ $client->firstName }} {{ $client->lastName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Département</label>
                            <select name="idDepartement"
                                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                                <option value="">— Aucun —</option>
                                @foreach($departements as $dept)
                                    <option value="{{ $dept->idDepartement }}" {{ old('idDepartement', $dossier->idDepartement) == $dept->idDepartement ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Destination</label>
                            <input name="distination" value="{{ old('distination', $dossier->distination) }}" placeholder="Ex: Paris, Dubai..."
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Date de voyage</label>
                            <input name="dateVoyage" type="date" value="{{ old('dateVoyage', $dossier->dateVoyage) }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Nombre de personnes *</label>
                            <input name="nombrePersonnes" type="number" min="1" required
                                   value="{{ old('nombrePersonnes', $dossier->nombrePersonnes) }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Nombre de jours *</label>
                            <input name="nombreJours" type="number" min="0" required
                                   value="{{ old('nombreJours', $dossier->nombreJours) }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Montant (MAD) *</label>
                            <input name="montant" type="number" step="0.01" min="0" required
                                   value="{{ old('montant', $dossier->montant) }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Statut</label>
                            <select name="status"
                                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                                <option value="ouvert"   {{ old('status', $dossier->status) === 'ouvert'   ? 'selected' : '' }}>Ouvert</option>
                                <option value="en_cours" {{ old('status', $dossier->status) === 'en_cours' ? 'selected' : '' }}>En cours</option>
                                <option value="ferme"    {{ old('status', $dossier->status) === 'ferme'    ? 'selected' : '' }}>Fermé</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Titre du document</label>
                            <input name="titreDocument" value="{{ old('titreDocument', $dossier->titreDocument) }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div class="md:col-span-2 lg:col-span-3">
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Commentaire</label>
                            <textarea name="commentaire" rows="3"
                                      class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40] resize-none">{{ old('commentaire', $dossier->commentaire) }}</textarea>
                        </div>

                        <div class="md:col-span-2 lg:col-span-3">
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Réponse</label>
                            <textarea name="reponse" rows="3"
                                      class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40] resize-none">{{ old('reponse', $dossier->reponse) }}</textarea>
                        </div>

                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('dossiers.show', $dossier->idDossier) }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Retour
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#b11d40] text-white font-bold rounded-xl hover:bg-[#7c1233] transition-all text-sm shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Enregistrer les modifications
                </button>
            </div>

        </form>
    </div>
</x-app-layout>