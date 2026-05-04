<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Rapport des Leads</title>
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
        .stat-card-value { font-size: 20px; font-weight: 800; }
        
        /* Couleurs Thématiques */
        .bg-main { background-color: #f0f7ff; color: #1e293b; border-color: #3b82f6; }
        .bg-leads { background-color: #f3e8ff; color: #7e22ce; border-color: #a855f7; } /* Purple */
        .bg-converted { background-color: #d1fae5; color: #047857; border-color: #10b981; } /* Green */
        .bg-lost { background-color: #ffe4e6; color: #be123c; border-color: #f43f5e; } /* Red */
        
        /* Table */
        .data-table { width: 100%; border-collapse: collapse; font-size: 10px; margin-bottom: 30px; border: 1px solid #e5e7eb; table-layout: fixed; }
        .data-table th { background-color: #1e293b; color: #ffffff; font-weight: bold; text-transform: uppercase; padding: 12px 10px; text-align: left; }
        .data-table td { padding: 10px; border-bottom: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb; vertical-align: middle; }
        .data-table tr:nth-child(even) { background-color: #f9fafb; }
        
        /* Badges */
        .badge { display: inline-block; padding: 5px 8px; border-radius: 6px; font-size: 8px; font-weight: 800; text-transform: uppercase; text-align: center; color: #ffffff; min-width: 60px; }
        .badge-particulier { background-color: #3b82f6; border: 1px solid #2563eb; }
        .badge-professionnel { background-color: #8b5cf6; border: 1px solid #7c3aed; }
        .badge-agence { background-color: #f59e0b; border: 1px solid #d97706; }
        .badge-nouveau { background-color: #94a3b8; border: 1px solid #64748b; }
        .badge-1er_appel { background-color: #3b82f6; border: 1px solid #2563eb; }
        .badge-2eme_appel { background-color: #f97316; border: 1px solid #ea580c; }
        .badge-promis { background-color: #eab308; border: 1px solid #ca8a04; }
        .badge-ok { background-color: #10b981; border: 1px solid #059669; }
        .badge-lost { background-color: #ef4444; border: 1px solid #dc2626; }
        .badge-default { background-color: #cbd5e1; border: 1px solid #94a3b8; color: #475569; }
        .badge-type { background-color: #e2e8f0; border: 1px solid #cbd5e1; color: #334155; }
        
        .lead-name { font-weight: bold; font-size: 11px; color: #1f2937; margin-bottom: 2px; }
        .lead-address { font-size: 9px; color: #6b7280; font-style: italic; }
        .lead-nat { font-size: 8px; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; }
        
        .contact-email { color: #2563eb; font-size: 10px; word-break: break-all; margin-bottom: 2px; }
        .contact-phone { font-weight: bold; color: #475569; font-size: 9px; }
        
        .affect-dept { font-weight: bold; color: #334155; font-size: 10px; margin-bottom: 2px; }
        .affect-user { font-size: 9px; color: #64748b; }
        
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
                            <div style="width: 100px; height: 40px; background: #f3f4f6; border: 1px dashed #ccc; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <span style="font-size:10px; color:#999;">LOGO</span>
                            </div>
                        @endif                       
                        <div style="color: #b11d40; font-size: 11px; font-weight: 900; margin-top: 5px; text-transform: uppercase; letter-spacing: 0.5px;">ACCESS MOROCCO</div>
                    </div>
                </td>
                <td width="34%" style="text-align: center; vertical-align: middle;">
                    <div style="font-size: 20px; font-weight: 800; color: #1e293b; text-transform: uppercase;">Rapport des Leads</div>
                    <div style="font-size: 9px; color: #94a3b8; margin-top: 4px;">Liste complète des prospects commerciaux</div>
                </td>
                <td width="33%" style="text-align: right; vertical-align: middle;">
                    <div style="color: #1e293b; font-size: 15px; font-weight: 800; text-transform: uppercase;">CRM PROSPECTS</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="metadata-box">
        <table class="metadata-table">
            <tr>
                <td width="50%">
                    <span class="metadata-label">Date d'extraction :</span> {{ now()->format('d/m/Y à H:i') }}
                </td>
                <td width="50%" style="text-align: right;">
                    <span class="metadata-label">Utilisateur :</span> {{ auth()->user()->name ?? 'Administrateur' }}
                </td>
            </tr>
        </table>
    </div>

    <table class="stats-table">
        <tr>
            <td class="stat-card bg-main" width="25%">
                <div class="stat-card-title">Total Leads</div>
                <div class="stat-card-value">{{ $leads->count() }}</div>
            </td>
            <td class="stat-card bg-leads" width="25%">
                <div class="stat-card-title">Leads actifs</div>
                <div class="stat-card-value">{{ $leads->whereIn('statut', ['nouveau', '1er_appel', '2eme_appel', 'promis'])->count() }}</div>
            </td>
            <td class="stat-card bg-converted" width="25%">
                <div class="stat-card-title">Convertis</div>
                <div class="stat-card-value">{{ $leads->where('statut', 'ok')->count() }}</div>
            </td>
            <td class="stat-card bg-lost" width="25%">
                <div class="stat-card-title">Perdus</div>
                <div class="stat-card-value">{{ $leads->where('statut', 'lost')->count() }}</div>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="14%">Lead</th>
                <th width="16%">Contact</th>
                <th width="9%" style="text-align: center;">Type</th>
                <th width="10%">Source</th>
                <th width="12%" style="font-size: 8.5px; letter-spacing: -0.2px;">Nationalité & Adresse</th>
                <th width="11%">Département</th>
                <th width="11%">Assigné à</th>
                <th width="8%" style="text-align: center;">Date</th>
                <th width="9%" style="text-align: center;">Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse($leads as $lead)
                <tr>
                    <td>
                        <div class="lead-name">{{ !empty($lead->firstName) ? $lead->firstName : 'Inconnu' }} {{ !empty($lead->lastName) ? $lead->lastName : '' }}</div>
                    </td>
                    <td>
                        <div class="contact-email">{{ !empty(trim($lead->email ?? '')) ? $lead->email : 'Email non renseigné' }}</div>
                        <div class="contact-phone">{{ !empty(trim($lead->phoneNumber ?? '')) ? $lead->phoneNumber : 'Tél non renseigné' }}</div>
                    </td>
                    <td style="text-align: center;">
                        <span class="badge badge-type">{{ !empty(trim($lead->type ?? '')) ? $lead->type : 'Non défini' }}</span>
                    </td>
                    <td>{{ !empty(trim($lead->source ?? '')) ? $lead->source : 'Non définie' }}</td>
                    <td>
                        <div style="font-weight: bold; color: #334155;">{{ !empty(trim($lead->nationalite ?? '')) ? $lead->nationalite : 'Non définie' }}</div>
                        <div class="lead-address" style="margin-top: 3px;">{{ !empty($lead->address) ? $lead->address : 'Adresse non renseignée' }}</div>
                    </td>
                    <td>{{ !empty(trim($lead->departements->title ?? '')) ? $lead->departements->title : 'Non spécifié' }}</td>
                    <td>{{ !empty($lead->user) ? $lead->user->firstName . ' ' . $lead->user->lastName : 'Non assigné' }}</td>
                    <td style="text-align: center; font-weight: bold; color: #475569;">
                        {{ !empty($lead->dateCreation) ? \Carbon\Carbon::parse($lead->dateCreation)->format('d/m/Y') : 'Inconnue' }}
                    </td>
                    <td style="text-align: center;">
                        <div class="badge badge-{{ strtolower(!empty($lead->statut) ? $lead->statut : 'nouveau') }}">
                            @php
                                $statusLabels = [
                                    'nouveau' => 'Nouveau',
                                    '1er_appel' => '1er Appel',
                                    '2eme_appel' => '2ème Appel',
                                    'promis' => 'Promis',
                                    'ok' => 'Converti',
                                    'lost' => 'Perdu'
                                ];
                                $statut = !empty($lead->statut) ? $lead->statut : 'nouveau';
                            @endphp
                            {{ $statusLabels[$statut] ?? $statut }}
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center; padding: 30px; color: #6b7280;">Aucun lead trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Access Morocco | Rapport Confidentiel - Page <span class="pagenum"></span>
    </div>
</body>
</html>