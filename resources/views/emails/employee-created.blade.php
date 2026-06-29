<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue chez Access Morocco</title>
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
                        <td style="height:4px; background:linear-gradient(90deg, #be2346 0%, #e8445a 40%, #ff6b8a 70%, #be2346 100%); border-radius:12px 12px 0 0; font-size:0; line-height:0;">&nbsp;</td>
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
                                                    <td style="width:72px; height:72px; background:linear-gradient(135deg,#be2346 0%,#8b1a33 100%); background-color:#be2346; border-radius:20px; text-align:center; vertical-align:middle; font-size:28px; font-weight:900; color:#ffffff; letter-spacing:-2px;">
                                                        AM
                                                    </td>
                                                </tr>
                                            </table>
                                        @endif

                                        <h1 style="color:#1e293b; font-size:26px; font-weight:800; letter-spacing:-0.8px; margin:0 0 8px; line-height:1.2;">Bienvenue dans l'Équipe!</h1>
                                        <p style="color:#64748b; font-size:14px; font-weight:500; margin:0;">Votre compte Access Morocco est prêt</p>
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
                                            Nous sommes ravis de vous accueillir au sein d'<span style="color:#0f172a; font-weight:600;">Access Morocco</span>. Votre compte collaborateur a été créé avec succès et vous pouvez désormais accéder à l'ensemble de nos outils et services internes.
                                        </p>

                                        <!-- ═══ CREDENTIALS CARD ═══ -->
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#fdf2f4; border:1px solid #fce7ec; border-radius:20px; margin-bottom:32px; overflow:hidden;">
                                            <!-- Top line -->
                                            <tr>
                                                <td style="height:2px; background:linear-gradient(90deg,#be2346,#ff6b8a,#be2346); font-size:0; line-height:0;">&nbsp;</td>
                                            </tr>
                                            <!-- Card label -->
                                            <tr>
                                                <td style="padding:28px 32px 0;">
                                                    <p style="font-size:10px; text-transform:uppercase; font-weight:800; color:#be2346; letter-spacing:2px; margin:0 0 20px;">
                                                        ● &nbsp;Vos identifiants de connexion
                                                    </p>
                                                </td>
                                            </tr>
                                            <!-- Email row -->
                                            <tr>
                                                <td style="padding:0 32px;">
                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                        <tr>
                                                            <td style="padding:16px 0; border-bottom:1px solid rgba(190,35,70,0.1);">
                                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                    <tr>
                                                                        <td style="font-size:12px; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:0.8px; width:120px; vertical-align:middle;">Email</td>
                                                                        <td align="right" style="vertical-align:middle;">
                                                                            <span style="font-size:15px; font-weight:700; color:#0f172a; background-color:#ffffff; border:1px solid #fce7ec; padding:8px 16px; border-radius:10px; font-family:'Cascadia Code','Fira Code',monospace; display:inline-block;">{{ $user->email }}</span>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- Password row -->
                                            <tr>
                                                <td style="padding:0 32px 28px;">
                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                        <tr>
                                                            <td style="padding:16px 0 0;">
                                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                    <tr>
                                                                        <td style="font-size:12px; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:0.8px; width:120px; vertical-align:middle;">Mot de passe</td>
                                                                        <td align="right" style="vertical-align:middle;">
                                                                            <span style="font-size:15px; font-weight:700; color:#0f172a; background-color:#ffffff; border:1px solid #fce7ec; padding:8px 16px; border-radius:10px; font-family:'Cascadia Code','Fira Code',monospace; display:inline-block;">{{ $password }}</span>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- ═══ INFO GRID ═══ -->
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:32px;">
                                            <tr>
                                                <!-- Poste -->
                                                <td width="33%" style="padding-right:6px; vertical-align:top;">
                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f8fafc; border:1px solid #e2e8f0; border-radius:16px;">
                                                        <tr>
                                                            <td align="center" style="padding:20px 12px;">
                                                                <p style="font-size:10px; text-transform:uppercase; font-weight:700; color:#64748b; letter-spacing:1px; margin:0 0 8px;">Poste</p>
                                                                <p style="font-size:14px; font-weight:800; color:#0f172a; margin:0;">{{ $user->post ?? '—' }}</p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <!-- Département -->
                                                <td width="34%" style="padding:0 6px; vertical-align:top;">
                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f8fafc; border:1px solid #e2e8f0; border-radius:16px;">
                                                        <tr>
                                                            <td align="center" style="padding:20px 12px;">
                                                                <p style="font-size:10px; text-transform:uppercase; font-weight:700; color:#64748b; letter-spacing:1px; margin:0 0 8px;">Département</p>
                                                                <p style="font-size:14px; font-weight:800; color:#0f172a; margin:0;">{{ $user->departement->title ?? '—' }}</p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <!-- Contrat -->
                                                <td width="33%" style="padding-left:6px; vertical-align:top;">
                                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f8fafc; border:1px solid #e2e8f0; border-radius:16px;">
                                                        <tr>
                                                            <td align="center" style="padding:20px 12px;">
                                                                <p style="font-size:10px; text-transform:uppercase; font-weight:700; color:#64748b; letter-spacing:1px; margin:0 0 8px;">Contrat</p>
                                                                <p style="font-size:14px; font-weight:800; color:#0f172a; margin:0;">{{ $user->typeContrat ?? '—' }}</p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- ═══ SECURITY NOTICE ═══ -->
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#fffbeb; border:1px solid #fde68a; border-radius:14px; margin-bottom:32px;">
                                            <tr>
                                                <td style="padding:20px 24px;">
                                                    <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                                        <tr>
                                                            <td valign="top" style="width:46px; padding-right:14px;">
                                                                <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                                                    <tr>
                                                                        <td style="width:32px; height:32px; background-color:#fef3c7; border-radius:10px; text-align:center; vertical-align:middle; font-size:16px;">🔒</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td valign="top" style="font-size:13px; color:#92400e; line-height:1.5; font-weight:500;">
                                                                Pour des raisons de sécurité, nous vous recommandons fortement de modifier votre mot de passe lors de votre première connexion.
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
                                                    <a href="{{ url('/login') }}" style="display:inline-block; padding:16px 40px; background:linear-gradient(135deg,#be2346 0%,#d42d54 100%); background-color:#be2346; color:#ffffff; text-decoration:none; border-radius:14px; font-weight:800; font-size:14px; letter-spacing:-0.2px;">Se connecter maintenant →</a>
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
