<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&family=Josefin+Sans:wght@200;300;400;500;600&family=Sacramento&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --green: {{ $invitation->color_primary ?? '#4A6741' }};
            --green-light: #6B8F63;
            --sage: #9CAF88;
            --kraft: #F5EEE6;
            --warm: #EDE4D8;
            --text: {{ $invitation->color_secondary ?? '#3D3929' }};
            --muted: #8B7D6B;
            --accent: #C4956A;
            --border: rgba(74,103,65,0.12);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Josefin Sans', sans-serif;
            font-weight: 300;
            color: var(--text);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }
        .font-display { font-family: 'Amatic SC', cursive; font-weight: 700; }
        .font-script { font-family: 'Sacramento', cursive; }
        .font-body { font-family: 'Josefin Sans', sans-serif; }
        [x-cloak] { display: none !important; }

        /* Kraft paper texture background */
        .bg-kraft {
            background-color: var(--kraft);
            background-image:
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='4' height='4'%3E%3Crect width='4' height='4' fill='%23F5EEE6'/%3E%3Crect width='1' height='1' x='1' y='1' fill='%23EDE4D8' opacity='0.3'/%3E%3C/svg%3E"),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100' height='100' filter='url(%23n)' opacity='0.02'/%3E%3C/svg%3E");
        }

        /* Animations */
        .reveal { opacity: 0; transform: translateY(30px); transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
        .reveal.active { opacity: 1; transform: translateY(0); }
        .reveal-delay-1 { transition-delay: 0.15s; }
        .reveal-delay-2 { transition-delay: 0.3s; }
        .reveal-delay-3 { transition-delay: 0.45s; }
        .reveal-delay-4 { transition-delay: 0.6s; }

        /* Hand-drawn divider */
        .divider-botanical {
            width: 180px; height: 30px; margin: 0 auto;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 180 30'%3E%3Cpath d='M10 15 Q45 5 90 15 Q135 25 170 15' fill='none' stroke='%234A6741' stroke-width='0.8' opacity='0.4'/%3E%3Cpath d='M85 12 Q88 8 90 5 Q92 8 95 12' fill='none' stroke='%234A6741' stroke-width='0.6' opacity='0.5'/%3E%3Cpath d='M82 14 Q85 10 87 7' fill='none' stroke='%239CAF88' stroke-width='0.5' opacity='0.4'/%3E%3Cpath d='M93 14 Q95 10 98 7' fill='none' stroke='%239CAF88' stroke-width='0.5' opacity='0.4'/%3E%3Ccircle cx='90' cy='4' r='1.5' fill='%234A6741' opacity='0.3'/%3E%3C/svg%3E") no-repeat center/contain;
        }
        .divider-sm {
            width: 100px; height: 20px; margin: 0 auto;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 20'%3E%3Cpath d='M10 10 Q30 4 50 10 Q70 16 90 10' fill='none' stroke='%234A6741' stroke-width='0.6' opacity='0.35'/%3E%3Cpath d='M47 8 L50 4 L53 8' fill='none' stroke='%239CAF88' stroke-width='0.5' opacity='0.4'/%3E%3C/svg%3E") no-repeat center/contain;
        }

        /* Botanical corner decorations */
        .botanical-corner-tl {
            position: absolute; top: 20px; left: 20px; width: 100px; height: 100px; pointer-events: none;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cpath d='M5 95 Q5 50 15 30 Q25 10 50 5' fill='none' stroke='%234A6741' stroke-width='1' opacity='0.3'/%3E%3Cpath d='M15 70 Q20 60 18 50 Q16 45 20 40' fill='none' stroke='%239CAF88' stroke-width='0.7' opacity='0.3'/%3E%3Cpath d='M20 40 Q15 38 12 35' fill='none' stroke='%236B8F63' stroke-width='0.5' opacity='0.3'/%3E%3Cpath d='M20 40 Q22 36 20 32' fill='none' stroke='%236B8F63' stroke-width='0.5' opacity='0.3'/%3E%3Cpath d='M10 80 Q14 75 12 70' fill='none' stroke='%239CAF88' stroke-width='0.5' opacity='0.25'/%3E%3Cpath d='M10 80 Q8 76 10 72' fill='none' stroke='%239CAF88' stroke-width='0.5' opacity='0.25'/%3E%3Cpath d='M30 20 Q35 15 42 12' fill='none' stroke='%236B8F63' stroke-width='0.6' opacity='0.3'/%3E%3Cpath d='M30 20 Q28 15 30 10' fill='none' stroke='%236B8F63' stroke-width='0.5' opacity='0.25'/%3E%3C/svg%3E") no-repeat center/contain;
        }
        .botanical-corner-tr {
            position: absolute; top: 20px; right: 20px; width: 100px; height: 100px; pointer-events: none;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cpath d='M95 95 Q95 50 85 30 Q75 10 50 5' fill='none' stroke='%234A6741' stroke-width='1' opacity='0.3'/%3E%3Cpath d='M85 70 Q80 60 82 50 Q84 45 80 40' fill='none' stroke='%239CAF88' stroke-width='0.7' opacity='0.3'/%3E%3Cpath d='M80 40 Q85 38 88 35' fill='none' stroke='%236B8F63' stroke-width='0.5' opacity='0.3'/%3E%3Cpath d='M80 40 Q78 36 80 32' fill='none' stroke='%236B8F63' stroke-width='0.5' opacity='0.3'/%3E%3Cpath d='M90 80 Q86 75 88 70' fill='none' stroke='%239CAF88' stroke-width='0.5' opacity='0.25'/%3E%3Cpath d='M90 80 Q92 76 90 72' fill='none' stroke='%239CAF88' stroke-width='0.5' opacity='0.25'/%3E%3Cpath d='M70 20 Q65 15 58 12' fill='none' stroke='%236B8F63' stroke-width='0.6' opacity='0.3'/%3E%3Cpath d='M70 20 Q72 15 70 10' fill='none' stroke='%236B8F63' stroke-width='0.5' opacity='0.25'/%3E%3C/svg%3E") no-repeat center/contain;
        }
        .botanical-corner-bl {
            position: absolute; bottom: 20px; left: 20px; width: 100px; height: 100px; pointer-events: none;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cpath d='M5 5 Q5 50 15 70 Q25 90 50 95' fill='none' stroke='%234A6741' stroke-width='1' opacity='0.3'/%3E%3Cpath d='M15 30 Q20 40 18 50 Q16 55 20 60' fill='none' stroke='%239CAF88' stroke-width='0.7' opacity='0.3'/%3E%3Cpath d='M20 60 Q15 62 12 65' fill='none' stroke='%236B8F63' stroke-width='0.5' opacity='0.3'/%3E%3Cpath d='M20 60 Q22 64 20 68' fill='none' stroke='%236B8F63' stroke-width='0.5' opacity='0.3'/%3E%3C/svg%3E") no-repeat center/contain;
        }
        .botanical-corner-br {
            position: absolute; bottom: 20px; right: 20px; width: 100px; height: 100px; pointer-events: none;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cpath d='M95 5 Q95 50 85 70 Q75 90 50 95' fill='none' stroke='%234A6741' stroke-width='1' opacity='0.3'/%3E%3Cpath d='M85 30 Q80 40 82 50 Q84 55 80 60' fill='none' stroke='%239CAF88' stroke-width='0.7' opacity='0.3'/%3E%3Cpath d='M80 60 Q85 62 88 65' fill='none' stroke='%236B8F63' stroke-width='0.5' opacity='0.3'/%3E%3Cpath d='M80 60 Q78 64 80 68' fill='none' stroke='%236B8F63' stroke-width='0.5' opacity='0.3'/%3E%3C/svg%3E") no-repeat center/contain;
        }

        /* Rustic card */
        .rustic-card {
            background: white;
            border: 1px solid var(--border);
            border-top: 3px solid var(--green);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(61,57,41,0.06), 0 1px 4px rgba(74,103,65,0.04);
        }

        /* Buttons */
        .btn-green {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 14px 32px;
            background: var(--green);
            color: white; font-weight: 500; font-size: 14px;
            border-radius: 50px; border: none; cursor: pointer;
            box-shadow: 0 4px 16px rgba(74,103,65,0.25);
            transition: all 0.3s ease;
            text-decoration: none;
            font-family: 'Josefin Sans', sans-serif;
        }
        .btn-green:hover { transform: translateY(-2px); box-shadow: 0 6px 24px rgba(74,103,65,0.35); background: var(--green-light); }

        .btn-outline-green {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 12px 28px;
            border: 1.5px solid var(--green);
            color: var(--green); font-weight: 500; font-size: 13px;
            border-radius: 50px; cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none; background: transparent;
            font-family: 'Josefin Sans', sans-serif;
        }
        .btn-outline-green:hover { background: var(--green); color: white; }

        /* Input fields */
        .input-rustic {
            width: 100%; padding: 14px 18px;
            background: var(--kraft); border: 1px solid var(--border);
            border-radius: 12px; font-size: 14px; color: var(--text);
            transition: border-color 0.3s;
            font-family: 'Josefin Sans', sans-serif;
        }
        .input-rustic:focus { outline: none; border-color: var(--green); box-shadow: 0 0 0 3px rgba(74,103,65,0.08); }
        .input-rustic::placeholder { color: var(--muted); opacity: 0.6; }

        /* Organic photo shapes */
        .photo-organic {
            border-radius: 60% 40% 50% 50% / 50% 55% 45% 50%;
            overflow: hidden;
        }
        .photo-organic-alt {
            border-radius: 40% 60% 50% 50% / 55% 45% 55% 45%;
            overflow: hidden;
        }

        /* Masonry gallery */
        .gallery-masonry {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        .gallery-masonry .gallery-item:first-child {
            grid-column: span 2;
            border-radius: 20px 20px 12px 12px;
        }
        .gallery-masonry .gallery-item {
            border-radius: 12px;
            overflow: hidden;
            aspect-ratio: 1;
        }
        .gallery-masonry .gallery-item:first-child {
            aspect-ratio: 16/10;
        }

        /* Countdown boxes */
        .countdown-box {
            background: var(--green);
            border-radius: 14px;
            padding: 20px 10px;
            box-shadow: 0 4px 12px rgba(74,103,65,0.2);
        }

        /* Music */
        @keyframes rotate { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        .music-spin { animation: rotate 3s linear infinite; }

        /* Leaf float animation */
        @keyframes floatLeaf {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-8px) rotate(3deg); }
        }
        .float-leaf { animation: floatLeaf 4s ease-in-out infinite; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--sage); border-radius: 4px; }

        /* Mobile Responsive */
        @media (max-width: 640px) {
            .botanical-corner-tl, .botanical-corner-tr, .botanical-corner-bl, .botanical-corner-br { width: 70px; height: 70px; }
            .photo-organic, .photo-organic-alt { width: 180px !important; height: 180px !important; }
            .countdown-box { padding: 14px 8px; }
            .gallery-masonry { gap: 8px; }
            section { padding-left: 16px; padding-right: 16px; }
        }
    </style>
