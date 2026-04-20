{{-- ═══════════ MODAL — Modifier Département ═══════════ --}}
<div id="editDepartmentModal"
     class="fixed inset-0 z-[100] {{ ($errors->any() && old('_method') === 'PUT') ? '' : 'hidden' }} flex items-center justify-center p-4"
     role="dialog" aria-modal="true" aria-labelledby="editDeptModalTitle">

    {{-- Backdrop --}}
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeEditDeptModal()"></div>

    {{-- Panel --}}
    <div class="relative bg-white w-full max-w-lg rounded-2xl shadow-2xl border border-slate-200 overflow-hidden flex flex-col max-h-[92vh] z-10"
         style="animation: modalIn .2s ease-out">

        {{-- Header --}}
        <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
            <div>
                <h2 class="text-lg font-black text-slate-800" id="editDeptModalTitle">Modifier Département</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Mise à jour · Access Morocco</p>
            </div>
            <button type="button" onclick="closeEditDeptModal()"
                class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#b11d40] hover:border-[#b11d40]/30 transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        @php
            $users = \App\Models\User::orderBy('firstName')->get();
        @endphp
        {{-- Form --}}
        <div class="overflow-y-auto">
            <form id="editDepartmentForm" action="{{ old('edit_url', '#') }}" method="POST" class="p-7 space-y-5">
                @csrf
                @method('PUT')
                
                {{-- Store the intended URL in case of validation failure --}}
                <input type="hidden" name="edit_url" id="edit_url_input" value="{{ old('edit_url') }}">

                {{-- Title --}}
                <div class="space-y-1.5">
                    <label for="edit_dept_title" class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">
                        Nom du département <span class="text-[#b11d40]">*</span>
                    </label>
                    <input type="text" name="title" id="edit_dept_title" required value="{{ old('title') }}"
                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all focus:border-[#b11d40] focus:ring-4 focus:ring-[#b11d40]/5 @if($errors->has('title') && old('_method') === 'PUT') border-red-400 @endif">
                    @if($errors->has('title') && old('_method') === 'PUT')
                        <p class="text-xs text-red-500 font-semibold ml-1 mt-1">{{ $errors->first('title') }}</p>
                    @endif
                </div>

                {{-- Description --}}
                <div class="space-y-1.5">
                    <label for="edit_dept_description" class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Description</label>
                    <textarea name="description" id="edit_dept_description" rows="3"
                              class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all resize-none focus:border-[#b11d40] focus:ring-4 focus:ring-[#b11d40]/5 @if($errors->has('description') && old('_method') === 'PUT') border-red-400 @endif">{{ old('description') }}</textarea>
                    @if($errors->has('description') && old('_method') === 'PUT')
                        <p class="text-xs text-red-500 font-semibold ml-1 mt-1">{{ $errors->first('description') }}</p>
                    @endif
                </div>

                {{-- Manager Dropdown --}}
                <div class="space-y-1.5">
                    <label for="edit_dept_manager" class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Manager / Responsable</label>
                    <div class="relative">
                        <select name="idUser" id="edit_dept_manager"
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none transition-all appearance-none focus:border-[#b11d40] focus:ring-4 focus:ring-[#b11d40]/5 @if($errors->has('idUser') && old('_method') === 'PUT') border-red-400 @endif">
                            <option value="">— Sans manager pour le moment —</option>
                            @if(isset($users))
                                @foreach($users as $user)
                                    <option value="{{ $user->idUser }}" {{ old('idUser') == $user->idUser ? 'selected' : '' }}>
                                        {{ $user->firstName }} {{ $user->lastName }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                    @if($errors->has('idUser') && old('_method') === 'PUT')
                        <p class="text-xs text-red-500 font-semibold ml-1 mt-1">{{ $errors->first('idUser') }}</p>
                    @endif
                </div>

                {{-- Buttons --}}
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeEditDeptModal()"
                        class="flex-1 py-3.5 rounded-2xl border-2 border-slate-100 font-bold text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition-all text-sm">
                        Annuler
                    </button>
                    <button type="submit"
                        class="flex-1 py-3.5 rounded-2xl bg-[#b11d40] hover:bg-[#911633] active:scale-95 font-extrabold text-white transition-all shadow-lg shadow-[#b11d40]/20 text-sm">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditDeptModal(id, title, description, managerId) {
        // Base URL for the update route, handling trailing slashes correctly
        // Note: Used /departements/edit/ base as per actual web.php but can be easily changed to /departements/ 
        let baseUrl = '{{ url("/departements/edit/") }}';
        const url = `${baseUrl}/${id}`;
        
        // Update form action
        document.getElementById('editDepartmentForm').action = url;
        document.getElementById('edit_url_input').value = url;
        
        // Populate inputs gracefully 
        document.getElementById('edit_dept_title').value = title || '';
        document.getElementById('edit_dept_description').value = description || '';
        document.getElementById('edit_dept_manager').value = managerId || '';
        
        // Open modal
        document.getElementById('editDepartmentModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeEditDeptModal() {
        document.getElementById('editDepartmentModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>
