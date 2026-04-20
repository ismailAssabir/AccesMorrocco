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
        <div class="bg-white border border-slate-200 p-8 rounded-3xl shadow-sm max-w-3xl">
            @php
                $users = \App\Models\User::orderBy('firstName')->get();
            @endphp
            <form action="{{ route('departements.update', $departement->idDepartement ?? $departement->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Title --}}
                <div class="space-y-1.5">
                    <label for="dept_title" class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">
                        Nom du département <span class="text-[#b11d40]">*</span>
                    </label>
                    <input type="text" name="title" id="dept_title" required value="{{ old('title', $departement->title) }}"
                           placeholder="Ex: Ressources Humaines"
                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#b11d40] focus:ring-4 focus:ring-[#b11d40]/5 @error('title') border-red-400 @enderror">
                    @error('title')
                        <p class="text-xs text-red-500 font-semibold ml-1 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="space-y-1.5">
                    <label for="dept_description" class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Description</label>
                    <textarea name="description" id="dept_description" rows="4"
                              placeholder="Missions et objectifs de ce département..."
                              class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all resize-none focus:border-[#b11d40] focus:ring-4 focus:ring-[#b11d40]/5 @error('description') border-red-400 @enderror">{{ old('description', $departement->description) }}</textarea>
                    @error('description')
                        <p class="text-xs text-red-500 font-semibold ml-1 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Manager Dropdown --}}
                <div class="space-y-1.5">
                    <label for="dept_manager" class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Manager / Responsable</label>
                    <div class="relative">
                        <select name="idUser" id="dept_manager"
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#b11d40] focus:ring-4 focus:ring-[#b11d40]/5 @error('idUser') border-red-400 @enderror">
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

                {{-- Buttons --}}
                <div class="flex gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('departements.show', $departement->idDepartement ?? $departement->id) }}"
                        class="px-8 py-3.5 rounded-2xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition-all text-sm text-center">
                        Annuler
                    </a>
                    <button type="submit"
                        class="px-8 py-3.5 rounded-2xl bg-[#b11d40] hover:bg-[#911633] active:scale-95 font-extrabold text-white transition-all shadow-lg shadow-[#b11d40]/20 text-sm">
                        Mettre à jour le département
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>
