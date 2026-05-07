@php
    $user = auth()->user();
    $client = auth()->guard('client')->user();
    $userType = $user ? $user->type : ($client ? 'client' : null);
    $searchItems = \Illuminate\Support\Facades\Cache::remember('global_search_items_' . $userType, 600, function() use ($userType) {
        $items = [
            ['title' => 'Accueil', 'url' => '/dashboard', 'type' => 'Page', 'keywords' => 'home dashboard tableau de bord accueil', 'icon' => '<path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />'],
        ];

        // Static Pages with Permission Checks
        if (Gate::allows('user.view')) {
            $items[] = ['title' => 'Ressources Humaines', 'url' => '/users', 'type' => 'Page', 'keywords' => 'rh utilisateurs personnel collaborateurs employés', 'icon' => '<path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />'];
        }
        if (Gate::allows('reclamation.view')) {
            $items[] = ['title' => 'Réclamations', 'url' => '/reclamations', 'type' => 'Page', 'keywords' => 'support plaintes tickets problemes', 'icon' => '<path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />'];
        }
        if (Gate::allows('departement.view')) {
            $items[] = ['title' => 'Département', 'url' => '/departements', 'type' => 'Page', 'keywords' => 'services bureaux organisation départements', 'icon' => '<path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m-1 4h1m5-10h1m-1 4h1m-1 4h1" />'];
        }
        if (Gate::allows('pointage.view')) {
            $items[] = ['title' => 'Pointage', 'url' => '/pointage', 'type' => 'Page', 'keywords' => 'heures temps retard presence pointages présence', 'icon' => '<path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />'];
        }
        if (Gate::allows('tache.view')) {
            $items[] = ['title' => 'Gestion des tâches', 'url' => '/tasks', 'type' => 'Page', 'keywords' => 'missions work travail todo tâches projets', 'icon' => '<path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />'];
        }
        if (Gate::allows('reunion.view')) {
            $items[] = ['title' => 'Réunions', 'url' => '/meetings', 'type' => 'Page', 'keywords' => 'réunions appels visio calendrier', 'icon' => '<path d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />'];
        }
        if (Gate::allows('objectif.view')) {
            $items[] = ['title' => 'Objectifs', 'url' => '/objectifs', 'type' => 'Page', 'keywords' => 'kpi performance cibles progression', 'icon' => '<path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />'];
        }
        if (Gate::allows('conge.view')) {
            $items[] = ['title' => 'Congés', 'url' => '/conge', 'type' => 'Page', 'keywords' => 'absences vacances repos congés', 'icon' => '<path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />'];
        }

        if ($userType === 'admin') {
            $items[] = ['title' => 'Clients', 'url' => '/clients', 'type' => 'Page', 'keywords' => 'crm clients acheteurs', 'icon' => '<path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />'];
            $items[] = ['title' => 'Catégories', 'url' => '/category', 'type' => 'Page', 'keywords' => 'tags types classification', 'icon' => '<path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />'];
            $items[] = ['title' => 'Permissions', 'url' => '/permissions', 'type' => 'Page', 'keywords' => 'roles droits acces securite', 'icon' => '<path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />'];
        }

        $items[] = ['title' => 'Mon Profil', 'url' => '/profile', 'type' => 'Page', 'keywords' => 'settings compte securite mon profil', 'icon' => '<path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />'];

        // Dynamic Items with Role Filtering
        try {
            if (Gate::allows('user.view')) {
                $users = \App\Models\User::select('idUser', 'firstName', 'lastName')->limit(50)->get();
                foreach($users as $user) {
                    $items[] = [
                        'title' => ($user->firstName ?? '') . ' ' . ($user->lastName ?? ''),
                        'url' => '/users/' . $user->idUser,
                        'type' => 'Employé',
                        'icon' => '<path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />'
                    ];
                }
            }

            if (Gate::allows('reclamation.view')) {
                $reclamations = \App\Models\Reclamation::select('idReclamation', 'titre');
                if ($userType === 'employee') {
                    $reclamations->where('idUser', auth()->id());
                }
                $reclamations = $reclamations->latest()->limit(50)->get();
                foreach($reclamations as $rec) {
                    $items[] = [
                        'title' => $rec->titre,
                        'url' => '/reclamation/' . $rec->idReclamation,
                        'type' => 'Réclamation',
                        'icon' => '<path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />'
                    ];
                }
            }

            if (Gate::allows('tache.view')) {
                $tasks = \App\Models\Tache::select('idTache', 'titre')->latest()->limit(50)->get();
                foreach($tasks as $task) {
                    $items[] = [
                        'title' => $task->titre,
                        'url' => '/tasks',
                        'type' => 'Tâche',
                        'icon' => '<path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />'
                    ];
                }
            }

            if (Gate::allows('reunion.view')) {
                $reunions = \App\Models\Reunion::select('idReunion', 'titre')->latest()->limit(50)->get();
                foreach($reunions as $reunion) {
                    $items[] = [
                        'title' => $reunion->titre,
                        'url' => '/meetings',
                        'type' => 'Réunion',
                        'icon' => '<path d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />'
                    ];
                }
            }
        } catch (\Exception $e) {}
        return $items;
    });

    $recentNotifications = \Illuminate\Support\Facades\Cache::remember('recent_notifications_' . ($userType ?? 'guest') . '_' . auth()->id(), 60, function() use ($userType, $user) {
        $notifications = collect();
        if (!$user) return $notifications;

        try {
            // 1. Tâches
            $tacheQuery = \App\Models\Tache::latest()->limit(15);
            if ($userType === 'employee') {
                $tacheQuery->whereHas('users', function($q) use ($user) { $q->where('user_taches.idUser', $user->idUser); });
            } elseif ($userType === 'manager') {
                $tacheQuery->where('idDepartement', $user->idDepartement);
            }
            $tasks = $tacheQuery->get()->map(fn($item) => [
                'title' => 'Nouvelle Tâche',
                'desc' => $item->titre,
                'time' => $item->created_at,
                'url' => '/tasks'
            ]);
            $notifications = $notifications->concat($tasks);

            // 2. Réunions
            $reunionQuery = \App\Models\Reunion::latest()->limit(15);
            if ($userType === 'employee') {
                $reunionQuery->where(function($q) use ($user) {
                    $q->whereNull('idDepartement')
                      ->orWhere('idDepartement', $user->idDepartement)
                      ->orWhereHas('participants', function($sq) use ($user) {
                          $sq->where('reunion_participants.idUser', $user->idUser);
                      });
                });
            } elseif ($userType === 'manager') {
                $reunionQuery->where('idDepartement', $user->idDepartement);
            }
            $reunions = $reunionQuery->get()->map(fn($item) => [
                'title' => 'Nouvelle Réunion',
                'desc' => $item->titre,
                'time' => $item->created_at,
                'url' => '/meetings'
            ]);
            $notifications = $notifications->concat($reunions);

            // 3. Reclamations
            $recQuery = \App\Models\Reclamation::latest()->limit(15);
            if ($userType === 'employee') {
                $recQuery->where('idUser', $user->idUser);
            } elseif ($userType === 'manager') {
                $recQuery->whereHas('user', function($q) use ($user) { $q->where('idDepartement', $user->idDepartement); });
            }
            $recs = $recQuery->get()->map(fn($item) => [
                'title' => 'Réclamation',
                'desc' => $item->titre,
                'time' => $item->updated_at,
                'url' => '/reclamations'
            ]);
            $notifications = $notifications->concat($recs);

            // 4. Dossiers (Pour Admin & Manager)
            if ($userType === 'admin' || $userType === 'manager') {
                $dossierQuery = \App\Models\Dossier::latest()->limit(15);
                if ($userType === 'manager') {
                    $dossierQuery->where('idDepartement', $user->idDepartement);
                }
                $dossiers = $dossierQuery->get()->map(fn($item) => [
                    'title' => 'Nouveau Dossier',
                    'desc' => $item->reference . ' - ' . ($item->distination ?? 'Pas de destination'),
                    'time' => $item->created_at,
                    'url' => '/dossiers'
                ]);
                $notifications = $notifications->concat($dossiers);
            }

            // 5. Leads (Pour Admin seulement)
            if ($userType === 'admin') {
                $leads = \App\Models\Lead::latest()->limit(15)->get()->map(fn($item) => [
                    'title' => 'Nouveau Lead',
                    'desc' => $item->firstName . ' ' . $item->lastName,
                    'time' => $item->created_at,
                    'url' => '/leads'
                ]);
                $notifications = $notifications->concat($leads);
            }

            // 6. Congés
            $congeQuery = \App\Models\Conge::latest()->limit(15);
            if ($userType === 'employee') {
                $congeQuery->where('idUser', $user->idUser);
            } elseif ($userType === 'manager') {
                $congeQuery->whereHas('user', function($q) use ($user) { $q->where('idDepartement', $user->idDepartement); });
            }
            $conges = $congeQuery->get()->map(fn($item) => [
                'title' => 'Demande de Congé',
                'desc' => $item->user->firstName . ' ' . $item->user->lastName . ' (' . $item->status . ')',
                'time' => $item->updated_at,
                'url' => '/conge'
            ]);
            $notifications = $notifications->concat($conges);
            
            return $notifications->sortByDesc('time')->take(30)->values();
        } catch (\Exception $e) {
            return collect();
        }
    });
    
    $newestNotificationTime = $recentNotifications->max('time');
    $newestTimestamp = $newestNotificationTime ? $newestNotificationTime->timestamp * 1000 : 0;
