<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Raleway:wght@200;300;400;500;600&family=Italiana&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --gold: {{ $invitation->color_primary ?? '#C9A96E' }};
            --black: #0a0a0a;
            --dark: #111111;
            --card: #181818;
            --border: #2a2a2a;
            --text: #e0e0e0;
            --muted: #777777;
        }
        body { font-family: 'Raleway', sans-serif; font-weight: 300; }
        .font-display { font-family: 'Cinzel', serif; }
        .font-accent { font-family: 'Italiana', serif; }
        [x-cloak] { display: none !important; }

        .luxury-glow {
            box-shadow: 0 0 40px rgba(201,169,110,0.08), inset 0 1px 0 rgba(201,169,110,0.1);
        }
        .gold-gradient-text {
            background: linear-gradient(135deg, #C9A96E 0%, #E8D5A3 40%, #C9A96E 60%, #A8884A 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .gold-line {
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }
        .diamond-shape {
            width: 8px; height: 8px;
            background: var(--gold);
            transform: rotate(45deg);
        }

        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        .shimmer-btn {
            background: linear-gradient(90deg, var(--gold) 0%, #E8D5A3 25%, var(--gold) 50%, #A8884A 75%, var(--gold) 100%);
            background-size: 200% 100%;
            animation: shimmer 3s linear infinite;
        }
    </style>
</head>
<body class="bg-[var(--black)] text-[var(--text)] overflow-x-hidden" x-data="invitationApp()" x-cloak>

    <!-- ========== OPENING ========== -->
    <section x-show="!opened" class="fixed inset-0 z-50 flex items-center justify-center bg-[var(--black)]"
        x-transition:leave="transition ease-in duration-700"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

        <!-- Corner decorations -->
        <div class="absolute top-8 left-8 w-16 h-16 border-t border-l border-[var(--gold)]/40"></div>
        <div class="absolute top-8 right-8 w-16 h-16 border-t border-r border-[var(--gold)]/40"></div>
        <div class="absolute bottom-8 left-8 w-16 h-16 border-b border-l border-[var(--gold)]/40"></div>
        <div class="absolute bottom-8 right-8 w-16 h-16 border-b border-r border-[var(--gold)]/40"></div>

        <!-- Background subtle radial -->
        <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse at center, rgba(201,169,110,0.03) 0%, transparent 70%)"></div>

        <div class="text-center px-8 relative">
            <div class="gold-line w-32 mx-auto mb-10"></div>

            <p class="text-[10px] uppercase tracking-[0.6em] text-[var(--muted)] mb-8 font-medium">The Wedding Of</p>

            <h1 class="text-5xl sm:text-7xl font-display font-medium gold-gradient-text leading-tight">{{ $invitation->groom_name }}</h1>
            <div class="flex items-center justify-center gap-5 my-5">
                <div class="w-10 h-[1px] bg-[var(--gold)]/30"></div>
                <div class="diamond-shape"></div>
                <div class="w-10 h-[1px] bg-[var(--gold)]/30"></div>
            </div>
            <h1 class="text-5xl sm:text-7xl font-display font-medium gold-gradient-text leading-tight">{{ $invitation->bride_name }}</h1>

            @if($guestName)
            <div class="mt-12 py-4 px-8 border border-[var(--border)] inline-block">
                <p class="text-[9px] uppercase tracking-[0.4em] text-[var(--muted)] mb-1">Kepada Yth.</p>
                <p class="text-sm font-medium text-[var(--text)]">{{ urldecode($guestName) }}</p>
            </div>
            @endif

            <div class="gold-line w-32 mx-auto mt-10 mb-10"></div>

            <button @click="openInvitation()" class="shimmer-btn px-10 py-3.5 text-[var(--black)] text-xs uppercase tracking-[0.3em] font-semibold hover:scale-105 transition-transform duration-300">
                Buka Undangan
            </button>
        </div>
    </section>

    <!-- ========== MAIN ========== -->
    <div x-show="opened" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

        <!-- HERO -->
        <section class="min-h-screen flex items-center justify-center py-24 px-6 relative">
            <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse at 50% 30%, rgba(201,169,110,0.04) 0%, transparent 60%)"></div>
            <div class="text-center relative z-10">
                <p class="text-[9px] uppercase tracking-[0.7em] text-[var(--gold)] mb-10">We Are Getting Married</p>

                <h2 class="text-6xl sm:text-8xl font-display gold-gradient-text leading-none">{{ $invitation->groom_name }}</h2>
                <div class="flex items-center justify-center gap-5 my-6">
                    <div class="w-16 h-[1px] bg-[var(--gold)]/20"></div>
                    <span class="text-2xl font-accent text-[var(--gold)]">&</span>
                    <div class="w-16 h-[1px] bg-[var(--gold)]/20"></div>
                </div>
                <h2 class="text-6xl sm:text-8xl font-display gold-gradient-text leading-none">{{ $invitation->bride_name }}</h2>

                <div class="mt-14 flex items-center justify-center gap-3">
                    <div class="w-8 h-[1px] bg-[var(--gold)]/30"></div>
                    <p class="text-xs text-[var(--muted)] tracking-wider">{{ $invitation->event_date->translatedFormat('d F Y') }}</p>
                    <div class="w-8 h-[1px] bg-[var(--gold)]/30"></div>
                </div>
            </div>
        </section>

        <!-- OPENING TEXT -->
        @if($invitation->opening_text)
        <section class="py-20 px-6 bg-[var(--dark)]">
            <div class="max-w-xl mx-auto text-center">
                <div class="gold-line w-16 mx-auto mb-8"></div>
                <p class="text-base text-[var(--text)]/80 leading-loose italic font-light">{{ $invitation->opening_text }}</p>
                <div class="gold-line w-16 mx-auto mt-8"></div>
            </div>
        </section>
        @endif

        <!-- COUPLE -->
        <section class="py-24 px-6 bg-[var(--black)]">
            <div class="max-w-4xl mx-auto">
                <p class="text-[9px] uppercase tracking-[0.6em] text-[var(--gold)] text-center mb-14">The Couple</p>

                <div class="grid md:grid-cols-2 gap-16">
                    <div class="text-center">
                        @if($invitation->groom_photo)
                        <div class="w-52 h-52 mx-auto mb-8 rounded-full overflow-hidden border border-[var(--gold)]/30 p-[3px]">
                            <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}" class="w-full h-full object-cover rounded-full">
                        </div>
                        @else
                        <div class="w-52 h-52 mx-auto mb-8 rounded-full border border-[var(--gold)]/20 flex items-center justify-center bg-[var(--card)]">
                            <span class="text-5xl font-display gold-gradient-text">{{ substr($invitation->groom_name, 0, 1) }}</span>
                        </div>
                        @endif
                        <h3 class="text-xl font-display font-medium text-[var(--gold)] mb-3">{{ $invitation->groom_name }}</h3>
                        @if($invitation->groom_father || $invitation->groom_mother)
                        <p class="text-xs text-[var(--muted)] leading-relaxed">Putra dari<br>{{ $invitation->groom_father }} & {{ $invitation->groom_mother }}</p>
                        @endif
                        @if($invitation->groom_instagram)
                        <a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" target="_blank" class="inline-block mt-3 text-xs text-[var(--muted)] hover:text-[var(--gold)] transition-colors">{{ $invitation->groom_instagram }}</a>
                        @endif
                    </div>
                    <div class="text-center">
                        @if($invitation->bride_photo)
                        <div class="w-52 h-52 mx-auto mb-8 rounded-full overflow-hidden border border-[var(--gold)]/30 p-[3px]">
                            <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}" class="w-full h-full object-cover rounded-full">
                        </div>
                        @else
                        <div class="w-52 h-52 mx-auto mb-8 rounded-full border border-[var(--gold)]/20 flex items-center justify-center bg-[var(--card)]">
                            <span class="text-5xl font-display gold-gradient-text">{{ substr($invitation->bride_name, 0, 1) }}</span>
                        </div>
                        @endif
                        <h3 class="text-xl font-display font-medium text-[var(--gold)] mb-3">{{ $invitation->bride_name }}</h3>
                        @if($invitation->bride_father || $invitation->bride_mother)
                        <p class="text-xs text-[var(--muted)] leading-relaxed">Putri dari<br>{{ $invitation->bride_father }} & {{ $invitation->bride_mother }}</p>
                        @endif
                        @if($invitation->bride_instagram)
                        <a href="https://instagram.com/{{ ltrim($invitation->bride_instagram, '@') }}" target="_blank" class="inline-block mt-3 text-xs text-[var(--muted)] hover:text-[var(--gold)] transition-colors">{{ $invitation->bride_instagram }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- COUNTDOWN -->
        <section class="py-20 px-6 bg-[var(--dark)] border-y border-[var(--border)]" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">
            <div class="max-w-md mx-auto text-center">
                <p class="text-[9px] uppercase tracking-[0.6em] text-[var(--gold)] mb-12">Save The Date</p>
                <div class="grid grid-cols-4 gap-4">
                    <div class="luxury-glow bg-[var(--card)] border border-[var(--border)] rounded-xl p-5">
                        <p class="text-3xl sm:text-4xl font-display gold-gradient-text" x-text="days">0</p>
                        <p class="text-[8px] uppercase tracking-[0.3em] text-[var(--muted)] mt-2">Hari</p>
                    </div>
                    <div class="luxury-glow bg-[var(--card)] border border-[var(--border)] rounded-xl p-5">
                        <p class="text-3xl sm:text-4xl font-display gold-gradient-text" x-text="hours">0</p>
                        <p class="text-[8px] uppercase tracking-[0.3em] text-[var(--muted)] mt-2">Jam</p>
                    </div>
                    <div class="luxury-glow bg-[var(--card)] border border-[var(--border)] rounded-xl p-5">
                        <p class="text-3xl sm:text-4xl font-display gold-gradient-text" x-text="minutes">0</p>
                        <p class="text-[8px] uppercase tracking-[0.3em] text-[var(--muted)] mt-2">Menit</p>
                    </div>
                    <div class="luxury-glow bg-[var(--card)] border border-[var(--border)] rounded-xl p-5">
                        <p class="text-3xl sm:text-4xl font-display gold-gradient-text" x-text="seconds">0</p>
                        <p class="text-[8px] uppercase tracking-[0.3em] text-[var(--muted)] mt-2">Detik</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- EVENT -->
        <section class="py-24 px-6 bg-[var(--black)]">
            <div class="max-w-lg mx-auto text-center">
                <p class="text-[9px] uppercase tracking-[0.6em] text-[var(--gold)] mb-4">When & Where</p>
                <h2 class="text-2xl font-display font-medium text-[var(--text)] mb-14">Detail Acara</h2>

                <div class="luxury-glow bg-[var(--card)] border border-[var(--border)] rounded-2xl p-10">
                    <h4 class="text-lg font-display font-medium text-[var(--gold)] mb-6">{{ $invitation->event_venue }}</h4>
                    <div class="space-y-2 text-sm text-[var(--muted)] mb-8">
                        <p>{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                        <p>{{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }} {{ $invitation->event_time_end ? '- ' . \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') : '' }} WIB</p>
                    </div>
                    @if($invitation->event_address)<p class="text-xs text-[var(--muted)]/70 mb-8">{{ $invitation->event_address }}</p>@endif
                    @if($invitation->event_maps_url)
                    <a href="{{ $invitation->event_maps_url }}" target="_blank" class="inline-flex items-center gap-2 px-7 py-3 border border-[var(--gold)]/50 text-[var(--gold)] text-xs uppercase tracking-[0.2em] hover:bg-[var(--gold)] hover:text-[var(--black)] transition-all duration-300 rounded-lg">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        Lihat Lokasi
                    </a>
                    @endif
                </div>

                @if($invitation->dress_code)
                <div class="mt-8 inline-flex items-center gap-3 px-5 py-2.5 border border-[var(--border)] rounded-lg">
                    <span class="text-xs text-[var(--muted)]">Dress Code:</span>
                    <span class="text-xs text-[var(--gold)] font-medium">{{ $invitation->dress_code }}</span>
                </div>
                @endif
            </div>
        </section>


        <!-- GALLERY -->
        @if($invitation->galleries->count() > 0)
        <section class="py-20 px-6 bg-[var(--dark)] border-y border-[var(--border)]">
            <div class="max-w-5xl mx-auto">
                <p class="text-[9px] uppercase tracking-[0.6em] text-[var(--gold)] text-center mb-14">Our Moments</p>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                    @foreach($invitation->galleries as $photo)
                    <div class="aspect-square overflow-hidden rounded-lg group relative">
                        <img src="{{ $photo->getImageUrl() }}" alt="{{ $photo->caption }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- RSVP -->
        <section class="py-24 px-6 bg-[var(--black)]">
            <div class="max-w-sm mx-auto">
                <p class="text-[9px] uppercase tracking-[0.6em] text-[var(--gold)] text-center mb-4">Attendance</p>
                <h2 class="text-2xl font-display font-medium text-[var(--text)] text-center mb-10">RSVP</h2>

                @if(session('success'))
                <div class="mb-6 p-4 border border-green-800/50 bg-green-900/10 text-green-400 text-xs text-center rounded-lg">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" class="space-y-4">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Lengkap" required class="w-full px-5 py-3.5 bg-[var(--card)] border border-[var(--border)] rounded-lg text-sm text-[var(--text)] placeholder-[var(--muted)]/50 focus:border-[var(--gold)] focus:ring-1 focus:ring-[var(--gold)]/30 transition-all">
                    <select name="rsvp_status" required class="w-full px-5 py-3.5 bg-[var(--card)] border border-[var(--border)] rounded-lg text-sm text-[var(--text)] focus:border-[var(--gold)] focus:ring-1 focus:ring-[var(--gold)]/30 transition-all">
                        <option value="" class="text-[var(--muted)]">Konfirmasi Kehadiran</option>
                        <option value="attending">Hadir</option>
                        <option value="not_attending">Tidak Hadir</option>
                        <option value="maybe">Belum Pasti</option>
                    </select>
                    <input type="number" name="number_of_guests" min="1" max="10" value="1" class="w-full px-5 py-3.5 bg-[var(--card)] border border-[var(--border)] rounded-lg text-sm text-[var(--text)] focus:border-[var(--gold)] focus:ring-1 focus:ring-[var(--gold)]/30 transition-all">
                    <button type="submit" class="w-full py-3.5 shimmer-btn text-[var(--black)] text-xs uppercase tracking-[0.2em] font-semibold rounded-lg hover:scale-[1.02] transition-transform">
                        Kirim Konfirmasi
                    </button>
                </form>
            </div>
        </section>

        <!-- GUESTBOOK -->
        <section class="py-20 px-6 bg-[var(--dark)] border-t border-[var(--border)]">
            <div class="max-w-md mx-auto">
                <p class="text-[9px] uppercase tracking-[0.6em] text-[var(--gold)] text-center mb-4">Wishes</p>
                <h2 class="text-2xl font-display font-medium text-[var(--text)] text-center mb-10">Ucapan & Doa</h2>

                <form method="POST" action="{{ route('invitation.guestbook', $invitation->slug) }}" class="space-y-4 mb-10">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Anda" required class="w-full px-5 py-3.5 bg-[var(--card)] border border-[var(--border)] rounded-lg text-sm text-[var(--text)] placeholder-[var(--muted)]/50 focus:border-[var(--gold)] focus:ring-1 focus:ring-[var(--gold)]/30 transition-all">
                    <textarea name="message" rows="3" placeholder="Tulis ucapan terbaik Anda..." required class="w-full px-5 py-3.5 bg-[var(--card)] border border-[var(--border)] rounded-lg text-sm text-[var(--text)] placeholder-[var(--muted)]/50 focus:border-[var(--gold)] focus:ring-1 focus:ring-[var(--gold)]/30 transition-all resize-none"></textarea>
                    <button type="submit" class="w-full py-3.5 border border-[var(--gold)]/50 text-[var(--gold)] text-xs uppercase tracking-[0.2em] rounded-lg hover:bg-[var(--gold)] hover:text-[var(--black)] transition-all duration-300">
                        Kirim Ucapan
                    </button>
                </form>

                <div class="space-y-3 max-h-80 overflow-y-auto" style="scrollbar-width: thin; scrollbar-color: var(--border) transparent;">
                    @foreach($invitation->guestbooks as $msg)
                    <div class="p-5 bg-[var(--card)] border border-[var(--border)] rounded-xl">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-[var(--gold)]/10 flex items-center justify-center flex-shrink-0">
                                <span class="text-[10px] font-semibold text-[var(--gold)]">{{ strtoupper(substr($msg->name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-[var(--gold)]">{{ $msg->name }}</p>
                                <p class="text-sm text-[var(--text)]/70 mt-1 leading-relaxed">{{ $msg->message }}</p>
                                <p class="text-[10px] text-[var(--muted)] mt-2">{{ $msg->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- ENVELOPE -->
        @if($invitation->bank_name || $invitation->qris_image)
        <section class="py-24 px-6 bg-[var(--black)] border-t border-[var(--border)]">
            <div class="max-w-sm mx-auto text-center">
                <p class="text-[9px] uppercase tracking-[0.6em] text-[var(--gold)] mb-4">Wedding Gift</p>
                <h2 class="text-2xl font-display font-medium text-[var(--text)] mb-4">Amplop Digital</h2>
                <p class="text-xs text-[var(--muted)] mb-10">Kehadiran Anda adalah hadiah terbaik. Namun jika berkenan:</p>

                @if($invitation->bank_name)
                <div class="luxury-glow bg-[var(--card)] border border-[var(--border)] rounded-xl p-8 mb-4" x-data="{ copied: false }">
                    <p class="text-[9px] uppercase tracking-[0.3em] text-[var(--muted)] mb-3">{{ $invitation->bank_name }}</p>
                    <p class="text-xl font-display gold-gradient-text tracking-wider mb-1">{{ $invitation->bank_account_number }}</p>
                    <p class="text-xs text-[var(--muted)]">a.n. {{ $invitation->bank_account_name }}</p>
                    <button @click="navigator.clipboard.writeText('{{ $invitation->bank_account_number }}'); copied = true; setTimeout(() => copied = false, 2000)" class="mt-5 px-5 py-2 border border-[var(--gold)]/30 text-[var(--gold)] text-[10px] uppercase tracking-wider rounded hover:bg-[var(--gold)]/10 transition-colors">
                        <span x-text="copied ? 'Tersalin!' : 'Salin Nomor'"></span>
                    </button>
                </div>
                @endif

                @if($invitation->qris_image)
                <div class="luxury-glow inline-block bg-white p-5 rounded-xl">
                    <img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS" class="w-48 h-48 object-contain">
                </div>
                @endif
            </div>
        </section>
        @endif

        <!-- CLOSING -->
        @if($invitation->closing_text)
        <section class="py-20 px-6 bg-[var(--dark)] border-t border-[var(--border)]">
            <div class="max-w-xl mx-auto text-center">
                <div class="gold-line w-16 mx-auto mb-8"></div>
                <p class="text-base text-[var(--text)]/70 leading-loose italic font-light mb-8">{{ $invitation->closing_text }}</p>
                <div class="flex items-center justify-center gap-5 mb-4">
                    <div class="w-10 h-[1px] bg-[var(--gold)]/30"></div>
                    <div class="diamond-shape"></div>
                    <div class="w-10 h-[1px] bg-[var(--gold)]/30"></div>
                </div>
                <h3 class="text-xl font-display gold-gradient-text">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</h3>
            </div>
        </section>
        @endif

        <!-- FOOTER -->
        <footer class="py-10 px-6 bg-[var(--black)] text-center border-t border-[var(--border)]">
            <div class="gold-line w-12 mx-auto mb-5"></div>
            <p class="text-[10px] text-[var(--muted)] tracking-wider">Crafted by <a href="{{ url('/') }}" class="text-[var(--gold)] hover:underline">UndanganDigital</a></p>
        </footer>
    </div>

    <!-- MUSIC -->
    @if($invitation->music_url)
    <div class="fixed bottom-6 right-6 z-40" x-show="opened" x-transition>
        <button @click="toggleMusic()" class="w-12 h-12 rounded-full border border-[var(--gold)]/40 bg-[var(--card)] flex items-center justify-center hover:border-[var(--gold)] transition-all" :class="playing && 'border-[var(--gold)] shadow-[0_0_15px_rgba(201,169,110,0.2)]'">
            <svg x-show="!playing" class="w-4 h-4 text-[var(--gold)]" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>
            <svg x-show="playing" class="w-4 h-4 text-[var(--gold)]" fill="currentColor" viewBox="0 0 20 20"><path d="M5.75 3a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75A.75.75 0 007.25 3h-1.5zM12.75 3a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75a.75.75 0 00-.75-.75h-1.5z"/></svg>
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
