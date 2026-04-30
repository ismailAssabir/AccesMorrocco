<x-app-layout>
<div class="p-8 bg-[#F8FAFC] min-h-screen">

    {{-- ═══════════ HEADER ═══════════ --}}
    @php
        $roleConfig = [
            'admin'    => ['badge' => 'bg-rose-50 text-rose-700 border-rose-200'],
            'manager'  => ['badge' => 'bg-blue-50 text-blue-700 border-blue-200'],
            'employee' => ['badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
        ];
        $cfg = $roleConfig[strtolower($role->name)] ?? ['badge' => 'bg-[#be2346]/10 text-[#be2346] border-[#be2346]/20'];
    @endphp
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
        <div class="flex items-center gap-4">
            <a href="{{ route('permissions.index') }}" 
               class="w-10 h-10 rounded-2xl border border-slate-200 bg-white flex items-center justify-center shadow-sm hover:border-[#be2346]/30 hover:text-[#be2346] transition-all group">
                <svg class="w-4 h-4 text-slate-400 group-hover:text-[#be2346]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">
                        Permissions du Rôle
                    </h1>
                    <span class="px-3 py-1 rounded-xl text-sm font-black border uppercase tracking-wider {{ $cfg['badge'] }}">
                        {{ ucfirst($role->name) }}
                    </span>
                </div>
                <p class="text-slate-400 text-sm mt-1 font-medium">Configurez les droits d'accès pour ce rôle.</p>
            </div>
        </div>

        {{-- Stats badge --}}
        @can('permission.edit')
        <div class="flex items-center gap-3">
            <div class="px-4 py-2 bg-white border border-slate-200 rounded-2xl shadow-sm text-center">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Modules</p>
                <p class="text-lg font-black text-slate-700 leading-none">{{ count($permissions) }}</p>
            </div>
            <div class="px-4 py-2 bg-white border border-slate-200 rounded-2xl shadow-sm text-center">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Permissions</p>
                <p class="text-lg font-black text-[#be2346] leading-none">{{ $role->permissions->count() }}</p>
            </div>
        </div>
        @endcan
    </div>

    @can('permission.edit')
    <form action="{{ route('permissions.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- ═══════════ SEARCH & FILTER BAR ═══════════ --}}
        <div class="flex flex-col sm:flex-row gap-3 mb-8 p-4 bg-white border border-slate-200 rounded-[2rem] shadow-sm">
            {{-- Search Input --}}
            <div class="relative flex-1">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input id="perm-search" type="text" placeholder="Rechercher une permission..." 
                    class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium outline-none transition-all focus:border-[#be2346]/40 focus:ring-4 focus:ring-[#be2346]/10 placeholder:text-slate-400">
            </div>

            {{-- Module Filter --}}
            <select id="perm-module-filter" class="bg-slate-50 border border-slate-200 rounded-2xl px-4 py-2.5 text-[11px] font-black uppercase tracking-widest text-slate-500 outline-none focus:border-[#be2346]/40 focus:ring-4 focus:ring-[#be2346]/10 transition-all appearance-none cursor-pointer min-w-[180px]">
                <option value="">Tous les modules</option>
                @foreach($permissions as $module => $perms)
                <option value="{{ strtolower($module) }}">{{ $module }}</option>
                @endforeach
            </select>

            {{-- Filter: Checked only --}}
            <button type="button" id="perm-checked-filter"
                class="flex items-center gap-2 px-4 py-2.5 rounded-2xl border border-slate-200 bg-slate-50 text-[11px] font-black uppercase tracking-widest text-slate-500 hover:border-[#be2346]/30 hover:bg-[#be2346]/5 hover:text-[#be2346] transition-all whitespace-nowrap">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                Actives seulement
            </button>

            {{-- Reset --}}
            <button type="button" id="perm-reset"
                class="flex items-center gap-2 px-4 py-2.5 rounded-2xl border border-slate-200 bg-slate-50 text-[11px] font-black uppercase tracking-widest text-slate-400 hover:text-slate-600 transition-all">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Réinitialiser
            </button>
        </div>

        {{-- Result Counter --}}
        <div id="perm-results-info" class="hidden mb-4 px-4 py-2 bg-[#be2346]/5 border border-[#be2346]/15 rounded-2xl">
            <p class="text-xs font-bold text-[#be2346]"><span id="perm-visible-count">0</span> résultat(s) trouvé(s)</p>
        </div>

        <div id="perm-grid" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach($permissions as $module => $perms)
            <div class="perm-module-card group bg-white border border-slate-200 rounded-[2rem] shadow-sm hover:shadow-lg hover:border-slate-300 transition-all duration-300 overflow-hidden"
                 data-module="{{ strtolower($module) }}">
                
                {{-- Module Header --}}
                <div class="px-6 pt-6 pb-4 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-[#be2346]/10 flex items-center justify-center">
                            <svg class="w-4 h-4 text-[#be2346]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h8"/>
                            </svg>
                        </div>
                        <p class="font-black text-slate-800 uppercase tracking-widest text-xs">{{ $module }}</p>
                    </div>
                    <label class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-100 cursor-pointer hover:border-[#be2346]/30 hover:bg-[#be2346]/5 transition-all">
                        <input type="checkbox" class="select-all accent-[#be2346]" data-module="{{ $module }}">
                        <span class="text-[10px] font-black text-[#be2346] uppercase tracking-widest">Tout cocher</span>
                    </label>
                </div>

                {{-- Permission Checkboxes --}}
                <div class="p-5 grid grid-cols-2 gap-3">
                    @foreach($perms as $perm)
                    @php 
                        $parts = explode('.', $perm->name);
                        $label = count($parts) > 1 ? $parts[1] : $perm->name;
                        $isChecked = $role->hasPermissionTo($perm->name);
                    @endphp
                    <label class="perm-item relative flex items-center gap-3 p-3.5 rounded-2xl border cursor-pointer transition-all duration-200
                        {{ $isChecked ? 'border-[#be2346]/30 bg-[#be2346]/5' : 'border-slate-100 bg-slate-50/50 hover:border-[#be2346]/20 hover:bg-[#be2346]/5' }}"
                         data-perm-label="{{ strtolower($label) }}" data-checked="{{ $isChecked ? '1' : '0' }}">
                        <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                               class="perm-{{ $module }} accent-[#be2346] w-4 h-4"
                               {{ $isChecked ? 'checked' : '' }}>
                        <span class="text-xs font-bold {{ $isChecked ? 'text-[#be2346]' : 'text-slate-600' }} capitalize">
                            {{ $label }}
                        </span>
                        @if($isChecked)
                        <span class="absolute top-2 right-2 w-1.5 h-1.5 rounded-full bg-[#be2346]"></span>
                        @endif
                    </label>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        {{-- Sticky Save Button --}}
        <div class="sticky bottom-8 mt-10 flex justify-center">
            <button type="submit" 
                    class="flex items-center gap-3 bg-[#be2346] hover:bg-[#a01d3a] text-white px-10 py-4 rounded-2xl font-black shadow-xl shadow-[#be2346]/30 transition-all active:scale-95">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                Enregistrer les modifications · {{ ucfirst($role->name) }}
            </button>
        </div>
    </form>
    @endcan

    <script>
        // ── Select All per module ──
        document.querySelectorAll('.select-all').forEach(check => {
            check.addEventListener('change', function() {
                document.querySelectorAll('.perm-' + this.dataset.module).forEach(p => p.checked = this.checked);
            });
        });

        // ── Search & Filter Logic ──
        const searchInput   = document.getElementById('perm-search');
        const moduleFilter  = document.getElementById('perm-module-filter');
        const checkedFilter = document.getElementById('perm-checked-filter');
        const resetBtn      = document.getElementById('perm-reset');
        const resultsInfo   = document.getElementById('perm-results-info');
        const visibleCount  = document.getElementById('perm-visible-count');
        let showCheckedOnly = false;

        function applyFilters() {
            const search = searchInput.value.trim().toLowerCase();
            const module = moduleFilter.value.toLowerCase();
            let totalVisible = 0;
            let hasFilter = search !== '' || module !== '' || showCheckedOnly;

            document.querySelectorAll('.perm-module-card').forEach(card => {
                const cardModule = card.dataset.module;
                const moduleMatch = module === '' || cardModule === module;
                if (!moduleMatch) { card.style.display = 'none'; return; }

                // If search matches the module name → show ALL its permissions
                const moduleNameMatch = search !== '' && cardModule.includes(search);

                let cardVisible = false;
                card.querySelectorAll('.perm-item').forEach(item => {
                    const label = item.dataset.permLabel || '';
                    const isChecked = item.dataset.checked === '1' || item.querySelector('input[type=checkbox]').checked;
                    const labelMatch = search === '' || label.includes(search) || moduleNameMatch;
                    const checkedMatch = !showCheckedOnly || isChecked;
                    const show = labelMatch && checkedMatch;
                    item.style.display = show ? '' : 'none';
                    if (show) { cardVisible = true; totalVisible++; }
                });

                card.style.display = cardVisible ? '' : 'none';
            });

            resultsInfo.classList.toggle('hidden', !hasFilter);
            if (hasFilter) visibleCount.textContent = totalVisible;
        }

        searchInput.addEventListener('input', applyFilters);
        moduleFilter.addEventListener('change', applyFilters);

        checkedFilter.addEventListener('click', function() {
            showCheckedOnly = !showCheckedOnly;
            this.classList.toggle('bg-[#be2346]', showCheckedOnly);
            this.classList.toggle('text-white', showCheckedOnly);
            this.classList.toggle('border-transparent', showCheckedOnly);
            this.classList.toggle('bg-slate-50', !showCheckedOnly);
            this.classList.toggle('text-slate-500', !showCheckedOnly);
            applyFilters();
        });

        resetBtn.addEventListener('click', function() {
            searchInput.value = '';
            moduleFilter.value = '';
            showCheckedOnly = false;
            checkedFilter.className = 'flex items-center gap-2 px-4 py-2.5 rounded-2xl border border-slate-200 bg-slate-50 text-[11px] font-black uppercase tracking-widest text-slate-500 hover:border-[#be2346]/30 hover:bg-[#be2346]/5 hover:text-[#be2346] transition-all whitespace-nowrap';
            document.querySelectorAll('.perm-module-card, .perm-item').forEach(el => el.style.display = '');
            resultsInfo.classList.add('hidden');
        });
    </script>
</div>
</x-app-layout>