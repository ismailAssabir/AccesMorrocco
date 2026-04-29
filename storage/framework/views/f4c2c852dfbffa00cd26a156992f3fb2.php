<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport des Catégories</title>

    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #374151;
            font-size: 11px;
            margin: 0;
        }

        @page { margin: 30px; }

        /* HEADER */
        .header table { width: 100%; }

        .title {
            font-size: 20px;
            font-weight: 800;
            text-align: center;
            color: #1e293b;
            text-transform: uppercase;
        }

        .subtitle {
            font-size: 9px;
            text-align: center;
            color: #94a3b8;
        }

        /* METADATA */
        .metadata-box {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 8px 12px;
            margin: 15px 0;
        }

        .metadata-table {
            width: 100%;
            font-size: 9px;
            color: #64748b;
        }

        .metadata-label {
            font-weight: bold;
            color: #334155;
        }

        /* STATS */
        .stats-table {
            width: 100%;
            border-spacing: 10px;
            margin-bottom: 20px;
        }

        .stat-card {
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            border: 2px solid #b11d40;
            background: #fdf2f5;
            color: #b11d40;
        }

        .stat-title {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .stat-value {
            font-size: 22px;
            font-weight: 800;
        }

        /* TABLE */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            border: 1px solid #e5e7eb;
        }

        .data-table th {
            background: #b11d40;
            color: white;
            padding: 10px;
            text-transform: uppercase;
        }

        .data-table td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
        }

        .data-table tr:nth-child(even) {
            background: #f9fafb;
        }

        /* FOOTER */
        .footer {
            position: fixed;
            bottom: -20px;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }

        .pagenum:before {
            content: counter(page);
        }
    </style>
</head>

<body>

    
    <div class="header">
        <table>
            <tr>
                
                <td width="30%" style="text-align: left;">
                    <div style="color:#b11d40;font-size:14px;font-weight:900;">
                        <?php echo e(config('app.name')); ?>

                    </div>
                </td>

                
                <td width="40%">
                    <div class="title">Rapport des Catégories</div>
                    <div class="subtitle">
                        Généré le <?php echo e(date('d/m/Y à H:i')); ?>

                    </div>
                </td>

                
                <td width="30%" style="text-align:right;">
                    <strong>SYSTÈME</strong>
                </td>
            </tr>
        </table>
    </div>

    
    <div class="metadata-box">
        <table class="metadata-table">
            <tr>
                <td>
                    <span class="metadata-label">Date :</span> <?php echo e(date('d/m/Y')); ?>

                </td>
                <td style="text-align:center;">
                    <span class="metadata-label">Utilisateur :</span> Admin
                </td>
                <td style="text-align:right;">
                    <span class="metadata-label">Total :</span> <?php echo e($categories->count()); ?>

                </td>
            </tr>
        </table>
    </div>

    
    <table class="stats-table">
        <tr>
            <td class="stat-card">
                <div class="stat-title">Total Catégories</div>
                <div class="stat-value"><?php echo e($categories->count()); ?></div>
            </td>
        </tr>
    </table>

    
    <table class="data-table">
        <thead>
            <tr>
                <th width="10%">#</th>
                <th width="30%">Titre</th>
                <th width="60%">Description</th>
            </tr>
        </thead>

        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($index + 1); ?></td>
                td class="category-nom">
                    <strong><?php echo e($category->nom); ?></strong>
                </td>
                <td>
                    <?php echo e($category->desc ?: '—'); ?>

                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="3" style="text-align:center;padding:20px;">
                    Aucune catégorie trouvée
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    
    <div class="footer">
        <?php echo e(config('app.name')); ?> | Rapport Catégories - Page <span class="pagenum"></span>
    </div>

</body>
</html><?php /**PATH C:\Users\4B\Desktop\ExercicesLaravel\voyage\resources\views/pdf/categories.blade.php ENDPATH**/ ?>