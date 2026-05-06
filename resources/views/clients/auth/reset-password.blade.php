<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau mot de passe — Access Morocco</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F8FAFC] min-h-screen flex items-center justify-center font-sans p-4">
    <div class="w-full max-w-md">

        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#b11d40] to-[#7c1233]"></div>
            <div class="p-8">

                <div class="text-center mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#b11d40] to-[#7c1233] flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-extrabold text-slate-800">Nouveau mot de passe</h1>
                    <p class="text-slate-500 text-sm mt-1">Choisissez un mot de passe sécurisé</p>
                </div>

                @if($errors->any())
                <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-2xl text-sm font-semibold">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $errors->first() }}
                </div>
                @endif

                <form method="POST" action="{{ route('client.password.reset') }}" class="space-y-5">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">
                            Nouveau mot de passe
                        </label>
                        <input type="password" name="password" required
                               class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-slate-800 font-medium text-sm focus:outline-none focus:ring-2 focus:ring-[#b11d40]/30 focus:border-[#b11d40] transition-all"
                               placeholder="Min. 8 caractères">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">
                            Confirmer le mot de passe
                        </label>
                        <input type="password" name="password_confirmation" required
                               class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 text-slate-800 font-medium text-sm focus:outline-none focus:ring-2 focus:ring-[#b11d40]/30 focus:border-[#b11d40] transition-all"
                               placeholder="Répéter le mot de passe">
                    </div>

                    <button type="submit"
                            class="w-full bg-[#b11d40] hover:bg-[#911633] text-white font-black py-3 rounded-2xl transition-all shadow-md shadow-[#b11d40]/20 active:scale-95 text-sm">
                        Réinitialiser le mot de passe →
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>