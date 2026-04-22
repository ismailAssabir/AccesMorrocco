<x-app-layout>
    <div class="px-8 py-8 min-h-screen bg-[#F8FAFC]">
        
        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ url('/users') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-slate-600 transition-colors mb-4">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Retour aux employés
            </a>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Ajouter un Employé</h1>
            <p class="text-sm font-medium text-slate-500 mt-1">Remplissez les informations pour enregistrer un nouveau collaborateur.</p>
        </div>

        {{-- Form Card --}}
        <div class="max-w-3xl bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#7c1233] to-[#be2346]"></div>
            
            <form action="{{ url('/users') }}" method="POST" class="p-8">
                @csrf
                
                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-xs text-red-600 font-semibold space-y-1">
                        <p>Veuillez corriger les erreurs ci-dessous :</p>
                        <ul class="list-disc pl-4 opacity-80">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                    
                    {{-- Personal Info --}}
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 mb-1.5">Prénom *</label>
                        <input type="text" name="firstName" value="{{ old('firstName') }}" required class="w-full bg-slate-50 border border-slate-200 focus:border-[#be2346] focus:bg-white rounded-xl px-4 py-3 text-sm outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 mb-1.5">Nom *</label>
                        <input type="text" name="lastName" value="{{ old('lastName') }}" required class="w-full bg-slate-50 border border-slate-200 focus:border-[#be2346] focus:bg-white rounded-xl px-4 py-3 text-sm outline-none transition-all">
                    </div>

                    {{-- Contact Info --}}
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 mb-1.5">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-slate-50 border border-slate-200 focus:border-[#be2346] focus:bg-white rounded-xl px-4 py-3 text-sm outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 mb-1.5">Téléphone *</label>
                        <input type="text" name="phoneNumber" value="{{ old('phoneNumber') }}" required class="w-full bg-slate-50 border border-slate-200 focus:border-[#be2346] focus:bg-white rounded-xl px-4 py-3 text-sm outline-none transition-all">
                    </div>

                    {{-- System & Security --}}
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 mb-1.5">Mot de Passe *</label>
                        <input type="password" name="password" required class="w-full bg-slate-50 border border-slate-200 focus:border-[#be2346] focus:bg-white rounded-xl px-4 py-3 text-sm outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 mb-1.5">CIN *</label>
                        <input type="text" name="cin" value="{{ old('cin') }}" required class="w-full bg-slate-50 border border-slate-200 focus:border-[#be2346] focus:bg-white rounded-xl px-4 py-3 text-sm outline-none transition-all">
                    </div>

                    {{-- Job Details --}}
                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 pt-4 mt-2 border-t border-slate-100">
                        <div>
                            <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 mb-1.5">Département</label>
                            <select name="idDepartement" class="w-full bg-slate-50 border border-slate-200 focus:border-[#be2346] focus:bg-white rounded-xl px-4 py-3 text-sm outline-none transition-all">
                                <option value="">-- Sélectionner --</option>
                                {{-- We dynamically pull this since it's allowed in Blade if controller didn't supply --}}
                                @php $depts = \App\Models\Departement::all(); @endphp
                                @foreach($depts as $dept)
                                    <option value="{{ $dept->idDepartement }}" {{ old('idDepartement') == $dept->idDepartement ? 'selected' : '' }}>
                                        {{ $dept->title ?? $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 mb-1.5">Rôle (Type) *</label>
                            <select name="type" class="w-full bg-slate-50 border border-slate-200 focus:border-[#be2346] focus:bg-white rounded-xl px-4 py-3 text-sm outline-none transition-all">
                                <option value="employee" {{ old('type') == 'employee' ? 'selected' : '' }}>Employé</option>
                                <option value="manager" {{ old('type') == 'manager' ? 'selected' : '' }}>Manager</option>
                                <option value="admin" {{ old('type') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 mb-1.5">Poste</label>
                            <input type="text" name="post" value="{{ old('post') }}" class="w-full bg-slate-50 border border-slate-200 focus:border-[#be2346] focus:bg-white rounded-xl px-4 py-3 text-sm outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 mb-1.5">Type de Contrat</label>
                            <select name="typeContrat" class="w-full bg-slate-50 border border-slate-200 focus:border-[#be2346] focus:bg-white rounded-xl px-4 py-3 text-sm outline-none transition-all">
                                <option value="CD" {{ old('typeContrat') == 'CD' ? 'selected' : '' }}>CDI</option>
                                <option value="CI" {{ old('typeContrat') == 'CI' ? 'selected' : '' }}>CI</option>
                                <option value="freelance" {{ old('typeContrat') == 'freelance' ? 'selected' : '' }}>Freelance</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 mb-1.5">Salaire Mensuel *</label>
                            <input type="number" name="salaire" value="{{ old('salaire') }}" required class="w-full bg-slate-50 border border-slate-200 focus:border-[#be2346] focus:bg-white rounded-xl px-4 py-3 text-sm outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1 mb-1.5">Date de Naissance *</label>
                            <input type="date" name="birthday" value="{{ old('birthday') }}" required class="w-full bg-slate-50 border border-slate-200 focus:border-[#be2346] focus:bg-white rounded-xl px-4 py-3 text-sm outline-none transition-all">
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ url('/users') }}" class="px-6 py-2.5 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-100 transition-colors">
                        Annuler
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#be2346] hover:bg-[#a01d3a] text-white text-sm font-extrabold shadow-md shadow-[#be2346]/20 transition-all focus:ring-4 focus:ring-[#be2346]/20">
                        Ajouter Employé
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
