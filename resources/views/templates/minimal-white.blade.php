<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400&family=Montserrat:wght@200;300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: {{ $invitation->color_primary ?? '#1a1a1a' }};
            --bg: #ffffff;
            --bg-alt: #f8f8f6;
            --text: #2c2c2c;
            --muted: #7a7a7a;
            --border: #e5e5e5;
            --accent: #c5b99b;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Montserrat', sans-serif; font-weight: 300; color: var(--text); background: var(--bg); overflow-x: hidden; -webkit-font-smoothing: antialiased; }
        .font-display { font-family: 'Cormorant Garamond', serif; }
        [x-cloak] { display: none !important; }

        /* Reveal Animation */
        .reveal { opacity: 0; transform: translateY(25px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal.active { opacity: 1; transform: translateY(0); }
        .reveal-d1 { transition-delay: 0.1s; }
        .reveal-d2 { transition-delay: 0.2s; }
        .reveal-d3 { transition-delay: 0.3s; }

        /* Line Ornament */
        .line-orn { display: flex; align-items: center; justify-content: center; gap: 20px; }
        .line-orn::before, .line-orn::after { content: ''; width: 50px; height: 0.5px; background: var(--border); }

        /* Inputs */
        .field {
            width: 100%; padding: 14px 0; font-size: 14px;
            background: transparent; border: none; border-bottom: 1px solid var(--border);
            color: var(--text); font-family: 'Montserrat', sans-serif; font-weight: 300;
            transition: border-color 0.3s;
        }
        .field:focus { outline: none; border-bottom-color: var(--primary); }
        .field::placeholder { color: #bbb; }
        select.field { cursor: pointer; -webkit-appearance: none; }

        .btn-primary {
            width: 100%; padding: 15px; font-size: 12px; letter-spacing: 3px; text-transform: uppercase;
            background: var(--primary); color: white; border: none; cursor: pointer;
            font-family: 'Montserrat', sans-serif; font-weight: 500;
            transition: all 0.4s ease;
        }
        .btn-primary:hover { opacity: 0.85; transform: translateY(-1px); }

        .btn-outline {
            display: inline-block; padding: 13px 36px; font-size: 11px; letter-spacing: 3px; text-transform: uppercase;
            border: 1px solid var(--primary); color: var(--primary); background: transparent;
            font-family: 'Montserrat', sans-serif; font-weight: 400;
            cursor: pointer; transition: all 0.3s; text-decoration: none;
        }
        .btn-outline:hover { background: var(--primary); color: white; }

        /* Gallery masonry */
        .masonry { columns: 2; column-gap: 8px; }
        .masonry-item { break-inside: avoid; margin-bottom: 8px; }

        @media (max-width: 640px) {
            .masonry { columns: 2; column-gap: 6px; }
            .masonry-item { margin-bottom: 6px; }
        }
    </style>
</head>
<body x-data="invitationApp()" x-cloak>

    <!-- ===== OPENING COVER ===== -->
    <section x-show="!opened" class="fixed inset-0 z-50 flex items-center justify-center bg-white"
        x-transition:leave="transition ease-in duration-600"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="text-center px-8 max-w-sm">
            <p class="text-[10px] uppercase tracking-[6px] text-[var(--muted)] mb-10 font-medium">The Wedding Of</p>

            <h1 class="text-5xl sm:text-6xl font-display font-light text-[var(--primary)] leading-[1.1] mb-1">{{ $invitation->groom_name }}</h1>

            <div class="line-orn my-6">
                <span class="text-lg font-display italic text-[var(--muted)]">&</span>
            </div>

            <h1 class="text-5xl sm:text-6xl font-display font-light text-[var(--primary)] leading-[1.1]">{{ $invitation->bride_name }}</h1>

            @if($guestName)
            <div class="mt-10 pt-6 border-t border-[var(--border)]">
                <p class="text-[9px] uppercase tracking-[3px] text-[var(--muted)] mb-2">Kepada Yth.</p>
                <p class="text-sm text-[var(--text)] font-medium">{{ urldecode($guestName) }}</p>
            </div>
            @endif

            <button @click="openInvitation()" class="btn-outline mt-10">Buka Undangan</button>
        </div>
    </section>

    <!-- ===== MAIN CONTENT ===== -->
    <div x-show="opened" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

        <!-- HERO -->
        <section class="min-h-screen flex items-center justify-center py-28 px-6">
            <div class="text-center max-w-md reveal">
                <p class="text-[9px] uppercase tracking-[6px] text-[var(--muted)] mb-12 font-medium">We Are Getting Married</p>

                <h2 class="text-6xl sm:text-7xl font-display font-light text-[var(--primary)] leading-[1.1]">{{ $invitation->groom_name }}</h2>

                <div class="line-orn my-8">
                    <span class="text-2xl font-display italic text-[var(--muted)]">&</span>
                </div>

                <h2 class="text-6xl sm:text-7xl font-display font-light text-[var(--primary)] leading-[1.1]">{{ $invitation->bride_name }}</h2>

                <div class="mt-14">
                    <div class="w-px h-12 bg-[var(--border)] mx-auto mb-5"></div>
                    <p class="text-[11px] uppercase tracking-[4px] text-[var(--muted)]">{{ $invitation->event_date->translatedFormat('d . m . Y') }}</p>
                </div>
            </div>
        </section>

        <!-- OPENING TEXT -->
        @if($invitation->opening_text)
        <section class="py-20 px-6 bg-[var(--bg-alt)]">
            <div class="max-w-md mx-auto text-center reveal">
                <p class="text-lg sm:text-xl font-display italic text-[var(--text)] leading-[2] font-light">"{{ $invitation->opening_text }}"</p>
            </div>
        </section>
        @endif

        <!-- COUPLE -->
        <section class="py-24 px-6">
            <div class="max-w-sm mx-auto">
                <!-- Groom -->
                <div class="text-center mb-16 reveal">
                    @if($invitation->groom_photo)
                    <div class="w-44 h-56 mx-auto mb-8 overflow-hidden">
                        <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}"
                            class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-1000">
                    </div>
                    @endif
                    <h3 class="text-3xl font-display font-medium text-[var(--primary)] mb-3">{{ $invitation->groom_name }}</h3>
                    @if($invitation->groom_father || $invitation->groom_mother)
                    <p class="text-xs text-[var(--muted)] leading-relaxed">Putra dari Bpk. {{ $invitation->groom_father }}<br>& Ibu {{ $invitation->groom_mother }}</p>
                    @endif
                    @if($invitation->groom_instagram)
                    <a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" target="_blank" class="inline-block mt-3 text-[10px] uppercase tracking-[2px] text-[var(--muted)] hover:text-[var(--primary)] transition">{{ $invitation->groom_instagram }}</a>
                    @endif
                </div>

                <div class="text-center mb-16 reveal reveal-d1">
                    <div class="line-orn"><span class="text-3xl font-display italic text-[var(--accent)]">&</span></div>
                </div>

                <!-- Bride -->
                <div class="text-center reveal reveal-d2">
                    @if($invitation->bride_photo)
                    <div class="w-44 h-56 mx-auto mb-8 overflow-hidden">
                        <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}"
                            class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-1000">
                    </div>
                    @endif
                    <h3 class="text-3xl font-display font-medium text-[var(--primary)] mb-3">{{ $invitation->bride_name }}</h3>
                    @if($invitation->bride_father || $invitation->bride_mother)
                    <p class="text-xs text-[var(--muted)] leading-relaxed">Putri dari Bpk. {{ $invitation->bride_father }}<br>& Ibu {{ $invitation->bride_mother }}</p>
                    @endif
                    @if($invitation->bride_instagram)
                    <a href="https://instagram.com/{{ ltrim($invitation->bride_instagram, '@') }}" target="_blank" class="inline-block mt-3 text-[10px] uppercase tracking-[2px] text-[var(--muted)] hover:text-[var(--primary)] transition">{{ $invitation->bride_instagram }}</a>
                    @endif
                </div>
            </div>
        </section>

        <!-- COUNTDOWN -->
        <section class="py-20 px-6 bg-[var(--bg-alt)]" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">
            <div class="max-w-sm mx-auto text-center reveal">
                <p class="text-[9px] uppercase tracking-[5px] text-[var(--muted)] mb-10">Counting Down</p>
                <div class="grid grid-cols-4 gap-0 border border-[var(--border)] divide-x divide-[var(--border)]">
                    <div class="py-8">
                        <p class="text-3xl sm:text-4xl font-display font-light text-[var(--primary)]" x-text="days">0</p>
                        <p class="text-[8px] uppercase tracking-[3px] text-[var(--muted)] mt-3">Hari</p>
                    </div>
                    <div class="py-8">
                        <p class="text-3xl sm:text-4xl font-display font-light text-[var(--primary)]" x-text="hours">0</p>
                        <p class="text-[8px] uppercase tracking-[3px] text-[var(--muted)] mt-3">Jam</p>
                    </div>
                    <div class="py-8">
                        <p class="text-3xl sm:text-4xl font-display font-light text-[var(--primary)]" x-text="minutes">0</p>
                        <p class="text-[8px] uppercase tracking-[3px] text-[var(--muted)] mt-3">Menit</p>
                    </div>
                    <div class="py-8">
                        <p class="text-3xl sm:text-4xl font-display font-light text-[var(--primary)]" x-text="seconds">0</p>
                        <p class="text-[8px] uppercase tracking-[3px] text-[var(--muted)] mt-3">Detik</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- EVENT DETAILS -->
        <section class="py-24 px-6">
            <div class="max-w-sm mx-auto text-center reveal">
                <p class="text-[9px] uppercase tracking-[5px] text-[var(--muted)] mb-4">When & Where</p>
                <h3 class="text-3xl font-display text-[var(--primary)] mb-14">Acara</h3>

                <div class="border border-[var(--border)] p-10">
                    <h4 class="text-lg font-display font-medium text-[var(--primary)] mb-6">{{ $invitation->event_venue }}</h4>

                    <div class="w-8 h-px bg-[var(--accent)] mx-auto mb-6"></div>

                    <p class="text-sm text-[var(--text)] mb-1">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                    <p class="text-sm text-[var(--muted)]">{{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }} {{ $invitation->event_time_end ? '— ' . \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') : '' }} WIB</p>

                    @if($invitation->event_address)
                    <p class="text-xs text-[var(--muted)] mt-5 leading-relaxed">{{ $invitation->event_address }}</p>
                    @endif

                    @if($invitation->event_maps_url)
                    <a href="{{ $invitation->event_maps_url }}" target="_blank" class="btn-outline mt-8 text-[10px]">Lihat Peta</a>
                    @endif
                </div>

                @if($invitation->dress_code)
                <div class="mt-8 py-4 border-t border-b border-[var(--border)]">
                    <p class="text-[10px] uppercase tracking-[3px] text-[var(--muted)]">Dress Code: <span class="text-[var(--text)] font-medium">{{ $invitation->dress_code }}</span></p>
                </div>
                @endif
            </div>
        </section>

        <!-- GALLERY -->
        @if($invitation->galleries->count() > 0)
        <section class="py-20 px-6 bg-[var(--bg-alt)]">
            <div class="max-w-lg mx-auto">
                <div class="text-center mb-12 reveal">
                    <p class="text-[9px] uppercase tracking-[5px] text-[var(--muted)] mb-4">Gallery</p>
                    <h3 class="text-3xl font-display text-[var(--primary)]">Momen Kami</h3>
                </div>
                <div class="masonry reveal reveal-d1">
                    @foreach($invitation->galleries as $i => $photo)
                    <div class="masonry-item overflow-hidden">
                        <img src="{{ $photo->getImageUrl() }}" alt="{{ $photo->caption }}"
                            class="w-full object-cover hover:scale-105 transition-transform duration-700" loading="lazy">
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- RSVP -->
        <section class="py-24 px-6">
            <div class="max-w-xs mx-auto">
                <div class="text-center mb-12 reveal">
                    <p class="text-[9px] uppercase tracking-[5px] text-[var(--muted)] mb-4">Attendance</p>
                    <h3 class="text-3xl font-display text-[var(--primary)]">RSVP</h3>
                </div>

                @if(session('success'))
                <div class="mb-6 py-3 text-center text-sm text-green-700 border border-green-200 reveal">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" class="space-y-6 reveal reveal-d1">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama lengkap" required class="field">
                    <select name="rsvp_status" required class="field">
                        <option value="">Konfirmasi kehadiran</option>
                        <option value="attending">Ya, saya hadir</option>
                        <option value="not_attending">Maaf, tidak bisa hadir</option>
                        <option value="maybe">Belum pasti</option>
                    </select>
                    <input type="number" name="number_of_guests" min="1" max="10" value="1" placeholder="Jumlah tamu" class="field">
                    <button type="submit" class="btn-primary mt-4">Kirim</button>
                </form>
            </div>
        </section>

        <!-- GUESTBOOK -->
        <section class="py-20 px-6 bg-[var(--bg-alt)]">
            <div class="max-w-sm mx-auto">
                <div class="text-center mb-12 reveal">
                    <p class="text-[9px] uppercase tracking-[5px] text-[var(--muted)] mb-4">Wishes</p>
                    <h3 class="text-3xl font-display text-[var(--primary)]">Ucapan</h3>
                </div>

                <form method="POST" action="{{ route('invitation.guestbook', $invitation->slug) }}" class="space-y-5 mb-12 reveal reveal-d1">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama" required class="field">
                    <textarea name="message" rows="3" placeholder="Tulis ucapan & doa..." required class="field resize-none" style="border-bottom: 1px solid var(--border);"></textarea>
                    <button type="submit" class="btn-primary">Kirim Ucapan</button>
                </form>

                <div class="space-y-0 max-h-80 overflow-y-auto reveal reveal-d2">
                    @foreach($invitation->guestbooks as $msg)
                    <div class="py-5 border-b border-[var(--border)]">
                        <p class="text-xs font-medium text-[var(--primary)] uppercase tracking-[1px]">{{ $msg->name }}</p>
                        <p class="text-sm text-[var(--muted)] mt-2 leading-relaxed font-light">{{ $msg->message }}</p>
                        <p class="text-[10px] text-[var(--muted)] mt-2 opacity-50">{{ $msg->created_at->diffForHumans() }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- AMPLOP DIGITAL -->
        @if($invitation->bank_name || $invitation->qris_image)
        <section class="py-24 px-6">
            <div class="max-w-xs mx-auto text-center reveal">
                <p class="text-[9px] uppercase tracking-[5px] text-[var(--muted)] mb-4">Gift</p>
                <h3 class="text-3xl font-display text-[var(--primary)] mb-4">Amplop Digital</h3>
                @if($invitation->gift_info)
                <p class="text-xs text-[var(--muted)] mb-10 leading-relaxed">{{ $invitation->gift_info }}</p>
                @else
                <p class="text-xs text-[var(--muted)] mb-10">Doa Anda sudah cukup. Jika berkenan memberi tanda kasih:</p>
                @endif

                @if($invitation->bank_name)
                <div class="border border-[var(--border)] p-8 mb-6" x-data="{ copied: false }">
                    <p class="text-[9px] uppercase tracking-[3px] text-[var(--muted)] mb-3">{{ $invitation->bank_name }}</p>
                    <p class="text-xl font-display font-medium text-[var(--primary)] tracking-wider">{{ $invitation->bank_account_number }}</p>
                    <p class="text-xs text-[var(--muted)] mt-2">a.n. {{ $invitation->bank_account_name }}</p>
                    <button @click="navigator.clipboard.writeText('{{ $invitation->bank_account_number }}'); copied = true; setTimeout(() => copied = false, 2000)"
                        class="mt-5 text-[9px] uppercase tracking-[2px] text-[var(--primary)] border border-[var(--primary)] px-5 py-2 hover:bg-[var(--primary)] hover:text-white transition-all cursor-pointer">
                        <span x-text="copied ? 'Tersalin!' : 'Salin'"></span>
                    </button>
                </div>
                @endif

                @if($invitation->qris_image)
                <div class="border border-[var(--border)] p-6 inline-block">
                    <img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS" class="w-40 h-40 object-contain mx-auto">
                    <p class="text-[9px] uppercase tracking-[2px] text-[var(--muted)] mt-4">Scan QRIS</p>
                </div>
                @endif
            </div>
        </section>
        @endif

        <!-- CLOSING -->
        @if($invitation->closing_text)
        <section class="py-24 px-6 bg-[var(--bg-alt)]">
            <div class="max-w-md mx-auto text-center reveal">
                <div class="w-px h-10 bg-[var(--border)] mx-auto mb-8"></div>
                <p class="text-base font-display italic text-[var(--muted)] leading-[2]">{{ $invitation->closing_text }}</p>
                <div class="w-px h-10 bg-[var(--border)] mx-auto my-8"></div>
                <h3 class="text-2xl font-display text-[var(--primary)]">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</h3>
            </div>
        </section>
        @endif

        <!-- FOOTER -->
        <footer class="py-10 px-6 text-center border-t border-[var(--border)]">
            <p class="text-[9px] uppercase tracking-[3px] text-[var(--muted)]">Made with love &middot; <a href="{{ url('/') }}" class="hover:text-[var(--primary)] transition">UndanganDigital</a></p>
        </footer>
    </div>

    <!-- MUSIC PLAYER -->
    @if($invitation->music_url)
    <div class="fixed bottom-6 right-6 z-40" x-show="opened">
        <button @click="toggleMusic()" class="w-10 h-10 border border-[var(--primary)] text-[var(--primary)] rounded-full flex items-center justify-center hover:bg-[var(--primary)] hover:text-white transition-all duration-300">
            <svg x-show="!playing" class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
            <svg x-show="playing" class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
        </button>
        <audio x-ref="audio" src="{{ asset('storage/' . $invitation->music_url) }}" loop></audio>
    </div>
    @endif

    <script>
    function invitationApp() {
        return {
            opened: false, playing: false,
            openInvitation() {
                this.opened = true;
                document.querySelectorAll('.reveal').forEach(el => {
                    const observer = new IntersectionObserver(entries => {
                        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('active'); observer.unobserve(e.target); } });
                    }, { threshold: 0.15 });
                    observer.observe(el);
                });
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
            update() {
                const diff = new Date(targetDate) - new Date();
                if (diff > 0) { this.days = Math.floor(diff/(1000*60*60*24)); this.hours = Math.floor((diff%(1000*60*60*24))/(1000*60*60)); this.minutes = Math.floor((diff%(1000*60*60))/(1000*60)); this.seconds = Math.floor((diff%(1000*60))/1000); }
            }
        };
    }
    </script>
</body>
</html>
