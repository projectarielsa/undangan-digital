<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Poppins:wght@200;300;400;500;600;700&family=Scheherazade+New:wght@400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --green: {{ $invitation->color_primary ?? '#1B5E20' }};
            --green-light: #2E7D32;
            --gold: #C9A96E;
            --cream: #FDFCF7;
            --sage: #F5F5DC;
            --text: #2C3E2C;
            --muted: #6B7B6B;
        }
        body { font-family: 'Poppins', sans-serif; font-weight: 300; }
        .font-display { font-family: 'Amiri', serif; }
        .font-arabic { font-family: 'Scheherazade New', serif; }
        [x-cloak] { display: none !important; }

        /* Islamic geometric pattern */
        .islamic-pattern {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Cg fill='none' stroke='%231B5E20' stroke-width='0.5' opacity='0.08'%3E%3Cpath d='M40 0L80 40L40 80L0 40Z'/%3E%3Cpath d='M40 10L70 40L40 70L10 40Z'/%3E%3Cpath d='M40 20L60 40L40 60L20 40Z'/%3E%3Ccircle cx='40' cy='40' r='8'/%3E%3C/g%3E%3C/svg%3E");
            background-repeat: repeat;
        }

        /* Arch shape - Islamic mihrab */
        .arch-frame {
            border-radius: 50% 50% 0 0 / 30% 30% 0 0;
            border: 2px solid var(--green);
            position: relative;
            overflow: hidden;
        }
        .arch-frame::before {
            content: '';
            position: absolute;
            inset: 4px;
            border-radius: 50% 50% 0 0 / 30% 30% 0 0;
            border: 1px solid var(--green);
            opacity: 0.3;
            pointer-events: none;
        }

        .geometric-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }
        .geometric-divider::before, .geometric-divider::after {
            content: '';
            width: 50px;
            height: 1px;
            background: var(--green);
            opacity: 0.3;
        }
        .geo-star {
            width: 12px;
            height: 12px;
            background: var(--green);
            clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
            opacity: 0.6;
        }

        .green-card {
            background: white;
            border: 1px solid rgba(27,94,32,0.12);
            border-radius: 16px;
            position: relative;
        }
        .green-card::after {
            content: '';
            position: absolute;
            top: -1px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--green), transparent);
            border-radius: 0 0 4px 4px;
        }

        .top-ornament {
            width: 100%;
            height: 40px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 40' fill='none'%3E%3Cpath d='M0 38 C50 38 50 20 100 20 C150 20 150 38 200 38 C250 38 250 20 300 20 C350 20 350 38 400 38' stroke='%231B5E20' stroke-width='1' opacity='0.15'/%3E%3Cpath d='M180 20 L200 8 L220 20' stroke='%231B5E20' stroke-width='1' opacity='0.3'/%3E%3Ccircle cx='200' cy='5' r='3' fill='%231B5E20' opacity='0.2'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 320px;
        }
    </style>
