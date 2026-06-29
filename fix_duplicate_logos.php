<?php
$snippetToRemove = <<<'EOD'
@php
    $imagePath = public_path('images/logo.png');
    $imageData = base64_encode(file_get_contents($imagePath));
    $src = 'data:image/png;base64,' . $imageData;
@endphp
<img src="{{ $src }}" alt="Access Morocco Logo" style="max-height: 45px; display: block; margin-bottom: 10px;">
EOD;

function replaceInFile($path, $search, $replace) {
    if (!file_exists($path)) return;
    $content = file_get_contents($path);
    $newContent = str_replace($search, $replace, $content);
    if ($content !== $newContent) {
        file_put_contents($path, $newContent);
        echo "Fixed $path\n";
    }
}

$dir = __DIR__ . '/resources/views/';

replaceInFile($dir . 'pointages/pdf.blade.php', $snippetToRemove, '<div style="color: #dc2626; font-size: 11px; font-weight: 900; margin-top: 5px; text-transform: uppercase; letter-spacing: 0.5px;">ACCESS MOROCCO</div>');
replaceInFile($dir . 'leads/pdf.blade.php', $snippetToRemove, '<div style="color: #b11d40; font-size: 11px; font-weight: 900; margin-top: 5px; text-transform: uppercase; letter-spacing: 0.5px;">ACCESS MOROCCO</div>');
replaceInFile($dir . 'dossiers/pdf.blade.php', $snippetToRemove, '<div style="color: #b11d40; font-size: 11px; font-weight: 900; margin-top: 5px; text-transform: uppercase; letter-spacing: 0.5px;">ACCESS MOROCCO</div>');
replaceInFile($dir . 'clients/pdf.blade.php', $snippetToRemove, '<div style="color: #be2346; font-size: 11px; font-weight: 900; margin-top: 5px; text-transform: uppercase; letter-spacing: 0.5px;">ACCESS MOROCCO</div>');

echo "Done.\n";
