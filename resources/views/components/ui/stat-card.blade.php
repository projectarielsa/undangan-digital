@props([
    'title',
    'value',
    'icon' => null,
    'color' => 'amber',
    'trend' => null,
    'trendUp' => true,
    'badge' => null
])

@php
    $colorClasses = [
        'amber' => [
            'bg' => 'bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/50 dark:to-blue-800/50',
            'text' => 'text-blue-600 dark:text-blue-400',
            'shadow' => 'hover:shadow-blue-500/5',
            'border' => 'hover:border-blue-200 dark:hover:border-blue-800',
            'badge' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400'
        ],
        'green' => [
            'bg' => 'bg-gradient-to-br from-green-100 to-green-200 dark:from-green-900/50 dark:to-green-800/50',
            'text' => 'text-green-600 dark:text-green-400',
            'shadow' => 'hover:shadow-green-500/5',
            'border' => 'hover:border-green-200 dark:hover:border-green-800',
            'badge' => 'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400'
        ],
        'blue' => [
            'bg' => 'bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/50 dark:to-blue-800/50',
            'text' => 'text-blue-600 dark:text-blue-400',
            'shadow' => 'hover:shadow-blue-500/5',
            'border' => 'hover:border-blue-200 dark:hover:border-blue-800',
            'badge' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400'
        ],
        'purple' => [
            'bg' => 'bg-gradient-to-br from-purple-100 to-purple-200 dark:from-purple-900/50 dark:to-purple-800/50',
            'text' => 'text-purple-600 dark:text-purple-400',
            'shadow' => 'hover:shadow-purple-500/5',
            'border' => 'hover:border-purple-200 dark:hover:border-purple-800',
            'badge' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400'
        ],
        'rose' => [
            'bg' => 'bg-gradient-to-br from-rose-100 to-rose-200 dark:from-rose-900/50 dark:to-rose-800/50',
            'text' => 'text-rose-600 dark:text-rose-400',
            'shadow' => 'hover:shadow-rose-500/5',
            'border' => 'hover:border-rose-200 dark:hover:border-rose-800',
            'badge' => 'bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400'
        ],
    ];
    $colors = $colorClasses[$color] ?? $colorClasses['amber'];
@endphp

<div class="group relative bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 hover:shadow-xl {{ $colors['shadow'] }} {{ $colors['border'] }} transition-all duration-300 hover:-translate-y-1 overflow-hidden">
    <!-- Background decoration -->
    <div class="absolute top-0 right-0 w-32 h-32 {{ str_replace('from-', 'bg-', explode(' ', $colors['bg'])[0]) }}/5 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform duration-500"></div>
    
    <div class="relative">
        <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 {{ $colors['bg'] }} rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                @if($icon)
                    {!! $icon !!}
                @else
                    <svg class="w-6 h-6 {{ $colors['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                @endif
            </div>
            
            @if($trend)
            <div class="flex items-center gap-1 {{ $trendUp ? 'text-green-500' : 'text-red-500' }} text-xs font-medium">
                <svg class="w-3 h-3 {{ $trendUp ? '' : 'rotate-180' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                <span>{{ $trend }}</span>
            </div>
            @elseif($badge)
            <span class="px-2 py-1 {{ $colors['badge'] }} text-xs font-medium rounded-lg">{{ $badge }}</span>
            @endif
        </div>
        
        <p class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ $value }}</p>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $title }}</p>
    </div>
</div>
