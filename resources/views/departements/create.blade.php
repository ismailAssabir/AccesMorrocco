{{-- ═══════════ MODAL — Nouveau Département ═══════════ --}}
<div id="addDepartmentModal"
     class="fixed inset-0 z-[100] {{ $errors->any() ? '' : 'hidden' }} flex items-center justify-center p-4"
     role="dialog" aria-modal="true" aria-labelledby="deptModalTitle">

    {{-- Backdrop --}}
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeDeptModal()"></div>

    {{-- Panel --}}
    <div class="relative bg-white w-full max-w-lg rounded-2xl shadow-2xl border border-slate-200 overflow-hidden flex flex-col max-h-[92vh] z-10"
         style="animation: modalIn .2s ease-out">

        {{-- Header --}}
        <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
            <div>
                <h2 class="text-lg font-black text-slate-800" id="deptModalTitle">Nouveau Département</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Fiche de création · Access Morocco</p>
            </div>
            <button type="button" onclick="closeDeptModal()"
                class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#b11d40] hover:border-[#b11d40]/30 transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        @php
            // هاد السطر كيجيب المستخدمين مرتبين بالاسم الأول
            $users = \App\Models\User::orderBy('firstName')->get();
        @endphp
        {{-- Form --}}
        <div class="overflow-y-auto">
            <form action="{{ route('departements.store') }}" method="POST" class="p-7 space-y-5">
                @csrf

                {{-- Title --}}
                <div class="space-y-1.5">
                    <label for="dept_title" class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">
                        Nom du département <span class="text-[#b11d40]">*</span>
                    </label>
                    <input type="text" name="title" id="dept_title" required value="{{ old('title') }}"
                           placeholder="Ex: Ressources Humaines"
                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#b11d40] focus:ring-4 focus:ring-[#b11d40]/5 @error('title') border-red-400 @enderror">
                    @error('title')
                        <p class="text-xs text-red-500 font-semibold ml-1 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="space-y-1.5">
                    <label for="dept_description" class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Description</label>
                    <textarea name="description" id="dept_description" rows="3"
                              placeholder="Missions et objectifs de ce département..."
                              class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all resize-none focus:border-[#b11d40] focus:ring-4 focus:ring-[#b11d40]/5 @error('description') border-red-400 @enderror">{{ old('description') }}</textarea>
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
                                {{-- Filter users directly in Blade collection to only show Managers --}}
                                @foreach($users->filter(fn($u) => strtolower($u->type ?? '') === 'manager') as $user)
                                    @php
                                        $uid   = $user->idUser ?? $user->id;
                                        $uName = trim(($user->firstName ?? '') . ' ' . ($user->lastName ?? '')) ?: 'Utilisateur';
                                    @endphp
                                    <option value="{{ $uid }}" {{ old('idUser') == $uid ? 'selected' : '' }}>
                                        {{ $uName }}
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
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeDeptModal()"
                        class="flex-1 py-3.5 rounded-2xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition-all text-sm">
                        Annuler
                    </button>
                    <button type="submit"
                        class="flex-1 py-3.5 rounded-2xl bg-[#b11d40] hover:bg-[#911633] active:scale-95 font-extrabold text-white transition-all shadow-lg shadow-[#b11d40]/20 text-sm">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    @keyframes modalIn {
        from { opacity: 0; transform: translateY(16px) scale(0.98); }
        to   { opacity: 1; transform: translateY(0)   scale(1);    }
    }
</style>
