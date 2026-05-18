<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $invitation->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Marcellus&family=Jost:wght@200;300;400;500;600&family=Pinyon+Script&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: {{ $invitation->color_primary ?? '#6B5B4B' }};
            --primary-dark: #4A3D32;
            --cream: #FAF7F2;
            --warm: #F3EDE4;
            --card: #FFFFFF;
            --text: #3B3025;
            --muted: #9A8B7A;
            --accent: #C4A97D;
            --border: rgba(107,91,75,0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Jost', sans-serif;
            font-weight: 300;
            color: var(--text);
            background: var(--cream);
            overflow: hidden;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .font-display { font-family: 'Marcellus', serif; }
        .font-script { font-family: 'Pinyon Script', cursive; }
        [x-cloak] { display: none !important; }

        /* ============ SCROLL REVEAL ANIMATIONS ============ */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.8s cubic-bezier(0.22, 0.61, 0.36, 1),
                        transform 0.8s cubic-bezier(0.22, 0.61, 0.36, 1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-d1 { transition-delay: 0.15s; }
        .reveal-d2 { transition-delay: 0.3s; }
        .reveal-d3 { transition-delay: 0.45s; }
        .reveal-d4 { transition-delay: 0.6s; }

        /* ============ BATIK LUNG-LUNGAN CORNER ORNAMENTS ============ */
        .batik-corner {
            position: absolute;
            width: 160px;
            height: 160px;
            pointer-events: none;
            opacity: 0.7;
        }
        .batik-corner svg { width: 100%; height: 100%; }
        .batik-tl { top: 0; left: 0; }
        .batik-tr { top: 0; right: 0; transform: scaleX(-1); }
        .batik-bl { bottom: 0; left: 0; transform: scaleY(-1); }
        .batik-br { bottom: 0; right: 0; transform: scale(-1, -1); }

        /* ============ COVER LARGE ORNAMENTS ============ */
        .batik-cover-corner {
            position: absolute;
            width: 220px;
            height: 220px;
            pointer-events: none;
        }
        .batik-cover-corner svg { width: 100%; height: 100%; }

        /* ============ TRADITIONAL DIVIDER ============ */
        .ornament-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin: 0 auto;
            width: fit-content;
        }
        .ornament-divider::before,
        .ornament-divider::after {
            content: '';
            width: 50px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--accent), transparent);
        }

        /* ============ EVENT CARDS ============ */
        .event-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-top: 3px solid var(--accent);
            border-radius: 20px;
            padding: 32px 24px;
            text-align: center;
            box-shadow: 0 4px 24px rgba(107,91,75,0.06);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .event-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(107,91,75,0.1);
        }

        /* ============ BUTTONS ============ */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px 32px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #FFFFFF;
            font-size: 13px;
            font-weight: 500;
            font-family: 'Jost', sans-serif;
            letter-spacing: 0.5px;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            box-shadow: 0 4px 16px rgba(107,91,75,0.3);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(107,91,75,0.4);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 28px;
            border: 1.5px solid var(--primary);
            color: var(--primary);
            font-size: 13px;
            font-weight: 500;
            font-family: 'Jost', sans-serif;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            background: transparent;
        }
        .btn-secondary:hover {
            background: var(--primary);
            color: #FFFFFF;
        }

        /* ============ FORM INPUTS ============ */
        .form-input {
            width: 100%;
            padding: 14px 18px;
            background: var(--warm);
            border: 1.5px solid var(--border);
            border-radius: 14px;
            font-size: 14px;
            color: var(--text);
            font-family: 'Jost', sans-serif;
            font-weight: 300;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(107,91,75,0.08);
        }
        .form-input::placeholder { color: var(--muted); }

        /* ============ PHOTO FRAMES ============ */
        .couple-photo {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid var(--accent);
            box-shadow: 0 8px 32px rgba(107,91,75,0.15), 0 0 0 8px rgba(196,169,125,0.08);
            margin: 0 auto;
        }
        .couple-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* ============ GALLERY ============ */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }
        .gallery-item {
            border-radius: 16px;
            overflow: hidden;
            aspect-ratio: 1;
            position: relative;
        }
        .gallery-item:first-child {
            grid-column: span 2;
            aspect-ratio: 16/9;
        }
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }
        .gallery-item:hover img {
            transform: scale(1.05);
        }

        /* ============ COUNTDOWN ============ */
        .countdown-box {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 16px;
            padding: 20px 8px;
            text-align: center;
        }

        /* ============ GUESTBOOK MESSAGES ============ */
        .message-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 16px;
            transition: box-shadow 0.3s;
        }
        .message-card:hover {
            box-shadow: 0 4px 16px rgba(107,91,75,0.06);
        }

        /* ============ MUSIC PLAYER ============ */
        @keyframes music-pulse {
            0% { box-shadow: 0 0 0 0 rgba(107,91,75,0.4); }
            70% { box-shadow: 0 0 0 10px rgba(107,91,75,0); }
            100% { box-shadow: 0 0 0 0 rgba(107,91,75,0); }
        }
        .music-playing { animation: music-pulse 2s infinite; }

        @keyframes float-gentle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }
        .float-anim { animation: float-gentle 4s ease-in-out infinite; }

        /* ============ COVER ANIMATION ============ */
        @keyframes fade-up-in {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .cover-anim { animation: fade-up-in 1s ease forwards; }
        .cover-anim-d1 { animation-delay: 0.2s; opacity: 0; }
        .cover-anim-d2 { animation-delay: 0.4s; opacity: 0; }
        .cover-anim-d3 { animation-delay: 0.6s; opacity: 0; }
        .cover-anim-d4 { animation-delay: 0.8s; opacity: 0; }
        .cover-anim-d5 { animation-delay: 1s; opacity: 0; }
    </style>
</head>
<body x-data="invitationApp()" x-cloak>


    {{-- ========== SVG ORNAMENT DEFINITIONS ========== --}}
    {{-- Lung-lungan (Javanese floral scroll) pattern used in corners --}}

    {{-- ========== SECTION 1: OPENING COVER ========== --}}
    <section x-show="!opened"
        class="fixed inset-0 z-50 flex items-center justify-center overflow-hidden"
        style="background: linear-gradient(160deg, var(--cream) 0%, var(--warm) 50%, #EDE5D8 100%);"
        x-transition:leave="transition ease-in duration-700"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95">

        {{-- Batik Corner Ornaments - Top Left --}}
        <div class="batik-cover-corner" style="top: 0; left: 0;">
            <svg viewBox="0 0 220 220" xmlns="http://www.w3.org/2000/svg">
                <g fill="none" stroke="var(--primary)" opacity="0.2">
                    {{-- Main lung-lungan spiral --}}
                    <path d="M10 10 C30 10 50 20 60 40 C70 60 55 80 40 85 C25 90 15 80 15 65 C15 50 30 45 40 50" stroke-width="1.5"/>
                    <path d="M40 50 C50 55 55 70 45 80 C35 90 20 85 25 70" stroke-width="1"/>
                    {{-- Floral elements --}}
                    <path d="M60 40 C80 35 95 50 90 70 C85 90 65 95 50 85" stroke-width="1.2"/>
                    <path d="M90 70 C105 65 115 80 110 95 C105 110 90 115 80 105" stroke-width="1"/>
                    {{-- Leaf curls --}}
                    <path d="M10 60 C20 55 30 60 25 75 C20 90 10 85 10 75" stroke-width="0.8"/>
                    <path d="M55 10 C60 20 55 35 45 30 C35 25 40 15 50 12" stroke-width="0.8"/>
                    {{-- Dots and small circles --}}
                    <circle cx="30" cy="30" r="2.5" fill="var(--primary)" opacity="0.15"/>
                    <circle cx="70" cy="55" r="2" fill="var(--primary)" opacity="0.12"/>
                    <circle cx="50" cy="75" r="1.5" fill="var(--primary)" opacity="0.1"/>
                    <circle cx="95" cy="85" r="1.5" fill="var(--primary)" opacity="0.08"/>
                    <circle cx="20" cy="45" r="1" fill="var(--accent)" opacity="0.2"/>
                    {{-- Extended tendrils --}}
                    <path d="M110 95 C125 90 140 100 135 115 C130 130 115 130 110 120" stroke-width="0.8" opacity="0.15"/>
                    <path d="M80 105 C90 115 85 130 70 130 C55 130 55 115 65 110" stroke-width="0.7" opacity="0.12"/>
                </g>
                {{-- Gold accent touches --}}
                <g fill="none" stroke="var(--accent)" opacity="0.15">
                    <ellipse cx="45" cy="45" rx="6" ry="4" stroke-width="0.8" transform="rotate(-35 45 45)"/>
                    <ellipse cx="75" cy="70" rx="5" ry="3" stroke-width="0.6" transform="rotate(20 75 70)"/>
                </g>
            </svg>
        </div>

        {{-- Top Right --}}
        <div class="batik-cover-corner" style="top: 0; right: 0; transform: scaleX(-1);">
            <svg viewBox="0 0 220 220" xmlns="http://www.w3.org/2000/svg">
                <g fill="none" stroke="var(--primary)" opacity="0.2">
                    <path d="M10 10 C30 10 50 20 60 40 C70 60 55 80 40 85 C25 90 15 80 15 65 C15 50 30 45 40 50" stroke-width="1.5"/>
                    <path d="M40 50 C50 55 55 70 45 80 C35 90 20 85 25 70" stroke-width="1"/>
                    <path d="M60 40 C80 35 95 50 90 70 C85 90 65 95 50 85" stroke-width="1.2"/>
                    <path d="M90 70 C105 65 115 80 110 95 C105 110 90 115 80 105" stroke-width="1"/>
                    <path d="M10 60 C20 55 30 60 25 75 C20 90 10 85 10 75" stroke-width="0.8"/>
                    <path d="M55 10 C60 20 55 35 45 30 C35 25 40 15 50 12" stroke-width="0.8"/>
                    <circle cx="30" cy="30" r="2.5" fill="var(--primary)" opacity="0.15"/>
                    <circle cx="70" cy="55" r="2" fill="var(--primary)" opacity="0.12"/>
                    <circle cx="50" cy="75" r="1.5" fill="var(--primary)" opacity="0.1"/>
                    <path d="M110 95 C125 90 140 100 135 115 C130 130 115 130 110 120" stroke-width="0.8" opacity="0.15"/>
                </g>
                <g fill="none" stroke="var(--accent)" opacity="0.15">
                    <ellipse cx="45" cy="45" rx="6" ry="4" stroke-width="0.8" transform="rotate(-35 45 45)"/>
                </g>
            </svg>
        </div>

        {{-- Bottom Left --}}
        <div class="batik-cover-corner" style="bottom: 0; left: 0; transform: scaleY(-1);">
            <svg viewBox="0 0 220 220" xmlns="http://www.w3.org/2000/svg">
                <g fill="none" stroke="var(--primary)" opacity="0.2">
                    <path d="M10 10 C30 10 50 20 60 40 C70 60 55 80 40 85 C25 90 15 80 15 65 C15 50 30 45 40 50" stroke-width="1.5"/>
                    <path d="M40 50 C50 55 55 70 45 80 C35 90 20 85 25 70" stroke-width="1"/>
                    <path d="M60 40 C80 35 95 50 90 70 C85 90 65 95 50 85" stroke-width="1.2"/>
                    <circle cx="30" cy="30" r="2.5" fill="var(--primary)" opacity="0.15"/>
                    <circle cx="70" cy="55" r="2" fill="var(--primary)" opacity="0.12"/>
                </g>
            </svg>
        </div>

        {{-- Bottom Right --}}
        <div class="batik-cover-corner" style="bottom: 0; right: 0; transform: scale(-1, -1);">
            <svg viewBox="0 0 220 220" xmlns="http://www.w3.org/2000/svg">
                <g fill="none" stroke="var(--primary)" opacity="0.2">
                    <path d="M10 10 C30 10 50 20 60 40 C70 60 55 80 40 85 C25 90 15 80 15 65 C15 50 30 45 40 50" stroke-width="1.5"/>
                    <path d="M40 50 C50 55 55 70 45 80 C35 90 20 85 25 70" stroke-width="1"/>
                    <path d="M60 40 C80 35 95 50 90 70 C85 90 65 95 50 85" stroke-width="1.2"/>
                    <circle cx="30" cy="30" r="2.5" fill="var(--primary)" opacity="0.15"/>
                    <circle cx="70" cy="55" r="2" fill="var(--primary)" opacity="0.12"/>
                </g>
            </svg>
        </div>

        {{-- Cover Content --}}
        <div class="text-center px-8 max-w-sm relative z-10">
            {{-- Traditional top ornament --}}
            <div class="cover-anim cover-anim-d1 mb-6">
                <svg width="120" height="30" viewBox="0 0 120 30" class="mx-auto" xmlns="http://www.w3.org/2000/svg">
                    <g fill="none" stroke="var(--accent)" stroke-width="0.8" opacity="0.6">
                        <path d="M10 15 C25 5 35 10 45 15 C55 20 65 20 75 15 C85 10 95 5 110 15"/>
                        <path d="M30 15 C40 10 50 12 60 15 C70 18 80 20 90 15"/>
                        <circle cx="60" cy="15" r="3" fill="var(--accent)" opacity="0.4"/>
                        <circle cx="45" cy="13" r="1.5" fill="var(--accent)" opacity="0.3"/>
                        <circle cx="75" cy="13" r="1.5" fill="var(--accent)" opacity="0.3"/>
                    </g>
                </svg>
            </div>

            <p class="cover-anim cover-anim-d1 text-[11px] uppercase tracking-[0.5em] text-[var(--muted)] mb-4 font-display">Mengundang Dengan Hormat</p>
            <p class="cover-anim cover-anim-d2 text-[10px] uppercase tracking-[0.3em] text-[var(--muted)] mb-8">The Wedding Of</p>

            <h1 class="cover-anim cover-anim-d2 text-6xl sm:text-7xl font-script text-[var(--primary)] leading-tight mb-2">{{ $invitation->groom_name }}</h1>
            <div class="cover-anim cover-anim-d3 my-3">
                <svg width="60" height="24" viewBox="0 0 60 24" class="mx-auto" xmlns="http://www.w3.org/2000/svg">
                    <text x="30" y="20" text-anchor="middle" font-family="'Pinyon Script', cursive" font-size="22" fill="var(--accent)">&</text>
                </svg>
            </div>
            <h1 class="cover-anim cover-anim-d3 text-6xl sm:text-7xl font-script text-[var(--primary)] leading-tight">{{ $invitation->bride_name }}</h1>

            {{-- Guest Name --}}
            @if($guestName)
            <div class="cover-anim cover-anim-d4 mt-10 mb-6">
                <p class="text-[10px] uppercase tracking-[0.3em] text-[var(--muted)] mb-3">Kepada Yth. Bapak/Ibu/Saudara/i</p>
                <div class="inline-block px-8 py-3 bg-white/60 backdrop-blur rounded-2xl border border-[var(--border)]" style="box-shadow: 0 2px 12px rgba(107,91,75,0.06);">
                    <p class="text-base font-display font-medium text-[var(--text)]">{{ urldecode($guestName) }}</p>
                </div>
            </div>
            @endif

            <p class="cover-anim cover-anim-d4 text-xs text-[var(--muted)] mb-8 leading-relaxed max-w-[280px] mx-auto">Tanpa mengurangi rasa hormat, kami mengundang Anda untuk hadir di hari bahagia kami</p>

            {{-- Open Button --}}
            <div class="cover-anim cover-anim-d5">
                <button @click="openInvitation()" class="btn-primary group">
                    <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Buka Undangan
                </button>
            </div>

            <p class="cover-anim cover-anim-d5 text-[10px] text-[var(--muted)] mt-8 opacity-60 font-display">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>

            {{-- Bottom ornament --}}
            <div class="cover-anim cover-anim-d5 mt-6">
                <svg width="120" height="30" viewBox="0 0 120 30" class="mx-auto" xmlns="http://www.w3.org/2000/svg" style="transform: scaleY(-1);">
                    <g fill="none" stroke="var(--accent)" stroke-width="0.8" opacity="0.6">
                        <path d="M10 15 C25 5 35 10 45 15 C55 20 65 20 75 15 C85 10 95 5 110 15"/>
                        <path d="M30 15 C40 10 50 12 60 15 C70 18 80 20 90 15"/>
                        <circle cx="60" cy="15" r="3" fill="var(--accent)" opacity="0.4"/>
                        <circle cx="45" cy="13" r="1.5" fill="var(--accent)" opacity="0.3"/>
                        <circle cx="75" cy="13" r="1.5" fill="var(--accent)" opacity="0.3"/>
                    </g>
                </svg>
            </div>
        </div>
    </section>



    {{-- ========== MAIN CONTENT (after cover opens) ========== --}}
    <div x-show="opened"
        x-transition:enter="transition ease-out duration-800"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100">

        {{-- ========== SECTION 2: HERO ========== --}}
        <section class="min-h-screen flex items-center justify-center py-28 px-6 relative overflow-hidden"
            style="background: linear-gradient(180deg, var(--cream) 0%, var(--warm) 100%);">

            {{-- Batik corners --}}
            <div class="batik-corner batik-tl">
                <svg viewBox="0 0 160 160" xmlns="http://www.w3.org/2000/svg">
                    <g fill="none" stroke="var(--primary)" opacity="0.12">
                        <path d="M8 8 C25 8 45 18 55 35 C65 52 50 72 38 76 C26 80 18 72 18 60 C18 48 30 44 38 48" stroke-width="1.2"/>
                        <path d="M55 35 C72 30 85 42 82 58 C79 74 62 78 50 70" stroke-width="1"/>
                        <path d="M8 50 C16 46 25 50 22 62" stroke-width="0.8"/>
                        <circle cx="28" cy="28" r="2" fill="var(--primary)" opacity="0.1"/>
                        <circle cx="60" cy="50" r="1.5" fill="var(--accent)" opacity="0.15"/>
                    </g>
                </svg>
            </div>
            <div class="batik-corner batik-tr">
                <svg viewBox="0 0 160 160" xmlns="http://www.w3.org/2000/svg">
                    <g fill="none" stroke="var(--primary)" opacity="0.12">
                        <path d="M8 8 C25 8 45 18 55 35 C65 52 50 72 38 76 C26 80 18 72 18 60 C18 48 30 44 38 48" stroke-width="1.2"/>
                        <path d="M55 35 C72 30 85 42 82 58 C79 74 62 78 50 70" stroke-width="1"/>
                        <circle cx="28" cy="28" r="2" fill="var(--primary)" opacity="0.1"/>
                    </g>
                </svg>
            </div>

            <div class="text-center max-w-md relative z-10">
                <div class="reveal mb-10">
                    <div class="ornament-divider">
                        <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 2 C14 5 14 9 10 10 C6 9 6 5 10 2Z" fill="var(--accent)" opacity="0.4"/>
                            <path d="M10 18 C14 15 14 11 10 10 C6 11 6 15 10 18Z" fill="var(--accent)" opacity="0.4"/>
                        </svg>
                    </div>
                </div>

                <p class="reveal reveal-d1 text-[10px] uppercase tracking-[0.5em] text-[var(--muted)] mb-8 font-display">The Wedding Of</p>

                <h2 class="reveal reveal-d1 text-7xl sm:text-8xl font-script text-[var(--primary)] leading-none">{{ $invitation->groom_name }}</h2>

                <div class="reveal reveal-d2 my-5">
                    <span class="text-4xl font-script text-[var(--accent)]">&</span>
                </div>

                <h2 class="reveal reveal-d2 text-7xl sm:text-8xl font-script text-[var(--primary)] leading-none">{{ $invitation->bride_name }}</h2>

                <p class="reveal reveal-d3 mt-12 text-sm text-[var(--muted)] font-display tracking-wide">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>

                <div class="reveal reveal-d3 mt-10">
                    <div class="ornament-divider">
                        <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="transform: rotate(180deg);">
                            <path d="M10 2 C14 5 14 9 10 10 C6 9 6 5 10 2Z" fill="var(--accent)" opacity="0.4"/>
                            <path d="M10 18 C14 15 14 11 10 10 C6 11 6 15 10 18Z" fill="var(--accent)" opacity="0.4"/>
                        </svg>
                    </div>
                </div>
            </div>
        </section>

        {{-- ========== SECTION 3: OPENING TEXT ========== --}}
        @if($invitation->opening_text)
        <section class="py-24 px-6 bg-[var(--card)] relative overflow-hidden">
            <div class="batik-corner batik-br" style="opacity: 0.4; width: 120px; height: 120px;">
                <svg viewBox="0 0 160 160" xmlns="http://www.w3.org/2000/svg">
                    <g fill="none" stroke="var(--accent)" opacity="0.2">
                        <path d="M8 8 C25 8 45 18 55 35 C65 52 50 72 38 76" stroke-width="1"/>
                        <circle cx="28" cy="28" r="2" fill="var(--accent)" opacity="0.15"/>
                    </g>
                </svg>
            </div>

            <div class="max-w-md mx-auto text-center">
                <div class="reveal">
                    <svg width="40" height="40" viewBox="0 0 40 40" class="mx-auto mb-8" xmlns="http://www.w3.org/2000/svg">
                        <g fill="none" stroke="var(--accent)" stroke-width="0.8" opacity="0.5">
                            <path d="M20 5 C25 10 30 15 30 20 C30 25 25 30 20 35 C15 30 10 25 10 20 C10 15 15 10 20 5Z"/>
                            <path d="M20 10 C23 14 26 17 26 20 C26 23 23 26 20 30 C17 26 14 23 14 20 C14 17 17 14 20 10Z"/>
                            <circle cx="20" cy="20" r="2" fill="var(--accent)" opacity="0.4"/>
                        </g>
                    </svg>
                </div>

                <div class="reveal reveal-d1">
                    <p class="text-[10px] uppercase tracking-[0.4em] text-[var(--muted)] mb-6 font-display">Bismillahirrahmanirrahim</p>
                    <p class="text-sm sm:text-base font-display italic text-[var(--text)] leading-[2] px-4">"{{ $invitation->opening_text }}"</p>
                </div>

                <div class="reveal reveal-d2 mt-8">
                    <svg width="80" height="16" viewBox="0 0 80 16" class="mx-auto" xmlns="http://www.w3.org/2000/svg">
                        <g fill="none" stroke="var(--accent)" stroke-width="0.6" opacity="0.4">
                            <path d="M5 8 C15 4 25 6 40 8 C55 10 65 12 75 8"/>
                            <circle cx="40" cy="8" r="2" fill="var(--accent)" opacity="0.3"/>
                        </g>
                    </svg>
                </div>
            </div>
        </section>
        @endif



        {{-- ========== SECTION 4: COUPLE PROFILES ========== --}}
        <section class="py-24 px-6 relative overflow-hidden" style="background: linear-gradient(180deg, var(--cream) 0%, var(--warm) 50%, var(--cream) 100%);">
            {{-- Decorative corners --}}
            <div class="batik-corner batik-tl" style="opacity: 0.5;">
                <svg viewBox="0 0 160 160" xmlns="http://www.w3.org/2000/svg">
                    <g fill="none" stroke="var(--primary)" opacity="0.15">
                        <path d="M8 8 C28 8 48 20 58 38 C68 56 52 76 38 80" stroke-width="1"/>
                        <path d="M38 48 C48 52 52 65 44 74" stroke-width="0.8"/>
                        <circle cx="25" cy="25" r="2" fill="var(--primary)" opacity="0.1"/>
                    </g>
                </svg>
            </div>
            <div class="batik-corner batik-br" style="opacity: 0.5;">
                <svg viewBox="0 0 160 160" xmlns="http://www.w3.org/2000/svg">
                    <g fill="none" stroke="var(--primary)" opacity="0.15">
                        <path d="M8 8 C28 8 48 20 58 38 C68 56 52 76 38 80" stroke-width="1"/>
                        <circle cx="25" cy="25" r="2" fill="var(--primary)" opacity="0.1"/>
                    </g>
                </svg>
            </div>

            <div class="max-w-md mx-auto">
                {{-- Section Header --}}
                <div class="text-center mb-16 reveal">
                    <p class="text-[10px] uppercase tracking-[0.4em] text-[var(--muted)] mb-3 font-display">Turut Mengundang</p>
                    <h3 class="text-2xl font-display text-[var(--text)]">Mempelai</h3>
                    <div class="ornament-divider mt-4">
                        <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 1 C11 4 11 7 8 8 C5 7 5 4 8 1Z" fill="var(--accent)" opacity="0.5"/>
                            <path d="M8 15 C11 12 11 9 8 8 C5 9 5 12 8 15Z" fill="var(--accent)" opacity="0.5"/>
                        </svg>
                    </div>
                </div>

                {{-- Groom --}}
                <div class="text-center mb-14 reveal reveal-d1">
                    @if($invitation->groom_photo)
                    <div class="couple-photo mb-6 float-anim">
                        <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}">
                    </div>
                    @else
                    <div class="couple-photo mb-6 float-anim flex items-center justify-center bg-[var(--warm)]">
                        <span class="text-5xl font-script text-[var(--primary)]">{{ substr($invitation->groom_name, 0, 1) }}</span>
                    </div>
                    @endif

                    <h4 class="text-3xl font-script text-[var(--primary)] mb-2">{{ $invitation->groom_name }}</h4>

                    @if($invitation->groom_father || $invitation->groom_mother)
                    <p class="text-xs text-[var(--muted)] leading-relaxed mt-3">
                        Putra dari<br>
                        <span class="text-[var(--text)] font-medium">Bpk. {{ $invitation->groom_father }}</span><br>
                        <span class="text-[var(--muted)]">&</span><br>
                        <span class="text-[var(--text)] font-medium">Ibu {{ $invitation->groom_mother }}</span>
                    </p>
                    @endif

                    @if($invitation->groom_instagram)
                    <a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" target="_blank"
                        class="inline-flex items-center gap-1.5 mt-4 px-4 py-1.5 text-xs text-[var(--primary)] bg-white/60 rounded-full border border-[var(--border)] hover:bg-[var(--primary)] hover:text-white transition-all">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        {{ $invitation->groom_instagram }}
                    </a>
                    @endif
                </div>

                {{-- Ampersand divider --}}
                <div class="text-center mb-14 reveal reveal-d2">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white border-2 border-[var(--accent)] shadow-lg" style="box-shadow: 0 4px 20px rgba(196,169,125,0.2);">
                        <span class="text-3xl font-script text-[var(--accent)]">&</span>
                    </div>
                </div>

                {{-- Bride --}}
                <div class="text-center reveal reveal-d3">
                    @if($invitation->bride_photo)
                    <div class="couple-photo mb-6 float-anim">
                        <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}">
                    </div>
                    @else
                    <div class="couple-photo mb-6 float-anim flex items-center justify-center bg-[var(--warm)]">
                        <span class="text-5xl font-script text-[var(--primary)]">{{ substr($invitation->bride_name, 0, 1) }}</span>
                    </div>
                    @endif

                    <h4 class="text-3xl font-script text-[var(--primary)] mb-2">{{ $invitation->bride_name }}</h4>

                    @if($invitation->bride_father || $invitation->bride_mother)
                    <p class="text-xs text-[var(--muted)] leading-relaxed mt-3">
                        Putri dari<br>
                        <span class="text-[var(--text)] font-medium">Bpk. {{ $invitation->bride_father }}</span><br>
                        <span class="text-[var(--muted)]">&</span><br>
                        <span class="text-[var(--text)] font-medium">Ibu {{ $invitation->bride_mother }}</span>
                    </p>
                    @endif

                    @if($invitation->bride_instagram)
                    <a href="https://instagram.com/{{ ltrim($invitation->bride_instagram, '@') }}" target="_blank"
                        class="inline-flex items-center gap-1.5 mt-4 px-4 py-1.5 text-xs text-[var(--primary)] bg-white/60 rounded-full border border-[var(--border)] hover:bg-[var(--primary)] hover:text-white transition-all">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        {{ $invitation->bride_instagram }}
                    </a>
                    @endif
                </div>
            </div>
        </section>



        {{-- ========== SECTION 5: COUNTDOWN TIMER ========== --}}
        <section class="py-20 px-6 relative overflow-hidden"
            style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);"
            x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">

            {{-- Subtle batik pattern overlay --}}
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cpath d=&quot;M30 5 C35 15 45 20 40 30 C35 40 25 40 20 30 C15 20 25 15 30 5Z&quot; fill=&quot;none&quot; stroke=&quot;white&quot; stroke-width=&quot;0.5&quot;/%3E%3C/svg%3E'); background-size: 60px 60px;"></div>

            <div class="max-w-sm mx-auto text-center relative z-10">
                <div class="reveal">
                    <p class="text-[10px] uppercase tracking-[0.5em] text-white/40 mb-3 font-display">Menghitung Hari</p>
                    <h3 class="text-xl font-display text-white/90 mb-10">Countdown</h3>
                </div>

                <div class="grid grid-cols-4 gap-3 reveal reveal-d1">
                    <div class="countdown-box">
                        <p class="text-3xl sm:text-4xl font-bold text-white font-display" x-text="days">0</p>
                        <p class="text-[9px] uppercase tracking-widest text-white/50 mt-2">Hari</p>
                    </div>
                    <div class="countdown-box">
                        <p class="text-3xl sm:text-4xl font-bold text-white font-display" x-text="hours">0</p>
                        <p class="text-[9px] uppercase tracking-widest text-white/50 mt-2">Jam</p>
                    </div>
                    <div class="countdown-box">
                        <p class="text-3xl sm:text-4xl font-bold text-white font-display" x-text="minutes">0</p>
                        <p class="text-[9px] uppercase tracking-widest text-white/50 mt-2">Menit</p>
                    </div>
                    <div class="countdown-box">
                        <p class="text-3xl sm:text-4xl font-bold text-white font-display" x-text="seconds">0</p>
                        <p class="text-[9px] uppercase tracking-widest text-white/50 mt-2">Detik</p>
                    </div>
                </div>

                <div class="reveal reveal-d2 mt-8">
                    <p class="text-xs text-white/50 font-display">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>
        </section>

        {{-- ========== SECTION 6: EVENT DETAILS ========== --}}
        <section class="py-24 px-6 bg-[var(--card)] relative overflow-hidden">
            {{-- Decorative corners --}}
            <div class="batik-corner batik-tl" style="opacity: 0.4;">
                <svg viewBox="0 0 160 160" xmlns="http://www.w3.org/2000/svg">
                    <g fill="none" stroke="var(--accent)" opacity="0.25">
                        <path d="M8 8 C25 8 45 18 55 35 C65 52 50 72 38 76" stroke-width="1"/>
                        <path d="M38 48 C48 52 52 65 44 74" stroke-width="0.8"/>
                        <circle cx="30" cy="30" r="2" fill="var(--accent)" opacity="0.2"/>
                    </g>
                </svg>
            </div>
            <div class="batik-corner batik-br" style="opacity: 0.4;">
                <svg viewBox="0 0 160 160" xmlns="http://www.w3.org/2000/svg">
                    <g fill="none" stroke="var(--accent)" opacity="0.25">
                        <path d="M8 8 C25 8 45 18 55 35 C65 52 50 72 38 76" stroke-width="1"/>
                        <circle cx="30" cy="30" r="2" fill="var(--accent)" opacity="0.2"/>
                    </g>
                </svg>
            </div>

            <div class="max-w-md mx-auto">
                {{-- Section Header --}}
                <div class="text-center mb-14 reveal">
                    <p class="text-[10px] uppercase tracking-[0.4em] text-[var(--muted)] mb-3 font-display">Save The Date</p>
                    <h3 class="text-2xl font-display text-[var(--text)]">Acara Pernikahan</h3>
                    <div class="ornament-divider mt-4">
                        <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 1 C11 4 11 7 8 8 C5 7 5 4 8 1Z" fill="var(--accent)" opacity="0.5"/>
                            <path d="M8 15 C11 12 11 9 8 8 C5 9 5 12 8 15Z" fill="var(--accent)" opacity="0.5"/>
                        </svg>
                    </div>
                </div>

                {{-- Akad Nikah Card --}}
                <div class="event-card mb-5 reveal reveal-d1">
                    <div class="w-14 h-14 mx-auto mb-5 rounded-full bg-[var(--warm)] flex items-center justify-center">
                        <svg class="w-6 h-6 text-[var(--primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-display font-medium text-[var(--text)] mb-4">Akad Nikah</h4>
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-[var(--text)]">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                        <p class="text-sm text-[var(--muted)]">
                            Pukul {{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }}
                            @if($invitation->event_time_end)
                            - {{ \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') }}
                            @else
                            - Selesai
                            @endif
                            WIB
                        </p>
                    </div>
                </div>

                {{-- Resepsi Card (optional) --}}
                @if($invitation->reception_date || $invitation->reception_venue)
                <div class="event-card mb-5 reveal reveal-d2">
                    <div class="w-14 h-14 mx-auto mb-5 rounded-full bg-[var(--warm)] flex items-center justify-center">
                        <svg class="w-6 h-6 text-[var(--primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0A1.75 1.75 0 003 15.546M9 3v2m6-2v2M3 12.5h18M4 7h16a1 1 0 011 1v11a2 2 0 01-2 2H5a2 2 0 01-2-2V8a1 1 0 011-1z"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-display font-medium text-[var(--text)] mb-4">Resepsi</h4>
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-[var(--text)]">{{ ($invitation->reception_date ?? $invitation->event_date)->translatedFormat('l, d F Y') }}</p>
                        @if($invitation->reception_time_start)
                        <p class="text-sm text-[var(--muted)]">
                            Pukul {{ \Carbon\Carbon::parse($invitation->reception_time_start)->format('H:i') }}
                            {{ $invitation->reception_time_end ? '- ' . \Carbon\Carbon::parse($invitation->reception_time_end)->format('H:i') : '' }} WIB
                        </p>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Venue & Maps Card --}}
                <div class="event-card reveal reveal-d3">
                    <div class="w-14 h-14 mx-auto mb-5 rounded-full bg-[var(--warm)] flex items-center justify-center">
                        <svg class="w-6 h-6 text-[var(--primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-display font-medium text-[var(--text)] mb-3">{{ $invitation->event_venue }}</h4>
                    @if($invitation->event_address)
                    <p class="text-xs text-[var(--muted)] leading-relaxed mb-5 max-w-xs mx-auto">{{ $invitation->event_address }}</p>
                    @endif
                    @if($invitation->event_maps_url)
                    <a href="{{ $invitation->event_maps_url }}" target="_blank" class="btn-primary text-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        Buka Google Maps
                    </a>
                    @endif
                </div>

                {{-- Dress Code --}}
                @if($invitation->dress_code)
                <div class="text-center mt-6 reveal reveal-d4">
                    <div class="inline-flex items-center gap-3 px-6 py-3 bg-[var(--warm)] rounded-2xl border border-[var(--border)]">
                        <svg class="w-4 h-4 text-[var(--accent)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                        </svg>
                        <span class="text-[11px] text-[var(--muted)]">Dress Code:</span>
                        <span class="text-[11px] font-medium text-[var(--primary)]">{{ $invitation->dress_code }}</span>
                    </div>
                </div>
                @endif
            </div>
        </section>



        {{-- ========== SECTION 7: GALLERY ========== --}}
        @if($invitation->galleries->count() > 0)
        <section class="py-24 px-6 bg-[var(--cream)]">
            <div class="max-w-lg mx-auto">
                {{-- Section Header --}}
                <div class="text-center mb-14 reveal">
                    <p class="text-[10px] uppercase tracking-[0.4em] text-[var(--muted)] mb-3 font-display">Our Moments</p>
                    <h3 class="text-2xl font-display text-[var(--text)]">Galeri Foto</h3>
                    <div class="ornament-divider mt-4">
                        <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 1 C11 4 11 7 8 8 C5 7 5 4 8 1Z" fill="var(--accent)" opacity="0.5"/>
                            <path d="M8 15 C11 12 11 9 8 8 C5 9 5 12 8 15Z" fill="var(--accent)" opacity="0.5"/>
                        </svg>
                    </div>
                </div>

                {{-- Gallery Grid --}}
                <div class="gallery-grid reveal reveal-d1">
                    @foreach($invitation->galleries as $i => $photo)
                    <div class="gallery-item {{ $i === 0 ? '' : '' }}" style="{{ $i === 0 ? 'grid-column: span 2; aspect-ratio: 16/9;' : '' }}">
                        <img src="{{ $photo->getImageUrl() }}" alt="{{ $photo->caption }}" class="w-full h-full object-cover" loading="lazy">
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        {{-- ========== SECTION 8: RSVP FORM ========== --}}
        <section class="py-24 px-6 bg-[var(--card)] relative overflow-hidden">
            {{-- Background ornament --}}
            <div class="batik-corner batik-tr" style="opacity: 0.3; width: 140px; height: 140px;">
                <svg viewBox="0 0 160 160" xmlns="http://www.w3.org/2000/svg">
                    <g fill="none" stroke="var(--accent)" opacity="0.2">
                        <path d="M8 8 C25 8 45 18 55 35 C65 52 50 72 38 76" stroke-width="1"/>
                        <path d="M55 35 C72 30 85 42 82 58" stroke-width="0.8"/>
                        <circle cx="35" cy="35" r="2" fill="var(--accent)" opacity="0.15"/>
                    </g>
                </svg>
            </div>

            <div class="max-w-sm mx-auto">
                {{-- Section Header --}}
                <div class="text-center mb-12 reveal">
                    <p class="text-[10px] uppercase tracking-[0.4em] text-[var(--muted)] mb-3 font-display">Konfirmasi Kehadiran</p>
                    <h3 class="text-2xl font-display text-[var(--text)]">RSVP</h3>
                    <p class="text-xs text-[var(--muted)] mt-3 leading-relaxed max-w-xs mx-auto">Merupakan suatu kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir</p>
                    <div class="ornament-divider mt-4">
                        <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 1 C11 4 11 7 8 8 C5 7 5 4 8 1Z" fill="var(--accent)" opacity="0.5"/>
                            <path d="M8 15 C11 12 11 9 8 8 C5 9 5 12 8 15Z" fill="var(--accent)" opacity="0.5"/>
                        </svg>
                    </div>
                </div>

                {{-- Success Message --}}
                @if(session('rsvp_success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 text-xs text-center rounded-2xl reveal">
                    {{ session('rsvp_success') }}
                </div>
                @endif

                {{-- RSVP Form --}}
                <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" class="space-y-4 reveal reveal-d1">
                    @csrf
                    <div>
                        <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}"
                            placeholder="Nama Lengkap" required class="form-input">
                    </div>
                    <div>
                        <select name="rsvp_status" required class="form-input">
                            <option value="">-- Konfirmasi Kehadiran --</option>
                            <option value="attending">Insya Allah, Saya Akan Hadir</option>
                            <option value="not_attending">Maaf, Saya Tidak Bisa Hadir</option>
                            <option value="maybe">Masih Belum Pasti</option>
                        </select>
                    </div>
                    <div>
                        <input type="number" name="number_of_guests" min="1" max="10" value="1"
                            placeholder="Jumlah Tamu" class="form-input">
                    </div>
                    <button type="submit" class="btn-primary w-full">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Kirim Konfirmasi
                    </button>
                </form>
            </div>
        </section>

        {{-- ========== SECTION 9: GUESTBOOK / UCAPAN ========== --}}
        <section class="py-24 px-6 bg-[var(--warm)] relative overflow-hidden">
            {{-- Background ornament --}}
            <div class="batik-corner batik-bl" style="opacity: 0.3; width: 120px; height: 120px;">
                <svg viewBox="0 0 160 160" xmlns="http://www.w3.org/2000/svg">
                    <g fill="none" stroke="var(--primary)" opacity="0.15">
                        <path d="M8 8 C25 8 45 18 55 35 C65 52 50 72 38 76" stroke-width="1"/>
                        <circle cx="30" cy="30" r="2" fill="var(--primary)" opacity="0.1"/>
                    </g>
                </svg>
            </div>

            <div class="max-w-sm mx-auto">
                {{-- Section Header --}}
                <div class="text-center mb-12 reveal">
                    <p class="text-[10px] uppercase tracking-[0.4em] text-[var(--muted)] mb-3 font-display">Ucapan & Doa</p>
                    <h3 class="text-2xl font-display text-[var(--text)]">Buku Tamu</h3>
                    <p class="text-xs text-[var(--muted)] mt-3">Kirimkan doa & ucapan terbaik untuk kedua mempelai</p>
                    <div class="ornament-divider mt-4">
                        <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 1 C11 4 11 7 8 8 C5 7 5 4 8 1Z" fill="var(--accent)" opacity="0.5"/>
                            <path d="M8 15 C11 12 11 9 8 8 C5 9 5 12 8 15Z" fill="var(--accent)" opacity="0.5"/>
                        </svg>
                    </div>
                </div>

                {{-- Success Message --}}
                @if(session('guestbook_success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 text-xs text-center rounded-2xl reveal">
                    {{ session('guestbook_success') }}
                </div>
                @endif

                {{-- Guestbook Form --}}
                <form method="POST" action="{{ route('invitation.guestbook', $invitation->slug) }}" class="space-y-4 mb-10 reveal reveal-d1">
                    @csrf
                    <div>
                        <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}"
                            placeholder="Nama Anda" required class="form-input">
                    </div>
                    <div>
                        <textarea name="message" rows="3" placeholder="Tulis ucapan & doa terbaik untuk kedua mempelai..." required
                            class="form-input" style="resize: none;"></textarea>
                    </div>
                    <button type="submit" class="btn-secondary w-full">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Kirim Ucapan
                    </button>
                </form>

                {{-- Messages List --}}
                @if($invitation->guestbooks->count() > 0)
                <div class="space-y-3 max-h-80 overflow-y-auto pr-1 reveal reveal-d2" style="scrollbar-width: thin; scrollbar-color: var(--border) transparent;">
                    @foreach($invitation->guestbooks->sortByDesc('created_at') as $msg)
                    <div class="message-card">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-full bg-[var(--warm)] flex items-center justify-center flex-shrink-0 border border-[var(--border)]">
                                <span class="text-[11px] font-bold text-[var(--primary)] font-display">{{ strtoupper(substr($msg->name, 0, 1)) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="text-xs font-semibold text-[var(--text)] truncate">{{ $msg->name }}</p>
                                    <p class="text-[9px] text-[var(--muted)] flex-shrink-0">{{ $msg->created_at->diffForHumans() }}</p>
                                </div>
                                <p class="text-xs text-[var(--muted)] mt-1.5 leading-relaxed">{{ $msg->message }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </section>



        {{-- ========== SECTION 10: AMPLOP DIGITAL / GIFT ========== --}}
        @if($invitation->bank_name || $invitation->qris_image)
        <section class="py-24 px-6 bg-[var(--card)] relative overflow-hidden">
            {{-- Decorative elements --}}
            <div class="batik-corner batik-tl" style="opacity: 0.3; width: 100px; height: 100px;">
                <svg viewBox="0 0 160 160" xmlns="http://www.w3.org/2000/svg">
                    <g fill="none" stroke="var(--accent)" opacity="0.2">
                        <path d="M8 8 C25 8 45 18 55 35" stroke-width="1"/>
                        <circle cx="30" cy="20" r="2" fill="var(--accent)" opacity="0.15"/>
                    </g>
                </svg>
            </div>
            <div class="batik-corner batik-br" style="opacity: 0.3; width: 100px; height: 100px;">
                <svg viewBox="0 0 160 160" xmlns="http://www.w3.org/2000/svg">
                    <g fill="none" stroke="var(--accent)" opacity="0.2">
                        <path d="M8 8 C25 8 45 18 55 35" stroke-width="1"/>
                        <circle cx="30" cy="20" r="2" fill="var(--accent)" opacity="0.15"/>
                    </g>
                </svg>
            </div>

            <div class="max-w-sm mx-auto text-center">
                {{-- Section Header --}}
                <div class="reveal">
                    <svg width="50" height="50" viewBox="0 0 50 50" class="mx-auto mb-6" xmlns="http://www.w3.org/2000/svg">
                        <g fill="none" stroke="var(--accent)" stroke-width="1" opacity="0.5">
                            <rect x="10" y="15" width="30" height="22" rx="3"/>
                            <path d="M10 18 L25 28 L40 18"/>
                            <path d="M22 12 L25 8 L28 12" stroke-width="0.8"/>
                            <circle cx="25" cy="6" r="2" fill="var(--accent)" opacity="0.3"/>
                        </g>
                    </svg>
                    <p class="text-[10px] uppercase tracking-[0.4em] text-[var(--muted)] mb-3 font-display">Wedding Gift</p>
                    <h3 class="text-2xl font-display text-[var(--text)] mb-4">Amplop Digital</h3>
                    @if($invitation->gift_info)
                    <p class="text-xs text-[var(--muted)] mb-8 leading-relaxed max-w-xs mx-auto">{{ $invitation->gift_info }}</p>
                    @else
                    <p class="text-xs text-[var(--muted)] mb-8 leading-relaxed max-w-xs mx-auto">Doa restu Anda sudah merupakan hadiah terindah bagi kami. Namun jika Anda berkenan memberikan tanda kasih, kami menyediakan amplop digital berikut:</p>
                    @endif
                </div>

                {{-- Bank Transfer --}}
                @if($invitation->bank_name)
                <div class="event-card mb-5 reveal reveal-d1" x-data="{ copied: false }">
                    <div class="w-12 h-12 mx-auto mb-4 rounded-full bg-[var(--warm)] flex items-center justify-center">
                        <svg class="w-5 h-5 text-[var(--primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
                        </svg>
                    </div>
                    <p class="text-[10px] uppercase tracking-widest text-[var(--muted)] mb-3">{{ $invitation->bank_name }}</p>
                    <p class="text-2xl font-bold text-[var(--text)] tracking-wider mb-1 font-display">{{ $invitation->bank_account_number }}</p>
                    <p class="text-xs text-[var(--muted)]">a.n. {{ $invitation->bank_account_name }}</p>
                    <button @click="navigator.clipboard.writeText('{{ $invitation->bank_account_number }}'); copied = true; setTimeout(() => copied = false, 2500)"
                        class="mt-5 px-6 py-2.5 bg-[var(--warm)] text-[var(--primary)] text-[11px] font-medium rounded-full hover:bg-[var(--primary)] hover:text-white transition-all border border-[var(--border)] cursor-pointer">
                        <span x-show="!copied">
                            <svg class="w-3.5 h-3.5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            Salin Nomor Rekening
                        </span>
                        <span x-show="copied" x-cloak class="text-green-600">✓ Berhasil Disalin!</span>
                    </button>
                </div>
                @endif

                {{-- QRIS --}}
                @if($invitation->qris_image)
                <div class="event-card reveal reveal-d2">
                    <div class="w-12 h-12 mx-auto mb-4 rounded-full bg-[var(--warm)] flex items-center justify-center">
                        <svg class="w-5 h-5 text-[var(--primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"/>
                        </svg>
                    </div>
                    <p class="text-[10px] uppercase tracking-widest text-[var(--muted)] mb-4">Scan QRIS</p>
                    <div class="inline-block p-3 bg-white rounded-2xl border border-[var(--border)] shadow-sm">
                        <img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS Code" class="w-48 h-48 object-contain">
                    </div>
                    <p class="text-[10px] text-[var(--muted)] mt-3">Scan QR code di atas menggunakan aplikasi e-wallet atau mobile banking Anda</p>
                </div>
                @endif
            </div>
        </section>
        @endif

        {{-- ========== SECTION 11: CLOSING TEXT ========== --}}
        <section class="py-24 px-6 relative overflow-hidden"
            style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);">

            {{-- Subtle pattern overlay --}}
            <div class="absolute inset-0 opacity-[0.04]" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;80&quot; height=&quot;80&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cpath d=&quot;M40 10 C50 20 55 30 50 40 C45 50 35 50 30 40 C25 30 30 20 40 10Z&quot; fill=&quot;none&quot; stroke=&quot;white&quot; stroke-width=&quot;0.5&quot;/%3E%3Ccircle cx=&quot;40&quot; cy=&quot;40&quot; r=&quot;3&quot; fill=&quot;none&quot; stroke=&quot;white&quot; stroke-width=&quot;0.3&quot;/%3E%3C/svg%3E'); background-size: 80px 80px;"></div>

            {{-- Batik corners with light color --}}
            <div class="absolute top-0 left-0 w-[140px] h-[140px] pointer-events-none">
                <svg viewBox="0 0 160 160" xmlns="http://www.w3.org/2000/svg">
                    <g fill="none" stroke="white" opacity="0.08">
                        <path d="M8 8 C25 8 45 18 55 35 C65 52 50 72 38 76" stroke-width="1.2"/>
                        <path d="M38 48 C48 52 52 65 44 74" stroke-width="0.8"/>
                        <circle cx="28" cy="28" r="2.5" fill="white" opacity="0.06"/>
                    </g>
                </svg>
            </div>
            <div class="absolute bottom-0 right-0 w-[140px] h-[140px] pointer-events-none" style="transform: scale(-1, -1);">
                <svg viewBox="0 0 160 160" xmlns="http://www.w3.org/2000/svg">
                    <g fill="none" stroke="white" opacity="0.08">
                        <path d="M8 8 C25 8 45 18 55 35 C65 52 50 72 38 76" stroke-width="1.2"/>
                        <path d="M38 48 C48 52 52 65 44 74" stroke-width="0.8"/>
                        <circle cx="28" cy="28" r="2.5" fill="white" opacity="0.06"/>
                    </g>
                </svg>
            </div>

            <div class="max-w-md mx-auto text-center relative z-10">
                {{-- Top ornament --}}
                <div class="reveal mb-10">
                    <svg width="100" height="20" viewBox="0 0 100 20" class="mx-auto" xmlns="http://www.w3.org/2000/svg">
                        <g fill="none" stroke="white" stroke-width="0.6" opacity="0.3">
                            <path d="M10 10 C25 4 35 6 50 10 C65 14 75 16 90 10"/>
                            <circle cx="50" cy="10" r="2.5" fill="white" opacity="0.2"/>
                            <circle cx="35" cy="8" r="1" fill="white" opacity="0.15"/>
                            <circle cx="65" cy="12" r="1" fill="white" opacity="0.15"/>
                        </g>
                    </svg>
                </div>

                @if($invitation->closing_text)
                <div class="reveal reveal-d1">
                    <p class="text-sm sm:text-base text-white/80 leading-[2] italic font-display">"{{ $invitation->closing_text }}"</p>
                </div>
                @endif

                <div class="reveal reveal-d2 mt-10">
                    <p class="text-[10px] uppercase tracking-[0.3em] text-white/40 mb-4">Kami yang berbahagia</p>
                    <h4 class="text-4xl font-script text-white/90">{{ $invitation->groom_name }}</h4>
                    <span class="text-xl font-script text-[var(--accent)] inline-block my-2">&</span>
                    <h4 class="text-4xl font-script text-white/90">{{ $invitation->bride_name }}</h4>
                </div>

                <div class="reveal reveal-d3 mt-10">
                    <p class="text-[10px] text-white/30 leading-relaxed">Beserta seluruh keluarga besar kedua mempelai</p>
                </div>

                {{-- Bottom ornament --}}
                <div class="reveal reveal-d3 mt-10">
                    <svg width="100" height="20" viewBox="0 0 100 20" class="mx-auto" xmlns="http://www.w3.org/2000/svg" style="transform: scaleY(-1);">
                        <g fill="none" stroke="white" stroke-width="0.6" opacity="0.3">
                            <path d="M10 10 C25 4 35 6 50 10 C65 14 75 16 90 10"/>
                            <circle cx="50" cy="10" r="2.5" fill="white" opacity="0.2"/>
                            <circle cx="35" cy="8" r="1" fill="white" opacity="0.15"/>
                            <circle cx="65" cy="12" r="1" fill="white" opacity="0.15"/>
                        </g>
                    </svg>
                </div>
            </div>
        </section>

        {{-- ========== SECTION 12: FOOTER ========== --}}
        <footer class="py-10 px-6 bg-[var(--cream)] text-center relative">
            <div class="reveal">
                {{-- Traditional divider --}}
                <svg width="120" height="24" viewBox="0 0 120 24" class="mx-auto mb-5" xmlns="http://www.w3.org/2000/svg">
                    <g fill="none" stroke="var(--accent)" stroke-width="0.6" opacity="0.4">
                        <path d="M10 12 C30 6 50 8 60 12 C70 16 90 18 110 12"/>
                        <circle cx="60" cy="12" r="2.5" fill="var(--accent)" opacity="0.3"/>
                        <circle cx="40" cy="10" r="1" fill="var(--accent)" opacity="0.2"/>
                        <circle cx="80" cy="14" r="1" fill="var(--accent)" opacity="0.2"/>
                    </g>
                </svg>

                <p class="text-[10px] text-[var(--muted)] mb-1">Made with ❤ by</p>
                <a href="{{ url('/') }}" class="text-xs text-[var(--primary)] hover:underline font-display font-medium">UndanganDigital</a>
                <p class="text-[9px] text-[var(--muted)] mt-3 opacity-50">&copy; {{ date('Y') }} All rights reserved</p>
            </div>
        </footer>

    </div>{{-- End of x-show="opened" --}}



    {{-- ========== SECTION 13: MUSIC PLAYER (Floating) ========== --}}
    @if($invitation->music_url)
    <div class="fixed bottom-6 right-6 z-40" x-show="opened" x-transition>
        <button @click="toggleMusic()"
            class="w-12 h-12 rounded-full shadow-xl flex items-center justify-center transition-all duration-300 border-2"
            :class="playing ? 'bg-[var(--primary)] text-white border-[var(--accent)] music-playing' : 'bg-white text-[var(--primary)] border-[var(--border)] hover:border-[var(--accent)]'"
            style="box-shadow: 0 4px 20px rgba(107,91,75,0.2);">
            {{-- Play icon --}}
            <svg x-show="!playing" class="w-4.5 h-4.5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
            </svg>
            {{-- Pause icon --}}
            <svg x-show="playing" x-cloak class="w-4.5 h-4.5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M5.75 3a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75A.75.75 0 007.25 3h-1.5zM12.75 3a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75a.75.75 0 00-.75-.75h-1.5z"/>
            </svg>
        </button>
        <audio x-ref="audio" src="{{ asset('storage/' . $invitation->music_url) }}" loop preload="auto"></audio>
    </div>
    @endif

    {{-- ========== JAVASCRIPT ========== --}}
    <script>
    function invitationApp() {
        return {
            opened: false,
            playing: false,

            openInvitation() {
                this.opened = true;
                document.body.style.overflow = 'auto';

                // Autoplay music if enabled
                @if($invitation->music_autoplay && $invitation->music_url)
                this.$nextTick(() => {
                    if (this.$refs.audio) {
                        this.$refs.audio.play()
                            .then(() => { this.playing = true; })
                            .catch(() => { /* Browser blocked autoplay */ });
                    }
                });
                @endif

                // Initialize scroll reveal animations
                this.$nextTick(() => {
                    setTimeout(() => this.initReveal(), 200);
                });
            },

            toggleMusic() {
                if (!this.$refs.audio) return;

                if (this.playing) {
                    this.$refs.audio.pause();
                    this.playing = false;
                } else {
                    this.$refs.audio.play()
                        .then(() => { this.playing = true; })
                        .catch(() => { /* Playback failed */ });
                }
            },

            initReveal() {
                const revealElements = document.querySelectorAll('.reveal');

                if ('IntersectionObserver' in window) {
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

                    revealElements.forEach(el => observer.observe(el));
                } else {
                    // Fallback for browsers without IntersectionObserver
                    revealElements.forEach(el => el.classList.add('active'));
                }
            }
        };
    }

    function countdown(targetDate) {
        return {
            days: 0,
            hours: 0,
            minutes: 0,
            seconds: 0,

            init() {
                this.update();
                setInterval(() => this.update(), 1000);
            },

            update() {
                const now = new Date().getTime();
                const target = new Date(targetDate).getTime();
                const diff = target - now;

                if (diff > 0) {
                    this.days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    this.hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    this.minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    this.seconds = Math.floor((diff % (1000 * 60)) / 1000);
                } else {
                    this.days = 0;
                    this.hours = 0;
                    this.minutes = 0;
                    this.seconds = 0;
                }
            }
        };
    }
    </script>
</body>
</html>
