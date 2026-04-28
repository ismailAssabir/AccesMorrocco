<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport de Pointage</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #374151; line-height: 1.5; margin: 0; padding: 0; font-size: 11px; }
        @page { margin: 30px; }
        
        /* Header */
        .header { width: 100%; padding-top: 10px; padding-bottom: 20px; margin-bottom: 15px; }
        .header table { width: 100%; border-collapse: collapse; }
        
        .metadata-box { background-color: #f8fafc; border-radius: 6px; padding: 8px 12px; margin-bottom: 20px; border: 1px solid #e5e7eb; }
        .metadata-table { width: 100%; font-size: 9px; color: #64748b; }
        .metadata-table td { padding: 4px; border: none; vertical-align: middle; }
        .metadata-label { font-weight: bold; color: #334155; }
        
        /* KPI Cards */
        .stats-table { width: 100%; margin-bottom: 20px; border-collapse: separate; border-spacing: 12px 0; margin-left: -12px; }
        .stat-card { border-radius: 8px; padding: 12px; text-align: center; vertical-align: middle; border-width: 2px; border-style: solid; }
        .stat-card-title { font-size: 9px; font-weight: bold; text-transform: uppercase; margin-bottom: 4px; color: #64748b; }
        .stat-card-value { font-size: 22px; font-weight: 800; }
        
        .bg-blue { background-color: #f0f7ff; color: #1d4ed8; border-color: #3b82f6; }
        .bg-green { background-color: #f0fdf4; color: #15803d; border-color: #22c55e; }
        .bg-orange { background-color: #fffaf0; color: #c2410c; border-color: #f97316; }
        .bg-red { background-color: #fef2f2; color: #b91c1c; border-color: #ef4444; }

        /* Table */
        .data-table { width: 100%; border-collapse: collapse; font-size: 10px; margin-bottom: 30px; border: 1px solid #e5e7eb; table-layout: fixed; }
        .data-table th { background-color: #130000ff; color: #ffffff; font-weight: bold; text-transform: uppercase; padding: 12px 10px; text-align: left; }
        .data-table td { padding: 10px; border-bottom: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb; vertical-align: middle; }
        .data-table tr:nth-child(even) { background-color: #f9fafb; }
        
        /* Badges */
        .badge { display: inline-block; padding: 5px 10px; border-radius: 6px; font-size: 9px; font-weight: 800; text-transform: uppercase; text-align: center; color: #ffffff; min-width: 70px; }
        .badge-present { background-color: #10b981; border: 1px solid #059669; }
        .badge-retard { background-color: #f59e0b; border: 1px solid #d97706; }
        .badge-absent { background-color: #ef4444; border: 1px solid #dc2626; }
        
        /* Utils */
        .justification-text { font-size: 9px; color: #4b5563; word-wrap: break-word; max-width: 200px; }
        .emp-name { font-weight: bold; font-size: 11px; color: #1f2937; }
        .emp-email { font-size: 8px; color: #6b7280; }
        .footer { position: fixed; bottom: -20px; left: 0; right: 0; text-align: center; font-size: 10px; color: #6b7280; border-top: 1px solid #e5e7eb; padding-top: 10px; font-weight: bold; }
        .pagenum:before { content: counter(page); }
    </style>
</head>
<body>

    <div class="header">
        <table style="width: 100%;">
            <tr>
                <td width="33%" style="text-align: left; vertical-align: top;">
                    <div style="display: inline-block; text-align: center; white-space: nowrap;">
                        @php
                            $logoPath = public_path('images/logo.png');
                            $logoSrc = null;
                            if (file_exists($logoPath)) {
                                try {
                                    $type = pathinfo($logoPath, PATHINFO_EXTENSION);
                                    $data = file_get_contents($logoPath);
                                    $logoSrc = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                } catch (\Exception $e) { $logoSrc = null; }
                            }
                        @endphp
                        @if($logoSrc)
                            <img src="{{ $logoSrc }}" style="width: 100px; display: block; margin: 0 auto;">
                        @else
                            <div style="width: 100px; height: 40px; background: #f3f4f6; border: 1px dashed #ccc; vertical-align: middle; text-align: center; font-size: 8px; color: #999; display: block; margin: 0 auto;">LOGO</div>
                        @endif
                        <div style="color: #dc2626; font-size: 11px; font-weight: 900; margin-top: 5px; text-transform: uppercase; letter-spacing: 0.5px;">ACCESS MOROCCO</div>
                    </div>
                </td>
                <td width="34%" style="text-align: center; vertical-align: middle;">
                    <div style="font-size: 22px; font-weight: 800; color: #1e293b; text-transform: uppercase;">Rapport de Pointage</div>
                    <div style="font-size: 9px; color: #94a3b8; margin-top: 4px;">Généré le : {{ $date }}</div>
                </td>
                <td width="33%" style="text-align: right; vertical-align: middle;">
                    <div style="color: #1e293b; font-size: 15px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">SYSTÈME RH</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="metadata-box">
        <table class="metadata-table">
            <tr>
                <td width="33%">
                    <span class="metadata-label">Période:</span> {{ ucfirst($filters['period']) }} 
                    @if($filters['start'] && ($filters['period'] !== 'Toutes les dates' || $filters['start'] !== $filters['end']))
                        ({{ $filters['start'] }} - {{ $filters['end'] }})
                    @endif
                </td>
                <td width="33%" style="text-align: center;">
                    <span class="metadata-label">Rôle:</span> {{ $filters['role'] }}
                </td>
                <td width="34%" style="text-align: right;">
                    <span class="metadata-label">Statut:</span> {{ $filters['status'] }}
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center; padding-top: 5px;">
                    <span class="metadata-label">Employé:</span> {{ $filters['employee'] }}
                </td>
            </tr>
        </table>
    </div>

    <table class="stats-table">
        <tr>
            <td class="stat-card bg-blue" width="25%">
                <div class="stat-card-title">Total</div>
                <div class="stat-card-value">{{ $stats['total'] }}</div>
            </td>
            <td class="stat-card bg-green" width="25%">
                <div class="stat-card-title">Présents</div>
                <div class="stat-card-value">{{ $stats['presents'] }}</div>
            </td>
            <td class="stat-card bg-orange" width="25%">
                <div class="stat-card-title">Retards</div>
                <div class="stat-card-value">{{ $stats['retards'] }}</div>
            </td>
            <td class="stat-card bg-red" width="25%">
                <div class="stat-card-title">Absents</div>
                <div class="stat-card-value">{{ $stats['absents'] }}</div>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="10%">Date</th>
                <th width="22%">Employé</th>
                <th width="10%">Rôle</th>
                <th width="8%" style="text-align: center;">Check-in</th>
                <th width="8%" style="text-align: center;">Check-out</th>
                <th width="10%" style="text-align: center;">Durée</th>
                <th width="10%" style="text-align: center;">Statut</th>
                <th width="22%">Justification</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pointages as $p)
                @php
                    $user = $p->user;
                    $empName = $user ? $user->firstName . ' ' . $user->lastName : 'Utilisateur inconnu';
                    
                    $duree = '00h 00m';
                    if ($p->heureEntree && $p->heureSortie) {
                        $entry = \Carbon\Carbon::parse($p->heureEntree);
                        $exit = \Carbon\Carbon::parse($p->heureSortie);
                        $mins = $entry->diffInMinutes($exit);
                        $duree = intdiv($mins, 60) . 'h ' . str_pad($mins % 60, 2, '0', STR_PAD_LEFT) . 'm';
                    }
                @endphp
                <tr>
                    <td style="font-weight: bold; color: #1f2937;">{{ \Carbon\Carbon::parse($p->date)->format('d/m/Y') }}</td>
                    <td>
                        <div class="emp-name">{{ $empName }}</div>
                        <div class="emp-email">{{ $user->email ?? 'Email non renseigné' }}</div>
                    </td>
                    <td style="text-transform: capitalize; color: #4b5563;">{{ $user->type ?? 'Non défini' }}</td>
                    <td style="text-align: center; font-weight: bold; color: #374151;">{{ $p->heureEntree ? \Carbon\Carbon::parse($p->heureEntree)->format('H:i') : 'Non marqué' }}</td>
                    <td style="text-align: center; font-weight: bold; color: #374151;">{{ $p->heureSortie ? \Carbon\Carbon::parse($p->heureSortie)->format('H:i') : 'Non marqué' }}</td>
                    <td style="text-align: center; font-weight: bold; color: #1f2937;">{{ $duree }}</td>
                    <td style="text-align: center;">
                        <div class="badge badge-{{ strtolower($p->status) }}">
                            @php
                                $statusTrans = [
                                    'present' => 'Présent',
                                    'absent' => 'Absent',
                                    'retard' => 'Retard'
                                ];
                            @endphp
                            {{ $statusTrans[strtolower($p->status)] ?? ucfirst($p->status) }}
                        </div>
                    </td>
                    <td class="justification-text">
                        @if($p->justification)
                            <strong style="color:#1f2937; font-size:9px;">{{ $p->typejustif }}</strong><br>
                            {{ Str::limit($p->justification, 60) }}
                        @else
                            Aucune
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px; color: #6b7280;">Aucun pointage trouvé pour ces critères.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Access Morocco | Rapport Confidentiel - Page <span class="pagenum"></span>
    </div>
</body>
</html>
