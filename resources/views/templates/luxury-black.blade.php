<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Raleway:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,300;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --gold: {{ $invitation->color_primary ?? '#B8860B' }};
            --gold-mid: #D4A843;
            --gold-light: #E8C978;
            --dark: {{ $invitation->color_secondary ?? '#050505' }};
            --dark-card: #0a0a0a;
            --body-bg: #050505;
            --text: #c8c8c8;
            --text-muted: #7a7a7a;
            --border-gold: rgba(184,134,11,0.2);
            --glow-gold: rgba(184,134,11,0.15);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Raleway', sans-serif; font-weight: 300; color: var(--text); overflow-x: hidden; -webkit-font-smoothing: antialiased; background: var(--body-bg); }
        .font-display { font-family: 'Cinzel Decorative', serif; }
        [x-cloak] { display: none !important; }

        /* Gold Gradient Text */
        .gold-text {
            background: linear-gradient(135deg, #B8860B 0%, #D4A843 40%, #E8C978 50%, #D4A843 60%, #B8860B 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Scroll Reveal */
        .reveal { opacity: 0; transform: translateY(40px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal.active { opacity: 1; transform: translateY(0); }
        .reveal-delay-1 { transition-delay: 0.15s; }
        .reveal-delay-2 { transition-delay: 0.3s; }
        .reveal-delay-3 { transition-delay: 0.45s; }
        .reveal-delay-4 { transition-delay: 0.6s; }

        /* Glassmorphism Card */
        .glass-card {
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--border-gold);
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.4), inset 0 1px 0 rgba(184,134,11,0.1);
        }

        /* Corner Ornaments */
        .corner-tl, .corner-tr, .corner-bl, .corner-br {
            position: absolute; width: 60px; height: 60px; pointer-events: none; opacity: 0.5;
        }
        .corner-tl { top: 20px; left: 20px; border-top: 1px solid var(--gold); border-left: 1px solid var(--gold); }
        .corner-tr { top: 20px; right: 20px; border-top: 1px solid var(--gold); border-right: 1px solid var(--gold); }
        .corner-bl { bottom: 20px; left: 20px; border-bottom: 1px solid var(--gold); border-left: 1px solid var(--gold); }
        .corner-br { bottom: 20px; right: 20px; border-bottom: 1px solid var(--gold); border-right: 1px solid var(--gold); }
        .corner-tl::after, .corner-tr::after, .corner-bl::after, .corner-br::after {
            content: ''; position: absolute; width: 6px; height: 6px;
            background: var(--gold); border-radius: 50%; opacity: 0.6;
        }
        .corner-tl::after { top: -3px; left: -3px; }
        .corner-tr::after { top: -3px; right: -3px; }
        .corner-bl::after { bottom: -3px; left: -3px; }
        .corner-br::after { bottom: -3px; right: -3px; }

        /* Diamond Divider */
        .diamond-divider {
            display: flex; align-items: center; justify-content: center; gap: 12px; padding: 20px 0;
        }
        .diamond-divider::before, .diamond-divider::after {
            content: ''; width: 60px; height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }
        .diamond-divider span {
            width: 10px; height: 10px; border: 1px solid var(--gold);
            transform: rotate(45deg); opacity: 0.7;
        }

        /* Buttons */
        .btn-luxury {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 16px 36px;
            background: linear-gradient(135deg, #B8860B 0%, #D4A843 50%, #B8860B 100%);
            background-size: 200% 200%;
            color: #050505; font-weight: 600; font-size: 13px;
            border-radius: 50px; border: none; cursor: pointer;
            box-shadow: 0 4px 24px rgba(184,134,11,0.3), 0 0 0 1px rgba(184,134,11,0.4);
            transition: all 0.4s ease;
            text-decoration: none; text-transform: uppercase; letter-spacing: 0.15em;
            position: relative; overflow: hidden;
        }
        .btn-luxury::after {
            content: ''; position: absolute; top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.3) 50%, transparent 70%);
            animation: shimmer 3s infinite;
        }
        .btn-luxury:hover { transform: translateY(-2px); box-shadow: 0 8px 32px rgba(184,134,11,0.5), 0 0 0 1px rgba(184,134,11,0.6); background-position: 100% 100%; }

        .btn-outline-lux {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 14px 30px;
            border: 1px solid var(--border-gold);
            color: var(--gold-mid); font-weight: 500; font-size: 12px;
            border-radius: 50px; cursor: pointer;
            transition: all 0.4s ease;
            text-decoration: none; background: transparent;
            text-transform: uppercase; letter-spacing: 0.1em;
        }
        .btn-outline-lux:hover { background: rgba(184,134,11,0.1); border-color: var(--gold); color: var(--gold-light); }

        /* Input Fields */
        .input-dark {
            width: 100%; padding: 16px 20px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(184,134,11,0.15);
            border-radius: 14px; font-size: 14px; color: var(--text);
            transition: all 0.3s ease;
            font-family: 'Raleway', sans-serif; font-weight: 300;
            backdrop-filter: blur(4px);
        }
        .input-dark:focus { outline: none; border-color: var(--gold); box-shadow: 0 0 20px rgba(184,134,11,0.1); }
        .input-dark::placeholder { color: var(--text-muted); opacity: 0.6; }
        .input-dark option { background: #111; color: var(--text); }

        /* Photo Frame */
        .photo-frame {
            position: relative; border-radius: 50%; overflow: hidden;
            padding: 3px;
            background: linear-gradient(135deg, #B8860B, #D4A843, #B8860B);
            box-shadow: 0 0 30px rgba(184,134,11,0.2), 0 0 60px rgba(184,134,11,0.05);
        }
        .photo-frame img { border-radius: 50%; width: 100%; height: 100%; object-fit: cover; }

        /* Animations */
        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-8px); } }
        @keyframes pulse-glow { 0%, 100% { opacity: 0.3; } 50% { opacity: 0.7; } }
        @keyframes particle-drift {
            0% { transform: translateY(0) translateX(0) scale(0); opacity: 0; }
            20% { opacity: 1; transform: scale(1); }
            100% { transform: translateY(-100vh) translateX(20px) scale(0.3); opacity: 0; }
        }
        @keyframes rotate { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }

        .float-animation { animation: float 4s ease-in-out infinite; }
        .music-spin { animation: rotate 3s linear infinite; }

        /* Gold Particles */
        .particles-container { position: absolute; inset: 0; overflow: hidden; pointer-events: none; }
        .particle {
            position: absolute; bottom: -10px;
            width: 2px; height: 2px;
            background: var(--gold);
            border-radius: 50%;
            animation: particle-drift linear infinite;
            opacity: 0;
        }

        /* Radial Glow */
        .radial-glow {
            position: absolute; width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(184,134,11,0.08) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 3px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 4px; opacity: 0.3; }

        /* Mobile Responsive */
        @media (max-width: 640px) {
            .corner-tl, .corner-tr, .corner-bl, .corner-br { width: 40px; height: 40px; }
            .photo-frame { width: 140px !important; height: 140px !important; }
            .diamond-divider::before, .diamond-divider::after { width: 40px; }
            section { padding-left: 16px; padding-right: 16px; }
        }
    </style>
