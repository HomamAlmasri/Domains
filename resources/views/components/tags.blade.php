@props(['task', 'size' => 'base'])
@php
    $classes = 'bg-white/10 hover:bg-blue-800 hover:border transition-colors font-bold duration-300 rounded-xl';
    if ($size === 'base') {
        $classes .= ' text-sm px-5 py-1';
    }
    if ($size === 'small') {
        $classes .= ' text-2xs px-3 py-1';
    }
@endphp
<a class="{{ $classes }}" href="/tags/{{ $task->tag }}">{{ $task->tag }}</a>
