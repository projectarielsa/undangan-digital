<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Italiana&family=Josefin+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { 
            --color-primary: {{ $invitation->color_primary ?? '#1a1a2e' }}; 
            --color-secondary: {{ $invitation->color_secondary ?? '#f8f6f4' }}; 
            --color-accent: {{ $invitation->color_accent ?? '#c9a87c' }}; 
        }
        .font-display { font-family: 'Italiana', serif; }
        .font-body { font-family: 'Josefin Sans', sans-serif; }
        [x-cloak] { display: none !important; }
        
        /* Animations */
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes scaleIn { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
        @keyframes float { 0%, 100% { transform: translateY(0) rotate(45deg); } 50% { transform: translateY(-10px) rotate(45deg); } }
        @keyframes pulse { 0%, 100% { opacity: 0.3; } 50% { opacity: 0.6; } }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        @keyframes drawLine { from { width: 0; } to { width: 100%; } }
        
        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; }
        .animate-fade-in { animation: fadeIn 1s ease-out forwards; }
        .animate-scale-in { animation: scaleIn 0.6s ease-out forwards; }
        .animate-float { animation: float 3s ease-in-out infinite; }
        .animate-pulse-slow { animation: pulse 4s ease-in-out infinite; }
        .animate-spin-slow { animation: spin 8s linear infinite; }
        .animate-draw-line { animation: drawLine 1.5s ease-out forwards; }
        
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }


        /* Geometric Patterns */
        .geo-grid {
            background-image: 
                linear-gradient(var(--color-accent) 1px, transparent 1px),
                linear-gradient(90deg, var(--color-accent) 1px, transparent 1px);
            background-size: 50px 50px;
            opacity: 0.1;
        }
        
        .geo-diamond {
            clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
        }
        
        .geo-hexagon {
            clip-path: polygon(25% 0%, 75% 0%, 100% 50%, 75% 100%, 25% 100%, 0% 50%);
        }
        
        .geo-octagon {
            clip-path: polygon(30% 0%, 70% 0%, 100% 30%, 100% 70%, 70% 100%, 30% 100%, 0% 70%, 0% 30%);
        }
        
        /* Glass Effect */
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, var(--color-primary), var(--color-accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--color-secondary); }
        ::-webkit-scrollbar-thumb { background: var(--color-accent); border-radius: 3px; }
        
        /* Section Transitions */
        .section-reveal { opacity: 0; transform: translateY(40px); transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1); }
        .section-reveal.revealed { opacity: 1; transform: translateY(0); }
    </style>
