<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,500&family=Josefin+Sans:wght@300;400;500;600&family=Great+Vibes&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --color-primary: {{ $invitation->color_primary ?? '#7B8E6B' }};
            --color-secondary: {{ $invitation->color_secondary ?? '#3D3D3D' }};
            --color-accent: {{ $invitation->color_accent ?? '#F5EFE6' }};
        }
        .font-display { font-family: 'Cormorant Garamond', serif; }
        .font-body { font-family: 'Josefin Sans', sans-serif; }
        .font-script { font-family: 'Great Vibes', cursive; }
        [x-cloak] { display: none !important; }
        .animate-spin-slow { animation: spin 3s linear infinite; }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-10px); } }
        .animate-fade-in-up { animation: fadeInUp 1s ease-out forwards; }
        .animate-fade-in { animation: fadeIn 1.2s ease-out forwards; }
        .animate-float { animation: float 3s ease-in-out infinite; }


        /* Watercolor decorative elements using CSS */
        .watercolor-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0.15;
            pointer-events: none;
        }
        .watercolor-frame {
            position: relative;
        }
        .watercolor-frame::before,
        .watercolor-frame::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            filter: blur(30px);
            opacity: 0.2;
            pointer-events: none;
        }
        .watercolor-frame::before {
            width: 200px; height: 200px;
            background: var(--color-primary);
            top: -50px; left: -50px;
        }
        .watercolor-frame::after {
            width: 150px; height: 150px;
            background: #D4A574;
            bottom: -30px; right: -30px;
        }
        .watercolor-divider {
            width: 80px; height: 3px;
            background: linear-gradient(90deg, transparent, var(--color-primary), transparent);
            margin: 0 auto;
            border-radius: 2px;
        }
        .section-watercolor {
            position: relative;
            overflow: hidden;
        }
        .section-watercolor::before {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            background: radial-gradient(ellipse, var(--color-primary), transparent 70%);
            opacity: 0.06;
            border-radius: 50%;
            top: -100px; right: -100px;
        }


        .leaf-decoration {
            position: absolute;
            width: 60px; height: 60px;
            opacity: 0.3;
            pointer-events: none;
        }
        .leaf-decoration svg { width: 100%; height: 100%; fill: var(--color-primary); }

        /* Scroll reveal animation */
        .reveal { opacity: 0; transform: translateY(30px); transition: all 0.8s ease; }
        .reveal.active { opacity: 1; transform: translateY(0); }

        /* Gallery grid */
        .gallery-masonry { columns: 2; column-gap: 12px; }
        @media (min-width: 768px) { .gallery-masonry { columns: 3; } }
        .gallery-masonry > div { break-inside: avoid; margin-bottom: 12px; }

        /* Timeline */
        .timeline-line {
            position: absolute;
            left: 20px;
            top: 0; bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, transparent, var(--color-primary), transparent);
        }
        @media (min-width: 768px) {
            .timeline-line { left: 50%; transform: translateX(-50%); }
        }

        /* Cover overlay pattern */
        .cover-pattern {
            background-image: radial-gradient(circle at 20% 80%, rgba(123, 142, 107, 0.1) 0%, transparent 50%),
                              radial-gradient(circle at 80% 20%, rgba(212, 165, 116, 0.1) 0%, transparent 50%),
                              radial-gradient(circle at 50% 50%, rgba(123, 142, 107, 0.05) 0%, transparent 70%);
        }
    </style>
</head>

