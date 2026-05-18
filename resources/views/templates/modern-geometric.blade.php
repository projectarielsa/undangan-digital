<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $invitation->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Work+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --navy: {{ $invitation->color_primary ?? '#1B2A4A' }};
            --navy-light: #2D4066;
            --copper: {{ $invitation->color_secondary ?? '#C17F59' }};
            --copper-light: #D4A07A;
            --white: #FFFFFF;
            --bg: #F8F9FC;
            --text: #1B2A4A;
            --muted: #6B7B9E;
            --border: rgba(27,42,74,0.1);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Work Sans', sans-serif; font-weight: 400; color: var(--text); overflow-x: hidden; -webkit-font-smoothing: antialiased; background: var(--bg); }
        .font-display { font-family: 'Bebas Neue', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        [x-cloak] { display: none !important; }

        /* Scroll Reveal */
        .reveal { opacity: 0; transform: translateY(40px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal.active { opacity: 1; transform: translateY(0); }
        .reveal-delay-1 { transition-delay: 0.15s; }
        .reveal-delay-2 { transition-delay: 0.3s; }
        .reveal-delay-3 { transition-delay: 0.45s; }
        .reveal-delay-4 { transition-delay: 0.6s; }

        /* Geometric Decorations */
        .geo-hexagon {
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
        }
        .geo-hex-frame {
            position: relative;
            width: 180px;
            height: 200px;
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
            background: linear-gradient(135deg, var(--copper), var(--copper-light));
            padding: 3px;
        }
        .geo-hex-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
        }
        .geo-hex-frame-inner {
            width: 100%;
            height: 100%;
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
            overflow: hidden;
        }

        /* Diagonal Section */
        .diagonal-top {
            clip-path: polygon(0 6%, 100% 0%, 100% 100%, 0% 100%);
        }
        .diagonal-bottom {
            clip-path: polygon(0 0%, 100% 0%, 100% 94%, 0% 100%);
        }
        .skew-section {
            transform: skewY(-3deg);
        }
        .skew-section > * {
            transform: skewY(3deg);
        }

        /* Geometric Card */
        .geo-card {
            background: var(--white);
            border-left: 4px solid var(--copper);
            border-radius: 0 16px 16px 0;
            box-shadow: 0 4px 24px rgba(27,42,74,0.06), 0 1px 4px rgba(27,42,74,0.04);
            transition: all 0.3s ease;
        }
        .geo-card:hover {
            box-shadow: 0 8px 40px rgba(27,42,74,0.1), 0 2px 8px rgba(27,42,74,0.06);
            transform: translateY(-2px);
        }

        /* Navy Card */
        .navy-card {
            background: var(--navy);
            color: var(--white);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(27,42,74,0.2);
        }

        /* Buttons */
        .btn-copper {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 16px 36px;
            background: linear-gradient(135deg, var(--copper) 0%, var(--copper-light) 100%);
            color: var(--white); font-weight: 600; font-size: 14px;
            border-radius: 4px; border: none; cursor: pointer;
            box-shadow: 0 4px 16px rgba(193,127,89,0.3);
            transition: all 0.4s ease;
            text-decoration: none; text-transform: uppercase; letter-spacing: 0.1em;
            font-family: 'Work Sans', sans-serif;
        }
        .btn-copper:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(193,127,89,0.4); }

        .btn-navy {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 14px 30px;
            background: var(--navy);
            color: var(--white); font-weight: 600; font-size: 13px;
            border-radius: 4px; border: none; cursor: pointer;
            box-shadow: 0 4px 16px rgba(27,42,74,0.2);
            transition: all 0.4s ease;
            text-decoration: none; text-transform: uppercase; letter-spacing: 0.08em;
            font-family: 'Work Sans', sans-serif;
        }
        .btn-navy:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(27,42,74,0.3); background: var(--navy-light); }

        .btn-outline-geo {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 14px 30px;
            border: 2px solid var(--navy);
            color: var(--navy); font-weight: 600; font-size: 13px;
            border-radius: 4px; cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none; background: transparent;
            text-transform: uppercase; letter-spacing: 0.08em;
            font-family: 'Work Sans', sans-serif;
        }
        .btn-outline-geo:hover { background: var(--navy); color: var(--white); }

        /* Input Fields */
        .input-geo {
            width: 100%; padding: 16px 20px;
            background: var(--white);
            border: 2px solid var(--border);
            border-radius: 4px; font-size: 14px; color: var(--text);
            transition: all 0.3s ease;
            font-family: 'Work Sans', sans-serif; font-weight: 400;
        }
        .input-geo:focus { outline: none; border-color: var(--copper); box-shadow: 0 0 0 3px rgba(193,127,89,0.1); }
        .input-geo::placeholder { color: var(--muted); }

        /* Geometric Line Divider */
        .geo-divider {
            display: flex; align-items: center; justify-content: center; gap: 16px; padding: 24px 0;
        }
        .geo-divider::before, .geo-divider::after {
            content: ''; width: 60px; height: 2px;
            background: var(--copper);
            opacity: 0.5;
        }
        .geo-divider .diamond {
            width: 10px; height: 10px;
            background: var(--copper);
            transform: rotate(45deg);
        }
        .geo-divider .triangle {
            width: 0; height: 0;
            border-left: 7px solid transparent;
            border-right: 7px solid transparent;
            border-bottom: 12px solid var(--copper);
        }

        /* Floating Geometric Shapes */
        .geo-shape {
            position: absolute;
            pointer-events: none;
            opacity: 0.08;
        }
        .geo-shape-outline {
            position: absolute;
            pointer-events: none;
            border: 2px solid var(--copper);
            opacity: 0.15;
        }

        /* Animations */
        @keyframes float { 0%, 100% { transform: translateY(0px) rotate(0deg); } 50% { transform: translateY(-12px) rotate(3deg); } }
        @keyframes rotate-slow { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        @keyframes pulse-geo { 0%, 100% { opacity: 0.1; transform: scale(1); } 50% { opacity: 0.2; transform: scale(1.05); } }
        @keyframes slide-diagonal { 0% { transform: translateX(-20px) translateY(20px); opacity: 0; } 100% { transform: translateX(0) translateY(0); opacity: 1; } }

        .float-animation { animation: float 5s ease-in-out infinite; }
        .rotate-slow { animation: rotate-slow 20s linear infinite; }
        .music-spin { animation: rotate-slow 3s linear infinite; }

        /* Geometric Gallery Grid */
        .gallery-geo-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        .gallery-geo-grid .geo-gallery-item:first-child {
            grid-column: span 2;
            aspect-ratio: 16/9;
        }
        .gallery-geo-grid .geo-gallery-item {
            aspect-ratio: 1;
            overflow: hidden;
            position: relative;
            border-radius: 4px;
            border: 2px solid var(--border);
        }
        .gallery-geo-grid .geo-gallery-item img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 0.6s ease;
        }
        .gallery-geo-grid .geo-gallery-item:hover img {
            transform: scale(1.08);
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: var(--bg); }
        ::-webkit-scrollbar-thumb { background: var(--copper); border-radius: 4px; }

        /* Countdown boxes */
        .countdown-box {
            background: var(--navy);
            border-radius: 8px;
            padding: 20px 12px;
            text-align: center;
            box-shadow: 0 4px 16px rgba(27,42,74,0.15);
            position: relative;
            overflow: hidden;
        }
        .countdown-box::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--copper), var(--copper-light));
        }

        /* Copper text */
        .copper-text { color: var(--copper); }
        .navy-text { color: var(--navy); }
    </style>
