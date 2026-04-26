<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['url']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['url']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<tr>
<td class="header" style="padding: 40px 0; text-align: center;">
<a href="<?php echo new \Illuminate\Support\EncodedHtmlString($url); ?>" style="display: inline-block; text-decoration: none;">
    <img src="https://i.ibb.co/Hfm6DJ2Y/access.png" alt="Access Morocco" style="width: 120px; height: auto; border: none; display: block; margin: 0 auto 15px auto;">
    <span style="color: #b11d40; font-size: 20px; font-weight: 800; letter-spacing: 4px; text-transform: uppercase; display: inline-block; font-family: 'Inter', sans-serif;">
        ACCESS MOROCCO
    </span>
</a>
</td>
</tr>
<?php /**PATH C:\Users\ABA SOLUTIONS\Desktop\PROJET STAGE Travel Agency\AccesMorrocco\resources\views/vendor/mail/html/header.blade.php ENDPATH**/ ?>