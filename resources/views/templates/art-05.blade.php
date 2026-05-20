<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Montserrat:wght@300;400;500;600&family=Great+Vibes&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --color-primary: {{ $invitation->color_primary ?? '#D4A574' }};
            --color-secondary: {{ $invitation->color_secondary ?? '#2C2C2C' }};
            --color-accent: {{ $invitation->color_accent ?? '#F8F5F0' }};
        }
        .font-display { font-family: 'Cormorant Garamond', serif; }
        .font-body { font-family: 'Montserrat', sans-serif; }
        .font-script { font-family: 'Great Vibes', cursive; }
        [x-cloak] { display: none !important; }
        .animate-spin-slow { animation: spin 3s linear infinite; }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes pulse-slow { 0%, 100% { opacity: 0.6; } 50% { opacity: 1; } }
        @keyframes slideUp { from { opacity: 0; transform: translateY(100px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in-up { animation: fadeInUp 1s ease-out forwards; }
        .animate-fade-in { animation: fadeIn 1.5s ease-out forwards; }
        .animate-pulse-slow { animation: pulse-slow 3s ease-in-out infinite; }
        .animate-slide-up { animation: slideUp 1s ease-out forwards; }
        .cover-gradient { 
            background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.1) 30%, rgba(0,0,0,0.1) 70%, rgba(0,0,0,0.5) 100%);
        }
        .section-reveal { opacity: 0; transform: translateY(30px); transition: all 0.8s ease; }
        .section-reveal.active { opacity: 1; transform: translateY(0); }
        .gallery-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; }
        @media (min-width: 768px) { .gallery-grid { grid-template-columns: repeat(3, 1fr); gap: 12px; } }
    </style>
