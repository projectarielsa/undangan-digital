<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <meta name="description" content="Wedding Invitation - {{ $invitation->groom_name }} & {{ $invitation->bride_name }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Quicksand:wght@300;400;500;600;700&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --rose: {{ $invitation->color_primary ?? '#9E4B5E' }};
            --rose-light: {{ $invitation->color_secondary ?? '#C06B7E' }};
            --blush: #FFF0F3;
            --cream: #FFFAF5;
            --peach: #FDDECF;
            --sage: #8FA68E;
            --text: #4A3C3C;
            --muted: #9B8585;
            --border: rgba(158,75,94,0.12);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Quicksand', sans-serif;
            font-weight: 400;
            color: var(--text);
            background: var(--cream);
            overflow: hidden;
            -webkit-font-smoothing: antialiased;
        }
        .font-script { font-family: 'Great Vibes', cursive; }
        .font-display { font-family: 'Libre Baskerville', serif; }
        .font-body { font-family: 'Quicksand', sans-serif; }
        [x-cloak] { display: none !important; }

        /* Watercolor Background Blobs */
        .watercolor-bg {
            position: fixed;
            inset: 0;
            z-index: -1;
            overflow: hidden;
            pointer-events: none;
        }
        .watercolor-bg::before {
            content: '';
            position: absolute;
            top: -20%;
            right: -10%;
            width: 60%;
            height: 60%;
            background: radial-gradient(ellipse, rgba(253,222,207,0.4) 0%, transparent 70%);
            border-radius: 50%;
            animation: floatBlob 20s ease-in-out infinite;
        }
        .watercolor-bg::after {
            content: '';
            position: absolute;
            bottom: -15%;
            left: -10%;
            width: 50%;
            height: 50%;
            background: radial-gradient(ellipse, rgba(143,166,142,0.2) 0%, transparent 70%);
            border-radius: 50%;
            animation: floatBlob 25s ease-in-out infinite reverse;
        }

        /* SVG Floral Corners */
        .floral-corner {
            position: absolute;
            width: 200px;
            height: 200px;
            pointer-events: none;
            opacity: 0.22;
            z-index: 1;
        }
        .floral-corner--tl { top: 0; left: 0; }
        .floral-corner--br { bottom: 0; right: 0; transform: rotate(180deg); }

        /* Card Styles */
        .inv-card {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(158,75,94,0.08);
            border: 1px solid var(--border);
            padding: 2.5rem 2rem;
            position: relative;
            overflow: hidden;
        }

        /* Petal Divider */
        .petal-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin: 2rem 0;
        }
        .petal-divider::before,
        .petal-divider::after {
            content: '';
            flex: 1;
            max-width: 80px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--rose), transparent);
            opacity: 0.35;
        }

        /* Photo Styles */
        .couple-photo {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: 0 8px 24px rgba(158,75,94,0.12);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }
        .couple-photo:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 36px rgba(158,75,94,0.18);
        }

        /* Button Styles */
        .btn-rose {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 32px;
            background: var(--rose);
            color: white;
            border: none;
            border-radius: 9999px;
            font-family: 'Quicksand', sans-serif;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            box-shadow: 0 4px 16px rgba(158,75,94,0.2);
        }
        .btn-rose:hover {
            background: var(--rose-light);
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(158,75,94,0.3);
        }
        .btn-rose-outline {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 28px;
            background: transparent;
            color: var(--rose);
            border: 2px solid var(--rose);
            border-radius: 9999px;
            font-family: 'Quicksand', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .btn-rose-outline:hover {
            background: var(--rose);
            color: white;
            box-shadow: 0 4px 16px rgba(158,75,94,0.2);
        }

        /* Form Inputs */
        .form-input {
            width: 100%;
            padding: 14px 20px;
            background: var(--blush);
            border: 1.5px solid var(--border);
            border-radius: 16px;
            font-family: 'Quicksand', sans-serif;
            font-size: 0.95rem;
            color: var(--text);
            transition: all 0.3s ease;
            outline: none;
        }
        .form-input:focus {
            border-color: var(--rose-light);
            box-shadow: 0 0 0 4px rgba(158,75,94,0.08);
            background: white;
        }
        .form-input::placeholder { color: var(--muted); }
        textarea.form-input { resize: vertical; min-height: 100px; }

        /* Scroll Reveal */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Gallery Grid */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        .gallery-grid .gallery-item:first-child {
            grid-column: span 2;
        }
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 20px;
            box-shadow: 0 4px 16px rgba(158,75,94,0.08);
            transition: transform 0.4s ease;
        }
        .gallery-item:hover img {
            transform: scale(1.02);
        }
        .gallery-item:first-child img { min-height: 280px; }
        .gallery-item:not(:first-child) img { height: 200px; }

        /* Countdown Cards */
        .countdown-card {
            background: white;
            border-radius: 16px;
            padding: 16px 12px;
            text-align: center;
            box-shadow: 0 4px 16px rgba(158,75,94,0.06);
            border: 1px solid var(--border);
            min-width: 72px;
        }
        .countdown-card .number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--rose);
            line-height: 1;
        }
        .countdown-card .label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--muted);
            margin-top: 4px;
        }

        /* Animations */
        @keyframes floatBlob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -20px) scale(1.05); }
            66% { transform: translate(-20px, 20px) scale(0.95); }
        }
        @keyframes floatPetal {
            0% { transform: translateY(-10vh) rotate(0deg) translateX(0); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(105vh) rotate(360deg) translateX(30px); opacity: 0; }
        }
        @keyframes softPulse {
            0%, 100% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.1); opacity: 1; }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            15% { transform: scale(1.15); }
            30% { transform: scale(1); }
            45% { transform: scale(1.1); }
        }

        .animate-fade-in-up { animation: fadeInUp 1s ease forwards; }
        .animate-float-petal { animation: floatPetal linear infinite; }
        .animate-pulse-soft { animation: softPulse 3s ease-in-out infinite; }
        .animate-heartbeat { animation: heartbeat 2s ease-in-out infinite; }

        /* Music Player */
        .music-btn {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: var(--rose);
            color: white;
            border: none;
            cursor: pointer;
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 20px rgba(158,75,94,0.3);
            transition: all 0.3s ease;
        }
        .music-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 28px rgba(158,75,94,0.4);
        }
        .music-btn.playing { animation: softPulse 2s ease-in-out infinite; }

        /* Cover Styles */
        .cover-section {
            position: fixed;
            inset: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--cream) 0%, var(--blush) 50%, var(--peach) 100%);
        }

        /* Floating Petals on Cover */
        .floating-petal {
            position: absolute;
            pointer-events: none;
            opacity: 0;
        }

        /* Guestbook Messages */
        .guestbook-msg {
            background: var(--blush);
            border-radius: 16px;
            padding: 16px 20px;
            border-left: 3px solid var(--rose);
            margin-bottom: 12px;
        }
        .guestbook-msg .msg-name {
            font-weight: 600;
            color: var(--rose);
            font-size: 0.85rem;
        }
        .guestbook-msg .msg-text {
            color: var(--text);
            font-size: 0.9rem;
            margin-top: 4px;
            line-height: 1.5;
        }
        .guestbook-msg .msg-date {
            font-size: 0.75rem;
            color: var(--muted);
            margin-top: 6px;
        }

        /* Section Spacing */
        .section-wrapper {
            max-width: 480px;
            margin: 0 auto;
            padding: 3rem 1.25rem;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .inv-card { padding: 2rem 1.5rem; }
            .couple-photo { width: 130px; height: 130px; }
            .floral-corner { width: 140px; height: 140px; }
            .countdown-card .number { font-size: 1.6rem; }
            .gallery-item:first-child img { min-height: 200px; }
            .gallery-item:not(:first-child) img { height: 160px; }
        }
    </style>
