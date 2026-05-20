@extends('layouts.app')
@section('title', 'Undangan Digital Premium - Buat Undangan Pernikahan Online')

@section('body')
<div x-data="{ scrollY: 0 }" @scroll.window="scrollY = window.scrollY">
<!-- Navbar -->
<nav class="fixed w-full z-50 transition-all duration-500"
     :class="scrollY > 50 ? 'bg-white/90 dark:bg-gray-900/90 backdrop-blur-xl shadow-lg shadow-black/5' : 'bg-transparent'"
     x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <a href="/" class="flex items-center gap-3 group">
                <div class="relative">
                    <div class="w-10 h-10 bg-gradient-to-br from-amber-400 via-amber-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/30 group-hover:shadow-amber-500/50 transition-all duration-300 group-hover:scale-110">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                        </svg>
                    </div>
                    <div class="absolute -inset-1 bg-gradient-to-r from-amber-400 to-amber-600 rounded-xl blur opacity-30 group-hover:opacity-50 transition-opacity"></div>
                </div>
                <span class="text-xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">UndanganDigital</span>
            </a>
            
            <div class="hidden md:flex items-center gap-1">
                <a href="#features" class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-amber-600 dark:hover:text-amber-400 rounded-lg hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-all">Fitur</a>
                <a href="#templates" class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-amber-600 dark:hover:text-amber-400 rounded-lg hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-all">Template</a>
                <a href="#pricing" class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-amber-600 dark:hover:text-amber-400 rounded-lg hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-all">Harga</a>
                <a href="#testimonials" class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-amber-600 dark:hover:text-amber-400 rounded-lg hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-all">Testimoni</a>
            </div>
            
            <div class="hidden md:flex items-center gap-3">
                <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-amber-600 transition-colors">Masuk</a>
                <a href="{{ route('register') }}" class="group relative px-6 py-2.5 text-sm font-semibold text-white rounded-full overflow-hidden transition-all hover:scale-105 hover:shadow-xl hover:shadow-amber-500/25">
                    <div class="absolute inset-0 bg-gradient-to-r from-amber-500 via-amber-600 to-amber-500 bg-size-200 bg-pos-0 group-hover:bg-pos-100 transition-all duration-500"></div>
                    <span class="relative flex items-center gap-2">
                        Mulai Gratis
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </span>
                </a>
            </div>
            
            <button @click="open = !open" class="md:hidden p-2 text-gray-600 hover:bg-gray-100 rounded-xl transition">
                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>


    <!-- Mobile Menu -->
    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" 
         class="md:hidden absolute top-full left-0 right-0 bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 shadow-xl p-4 space-y-2">
        <a href="#features" @click="open = false" class="block py-3 px-4 text-gray-600 dark:text-gray-300 hover:bg-amber-50 dark:hover:bg-amber-900/20 rounded-xl transition">Fitur</a>
        <a href="#templates" @click="open = false" class="block py-3 px-4 text-gray-600 dark:text-gray-300 hover:bg-amber-50 dark:hover:bg-amber-900/20 rounded-xl transition">Template</a>
        <a href="#pricing" @click="open = false" class="block py-3 px-4 text-gray-600 dark:text-gray-300 hover:bg-amber-50 dark:hover:bg-amber-900/20 rounded-xl transition">Harga</a>
        <a href="#testimonials" @click="open = false" class="block py-3 px-4 text-gray-600 dark:text-gray-300 hover:bg-amber-50 dark:hover:bg-amber-900/20 rounded-xl transition">Testimoni</a>
        <hr class="border-gray-100 dark:border-gray-800">
        <a href="{{ route('login') }}" class="block py-3 px-4 text-gray-600 dark:text-gray-300 hover:bg-gray-50 rounded-xl transition">Masuk</a>
        <a href="{{ route('register') }}" class="block py-3 px-4 bg-gradient-to-r from-amber-500 to-amber-600 text-white text-center font-semibold rounded-xl">Mulai Gratis</a>
    </div>
</nav>

