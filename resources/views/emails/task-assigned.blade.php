<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle tâche assignée — Access Morocco</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f7fc; font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif; -webkit-font-smoothing:antialiased;">

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f4f7fc;">
        <tr>
            <td align="center" style="padding:40px 20px;">

                <table role="presentation" width="640" cellpadding="0" cellspacing="0" border="0" style="max-width:640px; width:100%;">

                    <!-- ACCENT BAR (Blue) -->
                    <tr>
                        <td style="height:4px; background:linear-gradient(90deg, #2563eb 0%, #3b82f6 40%, #60a5fa 70%, #2563eb 100%); background-color:#3b82f6; border-radius:12px 12px 0 0; font-size:0; line-height:0;">&nbsp;</td>
                    </tr>

                    <!-- CONTAINER -->
                    <tr>
                        <td style="background-color:#ffffff; border:1px solid #e2e8f0; border-top:none; border-radius:0 0 24px 24px;">

                            <!-- HEADER with Logo -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center" style="padding:50px 48px 35px; border-bottom:1px solid #f1f5f9;">

                                        @if(isset($message) && file_exists(public_path('images/logo.png')))
                                            <img src="{{ $message->embed(public_path('images/logo.png')) }}" alt="Access Morocco" style="height:52px; width:auto; margin-bottom:24px; display:block; margin-left:auto; margin-right:auto; background:#fff; padding:8px 15px; border-radius:40px;">
                                        @else
                                            <img src="{{ asset('images/logo.png') }}" alt="Access Morocco" style="height:52px; width:auto; margin-bottom:24px; display:block; margin-left:auto; margin-right:auto; background:#fff; padding:8px 15px; border-radius:40px;">
                                        @endif

                                        <div style="display:inline-block; padding:6px 14px; background-color:#eff6ff; color:#2563eb; border-radius:100px; font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:1px; margin-bottom:16px;">
                                            Nouvelle tâche
                                        </div>
                                        <h1 style="color:#1e293b; font-size:26px; font-weight:800; letter-spacing:-0.8px; margin:0 0 8px; line-height:1.2;">{{ $tache->titre }}</h1>
                                    </td>
                                </tr>
                            </table>

                            <!-- CONTENT -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="padding:40px 48px;">

                                        <p style="font-size:18px; font-weight:700; color:#0f172a; margin:0 0 16px;">Bonjour {{ $user->firstName }},</p>

                                        <p style="line-height:1.7; margin:0 0 32px; font-size:14.5px; color:#475569;">
                                            Une nouvelle tâche vous a été assignée sur la plateforme <span style="color:#0f172a; font-weight:600;">Access Morocco</span>. Vous trouverez ci-dessous les détails de cette mission.
                                        </p>

                                        <!-- TASK INFO CARD -->
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f8fafc; border:1px solid #e2e8f0; border-radius:20px; margin-bottom:32px; overflow:hidden;">
                                            <tr>
                                                <td style="padding:28px 32px;">
                                                    <p style="font-size:10px; text-transform:uppercase; font-weight:800; color:#3b82f6; letter-spacing:2px; margin:0 0 20px;">
                                                        ● &nbsp;Détails de la tâche
                                                    </p>

                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                        
                                                        <!-- Priorité -->
                                                        <tr>
                                                            <td style="padding:12px 0; border-bottom:1px solid #e2e8f0;">
                                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                    <tr>
                                                                        <td style="font-size:12px; font-weight:700; color:#64748b; width:120px; vertical-align:top;">Priorité</td>
                                                                        <td align="right" style="vertical-align:top;">
                                                                            @if($tache->priorite == 'haute')
                                                                                <span style="color:#ef4444; font-weight:800;">🔴 Haute</span>
                                                                            @elseif($tache->priorite == 'moyenne')
                                                                                <span style="color:#f59e0b; font-weight:800;">🟡 Moyenne</span>
                                                                            @else
                                                                                <span style="color:#10b981; font-weight:800;">🟢 Basse</span>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>

                                                        <!-- Date -->
                                                        <tr>
                                                            <td style="padding:12px 0; border-bottom:1px solid #e2e8f0;">
                                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                    <tr>
                                                                        <td style="font-size:12px; font-weight:700; color:#64748b; width:120px; vertical-align:top;">Échéance</td>
                                                                        <td align="right" style="font-size:14px; font-weight:700; color:#0f172a; vertical-align:top;">
                                                                            @if($tache->dateDebut)
                                                                                {{ \Carbon\Carbon::parse($tache->dateDebut)->format('d/m/Y') }} 
                                                                                @if($tache->duree)
                                                                                    → {{ \Carbon\Carbon::parse($tache->duree)->format('d/m/Y') }}
                                                                                @endif
                                                                            @else
                                                                                Non définie
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>

                                                        <!-- Statut -->
                                                        <tr>
                                                            <td style="padding:12px 0; {{ $tache->description ? 'border-bottom:1px solid #e2e8f0;' : '' }}">
                                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                    <tr>
                                                                        <td style="font-size:12px; font-weight:700; color:#64748b; width:120px; vertical-align:top;">Statut</td>
                                                                        <td align="right" style="font-size:14px; font-weight:700; color:#0f172a; vertical-align:top;">
                                                                            {{ ucfirst(str_replace('_', ' ', $tache->status)) }}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>

                                                        <!-- Description -->
                                                        @if($tache->description)
                                                        <tr>
                                                            <td style="padding:16px 0 0;">
                                                                <div style="font-size:12px; font-weight:700; color:#64748b; margin-bottom:8px;">Description</div>
                                                                <div style="font-size:13px; color:#475569; line-height:1.6; background-color:#ffffff; padding:12px 16px; border-radius:10px; border:1px solid #e2e8f0;">
                                                                    {{ $tache->description }}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @endif

                                                    </table>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- CTA BUTTON -->
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td align="center" style="padding:8px 0 0;">
                                                    <a href="{{ url('/taches') }}" style="display:inline-block; padding:16px 40px; background:linear-gradient(135deg,#2563eb 0%,#1d4ed8 100%); background-color:#2563eb; color:#ffffff; text-decoration:none; border-radius:14px; font-weight:800; font-size:14px; letter-spacing:-0.2px;">Voir mes tâches →</a>
                                                </td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                            </table>

                            <!-- FOOTER -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center" style="padding:32px 48px; border-top:1px solid #f1f5f9;">
                                        <p style="font-size:13px; font-weight:800; color:#94a3b8; letter-spacing:-0.3px; margin:0 0 6px;">ACCESS MOROCCO</p>
                                        <p style="color:#cbd5e1; letter-spacing:6px; font-size:10px; margin:0 0 6px;">• • •</p>
                                        <p style="font-size:11px; color:#94a3b8; line-height:1.6; margin:0;">
                                            &copy; {{ date('Y') }} Access Morocco. Tous droits réservés.<br>
                                            Ceci est un message automatique, merci de ne pas y répondre.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

</body>
</html>
