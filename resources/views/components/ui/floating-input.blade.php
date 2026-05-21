@props([
    'name',
    'label',
    'type' => 'text',
    'value' => '',
    'required' => false,
    'icon' => null,
    'placeholder' => '',
    'disabled' => false
])

<div class="relative">
    @if($icon)
    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
        {!! $icon !!}
    </div>
    @endif
    
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        placeholder="{{ $placeholder ?: $label }}"
        {{ $attributes->merge([
            'class' => 'peer w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-blue-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none transition-all placeholder-transparent disabled:opacity-50 disabled:cursor-not-allowed' . ($icon ? ' pl-10' : '')
        ]) }}
    >
    <label 
        for="{{ $name }}" 
        class="absolute {{ $icon ? 'left-10' : 'left-4' }} -top-2.5 px-1 bg-white dark:bg-gray-800 text-xs font-medium text-gray-500 transition-all 
               peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:bg-transparent 
               peer-focus:-top-2.5 peer-focus:text-xs peer-focus:bg-white dark:peer-focus:bg-gray-800 peer-focus:text-blue-600
               peer-disabled:text-gray-400"
    >
        {{ $label }}@if($required)<span class="text-red-500 ml-0.5">*</span>@endif
    </label>
</div>