<!-- Hero Section -->
<section class="relative min-h-screen flex items-center overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0 bg-gradient-to-br from-amber-50 via-white to-rose-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800">
        <!-- Gradient Orbs -->
        <div class="absolute top-0 left-1/4 w-[600px] h-[600px] bg-gradient-to-br from-amber-200/40 to-transparent rounded-full blur-3xl" 
             :style="`transform: translateY(${scrollY * 0.1}px)`"></div>
        <div class="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-gradient-to-br from-rose-200/40 to-transparent rounded-full blur-3xl"
             :style="`transform: translateY(${-scrollY * 0.15}px)`"></div>
        <div class="absolute top-1/3 right-10 w-[300px] h-[300px] bg-gradient-to-br from-amber-300/20 to-transparent rounded-full blur-2xl"
             :style="`transform: translateY(${scrollY * 0.2}px)`"></div>
    </div>
    
    <!-- Floating Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Hearts -->
        <div class="absolute top-[15%] left-[10%] text-amber-300/30 animate-float" style="animation-delay: 0s;">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
        </div>
        <div class="absolute top-[25%] right-[15%] text-rose-300/30 animate-float" style="animation-delay: 1s;">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
        </div>
        <div class="absolute bottom-[30%] left-[20%] text-amber-400/20 animate-float" style="animation-delay: 2s;">
            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
        </div>
        <!-- Rings -->
        <div class="absolute top-[40%] right-[8%] text-amber-300/20 animate-spin-slow">
            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="1"/></svg>
        </div>
        <!-- Sparkles -->
        <div class="absolute top-[20%] left-[30%] text-amber-400/40 animate-pulse">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L9.19 8.63L2 9.24l5.46 4.73L5.82 21L12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2z"/></svg>
        </div>
    </div>


    <!-- Hero Content -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-20 lg:pt-40 lg:pb-32">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <!-- Left Content -->
            <div class="text-center lg:text-left">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-amber-100 to-rose-100 dark:from-amber-900/30 dark:to-rose-900/30 rounded-full mb-8 animate-fade-in-up">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                    </span>
                    <span class="text-sm font-semibold bg-gradient-to-r from-amber-600 to-rose-600 bg-clip-text text-transparent">Dipercaya Ribuan Pasangan Indonesia</span>
                </div>
                
                <!-- Heading -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold leading-tight mb-6 animate-fade-in-up" style="animation-delay: 0.1s;">
                    <span class="text-gray-900 dark:text-white">Buat Undangan</span><br>
                    <span class="relative">
                        <span class="bg-gradient-to-r from-amber-500 via-amber-600 to-rose-500 bg-clip-text text-transparent">Digital Premium</span>
                        <svg class="absolute -bottom-2 left-0 w-full" viewBox="0 0 300 12" fill="none">
                            <path d="M2 10C50 4 100 4 150 7C200 10 250 6 298 3" stroke="url(#gradient)" stroke-width="3" stroke-linecap="round"/>
                            <defs><linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%"><stop offset="0%" stop-color="#F59E0B"/><stop offset="100%" stop-color="#F43F5E"/></linearGradient></defs>
                        </svg>
                    </span>
                </h1>
                
                <p class="text-lg sm:text-xl text-gray-600 dark:text-gray-300 max-w-xl mx-auto lg:mx-0 mb-10 animate-fade-in-up" style="animation-delay: 0.2s;">
                    Undangan pernikahan online yang elegan, modern, dan berkesan. Dengan fitur lengkap RSVP, musik, galeri, countdown, dan amplop digital.
                </p>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 mb-12 animate-fade-in-up" style="animation-delay: 0.3s;">
                    <a href="{{ route('register') }}" class="group relative w-full sm:w-auto">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-amber-500 to-rose-500 rounded-full blur opacity-60 group-hover:opacity-100 transition duration-500"></div>
                        <div class="relative px-8 py-4 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-semibold rounded-full flex items-center justify-center gap-2 group-hover:shadow-2xl transition-all duration-300">
                            Buat Undangan Sekarang
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </div>
                    </a>
                    <a href="#templates" class="group w-full sm:w-auto px-8 py-4 border-2 border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-full flex items-center justify-center gap-2 hover:border-amber-300 hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-all">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6z"/>
                        </svg>
                        Lihat Template
                    </a>
                </div>


                <!-- Trust Badges -->
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-6 text-sm text-gray-500 dark:text-gray-400 animate-fade-in-up" style="animation-delay: 0.4s;">
                    <div class="flex items-center gap-2">
                        <div class="w-5 h-5 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                            <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        <span>Gratis trial 7 hari</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-5 h-5 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                            <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        <span>Setup 5 menit</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-5 h-5 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                            <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        <span>100% Responsive</span>
                    </div>
                </div>
            </div>
            
            <!-- Right Content - Preview Card -->
            <div class="relative animate-fade-in-up lg:animate-fade-in-right" style="animation-delay: 0.5s;">
                <div class="relative">
                    <!-- Glow Effect -->
                    <div class="absolute -inset-4 bg-gradient-to-r from-amber-400 to-rose-400 rounded-3xl blur-2xl opacity-20"></div>
                    
                    <!-- Main Card -->
                    <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl shadow-gray-200/50 dark:shadow-none overflow-hidden border border-gray-100 dark:border-gray-700">
                        <!-- Card Header -->
                        <div class="bg-gradient-to-r from-amber-500 to-rose-500 p-6 text-center">
                            <p class="text-white/80 text-xs uppercase tracking-widest mb-2">The Wedding of</p>
                            <h3 class="text-2xl font-serif text-white font-bold">Romeo & Juliet</h3>
                        </div>
                        
                        <!-- Card Body -->
                        <div class="p-6">
                            <!-- Date -->
                            <div class="text-center mb-6">
                                <p class="text-gray-500 text-sm mb-1">Save The Date</p>
                                <p class="text-xl font-semibold text-gray-900 dark:text-white">25 Desember 2025</p>
                            </div>
                            
                            <!-- Features Preview -->
                            <div class="grid grid-cols-3 gap-4 mb-6">
                                <div class="text-center p-3 bg-amber-50 dark:bg-amber-900/20 rounded-2xl">
                                    <svg class="w-6 h-6 mx-auto text-amber-600 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                                    </svg>
                                    <span class="text-xs text-gray-600 dark:text-gray-400">Musik</span>
                                </div>
                                <div class="text-center p-3 bg-rose-50 dark:bg-rose-900/20 rounded-2xl">
                                    <svg class="w-6 h-6 mx-auto text-rose-600 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-xs text-gray-600 dark:text-gray-400">Galeri</span>
                                </div>
                                <div class="text-center p-3 bg-amber-50 dark:bg-amber-900/20 rounded-2xl">
                                    <svg class="w-6 h-6 mx-auto text-amber-600 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-xs text-gray-600 dark:text-gray-400">Countdown</span>
                                </div>
                            </div>
                            
                            <!-- Mock Button -->
                            <div class="bg-gradient-to-r from-amber-500 to-amber-600 text-white text-center py-3 rounded-xl font-medium">
                                Buka Undangan
                            </div>
                        </div>
                    </div>
                    
                    <!-- Floating Elements -->
                    <div class="absolute -top-4 -right-4 w-20 h-20 bg-gradient-to-br from-rose-400 to-rose-500 rounded-2xl shadow-lg flex items-center justify-center animate-bounce-slow">
                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </div>
                    <div class="absolute -bottom-4 -left-4 w-16 h-16 bg-gradient-to-br from-amber-400 to-amber-500 rounded-2xl shadow-lg flex items-center justify-center animate-float">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
        <a href="#features" class="flex flex-col items-center gap-2 text-gray-400 hover:text-amber-500 transition-colors">
            <span class="text-xs uppercase tracking-widest">Scroll</span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </a>
    </div>
