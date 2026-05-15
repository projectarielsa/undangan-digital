<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $invitation->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
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
        body { font-family: 'Jost', sans-serif; font-weight: 300; color: var(--text); background: var(--cream); overflow-x: hidden; -webkit-font-smoothing: antialiased; }
        .font-display { font-family: 'Marcellus', serif; }
        .font-script { font-family: 'Pinyon Script', cursive; }
        [x-cloak] { display: none !important; }

        /* Scroll Animation */
        .anim { opacity: 0; transform: translateY(35px); transition: all 0.65s cubic-bezier(0.22, 0.61, 0.36, 1); }
        .anim.show { opacity: 1; transform: translateY(0); }
        .anim-d1 { transition-delay: 0.12s; }
        .anim-d2 { transition-delay: 0.24s; }
        .anim-d3 { transition-delay: 0.36s; }

        /* Floral corners */
        .fl-tl, .fl-tr, .fl-bl, .fl-br {
            position: absolute; width: 120px; height: 120px; pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 150 150'%3E%3Cpath d='M5 5 C25 35 15 65 40 80 C15 95 25 125 5 145' fill='none' stroke='%236B5B4B' stroke-width='1.2' opacity='0.12'/%3E%3Cpath d='M5 5 C35 25 65 15 80 40' fill='none' stroke='%236B5B4B' stroke-width='0.8' opacity='0.1'/%3E%3Ccircle cx='40' cy='40' r='3' fill='%236B5B4B' opacity='0.08'/%3E%3Ccircle cx='25' cy='65' r='2' fill='%236B5B4B' opacity='0.06'/%3E%3Ccircle cx='65' cy='25' r='2' fill='%236B5B4B' opacity='0.06'/%3E%3Cellipse cx='35' cy='35' rx='8' ry='5' fill='none' stroke='%236B5B4B' stroke-width='0.5' opacity='0.06' transform='rotate(-30 35 35)'/%3E%3C/svg%3E");
            background-size: contain; background-repeat: no-repeat;
        }
        .fl-tl { top: 0; left: 0; }
        .fl-tr { top: 0; right: 0; transform: scaleX(-1); }
        .fl-bl { bottom: 0; left: 0; transform: scaleY(-1); }
        .fl-br { bottom: 0; right: 0; transform: scale(-1); }

        /* Divider */
        .divider {
            width: 140px; height: 24px; margin: 0 auto;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 140 24'%3E%3Cpath d='M10 12 Q35 4 70 12 Q105 20 130 12' fill='none' stroke='%236B5B4B' stroke-width='0.7' opacity='0.25'/%3E%3Ccircle cx='70' cy='12' r='2.5' fill='%236B5B4B' opacity='0.35'/%3E%3Ccircle cx='55' cy='10' r='1' fill='%236B5B4B' opacity='0.2'/%3E%3Ccircle cx='85' cy='10' r='1' fill='%236B5B4B' opacity='0.2'/%3E%3C/svg%3E") no-repeat center/contain;
        }

        /* Cards */
        .event-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 28px 24px;
            text-align: center;
            box-shadow: 0 2px 12px rgba(0,0,0,0.03);
        }

        /* Buttons */
        .btn-primary {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 13px 28px; background: var(--primary);
            color: white; font-size: 13px; font-weight: 500;
            border-radius: 50px; border: none; cursor: pointer;
            transition: all 0.3s; text-decoration: none;
            box-shadow: 0 4px 12px rgba(107,91,75,0.25);
        }
        .btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); }

        .btn-secondary {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 12px 24px; border: 1.5px solid var(--primary);
            color: var(--primary); font-size: 13px; font-weight: 500;
            border-radius: 50px; cursor: pointer; transition: all 0.3s;
            text-decoration: none; background: transparent;
        }
        .btn-secondary:hover { background: var(--primary); color: white; }

        /* Inputs */
        .form-input {
            width: 100%; padding: 13px 16px;
            background: var(--warm); border: 1px solid var(--border);
            border-radius: 12px; font-size: 14px; color: var(--text);
            font-family: 'Jost', sans-serif; transition: border 0.3s;
        }
        .form-input:focus { outline: none; border-color: var(--primary); }
        .form-input::placeholder { color: var(--muted); }

        /* Music */
        @keyframes pulse-ring { 0% { box-shadow: 0 0 0 0 rgba(107,91,75,0.3); } 70% { box-shadow: 0 0 0 8px transparent; } 100% { box-shadow: 0 0 0 0 transparent; } }
        .music-pulse { animation: pulse-ring 2s infinite; }
    </style>
