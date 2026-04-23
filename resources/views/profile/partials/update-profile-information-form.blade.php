<section>
    <div class="mb-8">
        <h4 class="text-lg font-extrabold text-slate-900 elite-heading">Informations Personnelles</h4>
        <p class="text-[13px] text-slate-400 mt-1 leading-relaxed">Mettez à jour vos informations de profil et votre adresse e-mail.</p>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-8">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Prénom --}}
            <div class="space-y-2">
                <x-input-label for="firstName" :value="__('Prénom')" class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.08em]" />
                <x-text-input id="firstName" name="firstName" type="text"
                    class="w-full bg-slate-50/60 border border-[#f1f5f9] rounded-xl elite-input text-slate-800 font-semibold transition-all duration-200 px-4 py-3 text-sm focus:bg-white"
                    :value="old('firstName', $user->firstName)" required autofocus autocomplete="given-name" />
                <x-input-error class="mt-1" :messages="$errors->get('firstName')" />
            </div>

            {{-- Nom --}}
            <div class="space-y-2">
                <x-input-label for="lastName" :value="__('Nom')" class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.08em]" />
                <x-text-input id="lastName" name="lastName" type="text"
                    class="w-full bg-slate-50/60 border border-[#f1f5f9] rounded-xl elite-input text-slate-800 font-semibold transition-all duration-200 px-4 py-3 text-sm focus:bg-white"
                    :value="old('lastName', $user->lastName)" required autocomplete="family-name" />
                <x-input-error class="mt-1" :messages="$errors->get('lastName')" />
            </div>

            {{-- Email --}}
            <div class="space-y-2">
                <x-input-label for="email" :value="__('Adresse E-mail')" class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.08em]" />
                <x-text-input id="email" name="email" type="email"
                    class="w-full bg-slate-50/60 border border-[#f1f5f9] rounded-xl elite-input text-slate-800 font-semibold transition-all duration-200 px-4 py-3 text-sm focus:bg-white"
                    :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-1" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-3 p-3.5 bg-amber-50 rounded-xl border border-amber-100/80 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <p class="text-xs text-amber-800 font-semibold">
                            {{ __('E-mail non vérifié.') }}
                            <button form="send-verification" class="ml-1 underline text-[#b11d40] font-bold hover:text-[#961836] transition-colors">Renvoyer le lien</button>
                        </p>
                    </div>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-xs font-semibold text-emerald-600">{{ __('Un nouveau lien de vérification a été envoyé.') }}</p>
                    @endif
                @endif
            </div>

            {{-- Téléphone --}}
            <div class="space-y-2">
                <x-input-label for="phoneNumber" :value="__('Téléphone')" class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.08em]" />
                <x-text-input id="phoneNumber" name="phoneNumber" type="text"
                    class="w-full bg-slate-50/60 border border-[#f1f5f9] rounded-xl elite-input text-slate-800 font-semibold transition-all duration-200 px-4 py-3 text-sm focus:bg-white"
                    :value="old('phoneNumber', $user->phoneNumber)" autocomplete="tel" placeholder="+212 6XX-XXXXXX" />
                <x-input-error class="mt-1" :messages="$errors->get('phoneNumber')" />
            </div>

            {{-- CIN --}}
            <div class="space-y-2">
                <x-input-label for="cin" :value="__('CIN')" class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.08em]" />
                <x-text-input id="cin" name="cin" type="text"
                    class="w-full bg-slate-50/60 border border-[#f1f5f9] rounded-xl elite-input text-slate-800 font-semibold transition-all duration-200 px-4 py-3 text-sm focus:bg-white"
                    :value="old('cin', $user->cin)" placeholder="AB123456" />
                <x-input-error class="mt-1" :messages="$errors->get('cin')" />
            </div>

            {{-- Date de naissance --}}
            <div class="space-y-2">
                <x-input-label for="birthday" :value="__('Date de naissance')" class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.08em]" />
                <x-text-input id="birthday" name="birthday" type="date"
                    class="w-full bg-slate-50/60 border border-[#f1f5f9] rounded-xl elite-input text-slate-800 font-semibold transition-all duration-200 px-4 py-3 text-sm focus:bg-white"
                    :value="old('birthday', $user->birthday)" />
                <x-input-error class="mt-1" :messages="$errors->get('birthday')" />
            </div>

            {{-- Adresse (full width) --}}
            <div class="md:col-span-2 space-y-2">
                <x-input-label for="address" :value="__('Adresse')" class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.08em]" />
                <x-text-input id="address" name="address" type="text"
                    class="w-full bg-slate-50/60 border border-[#f1f5f9] rounded-xl elite-input text-slate-800 font-semibold transition-all duration-200 px-4 py-3 text-sm focus:bg-white"
                    :value="old('address', $user->address)" autocomplete="street-address"
                    placeholder="Votre adresse complète" />
                <x-input-error class="mt-1" :messages="$errors->get('address')" />
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-4 pt-2">
            <button type="submit"
                class="inline-flex items-center gap-2 bg-[#b11d40] hover:bg-[#961836] text-white rounded-xl px-7 py-3 text-sm font-bold shadow-lg shadow-[#b11d40]/15 hover:shadow-xl hover:shadow-[#b11d40]/25 transition-all duration-200 active:scale-[0.97]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                {{ __('Enregistrer') }}
            </button>

            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                    class="inline-flex items-center gap-2 text-emerald-700 bg-emerald-50 px-4 py-2.5 rounded-xl border border-emerald-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span class="text-xs font-bold">Modifications enregistrées</span>
                </div>
            @endif
        </div>
    </form>
</section>