</section>


<!-- Stats Section -->
<section class="py-16 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-amber-500 to-rose-500"></div>
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0zNiAxOGMzLjMxNCAwIDYgMi42ODYgNiA2cy0yLjY4NiA2LTYgNi02LTIuNjg2LTYtNiAyLjY4Ni02IDYtNiIgc3Ryb2tlPSJyZ2JhKDI1NSwyNTUsMjU1LDAuMSkiIHN0cm9rZS13aWR0aD0iMiIvPjwvZz48L3N2Zz4=')] opacity-30"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center" x-data="{ count: 0, target: 5000 }" x-intersect.once="let interval = setInterval(() => { if(count < target) count += 100; else clearInterval(interval); }, 20)">
                <p class="text-4xl sm:text-5xl font-bold text-white mb-2"><span x-text="count.toLocaleString()">0</span>+</p>
                <p class="text-white/80 text-sm">Undangan Dibuat</p>
            </div>
            <div class="text-center" x-data="{ count: 0, target: 10 }" x-intersect.once="let interval = setInterval(() => { if(count < target) count += 1; else clearInterval(interval); }, 100)">
                <p class="text-4xl sm:text-5xl font-bold text-white mb-2"><span x-text="count">0</span>+</p>
                <p class="text-white/80 text-sm">Template Premium</p>
            </div>
            <div class="text-center" x-data="{ count: 0, target: 99 }" x-intersect.once="let interval = setInterval(() => { if(count < target) count += 1; else clearInterval(interval); }, 30)">
                <p class="text-4xl sm:text-5xl font-bold text-white mb-2"><span x-text="count">0</span>%</p>
                <p class="text-white/80 text-sm">Kepuasan Pelanggan</p>
            </div>
            <div class="text-center" x-data="{ count: 0, target: 24 }" x-intersect.once="let interval = setInterval(() => { if(count < target) count += 1; else clearInterval(interval); }, 80)">
                <p class="text-4xl sm:text-5xl font-bold text-white mb-2"><span x-text="count">0</span>/7</p>
                <p class="text-white/80 text-sm">Support Online</p>
            </div>
        </div>
    </div>
</section>

@include('components.landing.features')
@include('components.landing.templates')
@include('components.landing.pricing')
@include('components.landing.testimonials')
@include('components.landing.faq')
@include('components.landing.cta')
@include('components.landing.footer')
</div>

<style>
    @keyframes fade-in-up { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fade-in-right { from { opacity: 0; transform: translateX(-20px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
    @keyframes bounce-slow { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
    @keyframes spin-slow { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    
    .animate-fade-in-up { animation: fade-in-up 0.8s ease-out forwards; opacity: 0; }
    .animate-fade-in-right { animation: fade-in-right 0.8s ease-out forwards; opacity: 0; }
    .animate-float { animation: float 3s ease-in-out infinite; }
    .animate-bounce-slow { animation: bounce-slow 2s ease-in-out infinite; }
    .animate-spin-slow { animation: spin-slow 20s linear infinite; }
    
    .bg-size-200 { background-size: 200% 100%; }
    .bg-pos-0 { background-position: 0% 0%; }
    .bg-pos-100 { background-position: 100% 0%; }
</style>
@endsection
