
<div id="globalDeleteModal" class="fixed inset-0 z-[150] hidden overflow-y-auto">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeGlobalDeleteModal()"></div>
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white w-full max-w-md rounded-[32px] shadow-2xl overflow-hidden text-center border-t-4 border-red-600 transition-all transform scale-95 opacity-0" id="globalDeleteModalContent">
            <div class="p-8">
                
                <div id="deleteModalIconContainer" class="w-20 h-20 bg-red-50 rounded-2xl flex items-center justify-center mx-auto mb-6 text-red-600">
                    <div id="deleteModalIcon">
                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>
                </div>

                
                <h2 id="deleteModalTitle" class="text-xl font-black text-slate-800 mb-2">Confirmer la suppression</h2>
                <p id="deleteModalDescription" class="text-slate-500 text-sm mb-8 font-medium px-4 leading-relaxed">
                    Cette action est irréversible. Voulez-vous vraiment supprimer cet élément ?
                </p>
                
                
                <div class="flex gap-3">
                    <button type="button" onclick="closeGlobalDeleteModal()" class="flex-1 py-3.5 rounded-xl bg-slate-100 text-slate-600 font-bold hover:bg-slate-200 transition-all active:scale-[0.98]">
                        Annuler
                    </button>
                    <form id="globalDeleteForm" method="POST" class="flex-1">
                        <?php echo csrf_field(); ?>
                        <div id="methodPlaceholder"></div>
                        <button type="submit" id="deleteModalConfirmBtn" class="w-full py-3.5 rounded-xl bg-red-600 text-white font-extrabold hover:bg-red-700 shadow-lg shadow-red-600/20 transition-all active:scale-[0.98]">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openGlobalDeleteModal(url, title, description, confirmBtnText = 'Supprimer', theme = 'danger', iconType = 'trash', method = 'DELETE') {
        const modal = document.getElementById('globalDeleteModal');
        const content = document.getElementById('globalDeleteModalContent');
        const form = document.getElementById('globalDeleteForm');
        const titleEl = document.getElementById('deleteModalTitle');
        const descEl = document.getElementById('deleteModalDescription');
        const confirmBtnEl = document.getElementById('deleteModalConfirmBtn');
        const iconContainer = document.getElementById('deleteModalIconContainer');
        const iconWrapper = document.getElementById('deleteModalIcon');
        const methodPlaceholder = document.getElementById('methodPlaceholder');

        form.action = url;
        if (title) titleEl.innerText = title;
        if (description) descEl.innerText = description;
        if (confirmBtnText) confirmBtnEl.innerText = confirmBtnText;

        // Method handling
        methodPlaceholder.innerHTML = method === 'DELETE' ? '<input type="hidden" name="_method" value="DELETE">' : '';

        // Theme handling
        if (theme === 'info' || theme === 'primary') {
            content.classList.replace('border-red-600', 'border-blue-600');
            iconContainer.classList.replace('bg-red-50', 'bg-blue-50');
            iconContainer.classList.replace('text-red-600', 'text-blue-600');
            confirmBtnEl.classList.replace('bg-red-600', 'bg-blue-600');
            confirmBtnEl.classList.replace('hover:bg-red-700', 'hover:bg-blue-700');
            confirmBtnEl.classList.replace('shadow-red-600/20', 'shadow-blue-600/20');
        }

        // Icon handling
        if (iconType === 'logout') {
            iconWrapper.innerHTML = `
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            `;
        } else if (iconType === 'switch' || iconType === 'refresh') {
            iconWrapper.innerHTML = `
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
            `;
        }

        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeGlobalDeleteModal() {
        const modal = document.getElementById('globalDeleteModal');
        const content = document.getElementById('globalDeleteModalContent');
        const confirmBtnEl = document.getElementById('deleteModalConfirmBtn');
        const iconContainer = document.getElementById('deleteModalIconContainer');
        const iconWrapper = document.getElementById('deleteModalIcon');

        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            
            // Reset to default (Red/Trash)
            document.getElementById('deleteModalConfirmBtn').innerText = 'Supprimer';
            content.classList.replace('border-blue-600', 'border-red-600');
            iconContainer.classList.replace('bg-blue-50', 'bg-red-50');
            iconContainer.classList.replace('text-blue-600', 'text-red-600');
            confirmBtnEl.classList.replace('bg-blue-600', 'bg-red-600');
            confirmBtnEl.classList.replace('hover:bg-blue-700', 'hover:bg-red-700');
            confirmBtnEl.classList.replace('shadow-blue-600/20', 'shadow-red-600/20');
            
            iconWrapper.innerHTML = `
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            `;
        }, 200);
    }

    // Standardize the global confirmDelete function
    window.confirmDelete = function(url, entityType) {
        let title = "Confirmer la suppression";
        let description = "Cette action est irréversible. Voulez-vous vraiment supprimer cet élément ?";

        // Branded logic for different modules
        if (entityType === 'réunion') {
            title = "Supprimer la réunion ?";
            description = "Cette action est irréversible. Voulez-vous vraiment supprimer cet événement ?";
        } else if (entityType === 'département') {
            title = "Supprimer le département ?";
            description = "Cette action est irréversible. Tous les liens avec ce département seront impactés.";
        } else if (entityType === 'collaborateur' || entityType === 'employé' || entityType === 'utilisateur') {
            title = "Supprimer le collaborateur ?";
            description = "Toutes les données de cet employé seront définitivement supprimées du système.";
        } else if (entityType === 'objectif') {
            title = "Supprimer l'objectif ?";
            description = "Cette action supprimera l'objectif et ses suivis d'avancement.";
        } else if (entityType === 'lead') {
            title = "Supprimer le lead ?";
            description = "Toutes les données de ce prospect seront définitivement supprimées.";
        } else if (entityType === 'historique' || entityType === 'pointage') {
            title = "Vider l'historique ?";
            description = "TOUS les enregistrements de pointage seront définitivement supprimés. Cette action est irréversible.";
        } else if (entityType === 'prime') {
            title = "Supprimer la prime ?";
            description = "Cette action est irréversible. Voulez-vous vraiment supprimer cette prime ?";
        }

        openGlobalDeleteModal(url, title, description);
    };

    window.confirmLogout = function() {
        openGlobalDeleteModal(
            "<?php echo e(route('logout')); ?>", 
            "Quitter la session ?", 
            "Êtes-vous sûr de vouloir vous déconnecter de votre compte Access Morocco ?", 
            "Se déconnecter", 
            "danger", 
            "logout", 
            "POST"
        );
    };
</script>
<?php /**PATH C:\Users\ABA SOLUTIONS\Desktop\PROJET STAGE Travel Agency\AccesMorrocco\resources\views/components/delete-confirmation-modal.blade.php ENDPATH**/ ?>