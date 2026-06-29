<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Mis à Jour — Access Morocco</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f7fc; font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif; -webkit-font-smoothing:antialiased;">

    <!-- Wrapper table for full email clients compatibility -->
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f4f7fc;">
        <tr>
            <td align="center" style="padding:40px 20px;">

                <!-- Main container -->
                <table role="presentation" width="640" cellpadding="0" cellspacing="0" border="0" style="max-width:640px; width:100%;">

                    <!-- ═══ ACCENT BAR ═══ -->
                    <tr>
                        <td style="height:4px; background:linear-gradient(90deg, #6366f1 0%, #8b5cf6 40%, #a78bfa 70%, #6366f1 100%); background-color:#6366f1; border-radius:12px 12px 0 0; font-size:0; line-height:0;">&nbsp;</td>
                    </tr>

                    <!-- ═══ CONTAINER ═══ -->
                    <tr>
                        <td style="background-color:#ffffff; border:1px solid #e2e8f0; border-top:none; border-radius:0 0 24px 24px;">

                            <!-- ─── HEADER with Logo ─── -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center" style="padding:50px 48px 35px; border-bottom:1px solid #f1f5f9;">

                                        <!-- Logo -->
                                        @if(file_exists(public_path('images/logo.png')))
                                            <img src="{{ $message->embed(public_path('images/logo.png')) }}" alt="Access Morocco" style="height:52px; width:auto; margin-bottom:24px; display:block; margin-left:auto; margin-right:auto;">
                                        @else
                                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="margin:0 auto 24px;">
                                                <tr>
                                                    <td style="width:72px; height:72px; background:linear-gradient(135deg,#6366f1 0%,#4338ca 100%); background-color:#6366f1; border-radius:20px; text-align:center; vertical-align:middle; font-size:28px; font-weight:900; color:#ffffff; letter-spacing:-2px;">
                                                        AM
                                                    </td>
                                                </tr>
                                            </table>
                                        @endif

                                        <h1 style="color:#1e293b; font-size:26px; font-weight:800; letter-spacing:-0.8px; margin:0 0 8px; line-height:1.2;">Profil Mis à Jour</h1>
                                        <p style="color:#64748b; font-size:14px; font-weight:500; margin:0;">Des modifications ont été apportées à votre compte</p>
                                    </td>
                                </tr>
                            </table>

                            <!-- ─── CONTENT ─── -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="padding:40px 48px;">

                                        <!-- Greeting -->
                                        <p style="font-size:18px; font-weight:700; color:#0f172a; margin:0 0 16px;">Bonjour {{ $user->firstName }} {{ $user->lastName }},</p>

                                        <!-- Message -->
                                        <p style="line-height:1.7; margin:0 0 32px; font-size:14.5px; color:#475569;">
                                            Nous vous informons que votre profil collaborateur chez <span style="color:#0f172a; font-weight:600;">Access Morocco</span> a été mis à jour. Voici le détail des modifications effectuées :
                                        </p>

                                        <!-- ═══ TIMESTAMP ═══ -->
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:32px;">
                                            <tr>
                                                <td align="center">
                                                    <span style="display:inline-block; background-color:#f8fafc; border:1px solid #e2e8f0; padding:10px 20px; border-radius:12px; font-size:12px; font-weight:600; color:#64748b;">
                                                        🕐 Mis à jour le <span style="color:#0f172a; font-weight:700;">{{ now()->format('d/m/Y à H:i') }}</span>
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- ═══ CHANGES CARD ═══ -->
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f5f3ff; border:1px solid #ede9fe; border-radius:20px; margin-bottom:32px; overflow:hidden;">
                                            <!-- Top line -->
                                            <tr>
                                                <td style="height:2px; background:linear-gradient(90deg,#6366f1,#a78bfa,#6366f1); background-color:#6366f1; font-size:0; line-height:0;">&nbsp;</td>
                                            </tr>
                                            <!-- Card label -->
                                            <tr>
                                                <td style="padding:28px 32px 20px;">
                                                    <p style="font-size:10px; text-transform:uppercase; font-weight:800; color:#6366f1; letter-spacing:2px; margin:0;">
                                                        ● &nbsp;Modifications apportées
                                                    </p>
                                                </td>
                                            </tr>

                                            @php
                                                $fieldLabels = [
                                                    'firstName'     => 'Prénom',
                                                    'lastName'      => 'Nom',
                                                    'email'         => 'Email',
                                                    'cin'           => 'CIN',
                                                    'birthday'      => 'Date de naissance',
                                                    'address'       => 'Adresse',
                                                    'phoneNumber'   => 'Téléphone',
                                                    'typeContrat'   => 'Type de contrat',
                                                    'salaire'       => 'Salaire',
                                                    'post'          => 'Poste',
                                                    'dateEmb'       => "Date d'embauche",
                                                    'idDepartement' => 'Département',
                                                    'status'        => 'Statut',
                                                    'type'          => 'Rôle',
                                                    'rip'           => 'RIP',
                                                    'password'      => 'Mot de passe',
                                                ];
                                            @endphp

                                            <!-- Change rows -->
                                            @foreach($changes as $field => $change)
                                            <tr>
                                                <td style="padding:0 32px {{ $loop->last ? '28px' : '0' }};">
                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:{{ $loop->last ? '0' : '12px' }};">
                                                        <tr>
                                                            <!-- Timeline dot -->
                                                            <td valign="top" style="width:32px; padding-right:12px;">
                                                                <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                                                    <tr>
                                                                        <td style="padding-top:14px;">
                                                                            <div style="width:10px; height:10px; background-color:#6366f1; border-radius:50%; margin:0 auto;"></div>
                                                                        </td>
                                                                    </tr>
                                                                    @if(!$loop->last)
                                                                    <tr>
                                                                        <td align="center" style="padding-top:4px;">
                                                                            <div style="width:2px; height:30px; background-color:#e0e7ff; margin:0 auto;"></div>
                                                                        </td>
                                                                    </tr>
                                                                    @endif
                                                                </table>
                                                            </td>
                                                            <!-- Change content -->
                                                            <td style="background-color:#ffffff; border:1px solid #ede9fe; border-radius:14px; padding:16px 20px;">
                                                                <p style="font-size:11px; font-weight:700; color:#6366f1; text-transform:uppercase; letter-spacing:0.8px; margin:0 0 10px;">{{ $fieldLabels[$field] ?? $field }}</p>
                                                                <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                                                    <tr>
                                                                        @if($field === 'password')
                                                                            <td style="font-size:14px; font-weight:500; color:#94a3b8; text-decoration:line-through; background-color:#f8fafc; padding:4px 12px; border-radius:8px;">••••••••</td>
                                                                            <td style="color:#cbd5e1; font-size:16px; padding:0 12px;">→</td>
                                                                            <td style="font-size:14px; font-weight:700; color:#0f172a; background-color:#eef2ff; padding:4px 12px; border-radius:8px;">Nouveau mot de passe défini</td>
                                                                        @elseif($field === 'salaire')
                                                                            <td style="font-size:14px; font-weight:500; color:#94a3b8; text-decoration:line-through; background-color:#f8fafc; padding:4px 12px; border-radius:8px;">{{ number_format($change['old'] ?? 0, 2) }} MAD</td>
                                                                            <td style="color:#cbd5e1; font-size:16px; padding:0 12px;">→</td>
                                                                            <td style="font-size:14px; font-weight:700; color:#0f172a; background-color:#eef2ff; padding:4px 12px; border-radius:8px;">{{ number_format($change['new'] ?? 0, 2) }} MAD</td>
                                                                        @else
                                                                            <td style="font-size:14px; font-weight:500; color:#94a3b8; text-decoration:line-through; background-color:#f8fafc; padding:4px 12px; border-radius:8px;">{{ $change['old'] ?? '—' }}</td>
                                                                            <td style="color:#cbd5e1; font-size:16px; padding:0 12px;">→</td>
                                                                            <td style="font-size:14px; font-weight:700; color:#0f172a; background-color:#eef2ff; padding:4px 12px; border-radius:8px;">{{ $change['new'] ?? '—' }}</td>
                                                                        @endif
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </table>

                                        <!-- ═══ INFO NOTICE ═══ -->
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#eff6ff; border:1px solid #bfdbfe; border-radius:14px; margin-bottom:32px;">
                                            <tr>
                                                <td style="padding:20px 24px;">
                                                    <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                                        <tr>
                                                            <td valign="top" style="width:46px; padding-right:14px;">
                                                                <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                                                    <tr>
                                                                        <td style="width:32px; height:32px; background-color:#dbeafe; border-radius:10px; text-align:center; vertical-align:middle; font-size:16px;">ℹ️</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td valign="top" style="font-size:13px; color:#1e40af; line-height:1.5; font-weight:500;">
                                                                Si vous n'êtes pas à l'origine de ces modifications ou si vous constatez une erreur, veuillez contacter immédiatement votre responsable ou l'administration RH.
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- ═══ CTA BUTTON ═══ -->
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td align="center" style="padding:8px 0 0;">
                                                    <a href="{{ url('/login') }}" style="display:inline-block; padding:16px 40px; background:linear-gradient(135deg,#6366f1 0%,#7c3aed 100%); background-color:#6366f1; color:#ffffff; text-decoration:none; border-radius:14px; font-weight:800; font-size:14px; letter-spacing:-0.2px;">Consulter mon profil →</a>
                                                </td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                            </table>

                            <!-- ─── FOOTER ─── -->
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
