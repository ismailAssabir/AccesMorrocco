<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Rapport des Dossiers</title>
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
        .bg-main { background-color: #f0f7ff; color: #1e293b; border-color: #3b82f6; } /* Total */
        .bg-money { background-color: #f0fdf4; color: #15803d; border-color: #22c55e; } /* Chiffre d'affaires */
        .bg-open { background-color: #fffaf0; color: #c2410c; border-color: #f97316; } /* En cours */

        /* Table */
        .data-table { width: 100%; border-collapse: collapse; font-size: 10px; margin-bottom: 30px; border: 1px solid #e5e7eb; table-layout: fixed; }
        .data-table th { background-color: #1e293b; color: #ffffff; font-weight: bold; text-transform: uppercase; padding: 12px 10px; text-align: left; }
        .data-table td { padding: 10px; border-bottom: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb; vertical-align: middle; }
        .data-table tr:nth-child(even) { background-color: #f9fafb; }
        
        /* Badges Statut */
        .badge { display: inline-block; padding: 5px 8px; border-radius: 6px; font-size: 8px; font-weight: 800; text-transform: uppercase; text-align: center; color: #ffffff; min-width: 60px; }
        .badge-ouvert { background-color: #3b82f6; border: 1px solid #2563eb; }
        .badge-en_cours { background-color: #f59e0b; border: 1px solid #d97706; }
        .badge-ferme { background-color: #6b7280; border: 1px solid #4b5563; }
        
        /* Utils */
        .client-name { font-weight: bold; font-size: 10px; color: #1f2937; }
        .dest-text { font-size: 9px; color: #6b7280; font-style: italic; }
        .amount { font-weight: 800; color: #1e293b; white-space: nowrap; }
        
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
                    <div style="width: 100px; height: 40px; background: #f3f4f6; border: 1px dashed #ccc; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="logo" style="max-height: 100%; max-width: 100%;">
                    </div>                       
                <div style="color: #b11d40; font-size: 11px; font-weight: 900; margin-top: 5px; text-transform: uppercase; letter-spacing: 0.5px;">ACCESS MOROCCO</div>
                    </div>
                </td>
                <td width="34%" style="text-align: center; vertical-align: middle;">
                    <div style="font-size: 20px; font-weight: 800; color: #1e293b; text-transform: uppercase;">Rapport des Dossiers</div>
                    <div style="font-size: 9px; color: #94a3b8; margin-top: 4px;">Période du <?php echo e(now()->format('d/m/Y')); ?></div>
                </td>
                <td width="33%" style="text-align: right; vertical-align: middle;">
                    <div style="color: #1e293b; font-size: 15px; font-weight: 800; text-transform: uppercase;">GESTION VOYAGES</div>
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
                <div class="stat-card-title">Total Dossiers</div>
                <div class="stat-card-value"><?php echo e($dossiers->count()); ?></div>
            </td>
            <td class="stat-card bg-money" width="33%">
                <div class="stat-card-title">Chiffre d'Affaires</div>
                <div class="stat-card-value"><?php echo e(number_format($dossiers->sum('montant'), 0, ',', ' ')); ?> <small style="font-size: 10px;">MAD</small></div>
            </td>
            <td class="stat-card bg-open" width="33%">
                <div class="stat-card-title">Dossiers ouverts</div>
                <div class="stat-card-value"><?php echo e($dossiers->where('status', 'ouvert')->count()); ?></div>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="12%">Référence</th>
                <th width="23%">Client & Destination</th>
                <th width="12%">Département</th>
                <th width="8%" style="text-align: center;">Pers.</th>
                <th width="8%" style="text-align: center;">Jours</th>
                <th width="15%" style="text-align: center;">Montant</th>
                <th width="12%" style="text-align: center;">Date Voyage</th>
                <th width="10%" style="text-align: center;">Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $dossiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td style="font-weight: bold; color: #1e293b;"><?php echo e($d->reference); ?></td>
                    <td>
                        <div class="client-name"><?php echo e($d->client->firstName ?? '—'); ?> <?php echo e($d->client->lastName ?? ''); ?></div>
                        <div class="dest-text"><?php echo e($d->distination ?? 'Destination non spécifiée'); ?></div>
                    </td>
                    <td style="color: #4b5563;"><?php echo e($d->departement->title ?? '—'); ?></td>
                    <td style="text-align: center;"><?php echo e($d->nombrePersonnes); ?></td>
                    <td style="text-align: center;"><?php echo e($d->nombreJours); ?></td>
                    <td style="text-align: center;" class="amount"><?php echo e(number_format($d->montant, 2, ',', ' ')); ?> MAD</td>
                    <td style="text-align: center; color: #1e293b;">
                        <?php echo e($d->dateVoyage ? \Carbon\Carbon::parse($d->dateVoyage)->format('d/m/Y') : '—'); ?>

                    </td>
                    <td style="text-align: center;">
                        <div class="badge badge-<?php echo e(strtolower($d->status)); ?>">
                            <?php echo e($d->status); ?>

                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" style="text-align: center; padding: 30px; color: #6b7280;">Aucun dossier trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        Access Morocco | Rapport Confidentiel - Page <span class="pagenum"></span>
    </div>
</body>
</html><?php /**PATH C:\Users\4B\Desktop\ExercicesLaravel\voyage\resources\views/dossiers/pdf.blade.php ENDPATH**/ ?>