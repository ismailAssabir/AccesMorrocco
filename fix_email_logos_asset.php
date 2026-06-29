<?php
$dir = __DIR__ . '/resources/views/emails/';

$files = [
    $dir . 'client-created.blade.php',
    $dir . 'client-reset-password.blade.php',
    $dir . 'new_presentation.blade.php',
    $dir . 'meeting-invitation.blade.php',
    $dir . 'client-welcome.blade.php',
    $dir . 'prime_paid.blade.php',
    $dir . 'prime_validated.blade.php',
    __DIR__ . '/resources/views/vendor/mail/html/header.blade.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        $newContent = str_replace(
            'https://i.ibb.co/Hfm6DJ2Y/access.png',
            '{{ asset(\'images/logo.png\') }}',
            $content
        );
        
        if ($content !== $newContent) {
            file_put_contents($file, $newContent);
            echo "Updated: $file\n";
        }
    }
}
echo "Done.\n";