<body class="font-body bg-[var(--color-accent)] text-[var(--color-secondary)] overflow-x-hidden" x-data="invitationApp()" x-cloak>

    <!-- ==================== OPENING COVER ==================== -->
    <section x-show="!opened" class="fixed inset-0 z-50 flex items-center justify-center"
        x-transition:leave="transition ease-in duration-700"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95">
        <div class="absolute inset-0 bg-[var(--color-accent)] cover-pattern"></div>
        <!-- Watercolor corner decorations -->
        <div class="watercolor-blob w-64 h-64 bg-[var(--color-primary)] top-0 left-0" style="top:-80px;left:-80px;"></div>
        <div class="watercolor-blob w-48 h-48 bg-[#D4A574] bottom-0 right-0" style="bottom:-60px;right:-60px;"></div>
        <div class="watercolor-blob w-32 h-32 bg-[var(--color-primary)]" style="top:20%;right:10%;opacity:0.1;"></div>
        <div class="watercolor-blob w-40 h-40 bg-[#E8C4A0]" style="bottom:20%;left:10%;opacity:0.1;"></div>

        <div class="text-center relative z-10 px-8">
            <!-- Floral frame SVG -->
            <div class="mb-6 animate-float">
                <svg class="w-24 h-24 mx-auto text-[var(--color-primary)] opacity-60" viewBox="0 0 100 100" fill="none">
                    <circle cx="50" cy="50" r="45" stroke="currentColor" stroke-width="0.5" stroke-dasharray="4 4"/>
                    <path d="M50 10 C55 25, 70 30, 50 50 C30 30, 45 25, 50 10Z" fill="currentColor" opacity="0.3"/>
                    <path d="M90 50 C75 55, 70 70, 50 50 C70 30, 75 45, 90 50Z" fill="currentColor" opacity="0.3"/>
                    <path d="M50 90 C45 75, 30 70, 50 50 C70 70, 55 75, 50 90Z" fill="currentColor" opacity="0.3"/>
                    <path d="M10 50 C25 45, 30 30, 50 50 C30 70, 25 55, 10 50Z" fill="currentColor" opacity="0.3"/>
                </svg>
            </div>

            <p class="text-xs uppercase tracking-[0.4em] text-[var(--color-primary)] mb-6 font-body font-light">The Wedding of</p>
            <h1 class="text-4xl sm:text-5xl font-display font-semibold text-[var(--color-secondary)] mb-1">{{ $invitation->groom_name }}</h1>
            <p class="text-4xl font-script text-[var(--color-primary)] my-3">&</p>
            <h1 class="text-4xl sm:text-5xl font-display font-semibold text-[var(--color-secondary)] mb-8">{{ $invitation->bride_name }}</h1>


            @if($guestName)
            <div class="mb-6">
                <p class="text-xs uppercase tracking-[0.2em] text-gray-500 mb-2">Kepada Yth.</p>
                <p class="text-lg font-display font-medium text-[var(--color-secondary)]">{{ urldecode($guestName) }}</p>
                @if($guest && $guest->invited_by)
                <p class="text-xs text-[var(--color-primary)] mt-1">Turut Mengundang: {{ $guest->invited_by }}</p>
                @endif
            </div>
            @endif

            <button @click="openInvitation()"
                class="px-10 py-3.5 bg-[var(--color-primary)] text-white font-body text-sm uppercase tracking-[0.2em] rounded-full hover:shadow-lg hover:shadow-[var(--color-primary)]/20 transition-all duration-300 transform hover:scale-105">
                Buka Undangan
            </button>
        </div>
    </section>

    <!-- ==================== MAIN CONTENT ==================== -->
    <div x-show="opened" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

        <!-- ========== HERO SECTION ========== -->
        <section class="min-h-screen flex items-center justify-center relative py-20 px-6 section-watercolor">
            <!-- Decorative watercolor blobs -->
            <div class="watercolor-blob w-80 h-80 bg-[var(--color-primary)]" style="top:-100px;left:-100px;"></div>
            <div class="watercolor-blob w-60 h-60 bg-[#D4A574]" style="bottom:-50px;right:-50px;"></div>
            <div class="watercolor-blob w-40 h-40 bg-[#E8D5B7]" style="top:30%;right:5%;opacity:0.1;"></div>

            <div class="text-center relative z-10 max-w-lg">
                <!-- Leaf ornament top -->
                <div class="flex justify-center mb-8">
                    <svg class="w-32 h-12 text-[var(--color-primary)] opacity-50" viewBox="0 0 120 40" fill="currentColor">
                        <path d="M60 35 C50 30, 30 25, 10 30 C30 20, 50 22, 60 20 C70 22, 90 20, 110 30 C90 25, 70 30, 60 35Z" opacity="0.4"/>
                        <path d="M60 30 C52 26, 38 23, 20 27 C38 18, 52 20, 60 18 C68 20, 82 18, 100 27 C82 23, 68 26, 60 30Z" opacity="0.6"/>
                    </svg>
                </div>

                <p class="text-xs uppercase tracking-[0.4em] text-[var(--color-primary)] mb-6 font-body">We're Getting Married</p>
                <h2 class="text-5xl sm:text-6xl font-display font-bold text-[var(--color-secondary)] mb-2">{{ $invitation->groom_name }}</h2>
                <p class="text-5xl font-script text-[var(--color-primary)] my-4">&</p>
                <h2 class="text-5xl sm:text-6xl font-display font-bold text-[var(--color-secondary)]">{{ $invitation->bride_name }}</h2>

                <div class="mt-10">
                    <div class="watercolor-divider mb-4"></div>
                    <p class="text-base text-gray-600 font-light">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                </div>

                <!-- Leaf ornament bottom -->
                <div class="flex justify-center mt-8">
                    <svg class="w-32 h-12 text-[var(--color-primary)] opacity-50 rotate-180" viewBox="0 0 120 40" fill="currentColor">
                        <path d="M60 35 C50 30, 30 25, 10 30 C30 20, 50 22, 60 20 C70 22, 90 20, 110 30 C90 25, 70 30, 60 35Z" opacity="0.4"/>
                        <path d="M60 30 C52 26, 38 23, 20 27 C38 18, 52 20, 60 18 C68 20, 82 18, 100 27 C82 23, 68 26, 60 30Z" opacity="0.6"/>
                    </svg>
                </div>
            </div>
        </section>


        <!-- ========== OPENING TEXT / AYAT ========== -->
        @if($invitation->opening_text)
        <section class="py-20 px-6 bg-white section-watercolor reveal">
            <div class="max-w-2xl mx-auto text-center">
                <svg class="w-10 h-10 mx-auto text-[var(--color-primary)] opacity-40 mb-6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                </svg>
                <p class="text-gray-600 leading-relaxed italic text-lg font-display font-light">{{ $invitation->opening_text }}</p>
                <div class="watercolor-divider mt-8"></div>
            </div>
        </section>
        @endif

        <!-- ========== COUPLE PROFILE ========== -->
        <section class="py-20 px-6 bg-[var(--color-accent)] section-watercolor reveal">
            <div class="watercolor-blob w-48 h-48 bg-[var(--color-primary)]" style="top:10%;left:-50px;"></div>
            <div class="watercolor-blob w-36 h-36 bg-[#D4A574]" style="bottom:10%;right:-30px;"></div>

            <div class="max-w-4xl mx-auto relative z-10">
                <div class="text-center mb-12">
                    <p class="text-xs uppercase tracking-[0.4em] text-[var(--color-primary)] mb-2">The Bride & Groom</p>
                    <h2 class="text-3xl sm:text-4xl font-display font-bold text-[var(--color-secondary)]">Mempelai</h2>
                </div>

                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <!-- Groom -->
                    <div class="text-center">
                        @if($invitation->groom_photo)
                        <div class="relative inline-block mb-6">
                            <div class="w-52 h-52 mx-auto rounded-full overflow-hidden border-4 border-white shadow-xl shadow-[var(--color-primary)]/10">
                                <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}" class="w-full h-full object-cover">
                            </div>
                            <!-- Decorative ring -->
                            <div class="absolute inset-0 w-52 h-52 mx-auto rounded-full border-2 border-dashed border-[var(--color-primary)]/30 animate-spin-slow" style="animation-duration: 20s;"></div>
                        </div>
                        @endif
                        <h3 class="text-2xl font-display font-bold text-[var(--color-secondary)]">{{ $invitation->groom_name }}</h3>
                        @if($invitation->groom_father || $invitation->groom_mother)
                        <p class="text-gray-500 mt-2 text-sm">Putra dari Bapak {{ $invitation->groom_father }} & Ibu {{ $invitation->groom_mother }}</p>
                        @endif
                        @if($invitation->groom_instagram)
                        <a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" target="_blank" class="inline-flex items-center gap-1.5 text-sm text-[var(--color-primary)] mt-3 hover:underline">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            {{ $invitation->groom_instagram }}
                        </a>
                        @endif
                    </div>


                    <!-- Bride -->
                    <div class="text-center">
                        @if($invitation->bride_photo)
                        <div class="relative inline-block mb-6">
                            <div class="w-52 h-52 mx-auto rounded-full overflow-hidden border-4 border-white shadow-xl shadow-[var(--color-primary)]/10">
                                <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}" class="w-full h-full object-cover">
                            </div>
                            <div class="absolute inset-0 w-52 h-52 mx-auto rounded-full border-2 border-dashed border-[var(--color-primary)]/30 animate-spin-slow" style="animation-duration: 20s; animation-direction: reverse;"></div>
                        </div>
                        @endif
                        <h3 class="text-2xl font-display font-bold text-[var(--color-secondary)]">{{ $invitation->bride_name }}</h3>
                        @if($invitation->bride_father || $invitation->bride_mother)
                        <p class="text-gray-500 mt-2 text-sm">Putri dari Bapak {{ $invitation->bride_father }} & Ibu {{ $invitation->bride_mother }}</p>
                        @endif
                        @if($invitation->bride_instagram)
                        <a href="https://instagram.com/{{ ltrim($invitation->bride_instagram, '@') }}" target="_blank" class="inline-flex items-center gap-1.5 text-sm text-[var(--color-primary)] mt-3 hover:underline">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            {{ $invitation->bride_instagram }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>


        <!-- ========== COUNTDOWN ========== -->
        <section class="py-20 px-6 bg-white relative overflow-hidden reveal">
            <div class="watercolor-blob w-72 h-72 bg-[var(--color-primary)]" style="top:-100px;right:-100px;"></div>
            <div class="watercolor-blob w-56 h-56 bg-[#E8D5B7]" style="bottom:-80px;left:-80px;"></div>

            <div class="max-w-3xl mx-auto text-center relative z-10">
                <p class="text-xs uppercase tracking-[0.4em] text-[var(--color-primary)] mb-2">Save The Date</p>
                <h2 class="text-3xl sm:text-4xl font-display font-bold text-[var(--color-secondary)] mb-10">Menghitung Hari</h2>

                <div class="grid grid-cols-4 gap-3 sm:gap-6" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">
                    <div class="bg-[var(--color-accent)] rounded-2xl p-4 sm:p-6 border border-[var(--color-primary)]/10">
                        <p class="text-3xl sm:text-5xl font-display font-bold text-[var(--color-primary)]" x-text="days">0</p>
                        <p class="text-xs uppercase tracking-wider text-gray-500 mt-2 font-body">Hari</p>
                    </div>
                    <div class="bg-[var(--color-accent)] rounded-2xl p-4 sm:p-6 border border-[var(--color-primary)]/10">
                        <p class="text-3xl sm:text-5xl font-display font-bold text-[var(--color-primary)]" x-text="hours">0</p>
                        <p class="text-xs uppercase tracking-wider text-gray-500 mt-2 font-body">Jam</p>
                    </div>
                    <div class="bg-[var(--color-accent)] rounded-2xl p-4 sm:p-6 border border-[var(--color-primary)]/10">
                        <p class="text-3xl sm:text-5xl font-display font-bold text-[var(--color-primary)]" x-text="minutes">0</p>
                        <p class="text-xs uppercase tracking-wider text-gray-500 mt-2 font-body">Menit</p>
                    </div>
                    <div class="bg-[var(--color-accent)] rounded-2xl p-4 sm:p-6 border border-[var(--color-primary)]/10">
                        <p class="text-3xl sm:text-5xl font-display font-bold text-[var(--color-primary)]" x-text="seconds">0</p>
                        <p class="text-xs uppercase tracking-wider text-gray-500 mt-2 font-body">Detik</p>
                    </div>
                </div>
            </div>
        </section>


        <!-- ========== EVENT DETAILS ========== -->
        <section class="py-20 px-6 bg-[var(--color-accent)] section-watercolor reveal">
            <div class="max-w-3xl mx-auto text-center relative z-10">
                <p class="text-xs uppercase tracking-[0.4em] text-[var(--color-primary)] mb-2">Wedding Day</p>
                <h2 class="text-3xl sm:text-4xl font-display font-bold text-[var(--color-secondary)] mb-12">Waktu & Tempat</h2>

                <!-- Akad / Main Event -->
                <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-sm border border-[var(--color-primary)]/10 relative overflow-hidden mb-6">
                    <div class="watercolor-blob w-32 h-32 bg-[var(--color-primary)]" style="top:-30px;right:-30px;opacity:0.08;"></div>

                    <div class="flex justify-center mb-6">
                        <svg class="w-12 h-12 text-[var(--color-primary)] opacity-60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>

                    <h4 class="text-xl font-display font-bold text-[var(--color-secondary)] mb-4">{{ $invitation->event_venue }}</h4>
                    <p class="text-gray-600 mb-2 font-body">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                    <p class="text-gray-600 mb-4 font-body">
                        Pukul {{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }}
                        {{ $invitation->event_time_end ? '- ' . \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') : '' }} WIB
                    </p>

                    @if($invitation->event_address)
                    <p class="text-gray-500 text-sm mb-6">{{ $invitation->event_address }}</p>
                    @endif

                    @if($invitation->event_maps_url)
                    <a href="{{ $invitation->event_maps_url }}" target="_blank"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-[var(--color-primary)] text-white font-body text-sm uppercase tracking-wider rounded-full hover:shadow-lg hover:shadow-[var(--color-primary)]/20 transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Lihat Lokasi
                    </a>
                    @endif
                </div>

                @if($invitation->dress_code)
                <div class="bg-white rounded-2xl p-5 border border-[var(--color-primary)]/10">
                    <p class="text-sm text-[var(--color-secondary)]">
                        <span class="font-medium">Dress Code:</span> {{ $invitation->dress_code }}
                    </p>
                </div>
                @endif
            </div>
        </section>


        <!-- ========== GALLERY ========== -->
        @if($invitation->galleries->count() > 0)
        <section class="py-20 px-6 bg-white section-watercolor reveal">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <p class="text-xs uppercase tracking-[0.4em] text-[var(--color-primary)] mb-2">Our Moments</p>
                    <h2 class="text-3xl sm:text-4xl font-display font-bold text-[var(--color-secondary)]">Galeri</h2>
                </div>

                <div class="gallery-masonry">
                    @foreach($invitation->galleries as $index => $photo)
                    <div class="rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                        <img src="{{ $photo->getImageUrl() }}" alt="{{ $photo->caption }}"
                            class="w-full object-cover hover:scale-105 transition-transform duration-500"
                            style="aspect-ratio: {{ $index % 3 == 0 ? '3/4' : ($index % 3 == 1 ? '1/1' : '4/3') }};">
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif


        <!-- ========== LOVE STORY TIMELINE ========== -->
        @if($invitation->love_story && count($invitation->love_story) > 0)
        <section class="py-20 px-6 bg-[var(--color-accent)] relative overflow-hidden reveal">
            <div class="watercolor-blob w-64 h-64 bg-[var(--color-primary)]" style="top:10%;right:-80px;"></div>
            <div class="watercolor-blob w-48 h-48 bg-[#D4A574]" style="bottom:10%;left:-60px;"></div>

            <div class="max-w-3xl mx-auto relative z-10">
                <div class="text-center mb-12">
                    <p class="text-xs uppercase tracking-[0.4em] text-[var(--color-primary)] mb-2">Our Journey</p>
                    <h2 class="text-3xl sm:text-4xl font-display font-bold text-[var(--color-secondary)]">Love Story</h2>
                </div>

                <div class="relative">
                    <div class="timeline-line"></div>

                    @foreach($invitation->love_story as $index => $story)
                    <div class="relative mb-12 last:mb-0 pl-14 md:pl-0 {{ $index % 2 == 0 ? 'md:pr-[55%]' : 'md:pl-[55%]' }}">
                        <!-- Timeline dot -->
                        <div class="absolute left-[14px] md:left-1/2 w-6 h-6 bg-white border-3 border-[var(--color-primary)] rounded-full transform -translate-x-1/2 z-10 shadow-sm">
                            <div class="absolute inset-1 bg-[var(--color-primary)] rounded-full opacity-60"></div>
                        </div>

                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-[var(--color-primary)]/10 hover:shadow-md transition-shadow duration-300">
                            @if(!empty($story['date']))
                            <p class="text-xs uppercase tracking-wider text-[var(--color-primary)] font-medium mb-2">{{ $story['date'] }}</p>
                            @endif
                            <h4 class="text-lg font-display font-bold text-[var(--color-secondary)] mb-2">{{ $story['title'] }}</h4>
                            <p class="text-gray-600 text-sm leading-relaxed font-body">{{ $story['description'] }}</p>
                            @if(!empty($story['image']))
                            <div class="mt-4 rounded-xl overflow-hidden">
                                <img src="{{ asset('storage/' . $story['image']) }}" alt="{{ $story['title'] }}" class="w-full h-40 object-cover">
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif


        <!-- ========== RSVP ========== -->
        <section class="py-20 px-6 bg-white section-watercolor reveal">
            <div class="max-w-lg mx-auto relative z-10">
                <div class="text-center mb-10">
                    <p class="text-xs uppercase tracking-[0.4em] text-[var(--color-primary)] mb-2">Attendance</p>
                    <h2 class="text-3xl sm:text-4xl font-display font-bold text-[var(--color-secondary)]">RSVP</h2>
                </div>

                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl text-center text-sm">
                    {{ session('success') }}
                </div>
                @endif

                <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" class="space-y-4">
                    @csrf
                    <div>
                        <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Anda"
                            required class="w-full px-5 py-3.5 bg-[var(--color-accent)] border border-[var(--color-primary)]/15 rounded-xl focus:ring-2 focus:ring-[var(--color-primary)]/30 focus:border-[var(--color-primary)] transition font-body text-sm">
                    </div>
                    <div>
                        <select name="rsvp_status" required
                            class="w-full px-5 py-3.5 bg-[var(--color-accent)] border border-[var(--color-primary)]/15 rounded-xl focus:ring-2 focus:ring-[var(--color-primary)]/30 focus:border-[var(--color-primary)] transition font-body text-sm">
                            <option value="">Konfirmasi Kehadiran</option>
                            <option value="attending">Hadir</option>
                            <option value="not_attending">Tidak Hadir</option>
                            <option value="maybe">Masih Ragu</option>
                        </select>
                    </div>
                    <div>
                        <input type="number" name="number_of_guests" min="1" max="10" value="1" placeholder="Jumlah Tamu"
                            class="w-full px-5 py-3.5 bg-[var(--color-accent)] border border-[var(--color-primary)]/15 rounded-xl focus:ring-2 focus:ring-[var(--color-primary)]/30 focus:border-[var(--color-primary)] transition font-body text-sm">
                    </div>
                    <button type="submit"
                        class="w-full py-3.5 bg-[var(--color-primary)] text-white font-body text-sm uppercase tracking-wider rounded-xl hover:shadow-lg hover:shadow-[var(--color-primary)]/20 transition-all duration-300">
                        Kirim Konfirmasi
                    </button>
                </form>
            </div>
        </section>


        <!-- ========== GUESTBOOK / UCAPAN ========== -->
        <section class="py-20 px-6 bg-[var(--color-accent)] section-watercolor reveal">
            <div class="max-w-lg mx-auto relative z-10">
                <div class="text-center mb-10">
                    <p class="text-xs uppercase tracking-[0.4em] text-[var(--color-primary)] mb-2">Wishes</p>
                    <h2 class="text-3xl sm:text-4xl font-display font-bold text-[var(--color-secondary)]">Ucapan & Doa</h2>
                </div>

                <form method="POST" action="{{ route('invitation.guestbook', $invitation->slug) }}" class="space-y-4 mb-10">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Anda"
                        required class="w-full px-5 py-3.5 bg-white border border-[var(--color-primary)]/15 rounded-xl focus:ring-2 focus:ring-[var(--color-primary)]/30 focus:border-[var(--color-primary)] transition font-body text-sm">
                    <textarea name="message" rows="3" placeholder="Tulis ucapan dan doa untuk kedua mempelai..."
                        required class="w-full px-5 py-3.5 bg-white border border-[var(--color-primary)]/15 rounded-xl focus:ring-2 focus:ring-[var(--color-primary)]/30 focus:border-[var(--color-primary)] transition font-body text-sm resize-none"></textarea>
                    <button type="submit"
                        class="w-full py-3.5 bg-[var(--color-secondary)] text-white font-body text-sm uppercase tracking-wider rounded-xl hover:opacity-90 transition-all duration-300">
                        Kirim Ucapan
                    </button>
                </form>

                <!-- Messages list -->
                <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2" style="scrollbar-width: thin; scrollbar-color: var(--color-primary) transparent;">
                    @foreach($invitation->guestbooks as $msg)
                    <div class="bg-white rounded-2xl p-5 border border-[var(--color-primary)]/10 shadow-sm">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-8 h-8 rounded-full bg-[var(--color-primary)]/10 flex items-center justify-center">
                                <span class="text-xs font-bold text-[var(--color-primary)]">{{ strtoupper(substr($msg->name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-[var(--color-secondary)] text-sm">{{ $msg->name }}</p>
                                <p class="text-xs text-gray-400">{{ $msg->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed pl-11">{{ $msg->message }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>


        <!-- ========== DIGITAL ENVELOPE ========== -->
        @if($invitation->hasDigitalEnvelope())
        <section class="py-20 px-6 bg-white section-watercolor reveal">
            <div class="max-w-lg mx-auto text-center relative z-10">
                <p class="text-xs uppercase tracking-[0.4em] text-[var(--color-primary)] mb-2">Wedding Gift</p>
                <h2 class="text-3xl sm:text-4xl font-display font-bold text-[var(--color-secondary)] mb-4">Amplop Digital</h2>

                @if($invitation->gift_info)
                <p class="text-gray-600 text-sm mb-10 max-w-md mx-auto leading-relaxed">{{ $invitation->gift_info }}</p>
                @endif

                <div class="space-y-4">
                    @foreach($invitation->bank_accounts_list as $account)
                    <div class="bg-[var(--color-accent)] rounded-2xl p-6 border border-[var(--color-primary)]/10 text-left relative overflow-hidden">
                        <div class="watercolor-blob w-24 h-24 bg-[var(--color-primary)]" style="top:-20px;right:-20px;opacity:0.08;"></div>
                        <div class="relative z-10">
                            <p class="text-xs uppercase tracking-wider text-[var(--color-primary)] font-medium mb-1">{{ $account['bank_name'] }}</p>
                            <p class="text-xl font-display font-bold text-[var(--color-secondary)] mb-1">{{ $account['account_number'] }}</p>
                            <p class="text-sm text-gray-500">a.n. {{ $account['account_name'] }}</p>
                        </div>
                        <button onclick="navigator.clipboard.writeText('{{ $account['account_number'] }}')" class="absolute top-4 right-4 p-2 rounded-lg bg-white/80 hover:bg-white text-[var(--color-primary)] transition z-10" title="Salin nomor rekening">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        </button>
                    </div>
                    @endforeach
                </div>

                @if($invitation->qris_image)
                <div class="mt-8">
                    <button @click="$dispatch('open-qris')" class="inline-block bg-[var(--color-accent)] p-6 rounded-2xl border border-[var(--color-primary)]/10 hover:shadow-md transition-shadow duration-300 cursor-pointer">
                        <img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS" class="w-48 h-48 object-contain mx-auto">
                        <p class="text-xs text-gray-500 mt-3">Tap untuk memperbesar</p>
                    </button>
                </div>
                @endif
            </div>
        </section>
        @endif


        <!-- ========== CLOSING ========== -->
        @if($invitation->closing_text)
        <section class="py-20 px-6 bg-[var(--color-accent)] relative overflow-hidden reveal">
            <div class="watercolor-blob w-80 h-80 bg-[var(--color-primary)]" style="top:-120px;left:-120px;"></div>
            <div class="watercolor-blob w-60 h-60 bg-[#D4A574]" style="bottom:-80px;right:-80px;"></div>

            <div class="max-w-2xl mx-auto text-center relative z-10">
                <svg class="w-16 h-16 mx-auto text-[var(--color-primary)] opacity-30 mb-6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
                <p class="text-gray-600 leading-relaxed italic text-lg font-display font-light mb-8">{{ $invitation->closing_text }}</p>
                <div class="watercolor-divider mb-6"></div>
                <h3 class="text-3xl font-script text-[var(--color-primary)]">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</h3>
            </div>
        </section>
        @endif

        <!-- ========== FOOTER ========== -->
        <footer class="py-8 px-6 bg-white text-center border-t border-[var(--color-primary)]/10">
            <p class="text-xs text-gray-400 font-body">Powered by <a href="{{ url('/') }}" class="text-[var(--color-primary)] hover:underline">UndanganDigital</a></p>
        </footer>

    </div><!-- end x-show="opened" -->


    <!-- ========== MUSIC PLAYER ========== -->
    @if($invitation->music_url)
    <div class="fixed bottom-6 right-6 z-40" x-show="opened">
        <button @click="toggleMusic()"
            class="w-14 h-14 bg-[var(--color-primary)] text-white rounded-full shadow-lg shadow-[var(--color-primary)]/30 flex items-center justify-center hover:scale-110 transition-transform duration-300"
            :class="{ 'animate-spin-slow': playing }">
            <svg x-show="!playing" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/>
            </svg>
            <svg x-show="playing" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z"/>
            </svg>
        </button>
        <audio x-ref="audio" src="{{ asset('storage/' . $invitation->music_url) }}" loop></audio>
    </div>
    @endif

    <!-- ========== JAVASCRIPT ========== -->
    <script>
    function invitationApp() {
        return {
            opened: false,
            playing: false,
            openInvitation() {
                this.opened = true;
                @if($invitation->music_autoplay && $invitation->music_url)
                this.$nextTick(() => {
                    this.$refs.audio?.play().then(() => this.playing = true).catch(() => {});
                });
                @endif
                // Trigger reveal animations after opening
                this.$nextTick(() => {
                    setTimeout(() => this.initReveal(), 300);
                });
            },
            toggleMusic() {
                if (this.playing) { this.$refs.audio?.pause(); }
                else { this.$refs.audio?.play(); }
                this.playing = !this.playing;
            },
            initReveal() {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('active');
                        }
                    });
                }, { threshold: 0.1 });
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

    @include('templates.partials.qris-modal')
</body>
</html>
