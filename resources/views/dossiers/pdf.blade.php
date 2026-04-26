<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1e293b; }
        .header { background: linear-gradient(135deg, #b11d40, #7c1233); color: white; padding: 20px 30px; margin-bottom: 24px; }
        .header h1 { font-size: 20px; font-weight: 900; }
        .header p { font-size: 11px; opacity: 0.8; margin-top: 4px; }
        .badge { display: inline-block; background: rgba(255,255,255,0.2); padding: 2px 10px; border-radius: 20px; font-size: 10px; font-weight: bold; margin-top: 6px; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: #f8fafc; }
        thead th { padding: 10px 12px; text-align: left; font-size: 9px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; border-bottom: 2px solid #e2e8f0; }
        tbody tr { border-bottom: 1px solid #f1f5f9; }
        tbody tr:nth-child(even) { background: #fafafa; }
        tbody td { padding: 9px 12px; color: #334155; vertical-align: middle; }
        .pill { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 9px; font-weight: 900; text-transform: uppercase; }
        .ouvert { background: #dbeafe; color: #2563eb; }
        .en_cours { background: #fef9c3; color: #a16207; }
        .ferme { background: #f1f5f9; color: #64748b; }
        .footer { margin-top: 24px; padding-top: 12px; border-top: 1px solid #e2e8f0; text-align: center; font-size: 9px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Rapport des Dossiers</h1>
        <p>Généré le {{ now()->format('d/m/Y à H:i') }}</p>
        <div class="badge">{{ $dossiers->count() }} dossier(s)</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Référence</th>
                <th>Client</th>
                <th>Destination</th>
                <th>Département</th>
                <th>Personnes</th>
                <th>Jours</th>
                <th>Montant</th>
                <th>Date voyage</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dossiers as $dossier)
            <tr>
                <td><strong>{{ $dossier->reference }}</strong></td>
                <td>{{ $dossier->client->firstName ?? '—' }} {{ $dossier->client->lastName ?? '' }}</td>
                <td>{{ $dossier->distination ?? '—' }}</td>
                <td>{{ $dossier->departement->title ?? '—' }}</td>
                <td>{{ $dossier->nombrePersonnes }}</td>
                <td>{{ $dossier->nombreJours }}</td>
                <td><strong>{{ number_format($dossier->montant, 2) }} MAD</strong></td>
                <td>{{ $dossier->dateVoyage ? \Carbon\Carbon::parse($dossier->dateVoyage)->format('d/m/Y') : '—' }}</td>
                <td><span class="pill {{ $dossier->status }}">{{ $dossier->status }}</span></td>
            </tr>
            @empty
            <tr><td colspan="9" style="text-align:center;padding:20px;color:#94a3b8;">Aucun dossier</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Rapport confidentiel — {{ config('app.name') }} © {{ now()->year }}</div>
</body>
</html>