</head>
<body class="font-body bg-[var(--color-secondary)] text-[var(--color-primary)] overflow-x-hidden" x-data="invitationApp()" x-cloak>


    <!-- Decorative Background Elements -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute top-20 left-10 w-32 h-32 border border-[var(--color-accent)]/20 rotate-45 animate-float"></div>
        <div class="absolute top-40 right-20 w-20 h-20 border border-[var(--color-accent)]/10 rotate-12 animate-float delay-200"></div>
        <div class="absolute bottom-40 left-1/4 w-24 h-24 border border-[var(--color-accent)]/15 rotate-45 animate-float delay-300"></div>
        <div class="absolute top-1/3 right-10 w-16 h-16 bg-[var(--color-accent)]/5 rotate-45 animate-pulse-slow"></div>
        <div class="absolute bottom-20 right-1/3 w-28 h-28 border border-[var(--color-accent)]/10 rotate-45 animate-float delay-400"></div>
    </div>

    <!-- Opening Cover -->
    <section x-show="!opened" class="fixed inset-0 z-50 flex items-center justify-center bg-[var(--color-primary)]" 
        x-transition:leave="transition ease-in-out duration-700" 
        x-transition:leave-start="opacity-100 scale-100" 
        x-transition:leave-end="opacity-0 scale-110">
        
        <!-- Animated Background Shapes -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-1/4 left-1/4 w-64 h-64 border border-[var(--color-accent)]/20 rotate-45 animate-spin-slow"></div>
            <div class="absolute bottom-1/4 right-1/4 w-48 h-48 border border-[var(--color-accent)]/10 rotate-12 animate-spin-slow" style="animation-direction: reverse;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 border border-[var(--color-accent)]/5 rotate-45"></div>
            <div class="geo-grid absolute inset-0"></div>
        </div>
        
        <div class="text-center relative z-10 px-6 max-w-md">
            <!-- Decorative Top Element -->
            <div class="flex justify-center mb-8 animate-fade-in">
                <div class="w-1 h-16 bg-gradient-to-b from-transparent via-[var(--color-accent)] to-transparent"></div>
            </div>
            
            <p class="text-xs uppercase tracking-[0.5em] text-[var(--color-accent)]/80 mb-8 animate-fade-in-up">The Wedding of</p>
            
            <div class="relative animate-scale-in delay-100">
                <div class="absolute -inset-4 border border-[var(--color-accent)]/30 rotate-45 scale-75"></div>
                <h1 class="text-5xl sm:text-6xl font-display text-white mb-3 tracking-wide">{{ $invitation->groom_name }}</h1>
                <div class="flex items-center justify-center gap-4 my-4">
                    <div class="w-16 h-[1px] bg-gradient-to-r from-transparent to-[var(--color-accent)]"></div>
                    <div class="w-3 h-3 border border-[var(--color-accent)] rotate-45"></div>
                    <div class="w-16 h-[1px] bg-gradient-to-l from-transparent to-[var(--color-accent)]"></div>
                </div>
                <h1 class="text-5xl sm:text-6xl font-display text-white tracking-wide">{{ $invitation->bride_name }}</h1>
            </div>
            
            @if($guestName)
            <div class="mt-10 animate-fade-in-up delay-200">
                <p class="text-xs uppercase tracking-[0.3em] text-white/50 mb-2">Kepada Yth.</p>
                <p class="text-lg text-[var(--color-accent)] font-medium">{{ urldecode($guestName) }}</p>
                @if($guest && $guest->invited_by)
                <p class="text-sm text-white/60 mt-2">Turut Mengundang: {{ $guest->invited_by }}</p>
                @endif
            </div>
            @endif
            
            <button @click="openInvitation()" class="mt-12 group relative animate-fade-in-up delay-300">
                <div class="absolute inset-0 bg-[var(--color-accent)] rotate-45 scale-0 group-hover:scale-100 transition-transform duration-500"></div>
                <span class="relative px-10 py-4 border-2 border-[var(--color-accent)] text-[var(--color-accent)] group-hover:text-[var(--color-primary)] text-sm uppercase tracking-[0.3em] font-medium transition-colors duration-500 inline-block">
                    Buka Undangan
                </span>
            </button>
            
            <!-- Decorative Bottom Element -->
            <div class="flex justify-center mt-8 animate-fade-in delay-400">
                <div class="w-1 h-16 bg-gradient-to-t from-transparent via-[var(--color-accent)] to-transparent"></div>
            </div>
        </div>
    </section>


    <!-- Main Content -->
    <div x-show="opened" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-1">

        <!-- Hero Section -->
        <section class="min-h-screen flex items-center justify-center relative py-24 px-6">
            <div class="absolute inset-0 geo-grid"></div>
            
            <!-- Floating Geometric Elements -->
            <div class="absolute top-20 left-20 w-20 h-20 border border-[var(--color-accent)]/30 rotate-45 animate-float"></div>
            <div class="absolute bottom-32 right-16 w-16 h-16 bg-[var(--color-accent)]/10 rotate-45 animate-float delay-300"></div>
            <div class="absolute top-1/3 right-1/4 w-12 h-12 border border-[var(--color-primary)]/20 rotate-12 animate-float delay-200"></div>
            
            <div class="text-center relative z-10 max-w-2xl section-reveal" x-intersect="$el.classList.add('revealed')">
                <!-- Decorative Frame -->
                <div class="relative inline-block p-12 sm:p-16">
                    <div class="absolute top-0 left-0 w-20 h-20 border-t-2 border-l-2 border-[var(--color-accent)]"></div>
                    <div class="absolute top-0 right-0 w-20 h-20 border-t-2 border-r-2 border-[var(--color-accent)]"></div>
                    <div class="absolute bottom-0 left-0 w-20 h-20 border-b-2 border-l-2 border-[var(--color-accent)]"></div>
                    <div class="absolute bottom-0 right-0 w-20 h-20 border-b-2 border-r-2 border-[var(--color-accent)]"></div>
                    
                    <p class="text-xs uppercase tracking-[0.5em] text-[var(--color-accent)] mb-8">We're Getting Married</p>
                    <h2 class="text-5xl sm:text-7xl font-display text-[var(--color-primary)] mb-4">{{ $invitation->groom_name }}</h2>
                    <div class="flex items-center justify-center gap-6 my-6">
                        <div class="w-24 h-[1px] bg-gradient-to-r from-transparent to-[var(--color-accent)]"></div>
                        <div class="relative">
                            <div class="w-4 h-4 border-2 border-[var(--color-accent)] rotate-45"></div>
                            <div class="absolute inset-0 w-4 h-4 bg-[var(--color-accent)]/30 rotate-45 scale-150"></div>
                        </div>
                        <div class="w-24 h-[1px] bg-gradient-to-l from-transparent to-[var(--color-accent)]"></div>
                    </div>
                    <h2 class="text-5xl sm:text-7xl font-display text-[var(--color-primary)]">{{ $invitation->bride_name }}</h2>
                    <div class="mt-10">
                        <p class="text-sm uppercase tracking-[0.3em] text-[var(--color-primary)]/60">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                    </div>
                </div>
            </div>
        </section>


        <!-- Opening Quote -->
        @if($invitation->opening_text)
        <section class="py-24 px-6 bg-white relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[var(--color-accent)] to-transparent"></div>
            <div class="absolute -left-20 top-1/2 -translate-y-1/2 w-40 h-40 border border-[var(--color-accent)]/10 rotate-45"></div>
            <div class="absolute -right-20 top-1/2 -translate-y-1/2 w-40 h-40 border border-[var(--color-accent)]/10 rotate-45"></div>
            
            <div class="max-w-3xl mx-auto text-center section-reveal" x-intersect="$el.classList.add('revealed')">
                <div class="w-8 h-8 border border-[var(--color-accent)] rotate-45 mx-auto mb-10"></div>
                <p class="text-xl sm:text-2xl text-[var(--color-primary)]/80 leading-relaxed font-light italic">
                    "{{ $invitation->opening_text }}"
                </p>
                <div class="w-8 h-8 border border-[var(--color-accent)] rotate-45 mx-auto mt-10"></div>
            </div>
        </section>
        @endif

        <!-- Couple Profile -->
        <section class="py-24 px-6 relative">
            <div class="absolute inset-0 geo-grid opacity-50"></div>
            
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-16 section-reveal" x-intersect="$el.classList.add('revealed')">
                    <p class="text-xs uppercase tracking-[0.5em] text-[var(--color-accent)] mb-4">The Couple</p>
                    <h2 class="text-4xl sm:text-5xl font-display text-[var(--color-primary)]">Mempelai</h2>
                </div>
                
                <div class="grid md:grid-cols-2 gap-16 lg:gap-24">
                    <!-- Groom -->
                    <div class="text-center section-reveal" x-intersect="$el.classList.add('revealed')">
                        @if($invitation->groom_photo)
                        <div class="relative inline-block mb-8">
                            <div class="absolute inset-0 border-2 border-[var(--color-accent)] rotate-45 scale-110"></div>
                            <div class="w-56 h-56 geo-octagon overflow-hidden relative z-10">
                                <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}" class="w-full h-full object-cover">
                            </div>
                        </div>
                        @else
                        <div class="w-56 h-56 geo-octagon bg-[var(--color-accent)]/20 mx-auto mb-8 flex items-center justify-center">
                            <svg class="w-20 h-20 text-[var(--color-accent)]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </div>
                        @endif
                        <h3 class="text-3xl font-display text-[var(--color-primary)] mb-2">{{ $invitation->groom_name }}</h3>
                        @if($invitation->groom_father || $invitation->groom_mother)
                        <p class="text-[var(--color-primary)]/60 text-sm mt-3">Putra dari<br>Bapak {{ $invitation->groom_father }} & Ibu {{ $invitation->groom_mother }}</p>
                        @endif
                        @if($invitation->groom_instagram)
                        <a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" target="_blank" class="inline-flex items-center gap-2 mt-4 text-[var(--color-accent)] hover:underline text-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z"/></svg>
                            {{ $invitation->groom_instagram }}
                        </a>
                        @endif
                    </div>


                    <!-- Bride -->
                    <div class="text-center section-reveal" x-intersect="$el.classList.add('revealed')">
                        @if($invitation->bride_photo)
                        <div class="relative inline-block mb-8">
                            <div class="absolute inset-0 border-2 border-[var(--color-accent)] rotate-45 scale-110"></div>
                            <div class="w-56 h-56 geo-octagon overflow-hidden relative z-10">
                                <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}" class="w-full h-full object-cover">
                            </div>
                        </div>
                        @else
                        <div class="w-56 h-56 geo-octagon bg-[var(--color-accent)]/20 mx-auto mb-8 flex items-center justify-center">
                            <svg class="w-20 h-20 text-[var(--color-accent)]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </div>
                        @endif
                        <h3 class="text-3xl font-display text-[var(--color-primary)] mb-2">{{ $invitation->bride_name }}</h3>
                        @if($invitation->bride_father || $invitation->bride_mother)
                        <p class="text-[var(--color-primary)]/60 text-sm mt-3">Putri dari<br>Bapak {{ $invitation->bride_father }} & Ibu {{ $invitation->bride_mother }}</p>
                        @endif
                        @if($invitation->bride_instagram)
                        <a href="https://instagram.com/{{ ltrim($invitation->bride_instagram, '@') }}" target="_blank" class="inline-flex items-center gap-2 mt-4 text-[var(--color-accent)] hover:underline text-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z"/></svg>
                            {{ $invitation->bride_instagram }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Countdown -->
        <section class="py-24 px-6 bg-[var(--color-primary)] text-white relative overflow-hidden">
            <!-- Animated Background -->
            <div class="absolute inset-0">
                <div class="absolute top-10 left-10 w-48 h-48 border border-white/10 rotate-45 animate-spin-slow"></div>
                <div class="absolute bottom-10 right-10 w-64 h-64 border border-white/5 rotate-12 animate-spin-slow" style="animation-direction: reverse;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] border border-white/5 rotate-45"></div>
            </div>
            
            <div class="max-w-4xl mx-auto text-center relative z-10 section-reveal" x-intersect="$el.classList.add('revealed')">
                <p class="text-xs uppercase tracking-[0.5em] text-[var(--color-accent)] mb-4">Save The Date</p>
                <h2 class="text-4xl sm:text-5xl font-display mb-16">Menghitung Hari</h2>
                
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-6" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">
                    <div class="group">
                        <div class="relative">
                            <div class="absolute inset-0 border border-[var(--color-accent)]/30 rotate-45 group-hover:rotate-[50deg] transition-transform duration-500"></div>
                            <div class="bg-white/5 backdrop-blur-sm p-8 relative">
                                <p class="text-4xl sm:text-6xl font-display text-[var(--color-accent)]" x-text="days">0</p>
                                <p class="text-xs uppercase tracking-[0.3em] text-white/50 mt-3">Hari</p>
                            </div>
                        </div>
                    </div>
                    <div class="group">
                        <div class="relative">
                            <div class="absolute inset-0 border border-[var(--color-accent)]/30 rotate-45 group-hover:rotate-[50deg] transition-transform duration-500"></div>
                            <div class="bg-white/5 backdrop-blur-sm p-8 relative">
                                <p class="text-4xl sm:text-6xl font-display text-[var(--color-accent)]" x-text="hours">0</p>
                                <p class="text-xs uppercase tracking-[0.3em] text-white/50 mt-3">Jam</p>
                            </div>
                        </div>
                    </div>
                    <div class="group">
                        <div class="relative">
                            <div class="absolute inset-0 border border-[var(--color-accent)]/30 rotate-45 group-hover:rotate-[50deg] transition-transform duration-500"></div>
                            <div class="bg-white/5 backdrop-blur-sm p-8 relative">
                                <p class="text-4xl sm:text-6xl font-display text-[var(--color-accent)]" x-text="minutes">0</p>
                                <p class="text-xs uppercase tracking-[0.3em] text-white/50 mt-3">Menit</p>
                            </div>
                        </div>
                    </div>
                    <div class="group">
                        <div class="relative">
                            <div class="absolute inset-0 border border-[var(--color-accent)]/30 rotate-45 group-hover:rotate-[50deg] transition-transform duration-500"></div>
                            <div class="bg-white/5 backdrop-blur-sm p-8 relative">
                                <p class="text-4xl sm:text-6xl font-display text-[var(--color-accent)]" x-text="seconds">0</p>
                                <p class="text-xs uppercase tracking-[0.3em] text-white/50 mt-3">Detik</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Event Details -->
        <section class="py-24 px-6 bg-white relative overflow-hidden">
            <div class="absolute -left-32 top-1/2 -translate-y-1/2 w-64 h-64 border border-[var(--color-accent)]/10 rotate-45"></div>
            <div class="absolute -right-32 top-1/2 -translate-y-1/2 w-64 h-64 border border-[var(--color-accent)]/10 rotate-45"></div>
            
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-16 section-reveal" x-intersect="$el.classList.add('revealed')">
                    <p class="text-xs uppercase tracking-[0.5em] text-[var(--color-accent)] mb-4">When & Where</p>
                    <h2 class="text-4xl sm:text-5xl font-display text-[var(--color-primary)]">Detail Acara</h2>
                </div>
                
                <div class="relative section-reveal" x-intersect="$el.classList.add('revealed')">
                    <!-- Decorative Frame -->
                    <div class="absolute -top-4 -left-4 w-8 h-8 border-t-2 border-l-2 border-[var(--color-accent)]"></div>
                    <div class="absolute -top-4 -right-4 w-8 h-8 border-t-2 border-r-2 border-[var(--color-accent)]"></div>
                    <div class="absolute -bottom-4 -left-4 w-8 h-8 border-b-2 border-l-2 border-[var(--color-accent)]"></div>
                    <div class="absolute -bottom-4 -right-4 w-8 h-8 border-b-2 border-r-2 border-[var(--color-accent)]"></div>
                    
                    <div class="bg-[var(--color-secondary)] p-10 sm:p-16 text-center">
                        <div class="w-12 h-12 border border-[var(--color-accent)] rotate-45 mx-auto mb-8 flex items-center justify-center">
                            <svg class="w-5 h-5 text-[var(--color-accent)] -rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        
                        <h3 class="text-2xl sm:text-3xl font-display text-[var(--color-primary)] mb-6">{{ $invitation->event_venue }}</h3>
                        
                        <div class="space-y-2 text-[var(--color-primary)]/70 mb-8">
                            <p class="text-lg">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                            <p>Pukul {{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }} {{ $invitation->event_time_end ? '- ' . \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') : '' }} WIB</p>
                            @if($invitation->event_address)
                            <p class="text-sm max-w-md mx-auto mt-4">{{ $invitation->event_address }}</p>
                            @endif
                        </div>
                        
                        @if($invitation->event_maps_url)
                        <a href="{{ $invitation->event_maps_url }}" target="_blank" class="group inline-flex items-center gap-3 px-8 py-3 border-2 border-[var(--color-primary)] text-[var(--color-primary)] text-sm uppercase tracking-[0.2em] hover:bg-[var(--color-primary)] hover:text-white transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Lihat Lokasi
                        </a>
                        @endif
                    </div>
                </div>
                
                @if($invitation->dress_code)
                <div class="mt-8 text-center section-reveal" x-intersect="$el.classList.add('revealed')">
                    <div class="inline-block px-8 py-4 border border-[var(--color-accent)]">
                        <p class="text-xs uppercase tracking-[0.3em] text-[var(--color-accent)] mb-1">Dress Code</p>
                        <p class="text-[var(--color-primary)] font-medium">{{ $invitation->dress_code }}</p>
                    </div>
                </div>
                @endif
            </div>
        </section>


        <!-- Love Story Timeline -->
        @if($invitation->love_story && count($invitation->love_story) > 0)
        <section class="py-24 px-6 bg-white relative overflow-hidden">
            <div class="absolute -left-32 top-1/2 -translate-y-1/2 w-64 h-64 border border-[var(--color-accent)]/10 rotate-45"></div>
            <div class="absolute -right-32 top-1/2 -translate-y-1/2 w-64 h-64 border border-[var(--color-accent)]/10 rotate-45"></div>
            
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-16 section-reveal" x-intersect="$el.classList.add('revealed')">
                    <p class="text-xs uppercase tracking-[0.5em] text-[var(--color-accent)] mb-4">Our Journey</p>
                    <h2 class="text-4xl sm:text-5xl font-display text-[var(--color-primary)]">Love Story</h2>
                </div>
                
                <div class="relative section-reveal" x-intersect="$el.classList.add('revealed')">
                    <!-- Timeline line -->
                    <div class="absolute left-4 md:left-1/2 top-0 bottom-0 w-0.5 bg-[var(--color-accent)]/30 transform md:-translate-x-1/2"></div>
                    
                    @foreach($invitation->love_story as $index => $story)
                    <div class="relative mb-16 last:mb-0 {{ $index % 2 == 0 ? 'md:pr-1/2' : 'md:pl-1/2 md:ml-auto' }}">
                        <!-- Timeline dot -->
                        <div class="absolute left-4 md:left-1/2 w-4 h-4 bg-[var(--color-accent)] rotate-45 transform -translate-x-1/2 md:-translate-x-1/2 border-4 border-white"></div>
                        
                        <div class="ml-12 md:ml-0 {{ $index % 2 == 0 ? 'md:mr-8' : 'md:ml-8' }}">
                            <div class="bg-[var(--color-secondary)] p-6 relative group">
                                <div class="absolute top-0 left-0 w-4 h-4 border-t-2 border-l-2 border-[var(--color-accent)] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                <div class="absolute top-0 right-0 w-4 h-4 border-t-2 border-r-2 border-[var(--color-accent)] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                <div class="absolute bottom-0 left-0 w-4 h-4 border-b-2 border-l-2 border-[var(--color-accent)] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                <div class="absolute bottom-0 right-0 w-4 h-4 border-b-2 border-r-2 border-[var(--color-accent)] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                @if(!empty($story['date']))
                                <p class="text-xs uppercase tracking-[0.3em] text-[var(--color-accent)] mb-2">{{ $story['date'] }}</p>
                                @endif
                                <h4 class="text-xl font-display text-[var(--color-primary)] mb-2">{{ $story['title'] }}</h4>
                                <p class="text-[var(--color-primary)]/70 text-sm leading-relaxed">{{ $story['description'] }}</p>
                                @if(!empty($story['image']))
                                <div class="mt-4 overflow-hidden">
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


        <!-- Gallery -->
        @if($invitation->galleries->count() > 0)
        <section class="py-24 px-6 relative">
            <div class="absolute inset-0 geo-grid opacity-50"></div>
            
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-16 section-reveal" x-intersect="$el.classList.add('revealed')">
                    <p class="text-xs uppercase tracking-[0.5em] text-[var(--color-accent)] mb-4">Our Moments</p>
                    <h2 class="text-4xl sm:text-5xl font-display text-[var(--color-primary)]">Galeri</h2>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 section-reveal" x-intersect="$el.classList.add('revealed')">
                    @foreach($invitation->galleries as $index => $photo)
                    <div class="group relative aspect-square overflow-hidden {{ $index === 0 ? 'md:col-span-2 md:row-span-2' : '' }}">
                        <img src="{{ $photo->getImageUrl() }}" alt="{{ $photo->caption }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-[var(--color-primary)]/0 group-hover:bg-[var(--color-primary)]/30 transition-colors duration-500"></div>
                        <div class="absolute inset-4 border border-white/0 group-hover:border-white/50 transition-colors duration-500"></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- RSVP -->
        <section class="py-24 px-6 bg-white relative overflow-hidden">
            <div class="absolute top-20 left-10 w-32 h-32 border border-[var(--color-accent)]/10 rotate-45"></div>
            <div class="absolute bottom-20 right-10 w-24 h-24 border border-[var(--color-accent)]/10 rotate-12"></div>
            
            <div class="max-w-lg mx-auto relative z-10">
                <div class="text-center mb-12 section-reveal" x-intersect="$el.classList.add('revealed')">
                    <p class="text-xs uppercase tracking-[0.5em] text-[var(--color-accent)] mb-4">Reservation</p>
                    <h2 class="text-4xl sm:text-5xl font-display text-[var(--color-primary)]">RSVP</h2>
                </div>
                
                @if(session('success'))
                <div class="mb-8 p-4 bg-green-50 border border-green-200 text-green-700 text-center text-sm">{{ session('success') }}</div>
                @endif
                
                <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" class="space-y-5 section-reveal" x-intersect="$el.classList.add('revealed')">
                    @csrf
                    <div class="relative">
                        <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Lengkap" required 
                            class="w-full px-5 py-4 bg-[var(--color-secondary)] border-0 border-b-2 border-[var(--color-accent)]/30 focus:border-[var(--color-accent)] focus:ring-0 transition-colors placeholder:text-[var(--color-primary)]/40">
                    </div>
                    <div class="relative">
                        <select name="rsvp_status" required 
                            class="w-full px-5 py-4 bg-[var(--color-secondary)] border-0 border-b-2 border-[var(--color-accent)]/30 focus:border-[var(--color-accent)] focus:ring-0 transition-colors text-[var(--color-primary)]">
                            <option value="" class="text-[var(--color-primary)]/40">Konfirmasi Kehadiran</option>
                            <option value="attending">Ya, Saya Akan Hadir</option>
                            <option value="not_attending">Maaf, Tidak Bisa Hadir</option>
                            <option value="maybe">Masih Ragu</option>
                        </select>
                    </div>
                    <div class="relative">
                        <input type="number" name="number_of_guests" min="1" max="10" value="1" placeholder="Jumlah Tamu" 
                            class="w-full px-5 py-4 bg-[var(--color-secondary)] border-0 border-b-2 border-[var(--color-accent)]/30 focus:border-[var(--color-accent)] focus:ring-0 transition-colors placeholder:text-[var(--color-primary)]/40">
                    </div>
                    <button type="submit" class="w-full py-4 bg-[var(--color-primary)] text-white text-sm uppercase tracking-[0.3em] hover:bg-[var(--color-accent)] transition-colors duration-300">
                        Kirim Konfirmasi
                    </button>
                </form>
            </div>
        </section>


        <!-- Guestbook / Wishes -->
        <section class="py-24 px-6 relative">
            <div class="absolute inset-0 geo-grid opacity-30"></div>
            
            <div class="max-w-2xl mx-auto relative z-10">
                <div class="text-center mb-12 section-reveal" x-intersect="$el.classList.add('revealed')">
                    <p class="text-xs uppercase tracking-[0.5em] text-[var(--color-accent)] mb-4">Send Your Wishes</p>
                    <h2 class="text-4xl sm:text-5xl font-display text-[var(--color-primary)]">Ucapan & Doa</h2>
                </div>
                
                <form method="POST" action="{{ route('invitation.guestbook', $invitation->slug) }}" class="space-y-5 mb-12 section-reveal" x-intersect="$el.classList.add('revealed')">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Anda" required 
                        class="w-full px-5 py-4 bg-white border-0 border-b-2 border-[var(--color-accent)]/30 focus:border-[var(--color-accent)] focus:ring-0 transition-colors placeholder:text-[var(--color-primary)]/40">
                    <textarea name="message" rows="4" placeholder="Tulis ucapan dan doa untuk kedua mempelai..." required 
                        class="w-full px-5 py-4 bg-white border-0 border-b-2 border-[var(--color-accent)]/30 focus:border-[var(--color-accent)] focus:ring-0 transition-colors placeholder:text-[var(--color-primary)]/40 resize-none"></textarea>
                    <button type="submit" class="w-full py-4 border-2 border-[var(--color-primary)] text-[var(--color-primary)] text-sm uppercase tracking-[0.3em] hover:bg-[var(--color-primary)] hover:text-white transition-all duration-300">
                        Kirim Ucapan
                    </button>
                </form>
                
                <!-- Messages List -->
                <div class="space-y-4 max-h-[500px] overflow-y-auto pr-2 section-reveal" x-intersect="$el.classList.add('revealed')">
                    @forelse($invitation->guestbooks as $msg)
                    <div class="bg-white p-6 relative group">
                        <div class="absolute top-0 left-0 w-3 h-3 border-t border-l border-[var(--color-accent)] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="absolute bottom-0 right-0 w-3 h-3 border-b border-r border-[var(--color-accent)] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-[var(--color-accent)]/20 geo-hexagon flex items-center justify-center flex-shrink-0">
                                <span class="text-[var(--color-accent)] text-sm font-medium">{{ strtoupper(substr($msg->name, 0, 1)) }}</span>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-[var(--color-primary)]">{{ $msg->name }}</p>
                                <p class="text-[var(--color-primary)]/70 text-sm mt-1 leading-relaxed">{{ $msg->message }}</p>
                                <p class="text-xs text-[var(--color-primary)]/40 mt-2">{{ $msg->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-[var(--color-primary)]/50 py-8">Jadilah yang pertama mengirim ucapan!</p>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Digital Envelope / Gift -->
        @if($invitation->hasDigitalEnvelope())
        <section class="py-24 px-6 bg-[var(--color-primary)] text-white relative overflow-hidden">
            <div class="absolute inset-0">
                <div class="absolute top-1/4 left-1/4 w-48 h-48 border border-white/5 rotate-45"></div>
                <div class="absolute bottom-1/4 right-1/4 w-32 h-32 border border-white/5 rotate-12"></div>
            </div>
            
            <div class="max-w-lg mx-auto text-center relative z-10 section-reveal" x-intersect="$el.classList.add('revealed')">
                <p class="text-xs uppercase tracking-[0.5em] text-[var(--color-accent)] mb-4">Wedding Gift</p>
                <h2 class="text-4xl sm:text-5xl font-display mb-8">Amplop Digital</h2>
                
                @if($invitation->gift_info)
                <p class="text-white/70 mb-10 leading-relaxed">{{ $invitation->gift_info }}</p>
                @else
                <p class="text-white/70 mb-10 leading-relaxed">Tanpa mengurangi rasa hormat, bagi Anda yang ingin memberikan tanda kasih, dapat melalui:</p>
                @endif
                
                @foreach($invitation->bank_accounts_list as $account)
                <div class="bg-white/10 backdrop-blur-sm p-8 mb-6 relative group">
                    <div class="absolute inset-0 border border-[var(--color-accent)]/30 rotate-1 group-hover:rotate-0 transition-transform duration-500"></div>
                    <div class="relative">
                        <p class="text-xs uppercase tracking-[0.3em] text-[var(--color-accent)] mb-3">{{ $account['bank_name'] }}</p>
                        <p class="text-3xl font-display text-white mb-2">{{ $account['account_number'] }}</p>
                        <p class="text-white/60 text-sm">a.n. {{ $account['account_name'] }}</p>
                    </div>
                </div>
                @endforeach
                
                @if($invitation->qris_image)
                <div class="inline-block bg-white p-4 mt-6 cursor-pointer" @click="$dispatch('open-qris')">
                    <p class="text-xs text-gray-500 mb-2">Tap untuk perbesar</p>
                    <img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS" class="w-48 h-48 object-contain">
                </div>
                @endif
            </div>
        </section>
        @endif


        <!-- Closing -->
        @if($invitation->closing_text)
        <section class="py-24 px-6 bg-white relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[var(--color-accent)] to-transparent"></div>
            <div class="absolute -left-20 top-1/2 -translate-y-1/2 w-40 h-40 border border-[var(--color-accent)]/10 rotate-45"></div>
            <div class="absolute -right-20 top-1/2 -translate-y-1/2 w-40 h-40 border border-[var(--color-accent)]/10 rotate-45"></div>
            
            <div class="max-w-3xl mx-auto text-center section-reveal" x-intersect="$el.classList.add('revealed')">
                <div class="w-8 h-8 border border-[var(--color-accent)] rotate-45 mx-auto mb-10"></div>
                <p class="text-xl text-[var(--color-primary)]/80 leading-relaxed font-light mb-10">
                    {{ $invitation->closing_text }}
                </p>
                <div class="flex items-center justify-center gap-4 mb-6">
                    <div class="w-16 h-[1px] bg-gradient-to-r from-transparent to-[var(--color-accent)]"></div>
                    <div class="w-3 h-3 border border-[var(--color-accent)] rotate-45"></div>
                    <div class="w-16 h-[1px] bg-gradient-to-l from-transparent to-[var(--color-accent)]"></div>
                </div>
                <h3 class="text-3xl font-display text-[var(--color-primary)]">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</h3>
            </div>
        </section>
        @endif

        <!-- Footer -->
        <footer class="py-10 px-6 bg-[var(--color-secondary)] text-center relative">
            <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-[var(--color-accent)]/30 to-transparent"></div>
            <p class="text-xs text-[var(--color-primary)]/40 tracking-wider">
                Made with love • Powered by <a href="{{ url('/') }}" class="text-[var(--color-accent)] hover:underline">Ellori</a>
            </p>
        </footer>
    </div>

    <!-- Music Player -->
    @if($invitation->music_url)
    <div class="fixed bottom-6 right-6 z-40" x-show="opened" x-transition>
        <button @click="toggleMusic()" class="group relative w-14 h-14 flex items-center justify-center">
            <div class="absolute inset-0 bg-[var(--color-primary)] rotate-45 group-hover:rotate-[50deg] transition-transform duration-300"></div>
            <span class="relative text-white">
                <svg x-show="!playing" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/></svg>
                <svg x-show="playing" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z"/></svg>
            </span>
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
    
    // Section reveal on scroll
    document.addEventListener('DOMContentLoaded', function() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                }
            });
        }, { threshold: 0.1 });
        
        document.querySelectorAll('.section-reveal').forEach(el => observer.observe(el));
    });
    </script>
    @include('templates.partials.qris-modal')
</body>
</html>