</head>
<body x-data="invitationApp()" x-cloak>
    <!-- Watercolor Background -->
    <div class="watercolor-bg"></div>

    <!-- Audio Player -->
    @if($invitation->music_url)
    <audio id="bgMusic" loop preload="auto">
        <source src="{{ $invitation->music_url }}" type="audio/mpeg">
    </audio>
    @endif


    <!-- ═══════════════════════════════════════════════════════════════════
         SECTION 1: OPENING COVER
    ═══════════════════════════════════════════════════════════════════ -->
    <section x-show="!opened" x-transition:leave="transition ease-in duration-500"
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="cover-section">
        <!-- Floating Petals -->
        <template x-for="i in 12" :key="i">
            <div class="floating-petal" :style="`left: ${Math.random()*90}%; animation-duration: ${6+Math.random()*8}s; animation-delay: ${Math.random()*5}s;`">
                <svg :width="12 + Math.random()*10" :height="16 + Math.random()*10" viewBox="0 0 20 24" fill="none">
                    <path d="M10 0C10 0 20 8 18 16C16 24 4 24 2 16C0 8 10 0 10 0Z" :fill="i % 3 === 0 ? 'rgba(158,75,94,0.3)' : (i % 3 === 1 ? 'rgba(253,222,207,0.5)' : 'rgba(143,166,142,0.3)')"/>
                </svg>
            </div>
        </template>

        <!-- SVG Floral Corner Top-Left -->
        <div class="floral-corner floral-corner--tl">
            <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 5C20 30 15 60 30 80C15 95 5 70 5 5Z" fill="rgba(143,166,142,0.3)"/>
                <path d="M10 10C30 20 25 50 40 65" stroke="rgba(143,166,142,0.5)" stroke-width="1"/>
                <path d="M20 5C35 25 50 30 55 50C40 55 30 40 20 5Z" fill="rgba(143,166,142,0.2)"/>
                <circle cx="50" cy="55" r="12" fill="rgba(158,75,94,0.2)"/>
                <circle cx="50" cy="55" r="7" fill="rgba(158,75,94,0.3)"/>
                <circle cx="50" cy="55" r="3" fill="rgba(158,75,94,0.5)"/>
                <path d="M35 35C42 28 58 28 65 35C72 42 72 58 65 65" stroke="rgba(158,75,94,0.2)" stroke-width="0.8"/>
                <path d="M30 70C35 80 45 85 55 82" stroke="rgba(143,166,142,0.4)" stroke-width="0.8"/>
                <path d="M60 30C70 35 75 45 72 55" stroke="rgba(143,166,142,0.4)" stroke-width="0.8"/>
                <circle cx="32" cy="42" r="4" fill="rgba(253,222,207,0.5)"/>
                <circle cx="68" cy="48" r="3" fill="rgba(253,222,207,0.4)"/>
            </svg>
        </div>

        <!-- SVG Floral Corner Bottom-Right -->
        <div class="floral-corner floral-corner--br">
            <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 5C20 30 15 60 30 80C15 95 5 70 5 5Z" fill="rgba(143,166,142,0.3)"/>
                <path d="M10 10C30 20 25 50 40 65" stroke="rgba(143,166,142,0.5)" stroke-width="1"/>
                <path d="M20 5C35 25 50 30 55 50C40 55 30 40 20 5Z" fill="rgba(143,166,142,0.2)"/>
                <circle cx="50" cy="55" r="12" fill="rgba(158,75,94,0.2)"/>
                <circle cx="50" cy="55" r="7" fill="rgba(158,75,94,0.3)"/>
                <circle cx="50" cy="55" r="3" fill="rgba(158,75,94,0.5)"/>
                <path d="M35 35C42 28 58 28 65 35C72 42 72 58 65 65" stroke="rgba(158,75,94,0.2)" stroke-width="0.8"/>
                <path d="M30 70C35 80 45 85 55 82" stroke="rgba(143,166,142,0.4)" stroke-width="0.8"/>
                <path d="M60 30C70 35 75 45 72 55" stroke="rgba(143,166,142,0.4)" stroke-width="0.8"/>
                <circle cx="32" cy="42" r="4" fill="rgba(253,222,207,0.5)"/>
                <circle cx="68" cy="48" r="3" fill="rgba(253,222,207,0.4)"/>
            </svg>
        </div>

        <!-- Cover Content -->
        <div class="text-center px-6" style="animation: fadeInUp 1.2s ease forwards;">
            <p class="font-body text-sm tracking-widest uppercase" style="color: var(--muted); letter-spacing: 3px;">The Wedding of</p>
            <h1 class="font-script mt-4" style="font-size: 3.5rem; color: var(--rose); line-height: 1.1;">
                {{ $invitation->groom_name }}<br>
                <span style="font-size: 1.8rem; color: var(--muted);">&amp;</span><br>
                {{ $invitation->bride_name }}
            </h1>
            <div class="petal-divider mt-6 mb-6">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M12 4C12 4 6 9 6 13C6 17 12 20 12 20C12 20 18 17 18 13C18 9 12 4 12 4Z" fill="var(--rose)" opacity="0.6"/>
                </svg>
            </div>

            @if($guestName)
            <p class="font-body text-sm" style="color: var(--muted);">Kepada Yth.</p>
            <p class="font-display mt-1" style="font-size: 1.2rem; color: var(--text); font-weight: 700;">{{ $guestName }}</p>
            @endif

            <button @click="openInvitation()" class="btn-rose mt-8">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Buka Undangan
            </button>
        </div>
    </section>


    <!-- ═══════════════════════════════════════════════════════════════════
         SECTION 2: HERO
    ═══════════════════════════════════════════════════════════════════ -->
    <main x-show="opened" x-transition:enter="transition ease-out duration-700"
          x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

    <section class="section-wrapper" style="padding-top: 4rem; padding-bottom: 2rem;">
        <div class="inv-card text-center reveal" style="background: linear-gradient(180deg, rgba(255,240,243,0.6) 0%, rgba(255,250,245,0.8) 100%);">
            <!-- Floral Corner Accents -->
            <div class="floral-corner floral-corner--tl" style="width: 120px; height: 120px; opacity: 0.15;">
                <svg viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 5C15 25 10 45 25 55C10 65 5 45 5 5Z" fill="rgba(143,166,142,0.4)"/>
                    <circle cx="30" cy="35" r="8" fill="rgba(158,75,94,0.2)"/>
                    <circle cx="30" cy="35" r="4" fill="rgba(158,75,94,0.4)"/>
                    <path d="M15 15C25 10 35 15 38 25" stroke="rgba(143,166,142,0.5)" stroke-width="0.8"/>
                </svg>
            </div>
            <div class="floral-corner floral-corner--br" style="width: 120px; height: 120px; opacity: 0.15;">
                <svg viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 5C15 25 10 45 25 55C10 65 5 45 5 5Z" fill="rgba(143,166,142,0.4)"/>
                    <circle cx="30" cy="35" r="8" fill="rgba(158,75,94,0.2)"/>
                    <circle cx="30" cy="35" r="4" fill="rgba(158,75,94,0.4)"/>
                    <path d="M15 15C25 10 35 15 38 25" stroke="rgba(143,166,142,0.5)" stroke-width="0.8"/>
                </svg>
            </div>

            <p class="font-body text-xs tracking-widest uppercase" style="color: var(--muted); letter-spacing: 4px;">We Are Getting Married</p>
            <h2 class="font-script mt-4" style="font-size: 3.2rem; color: var(--rose); line-height: 1.15;">
                {{ $invitation->groom_name }}
            </h2>
            <div class="flex justify-center my-3">
                <svg width="32" height="32" viewBox="0 0 24 24" class="animate-heartbeat">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="var(--rose)" opacity="0.7"/>
                </svg>
            </div>
            <h2 class="font-script" style="font-size: 3.2rem; color: var(--rose); line-height: 1.15;">
                {{ $invitation->bride_name }}
            </h2>
            <p class="font-display mt-5" style="font-size: 0.9rem; color: var(--muted); font-style: italic;">
                {{ $invitation->event_date->translatedFormat('l, d F Y') }}
            </p>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════════════
         SECTION 3: OPENING TEXT
    ═══════════════════════════════════════════════════════════════════ -->
    <section class="section-wrapper" style="padding-top: 1rem; padding-bottom: 1rem;">
        <div class="text-center reveal">
            <div class="petal-divider">
                <svg width="16" height="16" viewBox="0 0 20 24" fill="none">
                    <path d="M10 0C10 0 20 8 18 16C16 24 4 24 2 16C0 8 10 0 10 0Z" fill="var(--sage)" opacity="0.5"/>
                </svg>
            </div>
            <p class="font-display mt-4" style="font-style: italic; font-size: 1rem; line-height: 1.9; color: var(--text); max-width: 380px; margin-left: auto; margin-right: auto;">
                {!! nl2br(e($invitation->opening_text ?? 'Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu pasangan hidup dari jenismu sendiri, supaya kamu mendapat ketenangan hati, dan dijadikan-Nya di antaramu rasa kasih dan sayang.')) !!}
            </p>
            <p class="font-body mt-3 text-sm" style="color: var(--muted);">— QS. Ar-Rum: 21</p>
        </div>
    </section>


    <!-- ═══════════════════════════════════════════════════════════════════
         SECTION 4: COUPLE PROFILES
    ═══════════════════════════════════════════════════════════════════ -->
    <section class="section-wrapper" style="padding-top: 2rem;">
        <div class="text-center reveal">
            <p class="font-script" style="font-size: 2rem; color: var(--rose);">Mempelai</p>
        </div>

        <!-- Groom -->
        <div class="inv-card mt-8 text-center reveal">
            <div class="flex justify-center mb-4">
                @if($invitation->groom_photo)
                <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}" class="couple-photo">
                @else
                <div class="couple-photo flex items-center justify-center" style="background: var(--blush);">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--rose)" stroke-width="1.5">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2M12 11a4 4 0 100-8 4 4 0 000 8z"/>
                    </svg>
                </div>
                @endif
            </div>
            <h3 class="font-script" style="font-size: 2.2rem; color: var(--rose);">{{ $invitation->groom_name }}</h3>
            <p class="font-body text-sm mt-2" style="color: var(--muted);">
                Putra dari Bapak {{ $invitation->groom_father ?? '-' }}<br>
                &amp; Ibu {{ $invitation->groom_mother ?? '-' }}
            </p>
            @if($invitation->groom_instagram)
            <a href="https://instagram.com/{{ $invitation->groom_instagram }}" target="_blank" class="inline-flex items-center gap-1 mt-3" style="color: var(--rose); font-size: 0.85rem; text-decoration: none;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                </svg>
                {{ '@' . $invitation->groom_instagram }}
            </a>
            @endif
        </div>

        <!-- Divider Heart -->
        <div class="flex justify-center my-6">
            <svg width="28" height="28" viewBox="0 0 24 24" class="animate-heartbeat">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="var(--rose)" opacity="0.5"/>
            </svg>
        </div>

        <!-- Bride -->
        <div class="inv-card text-center reveal">
            <div class="flex justify-center mb-4">
                @if($invitation->bride_photo)
                <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}" class="couple-photo">
                @else
                <div class="couple-photo flex items-center justify-center" style="background: var(--blush);">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--rose)" stroke-width="1.5">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2M12 11a4 4 0 100-8 4 4 0 000 8z"/>
                    </svg>
                </div>
                @endif
            </div>
            <h3 class="font-script" style="font-size: 2.2rem; color: var(--rose);">{{ $invitation->bride_name }}</h3>
            <p class="font-body text-sm mt-2" style="color: var(--muted);">
                Putri dari Bapak {{ $invitation->bride_father ?? '-' }}<br>
                &amp; Ibu {{ $invitation->bride_mother ?? '-' }}
            </p>
            @if($invitation->bride_instagram)
            <a href="https://instagram.com/{{ $invitation->bride_instagram }}" target="_blank" class="inline-flex items-center gap-1 mt-3" style="color: var(--rose); font-size: 0.85rem; text-decoration: none;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                </svg>
                {{ '@' . $invitation->bride_instagram }}
            </a>
            @endif
        </div>
    </section>


    <!-- ═══════════════════════════════════════════════════════════════════
         SECTION 5: COUNTDOWN TIMER
    ═══════════════════════════════════════════════════════════════════ -->
    <section class="section-wrapper" style="padding-top: 2rem; padding-bottom: 2rem;">
        <div class="text-center reveal" x-data="countdown('{{ $invitation->event_date->toIso8601String() }}')">
            <p class="font-script" style="font-size: 2rem; color: var(--rose);">Menghitung Hari</p>
            <p class="font-body text-sm mt-2" style="color: var(--muted);">Menuju hari bahagia kami</p>

            <div class="flex justify-center gap-3 mt-6">
                <div class="countdown-card">
                    <div class="number" x-text="days">0</div>
                    <div class="label">Hari</div>
                </div>
                <div class="countdown-card">
                    <div class="number" x-text="hours">0</div>
                    <div class="label">Jam</div>
                </div>
                <div class="countdown-card">
                    <div class="number" x-text="minutes">0</div>
                    <div class="label">Menit</div>
                </div>
                <div class="countdown-card">
                    <div class="number" x-text="seconds">0</div>
                    <div class="label">Detik</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════════════
         SECTION 6: EVENT DETAILS
    ═══════════════════════════════════════════════════════════════════ -->
    <section class="section-wrapper" style="padding-top: 2rem;">
        <div class="text-center reveal">
            <p class="font-script" style="font-size: 2rem; color: var(--rose);">Detail Acara</p>
        </div>

        <div class="inv-card mt-6 text-center reveal" style="position: relative;">
            <!-- Floral Corner Accents on Card -->
            <div class="floral-corner floral-corner--tl" style="width: 80px; height: 80px; opacity: 0.12;">
                <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 5C12 20 8 35 18 42C8 48 5 35 5 5Z" fill="rgba(143,166,142,0.5)"/>
                    <circle cx="22" cy="28" r="5" fill="rgba(158,75,94,0.3)"/>
                    <path d="M10 10C18 8 24 12 26 18" stroke="rgba(143,166,142,0.6)" stroke-width="0.6"/>
                </svg>
            </div>
            <div class="floral-corner floral-corner--br" style="width: 80px; height: 80px; opacity: 0.12;">
                <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 5C12 20 8 35 18 42C8 48 5 35 5 5Z" fill="rgba(143,166,142,0.5)"/>
                    <circle cx="22" cy="28" r="5" fill="rgba(158,75,94,0.3)"/>
                    <path d="M10 10C18 8 24 12 26 18" stroke="rgba(143,166,142,0.6)" stroke-width="0.6"/>
                </svg>
            </div>

            <!-- Event Icon -->
            <div class="flex justify-center mb-4">
                <div style="width: 56px; height: 56px; border-radius: 50%; background: var(--blush); display: flex; align-items: center; justify-content: center;">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="var(--rose)" stroke-width="1.5">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                        <path d="M12 14l-2 2 2 2 2-2-2-2z"/>
                    </svg>
                </div>
            </div>

            <h4 class="font-display" style="font-size: 1.1rem; color: var(--text); font-weight: 700;">Akad & Resepsi</h4>

            <div class="petal-divider" style="margin: 1rem 0;">
                <svg width="12" height="14" viewBox="0 0 20 24" fill="none">
                    <path d="M10 0C10 0 20 8 18 16C16 24 4 24 2 16C0 8 10 0 10 0Z" fill="var(--rose)" opacity="0.4"/>
                </svg>
            </div>

            <p class="font-display" style="font-size: 0.95rem; color: var(--text);">
                {{ $invitation->event_date->translatedFormat('l, d F Y') }}
            </p>
            <p class="font-body mt-2" style="color: var(--muted); font-size: 0.9rem;">
                Pukul {{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }}
                @if($invitation->event_time_end)
                 - {{ \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') }} WIB
                @else
                 WIB - Selesai
                @endif
            </p>

            <div class="mt-4 pt-4" style="border-top: 1px solid var(--border);">
                <p class="font-body font-semibold" style="color: var(--text); font-size: 0.95rem;">
                    {{ $invitation->event_venue }}
                </p>
                <p class="font-body mt-1 text-sm" style="color: var(--muted); line-height: 1.6;">
                    {{ $invitation->event_address }}
                </p>
            </div>

            @if($invitation->dress_code)
            <div class="mt-4 pt-4" style="border-top: 1px solid var(--border);">
                <p class="font-body text-xs uppercase tracking-wider" style="color: var(--muted);">Dress Code</p>
                <p class="font-body font-semibold mt-1" style="color: var(--rose);">{{ $invitation->dress_code }}</p>
            </div>
            @endif

            @if($invitation->event_maps_url)
            <div class="mt-6">
                <a href="{{ $invitation->event_maps_url }}" target="_blank" class="btn-rose-outline">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    Buka Google Maps
                </a>
            </div>
            @endif
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════════════
         SECTION 7: GALLERY
    ═══════════════════════════════════════════════════════════════════ -->
    @if($invitation->galleries && $invitation->galleries->count() > 0)
    <section class="section-wrapper" style="padding-top: 2rem;">
        <div class="text-center reveal">
            <p class="font-script" style="font-size: 2rem; color: var(--rose);">Galeri Kami</p>
            <p class="font-body text-sm mt-2" style="color: var(--muted);">Momen-momen indah bersama</p>
        </div>

        <div class="gallery-grid mt-6 reveal">
            @foreach($invitation->galleries as $photo)
            <div class="gallery-item">
                <img src="{{ $photo->getImageUrl() }}" alt="{{ $photo->caption ?? 'Gallery' }}" loading="lazy">
            </div>
            @endforeach
        </div>
    </section>
    @endif


    <!-- ═══════════════════════════════════════════════════════════════════
         SECTION 8: RSVP FORM
    ═══════════════════════════════════════════════════════════════════ -->
    <section class="section-wrapper" style="padding-top: 2rem;">
        <div class="text-center reveal">
            <p class="font-script" style="font-size: 2rem; color: var(--rose);">Konfirmasi Kehadiran</p>
            <p class="font-body text-sm mt-2" style="color: var(--muted);">Mohon konfirmasi kehadiran Anda</p>
        </div>

        <div class="inv-card mt-6 reveal">
            <form action="{{ route('invitation.rsvp', $invitation->slug) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="font-body text-sm font-semibold" style="color: var(--text); display: block; margin-bottom: 6px;">Nama</label>
                    <input type="text" name="name" value="{{ $guestName ?? '' }}" placeholder="Nama lengkap" class="form-input" required>
                </div>

                <div>
                    <label class="font-body text-sm font-semibold" style="color: var(--text); display: block; margin-bottom: 6px;">Konfirmasi</label>
                    <select name="attendance" class="form-input" required>
                        <option value="">-- Pilih --</option>
                        <option value="hadir">Akan Hadir</option>
                        <option value="tidak_hadir">Berhalangan Hadir</option>
                        <option value="ragu">Masih Ragu</option>
                    </select>
                </div>

                <div>
                    <label class="font-body text-sm font-semibold" style="color: var(--text); display: block; margin-bottom: 6px;">Jumlah Tamu</label>
                    <input type="number" name="guests_count" min="1" max="10" value="1" class="form-input">
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn-rose w-full justify-center">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        Kirim Konfirmasi
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════════════
         SECTION 9: GUESTBOOK
    ═══════════════════════════════════════════════════════════════════ -->
    <section class="section-wrapper" style="padding-top: 2rem;">
        <div class="text-center reveal">
            <p class="font-script" style="font-size: 2rem; color: var(--rose);">Ucapan & Doa</p>
            <p class="font-body text-sm mt-2" style="color: var(--muted);">Berikan ucapan terbaik untuk kami</p>
        </div>

        <div class="inv-card mt-6 reveal">
            <form action="{{ route('invitation.guestbook', $invitation->slug) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <input type="text" name="name" value="{{ $guestName ?? '' }}" placeholder="Nama Anda" class="form-input" required>
                </div>
                <div>
                    <textarea name="message" placeholder="Tulis ucapan & doa untuk kedua mempelai..." class="form-input" rows="4" required></textarea>
                </div>
                <div>
                    <button type="submit" class="btn-rose w-full justify-center">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="22" y1="2" x2="11" y2="13"/>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                        </svg>
                        Kirim Ucapan
                    </button>
                </div>
            </form>
        </div>

        <!-- Messages List -->
        @if($invitation->guestbooks && $invitation->guestbooks->count() > 0)
        <div class="mt-6 reveal" style="max-height: 400px; overflow-y: auto; padding-right: 4px;">
            @foreach($invitation->guestbooks->sortByDesc('created_at') as $message)
            <div class="guestbook-msg">
                <div class="msg-name">{{ $message->name }}</div>
                <div class="msg-text">{{ $message->message }}</div>
                <div class="msg-date">{{ $message->created_at->diffForHumans() }}</div>
            </div>
            @endforeach
        </div>
        @endif
    </section>


    <!-- ═══════════════════════════════════════════════════════════════════
         SECTION 10: DIGITAL ENVELOPE / AMPLOP
    ═══════════════════════════════════════════════════════════════════ -->
    @if($invitation->bank_account_number || $invitation->qris_image)
    <section class="section-wrapper" style="padding-top: 2rem;">
        <div class="text-center reveal">
            <p class="font-script" style="font-size: 2rem; color: var(--rose);">Amplop Digital</p>
            <p class="font-body text-sm mt-2" style="color: var(--muted);">Doa restu Anda merupakan karunia yang sangat berarti bagi kami</p>
        </div>

        <div class="inv-card mt-6 text-center reveal">
            <!-- Gift Icon -->
            <div class="flex justify-center mb-4">
                <div style="width: 56px; height: 56px; border-radius: 50%; background: var(--blush); display: flex; align-items: center; justify-content: center;">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="var(--rose)" stroke-width="1.5">
                        <polyline points="20 12 20 22 4 22 4 12"/>
                        <rect x="2" y="7" width="20" height="5"/>
                        <line x1="12" y1="22" x2="12" y2="7"/>
                        <path d="M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7z"/>
                        <path d="M12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/>
                    </svg>
                </div>
            </div>

            @if($invitation->gift_info)
            <p class="font-body text-sm mb-4" style="color: var(--muted); line-height: 1.6;">
                {{ $invitation->gift_info }}
            </p>
            @endif

            @if($invitation->bank_account_number)
            <div style="background: var(--blush); border-radius: 16px; padding: 20px; margin-top: 16px;">
                <p class="font-body text-xs uppercase tracking-wider" style="color: var(--muted);">Transfer Bank</p>
                <p class="font-body font-bold mt-2" style="color: var(--text); font-size: 1rem;">{{ $invitation->bank_name }}</p>
                <div class="flex items-center justify-center gap-2 mt-2">
                    <p class="font-body font-bold" style="color: var(--rose); font-size: 1.2rem; letter-spacing: 1px;" x-ref="bankNumber">{{ $invitation->bank_account_number }}</p>
                    <button @click="navigator.clipboard.writeText($refs.bankNumber.textContent.trim())" type="button" style="background: none; border: none; cursor: pointer; color: var(--rose); padding: 4px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                            <path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/>
                        </svg>
                    </button>
                </div>
                <p class="font-body text-sm mt-1" style="color: var(--muted);">a.n. {{ $invitation->bank_account_name }}</p>
            </div>
            @endif

            @if($invitation->qris_image)
            <div style="background: var(--blush); border-radius: 16px; padding: 20px; margin-top: 16px;">
                <p class="font-body text-xs uppercase tracking-wider" style="color: var(--muted);">QRIS</p>
                <div class="flex justify-center mt-3">
                    <img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS" style="max-width: 220px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.06);">
                </div>
            </div>
            @endif
        </div>
    </section>
    @endif

    <!-- ═══════════════════════════════════════════════════════════════════
         SECTION 11: CLOSING TEXT
    ═══════════════════════════════════════════════════════════════════ -->
    <section class="section-wrapper" style="padding-top: 2rem; padding-bottom: 1rem;">
        <div class="text-center reveal">
            <div class="petal-divider">
                <svg width="20" height="20" viewBox="0 0 24 24" class="animate-heartbeat">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="var(--rose)" opacity="0.6"/>
                </svg>
            </div>
            <p class="font-display mt-6" style="font-style: italic; font-size: 1rem; line-height: 1.9; color: var(--text); max-width: 380px; margin-left: auto; margin-right: auto;">
                {!! nl2br(e($invitation->closing_text ?? 'Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu kepada kedua mempelai.')) !!}
            </p>
            <p class="font-body mt-4 text-sm" style="color: var(--muted);">Atas kehadiran dan doa restu, kami ucapkan terima kasih.</p>

            <div class="mt-6">
                <p class="font-body text-sm" style="color: var(--muted);">Kami yang berbahagia,</p>
                <p class="font-script mt-2" style="font-size: 2rem; color: var(--rose);">
                    {{ $invitation->groom_name }} & {{ $invitation->bride_name }}
                </p>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════════════
         SECTION 12: FOOTER
    ═══════════════════════════════════════════════════════════════════ -->
    <footer class="section-wrapper" style="padding-top: 1rem; padding-bottom: 4rem;">
        <div class="text-center reveal">
            <div class="petal-divider mb-4">
                <svg width="14" height="16" viewBox="0 0 20 24" fill="none">
                    <path d="M10 0C10 0 20 8 18 16C16 24 4 24 2 16C0 8 10 0 10 0Z" fill="var(--sage)" opacity="0.4"/>
                </svg>
            </div>
            <p class="font-body text-xs" style="color: var(--muted);">
                Made with
                <svg width="12" height="12" viewBox="0 0 24 24" fill="var(--rose)" style="display: inline; vertical-align: middle;">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
                by {{ config('app.name', 'Undangan Digital') }}
            </p>
            <p class="font-body text-xs mt-1" style="color: var(--muted); opacity: 0.6;">
                &copy; {{ date('Y') }} All rights reserved
            </p>
        </div>
    </footer>

    </main><!-- End main x-show="opened" -->


    <!-- ═══════════════════════════════════════════════════════════════════
         SECTION 13: MUSIC PLAYER (Floating)
    ═══════════════════════════════════════════════════════════════════ -->
    @if($invitation->music_url)
    <button x-show="opened" @click="toggleMusic()" class="music-btn" :class="{ 'playing': playing }"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-75"
            x-transition:enter-end="opacity-100 scale-100"
            title="Toggle Music">
        <template x-if="playing">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 18V5l12-2v13"/>
                <circle cx="6" cy="18" r="3"/>
                <circle cx="18" cy="16" r="3"/>
            </svg>
        </template>
        <template x-if="!playing">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="1" y1="1" x2="23" y2="23"/>
                <path d="M9 18V5l12-2v13"/>
                <circle cx="6" cy="18" r="3"/>
                <circle cx="18" cy="16" r="3"/>
            </svg>
        </template>
    </button>
    @endif

    <!-- ═══════════════════════════════════════════════════════════════════
         JAVASCRIPT: Alpine.js App + Countdown + Scroll Reveal
    ═══════════════════════════════════════════════════════════════════ -->
    <script>
        function invitationApp() {
            return {
                opened: false,
                playing: false,

                openInvitation() {
                    this.opened = true;
                    document.body.style.overflow = 'auto';

                    // Autoplay music if enabled
                    @if($invitation->music_autoplay)
                    this.$nextTick(() => {
                        this.playMusic();
                    });
                    @endif

                    // Initialize scroll reveal after transition
                    this.$nextTick(() => {
                        setTimeout(() => this.initReveal(), 200);
                    });
                },

                playMusic() {
                    const audio = document.getElementById('bgMusic');
                    if (audio) {
                        audio.play().then(() => {
                            this.playing = true;
                        }).catch(() => {
                            this.playing = false;
                        });
                    }
                },

                toggleMusic() {
                    const audio = document.getElementById('bgMusic');
                    if (!audio) return;

                    if (this.playing) {
                        audio.pause();
                        this.playing = false;
                    } else {
                        audio.play().then(() => {
                            this.playing = true;
                        }).catch(() => {
                            this.playing = false;
                        });
                    }
                },

                initReveal() {
                    const reveals = document.querySelectorAll('.reveal');
                    const observerOptions = {
                        root: null,
                        rootMargin: '0px 0px -60px 0px',
                        threshold: 0.15
                    };

                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.classList.add('active');
                                observer.unobserve(entry.target);
                            }
                        });
                    }, observerOptions);

                    reveals.forEach(el => observer.observe(el));
                }
            };
        }

        function countdown(targetDate) {
            return {
                days: 0,
                hours: 0,
                minutes: 0,
                seconds: 0,
                interval: null,

                init() {
                    this.updateCountdown(targetDate);
                    this.interval = setInterval(() => {
                        this.updateCountdown(targetDate);
                    }, 1000);
                },

                updateCountdown(target) {
                    const now = new Date().getTime();
                    const eventDate = new Date(target).getTime();
                    const diff = eventDate - now;

                    if (diff <= 0) {
                        this.days = 0;
                        this.hours = 0;
                        this.minutes = 0;
                        this.seconds = 0;
                        if (this.interval) clearInterval(this.interval);
                        return;
                    }

                    this.days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    this.hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    this.minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    this.seconds = Math.floor((diff % (1000 * 60)) / 1000);
                },

                destroy() {
                    if (this.interval) clearInterval(this.interval);
                }
            };
        }

        // Initialize floating petals animation on cover
        document.addEventListener('DOMContentLoaded', () => {
            const petals = document.querySelectorAll('.floating-petal');
            petals.forEach(petal => {
                petal.classList.add('animate-float-petal');
            });
        });
    </script>
</body>
</html>
