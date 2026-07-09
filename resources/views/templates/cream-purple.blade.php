<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Marcellus&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Great+Vibes&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
:root {
            --cream:#ded7c7;
            --cream-light:#f5f0e8;
            --brown:#604024;
            --purple:#9F709A;
            --purple-dark:#7a5577;
            --olive:#747254;
            --font-base:'Marcellus',serif;
            --font-accent:'Playfair Display',serif;
            --font-script:'Great Vibes',cursive;
        }

        body {
            font-family:var(--font-base) !important;
            line-height:1.6;
            color:var(--brown);
            overflow-x:hidden;
            background:var(--cream);
        }

        .font-accent {
            font-family:var(--font-accent)!important;
        }

        .font-script {
            font-family:var(--font-script)!important;
        }

        [x-cloak] {
            display:none!important;
        }

        @keyframes waveL {
            0%{transform:rotate(-3deg)}100%{transform:rotate(4deg)};
        }

        @keyframes waveR {
            0%{transform:rotate(3deg)}100%{transform:rotate(-4deg)};
        }

        .wave-l {
            animation:waveL 4s ease-in-out infinite alternate;
            transform-origin:bottom center;
        }

        .wave-r {
            animation:waveR 4s ease-in-out infinite alternate;
            transform-origin:bottom center;
        }

        .reveal {
            opacity:0;
            transform:translateY(30px);
            transition:all .8s cubic-bezier(.25,.46,.45,.94);
        }

        .reveal.active {
            opacity:1;
            transform:translateY(0);
        }

        .btn-c {
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:12px 28px;
            background:var(--purple);
            color:#fff;
            font-weight:600;
            font-size:14px;
            border-radius:50px;
            border:none;
            cursor:pointer;
            text-decoration:none;
            font-family:var(--font-base) !important;
            box-shadow:0 4px 15px rgba(159,112,154,.35);
            transition:all .3s;
        }

        .btn-c:hover {
            background:var(--purple-dark);
            transform:translateY(-2px);
        }

        .btn-o {
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:10px 24px;
            border:2px solid var(--purple);
            color:var(--purple);
            font-weight:600;
            font-size:13px;
            border-radius:50px;
            background:transparent;
            cursor:pointer;
            text-decoration:none;
            font-family:var(--font-base) !important;
            transition:all .3s;
        }

        .btn-o:hover {
            background:var(--purple);
            color:#fff;
        }

        .inp {
            width:100%;
            padding:12px 16px;
            background:rgba(255,255,255,.6);
            border:1.5px solid var(--olive);
            border-radius:12px;
            font-size:14px;
            color:var(--brown);
            font-family:var(--font-base) !important;
        }

        .inp:focus {
            outline:none;
            border-color:var(--purple);
            box-shadow:0 0 0 3px rgba(159,112,154,.1);
        }

        .sf {
            min-height:100vh;
            position:relative;
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
            padding:80px 24px;
        }

        @media(min-width:768px) {
            .sf {
                padding:80px 48px;
            }
        }

        @media(min-width:1024px) {
            .sf {
                padding:80px 80px;
            }
        }

        .cd {
            display:inline-flex;
            flex-direction:column;
            align-items:center;
            padding:10px 14px;
            border:1.5px solid var(--purple);
            border-radius:10px;
            margin:0 4px;
            min-width:60px;
            background:rgba(255,255,255,.3);
            backdrop-filter:blur(5px);
        }

        .cd .n {
            font-size:1.8rem;
            font-weight:700;
            color:var(--purple);
            font-family:var(--font-accent) !important;
        }

        .cd .l {
            font-size:.7rem;
            color:#fff;
        }

        .gi {
            border-radius:8px;
            border:3px solid var(--olive);
        }

        .gi img {
            width:100%;
            height:100%;
            object-fit:cover;
            transition:transform .5s;
        }

        .gi:hover img {
            transform:scale(1.08);
        }

        .ft1 {
            transform:rotate(-4deg);
            border:3px solid var(--olive);
            border-radius:6px;
            }

        .ft2 {
            transform:rotate(2deg);
            border:3px solid var(--olive);
            border-radius:6px;
            }

        .bc {
            display:flex;
            align-items:center;
            gap:12px;
            padding:12px;
            border:1px solid var(--olive);
            border-radius:10px;
            background:rgba(255,255,255,.4);
        }

        .bl {
            width:60px;
            height:40px;
            object-fit:contain;
            border-radius:6px;
            background:#fff;
            padding:4px;
        }

        .mb {
            position:fixed;
            bottom:20px;
            right:20px;
            z-index:100;
            width:48px;
            height:48px;
            border-radius:50%;
            background:var(--purple);
            color:#fff;
            border:none;
            cursor:pointer;
            display:flex;
            align-items:center;
            justify-content:center;
            box-shadow:0 4px 15px rgba(0,0,0,.2);
            transition:transform .3s;
        }

        .mb:hover {
            transform:scale(1.1);
        }

        ::-webkit-scrollbar {
            width:4px;
        }

        ::-webkit-scrollbar-thumb {
            background:var(--purple);
            border-radius:4px;
        }

        @media(max-width:480px) {
            .cd {
                padding:8px 10px;
                min-width:50px;
            }
            .cd .n {
                font-size:1.4rem;
            }
            .sf {
                padding:60px 16px;
            }
        }


    </style>
    </head>