</head>
<body class="bg-kraft" x-data="invitationApp()" x-cloak>


    <!-- ===================== OPENING COVER ===================== -->
    <section x-show="!opened" class="fixed inset-0 z-50 flex items-center justify-center bg-kraft"
        x-transition:leave="transition ease-in duration-700"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95">

        <!-- Botanical SVG Frame Corners -->
        <div class="botanical-corner-tl"></div>
        <div class="botanical-corner-tr"></div>
        <div class="botanical-corner-bl"></div>
        <div class="botanical-corner-br"></div>

        <!-- Subtle fern pattern overlay -->
        <div class="absolute inset-0 pointer-events-none opacity-[0.04]" style="background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60'%3E%3Cpath d='M30 5 Q32 15 30 25 Q28 15 30 5' fill='none' stroke='%234A6741' stroke-width='0.5'/%3E%3Cpath d='M25 15 Q28 18 30 15' fill='none' stroke='%234A6741' stroke-width='0.4'/%3E%3Cpath d='M35 15 Q32 18 30 15' fill='none' stroke='%234A6741' stroke-width='0.4'/%3E%3C/svg%3E&quot;); background-size: 60px 60px;"></div>

        <div class="text-center px-8 relative z-10 max-w-sm">
            <!-- Top botanical SVG decoration -->
            <div class="mb-8 float-leaf">
                <svg width="80" height="60" viewBox="0 0 80 60" fill="none" xmlns="http://www.w3.org/2000/svg" class="mx-auto opacity-50">
                    <path d="M40 55 Q38 40 30 30 Q22 20 10 18" stroke="#4A6741" stroke-width="1.2" fill="none"/>
                    <path d="M40 55 Q42 40 50 30 Q58 20 70 18" stroke="#4A6741" stroke-width="1.2" fill="none"/>
                    <path d="M30 30 Q28 26 24 24" stroke="#9CAF88" stroke-width="0.8" fill="none"/>
                    <path d="M30 30 Q32 26 30 22" stroke="#9CAF88" stroke-width="0.8" fill="none"/>
                    <path d="M50 30 Q52 26 56 24" stroke="#9CAF88" stroke-width="0.8" fill="none"/>
                    <path d="M50 30 Q48 26 50 22" stroke="#9CAF88" stroke-width="0.8" fill="none"/>
                    <path d="M25 22 Q22 19 18 18" stroke="#6B8F63" stroke-width="0.6" fill="none"/>
                    <path d="M55 22 Q58 19 62 18" stroke="#6B8F63" stroke-width="0.6" fill="none"/>
                    <circle cx="40" cy="55" r="2" fill="#4A6741" opacity="0.3"/>
                </svg>
            </div>

            <p class="text-xs uppercase tracking-[0.4em] text-[var(--muted)] mb-6 font-body font-light">The Wedding Of</p>

            <h1 class="text-5xl sm:text-6xl font-display text-[var(--green)] leading-tight mb-2">{{ $invitation->groom_name }}</h1>

            <div class="flex items-center justify-center gap-4 my-4">
                <div class="w-10 h-px bg-[var(--sage)]"></div>
                <span class="text-3xl font-script text-[var(--accent)]">&</span>
                <div class="w-10 h-px bg-[var(--sage)]"></div>
            </div>

            <h1 class="text-5xl sm:text-6xl font-display text-[var(--green)] leading-tight">{{ $invitation->bride_name }}</h1>

            @if($guestName)
            <div class="mt-8 py-3 px-6 border border-[var(--border)] rounded-2xl bg-white/60 backdrop-blur-sm inline-block">
                <p class="text-[10px] uppercase tracking-[0.3em] text-[var(--muted)] mb-1">Kepada Yth.</p>
                <p class="text-base text-[var(--text)] font-medium font-body">{{ urldecode($guestName) }}</p>
            </div>
            @endif

            <div class="divider-botanical mt-8 mb-8"></div>

            <button @click="openInvitation()" class="btn-green">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Buka Undangan
            </button>

            <p class="text-xs text-[var(--muted)] mt-6 font-body">{{ $invitation->event_date->translatedFormat('d F Y') }}</p>
        </div>
    </section>

    <!-- ===================== MAIN CONTENT ===================== -->
    <div x-show="opened" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

        <!-- ===================== HERO ===================== -->
        <section class="min-h-screen flex items-center justify-center py-24 px-6 relative bg-kraft">
            <!-- Background botanical elements -->
            <div class="absolute top-10 left-5 opacity-20 float-leaf" style="animation-delay: 0.5s;">
                <svg width="50" height="80" viewBox="0 0 50 80" fill="none">
                    <path d="M25 75 Q23 55 18 40 Q13 25 5 15" stroke="#4A6741" stroke-width="1" fill="none"/>
                    <path d="M18 40 Q15 37 12 36" stroke="#9CAF88" stroke-width="0.6" fill="none"/>
                    <path d="M18 40 Q20 36 18 32" stroke="#9CAF88" stroke-width="0.6" fill="none"/>
                    <path d="M13 28 Q10 25 7 24" stroke="#6B8F63" stroke-width="0.5" fill="none"/>
                </svg>
            </div>
            <div class="absolute bottom-10 right-5 opacity-20 float-leaf" style="animation-delay: 1.5s;">
                <svg width="50" height="80" viewBox="0 0 50 80" fill="none">
                    <path d="M25 5 Q27 25 32 40 Q37 55 45 65" stroke="#4A6741" stroke-width="1" fill="none"/>
                    <path d="M32 40 Q35 37 38 36" stroke="#9CAF88" stroke-width="0.6" fill="none"/>
                    <path d="M32 40 Q30 44 32 48" stroke="#9CAF88" stroke-width="0.6" fill="none"/>
                    <path d="M37 52 Q40 55 43 56" stroke="#6B8F63" stroke-width="0.5" fill="none"/>
                </svg>
            </div>

            <div class="text-center max-w-lg relative z-10 reveal">
                <div class="divider-botanical mb-10"></div>

                <p class="text-[11px] uppercase tracking-[0.6em] text-[var(--muted)] mb-10 font-body">We Are Getting Married</p>

                <h2 class="text-6xl sm:text-7xl font-display text-[var(--green)] leading-tight">{{ $invitation->groom_name }}</h2>

                <div class="flex items-center justify-center gap-5 my-5">
                    <div class="w-14 h-px bg-gradient-to-r from-transparent to-[var(--sage)]"></div>
                    <span class="text-4xl font-script text-[var(--accent)]">&</span>
                    <div class="w-14 h-px bg-gradient-to-l from-transparent to-[var(--sage)]"></div>
                </div>

                <h2 class="text-6xl sm:text-7xl font-display text-[var(--green)] leading-tight">{{ $invitation->bride_name }}</h2>

                <div class="mt-12 inline-flex items-center gap-3 px-5 py-2.5 bg-white border border-[var(--border)] rounded-full shadow-sm">
                    <svg class="w-4 h-4 text-[var(--green)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span class="text-sm text-[var(--text)] font-body">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</span>
                </div>

                <div class="divider-botanical mt-12" style="transform: scaleY(-1)"></div>
            </div>
        </section>

        <!-- ===================== OPENING TEXT ===================== -->
        @if($invitation->opening_text)
        <section class="py-20 px-6 bg-white relative">
            <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-[var(--sage)] to-transparent opacity-30"></div>
            <div class="max-w-lg mx-auto text-center reveal">
                <div class="divider-sm mb-8"></div>
                <p class="text-base sm:text-lg font-body italic text-[var(--text)] leading-loose opacity-80">"{{ $invitation->opening_text }}"</p>
                <div class="divider-sm mt-8" style="transform: scaleY(-1)"></div>
            </div>
        </section>
        @endif


        <!-- ===================== COUPLE ===================== -->
        <section class="py-20 px-6 bg-kraft relative">
            <div class="max-w-lg mx-auto">
                <div class="text-center mb-14 reveal">
                    <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--muted)] mb-2 font-body">The Happy Couple</p>
                    <h3 class="text-4xl font-display text-[var(--green)]">Mempelai</h3>
                </div>

                <!-- Groom -->
                <div class="text-center mb-14 reveal reveal-delay-1">
                    @if($invitation->groom_photo)
                    <div class="w-52 h-52 mx-auto mb-6 photo-organic p-1.5 bg-gradient-to-br from-[var(--green)] to-[var(--sage)] shadow-lg">
                        <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}" class="w-full h-full object-cover photo-organic">
                    </div>
                    @else
                    <div class="w-52 h-52 mx-auto mb-6 photo-organic bg-[var(--warm)] flex items-center justify-center border-2 border-[var(--sage)]/30 shadow-md">
                        <span class="text-6xl font-display text-[var(--green)]">{{ substr($invitation->groom_name, 0, 1) }}</span>
                    </div>
                    @endif
                    <h4 class="text-4xl font-display text-[var(--green)] mb-2">{{ $invitation->groom_name }}</h4>
                    @if($invitation->groom_father || $invitation->groom_mother)
                    <p class="text-sm text-[var(--muted)] leading-relaxed font-body">Putra dari<br>
                        <span class="text-[var(--text)]">Bpk. {{ $invitation->groom_father }}</span> &
                        <span class="text-[var(--text)]">Ibu {{ $invitation->groom_mother }}</span>
                    </p>
                    @endif
                    @if($invitation->groom_instagram)
                    <a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" target="_blank" class="inline-flex items-center gap-1.5 mt-3 text-sm text-[var(--green)] hover:text-[var(--green-light)] transition-colors font-body">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        {{ $invitation->groom_instagram }}
                    </a>
                    @endif
                </div>

                <!-- & Symbol -->
                <div class="text-center mb-14 reveal reveal-delay-2">
                    <div class="inline-flex items-center gap-4">
                        <svg width="40" height="20" viewBox="0 0 40 20" class="opacity-40">
                            <path d="M0 10 Q10 5 20 10 Q10 15 0 10" fill="none" stroke="#4A6741" stroke-width="0.8"/>
                            <path d="M15 8 Q18 5 20 3" fill="none" stroke="#9CAF88" stroke-width="0.5"/>
                        </svg>
                        <span class="text-5xl font-script text-[var(--accent)]">&</span>
                        <svg width="40" height="20" viewBox="0 0 40 20" class="opacity-40" style="transform: scaleX(-1)">
                            <path d="M0 10 Q10 5 20 10 Q10 15 0 10" fill="none" stroke="#4A6741" stroke-width="0.8"/>
                            <path d="M15 8 Q18 5 20 3" fill="none" stroke="#9CAF88" stroke-width="0.5"/>
                        </svg>
                    </div>
                </div>

                <!-- Bride -->
                <div class="text-center reveal reveal-delay-3">
                    @if($invitation->bride_photo)
                    <div class="w-52 h-52 mx-auto mb-6 photo-organic-alt p-1.5 bg-gradient-to-br from-[var(--sage)] to-[var(--green-light)] shadow-lg">
                        <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}" class="w-full h-full object-cover photo-organic-alt">
                    </div>
                    @else
                    <div class="w-52 h-52 mx-auto mb-6 photo-organic-alt bg-[var(--warm)] flex items-center justify-center border-2 border-[var(--sage)]/30 shadow-md">
                        <span class="text-6xl font-display text-[var(--green)]">{{ substr($invitation->bride_name, 0, 1) }}</span>
                    </div>
                    @endif
                    <h4 class="text-4xl font-display text-[var(--green)] mb-2">{{ $invitation->bride_name }}</h4>
                    @if($invitation->bride_father || $invitation->bride_mother)
                    <p class="text-sm text-[var(--muted)] leading-relaxed font-body">Putri dari<br>
                        <span class="text-[var(--text)]">Bpk. {{ $invitation->bride_father }}</span> &
                        <span class="text-[var(--text)]">Ibu {{ $invitation->bride_mother }}</span>
                    </p>
                    @endif
                    @if($invitation->bride_instagram)
                    <a href="https://instagram.com/{{ ltrim($invitation->bride_instagram, '@') }}" target="_blank" class="inline-flex items-center gap-1.5 mt-3 text-sm text-[var(--green)] hover:text-[var(--green-light)] transition-colors font-body">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        {{ $invitation->bride_instagram }}
                    </a>
                    @endif
                </div>
            </div>
        </section>

        <!-- ===================== COUNTDOWN ===================== -->
        <section class="py-20 px-6 bg-[var(--green)] relative overflow-hidden">
            <!-- Leaf pattern overlay -->
            <div class="absolute inset-0 pointer-events-none opacity-[0.06]" style="background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40'%3E%3Cpath d='M20 5 Q22 12 20 20 Q18 12 20 5' fill='none' stroke='white' stroke-width='0.5'/%3E%3Cpath d='M16 12 Q18 14 20 12' fill='none' stroke='white' stroke-width='0.3'/%3E%3Cpath d='M24 12 Q22 14 20 12' fill='none' stroke='white' stroke-width='0.3'/%3E%3C/svg%3E&quot;); background-size: 40px 40px;"></div>

            <div class="max-w-md mx-auto text-center relative z-10 reveal" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">
                <p class="text-[10px] uppercase tracking-[0.5em] text-white/60 mb-3 font-body">Save The Date</p>
                <h3 class="text-4xl font-display text-white mb-10">Menghitung Hari</h3>

                <div class="grid grid-cols-4 gap-3">
                    <div class="countdown-box text-center">
                        <p class="text-3xl sm:text-4xl font-display text-white" x-text="days">0</p>
                        <p class="text-[9px] uppercase tracking-[0.2em] text-white/50 mt-1 font-body">Hari</p>
                    </div>
                    <div class="countdown-box text-center">
                        <p class="text-3xl sm:text-4xl font-display text-white" x-text="hours">0</p>
                        <p class="text-[9px] uppercase tracking-[0.2em] text-white/50 mt-1 font-body">Jam</p>
                    </div>
                    <div class="countdown-box text-center">
                        <p class="text-3xl sm:text-4xl font-display text-white" x-text="minutes">0</p>
                        <p class="text-[9px] uppercase tracking-[0.2em] text-white/50 mt-1 font-body">Menit</p>
                    </div>
                    <div class="countdown-box text-center">
                        <p class="text-3xl sm:text-4xl font-display text-white" x-text="seconds">0</p>
                        <p class="text-[9px] uppercase tracking-[0.2em] text-white/50 mt-1 font-body">Detik</p>
                    </div>
                </div>

                <p class="text-white/70 text-sm mt-8 font-body">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
            </div>
        </section>


        <!-- ===================== EVENT DETAILS ===================== -->
        <section class="py-20 px-6 bg-white relative">
            <div class="max-w-lg mx-auto text-center">
                <div class="reveal">
                    <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--muted)] mb-2 font-body">When & Where</p>
                    <h3 class="text-4xl font-display text-[var(--green)] mb-12">Acara Pernikahan</h3>
                </div>

                <div class="rustic-card p-8 sm:p-10 relative reveal reveal-delay-1">
                    <!-- Leaf decoration on card -->
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                        <svg width="50" height="25" viewBox="0 0 50 25" class="opacity-40">
                            <path d="M25 22 Q23 15 18 10 Q13 5 5 3" stroke="#4A6741" stroke-width="0.8" fill="none"/>
                            <path d="M25 22 Q27 15 32 10 Q37 5 45 3" stroke="#4A6741" stroke-width="0.8" fill="none"/>
                            <path d="M18 10 Q16 8 14 7" stroke="#9CAF88" stroke-width="0.5" fill="none"/>
                            <path d="M32 10 Q34 8 36 7" stroke="#9CAF88" stroke-width="0.5" fill="none"/>
                        </svg>
                    </div>

                    <div class="w-14 h-14 mx-auto mb-6 rounded-full bg-[var(--kraft)] flex items-center justify-center border border-[var(--border)]">
                        <svg class="w-6 h-6 text-[var(--green)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>

                    <h4 class="text-2xl font-display text-[var(--green)] mb-5">{{ $invitation->event_venue }}</h4>

                    <div class="space-y-1.5 text-sm text-[var(--muted)] mb-6 font-body">
                        <p class="font-medium text-[var(--text)]">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                        <p>Pukul {{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }} {{ $invitation->event_time_end ? '- ' . \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') : '' }} WIB</p>
                    </div>

                    @if($invitation->event_address)
                    <p class="text-xs text-[var(--muted)] mb-8 max-w-xs mx-auto leading-relaxed font-body">{{ $invitation->event_address }}</p>
                    @endif

                    @if($invitation->event_maps_url)
                    <a href="{{ $invitation->event_maps_url }}" target="_blank" class="btn-green text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        Buka Maps
                    </a>
                    @endif
                </div>

                @if($invitation->dress_code)
                <div class="mt-6 inline-flex items-center gap-2 px-5 py-2.5 bg-[var(--kraft)] rounded-full border border-[var(--border)] reveal reveal-delay-2">
                    <svg class="w-4 h-4 text-[var(--green)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span class="text-xs text-[var(--text)] font-body">Dress Code: <strong>{{ $invitation->dress_code }}</strong></span>
                </div>
                @endif
            </div>
        </section>

        <!-- ===================== GALLERY ===================== -->
        @if($invitation->galleries->count() > 0)
        <section class="py-20 px-6 bg-kraft">
            <div class="max-w-lg mx-auto">
                <div class="text-center mb-12 reveal">
                    <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--muted)] mb-2 font-body">Our Moments</p>
                    <h3 class="text-4xl font-display text-[var(--green)]">Galeri</h3>
                </div>
                <div class="gallery-masonry reveal reveal-delay-1">
                    @foreach($invitation->galleries as $i => $photo)
                    <div class="gallery-item group">
                        <img src="{{ $photo->getImageUrl() }}" alt="Gallery {{ $i + 1 }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- ===================== RSVP ===================== -->
        <section class="py-20 px-6 bg-white relative">
            <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-[var(--sage)] to-transparent opacity-30"></div>
            <div class="max-w-sm mx-auto">
                <div class="text-center mb-10 reveal">
                    <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--muted)] mb-2 font-body">Attendance</p>
                    <h3 class="text-4xl font-display text-[var(--green)]">RSVP</h3>
                    <p class="text-sm text-[var(--muted)] mt-3 font-body">Konfirmasi kehadiran Anda</p>
                </div>

                @if(session('rsvp_success'))
                <div class="mb-5 p-4 bg-green-50 border border-green-200 text-green-700 text-sm text-center rounded-2xl font-body">{{ session('rsvp_success') }}</div>
                @endif

                <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" class="space-y-4 reveal reveal-delay-1">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Lengkap" required class="input-rustic">
                    <select name="rsvp_status" required class="input-rustic">
                        <option value="">-- Konfirmasi Kehadiran --</option>
                        <option value="attending">Ya, Saya Akan Hadir</option>
                        <option value="not_attending">Maaf, Tidak Bisa Hadir</option>
                        <option value="maybe">Masih Belum Pasti</option>
                    </select>
                    <input type="number" name="number_of_guests" min="1" max="10" value="1" placeholder="Jumlah Tamu" class="input-rustic">
                    <button type="submit" class="btn-green w-full justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Kirim Konfirmasi
                    </button>
                </form>
            </div>
        </section>

        <!-- ===================== GUESTBOOK ===================== -->
        <section class="py-20 px-6 bg-kraft">
            <div class="max-w-md mx-auto">
                <div class="text-center mb-10 reveal">
                    <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--muted)] mb-2 font-body">Wishes</p>
                    <h3 class="text-4xl font-display text-[var(--green)]">Ucapan & Doa</h3>
                </div>

                <form method="POST" action="{{ route('invitation.guestbook', $invitation->slug) }}" class="space-y-4 mb-10 reveal reveal-delay-1">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Anda" required class="input-rustic">
                    <textarea name="message" rows="4" placeholder="Tulis ucapan & doa terbaik Anda..." required class="input-rustic" style="resize: none;"></textarea>
                    <button type="submit" class="btn-outline-green w-full justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        Kirim Ucapan
                    </button>
                </form>

                @if($invitation->guestbooks->count() > 0)
                <div class="space-y-3 max-h-80 overflow-y-auto pr-1 reveal reveal-delay-2">
                    @foreach($invitation->guestbooks as $msg)
                    <div class="bg-white rounded-2xl p-5 border border-[var(--border)] shadow-sm">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-full bg-[var(--kraft)] flex items-center justify-center flex-shrink-0 border border-[var(--border)]">
                                <span class="text-xs font-bold text-[var(--green)]">{{ strtoupper(substr($msg->name, 0, 1)) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-[var(--text)] font-body">{{ $msg->name }}</p>
                                <p class="text-sm text-[var(--muted)] mt-1 leading-relaxed font-body">{{ $msg->message }}</p>
                                <p class="text-[10px] text-[var(--muted)] opacity-50 mt-2 font-body">{{ $msg->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </section>


        <!-- ===================== DIGITAL ENVELOPE ===================== -->
        @if($invitation->bankAccounts->count() > 0 || $invitation->bank_name || $invitation->qris_image)
        <section class="py-20 px-6 bg-white relative">
            <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-[var(--sage)] to-transparent opacity-30"></div>
            <div class="max-w-sm mx-auto text-center">
                <div class="reveal">
                    <div class="w-14 h-14 mx-auto mb-6 rounded-full bg-[var(--kraft)] flex items-center justify-center border border-[var(--border)]">
                        <svg class="w-6 h-6 text-[var(--accent)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--muted)] mb-2 font-body">Wedding Gift</p>
                    <h3 class="text-4xl font-display text-[var(--green)] mb-3">Amplop Digital</h3>
                    @if($invitation->gift_info)
                    <p class="text-sm text-[var(--muted)] mb-8 leading-relaxed font-body">{{ $invitation->gift_info }}</p>
                    @else
                    <p class="text-sm text-[var(--muted)] mb-8 font-body">Doa restu Anda sudah cukup. Namun jika berkenan memberi tanda kasih:</p>
                    @endif
                </div>

                @if($invitation->bankAccounts->count() > 0)
                    @foreach($invitation->bankAccounts as $bank)
                    <div class="rustic-card p-6 mb-4 reveal reveal-delay-1" x-data="{ copied: false }">
                        <p class="text-[10px] uppercase tracking-[0.2em] text-[var(--muted)] mb-2 font-body">{{ $bank->bank_name }}</p>
                        <p class="text-2xl font-display text-[var(--green)] tracking-wider mb-1">{{ $bank->account_number }}</p>
                        <p class="text-sm text-[var(--muted)] font-body">a.n. {{ $bank->account_name }}</p>
                        <button @click="navigator.clipboard.writeText('{{ $bank->account_number }}'); copied = true; setTimeout(() => copied = false, 2000)" class="mt-4 px-5 py-2 bg-[var(--kraft)] text-[var(--green)] text-xs font-medium rounded-full hover:bg-[var(--green)] hover:text-white transition-all border border-[var(--border)] font-body">
                            <span x-text="copied ? '✓ Tersalin!' : 'Salin Nomor'"></span>
                        </button>
                    </div>
                    @endforeach
                @elseif($invitation->bank_name)
                    {{-- Fallback to old single bank field --}}
                    <div class="rustic-card p-6 mb-4 reveal reveal-delay-1" x-data="{ copied: false }">
                        <p class="text-[10px] uppercase tracking-[0.2em] text-[var(--muted)] mb-2 font-body">{{ $invitation->bank_name }}</p>
                        <p class="text-2xl font-display text-[var(--green)] tracking-wider mb-1">{{ $invitation->bank_account_number }}</p>
                        <p class="text-sm text-[var(--muted)] font-body">a.n. {{ $invitation->bank_account_name }}</p>
                        <button @click="navigator.clipboard.writeText('{{ $invitation->bank_account_number }}'); copied = true; setTimeout(() => copied = false, 2000)" class="mt-4 px-5 py-2 bg-[var(--kraft)] text-[var(--green)] text-xs font-medium rounded-full hover:bg-[var(--green)] hover:text-white transition-all border border-[var(--border)] font-body">
                            <span x-text="copied ? '✓ Tersalin!' : 'Salin Nomor'"></span>
                        </button>
                    </div>
                @endif

                @if($invitation->qris_image)
                <div class="rustic-card p-5 inline-block reveal reveal-delay-2">
                    <img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS" class="w-48 h-48 object-contain mx-auto rounded-lg">
                    <p class="text-[10px] text-[var(--muted)] mt-3 font-body">Scan QRIS</p>
                </div>
                @endif
            </div>
        </section>
        @endif

        <!-- ===================== CLOSING TEXT ===================== -->
        @if($invitation->closing_text)
        <section class="py-20 px-6 bg-[var(--green)] text-center relative overflow-hidden">
            <!-- Leaf pattern overlay -->
            <div class="absolute inset-0 pointer-events-none opacity-[0.05]" style="background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60'%3E%3Cpath d='M30 5 Q32 15 30 25 Q28 15 30 5' fill='none' stroke='white' stroke-width='0.5'/%3E%3Cpath d='M25 15 Q28 18 30 15' fill='none' stroke='white' stroke-width='0.4'/%3E%3Cpath d='M35 15 Q32 18 30 15' fill='none' stroke='white' stroke-width='0.4'/%3E%3C/svg%3E&quot;); background-size: 60px 60px;"></div>

            <div class="max-w-lg mx-auto relative z-10 reveal">
                <div class="divider-botanical mb-8 opacity-50" style="filter: brightness(3);"></div>
                <p class="text-base sm:text-lg text-white/80 leading-loose font-body font-light italic mb-8">"{{ $invitation->closing_text }}"</p>
                <div class="divider-sm mb-6" style="filter: brightness(3); opacity: 0.5;"></div>
                <h4 class="text-4xl font-display text-white">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</h4>
                <div class="divider-botanical mt-8 opacity-50" style="transform: scaleY(-1); filter: brightness(3);"></div>
            </div>
        </section>
        @endif

        <!-- ===================== FOOTER ===================== -->
        <footer class="py-8 px-6 bg-kraft text-center border-t border-[var(--border)]">
            <div class="divider-sm mb-4"></div>
            <p class="text-[10px] text-[var(--muted)] font-body">Made with <span class="text-[var(--accent)]">♥</span> by <a href="{{ url('/') }}" class="text-[var(--green)] hover:underline font-medium">UndanganDigital</a></p>
            <p class="text-[9px] text-[var(--muted)] opacity-50 mt-2 font-body">Rustic Garden Template</p>
        </footer>
    </div>

    <!-- ===================== MUSIC PLAYER ===================== -->
    @if($invitation->music_url)
    <div class="fixed bottom-5 right-5 z-40" x-show="opened" x-transition>
        <button @click="toggleMusic()" class="w-12 h-12 rounded-full shadow-xl flex items-center justify-center transition-all duration-300 hover:scale-110"
            :class="playing ? 'bg-[var(--green)] text-white music-spin' : 'bg-white text-[var(--green)] border border-[var(--border)]'">
            <svg x-show="!playing" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>
            <svg x-show="playing" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M5.75 3a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75A.75.75 0 007.25 3h-1.5zM12.75 3a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75a.75.75 0 00-.75-.75h-1.5z"/></svg>
        </button>
        <audio x-ref="audio" src="{{ asset('storage/' . $invitation->music_url) }}" loop preload="auto"></audio>
    </div>
    @endif

    <!-- ===================== SCRIPTS ===================== -->
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
                this.$nextTick(() => setTimeout(() => this.initReveal(), 200));
            },

            toggleMusic() {
                if (this.playing) {
                    this.$refs.audio?.pause();
                } else {
                    this.$refs.audio?.play();
                }
                this.playing = !this.playing;
            },

            initReveal() {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('active');
                        }
                    });
                }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
                document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
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
                const diff = new Date(targetDate) - new Date();
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
