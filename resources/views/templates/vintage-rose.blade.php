<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Lora:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --dusty-rose: {{ $invitation->color_primary ?? '#C4888B' }};
            --rose-dark: {{ $invitation->color_secondary ?? '#A06568' }};
            --antique: #FAF3EB;
            --sepia: #F0E6D8;
            --brown: #6B4C3B;
            --text: #4A3728;
            --muted: #9A8577;
            --gold: #B8956B;
            --border: rgba(196,136,139,0.2);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Lora', serif;
            font-weight: 400;
            color: var(--text);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            background-color: var(--antique);
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 0v60M0 30h60' stroke='%23C4888B' stroke-width='0.3' opacity='0.04'/%3E%3C/svg%3E");
        }
        .font-display { font-family: 'EB Garamond', serif; }
        .font-script { font-family: 'Dancing Script', cursive; font-weight: 600; }
        .font-body { font-family: 'Lora', serif; }
        [x-cloak] { display: none !important; }

        /* Animations */
        .reveal { opacity: 0; transform: translateY(30px); transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
        .reveal.active { opacity: 1; transform: translateY(0); }
        .reveal-delay-1 { transition-delay: 0.2s; }
        .reveal-delay-2 { transition-delay: 0.4s; }
        .reveal-delay-3 { transition-delay: 0.6s; }

        /* Victorian Ornate Border Frame */
        .ornate-frame {
            position: relative;
            border: 2px solid var(--dusty-rose);
            padding: 40px;
            background: var(--antique);
        }
        .ornate-frame::before,
        .ornate-frame::after {
            content: '';
            position: absolute;
            border: 1px solid var(--dusty-rose);
            opacity: 0.5;
        }
        .ornate-frame::before {
            top: 8px; left: 8px; right: 8px; bottom: 8px;
        }
        .ornate-frame::after {
            top: 14px; left: 14px; right: 14px; bottom: 14px;
            border-style: dotted;
            opacity: 0.3;
        }

        /* Corner Ornaments */
        .corner-ornament {
            position: absolute;
            width: 60px;
            height: 60px;
            pointer-events: none;
        }
        .corner-ornament svg { width: 100%; height: 100%; }
        .corner-tl { top: -4px; left: -4px; }
        .corner-tr { top: -4px; right: -4px; transform: scaleX(-1); }
        .corner-bl { bottom: -4px; left: -4px; transform: scaleY(-1); }
        .corner-br { bottom: -4px; right: -4px; transform: scale(-1); }

        /* Ornate Divider */
        .ornate-divider {
            width: 240px; height: 40px; margin: 0 auto;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 240 40'%3E%3Cpath d='M20 20 C40 10, 60 10, 80 20 C90 25, 95 25, 100 20 L105 18 C108 16, 112 16, 115 18 L120 20 L125 18 C128 16, 132 16, 135 18 L140 20 C145 25, 150 25, 160 20 C180 10, 200 10, 220 20' fill='none' stroke='%23C4888B' stroke-width='1' opacity='0.6'/%3E%3Ccircle cx='120' cy='20' r='3' fill='%23C4888B' opacity='0.7'/%3E%3Ccircle cx='100' cy='20' r='1.5' fill='%23C4888B' opacity='0.4'/%3E%3Ccircle cx='140' cy='20' r='1.5' fill='%23C4888B' opacity='0.4'/%3E%3Cpath d='M108 13 L112 9 L116 13' fill='none' stroke='%23C4888B' stroke-width='0.6' opacity='0.4'/%3E%3Cpath d='M124 13 L128 9 L132 13' fill='none' stroke='%23C4888B' stroke-width='0.6' opacity='0.4'/%3E%3C/svg%3E") no-repeat center/contain;
        }
        .ornate-divider-sm {
            width: 140px; height: 24px; margin: 0 auto;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 140 24'%3E%3Cpath d='M10 12 C30 5, 50 5, 70 12 C90 19, 110 19, 130 12' fill='none' stroke='%23C4888B' stroke-width='0.8' opacity='0.5'/%3E%3Ccircle cx='70' cy='12' r='2.5' fill='%23C4888B' opacity='0.6'/%3E%3Cpath d='M60 8 L64 5 L68 8' fill='none' stroke='%23C4888B' stroke-width='0.5' opacity='0.35'/%3E%3Cpath d='M72 8 L76 5 L80 8' fill='none' stroke='%23C4888B' stroke-width='0.5' opacity='0.35'/%3E%3C/svg%3E") no-repeat center/contain;
        }

        /* Vintage Card */
        .vintage-card {
            background: var(--antique);
            border: 1.5px solid var(--border);
            border-radius: 4px;
            box-shadow: 0 4px 20px rgba(107,76,59,0.06), inset 0 0 60px rgba(240,230,216,0.5);
            position: relative;
        }
        .vintage-card::before {
            content: '';
            position: absolute;
            top: 6px; left: 6px; right: 6px; bottom: 6px;
            border: 1px solid rgba(196,136,139,0.15);
            border-radius: 2px;
            pointer-events: none;
        }

        /* Vintage Photo Frame */
        .vintage-photo-frame {
            position: relative;
            padding: 8px;
            background: linear-gradient(135deg, #f5ede3, #ebe2d6);
            border: 2px solid var(--dusty-rose);
            box-shadow: 0 6px 24px rgba(107,76,59,0.12), inset 0 2px 4px rgba(255,255,255,0.6);
        }
        .vintage-photo-frame::before {
            content: '';
            position: absolute;
            top: 3px; left: 3px; right: 3px; bottom: 3px;
            border: 1px solid rgba(196,136,139,0.3);
            pointer-events: none;
        }
        .vintage-photo-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: saturate(0.85);
            transition: filter 0.5s ease;
        }
        .vintage-photo-frame:hover img {
            filter: saturate(0.6) sepia(0.2);
        }

        /* Buttons */
        .btn-vintage {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 14px 32px;
            background: linear-gradient(135deg, var(--dusty-rose) 0%, var(--rose-dark) 100%);
            color: white; font-family: 'EB Garamond', serif; font-weight: 500; font-size: 15px;
            border-radius: 50px; border: none; cursor: pointer;
            box-shadow: 0 4px 16px rgba(196,136,139,0.3);
            transition: all 0.3s ease;
            text-decoration: none;
            letter-spacing: 0.5px;
        }
        .btn-vintage:hover { transform: translateY(-2px); box-shadow: 0 6px 24px rgba(196,136,139,0.4); }

        .btn-outline-vintage {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 12px 28px;
            border: 1.5px solid var(--dusty-rose);
            color: var(--dusty-rose); font-family: 'EB Garamond', serif; font-weight: 500; font-size: 14px;
            border-radius: 50px; cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none; background: transparent;
            letter-spacing: 0.5px;
        }
        .btn-outline-vintage:hover { background: var(--dusty-rose); color: white; }

        /* Input */
        .input-vintage {
            width: 100%; padding: 14px 18px;
            background: white; border: 1px solid var(--border);
            border-radius: 4px; font-size: 14px; color: var(--text);
            transition: border-color 0.3s;
            font-family: 'Lora', serif;
        }
        .input-vintage:focus { outline: none; border-color: var(--dusty-rose); box-shadow: 0 0 0 3px rgba(196,136,139,0.1); }
        .input-vintage::placeholder { color: var(--muted); opacity: 0.6; }

        /* Postmark Badge */
        .postmark-badge {
            position: relative;
            display: inline-block;
            padding: 12px 24px;
            border: 2px solid var(--dusty-rose);
            border-radius: 50%;
            transform: rotate(-8deg);
            opacity: 0.8;
        }
        .postmark-badge::after {
            content: '';
            position: absolute;
            top: 4px; left: 4px; right: 4px; bottom: 4px;
            border: 1px dashed var(--dusty-rose);
            border-radius: 50%;
            opacity: 0.5;
        }

        /* Music */
        @keyframes rotate { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        .music-spin { animation: rotate 3s linear infinite; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--dusty-rose); border-radius: 4px; opacity: 0.5; }

        /* Countdown vintage cards */
        .countdown-card {
            background: linear-gradient(180deg, #fffdf8 0%, var(--sepia) 100%);
            border: 1.5px solid var(--border);
            border-radius: 4px;
            box-shadow: 0 3px 12px rgba(107,76,59,0.08);
            position: relative;
        }
        .countdown-card::before {
            content: '';
            position: absolute;
            top: 3px; left: 3px; right: 3px; bottom: 3px;
            border: 1px solid rgba(196,136,139,0.12);
            pointer-events: none;
        }

        /* Gallery grid */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        .gallery-grid .gallery-item:first-child {
            grid-column: span 2;
            aspect-ratio: 16/10;
        }
        .gallery-grid .gallery-item {
            aspect-ratio: 1;
            overflow: hidden;
        }

        /* Mobile Responsive */
        @media (max-width: 640px) {
            .ornate-frame { padding: 24px; }
            .ornate-divider { width: 180px; }
            .vintage-photo-frame { width: 180px !important; height: 180px !important; }
            .corner-ornament { width: 40px; height: 40px; }
            .countdown-card { padding: 12px 6px; }
            .gallery-grid { gap: 8px; }
            section { padding-left: 16px; padding-right: 16px; }
        }
    </style>
</head>

<body class="bg-[var(--antique)]" x-data="invitationApp()" x-cloak>

    <!-- ===================== OPENING COVER ===================== -->
    <section x-show="!opened" class="fixed inset-0 z-50 flex items-center justify-center"
        style="background: linear-gradient(180deg, #4A3728 0%, #6B4C3B 50%, #4A3728 100%);"
        x-transition:leave="transition ease-in duration-700"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95">

        <!-- Antique Paper Texture Overlay -->
        <div class="absolute inset-0 pointer-events-none opacity-[0.04]" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;100&quot; height=&quot;100&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cfilter id=&quot;noise&quot;%3E%3CfeTurbulence type=&quot;fractalNoise&quot; baseFrequency=&quot;0.85&quot; numOctaves=&quot;4&quot; /%3E%3C/filter%3E%3Crect width=&quot;100&quot; height=&quot;100&quot; filter=&quot;url(%23noise)&quot; opacity=&quot;0.5&quot; /%3E%3C/svg%3E');"></div>

        <!-- Ornate SVG Frame -->
        <div class="absolute inset-6 sm:inset-10 pointer-events-none">
            <svg class="w-full h-full" viewBox="0 0 400 600" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <rect x="10" y="10" width="380" height="580" stroke="#C4888B" stroke-width="1.5" opacity="0.4" rx="2"/>
                <rect x="18" y="18" width="364" height="564" stroke="#C4888B" stroke-width="0.5" opacity="0.25" rx="1"/>
                <!-- Corner Scrollwork TL -->
                <path d="M10 60 C10 30, 30 10, 60 10" stroke="#C4888B" stroke-width="1.2" opacity="0.5" fill="none"/>
                <path d="M10 80 C10 40, 40 10, 80 10" stroke="#C4888B" stroke-width="0.6" opacity="0.3" fill="none"/>
                <circle cx="30" cy="30" r="4" stroke="#C4888B" stroke-width="0.8" fill="none" opacity="0.4"/>
                <!-- Corner Scrollwork TR -->
                <path d="M390 60 C390 30, 370 10, 340 10" stroke="#C4888B" stroke-width="1.2" opacity="0.5" fill="none"/>
                <path d="M390 80 C390 40, 360 10, 320 10" stroke="#C4888B" stroke-width="0.6" opacity="0.3" fill="none"/>
                <circle cx="370" cy="30" r="4" stroke="#C4888B" stroke-width="0.8" fill="none" opacity="0.4"/>
                <!-- Corner Scrollwork BL -->
                <path d="M10 540 C10 570, 30 590, 60 590" stroke="#C4888B" stroke-width="1.2" opacity="0.5" fill="none"/>
                <path d="M10 520 C10 560, 40 590, 80 590" stroke="#C4888B" stroke-width="0.6" opacity="0.3" fill="none"/>
                <circle cx="30" cy="570" r="4" stroke="#C4888B" stroke-width="0.8" fill="none" opacity="0.4"/>
                <!-- Corner Scrollwork BR -->
                <path d="M390 540 C390 570, 370 590, 340 590" stroke="#C4888B" stroke-width="1.2" opacity="0.5" fill="none"/>
                <path d="M390 520 C390 560, 360 590, 320 590" stroke="#C4888B" stroke-width="0.6" opacity="0.3" fill="none"/>
                <circle cx="370" cy="570" r="4" stroke="#C4888B" stroke-width="0.8" fill="none" opacity="0.4"/>
            </svg>
        </div>

        <div class="text-center px-8 relative z-10 max-w-sm">
            <div class="ornate-divider mb-8 opacity-80"></div>

            <p class="text-[10px] uppercase tracking-[0.6em] text-[var(--dusty-rose)] mb-8 font-display" style="letter-spacing: 0.5em;">The Wedding Of</p>

            <h1 class="text-5xl sm:text-6xl font-script text-white leading-tight mb-2" style="text-shadow: 0 2px 20px rgba(196,136,139,0.3)">{{ $invitation->groom_name }}</h1>

            <div class="flex items-center justify-center gap-4 my-5">
                <div class="w-12 h-px bg-gradient-to-r from-transparent to-[var(--dusty-rose)] opacity-50"></div>
                <span class="text-3xl font-script text-[var(--dusty-rose)]">&</span>
                <div class="w-12 h-px bg-gradient-to-l from-transparent to-[var(--dusty-rose)] opacity-50"></div>
            </div>

            <h1 class="text-5xl sm:text-6xl font-script text-white leading-tight" style="text-shadow: 0 2px 20px rgba(196,136,139,0.3)">{{ $invitation->bride_name }}</h1>

            @if($guestName)
            <div class="mt-10 py-3 px-6 border border-[var(--dusty-rose)]/20 bg-white/5 backdrop-blur-sm inline-block" style="border-radius: 2px;">
                <p class="text-[9px] uppercase tracking-[0.4em] text-[var(--dusty-rose)]/60 mb-1 font-display">Kepada Yth.</p>
                <p class="text-base text-white font-display font-medium">{{ urldecode($guestName) }}</p>
            </div>
            @endif

            <div class="ornate-divider mt-10 mb-10 opacity-80" style="transform: scaleY(-1)"></div>

            <button @click="openInvitation()" class="btn-vintage">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Buka Undangan
            </button>

            <p class="text-xs text-white/30 mt-6 font-display">{{ $invitation->event_date->translatedFormat('d F Y') }}</p>
        </div>
    </section>

    <!-- ===================== MAIN CONTENT ===================== -->
    <div x-show="opened" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

        <!-- =================== HERO SECTION =================== -->
        <section class="min-h-screen flex items-center justify-center py-24 px-6 relative overflow-hidden">
            <!-- Subtle radial glow -->
            <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse at 50% 40%, rgba(196,136,139,0.06) 0%, transparent 60%)"></div>

            <div class="text-center max-w-lg relative z-10 reveal">
                <!-- Victorian Top Ornament -->
                <svg class="w-48 h-16 mx-auto mb-8 opacity-60" viewBox="0 0 200 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 30 C40 15, 60 15, 80 30 C85 33, 90 33, 95 30 L100 27 L105 30 C110 33, 115 33, 120 30 C140 15, 160 15, 180 30" stroke="#C4888B" stroke-width="1.2" fill="none"/>
                    <path d="M40 30 C55 22, 70 22, 85 30" stroke="#C4888B" stroke-width="0.5" opacity="0.4" fill="none"/>
                    <path d="M115 30 C130 22, 145 22, 160 30" stroke="#C4888B" stroke-width="0.5" opacity="0.4" fill="none"/>
                    <circle cx="100" cy="27" r="4" stroke="#C4888B" stroke-width="1" fill="none" opacity="0.7"/>
                    <circle cx="100" cy="27" r="1.5" fill="#C4888B" opacity="0.5"/>
                    <path d="M92 18 L96 13 L100 18 L104 13 L108 18" stroke="#C4888B" stroke-width="0.7" fill="none" opacity="0.4"/>
                    <path d="M50 42 L60 45 L70 42" stroke="#C4888B" stroke-width="0.5" opacity="0.3" fill="none"/>
                    <path d="M130 42 L140 45 L150 42" stroke="#C4888B" stroke-width="0.5" opacity="0.3" fill="none"/>
                </svg>

                <p class="text-[11px] uppercase tracking-[0.7em] text-[var(--muted)] mb-10 font-display">We Are Getting Married</p>

                <h2 class="text-6xl sm:text-7xl font-script text-[var(--rose-dark)] leading-tight">{{ $invitation->groom_name }}</h2>

                <div class="flex items-center justify-center gap-5 my-6">
                    <div class="w-16 h-px bg-gradient-to-r from-transparent to-[var(--dusty-rose)]"></div>
                    <span class="text-4xl font-script text-[var(--dusty-rose)]">&</span>
                    <div class="w-16 h-px bg-gradient-to-l from-transparent to-[var(--dusty-rose)]"></div>
                </div>

                <h2 class="text-6xl sm:text-7xl font-script text-[var(--rose-dark)] leading-tight">{{ $invitation->bride_name }}</h2>

                <!-- Postmark Date Badge -->
                <div class="mt-12 inline-block">
                    <div class="postmark-badge">
                        <p class="text-[9px] uppercase tracking-[0.2em] text-[var(--dusty-rose)] font-display">Save The Date</p>
                        <p class="text-sm font-display font-semibold text-[var(--brown)] mt-1">{{ $invitation->event_date->translatedFormat('d M Y') }}</p>
                    </div>
                </div>

                <!-- Victorian Bottom Ornament -->
                <svg class="w-48 h-16 mx-auto mt-10 opacity-60" viewBox="0 0 200 60" fill="none" xmlns="http://www.w3.org/2000/svg" style="transform: scaleY(-1)">
                    <path d="M20 30 C40 15, 60 15, 80 30 C85 33, 90 33, 95 30 L100 27 L105 30 C110 33, 115 33, 120 30 C140 15, 160 15, 180 30" stroke="#C4888B" stroke-width="1.2" fill="none"/>
                    <circle cx="100" cy="27" r="4" stroke="#C4888B" stroke-width="1" fill="none" opacity="0.7"/>
                    <circle cx="100" cy="27" r="1.5" fill="#C4888B" opacity="0.5"/>
                </svg>
            </div>
        </section>


        <!-- =================== OPENING TEXT =================== -->
        @if($invitation->opening_text)
        <section class="py-20 px-6" style="background: linear-gradient(180deg, var(--sepia) 0%, var(--antique) 100%);">
            <div class="max-w-lg mx-auto text-center reveal">
                <div class="ornate-divider-sm mb-8"></div>
                <p class="text-base sm:text-lg font-display italic text-[var(--text)] leading-loose" style="opacity: 0.85;">"{{ $invitation->opening_text }}"</p>
                <div class="ornate-divider-sm mt-8"></div>
            </div>
        </section>
        @endif

        <!-- =================== COUPLE PROFILES =================== -->
        <section class="py-20 px-6 bg-[var(--antique)]">
            <div class="max-w-lg mx-auto">
                <div class="text-center mb-14 reveal">
                    <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--muted)] mb-3 font-display">The Happy Couple</p>
                    <h3 class="text-3xl font-display font-semibold text-[var(--brown)]">Mempelai</h3>
                    <div class="ornate-divider-sm mt-4"></div>
                </div>

                <!-- Groom -->
                <div class="text-center mb-16 reveal reveal-delay-1">
                    @if($invitation->groom_photo)
                    <div class="w-52 h-52 mx-auto mb-6 vintage-photo-frame rounded-full overflow-hidden">
                        <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}" class="rounded-full">
                    </div>
                    @else
                    <div class="w-52 h-52 mx-auto mb-6 rounded-full flex items-center justify-center" style="background: var(--sepia); border: 2px solid var(--dusty-rose);">
                        <span class="text-6xl font-script text-[var(--dusty-rose)]">{{ substr($invitation->groom_name, 0, 1) }}</span>
                    </div>
                    @endif
                    <h4 class="text-2xl font-display font-semibold text-[var(--brown)] mb-2">{{ $invitation->groom_name }}</h4>
                    @if($invitation->groom_father || $invitation->groom_mother)
                    <p class="text-sm text-[var(--muted)] leading-relaxed font-body">Putra dari<br>
                        <span class="text-[var(--text)] font-medium">Bpk. {{ $invitation->groom_father }}</span> &
                        <span class="text-[var(--text)] font-medium">Ibu {{ $invitation->groom_mother }}</span>
                    </p>
                    @endif
                    @if($invitation->groom_instagram)
                    <a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" target="_blank" class="inline-flex items-center gap-1.5 mt-3 text-sm text-[var(--dusty-rose)] hover:text-[var(--rose-dark)] transition-colors font-body">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        {{ $invitation->groom_instagram }}
                    </a>
                    @endif
                </div>

                <!-- Ampersand -->
                <div class="text-center mb-16 reveal reveal-delay-2">
                    <span class="text-5xl font-script text-[var(--dusty-rose)]">&</span>
                </div>

                <!-- Bride -->
                <div class="text-center reveal reveal-delay-3">
                    @if($invitation->bride_photo)
                    <div class="w-52 h-52 mx-auto mb-6 vintage-photo-frame rounded-full overflow-hidden">
                        <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}" class="rounded-full">
                    </div>
                    @else
                    <div class="w-52 h-52 mx-auto mb-6 rounded-full flex items-center justify-center" style="background: var(--sepia); border: 2px solid var(--dusty-rose);">
                        <span class="text-6xl font-script text-[var(--dusty-rose)]">{{ substr($invitation->bride_name, 0, 1) }}</span>
                    </div>
                    @endif
                    <h4 class="text-2xl font-display font-semibold text-[var(--brown)] mb-2">{{ $invitation->bride_name }}</h4>
                    @if($invitation->bride_father || $invitation->bride_mother)
                    <p class="text-sm text-[var(--muted)] leading-relaxed font-body">Putri dari<br>
                        <span class="text-[var(--text)] font-medium">Bpk. {{ $invitation->bride_father }}</span> &
                        <span class="text-[var(--text)] font-medium">Ibu {{ $invitation->bride_mother }}</span>
                    </p>
                    @endif
                    @if($invitation->bride_instagram)
                    <a href="https://instagram.com/{{ ltrim($invitation->bride_instagram, '@') }}" target="_blank" class="inline-flex items-center gap-1.5 mt-3 text-sm text-[var(--dusty-rose)] hover:text-[var(--rose-dark)] transition-colors font-body">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        {{ $invitation->bride_instagram }}
                    </a>
                    @endif
                </div>
            </div>
        </section>

        <!-- =================== COUNTDOWN =================== -->
        <section class="py-20 px-6 relative overflow-hidden" style="background: linear-gradient(180deg, var(--brown) 0%, #5A3E2E 100%);">
            <!-- Vintage texture -->
            <div class="absolute inset-0 pointer-events-none opacity-[0.03]" style="background-image: radial-gradient(circle, var(--dusty-rose) 1px, transparent 1px); background-size: 24px 24px;"></div>

            <div class="max-w-md mx-auto text-center relative z-10 reveal" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">
                <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--dusty-rose)] mb-3 font-display">Save The Date</p>
                <h3 class="text-2xl font-display text-white mb-10">Menghitung Hari</h3>

                <div class="grid grid-cols-4 gap-3">
                    <div class="countdown-card py-5 px-2">
                        <p class="text-3xl sm:text-4xl font-display font-bold text-[var(--dusty-rose)]" x-text="days">0</p>
                        <p class="text-[9px] uppercase tracking-[0.2em] text-white/50 mt-2 font-display">Hari</p>
                    </div>
                    <div class="countdown-card py-5 px-2">
                        <p class="text-3xl sm:text-4xl font-display font-bold text-[var(--dusty-rose)]" x-text="hours">0</p>
                        <p class="text-[9px] uppercase tracking-[0.2em] text-white/50 mt-2 font-display">Jam</p>
                    </div>
                    <div class="countdown-card py-5 px-2">
                        <p class="text-3xl sm:text-4xl font-display font-bold text-[var(--dusty-rose)]" x-text="minutes">0</p>
                        <p class="text-[9px] uppercase tracking-[0.2em] text-white/50 mt-2 font-display">Menit</p>
                    </div>
                    <div class="countdown-card py-5 px-2">
                        <p class="text-3xl sm:text-4xl font-display font-bold text-[var(--dusty-rose)]" x-text="seconds">0</p>
                        <p class="text-[9px] uppercase tracking-[0.2em] text-white/50 mt-2 font-display">Detik</p>
                    </div>
                </div>
            </div>
        </section>


        <!-- =================== EVENT DETAILS =================== -->
        <section class="py-20 px-6 bg-[var(--antique)]">
            <div class="max-w-lg mx-auto text-center">
                <div class="reveal">
                    <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--muted)] mb-3 font-display">When & Where</p>
                    <h3 class="text-3xl font-display font-semibold text-[var(--brown)] mb-12">Acara Pernikahan</h3>
                </div>

                <div class="vintage-card p-8 sm:p-10 reveal reveal-delay-1">
                    <!-- Corner Ornaments -->
                    <div class="corner-ornament corner-tl">
                        <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 55 C5 30, 30 5, 55 5" stroke="#C4888B" stroke-width="1" opacity="0.5" fill="none"/>
                            <path d="M5 40 C5 20, 20 5, 40 5" stroke="#C4888B" stroke-width="0.5" opacity="0.3" fill="none"/>
                            <circle cx="15" cy="15" r="3" stroke="#C4888B" stroke-width="0.8" fill="none" opacity="0.4"/>
                        </svg>
                    </div>
                    <div class="corner-ornament corner-tr">
                        <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 55 C5 30, 30 5, 55 5" stroke="#C4888B" stroke-width="1" opacity="0.5" fill="none"/>
                            <path d="M5 40 C5 20, 20 5, 40 5" stroke="#C4888B" stroke-width="0.5" opacity="0.3" fill="none"/>
                            <circle cx="15" cy="15" r="3" stroke="#C4888B" stroke-width="0.8" fill="none" opacity="0.4"/>
                        </svg>
                    </div>
                    <div class="corner-ornament corner-bl">
                        <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 55 C5 30, 30 5, 55 5" stroke="#C4888B" stroke-width="1" opacity="0.5" fill="none"/>
                            <path d="M5 40 C5 20, 20 5, 40 5" stroke="#C4888B" stroke-width="0.5" opacity="0.3" fill="none"/>
                            <circle cx="15" cy="15" r="3" stroke="#C4888B" stroke-width="0.8" fill="none" opacity="0.4"/>
                        </svg>
                    </div>
                    <div class="corner-ornament corner-br">
                        <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 55 C5 30, 30 5, 55 5" stroke="#C4888B" stroke-width="1" opacity="0.5" fill="none"/>
                            <path d="M5 40 C5 20, 20 5, 40 5" stroke="#C4888B" stroke-width="0.5" opacity="0.3" fill="none"/>
                            <circle cx="15" cy="15" r="3" stroke="#C4888B" stroke-width="0.8" fill="none" opacity="0.4"/>
                        </svg>
                    </div>

                    <div class="w-14 h-14 mx-auto mb-6 rounded-full flex items-center justify-center" style="background: var(--sepia); border: 1px solid var(--border);">
                        <svg class="w-6 h-6 text-[var(--dusty-rose)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>

                    <h4 class="text-xl font-display font-semibold text-[var(--brown)] mb-5">{{ $invitation->event_venue }}</h4>

                    <div class="space-y-1.5 text-sm text-[var(--muted)] mb-6 font-body">
                        <p class="font-medium text-[var(--text)]">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                        <p>Pukul {{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }} {{ $invitation->event_time_end ? '- ' . \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') : '' }} WIB</p>
                    </div>

                    @if($invitation->event_address)
                    <p class="text-xs text-[var(--muted)] mb-8 max-w-xs mx-auto leading-relaxed font-body">{{ $invitation->event_address }}</p>
                    @endif

                    <div class="ornate-divider-sm mb-8"></div>

                    @if($invitation->event_maps_url)
                    <a href="{{ $invitation->event_maps_url }}" target="_blank" class="btn-vintage text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        Buka Maps
                    </a>
                    @endif
                </div>

                @if($invitation->dress_code)
                <div class="mt-6 inline-flex items-center gap-2 px-5 py-2.5 bg-[var(--sepia)] border border-[var(--border)] reveal reveal-delay-2" style="border-radius: 2px;">
                    <svg class="w-4 h-4 text-[var(--dusty-rose)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span class="text-xs text-[var(--text)] font-display">Dress Code: <strong>{{ $invitation->dress_code }}</strong></span>
                </div>
                @endif
            </div>
        </section>

        <!-- =================== GALLERY =================== -->
        @if($invitation->galleries->count() > 0)
        <section class="py-20 px-6" style="background: var(--sepia);">
            <div class="max-w-lg mx-auto">
                <div class="text-center mb-12 reveal">
                    <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--muted)] mb-3 font-display">Our Moments</p>
                    <h3 class="text-3xl font-display font-semibold text-[var(--brown)]">Galeri</h3>
                    <div class="ornate-divider-sm mt-4"></div>
                </div>
                <div class="gallery-grid reveal reveal-delay-1">
                    @foreach($invitation->galleries as $i => $photo)
                    <div class="gallery-item vintage-photo-frame {{ $i === 0 ? 'col-span-2' : '' }}">
                        <img src="{{ $photo->getImageUrl() }}" alt="{{ $photo->caption ?? 'Gallery photo' }}" class="w-full h-full object-cover" loading="lazy">
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif


        <!-- =================== RSVP =================== -->
        <section class="py-20 px-6 bg-[var(--antique)]">
            <div class="max-w-sm mx-auto">
                <div class="text-center mb-10 reveal">
                    <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--muted)] mb-3 font-display">Attendance</p>
                    <h3 class="text-3xl font-display font-semibold text-[var(--brown)]">RSVP</h3>
                    <p class="text-sm text-[var(--muted)] mt-3 font-body">Konfirmasi kehadiran Anda</p>
                    <div class="ornate-divider-sm mt-4"></div>
                </div>

                @if(session('rsvp_success'))
                <div class="mb-5 p-4 bg-green-50 border border-green-200 text-green-700 text-sm text-center font-body" style="border-radius: 2px;">{{ session('rsvp_success') }}</div>
                @endif

                <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" class="space-y-4 reveal reveal-delay-1">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Lengkap" required class="input-vintage">
                    <select name="rsvp_status" required class="input-vintage">
                        <option value="">-- Konfirmasi Kehadiran --</option>
                        <option value="attending">Ya, Saya Akan Hadir</option>
                        <option value="not_attending">Maaf, Tidak Bisa Hadir</option>
                        <option value="maybe">Masih Belum Pasti</option>
                    </select>
                    <input type="number" name="number_of_guests" min="1" max="10" value="1" placeholder="Jumlah Tamu" class="input-vintage">
                    <button type="submit" class="btn-vintage w-full justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Kirim Konfirmasi
                    </button>
                </form>
            </div>
        </section>

        <!-- =================== GUESTBOOK =================== -->
        <section class="py-20 px-6" style="background: var(--sepia);">
            <div class="max-w-md mx-auto">
                <div class="text-center mb-10 reveal">
                    <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--muted)] mb-3 font-display">Wishes</p>
                    <h3 class="text-3xl font-display font-semibold text-[var(--brown)]">Ucapan & Doa</h3>
                    <div class="ornate-divider-sm mt-4"></div>
                </div>

                <form method="POST" action="{{ route('invitation.guestbook', $invitation->slug) }}" class="space-y-4 mb-10 reveal reveal-delay-1">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Anda" required class="input-vintage">
                    <textarea name="message" rows="4" placeholder="Tulis ucapan & doa terbaik Anda..." required class="input-vintage" style="resize: none;"></textarea>
                    <button type="submit" class="btn-outline-vintage w-full justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        Kirim Ucapan
                    </button>
                </form>

                @if(session('guestbook_success'))
                <div class="mb-5 p-4 bg-green-50 border border-green-200 text-green-700 text-sm text-center font-body" style="border-radius: 2px;">{{ session('guestbook_success') }}</div>
                @endif

                <div class="space-y-3 max-h-80 overflow-y-auto pr-1 reveal reveal-delay-2">
                    @foreach($invitation->guestbooks as $msg)
                    <div class="vintage-card p-5">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0" style="background: var(--sepia); border: 1px solid var(--border);">
                                <span class="text-xs font-bold text-[var(--dusty-rose)] font-display">{{ strtoupper(substr($msg->name, 0, 1)) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-[var(--brown)] font-display">{{ $msg->name }}</p>
                                <p class="text-sm text-[var(--muted)] mt-1 leading-relaxed font-body">{{ $msg->message }}</p>
                                <p class="text-[10px] text-[var(--muted)] mt-2 font-body" style="opacity: 0.6;">{{ $msg->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>


        <!-- =================== DIGITAL ENVELOPE =================== -->
        @if($invitation->bank_name || $invitation->qris_image)
        <section class="py-20 px-6 bg-[var(--antique)]">
            <div class="max-w-sm mx-auto text-center">
                <div class="reveal">
                    <div class="w-14 h-14 mx-auto mb-6 rounded-full flex items-center justify-center" style="background: var(--sepia); border: 1px solid var(--border);">
                        <svg class="w-6 h-6 text-[var(--gold)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--muted)] mb-3 font-display">Wedding Gift</p>
                    <h3 class="text-3xl font-display font-semibold text-[var(--brown)] mb-3">Amplop Digital</h3>
                    @if($invitation->gift_info)
                    <p class="text-sm text-[var(--muted)] mb-8 leading-relaxed font-body">{{ $invitation->gift_info }}</p>
                    @else
                    <p class="text-sm text-[var(--muted)] mb-8 font-body">Doa restu Anda sudah cukup. Namun jika berkenan memberi tanda kasih:</p>
                    @endif
                    <div class="ornate-divider-sm mb-8"></div>
                </div>

                @if($invitation->bank_name)
                <div class="vintage-card p-6 mb-4 reveal reveal-delay-1" x-data="{ copied: false }">
                    <p class="text-[10px] uppercase tracking-[0.3em] text-[var(--muted)] mb-2 font-display">{{ $invitation->bank_name }}</p>
                    <p class="text-2xl font-bold text-[var(--brown)] tracking-wider mb-1 font-display">{{ $invitation->bank_account_number }}</p>
                    <p class="text-sm text-[var(--muted)] font-body">a.n. {{ $invitation->bank_account_name }}</p>
                    <button @click="navigator.clipboard.writeText('{{ $invitation->bank_account_number }}'); copied = true; setTimeout(() => copied = false, 2000)" class="mt-4 px-5 py-2 text-xs font-semibold transition-all font-display" style="background: var(--sepia); color: var(--dusty-rose); border: 1px solid var(--border); border-radius: 50px;" onmouseover="this.style.background='var(--dusty-rose)'; this.style.color='white';" onmouseout="this.style.background='var(--sepia)'; this.style.color='var(--dusty-rose)';">
                        <span x-text="copied ? '✓ Tersalin!' : 'Salin Nomor'"></span>
                    </button>
                </div>
                @endif

                @if($invitation->qris_image)
                <div class="vintage-card p-5 inline-block reveal reveal-delay-2">
                    <img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS" class="w-48 h-48 object-contain mx-auto">
                    <p class="text-[10px] text-[var(--muted)] mt-3 font-display">Scan QRIS</p>
                </div>
                @endif
            </div>
        </section>
        @endif

        <!-- =================== CLOSING TEXT =================== -->
        @if($invitation->closing_text)
        <section class="py-20 px-6 text-center relative overflow-hidden" style="background: linear-gradient(180deg, var(--brown) 0%, #5A3E2E 100%);">
            <!-- Texture overlay -->
            <div class="absolute inset-0 pointer-events-none opacity-[0.03]" style="background-image: radial-gradient(circle, var(--dusty-rose) 1px, transparent 1px); background-size: 20px 20px;"></div>

            <div class="max-w-md mx-auto relative z-10 reveal">
                <!-- Ornate top frame -->
                <svg class="w-40 h-12 mx-auto mb-8 opacity-60" viewBox="0 0 160 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 24 C30 10, 50 10, 70 24 C75 27, 78 27, 80 24 L80 22 L80 24 C82 27, 85 27, 90 24 C110 10, 130 10, 150 24" stroke="#C4888B" stroke-width="1" fill="none"/>
                    <circle cx="80" cy="22" r="3" stroke="#C4888B" stroke-width="0.8" fill="none" opacity="0.6"/>
                    <circle cx="80" cy="22" r="1" fill="#C4888B" opacity="0.5"/>
                </svg>

                <p class="text-base sm:text-lg font-display italic text-white/80 leading-loose mb-8">"{{ $invitation->closing_text }}"</p>

                <p class="text-sm text-white/50 font-display">Dengan penuh cinta,</p>
                <p class="text-2xl font-script text-[var(--dusty-rose)] mt-2">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</p>

                <!-- Ornate bottom frame -->
                <svg class="w-40 h-12 mx-auto mt-8 opacity-60" viewBox="0 0 160 48" fill="none" xmlns="http://www.w3.org/2000/svg" style="transform: scaleY(-1)">
                    <path d="M10 24 C30 10, 50 10, 70 24 C75 27, 78 27, 80 24 L80 22 L80 24 C82 27, 85 27, 90 24 C110 10, 130 10, 150 24" stroke="#C4888B" stroke-width="1" fill="none"/>
                    <circle cx="80" cy="22" r="3" stroke="#C4888B" stroke-width="0.8" fill="none" opacity="0.6"/>
                    <circle cx="80" cy="22" r="1" fill="#C4888B" opacity="0.5"/>
                </svg>
            </div>
        </section>
        @endif

        <!-- =================== FOOTER =================== -->
        <footer class="py-10 px-6 text-center" style="background: var(--sepia); border-top: 1px solid var(--border);">
            <div class="max-w-md mx-auto reveal">
                <div class="ornate-divider-sm mb-6"></div>
                <p class="text-sm font-display text-[var(--muted)] mb-2">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</p>
                <p class="text-xs text-[var(--muted)] font-body" style="opacity: 0.6;">{{ $invitation->event_date->translatedFormat('d F Y') }}</p>
                <div class="ornate-divider-sm mt-6"></div>
                <p class="text-[10px] text-[var(--muted)] mt-6 font-body" style="opacity: 0.4;">Crafted with love</p>
            </div>
        </footer>

    </div><!-- End main content wrapper -->


    <!-- =================== FLOATING MUSIC PLAYER =================== -->
    @if($invitation->music_url)
    <div x-show="opened" class="fixed bottom-6 right-6 z-40" x-transition>
        <button @click="toggleMusic()" class="w-12 h-12 rounded-full flex items-center justify-center shadow-lg transition-all duration-300 hover:scale-110"
            style="background: linear-gradient(135deg, var(--dusty-rose), var(--rose-dark)); border: 2px solid rgba(255,255,255,0.2);">
            <svg x-show="!playing" class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
            <svg x-show="playing" class="w-5 h-5 text-white" :class="playing ? 'music-spin' : ''" fill="currentColor" viewBox="0 0 24 24"><path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
        </button>
    </div>
    <audio x-ref="audio" loop preload="auto">
        <source src="{{ asset('storage/' . $invitation->music_url) }}" type="audio/mpeg">
    </audio>
    @endif

    <!-- =================== ALPINE.JS APP =================== -->
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
                    const audio = this.$refs.audio;
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

                playMusic() {
                    const audio = this.$refs.audio;
                    if (!audio) return;
                    audio.play().then(() => {
                        this.playing = true;
                    }).catch(() => {
                        this.playing = false;
                    });
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
                    this.calculateTime(targetDate);
                    this.interval = setInterval(() => {
                        this.calculateTime(targetDate);
                    }, 1000);
                },

                calculateTime(target) {
                    const now = new Date().getTime();
                    const eventTime = new Date(target).getTime();
                    const diff = eventTime - now;

                    if (diff <= 0) {
                        this.days = '0';
                        this.hours = '0';
                        this.minutes = '0';
                        this.seconds = '0';
                        if (this.interval) clearInterval(this.interval);
                        return;
                    }

                    this.days = Math.floor(diff / (1000 * 60 * 60 * 24)).toString();
                    this.hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString();
                    this.minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60)).toString();
                    this.seconds = Math.floor((diff % (1000 * 60)) / 1000).toString();
                },

                destroy() {
                    if (this.interval) clearInterval(this.interval);
                }
            }
        }
    </script>
</body>
</html>
