<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Quicksand:wght@300;400;500;600;700&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --rose: {{ $invitation->color_primary ?? '#9E4B5E' }};
            --blush: #FFF0F3;
            --cream: #FFFAF5;
            --peach: #FDDECF;
            --sage: #8FA68E;
            --text: #4A3C3C;
            --muted: #9B8585;
        }
        body { font-family: 'Quicksand', sans-serif; font-weight: 400; }
        .font-display { font-family: 'Libre Baskerville', serif; }
        .font-script { font-family: 'Great Vibes', cursive; }
        [x-cloak] { display: none !important; }

        .floral-corner-tl, .floral-corner-br {
            position: absolute;
            width: 180px;
            height: 180px;
            pointer-events: none;
            opacity: 0.15;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'%3E%3Cpath d='M10 190 C40 160 30 120 60 100 C30 80 40 40 10 10' fill='none' stroke='%239E4B5E' stroke-width='1.5'/%3E%3Cpath d='M20 180 C50 150 80 140 90 100' fill='none' stroke='%239E4B5E' stroke-width='1'/%3E%3Ccircle cx='60' cy='100' r='6' fill='%239E4B5E' opacity='0.4'/%3E%3Ccircle cx='45' cy='75' r='4' fill='%239E4B5E' opacity='0.3'/%3E%3Ccircle cx='45' cy='125' r='4' fill='%239E4B5E' opacity='0.3'/%3E%3Ccircle cx='30' cy='55' r='3' fill='%238FA68E' opacity='0.4'/%3E%3Ccircle cx='30' cy='145' r='3' fill='%238FA68E' opacity='0.4'/%3E%3Cpath d='M40 60 Q50 55 45 45' fill='none' stroke='%238FA68E' stroke-width='0.8'/%3E%3Cpath d='M40 140 Q50 145 45 155' fill='none' stroke='%238FA68E' stroke-width='0.8'/%3E%3C/svg%3E");
            background-size: contain;
            background-repeat: no-repeat;
        }
        .floral-corner-tl { top: 0; left: 0; }
        .floral-corner-br { bottom: 0; right: 0; transform: rotate(180deg); }

        .petal-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .petal-divider::before, .petal-divider::after {
            content: '';
            width: 50px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--rose), transparent);
            opacity: 0.4;
        }
        .petal-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--rose);
            opacity: 0.5;
        }

        .watercolor-bg {
            background: radial-gradient(ellipse at 20% 20%, rgba(253,222,207,0.4) 0%, transparent 50%),
                        radial-gradient(ellipse at 80% 80%, rgba(255,240,243,0.5) 0%, transparent 50%),
                        radial-gradient(ellipse at 50% 50%, rgba(143,166,142,0.05) 0%, transparent 40%);
        }

        .soft-card {
            background: rgba(255,255,255,0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(158,75,94,0.1);
            border-radius: 24px;
        }
    </style>
</head>
<body class="bg-[var(--cream)] text-[var(--text)] overflow-x-hidden" x-data="invitationApp()" x-cloak>

    <!-- ========== OPENING ========== -->
    <section x-show="!opened" class="fixed inset-0 z-50 flex items-center justify-center bg-[var(--blush)] watercolor-bg"
        x-transition:leave="transition ease-in duration-600"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

        <div class="floral-corner-tl"></div>
        <div class="floral-corner-br"></div>

        <div class="text-center px-8 relative">
            <p class="text-xs tracking-[0.4em] text-[var(--muted)] mb-6 uppercase">The Wedding Of</p>

            <h1 class="text-5xl sm:text-6xl font-script text-[var(--rose)] mb-1">{{ $invitation->groom_name }}</h1>
            <div class="petal-divider my-4">
                <span class="petal-dot"></span>
            </div>
            <h1 class="text-5xl sm:text-6xl font-script text-[var(--rose)]">{{ $invitation->bride_name }}</h1>

            @if($guestName)
            <div class="mt-10 py-3 px-6 bg-white/50 backdrop-blur-sm rounded-full inline-block border border-[var(--rose)]/10">
                <p class="text-[10px] uppercase tracking-wider text-[var(--muted)] mb-0.5">Kepada Yth.</p>
                <p class="text-sm font-medium text-[var(--text)]">{{ urldecode($guestName) }}</p>
            </div>
            @endif

            <div class="mt-10">
                <button @click="openInvitation()" class="px-10 py-3.5 bg-[var(--rose)] text-white text-sm font-medium rounded-full hover:bg-[var(--rose)]/90 hover:shadow-lg hover:shadow-[var(--rose)]/20 transition-all duration-300 hover:scale-105">
                    Buka Undangan
                </button>
            </div>

            <p class="text-[10px] text-[var(--muted)] mt-8">{{ $invitation->event_date->translatedFormat('d F Y') }}</p>
        </div>
    </section>

    <!-- ========== MAIN ========== -->
    <div x-show="opened" x-transition:enter="transition ease-out duration-800" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

        <!-- HERO -->
        <section class="min-h-screen flex items-center justify-center py-24 px-6 watercolor-bg relative">
            <div class="floral-corner-tl" style="opacity: 0.1"></div>
            <div class="floral-corner-br" style="opacity: 0.1"></div>

            <div class="text-center relative z-10">
                <p class="text-xs tracking-[0.5em] text-[var(--sage)] uppercase mb-10">We're Getting Married</p>

                <h2 class="text-6xl sm:text-7xl font-script text-[var(--rose)] leading-tight">{{ $invitation->groom_name }}</h2>
                <div class="petal-divider my-6">
                    <span class="text-2xl font-script text-[var(--rose)]">&</span>
                </div>
                <h2 class="text-6xl sm:text-7xl font-script text-[var(--rose)] leading-tight">{{ $invitation->bride_name }}</h2>

                <p class="mt-12 text-sm text-[var(--muted)]">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
            </div>
        </section>

        <!-- OPENING TEXT -->
        @if($invitation->opening_text)
        <section class="py-20 px-6 bg-white">
            <div class="max-w-xl mx-auto text-center">
                <div class="petal-divider mb-8"><span class="petal-dot"></span></div>
                <p class="text-base text-[var(--text)]/80 leading-loose italic font-display">{{ $invitation->opening_text }}</p>
                <div class="petal-divider mt-8"><span class="petal-dot"></span></div>
            </div>
        </section>
        @endif

        <!-- COUPLE -->
        <section class="py-24 px-6 bg-[var(--cream)] watercolor-bg relative">
            <div class="max-w-4xl mx-auto">
                <p class="text-xs tracking-[0.4em] text-[var(--sage)] text-center uppercase mb-14">The Happy Couple</p>

                <div class="grid md:grid-cols-2 gap-16">
                    <!-- Groom -->
                    <div class="text-center">
                        @if($invitation->groom_photo)
                        <div class="w-52 h-52 mx-auto mb-8 rounded-full overflow-hidden border-4 border-white shadow-lg shadow-[var(--rose)]/10 p-1 bg-white">
                            <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}" class="w-full h-full object-cover rounded-full">
                        </div>
                        @else
                        <div class="w-52 h-52 mx-auto mb-8 rounded-full bg-gradient-to-br from-[var(--blush)] to-[var(--peach)] flex items-center justify-center border-4 border-white shadow-lg">
                            <span class="text-5xl font-script text-[var(--rose)]">{{ substr($invitation->groom_name, 0, 1) }}</span>
                        </div>
                        @endif
                        <h3 class="text-3xl font-script text-[var(--rose)] mb-3">{{ $invitation->groom_name }}</h3>
                        @if($invitation->groom_father || $invitation->groom_mother)
                        <p class="text-xs text-[var(--muted)] leading-relaxed">Putra dari<br><span class="font-medium text-[var(--text)]">{{ $invitation->groom_father }} & {{ $invitation->groom_mother }}</span></p>
                        @endif
                        @if($invitation->groom_instagram)
                        <a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" target="_blank" class="inline-block mt-3 text-xs text-[var(--rose)] hover:underline">{{ $invitation->groom_instagram }}</a>
                        @endif
                    </div>

                    <!-- Bride -->
                    <div class="text-center">
                        @if($invitation->bride_photo)
                        <div class="w-52 h-52 mx-auto mb-8 rounded-full overflow-hidden border-4 border-white shadow-lg shadow-[var(--rose)]/10 p-1 bg-white">
                            <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}" class="w-full h-full object-cover rounded-full">
                        </div>
                        @else
                        <div class="w-52 h-52 mx-auto mb-8 rounded-full bg-gradient-to-br from-[var(--blush)] to-[var(--peach)] flex items-center justify-center border-4 border-white shadow-lg">
                            <span class="text-5xl font-script text-[var(--rose)]">{{ substr($invitation->bride_name, 0, 1) }}</span>
                        </div>
                        @endif
                        <h3 class="text-3xl font-script text-[var(--rose)] mb-3">{{ $invitation->bride_name }}</h3>
                        @if($invitation->bride_father || $invitation->bride_mother)
                        <p class="text-xs text-[var(--muted)] leading-relaxed">Putri dari<br><span class="font-medium text-[var(--text)]">{{ $invitation->bride_father }} & {{ $invitation->bride_mother }}</span></p>
                        @endif
                        @if($invitation->bride_instagram)
                        <a href="https://instagram.com/{{ ltrim($invitation->bride_instagram, '@') }}" target="_blank" class="inline-block mt-3 text-xs text-[var(--rose)] hover:underline">{{ $invitation->bride_instagram }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- COUNTDOWN -->
        <section class="py-20 px-6 bg-[var(--rose)] relative overflow-hidden" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">
            <div class="absolute inset-0 pointer-events-none opacity-10" style="background-image: radial-gradient(circle at 10% 20%, white 0%, transparent 40%), radial-gradient(circle at 90% 80%, white 0%, transparent 40%)"></div>

            <div class="max-w-md mx-auto text-center relative z-10">
                <p class="text-xs tracking-[0.4em] text-white/70 uppercase mb-10">Counting The Days</p>
                <div class="grid grid-cols-4 gap-4">
                    <div class="bg-white/15 backdrop-blur-sm rounded-2xl p-5 border border-white/20">
                        <p class="text-3xl sm:text-4xl font-bold text-white" x-text="days">0</p>
                        <p class="text-[9px] uppercase tracking-wider text-white/60 mt-2">Hari</p>
                    </div>
                    <div class="bg-white/15 backdrop-blur-sm rounded-2xl p-5 border border-white/20">
                        <p class="text-3xl sm:text-4xl font-bold text-white" x-text="hours">0</p>
                        <p class="text-[9px] uppercase tracking-wider text-white/60 mt-2">Jam</p>
                    </div>
                    <div class="bg-white/15 backdrop-blur-sm rounded-2xl p-5 border border-white/20">
                        <p class="text-3xl sm:text-4xl font-bold text-white" x-text="minutes">0</p>
                        <p class="text-[9px] uppercase tracking-wider text-white/60 mt-2">Menit</p>
                    </div>
                    <div class="bg-white/15 backdrop-blur-sm rounded-2xl p-5 border border-white/20">
                        <p class="text-3xl sm:text-4xl font-bold text-white" x-text="seconds">0</p>
                        <p class="text-[9px] uppercase tracking-wider text-white/60 mt-2">Detik</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- EVENT -->
        <section class="py-24 px-6 bg-white">
            <div class="max-w-lg mx-auto text-center">
                <p class="text-xs tracking-[0.4em] text-[var(--sage)] uppercase mb-4">When & Where</p>
                <h2 class="text-3xl font-script text-[var(--rose)] mb-14">Detail Acara</h2>

                <div class="soft-card p-10">
                    <div class="w-12 h-12 mx-auto mb-6 rounded-full bg-[var(--blush)] flex items-center justify-center">
                        <svg class="w-5 h-5 text-[var(--rose)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h4 class="text-lg font-display font-bold text-[var(--text)] mb-5">{{ $invitation->event_venue }}</h4>
                    <div class="space-y-1.5 text-sm text-[var(--muted)] mb-6">
                        <p>{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                        <p>Pukul {{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }} {{ $invitation->event_time_end ? '- ' . \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') : '' }} WIB</p>
                    </div>
                    @if($invitation->event_address)<p class="text-xs text-[var(--muted)]/80 mb-8">{{ $invitation->event_address }}</p>@endif
                    @if($invitation->event_maps_url)
                    <a href="{{ $invitation->event_maps_url }}" target="_blank" class="inline-flex items-center gap-2 px-7 py-3 bg-[var(--rose)] text-white text-xs font-medium rounded-full hover:shadow-lg hover:shadow-[var(--rose)]/20 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        Lihat Lokasi
                    </a>
                    @endif
                </div>

                @if($invitation->dress_code)
                <div class="mt-8 inline-flex items-center gap-2 px-5 py-2.5 bg-[var(--blush)] rounded-full border border-[var(--rose)]/10">
                    <svg class="w-4 h-4 text-[var(--rose)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span class="text-xs text-[var(--text)]">Dress Code: <strong>{{ $invitation->dress_code }}</strong></span>
                </div>
                @endif
            </div>
        </section>


        <!-- GALLERY -->
        @if($invitation->galleries->count() > 0)
        <section class="py-20 px-6 bg-[var(--cream)] watercolor-bg">
            <div class="max-w-5xl mx-auto">
                <p class="text-xs tracking-[0.4em] text-[var(--sage)] text-center uppercase mb-4">Our Moments</p>
                <h2 class="text-3xl font-script text-[var(--rose)] text-center mb-14">Galeri Foto</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($invitation->galleries as $photo)
                    <div class="aspect-square rounded-3xl overflow-hidden group shadow-sm">
                        <img src="{{ $photo->getImageUrl() }}" alt="{{ $photo->caption }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- RSVP -->
        <section class="py-24 px-6 bg-white">
            <div class="max-w-sm mx-auto">
                <p class="text-xs tracking-[0.4em] text-[var(--sage)] text-center uppercase mb-4">Attendance</p>
                <h2 class="text-3xl font-script text-[var(--rose)] text-center mb-10">RSVP</h2>

                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 text-xs text-center rounded-2xl">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" class="space-y-4">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Lengkap" required class="w-full px-5 py-3.5 bg-[var(--blush)]/50 border border-[var(--rose)]/10 rounded-2xl text-sm focus:ring-2 focus:ring-[var(--rose)]/30 focus:border-[var(--rose)]/30 transition-all placeholder:text-[var(--muted)]/60">
                    <select name="rsvp_status" required class="w-full px-5 py-3.5 bg-[var(--blush)]/50 border border-[var(--rose)]/10 rounded-2xl text-sm focus:ring-2 focus:ring-[var(--rose)]/30 focus:border-[var(--rose)]/30 transition-all">
                        <option value="">Konfirmasi Kehadiran</option>
                        <option value="attending">Ya, Saya Akan Hadir</option>
                        <option value="not_attending">Maaf, Tidak Bisa Hadir</option>
                        <option value="maybe">Masih Belum Pasti</option>
                    </select>
                    <input type="number" name="number_of_guests" min="1" max="10" value="1" class="w-full px-5 py-3.5 bg-[var(--blush)]/50 border border-[var(--rose)]/10 rounded-2xl text-sm focus:ring-2 focus:ring-[var(--rose)]/30 focus:border-[var(--rose)]/30 transition-all">
                    <button type="submit" class="w-full py-3.5 bg-[var(--rose)] text-white text-sm font-medium rounded-2xl hover:bg-[var(--rose)]/90 hover:shadow-lg hover:shadow-[var(--rose)]/20 transition-all">
                        Kirim Konfirmasi
                    </button>
                </form>
            </div>
        </section>

        <!-- GUESTBOOK -->
        <section class="py-20 px-6 bg-[var(--blush)]">
            <div class="max-w-md mx-auto">
                <p class="text-xs tracking-[0.4em] text-[var(--sage)] text-center uppercase mb-4">Best Wishes</p>
                <h2 class="text-3xl font-script text-[var(--rose)] text-center mb-10">Ucapan & Doa</h2>

                <form method="POST" action="{{ route('invitation.guestbook', $invitation->slug) }}" class="space-y-4 mb-10">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Anda" required class="w-full px-5 py-3.5 bg-white border border-[var(--rose)]/10 rounded-2xl text-sm focus:ring-2 focus:ring-[var(--rose)]/30 focus:border-[var(--rose)]/30 transition-all placeholder:text-[var(--muted)]/60">
                    <textarea name="message" rows="3" placeholder="Tulis ucapan & doa terbaik..." required class="w-full px-5 py-3.5 bg-white border border-[var(--rose)]/10 rounded-2xl text-sm focus:ring-2 focus:ring-[var(--rose)]/30 focus:border-[var(--rose)]/30 transition-all resize-none placeholder:text-[var(--muted)]/60"></textarea>
                    <button type="submit" class="w-full py-3.5 border-2 border-[var(--rose)] text-[var(--rose)] text-sm font-medium rounded-2xl hover:bg-[var(--rose)] hover:text-white transition-all duration-300">
                        Kirim Ucapan
                    </button>
                </form>

                <div class="space-y-3 max-h-80 overflow-y-auto pr-1">
                    @foreach($invitation->guestbooks as $msg)
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-[var(--rose)]/5">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-[var(--blush)] to-[var(--peach)] flex items-center justify-center flex-shrink-0">
                                <span class="text-xs font-bold text-[var(--rose)]">{{ strtoupper(substr($msg->name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-[var(--text)]">{{ $msg->name }}</p>
                                <p class="text-sm text-[var(--muted)] mt-1 leading-relaxed">{{ $msg->message }}</p>
                                <p class="text-[10px] text-[var(--muted)]/60 mt-2">{{ $msg->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- ENVELOPE -->
        @if($invitation->bank_name || $invitation->qris_image)
        <section class="py-24 px-6 bg-white">
            <div class="max-w-sm mx-auto text-center">
                <p class="text-xs tracking-[0.4em] text-[var(--sage)] uppercase mb-4">Wedding Gift</p>
                <h2 class="text-3xl font-script text-[var(--rose)] mb-4">Amplop Digital</h2>
                <p class="text-xs text-[var(--muted)] mb-10">Kehadiran & doa restu Anda sudah cukup bagi kami. Namun jika berkenan:</p>

                @if($invitation->bank_name)
                <div class="soft-card p-8 mb-4" x-data="{ copied: false }">
                    <p class="text-[10px] uppercase tracking-wider text-[var(--muted)] mb-2">{{ $invitation->bank_name }}</p>
                    <p class="text-xl font-bold text-[var(--text)] tracking-wider mb-1">{{ $invitation->bank_account_number }}</p>
                    <p class="text-xs text-[var(--muted)]">a.n. {{ $invitation->bank_account_name }}</p>
                    <button @click="navigator.clipboard.writeText('{{ $invitation->bank_account_number }}'); copied = true; setTimeout(() => copied = false, 2000)" class="mt-5 px-5 py-2 bg-[var(--blush)] text-[var(--rose)] text-[10px] font-medium rounded-full hover:bg-[var(--rose)] hover:text-white transition-all">
                        <span x-text="copied ? 'Tersalin!' : 'Salin Nomor Rekening'"></span>
                    </button>
                </div>
                @endif

                @if($invitation->qris_image)
                <div class="inline-block bg-white p-5 rounded-3xl shadow-sm border border-[var(--rose)]/10">
                    <img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS" class="w-48 h-48 object-contain">
                    <p class="text-[10px] text-[var(--muted)] mt-3">Scan QRIS</p>
                </div>
                @endif
            </div>
        </section>
        @endif

        <!-- CLOSING -->
        @if($invitation->closing_text)
        <section class="py-20 px-6 bg-[var(--cream)] watercolor-bg relative">
            <div class="floral-corner-tl" style="opacity: 0.08"></div>
            <div class="floral-corner-br" style="opacity: 0.08"></div>
            <div class="max-w-xl mx-auto text-center relative z-10">
                <div class="petal-divider mb-8"><span class="petal-dot"></span></div>
                <p class="text-base text-[var(--text)]/80 leading-loose italic font-display mb-8">{{ $invitation->closing_text }}</p>
                <p class="text-sm text-[var(--muted)] mb-4">Dengan cinta,</p>
                <h3 class="text-3xl font-script text-[var(--rose)]">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</h3>
                <div class="petal-divider mt-8"><span class="petal-dot"></span></div>
            </div>
        </section>
        @endif

        <!-- FOOTER -->
        <footer class="py-10 px-6 bg-white text-center border-t border-[var(--rose)]/5">
            <p class="text-[10px] text-[var(--muted)] tracking-wider">Made with love by <a href="{{ url('/') }}" class="text-[var(--rose)] hover:underline">UndanganDigital</a></p>
        </footer>
    </div>

    <!-- MUSIC -->
    @if($invitation->music_url)
    <div class="fixed bottom-6 right-6 z-40" x-show="opened" x-transition>
        <button @click="toggleMusic()" class="w-12 h-12 rounded-full shadow-lg flex items-center justify-center transition-all duration-300 hover:scale-110" :class="playing ? 'bg-[var(--rose)] text-white' : 'bg-white text-[var(--rose)] border border-[var(--rose)]/20'">
            <svg x-show="!playing" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>
            <svg x-show="playing" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5.75 3a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75A.75.75 0 007.25 3h-1.5zM12.75 3a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75a.75.75 0 00-.75-.75h-1.5z"/></svg>
        </button>
        <audio x-ref="audio" src="{{ asset('storage/' . $invitation->music_url) }}" loop preload="auto"></audio>
    </div>
    @endif

    <script>
    function invitationApp() {
        return {
            opened: false, playing: false,
            openInvitation() {
                this.opened = true;
                @if($invitation->music_autoplay && $invitation->music_url)
                this.$nextTick(() => { this.$refs.audio?.play().then(() => this.playing = true).catch(() => {}); });
                @endif
            },
            toggleMusic() { if (this.playing) { this.$refs.audio?.pause(); } else { this.$refs.audio?.play(); } this.playing = !this.playing; }
        };
    }
    function countdown(targetDate) {
        return {
            days: 0, hours: 0, minutes: 0, seconds: 0,
            init() { this.update(); setInterval(() => this.update(), 1000); },
            update() { const diff = new Date(targetDate) - new Date(); if (diff > 0) { this.days = Math.floor(diff/(1000*60*60*24)); this.hours = Math.floor((diff%(1000*60*60*24))/(1000*60*60)); this.minutes = Math.floor((diff%(1000*60*60))/(1000*60)); this.seconds = Math.floor((diff%(1000*60))/1000); } }
        };
    }
    </script>
</body>
</html>
