@props(['variant' => 'default', 'size' => 'md'])

@php
$variants = [
    'default' => 'bg-gray-100 text-gray-700 border-gray-200',
    'primary' => 'bg-primary-50 text-primary-700 border-primary-200',
    'success' => 'bg-green-50 text-green-700 border-green-200',
    'warning' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
    'error' => 'bg-red-50 text-red-700 border-red-200',
    'info' => 'bg-blue-50 text-blue-700 border-blue-200',
];

$sizes = [
    'sm' => 'px-2 py-0.5 text-xs',
    'md' => 'px-2.5 py-1 text-sm',
    'lg' => 'px-3 py-1.5 text-base',
];

$classes = $variants[$variant] . ' ' . $sizes[$size];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center font-bold rounded-full border $classes"]) }}>
    {{ $slot }}
</span>
