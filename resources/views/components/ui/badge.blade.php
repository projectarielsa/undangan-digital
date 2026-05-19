@props([
    'type' => 'default',
    'size' => 'md',
    'dot' => false,
    'pulse' => false
])

@php
    $types = [
        'default' => 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400',
        'primary' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400',
        'success' => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
        'warning' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400',
        'danger' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
        'info' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
        'purple' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400',
    ];
    
    $dotColors = [
        'default' => 'bg-gray-400',
        'primary' => 'bg-amber-500',
        'success' => 'bg-green-500',
        'warning' => 'bg-yellow-500',
        'danger' => 'bg-red-500',
        'info' => 'bg-blue-500',
        'purple' => 'bg-purple-500',
    ];
    
    $sizes = [
        'sm' => 'px-2 py-0.5 text-[10px]',
        'md' => 'px-2.5 py-1 text-xs',
        'lg' => 'px-3 py-1.5 text-sm',
    ];
    
    $typeClass = $types[$type] ?? $types['default'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $dotColor = $dotColors[$type] ?? $dotColors['default'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 font-semibold rounded-full $typeClass $sizeClass"]) }}>
    @if($dot)
    <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }} {{ $pulse ? 'animate-pulse' : '' }}"></span>
    @endif
    {{ $slot }}
</span>
