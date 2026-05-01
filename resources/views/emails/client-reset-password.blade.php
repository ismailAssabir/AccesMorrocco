<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background: #F8FAFC; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: white; border-radius: 24px; overflow: hidden; border: 1px solid #E2E8F0; }
        .header { background: linear-gradient(135deg, #b11d40, #7c1233); padding: 40px; text-align: center; }
        .header h1 { color: white; font-size: 22px; font-weight: 800; margin: 0; }
        .body { padding: 40px; }
        .text { color: #64748B; font-size: 14px; line-height: 1.6; margin-bottom: 24px; }
        .btn { display: block; text-align: center; background: linear-gradient(135deg, #b11d40, #7c1233); color: white; text-decoration: none; padding: 16px 32px; border-radius: 16px; font-weight: 700; font-size: 15px; margin: 24px 0; }
        .warning { background: #FFF7ED; border: 1px solid #FED7AA; border-radius: 12px; padding: 16px; font-size: 13px; color: #92400E; }
        .footer { background: #F8FAFC; padding: 24px 40px; text-align: center; border-top: 1px solid #E2E8F0; }
        .footer p { color: #94A3B8; font-size: 12px; margin: 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔐 Access Morocco</h1>
        </div>
        <div class="body">
            <p class="text">Vous avez demandé la réinitialisation de votre mot de passe. Cliquez sur le bouton ci-dessous pour en définir un nouveau.</p>
            <a href="{{ $resetUrl }}" class="btn">Réinitialiser mon mot de passe →</a>
            <div class="warning">
                ⚠️ Ce lien expire dans <strong>60 minutes</strong>. Si vous n'avez pas demandé cette réinitialisation, ignorez cet email.
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Access Morocco. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>