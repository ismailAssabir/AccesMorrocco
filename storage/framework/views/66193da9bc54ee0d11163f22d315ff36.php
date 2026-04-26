<div x-data="pointageModal()" 
     x-show="isOpen" 
     x-on:open-pointage-modal.window="openModal()" 
     class="fixed inset-0 z-[150] overflow-y-auto" 
     style="display: none;">
    
    
    <div x-show="isOpen" 
         x-transition:enter="ease-out duration-300" 
         x-transition:enter-start="opacity-0" 
         x-transition:enter-end="opacity-100" 
         x-transition:leave="ease-in duration-200" 
         x-transition:leave-start="opacity-100" 
         x-transition:leave-end="opacity-0" 
         @click="closeModal()" 
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

    
    <div class="flex min-h-full items-center justify-center p-4">
        <div x-show="isOpen" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
             class="relative transform overflow-hidden rounded-[32px] bg-white shadow-2xl transition-all w-full max-w-lg">
            
            
            <div class="px-8 pt-8 pb-6 flex items-center justify-between border-b border-slate-50">
                <div>
                    <h2 class="text-2xl font-black text-slate-800 tracking-tight">Pointage Digital</h2>
                    <div class="flex items-center gap-2 mt-1">
                        <p class="text-sm text-slate-400 font-medium" x-text="currentTimeDisplay"></p>
                        <?php if(auth()->user()->type !== 'employee'): ?>
                            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                            <a href="<?php echo e(route('admin.pointages.index')); ?>" class="text-[10px] font-black text-[#be2346] uppercase hover:underline">Tableau de bord</a>
                        <?php endif; ?>
                    </div>
                </div>
                <button @click="closeModal()" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:text-[#be2346] hover:bg-red-50 transition-all">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            
            <div class="p-8 space-y-8">
                
                
                <div class="flex flex-col items-center justify-center py-4">
                    <div class="relative">
                        <div class="w-24 h-24 rounded-3xl bg-slate-50 flex items-center justify-center animate-pulse" x-show="isLoading">
                            <svg class="w-10 h-10 text-slate-200 animate-spin" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </div>
                        
                        <div x-show="!isLoading" class="flex flex-col items-center">
                            <div class="w-24 h-24 rounded-[32px] flex items-center justify-center shadow-inner transition-colors duration-500"
                                :class="{
                                    'bg-emerald-50 text-emerald-500': status.checked_in && !status.checked_out,
                                    'bg-slate-50 text-slate-300': !status.checked_in,
                                    'bg-indigo-50 text-indigo-500': status.checked_in && status.checked_out
                                }">
                                <template x-if="!status.checked_in">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                                </template>
                                <template x-if="status.checked_in && !status.checked_out">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </template>
                                <template x-if="status.checked_in && status.checked_out">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </template>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 text-center" x-show="!isLoading">
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] px-3 py-1 rounded-full border transition-all"
                            :class="{
                                'text-emerald-600 bg-emerald-50 border-emerald-100': status.checked_in && !status.checked_out,
                                'text-slate-400 bg-slate-50 border-slate-100': !status.checked_in,
                                'text-indigo-600 bg-indigo-50 border-indigo-100': status.checked_in && status.checked_out
                            }"
                            x-text="statusText"></span>
                    </div>
                </div>

                
                <div class="grid grid-cols-2 gap-4" x-show="!isLoading">
                    <div class="bg-slate-50/50 p-4 rounded-2xl border border-slate-100 text-center">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Arrivée</p>
                        <p class="text-lg font-black text-slate-800 mt-1" x-text="status.heureEntree || '--:--'"></p>
                    </div>
                    <div class="bg-slate-50/50 p-4 rounded-2xl border border-slate-100 text-center">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Départ</p>
                        <p class="text-lg font-black text-slate-800 mt-1" x-text="status.heureSortie || '--:--'"></p>
                    </div>
                </div>

                
                <div class="flex items-center gap-3 bg-indigo-50/30 p-4 rounded-2xl border border-indigo-100/50">
                    <div class="w-10 h-10 rounded-xl bg-white border border-indigo-100 flex items-center justify-center text-indigo-500 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest leading-none">Localisation</p>
                        <p class="text-xs font-bold text-indigo-600 mt-1 truncate" x-text="gpsStatus"></p>
                    </div>
                    <div class="flex items-center" x-show="isLocating">
                         <svg class="w-4 h-4 text-indigo-400 animate-spin" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </div>
                </div>
            </div>

            
            <div class="p-8 pt-0">
                <template x-if="!status.checked_in">
                    <button @click="handleAction('checkin')" 
                        :disabled="isProcessing || isLocating"
                        class="w-full bg-emerald-500 hover:bg-emerald-600 disabled:opacity-50 disabled:cursor-not-allowed text-white py-4 rounded-2xl font-black text-sm shadow-xl shadow-emerald-500/20 transition-all active:scale-[0.98] flex items-center justify-center gap-3">
                        <span x-show="!isProcessing">Pointer l'Entrée</span>
                        <svg x-show="isProcessing" class="w-5 h-5 animate-spin" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </button>
                </template>

                <template x-if="status.checked_in && !status.checked_out">
                    <button @click="handleAction('checkout')" 
                        :disabled="isProcessing || isLocating"
                        class="w-full bg-[#be2346] hover:bg-[#a01d3a] disabled:opacity-50 disabled:cursor-not-allowed text-white py-4 rounded-2xl font-black text-sm shadow-xl shadow-[#be2346]/20 transition-all active:scale-[0.98] flex items-center justify-center gap-3">
                        <span x-show="!isProcessing">Pointer la Sortie</span>
                        <svg x-show="isProcessing" class="w-5 h-5 animate-spin" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </button>
                </template>

                <template x-if="status.checked_in && status.checked_out">
                    <div class="w-full bg-slate-100 text-slate-400 py-4 rounded-2xl font-black text-sm text-center">
                        Journée terminée
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function pointageModal() {
    return {
        isOpen: false,
        isLoading: true,
        isProcessing: false,
        isLocating: false,
        currentTimeDisplay: '',
        gpsStatus: '📡 En attente...',
        currentCoords: null,
        status: {
            checked_in: false,
            checked_out: false,
            heureEntree: null,
            heureSortie: null,
            status: null
        },

        init() {
            this.updateClock();
            setInterval(() => this.updateClock(), 1000);
        },

        updateClock() {
            const now = new Date();
            const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
            this.currentTimeDisplay = now.toLocaleDateString('fr-FR', options);
        },

        get statusText() {
            if (!this.status.checked_in) return 'Absent';
            if (this.status.checked_in && !this.status.checked_out) return 'En poste';
            return 'Terminé';
        },

        async openModal() {
            this.isOpen = true;
            this.isLoading = true;
            await this.fetchStatus();
            this.startLocationWatch();
        },

        closeModal() {
            this.isOpen = false;
        },

        async fetchStatus() {
            try {
                const response = await fetch('<?php echo e(route("pointage.status")); ?>');
                const data = await response.json();
                this.status = data;
            } catch (error) {
                console.error('Fetch error:', error);
            } finally {
                this.isLoading = false;
            }
        },

        startLocationWatch() {
            if (!navigator.geolocation) {
                this.gpsStatus = '❌ Non supporté';
                return;
            }

            this.isLocating = true;
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    this.currentCoords = `${position.coords.latitude},${position.coords.longitude}`;
                    this.gpsStatus = `✅ ${position.coords.latitude.toFixed(4)}, ${position.coords.longitude.toFixed(4)}`;
                    this.isLocating = false;
                },
                (error) => {
                    this.gpsStatus = '❌ Accès refusé';
                    this.isLocating = false;
                },
                { enableHighAccuracy: true, timeout: 5000 }
            );
        },

        async handleAction(action) {
            if (!this.currentCoords) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Localisation requise',
                    text: 'Veuillez autoriser l\'accès GPS pour pointer.',
                    confirmButtonColor: '#be2346'
                });
                return;
            }

            this.isProcessing = true;
            
            const url = action === 'checkin' ? '<?php echo e(route("pointage.checkin")); ?>' : '<?php echo e(route("pointage.checkout")); ?>';
            
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ gps: this.currentCoords })
                });

                const data = await response.json();

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succès !',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                    
                    // Update state
                    if (action === 'checkin') {
                        this.status.checked_in = true;
                        this.status.heureEntree = data.heureEntree;
                    } else {
                        this.status.checked_out = true;
                        this.status.heureSortie = data.heureSortie;
                    }
                    this.status.status = data.status;
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: data.message,
                        confirmButtonColor: '#be2346'
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur réseau',
                    text: 'Impossible de contacter le serveur.',
                    confirmButtonColor: '#be2346'
                });
            } finally {
                this.isProcessing = false;
            }
        }
    }
}
</script>
<?php /**PATH C:\Users\4B\Desktop\ExercicesLaravel\voyage\resources\views/components/pointage-modal.blade.php ENDPATH**/ ?>