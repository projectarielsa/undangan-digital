@extends('layouts.app')
@section('title', 'Undangan Digital Premium - Buat Undangan Pernikahan Online')

@section('body')
<!-- Navbar -->
<nav class="fixed w-full z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-100 dark:border-gray-800" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <a href="/" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-gradient-to-br from-amber-500 to-amber-700 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
                </div>
                <span class="text-lg font-bold text-gray-900 dark:text-white">UndanganDigital</span>
            </a>
            <div class="hidden md:flex items-center gap-8">
                <a href="#features" class="text-sm text-gray-600 dark:text-gray-300 hover:text-amber-600 transition">Fitur</a>
                <a href="#templates" class="text-sm text-gray-600 dark:text-gray-300 hover:text-amber-600 transition">Template</a>
                <a href="#pricing" class="text-sm text-gray-600 dark:text-gray-300 hover:text-amber-600 transition">Harga</a>
                <a href="#testimonials" class="text-sm text-gray-600 dark:text-gray-300 hover:text-amber-600 transition">Testimoni</a>
            </div>
            <div class="hidden md:flex items-center gap-3">
                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-amber-600 transition">Masuk</a>
                <a href="{{ route('register') }}" class="px-5 py-2.5 bg-gradient-to-r from-amber-600 to-amber-700 text-white text-sm font-semibold rounded-full shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 transition-all">Mulai Gratis</a>
            </div>
            <button @click="open = !open" class="md:hidden p-2 text-gray-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg></button>
        </div>
    </div>
    <div x-show="open" x-transition class="md:hidden bg-white dark:bg-gray-900 border-t p-4 space-y-3">
        <a href="#features" class="block py-2 text-gray-600">Fitur</a>
        <a href="#pricing" class="block py-2 text-gray-600">Harga</a>
        <a href="{{ route('login') }}" class="block py-2 text-gray-600">Masuk</a>
        <a href="{{ route('register') }}" class="block py-2 px-4 bg-amber-600 text-white text-center rounded-full font-semibold">Mulai Gratis</a>
    </div>
</nav>

<!-- Hero -->
<section class="relative pt-32 pb-20 lg:pt-40 lg:pb-32 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-amber-50/50 to-white dark:from-gray-900 dark:to-gray-900 pointer-events-none"></div>
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[800px] bg-amber-200/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-4xl mx-auto">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 rounded-full text-sm font-medium mb-6">
                <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>Platform Undangan #1 di Indonesia
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white leading-tight mb-6 font-serif">
                Buat Undangan Digital <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-600 to-amber-800">Premium</span> dalam Hitungan Menit
            </h1>
            <p class="text-lg sm:text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto mb-10">Undangan pernikahan online yang elegan, modern, dan berkesan. Dengan fitur lengkap RSVP, musik, galeri, countdown, dan amplop digital.</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-amber-600 to-amber-700 text-white font-semibold rounded-full shadow-xl shadow-amber-500/30 hover:shadow-amber-500/50 transition-all transform hover:scale-105 text-lg">Buat Undangan Sekarang</a>
                <a href="#templates" class="w-full sm:w-auto px-8 py-4 border-2 border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-full hover:border-amber-300 hover:text-amber-600 transition-all text-lg">Lihat Template</a>
            </div>
            <div class="mt-12 flex items-center justify-center gap-8 text-sm text-gray-500 dark:text-gray-400">
                <div class="flex items-center gap-2"><svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"/></svg> Gratis trial</div>
                <div class="flex items-center gap-2"><svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"/></svg> Setup 5 menit</div>
                <div class="flex items-center gap-2"><svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"/></svg> Mobile friendly</div>
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
@endsection
