<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nouvelle Présentation — Access Morocco</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #1e293b;
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #1e293b;
            padding: 40px;
            text-align: center;
        }
        .header img {
            height: 40px;
        }
        .content {
            padding: 40px;
        }
        .greeting {
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 16px;
        }
        .message {
            font-size: 16px;
            color: #475569;
            margin-bottom: 32px;
        }
        .card {
            background-color: #f1f5f9;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 32px;
            border-left: 4px solid #be2346;
        }
        .card-title {
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #be2346;
            margin-bottom: 8px;
        }
        .card-value {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
        }
        .btn-container {
            text-align: center;
        }
        .btn {
            display: inline-block;
            background-color: #be2346;
            color: #ffffff !important;
            padding: 16px 32px;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: transform 0.2s;
            box-shadow: 0 4px 6px -1px rgba(190, 35, 70, 0.2);
        }
        .footer {
            padding: 32px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            background-color: #f8fafc;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            
            <h1 style="color: white; margin: 0; font-weight: 900; letter-spacing: -1px;">ACCESS MOROCCO</h1>
        </div>
        <div class="content">
            <div class="greeting">Bonjour <?php echo e($client->firstName); ?>,</div>
            <p class="message">
                Une nouvelle proposition de voyage a été préparée spécialement pour vous. Nos conseillers ont finalisé les détails de votre prochaine expérience au Maroc.
            </p>
            
            <div class="card">
                <div class="card-title">Présentation</div>
                <div class="card-value"><?php echo e($presentation->titre); ?></div>
                
                <div style="margin-top: 16px;">
                    <div class="card-title">Destination</div>
                    <div class="card-value"><?php echo e($presentation->dossier->distination); ?></div>
                </div>
            </div>

            <div class="btn-container">
                <a href="<?php echo e(route('clients.presentations.show', $presentation->idPresentation)); ?>" class="btn">
                    Voir ma présentation
                </a>
            </div>
        </div>
        <div class="footer">
            &copy; <?php echo e(date('Y')); ?> Access Morocco Experience. Tous droits réservés.<br>
            Ceci est un message automatique, merci de ne pas y répondre directement.
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\dell\Desktop\AccesMorrocco\resources\views/emails/new_presentation.blade.php ENDPATH**/ ?>