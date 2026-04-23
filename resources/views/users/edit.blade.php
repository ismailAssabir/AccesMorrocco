<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen font-sans text-slate-900">
        
        {{-- Header Section --}}
        <div class="max-w-4xl mx-auto mb-8">
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ route('users.index') }}" class="p-2 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#be2346] hover:border-[#be2346]/30 transition-all shadow-sm">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <div>
                    <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Modifier le profil</h1>
                    <p class="text-slate-500 text-sm mt-1 font-medium">Mise à jour des informations de {{ $user->firstName }} {{ $user->lastName }}</p>
                </div>
            </div>
        </div>

        {{-- Main Form Card --}}
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-[32px] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                
                {{-- Decorative Top Bar --}}
                <div class="h-2 w-full bg-gradient-to-r from-[#be2346] to-[#7c1233]"></div>

                <form action="{{ route('users.update', $user->idUser) }}" method="POST" class="p-8 md:p-12 space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        {{-- Section: Informations Personnelles --}}
                        <div class="space-y-6">
                            <h3 class="text-xs font-black uppercase text-slate-400 tracking-[0.2em] flex items-center gap-2">
                                <span class="w-8 h-px bg-slate-200"></span>
                                Informations Personnelles
                            </h3>

                            <div class="space-y-4">
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Prénom</label>
                                    <input type="text" name="firstName" value="{{ old('firstName', $user->firstName) }}" required
                                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Nom</label>
                                    <input type="text" name="lastName" value="{{ old('lastName', $user->lastName) }}" required
                                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">CIN / ID</label>
                                    <input type="text" name="cin" value="{{ old('cin', $user->cin) }}" required
                                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Date de Naissance</label>
                                    <input type="date" name="birthday" value="{{ old('birthday', $user->birthday ? date('Y-m-d', strtotime($user->birthday)) : '') }}" required
                                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>
                            </div>
                        </div>

                        {{-- Section: Contact & Localisation --}}
                        <div class="space-y-6">
                            <h3 class="text-xs font-black uppercase text-slate-400 tracking-[0.2em] flex items-center gap-2">
                                <span class="w-8 h-px bg-slate-200"></span>
                                Contact & Adresse
                            </h3>

                            <div class="space-y-4">
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Email Professionnel</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Téléphone</label>
                                    <input type="text" name="phoneNumber" value="{{ old('phoneNumber', $user->phoneNumber) }}" required
                                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Adresse</label>
                                    <input type="text" name="address" value="{{ old('address', $user->address) }}"
                                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>
                            </div>
                        </div>

                        {{-- Section: Carrière & Contrat --}}
                        <div class="space-y-6 md:col-span-2">
                            <h3 class="text-xs font-black uppercase text-slate-400 tracking-[0.2em] flex items-center gap-2">
                                <span class="w-8 h-px bg-slate-200"></span>
                                Conditions de Travail
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Poste Actuel</label>
                                    <input type="text" name="post" value="{{ old('post', $user->post) }}"
                                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Salaire (MAD)</label>
                                    <input type="number" name="salaire" value="{{ old('salaire', $user->salaire) }}" required
                                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Date d'embauche</label>
                                    <input type="date" name="dateEmb" value="{{ old('dateEmb', $user->dateEmb ? date('Y-m-d', strtotime($user->dateEmb)) : '') }}"
                                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Département Affecté</label>
                                    <select name="idDepartement" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                        @foreach($departements as $dept)
                                            <option value="{{ $dept->idDepartement }}" {{ old('idDepartement', $user->idDepartement) == $dept->idDepartement ? 'selected' : '' }}>
                                                {{ $dept->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Type de Contrat</label>
                                    <select name="typeContrat" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                        <option value="CD" {{ old('typeContrat', $user->typeContrat) == 'CD' ? 'selected' : '' }}>CDI</option>
                                        <option value="CI" {{ old('typeContrat', $user->typeContrat) == 'CI' ? 'selected' : '' }}>CI</option>
                                        <option value="freelance" {{ old('typeContrat', $user->typeContrat) == 'freelance' ? 'selected' : '' }}>Freelance</option>
                                    </select>
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Rôle Système</label>
                                    <select name="type" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                        <option value="employee" {{ old('type', $user->type) == 'employee' ? 'selected' : '' }}>Employé</option>
                                        <option value="manager" {{ old('type', $user->type) == 'manager' ? 'selected' : '' }}>Manager</option>
                                        <option value="admin" {{ old('type', $user->type) == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Statut</label>
                                    <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                        <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Actif</option>
                                        <option value="desactive" {{ old('status', $user->status) == 'desactive' ? 'selected' : '' }}>Désactivé</option>
                                        <option value="conge" {{ old('status', $user->status) == 'conge' ? 'selected' : '' }}>En Congé</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Section: Sécurité (Facultatif) --}}
                        <div class="space-y-6 md:col-span-2">
                            <h3 class="text-xs font-black uppercase text-slate-400 tracking-[0.2em] flex items-center gap-2">
                                <span class="w-8 h-px bg-slate-200"></span>
                                Sécurité
                            </h3>
                            <div class="space-y-1.5 max-w-md">
                                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                                <input type="password" name="password" placeholder="Min. 8 caractères"
                                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                            </div>
                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="pt-10 flex flex-col md:flex-row gap-4">
                        <a href="{{ route('users.index') }}" 
                           class="flex-1 py-4 rounded-2xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition-all text-sm text-center">
                            Annuler les modifications
                        </a>
                        <button type="submit" 
                                class="flex-1 py-4 rounded-2xl bg-[#be2346] hover:bg-[#a01d3a] active:scale-[0.98] font-black text-white transition-all shadow-xl shadow-[#be2346]/20 text-sm">
                            Enregistrer les changements
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
