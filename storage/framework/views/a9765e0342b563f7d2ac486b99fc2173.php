<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background: #F8FAFC; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: white; border-radius: 24px; overflow: hidden; border: 1px solid #E2E8F0; }
        .header { background: linear-gradient(135deg, #b11d40, #7c1233); padding: 40px; text-align: center; }
        .header h1 { color: white; font-size: 24px; font-weight: 800; margin: 0; }
        .header p { color: rgba(255,255,255,0.7); font-size: 14px; margin: 8px 0 0; }
        .body { padding: 40px; }
        .greeting { font-size: 18px; font-weight: 700; color: #0F172A; margin-bottom: 16px; }
        .text { color: #64748B; font-size: 14px; line-height: 1.6; margin-bottom: 24px; }
        .credentials { background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px; margin-bottom: 24px; }
        .cred-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #E2E8F0; }
        .cred-row:last-child { border-bottom: none; }
        .cred-label { font-size: 12px; font-weight: 700; text-transform: uppercase; color: #94A3B8; letter-spacing: 0.5px; }
        .cred-value { font-size: 14px; font-weight: 700; color: #0F172A; }
        .password-value { font-family: monospace; font-size: 16px; font-weight: 800; color: #b11d40; background: #fff0f3; padding: 4px 12px; border-radius: 8px; }
        .btn { display: block; text-align: center; background: linear-gradient(135deg, #b11d40, #7c1233); color: white; text-decoration: none; padding: 16px 32px; border-radius: 16px; font-weight: 700; font-size: 15px; margin: 24px 0; }
        .warning { background: #FFF7ED; border: 1px solid #FED7AA; border-radius: 12px; padding: 16px; font-size: 13px; color: #92400E; }
        .footer { background: #F8FAFC; padding: 24px 40px; text-align: center; border-top: 1px solid #E2E8F0; }
        .footer p { color: #94A3B8; font-size: 12px; margin: 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🌍 Access Morocco</h1>
            <p>Votre espace client est prêt</p>
        </div>

        <div class="body">
            <p class="greeting">Bonjour <?php echo e($client->firstName); ?> <?php echo e($client->lastName); ?> 👋</p>

            <p class="text">
                Votre dossier a été créé avec succès. Vous pouvez maintenant accéder à votre espace client pour suivre vos voyages, consulter vos documents et vérifier vos paiements.
            </p>

            <div class="credentials">
                <div class="cred-row">
                    <span class="cred-label">Email</span>
                    <span class="cred-value"><?php echo e($client->email); ?></span>
                </div>
                <div class="cred-row">
                    <span class="cred-label">Mot de passe</span>
                    <span class="password-value"><?php echo e($password); ?></span>
                </div>
            </div>

            <a href="<?php echo e(url('/client/login')); ?>" class="btn">
                Accéder à mon espace →
            </a>

            <div class="warning">
                ⚠️ Pour votre sécurité, nous vous recommandons de changer votre mot de passe lors de votre première connexion.
            </div>
        </div>

        <div class="footer">
            <p>&copy; <?php echo e(date('Y')); ?> Access Morocco. Tous droits réservés.</p>
            <p style="margin-top:8px">Si vous n'êtes pas à l'origine de cette demande, ignorez cet email.</p>
        </div>
    </div>
</body>
</html><?php /**PATH C:\Users\4B\Desktop\ExercicesLaravel\voyage\resources\views/emails/client-created.blade.php ENDPATH**/ ?>