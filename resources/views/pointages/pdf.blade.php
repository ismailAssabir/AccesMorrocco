<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport de Pointage</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #334155; line-height: 1.5; margin: 0; padding: 0; }
        @page { margin: 0; }
        .header { padding: 40px; border-bottom: 2px solid #f1f5f9; background: #fff; }
        .logo-container { float: left; }
        .company-info { float: right; text-align: right; }
        .logo { height: 45px; margin-bottom: 8px; }
        .company-name { font-size: 20px; font-weight: 800; color: #1e293b; margin: 0; letter-spacing: -0.5px; }
        .report-title { clear: both; padding: 30px 40px 10px 40px; }
        .report-title h1 { font-size: 28px; font-weight: 900; margin: 0; color: #1e293b; letter-spacing: -1px; }
        .filters-info { padding: 15px 40px; background: #f8fafc; border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; font-size: 11px; color: #64748b; }
        .stats-grid { padding: 25px 40px; overflow: hidden; }
        .stat-card { float: left; width: 23%; background: #fff; border: 1px solid #e2e8f0; padding: 15px; border-radius: 12px; margin-right: 2%; text-align: left; }
        .stat-card:last-child { margin-right: 0; }
        .stat-label { font-size: 9px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .stat-value { font-size: 22px; font-weight: 900; color: #1e293b; }
        .table-container { padding: 0 40px 40px 40px; }
        table { width: 100%; border-collapse: collapse; font-size: 11px; border-radius: 12px; overflow: hidden; }
        th { background: #1e293b; color: #fff; font-weight: 700; text-transform: uppercase; padding: 14px 12px; text-align: left; letter-spacing: 0.5px; }
        td { padding: 12px; border-bottom: 1px solid #f1f5f9; color: #475569; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .status-badge { padding: 4px 10px; border-radius: 6px; font-weight: 800; font-size: 9px; text-transform: uppercase; display: inline-block; }
        .status-present { background: #d1fae5; color: #065f46; }
        .status-retard { background: #fef3c7; color: #92400e; }
        .status-absent { background: #fee2e2; color: #991b1b; }
        .footer { position: fixed; bottom: 0; width: 100%; padding: 20px 40px; font-size: 10px; color: #94a3b8; border-top: 1px solid #f1f5f9; text-align: center; background: #fff; }
        .pagenum:before { content: counter(page); }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-container">
            @if(file_exists(public_path('images/logo.png')))
                <img src="{{ public_path('images/logo.png') }}" class="logo">
            @else
                <div style="width: 45px; height: 45px; background: #b11d40; border-radius: 10px; margin-bottom: 8px;"></div>
            @endif
            <div>
                <span style="font-size: 18px; font-weight: 900; color: #1e293b;">ACCESS</span>
                <span style="font-size: 18px; font-weight: 900; color: #b11d40;">MOROCCO</span>
            </div>
        </div>
        <div class="company-info">
            <p class="company-name">Attendance Intelligence</p>
            <p style="font-size: 11px; color: #64748b; margin: 4px 0;">Généré le: {{ $date }}</p>
            <p style="font-size: 11px; font-weight: bold; color: #b11d40;">Confidentiel</p>
        </div>
    </div>

    <div class="report-title">
        <h1>Rapport de Pointage Personnalisé</h1>
    </div>

    <div class="filters-info">
        <strong>Période:</strong> {{ ucfirst($filters['period']) }} 
        @if($filters['start']) ({{ $filters['start'] }} — {{ $filters['end'] }}) @endif
        <span style="margin: 0 15px; color: #cbd5e1;">|</span>
        <strong>Rôle:</strong> {{ ucfirst($filters['role'] ?: 'Tous') }}
        <span style="margin: 0 15px; color: #cbd5e1;">|</span>
        <strong>Statut:</strong> {{ ucfirst($filters['status'] ?: 'Tous') }}
        <span style="margin: 0 15px; color: #cbd5e1;">|</span>
        <strong>Justificatif:</strong> {{ $filters['justified'] === 'yes' ? 'Avec' : ($filters['justified'] === 'no' ? 'Sans' : 'Tous') }}
    </div>

    <div class="stats-grid">
        <div class="stat-card" style="border-left: 4px solid #1e293b;">
            <div class="stat-label">Total Records</div>
            <div class="stat-value">{{ $stats['total'] }}</div>
        </div>
        <div class="stat-card" style="border-left: 4px solid #10b981;">
            <div class="stat-label">Présents</div>
            <div class="stat-value" style="color: #059669;">{{ $stats['presents'] }}</div>
        </div>
        <div class="stat-card" style="border-left: 4px solid #f59e0b;">
            <div class="stat-label">Retards</div>
            <div class="stat-value" style="color: #d97706;">{{ $stats['retards'] }}</div>
        </div>
        <div class="stat-card" style="border-left: 4px solid #ef4444;">
            <div class="stat-label">Absents</div>
            <div class="stat-value" style="color: #dc2626;">{{ $stats['absents'] }}</div>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th width="10%">Date</th>
                    <th width="20%">Employé</th>
                    <th width="10%">Rôle</th>
                    <th width="10%">Check-in</th>
                    <th width="10%">Check-out</th>
                    <th width="10%">Durée</th>
                    <th width="10%">Statut</th>
                    <th width="20%">Justification</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pointages as $p)
                    @php
                        $user = $p->user;
                        $empName = $user ? $user->firstName . ' ' . $user->lastName : 'Inconnu';
                    @endphp
                    <tr>
                        <td style="font-weight: bold; color: #1e293b;">{{ \Carbon\Carbon::parse($p->date)->format('d/m/Y') }}</td>
                        <td>
                            <strong style="color: #1e293b;">{{ $empName }}</strong><br>
                            <span style="font-size: 9px; color: #94a3b8;">{{ $user->email ?? '' }}</span>
                        </td>
                        <td><span style="text-transform: capitalize;">{{ $user->type ?? '--' }}</span></td>
                        <td>
                            @if($p->heureEntree)
                                <span style="font-weight: bold; color: #10b981;">{{ \Carbon\Carbon::parse($p->heureEntree)->format('H:i') }}</span>
                            @else
                                <span style="color: #cbd5e1;">--:--</span>
                            @endif
                        </td>
                        <td>
                            @if($p->heureSortie)
                                <span style="font-weight: bold; color: #6366f1;">{{ \Carbon\Carbon::parse($p->heureSortie)->format('H:i') }}</span>
                            @else
                                <span style="color: #cbd5e1;">--:--</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $duree = '--';
                                if ($p->heureEntree && $p->heureSortie) {
                                    $entry = \Carbon\Carbon::parse($p->heureEntree);
                                    $exit = \Carbon\Carbon::parse($p->heureSortie);
                                    $mins = $entry->diffInMinutes($exit);
                                    $duree = intdiv($mins, 60) . 'h ' . ($mins % 60) . 'min';
                                }
                            @endphp
                            <span style="font-weight: bold; color: #475569;">{{ $duree }}</span>
                        </td>
                        <td>
                            <span class="status-badge status-{{ $p->status }}">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td>
                            @if($p->justification)
                                <div style="font-size: 9px; line-height: 1.2;">
                                    <strong>{{ $p->typejustif }}</strong><br>
                                    {{ Str::limit($p->justification, 50) }}
                                </div>
                            @else
                                <span style="color: #cbd5e1; font-style: italic;">Aucune justification</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        Page <span class="pagenum"></span> — Rapport généré par le système Access Morocco. Tous droits réservés.
    </div>
</body>
</html>