</head>
<body x-data="invitationApp()" x-cloak>

    <!-- ========== OPENING COVER ========== -->
    <section x-show="!opened" class="fixed inset-0 z-50 flex items-center justify-center overflow-hidden bg-[var(--cream)]"
        x-transition:leave="transition ease-in duration-600"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

        <div class="fl-tl"></div>
        <div class="fl-tr"></div>
        <div class="fl-bl"></div>
        <div class="fl-br"></div>

        <div class="text-center px-8 max-w-sm relative z-10">
            <div class="divider mb-8"></div>

            <p class="text-[11px] uppercase tracking-[0.4em] text-[var(--muted)] mb-6">The Wedding Of</p>

            <h1 class="text-6xl sm:text-7xl font-script text-[var(--primary)] leading-tight">{{ $invitation->groom_name }}</h1>
            <p class="text-3xl font-script text-[var(--accent)] my-2">&</p>
            <h1 class="text-6xl sm:text-7xl font-script text-[var(--primary)] leading-tight">{{ $invitation->bride_name }}</h1>

            <div class="divider my-8" style="transform: scaleY(-1)"></div>

            @if($guestName)
            <div class="mb-8">
                <p class="text-[10px] uppercase tracking-[0.3em] text-[var(--muted)] mb-2">Kepada Yth. Bapak/Ibu/Saudara/i</p>
                <div class="inline-block px-6 py-2.5 bg-[var(--warm)] rounded-xl border border-[var(--border)]">
                    <p class="text-base font-display font-medium text-[var(--text)]">{{ urldecode($guestName) }}</p>
                </div>
            </div>
            @endif

            <p class="text-xs text-[var(--muted)] mb-8 leading-relaxed max-w-xs mx-auto">Tanpa mengurangi rasa hormat, kami mengundang Anda untuk hadir di acara pernikahan kami</p>

            <button @click="openInvitation()" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Buka Undangan
            </button>

            <p class="text-[10px] text-[var(--muted)] mt-6 opacity-60">{{ $invitation->event_date->translatedFormat('d F Y') }}</p>
        </div>
    </section>

    <!-- ========== MAIN ========== -->
    <div x-show="opened" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

        <!-- HERO -->
        <section class="min-h-screen flex items-center justify-center py-24 px-6 relative">
            <div class="fl-tl" style="opacity: 0.8"></div>
            <div class="fl-tr" style="opacity: 0.8"></div>

            <div class="text-center max-w-md anim">
                <div class="divider mb-10"></div>
                <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--muted)] mb-10">The Wedding Of</p>
                <h2 class="text-7xl sm:text-8xl font-script text-[var(--primary)] leading-none">{{ $invitation->groom_name }}</h2>
                <p class="text-4xl font-script text-[var(--accent)] my-4">&</p>
                <h2 class="text-7xl sm:text-8xl font-script text-[var(--primary)] leading-none">{{ $invitation->bride_name }}</h2>
                <p class="mt-10 text-sm text-[var(--muted)] font-display">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                <div class="divider mt-10" style="transform: scaleY(-1)"></div>
            </div>
        </section>

        <!-- AYAT -->
        @if($invitation->opening_text)
        <section class="py-20 px-6 bg-[var(--card)]">
            <div class="max-w-md mx-auto text-center anim">
                <div class="divider mb-8"></div>
                <p class="text-sm sm:text-base font-display italic text-[var(--text)] leading-loose">"{{ $invitation->opening_text }}"</p>
                <div class="divider mt-8" style="transform: scaleY(-1)"></div>
            </div>
        </section>
        @endif

        <!-- MEMPELAI -->
        <section class="py-20 px-6 bg-[var(--cream)] relative">
            <div class="fl-bl" style="opacity: 0.6"></div>
            <div class="fl-tr" style="opacity: 0.6"></div>

            <div class="max-w-md mx-auto">
                <div class="text-center mb-14 anim">
                    <p class="text-[10px] uppercase tracking-[0.4em] text-[var(--muted)] mb-2">Bride & Groom</p>
                    <h3 class="text-2xl font-display text-[var(--text)]">Mempelai</h3>
                </div>

                <!-- Pria -->
                <div class="text-center mb-12 anim anim-d1">
                    @if($invitation->groom_photo)
                    <div class="w-40 h-40 mx-auto mb-5 rounded-full overflow-hidden shadow-xl border-[3px] border-white" style="box-shadow: 0 8px 30px rgba(107,91,75,0.15);">
                        <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}" class="w-full h-full object-cover">
                    </div>
                    @else
                    <div class="w-40 h-40 mx-auto mb-5 rounded-full bg-[var(--warm)] flex items-center justify-center border-[3px] border-white shadow-xl">
                        <span class="text-5xl font-script text-[var(--primary)]">{{ substr($invitation->groom_name, 0, 1) }}</span>
                    </div>
                    @endif
                    <h4 class="text-2xl font-display text-[var(--text)] mb-1">{{ $invitation->groom_name }}</h4>
                    @if($invitation->groom_father || $invitation->groom_mother)
                    <p class="text-xs text-[var(--muted)] leading-relaxed mt-2">Putra dari<br>
                        <span class="text-[var(--text)] font-medium">Bpk. {{ $invitation->groom_father }}</span> &
                        <span class="text-[var(--text)] font-medium">Ibu {{ $invitation->groom_mother }}</span>
                    </p>
                    @endif
                    @if($invitation->groom_instagram)
                    <a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" target="_blank" class="inline-flex items-center gap-1 mt-2 text-xs text-[var(--primary)] hover:underline">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        {{ $invitation->groom_instagram }}
                    </a>
                    @endif
                </div>

                <div class="text-center mb-12 anim anim-d2"><span class="text-4xl font-script text-[var(--accent)]">&</span></div>

                <!-- Wanita -->
                <div class="text-center anim anim-d3">
                    @if($invitation->bride_photo)
                    <div class="w-40 h-40 mx-auto mb-5 rounded-full overflow-hidden shadow-xl border-[3px] border-white" style="box-shadow: 0 8px 30px rgba(107,91,75,0.15);">
                        <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}" class="w-full h-full object-cover">
                    </div>
                    @else
                    <div class="w-40 h-40 mx-auto mb-5 rounded-full bg-[var(--warm)] flex items-center justify-center border-[3px] border-white shadow-xl">
                        <span class="text-5xl font-script text-[var(--primary)]">{{ substr($invitation->bride_name, 0, 1) }}</span>
                    </div>
                    @endif
                    <h4 class="text-2xl font-display text-[var(--text)] mb-1">{{ $invitation->bride_name }}</h4>
                    @if($invitation->bride_father || $invitation->bride_mother)
                    <p class="text-xs text-[var(--muted)] leading-relaxed mt-2">Putri dari<br>
                        <span class="text-[var(--text)] font-medium">Bpk. {{ $invitation->bride_father }}</span> &
                        <span class="text-[var(--text)] font-medium">Ibu {{ $invitation->bride_mother }}</span>
                    </p>
                    @endif
                    @if($invitation->bride_instagram)
                    <a href="https://instagram.com/{{ ltrim($invitation->bride_instagram, '@') }}" target="_blank" class="inline-flex items-center gap-1 mt-2 text-xs text-[var(--primary)] hover:underline">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        {{ $invitation->bride_instagram }}
                    </a>
                    @endif
                </div>
            </div>
        </section>

        <!-- COUNTDOWN -->
        <section class="py-16 px-6 bg-[var(--primary)]" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">
            <div class="max-w-sm mx-auto text-center anim">
                <p class="text-[10px] uppercase tracking-[0.4em] text-white/50 mb-8">Counting Down</p>
                <div class="grid grid-cols-4 gap-3">
                    <div class="bg-white/10 backdrop-blur rounded-xl py-4">
                        <p class="text-2xl sm:text-3xl font-bold text-white" x-text="days">0</p>
                        <p class="text-[9px] uppercase tracking-wider text-white/40 mt-1">Hari</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur rounded-xl py-4">
                        <p class="text-2xl sm:text-3xl font-bold text-white" x-text="hours">0</p>
                        <p class="text-[9px] uppercase tracking-wider text-white/40 mt-1">Jam</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur rounded-xl py-4">
                        <p class="text-2xl sm:text-3xl font-bold text-white" x-text="minutes">0</p>
                        <p class="text-[9px] uppercase tracking-wider text-white/40 mt-1">Menit</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur rounded-xl py-4">
                        <p class="text-2xl sm:text-3xl font-bold text-white" x-text="seconds">0</p>
                        <p class="text-[9px] uppercase tracking-wider text-white/40 mt-1">Detik</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ACARA (Akad & Resepsi terpisah - gaya IndoInvite) -->
        <section class="py-20 px-6 bg-[var(--card)] relative">
            <div class="fl-tl" style="opacity: 0.5"></div>
            <div class="fl-br" style="opacity: 0.5"></div>

            <div class="max-w-md mx-auto">
                <div class="text-center mb-12 anim">
                    <p class="text-[10px] uppercase tracking-[0.4em] text-[var(--muted)] mb-2">Save The Date</p>
                    <h3 class="text-2xl font-display text-[var(--text)]">Acara Pernikahan</h3>
                </div>

                <!-- Akad -->
                <div class="event-card mb-4 anim anim-d1">
                    <div class="w-11 h-11 mx-auto mb-4 rounded-full bg-[var(--warm)] flex items-center justify-center">
                        <svg class="w-5 h-5 text-[var(--primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <h4 class="text-lg font-display font-medium text-[var(--text)] mb-3">Akad Nikah</h4>
                    <p class="text-sm font-medium text-[var(--text)]">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                    <p class="text-sm text-[var(--muted)]">Pukul {{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }} WIB - Selesai</p>
                </div>

                <!-- Resepsi -->
                @if($invitation->reception_date || $invitation->reception_venue)
                <div class="event-card mb-4 anim anim-d2">
                    <div class="w-11 h-11 mx-auto mb-4 rounded-full bg-[var(--warm)] flex items-center justify-center">
                        <svg class="w-5 h-5 text-[var(--primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0A1.75 1.75 0 003 15.546M3 12.5c.523 0 1.046-.151 1.5-.454a2.704 2.704 0 013 0 2.704 2.704 0 003 0 2.704 2.704 0 013 0 2.704 2.704 0 003 0c.454-.303.977-.454 1.5-.454"/></svg>
                    </div>
                    <h4 class="text-lg font-display font-medium text-[var(--text)] mb-3">Resepsi</h4>
                    <p class="text-sm font-medium text-[var(--text)]">{{ ($invitation->reception_date ?? $invitation->event_date)->translatedFormat('l, d F Y') }}</p>
                    @if($invitation->reception_time_start)
                    <p class="text-sm text-[var(--muted)]">Pukul {{ \Carbon\Carbon::parse($invitation->reception_time_start)->format('H:i') }} {{ $invitation->reception_time_end ? '- ' . \Carbon\Carbon::parse($invitation->reception_time_end)->format('H:i') : '' }} WIB</p>
                    @endif
                </div>
                @endif

                <!-- Lokasi -->
                <div class="event-card anim anim-d3">
                    <div class="w-11 h-11 mx-auto mb-4 rounded-full bg-[var(--warm)] flex items-center justify-center">
                        <svg class="w-5 h-5 text-[var(--primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h4 class="text-base font-display font-medium text-[var(--text)] mb-2">{{ $invitation->event_venue }}</h4>
                    @if($invitation->event_address)
                    <p class="text-xs text-[var(--muted)] leading-relaxed mb-4">{{ $invitation->event_address }}</p>
                    @endif
                    @if($invitation->event_maps_url)
                    <a href="{{ $invitation->event_maps_url }}" target="_blank" class="btn-primary text-xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        Lihat Google Maps
                    </a>
                    @endif
                </div>

                @if($invitation->dress_code)
                <div class="text-center mt-5 anim">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-[var(--warm)] rounded-full border border-[var(--border)]">
                        <span class="text-[10px] text-[var(--muted)]">Dress Code:</span>
                        <span class="text-[10px] font-medium text-[var(--primary)]">{{ $invitation->dress_code }}</span>
                    </div>
                </div>
                @endif
            </div>
        </section>

        <!-- GALLERY -->
        @if($invitation->galleries->count() > 0)
        <section class="py-20 px-6 bg-[var(--cream)]">
            <div class="max-w-lg mx-auto">
                <div class="text-center mb-12 anim">
                    <p class="text-[10px] uppercase tracking-[0.4em] text-[var(--muted)] mb-2">Our Moments</p>
                    <h3 class="text-2xl font-display text-[var(--text)]">Galeri</h3>
                </div>
                <div class="grid grid-cols-2 gap-2 anim anim-d1">
                    @foreach($invitation->galleries as $i => $photo)
                    <div class="aspect-square rounded-xl overflow-hidden {{ $i === 0 ? 'col-span-2 aspect-video' : '' }} group">
                        <img src="{{ $photo->getImageUrl() }}" alt="{{ $photo->caption }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- RSVP -->
        <section class="py-20 px-6 bg-[var(--card)]">
            <div class="max-w-sm mx-auto">
                <div class="text-center mb-10 anim">
                    <p class="text-[10px] uppercase tracking-[0.4em] text-[var(--muted)] mb-2">Konfirmasi</p>
                    <h3 class="text-2xl font-display text-[var(--text)]">RSVP</h3>
                    <p class="text-xs text-[var(--muted)] mt-2">Mohon konfirmasi kehadiran Anda</p>
                </div>

                @if(session('success'))
                <div class="mb-5 p-3.5 bg-green-50 border border-green-200 text-green-700 text-xs text-center rounded-xl">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" class="space-y-3 anim anim-d1">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Lengkap" required class="form-input">
                    <select name="rsvp_status" required class="form-input">
                        <option value="">-- Konfirmasi Kehadiran --</option>
                        <option value="attending">Ya, Saya Akan Hadir</option>
                        <option value="not_attending">Maaf, Tidak Bisa Hadir</option>
                        <option value="maybe">Masih Ragu</option>
                    </select>
                    <input type="number" name="number_of_guests" min="1" max="10" value="1" placeholder="Jumlah Tamu" class="form-input">
                    <button type="submit" class="btn-primary w-full justify-center">Kirim Konfirmasi</button>
                </form>
            </div>
        </section>

        <!-- UCAPAN -->
        <section class="py-20 px-6 bg-[var(--cream)]">
            <div class="max-w-sm mx-auto">
                <div class="text-center mb-10 anim">
                    <p class="text-[10px] uppercase tracking-[0.4em] text-[var(--muted)] mb-2">Wishes</p>
                    <h3 class="text-2xl font-display text-[var(--text)]">Ucapan & Doa</h3>
                </div>

                <form method="POST" action="{{ route('invitation.guestbook', $invitation->slug) }}" class="space-y-3 mb-8 anim anim-d1">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Anda" required class="form-input">
                    <textarea name="message" rows="3" placeholder="Tulis ucapan & doa terbaik..." required class="form-input" style="resize:none"></textarea>
                    <button type="submit" class="btn-secondary w-full justify-center">Kirim Ucapan</button>
                </form>

                <div class="space-y-3 max-h-72 overflow-y-auto anim anim-d2">
                    @foreach($invitation->guestbooks as $msg)
                    <div class="bg-[var(--card)] rounded-xl p-4 border border-[var(--border)]">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-[var(--warm)] flex items-center justify-center flex-shrink-0">
                                <span class="text-[10px] font-bold text-[var(--primary)]">{{ strtoupper(substr($msg->name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-[var(--text)]">{{ $msg->name }}</p>
                                <p class="text-xs text-[var(--muted)] mt-1 leading-relaxed">{{ $msg->message }}</p>
                                <p class="text-[9px] text-[var(--muted)] opacity-50 mt-1">{{ $msg->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- AMPLOP DIGITAL -->
        @if($invitation->bank_name || $invitation->qris_image)
        <section class="py-20 px-6 bg-[var(--card)]">
            <div class="max-w-sm mx-auto text-center anim">
                <div class="divider mb-8"></div>
                <p class="text-[10px] uppercase tracking-[0.4em] text-[var(--muted)] mb-2">Wedding Gift</p>
                <h3 class="text-2xl font-display text-[var(--text)] mb-3">Amplop Digital</h3>
                @if($invitation->gift_info)
                <p class="text-xs text-[var(--muted)] mb-8 leading-relaxed">{{ $invitation->gift_info }}</p>
                @else
                <p class="text-xs text-[var(--muted)] mb-8">Doa restu Anda sudah cukup. Namun jika berkenan memberi tanda kasih:</p>
                @endif

                @if($invitation->bank_name)
                <div class="event-card mb-4" x-data="{ copied: false }">
                    <p class="text-[10px] uppercase tracking-wider text-[var(--muted)] mb-2">{{ $invitation->bank_name }}</p>
                    <p class="text-xl font-bold text-[var(--text)] tracking-wider mb-1">{{ $invitation->bank_account_number }}</p>
                    <p class="text-xs text-[var(--muted)]">a.n. {{ $invitation->bank_account_name }}</p>
                    <button @click="navigator.clipboard.writeText('{{ $invitation->bank_account_number }}'); copied = true; setTimeout(() => copied = false, 2000)" class="mt-4 px-5 py-2 bg-[var(--warm)] text-[var(--primary)] text-[11px] font-medium rounded-full hover:bg-[var(--primary)] hover:text-white transition-all border border-[var(--border)]">
                        <span x-text="copied ? '✓ Tersalin!' : 'Salin Nomor'"></span>
                    </button>
                </div>
                @endif

                @if($invitation->qris_image)
                <div class="event-card inline-block">
                    <img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS" class="w-44 h-44 object-contain mx-auto">
                    <p class="text-[10px] text-[var(--muted)] mt-2">Scan QRIS</p>
                </div>
                @endif

                <div class="divider mt-8" style="transform: scaleY(-1)"></div>
            </div>
        </section>
        @endif

        <!-- CLOSING -->
        @if($invitation->closing_text)
        <section class="py-20 px-6 bg-[var(--primary)] relative">
            <div class="max-w-md mx-auto text-center anim relative z-10">
                <div class="divider mb-8 opacity-40" style="filter: brightness(3)"></div>
                <p class="text-sm text-white/70 leading-loose italic">{{ $invitation->closing_text }}</p>
                <p class="text-xs text-white/40 mt-6 mb-2">Kami yang berbahagia,</p>
                <h4 class="text-2xl font-script text-white">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</h4>
                <div class="divider mt-8 opacity-40" style="filter: brightness(3); transform: scaleY(-1)"></div>
            </div>
        </section>
        @endif

        <!-- FOOTER -->
        <footer class="py-8 px-6 bg-[var(--cream)] text-center">
            <div class="divider mb-4"></div>
            <p class="text-[10px] text-[var(--muted)]">Created by <a href="{{ url('/') }}" class="text-[var(--primary)] hover:underline font-medium">UndanganDigital</a></p>
        </footer>
    </div>

    <!-- MUSIC -->
    @if($invitation->music_url)
    <div class="fixed bottom-5 right-5 z-40" x-show="opened" x-transition>
        <button @click="toggleMusic()" class="w-11 h-11 rounded-full shadow-lg flex items-center justify-center transition-all"
            :class="playing ? 'bg-[var(--primary)] text-white music-pulse' : 'bg-white text-[var(--primary)] border border-[var(--border)]'">
            <svg x-show="!playing" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>
            <svg x-show="playing" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5.75 3a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75A.75.75 0 007.25 3h-1.5zM12.75 3a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75a.75.75 0 00-.75-.75h-1.5z"/></svg>
        </button>
        <audio x-ref="audio" src="{{ asset('storage/' . $invitation->music_url) }}" loop preload="auto"></audio>
    </div>
    @endif

    <!-- SCRIPT -->
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
                this.$nextTick(() => setTimeout(() => this.initAnim(), 150));
            },
            toggleMusic() { if (this.playing) { this.$refs.audio?.pause(); } else { this.$refs.audio?.play(); } this.playing = !this.playing; },
            initAnim() {
                const obs = new IntersectionObserver((entries) => {
                    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('show'); });
                }, { threshold: 0.12, rootMargin: '0px 0px -30px 0px' });
                document.querySelectorAll('.anim').forEach(el => obs.observe(el));
            }
        };
    }
    function countdown(targetDate) {
        return {
            days: 0, hours: 0, minutes: 0, seconds: 0,
            init() { this.update(); setInterval(() => this.update(), 1000); },
            update() {
                const d = new Date(targetDate) - new Date();
                if (d > 0) { this.days = Math.floor(d/(864e5)); this.hours = Math.floor((d%864e5)/36e5); this.minutes = Math.floor((d%36e5)/6e4); this.seconds = Math.floor((d%6e4)/1e3); }
            }
        };
    }
    </script>
</body>
</html>
