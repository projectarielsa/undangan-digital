<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Nunito:wght@300;400;600;700&family=Josefin+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --coral: {{ $invitation->color_primary ?? '#E8756D' }};
            --coral-light: #F09A94;
            --teal: {{ $invitation->color_secondary ?? '#2BA5A5' }};
            --teal-light: #7DD3D3;
            --sand: #FFF8F0;
            --sunset: #FFB74D;
            --palm: #2D6B4F;
            --text: #2D3B36;
            --muted: #7A8B85;
            --border: rgba(232,117,109,0.15);
        }

        body {
            font-family: 'Nunito', sans-serif !important;
            line-height: 1.6 !important;
            color: var(--text);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            background: white;
        }
        .font-display { font-family: 'Pacifico', cursive !important; }
        .font-accent { font-family: 'Josefin Sans', sans-serif !important; }
        [x-cloak] { display: none !important; }

        /* Animations */
        .reveal { opacity: 0; transform: translateY(30px); transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
        .reveal.active { opacity: 1; transform: translateY(0); }
        .reveal-delay-1 { transition-delay: 0.15s; }
        .reveal-delay-2 { transition-delay: 0.3s; }
        .reveal-delay-3 { transition-delay: 0.45s; }
        .reveal-delay-4 { transition-delay: 0.6s; }

        /* Keyframes */
        @keyframes waveMotion {
            0%, 100% { transform: translateX(0) translateY(0); }
            25% { transform: translateX(-5px) translateY(3px); }
            50% { transform: translateX(0) translateY(5px); }
            75% { transform: translateX(5px) translateY(3px); }
        }
        @keyframes floatingLeaf {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            25% { transform: translateY(-8px) rotate(2deg); }
            50% { transform: translateY(-4px) rotate(-1deg); }
            75% { transform: translateY(-10px) rotate(3deg); }
        }
        @keyframes floatingLeafReverse {
            0%, 100% { transform: translateY(0) rotate(0deg) scaleX(-1); }
            25% { transform: translateY(-6px) rotate(-2deg) scaleX(-1); }
            50% { transform: translateY(-10px) rotate(1deg) scaleX(-1); }
            75% { transform: translateY(-4px) rotate(-3deg) scaleX(-1); }
        }
        @keyframes gentlePulse {
            0%, 100% { opacity: 0.6; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.05); }
        }
        @keyframes rotate { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }

        .wave-motion { animation: waveMotion 6s ease-in-out infinite; }
        .floating-leaf { animation: floatingLeaf 5s ease-in-out infinite; }
        .floating-leaf-reverse { animation: floatingLeafReverse 6s ease-in-out infinite; }
        .gentle-pulse { animation: gentlePulse 3s ease-in-out infinite; }
        .music-spin { animation: rotate 3s linear infinite; }

        /* Tropical Card */
        .tropical-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(232,117,109,0.08);
            position: relative;
            overflow: hidden;
        }
        .tropical-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--coral), var(--sunset), var(--teal));
        }

        /* Buttons */
        .btn-tropical {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 14px 32px;
            background: linear-gradient(135deg, var(--coral) 0%, var(--sunset) 100%);
            color: white; font-weight: 700; font-size: 14px;
            border-radius: 50px; border: none; cursor: pointer;
            box-shadow: 0 6px 20px rgba(232,117,109,0.35);
            transition: all 0.3s ease;
            text-decoration: none;
            font-family: 'Nunito', sans-serif;
        }
        .btn-tropical:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(232,117,109,0.45); }

        .btn-outline-tropical {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 12px 28px;
            border: 2px solid var(--teal);
            color: var(--teal); font-weight: 600; font-size: 13px;
            border-radius: 50px; cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none; background: transparent;
            font-family: 'Nunito', sans-serif;
        }
        .btn-outline-tropical:hover { background: var(--teal); color: white; }

        /* Input */
        .input-tropical {
            width: 100%; padding: 14px 18px;
            background: var(--sand); border: 1.5px solid var(--border);
            border-radius: 16px; font-size: 14px; color: var(--text);
            transition: border-color 0.3s, box-shadow 0.3s;
            font-family: 'Nunito', sans-serif;
        }
        .input-tropical:focus { outline: none; border-color: var(--teal); box-shadow: 0 0 0 3px rgba(43,165,165,0.1); }
        .input-tropical::placeholder { color: var(--muted); opacity: 0.6; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--coral); border-radius: 4px; }

        /* Photo shapes */
        .organic-shape {
            border-radius: 60% 40% 50% 50% / 50% 60% 40% 50%;
            overflow: hidden;
        }
        .organic-shape-alt {
            border-radius: 40% 60% 50% 50% / 50% 40% 60% 50%;
            overflow: hidden;
        }

        /* Mobile Responsive */
        @media (max-width: 640px) {
            .organic-shape, .organic-shape-alt { width: 180px !important; height: 180px !important; }
            .countdown-card { padding: 14px 8px; }
            .countdown-card .number { font-size: 1.5rem; }
            section { padding-left: 16px; padding-right: 16px; }
        }
        @media (max-width: 380px) {
            .organic-shape, .organic-shape-alt { width: 150px !important; height: 150px !important; }
        }
    </style>
