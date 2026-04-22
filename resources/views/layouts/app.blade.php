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
                }).then((result) => {
                    if (result.isConfirmed && options.onConfirm) {
                        options.onConfirm();
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