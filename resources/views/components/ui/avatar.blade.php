@props([
    'name' => '',
    'src' => null,
    'size' => 'md',
    'color' => 'amber',
    'status' => null
])

@php
    $sizes = [
        'xs' => 'w-6 h-6 text-[10px]',
        'sm' => 'w-8 h-8 text-xs',
        'md' => 'w-10 h-10 text-sm',
        'lg' => 'w-12 h-12 text-base',
        'xl' => 'w-16 h-16 text-lg',
        '2xl' => 'w-20 h-20 text-xl',
    ];
    
    $colors = [
        'amber' => 'bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/50 dark:to-blue-800/50 text-blue-700 dark:text-blue-300',
        'blue' => 'bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/50 dark:to-blue-800/50 text-blue-700 dark:text-blue-300',
        'green' => 'bg-gradient-to-br from-green-100 to-green-200 dark:from-green-900/50 dark:to-green-800/50 text-green-700 dark:text-green-300',
        'rose' => 'bg-gradient-to-br from-rose-100 to-rose-200 dark:from-rose-900/50 dark:to-rose-800/50 text-rose-700 dark:text-rose-300',
        'purple' => 'bg-gradient-to-br from-purple-100 to-purple-200 dark:from-purple-900/50 dark:to-purple-800/50 text-purple-700 dark:text-purple-300',
    ];
    
    $statusColors = [
        'online' => 'bg-green-500',
        'offline' => 'bg-gray-400',
        'busy' => 'bg-red-500',
        'away' => 'bg-yellow-500',
    ];
    
    $statusSizes = [
        'xs' => 'w-1.5 h-1.5',
        'sm' => 'w-2 h-2',
        'md' => 'w-2.5 h-2.5',
        'lg' => 'w-3 h-3',
        'xl' => 'w-3.5 h-3.5',
        '2xl' => 'w-4 h-4',
    ];
    
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $colorClass = $colors[$color] ?? $colors['amber'];
    $statusColor = $statusColors[$status] ?? null;
    $statusSize = $statusSizes[$size] ?? $statusSizes['md'];
    
    $initials = collect(explode(' ', $name))
        ->map(fn($word) => strtoupper(substr($word, 0, 1)))
        ->take(2)
        ->join('');
@endphp

<div class="relative inline-flex" {{ $attributes }}>
    @if($src)
    <img src="{{ $src }}" alt="{{ $name }}" class="{{ $sizeClass }} rounded-full object-cover">
    @else
    <div class="{{ $sizeClass }} {{ $colorClass }} rounded-full flex items-center justify-center font-semibold">
        {{ $initials ?: '?' }}
    </div>
    @endif
    
    @if($status)
    <span class="absolute bottom-0 right-0 {{ $statusSize }} {{ $statusColor }} rounded-full ring-2 ring-white dark:ring-gray-800"></span>
    @endif
</div>
