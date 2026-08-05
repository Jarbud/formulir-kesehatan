@props(['title', 'value', 'icon', 'color' => 'primary', 'trend' => null])

@php
$colors = [
    'primary' => 'bg-primary-50 text-primary-600',
    'accent' => 'bg-accent-50 text-accent-600',
    'success' => 'bg-green-50 text-green-600',
    'warning' => 'bg-yellow-50 text-yellow-600',
    'error' => 'bg-red-50 text-red-600',
];

$iconBgClass = $colors[$color] ?? $colors['primary'];
@endphp

<div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition-all duration-300">
    <div class="flex items-center justify-between mb-4">
        <div class="p-3 rounded-xl {{ $iconBgClass }}">
            <i data-lucide="{{ $icon }}" class="w-6 h-6"></i>
        </div>
        
        @if($trend)
            <span class="text-sm font-bold {{ $trend > 0 ? 'text-green-600' : 'text-red-600' }}">
                @if($trend > 0)
                    <i data-lucide="trending-up" class="w-4 h-4 inline"></i> +{{ $trend }}%
                @else
                    <i data-lucide="trending-down" class="w-4 h-4 inline"></i> {{ $trend }}%
                @endif
            </span>
        @endif
    </div>
    
    <p class="text-gray-500 text-sm font-medium mb-1">{{ $title }}</p>
    <p class="text-3xl font-black text-gray-900">{{ $value }}</p>
</div>
