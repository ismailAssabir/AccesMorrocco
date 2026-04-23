<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen font-sans text-slate-900">

        {{-- TOP BAR --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Gestion des Permissions</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Gérez les rôles et permissions de chaque employé.</p>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>

            @if($employes->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/60">
                            <th class="text-left px-6 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Employé</th>
                            <th class="text-left px-6 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Rôle</th>
                            <th class="text-left px-6 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Permissions directes</th>
                            <th class="text-right px-6 py-4 text-[10px] font-black uppercase text-slate-400 tracking-widest">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($employes as $employe)
                        @php
                            $role = $employe->roles->first();
                            $roleColor = match($role?->name) {
                                'admin'   => 'bg-[#b11d40]/10 text-[#b11d40]',
                                'manager' => 'bg-blue-50 text-blue-600',
                                'employe' => 'bg-emerald-50 text-emerald-600',
                                default   => 'bg-slate-100 text-slate-500',
                            };
                            $initials = strtoupper(mb_substr($employe->firstName, 0, 1) . mb_substr($employe->lastName, 0, 1));
                            $avatarColors = ['bg-[#b11d40]','bg-blue-500','bg-emerald-500','bg-amber-500','bg-violet-500'];
                            $avatarColor = $avatarColors[$loop->index % count($avatarColors)];
                        @endphp
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            {{-- Employé --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl {{ $avatarColor }} flex items-center justify-center text-xs font-black text-white shrink-0">
                                        {{ $initials }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800">{{ $employe->firstName }} {{ $employe->lastName }}</p>
                                        <p class="text-[11px] text-slate-400">{{ $employe->post ?? $employe->email }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Rôle --}}
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-black {{ $roleColor }}">
                                    {{ ucfirst($role?->name ?? 'Aucun rôle') }}
                                </span>
                            </td>

                            {{-- Permissions directes --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1.5 max-w-xs">
                                    @forelse($employe->permissions->take(3) as $perm)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-bold bg-slate-100 text-slate-600">
                                            {{ $perm->name }}
                                        </span>
                                    @empty
                                        <span class="text-[11px] text-slate-400 italic">Aucune permission directe</span>
                                    @endforelse
                                    @if($employe->permissions->count() > 3)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-bold bg-slate-200 text-slate-500">
                                            +{{ $employe->permissions->count() - 3 }}
                                        </span>
                                    @endif
                                </div>
                            </td>

                            {{-- Action --}}
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('permissions.edit', $employe->idUser) }}"
                                   class="inline-flex items-center gap-1.5 text-xs font-bold text-[#b11d40] border border-[#b11d40]/30 hover:bg-[#b11d40] hover:text-white px-4 py-2 rounded-xl transition-all duration-200 active:scale-95">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Modifier
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @else
            {{-- Empty State --}}
            <div class="flex flex-col items-center justify-center py-20 px-8 text-center">
                <div class="w-20 h-20 rounded-3xl bg-[#b11d40]/10 flex items-center justify-center mb-5">
                    <svg class="w-10 h-10 text-[#b11d40]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-extrabold text-slate-800">Aucun employé</h3>
                <p class="text-slate-500 mt-2 max-w-sm text-sm">Aucun employé trouvé dans le système.</p>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>