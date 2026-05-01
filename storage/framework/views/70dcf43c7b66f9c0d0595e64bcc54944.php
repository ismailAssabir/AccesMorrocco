<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue sur Access Morocco</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f7fc;
            font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
        }
        .container {
            max-width: 580px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            border: 1px solid #e6edf2;
        }
        .header {
            background: linear-gradient(135deg, #0057a3 0%, #003f73 100%);
            padding: 30px 20px;
            text-align: center;
        }
        .logo {
            max-width: 130px;
            margin-bottom: 12px;
        }
        .app-name {
            font-size: 28px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 1px;
            margin: 8px 0 0;
            font-family: inherit;
        }
        .app-tagline {
            color: #d4e3ff;
            font-size: 14px;
            margin-top: 5px;
        }
        .content {
            padding: 32px 30px;
            background: #fff;
        }
        h2 {
            color: #003f73;
            font-size: 24px;
            margin-top: 0;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .highlight {
            background: #f0f7fe;
            padding: 18px 20px;
            border-radius: 16px;
            margin: 20px 0;
            border-left: 4px solid #0057a3;
        }
        .info-row {
            margin: 12px 0;
            font-size: 16px;
        }
        .info-label {
            font-weight: 700;
            color: #1e4663;
            min-width: 85px;
            display: inline-block;
        }
        .info-value {
            color: #2c3e50;
        }
        .btn {
            display: inline-block;
            background: #0057a3;
            color: white !important;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0 10px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(0,87,163,0.2);
        }
        .btn:hover {
            background: #003f73;
            transform: translateY(-1px);
        }
        .alert-box {
            background: #fff5f0;
            border-left: 4px solid #e67e22;
            padding: 15px 18px;
            border-radius: 12px;
            margin-top: 28px;
            margin-bottom: 10px;
        }
        .alert-text {
            color: #c0392b;
            font-weight: 500;
            margin: 0;
            font-size: 14px;
        }
        hr {
            margin: 25px 0;
            border: none;
            height: 1px;
            background: #e2e8f0;
        }
        .footer {
            background: #f9fbfd;
            padding: 20px 30px;
            text-align: center;
            font-size: 12px;
            color: #7f8c8d;
            border-top: 1px solid #eef2f5;
        }
        .footer a {
            color: #0057a3;
            text-decoration: none;
        }
        @media (max-width: 600px) {
            .content {
                padding: 24px 20px;
            }
            .btn {
                display: block;
                text-align: center;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <!-- EN-TÊTE AVEC LOGO + NOM APP -->
    <div class="header">
        <img src="https://via.placeholder.com/140x60?text=Access+Morocco+Logo" alt="Access Morocco" class="logo" style="background:#fff; padding:8px 15px; border-radius:40px;">
        <!-- 
            ⚠️ Remplacez l'URL placeholder par votre vrai logo hébergé (PNG/SVG).
            Exemple : https://www.accesmorocco.com/logo.png 
        -->
        <div class="app-name">Access Morocco</div>
        <div class="app-tagline">Votre accès simplifié aux services</div>
    </div>

    <!-- CORPS PRINCIPAL -->
    <div class="content">
        <h2>Bienvenue <?php echo e($client->firstName); ?> 👋</h2>
        <p style="font-size:16px; color:#2d3748;">Votre compte a été créé avec succès. Vous pouvez dès à présent accéder à votre espace personnel.</p>

        <!-- INFOS COMPTE (mises en valeur) -->
        <div class="highlight">
            <div class="info-row">
                <span class="info-label">📧 Email :</span>
                <span class="info-value"><?php echo e($client->email); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">🔒 Mot de passe :</span>
                <span class="info-value"><?php echo e($password); ?></span>
            </div>
        </div>

        <!-- BOUTON CONNEXION -->
        <div style="text-align: center;">
            <a href="<?php echo e(url('/clients/login')); ?>" class="btn">
                🔑 Accéder à l'application
            </a>
        </div>

        <!-- ALERTE SÉCURITÉ -->
        <div class="alert-box">
            <p class="alert-text">
                ⚠️ <strong>Consigne de sécurité :</strong> Merci de changer votre mot de passe après votre première connexion.
            </p>
        </div>

        <hr>
        <p style="font-size:13px; color:#6c7a89; margin-bottom:0;">
            Cet email a été généré automatiquement. Si vous n'êtes pas à l'origine de cette création, veuillez ignorer ce message.
        </p>
    </div>

    <!-- PIED DE PAGE -->
    <div class="footer">
        © <?php echo e(date('Y')); ?> Access Morocco — Tous droits réservés.<br>
        <a href="#">Centre d'aide</a> &nbsp;|&nbsp;
        <a href="#">Politique de confidentialité</a>
    </div>
</div>
</body>
</html><?php /**PATH C:\Users\4B\Desktop\ExercicesLaravel\voyage\resources\views/emails/client-welcome.blade.php ENDPATH**/ ?>