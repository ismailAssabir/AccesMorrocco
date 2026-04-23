<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(auth()->user()->type === 'employee')
                {{-- ═══════════ EMPLOYEE DASHBOARD ═══════════ --}}
                
                {{-- Welcome Header --}}
                <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Mon Espace Personnel</h1>
                        <p class="text-sm text-gray-500 mt-1">Bonjour {{ auth()->user()->firstName }}, voici vos tâches et événements à venir. <span class="ml-2 px-2 py-0.5 bg-blue-50 text-blue-600 rounded text-[10px] font-bold uppercase tracking-widest border border-blue-100">{{ optional(auth()->user()->departement)->title ?? 'Global' }}</span></p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ url('/reclamations') }}" class="inline-flex items-center px-4 py-2 bg-[#be2346] text-white text-sm font-semibold rounded-lg hover:bg-[#a01d3a] transition-colors shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 4v16m8-8H4" stroke-width="2"/></svg>
                            Nouvelle Réclamation
                        </a>
                    </div>
                </div>

                {{-- Personal Metrics --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Mes Tâches</p>
                        <div class="flex items-center justify-between">
                            <h3 class="text-2xl font-bold text-gray-900">{{ $stats['myTasks'] }}</h3>
                            <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke-width="2"/></svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Réunions Dept.</p>
                        <div class="flex items-center justify-between">
                            <h3 class="text-2xl font-bold text-gray-900">{{ $stats['myDepartmentMeetings'] }}</h3>
                            <div class="p-2 bg-purple-50 text-purple-600 rounded-lg">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" stroke-width="2"/></svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Réclamations</p>
                        <div class="flex items-center justify-between">
                            <h3 class="text-2xl font-bold text-gray-900">{{ $stats['myPendingReclamations'] }}</h3>
                            <div class="p-2 bg-rose-50 text-rose-600 rounded-lg">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- My Recent Tasks --}}
                    <div class="lg:col-span-2 space-y-8">
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                                <h2 class="text-lg font-bold text-gray-900">Mes Tâches Récentes</h2>
                                <a href="{{ route('tasks.index') }}" class="text-sm font-semibold text-[#be2346] hover:underline">Voir tout</a>
                            </div>
                            <div class="p-6">
                                @forelse($myRecentTasks as $task)
                                    <div class="flex items-center justify-between p-4 mb-4 bg-gray-50 rounded-lg last:mb-0 border border-transparent hover:border-gray-200 transition-all">
                                        <div class="flex items-center gap-4">
                                            <div class="w-2 h-2 rounded-full {{ $task->status === 'termine' ? 'bg-green-500' : 'bg-amber-500' }}"></div>
                                            <div>
                                                <p class="text-sm font-bold text-gray-900">{{ $task->titre }}</p>
                                                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-tight">{{ $task->priorite }} • {{ $task->dateDebut ? $task->dateDebut->format('d/m/Y') : 'Pas de date' }}</p>
                                            </div>
                                        </div>
                                        <span class="text-xs font-bold text-gray-500">{{ $task->status }}</span>
                                    </div>
                                @empty
                                    <p class="text-center text-gray-400 italic py-8">Aucune tâche assignée pour le moment.</p>
                                @endforelse
                            </div>
                        </div>

                        {{-- My Recent Reclamations --}}
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100">
                                <h2 class="text-lg font-bold text-gray-900">Mes Réclamations</h2>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left">
                                    <thead class="bg-gray-50 border-b border-gray-100">
                                        <tr>
                                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Sujet</th>
                                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @forelse($myRecentReclamations as $rec)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $rec->titre ?? 'Réclamation' }}</td>
                                                <td class="px-6 py-4">
                                                    <span class="px-2 py-1 text-[10px] font-bold rounded-full {{ $rec->status === 'resolue' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                                        {{ $rec->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="px-6 py-8 text-center text-gray-400 italic">Aucune réclamation envoyée.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Upcoming Meetings --}}
                    <div class="space-y-6">
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                            <h2 class="text-sm font-bold text-gray-900 uppercase tracking-widest mb-6">Prochaines Réunions</h2>
                            <div class="space-y-4">
                                @forelse($upcomingReunions as $reunion)
                                    <div class="flex gap-4 pb-4 border-b border-gray-50 last:border-0 last:pb-0">
                                        <div class="bg-gray-100 rounded-lg p-2 h-12 w-12 flex flex-col items-center justify-center text-[#be2346]">
                                            <span class="text-xs font-bold uppercase">{{ \Carbon\Carbon::parse($reunion->dateHeure)->translatedFormat('M') }}</span>
                                            <span class="text-sm font-black">{{ \Carbon\Carbon::parse($reunion->dateHeure)->format('d') }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">{{ $reunion->titre }}</p>
                                            <p class="text-[10px] text-gray-400 font-medium uppercase mt-0.5">{{ \Carbon\Carbon::parse($reunion->dateHeure)->format('H:i') }} • {{ $reunion->lieu ?? 'Visioconférence' }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs text-gray-400 italic">Pas de réunion prévue.</p>
                                @endforelse
                            </div>
                        </div>

                        {{-- Shortcuts --}}
                        <div class="bg-gray-900 rounded-xl p-6 text-white shadow-lg">
                            <h2 class="text-xs font-bold uppercase tracking-widest mb-6 text-gray-400">Liens Utiles</h2>
                            <div class="grid grid-cols-1 gap-2">
                                <a href="{{ route('conge.index') }}" class="flex items-center p-3 bg-white/5 hover:bg-white/10 rounded-lg transition-colors">
                                    <svg class="w-4 h-4 mr-3 text-[#be2346]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2"/></svg>
                                    <span class="text-sm font-medium">Demander un congé</span>
                                </a>
                                <a href="{{ url('/demandeDocuments') }}" class="flex items-center p-3 bg-white/5 hover:bg-white/10 rounded-lg transition-colors">
                                    <svg class="w-4 h-4 mr-3 text-[#be2346]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2"/></svg>
                                    <span class="text-sm font-medium">Documents RH</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                {{-- ═══════════ ADMIN/MANAGER DASHBOARD ═══════════ --}}
                
                {{-- Page Header --}}
                <div class="mb-8 border-b border-gray-200 pb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Tableau de bord de gestion</h1>
                        <p class="text-sm text-gray-500 mt-1">Bienvenue, {{ Auth::user()->firstName }} {{ Auth::user()->lastName }} | Session active : {{ now()->format('d/m/Y') }}</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('reunions.index') }}" class="inline-flex items-center px-4 py-2 bg-[#be2346] text-white text-sm font-semibold rounded-lg hover:bg-[#a01d3a] transition-colors shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                            Nouvelle Réunion
                        </a>
                    </div>
                </div>

                {{-- Metric Cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-center">
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-lg mr-4">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Effectif Total</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $stats['totalEmployees'] }}</h3>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-center">
                        <div class="p-3 bg-amber-50 text-amber-600 rounded-lg mr-4">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Missions Actives</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $stats['totalTasks'] }}</h3>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-center">
                        <div class="p-3 bg-purple-50 text-purple-600 rounded-lg mr-4">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Réunions Prévues</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $stats['upcomingMeetings'] }}</h3>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-center">
                        <div class="p-3 bg-[#be2346]/10 text-[#be2346] rounded-lg mr-4">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Requêtes en cours</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $stats['pendingReclamations'] }}</h3>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-8">
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                                <h2 class="text-lg font-bold text-gray-900">Réclamations Récentes</h2>
                                <a href="{{ url('/reclamations') }}" class="text-sm font-semibold text-[#be2346] hover:underline">Voir tout</a>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left">
                                    <thead class="bg-gray-50 border-b border-gray-100">
                                        <tr>
                                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Titre / Demandeur</th>
                                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Date</th>
                                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @forelse($recentReclamations as $reclamation)
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="px-6 py-4">
                                                    <div class="font-bold text-gray-900">{{ $reclamation->titre ?? 'Requête' }}</div>
                                                    <div class="text-xs text-gray-400">{{ $reclamation->user->firstName }} {{ $reclamation->user->lastName }}</div>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-600">
                                                    {{ \Carbon\Carbon::parse($reclamation->created_at)->format('d/m/Y') }}
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <span class="px-3 py-1 text-[10px] font-bold uppercase rounded-full 
                                                        {{ $reclamation->status === 'resolue' ? 'bg-green-100 text-green-700' : ($reclamation->status === 'en_cours' ? 'bg-amber-100 text-amber-700' : 'bg-red-50 text-red-700') }}">
                                                        {{ str_replace('_', ' ', $reclamation->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="px-6 py-12 text-center text-gray-400 italic">Aucune donnée disponible.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100">
                                <h2 class="text-lg font-bold text-gray-900">Agenda des Réunions</h2>
                            </div>
                            <div class="p-6 space-y-6">
                                @forelse($upcomingReunions as $reunion)
                                    <div class="flex gap-6 pb-6 border-b border-gray-50 last:border-0 last:pb-0">
                                        <div class="flex-shrink-0 w-16 text-center">
                                            <div class="text-xs font-bold text-gray-400 uppercase">{{ \Carbon\Carbon::parse($reunion->dateHeure)->translatedFormat('M') }}</div>
                                            <div class="text-2xl font-black text-gray-900">{{ \Carbon\Carbon::parse($reunion->dateHeure)->format('d') }}</div>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-bold text-gray-900">{{ $reunion->titre }}</h4>
                                            <div class="flex items-center text-xs text-gray-500 mt-1 gap-4">
                                                <span class="flex items-center"><svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 8v4l3 3" stroke-width="2" /></svg> {{ \Carbon\Carbon::parse($reunion->dateHeure)->format('H:i') }}</span>
                                                <span class="flex items-center"><svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2" /></svg> {{ $reunion->lieu ?? 'Visioconférence' }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="{{ route('reunions.index') }}" class="p-2 text-gray-400 hover:text-[#be2346]">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-gray-400 italic py-4">Pas de réunion à l'agenda.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                            <h2 class="text-sm font-bold text-gray-900 uppercase tracking-widest mb-6">Direction & Management</h2>
                            <div class="space-y-4">
                                @forelse($managers as $manager)
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-gray-100 flex-shrink-0 overflow-hidden">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($manager->firstName . ' ' . $manager->lastName) }}&background=E5E7EB&color=4B5563&bold=true" alt="">
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">{{ $manager->firstName }} {{ $manager->lastName }}</p>
                                            <p class="text-[10px] text-gray-400 font-medium uppercase tracking-tighter">{{ $manager->post ?? 'Responsable' }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs text-gray-400 italic">Aucun membre répertorié.</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="bg-gray-900 rounded-xl p-6 text-white shadow-lg">
                            <h2 class="text-sm font-bold uppercase tracking-widest mb-6 text-gray-400">Accès Rapide</h2>
                            <div class="grid grid-cols-1 gap-3">
                                <a href="{{ route('users.index') }}" class="flex items-center p-3 bg-white/5 hover:bg-white/10 rounded-lg transition-colors border border-white/5">
                                    <div class="w-8 h-8 rounded bg-blue-500/20 flex items-center justify-center text-blue-400 mr-3">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                                    </div>
                                    <span class="text-sm font-medium">Inscrire Employé</span>
                                </a>
                                <a href="{{ route('goals.index') }}" class="flex items-center p-3 bg-white/5 hover:bg-white/10 rounded-lg transition-colors border border-white/5">
                                    <div class="w-8 h-8 rounded bg-amber-500/20 flex items-center justify-center text-amber-400 mr-3">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                    </div>
                                    <span class="text-sm font-medium">Définir Objectifs</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
