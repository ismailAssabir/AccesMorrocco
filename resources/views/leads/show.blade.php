<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen">

        {{-- Header --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <a href="{{ route('leads.index') }}"
                   class="inline-flex items-center gap-2 text-slate-400 hover:text-[#b11d40] text-sm font-bold mb-2 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Retour aux leads
                </a>
                <h1 class="text-2xl font-extrabold text-slate-800">
                    {{ $lead->firstName }} {{ $lead->lastName }}
                </h1>
                <p class="text-slate-500 text-sm">Détails du prospect</p>
            </div>

            <div class="flex gap-3">
                @can('lead.edit')
                <button onclick="document.getElementById('modal-edit').classList.remove('hidden')"
                        class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-[#b11d40] hover:text-white hover:border-[#b11d40] transition-all text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Modifier
                </button>
                @endcan

                @can('lead.delete')
                <form method="POST" action="{{ route('leads.destroy', $lead->idLead) }}"
                      onsubmit="return confirm('Supprimer ce lead ?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="flex items-center gap-2 px-4 py-2 bg-white border border-red-200 text-red-500 font-bold rounded-xl hover:bg-red-500 hover:text-white transition-all text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Supprimer
                    </button>
                </form>
                @endcan
            </div>
        </div>

        {{-- Flash Message --}}
        @if(session('msg'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl text-sm font-semibold">
            {{ session('msg') }}
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Carte identité --}}
            <div class="lg:col-span-1">
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                    <div class="p-6 flex flex-col items-center text-center">
                        <div class="w-20 h-20 rounded-3xl bg-[#b11d40]/10 flex items-center justify-center mb-4">
                            <span class="text-[#b11d40] font-black text-2xl">
                                {{ strtoupper(substr($lead->firstName, 0, 1)) }}{{ strtoupper(substr($lead->lastName, 0, 1)) }}
                            </span>
                        </div>
                        <h2 class="text-xl font-extrabold text-slate-800">{{ $lead->firstName }} {{ $lead->lastName }}</h2>
                        <span class="mt-2 px-3 py-1 rounded-xl text-xs font-black bg-[#b11d40]/10 text-[#b11d40] uppercase">
                            {{ $lead->type }}
                        </span>

                        <div class="w-full mt-6 space-y-3 text-left">
                            <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-2xl">
                                <div class="w-8 h-8 rounded-xl bg-white border border-slate-200 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 font-bold uppercase">Email</p>
                                    <p class="text-sm text-slate-700 font-semibold">{{ $lead->email ?? '—' }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-2xl">
                                <div class="w-8 h-8 rounded-xl bg-white border border-slate-200 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 font-bold uppercase">Téléphone</p>
                                    <p class="text-sm text-slate-700 font-semibold">{{ $lead->phoneNumber ?? '—' }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-2xl">
                                <div class="w-8 h-8 rounded-xl bg-white border border-slate-200 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 font-bold uppercase">Adresse</p>
                                    <p class="text-sm text-slate-700 font-semibold">{{ $lead->adresse ?? '—' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Détails complets --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Informations personnelles --}}
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                    <div class="p-6">
                        <h3 class="text-sm font-black text-slate-400 uppercase tracking-wider mb-4">Informations personnelles</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div>
                                <p class="text-xs font-black text-slate-400 uppercase mb-1">CNE</p>
                                <p class="text-sm font-semibold text-slate-700">{{ $lead->CNE ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-black text-slate-400 uppercase mb-1">Nationalité</p>
                                <p class="text-sm font-semibold text-slate-700">{{ $lead->nationalite ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-black text-slate-400 uppercase mb-1">Source</p>
                                <p class="text-sm font-semibold text-slate-700">{{ $lead->source ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-black text-slate-400 uppercase mb-1">Département</p>
                                <p class="text-sm font-semibold text-slate-700">{{ $lead->departements->name ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-black text-slate-400 uppercase mb-1">Responsable</p>
                                <p class="text-sm font-semibold text-slate-700">
                                    {{ $lead->user ? $lead->user->firstName . ' ' . $lead->user->lastName : '—' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-black text-slate-400 uppercase mb-1">Date création</p>
                                <p class="text-sm font-semibold text-slate-700">
                                    {{ $lead->dateCreation ? \Carbon\Carbon::parse($lead->dateCreation)->format('d/m/Y') : '—' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Note --}}
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                    <div class="p-6">
                        <h3 class="text-sm font-black text-slate-400 uppercase tracking-wider mb-3">Note</h3>
                        @if($lead->note)
                            <p class="text-sm text-slate-700 leading-relaxed bg-slate-50 rounded-2xl p-4">{{ $lead->note }}</p>
                        @else
                            <p class="text-sm text-slate-400 italic">Aucune note renseignée.</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ===== MODAL EDIT ===== --}}
    @can('lead.edit')
    <div id="modal-edit" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
        <div class="bg-white rounded-3xl shadow-xl w-full max-w-2xl overflow-hidden">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-extrabold text-slate-800">Modifier le Lead</h2>
                    <button onclick="document.getElementById('modal-edit').classList.add('hidden')"
                            class="text-slate-400 hover:text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <form method="POST" action="{{ route('leads.update', $lead->idLead) }}">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Prénom *</label>
                            <input name="firstName" required value="{{ $lead->firstName }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Nom *</label>
                            <input name="lastName" required value="{{ $lead->lastName }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Email</label>
                            <input name="email" type="email" value="{{ $lead->email }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Téléphone</label>
                            <input name="phoneNumber" value="{{ $lead->phoneNumber }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Type *</label>
                            <input name="type" required value="{{ $lead->type }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Source</label>
                            <input name="source" value="{{ $lead->source }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Nationalité</label>
                            <input name="nationalite" value="{{ $lead->nationalite }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Adresse</label>
                            <input name="adresse" value="{{ $lead->adresse }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">CNE</label>
                            <input name="CNE" value="{{ $lead->CNE }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Département</label>
                            <select name="idDepartement"
                                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                                <option value="">— Aucun —</option>
                                @foreach($departements as $dept)
                                    <option value="{{ $dept->idDepartement }}" {{ $lead->idDepartement == $dept->idDepartement ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Responsable</label>
                            <select name="idUser"
                                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                                <option value="">— Aucun —</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->idUser }}" {{ $lead->idUser == $user->idUser ? 'selected' : '' }}>
                                        {{ $user->firstName }} {{ $user->lastName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Note</label>
                            <textarea name="note" rows="3"
                                      class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40] resize-none">{{ $lead->note }}</textarea>
                        </div>
                    </div>
                    <div class="flex gap-3 justify-end mt-6">
                        <button type="button" onclick="document.getElementById('modal-edit').classList.add('hidden')"
                                class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm">
                            Annuler
                        </button>
                        <button type="submit"
                                class="px-5 py-2.5 bg-[#b11d40] text-white font-bold rounded-xl hover:bg-[#7c1233] transition-all text-sm shadow">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan

</x-app-layout>