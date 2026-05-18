<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <meta name="description" content="Undangan Pernikahan {{ $invitation->groom_name }} & {{ $invitation->bride_name }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Poppins:wght@200;300;400;500;600;700&family=Scheherazade+New:wght@400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --green: {{ $invitation->color_primary ?? '#1B5E20' }};
            --green-light: {{ $invitation->color_secondary ?? '#2E7D32' }};
            --gold: #C9A96E;
            --gold-light: #E8D5A3;
            --cream: #FDFCF7;
            --sage: #F5F5DC;
            --text: #2C3E2C;
            --muted: #6B7B6B;
            --border: rgba(27, 94, 32, 0.12);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            font-weight: 300;
            background-color: var(--cream);
            color: var(--text);
            overflow: hidden;
            line-height: 1.7;
        }
        [x-cloak] { display: none !important; }

        .font-display { font-family: 'Amiri', serif; }
        .font-arabic { font-family: 'Scheherazade New', serif; }

        /* === ISLAMIC GEOMETRIC TESSELLATION BACKGROUND === */
        .islamic-tessellation {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120' viewBox='0 0 120 120'%3E%3Cg fill='none' stroke='%231B5E20' stroke-width='0.4' opacity='0.04'%3E%3Cpath d='M60 0L120 60L60 120L0 60Z'/%3E%3Cpath d='M60 15L105 60L60 105L15 60Z'/%3E%3Cpath d='M60 30L90 60L60 90L30 60Z'/%3E%3Cpath d='M30 0L60 30L30 60L0 30Z'/%3E%3Cpath d='M90 0L120 30L90 60L60 30Z'/%3E%3Cpath d='M30 60L60 90L30 120L0 90Z'/%3E%3Cpath d='M90 60L120 90L90 120L60 90Z'/%3E%3Ccircle cx='60' cy='60' r='6'/%3E%3Ccircle cx='0' cy='0' r='4'/%3E%3Ccircle cx='120' cy='0' r='4'/%3E%3Ccircle cx='0' cy='120' r='4'/%3E%3Ccircle cx='120' cy='120' r='4'/%3E%3Cpath d='M60 54L66 60L60 66L54 60Z'/%3E%3C/g%3E%3C/svg%3E");
            background-repeat: repeat;
        }

        /* === 8-POINTED STAR SVG DIVIDER === */
        .star-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 24px 0;
        }
        .star-divider::before,
        .star-divider::after {
            content: '';
            flex: 1;
            max-width: 80px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }

        /* === ARCH / MIHRAB FRAME === */
        .arch-frame {
            border-radius: 50% 50% 4px 4px / 35% 35% 0 0;
            border: 2px solid var(--gold);
            position: relative;
            overflow: hidden;
        }
        .arch-frame::before {
            content: '';
            position: absolute;
            inset: 5px;
            border-radius: 50% 50% 3px 3px / 35% 35% 0 0;
            border: 1px solid var(--gold-light);
            opacity: 0.5;
            pointer-events: none;
        }

        /* === GOLD GEOMETRIC CORNER ORNAMENTS === */
        .corner-ornament {
            position: absolute;
            width: 60px;
            height: 60px;
        }
        .corner-ornament svg { width: 100%; height: 100%; }
        .corner-tl { top: 20px; left: 20px; }
        .corner-tr { top: 20px; right: 20px; transform: scaleX(-1); }
        .corner-bl { bottom: 20px; left: 20px; transform: scaleY(-1); }
        .corner-br { bottom: 20px; right: 20px; transform: scale(-1, -1); }

        /* === CARDS === */
        .card-islamic {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border);
            border-top: 3px solid var(--green);
            padding: 32px 24px;
            box-shadow: 0 4px 20px rgba(27, 94, 32, 0.06);
        }
        .card-islamic-gold {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border);
            border-top: 3px solid var(--gold);
            padding: 32px 24px;
            box-shadow: 0 4px 20px rgba(201, 169, 110, 0.08);
        }

        /* === SCROLL REVEAL === */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-delay-1 { transition-delay: 0.1s; }
        .reveal-delay-2 { transition-delay: 0.2s; }
        .reveal-delay-3 { transition-delay: 0.3s; }
        .reveal-delay-4 { transition-delay: 0.4s; }

        /* === OPENING COVER === */
        .opening-cover {
            position: fixed;
            inset: 0;
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(160deg, #1B5E20 0%, #0D3B12 60%, #091F09 100%);
            overflow: hidden;
        }
        .opening-cover .islamic-tessellation {
            position: absolute;
            inset: 0;
            opacity: 0.08;
        }

        /* === COUNTDOWN === */
        .countdown-box {
            background: linear-gradient(135deg, var(--green) 0%, var(--green-light) 100%);
            border-radius: 12px;
            padding: 16px 12px;
            text-align: center;
            color: white;
            min-width: 70px;
            box-shadow: 0 4px 15px rgba(27, 94, 32, 0.3);
        }
        .countdown-box .number {
            font-size: 2rem;
            font-weight: 700;
            font-family: 'Amiri', serif;
            line-height: 1;
        }
        .countdown-box .label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.9;
            margin-top: 4px;
        }

        /* === FORM STYLES === */
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            transition: all 0.3s;
            background: white;
        }
        .form-input:focus {
            outline: none;
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(27, 94, 32, 0.1);
        }
        .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            background: white;
            transition: all 0.3s;
            appearance: none;
            cursor: pointer;
        }
        .form-select:focus {
            outline: none;
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(27, 94, 32, 0.1);
        }

        /* === BUTTON === */
        .btn-green {
            background: linear-gradient(135deg, var(--green) 0%, var(--green-light) 100%);
            color: white;
            border: none;
            padding: 14px 32px;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(27, 94, 32, 0.25);
        }
        .btn-green:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(27, 94, 32, 0.35);
        }
        .btn-gold {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            color: var(--text);
            border: none;
            padding: 14px 32px;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(201, 169, 110, 0.3);
        }
        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(201, 169, 110, 0.4);
        }

        /* === GALLERY === */
        .gallery-item {
            border-radius: 12px;
            overflow: hidden;
            border: 2px solid var(--border);
            transition: all 0.3s;
            position: relative;
        }
        .gallery-item:hover {
            border-color: var(--gold);
            transform: scale(1.02);
            box-shadow: 0 8px 25px rgba(27, 94, 32, 0.12);
        }
        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        /* === MUSIC PLAYER FLOATING === */
        .music-player {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 100;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--green) 0%, var(--green-light) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(27, 94, 32, 0.4);
            transition: all 0.3s;
            border: 2px solid var(--gold);
        }
        .music-player:hover {
            transform: scale(1.1);
        }
        .music-player.playing {
            animation: pulse-music 2s infinite;
        }
        @keyframes pulse-music {
            0%, 100% { box-shadow: 0 4px 20px rgba(27, 94, 32, 0.4); }
            50% { box-shadow: 0 4px 30px rgba(27, 94, 32, 0.7); }
        }

        /* === GUESTBOOK MESSAGES === */
        .guestbook-msg {
            background: var(--sage);
            border-radius: 12px;
            padding: 16px;
            border-left: 3px solid var(--green);
            margin-bottom: 12px;
        }

        /* === SECTION SPACING === */
        .section-padding {
            padding: 60px 20px;
        }
        .section-padding-lg {
            padding: 80px 20px;
        }

        /* === ENVELOPE SECTION === */
        .envelope-card {
            background: linear-gradient(135deg, #FDFCF7 0%, #F5F5DC 100%);
            border: 1px solid var(--gold);
            border-radius: 12px;
            padding: 24px;
            text-align: center;
        }

        /* === ANIMATIONS === */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        .animate-float { animation: float 3s ease-in-out infinite; }

        /* === RESPONSIVE === */
        @media (max-width: 640px) {
            .countdown-box .number { font-size: 1.5rem; }
            .countdown-box { min-width: 60px; padding: 12px 8px; }
            .section-padding { padding: 40px 16px; }
            .section-padding-lg { padding: 60px 16px; }
            .corner-ornament { width: 40px; height: 40px; }
            .corner-tl { top: 12px; left: 12px; }
            .corner-tr { top: 12px; right: 12px; }
            .corner-bl { bottom: 12px; left: 12px; }
            .corner-br { bottom: 12px; right: 12px; }
        }
    </style>
</head>
<body x-data="invitationApp()" class="islamic-tessellation">
    {{-- AUDIO ELEMENT --}}
    <audio x-ref="audio" loop preload="auto">
        <source src="{{ asset('storage/' . $invitation->music_url) }}" type="audio/mpeg">
    </audio>


    {{-- ============================================ --}}
    {{-- SECTION 1: OPENING COVER --}}
    {{-- ============================================ --}}
    <section x-show="!opened" x-cloak class="opening-cover" x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="islamic-tessellation" style="position:absolute;inset:0;background-image:url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120' viewBox='0 0 120 120'%3E%3Cg fill='none' stroke='%23C9A96E' stroke-width='0.5' opacity='0.1'%3E%3Cpath d='M60 0L120 60L60 120L0 60Z'/%3E%3Cpath d='M60 15L105 60L60 105L15 60Z'/%3E%3Cpath d='M60 30L90 60L60 90L30 60Z'/%3E%3Ccircle cx='60' cy='60' r='8'/%3E%3C/g%3E%3C/svg%3E&quot;);background-repeat:repeat;"></div>

        {{-- Gold Geometric Corner Ornaments --}}
        <div class="corner-ornament corner-tl">
            <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0L60 0L60 4L4 4L4 60L0 60Z" fill="#C9A96E" opacity="0.8"/>
                <path d="M0 0L30 0L30 2L2 2L2 30L0 30Z" fill="#E8D5A3" opacity="0.6"/>
                <path d="M8 8L24 8L24 10L10 10L10 24L8 24Z" fill="#C9A96E" opacity="0.5"/>
                <circle cx="4" cy="4" r="2" fill="#C9A96E" opacity="0.7"/>
                <path d="M0 15L15 0" stroke="#C9A96E" stroke-width="0.5" opacity="0.4"/>
                <path d="M0 30L30 0" stroke="#C9A96E" stroke-width="0.5" opacity="0.3"/>
            </svg>
        </div>
        <div class="corner-ornament corner-tr">
            <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0L60 0L60 4L4 4L4 60L0 60Z" fill="#C9A96E" opacity="0.8"/>
                <path d="M0 0L30 0L30 2L2 2L2 30L0 30Z" fill="#E8D5A3" opacity="0.6"/>
                <path d="M8 8L24 8L24 10L10 10L10 24L8 24Z" fill="#C9A96E" opacity="0.5"/>
                <circle cx="4" cy="4" r="2" fill="#C9A96E" opacity="0.7"/>
                <path d="M0 15L15 0" stroke="#C9A96E" stroke-width="0.5" opacity="0.4"/>
                <path d="M0 30L30 0" stroke="#C9A96E" stroke-width="0.5" opacity="0.3"/>
            </svg>
        </div>
        <div class="corner-ornament corner-bl">
            <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0L60 0L60 4L4 4L4 60L0 60Z" fill="#C9A96E" opacity="0.8"/>
                <path d="M0 0L30 0L30 2L2 2L2 30L0 30Z" fill="#E8D5A3" opacity="0.6"/>
                <path d="M8 8L24 8L24 10L10 10L10 24L8 24Z" fill="#C9A96E" opacity="0.5"/>
                <circle cx="4" cy="4" r="2" fill="#C9A96E" opacity="0.7"/>
            </svg>
        </div>
        <div class="corner-ornament corner-br">
            <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0L60 0L60 4L4 4L4 60L0 60Z" fill="#C9A96E" opacity="0.8"/>
                <path d="M0 0L30 0L30 2L2 2L2 30L0 30Z" fill="#E8D5A3" opacity="0.6"/>
                <path d="M8 8L24 8L24 10L10 10L10 24L8 24Z" fill="#C9A96E" opacity="0.5"/>
                <circle cx="4" cy="4" r="2" fill="#C9A96E" opacity="0.7"/>
            </svg>
        </div>

        {{-- Opening Content --}}
        <div class="text-center relative z-10 px-6" style="max-width: 400px;">
            {{-- Bismillah --}}
            <p class="font-arabic text-2xl mb-6" style="color: var(--gold); line-height: 1.8;">
                بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ
            </p>

            {{-- 8-pointed star ornament --}}
            <div class="flex justify-center mb-6">
                <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 0L22.5 13.5L36 18L22.5 22.5L18 36L13.5 22.5L0 18L13.5 13.5Z" fill="#C9A96E" opacity="0.8"/>
                    <path d="M18 6L21 15L30 18L21 21L18 30L15 21L6 18L15 15Z" fill="#E8D5A3" opacity="0.6"/>
                    <circle cx="18" cy="18" r="3" fill="#C9A96E"/>
                </svg>
            </div>

            <p class="text-sm uppercase tracking-widest mb-3" style="color: var(--gold-light); letter-spacing: 3px;">
                The Wedding of
            </p>

            <h1 class="font-display text-4xl md:text-5xl mb-2" style="color: white; font-weight: 700;">
                {{ $invitation->groom_name }}
            </h1>
            <p class="font-display text-2xl mb-2" style="color: var(--gold);">&amp;</p>
            <h1 class="font-display text-4xl md:text-5xl mb-6" style="color: white; font-weight: 700;">
                {{ $invitation->bride_name }}
            </h1>

            {{-- Guest Name --}}
            @if($guestName)
            <div class="mb-6" style="border-top: 1px solid rgba(201,169,110,0.3); border-bottom: 1px solid rgba(201,169,110,0.3); padding: 16px 0;">
                <p class="text-xs uppercase tracking-widest mb-1" style="color: var(--gold-light); opacity: 0.8;">Kepada Yth.</p>
                <p class="text-lg font-medium" style="color: white;">{{ $guestName }}</p>
            </div>
            @endif

            {{-- Open Button --}}
            <button @click="openInvitation()" class="btn-gold inline-flex items-center gap-2" style="margin-top: 8px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Buka Undangan
            </button>
        </div>
    </section>


    {{-- ============================================ --}}
    {{-- MAIN CONTENT (shown after opening) --}}
    {{-- ============================================ --}}
    <main x-show="opened" x-cloak x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

        {{-- ============================================ --}}
        {{-- SECTION 2: HERO --}}
        {{-- ============================================ --}}
        <section class="section-padding-lg text-center relative overflow-hidden" style="background: linear-gradient(180deg, var(--cream) 0%, white 50%, var(--sage) 100%);">
            {{-- Subtle pattern overlay --}}
            <div class="absolute inset-0 islamic-tessellation" style="opacity: 0.6;"></div>

            <div class="relative z-10 max-w-lg mx-auto">
                {{-- Bismillah --}}
                <div class="reveal">
                    <p class="font-arabic text-xl md:text-2xl mb-2" style="color: var(--green); line-height: 2;">
                        بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ
                    </p>
                    <p class="text-xs mb-8" style="color: var(--muted);">Dengan menyebut nama Allah Yang Maha Pengasih lagi Maha Penyayang</p>
                </div>

                {{-- Star Divider --}}
                <div class="star-divider reveal reveal-delay-1">
                    <svg width="28" height="28" viewBox="0 0 36 36" fill="none">
                        <path d="M18 0L22.5 13.5L36 18L22.5 22.5L18 36L13.5 22.5L0 18L13.5 13.5Z" fill="var(--gold)" opacity="0.7"/>
                        <circle cx="18" cy="18" r="3" fill="var(--gold)"/>
                    </svg>
                </div>

                {{-- Names --}}
                <div class="reveal reveal-delay-2">
                    <p class="text-sm uppercase tracking-widest mb-4" style="color: var(--muted); letter-spacing: 3px;">The Wedding of</p>
                    <h1 class="font-display text-5xl md:text-6xl mb-2" style="color: var(--green); font-weight: 700;">
                        {{ $invitation->groom_name }}
                    </h1>
                    <div class="flex justify-center my-3">
                        <svg width="40" height="20" viewBox="0 0 40 20" fill="none">
                            <path d="M0 10H15M25 10H40" stroke="var(--gold)" stroke-width="1"/>
                            <text x="20" y="14" text-anchor="middle" font-family="Amiri" font-size="14" fill="var(--gold)">&amp;</text>
                        </svg>
                    </div>
                    <h1 class="font-display text-5xl md:text-6xl mb-6" style="color: var(--green); font-weight: 700;">
                        {{ $invitation->bride_name }}
                    </h1>
                </div>

                {{-- Date Badge --}}
                <div class="reveal reveal-delay-3 inline-block" style="background: var(--green); color: white; padding: 10px 24px; border-radius: 50px; font-size: 0.85rem; letter-spacing: 1px;">
                    {{ $invitation->event_date->translatedFormat('l, d F Y') }}
                </div>
            </div>
        </section>

        {{-- ============================================ --}}
        {{-- SECTION 3: OPENING TEXT / QURANIC VERSE --}}
        {{-- ============================================ --}}
        <section class="section-padding text-center" style="background: white;">
            <div class="max-w-lg mx-auto">
                {{-- Star Divider --}}
                <div class="star-divider reveal">
                    <svg width="24" height="24" viewBox="0 0 36 36" fill="none">
                        <path d="M18 0L22.5 13.5L36 18L22.5 22.5L18 36L13.5 22.5L0 18L13.5 13.5Z" fill="var(--green)" opacity="0.5"/>
                        <circle cx="18" cy="18" r="2.5" fill="var(--green)" opacity="0.7"/>
                    </svg>
                </div>

                <div class="card-islamic reveal reveal-delay-1" style="margin-top: 20px;">
                    {{-- Arabic Verse --}}
                    <p class="font-arabic text-xl md:text-2xl mb-4" style="color: var(--green); line-height: 2.2; direction: rtl;">
                        وَمِنْ آيَاتِهِ أَنْ خَلَقَ لَكُم مِّنْ أَنفُسِكُمْ أَزْوَاجًا لِّتَسْكُنُوا إِلَيْهَا وَجَعَلَ بَيْنَكُم مَّوَدَّةً وَرَحْمَةً
                    </p>

                    {{-- Translation --}}
                    <p class="text-sm mb-3" style="color: var(--text); line-height: 1.8;">
                        "Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu pasangan hidup dari jenismu sendiri, supaya kamu merasa tenteram kepadanya, dan dijadikan-Nya di antaramu rasa kasih dan sayang."
                    </p>
                    <p class="text-xs font-medium" style="color: var(--gold);">— QS. Ar-Rum: 21</p>
                </div>

                @if($invitation->opening_text)
                <div class="reveal reveal-delay-2 mt-8">
                    <p class="text-sm" style="color: var(--muted); line-height: 1.8;">
                        {{ $invitation->opening_text }}
                    </p>
                </div>
                @endif
            </div>
        </section>


        {{-- ============================================ --}}
        {{-- SECTION 4: COUPLE PROFILES --}}
        {{-- ============================================ --}}
        <section class="section-padding-lg" style="background: var(--sage);">
            <div class="max-w-2xl mx-auto">
                {{-- Section Header --}}
                <div class="text-center reveal">
                    <p class="font-arabic text-lg mb-2" style="color: var(--green);">العروسان</p>
                    <h2 class="font-display text-3xl mb-2" style="color: var(--green);">Mempelai</h2>
                    <div class="star-divider">
                        <svg width="24" height="24" viewBox="0 0 36 36" fill="none">
                            <path d="M18 0L22.5 13.5L36 18L22.5 22.5L18 36L13.5 22.5L0 18L13.5 13.5Z" fill="var(--gold)" opacity="0.6"/>
                            <circle cx="18" cy="18" r="2" fill="var(--gold)"/>
                        </svg>
                    </div>
                </div>

                {{-- Groom --}}
                <div class="card-islamic-gold text-center mb-8 reveal reveal-delay-1">
                    <div class="flex justify-center mb-4">
                        <div class="arch-frame" style="width: 160px; height: 200px;">
                            @if($invitation->groom_photo)
                            <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center" style="background: var(--sage);">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="1.5">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                            </div>
                            @endif
                        </div>
                    </div>
                    <h3 class="font-display text-2xl mb-1" style="color: var(--green); font-weight: 700;">{{ $invitation->groom_name }}</h3>
                    <p class="text-sm mb-3" style="color: var(--muted);">
                        Putra dari Bapak {{ $invitation->groom_father }}<br>& Ibu {{ $invitation->groom_mother }}
                    </p>
                    @if($invitation->groom_instagram)
                    <a href="https://instagram.com/{{ $invitation->groom_instagram }}" target="_blank" class="inline-flex items-center gap-1 text-sm" style="color: var(--green); text-decoration: none;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="2" width="20" height="20" rx="5"/>
                            <circle cx="12" cy="12" r="5"/>
                            <circle cx="17.5" cy="6.5" r="1.5" fill="currentColor" stroke="none"/>
                        </svg>
                        {{ '@' . $invitation->groom_instagram }}
                    </a>
                    @endif
                </div>

                {{-- Geometric Star Between Profiles --}}
                <div class="flex justify-center my-6 reveal">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M24 4L28 20L44 24L28 28L24 44L20 28L4 24L20 20Z" fill="none" stroke="var(--gold)" stroke-width="1"/>
                        <path d="M24 10L27 21L38 24L27 27L24 38L21 27L10 24L21 21Z" fill="var(--gold)" opacity="0.3"/>
                        <circle cx="24" cy="24" r="4" fill="var(--gold)" opacity="0.5"/>
                        <circle cx="24" cy="24" r="2" fill="var(--gold)"/>
                    </svg>
                </div>

                {{-- Bride --}}
                <div class="card-islamic-gold text-center reveal reveal-delay-2">
                    <div class="flex justify-center mb-4">
                        <div class="arch-frame" style="width: 160px; height: 200px;">
                            @if($invitation->bride_photo)
                            <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center" style="background: var(--sage);">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="1.5">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                            </div>
                            @endif
                        </div>
                    </div>
                    <h3 class="font-display text-2xl mb-1" style="color: var(--green); font-weight: 700;">{{ $invitation->bride_name }}</h3>
                    <p class="text-sm mb-3" style="color: var(--muted);">
                        Putri dari Bapak {{ $invitation->bride_father }}<br>& Ibu {{ $invitation->bride_mother }}
                    </p>
                    @if($invitation->bride_instagram)
                    <a href="https://instagram.com/{{ $invitation->bride_instagram }}" target="_blank" class="inline-flex items-center gap-1 text-sm" style="color: var(--green); text-decoration: none;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="2" width="20" height="20" rx="5"/>
                            <circle cx="12" cy="12" r="5"/>
                            <circle cx="17.5" cy="6.5" r="1.5" fill="currentColor" stroke="none"/>
                        </svg>
                        {{ '@' . $invitation->bride_instagram }}
                    </a>
                    @endif
                </div>
            </div>
        </section>


        {{-- ============================================ --}}
        {{-- SECTION 5: COUNTDOWN TIMER --}}
        {{-- ============================================ --}}
        <section class="section-padding text-center" style="background: white;">
            <div class="max-w-lg mx-auto">
                <div class="reveal">
                    <p class="font-arabic text-lg mb-1" style="color: var(--green);">العد التنازلي</p>
                    <h2 class="font-display text-3xl mb-2" style="color: var(--green);">Menuju Hari Bahagia</h2>
                    <div class="star-divider">
                        <svg width="22" height="22" viewBox="0 0 36 36" fill="none">
                            <path d="M18 0L22.5 13.5L36 18L22.5 22.5L18 36L13.5 22.5L0 18L13.5 13.5Z" fill="var(--gold)" opacity="0.6"/>
                            <circle cx="18" cy="18" r="2" fill="var(--gold)"/>
                        </svg>
                    </div>
                </div>

                <div class="reveal reveal-delay-1" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i:s') }}')">
                    <div class="flex justify-center gap-3 md:gap-4 flex-wrap">
                        <div class="countdown-box">
                            <div class="number" x-text="days">00</div>
                            <div class="label">Hari</div>
                        </div>
                        <div class="countdown-box">
                            <div class="number" x-text="hours">00</div>
                            <div class="label">Jam</div>
                        </div>
                        <div class="countdown-box">
                            <div class="number" x-text="minutes">00</div>
                            <div class="label">Menit</div>
                        </div>
                        <div class="countdown-box">
                            <div class="number" x-text="seconds">00</div>
                            <div class="label">Detik</div>
                        </div>
                    </div>

                    {{-- Gold accent below countdown --}}
                    <div class="flex justify-center mt-6">
                        <div style="width: 60px; height: 2px; background: linear-gradient(90deg, transparent, var(--gold), transparent);"></div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ============================================ --}}
        {{-- SECTION 6: EVENT DETAILS --}}
        {{-- ============================================ --}}
        <section class="section-padding-lg" style="background: var(--cream);">
            <div class="max-w-lg mx-auto">
                {{-- Section Header --}}
                <div class="text-center reveal">
                    <p class="font-arabic text-lg mb-1" style="color: var(--green);">تفاصيل الحفل</p>
                    <h2 class="font-display text-3xl mb-2" style="color: var(--green);">Acara Pernikahan</h2>
                    <div class="star-divider">
                        <svg width="22" height="22" viewBox="0 0 36 36" fill="none">
                            <path d="M18 0L22.5 13.5L36 18L22.5 22.5L18 36L13.5 22.5L0 18L13.5 13.5Z" fill="var(--gold)" opacity="0.6"/>
                            <circle cx="18" cy="18" r="2" fill="var(--gold)"/>
                        </svg>
                    </div>
                </div>

                {{-- Akad Nikah Card --}}
                <div class="card-islamic reveal reveal-delay-1 mb-6">
                    {{-- Label --}}
                    <div class="text-center mb-4">
                        <span class="inline-block px-4 py-1 text-xs font-medium uppercase tracking-wider" style="background: var(--green); color: white; border-radius: 50px; letter-spacing: 2px;">
                            Akad Nikah
                        </span>
                    </div>

                    {{-- Geometric mini divider --}}
                    <div class="flex justify-center mb-4">
                        <svg width="60" height="12" viewBox="0 0 60 12" fill="none">
                            <path d="M0 6H20" stroke="var(--gold)" stroke-width="0.5"/>
                            <path d="M40 6H60" stroke="var(--gold)" stroke-width="0.5"/>
                            <path d="M30 0L36 6L30 12L24 6Z" fill="var(--gold)" opacity="0.5"/>
                            <circle cx="30" cy="6" r="2" fill="var(--gold)"/>
                        </svg>
                    </div>

                    {{-- Date --}}
                    <div class="text-center mb-4">
                        <div class="flex items-center justify-center gap-2 mb-2">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/>
                                <line x1="8" y1="2" x2="8" y2="6"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            <span class="font-medium" style="color: var(--text);">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</span>
                        </div>
                    </div>

                    {{-- Time --}}
                    <div class="text-center mb-4">
                        <div class="flex items-center justify-center gap-2">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12,6 12,12 16,14"/>
                            </svg>
                            <span style="color: var(--text);">
                                {{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }}
                                @if($invitation->event_time_end)
                                    - {{ \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') }} WIB
                                @else
                                    - Selesai
                                @endif
                            </span>
                        </div>
                    </div>

                    {{-- Venue --}}
                    <div class="text-center mb-4">
                        <div class="flex items-start justify-center gap-2">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2" class="mt-0.5 flex-shrink-0">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            <div class="text-left">
                                <p class="font-medium" style="color: var(--text);">{{ $invitation->event_venue }}</p>
                                <p class="text-sm" style="color: var(--muted);">{{ $invitation->event_address }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Maps Button --}}
                    @if($invitation->event_maps_url)
                    <div class="text-center mt-5">
                        <a href="{{ $invitation->event_maps_url }}" target="_blank" class="btn-green inline-flex items-center gap-2" style="font-size: 0.85rem; padding: 10px 24px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polygon points="1,6 1,22 8,18 16,22 23,18 23,2 16,6 8,2"/>
                                <line x1="8" y1="2" x2="8" y2="18"/>
                                <line x1="16" y1="6" x2="16" y2="22"/>
                            </svg>
                            Lihat Lokasi
                        </a>
                    </div>
                    @endif

                    {{-- Dress Code --}}
                    @if($invitation->dress_code)
                    <div class="text-center mt-5 pt-4" style="border-top: 1px solid var(--border);">
                        <p class="text-xs uppercase tracking-wider mb-1" style="color: var(--muted);">Dress Code</p>
                        <p class="font-medium" style="color: var(--green);">{{ $invitation->dress_code }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </section>


        {{-- ============================================ --}}
        {{-- SECTION 7: GALLERY --}}
        {{-- ============================================ --}}
        @if($invitation->galleries && $invitation->galleries->count() > 0)
        <section class="section-padding" style="background: white;">
            <div class="max-w-2xl mx-auto">
                {{-- Section Header --}}
                <div class="text-center reveal">
                    <p class="font-arabic text-lg mb-1" style="color: var(--green);">معرض الصور</p>
                    <h2 class="font-display text-3xl mb-2" style="color: var(--green);">Galeri Foto</h2>
                    <div class="star-divider">
                        <svg width="22" height="22" viewBox="0 0 36 36" fill="none">
                            <path d="M18 0L22.5 13.5L36 18L22.5 22.5L18 36L13.5 22.5L0 18L13.5 13.5Z" fill="var(--gold)" opacity="0.6"/>
                            <circle cx="18" cy="18" r="2" fill="var(--gold)"/>
                        </svg>
                    </div>
                </div>

                {{-- Gallery Grid --}}
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4">
                    @foreach($invitation->galleries as $index => $photo)
                    <div class="gallery-item reveal reveal-delay-{{ ($index % 4) + 1 }}">
                        <img src="{{ $photo->getImageUrl() }}" alt="{{ $photo->caption ?? 'Gallery photo' }}" loading="lazy">
                        @if($photo->caption)
                        <div style="padding: 8px 12px; background: white;">
                            <p class="text-xs" style="color: var(--muted);">{{ $photo->caption }}</p>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        {{-- ============================================ --}}
        {{-- SECTION 8: RSVP FORM --}}
        {{-- ============================================ --}}
        <section class="section-padding-lg" style="background: var(--sage);">
            <div class="max-w-lg mx-auto">
                {{-- Section Header --}}
                <div class="text-center reveal">
                    <p class="font-arabic text-lg mb-1" style="color: var(--green);">الرد على الدعوة</p>
                    <h2 class="font-display text-3xl mb-2" style="color: var(--green);">Konfirmasi Kehadiran</h2>
                    <div class="star-divider">
                        <svg width="22" height="22" viewBox="0 0 36 36" fill="none">
                            <path d="M18 0L22.5 13.5L36 18L22.5 22.5L18 36L13.5 22.5L0 18L13.5 13.5Z" fill="var(--gold)" opacity="0.6"/>
                            <circle cx="18" cy="18" r="2" fill="var(--gold)"/>
                        </svg>
                    </div>
                    <p class="text-sm mb-6" style="color: var(--muted);">Mohon konfirmasi kehadiran Anda untuk membantu kami mempersiapkan acara dengan lebih baik.</p>
                </div>

                {{-- RSVP Form --}}
                <div class="card-islamic reveal reveal-delay-1">
                    <form action="{{ route('invitation.rsvp', $invitation->slug) }}" method="POST" x-data="{ submitted: false }" @submit.prevent="submitted = true; $el.submit();">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2" style="color: var(--text);">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ $guestName ?? '' }}" class="form-input" placeholder="Masukkan nama Anda" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2" style="color: var(--text);">Konfirmasi Kehadiran</label>
                            <select name="rsvp_status" class="form-select" required>
                                <option value="">Pilih Status</option>
                                <option value="attending">Hadir</option>
                                <option value="not_attending">Tidak Hadir</option>
                                <option value="maybe">Masih Ragu</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2" style="color: var(--text);">Jumlah Tamu</label>
                            <input type="number" name="number_of_guests" min="1" max="10" value="1" class="form-input" placeholder="1">
                        </div>

                        <button type="submit" class="btn-green w-full" :disabled="submitted">
                            <span x-show="!submitted">Kirim Konfirmasi</span>
                            <span x-show="submitted">Terkirim ✓</span>
                        </button>
                    </form>
                </div>
            </div>
        </section>


        {{-- ============================================ --}}
        {{-- SECTION 9: GUESTBOOK --}}
        {{-- ============================================ --}}
        <section class="section-padding" style="background: white;">
            <div class="max-w-lg mx-auto">
                {{-- Section Header --}}
                <div class="text-center reveal">
                    <p class="font-arabic text-lg mb-1" style="color: var(--green);">كتاب الضيوف</p>
                    <h2 class="font-display text-3xl mb-2" style="color: var(--green);">Ucapan & Doa</h2>
                    <div class="star-divider">
                        <svg width="22" height="22" viewBox="0 0 36 36" fill="none">
                            <path d="M18 0L22.5 13.5L36 18L22.5 22.5L18 36L13.5 22.5L0 18L13.5 13.5Z" fill="var(--gold)" opacity="0.6"/>
                            <circle cx="18" cy="18" r="2" fill="var(--gold)"/>
                        </svg>
                    </div>
                    <p class="text-sm mb-6" style="color: var(--muted);">Berikan ucapan dan doa terbaik untuk kedua mempelai.</p>
                </div>

                {{-- Guestbook Form --}}
                <div class="card-islamic-gold reveal reveal-delay-1 mb-6">
                    <form action="{{ route('invitation.guestbook', $invitation->slug) }}" method="POST" x-data="{ guestSubmitted: false }" @submit.prevent="guestSubmitted = true; $el.submit();">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2" style="color: var(--text);">Nama</label>
                            <input type="text" name="name" value="{{ $guestName ?? '' }}" class="form-input" placeholder="Masukkan nama Anda" required>
                        </div>

                        <div class="mb-5">
                            <label class="block text-sm font-medium mb-2" style="color: var(--text);">Ucapan & Doa</label>
                            <textarea name="message" class="form-input" rows="4" placeholder="Tulis ucapan dan doa Anda..." required style="resize: vertical;"></textarea>
                        </div>

                        <button type="submit" class="btn-green w-full" :disabled="guestSubmitted">
                            <span x-show="!guestSubmitted">Kirim Ucapan</span>
                            <span x-show="guestSubmitted">Terkirim ✓</span>
                        </button>
                    </form>
                </div>

                {{-- Messages List --}}
                @if($invitation->guestbooks && $invitation->guestbooks->count() > 0)
                <div class="reveal reveal-delay-2">
                    <p class="text-sm font-medium mb-4" style="color: var(--text);">
                        <span style="color: var(--green);">{{ $invitation->guestbooks->count() }}</span> Ucapan
                    </p>
                    <div style="max-height: 400px; overflow-y: auto; padding-right: 4px;">
                        @foreach($invitation->guestbooks->sortByDesc('created_at')->take(20) as $guestbook)
                        <div class="guestbook-msg">
                            <div class="flex items-center gap-2 mb-2">
                                <div style="width: 28px; height: 28px; border-radius: 50%; background: var(--green); display: flex; align-items: center; justify-content: center;">
                                    <span class="text-xs font-medium" style="color: white;">{{ strtoupper(substr($guestbook->name, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium" style="color: var(--text);">{{ $guestbook->name }}</p>
                                    <p class="text-xs" style="color: var(--muted);">{{ $guestbook->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <p class="text-sm" style="color: var(--text); line-height: 1.6;">{{ $guestbook->message }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </section>


        {{-- ============================================ --}}
        {{-- SECTION 10: DIGITAL ENVELOPE / AMPLOP --}}
        {{-- ============================================ --}}
        @if($invitation->bank_name || $invitation->qris_image)
        <section class="section-padding-lg" style="background: var(--cream);">
            <div class="max-w-lg mx-auto">
                {{-- Section Header --}}
                <div class="text-center reveal">
                    <p class="font-arabic text-lg mb-1" style="color: var(--green);">هدية</p>
                    <h2 class="font-display text-3xl mb-2" style="color: var(--green);">Amplop Digital</h2>
                    <div class="star-divider">
                        <svg width="22" height="22" viewBox="0 0 36 36" fill="none">
                            <path d="M18 0L22.5 13.5L36 18L22.5 22.5L18 36L13.5 22.5L0 18L13.5 13.5Z" fill="var(--gold)" opacity="0.6"/>
                            <circle cx="18" cy="18" r="2" fill="var(--gold)"/>
                        </svg>
                    </div>
                    <p class="text-sm mb-6" style="color: var(--muted);">Doa restu Anda merupakan karunia yang sangat berarti bagi kami. Namun jika Anda ingin memberikan tanda kasih, kami menyediakan amplop digital.</p>
                </div>

                {{-- Bank Transfer --}}
                @if($invitation->bank_name)
                <div class="envelope-card reveal reveal-delay-1 mb-4">
                    <div class="flex justify-center mb-3">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="1.5">
                            <rect x="2" y="5" width="20" height="14" rx="2"/>
                            <path d="M2 10h20"/>
                        </svg>
                    </div>
                    <p class="text-sm font-medium mb-1" style="color: var(--text);">Bank Transfer</p>
                    <p class="text-lg font-semibold mb-1" style="color: var(--green);">{{ $invitation->bank_name }}</p>
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-lg mb-2" style="background: white; border: 1px solid var(--border);" x-data="{ copied: false }">
                        <span class="font-mono text-sm font-medium" style="color: var(--text);">{{ $invitation->bank_account_number }}</span>
                        <button @click="navigator.clipboard.writeText('{{ $invitation->bank_account_number }}'); copied = true; setTimeout(() => copied = false, 2000)" class="text-xs px-2 py-1 rounded" style="background: var(--green); color: white; border: none; cursor: pointer;">
                            <span x-show="!copied">Salin</span>
                            <span x-show="copied">✓</span>
                        </button>
                    </div>
                    <p class="text-sm" style="color: var(--muted);">a.n. {{ $invitation->bank_account_name }}</p>
                </div>
                @endif

                {{-- QRIS --}}
                @if($invitation->qris_image)
                <div class="envelope-card reveal reveal-delay-2">
                    <div class="flex justify-center mb-3">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="1.5">
                            <rect x="3" y="3" width="7" height="7"/>
                            <rect x="14" y="3" width="7" height="7"/>
                            <rect x="3" y="14" width="7" height="7"/>
                            <rect x="14" y="14" width="3" height="3"/>
                            <rect x="18" y="18" width="3" height="3"/>
                            <rect x="14" y="18" width="3" height="3"/>
                            <rect x="18" y="14" width="3" height="3"/>
                        </svg>
                    </div>
                    <p class="text-sm font-medium mb-3" style="color: var(--text);">QRIS</p>
                    <div class="flex justify-center mb-3">
                        <img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS Code" style="max-width: 200px; border-radius: 8px; border: 2px solid var(--border);">
                    </div>
                    <p class="text-xs" style="color: var(--muted);">Scan kode QR di atas untuk mengirim hadiah</p>
                </div>
                @endif

                {{-- Gift Info --}}
                @if($invitation->gift_info)
                <div class="text-center mt-6 reveal reveal-delay-3">
                    <p class="text-sm" style="color: var(--muted);">{{ $invitation->gift_info }}</p>
                </div>
                @endif
            </div>
        </section>
        @endif


        {{-- ============================================ --}}
        {{-- SECTION 11: CLOSING TEXT --}}
        {{-- ============================================ --}}
        <section class="section-padding-lg text-center" style="background: linear-gradient(180deg, white 0%, var(--sage) 100%);">
            <div class="max-w-lg mx-auto">
                <div class="reveal">
                    {{-- Geometric Star --}}
                    <div class="flex justify-center mb-6">
                        <svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M28 0L34 22L56 28L34 34L28 56L22 34L0 28L22 22Z" fill="none" stroke="var(--gold)" stroke-width="1" opacity="0.6"/>
                            <path d="M28 8L32 24L48 28L32 32L28 48L24 32L8 28L24 24Z" fill="var(--gold)" opacity="0.15"/>
                            <path d="M28 14L31 25L42 28L31 31L28 42L25 31L14 28L25 25Z" fill="var(--gold)" opacity="0.25"/>
                            <circle cx="28" cy="28" r="4" fill="var(--gold)" opacity="0.5"/>
                            <circle cx="28" cy="28" r="2" fill="var(--gold)"/>
                        </svg>
                    </div>

                    {{-- Arabic Verse - Ar-Rum 21 --}}
                    <div class="card-islamic" style="border-top-color: var(--gold);">
                        <p class="font-arabic text-xl md:text-2xl mb-4" style="color: var(--green); line-height: 2.2; direction: rtl;">
                            وَمِنْ آيَاتِهِ أَنْ خَلَقَ لَكُم مِّنْ أَنفُسِكُمْ أَزْوَاجًا لِّتَسْكُنُوا إِلَيْهَا وَجَعَلَ بَيْنَكُم مَّوَدَّةً وَرَحْمَةً ۚ إِنَّ فِي ذَٰلِكَ لَآيَاتٍ لِّقَوْمٍ يَتَفَكَّرُونَ
                        </p>
                        <p class="text-sm mb-3" style="color: var(--text); line-height: 1.8;">
                            "Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu pasangan hidup dari jenismu sendiri, supaya kamu merasa tenteram kepadanya, dan dijadikan-Nya di antaramu rasa kasih dan sayang. Sesungguhnya pada yang demikian itu benar-benar terdapat tanda-tanda bagi kaum yang berpikir."
                        </p>
                        <p class="text-xs font-medium" style="color: var(--gold);">— QS. Ar-Rum (30): 21</p>
                    </div>
                </div>

                {{-- Closing Message --}}
                <div class="reveal reveal-delay-1 mt-8">
                    @if($invitation->closing_text)
                    <p class="text-sm mb-6" style="color: var(--muted); line-height: 1.8;">
                        {{ $invitation->closing_text }}
                    </p>
                    @else
                    <p class="text-sm mb-6" style="color: var(--muted); line-height: 1.8;">
                        Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu kepada kedua mempelai.
                    </p>
                    @endif

                    <p class="font-arabic text-lg mb-4" style="color: var(--green);">وَالسَّلَامُ عَلَيْكُمْ وَرَحْمَةُ اللَّهِ وَبَرَكَاتُهُ</p>
                    <p class="text-xs mb-6" style="color: var(--muted);">Wassalamu'alaikum Warahmatullahi Wabarakatuh</p>

                    {{-- Names --}}
                    <div class="mt-6">
                        <p class="text-sm uppercase tracking-wider mb-2" style="color: var(--muted);">Kami yang berbahagia</p>
                        <h3 class="font-display text-2xl" style="color: var(--green);">
                            {{ $invitation->groom_name }} & {{ $invitation->bride_name }}
                        </h3>
                    </div>
                </div>
            </div>
        </section>

        {{-- ============================================ --}}
        {{-- SECTION 12: FOOTER --}}
        {{-- ============================================ --}}
        <footer class="text-center" style="background: var(--green); color: white; padding: 32px 20px;">
            <div class="max-w-lg mx-auto">
                {{-- Footer Star --}}
                <div class="flex justify-center mb-4">
                    <svg width="24" height="24" viewBox="0 0 36 36" fill="none">
                        <path d="M18 0L22.5 13.5L36 18L22.5 22.5L18 36L13.5 22.5L0 18L13.5 13.5Z" fill="#C9A96E" opacity="0.6"/>
                        <circle cx="18" cy="18" r="2" fill="#C9A96E"/>
                    </svg>
                </div>

                <p class="font-display text-lg mb-1" style="color: var(--gold-light);">
                    {{ $invitation->groom_name }} & {{ $invitation->bride_name }}
                </p>
                <p class="text-xs mb-4" style="opacity: 0.7;">
                    {{ $invitation->event_date->translatedFormat('d F Y') }}
                </p>

                <div style="width: 40px; height: 1px; background: rgba(201,169,110,0.4); margin: 16px auto;"></div>

                <p class="text-xs" style="opacity: 0.6;">
                    &copy; {{ date('Y') }} Undangan Digital. Made with ❤️
                </p>
            </div>
        </footer>

    </main>


    {{-- ============================================ --}}
    {{-- SECTION 13: FLOATING MUSIC PLAYER --}}
    {{-- ============================================ --}}
    <div x-show="opened" x-cloak class="music-player" :class="{ 'playing': playing }" @click="toggleMusic()" title="Play/Pause Music">
        {{-- Play Icon --}}
        <svg x-show="!playing" width="20" height="20" viewBox="0 0 24 24" fill="white" stroke="none">
            <polygon points="5,3 19,12 5,21"/>
        </svg>
        {{-- Pause Icon --}}
        <svg x-show="playing" width="20" height="20" viewBox="0 0 24 24" fill="white" stroke="none">
            <rect x="6" y="4" width="4" height="16"/>
            <rect x="14" y="4" width="4" height="16"/>
        </svg>
    </div>

    {{-- ============================================ --}}
    {{-- JAVASCRIPT --}}
    {{-- ============================================ --}}
    <script>
        function invitationApp() {
            return {
                opened: false,
                playing: false,

                openInvitation() {
                    this.opened = true;
                    document.body.style.overflow = 'auto';

                    // Auto-play music if enabled
                    @if($invitation->music_autoplay)
                    this.$nextTick(() => {
                        this.playMusic();
                    });
                    @endif

                    // Initialize scroll reveal
                    this.$nextTick(() => {
                        setTimeout(() => this.initReveal(), 200);
                    });
                },

                playMusic() {
                    const audio = this.$refs.audio;
                    if (audio) {
                        audio.play().then(() => {
                            this.playing = true;
                        }).catch((e) => {
                            console.log('Autoplay prevented:', e);
                        });
                    }
                },

                toggleMusic() {
                    const audio = this.$refs.audio;
                    if (!audio) return;

                    if (this.playing) {
                        audio.pause();
                        this.playing = false;
                    } else {
                        audio.play().then(() => {
                            this.playing = true;
                        }).catch((e) => {
                            console.log('Play prevented:', e);
                        });
                    }
                },

                initReveal() {
                    const observerOptions = {
                        root: null,
                        rootMargin: '0px 0px -50px 0px',
                        threshold: 0.1
                    };

                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach((entry) => {
                            if (entry.isIntersecting) {
                                entry.target.classList.add('active');
                                observer.unobserve(entry.target);
                            }
                        });
                    }, observerOptions);

                    document.querySelectorAll('.reveal').forEach((el) => {
                        observer.observe(el);
                    });
                }
            };
        }

        function countdown(targetDate) {
            return {
                days: '00',
                hours: '00',
                minutes: '00',
                seconds: '00',
                interval: null,

                init() {
                    this.calculateTime();
                    this.interval = setInterval(() => {
                        this.calculateTime();
                    }, 1000);
                },

                calculateTime() {
                    const target = new Date(targetDate).getTime();
                    const now = new Date().getTime();
                    const diff = target - now;

                    if (diff <= 0) {
                        this.days = '00';
                        this.hours = '00';
                        this.minutes = '00';
                        this.seconds = '00';
                        if (this.interval) {
                            clearInterval(this.interval);
                        }
                        return;
                    }

                    this.days = String(Math.floor(diff / (1000 * 60 * 60 * 24))).padStart(2, '0');
                    this.hours = String(Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
                    this.minutes = String(Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                    this.seconds = String(Math.floor((diff % (1000 * 60)) / 1000)).padStart(2, '0');
                },

                destroy() {
                    if (this.interval) {
                        clearInterval(this.interval);
                    }
                }
            };
        }
    </script>
</body>
</html>
