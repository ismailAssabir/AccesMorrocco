<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        /* Configuration de la page pour le moteur de rendu PDF (DomPDF/Snappy) */
        @page { margin: 0; }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            font-size: 10px; 
            color: #334155; 
            line-height: 1.5;
            background-color: #ffffff;
        }

        /* En-tête Moderne */
        .header { 
            background-color: #1e293b; 
            color: white; 
            padding: 40px 30px; 
            position: relative;
            border-bottom: 4px solid #b11d40; /* Touche de rappel de votre couleur rouge */
        }
        
        .header-content { display: block; }
        
        .header h1 { 
            font-size: 24px; 
            font-weight: bold; 
            letter-spacing: -0.5px;
            margin-bottom: 5px;
        }
        
        .meta-info { font-size: 10px; color: #94a3b8; }

        .stats-badge {
            position: absolute;
            top: 45px;
            right: 30px;
            background: rgba(255, 255, 255, 0.1);
            padding: 10px 15px;
            border-radius: 8px;
            text-align: right;
        }

        .stats-badge .count { font-size: 18px; font-weight: bold; display: block; color: #f8fafc; }
        .stats-badge .label { font-size: 9px; text-transform: uppercase; color: #94a3b8; }

        /* Table Design */
        .container { padding: 30px; }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px;
            table-layout: fixed; /* Empêche le débordement */
        }

        thead th { 
            background-color: #f8fafc;
            padding: 12px 8px; 
            text-align: left; 
            font-size: 8px; 
            font-weight: 700; 
            text-transform: uppercase; 
            color: #64748b; 
            border-bottom: 1px solid #e2e8f0;
        }

        tbody tr { border-bottom: 1px solid #f1f5f9; }
        tbody tr:nth-child(even) { background-color: #fafafa; }

        td { 
            padding: 12px 8px; 
            word-wrap: break-word; 
            vertical-align: middle;
        }

        .ref-text { color: #1e293b; font-weight: bold; }
        .amount { color: #b11d40; font-weight: 700; white-space: nowrap; }

        /* Status Pills */
        .pill { 
            display: inline-block; 
            padding: 4px 8px; 
            border-radius: 4px; 
            font-size: 8px; 
            font-weight: bold; 
            text-align: center;
            text-transform: uppercase;
        }
        .ouvert { background: #e0f2fe; color: #0369a1; }
        .en_cours { background: #fefce8; color: #854d0e; }
        .ferme { background: #f1f5f9; color: #475569; }

        /* Footer */
        .footer { 
            position: fixed; 
            bottom: 0; 
            width: 100%;
            padding: 20px 30px; 
            font-size: 9px; 
            color: #94a3b8; 
            border-top: 1px solid #f1f5f9;
            text-align: left;
        }
        .page-number:before { content: "Page " counter(page); }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>Rapport d'Activité</h1>
            <p class="meta-info">Document généré le <?php echo e(now()->format('d/m/Y à H:i')); ?></p>
        </div>
        <div class="stats-badge">
            <span class="count"><?php echo e($dossiers->count()); ?></span>
            <span class="label">Dossiers Total</span>
        </div>
    </div>

    <div class="container">
        <table>
            <thead>
                <tr>
                    <th width="12%">Référence</th>
                    <th width="18%">Client</th>
                    <th width="15%">Destination</th>
                    <th width="12%">Dép.</th>
                    <th width="7%">Pers.</th>
                    <th width="15%">Montant</th>
                    <th width="12%">Date Voyage</th>
                    <th width="9%">Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $dossiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dossier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="ref-text"><?php echo e($dossier->reference); ?></td>
                    <td><?php echo e($dossier->client->firstName ?? '—'); ?> <?php echo e($dossier->client->lastName ?? ''); ?></td>
                    <td><?php echo e($dossier->distination ?? '—'); ?></td>
                    <td><small><?php echo e($dossier->departement->title ?? '—'); ?></small></td>
                    <td style="text-align: center;"><?php echo e($dossier->nombrePersonnes); ?></td>
                    <td class="amount"><?php echo e(number_format($dossier->montant, 2, ',', ' ')); ?> MAD</td>
                    <td><?php echo e($dossier->dateVoyage ? \Carbon\Carbon::parse($dossier->dateVoyage)->format('d/m/Y') : '—'); ?></td>
                    <td>
                        <span class="pill <?php echo e(strtolower($dossier->status)); ?>">
                            <?php echo e($dossier->status); ?>

                        </span>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" style="text-align:center; padding: 40px; color: #94a3b8;">
                        Aucune donnée disponible pour cette période.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="border: none; padding: 0;"><?php echo e(config('app.name')); ?> &copy; <?php echo e(now()->year); ?> — Confidentiel</td>
                <td style="border: none; padding: 0; text-align: right;" class="page-number"></td>
            </tr>
        </table>
    </div>
</body>
</html><?php /**PATH C:\Users\4B\Desktop\ExercicesLaravel\voyage\resources\views/dossiers/pdf.blade.php ENDPATH**/ ?>