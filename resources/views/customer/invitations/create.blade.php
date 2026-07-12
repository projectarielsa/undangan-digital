@extends('layouts.dashboard')
@section('page-title', 'Buat Undangan Baru')
@section('sidebar-nav')<x-customer-nav />@endsection

@section('content')
<div class="max-w-5xl" x-data="invitationWizard()">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('customer.invitations.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600 transition-colors group">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar Undangan
        </a>
    </div>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-2">Buat Undangan Baru</h1>
        <p class="text-gray-500 dark:text-gray-400">Ikuti langkah-langkah berikut untuk membuat undangan digital yang sempurna</p>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <div>
                <p class="font-medium text-red-800 dark:text-red-200 text-sm">Mohon perbaiki kesalahan berikut:</p>
                <ul class="mt-1 text-sm text-red-600 dark:text-red-300 list-disc list-inside">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <!-- Stepper -->
    <div class="mb-8">
        <div class="flex items-center justify-between relative">
            <!-- Progress Line -->
            <div class="absolute top-5 left-0 right-0 h-0.5 bg-gray-200 dark:bg-gray-700 mx-12"></div>
            <div class="absolute top-5 left-0 h-0.5 bg-gradient-to-r from-blue-500 to-rose-500 mx-12 transition-all duration-500" :style="`width: calc(${(currentStep - 1) / 4 * 100}% - 6rem)`"></div>
            
            <!-- Steps -->
            <template x-for="(step, index) in steps" :key="index">
                <div class="relative z-10 flex flex-col items-center">
                    <button @click="goToStep(index + 1)" 
                            :disabled="index + 1 > maxStep"
                            class="w-10 h-10 rounded-full flex items-center justify-center font-semibold text-sm transition-all duration-300"
                            :class="{
                                'bg-gradient-to-r from-blue-500 to-rose-500 text-white shadow-lg shadow-blue-500/30': currentStep === index + 1,
                                'bg-green-500 text-white': currentStep > index + 1,
                                'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400': currentStep < index + 1,
                                'cursor-pointer hover:scale-110': index + 1 <= maxStep,
                                'cursor-not-allowed': index + 1 > maxStep
                            }">
                        <span x-show="currentStep <= index + 1" x-text="index + 1"></span>
                        <svg x-show="currentStep > index + 1" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <span class="mt-2 text-xs font-medium transition-colors hidden sm:block"
                          :class="currentStep >= index + 1 ? 'text-gray-900 dark:text-white' : 'text-gray-400 dark:text-gray-500'"
                          x-text="step.title"></span>
                </div>
            </template>
        </div>
    </div>


    <!-- Form -->
    <form method="POST" action="{{ route('customer.invitations.store') }}" enctype="multipart/form-data" @submit="submitting = true">
        @csrf

        @if($errors->any())
        <script>
            // Auto scroll to top to show errors
            document.addEventListener('DOMContentLoaded', function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        </script>
        @endif
        
        <!-- Step 1: Template Selection -->
        <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0">
            <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Pilih Template</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Pilih desain yang sesuai dengan selera Anda</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    @if(!$hasActiveSubscription)
                    <div class="mb-4 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl">
                        <p class="text-sm text-blue-700 dark:text-blue-300">
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            Template <b>PRO</b> hanya tersedia untuk pelanggan berbayar. <a href="{{ route('customer.packages') }}" class="underline font-semibold">Berlangganan sekarang</a>
                        </p>
                    </div>
                    @endif

                    <!-- Search + Filter -->
                    <div class="flex flex-col sm:flex-row gap-3 mb-5">
                        <div class="relative flex-1">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input type="text" placeholder="Cari template..." x-model="templateSearch"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div class="flex gap-2 flex-wrap">
                            <template x-for="cat in templateCategories" :key="cat">
                                <button type="button" @click="templateFilter = (templateFilter === cat) ? 'all' : cat"
                                        class="px-3 py-1.5 rounded-lg text-xs font-medium transition-all"
                                        :class="templateFilter === cat ? 'bg-blue-500 text-white shadow-md shadow-blue-500/25' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'">
                                    <span x-text="cat === 'all' ? 'Semua' : cat"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Template Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($templates as $template)
                        @php $isLocked = $template->is_premium && !$hasActiveSubscription; @endphp
                        <div class="relative group"
                             x-show="(templateFilter === 'all' || '{{ strtolower($template->category) }}' === templateFilter) &amp;&amp; (templateSearch === '' || '{{ strtolower($template->name) }}'.includes(templateSearch.toLowerCase()))"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100">
                            <label class="{{ $isLocked ? 'cursor-not-allowed' : 'cursor-pointer' }} block">
                                <input type="radio" name="template_id" value="{{ $template->id }}" class="peer hidden"
                                       {{ $loop->first && !$isLocked ? 'checked' : '' }}
                                       {{ $isLocked ? 'disabled' : '' }}
                                       x-model="formData.template_id">
                                <div class="relative rounded-2xl border-2 border-gray-200 dark:border-gray-600 peer-checked:border-blue-500 peer-checked:ring-4 peer-checked:ring-blue-500/20 overflow-hidden transition-all duration-300 {{ $isLocked ? 'opacity-60' : 'group-hover:border-blue-300 group-hover:shadow-lg hover:scale-[1.02]' }}">
                                    <!-- Thumbnail Image -->
                                    <div class="aspect-[3/4] relative overflow-hidden bg-gray-100 dark:bg-gray-700">
                                        @if($template->thumbnail)
                                        <img src="{{ asset($template->thumbnail) }}" alt="{{ $template->name }}"
                                             class="w-full h-full object-cover object-top"
                                             loading="lazy">
                                        @else
                                        <div class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg, {{ $template->color_primary }}25, {{ $template->color_secondary }}15)">
                                            <div class="text-center p-4">
                                                <p class="text-[10px] uppercase tracking-widest mb-2 opacity-60" style="color: {{ $template->color_primary }}">{{ $template->category }}</p>
                                                <p class="text-sm font-serif font-semibold text-gray-800 dark:text-gray-200">{{ $template->name }}</p>
                                            </div>
                                        </div>
                                        @endif

                                        <!-- PRO Badge -->
                                        @if($template->is_premium)
                                        <div class="absolute top-2 right-2 z-20">
                                            <span class="px-2 py-0.5 {{ $isLocked ? 'bg-gray-500' : 'bg-gradient-to-r from-blue-500 to-purple-500' }} text-white text-[10px] font-bold rounded-full shadow-md">
                                                @if($isLocked)
                                                🔒 PRO
                                                @else
                                                ⭐ PRO
                                                @endif
                                            </span>
                                        </div>
                                        @endif

                                        <!-- Lock Overlay -->
                                        @if($isLocked)
                                        <div class="absolute inset-0 bg-black/40 backdrop-blur-[1px] flex flex-col items-center justify-center z-10">
                                            <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mb-2">
                                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                                            </div>
                                            <p class="text-white text-[11px] font-semibold">Berlangganan</p>
                                        </div>
                                        @endif

                                        <!-- Selected Checkmark -->
                                        <div class="absolute inset-0 bg-blue-500/20 flex items-center justify-center opacity-0 peer-checked:opacity-100 transition-opacity z-20">
                                            <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center shadow-lg shadow-blue-500/40 ring-4 ring-white/50">
                                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        </div>

                                        <!-- Hover Overlay: Demo Button -->
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-100 transition-opacity z-20 flex items-end justify-center pb-4">
                                            <a href="{{ route('demo.show', $template->slug) }}" target="_blank"
                                               onclick="event.stopPropagation();"
                                               class="inline-flex items-center gap-1.5 bg-white/95 hover:bg-white text-gray-900 text-xs font-semibold px-4 py-2 rounded-full shadow-lg transition-all hover:scale-105 no-underline">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                Preview
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Info Bar -->
                                    <div class="p-3 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $template->name }}</p>
                                        <div class="flex items-center justify-between mt-1.5">
                                            <div class="flex items-center gap-1">
                                                <div class="w-3 h-3 rounded-full border-2 border-white shadow-sm ring-1 ring-gray-200 dark:ring-gray-600" style="background: {{ $template->color_primary }}"></div>
                                                <div class="w-3 h-3 rounded-full border-2 border-white shadow-sm ring-1 ring-gray-200 dark:ring-gray-600" style="background: {{ $template->color_secondary }}"></div>
                                            </div>
                                            <span class="text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-wider">{{ $template->category }}</span>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2: Couple Information -->
        <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0">
            <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-rose-100 dark:bg-rose-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Informasi Mempelai</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Masukkan data kedua mempelai</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid lg:grid-cols-2 gap-8">
                        <!-- Groom -->
                        <div class="space-y-5">
                            <div class="flex items-center gap-2 pb-3 border-b border-gray-100 dark:border-gray-700">
                                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">Mempelai Pria</h3>
                            </div>
                            
                            <div class="relative">
                                <input type="text" name="groom_name" id="groom_name" value="{{ old('groom_name') }}" required
                                       class="peer w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-blue-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none transition-all placeholder-transparent"
                                       placeholder="Nama Lengkap">
                                <label for="groom_name" class="absolute left-4 -top-2.5 px-1 bg-white dark:bg-gray-800 text-xs font-medium text-gray-500 transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:bg-transparent peer-focus:-top-2.5 peer-focus:text-xs peer-focus:bg-white dark:peer-focus:bg-gray-800 peer-focus:text-blue-600">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div class="relative">
                                    <input type="text" name="groom_father" id="groom_father" value="{{ old('groom_father') }}"
                                           class="peer w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-blue-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none transition-all placeholder-transparent"
                                           placeholder="Nama Ayah">
                                    <label for="groom_father" class="absolute left-4 -top-2.5 px-1 bg-white dark:bg-gray-800 text-xs font-medium text-gray-500 transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:bg-transparent peer-focus:-top-2.5 peer-focus:text-xs peer-focus:bg-white dark:peer-focus:bg-gray-800 peer-focus:text-blue-600">
                                        Nama Ayah
                                    </label>
                                </div>
                                <div class="relative">
                                    <input type="text" name="groom_mother" id="groom_mother" value="{{ old('groom_mother') }}"
                                           class="peer w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-blue-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none transition-all placeholder-transparent"
                                           placeholder="Nama Ibu">
                                    <label for="groom_mother" class="absolute left-4 -top-2.5 px-1 bg-white dark:bg-gray-800 text-xs font-medium text-gray-500 transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:bg-transparent peer-focus:-top-2.5 peer-focus:text-xs peer-focus:bg-white dark:peer-focus:bg-gray-800 peer-focus:text-blue-600">
                                        Nama Ibu
                                    </label>
                                </div>
                            </div>
                            
                            <div class="relative">
                                <input type="text" name="groom_instagram" id="groom_instagram" value="{{ old('groom_instagram') }}"
                                       class="peer w-full px-4 py-3.5 pl-10 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-blue-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none transition-all placeholder-transparent"
                                       placeholder="@username">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z"/>
                                </svg>
                                <label for="groom_instagram" class="absolute left-10 -top-2.5 px-1 bg-white dark:bg-gray-800 text-xs font-medium text-gray-500 transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:bg-transparent peer-focus:-top-2.5 peer-focus:text-xs peer-focus:bg-white dark:peer-focus:bg-gray-800 peer-focus:text-blue-600">
                                    Instagram
                                </label>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Foto Mempelai Pria</label>
                                <div class="relative" x-data="{ groomPreview: null }">
                                    <input type="file" name="groom_photo" accept="image/*" class="hidden" id="groom_photo" @change="groomPreview = URL.createObjectURL($event.target.files[0])">
                                    <label for="groom_photo" class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl cursor-pointer hover:border-blue-400 hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-all">
                                        <template x-if="!groomPreview">
                                            <div class="text-center">
                                                <svg class="w-10 h-10 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <p class="text-sm text-gray-500">Klik untuk upload foto</p>
                                                <p class="text-xs text-gray-400 mt-1">PNG, JPG (max 2MB)</p>
                                            </div>
                                        </template>
                                        <template x-if="groomPreview">
                                            <img :src="groomPreview" class="w-full h-full object-cover rounded-xl">
                                        </template>
                                    </label>
                                </div>
                            </div>
                        </div>


                        <!-- Bride -->
                        <div class="space-y-5">
                            <div class="flex items-center gap-2 pb-3 border-b border-gray-100 dark:border-gray-700">
                                <div class="w-8 h-8 bg-rose-100 dark:bg-rose-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">Mempelai Wanita</h3>
                            </div>
                            
                            <div class="relative">
                                <input type="text" name="bride_name" id="bride_name" value="{{ old('bride_name') }}" required
                                       class="peer w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-blue-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none transition-all placeholder-transparent"
                                       placeholder="Nama Lengkap">
                                <label for="bride_name" class="absolute left-4 -top-2.5 px-1 bg-white dark:bg-gray-800 text-xs font-medium text-gray-500 transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:bg-transparent peer-focus:-top-2.5 peer-focus:text-xs peer-focus:bg-white dark:peer-focus:bg-gray-800 peer-focus:text-blue-600">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div class="relative">
                                    <input type="text" name="bride_father" id="bride_father" value="{{ old('bride_father') }}"
                                           class="peer w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-blue-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none transition-all placeholder-transparent"
                                           placeholder="Nama Ayah">
                                    <label for="bride_father" class="absolute left-4 -top-2.5 px-1 bg-white dark:bg-gray-800 text-xs font-medium text-gray-500 transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:bg-transparent peer-focus:-top-2.5 peer-focus:text-xs peer-focus:bg-white dark:peer-focus:bg-gray-800 peer-focus:text-blue-600">
                                        Nama Ayah
                                    </label>
                                </div>
                                <div class="relative">
                                    <input type="text" name="bride_mother" id="bride_mother" value="{{ old('bride_mother') }}"
                                           class="peer w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-blue-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none transition-all placeholder-transparent"
                                           placeholder="Nama Ibu">
                                    <label for="bride_mother" class="absolute left-4 -top-2.5 px-1 bg-white dark:bg-gray-800 text-xs font-medium text-gray-500 transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:bg-transparent peer-focus:-top-2.5 peer-focus:text-xs peer-focus:bg-white dark:peer-focus:bg-gray-800 peer-focus:text-blue-600">
                                        Nama Ibu
                                    </label>
                                </div>
                            </div>
                            
                            <div class="relative">
                                <input type="text" name="bride_instagram" id="bride_instagram" value="{{ old('bride_instagram') }}"
                                       class="peer w-full px-4 py-3.5 pl-10 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-blue-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none transition-all placeholder-transparent"
                                       placeholder="@username">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z"/>
                                </svg>
                                <label for="bride_instagram" class="absolute left-10 -top-2.5 px-1 bg-white dark:bg-gray-800 text-xs font-medium text-gray-500 transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:bg-transparent peer-focus:-top-2.5 peer-focus:text-xs peer-focus:bg-white dark:peer-focus:bg-gray-800 peer-focus:text-blue-600">
                                    Instagram
                                </label>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Foto Mempelai Wanita</label>
                                <div class="relative" x-data="{ bridePreview: null }">
                                    <input type="file" name="bride_photo" accept="image/*" class="hidden" id="bride_photo" @change="bridePreview = URL.createObjectURL($event.target.files[0])">
                                    <label for="bride_photo" class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl cursor-pointer hover:border-blue-400 hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-all">
                                        <template x-if="!bridePreview">
                                            <div class="text-center">
                                                <svg class="w-10 h-10 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <p class="text-sm text-gray-500">Klik untuk upload foto</p>
                                                <p class="text-xs text-gray-400 mt-1">PNG, JPG (max 2MB)</p>
                                            </div>
                                        </template>
                                        <template x-if="bridePreview">
                                            <img :src="bridePreview" class="w-full h-full object-cover rounded-xl">
                                        </template>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Step 3: Event Details -->
        <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0">
            <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Detail Acara</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Informasi waktu dan tempat acara</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Date & Time -->
                    <div class="grid md:grid-cols-3 gap-4">
                        <div class="relative">
                            <input type="date" name="event_date" id="event_date" value="{{ old('event_date') }}" required
                                   class="peer w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-blue-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none transition-all">
                            <label for="event_date" class="absolute left-4 -top-2.5 px-1 bg-white dark:bg-gray-800 text-xs font-medium text-gray-500">
                                Tanggal Acara <span class="text-red-500">*</span>
                            </label>
                        </div>
                        <div class="relative">
                            <input type="time" name="event_time_start" id="event_time_start" value="{{ old('event_time_start') }}" required
                                   class="peer w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-blue-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none transition-all">
                            <label for="event_time_start" class="absolute left-4 -top-2.5 px-1 bg-white dark:bg-gray-800 text-xs font-medium text-gray-500">
                                Jam Mulai <span class="text-red-500">*</span>
                            </label>
                        </div>
                        <div class="relative">
                            <input type="time" name="event_time_end" id="event_time_end" value="{{ old('event_time_end') }}"
                                   class="peer w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-blue-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none transition-all">
                            <label for="event_time_end" class="absolute left-4 -top-2.5 px-1 bg-white dark:bg-gray-800 text-xs font-medium text-gray-500">
                                Jam Selesai
                            </label>
                        </div>
                    </div>
                    
                    <!-- Venue -->
                    <div class="relative">
                        <input type="text" name="event_venue" id="event_venue" value="{{ old('event_venue') }}" required
                               class="peer w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-blue-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none transition-all placeholder-transparent"
                               placeholder="Nama Gedung / Tempat">
                        <label for="event_venue" class="absolute left-4 -top-2.5 px-1 bg-white dark:bg-gray-800 text-xs font-medium text-gray-500 transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:bg-transparent peer-focus:-top-2.5 peer-focus:text-xs peer-focus:bg-white dark:peer-focus:bg-gray-800 peer-focus:text-blue-600">
                            Nama Gedung / Tempat <span class="text-red-500">*</span>
                        </label>
                    </div>
                    
                    <!-- Address -->
                    <div class="relative">
                        <textarea name="event_address" id="event_address" rows="3"
                                  class="peer w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-blue-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none transition-all resize-none placeholder-transparent"
                                  placeholder="Alamat lengkap">{{ old('event_address') }}</textarea>
                        <label for="event_address" class="absolute left-4 -top-2.5 px-1 bg-white dark:bg-gray-800 text-xs font-medium text-gray-500 transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:bg-transparent peer-focus:-top-2.5 peer-focus:text-xs peer-focus:bg-white dark:peer-focus:bg-gray-800 peer-focus:text-blue-600">
                            Alamat Lengkap
                        </label>
                    </div>
                    
                    <!-- Maps URL -->
                    <div class="relative">
                        <input type="url" name="event_maps_url" id="event_maps_url" value="{{ old('event_maps_url') }}"
                               class="peer w-full px-4 py-3.5 pl-10 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-blue-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none transition-all placeholder-transparent"
                               placeholder="https://maps.google.com/...">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <label for="event_maps_url" class="absolute left-10 -top-2.5 px-1 bg-white dark:bg-gray-800 text-xs font-medium text-gray-500 transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:bg-transparent peer-focus:-top-2.5 peer-focus:text-xs peer-focus:bg-white dark:peer-focus:bg-gray-800 peer-focus:text-blue-600">
                            Link Google Maps
                        </label>
                    </div>
                    
                    <!-- Dress Code -->
                    <div class="relative">
                        <input type="text" name="dress_code" id="dress_code" value="{{ old('dress_code') }}"
                               class="peer w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-blue-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none transition-all placeholder-transparent"
                               placeholder="Sage Green / Formal Attire">
                        <label for="dress_code" class="absolute left-4 -top-2.5 px-1 bg-white dark:bg-gray-800 text-xs font-medium text-gray-500 transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:bg-transparent peer-focus:-top-2.5 peer-focus:text-xs peer-focus:bg-white dark:peer-focus:bg-gray-800 peer-focus:text-blue-600">
                            Dress Code (Opsional)
                        </label>
                    </div>
                </div>
            </div>
        </div>


        <!-- Step 4: Content & Messages -->
        <div x-show="currentStep === 4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0">
            <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Konten Undangan</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Kata pembuka, penutup, dan media</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Opening Text -->
                    <div class="relative">
                        <textarea name="opening_text" id="opening_text" rows="4"
                                  class="peer w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-blue-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none transition-all resize-none placeholder-transparent"
                                  placeholder="Kata Pembuka">{{ old('opening_text', 'Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud menyelenggarakan resepsi pernikahan kami.') }}</textarea>
                        <label for="opening_text" class="absolute left-4 -top-2.5 px-1 bg-white dark:bg-gray-800 text-xs font-medium text-gray-500 transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:bg-transparent peer-focus:-top-2.5 peer-focus:text-xs peer-focus:bg-white dark:peer-focus:bg-gray-800 peer-focus:text-blue-600">
                            Kata Pembuka
                        </label>
                    </div>
                    
                    <!-- Closing Text -->
                    <div class="relative">
                        <textarea name="closing_text" id="closing_text" rows="4"
                                  class="peer w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-blue-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none transition-all resize-none placeholder-transparent"
                                  placeholder="Kata Penutup">{{ old('closing_text', 'Merupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu. Atas kehadiran dan doa restunya, kami mengucapkan terima kasih.') }}</textarea>
                        <label for="closing_text" class="absolute left-4 -top-2.5 px-1 bg-white dark:bg-gray-800 text-xs font-medium text-gray-500 transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:bg-transparent peer-focus:-top-2.5 peer-focus:text-xs peer-focus:bg-white dark:peer-focus:bg-gray-800 peer-focus:text-blue-600">
                            Kata Penutup
                        </label>
                    </div>
                    
                    <!-- Cover Image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cover Image (Opsional)</label>
                        <div class="relative" x-data="{ coverPreview: null }">
                            <input type="file" name="cover_image" accept="image/*" class="hidden" id="cover_image" @change="coverPreview = URL.createObjectURL($event.target.files[0])">
                            <label for="cover_image" class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl cursor-pointer hover:border-blue-400 hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-all">
                                <template x-if="!coverPreview">
                                    <div class="text-center">
                                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="text-sm text-gray-500 mb-1">Upload cover image untuk undangan</p>
                                        <p class="text-xs text-gray-400">PNG, JPG (Rekomendasi: 1920x1080)</p>
                                    </div>
                                </template>
                                <template x-if="coverPreview">
                                    <img :src="coverPreview" class="w-full h-full object-cover rounded-xl">
                                </template>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Info Box -->
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <div class="text-sm">
                                <p class="font-medium text-blue-800 dark:text-blue-200">Tips</p>
                                <p class="text-blue-700 dark:text-blue-300 mt-1">Anda dapat menambahkan galeri foto, musik, dan informasi amplop digital setelah undangan dibuat melalui halaman edit.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Step 5: Preview & Submit -->
        <div x-show="currentStep === 5" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0">
            <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Konfirmasi & Simpan</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Periksa kembali informasi undangan Anda</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <!-- Summary Cards -->
                    <div class="grid md:grid-cols-2 gap-6 mb-8">
                        <!-- Couple Summary -->
                        <div class="p-5 bg-gradient-to-br from-rose-50 to-blue-50 dark:from-rose-900/20 dark:to-blue-900/20 rounded-2xl border border-rose-100 dark:border-rose-800">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-rose-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                                Mempelai
                            </h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Pria:</span>
                                    <span class="font-medium text-gray-900 dark:text-white" x-text="summary.groom_name || '-'">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Wanita:</span>
                                    <span class="font-medium text-gray-900 dark:text-white" x-text="summary.bride_name || '-'">-</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Event Summary -->
                        <div class="p-5 bg-gradient-to-br from-purple-50 to-blue-50 dark:from-purple-900/20 dark:to-blue-900/20 rounded-2xl border border-purple-100 dark:border-purple-800">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Acara
                            </h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Tanggal:</span>
                                    <span class="font-medium text-gray-900 dark:text-white" x-text="summary.event_date || '-'">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Tempat:</span>
                                    <span class="font-medium text-gray-900 dark:text-white truncate max-w-[150px]" x-text="summary.event_venue || '-'">-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Checklist -->
                    <div class="p-5 bg-gray-50 dark:bg-gray-700/50 rounded-2xl mb-6">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-4">Checklist Kelengkapan</h4>
                        <div class="grid sm:grid-cols-2 gap-3">
                            <div class="flex items-center gap-2 text-sm">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300">Template dipilih</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300">Informasi mempelai</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300">Detail acara</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300">Konten undangan</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Note -->
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <div class="text-sm">
                                <p class="font-medium text-blue-800 dark:text-blue-200">Catatan</p>
                                <p class="text-blue-700 dark:text-blue-300 mt-1">Undangan akan disimpan sebagai draft. Anda dapat mengedit dan menambahkan fitur lainnya seperti galeri foto, musik, dan amplop digital sebelum mempublikasikan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">
            <button type="button" 
                    @click="prevStep()" 
                    x-show="currentStep > 1"
                    class="flex items-center gap-2 px-6 py-3 text-gray-600 dark:text-gray-400 font-medium hover:text-gray-900 dark:hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Sebelumnya
            </button>
            <div x-show="currentStep === 1"></div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('customer.invitations.index') }}" class="px-6 py-3 text-gray-500 hover:text-gray-700 font-medium transition-colors">
                    Batal
                </a>
                
                <button type="button" 
                        @click="nextStep()"
                        x-show="currentStep < 5"
                        class="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40">
                    Selanjutnya
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
                
                <button type="submit" 
                        x-show="currentStep === 5"
                        :disabled="submitting"
                        class="flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-emerald-700 transition-all shadow-lg shadow-green-500/25 hover:shadow-green-500/40 disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg x-show="!submitting" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <svg x-show="submitting" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span x-text="submitting ? 'Menyimpan...' : 'Buat Undangan'"></span>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
