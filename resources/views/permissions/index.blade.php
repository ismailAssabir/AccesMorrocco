<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen">
        <div class="mb-8">
            <h1 class="text-2xl font-extrabold text-slate-800">Configuration des Rôles</h1>
            <p class="text-slate-500 text-sm">Définissez les accès standards pour chaque type de compte.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($roles as $role)
            <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden flex flex-col">
                <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
                <div class="p-6 flex-1">
                    <div class="flex justify-between items-start mb-4">
                        <span class="px-3 py-1 rounded-xl text-xs font-black bg-[#b11d40]/10 text-[#b11d40] uppercase">
                            {{ $role->name }}
                        </span>
                        <span class="text-xs font-bold text-slate-400">{{ $role->permissions->count() }} Perms</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Accès {{ ucfirst($role->name) }}</h3>
                    <p class="text-slate-500 text-sm mb-6">Modifiez les droits d'accès globaux pour tous les {{ $role->name }}s.</p>
                </div>
                @can('permission.edit')
                <div class="p-4 bg-slate-50 border-t border-slate-100">
                    <a href="{{ route('permissions.edit', $role->id) }}" 
                       class="flex items-center justify-center gap-2 w-full bg-white border border-slate-200 text-slate-700 font-bold py-2 rounded-xl hover:bg-[#b11d40] hover:text-white transition-all">
                        Configurer les permissions
                    </a>
                </div>
            </div>
            @endcan
            @endforeach
        </div>
    </div>
</x-app-layout>