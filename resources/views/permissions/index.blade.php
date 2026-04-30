<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen">

        {{-- ═══════════ PAGE HEADER ═══════════ --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Configuration des Rôles</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Définissez les accès standards pour chaque type de compte.</p>
            </div>
            <div class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-2xl shadow-sm">
                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="text-xs font-black text-slate-500 uppercase tracking-widest">{{ count($roles) }} Rôles Actifs</span>
            </div>
        </div>

        {{-- ═══════════ ROLE CARDS ═══════════ --}}
        @php
            $roleConfig = [
                'admin'    => ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'bg' => 'from-rose-600 to-[#be2346]', 'badge' => 'bg-rose-50 text-rose-700 border-rose-200'],
                'manager'  => ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'bg' => 'from-blue-600 to-blue-500', 'badge' => 'bg-blue-50 text-blue-700 border-blue-200'],
                'employee' => ['icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'bg' => 'from-emerald-600 to-emerald-500', 'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
            ];
            $defaultConfig = ['icon' => 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4', 'bg' => 'from-slate-600 to-slate-500', 'badge' => 'bg-slate-100 text-slate-600 border-slate-200'];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($roles as $role)
            @php $cfg = $roleConfig[strtolower($role->name)] ?? $defaultConfig; @endphp
            <div class="group bg-white border border-slate-200 rounded-[2.5rem] shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col">
                
                {{-- Card Top Gradient Bar --}}
                <div class="h-1.5 w-full bg-gradient-to-r {{ $cfg['bg'] }}"></div>

                <div class="p-8 flex-1 flex flex-col">
                    {{-- Role Icon + Badge --}}
                    <div class="flex items-start justify-between mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br {{ $cfg['bg'] }} flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $cfg['icon'] }}"/>
                            </svg>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-xl border {{ $cfg['badge'] }}">
                            {{ ucfirst($role->name) }}
                        </span>
                    </div>

                    {{-- Role Info --}}
                    <h3 class="text-xl font-black text-slate-800 mb-1 tracking-tight">Accès {{ ucfirst($role->name) }}</h3>
                    <p class="text-sm text-slate-400 font-medium mb-6 leading-relaxed">
                        Gérez et configurez les droits d'accès pour tous les utilisateurs de type <span class="font-bold text-slate-600">{{ $role->name }}</span>.
                    </p>

                    {{-- Permission Stats --}}
                    <div class="flex items-center gap-3 mb-6 mt-auto">
                        <div class="flex-1 bg-slate-50 border border-slate-100 rounded-2xl p-3 text-center">
                            <p class="text-2xl font-black text-[#be2346] leading-none">{{ $role->permissions->count() }}</p>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Permissions</p>
                        </div>
                        <div class="flex-1 bg-slate-50 border border-slate-100 rounded-2xl p-3 text-center">
                            <p class="text-2xl font-black text-slate-700 leading-none">{{ $role->users()->count() }}</p>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Utilisateurs</p>
                        </div>
                    </div>

                    {{-- CTA Button --}}
                    @can('permission.edit')
                    <a href="{{ route('permissions.edit', $role->id) }}"
                       class="flex items-center justify-center gap-2.5 w-full py-3.5 rounded-2xl font-black text-sm transition-all duration-300 bg-slate-50 border border-slate-200 text-slate-600 hover:bg-[#be2346] hover:text-white hover:border-transparent hover:shadow-lg hover:shadow-[#be2346]/20 active:scale-95">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Configurer les permissions
                    </a>
                    @endcan
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>