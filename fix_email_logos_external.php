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
            '{{ $message->embed(public_path(\'images/logo.png\')) }}',
            'https://i.ibb.co/Hfm6DJ2Y/access.png',
            $content
        );
        
        // Also just in case they currently have asset() if a previous script didn't run properly
        $newContent = str_replace(
            '{{ asset(\'images/logo.png\') }}',
            'https://i.ibb.co/Hfm6DJ2Y/access.png',
            $newContent
        );
        
        if ($content !== $newContent) {
            file_put_contents($file, $newContent);
            echo "Updated: $file\n";
        }
    }
}
echo "Done.\n";
