<section>
    <div class="mb-8">
        <h4 class="text-lg font-extrabold text-slate-900 elite-heading">Mot de passe</h4>
        <p class="text-[13px] text-slate-400 mt-1 leading-relaxed">Assurez-vous d'utiliser un mot de passe long et aléatoire pour sécuriser votre compte.</p>
    </div>

    <form method="post" action="{{ route('password.update') }}" class="space-y-8">
        @csrf
        @method('put')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Mot de passe actuel (full width) --}}
            <div class="md:col-span-2 space-y-2">
                <x-input-label for="update_password_current_password" :value="__('Mot de passe actuel')" class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.08em]" />
                <x-text-input id="update_password_current_password" name="current_password" type="password"
                    class="w-full md:w-1/2 bg-slate-50/60 border border-[#f1f5f9] rounded-xl elite-input text-slate-800 font-semibold transition-all duration-200 px-4 py-3 text-sm focus:bg-white"
                    autocomplete="current-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" />
            </div>

            {{-- Nouveau mot de passe --}}
            <div class="space-y-2">
                <x-input-label for="update_password_password" :value="__('Nouveau mot de passe')" class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.08em]" />
                <x-text-input id="update_password_password" name="password" type="password"
                    class="w-full bg-slate-50/60 border border-[#f1f5f9] rounded-xl elite-input text-slate-800 font-semibold transition-all duration-200 px-4 py-3 text-sm focus:bg-white"
                    autocomplete="new-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1" />
            </div>

            {{-- Confirmer --}}
            <div class="space-y-2">
                <x-input-label for="update_password_password_confirmation" :value="__('Confirmer le mot de passe')" class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.08em]" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                    class="w-full bg-slate-50/60 border border-[#f1f5f9] rounded-xl elite-input text-slate-800 font-semibold transition-all duration-200 px-4 py-3 text-sm focus:bg-white"
                    autocomplete="new-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1" />
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-4 pt-2">
            <button type="submit"
                class="inline-flex items-center gap-2 bg-[#b11d40] hover:bg-[#961836] text-white rounded-xl px-7 py-3 text-sm font-bold shadow-lg shadow-[#b11d40]/15 hover:shadow-xl hover:shadow-[#b11d40]/25 transition-all duration-200 active:scale-[0.97]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                {{ __('Mettre à jour') }}
            </button>

            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                    class="inline-flex items-center gap-2 text-emerald-700 bg-emerald-50 px-4 py-2.5 rounded-xl border border-emerald-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span class="text-xs font-bold">Mot de passe mis à jour</span>
                </div>
            @endif
        </div>
    </form>
</section>
