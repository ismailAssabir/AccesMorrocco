<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Prime Payée</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
            color: #334155;
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
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 40px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .content {
            padding: 40px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #1e293b;
        }
        .message {
            line-height: 1.6;
            margin-bottom: 30px;
            font-size: 15px;
        }
        .prime-card {
            background-color: #f0fdf4;
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 30px;
            border: 1px solid #dcfce7;
        }
        .prime-amount {
            font-size: 32px;
            font-weight: 900;
            color: #059669;
            margin-bottom: 5px;
        }
        .prime-label {
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 800;
            color: #64748b;
            letter-spacing: 1px;
        }
        .prime-details {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px dashed #bbf7d0;
            font-size: 14px;
        }
        .footer {
            padding: 30px;
            text-align: center;
            background-color: #f8fafc;
            font-size: 12px;
            color: #94a3b8;
        }
        .btn {
            display: inline-block;
            padding: 14px 28px;
            background-color: #10b981;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 14px;
            transition: all 0.3s;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Paiement Effectué !</h1>
        </div>
        <div class="content">
            <p class="greeting">Bonjour <?php echo e($prime->user->firstName); ?>,</p>
            <p class="message">
                Nous sommes ravis de vous confirmer que votre prime a été payée avec succès. Le montant a été transféré selon nos modalités habituelles de paiement.
            </p>
            
            <div class="prime-card">
                <div class="prime-label">Montant réglé</div>
                <div class="prime-amount"><?php echo e(number_format($prime->montant, 2)); ?> MAD</div>
                
                <div class="prime-details">
                    <strong>Motif :</strong> <?php echo e($prime->motif ?? 'Prime de performance'); ?><br>
                    <strong>Statut actuel :</strong> <span style="color: #059669; font-weight: bold;">Payée</span>
                </div>
            </div>

            <p class="message">
                Merci encore pour votre dévouement et vos efforts constants au sein d'<strong>AccesMorrocco</strong>.
            </p>

            <div style="text-align: center; margin-top: 40px;">
                <a href="<?php echo e(url('/primes')); ?>" class="btn">Consulter mon historique</a>
            </div>
        </div>
        <div class="footer">
            &copy; <?php echo e(date('Y')); ?> AccesMorrocco. Tous droits réservés.<br>
            Ceci est un message automatique, merci de ne pas y répondre.
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\ABA SOLUTIONS\Desktop\PROJET STAGE Travel Agency\AccesMorrocco\resources\views/emails/prime_paid.blade.php ENDPATH**/ ?>