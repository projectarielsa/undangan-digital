<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $invitation->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Nunito+Sans:wght@200;300;400;600&family=Tangerine:wght@400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --gold: {{ $invitation->color_primary ?? '#B8860B' }};
            --gold-light: #D4A843;
            --gold-pale: #F5ECD7;
            --dark: {{ $invitation->color_secondary ?? '#1C1410' }};
            --cream: #FFFDF8;
            --text: #3D2E1F;
            --muted: #8B7355;
            --border: rgba(184,134,11,0.15);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Nunito Sans', sans-serif; font-weight: 300; color: var(--text); overflow-x: hidden; -webkit-font-smoothing: antialiased; }
        .font-display { font-family: 'Playfair Display', serif; }
        .font-script { font-family: 'Tangerine', cursive; font-weight: 700; }
        [x-cloak] { display: none !important; }

        /* Animations */
        .reveal { opacity: 0; transform: translateY(30px); transition: all 0.7s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
        .reveal.active { opacity: 1; transform: translateY(0); }
        .reveal-delay-1 { transition-delay: 0.15s; }
        .reveal-delay-2 { transition-delay: 0.3s; }
        .reveal-delay-3 { transition-delay: 0.45s; }

        /* Ornament */
        .ornament {
            width: 200px; height: 40px; margin: 0 auto;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 40'%3E%3Cpath d='M20 20 Q50 8 80 20 Q100 28 100 20 Q100 12 120 20 Q150 32 180 20' fill='none' stroke='%23B8860B' stroke-width='0.8' opacity='0.5'/%3E%3Ccircle cx='100' cy='20' r='3' fill='%23B8860B' opacity='0.6'/%3E%3Ccircle cx='85' cy='17' r='1.5' fill='%23B8860B' opacity='0.3'/%3E%3Ccircle cx='115' cy='17' r='1.5' fill='%23B8860B' opacity='0.3'/%3E%3Cpath d='M90 20 L95 15 L100 20 L105 15 L110 20' fill='none' stroke='%23B8860B' stroke-width='0.5' opacity='0.4'/%3E%3C/svg%3E") no-repeat center/contain;
        }
        .ornament-sm {
            width: 100px; height: 20px; margin: 0 auto;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 20'%3E%3Cpath d='M10 10 Q25 3 50 10 Q75 17 90 10' fill='none' stroke='%23B8860B' stroke-width='0.6' opacity='0.4'/%3E%3Ccircle cx='50' cy='10' r='2' fill='%23B8860B' opacity='0.5'/%3E%3C/svg%3E") no-repeat center/contain;
        }

        .corner-tl, .corner-tr, .corner-bl, .corner-br {
            position: absolute; width: 80px; height: 80px; pointer-events: none;
            border-color: var(--gold); opacity: 0.3;
        }
        .corner-tl { top: 16px; left: 16px; border-top: 1.5px solid; border-left: 1.5px solid; }
        .corner-tr { top: 16px; right: 16px; border-top: 1.5px solid; border-right: 1.5px solid; }
        .corner-bl { bottom: 16px; left: 16px; border-bottom: 1.5px solid; border-left: 1.5px solid; }
        .corner-br { bottom: 16px; right: 16px; border-bottom: 1.5px solid; border-right: 1.5px solid; }

        .gold-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 20px;
            box-shadow: 0 4px 24px rgba(184,134,11,0.06);
        }

        .btn-gold {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 14px 32px;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            color: white; font-weight: 600; font-size: 14px;
            border-radius: 50px; border: none; cursor: pointer;
            box-shadow: 0 4px 16px rgba(184,134,11,0.3);
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 6px 24px rgba(184,134,11,0.4); }

        .btn-outline {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 12px 28px;
            border: 1.5px solid var(--gold);
            color: var(--gold); font-weight: 600; font-size: 13px;
            border-radius: 50px; cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none; background: transparent;
        }
        .btn-outline:hover { background: var(--gold); color: white; }

        .input-field {
            width: 100%; padding: 14px 18px;
            background: var(--cream); border: 1px solid var(--border);
            border-radius: 12px; font-size: 14px; color: var(--text);
            transition: border-color 0.3s;
            font-family: 'Nunito Sans', sans-serif;
        }
        .input-field:focus { outline: none; border-color: var(--gold); }
        .input-field::placeholder { color: var(--muted); opacity: 0.6; }

        /* Music */
        @keyframes rotate { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        .music-spin { animation: rotate 3s linear infinite; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 4px; opacity: 0.5; }
    </style>
</head>
<body class="bg-[var(--cream)]" x-data="invitationApp()" x-cloak>

    <!-- ===================== OPENING COVER ===================== -->
    <section x-show="!opened" class="fixed inset-0 z-50 flex items-center justify-center bg-[var(--dark)]"
        x-transition:leave="transition ease-in duration-800"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95">

        <div class="corner-tl"></div>
        <div class="corner-tr"></div>
        <div class="corner-bl"></div>
        <div class="corner-br"></div>

        <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse at center, rgba(184,134,11,0.05) 0%, transparent 70%)"></div>

        <div class="text-center px-8 relative z-10 max-w-sm">
            <div class="ornament mb-8 opacity-70"></div>

            <p class="text-xs uppercase tracking-[0.5em] text-[var(--gold-light)] mb-8 font-light">The Wedding Of</p>

            <h1 class="text-6xl sm:text-7xl font-script text-white leading-none mb-2" style="text-shadow: 0 2px 20px rgba(184,134,11,0.3)">{{ $invitation->groom_name }}</h1>

            <div class="flex items-center justify-center gap-4 my-5">
                <div class="w-12 h-px bg-gradient-to-r from-transparent to-[var(--gold-light)] opacity-50"></div>
                <span class="text-2xl font-script text-[var(--gold-light)]">&</span>
                <div class="w-12 h-px bg-gradient-to-l from-transparent to-[var(--gold-light)] opacity-50"></div>
            </div>

            <h1 class="text-6xl sm:text-7xl font-script text-white leading-none" style="text-shadow: 0 2px 20px rgba(184,134,11,0.3)">{{ $invitation->bride_name }}</h1>

            @if($guestName)
            <div class="mt-10 py-3 px-6 border border-[var(--gold)]/20 rounded-2xl bg-white/5 backdrop-blur-sm inline-block">
                <p class="text-[10px] uppercase tracking-[0.3em] text-[var(--gold-light)]/60 mb-1">Kepada Yth.</p>
                <p class="text-base text-white font-medium">{{ urldecode($guestName) }}</p>
            </div>
            @endif

            <div class="ornament mt-10 mb-10 opacity-70" style="transform: scaleY(-1)"></div>

            <button @click="openInvitation()" class="btn-gold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Buka Undangan
            </button>

            <p class="text-xs text-white/30 mt-6">{{ $invitation->event_date->translatedFormat('d F Y') }}</p>
        </div>
    </section>

    <!-- ===================== MAIN CONTENT ===================== -->
    <div x-show="opened" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

        <!-- HERO -->
        <section class="min-h-screen flex items-center justify-center py-24 px-6 relative">
            <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse at 50% 30%, rgba(184,134,11,0.03) 0%, transparent 50%)"></div>

            <div class="text-center max-w-lg relative z-10 reveal">
                <div class="ornament mb-10"></div>

                <p class="text-[11px] uppercase tracking-[0.6em] text-[var(--muted)] mb-10">We Are Getting Married</p>

                <h2 class="text-7xl sm:text-8xl font-script text-[var(--gold)] leading-none">{{ $invitation->groom_name }}</h2>

                <div class="flex items-center justify-center gap-5 my-6">
                    <div class="w-16 h-px bg-gradient-to-r from-transparent to-[var(--gold)]"></div>
                    <span class="text-3xl font-script text-[var(--gold)]">&</span>
                    <div class="w-16 h-px bg-gradient-to-l from-transparent to-[var(--gold)]"></div>
                </div>

                <h2 class="text-7xl sm:text-8xl font-script text-[var(--gold)] leading-none">{{ $invitation->bride_name }}</h2>

                <div class="mt-12 inline-flex items-center gap-3 px-5 py-2.5 bg-white border border-[var(--border)] rounded-full shadow-sm">
                    <svg class="w-4 h-4 text-[var(--gold)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span class="text-sm text-[var(--text)]">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</span>
                </div>

                <div class="ornament mt-12" style="transform: scaleY(-1)"></div>
            </div>
        </section>

        <!-- OPENING TEXT -->
        @if($invitation->opening_text)
        <section class="py-20 px-6 bg-white">
            <div class="max-w-lg mx-auto text-center reveal">
                <div class="ornament-sm mb-8"></div>
                <p class="text-base sm:text-lg font-display italic text-[var(--text)]/80 leading-loose">"{{ $invitation->opening_text }}"</p>
                <div class="ornament-sm mt-8"></div>
            </div>
        </section>
        @endif

        <!-- COUPLE -->
        <section class="py-20 px-6 bg-[var(--cream)]">
            <div class="max-w-lg mx-auto">
                <div class="text-center mb-14 reveal">
                    <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--muted)] mb-2">The Happy Couple</p>
                    <h3 class="text-3xl font-display font-medium text-[var(--dark)]">Mempelai</h3>
                </div>

                <!-- Groom -->
                <div class="text-center mb-14 reveal reveal-delay-1">
                    @if($invitation->groom_photo)
                    <div class="w-48 h-48 mx-auto mb-6 rounded-full overflow-hidden p-1 bg-gradient-to-br from-[var(--gold)] to-[var(--gold-light)] shadow-xl">
                        <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}" class="w-full h-full object-cover rounded-full">
                    </div>
                    @else
                    <div class="w-48 h-48 mx-auto mb-6 rounded-full bg-[var(--gold-pale)] flex items-center justify-center border-2 border-[var(--gold)]/20 shadow-lg">
                        <span class="text-6xl font-script text-[var(--gold)]">{{ substr($invitation->groom_name, 0, 1) }}</span>
                    </div>
                    @endif
                    <h4 class="text-3xl font-display font-medium text-[var(--dark)] mb-2">{{ $invitation->groom_name }}</h4>
                    @if($invitation->groom_father || $invitation->groom_mother)
                    <p class="text-sm text-[var(--muted)] leading-relaxed">Putra dari<br>
                        <span class="text-[var(--text)]">Bpk. {{ $invitation->groom_father }}</span> &
                        <span class="text-[var(--text)]">Ibu {{ $invitation->groom_mother }}</span>
                    </p>
                    @endif
                    @if($invitation->groom_instagram)
                    <a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" target="_blank" class="inline-flex items-center gap-1.5 mt-3 text-sm text-[var(--gold)] hover:underline">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        {{ $invitation->groom_instagram }}
                    </a>
                    @endif
                </div>

                <!-- & Symbol -->
                <div class="text-center mb-14 reveal reveal-delay-2">
                    <span class="text-5xl font-script text-[var(--gold)]">&</span>
                </div>

                <!-- Bride -->
                <div class="text-center reveal reveal-delay-3">
                    @if($invitation->bride_photo)
                    <div class="w-48 h-48 mx-auto mb-6 rounded-full overflow-hidden p-1 bg-gradient-to-br from-[var(--gold)] to-[var(--gold-light)] shadow-xl">
                        <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}" class="w-full h-full object-cover rounded-full">
                    </div>
                    @else
                    <div class="w-48 h-48 mx-auto mb-6 rounded-full bg-[var(--gold-pale)] flex items-center justify-center border-2 border-[var(--gold)]/20 shadow-lg">
                        <span class="text-6xl font-script text-[var(--gold)]">{{ substr($invitation->bride_name, 0, 1) }}</span>
                    </div>
                    @endif
                    <h4 class="text-3xl font-display font-medium text-[var(--dark)] mb-2">{{ $invitation->bride_name }}</h4>
                    @if($invitation->bride_father || $invitation->bride_mother)
                    <p class="text-sm text-[var(--muted)] leading-relaxed">Putri dari<br>
                        <span class="text-[var(--text)]">Bpk. {{ $invitation->bride_father }}</span> &
                        <span class="text-[var(--text)]">Ibu {{ $invitation->bride_mother }}</span>
                    </p>
                    @endif
                    @if($invitation->bride_instagram)
                    <a href="https://instagram.com/{{ ltrim($invitation->bride_instagram, '@') }}" target="_blank" class="inline-flex items-center gap-1.5 mt-3 text-sm text-[var(--gold)] hover:underline">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        {{ $invitation->bride_instagram }}
                    </a>
                    @endif
                </div>
            </div>
        </section>

        <!-- COUNTDOWN -->
        <section class="py-20 px-6 bg-[var(--dark)] relative overflow-hidden">
            <div class="absolute inset-0 pointer-events-none opacity-[0.03]" style="background-image: radial-gradient(circle, var(--gold) 1px, transparent 1px); background-size: 30px 30px;"></div>

            <div class="max-w-md mx-auto text-center relative z-10 reveal" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">
                <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--gold-light)] mb-3">Save The Date</p>
                <h3 class="text-2xl font-display text-white mb-10">Menghitung Hari</h3>

                <div class="grid grid-cols-4 gap-3">
                    <div class="bg-white/[0.06] backdrop-blur-sm border border-white/10 rounded-2xl py-5 px-2">
                        <p class="text-3xl sm:text-4xl font-bold text-[var(--gold-light)]" x-text="days">0</p>
                        <p class="text-[9px] uppercase tracking-[0.2em] text-white/40 mt-2">Hari</p>
                    </div>
                    <div class="bg-white/[0.06] backdrop-blur-sm border border-white/10 rounded-2xl py-5 px-2">
                        <p class="text-3xl sm:text-4xl font-bold text-[var(--gold-light)]" x-text="hours">0</p>
                        <p class="text-[9px] uppercase tracking-[0.2em] text-white/40 mt-2">Jam</p>
                    </div>
                    <div class="bg-white/[0.06] backdrop-blur-sm border border-white/10 rounded-2xl py-5 px-2">
                        <p class="text-3xl sm:text-4xl font-bold text-[var(--gold-light)]" x-text="minutes">0</p>
                        <p class="text-[9px] uppercase tracking-[0.2em] text-white/40 mt-2">Menit</p>
                    </div>
                    <div class="bg-white/[0.06] backdrop-blur-sm border border-white/10 rounded-2xl py-5 px-2">
                        <p class="text-3xl sm:text-4xl font-bold text-[var(--gold-light)]" x-text="seconds">0</p>
                        <p class="text-[9px] uppercase tracking-[0.2em] text-white/40 mt-2">Detik</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- EVENT -->
        <section class="py-20 px-6 bg-white">
            <div class="max-w-lg mx-auto text-center">
                <div class="reveal">
                    <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--muted)] mb-2">When & Where</p>
                    <h3 class="text-3xl font-display font-medium text-[var(--dark)] mb-12">Acara Pernikahan</h3>
                </div>

                <div class="gold-card p-8 sm:p-10 reveal reveal-delay-1">
                    <div class="w-14 h-14 mx-auto mb-6 rounded-full bg-[var(--gold-pale)] flex items-center justify-center">
                        <svg class="w-6 h-6 text-[var(--gold)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>

                    <h4 class="text-xl font-display font-semibold text-[var(--dark)] mb-5">{{ $invitation->event_venue }}</h4>

                    <div class="space-y-1.5 text-sm text-[var(--muted)] mb-6">
                        <p class="font-medium text-[var(--text)]">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                        <p>Pukul {{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }} {{ $invitation->event_time_end ? '- ' . \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') : '' }} WIB</p>
                    </div>

                    @if($invitation->event_address)
                    <p class="text-xs text-[var(--muted)] mb-8 max-w-xs mx-auto leading-relaxed">{{ $invitation->event_address }}</p>
                    @endif

                    @if($invitation->event_maps_url)
                    <a href="{{ $invitation->event_maps_url }}" target="_blank" class="btn-gold text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        Buka Maps
                    </a>
                    @endif
                </div>

                @if($invitation->dress_code)
                <div class="mt-6 inline-flex items-center gap-2 px-5 py-2.5 bg-[var(--gold-pale)] rounded-full border border-[var(--border)] reveal reveal-delay-2">
                    <svg class="w-4 h-4 text-[var(--gold)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span class="text-xs text-[var(--text)]">Dress Code: <strong>{{ $invitation->dress_code }}</strong></span>
                </div>
                @endif
            </div>
        </section>

        <!-- GALLERY -->
        @if($invitation->galleries->count() > 0)
        <section class="py-20 px-6 bg-[var(--cream)]">
            <div class="max-w-lg mx-auto">
                <div class="text-center mb-12 reveal">
                    <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--muted)] mb-2">Our Moments</p>
                    <h3 class="text-3xl font-display font-medium text-[var(--dark)]">Galeri</h3>
                </div>
                <div class="grid grid-cols-2 gap-2 sm:gap-3 reveal reveal-delay-1">
                    @foreach($invitation->galleries as $i => $photo)
                    <div class="aspect-square rounded-2xl overflow-hidden {{ $i === 0 ? 'col-span-2 aspect-video' : '' }} group">
                        <img src="{{ $photo->getImageUrl() }}" alt="{{ $photo->caption }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- RSVP -->
        <section class="py-20 px-6 bg-white">
            <div class="max-w-sm mx-auto">
                <div class="text-center mb-10 reveal">
                    <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--muted)] mb-2">Attendance</p>
                    <h3 class="text-3xl font-display font-medium text-[var(--dark)]">RSVP</h3>
                    <p class="text-sm text-[var(--muted)] mt-3">Konfirmasi kehadiran Anda</p>
                </div>

                @if(session('success'))
                <div class="mb-5 p-4 bg-green-50 border border-green-200 text-green-700 text-sm text-center rounded-2xl">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" class="space-y-4 reveal reveal-delay-1">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Lengkap" required class="input-field">
                    <select name="rsvp_status" required class="input-field">
                        <option value="">-- Konfirmasi Kehadiran --</option>
                        <option value="attending">Ya, Saya Akan Hadir</option>
                        <option value="not_attending">Maaf, Tidak Bisa Hadir</option>
                        <option value="maybe">Masih Belum Pasti</option>
                    </select>
                    <input type="number" name="number_of_guests" min="1" max="10" value="1" placeholder="Jumlah Tamu" class="input-field">
                    <button type="submit" class="btn-gold w-full justify-center">Kirim Konfirmasi</button>
                </form>
            </div>
        </section>

        <!-- GUESTBOOK -->
        <section class="py-20 px-6 bg-[var(--cream)]">
            <div class="max-w-md mx-auto">
                <div class="text-center mb-10 reveal">
                    <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--muted)] mb-2">Wishes</p>
                    <h3 class="text-3xl font-display font-medium text-[var(--dark)]">Ucapan & Doa</h3>
                </div>

                <form method="POST" action="{{ route('invitation.guestbook', $invitation->slug) }}" class="space-y-4 mb-10 reveal reveal-delay-1">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Anda" required class="input-field">
                    <textarea name="message" rows="4" placeholder="Tulis ucapan & doa terbaik Anda..." required class="input-field" style="resize: none;"></textarea>
                    <button type="submit" class="btn-outline w-full justify-center">Kirim Ucapan</button>
                </form>

                <div class="space-y-3 max-h-80 overflow-y-auto pr-1 reveal reveal-delay-2">
                    @foreach($invitation->guestbooks as $msg)
                    <div class="bg-white rounded-2xl p-5 border border-[var(--border)]">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-full bg-[var(--gold-pale)] flex items-center justify-center flex-shrink-0 border border-[var(--border)]">
                                <span class="text-xs font-bold text-[var(--gold)]">{{ strtoupper(substr($msg->name, 0, 1)) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-[var(--dark)]">{{ $msg->name }}</p>
                                <p class="text-sm text-[var(--muted)] mt-1 leading-relaxed">{{ $msg->message }}</p>
                                <p class="text-[10px] text-[var(--muted)]/50 mt-2">{{ $msg->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- AMPLOP DIGITAL -->
        @if($invitation->bank_name || $invitation->qris_image)
        <section class="py-20 px-6 bg-white">
            <div class="max-w-sm mx-auto text-center">
                <div class="reveal">
                    <div class="w-14 h-14 mx-auto mb-6 rounded-full bg-[var(--gold-pale)] flex items-center justify-center">
                        <svg class="w-6 h-6 text-[var(--gold)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--muted)] mb-2">Wedding Gift</p>
                    <h3 class="text-3xl font-display font-medium text-[var(--dark)] mb-3">Amplop Digital</h3>
                    @if($invitation->gift_info)
                    <p class="text-sm text-[var(--muted)] mb-8 leading-relaxed">{{ $invitation->gift_info }}</p>
                    @else
                    <p class="text-sm text-[var(--muted)] mb-8">Doa restu Anda sudah cukup. Namun jika berkenan memberi tanda kasih:</p>
                    @endif
                </div>

                @if($invitation->bank_name)
                <div class="gold-card p-6 mb-4 reveal reveal-delay-1" x-data="{ copied: false }">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-[var(--muted)] mb-2">{{ $invitation->bank_name }}</p>
                    <p class="text-2xl font-bold text-[var(--dark)] tracking-wider mb-1">{{ $invitation->bank_account_number }}</p>
                    <p class="text-sm text-[var(--muted)]">a.n. {{ $invitation->bank_account_name }}</p>
                    <button @click="navigator.clipboard.writeText('{{ $invitation->bank_account_number }}'); copied = true; setTimeout(() => copied = false, 2000)" class="mt-4 px-5 py-2 bg-[var(--gold-pale)] text-[var(--gold)] text-xs font-semibold rounded-full hover:bg-[var(--gold)] hover:text-white transition-all border border-[var(--border)]">
                        <span x-text="copied ? '✓ Tersalin!' : 'Salin Nomor'"></span>
                    </button>
                </div>
                @endif

                @if($invitation->qris_image)
                <div class="gold-card p-5 inline-block reveal reveal-delay-2">
                    <img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS" class="w-48 h-48 object-contain mx-auto">
                    <p class="text-[10px] text-[var(--muted)] mt-3">Scan QRIS</p>
                </div>
                @endif
            </div>
        </section>
        @endif

        <!-- CLOSING -->
        @if($invitation->closing_text)
        <section class="py-20 px-6 bg-[var(--dark)] text-center relative overflow-hidden">
            <div class="absolute inset-0 pointer-events-none opacity-[0.03]" style="background-image: radial-gradient(circle, var(--gold) 1px, transparent 1px); background-size: 30px 30px;"></div>
            <div class="max-w-lg mx-auto relative z-10 reveal">
                <div class="ornament mb-8 opacity-50"></div>
                <p class="text-base sm:text-lg text-white/70 leading-loose font-light italic mb-8">"{{ $invitation->closing_text }}"</p>
                <div class="ornament-sm mb-6"></div>
                <h4 class="text-3xl font-script text-[var(--gold-light)]">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</h4>
                <div class="ornament mt-8 opacity-50" style="transform: scaleY(-1)"></div>
            </div>
        </section>
        @endif

        <!-- FOOTER -->
        <footer class="py-8 px-6 bg-[var(--cream)] text-center border-t border-[var(--border)]">
            <div class="ornament-sm mb-4"></div>
            <p class="text-[10px] text-[var(--muted)]">Made with love by <a href="{{ url('/') }}" class="text-[var(--gold)] hover:underline font-medium">UndanganDigital</a></p>
        </footer>
    </div>

    <!-- MUSIC PLAYER -->
    @if($invitation->music_url)
    <div class="fixed bottom-5 right-5 z-40" x-show="opened" x-transition>
        <button @click="toggleMusic()" class="w-12 h-12 rounded-full shadow-xl flex items-center justify-center transition-all duration-300 hover:scale-110"
            :class="playing ? 'bg-[var(--gold)] text-white music-spin' : 'bg-white text-[var(--gold)] border border-[var(--border)]'">
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
            opened: false, playing: false,
            openInvitation() {
                this.opened = true;
                document.body.style.overflow = 'auto';
                @if($invitation->music_autoplay && $invitation->music_url)
                this.$nextTick(() => { this.$refs.audio?.play().then(() => this.playing = true).catch(() => {}); });
                @endif
                this.$nextTick(() => setTimeout(() => this.initReveal(), 200));
            },
            toggleMusic() { if (this.playing) { this.$refs.audio?.pause(); } else { this.$refs.audio?.play(); } this.playing = !this.playing; },
            initReveal() {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('active'); });
                }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
                document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
            }
        };
    }
    function countdown(targetDate) {
        return {
            days: 0, hours: 0, minutes: 0, seconds: 0,
            init() { this.update(); setInterval(() => this.update(), 1000); },
            update() {
                const diff = new Date(targetDate) - new Date();
                if (diff > 0) { this.days = Math.floor(diff/(1000*60*60*24)); this.hours = Math.floor((diff%(1000*60*60*24))/(1000*60*60)); this.minutes = Math.floor((diff%(1000*60*60))/(1000*60)); this.seconds = Math.floor((diff%(1000*60))/1000); }
            }
        };
    }
    </script>
</body>
</html>
