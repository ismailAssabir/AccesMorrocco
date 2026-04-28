<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport de Pointage</title>
    <style>
        body { font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif; color: #222; line-height: 1.4; margin: 0; padding: 0; font-size: 11px; }
        @page { margin: 40px; }
        table { width: 100%; border-collapse: collapse; }
        .header { width: 100%; border-bottom: 2px solid #b11d40; padding-bottom: 15px; margin-bottom: 25px; }
        .header td { border: none; padding: 0; }
        .logo { max-height: 45px; }
        .company-name { font-size: 20px; font-weight: bold; color: #333; margin-bottom: 3px; }
        .company-subtitle { font-size: 11px; color: #777; }
        .report-title { font-size: 18px; font-weight: bold; text-align: center; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1px; color: #111; }
        .meta-box { border: 1px solid #ddd; padding: 12px; margin-bottom: 25px; background-color: #fafafa; }
        .meta-table { width: 100%; }
        .meta-table td { font-size: 10px; padding: 4px 8px; border: none; vertical-align: top; }
        .meta-table strong { color: #555; display: block; margin-bottom: 3px; text-transform: uppercase; font-size: 9px; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .data-table th, .data-table td { border: 1px solid #ccc; padding: 8px 6px; text-align: left; vertical-align: middle; }
        .data-table th { background-color: #f4f4f4; font-weight: bold; font-size: 10px; text-transform: uppercase; color: #333; }
        .data-table tr:nth-child(even) { background-color: #fcfcfc; }
        .footer { position: fixed; bottom: -20px; left: 0; right: 0; text-align: center; font-size: 9px; color: #888; border-top: 1px solid #ddd; padding-top: 8px; }
        .pagenum:before { content: counter(page); }
        .status { font-weight: bold; }
        .status-present { color: #2e7d32; }
        .status-retard { color: #ed6c02; }
        .status-absent { color: #d32f2f; }
        .text-center { text-align: center; }
        .emp-email { font-size: 9px; color: #666; margin-top: 2px; display: block; }
        .justif-text { font-size: 9px; color: #444; }
    </style>
</head>
<body>
    <table class="header">
        <tr>
            <td width="50%" style="vertical-align: middle;">
                @if(file_exists(public_path('images/logo.png')))
                    <img src="{{ str_replace('\\', '/', public_path('images/logo.png')) }}" class="logo">
                @else
                    <span style="font-size: 22px; font-weight: bold; color: #b11d40;">ACCESS MOROCCO</span>
                @endif
            </td>
            <td width="50%" style="text-align: right; vertical-align: middle;">
                <div class="company-name">Access Morocco</div>
                <div class="company-subtitle">Système de Gestion des Présences</div>
                <div class="company-subtitle">Généré le: {{ $date }}</div>
            </td>
        </tr>
    </table>

    <div class="report-title">Rapport de Pointage</div>

    <div class="meta-box">
        <table class="meta-table">
            <tr>
                <td width="30%">
                    <strong>Période du Rapport</strong>
                    {{ ucfirst($filters['period']) }} 
                    @if($filters['start']) 
                        <br><span style="color: #666; font-size: 9px;">({{ $filters['start'] }} — {{ $filters['end'] }})</span>
                    @endif
                </td>
                <td width="30%">
                    <strong>Filtres Actifs</strong>
                    Rôle : {{ ucfirst($filters['role'] ?: 'Tous') }}<br>
                    Statut : {{ ucfirst($filters['status'] ?: 'Tous') }}<br>
                    Justificatif : {{ $filters['justified'] === 'yes' ? 'Avec' : ($filters['justified'] === 'no' ? 'Sans' : 'Tous') }}
                </td>
                <td width="40%">
                    <strong>Résumé des Statistiques</strong>
                    <table style="width: 100%; border:none; padding:0; margin:0;">
                        <tr>
                            <td style="padding:0; border:none; width:50%;">Total Enregistrements : <b>{{ $stats['total'] }}</b></td>
                            <td style="padding:0; border:none; width:50%;">Retards : <b class="status-retard">{{ $stats['retards'] }}</b></td>
                        </tr>
                        <tr>
                            <td style="padding:0; border:none;">Présents : <b class="status-present">{{ $stats['presents'] }}</b></td>
                            <td style="padding:0; border:none;">Absents : <b class="status-absent">{{ $stats['absents'] }}</b></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="10%">Date</th>
                <th width="20%">Employé</th>
                <th width="10%">Rôle</th>
                <th width="9%" class="text-center">Check-in</th>
                <th width="9%" class="text-center">Check-out</th>
                <th width="10%" class="text-center">Durée</th>
                <th width="10%">Statut</th>
                <th width="22%">Justification</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pointages as $p)
                @php
                    $user = $p->user;
                    $empName = $user ? $user->firstName . ' ' . $user->lastName : 'Inconnu';
                    
                    $duree = '--';
                    if ($p->heureEntree && $p->heureSortie) {
                        $entry = \Carbon\Carbon::parse($p->heureEntree);
                        $exit = \Carbon\Carbon::parse($p->heureSortie);
                        $mins = $entry->diffInMinutes($exit);
                        $duree = intdiv($mins, 60) . 'h ' . str_pad($mins % 60, 2, '0', STR_PAD_LEFT) . 'm';
                    }
                @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($p->date)->format('d/m/Y') }}</td>
                    <td>
                        <strong>{{ $empName }}</strong>
                        <span class="emp-email">{{ $user->email ?? '' }}</span>
                    </td>
                    <td>{{ ucfirst($user->type ?? '--') }}</td>
                    <td class="text-center">{{ $p->heureEntree ? \Carbon\Carbon::parse($p->heureEntree)->format('H:i') : '--:--' }}</td>
                    <td class="text-center">{{ $p->heureSortie ? \Carbon\Carbon::parse($p->heureSortie)->format('H:i') : '--:--' }}</td>
                    <td class="text-center">{{ $duree }}</td>
                    <td>
                        <span class="status status-{{ strtolower($p->status) }}">
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>
                    <td class="justif-text">
                        @if($p->justification)
                            <strong>{{ $p->typejustif }}</strong><br>
                            {{ Str::limit($p->justification, 60) }}
                        @else
                            <span style="color: #aaa;">--</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            @if($pointages->isEmpty())
                <tr>
                    <td colspan="8" class="text-center" style="padding: 20px; color: #777;">
                        Aucun pointage trouvé pour ces filtres.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        Rapport de Pointage — Page <span class="pagenum"></span> — Généré automatiquement
    </div>
</body>
</html>
