@props(['padding' => true, 'hover' => false])

<div {{ $attributes->merge(['class' => 'bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden transition-all duration-300 ' . ($padding ? 'p-6' : '') . ($hover ? ' hover:shadow-xl hover:-translate-y-1' : '')]) }}>
    {{ $slot }}
</div>
