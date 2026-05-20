@extends('layouts.app')
@section('title', $title ?? 'Auth')

@section('body')
<div class="min-h-screen flex">
    <!-- Left Side - Branding -->
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-gradient-to-br from-blue-900 via-blue-800 to-yellow-900">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-20 w-72 h-72 bg-blue-300 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-yellow-300 rounded-full blur-3xl"></div>
        </div>
        <div class="relative z-10 flex flex-col justify-center items-center w-full p-12 text-white">
            <div class="max-w-md text-center">
                <div class="inline-flex items-center justify-center w-28 h-28 bg-white/10 backdrop-blur-sm rounded-3xl mb-6">
                    <img src="/image/logo.png" alt="Ellori" class="w-24 h-24 object-contain">
                </div>
                <p class="text-blue-100/80 text-lg leading-relaxed">Buat undangan pernikahan digital yang elegan, modern, dan berkesan untuk hari spesial Anda.</p>
                <div class="mt-12 space-y-4">
                    <div class="flex items-center gap-3 text-blue-100/70">
                        <svg class="w-5 h-5 text-blue-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"/></svg>
                        <span>Template premium & elegan</span>
                    </div>
                    <div class="flex items-center gap-3 text-blue-100/70">
                        <svg class="w-5 h-5 text-blue-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"/></svg>
                        <span>RSVP & manajemen tamu</span>
                    </div>
                    <div class="flex items-center gap-3 text-blue-100/70">
                        <svg class="w-5 h-5 text-blue-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"/></svg>
                        <span>Mudah, cepat, & mobile friendly</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Right Side - Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12">
        <div class="w-full max-w-md">
            <div class="lg:hidden text-center mb-8">
                <h1 class="text-2xl font-bold font-serif text-blue-900 dark:text-blue-300">Ellori</h1>
            </div>
            @yield('content')
        </div>
    </div>
</div>
@endsection
