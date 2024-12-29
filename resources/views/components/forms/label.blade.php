@props(['name', 'label'])

<div class="inline-flex items-center gap-x-2">
    <span class="w-2 h-2 bg-white inline-block mb-3"></span>
    <label class="font-bold mb-4" for="{{ $name }}">{{ $label }}</label>
</div>
