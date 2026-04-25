<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('permissions.index') }}" class="w-9 h-9 rounded-xl border border-slate-200 bg-white flex items-center justify-center shadow-sm">
                <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800">Permissions du Rôle : <span class="text-[#b11d40]">{{ ucfirst($role->name) }}</span></h1>
            </div>
        </div>
        
        @can('permission.edit')
        <form action="{{ route('permissions.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($permissions as $module => $perms)
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4 pb-4 border-b border-slate-50">
                            <p class="font-black text-slate-800 uppercase tracking-widest text-xs">{{ $module }}</p>
                            <label class="text-[10px] font-bold text-[#b11d40] cursor-pointer">
                                <input type="checkbox" class="select-all mr-1" data-module="{{ $module }}"> Tout cocher
                            </label>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            @foreach($perms as $perm)
                            <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-100 bg-slate-50/30 cursor-pointer hover:border-[#b11d40]/30 transition-all">
                                <input type="checkbox" name="permissions[]" value="{{ $perm->name }}" 
                                       class="perm-{{ $module }} accent-[#b11d40]"
                                       {{ $role->hasPermissionTo($perm->name) ? 'checked' : '' }}>
                                <span class="text-xs font-bold text-slate-700">{{ explode('.', $perm->name)[1] }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="sticky bottom-8 mt-10 flex justify-end">
                <button type="submit" class="bg-[#b11d40] text-white px-10 py-4 rounded-2xl font-black shadow-xl shadow-[#b11d40]/20 hover:scale-105 transition-transform">
                    Enregistrer les modifications pour {{ $role->name }}
                </button>
            </div>
        </form>
    </div>
@endcan
    <script>
        document.querySelectorAll('.select-all').forEach(check => {
            check.addEventListener('change', function() {
                document.querySelectorAll('.perm-' + this.dataset.module).forEach(p => p.checked = this.checked);
            });
        });
    </script>
</x-app-layout>