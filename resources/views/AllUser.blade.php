<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen font-sans text-slate-900">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Ressources Humaines</h1>
                <p class="text-slate-500 text-sm mt-1 font-medium">Gestion des effectifs et des talents Access Morocco.
                </p>
            </div>

            <button onclick="toggleModal('addUserModal')"
                class="flex items-center gap-2 bg-[#be2346] hover:bg-[#a01d3a] text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-md shadow-[#be2346]/10 active:scale-95 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter un Employé
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-slate-400 text-[10px] uppercase font-black tracking-widest">Effectif Total</p>
                    <span class="p-2 bg-slate-50 rounded-lg text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </span>
                </div>
                <h3 class="text-3xl font-bold mt-2 text-slate-800">{{ $users->count() }}</h3>
            </div>

            <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm border-l-4 border-l-[#be2346]">
                <p class="text-slate-400 text-[10px] uppercase font-black tracking-widest">En Congé</p>
                <h3 class="text-3xl font-bold mt-2 text-[#be2346]">{{ $users->where('status', 'conge')->count() }}</h3>
            </div>

            <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm">
                <p class="text-slate-400 text-[10px] uppercase font-black tracking-widest">Consultants</p>
                <h3 class="text-3xl font-bold mt-2 text-blue-600">
                    {{ $users->where('typeContrat', 'freelance')->count() }}</h3>
            </div>
        </div>

        @if(session('msg'))
            <div
                class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-600 rounded-2xl font-bold text-sm flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('msg') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-2xl font-bold text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden mb-8">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/50">
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                Collaborateur</th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Poste
                            </th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                Contrat</th>
                            <th
                                class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($users as $user)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-[#be2346]/10 flex items-center justify-center font-bold text-xs text-[#be2346]">
                                            {{ strtoupper(substr($user->firstName, 0, 1)) }}{{ strtoupper(substr($user->lastName, 0, 1)) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-slate-700">{{ $user->firstName }}
                                                {{ $user->lastName }}</span>
                                            <span class="text-[11px] text-slate-400">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 font-medium">{{ $user->post ?? 'Non défini' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="text-[10px] font-black text-slate-400 uppercase">{{ $user->typeContrat }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick='openEditModal(@json($user))'
                                            class="p-2 rounded-lg text-slate-400 hover:bg-[#be2346]/10 hover:text-[#be2346] transition-all">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-slate-400 text-sm">Aucun collaborateur
                                    trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <script>
            function openDeptModal() {
                const modal = document.getElementById('addUserModal');
                if (modal) {
                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden'; // منع scroll
                }
            }

            function closeDeptModal() {
                const modal = document.getElementById('addUserModal');
                if (modal) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto'; // رجوع scroll
                }
            }

            // ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeDeptModal();
                }
            });
        </script>

        <div id="addUserModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('addUserModal')"></div>
            <div class="relative flex items-center justify-center min-h-screen p-4">
                <div class="bg-white w-full max-w-2xl rounded-[32px] shadow-2xl overflow-hidden p-8">
                    <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between shrink-0">
                        <div>
                            <h2 class="text-lg font-black text-slate-800" id="deptModalTitle">Ajouter un collaborateur</h2>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Fiche de création · Access Morocco</p>
                        </div>
                        <button type="button" onclick="closeDeptModal()"
                            class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-[#b11d40] hover:border-[#b11d40]/30 transition-all">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <form action="{{ url('/users') }}" method="POST" class="space-y-5">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        
                            <input type="text" name="firstName" required placeholder="Prénom"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm">
                            <input type="text" name="lastName" required placeholder="Nom"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm">
                            <input type="hidden" name="fichier" value="placeholder">
                            <input type="hidden" name="rip" value="placeholder">
                            <input type="email" name="email" required placeholder="Email"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm col-span-2">
                            <input type="password" name="password" required placeholder="Mot de passe" value="12345678"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm">
                            <input type="text" name="cin" required placeholder="CIN"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm">
                            <input type="text" name="post" placeholder="Poste"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm">
                            <input type="text" name="phoneNumber" required placeholder="Téléphone"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm">
                            <input type="date" name="birthday" required
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm">
                            <input type="number" name="salaire" required placeholder="Salaire"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm">
                            <select name="typeContrat"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm">
                                <option value="CDI">CDI</option>
                                <option value="CI">CI</option>
                                <option value="freelance">Freelance</option>
                            </select>
                        </div>
                        <button type="submit"
                            class="w-full py-4 rounded-xl bg-[#be2346] text-white font-black">Confirmer l'ajout</button>
                    </form>
                </div>
            </div>
        </div>

        <div id="editUserModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('editUserModal')"></div>
            <div class="relative flex items-center justify-center min-h-screen p-4">
                <div class="bg-white w-full max-w-2xl rounded-[32px] shadow-2xl overflow-hidden p-8">
                    <h2 class="text-xl font-black text-slate-800 mb-6">Modifier collaborateur</h2>
                    <form id="editForm" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <input type="text" name="firstName" id="edit_firstName"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm">
                            <input type="text" name="lastName" id="edit_lastName"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm">
                            <input type="email" name="email" id="edit_email"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm col-span-2">
                            <input type="text" name="post" id="edit_post"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm col-span-2"
                                placeholder="Poste">
                            <input type="text" name="cin" id="edit_cin"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm"
                                placeholder="CIN">
                            <input type="number" name="salaire" id="edit_salaire"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm"
                                placeholder="Salaire">
                            <input type="text" name="phoneNumber" id="edit_phoneNumber"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm"
                                placeholder="Téléphone">
                            <input type="date" name="birthday" id="edit_birthday"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm">
                            <select name="typeContrat" id="edit_typeContrat"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm col-span-2 md:col-span-1">
                                <option value="CDI">CDI</option>
                                <option value="CI">CI</option>
                                <option value="freelance">Freelance</option>
                            </select>
                        </div>
                        <button type="submit"
                            class="w-full py-4 rounded-xl bg-slate-800 text-white font-black">Sauvegarder les
                            modifications</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Updated to handle specific modal IDs
        function toggleModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.toggle('hidden');
                document.body.style.overflow = modal.classList.contains('hidden') ? 'auto' : 'hidden';
            }
        }

        function openEditModal(user) {
            // Your friend's controller expects the ID to be passed to the route
            // Make sure your route in web.php is: Route::put('/users/edit/{id}', [UserController::class, 'update'])
            document.getElementById('editForm').action = '{{ url("/users/edit") }}/' + (user.idUser || user.id || user.id_user);

            document.getElementById('edit_firstName').value = user.firstName || '';
            document.getElementById('edit_lastName').value = user.lastName || '';
            document.getElementById('edit_email').value = user.email || '';
            document.getElementById('edit_cin').value = user.cin || '';
            document.getElementById('edit_post').value = user.post || '';
            document.getElementById('edit_salaire').value = user.salaire || '';
            document.getElementById('edit_phoneNumber').value = user.phoneNumber || '';
            document.getElementById('edit_birthday').value = user.birthday ? user.birthday.split(' ')[0] : '';
            if (document.getElementById('edit_typeContrat')) {
                document.getElementById('edit_typeContrat').value = user.typeContrat || 'CDI';
            }

            toggleModal('editUserModal');
        }
    </script>
</x-app-layout>