@props([
    'name',
    'label' => 'Upload file',
    'accept' => 'image/*',
    'hint' => 'PNG, JPG (max 2MB)',
    'preview' => true,
    'multiple' => false
])

<div x-data="{ 
    preview: null, 
    dragover: false,
    handleFiles(files) {
        if (files.length > 0 && files[0].type.startsWith('image/')) {
            this.preview = URL.createObjectURL(files[0]);
        }
    }
}" class="w-full">
    <input 
        type="file" 
        name="{{ $name }}" 
        id="{{ $name }}"
        accept="{{ $accept }}"
        {{ $multiple ? 'multiple' : '' }}
        class="hidden" 
        @change="handleFiles($event.target.files)"
    >
    
    <label 
        for="{{ $name }}" 
        class="relative flex flex-col items-center justify-center w-full h-48 border-2 border-dashed rounded-2xl cursor-pointer transition-all duration-300"
        :class="dragover 
            ? 'border-amber-500 bg-amber-50 dark:bg-amber-900/20' 
            : 'border-gray-300 dark:border-gray-600 hover:border-amber-400 hover:bg-amber-50/50 dark:hover:bg-amber-900/10'"
        @dragover.prevent="dragover = true"
        @dragleave.prevent="dragover = false"
        @drop.prevent="dragover = false; handleFiles($event.dataTransfer.files); $refs.input.files = $event.dataTransfer.files"
    >
        <template x-if="!preview">
            <div class="text-center">
                <div class="w-14 h-14 mx-auto mb-4 bg-gray-100 dark:bg-gray-700 rounded-2xl flex items-center justify-center" :class="dragover && 'bg-amber-100 dark:bg-amber-900/30'">
                    <svg class="w-7 h-7 text-gray-400" :class="dragover && 'text-amber-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
                    <span class="font-medium text-amber-600 dark:text-amber-400">Klik untuk upload</span> atau drag & drop
                </p>
                <p class="text-xs text-gray-400">{{ $hint }}</p>
            </div>
        </template>
        
        @if($preview)
        <template x-if="preview">
            <div class="relative w-full h-full group">
                <img :src="preview" class="w-full h-full object-cover rounded-xl">
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-xl flex items-center justify-center">
                    <span class="text-white text-sm font-medium">Klik untuk ganti</span>
                </div>
            </div>
        </template>
        @endif
    </label>
</div>
