<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Rapport des Clients</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #374151; line-height: 1.5; margin: 0; padding: 0; font-size: 11px; }
        @page { margin: 30px; }
        
        /* Header */
        .header { width: 100%; padding-top: 10px; padding-bottom: 20px; margin-bottom: 15px; }
        .header table { width: 100%; border-collapse: collapse; }
        
        .metadata-box { background-color: #f8fafc; border-radius: 6px; padding: 8px 12px; margin-bottom: 20px; border: 1px solid #e5e7eb; }
        .metadata-table { width: 100%; font-size: 9px; color: #64748b; }
        .metadata-table td { padding: 4px; border: none; vertical-align: middle; }
        .metadata-label { font-weight: bold; color: #334155; }
        
        /* KPI Cards */
        .stats-table { width: 100%; margin-bottom: 20px; border-collapse: separate; border-spacing: 12px 0; margin-left: -12px; }
        .stat-card { border-radius: 8px; padding: 12px; text-align: center; vertical-align: middle; border-width: 2px; border-style: solid; }
        .stat-card-title { font-size: 9px; font-weight: bold; text-transform: uppercase; margin-bottom: 4px; color: #64748b; }
        .stat-card-value { font-size: 20px; font-weight: 800; }
        
        /* Couleurs Thématiques */
        .bg-main { background-color: #f0f7ff; color: #1e293b; border-color: #3b82f6; }
        .bg-active { background-color: #f0fdf4; color: #15803d; border-color: #22c55e; }
        .bg-inactive { background-color: #fef2f2; color: #b91c1c; border-color: #ef4444; }
        
        /* Table */
        .data-table { width: 100%; border-collapse: collapse; font-size: 10px; margin-bottom: 30px; border: 1px solid #e5e7eb; table-layout: fixed; }
        .data-table th { background-color: #1e293b; color: #ffffff; font-weight: bold; text-transform: uppercase; padding: 12px 10px; text-align: left; }
        .data-table td { padding: 10px; border-bottom: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb; vertical-align: middle; }
        .data-table tr:nth-child(even) { background-color: #f9fafb; }
        
        /* Badges Statut */
        .badge { display: inline-block; padding: 5px 8px; border-radius: 6px; font-size: 8px; font-weight: 800; text-transform: uppercase; text-align: center; color: #ffffff; min-width: 60px; }
        .badge-actif { background-color: #22c55e; border: 1px solid #16a34a; }
        .badge-inactif { background-color: #ef4444; border: 1px solid #dc2626; }
        
        /* Badge Type Client */
        .type-badge { display: inline-block; padding: 3px 6px; border-radius: 4px; font-size: 8px; font-weight: 700; text-transform: uppercase; text-align: center; background-color: #fce7f3; color: #be185d; }
        
        /* Utils */
        .client-name { font-weight: bold; font-size: 10px; color: #1f2937; }
        .client-info { font-size: 9px; color: #6b7280; }
        
        .footer { position: fixed; bottom: -20px; left: 0; right: 0; text-align: center; font-size: 10px; color: #6b7280; border-top: 1px solid #e5e7eb; padding-top: 10px; font-weight: bold; }
        .pagenum:before { content: counter(page); }
    </style>
</head>
<body>

    <div class="header">
        <table style="width: 100%;">
            <tr>
                <td width="33%" style="text-align: left; vertical-align: top;">
                    <div style="display: inline-block; text-align: center; white-space: nowrap;">
                        <?php
                            $logoPath = public_path('images/logo.png');
                            $logoSrc = null;
                            if (file_exists($logoPath)) {
                                try {
                                    $type = pathinfo($logoPath, PATHINFO_EXTENSION);
                                    $data = file_get_contents($logoPath);
                                    $logoSrc = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                } catch (\Exception $e) { $logoSrc = null; }
                            }
                        ?>
                        <?php if($logoSrc): ?>
                            <img src="<?php echo e($logoSrc); ?>" style="width: 100px; display: block; margin: 0 auto;">
                        <?php else: ?>
                            <div style="width: 100px; height: 40px; background: #f3f4f6; border: 1px dashed #ccc; vertical-align: middle; text-align: center; font-size: 8px; color: #999; display: block; margin: 0 auto;">LOGO</div>
                        <?php endif; ?>
                        <div style="color: #be2346; font-size: 11px; font-weight: 900; margin-top: 5px; text-transform: uppercase; letter-spacing: 0.5px;">ACCESS MOROCCO</div>
                    </div>
                </td>
                <td width="34%" style="text-align: center; vertical-align: middle;">
                    <div style="font-size: 20px; font-weight: 800; color: #1e293b; text-transform: uppercase;">Rapport des Clients</div>
                    <div style="font-size: 9px; color: #94a3b8; margin-top: 4px;">Liste complète des clients enregistrés</div>
                </td>
                <td width="33%" style="text-align: right; vertical-align: middle;">
                    <div style="color: #1e293b; font-size: 15px; font-weight: 800; text-transform: uppercase;">CRM CLIENTS</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="metadata-box">
        <table class="metadata-table">
            <tr>
                <td width="50%">
                    <span class="metadata-label">Date d'extraction :</span> <?php echo e(now()->format('d/m/Y à H:i')); ?>

                </td>
                <td width="50%" style="text-align: right;">
                    <span class="metadata-label">Utilisateur :</span> <?php echo e(auth()->user()->name ?? 'Administrateur'); ?>

                </td>
            </tr>
        </table>
    </div>

    <table class="stats-table">
        <tr>
            <td class="stat-card bg-main" width="33%">
                <div class="stat-card-title">Total Clients</div>
                <div class="stat-card-value"><?php echo e($clients->count()); ?></div>
            </td>
            <td class="stat-card bg-active" width="33%">
                <div class="stat-card-title">Clients Actifs</div>
                <div class="stat-card-value"><?php echo e($clients->where('status', 'actif')->count()); ?></div>
            </td>
            <td class="stat-card bg-inactive" width="33%">
                <div class="stat-card-title">Clients Inactifs</div>
                <div class="stat-card-value"><?php echo e($clients->where('status', 'inactif')->count()); ?></div>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="15%">Client</th>
                <th width="15%">Email</th>
                <th width="10%">Téléphone</th>
                <th width="8%">CNE</th>
                <th width="10%">Type</th>
                <th width="8%">Nationalité</th>
                <th width="10%">Date Naissance</th>
                <th width="9%" style="text-align: center;">Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td style="font-weight: bold; color: #1e293b;"><?php echo e($client->idClient); ?></td>
                <td>
                    <div class="client-name"><?php echo e($client->firstName ?? '—'); ?> <?php echo e($client->lastName ?? ''); ?></div>
                    <div class="client-info"><?php echo e($client->address ?? 'Adresse non spécifiée'); ?></div>
                </td>
                <td style="color: #2563eb;"><?php echo e($client->email ?? '—'); ?></td>
                <td><?php echo e($client->phoneNumber ?? '—'); ?></td>
                <td><?php echo e($client->CNE ?? '—'); ?></td>
                <td>
                    <?php if($client->type): ?>
                        <span class="type-badge"><?php echo e($client->type); ?></span>
                    <?php else: ?>
                        <span style="color: #cbd5e1;">—</span>
                    <?php endif; ?>
                </td>
                <td><?php echo e($client->nationalite ?? '—'); ?></td>
                <td style="text-align: center;">
                    <?php echo e($client->dateNaissance ? \Carbon\Carbon::parse($client->dateNaissance)->format('d/m/Y') : '—'); ?>

                </td>
                <td style="text-align: center;">
                    <div class="badge badge-<?php echo e(strtolower($client->status ?? 'inactif')); ?>">
                        <?php echo e($client->status ?? 'Inactif'); ?>

                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="9" style="text-align: center; padding: 30px; color: #6b7280;">Aucun client trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        Access Morocco | Rapport Confidentiel - Page <span class="pagenum"></span>
    </div>
</body>
</html><?php /**PATH C:\Users\ABA SOLUTIONS\Desktop\PROJET STAGE Travel Agency\AccesMorrocco\resources\views/clients/pdf.blade.php ENDPATH**/ ?>