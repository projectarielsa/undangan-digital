@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'icon' => null,
    'iconPosition' => 'left',
    'loading' => false,
    'disabled' => false,
    'href' => null
])

@php
    $variants = [
        'primary' => 'bg-gradient-to-r from-amber-500 to-amber-600 text-white shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 hover:from-amber-600 hover:to-amber-700',
        'secondary' => 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600',
        'outline' => 'border-2 border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:border-amber-300 hover:bg-amber-50 dark:hover:bg-amber-900/20',
        'ghost' => 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800',
        'danger' => 'bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg shadow-red-500/25 hover:shadow-red-500/40 hover:from-red-600 hover:to-red-700',
        'success' => 'bg-gradient-to-r from-green-500 to-emerald-600 text-white shadow-lg shadow-green-500/25 hover:shadow-green-500/40 hover:from-green-600 hover:to-emerald-700',
        'gradient' => 'bg-gradient-to-r from-amber-500 via-rose-500 to-purple-500 text-white shadow-lg shadow-rose-500/25 hover:shadow-rose-500/40',
    ];
    
    $sizes = [
        'sm' => 'px-4 py-2 text-sm rounded-lg gap-1.5',
        'md' => 'px-6 py-3 text-sm rounded-xl gap-2',
        'lg' => 'px-8 py-4 text-base rounded-xl gap-2',
        'xl' => 'px-10 py-4 text-lg rounded-2xl gap-3',
    ];
    
    $baseClasses = 'inline-flex items-center justify-center font-semibold transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed';
    $variantClass = $variants[$variant] ?? $variants['primary'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

@if($href)
<a href="{{ $href }}" {{ $attributes->merge(['class' => "$baseClasses $variantClass $sizeClass"]) }}>
    @if($icon && $iconPosition === 'left')
        <span class="flex-shrink-0">{!! $icon !!}</span>
    @endif
    
    <span>{{ $slot }}</span>
    
    @if($icon && $iconPosition === 'right')
        <span class="flex-shrink-0">{!! $icon !!}</span>
    @endif
</a>
@else
<button 
    type="{{ $type }}" 
    {{ $disabled || $loading ? 'disabled' : '' }}
    {{ $attributes->merge(['class' => "$baseClasses $variantClass $sizeClass"]) }}
>
    @if($loading)
        <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    @elseif($icon && $iconPosition === 'left')
        <span class="flex-shrink-0">{!! $icon !!}</span>
    @endif
    
    <span>{{ $slot }}</span>
    
    @if(!$loading && $icon && $iconPosition === 'right')
        <span class="flex-shrink-0">{!! $icon !!}</span>
    @endif
</button>
@endif
