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
            --bg-alt: #fafafa;
            --text: #333333;
            --text-muted: #888888;
            --border: #e8e8e8;
        }
        body { font-family: 'Montserrat', sans-serif; font-weight: 300; }
        .font-display { font-family: 'Cormorant Garamond', serif; }
        [x-cloak] { display: none !important; }

        .line-ornament {
            display: flex;
            align-items: center;
            gap: 16px;
            justify-content: center;
        }
        .line-ornament::before,
        .line-ornament::after {
            content: '';
            width: 60px;
            height: 1px;
            background: var(--border);
        }

        .minimal-card {
            border: 1px solid var(--border);
            transition: all 0.3s ease;
        }
        .minimal-card:hover {
            border-color: var(--primary);
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        }
    </style>
</head>
<body class="bg-white text-[var(--text)] overflow-x-hidden leading-relaxed" x-data="invitationApp()" x-cloak>

    <!-- ========== OPENING ========== -->
    <section x-show="!opened" class="fixed inset-0 z-50 flex items-center justify-center bg-white"
        x-transition:leave="transition ease-in duration-500"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

        <div class="text-center px-8 max-w-sm">
            <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--text-muted)] mb-10">The Wedding Of</p>

            <h1 class="text-5xl sm:text-6xl font-display font-light text-[var(--primary)] leading-none mb-2">{{ $invitation->groom_name }}</h1>
            <p class="text-[var(--text-muted)] text-2xl font-display italic my-3">&</p>
            <h1 class="text-5xl sm:text-6xl font-display font-light text-[var(--primary)] leading-none">{{ $invitation->bride_name }}</h1>

            @if($guestName)
            <div class="mt-10 pt-8 border-t border-[var(--border)]">
                <p class="text-[10px] uppercase tracking-[0.3em] text-[var(--text-muted)] mb-1">Kepada</p>
                <p class="text-base font-medium text-[var(--primary)]">{{ urldecode($guestName) }}</p>
            </div>
            @endif

            <button @click="openInvitation()" class="mt-12 px-10 py-3.5 border border-[var(--primary)] text-[var(--primary)] text-xs uppercase tracking-[0.2em] font-medium hover:bg-[var(--primary)] hover:text-white transition-all duration-300">
                Buka Undangan
            </button>

            <p class="text-[10px] text-[var(--text-muted)] mt-8 tracking-wider">{{ $invitation->event_date->format('d . m . Y') }}</p>
        </div>
    </section>

    <!-- ========== MAIN CONTENT ========== -->
    <div x-show="opened" x-transition:enter="transition ease-out duration-800" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

        <!-- HERO -->
        <section class="min-h-screen flex items-center justify-center py-24 px-6">
            <div class="text-center max-w-lg">
                <p class="text-[10px] uppercase tracking-[0.6em] text-[var(--text-muted)] mb-12">We Are Getting Married</p>

                <h2 class="text-6xl sm:text-8xl font-display font-light text-[var(--primary)] leading-none">{{ $invitation->groom_name }}</h2>

                <div class="line-ornament my-8">
                    <span class="text-xl font-display italic text-[var(--text-muted)]">&</span>
                </div>

                <h2 class="text-6xl sm:text-8xl font-display font-light text-[var(--primary)] leading-none">{{ $invitation->bride_name }}</h2>

                <p class="mt-14 text-sm text-[var(--text-muted)] tracking-wide">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
            </div>
        </section>

        <!-- OPENING TEXT -->
        @if($invitation->opening_text)
        <section class="py-20 px-6 bg-[var(--bg-alt)]">
            <div class="max-w-xl mx-auto text-center">
                <p class="text-lg font-display italic text-[var(--text)] leading-loose">"{{ $invitation->opening_text }}"</p>
            </div>
        </section>
        @endif

        <!-- COUPLE -->
        <section class="py-24 px-6">
            <div class="max-w-4xl mx-auto">
                <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--text-muted)] text-center mb-16">The Couple</p>

                <div class="grid md:grid-cols-2 gap-20">
                    <!-- Groom -->
                    <div class="text-center">
                        @if($invitation->groom_photo)
                        <div class="w-56 h-56 mx-auto mb-8 overflow-hidden">
                            <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700" style="clip-path: circle(50%)">
                        </div>
                        @else
                        <div class="w-56 h-56 mx-auto mb-8 bg-[var(--bg-alt)] flex items-center justify-center" style="clip-path: circle(50%)">
                            <span class="text-6xl font-display font-light text-[var(--text-muted)]">{{ substr($invitation->groom_name, 0, 1) }}</span>
                        </div>
                        @endif
                        <h3 class="text-2xl font-display font-medium text-[var(--primary)] mb-3">{{ $invitation->groom_name }}</h3>
                        @if($invitation->groom_father || $invitation->groom_mother)
                        <p class="text-xs text-[var(--text-muted)] leading-loose">
                            Putra dari<br>{{ $invitation->groom_father }} & {{ $invitation->groom_mother }}
                        </p>
                        @endif
                        @if($invitation->groom_instagram)
                        <a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" target="_blank" class="inline-block mt-4 text-xs text-[var(--text-muted)] hover:text-[var(--primary)] transition-colors">{{ $invitation->groom_instagram }}</a>
                        @endif
                    </div>

                    <!-- Bride -->
                    <div class="text-center">
                        @if($invitation->bride_photo)
                        <div class="w-56 h-56 mx-auto mb-8 overflow-hidden">
                            <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700" style="clip-path: circle(50%)">
                        </div>
                        @else
                        <div class="w-56 h-56 mx-auto mb-8 bg-[var(--bg-alt)] flex items-center justify-center" style="clip-path: circle(50%)">
                            <span class="text-6xl font-display font-light text-[var(--text-muted)]">{{ substr($invitation->bride_name, 0, 1) }}</span>
                        </div>
                        @endif
                        <h3 class="text-2xl font-display font-medium text-[var(--primary)] mb-3">{{ $invitation->bride_name }}</h3>
                        @if($invitation->bride_father || $invitation->bride_mother)
                        <p class="text-xs text-[var(--text-muted)] leading-loose">
                            Putri dari<br>{{ $invitation->bride_father }} & {{ $invitation->bride_mother }}
                        </p>
                        @endif
                        @if($invitation->bride_instagram)
                        <a href="https://instagram.com/{{ ltrim($invitation->bride_instagram, '@') }}" target="_blank" class="inline-block mt-4 text-xs text-[var(--text-muted)] hover:text-[var(--primary)] transition-colors">{{ $invitation->bride_instagram }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- COUNTDOWN -->
        <section class="py-20 px-6 bg-[var(--bg-alt)] border-y border-[var(--border)]" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">
            <div class="max-w-md mx-auto text-center">
                <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--text-muted)] mb-10">Counting Days</p>
                <div class="grid grid-cols-4 gap-6">
                    <div>
                        <p class="text-4xl sm:text-5xl font-display font-light text-[var(--primary)]" x-text="days">0</p>
                        <p class="text-[9px] uppercase tracking-[0.3em] text-[var(--text-muted)] mt-3">Days</p>
                    </div>
                    <div>
                        <p class="text-4xl sm:text-5xl font-display font-light text-[var(--primary)]" x-text="hours">0</p>
                        <p class="text-[9px] uppercase tracking-[0.3em] text-[var(--text-muted)] mt-3">Hours</p>
                    </div>
                    <div>
                        <p class="text-4xl sm:text-5xl font-display font-light text-[var(--primary)]" x-text="minutes">0</p>
                        <p class="text-[9px] uppercase tracking-[0.3em] text-[var(--text-muted)] mt-3">Mins</p>
                    </div>
                    <div>
                        <p class="text-4xl sm:text-5xl font-display font-light text-[var(--primary)]" x-text="seconds">0</p>
                        <p class="text-[9px] uppercase tracking-[0.3em] text-[var(--text-muted)] mt-3">Secs</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- EVENT -->
        <section class="py-24 px-6">
            <div class="max-w-lg mx-auto text-center">
                <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--text-muted)] mb-4">When & Where</p>
                <h2 class="text-3xl font-display font-medium text-[var(--primary)] mb-14">Detail Acara</h2>

                <div class="minimal-card rounded-2xl p-10">
                    <h4 class="text-xl font-display font-medium text-[var(--primary)] mb-6">{{ $invitation->event_venue }}</h4>
                    <div class="space-y-1 text-sm text-[var(--text-muted)] mb-6">
                        <p>{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                        <p>{{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }} {{ $invitation->event_time_end ? '- ' . \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') : '' }} WIB</p>
                    </div>
                    @if($invitation->event_address)
                    <p class="text-xs text-[var(--text-muted)] mb-8">{{ $invitation->event_address }}</p>
                    @endif
                    @if($invitation->event_maps_url)
                    <a href="{{ $invitation->event_maps_url }}" target="_blank" class="inline-block px-8 py-3 border border-[var(--primary)] text-[var(--primary)] text-xs uppercase tracking-[0.15em] hover:bg-[var(--primary)] hover:text-white transition-all duration-300">
                        Buka Maps
                    </a>
                    @endif
                </div>

                @if($invitation->dress_code)
                <p class="mt-8 text-xs text-[var(--text-muted)]">Dress Code: <span class="font-medium text-[var(--primary)]">{{ $invitation->dress_code }}</span></p>
                @endif
            </div>
        </section>

        <!-- GALLERY -->
        @if($invitation->galleries->count() > 0)
        <section class="py-20 px-6 bg-[var(--bg-alt)] border-y border-[var(--border)]">
            <div class="max-w-5xl mx-auto">
                <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--text-muted)] text-center mb-14">Gallery</p>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                    @foreach($invitation->galleries as $photo)
                    <div class="aspect-square overflow-hidden group">
                        <img src="{{ $photo->getImageUrl() }}" alt="{{ $photo->caption }}" class="w-full h-full object-cover grayscale-[30%] group-hover:grayscale-0 group-hover:scale-105 transition-all duration-700">
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- RSVP -->
        <section class="py-24 px-6">
            <div class="max-w-sm mx-auto">
                <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--text-muted)] text-center mb-4">Attendance</p>
                <h2 class="text-3xl font-display font-medium text-[var(--primary)] text-center mb-10">RSVP</h2>

                @if(session('success'))
                <div class="mb-6 p-4 border border-green-200 text-green-700 text-xs text-center">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" class="space-y-4">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Lengkap" required class="w-full px-5 py-3.5 border border-[var(--border)] bg-transparent text-sm focus:border-[var(--primary)] focus:ring-0 transition-colors placeholder:text-[var(--text-muted)]/50">
                    <select name="rsvp_status" required class="w-full px-5 py-3.5 border border-[var(--border)] bg-transparent text-sm focus:border-[var(--primary)] focus:ring-0 transition-colors">
                        <option value="">Konfirmasi Kehadiran</option>
                        <option value="attending">Hadir</option>
                        <option value="not_attending">Tidak Hadir</option>
                        <option value="maybe">Belum Pasti</option>
                    </select>
                    <input type="number" name="number_of_guests" min="1" max="10" value="1" class="w-full px-5 py-3.5 border border-[var(--border)] bg-transparent text-sm focus:border-[var(--primary)] focus:ring-0 transition-colors">
                    <button type="submit" class="w-full py-3.5 bg-[var(--primary)] text-white text-xs uppercase tracking-[0.2em] hover:opacity-90 transition-opacity">
                        Kirim
                    </button>
                </form>
            </div>
        </section>

        <!-- GUESTBOOK -->
        <section class="py-20 px-6 bg-[var(--bg-alt)] border-t border-[var(--border)]">
            <div class="max-w-md mx-auto">
                <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--text-muted)] text-center mb-4">Wishes</p>
                <h2 class="text-3xl font-display font-medium text-[var(--primary)] text-center mb-10">Ucapan</h2>

                <form method="POST" action="{{ route('invitation.guestbook', $invitation->slug) }}" class="space-y-4 mb-12">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama" required class="w-full px-5 py-3.5 border border-[var(--border)] bg-white text-sm focus:border-[var(--primary)] focus:ring-0 transition-colors placeholder:text-[var(--text-muted)]/50">
                    <textarea name="message" rows="3" placeholder="Tulis ucapan Anda..." required class="w-full px-5 py-3.5 border border-[var(--border)] bg-white text-sm focus:border-[var(--primary)] focus:ring-0 transition-colors resize-none placeholder:text-[var(--text-muted)]/50"></textarea>
                    <button type="submit" class="w-full py-3.5 border border-[var(--primary)] text-[var(--primary)] text-xs uppercase tracking-[0.2em] hover:bg-[var(--primary)] hover:text-white transition-all duration-300">
                        Kirim Ucapan
                    </button>
                </form>

                <div class="space-y-4 max-h-80 overflow-y-auto">
                    @foreach($invitation->guestbooks as $msg)
                    <div class="p-5 border border-[var(--border)] bg-white">
                        <p class="text-xs font-medium text-[var(--primary)] mb-1">{{ $msg->name }}</p>
                        <p class="text-sm text-[var(--text-muted)] leading-relaxed">{{ $msg->message }}</p>
                        <p class="text-[10px] text-[var(--text-muted)]/60 mt-2">{{ $msg->created_at->diffForHumans() }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- ENVELOPE -->
        @if($invitation->bank_name || $invitation->qris_image)
        <section class="py-24 px-6 border-t border-[var(--border)]">
            <div class="max-w-sm mx-auto text-center">
                <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--text-muted)] mb-4">Gift</p>
                <h2 class="text-3xl font-display font-medium text-[var(--primary)] mb-4">Amplop Digital</h2>
                <p class="text-xs text-[var(--text-muted)] mb-10">Kehadiran Anda sudah cukup. Namun jika ingin memberi hadiah:</p>

                @if($invitation->bank_name)
                <div class="minimal-card p-8 mb-4 text-center" x-data="{ copied: false }">
                    <p class="text-[10px] uppercase tracking-[0.3em] text-[var(--text-muted)] mb-3">{{ $invitation->bank_name }}</p>
                    <p class="text-xl font-medium text-[var(--primary)] tracking-wider mb-1">{{ $invitation->bank_account_number }}</p>
                    <p class="text-xs text-[var(--text-muted)]">{{ $invitation->bank_account_name }}</p>
                    <button @click="navigator.clipboard.writeText('{{ $invitation->bank_account_number }}'); copied = true; setTimeout(() => copied = false, 2000)" class="mt-5 text-[10px] uppercase tracking-wider text-[var(--text-muted)] hover:text-[var(--primary)] border-b border-current pb-0.5 transition-colors">
                        <span x-text="copied ? 'Tersalin!' : 'Salin Nomor'"></span>
                    </button>
                </div>
                @endif

                @if($invitation->qris_image)
                <div class="minimal-card p-6 inline-block">
                    <img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS" class="w-48 h-48 object-contain">
                </div>
                @endif
            </div>
        </section>
        @endif

        <!-- CLOSING -->
        @if($invitation->closing_text)
        <section class="py-20 px-6 bg-[var(--bg-alt)] border-t border-[var(--border)]">
            <div class="max-w-xl mx-auto text-center">
                <p class="text-lg font-display italic text-[var(--text)] leading-loose mb-8">"{{ $invitation->closing_text }}"</p>
                <div class="line-ornament">
                    <span class="text-sm font-display italic text-[var(--text-muted)]">With Love</span>
                </div>
                <h3 class="text-2xl font-display font-medium text-[var(--primary)] mt-6">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</h3>
            </div>
        </section>
        @endif

        <!-- FOOTER -->
        <footer class="py-10 px-6 text-center border-t border-[var(--border)]">
            <p class="text-[10px] text-[var(--text-muted)] tracking-wider">Created with <a href="{{ url('/') }}" class="text-[var(--primary)] hover:underline">UndanganDigital</a></p>
        </footer>
    </div>

    <!-- MUSIC -->
    @if($invitation->music_url)
    <div class="fixed bottom-6 right-6 z-40" x-show="opened" x-transition>
        <button @click="toggleMusic()" class="w-12 h-12 border border-[var(--border)] bg-white rounded-full shadow-sm flex items-center justify-center hover:border-[var(--primary)] transition-colors" :class="playing && 'border-[var(--primary)]'">
            <svg x-show="!playing" class="w-4 h-4 text-[var(--primary)]" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>
            <svg x-show="playing" class="w-4 h-4 text-[var(--primary)]" fill="currentColor" viewBox="0 0 20 20"><path d="M5.75 3a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75A.75.75 0 007.25 3h-1.5zM12.75 3a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75a.75.75 0 00-.75-.75h-1.5z"/></svg>
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
