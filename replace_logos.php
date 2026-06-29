<?php
$pdfSnippet = <<<'EOD'
@php
    $imagePath = public_path('images/logo.png');
    $imageData = base64_encode(file_get_contents($imagePath));
    $src = 'data:image/png;base64,' . $imageData;
@endphp
<img src="{{ $src }}" alt="Access Morocco Logo" style="max-height: 45px; display: block; margin-bottom: 10px;">
EOD;

$emailSnippet = '<img src="{{ $message->embed(public_path(\'images/logo.png\')) }}" alt="Access Morocco Logo" style="max-width: 150px; height: auto; display: block; margin: 0 auto 15px auto;">';

function replaceInFile($path, $pattern, $replacement) {
    if (!file_exists($path)) {
        echo "File not found: $path\n";
        return;
    }
    $content = file_get_contents($path);
    $newContent = preg_replace($pattern, $replacement, $content);
    if ($content !== $newContent) {
        file_put_contents($path, $newContent);
        echo "Updated: $path\n";
    } else {
        echo "No match found in: $path\n";
    }
}

$dir = __DIR__ . '/resources/views/';

// PDF updates
$pdfs = [
    $dir . 'pointages/pdf.blade.php',
    $dir . 'leads/pdf.blade.php',
    $dir . 'dossiers/pdf.blade.php',
    $dir . 'clients/pdf.blade.php'
];

foreach ($pdfs as $pdf) {
    replaceInFile($pdf, '/<div style="color: #[A-Za-z0-9]+; font-size: 11px; font-weight: 900; margin-top: 5px; text-transform: uppercase; letter-spacing: 0\.5px;">ACCESS MOROCCO<\/div>/i', $pdfSnippet);
}

replaceInFile($dir . 'departements/report-pdf.blade.php', '/<div class="logo">ACCESS MOROCCO<\/div>/i', $pdfSnippet);
replaceInFile($dir . 'departements/report-pdf.blade.php', '/<div class="logo">AccesMorocco<\/div>/i', $pdfSnippet);

replaceInFile($dir . 'pdf/categories.blade.php', "/<div style=\"color:#b11d40;font-size:14px;font-weight:900;\">\s*\{\{\s*config\('app\.name'\)\s*\}\}\s*<\/div>/", $pdfSnippet);

// Email updates
replaceInFile($dir . 'emails/client-created.blade.php', '/<h1>🌍 Access Morocco<\/h1>/i', $emailSnippet);
replaceInFile($dir . 'emails/client-reset-password.blade.php', '/<h1>🔐 Access Morocco<\/h1>/i', $emailSnippet);
replaceInFile($dir . 'emails/new_presentation.blade.php', '/<h1 style="color: white; margin: 0; font-weight: 900; letter-spacing: -1px;">ACCESS MOROCCO<\/h1>/i', $emailSnippet);
replaceInFile($dir . 'emails/meeting-invitation.blade.php', '/<img src="https:\/\/i\.ibb\.co\/Hfm6DJ2Y\/access\.png" alt="Access Morocco" style="width: 120px; height: auto; border: none; display: block; margin: 0 auto 15px auto;">/', $emailSnippet);
replaceInFile($dir . 'emails/client-welcome.blade.php', '/<img src="https:\/\/via\.placeholder\.com\/140x60\?text=Access\+Morocco\+Logo" alt="Access Morocco" class="logo" style="background:#fff; padding:8px 15px; border-radius:40px;">/', $emailSnippet);
replaceInFile($dir . 'vendor/mail/html/header.blade.php', '/<img src="https:\/\/i\.ibb\.co\/Hfm6DJ2Y\/access\.png" alt="Access Morocco" style="width: 120px; height: auto; border: none; display: block; margin: 0 auto 15px auto;">/', $emailSnippet);

// Add logo before headers in prime emails
replaceInFile($dir . 'emails/prime_paid.blade.php', '/<h1>Paiement Effectué !<\/h1>/i', $emailSnippet . "\n            " . '<h1>Paiement Effectué !</h1>');
replaceInFile($dir . 'emails/prime_validated.blade.php', '/<h1>Félicitations !<\/h1>/i', $emailSnippet . "\n            " . '<h1>Félicitations !</h1>');

echo "Done.\n";
