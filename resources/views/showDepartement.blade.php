<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen font-sans text-slate-900">

        {{-- ═══════════ TOP BAR ═══════════ --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('departements.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-[#b11d40] hover:border-[#b11d40]/30 hover:bg-[#b11d40]/5 transition-all shadow-sm active:scale-95">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] font-black uppercase text-[#b11d40] tracking-widest bg-[#b11d40]/10 px-2 py-0.5 rounded-md">Département</span>
                    </div>
                    <h1 class="text-2xl font-extrabold tracking-tight text-slate-800 mt-1">{{ $departement->title }}</h1>
                    <p class="text-slate-500 text-sm mt-1 font-medium">{{ $departement->description ?? 'Aucune description disponible pour ce département.' }}</p>
                </div>
            </div>
            <button type="button" onclick="openEditDeptModal('{{ $departement->idDepartement ?? $departement->id }}', '{{ addslashes($departement->title) }}', '{{ addslashes($departement->description) }}', '{{ $departement->idUser }}')"
                class="flex items-center gap-2 bg-[#b11d40] hover:bg-[#911633] active:scale-95 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-md shadow-[#b11d40]/20 text-sm whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Modifier le département
            </button>
        </div>

        {{-- ═══════════ KPI STRIP ═══════════ --}}
        @php
            $managerName    = $departement->manager ? trim($departement->manager->firstName . ' ' . $departement->manager->lastName) : null;
            $managerInitials = $managerName ? strtoupper(mb_substr($managerName, 0, 1)) : '?';
            $presence       = $departement->presence ?? 0;
            $tasks          = $departement->tasks ?? 0;
            
            // Allow user relationship as requested, fallback to employes relationship or an empty array
            $employeesList  = $departement->users ?? $departement->employes ?? collect([]); 
            
            // Only count active employees for the KPI card
            $empCount       = $employeesList->whereIn('status', ['Actif', 'actif', 'Active', 'active'])->count();
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            {{-- Manager Info --}}
            <div class="bg-white border md:col-span-1 border-slate-200 p-5 rounded-2xl shadow-sm border-l-4 border-l-[#b11d40] flex items-center justify-between gap-4">
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Manager</p>
                    <p class="text-lg font-extrabold text-slate-800">{{ $managerName ?? 'Non assigné' }}</p>
                </div>
                @if($managerName)
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#7c1233] to-[#b11d40] flex items-center justify-center font-black text-lg text-white shadow-sm shrink-0">
                        {{ $managerInitials }}
                    </div>
                @else
                    <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                @endif
            </div>

            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm border-l-4 border-l-emerald-500 flex items-center gap-4">
                <span class="p-2.5 rounded-xl bg-emerald-50 text-emerald-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Employés Actifs</p>
                    <p class="text-2xl font-extrabold text-slate-800">{{ $empCount }}</p>
                </div>
            </div>

            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm border-l-4 border-l-blue-500 flex items-center gap-4">
                <span class="p-2.5 rounded-xl bg-blue-50 text-blue-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Présence Moy.</p>
                    <p class="text-2xl font-extrabold text-slate-800">{{ collect($employeesList)->avg('presence') ?? '100' }}%</p>
                </div>
            </div>

            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-sm border-l-4 border-l-amber-500 flex items-center gap-4">
                <span class="p-2.5 rounded-xl bg-amber-50 text-amber-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </span>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Tâches Faites</p>
                    <p class="text-2xl font-extrabold text-slate-800">{{ $tasks }}%</p>
                </div>
            </div>
        </div>

        {{-- ═══════════ EMPLOYEES LIST ═══════════ --}}
        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden flex flex-col">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h3 class="text-lg font-extrabold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#b11d40]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Membres du Département
                </h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 uppercase tracking-wider text-[11px] font-black w-2/5">Employé</th>
                            <th class="px-6 py-4 uppercase tracking-wider text-[11px] font-black w-1/5">Rôle / Poste</th>
                            <th class="px-6 py-4 uppercase tracking-wider text-[11px] font-black w-1/5 text-center">Présence</th>
                            <th class="px-6 py-4 uppercase tracking-wider text-[11px] font-black w-1/5 text-center">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($employeesList as $employee)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-slate-100 text-[#b11d40] flex items-center justify-center font-black shadow-sm shrink-0">
                                            {{ strtoupper(substr($employee->firstName, 0, 1) . substr($employee->lastName, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800">{{ $employee->firstName }} {{ $employee->lastName }}</p>
                                            <p class="text-[11px] text-slate-400 mt-0.5">{{ $employee->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold bg-blue-50 text-blue-600 border border-blue-100">
                                        {{ $employee->post ?? 'Employé' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{-- Placeholder presence if not dynamic --}}
                                    <div class="flex items-center justify-center gap-2">
                                        <span class="text-xs font-extrabold text-emerald-500">{{ $employee->presence ?? '100' }}%</span>
                                        <div class="w-16 bg-slate-100 rounded-full h-1.5">
                                            <div class="bg-emerald-400 h-1.5 rounded-full" style="width: {{ $employee->presence ?? '100' }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusStr = strtolower($employee->status ?? 'actif');
                                    @endphp
                                    @if($statusStr === 'actif' || $statusStr === 'active')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100/50">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Actif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold bg-slate-50 text-slate-500 border border-slate-200">
                                            Inactif
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center text-slate-500">
                                        <div class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        </div>
                                        <p class="font-bold text-slate-700">Aucun employé assigné</p>
                                        <p class="text-sm text-slate-400 mt-1 max-w-sm">Ce département ne possède actuellement aucun membre. Naviguez vers la liste des employés pour en assigner.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- Include the dynamically updating edit modal --}}
    @include('departements.edit_modal')
</x-app-layout>
