<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen font-sans text-slate-900">

        {{-- ═══════════ TOP BAR ═══════════ --}}
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('departements.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-[#b11d40] hover:border-[#b11d40]/30 hover:bg-[#b11d40]/5 transition-all shadow-sm active:scale-95">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-black uppercase text-[#b11d40] tracking-widest bg-[#b11d40]/10 px-2 py-0.5 rounded-md">Département</span>
                </div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800 mt-1">Modifier: {{ $departement->title }}</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Mettez à jour les informations et la structure de ce département.</p>
            </div>
        </div>

        {{-- ═══════════ FLASH MESSAGES ═══════════ --}}
        <div id="status-messages" class="mb-6">
            @if(session('msg'))
                <div class="msg-item mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-600 rounded-2xl font-bold text-sm flex items-center gap-3 transition-all duration-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('msg') }}
                </div>
            @endif
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const messages = document.querySelectorAll('.msg-item');
                messages.forEach(msg => {
                    setTimeout(() => {
                        msg.style.opacity = '0';
                        msg.style.transform = 'translateY(-10px)';
                        setTimeout(() => msg.remove(), 500);
                    }, 3000);
                });
            });
        </script>

        {{-- ═══════════ FORM CARD ═══════════ --}}
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-[32px] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                
                {{-- Decorative Top Bar --}}
                <div class="h-2 w-full bg-gradient-to-r from-[#be2346] to-[#7c1233]"></div>

                @php
                    $users = \App\Models\User::orderBy('firstName')->get();
                @endphp
                
                <form action="{{ route('departements.update', $departement->idDepartement ?? $departement->id) }}" method="POST" class="p-8 md:p-12 space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <h3 class="text-xs font-black uppercase text-slate-400 tracking-[0.2em] flex items-center gap-2">
                            <span class="w-8 h-px bg-slate-200"></span>
                            Détails du Département
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Title --}}
                            <div class="md:col-span-2 space-y-1.5">
                                <label for="dept_title" class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">
                                    Nom du département <span class="text-[#be2346]">*</span>
                                </label>
                                <input type="text" name="title" id="dept_title" required value="{{ old('title', $departement->title) }}"
                                       placeholder="Ex: Ressources Humaines"
                                       class="w-full bg-slate-50 border {{ $errors->has('title') ? 'border-red-400' : 'border-slate-200' }} rounded-2xl px-4 py-3.5 text-sm outline-none transition-all focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                @error('title')
                                    <p class="text-xs text-red-500 font-semibold ml-1 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="md:col-span-2 space-y-1.5">
                                <label for="dept_description" class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Description</label>
                                <textarea name="description" id="dept_description" rows="4"
                                          placeholder="Missions et objectifs de ce département..."
                                          class="w-full bg-slate-50 border {{ $errors->has('description') ? 'border-red-400' : 'border-slate-200' }} rounded-2xl px-4 py-3.5 text-sm outline-none transition-all resize-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">{{ old('description', $departement->description) }}</textarea>
                                @error('description')
                                    <p class="text-xs text-red-500 font-semibold ml-1 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Manager Dropdown --}}
                            <div class="md:col-span-2 space-y-1.5">
                                <label for="dept_manager" class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Manager / Responsable</label>
                                <div class="relative">
                                    <select name="idUser" id="dept_manager"
                                            class="w-full bg-slate-50 border {{ $errors->has('idUser') ? 'border-red-400' : 'border-slate-200' }} rounded-2xl px-4 py-3.5 text-sm outline-none transition-all appearance-none focus:border-[#be2346] focus:ring-4 focus:ring-[#be2346]/5">
                                        <option value="">— Sans manager pour le moment —</option>
                                        @if(isset($users))
                                            @foreach($users as $user)
                                                <option value="{{ $user->idUser }}" {{ old('idUser', $departement->idUser) == $user->idUser ? 'selected' : '' }}>
                                                    {{ $user->firstName }} {{ $user->lastName }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                                @error('idUser')
                                    <p class="text-xs text-red-500 font-semibold ml-1 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="pt-8 flex flex-col md:flex-row gap-4 border-t border-slate-100">
                        <a href="{{ route('departements.show', $departement->idDepartement ?? $departement->id) }}"
                           class="flex-1 py-4 rounded-2xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition-all text-sm text-center">
                            Annuler
                        </a>
                        <button type="submit"
                                class="flex-1 py-4 rounded-2xl bg-[#be2346] hover:bg-[#a01d3a] active:scale-[0.98] font-black text-white transition-all shadow-xl shadow-[#be2346]/20 text-sm">
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
