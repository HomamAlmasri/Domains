@php
    $classes =
        'p-4 bg-white/5 rounded-xl border border-transparent hover:border-blue-800 group transition-color duration-300 max-h-[195px]';
@endphp
<div {{ $attributes(['class' => $classes]) }}>
    {{ $slot }}
</div>
