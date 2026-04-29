<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Espace Client - Access Morocco')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F8FAFC]">
    <div class="min-h-screen">
        <!-- Header Client -->
        <nav class="bg-white border-b border-slate-200 shadow-sm">
            <div class="px-8 py-4 flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-bold text-[#b11d40]">Access Morocco</h1>
                    <p class="text-xs text-slate-500">Espace Client</p>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-slate-600">
                        {{ Auth::guard('client')->user()->firstName ?? '' }} {{ Auth::guard('client')->user()->lastName ?? '' }}
                    </span>
                    <form method="POST" action="{{ route('clients.logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-500 hover:text-red-700">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Contenu principal -->
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>