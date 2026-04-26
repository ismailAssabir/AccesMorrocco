<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen">

        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('clients.index') }}"
               class="inline-flex items-center gap-2 text-slate-400 hover:text-[#b11d40] text-sm font-bold mb-3 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Retour aux clients
            </a>
            <h1 class="text-2xl font-extrabold text-slate-800">Modifier le Client</h1>
            <p class="text-slate-500 text-sm">{{ $client->firstName }} {{ $client->lastName }}</p>
        </div>

        <form method="POST" action="{{ route('clients.update', $client->idClient) }}">
            @csrf @method('PUT')

            <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden mb-6">
                <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                <div class="p-6">
                    <h3 class="text-sm font-black text-slate-400 uppercase tracking-wider mb-5">Informations personnelles</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Prénom *</label>
                            <input name="firstName" required value="{{ old('firstName', $client->firstName) }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40] @error('firstName') border-red-400 @enderror">
                            @error('firstName')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Nom *</label>
                            <input name="lastName" required value="{{ old('lastName', $client->lastName) }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40] @error('lastName') border-red-400 @enderror">
                            @error('lastName')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Email *</label>
                            <input name="email" type="email" required value="{{ old('email', $client->email) }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40] @error('email') border-red-400 @enderror">
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Nouveau mot de passe</label>
                            <input name="password" type="password" placeholder="Laisser vide pour ne pas changer"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">CNE *</label>
                            <input name="CNE" required value="{{ old('CNE', $client->CNE) }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40] @error('CNE') border-red-400 @enderror">
                            @error('CNE')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Date de naissance *</label>
                            <input name="dateNaissance" type="date" required
                                   value="{{ old('dateNaissance', $client->dateNaissance) }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Téléphone *</label>
                            <input name="phoneNumber" required value="{{ old('phoneNumber', $client->phoneNumber) }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40] @error('phoneNumber') border-red-400 @enderror">
                            @error('phoneNumber')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Nationalité</label>
                            <input name="nationalite" value="{{ old('nationalite', $client->nationalite) }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Type</label>
                            <input name="type" value="{{ old('type', $client->type) }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Statut</label>
                            <select name="status"
                                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                                <option value="actif"   {{ old('status', $client->status) === 'actif'   ? 'selected' : '' }}>Actif</option>
                                <option value="inactif" {{ old('status', $client->status) === 'inactif' ? 'selected' : '' }}>Inactif</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Lead associé *</label>
                            <input name="idLead" required value="{{ old('idLead', $client->idLead) }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40] @error('idLead') border-red-400 @enderror">
                            @error('idLead')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-2 lg:col-span-3">
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Adresse</label>
                            <input name="address" value="{{ old('address', $client->address) }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div class="md:col-span-2 lg:col-span-3">
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Note</label>
                            <textarea name="note" rows="3"
                                      class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40] resize-none">{{ old('note', $client->note) }}</textarea>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Boutons --}}
            <div class="flex items-center justify-between">
                <a href="{{ route('clients.index') }}"
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