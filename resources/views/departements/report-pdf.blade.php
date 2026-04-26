<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport de Présence - {{ $departement->title }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #334155;
            line-height: 1.5;
            margin: 0;
            padding: 40px;
        }
        .header {
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .report-title {
            font-size: 20px;
            font-weight: bold;
            margin-top: 10px;
            color: #64748b;
        }
        .info-grid {
            margin-bottom: 30px;
            width: 100%;
        }
        .info-item {
            font-size: 13px;
            margin-bottom: 5px;
        }
        .label {
            font-weight: bold;
            color: #94a3b8;
            text-transform: uppercase;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th {
            background-color: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            text-align: left;
            padding: 12px;
            font-size: 11px;
            text-transform: uppercase;
            color: #64748b;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13px;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 9999px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-present { background-color: #f0fdf4; color: #166534; }
        .badge-absent { background-color: #fef2f2; color: #991b1b; }
        .summary-card {
            background-color: #1e293b;
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin-top: 40px;
        }
        .summary-title {
            font-size: 11px;
            text-transform: uppercase;
            color: #94a3b8;
            margin-bottom: 5px;
        }
        .summary-value {
            font-size: 24px;
            font-weight: bold;
        }
        .footer {
            position: fixed;
            bottom: 30px;
            left: 40px;
            right: 40px;
            font-size: 10px;
            color: #94a3b8;
            text-align: center;
            border-top: 1px solid #f1f5f9;
            padding-top: 10px;
        }
        .retard-text {
            color: #9a3412;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">AccesMorocco</div>
        <div class="report-title">Rapport de Présence</div>
    </div>

    <table class="info-grid">
        <tr>
            <td style="border:none; padding:0; width: 50%;">
                <div class="label">Département</div>
                <div class="info-item" style="font-size: 16px; font-weight: bold;">{{ $departement->title }}</div>
            </td>
            <td style="border:none; padding:0; width: 50%; text-align: right;">
                <div class="label">Période</div>
                <div class="info-item">
                    @if($period == 'today') Aujourd'hui ({{ now()->format('d/m/Y') }})
                    @elseif($period == 'weekly') 7 Derniers Jours
                    @else Ce Mois ({{ now()->translatedFormat('F Y') }})
                    @endif
                </div>
            </td>
        </tr>
        <tr>
            <td style="border:none; padding:10px 0 0 0;">
                <div class="label">Responsable</div>
                <div class="info-item">{{ $departement->manager->firstName ?? 'N/A' }} {{ $departement->manager->lastName ?? '' }}</div>
            </td>
            <td style="border:none; padding:10px 0 0 0; text-align: right;">
                <div class="label">Date de génération</div>
                <div class="info-item">{{ now()->format('d/m/Y H:i') }}</div>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Employé</th>
                <th>Poste</th>
                <th>Présence %</th>
                <th>Retards</th>
                <th>Statut Actuel</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departement->employes as $employee)
            <tr>
                <td><strong>{{ $employee->firstName }} {{ $employee->lastName }}</strong></td>
                <td>{{ $employee->post ?? 'Employé' }}</td>
                <td>
                    <span style="font-weight: bold; color: {{ $employee->presence_percentage > 80 ? '#10b981' : ($employee->presence_percentage > 50 ? '#f59e0b' : '#ef4444') }}">
                        {{ $employee->presence_percentage }}%
                    </span>
                </td>
                <td>
                    @if($employee->total_retards > 0)
                        <span class="retard-text">{{ $employee->total_retards }} retards</span>
                    @else
                        <span style="color: #94a3b8;">Aucun</span>
                    @endif
                </td>
                <td>
                    @if($employee->is_here_today)
                        <span class="badge badge-present">Présent</span>
                    @else
                        <span class="badge badge-absent">Absent</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary-card">
        <div class="summary-title">Moyenne de Présence du Département</div>
        <div class="summary-value">{{ $departement->avg_presence }}%</div>
    </div>

    <div class="footer">
        © {{ date('Y') }} AccesMorocco - Logiciel de Gestion de Présence. Document généré numériquement.
    </div>
</body>
</html>
