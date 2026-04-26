<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation à une réunion - Access Morocco</title>
    <style>
        /* Base styles for maximum compatibility */
        body {
            margin: 0;
            padding: 0;
            width: 100% !important;
            height: 100% !important;
            background-color: #f8fafc;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        table { border-collapse: collapse; }
        img { border: 0; outline: none; text-decoration: none; }
        
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }
        
        .header {
            padding: 40px 40px 20px 40px;
            text-align: center;
        }
        
        .content {
            padding: 0 40px 40px 40px;
        }
        
        .tag {
            display: inline-block;
            padding: 4px 12px;
            background-color: #fff1f2;
            color: #be2346;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 16px;
        }
        
        h1 {
            color: #0f172a;
            font-size: 28px;
            font-weight: 800;
            margin: 0 0 12px 0;
            letter-spacing: -0.02em;
        }
        
        .objectif {
            color: #be2346;
            font-size: 16px;
            font-weight: 600;
            margin: 0 0 24px 0;
        }
        
        .description {
            color: #64748b;
            font-size: 15px;
            line-height: 1.6;
            margin: 0 0 32px 0;
        }
        
        .info-grid {
            background-color: #f8fafc;
            border-radius: 20px;
            padding: 24px;
            margin-bottom: 32px;
        }
        
        .info-item {
            margin-bottom: 20px;
        }
        .info-item:last-child { margin-bottom: 0; }
        
        .info-label {
            color: #94a3b8;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 4px;
        }
        
        .info-value {
            color: #1e293b;
            font-size: 14px;
            font-weight: 700;
        }
        
        .btn-primary {
            display: block;
            background-color: #be2346;
            color: #ffffff !important;
            padding: 18px 24px;
            text-decoration: none;
            border-radius: 16px;
            font-weight: 800;
            font-size: 14px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            box-shadow: 0 10px 15px -3px rgba(190, 35, 70, 0.3);
        }
        
        .footer {
            padding: 32px 40px;
            text-align: center;
            color: #94a3b8;
            font-size: 12px;
        }
        
        .footer-logo {
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 8px;
            display: block;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header" style="text-align: left;">
            <div style="text-align: center; margin-bottom: 20px;">
                <img src="https://i.ibb.co/Hfm6DJ2Y/access.png" alt="Access Morocco" style="width: 120px; height: auto; border: none; display: block; margin: 0 auto 15px auto;">
                <span style="color: #b11d40; font-size: 20px; font-weight: 800; letter-spacing: 4px; text-transform: uppercase; display: inline-block; font-family: 'Inter', sans-serif;">
                    ACCESS MOROCCO
                </span>
            </div>
            <div style="text-align: center; margin-bottom: 30px;">
                <div class="tag" style="margin-bottom: 0;">Invitation à une réunion</div>
            </div>
            <h1 style="margin: 0; margin-bottom: 8px; text-align: left; color: #0f172a; font-size: 28px; font-weight: 800;">{{ $reunion->titre }}</h1>
            <p class="objectif" style="margin: 0; text-align: left; color: #be2346; font-size: 16px; font-weight: 600;">{{ $reunion->objectif }}</p>
        </div>
        
        <div class="content">
            @if($reunion->description)
                <p class="description">{{ $reunion->description }}</p>
            @endif
            
            <div class="info-grid">
                <table role="presentation" width="100%">
                    <tr>
                        <td style="padding-bottom: 20px;">
                            <div class="info-label">📅 Date & Heure</div>
                            <div class="info-value" style="color: #1e293b; font-size: 15px;">
                                {{ \Carbon\Carbon::parse($reunion->dateHeure)->translatedFormat('l d F Y') }} à {{ \Carbon\Carbon::parse($reunion->dateHeure)->format('H:i') }}
                                @if($reunion->heureFin)
                                    - {{ \Carbon\Carbon::parse($reunion->heureFin)->format('H:i') }}
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 20px;">
                            <div class="info-label">📍 Lieu</div>
                            <div class="info-value" style="color: #1e293b; font-size: 15px;">
                                @if($reunion->lieu)
                                    {{ $reunion->lieu }}
                                @elseif($reunion->type === 'Interne')
                                    Enterprise
                                @elseif($reunion->type === 'Externe')
                                    Meeting online
                                @else
                                    Visioconférence
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="info-label">🏷️ Type</div>
                            <div class="info-value" style="color: #1e293b; font-size: 15px;">{{ $reunion->type }}</div>
                        </td>
                    </tr>
                </table>
            </div>

            @if($reunion->lien)
                <a href="{{ str_starts_with($reunion->lien, 'http') ? $reunion->lien : 'https://' . $reunion->lien }}" class="btn-primary">
                    Rejoindre la réunion
                </a>
            @else
                <a href="{{ config('app.url') }}/reunions/{{ $reunion->idReunion }}" class="btn-primary">
                    Voir les détails
                </a>
            @endif
        </div>
        <div class="footer">
            <span class="footer-logo">Access Morocco</span>
            
            <!-- Footer Action -->
            <div style="margin: 20px 0; text-align: center;">
                <a href="{{ config('app.url') }}/reunions/{{ $reunion->idReunion }}" 
                   style="display: inline-block; background-color: #f1f5f9; color: #475569; padding: 12px 24px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; border: 1px solid #e2e8f0;">
                    Ouvrir dans l'application
                </a>
            </div>

            <p style="font-size: 12px; color: #94a3b8; text-align: center; line-height: 1.5; margin-bottom: 24px;">
                Pour accepter ou décliner cette invitation, merci d'utiliser le bouton ci-dessus ou de vous connecter à votre portail.
            </p>

            <table role="presentation" width="100%" style="border-top: 1px solid #f1f5f9; padding-top: 24px;">
                <tr>
                    <td style="text-align: center; color: #cbd5e1; font-size: 11px; font-weight: 500;">
                        &copy; {{ date('Y') }} Access Morocco Travel Agency. Tous droits réservés.
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
