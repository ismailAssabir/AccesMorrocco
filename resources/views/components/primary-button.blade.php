<button {{ $attributes->merge([
    'type'  => 'submit',
    'class' => 'btn-brand'
]) }}>
    <span>{{ $slot }}</span>
</button>