</head>

<body x-data="invitationApp()" x-cloak>

    <!-- ===================== SECTION 1: OPENING COVER ===================== -->
    <section x-show="!opened" class="fixed inset-0 z-50 flex items-center justify-center overflow-hidden"
        style="background: var(--navy);"
        x-transition:leave="transition ease-in duration-700"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-110">

        <!-- Geometric Background Shapes -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <!-- Large hexagon outline -->
            <div class="geo-shape-outline" style="width:300px; height:300px; top:-50px; right:-80px; clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%); animation: pulse-geo 6s ease-in-out infinite;"></div>
            <!-- Triangle -->
            <div class="geo-shape" style="width:0; height:0; border-left:80px solid transparent; border-right:80px solid transparent; border-bottom:140px solid var(--copper); bottom:10%; left:5%; opacity:0.06;"></div>
            <!-- Small diamonds -->
            <div class="geo-shape-outline" style="width:40px; height:40px; top:20%; left:15%; transform:rotate(45deg); border-color: var(--copper-light); animation: float 4s ease-in-out infinite;"></div>
            <div class="geo-shape-outline" style="width:60px; height:60px; bottom:25%; right:10%; transform:rotate(45deg); opacity:0.1;"></div>
            <!-- Diagonal lines -->
            <div style="position:absolute; top:0; left:0; right:0; bottom:0; pointer-events:none; opacity:0.04; background: repeating-linear-gradient(45deg, transparent, transparent 40px, var(--copper) 40px, var(--copper) 41px);"></div>
            <!-- Large circle outline -->
            <div class="geo-shape-outline" style="width:200px; height:200px; border-radius:50%; bottom:-60px; left:-40px; border-color: rgba(193,127,89,0.2);"></div>
        </div>

        <div class="text-center px-8 relative z-10 max-w-md">
            <!-- Top geometric frame -->
            <div class="flex items-center justify-center gap-3 mb-12">
                <div class="w-16 h-[2px] bg-[var(--copper)] opacity-60"></div>
                <div class="w-3 h-3 bg-[var(--copper)] transform rotate-45"></div>
                <div class="w-16 h-[2px] bg-[var(--copper)] opacity-60"></div>
            </div>

            <p class="text-xs uppercase tracking-[0.5em] text-[var(--copper-light)] mb-8 font-medium" style="font-family: 'Work Sans', sans-serif;">The Wedding Of</p>

            <h1 class="text-5xl sm:text-7xl font-display text-white leading-none tracking-wider mb-2">{{ strtoupper($invitation->groom_name) }}</h1>

            <div class="flex items-center justify-center gap-5 my-5">
                <div class="w-12 h-[2px] bg-[var(--copper)]"></div>
                <span class="text-2xl font-serif italic text-[var(--copper-light)]">&</span>
                <div class="w-12 h-[2px] bg-[var(--copper)]"></div>
            </div>

            <h1 class="text-5xl sm:text-7xl font-display text-white leading-none tracking-wider">{{ strtoupper($invitation->bride_name) }}</h1>

            @if($guestName)
            <div class="mt-12 py-4 px-8 border border-[var(--copper)] border-opacity-30 inline-block" style="border-radius: 2px; background: rgba(193,127,89,0.08);">
                <p class="text-[10px] uppercase tracking-[0.4em] text-[var(--muted)] mb-1" style="color: rgba(255,255,255,0.5);">Kepada Yth.</p>
                <p class="text-base text-white font-medium tracking-wide">{{ urldecode($guestName) }}</p>
            </div>
            @endif

            <!-- Bottom geometric frame -->
            <div class="flex items-center justify-center gap-3 mt-12 mb-10">
                <div class="w-16 h-[2px] bg-[var(--copper)] opacity-60"></div>
                <div class="w-3 h-3 border-2 border-[var(--copper)] transform rotate-45"></div>
                <div class="w-16 h-[2px] bg-[var(--copper)] opacity-60"></div>
            </div>

            <button @click="openInvitation()" class="btn-copper">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Buka Undangan
            </button>

            <p class="text-xs text-white/40 mt-8 tracking-wider font-light">{{ $invitation->event_date->translatedFormat('d F Y') }}</p>
        </div>
    </section>


    <!-- ===================== MAIN CONTENT ===================== -->
    <div x-show="opened" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

        <!-- ===================== SECTION 2: HERO ===================== -->
        <section class="min-h-screen flex items-center justify-center py-28 px-6 relative overflow-hidden" style="background: var(--bg);">
            <!-- Geometric decorations -->
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                <div class="geo-shape-outline" style="width:120px; height:120px; top:10%; right:8%; clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%); border-color: var(--navy); opacity: 0.08; animation: float 6s ease-in-out infinite;"></div>
                <div class="geo-shape-outline" style="width:80px; height:80px; bottom:15%; left:5%; transform: rotate(45deg); border-color: var(--copper); opacity: 0.12;"></div>
                <div class="geo-shape" style="width:200px; height:200px; top:60%; right:-60px; background: var(--navy); clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%); opacity: 0.03;"></div>
                <div style="position:absolute; top:0; left:0; width:100%; height:100%; pointer-events:none; opacity:0.02; background: repeating-linear-gradient(-45deg, transparent, transparent 60px, var(--navy) 60px, var(--navy) 61px);"></div>
            </div>

            <div class="text-center max-w-lg relative z-10 reveal">
                <div class="geo-divider mb-10">
                    <div class="triangle"></div>
                </div>

                <p class="text-xs uppercase tracking-[0.5em] text-[var(--muted)] mb-10 font-medium">We Are Getting Married</p>

                <h2 class="text-6xl sm:text-8xl font-display text-[var(--navy)] leading-none tracking-wider">{{ strtoupper($invitation->groom_name) }}</h2>

                <div class="flex items-center justify-center gap-6 my-6">
                    <div class="w-16 h-[2px] bg-[var(--copper)]"></div>
                    <div class="w-4 h-4 bg-[var(--copper)] transform rotate-45"></div>
                    <div class="w-16 h-[2px] bg-[var(--copper)]"></div>
                </div>

                <h2 class="text-6xl sm:text-8xl font-display text-[var(--navy)] leading-none tracking-wider">{{ strtoupper($invitation->bride_name) }}</h2>

                <div class="mt-12 inline-flex items-center gap-3 px-6 py-3 border-2 border-[var(--navy)] rounded-none">
                    <svg class="w-4 h-4 text-[var(--copper)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span class="text-sm text-[var(--navy)] font-medium tracking-wide">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</span>
                </div>

                <div class="geo-divider mt-12">
                    <div class="diamond"></div>
                </div>
            </div>
        </section>



        <!-- ===================== SECTION 3: OPENING TEXT ===================== -->
        @if($invitation->opening_text)
        <section class="py-24 px-6 relative" style="background: var(--white);">
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                <div class="geo-shape" style="width:150px; height:150px; top:20%; left:-40px; background: var(--copper); clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%); opacity:0.03;"></div>
            </div>
            <div class="max-w-lg mx-auto text-center reveal">
                <div class="geo-divider mb-8">
                    <div class="diamond"></div>
                </div>
                <p class="text-lg sm:text-xl font-serif italic text-[var(--navy)] leading-relaxed">"{{ $invitation->opening_text }}"</p>
                <div class="geo-divider mt-8">
                    <div class="diamond"></div>
                </div>
            </div>
        </section>
        @endif


        <!-- ===================== SECTION 4: COUPLE PROFILES ===================== -->
        <section class="py-28 px-6 relative overflow-hidden" style="background: var(--bg);">
            <!-- Background geometric pattern -->
            <div class="absolute inset-0 pointer-events-none">
                <div style="position:absolute; top:0; left:0; width:100%; height:100%; opacity:0.015; background: repeating-linear-gradient(45deg, transparent, transparent 80px, var(--navy) 80px, var(--navy) 81px);"></div>
            </div>

            <div class="max-w-lg mx-auto relative z-10">
                <div class="text-center mb-16 reveal">
                    <p class="text-xs uppercase tracking-[0.5em] text-[var(--muted)] mb-3 font-medium">The Happy Couple</p>
                    <h3 class="text-4xl sm:text-5xl font-display text-[var(--navy)] tracking-wider">MEMPELAI</h3>
                    <div class="geo-divider">
                        <div class="diamond"></div>
                    </div>
                </div>

                <!-- Groom -->
                <div class="flex flex-col items-center text-center mb-20 reveal reveal-delay-1">
                    @if($invitation->groom_photo)
                    <div class="geo-hex-frame mb-8">
                        <div class="geo-hex-frame-inner">
                            <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}">
                        </div>
                    </div>
                    @else
                    <div class="geo-hex-frame mb-8" style="display:flex; align-items:center; justify-content:center;">
                        <div class="geo-hex-frame-inner" style="display:flex; align-items:center; justify-content:center; background: var(--bg);">
                            <span class="text-5xl font-display text-[var(--navy)]">{{ substr($invitation->groom_name, 0, 1) }}</span>
                        </div>
                    </div>
                    @endif
                    <h4 class="text-3xl font-display text-[var(--navy)] tracking-wider mb-3">{{ strtoupper($invitation->groom_name) }}</h4>
                    @if($invitation->groom_father || $invitation->groom_mother)
                    <p class="text-sm text-[var(--muted)] leading-relaxed">Putra dari<br>
                        <span class="text-[var(--text)] font-medium">Bpk. {{ $invitation->groom_father }}</span> &
                        <span class="text-[var(--text)] font-medium">Ibu {{ $invitation->groom_mother }}</span>
                    </p>
                    @endif
                    @if($invitation->groom_instagram)
                    <a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" target="_blank" class="inline-flex items-center gap-2 mt-4 text-sm text-[var(--copper)] hover:text-[var(--copper-light)] transition-colors font-medium">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        {{ $invitation->groom_instagram }}
                    </a>
                    @endif
                </div>

                <!-- Geometric Divider -->
                <div class="flex items-center justify-center mb-20 reveal reveal-delay-2">
                    <div class="w-4 h-4 bg-[var(--copper)] transform rotate-45"></div>
                </div>

                <!-- Bride -->
                <div class="flex flex-col items-center text-center reveal reveal-delay-3">
                    @if($invitation->bride_photo)
                    <div class="geo-hex-frame mb-8">
                        <div class="geo-hex-frame-inner">
                            <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}">
                        </div>
                    </div>
                    @else
                    <div class="geo-hex-frame mb-8" style="display:flex; align-items:center; justify-content:center;">
                        <div class="geo-hex-frame-inner" style="display:flex; align-items:center; justify-content:center; background: var(--bg);">
                            <span class="text-5xl font-display text-[var(--navy)]">{{ substr($invitation->bride_name, 0, 1) }}</span>
                        </div>
                    </div>
                    @endif
                    <h4 class="text-3xl font-display text-[var(--navy)] tracking-wider mb-3">{{ strtoupper($invitation->bride_name) }}</h4>
                    @if($invitation->bride_father || $invitation->bride_mother)
                    <p class="text-sm text-[var(--muted)] leading-relaxed">Putri dari<br>
                        <span class="text-[var(--text)] font-medium">Bpk. {{ $invitation->bride_father }}</span> &
                        <span class="text-[var(--text)] font-medium">Ibu {{ $invitation->bride_mother }}</span>
                    </p>
                    @endif
                    @if($invitation->bride_instagram)
                    <a href="https://instagram.com/{{ ltrim($invitation->bride_instagram, '@') }}" target="_blank" class="inline-flex items-center gap-2 mt-4 text-sm text-[var(--copper)] hover:text-[var(--copper-light)] transition-colors font-medium">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        {{ $invitation->bride_instagram }}
                    </a>
                    @endif
                </div>
            </div>
        </section>



        <!-- ===================== SECTION 5: COUNTDOWN ===================== -->
        <section class="py-28 px-6 relative overflow-hidden" style="background: var(--white);">
            <div class="absolute inset-0 pointer-events-none">
                <div class="geo-shape-outline" style="width:100px; height:100px; top:15%; right:10%; clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%); border-color: var(--navy); opacity: 0.06;"></div>
                <div class="geo-shape-outline" style="width:50px; height:50px; bottom:20%; left:8%; transform: rotate(45deg); border-color: var(--copper); opacity: 0.1;"></div>
            </div>

            <div class="max-w-md mx-auto text-center relative z-10 reveal" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">
                <p class="text-xs uppercase tracking-[0.5em] text-[var(--muted)] mb-3 font-medium">Save The Date</p>
                <h3 class="text-4xl sm:text-5xl font-display text-[var(--navy)] tracking-wider mb-12">MENGHITUNG HARI</h3>

                <div class="grid grid-cols-4 gap-3 sm:gap-5">
                    <div class="countdown-box">
                        <p class="text-3xl sm:text-4xl font-bold text-[var(--copper)]" x-text="days">0</p>
                        <p class="text-[10px] uppercase tracking-[0.2em] text-white/60 mt-3 font-medium">Hari</p>
                    </div>
                    <div class="countdown-box">
                        <p class="text-3xl sm:text-4xl font-bold text-[var(--copper)]" x-text="hours">0</p>
                        <p class="text-[10px] uppercase tracking-[0.2em] text-white/60 mt-3 font-medium">Jam</p>
                    </div>
                    <div class="countdown-box">
                        <p class="text-3xl sm:text-4xl font-bold text-[var(--copper)]" x-text="minutes">0</p>
                        <p class="text-[10px] uppercase tracking-[0.2em] text-white/60 mt-3 font-medium">Menit</p>
                    </div>
                    <div class="countdown-box">
                        <p class="text-3xl sm:text-4xl font-bold text-[var(--copper)]" x-text="seconds">0</p>
                        <p class="text-[10px] uppercase tracking-[0.2em] text-white/60 mt-3 font-medium">Detik</p>
                    </div>
                </div>
            </div>
        </section>


        <!-- ===================== SECTION 6: EVENT DETAILS ===================== -->
        <section class="py-28 px-6 relative overflow-hidden diagonal-top" style="background: var(--bg); margin-top: -20px; padding-top: 80px;">
            <div class="absolute inset-0 pointer-events-none">
                <div style="position:absolute; top:0; left:0; width:100%; height:100%; opacity:0.02; background: repeating-linear-gradient(-45deg, transparent, transparent 50px, var(--navy) 50px, var(--navy) 51px);"></div>
            </div>

            <div class="max-w-lg mx-auto relative z-10">
                <div class="text-center mb-14 reveal">
                    <p class="text-xs uppercase tracking-[0.5em] text-[var(--muted)] mb-3 font-medium">When & Where</p>
                    <h3 class="text-4xl sm:text-5xl font-display text-[var(--navy)] tracking-wider">ACARA</h3>
                    <div class="geo-divider">
                        <div class="diamond"></div>
                    </div>
                </div>

                <div class="geo-card p-8 sm:p-10 reveal reveal-delay-1">
                    <div class="flex items-start gap-4 mb-6">
                        <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center bg-[var(--navy)] rounded-sm">
                            <svg class="w-5 h-5 text-[var(--copper)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-display text-[var(--navy)] tracking-wider mb-1">{{ strtoupper($invitation->event_venue) }}</h4>
                            <p class="text-sm text-[var(--muted)]">{{ $invitation->event_address }}</p>
                        </div>
                    </div>

                    <div class="border-t-2 border-[var(--border)] pt-6 mb-6">
                        <div class="flex items-center gap-4 mb-3">
                            <div class="w-10 h-10 flex-shrink-0 flex items-center justify-center border-2 border-[var(--copper)] rounded-sm">
                                <svg class="w-4 h-4 text-[var(--copper)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-[var(--navy)]">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                                <p class="text-sm text-[var(--muted)]">Pukul {{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }} {{ $invitation->event_time_end ? '- ' . \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') : '' }} WIB</p>
                            </div>
                        </div>
                    </div>

                    @if($invitation->dress_code)
                    <div class="border-t-2 border-[var(--border)] pt-6 mb-6">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-[var(--copper)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            <span class="text-sm text-[var(--text)]">Dress Code: <strong class="text-[var(--copper)]">{{ $invitation->dress_code }}</strong></span>
                        </div>
                    </div>
                    @endif

                    @if($invitation->event_maps_url)
                    <a href="{{ $invitation->event_maps_url }}" target="_blank" class="btn-navy w-full justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        Buka Google Maps
                    </a>
                    @endif
                </div>
            </div>
        </section>



        <!-- ===================== SECTION 7: GALLERY ===================== -->
        @if($invitation->galleries->count() > 0)
        <section class="py-28 px-6 relative" style="background: var(--white);">
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                <div class="geo-shape-outline" style="width:140px; height:140px; top:5%; left:-30px; clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%); border-color: var(--copper); opacity: 0.06;"></div>
                <div class="geo-shape-outline" style="width:70px; height:70px; bottom:10%; right:5%; transform: rotate(45deg); border-color: var(--navy); opacity: 0.06;"></div>
            </div>

            <div class="max-w-lg mx-auto relative z-10">
                <div class="text-center mb-14 reveal">
                    <p class="text-xs uppercase tracking-[0.5em] text-[var(--muted)] mb-3 font-medium">Our Moments</p>
                    <h3 class="text-4xl sm:text-5xl font-display text-[var(--navy)] tracking-wider">GALERI</h3>
                    <div class="geo-divider">
                        <div class="diamond"></div>
                    </div>
                </div>

                <div class="gallery-geo-grid reveal reveal-delay-1">
                    @foreach($invitation->galleries as $i => $photo)
                    <div class="geo-gallery-item group">
                        <img src="{{ $photo->getImageUrl() }}" alt="{{ $photo->caption ?? 'Gallery' }}" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-[var(--navy)]/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <!-- Geometric corner accents on hover -->
                        <div class="absolute top-2 left-2 w-6 h-6 border-t-2 border-l-2 border-[var(--copper)] opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="absolute bottom-2 right-2 w-6 h-6 border-b-2 border-r-2 border-[var(--copper)] opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif


        <!-- ===================== SECTION 8: RSVP ===================== -->
        <section class="py-28 px-6 relative overflow-hidden" style="background: var(--navy);">
            <!-- Geometric background -->
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                <div style="position:absolute; top:0; left:0; width:100%; height:100%; opacity:0.04; background: repeating-linear-gradient(45deg, transparent, transparent 40px, var(--copper) 40px, var(--copper) 41px);"></div>
                <div class="geo-shape-outline" style="width:180px; height:180px; top:-40px; right:-40px; clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%); border-color: var(--copper); opacity: 0.1;"></div>
                <div class="geo-shape-outline" style="width:100px; height:100px; bottom:10%; left:5%; transform:rotate(45deg); border-color: rgba(255,255,255,0.08);"></div>
            </div>

            <div class="max-w-sm mx-auto relative z-10">
                <div class="text-center mb-12 reveal">
                    <p class="text-xs uppercase tracking-[0.5em] text-[var(--copper-light)] mb-3 font-medium">Attendance</p>
                    <h3 class="text-4xl sm:text-5xl font-display text-white tracking-wider">RSVP</h3>
                    <p class="text-sm text-white/50 mt-4">Konfirmasi kehadiran Anda</p>
                    <div class="flex items-center justify-center gap-3 mt-6">
                        <div class="w-12 h-[2px] bg-[var(--copper)] opacity-50"></div>
                        <div class="w-3 h-3 bg-[var(--copper)] transform rotate-45"></div>
                        <div class="w-12 h-[2px] bg-[var(--copper)] opacity-50"></div>
                    </div>
                </div>

                @if(session('success'))
                <div class="mb-6 p-4 border-l-4 border-green-400 bg-green-400/10 text-green-300 text-sm rounded-r-md">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" class="space-y-5 reveal reveal-delay-1">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Lengkap" required class="input-geo" style="background: rgba(255,255,255,0.05); border-color: rgba(193,127,89,0.3); color: white;">
                    <select name="rsvp_status" required class="input-geo" style="background: rgba(255,255,255,0.05); border-color: rgba(193,127,89,0.3); color: white;">
                        <option value="" style="background: var(--navy);">-- Konfirmasi Kehadiran --</option>
                        <option value="attending" style="background: var(--navy);">Ya, Saya Akan Hadir</option>
                        <option value="not_attending" style="background: var(--navy);">Maaf, Tidak Bisa Hadir</option>
                        <option value="maybe" style="background: var(--navy);">Masih Belum Pasti</option>
                    </select>
                    <input type="number" name="number_of_guests" min="1" max="10" value="1" placeholder="Jumlah Tamu" class="input-geo" style="background: rgba(255,255,255,0.05); border-color: rgba(193,127,89,0.3); color: white;">
                    <button type="submit" class="btn-copper w-full justify-center">Kirim Konfirmasi</button>
                </form>
            </div>
        </section>



        <!-- ===================== SECTION 9: GUESTBOOK ===================== -->
        <section class="py-28 px-6 relative" style="background: var(--bg);">
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                <div class="geo-shape" style="width:120px; height:120px; top:10%; right:-30px; background: var(--copper); clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%); opacity:0.03;"></div>
            </div>

            <div class="max-w-md mx-auto relative z-10">
                <div class="text-center mb-12 reveal">
                    <p class="text-xs uppercase tracking-[0.5em] text-[var(--muted)] mb-3 font-medium">Wishes</p>
                    <h3 class="text-4xl sm:text-5xl font-display text-[var(--navy)] tracking-wider">UCAPAN & DOA</h3>
                    <div class="geo-divider">
                        <div class="diamond"></div>
                    </div>
                </div>

                <form method="POST" action="{{ route('invitation.guestbook', $invitation->slug) }}" class="space-y-5 mb-14 reveal reveal-delay-1">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Anda" required class="input-geo">
                    <textarea name="message" rows="4" placeholder="Tulis ucapan & doa terbaik Anda..." required class="input-geo" style="resize: none;"></textarea>
                    <button type="submit" class="btn-outline-geo w-full justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        Kirim Ucapan
                    </button>
                </form>

                <!-- Messages list -->
                <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2 reveal reveal-delay-2">
                    @foreach($invitation->guestbooks as $msg)
                    <div class="geo-card p-5">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 flex-shrink-0 flex items-center justify-center bg-[var(--navy)] rounded-sm">
                                <span class="text-xs font-bold text-[var(--copper)]">{{ strtoupper(substr($msg->name, 0, 1)) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-[var(--navy)]">{{ $msg->name }}</p>
                                <p class="text-sm text-[var(--muted)] mt-1.5 leading-relaxed">{{ $msg->message }}</p>
                                <p class="text-[10px] text-[var(--muted)] mt-2 opacity-60">{{ $msg->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>


        <!-- ===================== SECTION 10: DIGITAL ENVELOPE ===================== -->
        @if($invitation->bank_name || $invitation->qris_image)
        <section class="py-28 px-6 relative overflow-hidden" style="background: var(--white);">
            <div class="absolute inset-0 pointer-events-none">
                <div style="position:absolute; top:0; left:0; width:100%; height:100%; opacity:0.015; background: repeating-linear-gradient(45deg, transparent, transparent 60px, var(--copper) 60px, var(--copper) 61px);"></div>
                <div class="geo-shape-outline" style="width:160px; height:160px; bottom:-40px; left:-40px; clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%); border-color: var(--navy); opacity: 0.05;"></div>
            </div>

            <div class="max-w-sm mx-auto text-center relative z-10">
                <div class="reveal">
                    <div class="w-14 h-14 mx-auto mb-6 flex items-center justify-center bg-[var(--navy)] rounded-sm">
                        <svg class="w-6 h-6 text-[var(--copper)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-xs uppercase tracking-[0.5em] text-[var(--muted)] mb-3 font-medium">Wedding Gift</p>
                    <h3 class="text-4xl sm:text-5xl font-display text-[var(--navy)] tracking-wider mb-4">AMPLOP DIGITAL</h3>
                    @if($invitation->gift_info)
                    <p class="text-sm text-[var(--muted)] mb-10 leading-relaxed">{{ $invitation->gift_info }}</p>
                    @else
                    <p class="text-sm text-[var(--muted)] mb-10">Doa restu Anda sudah cukup. Namun jika berkenan memberi tanda kasih:</p>
                    @endif
                </div>

                @if($invitation->bank_name)
                <div class="geo-card p-7 mb-6 text-center reveal reveal-delay-1" x-data="{ copied: false }">
                    <p class="text-xs uppercase tracking-[0.3em] text-[var(--muted)] mb-3 font-medium">{{ $invitation->bank_name }}</p>
                    <p class="text-2xl font-bold text-[var(--navy)] tracking-wider mb-2 font-display">{{ $invitation->bank_account_number }}</p>
                    <p class="text-sm text-[var(--muted)]">a.n. {{ $invitation->bank_account_name }}</p>
                    <button @click="navigator.clipboard.writeText('{{ $invitation->bank_account_number }}'); copied = true; setTimeout(() => copied = false, 2000)" class="mt-5 px-6 py-2.5 text-xs font-semibold uppercase tracking-wider border-2 border-[var(--copper)] text-[var(--copper)] hover:bg-[var(--copper)] hover:text-white transition-all duration-300 rounded-sm">
                        <span x-text="copied ? '✓ Tersalin!' : 'Salin Nomor'"></span>
                    </button>
                </div>
                @endif

                @if($invitation->qris_image)
                <div class="geo-card p-6 inline-block reveal reveal-delay-2">
                    <div class="bg-white rounded-md p-3 border border-[var(--border)]">
                        <img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS" class="w-44 h-44 object-contain mx-auto">
                    </div>
                    <p class="text-xs text-[var(--muted)] mt-4 tracking-wider uppercase font-medium">Scan QRIS</p>
                </div>
                @endif
            </div>
        </section>
        @endif



        <!-- ===================== SECTION 11: CLOSING TEXT ===================== -->
        @if($invitation->closing_text)
        <section class="py-28 px-6 relative overflow-hidden diagonal-bottom" style="background: var(--navy);">
            <!-- Geometric background -->
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                <div style="position:absolute; top:0; left:0; width:100%; height:100%; opacity:0.03; background: repeating-linear-gradient(-45deg, transparent, transparent 50px, var(--copper) 50px, var(--copper) 51px);"></div>
                <div class="geo-shape-outline" style="width:200px; height:200px; top:10%; right:-60px; clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%); border-color: var(--copper); opacity: 0.08;"></div>
                <div class="geo-shape-outline" style="width:80px; height:80px; bottom:20%; left:5%; transform: rotate(45deg); border-color: rgba(255,255,255,0.06);"></div>
            </div>

            <div class="max-w-lg mx-auto text-center relative z-10 reveal">
                <div class="flex items-center justify-center gap-3 mb-10">
                    <div class="w-16 h-[2px] bg-[var(--copper)] opacity-50"></div>
                    <div class="w-3 h-3 bg-[var(--copper)] transform rotate-45"></div>
                    <div class="w-16 h-[2px] bg-[var(--copper)] opacity-50"></div>
                </div>

                <p class="text-lg sm:text-xl font-serif italic text-white/90 leading-relaxed mb-10">"{{ $invitation->closing_text }}"</p>

                <div class="flex items-center justify-center gap-3 mb-8">
                    <div class="w-12 h-[2px] bg-[var(--copper)] opacity-50"></div>
                    <div class="w-2 h-2 border border-[var(--copper)] transform rotate-45"></div>
                    <div class="w-12 h-[2px] bg-[var(--copper)] opacity-50"></div>
                </div>

                <h4 class="text-3xl sm:text-4xl font-display text-white tracking-wider">{{ strtoupper($invitation->groom_name) }} & {{ strtoupper($invitation->bride_name) }}</h4>

                <div class="flex items-center justify-center gap-3 mt-10">
                    <div class="w-16 h-[2px] bg-[var(--copper)] opacity-50"></div>
                    <div class="w-3 h-3 border-2 border-[var(--copper)] transform rotate-45"></div>
                    <div class="w-16 h-[2px] bg-[var(--copper)] opacity-50"></div>
                </div>
            </div>
        </section>
        @endif


        <!-- ===================== SECTION 12: FOOTER ===================== -->
        <footer class="py-12 px-6 text-center relative" style="background: var(--bg); border-top: 2px solid var(--border);">
            <div class="flex items-center justify-center gap-3 mb-6">
                <div class="w-8 h-[2px] bg-[var(--copper)] opacity-40"></div>
                <div class="w-2 h-2 bg-[var(--copper)] transform rotate-45 opacity-60"></div>
                <div class="w-8 h-[2px] bg-[var(--copper)] opacity-40"></div>
            </div>
            <p class="text-xs text-[var(--muted)] tracking-wider">Made with love by <a href="{{ url('/') }}" class="text-[var(--copper)] hover:text-[var(--copper-light)] transition-colors font-semibold">UndanganDigital</a></p>
            <p class="text-[10px] text-[var(--muted)] mt-2 opacity-50">Modern Geometric Template</p>
        </footer>
    </div>


    <!-- ===================== SECTION 13: MUSIC PLAYER ===================== -->
    @if($invitation->music_url)
    <div class="fixed bottom-6 right-6 z-40" x-show="opened" x-transition>
        <button @click="toggleMusic()" class="w-12 h-12 shadow-2xl flex items-center justify-center transition-all duration-300 hover:scale-110"
            :class="playing ? 'bg-[var(--copper)] text-white music-spin' : 'bg-[var(--navy)] text-[var(--copper)]'"
            style="clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%); box-shadow: 0 4px 20px rgba(27,42,74,0.3);">
            <svg x-show="!playing" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>
            <svg x-show="playing" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5.75 3a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75A.75.75 0 007.25 3h-1.5zM12.75 3a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75a.75.75 0 00-.75-.75h-1.5z"/></svg>
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
                }, { threshold: 0.12, rootMargin: '0px 0px -50px 0px' });
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
                }
            }
        };
    }
    </script>
</body>
</html>
