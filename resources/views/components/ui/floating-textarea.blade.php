@props([
    'name',
    'label',
    'value' => '',
    'required' => false,
    'rows' => 3,
    'placeholder' => '',
    'disabled' => false
])

<div class="relative">
    <textarea 
        name="{{ $name }}" 
        id="{{ $name }}"
        rows="{{ $rows }}"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        placeholder="{{ $placeholder ?: $label }}"
        {{ $attributes->merge([
            'class' => 'peer w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-amber-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none transition-all resize-none placeholder-transparent disabled:opacity-50 disabled:cursor-not-allowed'
        ]) }}
    >{{ old($name, $value) }}</textarea>
    <label 
        for="{{ $name }}" 
        class="absolute left-4 -top-2.5 px-1 bg-white dark:bg-gray-800 text-xs font-medium text-gray-500 transition-all 
               peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:bg-transparent 
               peer-focus:-top-2.5 peer-focus:text-xs peer-focus:bg-white dark:peer-focus:bg-gray-800 peer-focus:text-amber-600
               peer-disabled:text-gray-400"
    >
        {{ $label }}@if($required)<span class="text-red-500 ml-0.5">*</span>@endif
    </label>
</div>