function invitationWizard() {
    return {
        currentStep: 1,
        maxStep: 1,
        submitting: false,
        formData: {
            template_id: '{{ $templates->first()->id ?? '' }}'
        },
        templateSearch: '',
        templateFilter: 'all',
        templateCategories: ['all', 'elegant', 'minimal', 'luxury', 'floral', 'islamic', 'traditional', 'rustic', 'modern', 'vintage', 'tropical'],
        summary: {
            groom_name: '',
            bride_name: '',
            event_date: '',
            event_venue: ''
        },
        steps: [
            { title: 'Template', icon: 'template' },
            { title: 'Mempelai', icon: 'couple' },
            { title: 'Acara', icon: 'event' },
            { title: 'Konten', icon: 'content' },
            { title: 'Konfirmasi', icon: 'confirm' }
        ],
        
        nextStep() {
            if (this.currentStep < 5) {
                // Basic validation for required fields
                if (!this.validateCurrentStep()) {
                    return;
                }
                this.currentStep++;
                this.maxStep = Math.max(this.maxStep, this.currentStep);
                
                // Update summary when entering step 5
                if (this.currentStep === 5) {
                    this.updateSummary();
                }
                
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        },
        
        prevStep() {
            if (this.currentStep > 1) {
                this.currentStep--;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        },
        
        goToStep(step) {
            if (step <= this.maxStep) {
                this.currentStep = step;
                
                // Update summary when going to step 5
                if (this.currentStep === 5) {
                    this.updateSummary();
                }
                
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        },
        
        validateCurrentStep() {
            // Step 2: Validate couple names
            if (this.currentStep === 2) {
                const groomName = document.querySelector('[name="groom_name"]').value;
                const brideName = document.querySelector('[name="bride_name"]').value;
                if (!groomName || !brideName) {
                    alert('Mohon lengkapi nama mempelai pria dan wanita');
                    return false;
                }
            }
            
            // Step 3: Validate event details
            if (this.currentStep === 3) {
                const eventDate = document.querySelector('[name="event_date"]').value;
                const eventTime = document.querySelector('[name="event_time_start"]').value;
                const eventVenue = document.querySelector('[name="event_venue"]').value;
                if (!eventDate || !eventTime || !eventVenue) {
                    alert('Mohon lengkapi tanggal, jam, dan tempat acara');
                    return false;
                }
            }
            
            return true;
        },
        
        updateSummary() {
            this.summary.groom_name = document.querySelector('[name="groom_name"]')?.value || '';
            this.summary.bride_name = document.querySelector('[name="bride_name"]')?.value || '';
            this.summary.event_date = document.querySelector('[name="event_date"]')?.value || '';
            this.summary.event_venue = document.querySelector('[name="event_venue"]')?.value || '';
        }
    };
}
</script>
@endsection