</head>
<body class="bg-[var(--sand)]" x-data="invitationApp()" x-cloak>


    <!-- ===================== OPENING COVER ===================== -->
    <section x-show="!opened" class="fixed inset-0 z-50 flex items-center justify-center"
        x-transition:leave="transition ease-in duration-700"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-110"
        style="background: linear-gradient(135deg, #E8756D 0%, #FFB74D 40%, #2BA5A5 100%);">

        <!-- Tropical Leaf Frame SVG - Top Left -->
        <div class="absolute top-0 left-0 w-40 h-40 sm:w-56 sm:h-56 pointer-events-none floating-leaf" style="opacity:0.7">
            <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 10 C30 40, 50 80, 40 140 C35 160, 20 170, 10 180" stroke="rgba(255,255,255,0.4)" stroke-width="2" fill="none"/>
                <path d="M10 10 C50 20, 90 30, 120 60 C140 80, 130 100, 110 110 C90 115, 60 100, 40 80 C25 65, 15 40, 10 10Z" fill="rgba(45,107,79,0.5)"/>
                <path d="M10 10 C40 30, 70 60, 80 90" stroke="rgba(255,255,255,0.3)" stroke-width="1" fill="none"/>
                <path d="M10 10 C30 35, 50 55, 60 70" stroke="rgba(255,255,255,0.2)" stroke-width="0.8" fill="none"/>
                <path d="M5 50 C20 60, 40 65, 60 60 C75 55, 80 45, 70 35 C55 28, 30 35, 5 50Z" fill="rgba(45,107,79,0.35)"/>
            </svg>
        </div>

        <!-- Tropical Leaf Frame SVG - Top Right -->
        <div class="absolute top-0 right-0 w-40 h-40 sm:w-56 sm:h-56 pointer-events-none floating-leaf-reverse" style="opacity:0.7">
            <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" style="transform: scaleX(-1)">
                <path d="M10 10 C30 40, 50 80, 40 140 C35 160, 20 170, 10 180" stroke="rgba(255,255,255,0.4)" stroke-width="2" fill="none"/>
                <path d="M10 10 C50 20, 90 30, 120 60 C140 80, 130 100, 110 110 C90 115, 60 100, 40 80 C25 65, 15 40, 10 10Z" fill="rgba(45,107,79,0.5)"/>
                <path d="M10 10 C40 30, 70 60, 80 90" stroke="rgba(255,255,255,0.3)" stroke-width="1" fill="none"/>
                <path d="M5 50 C20 60, 40 65, 60 60 C75 55, 80 45, 70 35 C55 28, 30 35, 5 50Z" fill="rgba(45,107,79,0.35)"/>
            </svg>
        </div>

        <!-- Tropical Leaf Frame SVG - Bottom Left -->
        <div class="absolute bottom-0 left-0 w-36 h-36 sm:w-48 sm:h-48 pointer-events-none floating-leaf" style="opacity:0.6; animation-delay: 1s;">
            <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" style="transform: rotate(180deg)">
                <path d="M10 10 C50 20, 90 30, 120 60 C140 80, 130 100, 110 110 C90 115, 60 100, 40 80 C25 65, 15 40, 10 10Z" fill="rgba(45,107,79,0.45)"/>
                <path d="M30 30 C50 45, 70 70, 75 95" stroke="rgba(255,255,255,0.25)" stroke-width="1" fill="none"/>
            </svg>
        </div>

        <!-- Tropical Leaf Frame SVG - Bottom Right -->
        <div class="absolute bottom-0 right-0 w-36 h-36 sm:w-48 sm:h-48 pointer-events-none floating-leaf-reverse" style="opacity:0.6; animation-delay: 2s;">
            <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" style="transform: rotate(180deg) scaleX(-1)">
                <path d="M10 10 C50 20, 90 30, 120 60 C140 80, 130 100, 110 110 C90 115, 60 100, 40 80 C25 65, 15 40, 10 10Z" fill="rgba(45,107,79,0.45)"/>
                <path d="M30 30 C50 45, 70 70, 75 95" stroke="rgba(255,255,255,0.25)" stroke-width="1" fill="none"/>
            </svg>
        </div>

        <!-- Monstera Accent Center -->
        <div class="absolute inset-0 pointer-events-none flex items-center justify-center" style="opacity: 0.06;">
            <svg viewBox="0 0 400 400" class="w-96 h-96" fill="white">
                <path d="M200 50 C250 80, 300 130, 310 200 C315 240, 290 280, 250 300 C220 310, 180 310, 150 300 C110 280, 85 240, 90 200 C100 130, 150 80, 200 50Z"/>
                <ellipse cx="170" cy="180" rx="20" ry="30" fill="rgba(0,0,0,0.3)"/>
                <ellipse cx="230" cy="200" rx="18" ry="25" fill="rgba(0,0,0,0.3)"/>
                <ellipse cx="190" cy="250" rx="15" ry="22" fill="rgba(0,0,0,0.3)"/>
            </svg>
        </div>

        <div class="text-center px-8 relative z-10 max-w-sm">
            <p class="text-xs font-accent uppercase tracking-[0.4em] text-white/80 mb-6 font-light">The Wedding Of</p>

            <h1 class="text-5xl sm:text-6xl font-display text-white leading-tight mb-2" style="text-shadow: 0 3px 20px rgba(0,0,0,0.15)">{{ $invitation->groom_name }}</h1>

            <div class="flex items-center justify-center gap-4 my-4">
                <div class="w-10 h-px bg-white/50"></div>
                <span class="text-3xl font-display text-white/90">&</span>
                <div class="w-10 h-px bg-white/50"></div>
            </div>

            <h1 class="text-5xl sm:text-6xl font-display text-white leading-tight" style="text-shadow: 0 3px 20px rgba(0,0,0,0.15)">{{ $invitation->bride_name }}</h1>

            @if($guestName)
            <div class="mt-8 py-3 px-6 border border-white/30 rounded-2xl bg-white/10 backdrop-blur-sm inline-block">
                <p class="text-[10px] font-accent uppercase tracking-[0.3em] text-white/70 mb-1">Kepada Yth.</p>
                <p class="text-base text-white font-semibold">{{ urldecode($guestName) }}</p>
            </div>
            @endif

            <div class="mt-10">
                <button @click="openInvitation()" class="btn-tropical" style="background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(255,248,240,1)); color: var(--coral); box-shadow: 0 8px 30px rgba(0,0,0,0.15);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Buka Undangan
                </button>
            </div>

            <p class="text-xs text-white/60 mt-6 font-accent">{{ $invitation->event_date->translatedFormat('d F Y') }}</p>
        </div>
    </section>


    <!-- ===================== MAIN CONTENT ===================== -->
    <div x-show="opened" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

        <!-- ===================== HERO SECTION ===================== -->
        <section class="min-h-screen flex items-center justify-center py-20 px-6 relative overflow-hidden">
            <!-- Subtle background gradient -->
            <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse at 50% 20%, rgba(232,117,109,0.05) 0%, transparent 60%)"></div>

            <!-- Floating Palm Leaf Top Left -->
            <div class="absolute top-10 left-0 w-32 sm:w-44 pointer-events-none floating-leaf" style="opacity: 0.15;">
                <svg viewBox="0 0 150 200" fill="var(--palm)">
                    <path d="M10 180 C20 140, 30 100, 50 70 C65 50, 85 40, 110 35 C90 50, 75 70, 65 95 C55 120, 50 150, 50 180Z"/>
                    <path d="M10 180 C25 150, 45 125, 70 110 C55 130, 45 155, 40 180Z" opacity="0.6"/>
                </svg>
            </div>

            <!-- Floating Palm Leaf Top Right -->
            <div class="absolute top-10 right-0 w-32 sm:w-44 pointer-events-none floating-leaf-reverse" style="opacity: 0.15;">
                <svg viewBox="0 0 150 200" fill="var(--palm)" style="transform: scaleX(-1)">
                    <path d="M10 180 C20 140, 30 100, 50 70 C65 50, 85 40, 110 35 C90 50, 75 70, 65 95 C55 120, 50 150, 50 180Z"/>
                    <path d="M10 180 C25 150, 45 125, 70 110 C55 130, 45 155, 40 180Z" opacity="0.6"/>
                </svg>
            </div>

            <div class="text-center max-w-lg relative z-10 reveal">
                <!-- Plumeria flower accent -->
                <div class="flex justify-center mb-8 gentle-pulse">
                    <svg width="50" height="50" viewBox="0 0 50 50" fill="none">
                        <path d="M25 5 C27 15, 30 20, 25 25 C20 20, 23 15, 25 5Z" fill="var(--coral-light)" opacity="0.8"/>
                        <path d="M25 5 C27 15, 30 20, 25 25 C20 20, 23 15, 25 5Z" fill="var(--coral-light)" opacity="0.8" transform="rotate(72 25 25)"/>
                        <path d="M25 5 C27 15, 30 20, 25 25 C20 20, 23 15, 25 5Z" fill="var(--coral-light)" opacity="0.8" transform="rotate(144 25 25)"/>
                        <path d="M25 5 C27 15, 30 20, 25 25 C20 20, 23 15, 25 5Z" fill="var(--coral-light)" opacity="0.8" transform="rotate(216 25 25)"/>
                        <path d="M25 5 C27 15, 30 20, 25 25 C20 20, 23 15, 25 5Z" fill="var(--coral-light)" opacity="0.8" transform="rotate(288 25 25)"/>
                        <circle cx="25" cy="25" r="4" fill="var(--sunset)"/>
                    </svg>
                </div>

                <p class="text-xs font-accent uppercase tracking-[0.5em] text-[var(--muted)] mb-8">We Are Getting Married</p>

                <h2 class="text-5xl sm:text-7xl font-display text-[var(--coral)] leading-tight">{{ $invitation->groom_name }}</h2>

                <div class="flex items-center justify-center gap-5 my-5">
                    <div class="w-14 h-px bg-gradient-to-r from-transparent to-[var(--coral)]"></div>
                    <span class="text-3xl font-display text-[var(--teal)]">&</span>
                    <div class="w-14 h-px bg-gradient-to-l from-transparent to-[var(--coral)]"></div>
                </div>

                <h2 class="text-5xl sm:text-7xl font-display text-[var(--coral)] leading-tight">{{ $invitation->bride_name }}</h2>

                <div class="mt-10 inline-flex items-center gap-3 px-5 py-2.5 bg-white border border-[var(--border)] rounded-full shadow-sm">
                    <svg class="w-4 h-4 text-[var(--coral)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span class="text-sm text-[var(--text)] font-accent">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</span>
                </div>
            </div>

            <!-- Wave Divider Bottom -->
            <div class="absolute bottom-0 left-0 right-0 pointer-events-none">
                <svg viewBox="0 0 1440 100" preserveAspectRatio="none" class="w-full h-16 sm:h-24" fill="white">
                    <path d="M0,40 C360,80 720,0 1080,40 C1260,60 1380,80 1440,60 L1440,100 L0,100 Z"/>
                </svg>
            </div>
        </section>


        <!-- ===================== OPENING TEXT ===================== -->
        @if($invitation->opening_text)
        <section class="py-20 px-6 bg-white">
            <div class="max-w-lg mx-auto text-center reveal">
                <!-- Tropical leaf divider -->
                <div class="flex justify-center mb-8">
                    <svg width="120" height="30" viewBox="0 0 120 30" fill="none">
                        <path d="M0 15 C20 15, 30 5, 45 8 C55 10, 55 15, 60 15 C65 15, 65 10, 75 8 C90 5, 100 15, 120 15" stroke="var(--teal)" stroke-width="1" opacity="0.4"/>
                        <path d="M50 10 C55 5, 60 3, 65 5 C68 7, 70 10, 65 12 C60 14, 55 12, 50 10Z" fill="var(--palm)" opacity="0.3"/>
                        <path d="M55 10 C58 5, 62 3, 65 5 C67 7, 65 10, 62 12 C59 13, 56 12, 55 10Z" fill="var(--palm)" opacity="0.2"/>
                    </svg>
                </div>
                <p class="text-base sm:text-lg italic text-[var(--text)]/80 leading-loose font-light" style="font-family: 'Nunito', sans-serif;">"{{ $invitation->opening_text }}"</p>
                <div class="flex justify-center mt-8" style="transform: scaleY(-1);">
                    <svg width="120" height="30" viewBox="0 0 120 30" fill="none">
                        <path d="M0 15 C20 15, 30 5, 45 8 C55 10, 55 15, 60 15 C65 15, 65 10, 75 8 C90 5, 100 15, 120 15" stroke="var(--teal)" stroke-width="1" opacity="0.4"/>
                        <path d="M50 10 C55 5, 60 3, 65 5 C68 7, 70 10, 65 12 C60 14, 55 12, 50 10Z" fill="var(--palm)" opacity="0.3"/>
                    </svg>
                </div>
            </div>
        </section>
        @endif

        <!-- ===================== COUPLE SECTION ===================== -->
        <section class="py-20 px-6 bg-[var(--sand)] relative overflow-hidden">
            <!-- Background decorative monstera -->
            <div class="absolute top-0 right-0 w-48 h-48 pointer-events-none floating-leaf" style="opacity: 0.06;">
                <svg viewBox="0 0 200 200" fill="var(--palm)">
                    <path d="M100 20 C140 40, 170 80, 175 130 C178 160, 155 185, 120 190 C90 193, 60 180, 45 155 C30 130, 35 90, 55 60 C70 40, 85 25, 100 20Z"/>
                    <ellipse cx="90" cy="100" rx="15" ry="25" fill="var(--sand)"/>
                    <ellipse cx="130" cy="120" rx="12" ry="20" fill="var(--sand)"/>
                </svg>
            </div>

            <div class="max-w-lg mx-auto">
                <div class="text-center mb-14 reveal">
                    <p class="text-[10px] font-accent uppercase tracking-[0.5em] text-[var(--muted)] mb-3">The Happy Couple</p>
                    <h3 class="text-3xl font-display text-[var(--coral)]">Mempelai</h3>
                </div>

                <!-- Groom -->
                <div class="text-center mb-14 reveal reveal-delay-1">
                    @if($invitation->groom_photo)
                    <div class="w-52 h-52 mx-auto mb-6 organic-shape relative">
                        <div class="w-full h-full p-1.5" style="background: linear-gradient(135deg, var(--coral), var(--sunset));">
                            <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}" class="w-full h-full object-cover organic-shape">
                        </div>
                        <!-- Leaf accent on photo -->
                        <div class="absolute -top-3 -right-3 w-12 h-12 pointer-events-none floating-leaf" style="animation-delay: 0.5s;">
                            <svg viewBox="0 0 50 50" fill="var(--palm)" opacity="0.5">
                                <path d="M25 5 C35 10, 42 20, 44 32 C45 38, 40 44, 33 45 C26 46, 18 40, 14 32 C10 24, 12 14, 18 8 C21 6, 23 5, 25 5Z"/>
                            </svg>
                        </div>
                    </div>
                    @else
                    <div class="w-52 h-52 mx-auto mb-6 organic-shape flex items-center justify-center" style="background: linear-gradient(135deg, var(--coral-light), var(--sunset));">
                        <span class="text-6xl font-display text-white">{{ substr($invitation->groom_name, 0, 1) }}</span>
                    </div>
                    @endif
                    <h4 class="text-2xl font-display text-[var(--text)] mb-2">{{ $invitation->groom_name }}</h4>
                    @if($invitation->groom_father || $invitation->groom_mother)
                    <p class="text-sm text-[var(--muted)] leading-relaxed font-accent">Putra dari<br>
                        <span class="text-[var(--text)]">Bpk. {{ $invitation->groom_father }}</span> &
                        <span class="text-[var(--text)]">Ibu {{ $invitation->groom_mother }}</span>
                    </p>
                    @endif
                    @if($invitation->groom_instagram)
                    <a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" target="_blank" class="inline-flex items-center gap-1.5 mt-3 text-sm text-[var(--teal)] hover:underline font-accent">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        {{ $invitation->groom_instagram }}
                    </a>
                    @endif
                </div>

                <!-- Tropical & Symbol -->
                <div class="text-center mb-14 reveal reveal-delay-2">
                    <div class="flex items-center justify-center gap-4">
                        <div class="w-12 h-px bg-gradient-to-r from-transparent to-[var(--coral-light)]"></div>
                        <span class="text-4xl font-display text-[var(--teal)]">&</span>
                        <div class="w-12 h-px bg-gradient-to-l from-transparent to-[var(--coral-light)]"></div>
                    </div>
                </div>

                <!-- Bride -->
                <div class="text-center reveal reveal-delay-3">
                    @if($invitation->bride_photo)
                    <div class="w-52 h-52 mx-auto mb-6 organic-shape-alt relative">
                        <div class="w-full h-full p-1.5" style="background: linear-gradient(135deg, var(--teal), var(--teal-light));">
                            <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}" class="w-full h-full object-cover organic-shape-alt">
                        </div>
                        <!-- Leaf accent on photo -->
                        <div class="absolute -bottom-2 -left-3 w-12 h-12 pointer-events-none floating-leaf-reverse" style="animation-delay: 1s;">
                            <svg viewBox="0 0 50 50" fill="var(--palm)" opacity="0.5">
                                <path d="M25 5 C35 10, 42 20, 44 32 C45 38, 40 44, 33 45 C26 46, 18 40, 14 32 C10 24, 12 14, 18 8 C21 6, 23 5, 25 5Z"/>
                            </svg>
                        </div>
                    </div>
                    @else
                    <div class="w-52 h-52 mx-auto mb-6 organic-shape-alt flex items-center justify-center" style="background: linear-gradient(135deg, var(--teal), var(--teal-light));">
                        <span class="text-6xl font-display text-white">{{ substr($invitation->bride_name, 0, 1) }}</span>
                    </div>
                    @endif
                    <h4 class="text-2xl font-display text-[var(--text)] mb-2">{{ $invitation->bride_name }}</h4>
                    @if($invitation->bride_father || $invitation->bride_mother)
                    <p class="text-sm text-[var(--muted)] leading-relaxed font-accent">Putri dari<br>
                        <span class="text-[var(--text)]">Bpk. {{ $invitation->bride_father }}</span> &
                        <span class="text-[var(--text)]">Ibu {{ $invitation->bride_mother }}</span>
                    </p>
                    @endif
                    @if($invitation->bride_instagram)
                    <a href="https://instagram.com/{{ ltrim($invitation->bride_instagram, '@') }}" target="_blank" class="inline-flex items-center gap-1.5 mt-3 text-sm text-[var(--teal)] hover:underline font-accent">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        {{ $invitation->bride_instagram }}
                    </a>
                    @endif
                </div>
            </div>
        </section>


        <!-- ===================== COUNTDOWN ===================== -->
        <section class="py-20 px-6 relative overflow-hidden" style="background: linear-gradient(135deg, var(--coral) 0%, var(--sunset) 50%, var(--teal) 100%);">
            <!-- Wave top -->
            <div class="absolute top-0 left-0 right-0 pointer-events-none" style="transform: rotate(180deg);">
                <svg viewBox="0 0 1440 80" preserveAspectRatio="none" class="w-full h-12 sm:h-16" fill="var(--sand)">
                    <path d="M0,30 C480,70 960,0 1440,30 L1440,0 L0,0 Z"/>
                </svg>
            </div>

            <!-- Floating particles -->
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                <div class="absolute top-20 left-10 w-3 h-3 rounded-full bg-white/20 floating-leaf"></div>
                <div class="absolute top-32 right-20 w-2 h-2 rounded-full bg-white/15 floating-leaf-reverse"></div>
                <div class="absolute bottom-20 left-1/4 w-4 h-4 rounded-full bg-white/10 floating-leaf" style="animation-delay: 1s;"></div>
            </div>

            <div class="max-w-md mx-auto text-center relative z-10 reveal pt-8" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">
                <p class="text-xs font-accent uppercase tracking-[0.5em] text-white/80 mb-3">Save The Date</p>
                <h3 class="text-2xl font-display text-white mb-10">Menghitung Hari</h3>

                <div class="grid grid-cols-4 gap-3">
                    <div class="bg-white/15 backdrop-blur-md border border-white/20 rounded-2xl py-5 px-2">
                        <p class="text-3xl sm:text-4xl font-bold text-white" x-text="days">0</p>
                        <p class="text-[9px] font-accent uppercase tracking-[0.2em] text-white/70 mt-2">Hari</p>
                    </div>
                    <div class="bg-white/15 backdrop-blur-md border border-white/20 rounded-2xl py-5 px-2">
                        <p class="text-3xl sm:text-4xl font-bold text-white" x-text="hours">0</p>
                        <p class="text-[9px] font-accent uppercase tracking-[0.2em] text-white/70 mt-2">Jam</p>
                    </div>
                    <div class="bg-white/15 backdrop-blur-md border border-white/20 rounded-2xl py-5 px-2">
                        <p class="text-3xl sm:text-4xl font-bold text-white" x-text="minutes">0</p>
                        <p class="text-[9px] font-accent uppercase tracking-[0.2em] text-white/70 mt-2">Menit</p>
                    </div>
                    <div class="bg-white/15 backdrop-blur-md border border-white/20 rounded-2xl py-5 px-2">
                        <p class="text-3xl sm:text-4xl font-bold text-white" x-text="seconds">0</p>
                        <p class="text-[9px] font-accent uppercase tracking-[0.2em] text-white/70 mt-2">Detik</p>
                    </div>
                </div>
            </div>

            <!-- Wave bottom -->
            <div class="absolute bottom-0 left-0 right-0 pointer-events-none">
                <svg viewBox="0 0 1440 80" preserveAspectRatio="none" class="w-full h-12 sm:h-16" fill="white">
                    <path d="M0,50 C360,20 720,70 1080,40 C1260,28 1380,50 1440,40 L1440,80 L0,80 Z"/>
                </svg>
            </div>
        </section>

        <!-- ===================== EVENT DETAILS ===================== -->
        <section class="py-20 px-6 bg-white">
            <div class="max-w-lg mx-auto text-center">
                <div class="reveal">
                    <p class="text-[10px] font-accent uppercase tracking-[0.5em] text-[var(--muted)] mb-3">When & Where</p>
                    <h3 class="text-3xl font-display text-[var(--coral)] mb-12">Acara Pernikahan</h3>
                </div>

                <div class="tropical-card p-8 sm:p-10 reveal reveal-delay-1">
                    <!-- Wave top accent -->
                    <div class="absolute top-0 left-0 right-0 overflow-hidden rounded-t-3xl" style="height: 6px;">
                        <div class="w-full h-full" style="background: linear-gradient(90deg, var(--coral), var(--sunset), var(--teal));"></div>
                    </div>

                    <div class="w-16 h-16 mx-auto mb-6 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, var(--coral-light), var(--sunset)); opacity: 0.9;">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>

                    <h4 class="text-lg font-accent font-semibold text-[var(--text)] mb-2">Resepsi Pernikahan</h4>

                    <div class="space-y-4 mt-6 text-sm text-[var(--muted)]">
                        <div class="flex items-center justify-center gap-3">
                            <svg class="w-4 h-4 text-[var(--teal)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span class="font-accent">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</span>
                        </div>
                        <div class="flex items-center justify-center gap-3">
                            <svg class="w-4 h-4 text-[var(--teal)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="font-accent">{{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }} - {{ \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') }} WIB</span>
                        </div>
                        <div class="flex items-start justify-center gap-3">
                            <svg class="w-4 h-4 text-[var(--teal)] mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="font-accent text-left">{{ $invitation->event_venue }}<br>{{ $invitation->event_address }}</span>
                        </div>
                    </div>

                    @if($invitation->dress_code)
                    <div class="mt-6 pt-5 border-t border-[var(--border)]">
                        <p class="text-xs font-accent uppercase tracking-wider text-[var(--muted)] mb-1">Dress Code</p>
                        <p class="text-sm font-semibold text-[var(--text)] font-accent">{{ $invitation->dress_code }}</p>
                    </div>
                    @endif

                    @if($invitation->event_maps_url)
                    <div class="mt-8">
                        <a href="{{ $invitation->event_maps_url }}" target="_blank" class="btn-outline-tropical">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l5.447 2.724A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                            Buka Google Maps
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </section>


        <!-- ===================== GALLERY ===================== -->
        @if($invitation->galleries && ($invitation->galleries ? $invitation->galleries->count() : 0) > 0)
        <section class="py-20 px-6 bg-[var(--sand)] relative overflow-hidden">
            <!-- Decorative palm leaf -->
            <div class="absolute bottom-0 left-0 w-32 h-48 pointer-events-none floating-leaf" style="opacity: 0.08;">
                <svg viewBox="0 0 120 180" fill="var(--palm)">
                    <path d="M10 170 C15 130, 25 90, 45 60 C60 40, 80 30, 100 28 C80 45, 65 65, 55 90 C45 115, 40 145, 40 170Z"/>
                </svg>
            </div>

            <div class="max-w-lg mx-auto">
                <div class="text-center mb-12 reveal">
                    <p class="text-[10px] font-accent uppercase tracking-[0.5em] text-[var(--muted)] mb-3">Our Moments</p>
                    <h3 class="text-3xl font-display text-[var(--coral)]">Galeri</h3>
                </div>

                <div class="grid grid-cols-2 gap-3 reveal reveal-delay-1">
                    @foreach($invitation->galleries as $index => $photo)
                        @if($index === 0)
                        <div class="col-span-2 rounded-3xl overflow-hidden shadow-lg" style="box-shadow: 0 8px 30px rgba(232,117,109,0.12);">
                            <img src="{{ $photo->getImageUrl() }}" alt="Gallery {{ $index + 1 }}" class="w-full h-64 sm:h-80 object-cover hover:scale-105 transition-transform duration-700">
                        </div>
                        @else
                        <div class="rounded-2xl overflow-hidden shadow-md" style="box-shadow: 0 4px 16px rgba(43,165,165,0.08);">
                            <img src="{{ $photo->getImageUrl() }}" alt="Gallery {{ $index + 1 }}" class="w-full h-40 sm:h-48 object-cover hover:scale-105 transition-transform duration-700">
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- ===================== RSVP ===================== -->
        <section class="py-20 px-6 bg-white relative">
            <!-- Wave top -->
            <div class="absolute top-0 left-0 right-0 pointer-events-none" style="margin-top: -1px;">
                <svg viewBox="0 0 1440 60" preserveAspectRatio="none" class="w-full h-8 sm:h-12" fill="white">
                    <path d="M0,60 L0,30 C240,50 480,10 720,30 C960,50 1200,10 1440,30 L1440,60 Z"/>
                </svg>
            </div>

            <div class="max-w-lg mx-auto">
                <div class="text-center mb-12 reveal">
                    <p class="text-[10px] font-accent uppercase tracking-[0.5em] text-[var(--muted)] mb-3">Konfirmasi Kehadiran</p>
                    <h3 class="text-3xl font-display text-[var(--coral)]">RSVP</h3>
                </div>

                <div class="tropical-card p-8 reveal reveal-delay-1">
                    <form action="{{ route('invitation.rsvp', $invitation->slug) }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-sm font-accent font-semibold text-[var(--text)] mb-2">Nama</label>
                            <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Masukkan nama Anda" class="input-tropical" required>
                        </div>

                        <div>
                            <label class="block text-sm font-accent font-semibold text-[var(--text)] mb-2">Konfirmasi Kehadiran</label>
                            <select name="rsvp_status" class="input-tropical" required>
                                <option value="">-- Pilih --</option>
                                <option value="attending">Hadir</option>
                                <option value="not_attending">Tidak Hadir</option>
                                <option value="maybe">Mungkin Hadir</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-accent font-semibold text-[var(--text)] mb-2">Jumlah Tamu</label>
                            <input type="number" name="number_of_guests" min="1" max="10" value="1" class="input-tropical" required>
                        </div>

                        <button type="submit" class="btn-tropical w-full justify-center mt-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Kirim RSVP
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <!-- ===================== GUESTBOOK ===================== -->
        <section class="py-20 px-6 bg-[var(--sand)]">
            <div class="max-w-lg mx-auto">
                <div class="text-center mb-12 reveal">
                    <p class="text-[10px] font-accent uppercase tracking-[0.5em] text-[var(--muted)] mb-3">Wishes & Prayers</p>
                    <h3 class="text-3xl font-display text-[var(--coral)]">Ucapan</h3>
                </div>

                <!-- Form -->
                <div class="tropical-card p-8 mb-8 reveal reveal-delay-1">
                    <form action="{{ route('invitation.guestbook', $invitation->slug) }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-sm font-accent font-semibold text-[var(--text)] mb-2">Nama</label>
                            <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Masukkan nama Anda" class="input-tropical" required>
                        </div>
                        <div>
                            <label class="block text-sm font-accent font-semibold text-[var(--text)] mb-2">Ucapan & Doa</label>
                            <textarea name="message" rows="4" placeholder="Tulis ucapan dan doa terbaik Anda..." class="input-tropical" required></textarea>
                        </div>
                        <button type="submit" class="btn-tropical w-full justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            Kirim Ucapan
                        </button>
                    </form>
                </div>

                <!-- Messages -->
                @if($invitation->guestbooks && ($invitation->guestbooks ? $invitation->guestbooks->count() : 0) > 0)
                <div class="space-y-4 max-h-96 overflow-y-auto pr-2 reveal reveal-delay-2">
                    @foreach($invitation->guestbooks->sortByDesc('created_at') as $guestbook)
                    <div class="bg-white rounded-2xl p-5 border border-[var(--border)]" style="box-shadow: 0 2px 12px rgba(232,117,109,0.05);">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-sm font-bold" style="background: linear-gradient(135deg, var(--coral), var(--teal));">
                                {{ strtoupper(substr($guestbook->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-[var(--text)] font-accent">{{ $guestbook->name }}</p>
                                <p class="text-[10px] text-[var(--muted)]">{{ $guestbook->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <p class="text-sm text-[var(--text)]/80 leading-relaxed pl-12">{{ $guestbook->message }}</p>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </section>


        <!-- ===================== DIGITAL ENVELOPE ===================== -->
        @if(($invitation->bankAccounts ? $invitation->bankAccounts->count() : 0) > 0 || $invitation->bank_name || $invitation->qris_image)
        <section class="py-20 px-6 bg-white relative overflow-hidden">
            <!-- Decorative wave divider top -->
            <div class="absolute top-0 left-0 right-0 pointer-events-none wave-motion" style="opacity: 0.4;">
                <svg viewBox="0 0 1440 40" preserveAspectRatio="none" class="w-full h-6">
                    <path d="M0,20 C240,35 480,5 720,20 C960,35 1200,5 1440,20" fill="none" stroke="var(--teal-light)" stroke-width="1.5"/>
                </svg>
            </div>

            <div class="max-w-lg mx-auto">
                <div class="text-center mb-12 reveal">
                    <p class="text-[10px] font-accent uppercase tracking-[0.5em] text-[var(--muted)] mb-3">Wedding Gift</p>
                    <h3 class="text-3xl font-display text-[var(--coral)]">Amplop Digital</h3>
                    @if($invitation->gift_info)
                    <p class="text-sm text-[var(--muted)] mt-3 font-accent">{{ $invitation->gift_info }}</p>
                    @endif
                </div>

                <div class="space-y-5">
                    @if(($invitation->bankAccounts ? $invitation->bankAccounts->count() : 0) > 0)
                        @foreach($invitation->bankAccounts as $bank)
                        <div class="tropical-card p-6 sm:p-8 reveal reveal-delay-1">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-12 h-12 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, var(--coral-light), var(--sunset));">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-accent font-bold text-[var(--text)]">{{ $bank['bank_name'] }}</p>
                                    <p class="text-xs text-[var(--muted)]">Transfer Bank</p>
                                </div>
                            </div>
                            <div class="bg-[var(--sand)] rounded-xl p-4 flex items-center justify-between">
                                <div>
                                    <p class="text-lg font-bold text-[var(--text)] font-accent tracking-wider">{{ $bank['account_number'] }}</p>
                                    <p class="text-xs text-[var(--muted)] mt-1">a.n. {{ $bank['account_name'] }}</p>
                                </div>
                                <button onclick="navigator.clipboard.writeText('{{ $bank['account_number'] }}')" class="p-2 rounded-xl bg-white border border-[var(--border)] hover:border-[var(--teal)] transition-colors" title="Salin">
                                    <svg class="w-5 h-5 text-[var(--teal)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    @elseif($invitation->bank_name)
                        {{-- Fallback to old single bank field --}}
                        <div class="tropical-card p-6 sm:p-8 reveal reveal-delay-1">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-12 h-12 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, var(--coral-light), var(--sunset));">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-accent font-bold text-[var(--text)]">{{ $invitation->bank_name }}</p>
                                    <p class="text-xs text-[var(--muted)]">Transfer Bank</p>
                                </div>
                            </div>
                            <div class="bg-[var(--sand)] rounded-xl p-4 flex items-center justify-between">
                                <div>
                                    <p class="text-lg font-bold text-[var(--text)] font-accent tracking-wider">{{ $invitation->bank_account_number }}</p>
                                    <p class="text-xs text-[var(--muted)] mt-1">a.n. {{ $invitation->bank_account_name }}</p>
                                </div>
                                <button onclick="navigator.clipboard.writeText('{{ $invitation->bank_account_number }}')" class="p-2 rounded-xl bg-white border border-[var(--border)] hover:border-[var(--teal)] transition-colors" title="Salin">
                                    <svg class="w-5 h-5 text-[var(--teal)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                </button>
                            </div>
                        </div>
                    @endif

                    @if($invitation->qris_image)
                    <div class="tropical-card p-6 sm:p-8 text-center reveal reveal-delay-2">
                        <div class="flex items-center justify-center gap-3 mb-4">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, var(--teal), var(--teal-light));">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                            </div>
                            <div class="text-left">
                                <p class="text-sm font-accent font-bold text-[var(--text)]">QRIS</p>
                                <p class="text-xs text-[var(--muted)]">Scan untuk pembayaran</p>
                            </div>
                        </div>
                        <div class="bg-white rounded-2xl p-4 border border-[var(--border)] inline-block">
                            <img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS Code" class="w-48 h-48 object-contain mx-auto">
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </section>
        @endif

        <!-- ===================== CLOSING TEXT ===================== -->
        <section class="py-20 px-6 relative overflow-hidden" style="background: linear-gradient(180deg, var(--sand) 0%, rgba(232,117,109,0.05) 100%);">
            <!-- Tropical leaf frame for closing -->
            <div class="absolute top-8 left-4 w-24 h-24 pointer-events-none floating-leaf" style="opacity: 0.12;">
                <svg viewBox="0 0 100 100" fill="var(--palm)">
                    <path d="M10 90 C15 60, 25 40, 45 25 C60 15, 78 12, 90 15 C75 25, 60 40, 50 55 C40 70, 35 85, 35 95Z"/>
                </svg>
            </div>
            <div class="absolute top-8 right-4 w-24 h-24 pointer-events-none floating-leaf-reverse" style="opacity: 0.12;">
                <svg viewBox="0 0 100 100" fill="var(--palm)" style="transform: scaleX(-1)">
                    <path d="M10 90 C15 60, 25 40, 45 25 C60 15, 78 12, 90 15 C75 25, 60 40, 50 55 C40 70, 35 85, 35 95Z"/>
                </svg>
            </div>
            <div class="absolute bottom-8 left-8 w-20 h-20 pointer-events-none floating-leaf" style="opacity: 0.1; animation-delay: 1.5s;">
                <svg viewBox="0 0 80 80" fill="var(--palm)">
                    <path d="M10 70 C15 50, 25 30, 40 18 C52 10, 65 8, 72 12 C60 20, 48 35, 40 50 C33 62, 28 72, 28 78Z"/>
                </svg>
            </div>
            <div class="absolute bottom-8 right-8 w-20 h-20 pointer-events-none floating-leaf-reverse" style="opacity: 0.1; animation-delay: 2s;">
                <svg viewBox="0 0 80 80" fill="var(--palm)" style="transform: scaleX(-1)">
                    <path d="M10 70 C15 50, 25 30, 40 18 C52 10, 65 8, 72 12 C60 20, 48 35, 40 50 C33 62, 28 72, 28 78Z"/>
                </svg>
            </div>

            <div class="max-w-lg mx-auto text-center relative z-10 reveal">
                <!-- Plumeria decoration -->
                <div class="flex justify-center mb-8">
                    <svg width="60" height="60" viewBox="0 0 60 60" fill="none" class="gentle-pulse">
                        <path d="M30 8 C33 18, 36 23, 30 30 C24 23, 27 18, 30 8Z" fill="var(--coral-light)" opacity="0.7"/>
                        <path d="M30 8 C33 18, 36 23, 30 30 C24 23, 27 18, 30 8Z" fill="var(--coral-light)" opacity="0.7" transform="rotate(72 30 30)"/>
                        <path d="M30 8 C33 18, 36 23, 30 30 C24 23, 27 18, 30 8Z" fill="var(--coral-light)" opacity="0.7" transform="rotate(144 30 30)"/>
                        <path d="M30 8 C33 18, 36 23, 30 30 C24 23, 27 18, 30 8Z" fill="var(--coral-light)" opacity="0.7" transform="rotate(216 30 30)"/>
                        <path d="M30 8 C33 18, 36 23, 30 30 C24 23, 27 18, 30 8Z" fill="var(--coral-light)" opacity="0.7" transform="rotate(288 30 30)"/>
                        <circle cx="30" cy="30" r="5" fill="var(--sunset)"/>
                    </svg>
                </div>

                @if($invitation->closing_text)
                <p class="text-base sm:text-lg italic text-[var(--text)]/80 leading-loose mb-8">"{{ $invitation->closing_text }}"</p>
                @endif

                <h4 class="text-3xl font-display text-[var(--coral)] mb-2">Terima Kasih</h4>
                <p class="text-sm text-[var(--muted)] font-accent">Atas kehadiran dan doa restu Anda</p>

                <div class="mt-8 flex items-center justify-center gap-3">
                    <div class="w-12 h-px bg-gradient-to-r from-transparent to-[var(--teal-light)]"></div>
                    <span class="text-xl font-display text-[var(--teal)]">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</span>
                    <div class="w-12 h-px bg-gradient-to-l from-transparent to-[var(--teal-light)]"></div>
                </div>
            </div>
        </section>

        <!-- ===================== FOOTER ===================== -->
        <footer class="py-10 px-6 text-center" style="background: linear-gradient(135deg, var(--coral) 0%, var(--sunset) 50%, var(--teal) 100%);">
            <div class="max-w-lg mx-auto">
                <p class="text-white/80 text-xs font-accent tracking-wider">Made with
                    <svg class="w-3 h-3 inline text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    by Tropical Paradise</p>
                <p class="text-white/50 text-[10px] mt-2 font-accent">&copy; {{ date('Y') }} - Digital Wedding Invitation</p>
            </div>
        </footer>
    </div>


    <!-- ===================== MUSIC PLAYER (Floating) ===================== -->
    @if($invitation->music_url)
    <div class="fixed bottom-6 right-6 z-40" x-show="opened" x-transition>
        <button @click="toggleMusic()" class="w-12 h-12 rounded-full flex items-center justify-center shadow-xl transition-all duration-300 hover:scale-110" style="background: linear-gradient(135deg, var(--coral), var(--sunset));">
            <svg x-show="!playing" class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
            <svg x-show="playing" class="w-5 h-5 text-white music-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
        </button>
    </div>
    <audio x-ref="audio" loop>
        <source src="{{ asset('storage/' . $invitation->music_url) }}" type="audio/mpeg">
    </audio>
    @endif

    <!-- ===================== SCRIPTS ===================== -->
    <script>
        function invitationApp() {
            return {
                opened: false,
                playing: false,

                openInvitation() {
                    this.opened = true;
                    this.$nextTick(() => {
                        this.initReveal();
                        @if($invitation->music_url && $invitation->music_autoplay)
                        this.playMusic();
                        @endif
                    });
                },

                toggleMusic() {
                    if (this.playing) {
                        this.$refs.audio.pause();
                        this.playing = false;
                    } else {
                        this.playMusic();
                    }
                },

                playMusic() {
                    if (this.$refs.audio) {
                        this.$refs.audio.play().then(() => {
                            this.playing = true;
                        }).catch(() => {
                            this.playing = false;
                        });
                    }
                },

                initReveal() {
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.classList.add('active');
                            }
                        });
                    }, {
                        threshold: 0.1,
                        rootMargin: '0px 0px -50px 0px'
                    });

                    document.querySelectorAll('.reveal').forEach(el => {
                        observer.observe(el);
                    });
                }
            }
        }

        function countdown(targetDate) {
            return {
                days: '0',
                hours: '0',
                minutes: '0',
                seconds: '0',
                interval: null,

                init() {
                    this.updateCountdown(targetDate);
                    this.interval = setInterval(() => {
                        this.updateCountdown(targetDate);
                    }, 1000);
                },

                updateCountdown(target) {
                    const now = new Date().getTime();
                    const eventTime = new Date(target).getTime();
                    const distance = eventTime - now;

                    if (distance > 0) {
                        this.days = Math.floor(distance / (1000 * 60 * 60 * 24)).toString();
                        this.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString();
                        this.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).toString();
                        this.seconds = Math.floor((distance % (1000 * 60)) / 1000).toString();
                    } else {
                        this.days = '0';
                        this.hours = '0';
                        this.minutes = '0';
                        this.seconds = '0';
                        if (this.interval) clearInterval(this.interval);
                    }
                },

                destroy() {
                    if (this.interval) clearInterval(this.interval);
                }
            }
        }
    </script>
</body>
</html>