</head>
<body class="bg-[var(--cream)] text-[var(--text)] overflow-x-hidden" x-data="invitationApp()" x-cloak>

    <!-- ========== OPENING ========== -->
    <section x-show="!opened" class="fixed inset-0 z-50 flex items-center justify-center bg-[var(--green)] islamic-pattern"
        x-transition:leave="transition ease-in duration-600"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

        <!-- Corner geometric ornaments -->
        <div class="absolute top-6 left-6 w-14 h-14 border-t-2 border-l-2 border-[var(--gold)]/50"></div>
        <div class="absolute top-6 right-6 w-14 h-14 border-t-2 border-r-2 border-[var(--gold)]/50"></div>
        <div class="absolute bottom-6 left-6 w-14 h-14 border-b-2 border-l-2 border-[var(--gold)]/50"></div>
        <div class="absolute bottom-6 right-6 w-14 h-14 border-b-2 border-r-2 border-[var(--gold)]/50"></div>

        <div class="text-center px-8 text-white relative">
            <!-- Bismillah -->
            <p class="text-3xl sm:text-4xl font-arabic text-[var(--gold)] mb-8 leading-relaxed">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ</p>

            <p class="text-[10px] uppercase tracking-[0.5em] text-white/60 mb-8">The Wedding Of</p>

            <h1 class="text-4xl sm:text-5xl font-display font-bold text-white mb-2">{{ $invitation->groom_name }}</h1>
            <div class="geometric-divider my-5">
                <span class="geo-star" style="background: var(--gold)"></span>
            </div>
            <h1 class="text-4xl sm:text-5xl font-display font-bold text-white">{{ $invitation->bride_name }}</h1>

            @if($guestName)
            <div class="mt-10 py-3 px-8 border border-white/20 inline-block bg-white/5 backdrop-blur-sm rounded-lg">
                <p class="text-[9px] uppercase tracking-[0.3em] text-white/50 mb-1">Kepada Yth.</p>
                <p class="text-sm font-medium text-white">{{ urldecode($guestName) }}</p>
            </div>
            @endif

            <div class="mt-10">
                <button @click="openInvitation()" class="px-10 py-3.5 bg-[var(--gold)] text-[var(--green)] text-xs uppercase tracking-[0.2em] font-semibold rounded-lg hover:bg-[var(--gold)]/90 hover:scale-105 transition-all duration-300">
                    Buka Undangan
                </button>
            </div>

            <p class="text-[10px] text-white/40 mt-8 tracking-wider">{{ $invitation->event_date->translatedFormat('d F Y') }}</p>
        </div>
    </section>

    <!-- ========== MAIN ========== -->
    <div x-show="opened" x-transition:enter="transition ease-out duration-800" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

        <!-- HERO -->
        <section class="min-h-screen flex items-center justify-center py-24 px-6 relative islamic-pattern">
            <div class="text-center relative z-10 max-w-lg">
                <!-- Bismillah -->
                <p class="text-2xl sm:text-3xl font-arabic text-[var(--green)] mb-10 leading-relaxed">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ</p>
                <p class="text-xs text-[var(--muted)] mb-2 italic font-display">Dengan nama Allah Yang Maha Pengasih lagi Maha Penyayang</p>

                <div class="top-ornament my-8"></div>

                <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--green)] mb-8">We Are Getting Married</p>

                <h2 class="text-5xl sm:text-6xl font-display font-bold text-[var(--green)] leading-tight">{{ $invitation->groom_name }}</h2>
                <div class="geometric-divider my-6">
                    <span class="geo-star"></span>
                </div>
                <h2 class="text-5xl sm:text-6xl font-display font-bold text-[var(--green)] leading-tight">{{ $invitation->bride_name }}</h2>

                <div class="top-ornament my-8" style="transform: scaleY(-1)"></div>

                <p class="text-sm text-[var(--muted)]">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
            </div>
        </section>

        <!-- OPENING TEXT -->
        @if($invitation->opening_text)
        <section class="py-20 px-6 bg-white">
            <div class="max-w-xl mx-auto text-center">
                <div class="geometric-divider mb-8"><span class="geo-star"></span></div>
                <p class="text-base text-[var(--text)]/80 leading-loose italic font-display">{{ $invitation->opening_text }}</p>
                <div class="geometric-divider mt-8"><span class="geo-star"></span></div>
            </div>
        </section>
        @endif

        <!-- COUPLE -->
        <section class="py-24 px-6 bg-[var(--cream)] islamic-pattern">
            <div class="max-w-4xl mx-auto">
                <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--green)] text-center mb-14">The Bride & Groom</p>

                <div class="grid md:grid-cols-2 gap-16">
                    <!-- Groom -->
                    <div class="text-center">
                        <div class="arch-frame w-52 h-64 mx-auto mb-8 bg-[var(--sage)]">
                            @if($invitation->groom_photo)
                            <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center">
                                <span class="text-5xl font-display text-[var(--green)]/40">{{ substr($invitation->groom_name, 0, 1) }}</span>
                            </div>
                            @endif
                        </div>
                        <h3 class="text-2xl font-display font-bold text-[var(--green)] mb-3">{{ $invitation->groom_name }}</h3>
                        @if($invitation->groom_father || $invitation->groom_mother)
                        <p class="text-xs text-[var(--muted)] leading-relaxed">Putra dari<br><span class="font-medium text-[var(--text)]">Bapak {{ $invitation->groom_father }}</span><br>& <span class="font-medium text-[var(--text)]">Ibu {{ $invitation->groom_mother }}</span></p>
                        @endif
                        @if($invitation->groom_instagram)
                        <a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" target="_blank" class="inline-block mt-3 text-xs text-[var(--green)] hover:underline">{{ $invitation->groom_instagram }}</a>
                        @endif
                    </div>

                    <!-- Bride -->
                    <div class="text-center">
                        <div class="arch-frame w-52 h-64 mx-auto mb-8 bg-[var(--sage)]">
                            @if($invitation->bride_photo)
                            <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center">
                                <span class="text-5xl font-display text-[var(--green)]/40">{{ substr($invitation->bride_name, 0, 1) }}</span>
                            </div>
                            @endif
                        </div>
                        <h3 class="text-2xl font-display font-bold text-[var(--green)] mb-3">{{ $invitation->bride_name }}</h3>
                        @if($invitation->bride_father || $invitation->bride_mother)
                        <p class="text-xs text-[var(--muted)] leading-relaxed">Putri dari<br><span class="font-medium text-[var(--text)]">Bapak {{ $invitation->bride_father }}</span><br>& <span class="font-medium text-[var(--text)]">Ibu {{ $invitation->bride_mother }}</span></p>
                        @endif
                        @if($invitation->bride_instagram)
                        <a href="https://instagram.com/{{ ltrim($invitation->bride_instagram, '@') }}" target="_blank" class="inline-block mt-3 text-xs text-[var(--green)] hover:underline">{{ $invitation->bride_instagram }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- COUNTDOWN -->
        <section class="py-20 px-6 bg-[var(--green)] islamic-pattern relative" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">
            <div class="max-w-md mx-auto text-center relative z-10">
                <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--gold)] mb-10">Save The Date</p>
                <div class="grid grid-cols-4 gap-3 sm:gap-5">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 sm:p-5 border border-white/10">
                        <p class="text-3xl sm:text-4xl font-bold text-[var(--gold)]" x-text="days">0</p>
                        <p class="text-[8px] uppercase tracking-wider text-white/50 mt-2">Hari</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 sm:p-5 border border-white/10">
                        <p class="text-3xl sm:text-4xl font-bold text-[var(--gold)]" x-text="hours">0</p>
                        <p class="text-[8px] uppercase tracking-wider text-white/50 mt-2">Jam</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 sm:p-5 border border-white/10">
                        <p class="text-3xl sm:text-4xl font-bold text-[var(--gold)]" x-text="minutes">0</p>
                        <p class="text-[8px] uppercase tracking-wider text-white/50 mt-2">Menit</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 sm:p-5 border border-white/10">
                        <p class="text-3xl sm:text-4xl font-bold text-[var(--gold)]" x-text="seconds">0</p>
                        <p class="text-[8px] uppercase tracking-wider text-white/50 mt-2">Detik</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- EVENT -->
        <section class="py-24 px-6 bg-white">
            <div class="max-w-lg mx-auto text-center">
                <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--green)] mb-4">Waktu & Tempat</p>
                <h2 class="text-2xl font-display font-bold text-[var(--green)] mb-14">Detail Acara</h2>

                <div class="green-card p-10">
                    <div class="w-12 h-12 mx-auto mb-6 rounded-full bg-[var(--green)]/5 flex items-center justify-center border border-[var(--green)]/10">
                        <svg class="w-5 h-5 text-[var(--green)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h4 class="text-lg font-display font-bold text-[var(--text)] mb-5">{{ $invitation->event_venue }}</h4>
                    <div class="space-y-1.5 text-sm text-[var(--muted)] mb-6">
                        <p>{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                        <p>Pukul {{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }} {{ $invitation->event_time_end ? '- ' . \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') : '' }} WIB</p>
                    </div>
                    @if($invitation->event_address)<p class="text-xs text-[var(--muted)]/80 mb-8">{{ $invitation->event_address }}</p>@endif
                    @if($invitation->event_maps_url)
                    <a href="{{ $invitation->event_maps_url }}" target="_blank" class="inline-flex items-center gap-2 px-7 py-3 bg-[var(--green)] text-white text-xs font-medium rounded-lg hover:bg-[var(--green-light)] transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        Lihat Lokasi
                    </a>
                    @endif
                </div>

                @if($invitation->dress_code)
                <div class="mt-8 inline-flex items-center gap-2 px-5 py-2.5 bg-[var(--green)]/5 rounded-lg border border-[var(--green)]/10">
                    <span class="text-xs text-[var(--muted)]">Dress Code:</span>
                    <span class="text-xs text-[var(--green)] font-medium">{{ $invitation->dress_code }}</span>
                </div>
                @endif
            </div>
        </section>


        <!-- GALLERY -->
        @if($invitation->galleries->count() > 0)
        <section class="py-20 px-6 bg-[var(--cream)] islamic-pattern">
            <div class="max-w-5xl mx-auto">
                <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--green)] text-center mb-4">Our Moments</p>
                <h2 class="text-2xl font-display font-bold text-[var(--green)] text-center mb-14">Galeri Foto</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($invitation->galleries as $photo)
                    <div class="aspect-square rounded-xl overflow-hidden group border border-[var(--green)]/5">
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
                <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--green)] text-center mb-4">Konfirmasi</p>
                <h2 class="text-2xl font-display font-bold text-[var(--green)] text-center mb-10">RSVP</h2>

                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 text-xs text-center rounded-xl">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" class="space-y-4">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Lengkap" required class="w-full px-5 py-3.5 bg-[var(--cream)] border border-[var(--green)]/10 rounded-xl text-sm focus:ring-2 focus:ring-[var(--green)]/20 focus:border-[var(--green)]/30 transition-all placeholder:text-[var(--muted)]/50">
                    <select name="rsvp_status" required class="w-full px-5 py-3.5 bg-[var(--cream)] border border-[var(--green)]/10 rounded-xl text-sm focus:ring-2 focus:ring-[var(--green)]/20 focus:border-[var(--green)]/30 transition-all">
                        <option value="">Konfirmasi Kehadiran</option>
                        <option value="attending">Insya Allah Hadir</option>
                        <option value="not_attending">Maaf, Tidak Bisa Hadir</option>
                        <option value="maybe">Belum Pasti</option>
                    </select>
                    <input type="number" name="number_of_guests" min="1" max="10" value="1" class="w-full px-5 py-3.5 bg-[var(--cream)] border border-[var(--green)]/10 rounded-xl text-sm focus:ring-2 focus:ring-[var(--green)]/20 focus:border-[var(--green)]/30 transition-all">
                    <button type="submit" class="w-full py-3.5 bg-[var(--green)] text-white text-xs uppercase tracking-[0.15em] font-medium rounded-xl hover:bg-[var(--green-light)] transition-colors">
                        Kirim Konfirmasi
                    </button>
                </form>
            </div>
        </section>

        <!-- GUESTBOOK -->
        <section class="py-20 px-6 bg-[var(--sage)]">
            <div class="max-w-md mx-auto">
                <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--green)] text-center mb-4">Doa & Ucapan</p>
                <h2 class="text-2xl font-display font-bold text-[var(--green)] text-center mb-10">Ucapan</h2>

                <form method="POST" action="{{ route('invitation.guestbook', $invitation->slug) }}" class="space-y-4 mb-10">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Anda" required class="w-full px-5 py-3.5 bg-white border border-[var(--green)]/10 rounded-xl text-sm focus:ring-2 focus:ring-[var(--green)]/20 focus:border-[var(--green)]/30 transition-all placeholder:text-[var(--muted)]/50">
                    <textarea name="message" rows="3" placeholder="Tulis ucapan & doa terbaik Anda..." required class="w-full px-5 py-3.5 bg-white border border-[var(--green)]/10 rounded-xl text-sm focus:ring-2 focus:ring-[var(--green)]/20 focus:border-[var(--green)]/30 transition-all resize-none placeholder:text-[var(--muted)]/50"></textarea>
                    <button type="submit" class="w-full py-3.5 border-2 border-[var(--green)] text-[var(--green)] text-xs uppercase tracking-[0.15em] font-medium rounded-xl hover:bg-[var(--green)] hover:text-white transition-all duration-300">
                        Kirim Ucapan
                    </button>
                </form>

                <div class="space-y-3 max-h-80 overflow-y-auto pr-1">
                    @foreach($invitation->guestbooks as $msg)
                    <div class="bg-white rounded-xl p-5 border border-[var(--green)]/5">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-lg bg-[var(--green)]/5 flex items-center justify-center flex-shrink-0 border border-[var(--green)]/10">
                                <span class="text-[10px] font-bold text-[var(--green)]">{{ strtoupper(substr($msg->name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-[var(--text)]">{{ $msg->name }}</p>
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
                <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--green)] mb-4">Hadiah Pernikahan</p>
                <h2 class="text-2xl font-display font-bold text-[var(--green)] mb-4">Amplop Digital</h2>
                <p class="text-xs text-[var(--muted)] mb-10">Doa restu Anda merupakan karunia yang sangat berarti bagi kami. Namun jika memberi adalah tanda kasih Anda:</p>

                @if($invitation->bank_name)
                <div class="green-card p-8 mb-4" x-data="{ copied: false }">
                    <p class="text-[10px] uppercase tracking-wider text-[var(--muted)] mb-3">{{ $invitation->bank_name }}</p>
                    <p class="text-xl font-bold text-[var(--text)] tracking-wider mb-1">{{ $invitation->bank_account_number }}</p>
                    <p class="text-xs text-[var(--muted)]">a.n. {{ $invitation->bank_account_name }}</p>
                    <button @click="navigator.clipboard.writeText('{{ $invitation->bank_account_number }}'); copied = true; setTimeout(() => copied = false, 2000)" class="mt-5 px-5 py-2 bg-[var(--green)]/5 text-[var(--green)] text-[10px] font-medium rounded-lg border border-[var(--green)]/10 hover:bg-[var(--green)] hover:text-white transition-all">
                        <span x-text="copied ? 'Tersalin!' : 'Salin Nomor Rekening'"></span>
                    </button>
                </div>
                @endif

                @if($invitation->qris_image)
                <div class="inline-block bg-white p-5 rounded-xl border border-[var(--green)]/10 shadow-sm">
                    <img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS" class="w-48 h-48 object-contain">
                    <p class="text-[10px] text-[var(--muted)] mt-3">Scan QRIS</p>
                </div>
                @endif
            </div>
        </section>
        @endif

        <!-- CLOSING -->
        @if($invitation->closing_text)
        <section class="py-20 px-6 bg-[var(--green)] islamic-pattern relative">
            <div class="max-w-xl mx-auto text-center relative z-10">
                <p class="text-lg font-arabic text-[var(--gold)] mb-6">وَمِنْ آيَاتِهِ أَنْ خَلَقَ لَكُم مِّنْ أَنفُسِكُمْ أَزْوَاجًا</p>
                <p class="text-xs text-white/50 italic mb-8">QS. Ar-Rum: 21</p>
                <div class="geometric-divider mb-8"><span class="geo-star" style="background: var(--gold)"></span></div>
                <p class="text-base text-white/80 leading-loose font-light mb-8">{{ $invitation->closing_text }}</p>
                <h3 class="text-xl font-display font-bold text-[var(--gold)]">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</h3>
                <p class="text-lg font-arabic text-white/40 mt-6">وَالسَّلَامُ عَلَيْكُمْ وَرَحْمَةُ اللَّهِ وَبَرَكَاتُهُ</p>
            </div>
        </section>
        @endif

        <!-- FOOTER -->
        <footer class="py-10 px-6 bg-[var(--cream)] text-center">
            <div class="geometric-divider mb-5"><span class="geo-star"></span></div>
            <p class="text-[10px] text-[var(--muted)] tracking-wider">Made with love by <a href="{{ url('/') }}" class="text-[var(--green)] hover:underline">UndanganDigital</a></p>
        </footer>
    </div>

    <!-- MUSIC -->
    @if($invitation->music_url)
    <div class="fixed bottom-6 right-6 z-40" x-show="opened" x-transition>
        <button @click="toggleMusic()" class="w-12 h-12 rounded-xl shadow-lg flex items-center justify-center transition-all duration-300 hover:scale-110 border" :class="playing ? 'bg-[var(--green)] text-white border-[var(--green)]' : 'bg-white text-[var(--green)] border-[var(--green)]/20'">
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
