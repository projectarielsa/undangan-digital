<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --color-primary: {{ $invitation->color_primary ?? '#D4A5A5' }};
            --color-secondary: {{ $invitation->color_secondary ?? '#3D3D3D' }};
            --color-accent: #F5E6E0;
            --color-gold: #C9A959;
        }
        .font-display { font-family: 'Cormorant Garamond', serif; }
        .font-body { font-family: 'Montserrat', sans-serif; }
        [x-cloak] { display: none !important; }
        
        /* Animations */
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes pulse-soft { 0%, 100% { opacity: 1; } 50% { opacity: 0.7; } }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-10px); } }
        @keyframes rotate-slow { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        
        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; }
        .animate-fade-in { animation: fadeIn 1s ease-out forwards; }
        .animate-pulse-soft { animation: pulse-soft 2s ease-in-out infinite; }
        .animate-float { animation: float 3s ease-in-out infinite; }
        .animate-rotate-slow { animation: rotate-slow 20s linear infinite; }
        
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }
        
        /* Scroll animations */
        .scroll-animate { opacity: 0; transform: translateY(30px); transition: all 0.8s ease-out; }
        .scroll-animate.visible { opacity: 1; transform: translateY(0); }


        /* Glassmorphism */
        .glass { background: rgba(255, 255, 255, 0.25); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.18); }
        .glass-dark { background: rgba(61, 61, 61, 0.85); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); }
        
        /* Decorative elements */
        .floral-corner { position: absolute; width: 120px; height: 120px; opacity: 0.15; pointer-events: none; }
        .floral-corner svg { width: 100%; height: 100%; fill: var(--color-primary); }
        
        /* Shimmer effect */
        .shimmer { background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent); background-size: 200% 100%; animation: shimmer 2s infinite; }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--color-accent); }
        ::-webkit-scrollbar-thumb { background: var(--color-primary); border-radius: 3px; }
        
        /* Photo frame styles */
        .photo-frame { position: relative; padding: 8px; background: linear-gradient(135deg, var(--color-gold) 0%, #E8D5B7 50%, var(--color-gold) 100%); }
        .photo-frame::before { content: ''; position: absolute; inset: 4px; border: 1px solid rgba(255,255,255,0.3); pointer-events: none; }
        
        /* Divider ornament */
        .divider-ornament { display: flex; align-items: center; justify-content: center; gap: 1rem; }
        .divider-ornament::before, .divider-ornament::after { content: ''; flex: 1; height: 1px; background: linear-gradient(90deg, transparent, var(--color-primary), transparent); }
    </style>
</head>
<body class="font-body bg-[#FFFAF8] text-[var(--color-secondary)] overflow-x-hidden" x-data="invitationApp()" x-cloak>


    <!-- Floating Petals Background -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0" x-show="opened">
        <template x-for="i in 15" :key="i">
            <div class="absolute animate-float opacity-20"
                 :style="`left: ${Math.random() * 100}%; top: ${Math.random() * 100}%; animation-delay: ${Math.random() * 5}s; animation-duration: ${3 + Math.random() * 4}s;`">
                <svg class="w-4 h-4 text-[var(--color-primary)]" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
            </div>
        </template>
    </div>

    <!-- Opening Cover -->
    <section x-show="!opened" 
             class="fixed inset-0 z-50 flex items-center justify-center"
             style="background: linear-gradient(135deg, #FFFAF8 0%, var(--color-accent) 50%, #FFFAF8 100%);"
             x-transition:leave="transition ease-in duration-700"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-110">
        
        <!-- Decorative corners -->
        <div class="absolute top-0 left-0 w-32 h-32 opacity-20">
            <svg viewBox="0 0 100 100" fill="var(--color-primary)">
                <path d="M0,0 Q50,0 50,50 Q50,0 100,0 L100,100 Q50,100 50,50 Q50,100 0,100 Z" opacity="0.3"/>
            </svg>
        </div>
        <div class="absolute bottom-0 right-0 w-32 h-32 opacity-20 rotate-180">
            <svg viewBox="0 0 100 100" fill="var(--color-primary)">
                <path d="M0,0 Q50,0 50,50 Q50,0 100,0 L100,100 Q50,100 50,50 Q50,100 0,100 Z" opacity="0.3"/>
            </svg>
        </div>


        <div class="text-center px-8 max-w-md mx-auto">
            <!-- Ornament top -->
            <div class="mb-8 animate-fade-in">
                <svg class="w-16 h-16 mx-auto text-[var(--color-primary)] opacity-60" viewBox="0 0 100 100" fill="currentColor">
                    <circle cx="50" cy="50" r="3"/>
                    <circle cx="30" cy="50" r="2"/>
                    <circle cx="70" cy="50" r="2"/>
                    <path d="M20,50 Q35,35 50,50 Q65,35 80,50" fill="none" stroke="currentColor" stroke-width="1"/>
                    <path d="M20,50 Q35,65 50,50 Q65,65 80,50" fill="none" stroke="currentColor" stroke-width="1"/>
                </svg>
            </div>
            
            <p class="text-xs uppercase tracking-[0.4em] text-[var(--color-primary)] mb-6 animate-fade-in-up font-medium">
                The Wedding of
            </p>
            
            <h1 class="text-5xl sm:text-6xl font-display font-semibold text-[var(--color-secondary)] mb-3 animate-fade-in-up delay-100">
                {{ $invitation->groom_name }}
            </h1>
            
            <div class="my-4 animate-fade-in-up delay-200">
                <span class="inline-block text-4xl font-display italic text-[var(--color-primary)]">&</span>
            </div>
            
            <h1 class="text-5xl sm:text-6xl font-display font-semibold text-[var(--color-secondary)] mb-8 animate-fade-in-up delay-300">
                {{ $invitation->bride_name }}
            </h1>
            
            @if($guestName)
            <div class="mb-8 animate-fade-in-up delay-400">
                <p class="text-sm text-gray-500 mb-2">Kepada Yth. Bapak/Ibu/Saudara/i</p>
                <p class="text-xl font-display font-medium text-[var(--color-secondary)]">{{ urldecode($guestName) }}</p>
                @if($guest && $guest->invited_by)
                <p class="text-sm text-[var(--color-primary)] mt-2">Turut Mengundang: {{ $guest->invited_by }}</p>
                @endif
            </div>
            @endif
            
            <button @click="openInvitation()" 
                    class="group relative px-10 py-4 bg-[var(--color-primary)] text-white font-medium rounded-full overflow-hidden transition-all duration-300 hover:shadow-lg hover:shadow-[var(--color-primary)]/30 animate-fade-in-up delay-500">
                <span class="relative z-10 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Buka Undangan
                </span>
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent shimmer"></div>
            </button>
        </div>
    </section>


    <!-- Main Content -->
    <div x-show="opened" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-1">

        <!-- Hero Section -->
        <section class="min-h-screen flex items-center justify-center relative py-24 px-6">
            <div class="absolute inset-0 bg-gradient-to-b from-[var(--color-accent)]/30 via-transparent to-[var(--color-accent)]/30"></div>
            
            <!-- Decorative rings -->
            <div class="absolute top-20 left-1/2 -translate-x-1/2 opacity-5">
                <div class="w-96 h-96 border border-[var(--color-primary)] rounded-full animate-rotate-slow"></div>
                <div class="absolute inset-4 border border-[var(--color-primary)] rounded-full animate-rotate-slow" style="animation-direction: reverse;"></div>
            </div>
            
            <div class="text-center relative z-10 max-w-2xl scroll-animate" data-scroll>
                <div class="divider-ornament mb-8">
                    <svg class="w-8 h-8 text-[var(--color-primary)]" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </div>
                
                <p class="text-sm uppercase tracking-[0.3em] text-[var(--color-primary)] mb-6 font-medium">We're Getting Married</p>
                
                <h2 class="text-6xl sm:text-7xl font-display font-semibold text-[var(--color-secondary)] mb-4">
                    {{ $invitation->groom_name }}
                </h2>
                <p class="text-4xl font-display italic text-[var(--color-primary)] my-4">&</p>
                <h2 class="text-6xl sm:text-7xl font-display font-semibold text-[var(--color-secondary)]">
                    {{ $invitation->bride_name }}
                </h2>
                
                <div class="mt-12 flex flex-col items-center gap-2">
                    <p class="text-lg text-gray-600 font-light">{{ $invitation->event_date->translatedFormat('l') }}</p>
                    <p class="text-3xl font-display font-semibold text-[var(--color-secondary)]">
                        {{ $invitation->event_date->translatedFormat('d F Y') }}
                    </p>
                </div>
                
                <div class="divider-ornament mt-12">
                    <svg class="w-6 h-6 text-[var(--color-primary)]" viewBox="0 0 24 24" fill="currentColor">
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </div>
            </div>
        </section>


        <!-- Opening Text / Quote -->
        @if($invitation->opening_text)
        <section class="py-20 px-6 bg-white relative overflow-hidden">
            <div class="absolute top-0 left-0 w-40 h-40 bg-[var(--color-accent)] rounded-full -translate-x-1/2 -translate-y-1/2 opacity-50"></div>
            <div class="absolute bottom-0 right-0 w-60 h-60 bg-[var(--color-accent)] rounded-full translate-x-1/3 translate-y-1/3 opacity-50"></div>
            
            <div class="max-w-2xl mx-auto text-center relative z-10 scroll-animate" data-scroll>
                <svg class="w-12 h-12 mx-auto text-[var(--color-primary)] opacity-40 mb-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                </svg>
                <p class="text-xl sm:text-2xl font-display italic text-gray-600 leading-relaxed">
                    {{ $invitation->opening_text }}
                </p>
                <div class="mt-8 flex justify-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-[var(--color-primary)]"></span>
                    <span class="w-2 h-2 rounded-full bg-[var(--color-primary)] opacity-60"></span>
                    <span class="w-2 h-2 rounded-full bg-[var(--color-primary)] opacity-30"></span>
                </div>
            </div>
        </section>
        @endif

        <!-- Couple Profile -->
        <section class="py-20 px-6 bg-[#FFFAF8]">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-16 scroll-animate" data-scroll>
                    <p class="text-sm uppercase tracking-[0.3em] text-[var(--color-primary)] mb-3">The Happy Couple</p>
                    <h2 class="text-4xl font-display font-semibold text-[var(--color-secondary)]">Mempelai</h2>
                </div>
                
                <div class="grid md:grid-cols-2 gap-16 items-center">
                    <!-- Groom -->
                    <div class="text-center scroll-animate" data-scroll>
                        @if($invitation->groom_photo)
                        <div class="relative inline-block mb-8">
                            <div class="photo-frame rounded-full">
                                <div class="w-56 h-56 rounded-full overflow-hidden">
                                    <img src="{{ asset('storage/' . $invitation->groom_photo) }}" 
                                         alt="{{ $invitation->groom_name }}" 
                                         class="w-full h-full object-cover hover:scale-110 transition-transform duration-700">
                                </div>
                            </div>
                            <!-- Decorative ring -->
                            <div class="absolute -inset-4 border-2 border-dashed border-[var(--color-primary)]/20 rounded-full animate-rotate-slow"></div>
                        </div>
                        @endif
                        <h3 class="text-3xl font-display font-semibold text-[var(--color-secondary)] mb-2">
                            {{ $invitation->groom_name }}
                        </h3>
                        @if($invitation->groom_father || $invitation->groom_mother)
                        <p class="text-gray-500 mb-3">
                            Putra dari Bapak {{ $invitation->groom_father }}<br>& Ibu {{ $invitation->groom_mother }}
                        </p>
                        @endif
                        @if($invitation->groom_instagram)
                        <a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" 
                           target="_blank" 
                           class="inline-flex items-center gap-2 text-[var(--color-primary)] hover:underline transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                            {{ $invitation->groom_instagram }}
                        </a>
                        @endif
                    </div>


                    <!-- Bride -->
                    <div class="text-center scroll-animate" data-scroll>
                        @if($invitation->bride_photo)
                        <div class="relative inline-block mb-8">
                            <div class="photo-frame rounded-full">
                                <div class="w-56 h-56 rounded-full overflow-hidden">
                                    <img src="{{ asset('storage/' . $invitation->bride_photo) }}" 
                                         alt="{{ $invitation->bride_name }}" 
                                         class="w-full h-full object-cover hover:scale-110 transition-transform duration-700">
                                </div>
                            </div>
                            <div class="absolute -inset-4 border-2 border-dashed border-[var(--color-primary)]/20 rounded-full animate-rotate-slow" style="animation-direction: reverse;"></div>
                        </div>
                        @endif
                        <h3 class="text-3xl font-display font-semibold text-[var(--color-secondary)] mb-2">
                            {{ $invitation->bride_name }}
                        </h3>
                        @if($invitation->bride_father || $invitation->bride_mother)
                        <p class="text-gray-500 mb-3">
                            Putri dari Bapak {{ $invitation->bride_father }}<br>& Ibu {{ $invitation->bride_mother }}
                        </p>
                        @endif
                        @if($invitation->bride_instagram)
                        <a href="https://instagram.com/{{ ltrim($invitation->bride_instagram, '@') }}" 
                           target="_blank" 
                           class="inline-flex items-center gap-2 text-[var(--color-primary)] hover:underline transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                            {{ $invitation->bride_instagram }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>


        <!-- Countdown Section -->
        <section class="py-20 px-6 relative overflow-hidden" style="background: linear-gradient(135deg, var(--color-secondary) 0%, #2D2D2D 100%);">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-10 left-10 w-40 h-40 border border-white rounded-full"></div>
                <div class="absolute bottom-10 right-10 w-60 h-60 border border-white rounded-full"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-80 h-80 border border-white rounded-full"></div>
            </div>
            
            <div class="max-w-4xl mx-auto text-center relative z-10 scroll-animate" data-scroll>
                <p class="text-sm uppercase tracking-[0.3em] text-[var(--color-primary)] mb-4">Save The Date</p>
                <h2 class="text-4xl font-display font-semibold text-white mb-12">Menghitung Hari</h2>
                
                <div class="grid grid-cols-4 gap-4 sm:gap-8" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">
                    <div class="glass rounded-3xl p-6 sm:p-8">
                        <p class="text-4xl sm:text-5xl font-display font-bold text-[var(--color-primary)]" x-text="days">0</p>
                        <p class="text-xs sm:text-sm uppercase tracking-wider text-white/70 mt-2">Hari</p>
                    </div>
                    <div class="glass rounded-3xl p-6 sm:p-8">
                        <p class="text-4xl sm:text-5xl font-display font-bold text-[var(--color-primary)]" x-text="hours">0</p>
                        <p class="text-xs sm:text-sm uppercase tracking-wider text-white/70 mt-2">Jam</p>
                    </div>
                    <div class="glass rounded-3xl p-6 sm:p-8">
                        <p class="text-4xl sm:text-5xl font-display font-bold text-[var(--color-primary)]" x-text="minutes">0</p>
                        <p class="text-xs sm:text-sm uppercase tracking-wider text-white/70 mt-2">Menit</p>
                    </div>
                    <div class="glass rounded-3xl p-6 sm:p-8">
                        <p class="text-4xl sm:text-5xl font-display font-bold text-[var(--color-primary)]" x-text="seconds">0</p>
                        <p class="text-xs sm:text-sm uppercase tracking-wider text-white/70 mt-2">Detik</p>
                    </div>
                </div>
                
                <div class="mt-12">
                    <a href="#" @click.prevent="addToCalendar()" 
                       class="inline-flex items-center gap-2 px-6 py-3 border border-[var(--color-primary)] text-[var(--color-primary)] rounded-full hover:bg-[var(--color-primary)] hover:text-white transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Simpan ke Kalender
                    </a>
                </div>
            </div>
        </section>


        <!-- Event Details -->
        <section class="py-20 px-6 bg-white">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-16 scroll-animate" data-scroll>
                    <p class="text-sm uppercase tracking-[0.3em] text-[var(--color-primary)] mb-3">When & Where</p>
                    <h2 class="text-4xl font-display font-semibold text-[var(--color-secondary)]">Detail Acara</h2>
                </div>
                
                <div class="grid md:grid-cols-1 gap-8 scroll-animate" data-scroll>
                    <!-- Main Event Card -->
                    <div class="relative bg-gradient-to-br from-[var(--color-accent)] to-white rounded-3xl p-8 sm:p-12 border border-[var(--color-primary)]/10 overflow-hidden">
                        <div class="absolute top-0 right-0 w-40 h-40 bg-[var(--color-primary)]/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-16 h-16 bg-[var(--color-primary)]/10 rounded-2xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-[var(--color-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-display font-semibold text-[var(--color-secondary)]">{{ $invitation->event_venue }}</h3>
                                    <p class="text-[var(--color-primary)]">Resepsi Pernikahan</p>
                                </div>
                            </div>
                            
                            <div class="space-y-4 text-gray-600">
                                <div class="flex items-start gap-4">
                                    <svg class="w-5 h-5 text-[var(--color-primary)] mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>{{ $invitation->event_date->translatedFormat('l, d F Y') }}</span>
                                </div>
                                <div class="flex items-start gap-4">
                                    <svg class="w-5 h-5 text-[var(--color-primary)] mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>{{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }} {{ $invitation->event_time_end ? '- ' . \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') : '' }} WIB</span>
                                </div>
                                @if($invitation->event_address)
                                <div class="flex items-start gap-4">
                                    <svg class="w-5 h-5 text-[var(--color-primary)] mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span>{{ $invitation->event_address }}</span>
                                </div>
                                @endif
                            </div>
                            
                            @if($invitation->event_maps_url)
                            <div class="mt-8">
                                <a href="{{ $invitation->event_maps_url }}" target="_blank" 
                                   class="inline-flex items-center gap-2 px-6 py-3 bg-[var(--color-primary)] text-white rounded-full hover:shadow-lg hover:shadow-[var(--color-primary)]/30 transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                    Buka di Google Maps
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                @if($invitation->dress_code)
                <div class="mt-8 text-center scroll-animate" data-scroll>
                    <div class="inline-flex items-center gap-3 px-6 py-4 bg-amber-50 border border-amber-200 rounded-2xl">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                        </svg>
                        <span class="text-amber-800"><strong>Dress Code:</strong> {{ $invitation->dress_code }}</span>
                    </div>
                </div>
                @endif
            </div>
        </section>


        <!-- Love Story Timeline -->
        @if($invitation->love_story && count($invitation->love_story) > 0)
        <section class="py-20 px-6 bg-white">
            <div class="max-w-3xl mx-auto">
                <div class="text-center mb-16 scroll-animate" data-scroll>
                    <p class="text-sm uppercase tracking-[0.3em] text-[var(--color-primary)] mb-3">Our Journey</p>
                    <h2 class="text-4xl font-display font-semibold text-[var(--color-secondary)]">Love Story</h2>
                </div>
                
                <div class="relative scroll-animate" data-scroll>
                    <!-- Timeline line -->
                    <div class="absolute left-4 md:left-1/2 top-0 bottom-0 w-0.5 bg-[var(--color-primary)]/30 transform md:-translate-x-1/2"></div>
                    
                    @foreach($invitation->love_story as $index => $story)
                    <div class="relative mb-12 last:mb-0 {{ $index % 2 == 0 ? 'md:pr-1/2' : 'md:pl-1/2 md:ml-auto' }}">
                        <!-- Timeline dot -->
                        <div class="absolute left-4 md:left-1/2 w-4 h-4 bg-[var(--color-primary)] rounded-full transform -translate-x-1/2 md:-translate-x-1/2 border-4 border-white shadow-lg shadow-[var(--color-primary)]/20"></div>
                        
                        <div class="ml-12 md:ml-0 {{ $index % 2 == 0 ? 'md:mr-8' : 'md:ml-8' }}">
                            <div class="bg-gradient-to-br from-[var(--color-accent)] to-white rounded-3xl p-6 border border-[var(--color-primary)]/10">
                                @if(!empty($story['date']))
                                <p class="text-sm text-[var(--color-primary)] font-medium mb-2">{{ $story['date'] }}</p>
                                @endif
                                <h4 class="text-xl font-display font-semibold text-[var(--color-secondary)] mb-2">{{ $story['title'] }}</h4>
                                <p class="text-gray-600 text-sm leading-relaxed">{{ $story['description'] }}</p>
                                @if(!empty($story['image']))
                                <div class="mt-4 rounded-2xl overflow-hidden">
                                    <img src="{{ asset('storage/' . $story['image']) }}" alt="{{ $story['title'] }}" class="w-full h-48 object-cover hover:scale-110 transition-transform duration-700">
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif


        <!-- Gallery Section -->
        @if(($invitation->galleries ? $invitation->galleries->count() : 0) > 0)
        <section class="py-20 px-6 bg-[#FFFAF8]">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16 scroll-animate" data-scroll>
                    <p class="text-sm uppercase tracking-[0.3em] text-[var(--color-primary)] mb-3">Our Moments</p>
                    <h2 class="text-4xl font-display font-semibold text-[var(--color-secondary)]">Galeri Foto</h2>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 scroll-animate" data-scroll x-data="{ lightbox: false, currentImage: '' }">
                    @foreach($invitation->galleries as $index => $photo)
                    <div class="group relative {{ $index === 0 ? 'md:col-span-2 md:row-span-2' : '' }} aspect-square rounded-2xl overflow-hidden cursor-pointer"
                         @click="lightbox = true; currentImage = '{{ $photo->getImageUrl() }}'">
                        <img src="{{ $photo->getImageUrl() }}" 
                             alt="{{ $photo->caption }}" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-all duration-300 flex items-center justify-center">
                            <svg class="w-10 h-10 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                            </svg>
                        </div>
                    </div>
                    @endforeach
                    
                    <!-- Lightbox -->
                    <div x-show="lightbox" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         @click="lightbox = false"
                         class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4">
                        <button @click="lightbox = false" class="absolute top-4 right-4 text-white hover:text-[var(--color-primary)] transition">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                        <img :src="currentImage" class="max-w-full max-h-[85vh] rounded-lg" @click.stop>
                    </div>
                </div>
            </div>
        </section>
        @endif


        <!-- RSVP Section -->
        <section class="py-20 px-6 bg-white">
            <div class="max-w-xl mx-auto">
                <div class="text-center mb-12 scroll-animate" data-scroll>
                    <p class="text-sm uppercase tracking-[0.3em] text-[var(--color-primary)] mb-3">Confirmation</p>
                    <h2 class="text-4xl font-display font-semibold text-[var(--color-secondary)]">RSVP</h2>
                    <p class="text-gray-500 mt-4">Mohon konfirmasi kehadiran Anda</p>
                </div>
                
                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl text-center scroll-animate" data-scroll>
                    <svg class="w-6 h-6 mx-auto mb-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
                @endif
                
                <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" class="scroll-animate" data-scroll>
                    @csrf
                    <div class="space-y-6">
                        <div class="relative">
                            <input type="text" name="name" id="rsvp-name" 
                                   value="{{ $guestName ? urldecode($guestName) : '' }}" 
                                   required
                                   class="peer w-full px-4 py-4 bg-gray-50 border-2 border-gray-200 rounded-2xl focus:border-[var(--color-primary)] focus:bg-white focus:outline-none transition-all placeholder-transparent"
                                   placeholder="Nama Anda">
                            <label for="rsvp-name" 
                                   class="absolute left-4 -top-2.5 bg-white px-2 text-sm text-gray-500 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:bg-transparent peer-focus:-top-2.5 peer-focus:text-sm peer-focus:bg-white peer-focus:text-[var(--color-primary)]">
                                Nama Anda
                            </label>
                        </div>
                        
                        <div class="relative">
                            <select name="rsvp_status" required
                                    class="w-full px-4 py-4 bg-gray-50 border-2 border-gray-200 rounded-2xl focus:border-[var(--color-primary)] focus:bg-white focus:outline-none transition-all appearance-none">
                                <option value="">Konfirmasi Kehadiran</option>
                                <option value="attending">Hadir</option>
                                <option value="not_attending">Tidak Hadir</option>
                                <option value="maybe">Masih Ragu</option>
                            </select>
                            <svg class="w-5 h-5 absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        
                        <div class="relative">
                            <input type="number" name="number_of_guests" min="1" max="10" value="1"
                                   class="w-full px-4 py-4 bg-gray-50 border-2 border-gray-200 rounded-2xl focus:border-[var(--color-primary)] focus:bg-white focus:outline-none transition-all"
                                   placeholder="Jumlah Tamu">
                            <label class="absolute left-4 -top-2.5 bg-white px-2 text-sm text-gray-500">Jumlah Tamu</label>
                        </div>
                        
                        <button type="submit" 
                                class="w-full py-4 bg-[var(--color-primary)] text-white font-medium rounded-2xl hover:shadow-lg hover:shadow-[var(--color-primary)]/30 transition-all duration-300 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Kirim Konfirmasi
                        </button>
                    </div>
                </form>
            </div>
        </section>


        <!-- Guestbook / Wishes Section -->
        <section class="py-20 px-6 bg-[#FFFAF8]">
            <div class="max-w-2xl mx-auto">
                <div class="text-center mb-12 scroll-animate" data-scroll>
                    <p class="text-sm uppercase tracking-[0.3em] text-[var(--color-primary)] mb-3">Warm Wishes</p>
                    <h2 class="text-4xl font-display font-semibold text-[var(--color-secondary)]">Ucapan & Doa</h2>
                </div>
                
                <form method="POST" action="{{ route('invitation.guestbook', $invitation->slug) }}" class="mb-10 scroll-animate" data-scroll>
                    @csrf
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                        <div class="space-y-4">
                            <input type="text" name="name" 
                                   value="{{ $guestName ? urldecode($guestName) : '' }}" 
                                   required
                                   placeholder="Nama Anda"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:border-[var(--color-primary)] focus:outline-none transition-all">
                            <textarea name="message" rows="3" required
                                      placeholder="Tulis ucapan dan doa terbaik untuk kedua mempelai..."
                                      class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:border-[var(--color-primary)] focus:outline-none transition-all resize-none"></textarea>
                            <button type="submit" 
                                    class="w-full py-3 bg-[var(--color-secondary)] text-white font-medium rounded-xl hover:bg-gray-700 transition-all flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                Kirim Ucapan
                            </button>
                        </div>
                    </div>
                </form>
                
                <!-- Messages List -->
                <div class="space-y-4 max-h-[500px] overflow-y-auto scroll-animate" data-scroll>
                    @forelse($invitation->guestbooks as $msg)
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[var(--color-primary)] to-[var(--color-accent)] flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-medium text-sm">{{ strtoupper(substr($msg->name, 0, 1)) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-2 mb-1">
                                    <h4 class="font-medium text-[var(--color-secondary)] truncate">{{ $msg->name }}</h4>
                                    <span class="text-xs text-gray-400 flex-shrink-0">{{ $msg->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-600 text-sm leading-relaxed">{{ $msg->message }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <p>Jadilah yang pertama memberikan ucapan!</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </section>


        <!-- Digital Envelope / Gift Section -->
        @if($invitation->hasDigitalEnvelope())
        <section class="py-20 px-6 bg-white">
            <div class="max-w-xl mx-auto">
                <div class="text-center mb-12 scroll-animate" data-scroll>
                    <p class="text-sm uppercase tracking-[0.3em] text-[var(--color-primary)] mb-3">Wedding Gift</p>
                    <h2 class="text-4xl font-display font-semibold text-[var(--color-secondary)]">Amplop Digital</h2>
                    @if($invitation->gift_info)
                    <p class="text-gray-500 mt-4">{{ $invitation->gift_info }}</p>
                    @else
                    <p class="text-gray-500 mt-4">Doa restu Anda adalah hadiah terindah. Namun jika Anda ingin memberikan hadiah, kami menyediakan amplop digital.</p>
                    @endif
                </div>
                
                <div class="space-y-6 scroll-animate" data-scroll>
                    @foreach($invitation->bank_accounts_list as $account)
                    <div class="bg-gradient-to-br from-[var(--color-accent)] to-white rounded-3xl p-6 border border-[var(--color-primary)]/10" x-data="{ copied: false }">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-[var(--color-primary)]/10 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-[var(--color-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">{{ $account['bank_name'] }}</p>
                                <p class="text-lg font-semibold text-[var(--color-secondary)]">{{ $account['account_name'] }}</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between bg-white rounded-xl p-4">
                            <span class="text-xl font-mono font-semibold text-[var(--color-secondary)]">{{ $account['account_number'] }}</span>
                            <button @click="navigator.clipboard.writeText('{{ $account['account_number'] }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                    class="px-4 py-2 bg-[var(--color-primary)] text-white text-sm font-medium rounded-lg hover:opacity-90 transition flex items-center gap-2">
                                <svg x-show="!copied" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                </svg>
                                <svg x-show="copied" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span x-text="copied ? 'Tersalin!' : 'Salin'"></span>
                            </button>
                        </div>
                    </div>
                    @endforeach
                    
                    @if($invitation->qris_image)
                    <div class="bg-white rounded-3xl p-6 border border-gray-100 text-center cursor-pointer" @click="$dispatch('open-qris')">
                        <p class="text-sm text-gray-500 mb-4">Scan QRIS (tap untuk perbesar)</p>
                        <div class="inline-block p-4 bg-white rounded-2xl shadow-sm border">
                            <img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS" class="w-48 h-48 object-contain mx-auto">
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </section>
        @endif


        <!-- Closing Section -->
        @if($invitation->closing_text)
        <section class="py-24 px-6 relative overflow-hidden" style="background: linear-gradient(135deg, var(--color-secondary) 0%, #2D2D2D 100%);">
            <div class="absolute inset-0 opacity-5">
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <pattern id="hearts" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                        <path d="M10 18l-1-1C4 12 1 9 1 6c0-2.5 2-4.5 4.5-4.5 1.5 0 3 .7 4.5 2 1.5-1.3 3-2 4.5-2C17 1.5 19 3.5 19 6c0 3-3 6-8 11l-1 1z" fill="white"/>
                    </pattern>
                    <rect x="0" y="0" width="100%" height="100%" fill="url(#hearts)"/>
                </svg>
            </div>
            
            <div class="max-w-2xl mx-auto text-center relative z-10 scroll-animate" data-scroll>
                <svg class="w-12 h-12 mx-auto text-[var(--color-primary)] mb-8" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
                
                <p class="text-xl font-display italic text-white/90 leading-relaxed mb-10">
                    {{ $invitation->closing_text }}
                </p>
                
                <div class="divider-ornament mb-8">
                    <span class="w-2 h-2 rounded-full bg-[var(--color-primary)]"></span>
                </div>
                
                <h3 class="text-3xl font-display font-semibold text-[var(--color-primary)]">
                    {{ $invitation->groom_name }} & {{ $invitation->bride_name }}
                </h3>
                <p class="text-white/60 mt-4">{{ $invitation->event_date->translatedFormat('d F Y') }}</p>
            </div>
        </section>
        @endif

        <!-- Footer -->
        <footer class="py-8 px-6 bg-[#FFFAF8] text-center">
            <div class="flex items-center justify-center gap-2 text-sm text-gray-400">
                <svg class="w-4 h-4 text-[var(--color-primary)]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
                <span>Made with love by</span>
                <a href="{{ url('/') }}" class="text-[var(--color-primary)] hover:underline font-medium">Ellori</a>
            </div>
        </footer>
    </div>


    <!-- Music Player -->
    @if($invitation->music_url)
    <div class="fixed bottom-6 right-6 z-40" x-show="opened">
        <button @click="toggleMusic()" 
                class="group relative w-14 h-14 bg-white text-[var(--color-primary)] rounded-full shadow-lg flex items-center justify-center hover:shadow-xl transition-all duration-300"
                :class="{ 'animate-pulse-soft': playing }">
            <div class="absolute inset-0 bg-[var(--color-primary)]/10 rounded-full" :class="{ 'animate-ping': playing }"></div>
            <svg x-show="!playing" class="w-6 h-6 relative z-10" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/>
            </svg>
            <svg x-show="playing" class="w-6 h-6 relative z-10" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z"/>
            </svg>
        </button>
        <audio x-ref="audio" src="{{ asset('storage/' . $invitation->music_url) }}" loop></audio>
    </div>
    @endif

    <script>
    function invitationApp() {
        return {
            opened: false,
            playing: false,
            openInvitation() {
                this.opened = true;
                document.body.style.overflow = 'auto';
                
                // Trigger scroll animations
                this.$nextTick(() => {
                    this.initScrollAnimations();
                });
                
                @if($invitation->music_autoplay && $invitation->music_url)
                this.$nextTick(() => {
                    this.$refs.audio?.play().then(() => this.playing = true).catch(() => {});
                });
                @endif
            },
            toggleMusic() {
                if (this.playing) {
                    this.$refs.audio?.pause();
                } else {
                    this.$refs.audio?.play();
                }
                this.playing = !this.playing;
            },
            initScrollAnimations() {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('visible');
                        }
                    });
                }, { threshold: 0.1 });
                
                document.querySelectorAll('.scroll-animate').forEach(el => {
                    observer.observe(el);
                });
            },
            addToCalendar() {
                const event = {
                    title: 'Pernikahan {{ $invitation->groom_name }} & {{ $invitation->bride_name }}',
                    start: '{{ $invitation->event_date->format("Ymd") }}T{{ str_replace(":", "", $invitation->event_time_start) }}00',
                    end: '{{ $invitation->event_date->format("Ymd") }}T{{ $invitation->event_time_end ? str_replace(":", "", $invitation->event_time_end) . "00" : str_replace(":", "", $invitation->event_time_start) . "00" }}',
                    location: '{{ $invitation->event_venue }}, {{ $invitation->event_address }}'
                };
                
                const url = `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(event.title)}&dates=${event.start}/${event.end}&location=${encodeURIComponent(event.location)}`;
                window.open(url, '_blank');
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
    @include('templates.partials.qris-modal')
</body>
</html>
