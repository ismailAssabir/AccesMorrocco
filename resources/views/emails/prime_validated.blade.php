<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Prime Validée</title>
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
            background: linear-gradient(135deg, #b11d40 0%, #7c1233 100%);
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
            background-color: #f1f5f9;
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 30px;
            border: 1px solid #e2e8f0;
        }
        .prime-amount {
            font-size: 32px;
            font-weight: 900;
            color: #b11d40;
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
            border-top: 1px dashed #cbd5e1;
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
            background-color: #b11d40;
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
            <h1>Bonne Nouvelle !</h1>
        </div>
        <div class="content">
            <p class="greeting">Bonjour {{ $prime->user->firstName }},</p>
            <p class="message">
                Nous avons le plaisir de vous informer que votre prime a été officiellement validée par la direction. C'est le moment de célébrer votre engagement et votre contribution exceptionnelle à <strong>AccesMorrocco</strong>.
            </p>
            
            <div class="prime-card">
                <div class="prime-label">Montant de la prime</div>
                <div class="prime-amount">{{ number_format($prime->montant, 2) }} MAD</div>
                
                <div class="prime-details">
                    <strong>Motif :</strong> {{ $prime->motif ?? 'Performance exceptionnelle' }}<br>
                    <strong>Date d'attribution :</strong> {{ \Carbon\Carbon::parse($prime->dateAttribution)->format('d/m/Y') }}
                </div>
            </div>

            <p class="message">
                Cette récompense reflète la valeur que vous apportez à notre équipe. Continuez ainsi, votre travail acharné ne passe pas inaperçu !
            </p>

            <div style="text-align: center; margin-top: 40px;">
                <a href="{{ url('/primes') }}" class="btn">Voir mes primes</a>
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} AccesMorrocco. Tous droits réservés.<br>
            Ceci est un message automatique, merci de ne pas y répondre.
        </div>
    </div>
</body>
</html>
