<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Introuvable | Access Morocco</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .gradient-text {
            background: linear-gradient(135deg, #b11d40, #7c1233);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .blob {
            position: absolute;
            filter: blur(80px);
            z-index: -1;
            opacity: 0.4;
        }
        @keyframes float {
            0% { transform: translateY(0px) rotate(3deg); }
            50% { transform: translateY(-10px) rotate(-3deg); }
            100% { transform: translateY(0px) rotate(3deg); }
        }
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-[#F8FAFC] min-h-screen flex items-center justify-center relative overflow-hidden font-sans">

    <!-- Decorative blobs -->
    <div class="blob bg-[#b11d40] w-96 h-96 rounded-full top-[-10%] left-[-10%]"></div>
    <div class="blob bg-slate-300 w-96 h-96 rounded-full bottom-[-10%] right-[-10%]"></div>

    <div class="max-w-2xl w-full px-6 text-center z-10">
        <!-- Icon -->
        <div class="mb-8 flex justify-center">
            <div class="w-24 h-24 bg-white rounded-3xl shadow-xl shadow-[#b11d40]/10 flex items-center justify-center animate-float">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-[#b11d40]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- 404 Text -->
        <h1 class="text-9xl font-black gradient-text tracking-tighter mb-4 drop-shadow-sm">404</h1>
        
        <h2 class="text-3xl md:text-4xl font-extrabold text-slate-800 mb-4">Oups ! Page introuvable</h2>
        
        <p class="text-slate-500 text-lg mb-10 max-w-lg mx-auto leading-relaxed">
            Il semble que vous vous soyez égaré. La page que vous recherchez n'existe pas, a été supprimée ou est temporairement indisponible.
        </p>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <button onclick="window.history.back()" class="w-full sm:w-auto px-8 py-3.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-2xl hover:bg-slate-50 hover:text-[#b11d40] transition-all shadow-sm">
                ← Revenir en arrière
            </button>
            <a href="{{ url('/') }}" class="w-full sm:w-auto px-8 py-3.5 bg-gradient-to-r from-[#b11d40] to-[#7c1233] text-white font-bold rounded-2xl hover:shadow-lg hover:shadow-[#b11d40]/30 hover:-translate-y-0.5 transition-all">
                Retour à l'accueil
            </a>
        </div>
    </div>
</body>
</html>
