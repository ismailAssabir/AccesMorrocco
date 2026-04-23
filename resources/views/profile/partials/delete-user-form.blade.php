<section>
    <div class="mb-8">
        <h4 class="text-lg font-extrabold text-slate-900 elite-heading">Supprimer le compte</h4>
        <p class="text-[13px] text-slate-400 mt-1 leading-relaxed">Une fois votre compte supprimé, toutes ses données seront définitivement effacées.</p>
    </div>

    {{-- Warning Banner --}}
    <div class="p-5 bg-red-50/60 rounded-2xl border border-red-100/60 mb-8">
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center flex-shrink-0 shadow-sm border border-red-100/50">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div class="flex-1 space-y-2">
                <p class="text-sm font-bold text-red-900">Action irréversible</p>
                <p class="text-[13px] text-red-700/80 leading-relaxed">
                    {{ __('La suppression de votre compte entraînera la perte définitive de toutes vos données, tâches, documents et historique. Cette action ne peut pas être annulée.') }}
                </p>
            </div>
        </div>
    </div>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center gap-2 bg-[#b11d40] hover:bg-[#961836] text-white rounded-xl px-7 py-3 text-sm font-bold shadow-lg shadow-[#b11d40]/15 hover:shadow-xl hover:shadow-[#b11d40]/25 transition-all duration-200 active:scale-[0.97] border-none"
    >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        {{ __('Supprimer mon compte') }}
    </x-danger-button>

    {{-- Confirmation Modal --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 sm:p-10">
            @csrf
            @method('delete')

            <div class="flex items-center gap-4 mb-6">
                <div class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <h2 class="text-xl font-extrabold text-slate-900 elite-heading">
                        {{ __('Confirmer la suppression') }}
                    </h2>
                    <p class="text-sm text-slate-400 mt-0.5">Cette action est définitive et irréversible.</p>
                </div>
            </div>

            <p class="text-sm text-slate-500 leading-relaxed mb-6">
                {{ __('Pour confirmer, veuillez saisir votre mot de passe actuel ci-dessous.') }}
            </p>

            <div class="space-y-2 mb-8">
                <x-input-label for="password" :value="__('Mot de passe')" class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.08em]" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="w-full bg-slate-50/60 border border-[#f1f5f9] rounded-xl elite-input text-slate-800 font-semibold transition-all duration-200 px-4 py-3 text-sm focus:bg-white"
                    placeholder="Votre mot de passe"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1" />
            </div>

            <div class="flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')"
                    class="rounded-xl px-6 py-2.5 border-[#f1f5f9] text-slate-500 font-bold text-sm hover:bg-slate-50 transition-colors">
                    {{ __('Annuler') }}
                </x-secondary-button>

                <x-danger-button
                    class="bg-[#b11d40] hover:bg-[#961836] rounded-xl px-6 py-2.5 font-bold text-sm border-none shadow-lg shadow-[#b11d40]/15 transition-all duration-200">
                    {{ __('Supprimer définitivement') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
