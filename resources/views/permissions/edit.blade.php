<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen font-sans text-slate-900">

        {{-- TOP BAR --}}
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('permissions.index') }}"
               class="w-9 h-9 rounded-xl border border-slate-200 bg-white flex items-center justify-center hover:bg-slate-50 transition-colors shadow-sm">
                <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Modifier les permissions</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">
                    {{ $employe->firstName }} {{ $employe->lastName }} —
                    <span class="text-[#b11d40] font-bold">{{ $employe->post ?? $employe->email }}</span>
                </p>
            </div>
        </div>

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
        <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl font-semibold text-sm">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('permissions.update', $employe->idUser) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- COLONNE GAUCHE — Employé + Rôle --}}
                <div class="flex flex-col gap-6">

                    {{-- Card Employé --}}
                    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                        <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                        <div class="p-6 flex flex-col items-center text-center gap-3">
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#7c1233] to-[#b11d40] flex items-center justify-center text-xl font-black text-white shadow-md">
                                {{ strtoupper(mb_substr($employe->firstName, 0, 1) . mb_substr($employe->lastName, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-extrabold text-slate-800 text-lg">{{ $employe->firstName }} {{ $employe->lastName }}</p>
                                <p class="text-sm text-slate-400 mt-0.5">{{ $employe->email }}</p>
                                @if($employe->post)
                                    <span class="inline-flex mt-2 px-3 py-1 rounded-xl text-xs font-black bg-slate-100 text-slate-600">
                                        {{ $employe->post }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Card Rôle --}}
                    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                        <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                        <div class="p-6">
                            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-4">Rôle principal</p>
                            <div class="flex flex-col gap-3">
                                @foreach($roles as $role)
                                @php
                                    $roleStyle = match($role->name) {
                                        'admin'   => 'border-[#b11d40] bg-[#b11d40]/5 text-[#b11d40]',
                                        'manager' => 'border-blue-400 bg-blue-50 text-blue-600',
                                        'employe' => 'border-emerald-400 bg-emerald-50 text-emerald-600',
                                        default   => 'border-slate-200 bg-slate-50 text-slate-600',
                                    };
                                    $checked = $employe->hasRole($role->name);
                                @endphp
                                <label class="flex items-center gap-3 p-3 rounded-2xl border-2 cursor-pointer transition-all {{ $checked ? $roleStyle : 'border-slate-200 bg-white' }} hover:border-[#b11d40]/40">
                                    <input type="radio" name="role" value="{{ $role->name }}"
                                           {{ $checked ? 'checked' : '' }}
                                           class="accent-[#b11d40] w-4 h-4 shrink-0">
                                    <div>
                                        <p class="font-black text-sm">{{ ucfirst($role->name) }}</p>
                                        <p class="text-[10px] text-slate-400">
                                            {{ $role->permissions->count() }} permissions incluses
                                        </p>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- COLONNE DROITE — Permissions par module --}}
                <div class="lg:col-span-2 flex flex-col gap-6">
                    @foreach($permissions as $module => $perms)
                    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                        <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                        <div class="p-6">

                            {{-- Module Header --}}
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-[#b11d40]/10 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-[#b11d40]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </div>
                                    <p class="font-extrabold text-slate-800">{{ ucfirst($module) }}</p>
                                </div>

                                {{-- Tout sélectionner --}}
                                <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-500 hover:text-[#b11d40] transition-colors">
                                    <input type="checkbox"
                                           class="select-all accent-[#b11d40] w-4 h-4"
                                           data-module="{{ $module }}">
                                    Tout sélectionner
                                </label>
                            </div>

                            {{-- Permissions Grid --}}
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                @foreach($perms as $perm)
                                @php
                                    $action = explode('.', $perm->name)[1];
                                    $actionStyle = match($action) {
                                        'view'    => 'bg-blue-50 text-blue-600 border-blue-200',
                                        'create'  => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                        'edit'    => 'bg-amber-50 text-amber-600 border-amber-200',
                                        'delete'  => 'bg-red-50 text-red-500 border-red-200',
                                        'approve' => 'bg-violet-50 text-violet-600 border-violet-200',
                                        'respond' => 'bg-pink-50 text-pink-600 border-pink-200',
                                        default   => 'bg-slate-50 text-slate-600 border-slate-200',
                                    };
                                    $hasPermission = $employe->hasPermissionTo($perm->name);
                                @endphp
                                <label class="flex items-center gap-2.5 p-3 rounded-2xl border cursor-pointer transition-all
                                              {{ $hasPermission ? $actionStyle : 'border-slate-200 bg-white' }}
                                              hover:border-[#b11d40]/30 hover:bg-[#b11d40]/5 group">
                                    <input type="checkbox"
                                           name="permissions[]"
                                           value="{{ $perm->name }}"
                                           class="perm-{{ $module }} accent-[#b11d40] w-4 h-4 shrink-0"
                                           {{ $hasPermission ? 'checked' : '' }}>
                                    <span class="text-xs font-black capitalize">{{ $action }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach

                    {{-- BOUTONS --}}
                    <div class="flex items-center justify-end gap-3 mt-2">
                        <a href="{{ route('permissions.index') }}"
                           class="px-6 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-600 font-bold text-sm hover:bg-slate-50 transition-all active:scale-95">
                            Annuler
                        </a>
                        <button type="submit"
                                class="flex items-center gap-2 bg-[#b11d40] hover:bg-[#911633] text-white px-6 py-2.5 rounded-xl font-bold text-sm transition-all shadow-md shadow-[#b11d40]/20 active:scale-95">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            Enregistrer
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.querySelectorAll('.select-all').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const module = this.dataset.module;
                document.querySelectorAll('.perm-' + module).forEach(function(perm) {
                    perm.checked = checkbox.checked;
                });
            });
        });
    </script>
</x-app-layout>