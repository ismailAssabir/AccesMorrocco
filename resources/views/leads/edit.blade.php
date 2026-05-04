<x-app-layout>
    <div class="p-8 min-h-screen">

        {{-- TOAST NOTIFICATIONS --}}
        <div class="fixed top-5 right-5 z-50 flex flex-col gap-3 pointer-events-none">
            @if(session('msg'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-x-4"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-x-0"
                 x-transition:leave-end="opacity-0 translate-x-4"
                 class="bg-white border-l-4 border-emerald-500 text-slate-700 shadow-lg rounded-xl p-4 flex items-center gap-3 w-80 pointer-events-auto">
                <div class="bg-emerald-100 p-2 rounded-full">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <p class="font-medium text-sm flex-1">{{ session('msg') }}</p>
                <button @click="show = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            @endif

            @if(session('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-x-4"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-x-0"
                 x-transition:leave-end="opacity-0 translate-x-4"
                 class="bg-white border-l-4 border-red-500 text-slate-700 shadow-lg rounded-xl p-4 flex items-center gap-3 w-80 pointer-events-auto">
                <div class="bg-red-100 p-2 rounded-full">
                    <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <p class="font-medium text-sm flex-1">{{ session('error') }}</p>
                <button @click="show = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            @endif
        </div>

        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('leads.index') }}"
               class="inline-flex items-center gap-2 text-slate-400 hover:text-[#b11d40] text-sm font-bold mb-3 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Retour aux leads
            </a>
            <h1 class="text-2xl font-extrabold text-slate-800">Modifier le Lead</h1>
            <p class="text-slate-500 text-sm">{{ $lead->firstName }} {{ $lead->lastName }}</p>
        </div>

        <form method="POST" action="{{ route('leads.update', $lead->idLead) }}">
            @csrf @method('PUT')

            <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden mb-6">
                <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                <div class="p-6">
                    <h3 class="text-sm font-black text-slate-400 uppercase tracking-wider mb-5">Informations personnelles</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Prénom *</label>
                            <input name="firstName" required value="{{ old('firstName', $lead->firstName) }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border {{ $errors->has('firstName') ? 'border-red-400' : 'border-slate-200' }} rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                            @error('firstName')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Nom *</label>
                            <input name="lastName" required value="{{ old('lastName', $lead->lastName) }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border {{ $errors->has('lastName') ? 'border-red-400' : 'border-slate-200' }} rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                            @error('lastName')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Type *</label>

                            @php
                                $knownTypes = ['particulier', 'famille', 'entreprise', 'groupe'];
                                $currentType = old('type', $lead->type);
                                $isOther = $currentType && !in_array($currentType, $knownTypes);
                            @endphp

                            <select name="type_select" id="type_select" 
                                onchange="
                                        var isOther = this.value === 'autre';
                                        document.getElementById('other-type-wrapper').classList.toggle('hidden', !isOther);
                                        document.getElementById('type-other-input').disabled = !isOther;
                                        document.getElementById('type-select').disabled = isOther;
                                    "
                                class="w-full px-3 py-2.5 bg-slate-50 border {{ $errors->has('type') ? 'border-red-400' : 'border-slate-200' }} rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                                <option value="" disabled {{ !$currentType ? 'selected' : '' }}>Sélectionner un type</option>
                                <option value="particulier" {{ $currentType === 'particulier' ? 'selected' : '' }}>Particulier</option>
                                <option value="famille"     {{ $currentType === 'famille'     ? 'selected' : '' }}>Famille</option>
                                <option value="entreprise"  {{ $currentType === 'entreprise'  ? 'selected' : '' }}>Entreprise</option>
                                <option value="groupe"      {{ $currentType === 'groupe'      ? 'selected' : '' }}>Groupe</option>
                                <option value="autre"       {{ $isOther                       ? 'selected' : '' }}>Autre</option>
                            </select>

                            <div id="other-type-wrapper" class="{{ $isOther ? '' : 'hidden' }} mt-2">
                                <input name="type" id="type-other-input"
                                    value="{{ $isOther ? $currentType : '' }}"
                                    placeholder="Précisez le type..."
                                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                            </div>

                            @error('type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Email</label>
                            <input name="email" type="email" value="{{ old('email', $lead->email) }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border {{ $errors->has('email') ? 'border-red-400' : 'border-slate-200' }} rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Téléphone</label>
                            <input name="phoneNumber" value="{{ old('phoneNumber', $lead->phoneNumber) }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">CNE</label>
                            <input name="CNE" value="{{ old('CNE', $lead->CNE) }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Nationalité</label>
                            <input name="nationalite" value="{{ old('nationalite', $lead->nationalite) }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Source</label>
                            <input name="source" value="{{ old('source', $lead->source) }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Adresse</label>
                            <input name="address" value="{{ old('address', $lead->address) }}"
                                   class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40]">
                        </div>

                        <div class="md:col-span-2 lg:col-span-3">
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1.5">Note</label>
                            <textarea name="note" rows="3"
                                      class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-[#b11d40] focus:ring-1 focus:ring-[#b11d40] resize-none">{{ old('note', $lead->note) }}</textarea>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Boutons --}}
            <div class="flex items-center justify-between">
                <a href="{{ route('leads.index') }}"
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