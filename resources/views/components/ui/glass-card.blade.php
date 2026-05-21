@props([
    'padding' => 'p-6',
    'hover' => false,
    'dark' => false
])

<div {{ $attributes->merge([
    'class' => implode(' ', [
        'relative overflow-hidden rounded-3xl',
        $dark 
            ? 'bg-gray-900/80 dark:bg-gray-800/80 border border-white/10' 
            : 'bg-white/70 dark:bg-gray-800/70 border border-white/20 dark:border-gray-700/50',
        'backdrop-blur-xl shadow-xl',
        $hover ? 'transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 hover:bg-white/80 dark:hover:bg-gray-800/80' : '',
        $padding
    ])
]) }}>
    <!-- Optional gradient overlay -->
    <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent pointer-events-none"></div>
    
    <!-- Content -->
    <div class="relative z-10">
        {{ $slot }}
    </div>
</div>
