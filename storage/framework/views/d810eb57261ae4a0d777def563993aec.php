

<?php $__env->startSection('title', 'Tableau de bord — Espace Client'); ?>
<?php $__env->startSection('page-title', 'Tableau de bord'); ?>
<?php $__env->startSection('page-subtitle', 'Suivez vos dossiers et paiements'); ?>

<?php $__env->startSection('content'); ?>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
    <div class="animate-fade-in">
        <h1 class="text-3xl font-black text-gray-900 tracking-tight">Mon Espace <span class="text-[#b11d40]">Client</span></h1>
        <div class="flex items-center gap-4 mt-2">
            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-[#b11d40]/10 text-[#b11d40] uppercase tracking-widest border border-[#b11d40]/20">
                Client
            </span>
            <span class="text-xs text-gray-400 font-medium tracking-wide italic">
                Bonjour <?php echo e(auth()->user()->firstName ?? 'Client'); ?>

            </span>
        </div>
    </div>
    
</div>

<?php
    $totalDossiers   = $dossiers->total();
    $enCours         = $dossiers->getCollection()->where('status', 'en_cours')->count();
    $termines        = $dossiers->getCollection()->where('status', 'ferme')->count();
    $totalPaiements  = $dossiers->getCollection()->sum(fn($d) => $d->montant ?? 0);
    
    // Données pour les graphiques
    $monthlyDossiers = [];
    $monthlyPayments = [];
    
    // Regrouper par mois
    foreach($dossiers->getCollection() as $dossier) {
        if($dossier->created_at) {
            $month = $dossier->created_at->format('M Y');
            $monthlyDossiers[$month] = ($monthlyDossiers[$month] ?? 0) + 1;
            $monthlyPayments[$month] = ($monthlyPayments[$month] ?? 0) + ($dossier->montant ?? 0);
        }
    }
    
    // Obtenir les 6 derniers mois
    $last6Months = [];
    for($i = 5; $i >= 0; $i--) {
        $last6Months[] = now()->subMonths($i)->format('M Y');
    }
    
    // Remplir les données manquantes
    $dossierData = [];
    $paymentData = [];
    foreach($last6Months as $month) {
        $dossierData[] = $monthlyDossiers[$month] ?? 0;
        $paymentData[] = $monthlyPayments[$month] ?? 0;
    }
?>


<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    
    <div class="lg:col-span-2 bg-white p-8 rounded-[2rem] border border-gray-100 shadow-2xl shadow-gray-200/50 relative overflow-hidden hover:shadow-[#b11d40]/10 hover:-translate-y-1 hover:border-[#b11d40]/20 transition-all duration-300">
        <div class="absolute top-0 right-0 p-8">
            <div class="flex items-center gap-2">
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Évolution Directe</span>
            </div>
        </div>
        <h2 class="text-xl font-black text-gray-900 mb-2">Activité des Dossiers</h2>
        <p class="text-xs text-gray-400 mb-8 font-medium">Évolution sur les 6 derniers mois</p>
        <div id="dossiersChart" class="min-h-[250px]"></div>
    </div>

    
    <div class="flex flex-col gap-6">
        <div class="bg-gradient-to-br from-[#b11d40] to-rose-700 p-8 rounded-[2rem] text-white shadow-xl shadow-rose-900/20 relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-white/10 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
            <p class="text-[10px] font-bold text-rose-100 uppercase tracking-widest mb-1 opacity-80">Total Investi</p>
            <h3 class="text-4xl font-black"><?php echo e(number_format($totalPaiements, 0, ',', ' ')); ?> <span class="text-lg">MAD</span></h3>
            <div class="mt-6 flex items-center text-xs font-bold text-rose-100/70">
                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                <?php echo e($totalDossiers); ?> dossier(s) au total
            </div>
        </div>
        
        <?php
            $perc = $totalDossiers > 0 ? round(($termines / $totalDossiers) * 100) : 0;
            $colorTheme = $perc >= 80 ? 'green' : ($perc >= 40 ? 'amber' : 'red');
            $themes = [
                'green' => [
                    'bg' => 'bg-emerald-50', 
                    'text' => 'text-emerald-600', 
                    'bar' => 'bg-emerald-500', 
                    'hoverBg' => 'group-hover/item:bg-emerald-500',
                    'glow' => 'group-hover/item:shadow-emerald-500/20'
                ],
                'amber' => [
                    'bg' => 'bg-amber-50', 
                    'text' => 'text-amber-600', 
                    'bar' => 'bg-amber-500', 
                    'hoverBg' => 'group-hover/item:bg-amber-500',
                    'glow' => 'group-hover/item:shadow-amber-500/20'
                ],
                'red' => [
                    'bg' => 'bg-rose-50', 
                    'text' => 'text-rose-600', 
                    'bar' => 'bg-rose-500', 
                    'hoverBg' => 'group-hover/item:bg-rose-500',
                    'glow' => 'group-hover/item:shadow-rose-500/20'
                ],
            ];
            $theme = $themes[$colorTheme];
        ?>
        
        <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-xl shadow-gray-200/40 cursor-pointer group/item hover:shadow-2xl hover:shadow-[#b11d40]/20 hover:-translate-y-1 hover:border-[#b11d40]/20 transition-all duration-300"
            onclick="window.location='<?php echo e(route('clients.dossiers')); ?>'">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 <?php echo e($theme['bg']); ?> <?php echo e($theme['text']); ?> rounded-2xl <?php echo e($theme['hoverBg']); ?> group-hover/item:text-white transition-all duration-300 group-hover/item:scale-110 shadow-sm <?php echo e($theme['glow']); ?>">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Taux d'achèvement</p>
                    <h3 class="text-2xl font-black text-gray-900 group-hover/item:<?php echo e($theme['text']); ?> transition-colors duration-300"><?php echo e($termines); ?> / <?php echo e($totalDossiers); ?></h3>
                </div>
            </div>
            <div class="w-full bg-gray-100 h-1.5 rounded-full overflow-hidden">
                <div class="<?php echo e($theme['bar']); ?> h-full rounded-full transition-all duration-1000" style="width: <?php echo e($perc); ?>%"></div>
            </div>
        </div>
    </div>
</div>


<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
    
    <div class="bg-white p-6 rounded-[1.5rem] border border-gray-100 shadow-lg shadow-gray-100/50 hover:shadow-2xl hover:shadow-[#b11d40]/15 transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Répartition financière</p>
            <div class="p-2 bg-[#b11d40]/10 rounded-xl">
                <svg class="w-4 h-4 text-[#b11d40]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <div id="paymentsChart" class="min-h-[200px]"></div>
    </div>

    
    <div class="bg-white p-6 rounded-[1.5rem] border border-gray-100 shadow-lg shadow-gray-100/50 hover:shadow-2xl hover:shadow-[#b11d40]/15 transition-all duration-300 lg:col-span-1">
        <div class="flex items-center justify-between mb-4">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Distribution</p>
            <div class="p-2 bg-purple-50 rounded-xl">
                <svg class="w-4 h-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
        </div>
        <div id="statusChart" class="min-h-[200px]"></div>
    </div>

    
    <div class="bg-white p-6 rounded-[1.5rem] border border-gray-100 shadow-lg shadow-gray-100/50 hover:shadow-2xl hover:shadow-[#b11d40]/15 transition-all duration-300 lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Évolution des paiements</p>
            <div class="p-2 bg-emerald-50 rounded-xl">
                <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
        </div>
        <div id="paymentTrendChart" class="min-h-[200px]"></div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Graphique d'évolution des dossiers
        var dossierOptions = {
            series: [{
                name: 'Dossiers créés',
                data: <?php echo json_encode($dossierData, 15, 512) ?>,
                color: '#b11d40'
            }],
            chart: {
                type: 'area',
                height: 250,
                toolbar: { show: false },
                background: 'transparent',
                sparkline: { enabled: false }
            },
            stroke: { curve: 'smooth', width: 3 },
            fill: { 
                type: 'gradient',
                gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05 }
            },
            xaxis: { 
                categories: <?php echo json_encode($last6Months, 15, 512) ?>,
                labels: { style: { fontSize: '10px', colors: '#9ca3af' } }
            },
            yaxis: { 
                title: { text: 'Nombre de dossiers', style: { fontSize: '10px' } },
                labels: { style: { fontSize: '10px', colors: '#9ca3af' } }
            },
            grid: { borderColor: '#f3f4f6', strokeDashArray: 4 }
        };
        
        var dossierChart = new ApexCharts(document.querySelector("#dossiersChart"), dossierOptions);
        dossierChart.render();
        
        // Graphique des montants par dossier (donut)
        var paymentOptions = {
            series: <?php echo json_encode(array_values($monthlyPayments), 15, 512) ?>,
            chart: { type: 'donut', height: 200, toolbar: { show: false } },
            labels: <?php echo json_encode(array_keys($monthlyPayments), 15, 512) ?>,
            colors: ['#b11d40', '#dc2626', '#f97316', '#f59e0b', '#eab308', '#84cc16'],
            legend: { position: 'bottom', fontSize: '10px' },
            dataLabels: { enabled: true, formatter: function(val) { return Math.round(val) + '%'; } },
            plotOptions: { pie: { donut: { size: '60%', labels: { show: true, total: { show: true, label: 'Total', formatter: function() { return '<?php echo e(number_format($totalPaiements, 0, ',', ' ')); ?> MAD'; } } } } } }
        };
        
        var paymentChart = new ApexCharts(document.querySelector("#paymentsChart"), paymentOptions);
        paymentChart.render();
        
        // Graphique de distribution des statuts
        var otherStatus = <?php echo e($totalDossiers - $enCours - $termines); ?>;
        var statusOptions = {
            series: [<?php echo e($enCours); ?>, <?php echo e($termines); ?>, otherStatus],
            chart: { type: 'pie', height: 200, toolbar: { show: false } },
            labels: ['En cours', 'Terminés', 'Autres'],
            colors: ['#f59e0b', '#10b981', '#6b7280'],
            legend: { position: 'bottom', fontSize: '10px' },
            dataLabels: { enabled: true, formatter: function(val) { return Math.round(val) + '%'; } }
        };
        
        var statusChart = new ApexCharts(document.querySelector("#statusChart"), statusOptions);
        statusChart.render();
        
        // Graphique d'évolution des paiements
        var paymentTrendOptions = {
            series: [{
                name: 'Montants (MAD)',
                data: <?php echo json_encode($paymentData, 15, 512) ?>,
                color: '#10b981'
            }],
            chart: { type: 'line', height: 200, toolbar: { show: false }, sparkline: { enabled: false } },
            stroke: { curve: 'smooth', width: 3 },
            fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.7, opacityTo: 0.3 } },
            xaxis: { categories: <?php echo json_encode($last6Months, 15, 512) ?>, labels: { style: { fontSize: '10px', colors: '#9ca3af' } } },
            yaxis: { title: { text: 'Montant (MAD)', style: { fontSize: '10px' } }, labels: { style: { fontSize: '10px', colors: '#9ca3af' }, formatter: function(val) { return val.toLocaleString(); } } },
            tooltip: { y: { formatter: function(val) { return val.toLocaleString() + ' MAD'; } } },
            grid: { borderColor: '#f3f4f6', strokeDashArray: 4 }
        };
        
        var paymentTrendChart = new ApexCharts(document.querySelector("#paymentTrendChart"), paymentTrendOptions);
        paymentTrendChart.render();
    });
</script>

<style>
    .animate-fade-in {
        animation: fadeIn 0.6s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\4B\Desktop\ExercicesLaravel\voyage\resources\views/clients/dashboard.blade.php ENDPATH**/ ?>