@endphp


<nav class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-gray-100 px-8 py-3">
    <div class="flex items-center justify-end">
        
        <div class="flex items-center gap-6">
            
            <div x-data="{ 
                search: '', 
                items: {{ json_encode($searchItems) }},
                get filteredItems() {
                    if (this.search.length < 2) return [];
                    const query = this.search.toLowerCase();
                    return this.items.filter(i => 
                        (i.title?.toLowerCase() || '').includes(query) || 
                        (i.type?.toLowerCase() || '').includes(query) ||
                        (i.keywords?.toLowerCase() || '').includes(query)
                    ).slice(0, 10);
                }
            }" class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400 group-focus-within:text-[#be2346] transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" 
                    x-model="search"
                    placeholder="Rechercher (nom, page...)" 
                    class="block w-64 group-focus-within:w-80 pl-11 pr-4 py-2 border-none bg-gray-100/60 rounded-xl text-sm placeholder-gray-400 focus:ring-2 focus:ring-[#be2346]/10 focus:bg-white transition-all duration-300">

                <!-- Results Dropdown -->
                <div x-show="search.length >= 2" 
                    x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    @click.away="search = ''"
                    class="absolute top-full right-0 mt-3 w-[350px] bg-white rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] border border-gray-100 overflow-hidden z-50">
                    
                    <div class="px-4 py-3 bg-gray-50/50 border-b border-gray-50 flex justify-between items-center">
                        <span class="text-[10px] font-black uppercase tracking-widest text-[#be2346]">Résultats de recherche</span>
                        <span class="text-[10px] font-bold text-gray-400" x-text="filteredItems.length + ' trouvé(s)'"></span>
                    </div>

                    <div class="max-h-[400px] overflow-y-auto">
                        <template x-for="item in filteredItems" :key="item.url + item.title">
                            <a :href="item.url" class="flex items-center gap-4 px-5 py-4 hover:bg-[#be2346]/5 transition-all group">
                                <div class="w-10 h-10 rounded-xl bg-gray-50 group-hover:bg-white flex items-center justify-center text-gray-400 group-hover:text-[#be2346] transition-all shadow-sm">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-html="item.icon"></svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-gray-800 group-hover:text-[#be2346] transition-colors" x-text="item.title"></p>
                                    <p class="text-[10px] font-black uppercase tracking-wider text-gray-400 mt-0.5" x-text="item.type"></p>
                                </div>
                                <svg class="w-4 h-4 text-gray-300 opacity-0 group-hover:opacity-100 transition-all -translate-x-2 group-hover:translate-x-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </template>

                        <div x-show="filteredItems.length === 0" class="px-5 py-8 text-center">
                            <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <p class="text-sm font-bold text-gray-400">Aucun résultat pour "<span x-text="search" class="text-gray-600"></span>"</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="h-6 w-[1px] bg-gray-200"></div>

            <div x-data="{ 
                open: false,
                readNotifs: JSON.parse(localStorage.getItem('read_notifications_{{ auth()->id() }}') || '[]'),
                notifications: {{ json_encode($recentNotifications->map(function($n) {
                    $n['timestamp'] = \Carbon\Carbon::parse($n['time'])->timestamp * 1000;
                    $n['time_human'] = \Carbon\Carbon::parse($n['time'])->diffForHumans();
                    $n['id'] = md5(($n['url'] ?? '') . $n['title'] . $n['timestamp']);
                    return $n;
                })) }},
                get unreadNotifications() {
                    return this.notifications.filter(n => !this.readNotifs.includes(n.id));
                },
                markAsRead(id) {
                    if (!this.readNotifs.includes(id)) {
                        this.readNotifs.push(id);
                        if (this.readNotifs.length > 100) this.readNotifs.shift(); 
                        localStorage.setItem('read_notifications_{{ auth()->id() }}', JSON.stringify(this.readNotifs));
                    }
                },
                markAllAsRead() {
                    this.notifications.forEach(n => {
                        if (!this.readNotifs.includes(n.id)) {
                            this.readNotifs.push(n.id);
                        }
                    });
                    localStorage.setItem('read_notifications_{{ auth()->id() }}', JSON.stringify(this.readNotifs));
                },
                toggle() {
                    this.open = !this.open;
                },
                close() {
                    this.open = false;
                }
            }" @click.away="close()" class="relative">
                <button @click="toggle()" 
                    class="relative p-2 rounded-xl hover:bg-[#be2346]/5 transition-all duration-300 group">
                    
                    <template x-if="unreadNotifications.length > 0">
                        <span class="absolute -top-1 -right-1 flex min-w-[16px] h-4 px-1 items-center justify-center bg-[#be2346] text-[9px] font-black text-white rounded-full border-2 border-white shadow-sm ring-1 ring-[#be2346]/20">
                            <span x-text="unreadNotifications.length"></span>
                        </span>
                    </template>
                    
                    <svg class="w-6 h-6 text-gray-500 group-hover:text-[#be2346] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </button>

                <div x-show="open" 
                    x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-[-10px]"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    class="absolute right-0 mt-4 w-80 bg-white rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] border border-gray-100 overflow-hidden z-[100]">
                    
                    <div class="px-6 py-5 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                        <p class="text-[11px] font-black uppercase tracking-[0.2em] text-[#be2346]">Notifications</p>
                        <button @click="markAllAsRead()" x-show="unreadNotifications.length > 0" class="text-[10px] font-bold text-gray-400 hover:text-[#be2346] transition-colors uppercase tracking-wider">Tout marquer comme lu</button>
                    </div>

                    <div class="max-h-[400px] overflow-y-auto scrollbar-thin scrollbar-thumb-gray-200">
                        <template x-for="notif in unreadNotifications" :key="notif.id">
                            <a :href="notif.url" @click="markAsRead(notif.id)" class="block px-6 py-5 border-b border-gray-50 hover:bg-gray-50 transition-all cursor-pointer group relative">
                                <div class="flex justify-between items-start mb-1.5">
                                    <p class="text-[13px] font-bold text-gray-800 group-hover:text-[#be2346] transition-colors pr-4" x-text="notif.title"></p>
                                    <span class="text-[10px] text-gray-400 font-bold whitespace-nowrap" x-text="notif.time_human"></span>
                                </div>
                                <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed" x-text="notif.desc"></p>
                                <div class="absolute left-0 top-0 bottom-0 w-1 bg-[#be2346] scale-y-0 group-hover:scale-y-100 transition-transform duration-300"></div>
                            </a>
                        </template>

                        <div x-show="unreadNotifications.length === 0" class="py-16 text-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                            </div>
                            <p class="text-sm font-bold text-gray-400">Aucune nouvelle notification</p>
                            <p class="text-[10px] text-gray-300 font-medium mt-1">Vous êtes à jour !</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</nav>