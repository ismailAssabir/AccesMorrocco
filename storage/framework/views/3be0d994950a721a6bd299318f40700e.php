<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1e293b; background: #fff; }

        .header {
            background: linear-gradient(135deg, #b11d40, #7c1233);
            color: white;
            padding: 20px 30px;
            margin-bottom: 24px;
        }
        .header h1 { font-size: 20px; font-weight: 900; letter-spacing: -0.5px; }
        .header p { font-size: 11px; opacity: 0.8; margin-top: 4px; }
        .header .meta { font-size: 10px; margin-top: 8px; opacity: 0.7; }

        .badge-count {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: bold;
            margin-top: 6px;
        }

        table { width: 100%; border-collapse: collapse; }
        thead tr { background: #f8fafc; }
        thead th {
            padding: 10px 12px;
            text-align: left;
            font-size: 9px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94a3b8;
            border-bottom: 2px solid #e2e8f0;
        }
        tbody tr { border-bottom: 1px solid #f1f5f9; }
        tbody tr:nth-child(even) { background: #fafafa; }
        tbody td { padding: 9px 12px; color: #334155; vertical-align: middle; }

        .avatar {
            display: inline-block;
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: #fce4ea;
            color: #b11d40;
            font-weight: 900;
            font-size: 10px;
            text-align: center;
            line-height: 28px;
        }
        .name-block { display: inline-block; vertical-align: middle; margin-left: 8px; }
        .name { font-weight: 700; font-size: 11px; color: #0f172a; }
        .sub { font-size: 9px; color: #94a3b8; }

        .pill {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            background: #fce4ea;
            color: #b11d40;
            font-size: 9px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .footer {
            margin-top: 24px;
            padding-top: 12px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Rapport des Leads</h1>
        <p>Liste complète des prospects commerciaux</p>
        <div class="meta">Généré le <?php echo e(now()->format('d/m/Y à H:i')); ?></div>
        <div class="badge-count"><?php echo e($leads->count()); ?> lead(s)</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Lead</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Type</th>
                <th>Source</th>
                <th>Nationalité</th>
                <th>Département</th>
                <th>Date création</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>
                    <span class="avatar"><?php echo e(strtoupper(substr($lead->firstName,0,1))); ?><?php echo e(strtoupper(substr($lead->lastName,0,1))); ?></span>
                    <span class="name-block">
                        <div class="name"><?php echo e($lead->firstName); ?> <?php echo e($lead->lastName); ?></div>
                        <div class="sub"><?php echo e($lead->adresse ?? '—'); ?></div>
                    </span>
                </td>
                <td><?php echo e($lead->email ?? '—'); ?></td>
                <td><?php echo e($lead->phoneNumber ?? '—'); ?></td>
                <td><span class="pill"><?php echo e($lead->type); ?></span></td>
                <td><?php echo e($lead->source ?? '—'); ?></td>
                <td><?php echo e($lead->nationalite ?? '—'); ?></td>
                <td><?php echo e($lead->departements->name ?? '—'); ?></td>
                <td><?php echo e($lead->dateCreation ? \Carbon\Carbon::parse($lead->dateCreation)->format('d/m/Y') : '—'); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="8" style="text-align:center; padding: 30px; color: #94a3b8;">Aucun lead trouvé</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        Rapport confidentiel — <?php echo e(config('app.name')); ?> © <?php echo e(now()->year); ?>

    </div>
</body>
</html><?php /**PATH C:\Users\4B\Desktop\ExercicesLaravel\voyage\resources\views/leads/pdf.blade.php ENDPATH**/ ?>