<body class="font-body bg-[var(--cream)] text-[var(--brown)] overflow-x-hidden" x-data="creamApp()" x-cloak>

    <!-- COVER SECTION -->
    <section x-show="!opened" class="fixed inset-0 z-50 flex items-center justify-center"
        x-transition:leave="transition ease-in duration-700"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-110"
        style="background: linear-gradient(180deg, #ded7c7 0%, #f5f0e8 50%, #ded7c7 100%);">
        <!-- Flower decorations -->
        <div class="petal wave-l" style="width:80px;height:120px;background:#9F709A;top:8%;left:5%;transform:rotate(-25deg);opacity:.12"></div>
        <div class="petal wave-r" style="width:60px;height:90px;background:#9F709A;top:5%;right:8%;transform:rotate(25deg) scaleX(-1);opacity:.12"></div>
        <div class="petal wave-l" style="width:50px;height:75px;background:#747254;bottom:12%;left:8%;transform:rotate(-15deg);opacity:.08"></div>
        <div class="petal wave-r" style="width:55px;height:80px;background:#747254;bottom:8%;right:5%;transform:rotate(20deg) scaleX(-1);opacity:.08"></div>
        <!-- SVG leaf top-left -->
        <div class="absolute top-0 left-0 w-32 h-32 sm:w-44 sm:h-44 pointer-events-none wave-l" style="opacity:.5">
            <svg viewBox="0 0 200 200" fill="none"><path d="M10 10 C50 20 90 30 120 60 C140 80 130 100 110 110 C90 115 60 100 40 80 C25 65 15 40 10 10Z" fill="rgba(159,112,154,0.35)"/><path d="M10 10 C40 30 70 60 80 90" stroke="rgba(116,114,84,0.3)" stroke-width="1.5" fill="none"/></svg>
        </div>
        <!-- SVG leaf top-right -->
        <div class="absolute top-0 right-0 w-32 h-32 sm:w-44 sm:h-44 pointer-events-none wave-r" style="opacity:.5">
            <svg viewBox="0 0 200 200" fill="none" style="transform:scaleX(-1)"><path d="M10 10 C50 20 90 30 120 60 C140 80 130 100 110 110 C90 115 60 100 40 80 C25 65 15 40 10 10Z" fill="rgba(159,112,154,0.35)"/></svg>
        </div>
        <!-- SVG leaf bottom-left -->
        <div class="absolute bottom-0 left-0 w-28 h-28 sm:w-36 sm:h-36 pointer-events-none wave-l" style="opacity:.4">
            <svg viewBox="0 0 200 200" fill="none" style="transform:rotate(180deg)"><path d="M10 10 C50 20 90 30 120 60 C140 80 130 100 110 110 C90 115 60 100 40 80 C25 65 15 40 10 10Z" fill="rgba(159,112,154,0.3)"/></svg>
        </div>
        <!-- SVG leaf bottom-right -->
        <div class="absolute bottom-0 right-0 w-28 h-28 sm:w-36 sm:h-36 pointer-events-none wave-r" style="opacity:.4">
            <svg viewBox="0 0 200 200" fill="none" style="transform:rotate(180deg) scaleX(-1)"><path d="M10 10 C50 20 90 30 120 60 C140 80 130 100 110 110 C90 115 60 100 40 80 C25 65 15 40 10 10Z" fill="rgba(159,112,154,0.3)"/></svg>
        </div>
        <div class="text-center relative z-10 px-6">
            <p class="text-sm tracking-[0.3em] uppercase mb-4" style="color:var(--olive)">The Wedding Of</p>
            <h1 class="font-script text-5xl sm:text-7xl mb-6" style="color:var(--purple)">
                {{ $invitation->groom_name ?? 'Nizar' }} & {{ $invitation->bride_name ?? 'Aera' }}
            </h1>
            <div class="mt-4 p-4 rounded-xl max-w-xs mx-auto" style="background:rgba(255,255,255,.47);backdrop-filter:blur(8px)">
                <p class="text-sm" style="color:var(--olive)">Kepada Yth.</p>
                <p class="text-base font-semibold mt-1" style="color:var(--brown)">{{ $invitation->guest_name ?? 'Bapak/Ibu/Saudara/i' }}</p>
            </div>
            <button @click="opened = true; playMusic()" class="btn-c mt-8">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                Buka Undangan
            </button>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <div x-show="opened" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="main-content">

        <!-- OPENING SECTION -->
        <section class="sf" style="background:linear-gradient(180deg, #f5f0e8 0%, #ded7c7 100%)">
            <div class="petal wave-l" style="width:60px;height:90px;background:#9F709A;top:5%;left:-3%;opacity:.1"></div>
            <div class="petal wave-r" style="width:50px;height:75px;background:#9F709A;top:8%;right:-2%;opacity:.1"></div>
            <div class="text-center max-w-lg mx-auto reveal">
                <p class="text-lg mb-2" style="color:var(--purple)">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ</p>
                <p class="text-sm italic mt-6 mb-8" style="color:var(--olive)">Assalamu'alaikum Warahmatullahi Wabarakatuh</p>
                <p class="text-sm leading-relaxed mb-8" style="color:var(--brown)">Tanpa mengurangi rasa hormat, kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara pernikahan kami</p>
                <div class="my-8">
                    <h2 class="font-accent text-2xl sm:text-3xl" style="color:var(--purple)">{{ $invitation->groom_name ?? 'Nizar' }}</h2>
                    <p class="font-script text-4xl my-2" style="color:var(--olive)">&</p>
                    <h2 class="font-accent text-2xl sm:text-3xl" style="color:var(--purple)">{{ $invitation->bride_name ?? 'Aera' }}</h2>
                </div>
                <div class="my-8 p-6 rounded-xl" style="background:rgba(159,112,154,.08)">
                    <p class="text-sm italic leading-relaxed" style="color:var(--olive)">"Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu pasangan hidup dari jenismu sendiri, supaya kamu cenderung dan merasa tenteram kepadanya, dan dijadikan-Nya di antaramu rasa kasih dan sayang."</p>
                    <p class="text-xs mt-3 font-semibold" style="color:var(--purple)">QS. Ar-Rum: 21</p>
                </div>
            </div>
            <!-- Flower divider -->
            <div class="flex items-center justify-center gap-4 mt-8 opacity-30">
                <svg width="60" height="20" viewBox="0 0 60 20"><path d="M0 10 Q15 0 30 10 Q45 20 60 10" stroke="#9F709A" fill="none" stroke-width="1.5"/></svg>
                <div style="width:8px;height:8px;border-radius:50%;background:#9F709A"></div>
                <svg width="60" height="20" viewBox="0 0 60 20"><path d="M0 10 Q15 20 30 10 Q45 0 60 10" stroke="#9F709A" fill="none" stroke-width="1.5"/></svg>
            </div>
        </section>

        <!-- COUPLE SECTION -->
        <section class="sf" style="background:linear-gradient(180deg, #ded7c7 0%, #f5f0e8 100%)">
            <div class="text-center max-w-lg mx-auto reveal">
                <h3 class="text-xs tracking-[0.3em] uppercase mb-6" style="color:var(--olive)">Mempelai</h3>
                <!-- Groom -->
                <div class="mb-8">
                    <div class="w-40 h-40 mx-auto rounded-full border-4 overflow-hidden mb-4" style="border-color:var(--purple)">
                        @if(optional($invitation)->groom_photo)
                            <img src="{{ Storage::url($invitation->groom_photo) }}" alt="{{ $invitation->groom_name ?? 'Groom' }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center" style="background:rgba(159,112,154,.15)">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#9F709A" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                            </div>
                        @endif
                    </div>
                    <h2 class="font-accent text-xl" style="color:var(--purple)">{{ $invitation->groom_name ?? 'Nizar' }}</h2>
                    @if(optional($invitation)->groom_full_name)
                        <p class="text-sm mt-1" style="color:var(--brown)">{{ $invitation->groom_full_name }}</p>
                    @endif
                    @if(optional($invitation)->groom_parents)
                        <p class="text-xs mt-2" style="color:var(--olive)">{{ $invitation->groom_parents }}</p>
                    @endif
                    @if(optional($invitation)->groom_ig)
                        <a href="https://instagram.com/{{ ltrim($invitation->groom_ig, '@') }}" target="_blank" class="btn-o mt-3 text-xs">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="5"/><circle cx="17.5" cy="6.5" r="1.5" fill="currentColor"/></svg>
                            {{ $invitation->groom_ig }}
                        </a>
                    @endif
                </div>
                <!-- Ampersand -->
                <p class="font-script text-4xl my-4" style="color:var(--olive)">&</p>
                <!-- Bride -->
                <div class="mb-8">
                    <div class="w-40 h-40 mx-auto rounded-full border-4 overflow-hidden mb-4" style="border-color:var(--purple)">
                        @if(optional($invitation)->bride_photo)
                            <img src="{{ Storage::url($invitation->bride_photo) }}" alt="{{ $invitation->bride_name ?? 'Bride' }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center" style="background:rgba(159,112,154,.15)">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#9F709A" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                            </div>
                        @endif
                    </div>
                    <h2 class="font-accent text-xl" style="color:var(--purple)">{{ $invitation->bride_name ?? 'Aera' }}</h2>
                    @if(optional($invitation)->bride_full_name)
                        <p class="text-sm mt-1" style="color:var(--brown)">{{ $invitation->bride_full_name }}</p>
                    @endif
                    @if(optional($invitation)->bride_parents)
                        <p class="text-xs mt-2" style="color:var(--olive)">{{ $invitation->bride_parents }}</p>
                    @endif
                    @if(optional($invitation)->bride_ig)
                        <a href="https://instagram.com/{{ ltrim($invitation->bride_ig, '@') }}" target="_blank" class="btn-o mt-3 text-xs">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="5"/><circle cx="17.5" cy="6.5" r="1.5" fill="currentColor"/></svg>
                            {{ $invitation->bride_ig }}
                        </a>
                    @endif
                </div>
            </div>
        </section>

        <!-- EVENT SECTION -->
        <section class="sf" style="background:linear-gradient(180deg, #f5f0e8 0%, #ded7c7 100%)">
            <div class="petal wave-r" style="width:50px;height:75px;background:#747254;top:10%;right:-2%;opacity:.08"></div>
            <div class="text-center max-w-lg mx-auto reveal">
                <h3 class="text-xs tracking-[0.3em] uppercase mb-8" style="color:var(--olive)">Waktu & Tempat</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Akad -->
                    <div class="p-6 rounded-xl" style="background:rgba(255,255,255,.5);border:1px solid rgba(116,114,84,.2)">
                        <div class="w-12 h-12 mx-auto mb-4 rounded-full flex items-center justify-center" style="background:rgba(159,112,154,.15)">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#9F709A" stroke-width="1.5"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                        </div>
                        <h4 class="font-accent text-lg mb-2" style="color:var(--purple)">Akad Nikah</h4>
                        @if(optional($invitation)->akad_date)
                            <p class="text-sm font-semibold" style="color:var(--brown)">{{ \Carbon\Carbon::parse($invitation->akad_date)->translatedFormat('d F Y') }}</p>
                        @elseif(optional($invitation)->event_date)
                            <p class="text-sm font-semibold" style="color:var(--brown)">{{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d F Y') }}</p>
                        @endif
                        @if(optional($invitation)->akad_time)
                            <p class="text-sm mt-1" style="color:var(--olive)">{{ $invitation->akad_time }} WIB</p>
                        @endif
                        @if(optional($invitation)->akad_venue)
                            <p class="text-xs mt-2" style="color:var(--brown)">{{ $invitation->akad_venue }}</p>
                        @elseif(optional($invitation)->event_venue)
                            <p class="text-xs mt-2" style="color:var(--brown)">{{ $invitation->event_venue }}</p>
                        @endif
                    </div>
                    <!-- Resepsi -->
                    <div class="p-6 rounded-xl" style="background:rgba(255,255,255,.5);border:1px solid rgba(116,114,84,.2)">
                        <div class="w-12 h-12 mx-auto mb-4 rounded-full flex items-center justify-center" style="background:rgba(159,112,154,.15)">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#9F709A" stroke-width="1.5"><path d="M8 2v4M16 2v4M3 10h18M5 4h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z"/></svg>
                        </div>
                        <h4 class="font-accent text-lg mb-2" style="color:var(--purple)">Resepsi</h4>
                        @if(optional($invitation)->resepsi_date)
                            <p class="text-sm font-semibold" style="color:var(--brown)">{{ \Carbon\Carbon::parse($invitation->resepsi_date)->translatedFormat('d F Y') }}</p>
                        @elseif(optional($invitation)->event_date)
                            <p class="text-sm font-semibold" style="color:var(--brown)">{{ \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d F Y') }}</p>
                        @endif
                        @if(optional($invitation)->resepsi_time)
                            <p class="text-sm mt-1" style="color:var(--olive)">{{ $invitation->resepsi_time }} WIB</p>
                        @elseif(optional($invitation)->event_time)
                            <p class="text-sm mt-1" style="color:var(--olive)">{{ $invitation->event_time }} WIB</p>
                        @endif
                        @if(optional($invitation)->resepsi_venue)
                            <p class="text-xs mt-2" style="color:var(--brown)">{{ $invitation->resepsi_venue }}</p>
                        @elseif(optional($invitation)->event_venue)
                            <p class="text-xs mt-2" style="color:var(--brown)">{{ $invitation->event_venue }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Flower divider -->
            <div class="flex items-center justify-center gap-4 mt-10 opacity-30">
                <svg width="60" height="20" viewBox="0 0 60 20"><path d="M0 10 Q15 0 30 10 Q45 20 60 10" stroke="#9F709A" fill="none" stroke-width="1.5"/></svg>
                <div style="width:8px;height:8px;border-radius:50%;background:#9F709A"></div>
                <svg width="60" height="20" viewBox="0 0 60 20"><path d="M0 10 Q15 20 30 10 Q45 0 60 10" stroke="#9F709A" fill="none" stroke-width="1.5"/></svg>
            </div>
        </section>

        <!-- COUNTDOWN + MAP SECTION -->
        <section class="sf" style="background:linear-gradient(180deg, #ded7c7 0%, #9F709A 100%)">
            <div class="text-center max-w-lg mx-auto reveal">
                <h3 class="text-xs tracking-[0.3em] uppercase mb-4 text-white opacity-80">Hitung Mundur</h3>
                <div class="flex justify-center mb-8" x-data="countdown()" x-init="init()">
                    <div class="cd"><span class="n" x-text="days">0</span><span class="l">Hari</span></div>
                    <div class="cd"><span class="n" x-text="hours">0</span><span class="l">Jam</span></div>
                    <div class="cd"><span class="n" x-text="minutes">0</span><span class="l">Menit</span></div>
                    <div class="cd"><span class="n" x-text="seconds">0</span><span class="l">Detik</span></div>
                </div>
                @if(optional($invitation)->event_date)
                    <a href="https://www.google.com/calendar/render?action=TEMPLATE&text={{ urlencode(($invitation->title ?? 'Wedding') . ' - ' . ($invitation->groom_name ?? '') . ' & ' . ($invitation->bride_name ?? '')) }}&dates={{ \Carbon\Carbon::parse($invitation->event_date)->format('Ymd') }}T{{ \Carbon\Carbon::parse($invitation->event_time ?? '08:00')->format('Hi00') }}00Z&location={{ urlencode($invitation->event_venue ?? '') }}" target="_blank" class="btn-o text-white" style="border-color:rgba(255,255,255,.5)">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Tambahkan ke Kalender
                    </a>
                @endif
                @if(optional($invitation)->google_maps)
                    <div class="mt-8 rounded-xl overflow-hidden" style="border:2px solid rgba(255,255,255,.3)">
                        <iframe src="{{ $invitation->google_maps }}" width="100%" height="250" style="border:0;" allowfullscreen loading="lazy"></iframe>
                    </div>
                    <p class="text-xs text-white mt-4 opacity-80">{{ $invitation->event_venue ?? '' }}</p>
                    <a href="{{ $invitation->google_maps }}" target="_blank" class="btn-o mt-3 text-white" style="border-color:rgba(255,255,255,.5)">Buka Google Maps</a>
                @endif
            </div>
        </section>

        <!-- GALLERY SECTION -->
        <section class="sf" style="background:linear-gradient(180deg, #9F709A 0%, #ded7c7 100%)">
            <div class="text-center max-w-lg mx-auto reveal">
                <h3 class="text-xs tracking-[0.3em] uppercase mb-8 text-white opacity-80">Galeri</h3>
                @if(optional($invitation)->gallery && count($invitation->gallery) > 0)
                    <div class="columns-2 gap-3 px-4">
                        @foreach($invitation->gallery as $i => $photo)
                            <div class="gi mb-3 {{ $i % 3 == 0 ? 'ft1' : 'ft2' }}">
                                <img src="{{ Storage::url($photo) }}" alt="Gallery {{ $i + 1 }}" loading="lazy">
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="columns-2 gap-3 px-4">
                        <div class="gi mb-3 ft1"><div class="w-full h-48 sm:h-64" style="background:rgba(159,112,154,.2)"></div></div>
                        <div class="gi mb-3 ft2"><div class="w-full h-40 sm:h-56" style="background:rgba(159,112,154,.15)"></div></div>
                        <div class="gi mb-3 ft2"><div class="w-full h-44 sm:h-60" style="background:rgba(159,112,154,.18)"></div></div>
                        <div class="gi mb-3 ft1"><div class="w-full h-52 sm:h-72" style="background:rgba(159,112,154,.12)"></div></div>
                    </div>
                @endif
            </div>
        </section>

        <!-- RSVP SECTION -->
        <section class="sf" style="background:linear-gradient(180deg, #ded7c7 0%, #f5f0e8 100%)" x-data="{ showForm: false }">
            <div class="text-center max-w-lg mx-auto reveal">
                <h3 class="text-xs tracking-[0.3em] uppercase mb-8" style="color:var(--olive)">Ucapan & RSVP</h3>
                <!-- Tilted photo frames -->
                <div class="flex justify-center gap-4 mb-8">
                    <div class="ft1 w-24 h-32 sm:w-32 sm:h-40">
                        @if(optional($invitation)->groom_photo)
                            <img src="{{ Storage::url($invitation->groom_photo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full" style="background:rgba(159,112,154,.15)"></div>
                        @endif
                    </div>
                    <div class="ft2 w-24 h-32 sm:w-32 sm:h-40">
                        @if(optional($invitation)->bride_photo)
                            <img src="{{ Storage::url($invitation->bride_photo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full" style="background:rgba(159,112,154,.15)"></div>
                        @endif
                    </div>
                </div>
                <button @click="showForm = !showForm" class="btn-c">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                    Kirim Ucapan
                </button>
                <div x-show="showForm" x-transition class="mt-6 text-left">
                    <div class="space-y-3">
                        <input type="text" placeholder="Nama" class="inp" x-model="rsvpName">
                        <div class="flex gap-2">
                            <button @click="rsvpAttend='Hadir'" :class="rsvpAttend=='Hadir'?'btn-c':'btn-o' + ' flex-1 text-sm py-2'">Hadir</button>
                            <button @click="rsvpAttend='Tidak Hadir'" :class="rsvpAttend=='Tidak Hadir'?'btn-c':'btn-o' + ' flex-1 text-sm py-2'">Tidak Hadir</button>
                        </div>
                        <textarea placeholder="Ucapan & Doa" class="inp" rows="3" x-model="rsvpMsg"></textarea>
                        <button @click="submitRsvp()" class="btn-c w-full justify-center">Kirim</button>
                    </div>
                </div>
                <!-- Wishes list -->
                <div class="mt-8 space-y-3 text-left" x-init="loadWishes()">
                    <template x-for="w in wishes" :key="w.id">
                        <div class="p-3 rounded-xl" style="background:rgba(255,255,255,.5);border:1px solid rgba(116,114,84,.15)">
                            <p class="text-sm font-semibold" style="color:var(--purple)" x-text="w.name"></p>
                            <p class="text-xs mt-1" style="color:var(--brown)" x-text="w.message"></p>
                            <p class="text-xs mt-1 opacity-50" style="color:var(--olive)" x-text="w.created_at"></p>
                        </div>
                    </template>
                </div>
            </div>
        </section>

        <!-- GIFT / CLOSING SECTION -->
        <section class="sf" style="background:linear-gradient(180deg, #f5f0e8 0%, #ded7c7 100%)">
            <div class="petal wave-l" style="width:60px;height:90px;background:#9F709A;bottom:5%;left:-3%;opacity:.1"></div>
            <div class="petal wave-r" style="width:50px;height:75px;background:#9F709A;bottom:8%;right:-2%;opacity:.1"></div>
            <div class="text-center max-w-lg mx-auto reveal">
                <h3 class="text-xs tracking-[0.3em] uppercase mb-6" style="color:var(--olive)">Kirim Hadiah</h3>
                @if(optional($invitation)->bank_accounts && count($invitation->bank_accounts) > 0)
                    <div class="space-y-3 mb-8">
                        @foreach($invitation->bank_accounts as $account)
                            <div class="bc">
                                <div class="bl flex items-center justify-center">
                                    <span class="text-xs font-bold" style="color:var(--purple)">{{ strtoupper(substr($account['bank_name'] ?? 'BANK', 0, 3)) }}</span>
                                </div>
                                <div class="text-left flex-1">
                                    <p class="text-xs" style="color:var(--olive)">{{ $account['bank_name'] ?? '' }}</p>
                                    <p class="text-sm font-semibold" style="color:var(--brown)">{{ $account['account_number'] ?? '' }}</p>
                                    <p class="text-xs" style="color:var(--olive)">{{ $account['account_name'] ?? '' }}</p>
                                </div>
                                <button @click="copyToClipboard('{{ $account['account_number'] ?? '' }}')" class="btn-o text-xs py-1 px-3">Salin</button>
                            </div>
                        @endforeach
                    </div>
                @endif
                @if(optional($invitation)->gift_address)
                    <div class="p-4 rounded-xl mb-8" style="background:rgba(255,255,255,.4);border:1px solid rgba(116,114,84,.15)">
                        <p class="text-xs" style="color:var(--olive)">Alamat Kirim Hadiah</p>
                        <p class="text-sm mt-1" style="color:var(--brown)">{{ $invitation->gift_address }}</p>
                    </div>
                @endif
                <!-- Closing -->
                <div class="mt-12 mb-8">
                    <p class="text-sm mb-4" style="color:var(--olive)">Merupakan suatu kehormatan dan kebahagiaan apabila Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu kepada kami.</p>
                    <p class="text-sm mb-2" style="color:var(--olive)">Atas kehadiran dan doa restunya, kami mengucapkan terima kasih.</p>
                </div>
                <div class="my-8">
                    <p class="font-script text-3xl" style="color:var(--purple)">{{ $invitation->groom_name ?? 'Nizar' }} & {{ $invitation->bride_name ?? 'Aera' }}</p>
                </div>
                <p class="text-xs" style="color:var(--olive)">Wassalamu'alaikum Warahmatullahi Wabarakatuh</p>
            </div>
        </section>
    </div>

    <!-- Music toggle -->
    <button @click="toggleMusic()" class="mb" x-show="opened">
        <svg x-show="!musicPlaying" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>
        <svg x-show="musicPlaying" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="2" width="4" height="20"/><rect x="14" y="2" width="4" height="20"/></svg>
    </button>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function creamApp() {
            return {
                opened: false,
                musicPlaying: false,
                rsvpName: '',
                rsvpAttend: 'Hadir',
                rsvpMsg: '',
                wishes: [],
                init() {
                    const params = new URLSearchParams(window.location.search);
                    if (params.get('guest')) {
                        this.opened = true;
                    }
                    // Scroll reveal
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('active'); }});
                    }, { threshold: 0.1 });
                    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
                    this.loadWishes();
                },
                playMusic() {
                    const audio = document.getElementById('bgm');
                    if (audio) { audio.play().catch(()=>{}); this.musicPlaying = true; }
                },
                toggleMusic() {
                    const audio = document.getElementById('bgm');
                    if (!audio) return;
                    if (this.musicPlaying) { audio.pause(); this.musicPlaying = false; }
                    else { audio.play().catch(()=>{}); this.musicPlaying = true; }
                },
                async loadWishes() {
                    try {
                        const slug = '{{ $invitation->slug ?? "" }}';
                        if (!slug) return;
                        const res = await fetch(`/api/invitations/${slug}/wishes`);
                        const data = await res.json();
                        this.wishes = data.data || data || [];
                    } catch(e) {}
                },
                async submitRsvp() {
                    if (!this.rsvpName.trim()) return alert('Nama harus diisi');
                    try {
                        const slug = '{{ $invitation->slug ?? "" }}';
                        const res = await fetch(`/api/invitations/${slug}/wishes`, {
                            method: 'POST',
                            headers: {'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest'},
                            body: JSON.stringify({ name: this.rsvpName, attendance: this.rsvpAttend, message: this.rsvpMsg })
                        });
                        if (res.ok) {
                            this.rsvpName = ''; this.rsvpMsg = ''; this.rsvpAttend = 'Hadir';
                            this.loadWishes();
                            alert('Terima kasih atas ucapan dan doanya!');
                        }
                    } catch(e) { alert('Gagal mengirim, coba lagi.'); }
                },
                copyToClipboard(text) {
                    navigator.clipboard.writeText(text).then(() => alert('Nomor rekening disalin!'));
                }
            }
        }
        function countdown() {
            return {
                days: 0, hours: 0, minutes: 0, seconds: 0,
                init() {
                    const target = new Date('{{ optional($invitation)->event_date ? $invitation->event_date . "T" . ($invitation->event_time ?? "08:00") : "2025-12-31T00:00" }}').getTime();
                    const tick = () => {
                        const now = Date.now();
                        const diff = Math.max(0, target - now);
                        this.days = Math.floor(diff / 86400000);
                        this.hours = Math.floor((diff % 86400000) / 3600000);
                        this.minutes = Math.floor((diff % 3600000) / 60000);
                        this.seconds = Math.floor((diff % 60000) / 1000);
                    };
                    tick();
                    setInterval(tick, 1000);
                }
            }
        }
    </script>
    <!-- Hidden audio for music -->
    @if(optional($invitation)->music_url)
        <audio id="bgm" loop preload="none"><source src="{{ $invitation->music_url }}" type="audio/mpeg"></audio>
    @endif
</body>
</html>