</head>
<body x-data="invitationApp()" x-cloak>


    <!-- ===================== OPENING COVER ===================== -->
    <section x-show="!opened" class="fixed inset-0 z-50 flex items-center justify-center"
        style="background: radial-gradient(ellipse at 50% 50%, #0d0d0d 0%, #050505 100%);"
        x-transition:leave="transition ease-in duration-700"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-110">

        <div class="corner-tl"></div>
        <div class="corner-tr"></div>
        <div class="corner-bl"></div>
        <div class="corner-br"></div>

        <!-- Particle dust effect -->
        <div class="particles-container">
            <div class="particle" style="left:10%; animation-duration:8s; animation-delay:0s;"></div>
            <div class="particle" style="left:20%; animation-duration:12s; animation-delay:1s;"></div>
            <div class="particle" style="left:35%; animation-duration:9s; animation-delay:2s;"></div>
            <div class="particle" style="left:50%; animation-duration:11s; animation-delay:0.5s;"></div>
            <div class="particle" style="left:65%; animation-duration:10s; animation-delay:3s;"></div>
            <div class="particle" style="left:75%; animation-duration:13s; animation-delay:1.5s;"></div>
            <div class="particle" style="left:85%; animation-duration:8s; animation-delay:2.5s;"></div>
            <div class="particle" style="left:92%; animation-duration:14s; animation-delay:4s;"></div>
        </div>

        <!-- Radial glow -->
        <div class="radial-glow" style="top: 50%; left: 50%; transform: translate(-50%, -50%); animation: pulse-glow 4s ease-in-out infinite;"></div>

        <div class="text-center px-8 relative z-10 max-w-sm">
            <div class="diamond-divider mb-10">
                <span></span>
            </div>

            <p class="text-[10px] uppercase tracking-[0.6em] text-[var(--gold-mid)] mb-10 font-light">The Wedding Of</p>

            <h1 class="text-4xl sm:text-5xl font-display gold-text leading-tight mb-3">{{ $invitation->groom_name }}</h1>

            <div class="flex items-center justify-center gap-5 my-6">
                <div class="w-16 h-px bg-gradient-to-r from-transparent via-[var(--gold)] to-transparent opacity-40"></div>
                <span class="text-3xl font-display gold-text">&</span>
                <div class="w-16 h-px bg-gradient-to-r from-transparent via-[var(--gold)] to-transparent opacity-40"></div>
            </div>

            <h1 class="text-4xl sm:text-5xl font-display gold-text leading-tight">{{ $invitation->bride_name }}</h1>

            @if($guestName)
            <div class="mt-12 py-4 px-8 glass-card inline-block">
                <p class="text-[9px] uppercase tracking-[0.4em] text-[var(--text-muted)] mb-1.5">Kepada Yth.</p>
                <p class="text-base text-white font-medium tracking-wide">{{ urldecode($guestName) }}</p>
            </div>
            @endif

            <div class="diamond-divider mt-12 mb-10">
                <span></span>
            </div>

            <button @click="openInvitation()" class="btn-luxury">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Buka Undangan
            </button>

            <p class="text-[10px] text-[var(--text-muted)] mt-8 tracking-wider">{{ $invitation->event_date->translatedFormat('d F Y') }}</p>
        </div>
    </section>


    <!-- ===================== MAIN CONTENT ===================== -->
    <div x-show="opened" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

        <!-- HERO -->
        <section class="min-h-screen flex items-center justify-center py-28 px-6 relative overflow-hidden">
            <!-- Background effects -->
            <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse at 50% 20%, rgba(184,134,11,0.04) 0%, transparent 60%);"></div>
            <div class="particles-container">
                <div class="particle" style="left:15%; animation-duration:10s; animation-delay:0s;"></div>
                <div class="particle" style="left:40%; animation-duration:14s; animation-delay:2s;"></div>
                <div class="particle" style="left:60%; animation-duration:11s; animation-delay:1s;"></div>
                <div class="particle" style="left:80%; animation-duration:13s; animation-delay:3s;"></div>
            </div>

            <div class="text-center max-w-lg relative z-10 reveal">
                <div class="diamond-divider mb-12">
                    <span></span>
                </div>

                <p class="text-[10px] uppercase tracking-[0.7em] text-[var(--text-muted)] mb-12 font-light">We Are Getting Married</p>

                <h2 class="text-5xl sm:text-6xl font-display gold-text leading-tight">{{ $invitation->groom_name }}</h2>

                <div class="flex items-center justify-center gap-6 my-8">
                    <div class="w-20 h-px bg-gradient-to-r from-transparent via-[var(--gold)] to-transparent opacity-50"></div>
                    <div class="w-3 h-3 border border-[var(--gold)] transform rotate-45 opacity-60"></div>
                    <div class="w-20 h-px bg-gradient-to-r from-transparent via-[var(--gold)] to-transparent opacity-50"></div>
                </div>

                <h2 class="text-5xl sm:text-6xl font-display gold-text leading-tight">{{ $invitation->bride_name }}</h2>

                <div class="mt-14 inline-flex items-center gap-3 px-6 py-3 glass-card rounded-full">
                    <svg class="w-4 h-4 text-[var(--gold-mid)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span class="text-sm text-[var(--text)] font-light tracking-wide">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</span>
                </div>

                <div class="diamond-divider mt-14">
                    <span></span>
                </div>
            </div>
        </section>

        <!-- OPENING TEXT -->
        @if($invitation->opening_text)
        <section class="py-24 px-6 relative">
            <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse at 50% 50%, rgba(184,134,11,0.03) 0%, transparent 50%);"></div>
            <div class="max-w-lg mx-auto text-center reveal">
                <div class="diamond-divider mb-10">
                    <span></span>
                </div>
                <p class="text-base sm:text-lg italic text-[var(--text)] leading-loose font-light">"{{ $invitation->opening_text }}"</p>
                <div class="diamond-divider mt-10">
                    <span></span>
                </div>
            </div>
        </section>
        @endif


        <!-- COUPLE -->
        <section class="py-24 px-6 relative">
            <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse at 30% 50%, rgba(184,134,11,0.03) 0%, transparent 40%), radial-gradient(ellipse at 70% 50%, rgba(184,134,11,0.03) 0%, transparent 40%);"></div>

            <div class="max-w-lg mx-auto">
                <div class="text-center mb-16 reveal">
                    <p class="text-[9px] uppercase tracking-[0.6em] text-[var(--text-muted)] mb-3">The Happy Couple</p>
                    <h3 class="text-2xl font-display gold-text">Mempelai</h3>
                </div>

                <!-- Groom -->
                <div class="text-center mb-16 reveal reveal-delay-1">
                    @if($invitation->groom_photo)
                    <div class="w-44 h-44 mx-auto mb-8 photo-frame">
                        <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}">
                    </div>
                    @else
                    <div class="w-44 h-44 mx-auto mb-8 rounded-full flex items-center justify-center border border-[var(--border-gold)] bg-white/[0.02]" style="box-shadow: 0 0 30px rgba(184,134,11,0.1);">
                        <span class="text-5xl font-display gold-text">{{ substr($invitation->groom_name, 0, 1) }}</span>
                    </div>
                    @endif
                    <h4 class="text-2xl font-display gold-text mb-3">{{ $invitation->groom_name }}</h4>
                    @if($invitation->groom_father || $invitation->groom_mother)
                    <p class="text-sm text-[var(--text-muted)] leading-relaxed font-light">Putra dari<br>
                        <span class="text-[var(--text)]">Bpk. {{ $invitation->groom_father }}</span> &
                        <span class="text-[var(--text)]">Ibu {{ $invitation->groom_mother }}</span>
                    </p>
                    @endif
                    @if($invitation->groom_instagram)
                    <a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" target="_blank" class="inline-flex items-center gap-2 mt-4 text-sm text-[var(--gold-mid)] hover:text-[var(--gold-light)] transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        {{ $invitation->groom_instagram }}
                    </a>
                    @endif
                </div>

                <!-- Divider -->
                <div class="text-center mb-16 reveal reveal-delay-2">
                    <div class="w-3 h-3 mx-auto border border-[var(--gold)] transform rotate-45 opacity-60"></div>
                </div>

                <!-- Bride -->
                <div class="text-center reveal reveal-delay-3">
                    @if($invitation->bride_photo)
                    <div class="w-44 h-44 mx-auto mb-8 photo-frame">
                        <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}">
                    </div>
                    @else
                    <div class="w-44 h-44 mx-auto mb-8 rounded-full flex items-center justify-center border border-[var(--border-gold)] bg-white/[0.02]" style="box-shadow: 0 0 30px rgba(184,134,11,0.1);">
                        <span class="text-5xl font-display gold-text">{{ substr($invitation->bride_name, 0, 1) }}</span>
                    </div>
                    @endif
                    <h4 class="text-2xl font-display gold-text mb-3">{{ $invitation->bride_name }}</h4>
                    @if($invitation->bride_father || $invitation->bride_mother)
                    <p class="text-sm text-[var(--text-muted)] leading-relaxed font-light">Putri dari<br>
                        <span class="text-[var(--text)]">Bpk. {{ $invitation->bride_father }}</span> &
                        <span class="text-[var(--text)]">Ibu {{ $invitation->bride_mother }}</span>
                    </p>
                    @endif
                    @if($invitation->bride_instagram)
                    <a href="https://instagram.com/{{ ltrim($invitation->bride_instagram, '@') }}" target="_blank" class="inline-flex items-center gap-2 mt-4 text-sm text-[var(--gold-mid)] hover:text-[var(--gold-light)] transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        {{ $invitation->bride_instagram }}
                    </a>
                    @endif
                </div>
            </div>
        </section>


        <!-- COUNTDOWN -->
        <section class="py-24 px-6 relative overflow-hidden">
            <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse at 50% 50%, rgba(184,134,11,0.05) 0%, transparent 60%);"></div>
            <div class="absolute inset-0 pointer-events-none opacity-[0.02]" style="background-image: radial-gradient(circle, var(--gold) 1px, transparent 1px); background-size: 40px 40px;"></div>

            <div class="max-w-md mx-auto text-center relative z-10 reveal" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">
                <p class="text-[9px] uppercase tracking-[0.6em] text-[var(--text-muted)] mb-3">Save The Date</p>
                <h3 class="text-2xl font-display gold-text mb-12">Menghitung Hari</h3>

                <div class="grid grid-cols-4 gap-3 sm:gap-4">
                    <div class="glass-card py-6 px-2 text-center">
                        <p class="text-3xl sm:text-4xl font-bold gold-text" x-text="days">0</p>
                        <p class="text-[8px] uppercase tracking-[0.3em] text-[var(--text-muted)] mt-3">Hari</p>
                    </div>
                    <div class="glass-card py-6 px-2 text-center">
                        <p class="text-3xl sm:text-4xl font-bold gold-text" x-text="hours">0</p>
                        <p class="text-[8px] uppercase tracking-[0.3em] text-[var(--text-muted)] mt-3">Jam</p>
                    </div>
                    <div class="glass-card py-6 px-2 text-center">
                        <p class="text-3xl sm:text-4xl font-bold gold-text" x-text="minutes">0</p>
                        <p class="text-[8px] uppercase tracking-[0.3em] text-[var(--text-muted)] mt-3">Menit</p>
                    </div>
                    <div class="glass-card py-6 px-2 text-center">
                        <p class="text-3xl sm:text-4xl font-bold gold-text" x-text="seconds">0</p>
                        <p class="text-[8px] uppercase tracking-[0.3em] text-[var(--text-muted)] mt-3">Detik</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- EVENT -->
        <section class="py-24 px-6 relative">
            <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse at 50% 30%, rgba(184,134,11,0.03) 0%, transparent 50%);"></div>

            <div class="max-w-lg mx-auto text-center">
                <div class="reveal">
                    <p class="text-[9px] uppercase tracking-[0.6em] text-[var(--text-muted)] mb-3">When & Where</p>
                    <h3 class="text-2xl font-display gold-text mb-14">Acara Pernikahan</h3>
                </div>

                <div class="glass-card p-8 sm:p-10 reveal reveal-delay-1">
                    <div class="w-14 h-14 mx-auto mb-7 rounded-full flex items-center justify-center border border-[var(--border-gold)]" style="background: rgba(184,134,11,0.05);">
                        <svg class="w-6 h-6 text-[var(--gold-mid)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>

                    <h4 class="text-xl font-display gold-text mb-6">{{ $invitation->event_venue }}</h4>

                    <div class="space-y-2 text-sm text-[var(--text-muted)] mb-7">
                        <p class="font-medium text-[var(--text)]">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                        <p>Pukul {{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }} {{ $invitation->event_time_end ? '- ' . \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') : '' }} WIB</p>
                    </div>

                    @if($invitation->event_address)
                    <p class="text-xs text-[var(--text-muted)] mb-8 max-w-xs mx-auto leading-relaxed font-light">{{ $invitation->event_address }}</p>
                    @endif

                    <div class="diamond-divider mb-8">
                        <span></span>
                    </div>

                    @if($invitation->event_maps_url)
                    <a href="{{ $invitation->event_maps_url }}" target="_blank" class="btn-luxury text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        Buka Maps
                    </a>
                    @endif
                </div>

                @if($invitation->dress_code)
                <div class="mt-8 inline-flex items-center gap-3 px-6 py-3 glass-card rounded-full reveal reveal-delay-2">
                    <svg class="w-4 h-4 text-[var(--gold-mid)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span class="text-xs text-[var(--text)]">Dress Code: <strong class="text-[var(--gold-mid)]">{{ $invitation->dress_code }}</strong></span>
                </div>
                @endif
            </div>
        </section>


        <!-- GALLERY -->
        @if($invitation->galleries->count() > 0)
        <section class="py-24 px-6 relative">
            <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse at 50% 50%, rgba(184,134,11,0.02) 0%, transparent 50%);"></div>

            <div class="max-w-lg mx-auto">
                <div class="text-center mb-14 reveal">
                    <p class="text-[9px] uppercase tracking-[0.6em] text-[var(--text-muted)] mb-3">Our Moments</p>
                    <h3 class="text-2xl font-display gold-text">Galeri</h3>
                </div>
                <div class="grid grid-cols-2 gap-3 sm:gap-4 reveal reveal-delay-1">
                    @foreach($invitation->galleries as $i => $photo)
                    <div class="aspect-square {{ $i === 0 ? 'col-span-2 aspect-video' : '' }} rounded-2xl overflow-hidden group relative border border-[var(--border-gold)]" style="box-shadow: 0 0 20px rgba(184,134,11,0.08);">
                        <img src="{{ $photo->getImageUrl() }}" alt="{{ $photo->caption }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000 ease-out" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- RSVP -->
        <section class="py-24 px-6 relative">
            <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse at 50% 30%, rgba(184,134,11,0.04) 0%, transparent 50%);"></div>

            <div class="max-w-sm mx-auto relative z-10">
                <div class="text-center mb-12 reveal">
                    <p class="text-[9px] uppercase tracking-[0.6em] text-[var(--text-muted)] mb-3">Attendance</p>
                    <h3 class="text-2xl font-display gold-text">RSVP</h3>
                    <p class="text-sm text-[var(--text-muted)] mt-4 font-light">Konfirmasi kehadiran Anda</p>
                </div>

                @if(session('success'))
                <div class="mb-6 p-4 glass-card text-green-400 text-sm text-center" style="border-color: rgba(74,222,128,0.2);">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" class="space-y-5 reveal reveal-delay-1">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Lengkap" required class="input-dark">
                    <select name="rsvp_status" required class="input-dark">
                        <option value="">-- Konfirmasi Kehadiran --</option>
                        <option value="attending">Ya, Saya Akan Hadir</option>
                        <option value="not_attending">Maaf, Tidak Bisa Hadir</option>
                        <option value="maybe">Masih Belum Pasti</option>
                    </select>
                    <input type="number" name="number_of_guests" min="1" max="10" value="1" placeholder="Jumlah Tamu" class="input-dark">
                    <button type="submit" class="btn-luxury w-full justify-center">Kirim Konfirmasi</button>
                </form>
            </div>
        </section>

        <!-- GUESTBOOK -->
        <section class="py-24 px-6 relative">
            <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse at 50% 70%, rgba(184,134,11,0.03) 0%, transparent 50%);"></div>

            <div class="max-w-md mx-auto relative z-10">
                <div class="text-center mb-12 reveal">
                    <p class="text-[9px] uppercase tracking-[0.6em] text-[var(--text-muted)] mb-3">Wishes</p>
                    <h3 class="text-2xl font-display gold-text">Ucapan & Doa</h3>
                </div>

                <form method="POST" action="{{ route('invitation.guestbook', $invitation->slug) }}" class="space-y-5 mb-12 reveal reveal-delay-1">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Anda" required class="input-dark">
                    <textarea name="message" rows="4" placeholder="Tulis ucapan & doa terbaik Anda..." required class="input-dark" style="resize: none;"></textarea>
                    <button type="submit" class="btn-outline-lux w-full justify-center">Kirim Ucapan</button>
                </form>

                <div class="space-y-4 max-h-96 overflow-y-auto pr-1 reveal reveal-delay-2">
                    @foreach($invitation->guestbooks as $msg)
                    <div class="glass-card p-5">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0 border border-[var(--border-gold)]" style="background: rgba(184,134,11,0.08);">
                                <span class="text-xs font-bold text-[var(--gold-mid)]">{{ strtoupper(substr($msg->name, 0, 1)) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-white">{{ $msg->name }}</p>
                                <p class="text-sm text-[var(--text-muted)] mt-1.5 leading-relaxed font-light">{{ $msg->message }}</p>
                                <p class="text-[10px] text-[var(--text-muted)] mt-2 opacity-50">{{ $msg->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>


        <!-- AMPLOP DIGITAL -->
        @if($invitation->bank_name || $invitation->qris_image)
        <section class="py-24 px-6 relative">
            <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse at 50% 50%, rgba(184,134,11,0.04) 0%, transparent 50%);"></div>

            <div class="max-w-sm mx-auto text-center relative z-10">
                <div class="reveal">
                    <div class="w-14 h-14 mx-auto mb-7 rounded-full flex items-center justify-center border border-[var(--border-gold)]" style="background: rgba(184,134,11,0.05);">
                        <svg class="w-6 h-6 text-[var(--gold-mid)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-[9px] uppercase tracking-[0.6em] text-[var(--text-muted)] mb-3">Wedding Gift</p>
                    <h3 class="text-2xl font-display gold-text mb-4">Amplop Digital</h3>
                    @if($invitation->gift_info)
                    <p class="text-sm text-[var(--text-muted)] mb-10 leading-relaxed font-light">{{ $invitation->gift_info }}</p>
                    @else
                    <p class="text-sm text-[var(--text-muted)] mb-10 font-light">Doa restu Anda sudah cukup. Namun jika berkenan memberi tanda kasih:</p>
                    @endif
                </div>

                @if($invitation->bank_name)
                <div class="glass-card p-7 mb-5 reveal reveal-delay-1" x-data="{ copied: false }">
                    <p class="text-[9px] uppercase tracking-[0.3em] text-[var(--text-muted)] mb-3">{{ $invitation->bank_name }}</p>
                    <p class="text-2xl font-bold gold-text tracking-wider mb-2">{{ $invitation->bank_account_number }}</p>
                    <p class="text-sm text-[var(--text-muted)] font-light">a.n. {{ $invitation->bank_account_name }}</p>
                    <button @click="navigator.clipboard.writeText('{{ $invitation->bank_account_number }}'); copied = true; setTimeout(() => copied = false, 2000)" class="mt-5 px-6 py-2.5 rounded-full text-xs font-medium border border-[var(--border-gold)] text-[var(--gold-mid)] hover:bg-[var(--gold)] hover:text-black hover:border-[var(--gold)] transition-all duration-300">
                        <span x-text="copied ? '&#10003; Tersalin!' : 'Salin Nomor'"></span>
                    </button>
                </div>
                @endif

                @if($invitation->qris_image)
                <div class="glass-card p-6 inline-block reveal reveal-delay-2">
                    <div class="bg-white rounded-xl p-3">
                        <img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS" class="w-44 h-44 object-contain mx-auto">
                    </div>
                    <p class="text-[10px] text-[var(--text-muted)] mt-4 tracking-wider uppercase">Scan QRIS</p>
                </div>
                @endif
            </div>
        </section>
        @endif

        <!-- CLOSING -->
        @if($invitation->closing_text)
        <section class="py-24 px-6 relative overflow-hidden">
            <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse at 50% 50%, rgba(184,134,11,0.06) 0%, transparent 50%);"></div>
            <div class="particles-container">
                <div class="particle" style="left:20%; animation-duration:9s; animation-delay:0s;"></div>
                <div class="particle" style="left:45%; animation-duration:12s; animation-delay:1.5s;"></div>
                <div class="particle" style="left:70%; animation-duration:10s; animation-delay:3s;"></div>
                <div class="particle" style="left:90%; animation-duration:11s; animation-delay:2s;"></div>
            </div>

            <div class="max-w-lg mx-auto text-center relative z-10 reveal">
                <div class="diamond-divider mb-10">
                    <span></span>
                </div>
                <p class="text-base sm:text-lg text-[var(--text)] leading-loose font-light italic mb-10">"{{ $invitation->closing_text }}"</p>
                <div class="diamond-divider mb-8">
                    <span></span>
                </div>
                <h4 class="text-2xl font-display gold-text">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</h4>
                <div class="diamond-divider mt-10">
                    <span></span>
                </div>
            </div>
        </section>
        @endif

        <!-- FOOTER -->
        <footer class="py-10 px-6 text-center border-t border-[var(--border-gold)]">
            <div class="diamond-divider mb-5">
                <span></span>
            </div>
            <p class="text-[10px] text-[var(--text-muted)] tracking-wider">Made with love by <a href="{{ url('/') }}" class="text-[var(--gold-mid)] hover:text-[var(--gold-light)] transition-colors font-medium">UndanganDigital</a></p>
        </footer>
    </div>


    <!-- MUSIC PLAYER -->
    @if($invitation->music_url)
    <div class="fixed bottom-6 right-6 z-40" x-show="opened" x-transition>
        <button @click="toggleMusic()" class="w-12 h-12 rounded-full shadow-2xl flex items-center justify-center transition-all duration-300 hover:scale-110 border"
            :class="playing ? 'bg-[var(--gold)] text-black border-[var(--gold)] music-spin' : 'bg-black/80 text-[var(--gold-mid)] border-[var(--border-gold)] backdrop-blur-sm'"
            style="box-shadow: 0 0 20px rgba(184,134,11,0.2);">
            <svg x-show="!playing" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>
            <svg x-show="playing" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M5.75 3a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75A.75.75 0 007.25 3h-1.5zM12.75 3a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75a.75.75 0 00-.75-.75h-1.5z"/></svg>
        </button>
        <audio x-ref="audio" src="{{ asset('storage/' . $invitation->music_url) }}" loop preload="auto"></audio>
    </div>
    @endif

    <!-- SCRIPTS -->
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
