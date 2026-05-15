<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Lato:wght@300;400;700&family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --gold: {{ $invitation->color_primary ?? '#D4AF37' }};
            --dark: {{ $invitation->color_secondary ?? '#1a1a2e' }};
            --cream: #faf6ef;
            --gold-light: #f5e6b8;
        }
        body { font-family: 'Lato', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
        .font-script { font-family: 'Dancing Script', cursive; }
        [x-cloak] { display: none !important; }

        /* Ornament SVG */
        .ornament-top, .ornament-bottom {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 60' fill='none'%3E%3Cpath d='M200 30C200 30 160 5 120 15C80 25 60 30 40 25C20 20 0 30 0 30M200 30C200 30 240 5 280 15C320 25 340 30 360 25C380 20 400 30 400 30' stroke='%23D4AF37' stroke-width='1' opacity='0.4'/%3E%3Ccircle cx='200' cy='30' r='4' fill='%23D4AF37' opacity='0.6'/%3E%3Ccircle cx='180' cy='28' r='2' fill='%23D4AF37' opacity='0.3'/%3E%3Ccircle cx='220' cy='28' r='2' fill='%23D4AF37' opacity='0.3'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 300px;
            height: 60px;
        }

        .gold-border-frame {
            border: 1px solid var(--gold);
            position: relative;
        }
        .gold-border-frame::before {
            content: '';
            position: absolute;
            inset: 4px;
            border: 1px solid var(--gold);
            opacity: 0.3;
            pointer-events: none;
        }

        .fade-in { animation: fadeInUp 0.8s ease-out both; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-spin-slow { animation: spin 4s linear infinite; }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

        .section-divider {
            width: 80px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            margin: 0 auto;
        }
    </style>
</head>
<body class="bg-[var(--cream)] text-gray-800 overflow-x-hidden" x-data="invitationApp()" x-cloak>

    <!-- ========== OPENING COVER ========== -->
    <section x-show="!opened" class="fixed inset-0 z-50 flex items-center justify-center bg-[var(--dark)] overflow-hidden"
        x-transition:leave="transition ease-in duration-700"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95">

        <!-- Decorative corners -->
        <div class="absolute top-6 left-6 w-20 h-20 border-t-2 border-l-2 border-[var(--gold)] opacity-40"></div>
        <div class="absolute top-6 right-6 w-20 h-20 border-t-2 border-r-2 border-[var(--gold)] opacity-40"></div>
        <div class="absolute bottom-6 left-6 w-20 h-20 border-b-2 border-l-2 border-[var(--gold)] opacity-40"></div>
        <div class="absolute bottom-6 right-6 w-20 h-20 border-b-2 border-r-2 border-[var(--gold)] opacity-40"></div>

        <!-- Floating particles -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute top-1/4 left-1/4 w-1 h-1 bg-[var(--gold)] rounded-full opacity-40 animate-pulse"></div>
            <div class="absolute top-1/3 right-1/3 w-1.5 h-1.5 bg-[var(--gold)] rounded-full opacity-30 animate-pulse" style="animation-delay: 0.5s"></div>
            <div class="absolute bottom-1/3 left-1/3 w-1 h-1 bg-[var(--gold)] rounded-full opacity-50 animate-pulse" style="animation-delay: 1s"></div>
            <div class="absolute bottom-1/4 right-1/4 w-2 h-2 bg-[var(--gold)] rounded-full opacity-20 animate-pulse" style="animation-delay: 1.5s"></div>
        </div>

        <div class="text-center text-white px-8 relative">
            <div class="ornament-top mb-6 opacity-60"></div>

            <p class="text-xs uppercase tracking-[0.4em] text-[var(--gold-light)] mb-6 font-light">The Wedding Of</p>

            <h1 class="text-5xl sm:text-6xl font-display font-bold mb-3 text-white" style="text-shadow: 0 2px 20px rgba(212,175,55,0.2)">{{ $invitation->groom_name }}</h1>
            <div class="flex items-center justify-center gap-4 my-4">
                <div class="w-12 h-[1px] bg-gradient-to-r from-transparent to-[var(--gold)]"></div>
                <span class="text-3xl font-script text-[var(--gold)]">&</span>
                <div class="w-12 h-[1px] bg-gradient-to-l from-transparent to-[var(--gold)]"></div>
            </div>
            <h1 class="text-5xl sm:text-6xl font-display font-bold mb-8 text-white" style="text-shadow: 0 2px 20px rgba(212,175,55,0.2)">{{ $invitation->bride_name }}</h1>

            @if($guestName)
            <div class="mb-8 py-4 px-6 border border-[var(--gold)]/20 rounded-xl bg-white/5 backdrop-blur-sm inline-block">
                <p class="text-xs text-[var(--gold-light)]/70 uppercase tracking-wider mb-1">Kepada Yth.</p>
                <p class="text-lg font-medium text-white">{{ urldecode($guestName) }}</p>
            </div>
            @endif

            <div class="ornament-bottom mb-8 opacity-60"></div>

            <button @click="openInvitation()" class="group relative px-10 py-4 overflow-hidden rounded-full transition-all duration-300 hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-r from-[var(--gold)] via-[var(--gold-light)] to-[var(--gold)] opacity-90 group-hover:opacity-100 transition-opacity"></div>
                <span class="relative text-[var(--dark)] font-semibold tracking-wide flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19V5a2 2 0 012-2h6.5l1 1H19a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                    Buka Undangan
                </span>
            </button>

            <p class="text-xs text-gray-400 mt-6">{{ $invitation->event_date->translatedFormat('d F Y') }}</p>
        </div>
    </section>


    <!-- ========== MAIN CONTENT ========== -->
    <div x-show="opened" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

        <!-- HERO SECTION -->
        <section class="relative min-h-screen flex items-center justify-center py-24 px-6">
            <!-- Background pattern -->
            <div class="absolute inset-0 pointer-events-none" style="background-image: radial-gradient(circle at 20% 50%, rgba(212,175,55,0.03) 0%, transparent 50%), radial-gradient(circle at 80% 50%, rgba(212,175,55,0.03) 0%, transparent 50%)"></div>

            <div class="text-center relative z-10 max-w-2xl mx-auto">
                <div class="ornament-top mb-8"></div>

                <p class="text-xs uppercase tracking-[0.5em] text-[var(--gold)] mb-8 font-light">We Are Getting Married</p>

                <div class="space-y-3">
                    <h2 class="text-5xl sm:text-7xl font-display font-bold text-[var(--dark)] leading-tight">{{ $invitation->groom_name }}</h2>
                    <div class="flex items-center justify-center gap-6 py-2">
                        <div class="w-16 h-[1px] bg-gradient-to-r from-transparent to-[var(--gold)]"></div>
                        <span class="text-4xl font-script text-[var(--gold)]">&</span>
                        <div class="w-16 h-[1px] bg-gradient-to-l from-transparent to-[var(--gold)]"></div>
                    </div>
                    <h2 class="text-5xl sm:text-7xl font-display font-bold text-[var(--dark)] leading-tight">{{ $invitation->bride_name }}</h2>
                </div>

                <div class="mt-10 inline-flex items-center gap-3 px-6 py-3 bg-white rounded-full shadow-sm border border-[var(--gold)]/10">
                    <svg class="w-4 h-4 text-[var(--gold)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span class="text-sm text-gray-600">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</span>
                </div>

                <div class="ornament-bottom mt-10"></div>
            </div>
        </section>

        <!-- OPENING TEXT -->
        @if($invitation->opening_text)
        <section class="py-20 px-6 bg-white">
            <div class="max-w-2xl mx-auto text-center">
                <div class="section-divider mb-8"></div>
                <p class="text-gray-600 leading-loose text-lg font-light italic font-display">"{!! nl2br(e($invitation->opening_text)) !!}"</p>
                <div class="section-divider mt-8"></div>
            </div>
        </section>
        @endif

        <!-- COUPLE PROFILE -->
        <section class="py-20 px-6 bg-[var(--cream)]">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <p class="text-xs uppercase tracking-[0.4em] text-[var(--gold)] mb-3">The Bride & Groom</p>
                    <h2 class="text-3xl sm:text-4xl font-display font-bold text-[var(--dark)]">Mempelai</h2>
                </div>

                <div class="grid md:grid-cols-2 gap-16">
                    <!-- Groom -->
                    <div class="text-center group">
                        <div class="relative inline-block mb-8">
                            @if($invitation->groom_photo)
                            <div class="w-52 h-52 rounded-full overflow-hidden border-2 border-[var(--gold)]/30 p-1 mx-auto">
                                <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}" class="w-full h-full object-cover rounded-full">
                            </div>
                            @else
                            <div class="w-52 h-52 rounded-full bg-gradient-to-br from-[var(--gold-light)] to-[var(--cream)] flex items-center justify-center mx-auto border-2 border-[var(--gold)]/20">
                                <span class="text-5xl font-display text-[var(--gold)]">{{ substr($invitation->groom_name, 0, 1) }}</span>
                            </div>
                            @endif
                            <!-- Decorative ring -->
                            <div class="absolute -inset-3 rounded-full border border-[var(--gold)]/10 pointer-events-none"></div>
                        </div>
                        <h3 class="text-2xl font-display font-bold text-[var(--dark)] mb-2">{{ $invitation->groom_name }}</h3>
                        @if($invitation->groom_father || $invitation->groom_mother)
                        <p class="text-sm text-gray-500 leading-relaxed">Putra dari<br><span class="font-medium text-gray-700">Bapak {{ $invitation->groom_father }}</span> &<br><span class="font-medium text-gray-700">Ibu {{ $invitation->groom_mother }}</span></p>
                        @endif
                        @if($invitation->groom_instagram)
                        <a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" target="_blank" class="inline-flex items-center gap-1.5 mt-3 text-sm text-[var(--gold)] hover:text-[var(--dark)] transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            {{ $invitation->groom_instagram }}
                        </a>
                        @endif
                    </div>

                    <!-- Bride -->
                    <div class="text-center group">
                        <div class="relative inline-block mb-8">
                            @if($invitation->bride_photo)
                            <div class="w-52 h-52 rounded-full overflow-hidden border-2 border-[var(--gold)]/30 p-1 mx-auto">
                                <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}" class="w-full h-full object-cover rounded-full">
                            </div>
                            @else
                            <div class="w-52 h-52 rounded-full bg-gradient-to-br from-[var(--gold-light)] to-[var(--cream)] flex items-center justify-center mx-auto border-2 border-[var(--gold)]/20">
                                <span class="text-5xl font-display text-[var(--gold)]">{{ substr($invitation->bride_name, 0, 1) }}</span>
                            </div>
                            @endif
                            <div class="absolute -inset-3 rounded-full border border-[var(--gold)]/10 pointer-events-none"></div>
                        </div>
                        <h3 class="text-2xl font-display font-bold text-[var(--dark)] mb-2">{{ $invitation->bride_name }}</h3>
                        @if($invitation->bride_father || $invitation->bride_mother)
                        <p class="text-sm text-gray-500 leading-relaxed">Putri dari<br><span class="font-medium text-gray-700">Bapak {{ $invitation->bride_father }}</span> &<br><span class="font-medium text-gray-700">Ibu {{ $invitation->bride_mother }}</span></p>
                        @endif
                        @if($invitation->bride_instagram)
                        <a href="https://instagram.com/{{ ltrim($invitation->bride_instagram, '@') }}" target="_blank" class="inline-flex items-center gap-1.5 mt-3 text-sm text-[var(--gold)] hover:text-[var(--dark)] transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            {{ $invitation->bride_instagram }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- COUNTDOWN -->
        <section class="py-20 px-6 bg-[var(--dark)] relative overflow-hidden">
            <!-- Background ornament -->
            <div class="absolute inset-0 pointer-events-none opacity-5">
                <div class="absolute top-0 left-0 w-64 h-64 border border-[var(--gold)] rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 border border-[var(--gold)] rounded-full translate-x-1/2 translate-y-1/2"></div>
            </div>

            <div class="max-w-3xl mx-auto text-center relative z-10" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">
                <p class="text-xs uppercase tracking-[0.4em] text-[var(--gold-light)] mb-3">Save The Date</p>
                <h2 class="text-3xl font-display font-bold text-white mb-12">Menghitung Hari</h2>

                <div class="grid grid-cols-4 gap-3 sm:gap-6 max-w-md mx-auto">
                    <div class="gold-border-frame rounded-2xl p-4 sm:p-6 bg-white/5 backdrop-blur-sm">
                        <p class="text-3xl sm:text-5xl font-bold text-[var(--gold)]" x-text="days">0</p>
                        <p class="text-[10px] sm:text-xs uppercase tracking-wider text-gray-400 mt-2">Hari</p>
                    </div>
                    <div class="gold-border-frame rounded-2xl p-4 sm:p-6 bg-white/5 backdrop-blur-sm">
                        <p class="text-3xl sm:text-5xl font-bold text-[var(--gold)]" x-text="hours">0</p>
                        <p class="text-[10px] sm:text-xs uppercase tracking-wider text-gray-400 mt-2">Jam</p>
                    </div>
                    <div class="gold-border-frame rounded-2xl p-4 sm:p-6 bg-white/5 backdrop-blur-sm">
                        <p class="text-3xl sm:text-5xl font-bold text-[var(--gold)]" x-text="minutes">0</p>
                        <p class="text-[10px] sm:text-xs uppercase tracking-wider text-gray-400 mt-2">Menit</p>
                    </div>
                    <div class="gold-border-frame rounded-2xl p-4 sm:p-6 bg-white/5 backdrop-blur-sm">
                        <p class="text-3xl sm:text-5xl font-bold text-[var(--gold)]" x-text="seconds">0</p>
                        <p class="text-[10px] sm:text-xs uppercase tracking-wider text-gray-400 mt-2">Detik</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- EVENT DETAILS -->
        <section class="py-20 px-6 bg-white">
            <div class="max-w-3xl mx-auto text-center">
                <p class="text-xs uppercase tracking-[0.4em] text-[var(--gold)] mb-3">When & Where</p>
                <h2 class="text-3xl sm:text-4xl font-display font-bold text-[var(--dark)] mb-14">Acara Pernikahan</h2>

                <div class="gold-border-frame rounded-3xl p-8 sm:p-12 bg-[var(--cream)]">
                    <div class="w-14 h-14 mx-auto mb-6 rounded-full bg-[var(--gold)]/10 flex items-center justify-center">
                        <svg class="w-6 h-6 text-[var(--gold)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>

                    <h4 class="text-2xl font-display font-bold text-[var(--dark)] mb-6">{{ $invitation->event_venue }}</h4>

                    <div class="space-y-2 text-gray-600 mb-6">
                        <p class="text-lg">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                        <p>Pukul {{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }} {{ $invitation->event_time_end ? '- ' . \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') : '' }} WIB</p>
                    </div>

                    @if($invitation->event_address)
                    <p class="text-sm text-gray-500 mb-8 max-w-sm mx-auto">{{ $invitation->event_address }}</p>
                    @endif

                    @if($invitation->event_maps_url)
                    <a href="{{ $invitation->event_maps_url }}" target="_blank" class="inline-flex items-center gap-2 px-7 py-3 bg-[var(--gold)] text-[var(--dark)] font-semibold rounded-full text-sm hover:shadow-lg hover:shadow-[var(--gold)]/20 transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Lihat Lokasi
                    </a>
                    @endif
                </div>

                @if($invitation->dress_code)
                <div class="mt-8 inline-flex items-center gap-3 px-6 py-3 bg-[var(--gold)]/5 rounded-full border border-[var(--gold)]/20">
                    <svg class="w-5 h-5 text-[var(--gold)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span class="text-sm"><strong class="text-[var(--dark)]">Dress Code:</strong> <span class="text-gray-600">{{ $invitation->dress_code }}</span></span>
                </div>
                @endif
            </div>
        </section>


        <!-- GALLERY -->
        @if($invitation->galleries->count() > 0)
        <section class="py-20 px-6 bg-[var(--cream)]">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-14">
                    <p class="text-xs uppercase tracking-[0.4em] text-[var(--gold)] mb-3">Our Moments</p>
                    <h2 class="text-3xl sm:text-4xl font-display font-bold text-[var(--dark)]">Galeri Foto</h2>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 sm:gap-4">
                    @foreach($invitation->galleries as $index => $photo)
                    <div class="aspect-square rounded-2xl overflow-hidden {{ $index === 0 ? 'md:col-span-2 md:row-span-2' : '' }} group relative">
                        <img src="{{ $photo->getImageUrl() }}" alt="{{ $photo->caption }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- RSVP -->
        <section class="py-20 px-6 bg-white">
            <div class="max-w-md mx-auto">
                <div class="text-center mb-10">
                    <p class="text-xs uppercase tracking-[0.4em] text-[var(--gold)] mb-3">Attendance</p>
                    <h2 class="text-3xl sm:text-4xl font-display font-bold text-[var(--dark)]">RSVP</h2>
                    <p class="text-sm text-gray-500 mt-3">Konfirmasi kehadiran Anda</p>
                </div>

                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl text-center text-sm flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"/></svg>
                    {{ session('success') }}
                </div>
                @endif

                <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" class="space-y-4">
                    @csrf
                    <div>
                        <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Lengkap" required class="w-full px-5 py-3.5 bg-[var(--cream)] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[var(--gold)] focus:border-[var(--gold)] transition-all text-sm">
                    </div>
                    <div>
                        <select name="rsvp_status" required class="w-full px-5 py-3.5 bg-[var(--cream)] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[var(--gold)] focus:border-[var(--gold)] transition-all text-sm">
                            <option value="">-- Konfirmasi Kehadiran --</option>
                            <option value="attending">Ya, Saya Akan Hadir</option>
                            <option value="not_attending">Maaf, Tidak Bisa Hadir</option>
                            <option value="maybe">Masih Belum Pasti</option>
                        </select>
                    </div>
                    <div>
                        <input type="number" name="number_of_guests" min="1" max="10" value="1" placeholder="Jumlah Tamu" class="w-full px-5 py-3.5 bg-[var(--cream)] border border-gray-200 rounded-xl focus:ring-2 focus:ring-[var(--gold)] focus:border-[var(--gold)] transition-all text-sm">
                    </div>
                    <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-[var(--gold)] to-[var(--gold-light)] text-[var(--dark)] font-semibold rounded-xl hover:shadow-lg hover:shadow-[var(--gold)]/20 transition-all duration-300 text-sm">
                        Kirim Konfirmasi
                    </button>
                </form>
            </div>
        </section>

        <!-- GUESTBOOK / WISHES -->
        <section class="py-20 px-6 bg-[var(--cream)]">
            <div class="max-w-lg mx-auto">
                <div class="text-center mb-10">
                    <p class="text-xs uppercase tracking-[0.4em] text-[var(--gold)] mb-3">Best Wishes</p>
                    <h2 class="text-3xl sm:text-4xl font-display font-bold text-[var(--dark)]">Ucapan & Doa</h2>
                </div>

                <form method="POST" action="{{ route('invitation.guestbook', $invitation->slug) }}" class="space-y-4 mb-10">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Anda" required class="w-full px-5 py-3.5 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[var(--gold)] focus:border-[var(--gold)] transition-all text-sm">
                    <textarea name="message" rows="4" placeholder="Tulis ucapan & doa terbaik Anda untuk kedua mempelai..." required class="w-full px-5 py-3.5 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[var(--gold)] focus:border-[var(--gold)] transition-all text-sm resize-none"></textarea>
                    <button type="submit" class="w-full py-3.5 bg-[var(--dark)] text-white font-semibold rounded-xl hover:bg-[var(--dark)]/90 transition-all text-sm">
                        Kirim Ucapan
                    </button>
                </form>

                <!-- Messages list -->
                <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2" style="scrollbar-width: thin; scrollbar-color: var(--gold) transparent;">
                    @foreach($invitation->guestbooks as $msg)
                    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-full bg-[var(--gold)]/10 flex items-center justify-center flex-shrink-0">
                                <span class="text-xs font-bold text-[var(--gold)]">{{ strtoupper(substr($msg->name, 0, 1)) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-[var(--dark)] text-sm">{{ $msg->name }}</p>
                                <p class="text-gray-600 text-sm mt-1 leading-relaxed">{{ $msg->message }}</p>
                                <p class="text-xs text-gray-400 mt-2">{{ $msg->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- DIGITAL ENVELOPE -->
        @if($invitation->bank_name || $invitation->qris_image)
        <section class="py-20 px-6 bg-white">
            <div class="max-w-md mx-auto text-center">
                <div class="w-14 h-14 mx-auto mb-6 rounded-full bg-[var(--gold)]/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-[var(--gold)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-xs uppercase tracking-[0.4em] text-[var(--gold)] mb-3">Wedding Gift</p>
                <h2 class="text-3xl font-display font-bold text-[var(--dark)] mb-4">Amplop Digital</h2>
                @if($invitation->gift_info)
                <p class="text-sm text-gray-500 mb-8 max-w-sm mx-auto">{{ $invitation->gift_info }}</p>
                @else
                <p class="text-sm text-gray-500 mb-8">Doa restu Anda sudah cukup. Namun jika ingin memberikan hadiah, bisa melalui:</p>
                @endif

                @if($invitation->bank_name)
                <div class="gold-border-frame rounded-2xl p-6 bg-[var(--cream)] mb-4" x-data="{ copied: false }">
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-2">{{ $invitation->bank_name }}</p>
                    <p class="text-2xl font-bold text-[var(--dark)] tracking-wider mb-1">{{ $invitation->bank_account_number }}</p>
                    <p class="text-sm text-gray-500">a.n. {{ $invitation->bank_account_name }}</p>
                    <button @click="navigator.clipboard.writeText('{{ $invitation->bank_account_number }}'); copied = true; setTimeout(() => copied = false, 2000)" class="mt-4 inline-flex items-center gap-1.5 px-4 py-2 bg-[var(--gold)]/10 text-[var(--gold)] text-xs font-medium rounded-lg hover:bg-[var(--gold)]/20 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <span x-text="copied ? 'Tersalin!' : 'Salin Nomor'"></span>
                    </button>
                </div>
                @endif

                @if($invitation->qris_image)
                <div class="inline-block bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
                    <img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS" class="w-52 h-52 object-contain mx-auto">
                    <p class="text-xs text-gray-400 mt-3">Scan QRIS di atas</p>
                </div>
                @endif
            </div>
        </section>
        @endif

        <!-- CLOSING -->
        @if($invitation->closing_text)
        <section class="py-20 px-6 bg-[var(--dark)] text-center relative overflow-hidden">
            <div class="absolute inset-0 pointer-events-none opacity-5">
                <div class="absolute top-10 left-10 w-40 h-40 border border-[var(--gold)] rounded-full"></div>
                <div class="absolute bottom-10 right-10 w-60 h-60 border border-[var(--gold)] rounded-full"></div>
            </div>
            <div class="max-w-2xl mx-auto relative z-10">
                <div class="ornament-top mb-8 opacity-60"></div>
                <p class="text-white/80 leading-loose text-lg font-light italic font-display mb-8">"{!! nl2br(e($invitation->closing_text)) !!}"</p>
                <div class="section-divider mb-6" style="background: linear-gradient(90deg, transparent, var(--gold-light), transparent)"></div>
                <h3 class="text-2xl font-display font-bold text-[var(--gold)]">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</h3>
                <div class="ornament-bottom mt-8 opacity-60"></div>
            </div>
        </section>
        @endif

        <!-- FOOTER -->
        <footer class="py-10 px-6 bg-[var(--cream)] text-center border-t border-[var(--gold)]/10">
            <div class="section-divider mb-6"></div>
            <p class="text-xs text-gray-400">Made with love by <a href="{{ url('/') }}" class="text-[var(--gold)] hover:underline font-medium">UndanganDigital</a></p>
        </footer>
    </div>

    <!-- ========== MUSIC PLAYER ========== -->
    @if($invitation->music_url)
    <div class="fixed bottom-6 right-6 z-40" x-show="opened" x-transition>
        <button @click="toggleMusic()" class="group w-14 h-14 rounded-full shadow-xl flex items-center justify-center transition-all duration-300 hover:scale-110" :class="playing ? 'bg-[var(--gold)] text-[var(--dark)]' : 'bg-[var(--dark)] text-[var(--gold)]'" :style="playing ? 'animation: spin 4s linear infinite' : ''">
            <svg x-show="!playing" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/></svg>
            <svg x-show="playing" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z"/></svg>
        </button>
        <audio x-ref="audio" src="{{ asset('storage/' . $invitation->music_url) }}" loop preload="auto"></audio>
    </div>
    @endif

    <!-- ========== SCRIPTS ========== -->
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
            },
            toggleMusic() {
                if (this.playing) {
                    this.$refs.audio?.pause();
                } else {
                    this.$refs.audio?.play();
                }
                this.playing = !this.playing;
            }
        };
    }

    function countdown(targetDate) {
        return {
            days: 0, hours: 0, minutes: 0, seconds: 0,
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
