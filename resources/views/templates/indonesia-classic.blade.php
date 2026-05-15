<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $invitation->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Alex+Brush&family=Josefin+Sans:wght@300;400;500;600&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: {{ $invitation->color_primary ?? '#8B7355' }};
            --primary-light: #A89070;
            --bg: #FBF8F4;
            --bg-alt: #F5F0EA;
            --dark: #3D3229;
            --text: #5A4A3A;
            --muted: #8C7E70;
            --accent: #C4A882;
            --white: #FFFFFF;
        }
        * { box-sizing: border-box; }
        body { font-family: 'Josefin Sans', sans-serif; font-weight: 300; margin: 0; padding: 0; overflow-x: hidden; }
        .font-script { font-family: 'Alex Brush', cursive; }
        .font-serif { font-family: 'Cormorant Garamond', serif; }
        [x-cloak] { display: none !important; }

        /* ===== Scroll Animations ===== */
        .fade-up {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .fade-in {
            opacity: 0;
            transition: opacity 0.8s ease;
        }
        .fade-in.visible { opacity: 1; }

        .delay-100 { transition-delay: 0.1s; }
        .delay-200 { transition-delay: 0.2s; }
        .delay-300 { transition-delay: 0.3s; }
        .delay-400 { transition-delay: 0.4s; }

        /* ===== Ornaments ===== */
        .floral-top-left {
            position: absolute;
            top: 0; left: 0;
            width: 140px; height: 140px;
            pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'%3E%3Cpath d='M0 0 C30 40 20 80 50 100 C20 120 30 160 0 200' fill='none' stroke='%238B7355' stroke-width='1' opacity='0.2'/%3E%3Cpath d='M0 0 C40 30 80 20 100 50' fill='none' stroke='%238B7355' stroke-width='0.8' opacity='0.15'/%3E%3Ccircle cx='50' cy='50' r='4' fill='%238B7355' opacity='0.15'/%3E%3Ccircle cx='30' cy='80' r='3' fill='%238B7355' opacity='0.1'/%3E%3Ccircle cx='80' cy='30' r='3' fill='%238B7355' opacity='0.1'/%3E%3Cpath d='M20 30 Q35 25 30 10' fill='none' stroke='%238B7355' stroke-width='0.6' opacity='0.12'/%3E%3Cpath d='M25 60 Q40 55 35 40' fill='none' stroke='%238B7355' stroke-width='0.6' opacity='0.12'/%3E%3C/svg%3E");
            background-size: contain;
            background-repeat: no-repeat;
        }
        .floral-top-right {
            position: absolute;
            top: 0; right: 0;
            width: 140px; height: 140px;
            pointer-events: none;
            transform: scaleX(-1);
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'%3E%3Cpath d='M0 0 C30 40 20 80 50 100 C20 120 30 160 0 200' fill='none' stroke='%238B7355' stroke-width='1' opacity='0.2'/%3E%3Cpath d='M0 0 C40 30 80 20 100 50' fill='none' stroke='%238B7355' stroke-width='0.8' opacity='0.15'/%3E%3Ccircle cx='50' cy='50' r='4' fill='%238B7355' opacity='0.15'/%3E%3Ccircle cx='30' cy='80' r='3' fill='%238B7355' opacity='0.1'/%3E%3Ccircle cx='80' cy='30' r='3' fill='%238B7355' opacity='0.1'/%3E%3Cpath d='M20 30 Q35 25 30 10' fill='none' stroke='%238B7355' stroke-width='0.6' opacity='0.12'/%3E%3Cpath d='M25 60 Q40 55 35 40' fill='none' stroke='%238B7355' stroke-width='0.6' opacity='0.12'/%3E%3C/svg%3E");
            background-size: contain;
            background-repeat: no-repeat;
        }
        .floral-bottom-left {
            position: absolute;
            bottom: 0; left: 0;
            width: 140px; height: 140px;
            pointer-events: none;
            transform: scaleY(-1);
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'%3E%3Cpath d='M0 0 C30 40 20 80 50 100 C20 120 30 160 0 200' fill='none' stroke='%238B7355' stroke-width='1' opacity='0.2'/%3E%3Cpath d='M0 0 C40 30 80 20 100 50' fill='none' stroke='%238B7355' stroke-width='0.8' opacity='0.15'/%3E%3Ccircle cx='50' cy='50' r='4' fill='%238B7355' opacity='0.15'/%3E%3Ccircle cx='30' cy='80' r='3' fill='%238B7355' opacity='0.1'/%3E%3C/svg%3E");
            background-size: contain;
            background-repeat: no-repeat;
        }
        .floral-bottom-right {
            position: absolute;
            bottom: 0; right: 0;
            width: 140px; height: 140px;
            pointer-events: none;
            transform: scale(-1, -1);
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'%3E%3Cpath d='M0 0 C30 40 20 80 50 100 C20 120 30 160 0 200' fill='none' stroke='%238B7355' stroke-width='1' opacity='0.2'/%3E%3Cpath d='M0 0 C40 30 80 20 100 50' fill='none' stroke='%238B7355' stroke-width='0.8' opacity='0.15'/%3E%3Ccircle cx='50' cy='50' r='4' fill='%238B7355' opacity='0.15'/%3E%3Ccircle cx='30' cy='80' r='3' fill='%238B7355' opacity='0.1'/%3E%3C/svg%3E");
            background-size: contain;
            background-repeat: no-repeat;
        }

        .section-ornament {
            width: 120px;
            height: 30px;
            margin: 0 auto;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 120 30' fill='none'%3E%3Cpath d='M0 15 Q30 5 60 15 Q90 25 120 15' stroke='%238B7355' stroke-width='0.8' opacity='0.3'/%3E%3Ccircle cx='60' cy='15' r='3' fill='%238B7355' opacity='0.4'/%3E%3Ccircle cx='45' cy='12' r='1.5' fill='%238B7355' opacity='0.2'/%3E%3Ccircle cx='75' cy='12' r='1.5' fill='%238B7355' opacity='0.2'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
        }

        /* ===== Music Button ===== */
        @keyframes musicPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .music-playing { animation: musicPulse 2s ease-in-out infinite; }
    </style>
</head>
<body class="bg-[var(--bg)] text-[var(--text)]" x-data="invitationApp()" x-cloak>


    <!-- ==================== OPENING COVER ==================== -->
    <section x-show="!opened" class="fixed inset-0 z-50 flex items-center justify-center overflow-hidden"
        style="background: linear-gradient(180deg, var(--bg) 0%, var(--bg-alt) 100%)"
        x-transition:leave="transition ease-in duration-700"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

        <div class="floral-top-left"></div>
        <div class="floral-top-right"></div>
        <div class="floral-bottom-left"></div>
        <div class="floral-bottom-right"></div>

        <div class="text-center px-8 relative z-10 max-w-sm mx-auto">
            <div class="section-ornament mb-8"></div>

            <p class="text-[11px] uppercase tracking-[0.4em] text-[var(--muted)] mb-6">The Wedding Of</p>

            <h1 class="text-5xl sm:text-6xl font-script text-[var(--primary)] leading-tight">{{ $invitation->groom_name }}</h1>
            <p class="text-2xl font-script text-[var(--accent)] my-2">&</p>
            <h1 class="text-5xl sm:text-6xl font-script text-[var(--primary)] leading-tight">{{ $invitation->bride_name }}</h1>

            <div class="section-ornament my-8" style="transform: scaleY(-1)"></div>

            @if($guestName)
            <div class="mt-6 mb-8">
                <p class="text-[10px] uppercase tracking-[0.3em] text-[var(--muted)] mb-2">Kepada Yth. Bapak/Ibu/Saudara/i</p>
                <p class="text-lg font-serif font-semibold text-[var(--dark)] bg-[var(--bg-alt)] inline-block px-6 py-2 rounded-lg border border-[var(--primary)]/10">{{ urldecode($guestName) }}</p>
            </div>
            @endif

            <p class="text-xs text-[var(--muted)] mb-8">Tanpa mengurangi rasa hormat, kami mengundang Anda untuk hadir di acara pernikahan kami.</p>

            <button @click="openInvitation()" class="px-8 py-3.5 bg-[var(--primary)] text-white text-sm font-medium rounded-full hover:bg-[var(--primary-light)] shadow-lg shadow-[var(--primary)]/20 transition-all duration-300 hover:scale-105 flex items-center gap-2 mx-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19V5a2 2 0 012-2h6.5l1 1H19a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                Buka Undangan
            </button>
        </div>
    </section>

    <!-- ==================== MAIN CONTENT ==================== -->
    <div x-show="opened" x-transition:enter="transition ease-out duration-800" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

        <!-- ===== HERO ===== -->
        <section class="min-h-screen flex items-center justify-center py-20 px-6 relative" style="background: linear-gradient(180deg, var(--bg) 0%, var(--white) 50%, var(--bg) 100%)">
            <div class="floral-top-left" style="opacity: 0.7"></div>
            <div class="floral-top-right" style="opacity: 0.7"></div>

            <div class="text-center max-w-md mx-auto fade-up">
                <div class="section-ornament mb-8"></div>
                <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--muted)] mb-8">The Wedding Of</p>
                <h2 class="text-6xl sm:text-7xl font-script text-[var(--primary)] leading-tight">{{ $invitation->groom_name }}</h2>
                <p class="text-3xl font-script text-[var(--accent)] my-3">&</p>
                <h2 class="text-6xl sm:text-7xl font-script text-[var(--primary)] leading-tight">{{ $invitation->bride_name }}</h2>
                <p class="mt-8 text-sm text-[var(--muted)] font-serif italic">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                <div class="section-ornament mt-8" style="transform: scaleY(-1)"></div>
            </div>
        </section>

        <!-- ===== AYAT / OPENING TEXT ===== -->
        @if($invitation->opening_text)
        <section class="py-16 px-6 bg-[var(--white)] relative">
            <div class="max-w-md mx-auto text-center fade-up">
                <div class="section-ornament mb-6"></div>
                <p class="text-sm font-serif italic text-[var(--text)] leading-loose px-4">"{{ $invitation->opening_text }}"</p>
                <div class="section-ornament mt-6" style="transform: scaleY(-1)"></div>
            </div>
        </section>
        @endif

        <!-- ===== MEMPELAI ===== -->
        <section class="py-16 px-6 bg-[var(--bg)] relative">
            <div class="floral-top-left" style="opacity: 0.5"></div>
            <div class="floral-bottom-right" style="opacity: 0.5"></div>

            <div class="max-w-md mx-auto">
                <div class="text-center mb-12 fade-up">
                    <p class="text-[10px] uppercase tracking-[0.4em] text-[var(--muted)] mb-2">Bride & Groom</p>
                    <h3 class="text-2xl font-serif text-[var(--dark)]">Mempelai</h3>
                </div>

                <!-- Groom -->
                <div class="text-center mb-12 fade-up delay-100">
                    @if($invitation->groom_photo)
                    <div class="w-44 h-44 mx-auto mb-5 rounded-full overflow-hidden border-[3px] border-[var(--accent)]/40 p-[3px] bg-white shadow-lg">
                        <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}" class="w-full h-full object-cover rounded-full">
                    </div>
                    @else
                    <div class="w-44 h-44 mx-auto mb-5 rounded-full bg-[var(--bg-alt)] flex items-center justify-center border-[3px] border-[var(--accent)]/30 shadow-lg">
                        <span class="text-5xl font-script text-[var(--primary)]">{{ substr($invitation->groom_name, 0, 1) }}</span>
                    </div>
                    @endif
                    <h4 class="text-3xl font-script text-[var(--primary)] mb-2">{{ $invitation->groom_name }}</h4>
                    @if($invitation->groom_father || $invitation->groom_mother)
                    <p class="text-xs text-[var(--muted)] leading-relaxed">Putra dari<br>
                        <span class="text-[var(--text)] font-medium">Bapak {{ $invitation->groom_father }}</span><br>
                        & <span class="text-[var(--text)] font-medium">Ibu {{ $invitation->groom_mother }}</span>
                    </p>
                    @endif
                    @if($invitation->groom_instagram)
                    <a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" target="_blank" class="inline-flex items-center gap-1 mt-2 text-xs text-[var(--primary)] hover:underline">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        {{ $invitation->groom_instagram }}
                    </a>
                    @endif
                </div>

                <div class="text-center mb-12 fade-up delay-200">
                    <p class="text-4xl font-script text-[var(--accent)]">&</p>
                </div>

                <!-- Bride -->
                <div class="text-center fade-up delay-300">
                    @if($invitation->bride_photo)
                    <div class="w-44 h-44 mx-auto mb-5 rounded-full overflow-hidden border-[3px] border-[var(--accent)]/40 p-[3px] bg-white shadow-lg">
                        <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}" class="w-full h-full object-cover rounded-full">
                    </div>
                    @else
                    <div class="w-44 h-44 mx-auto mb-5 rounded-full bg-[var(--bg-alt)] flex items-center justify-center border-[3px] border-[var(--accent)]/30 shadow-lg">
                        <span class="text-5xl font-script text-[var(--primary)]">{{ substr($invitation->bride_name, 0, 1) }}</span>
                    </div>
                    @endif
                    <h4 class="text-3xl font-script text-[var(--primary)] mb-2">{{ $invitation->bride_name }}</h4>
                    @if($invitation->bride_father || $invitation->bride_mother)
                    <p class="text-xs text-[var(--muted)] leading-relaxed">Putri dari<br>
                        <span class="text-[var(--text)] font-medium">Bapak {{ $invitation->bride_father }}</span><br>
                        & <span class="text-[var(--text)] font-medium">Ibu {{ $invitation->bride_mother }}</span>
                    </p>
                    @endif
                    @if($invitation->bride_instagram)
                    <a href="https://instagram.com/{{ ltrim($invitation->bride_instagram, '@') }}" target="_blank" class="inline-flex items-center gap-1 mt-2 text-xs text-[var(--primary)] hover:underline">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        {{ $invitation->bride_instagram }}
                    </a>
                    @endif
                </div>
            </div>
        </section>

        <!-- ===== COUNTDOWN ===== -->
        <section class="py-16 px-6 bg-[var(--primary)] relative" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">
            <div class="max-w-sm mx-auto text-center fade-up">
                <p class="text-[10px] uppercase tracking-[0.4em] text-white/60 mb-8">Counting Down</p>
                <div class="grid grid-cols-4 gap-3">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/10">
                        <p class="text-2xl sm:text-3xl font-bold text-white" x-text="days">0</p>
                        <p class="text-[9px] uppercase tracking-wider text-white/50 mt-1">Hari</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/10">
                        <p class="text-2xl sm:text-3xl font-bold text-white" x-text="hours">0</p>
                        <p class="text-[9px] uppercase tracking-wider text-white/50 mt-1">Jam</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/10">
                        <p class="text-2xl sm:text-3xl font-bold text-white" x-text="minutes">0</p>
                        <p class="text-[9px] uppercase tracking-wider text-white/50 mt-1">Menit</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/10">
                        <p class="text-2xl sm:text-3xl font-bold text-white" x-text="seconds">0</p>
                        <p class="text-[9px] uppercase tracking-wider text-white/50 mt-1">Detik</p>
                    </div>
                </div>
            </div>
        </section>


        <!-- ===== AKAD & RESEPSI (Terpisah seperti IndoInvite) ===== -->
        <section class="py-16 px-6 bg-[var(--white)] relative">
            <div class="floral-top-right" style="opacity: 0.4"></div>
            <div class="floral-bottom-left" style="opacity: 0.4"></div>

            <div class="max-w-md mx-auto">
                <div class="text-center mb-10 fade-up">
                    <p class="text-[10px] uppercase tracking-[0.4em] text-[var(--muted)] mb-2">Save The Date</p>
                    <h3 class="text-2xl font-serif text-[var(--dark)]">Acara Pernikahan</h3>
                </div>

                <!-- Akad Nikah -->
                <div class="bg-[var(--bg)] rounded-2xl p-6 mb-4 border border-[var(--primary)]/8 fade-up delay-100">
                    <div class="text-center">
                        <div class="w-10 h-10 mx-auto mb-3 rounded-full bg-[var(--primary)]/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-[var(--primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <h4 class="text-lg font-serif font-semibold text-[var(--dark)] mb-3">Akad Nikah</h4>
                        <div class="space-y-1 text-sm text-[var(--muted)]">
                            <p class="font-medium text-[var(--text)]">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                            <p>Pukul {{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }} WIB - Selesai</p>
                        </div>
                    </div>
                </div>

                <!-- Resepsi -->
                @if($invitation->reception_date || $invitation->reception_venue)
                <div class="bg-[var(--bg)] rounded-2xl p-6 mb-4 border border-[var(--primary)]/8 fade-up delay-200">
                    <div class="text-center">
                        <div class="w-10 h-10 mx-auto mb-3 rounded-full bg-[var(--primary)]/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-[var(--primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0A1.75 1.75 0 003 15.546m18-3.046c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0A1.75 1.75 0 003 12.5"/></svg>
                        </div>
                        <h4 class="text-lg font-serif font-semibold text-[var(--dark)] mb-3">Resepsi</h4>
                        <div class="space-y-1 text-sm text-[var(--muted)]">
                            <p class="font-medium text-[var(--text)]">{{ ($invitation->reception_date ?? $invitation->event_date)->translatedFormat('l, d F Y') }}</p>
                            @if($invitation->reception_time_start)
                            <p>Pukul {{ \Carbon\Carbon::parse($invitation->reception_time_start)->format('H:i') }} {{ $invitation->reception_time_end ? '- ' . \Carbon\Carbon::parse($invitation->reception_time_end)->format('H:i') : '' }} WIB</p>
                            @else
                            <p>Pukul {{ \Carbon\Carbon::parse($invitation->event_time_end ?? $invitation->event_time_start)->format('H:i') }} WIB - Selesai</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Lokasi -->
                <div class="bg-[var(--bg)] rounded-2xl p-6 border border-[var(--primary)]/8 fade-up delay-300">
                    <div class="text-center">
                        <div class="w-10 h-10 mx-auto mb-3 rounded-full bg-[var(--primary)]/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-[var(--primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <h4 class="text-lg font-serif font-semibold text-[var(--dark)] mb-2">{{ $invitation->event_venue }}</h4>
                        @if($invitation->event_address)
                        <p class="text-xs text-[var(--muted)] mb-4 leading-relaxed">{{ $invitation->event_address }}</p>
                        @endif
                        @if($invitation->event_maps_url)
                        <a href="{{ $invitation->event_maps_url }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[var(--primary)] text-white text-xs font-medium rounded-full hover:bg-[var(--primary-light)] transition-colors shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            Lihat Google Maps
                        </a>
                        @endif
                    </div>
                </div>

                @if($invitation->dress_code)
                <div class="mt-4 text-center fade-up delay-400">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-[var(--bg-alt)] rounded-lg border border-[var(--primary)]/8">
                        <span class="text-[10px] text-[var(--muted)]">Dress Code:</span>
                        <span class="text-[10px] font-medium text-[var(--primary)]">{{ $invitation->dress_code }}</span>
                    </div>
                </div>
                @endif
            </div>
        </section>

        <!-- ===== GALLERY ===== -->
        @if($invitation->galleries->count() > 0)
        <section class="py-16 px-6 bg-[var(--bg)]">
            <div class="max-w-lg mx-auto">
                <div class="text-center mb-10 fade-up">
                    <p class="text-[10px] uppercase tracking-[0.4em] text-[var(--muted)] mb-2">Our Moments</p>
                    <h3 class="text-2xl font-serif text-[var(--dark)]">Galeri</h3>
                </div>
                <div class="grid grid-cols-2 gap-2 fade-up delay-100">
                    @foreach($invitation->galleries as $photo)
                    <div class="aspect-square rounded-xl overflow-hidden group {{ $loop->first ? 'col-span-2 aspect-video' : '' }}">
                        <img src="{{ $photo->getImageUrl() }}" alt="{{ $photo->caption }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- ===== RSVP ===== -->
        <section class="py-16 px-6 bg-[var(--white)] relative">
            <div class="max-w-sm mx-auto">
                <div class="text-center mb-8 fade-up">
                    <p class="text-[10px] uppercase tracking-[0.4em] text-[var(--muted)] mb-2">Konfirmasi</p>
                    <h3 class="text-2xl font-serif text-[var(--dark)]">RSVP</h3>
                    <p class="text-xs text-[var(--muted)] mt-2">Mohon konfirmasi kehadiran Anda</p>
                </div>

                @if(session('success'))
                <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 text-xs text-center rounded-xl">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" class="space-y-3 fade-up delay-100">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Lengkap" required class="w-full px-4 py-3 bg-[var(--bg)] border border-[var(--primary)]/10 rounded-xl text-sm focus:ring-2 focus:ring-[var(--primary)]/20 focus:border-[var(--primary)]/30 transition-all placeholder:text-[var(--muted)]/50">
                    <select name="rsvp_status" required class="w-full px-4 py-3 bg-[var(--bg)] border border-[var(--primary)]/10 rounded-xl text-sm focus:ring-2 focus:ring-[var(--primary)]/20 focus:border-[var(--primary)]/30 transition-all">
                        <option value="">-- Konfirmasi Kehadiran --</option>
                        <option value="attending">Ya, Saya Akan Hadir</option>
                        <option value="not_attending">Maaf, Tidak Bisa Hadir</option>
                        <option value="maybe">Masih Ragu</option>
                    </select>
                    <input type="number" name="number_of_guests" min="1" max="10" value="1" placeholder="Jumlah Tamu" class="w-full px-4 py-3 bg-[var(--bg)] border border-[var(--primary)]/10 rounded-xl text-sm focus:ring-2 focus:ring-[var(--primary)]/20 focus:border-[var(--primary)]/30 transition-all">
                    <button type="submit" class="w-full py-3.5 bg-[var(--primary)] text-white text-sm font-medium rounded-xl hover:bg-[var(--primary-light)] transition-colors shadow-sm">
                        Kirim Konfirmasi
                    </button>
                </form>
            </div>
        </section>

        <!-- ===== UCAPAN ===== -->
        <section class="py-16 px-6 bg-[var(--bg)]">
            <div class="max-w-sm mx-auto">
                <div class="text-center mb-8 fade-up">
                    <p class="text-[10px] uppercase tracking-[0.4em] text-[var(--muted)] mb-2">Wishes</p>
                    <h3 class="text-2xl font-serif text-[var(--dark)]">Ucapan & Doa</h3>
                </div>

                <form method="POST" action="{{ route('invitation.guestbook', $invitation->slug) }}" class="space-y-3 mb-8 fade-up delay-100">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Anda" required class="w-full px-4 py-3 bg-[var(--white)] border border-[var(--primary)]/10 rounded-xl text-sm focus:ring-2 focus:ring-[var(--primary)]/20 focus:border-[var(--primary)]/30 transition-all placeholder:text-[var(--muted)]/50">
                    <textarea name="message" rows="3" placeholder="Tulis ucapan & doa..." required class="w-full px-4 py-3 bg-[var(--white)] border border-[var(--primary)]/10 rounded-xl text-sm focus:ring-2 focus:ring-[var(--primary)]/20 focus:border-[var(--primary)]/30 transition-all resize-none placeholder:text-[var(--muted)]/50"></textarea>
                    <button type="submit" class="w-full py-3.5 border-2 border-[var(--primary)] text-[var(--primary)] text-sm font-medium rounded-xl hover:bg-[var(--primary)] hover:text-white transition-all duration-300">
                        Kirim Ucapan
                    </button>
                </form>

                <div class="space-y-3 max-h-72 overflow-y-auto fade-up delay-200" style="scrollbar-width: thin;">
                    @foreach($invitation->guestbooks as $msg)
                    <div class="bg-[var(--white)] rounded-xl p-4 border border-[var(--primary)]/5">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-[var(--primary)]/10 flex items-center justify-center flex-shrink-0">
                                <span class="text-[10px] font-bold text-[var(--primary)]">{{ strtoupper(substr($msg->name, 0, 1)) }}</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-[var(--dark)]">{{ $msg->name }}</p>
                                <p class="text-xs text-[var(--muted)] mt-1 leading-relaxed">{{ $msg->message }}</p>
                                <p class="text-[9px] text-[var(--muted)]/50 mt-1">{{ $msg->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- ===== AMPLOP DIGITAL ===== -->
        @if($invitation->bank_name || $invitation->qris_image)
        <section class="py-16 px-6 bg-[var(--white)]">
            <div class="max-w-sm mx-auto text-center fade-up">
                <div class="section-ornament mb-6"></div>
                <p class="text-[10px] uppercase tracking-[0.4em] text-[var(--muted)] mb-2">Wedding Gift</p>
                <h3 class="text-2xl font-serif text-[var(--dark)] mb-3">Amplop Digital</h3>
                <p class="text-xs text-[var(--muted)] mb-8">Doa restu Anda merupakan karunia yang sangat berarti. Namun jika ingin memberi tanda kasih, bisa melalui:</p>

                @if($invitation->bank_name)
                <div class="bg-[var(--bg)] rounded-xl p-5 border border-[var(--primary)]/8 mb-4" x-data="{ copied: false }">
                    <p class="text-[10px] uppercase tracking-wider text-[var(--muted)] mb-2">{{ $invitation->bank_name }}</p>
                    <p class="text-lg font-bold text-[var(--dark)] tracking-wider mb-1">{{ $invitation->bank_account_number }}</p>
                    <p class="text-xs text-[var(--muted)]">a.n. {{ $invitation->bank_account_name }}</p>
                    <button @click="navigator.clipboard.writeText('{{ $invitation->bank_account_number }}'); copied = true; setTimeout(() => copied = false, 2000)" class="mt-4 px-4 py-2 bg-[var(--primary)]/10 text-[var(--primary)] text-[10px] font-medium rounded-lg hover:bg-[var(--primary)] hover:text-white transition-all">
                        <span x-text="copied ? '✓ Tersalin!' : 'Salin Nomor Rekening'"></span>
                    </button>
                </div>
                @endif

                @if($invitation->qris_image)
                <div class="inline-block bg-white p-4 rounded-xl border border-[var(--primary)]/8 shadow-sm">
                    <img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS" class="w-44 h-44 object-contain mx-auto">
                    <p class="text-[10px] text-[var(--muted)] mt-2">Scan QRIS</p>
                </div>
                @endif

                <div class="section-ornament mt-8" style="transform: scaleY(-1)"></div>
            </div>
        </section>
        @endif

        <!-- ===== CLOSING ===== -->
        @if($invitation->closing_text)
        <section class="py-16 px-6 bg-[var(--bg)] relative">
            <div class="floral-top-left" style="opacity: 0.4"></div>
            <div class="floral-bottom-right" style="opacity: 0.4"></div>
            <div class="max-w-sm mx-auto text-center fade-up relative z-10">
                <div class="section-ornament mb-6"></div>
                <p class="text-sm font-serif italic text-[var(--text)] leading-loose mb-6">{{ $invitation->closing_text }}</p>
                <p class="text-xs text-[var(--muted)] mb-2">Atas kehadiran dan doa restu, kami mengucapkan terima kasih.</p>
                <h4 class="text-2xl font-script text-[var(--primary)] mt-4">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</h4>
                <div class="section-ornament mt-6" style="transform: scaleY(-1)"></div>
            </div>
        </section>
        @endif

        <!-- ===== FOOTER ===== -->
        <footer class="py-8 px-6 bg-[var(--primary)] text-center">
            <p class="text-[10px] text-white/50 tracking-wider">Created with <a href="{{ url('/') }}" class="text-white/70 hover:text-white hover:underline">UndanganDigital</a></p>
        </footer>
    </div>

    <!-- ==================== MUSIC PLAYER ==================== -->
    @if($invitation->music_url)
    <div class="fixed bottom-5 right-5 z-40" x-show="opened" x-transition>
        <button @click="toggleMusic()" class="w-11 h-11 rounded-full shadow-lg flex items-center justify-center transition-all duration-300" :class="playing ? 'bg-[var(--primary)] text-white music-playing' : 'bg-white text-[var(--primary)] border border-[var(--primary)]/20'">
            <svg x-show="!playing" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>
            <svg x-show="playing" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5.75 3a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75A.75.75 0 007.25 3h-1.5zM12.75 3a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75a.75.75 0 00-.75-.75h-1.5z"/></svg>
        </button>
        <audio x-ref="audio" src="{{ asset('storage/' . $invitation->music_url) }}" loop preload="auto"></audio>
    </div>
    @endif

    <!-- ==================== SCRIPTS ==================== -->
    <script>
    function invitationApp() {
        return {
            opened: false,
            playing: false,
            openInvitation() {
                this.opened = true;
                document.body.style.overflow = 'auto';
                @if($invitation->music_autoplay && $invitation->music_url)
                this.$nextTick(() => {
                    this.$refs.audio?.play().then(() => this.playing = true).catch(() => {});
                });
                @endif
                // Initialize scroll animations
                this.$nextTick(() => setTimeout(() => this.initScrollObserver(), 100));
            },
            toggleMusic() {
                if (this.playing) { this.$refs.audio?.pause(); }
                else { this.$refs.audio?.play(); }
                this.playing = !this.playing;
            },
            initScrollObserver() {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('visible');
                        }
                    });
                }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

                document.querySelectorAll('.fade-up, .fade-in').forEach(el => observer.observe(el));
            }
        };
    }

    function countdown(targetDate) {
        return {
            days: 0, hours: 0, minutes: 0, seconds: 0,
            init() { this.update(); setInterval(() => this.update(), 1000); },
            update() {
                const diff = new Date(targetDate) - new Date();
                if (diff > 0) {
                    this.days = Math.floor(diff / (1000*60*60*24));
                    this.hours = Math.floor((diff % (1000*60*60*24)) / (1000*60*60));
                    this.minutes = Math.floor((diff % (1000*60*60)) / (1000*60));
                    this.seconds = Math.floor((diff % (1000*60)) / 1000);
                }
            }
        };
    }
    </script>
</body>
</html>