</head>
<body class="font-body bg-[var(--color-accent)] text-[var(--color-secondary)] overflow-x-hidden" x-data="invitationApp()" x-cloak>


    <!-- ==================== OPENING COVER WITH PREWED BACKGROUND ==================== -->
    <section x-show="!opened" class="fixed inset-0 z-50"
        x-transition:leave="transition ease-in duration-700"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        
        <!-- Background Image - Uses first gallery photo or groom/bride photo -->
        <div class="absolute inset-0">
            @php
                $coverImage = null;
                if($invitation->galleries->count() > 0) {
                    $coverImage = $invitation->galleries->first()->getImageUrl();
                } elseif($invitation->groom_photo) {
                    $coverImage = asset('storage/' . $invitation->groom_photo);
                }
            @endphp
            
            @if($coverImage)
            <img src="{{ $coverImage }}" alt="Cover" class="w-full h-full object-cover">
            @else
            <div class="w-full h-full bg-gradient-to-br from-gray-800 to-gray-900"></div>
            @endif
        </div>
        
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 cover-gradient"></div>
        
        <!-- Decorative Frame -->
        <div class="absolute inset-4 sm:inset-8 border border-white/20 rounded-lg pointer-events-none"></div>
        <div class="absolute inset-6 sm:inset-12 border border-white/10 rounded-lg pointer-events-none"></div>
        
        <!-- Content -->
        <div class="relative z-10 flex flex-col items-center justify-center min-h-screen px-6 text-center text-white">
            <!-- Top ornament -->
            <div class="mb-6 animate-pulse-slow">
                <svg class="w-16 h-16 mx-auto text-white/60" viewBox="0 0 100 50" fill="currentColor">
                    <path d="M50 45 C40 40, 20 35, 5 40 C20 30, 40 32, 50 25 C60 32, 80 30, 95 40 C80 35, 60 40, 50 45Z" opacity="0.5"/>
                    <path d="M50 40 C42 36, 28 33, 15 37 C28 28, 42 30, 50 23 C58 30, 72 28, 85 37 C72 33, 58 36, 50 40Z" opacity="0.7"/>
                </svg>
            </div>
            
            <p class="text-xs sm:text-sm uppercase tracking-[0.4em] text-white/80 mb-4 font-body font-light animate-fade-in" style="animation-delay: 0.2s;">
                The Wedding of
            </p>
            
            <h1 class="text-4xl sm:text-6xl md:text-7xl font-display font-semibold mb-2 animate-fade-in-up" style="animation-delay: 0.4s;">
                {{ $invitation->groom_name }}
            </h1>
            
            <p class="text-5xl sm:text-6xl font-script text-[var(--color-primary)] my-2 animate-fade-in" style="animation-delay: 0.6s;">&</p>
            
            <h1 class="text-4xl sm:text-6xl md:text-7xl font-display font-semibold mb-8 animate-fade-in-up" style="animation-delay: 0.8s;">
                {{ $invitation->bride_name }}
            </h1>


            <!-- Date -->
            <p class="text-sm sm:text-base text-white/70 font-light tracking-wider mb-8 animate-fade-in" style="animation-delay: 1s;">
                {{ $invitation->event_date->translatedFormat('d . m . Y') }}
            </p>
            
            @if($guestName)
            <div class="mb-8 animate-fade-in" style="animation-delay: 1.2s;">
                <p class="text-xs uppercase tracking-[0.2em] text-white/50 mb-2">Kepada Yth.</p>
                <p class="text-lg sm:text-xl font-display font-medium text-white">{{ urldecode($guestName) }}</p>
                @if($guest && $guest->invited_by)
                <p class="text-xs text-[var(--color-primary)] mt-2">Turut Mengundang: {{ $guest->invited_by }}</p>
                @endif
            </div>
            @endif
            
            <!-- Open Button -->
            <button @click="openInvitation()"
                class="group relative px-10 py-4 bg-white/10 backdrop-blur-sm border border-white/30 text-white font-body text-sm uppercase tracking-[0.2em] rounded-full overflow-hidden transition-all duration-500 hover:bg-white hover:text-[var(--color-secondary)] animate-slide-up" style="animation-delay: 1.4s;">
                <span class="relative z-10 flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Buka Undangan
                </span>
            </button>
            
            <!-- Bottom ornament -->
            <div class="mt-8 animate-pulse-slow">
                <svg class="w-16 h-16 mx-auto text-white/60 rotate-180" viewBox="0 0 100 50" fill="currentColor">
                    <path d="M50 45 C40 40, 20 35, 5 40 C20 30, 40 32, 50 25 C60 32, 80 30, 95 40 C80 35, 60 40, 50 45Z" opacity="0.5"/>
                    <path d="M50 40 C42 36, 28 33, 15 37 C28 28, 42 30, 50 23 C58 30, 72 28, 85 37 C72 33, 58 36, 50 40Z" opacity="0.7"/>
                </svg>
            </div>
        </div>
        
        <!-- Scroll indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 text-white/50 animate-bounce">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </section>


    <!-- ==================== MAIN CONTENT ==================== -->
    <div x-show="opened" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

        <!-- ========== HERO SECTION ========== -->
        <section class="min-h-screen flex items-center justify-center relative py-20 px-6 bg-[var(--color-accent)]">
            <!-- Decorative background -->
            <div class="absolute inset-0 opacity-5">
                <div class="absolute top-20 left-10 w-64 h-64 bg-[var(--color-primary)] rounded-full blur-3xl"></div>
                <div class="absolute bottom-20 right-10 w-80 h-80 bg-[var(--color-primary)] rounded-full blur-3xl"></div>
            </div>
            
            <div class="text-center relative z-10 max-w-lg">
                <!-- Decorative leaf -->
                <div class="flex justify-center mb-8">
                    <svg class="w-40 h-16 text-[var(--color-primary)] opacity-40" viewBox="0 0 160 60" fill="currentColor">
                        <path d="M80 55 C65 48, 35 42, 10 48 C35 35, 65 38, 80 30 C95 38, 125 35, 150 48 C125 42, 95 48, 80 55Z" opacity="0.5"/>
                        <path d="M80 48 C68 42, 45 38, 25 43 C45 32, 68 35, 80 28 C92 35, 115 32, 135 43 C115 38, 92 42, 80 48Z" opacity="0.7"/>
                    </svg>
                </div>
                
                <p class="text-xs uppercase tracking-[0.4em] text-[var(--color-primary)] mb-6 font-body">We're Getting Married</p>
                <h2 class="text-5xl sm:text-6xl font-display font-bold text-[var(--color-secondary)] mb-2">{{ $invitation->groom_name }}</h2>
                <p class="text-5xl sm:text-6xl font-script text-[var(--color-primary)] my-4">&</p>
                <h2 class="text-5xl sm:text-6xl font-display font-bold text-[var(--color-secondary)]">{{ $invitation->bride_name }}</h2>
                
                <div class="mt-10">
                    <div class="w-20 h-[2px] bg-gradient-to-r from-transparent via-[var(--color-primary)] to-transparent mx-auto mb-4"></div>
                    <p class="text-base text-gray-600 font-light">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                </div>
                
                <!-- Decorative leaf bottom -->
                <div class="flex justify-center mt-8">
                    <svg class="w-40 h-16 text-[var(--color-primary)] opacity-40 rotate-180" viewBox="0 0 160 60" fill="currentColor">
                        <path d="M80 55 C65 48, 35 42, 10 48 C35 35, 65 38, 80 30 C95 38, 125 35, 150 48 C125 42, 95 48, 80 55Z" opacity="0.5"/>
                        <path d="M80 48 C68 42, 45 38, 25 43 C45 32, 68 35, 80 28 C92 35, 115 32, 135 43 C115 38, 92 42, 80 48Z" opacity="0.7"/>
                    </svg>
                </div>
            </div>
        </section>


        <!-- ========== OPENING TEXT / AYAT ========== -->
        @if($invitation->opening_text)
        <section class="py-20 px-6 bg-white section-reveal">
            <div class="max-w-2xl mx-auto text-center">
                <svg class="w-10 h-10 mx-auto text-[var(--color-primary)] opacity-40 mb-6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                </svg>
                <p class="text-gray-600 leading-relaxed italic text-lg font-display">{{ $invitation->opening_text }}</p>
                <div class="w-16 h-[1px] bg-[var(--color-primary)] mx-auto mt-8"></div>
            </div>
        </section>
        @endif

        <!-- ========== COUPLE PROFILE ========== -->
        <section class="py-20 px-6 bg-[var(--color-accent)] section-reveal">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <p class="text-xs uppercase tracking-[0.4em] text-[var(--color-primary)] mb-2">The Bride & Groom</p>
                    <h2 class="text-3xl sm:text-4xl font-display font-bold text-[var(--color-secondary)]">Mempelai</h2>
                </div>

                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <!-- Groom -->
                    <div class="text-center">
                        @if($invitation->groom_photo)
                        <div class="relative inline-block mb-6">
                            <div class="w-56 h-56 mx-auto rounded-full overflow-hidden border-4 border-white shadow-2xl shadow-[var(--color-primary)]/20">
                                <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}" class="w-full h-full object-cover">
                            </div>
                            <div class="absolute inset-0 w-56 h-56 mx-auto rounded-full border-2 border-dashed border-[var(--color-primary)]/40 animate-spin-slow" style="animation-duration: 25s;"></div>
                        </div>
                        @endif
                        <h3 class="text-2xl font-display font-bold text-[var(--color-secondary)]">{{ $invitation->groom_name }}</h3>
                        @if($invitation->groom_father || $invitation->groom_mother)
                        <p class="text-gray-500 mt-2 text-sm">Putra dari Bapak {{ $invitation->groom_father }} & Ibu {{ $invitation->groom_mother }}</p>
                        @endif
                        @if($invitation->groom_instagram)
                        <a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" target="_blank" class="inline-flex items-center gap-1.5 text-sm text-[var(--color-primary)] mt-3 hover:underline">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            {{ $invitation->groom_instagram }}
                        </a>
                        @endif
                    </div>


                    <!-- Bride -->
                    <div class="text-center">
                        @if($invitation->bride_photo)
                        <div class="relative inline-block mb-6">
                            <div class="w-56 h-56 mx-auto rounded-full overflow-hidden border-4 border-white shadow-2xl shadow-[var(--color-primary)]/20">
                                <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}" class="w-full h-full object-cover">
                            </div>
                            <div class="absolute inset-0 w-56 h-56 mx-auto rounded-full border-2 border-dashed border-[var(--color-primary)]/40 animate-spin-slow" style="animation-duration: 25s; animation-direction: reverse;"></div>
                        </div>
                        @endif
                        <h3 class="text-2xl font-display font-bold text-[var(--color-secondary)]">{{ $invitation->bride_name }}</h3>
                        @if($invitation->bride_father || $invitation->bride_mother)
                        <p class="text-gray-500 mt-2 text-sm">Putri dari Bapak {{ $invitation->bride_father }} & Ibu {{ $invitation->bride_mother }}</p>
                        @endif
                        @if($invitation->bride_instagram)
                        <a href="https://instagram.com/{{ ltrim($invitation->bride_instagram, '@') }}" target="_blank" class="inline-flex items-center gap-1.5 text-sm text-[var(--color-primary)] mt-3 hover:underline">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            {{ $invitation->bride_instagram }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>


        <!-- ========== COUNTDOWN ========== -->
        <section class="py-20 px-6 bg-[var(--color-secondary)] relative overflow-hidden section-reveal">
            <!-- Background pattern -->
            <div class="absolute inset-0 opacity-5">
                <div class="absolute top-0 left-0 w-full h-full bg-[url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"1\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]"></div>
            </div>
            
            <div class="max-w-3xl mx-auto text-center relative z-10">
                <p class="text-xs uppercase tracking-[0.4em] text-[var(--color-primary)] mb-2">Save The Date</p>
                <h2 class="text-3xl sm:text-4xl font-display font-bold text-white mb-10">Menghitung Hari</h2>

                <div class="grid grid-cols-4 gap-3 sm:gap-6" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">
                    <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-4 sm:p-6 border border-white/10">
                        <p class="text-3xl sm:text-5xl font-display font-bold text-[var(--color-primary)]" x-text="days">0</p>
                        <p class="text-xs uppercase tracking-wider text-white/60 mt-2 font-body">Hari</p>
                    </div>
                    <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-4 sm:p-6 border border-white/10">
                        <p class="text-3xl sm:text-5xl font-display font-bold text-[var(--color-primary)]" x-text="hours">0</p>
                        <p class="text-xs uppercase tracking-wider text-white/60 mt-2 font-body">Jam</p>
                    </div>
                    <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-4 sm:p-6 border border-white/10">
                        <p class="text-3xl sm:text-5xl font-display font-bold text-[var(--color-primary)]" x-text="minutes">0</p>
                        <p class="text-xs uppercase tracking-wider text-white/60 mt-2 font-body">Menit</p>
                    </div>
                    <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-4 sm:p-6 border border-white/10">
                        <p class="text-3xl sm:text-5xl font-display font-bold text-[var(--color-primary)]" x-text="seconds">0</p>
                        <p class="text-xs uppercase tracking-wider text-white/60 mt-2 font-body">Detik</p>
                    </div>
                </div>
            </div>
        </section>


        <!-- ========== EVENT DETAILS ========== -->
        <section class="py-20 px-6 bg-white section-reveal">
            <div class="max-w-3xl mx-auto text-center">
                <p class="text-xs uppercase tracking-[0.4em] text-[var(--color-primary)] mb-2">Wedding Day</p>
                <h2 class="text-3xl sm:text-4xl font-display font-bold text-[var(--color-secondary)] mb-12">Waktu & Tempat</h2>

                <div class="bg-[var(--color-accent)] rounded-3xl p-8 sm:p-10 border border-[var(--color-primary)]/10 relative overflow-hidden">
                    <!-- Decorative corners -->
                    <div class="absolute top-4 left-4 w-8 h-8 border-l-2 border-t-2 border-[var(--color-primary)]/30"></div>
                    <div class="absolute top-4 right-4 w-8 h-8 border-r-2 border-t-2 border-[var(--color-primary)]/30"></div>
                    <div class="absolute bottom-4 left-4 w-8 h-8 border-l-2 border-b-2 border-[var(--color-primary)]/30"></div>
                    <div class="absolute bottom-4 right-4 w-8 h-8 border-r-2 border-b-2 border-[var(--color-primary)]/30"></div>
                    
                    <div class="flex justify-center mb-6">
                        <svg class="w-12 h-12 text-[var(--color-primary)] opacity-60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>

                    <h4 class="text-xl font-display font-bold text-[var(--color-secondary)] mb-4">{{ $invitation->event_venue }}</h4>
                    <p class="text-gray-600 mb-2 font-body">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                    <p class="text-gray-600 mb-4 font-body">
                        Pukul {{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }}
                        {{ $invitation->event_time_end ? '- ' . \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') : '' }} WIB
                    </p>

                    @if($invitation->event_address)
                    <p class="text-gray-500 text-sm mb-6">{{ $invitation->event_address }}</p>
                    @endif

                    @if($invitation->event_maps_url)
                    <a href="{{ $invitation->event_maps_url }}" target="_blank"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-[var(--color-primary)] text-white font-body text-sm uppercase tracking-wider rounded-full hover:shadow-lg hover:shadow-[var(--color-primary)]/30 transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Lihat Lokasi
                    </a>
                    @endif
                </div>

                @if($invitation->dress_code)
                <div class="mt-6 bg-[var(--color-primary)]/10 rounded-2xl p-5 border border-[var(--color-primary)]/20">
                    <p class="text-sm text-[var(--color-secondary)]">
                        <span class="font-medium">Dress Code:</span> {{ $invitation->dress_code }}
                    </p>
                </div>
                @endif
            </div>
        </section>


        <!-- ========== GALLERY ========== -->
        @if($invitation->galleries->count() > 0)
        <section class="py-20 px-6 bg-[var(--color-accent)] section-reveal">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <p class="text-xs uppercase tracking-[0.4em] text-[var(--color-primary)] mb-2">Our Moments</p>
                    <h2 class="text-3xl sm:text-4xl font-display font-bold text-[var(--color-secondary)]">Galeri</h2>
                </div>

                <div class="gallery-grid">
                    @foreach($invitation->galleries as $index => $photo)
                    <div class="relative group overflow-hidden rounded-xl aspect-square">
                        <img src="{{ $photo->getImageUrl() }}" alt="{{ $photo->caption }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- ========== LOVE STORY TIMELINE ========== -->
        @if($invitation->love_story && count($invitation->love_story) > 0)
        <section class="py-20 px-6 bg-white section-reveal">
            <div class="max-w-3xl mx-auto">
                <div class="text-center mb-12">
                    <p class="text-xs uppercase tracking-[0.4em] text-[var(--color-primary)] mb-2">Our Journey</p>
                    <h2 class="text-3xl sm:text-4xl font-display font-bold text-[var(--color-secondary)]">Love Story</h2>
                </div>

                <div class="relative">
                    <!-- Timeline line -->
                    <div class="absolute left-4 md:left-1/2 top-0 bottom-0 w-0.5 bg-gradient-to-b from-transparent via-[var(--color-primary)] to-transparent transform md:-translate-x-1/2"></div>

                    @foreach($invitation->love_story as $index => $story)
                    <div class="relative mb-12 last:mb-0 pl-14 md:pl-0 {{ $index % 2 == 0 ? 'md:pr-[55%]' : 'md:pl-[55%]' }}">
                        <!-- Timeline dot -->
                        <div class="absolute left-[14px] md:left-1/2 w-6 h-6 bg-white border-2 border-[var(--color-primary)] rounded-full transform -translate-x-1/2 z-10 shadow-md">
                            <div class="absolute inset-1.5 bg-[var(--color-primary)] rounded-full"></div>
                        </div>

                        <div class="bg-[var(--color-accent)] rounded-2xl p-6 border border-[var(--color-primary)]/10 hover:shadow-lg transition-shadow duration-300">
                            @if(!empty($story['date']))
                            <p class="text-xs uppercase tracking-wider text-[var(--color-primary)] font-medium mb-2">{{ $story['date'] }}</p>
                            @endif
                            <h4 class="text-lg font-display font-bold text-[var(--color-secondary)] mb-2">{{ $story['title'] }}</h4>
                            <p class="text-gray-600 text-sm leading-relaxed font-body">{{ $story['description'] }}</p>
                            @if(!empty($story['image']))
                            <div class="mt-4 rounded-xl overflow-hidden">
                                <img src="{{ asset('storage/' . $story['image']) }}" alt="{{ $story['title'] }}" class="w-full h-40 object-cover">
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif


        <!-- ========== RSVP ========== -->
        <section class="py-20 px-6 bg-[var(--color-accent)] section-reveal">
            <div class="max-w-lg mx-auto">
                <div class="text-center mb-10">
                    <p class="text-xs uppercase tracking-[0.4em] text-[var(--color-primary)] mb-2">Attendance</p>
                    <h2 class="text-3xl sm:text-4xl font-display font-bold text-[var(--color-secondary)]">RSVP</h2>
                </div>

                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl text-center text-sm">
                    {{ session('success') }}
                </div>
                @endif

                <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" class="space-y-4">
                    @csrf
                    <div>
                        <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Anda"
                            required class="w-full px-5 py-3.5 bg-white border border-[var(--color-primary)]/20 rounded-xl focus:ring-2 focus:ring-[var(--color-primary)]/30 focus:border-[var(--color-primary)] transition font-body text-sm">
                    </div>
                    <div>
                        <select name="rsvp_status" required
                            class="w-full px-5 py-3.5 bg-white border border-[var(--color-primary)]/20 rounded-xl focus:ring-2 focus:ring-[var(--color-primary)]/30 focus:border-[var(--color-primary)] transition font-body text-sm">
                            <option value="">Konfirmasi Kehadiran</option>
                            <option value="attending">Hadir</option>
                            <option value="not_attending">Tidak Hadir</option>
                            <option value="maybe">Masih Ragu</option>
                        </select>
                    </div>
                    <div>
                        <input type="number" name="number_of_guests" min="1" max="10" value="1" placeholder="Jumlah Tamu"
                            class="w-full px-5 py-3.5 bg-white border border-[var(--color-primary)]/20 rounded-xl focus:ring-2 focus:ring-[var(--color-primary)]/30 focus:border-[var(--color-primary)] transition font-body text-sm">
                    </div>
                    <button type="submit"
                        class="w-full py-3.5 bg-[var(--color-primary)] text-white font-body text-sm uppercase tracking-wider rounded-xl hover:shadow-lg hover:shadow-[var(--color-primary)]/30 transition-all duration-300">
                        Kirim Konfirmasi
                    </button>
                </form>
            </div>
        </section>


        <!-- ========== GUESTBOOK ========== -->
        <section class="py-20 px-6 bg-white section-reveal">
            <div class="max-w-lg mx-auto">
                <div class="text-center mb-10">
                    <p class="text-xs uppercase tracking-[0.4em] text-[var(--color-primary)] mb-2">Wishes</p>
                    <h2 class="text-3xl sm:text-4xl font-display font-bold text-[var(--color-secondary)]">Ucapan & Doa</h2>
                </div>

                <form method="POST" action="{{ route('invitation.guestbook', $invitation->slug) }}" class="space-y-4 mb-8">
                    @csrf
                    <div>
                        <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Anda"
                            required class="w-full px-5 py-3.5 bg-[var(--color-accent)] border border-[var(--color-primary)]/15 rounded-xl focus:ring-2 focus:ring-[var(--color-primary)]/30 focus:border-[var(--color-primary)] transition font-body text-sm">
                    </div>
                    <div>
                        <textarea name="message" rows="3" placeholder="Tulis ucapan dan doa untuk kedua mempelai..."
                            required class="w-full px-5 py-3.5 bg-[var(--color-accent)] border border-[var(--color-primary)]/15 rounded-xl focus:ring-2 focus:ring-[var(--color-primary)]/30 focus:border-[var(--color-primary)] transition font-body text-sm resize-none"></textarea>
                    </div>
                    <button type="submit"
                        class="w-full py-3.5 bg-[var(--color-secondary)] text-white font-body text-sm uppercase tracking-wider rounded-xl hover:opacity-90 transition-all duration-300">
                        Kirim Ucapan
                    </button>
                </form>

                <!-- Messages List -->
                <div class="space-y-4 max-h-96 overflow-y-auto">
                    @foreach($invitation->guestbooks as $msg)
                    <div class="bg-[var(--color-accent)] rounded-2xl p-4 border border-[var(--color-primary)]/10">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-full bg-[var(--color-primary)]/20 flex items-center justify-center flex-shrink-0">
                                <span class="text-sm font-medium text-[var(--color-primary)]">{{ substr($msg->name, 0, 1) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-[var(--color-secondary)] text-sm">{{ $msg->name }}</p>
                                <p class="text-gray-600 text-sm mt-1">{{ $msg->message }}</p>
                                <p class="text-xs text-gray-400 mt-2">{{ $msg->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>


        <!-- ========== DIGITAL ENVELOPE ========== -->
        @if($invitation->hasDigitalEnvelope())
        <section class="py-20 px-6 bg-[var(--color-accent)] section-reveal">
            <div class="max-w-lg mx-auto text-center">
                <p class="text-xs uppercase tracking-[0.4em] text-[var(--color-primary)] mb-2">Wedding Gift</p>
                <h2 class="text-3xl sm:text-4xl font-display font-bold text-[var(--color-secondary)] mb-4">Amplop Digital</h2>
                
                @if($invitation->gift_info)
                <p class="text-gray-600 mb-8 text-sm">{{ $invitation->gift_info }}</p>
                @else
                <p class="text-gray-600 mb-8 text-sm">Doa restu Anda merupakan karunia yang sangat berarti bagi kami. Namun jika Anda ingin memberikan hadiah, kami menyediakan amplop digital.</p>
                @endif

                @foreach($invitation->bank_accounts_list as $account)
                <div class="bg-white rounded-2xl p-6 border border-[var(--color-primary)]/10 mb-4 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-[var(--color-primary)]/5 rounded-bl-full"></div>
                    <p class="text-sm text-gray-500 mb-1">{{ $account['bank_name'] }}</p>
                    <p class="text-xl font-bold text-[var(--color-secondary)] font-display">{{ $account['account_number'] }}</p>
                    <p class="text-sm text-gray-500 mt-1">a.n. {{ $account['account_name'] }}</p>
                    <button onclick="navigator.clipboard.writeText('{{ $account['account_number'] }}')" 
                        class="mt-3 text-xs text-[var(--color-primary)] hover:underline">
                        Salin Nomor Rekening
                    </button>
                </div>
                @endforeach

                @if($invitation->qris_image)
                <div class="mt-6">
                    <p class="text-sm text-gray-500 mb-4">Atau scan QRIS berikut:</p>
                    <div class="inline-block bg-white p-4 rounded-2xl border border-[var(--color-primary)]/10 cursor-pointer" @click="$dispatch('open-qris')">
                        <img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS" class="w-48 h-48 object-contain mx-auto">
                        <p class="text-xs text-gray-400 mt-2">Klik untuk memperbesar</p>
                    </div>
                </div>
                @endif
            </div>
        </section>
        @endif


        <!-- ========== CLOSING ========== -->
        @if($invitation->closing_text)
        <section class="py-20 px-6 bg-[var(--color-secondary)] text-white text-center relative overflow-hidden">
            <!-- Background pattern -->
            <div class="absolute inset-0 opacity-5">
                <div class="absolute top-0 left-0 w-full h-full bg-[url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"1\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]"></div>
            </div>
            
            <div class="max-w-2xl mx-auto relative z-10">
                <svg class="w-10 h-10 mx-auto text-[var(--color-primary)] opacity-60 mb-6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
                <p class="text-white/80 leading-relaxed italic text-lg mb-8 font-display">{{ $invitation->closing_text }}</p>
                <div class="w-16 h-[1px] bg-[var(--color-primary)] mx-auto mb-6"></div>
                <h3 class="text-2xl font-display font-bold text-[var(--color-primary)]">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</h3>
            </div>
        </section>
        @endif

        <!-- ========== FOOTER ========== -->
        <footer class="py-8 px-6 bg-[var(--color-accent)] text-center border-t border-[var(--color-primary)]/10">
            <p class="text-xs text-gray-400">
                Made with <span class="text-red-400">❤</span> by 
                <a href="{{ url('/') }}" class="text-[var(--color-primary)] hover:underline">UndanganDigital</a>
            </p>
        </footer>
    </div>


    <!-- ==================== MUSIC PLAYER ==================== -->
    @if($invitation->music_url)
    <div class="fixed bottom-6 right-6 z-40" x-show="opened">
        <button @click="toggleMusic()" 
            class="w-14 h-14 bg-[var(--color-primary)] text-white rounded-full shadow-lg shadow-[var(--color-primary)]/30 flex items-center justify-center hover:scale-110 transition-transform duration-300"
            :class="{ 'animate-spin-slow': playing }">
            <svg x-show="!playing" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
            </svg>
            <svg x-show="playing" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
        </button>
        <audio x-ref="audio" src="{{ asset('storage/' . $invitation->music_url) }}" loop></audio>
    </div>
    @endif

    <!-- QRIS Modal -->
    @include('templates.partials.qris-modal')

    <script>
    function invitationApp() {
        return {
            opened: false,
            playing: false,
            openInvitation() {
                this.opened = true;
                @if($invitation->music_autoplay && $invitation->music_url)
                this.$nextTick(() => {
                    this.$refs.audio?.play().then(() => this.playing = true).catch(() => {});
                });
                @endif
                // Initialize scroll reveal
                this.$nextTick(() => this.initScrollReveal());
            },
            toggleMusic() {
                if (this.playing) {
                    this.$refs.audio?.pause();
                } else {
                    this.$refs.audio?.play();
                }
                this.playing = !this.playing;
            },
            initScrollReveal() {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('active');
                        }
                    });
                }, { threshold: 0.1 });
                
                document.querySelectorAll('.section-reveal').forEach(el => observer.observe(el));
            }
        };
    }

    function countdown(targetDate) {
        return {
            days: 0, hours: 0, minutes: 0, seconds: 0,
            init() {
                this.update();
                setInterval(() => this.update(), 1000);
            },
            update() {
                const diff = new Date(targetDate) - new Date();
                if (diff > 0) {
                    this.days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    this.hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    this.minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    this.seconds = Math.floor((diff % (1000 * 60)) / 1000);
                }
            }
        };
    }
    </script>
</body>
</html>
