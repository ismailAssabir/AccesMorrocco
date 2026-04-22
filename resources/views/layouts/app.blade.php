<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>
            /* Custom SweetAlert2 Styles to match the requested design */
            .swal2-popup {
                border-radius: 32px !important;
                padding: 40px !important;
                font-family: 'Outfit', sans-serif !important;
                width: 450px !important;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15) !important;
            }
            .swal2-title {
                font-weight: 900 !important;
                color: #1e293b !important;
                font-size: 26px !important;
                margin-top: 24px !important;
                letter-spacing: -0.025em !important;
            }
            .swal2-html-container {
                color: #64748b !important;
                font-size: 15px !important;
                line-height: 1.6 !important;
                margin-top: 12px !important;
                font-weight: 500 !important;
            }
            .swal2-actions {
                margin-top: 36px !important;
                gap: 16px !important;
                width: 100% !important;
                justify-content: center !important;
            }
            .swal2-confirm {
                background: #f84444 !important;
                border-radius: 18px !important;
                font-weight: 800 !important;
                padding: 16px 44px !important;
                font-size: 16px !important;
                box-shadow: 0 10px 15px -3px rgba(248, 68, 68, 0.4) !important;
                order: 2 !important;
                border: none !important;
                color: white !important;
                transition: all 0.2s !important;
            }
            .swal2-confirm:hover {
                background: #ef4444 !important;
                transform: translateY(-2px) !important;
            }
            .swal2-cancel {
                background: white !important;
                color: #94a3b8 !important;
                border: 1.5px solid #f1f5f9 !important;
                border-radius: 18px !important;
                font-weight: 700 !important;
                padding: 16px 44px !important;
                font-size: 16px !important;
                order: 1 !important;
                transition: all 0.2s !important;
            }
            .swal2-cancel:hover {
                background: #f8fafc !important;
                color: #64748b !important;
            }
            .swal2-icon {
                border: none !important;
                background: #fef2f2 !important;
                width: 90px !important;
                height: 90px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                margin: 0 auto !important;
                border-radius: 50% !important;
            }
            .swal2-icon.swal2-warning {
                color: #f84444 !important;
            }
            .swal2-icon.swal2-warning .swal2-icon-content {
                font-size: 44px !important;
                font-family: inherit !important;
            }
            /* New Trash Icon Style */
            .swal2-trash-container {
                width: 100px;
                height: 100px;
                background: #fef2f2;
                border-radius: 24px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto;
            }
        </style>
        <script>
            window.showConfirmModal = function(options) {
                Swal.fire({
                    title: options.title || 'Supprimer !',
                    text: options.text || 'Êtes-vous sûr ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: options.confirmButtonText || 'Confirmer',
                    cancelButtonText: options.cancelButtonText || 'Annuler',
                    buttonsStyling: false,
                    reverseButtons: false,
                    allowOutsideClick: true,
                    customClass: {
                        popup: 'rounded-[32px] p-10',
                        title: 'text-2xl font-black text-slate-800',
                        htmlContainer: 'text-slate-500',
                        confirmButton: 'bg-[#f84444] text-white px-8 py-3.5 rounded-2xl font-extrabold shadow-lg shadow-red-500/20 mx-2 transition-all hover:bg-red-600',
                        cancelButton: 'bg-[#f1f5f9] text-slate-700 px-8 py-3.5 rounded-2xl font-bold mx-2 transition-all hover:bg-slate-200'
                    }
                }).then((result) => {
                    if (result.isConfirmed && options.onConfirm) {
                        options.onConfirm();
                    }
                });
            }

            window.confirmDelete = function(url, entityName) {
                Swal.fire({
                    title: 'Confirmer la suppression',
                    text: `Êtes-vous sûr de vouloir supprimer cette ${entityName} ? Cette action est irréversible.`,
                    iconHtml: `
                        <div class="swal2-trash-container">
                            <svg class="w-12 h-12 text-[#d32f2f]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Supprimer',
                    cancelButtonText: 'Annuler',
                    buttonsStyling: false,
                    reverseButtons: false,
                    customClass: {
                        popup: 'rounded-[32px] p-10',
                        title: 'text-2xl font-black text-slate-800 mt-6',
                        htmlContainer: 'text-slate-500 mt-4 px-4 leading-relaxed',
                        confirmButton: 'bg-[#d32f2f] text-white px-10 py-4 rounded-2xl font-extrabold shadow-lg shadow-red-500/20 mx-2 transition-all hover:bg-red-700',
                        cancelButton: 'bg-[#f1f5f9] text-slate-700 px-10 py-4 rounded-2xl font-bold mx-2 transition-all hover:bg-slate-200'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = url;
                        form.innerHTML = `
                            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                            <input type="hidden" name="_method" value="DELETE">
                        `;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }
        </script>
    </head>
    <body class="font-sans antialiased text-gray-900">
       <div class="flex min-h-screen bg-[#FDFCFB]"> 
    
    <x-sidebar />

    <div class="flex-1 flex flex-col min-w-0 bg-transparent">
        @include('layouts.navigation')

        <main class="flex-1">
            {{ $slot }}
        </main>
    </div>
</div>
    </body>
</html>