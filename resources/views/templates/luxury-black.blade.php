<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Raleway:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --color-primary: {{ $invitation->color_primary ?? '#C9A96E' }}; --color-secondary: {{ $invitation->color_secondary ?? '#0d0d0d' }}; --color-accent: {{ $invitation->color_accent ?? '#1a1a1a' }}; }
        .font-serif { font-family: 'Cinzel', serif; }
        .font-sans { font-family: 'Raleway', sans-serif; }
        [x-cloak] { display: none !important; }
        .gold-gradient { background: linear-gradient(135deg, #C9A96E 0%, #E8D5A3 50%, #C9A96E 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .border-gold { border-image: linear-gradient(135deg, #C9A96E, #E8D5A3, #C9A96E) 1; }
        .bg-pattern { background-image: radial-gradient(circle at 20% 50%, rgba(201,169,110,0.03) 0%, transparent 50%), radial-gradient(circle at 80% 50%, rgba(201,169,110,0.03) 0%, transparent 50%); }
        .glow { box-shadow: 0 0 30px rgba(201,169,110,0.15); }
        @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        .shimmer { background: linear-gradient(90deg, transparent, rgba(201,169,110,0.1), transparent); background-size: 200% 100%; animation: shimmer 3s infinite; }
    </style>
</head>
<body class="font-sans bg-[var(--color-secondary)] text-gray-300 overflow-x-hidden" x-data="invitationApp()" x-cloak>

    <!-- Opening Cover -->
    <section x-show="!opened" class="fixed inset-0 z-50 flex items-center justify-center bg-black" x-transition:leave="transition ease-in duration-700" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-pattern"></div>
        <div class="text-center px-6 relative z-10">
            <div class="w-20 h-px bg-gradient-to-r from-transparent via-[var(--color-primary)] to-transparent mx-auto mb-8"></div>
            <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--color-primary)] mb-6">The Wedding of</p>
            <h1 class="text-4xl sm:text-6xl font-serif font-bold gold-gradient mb-3">{{ $invitation->groom_name }}</h1>
            <p class="text-2xl font-serif text-[var(--color-primary)] my-4">&</p>
            <h1 class="text-4xl sm:text-6xl font-serif font-bold gold-gradient mb-8">{{ $invitation->bride_name }}</h1>
            <div class="w-20 h-px bg-gradient-to-r from-transparent via-[var(--color-primary)] to-transparent mx-auto mb-8"></div>
            @if($guestName)
            <p class="text-[10px] uppercase tracking-[0.3em] text-gray-500 mb-2">Kepada Yth.</p>
            <p class="text-sm text-gray-300 mb-8">{{ urldecode($guestName) }}</p>
            @endif
            <button @click="openInvitation()" class="px-10 py-3.5 bg-gradient-to-r from-[#C9A96E] to-[#E8D5A3] text-black font-semibold text-xs uppercase tracking-[0.2em] hover:shadow-[0_0_30px_rgba(201,169,110,0.4)] transition-all duration-500 transform hover:scale-105">
                Buka Undangan
            </button>
        </div>
    </section>

    <!-- Main Content -->
    <div x-show="opened" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

        <!-- Hero -->
        <section class="min-h-screen flex items-center justify-center py-20 px-6 bg-pattern relative">
            <div class="absolute top-0 left-0 w-32 h-32 border-t border-l border-[var(--color-primary)]/20"></div>
            <div class="absolute bottom-0 right-0 w-32 h-32 border-b border-r border-[var(--color-primary)]/20"></div>
            <div class="text-center max-w-lg relative z-10">
                <p class="text-[10px] uppercase tracking-[0.5em] text-[var(--color-primary)] mb-8">We Are Getting Married</p>
                <h2 class="text-5xl sm:text-7xl font-serif font-bold gold-gradient leading-tight">{{ $invitation->groom_name }}</h2>
                <p class="text-3xl font-serif text-[var(--color-primary)] my-6">&</p>
                <h2 class="text-5xl sm:text-7xl font-serif font-bold gold-gradient leading-tight">{{ $invitation->bride_name }}</h2>
                <div class="mt-12">
                    <div class="w-px h-12 bg-gradient-to-b from-transparent via-[var(--color-primary)] to-transparent mx-auto mb-4"></div>
                    <p class="text-xs text-gray-500 tracking-widest">{{ $invitation->event_date->translatedFormat('d F Y') }}</p>
                </div>
            </div>
        </section>

        <!-- Opening Text -->
        @if($invitation->opening_text)
        <section class="py-20 px-6 bg-[var(--color-accent)] shimmer">
            <div class="max-w-xl mx-auto text-center">
                <div class="w-16 h-px bg-gradient-to-r from-transparent via-[var(--color-primary)] to-transparent mx-auto mb-8"></div>
                <p class="text-gray-400 leading-loose italic text-base">{{ $invitation->opening_text }}</p>
                <div class="w-16 h-px bg-gradient-to-r from-transparent via-[var(--color-primary)] to-transparent mx-auto mt-8"></div>
            </div>
        </section>
        @endif

        <!-- Couple -->
        <section class="py-24 px-6 bg-[var(--color-secondary)]">
            <div class="max-w-4xl mx-auto grid md:grid-cols-2 gap-16">
                <div class="text-center">
                    @if($invitation->groom_photo)
                    <div class="w-52 h-52 mx-auto mb-8 rounded-full overflow-hidden border-2 border-[var(--color-primary)]/30 glow">
                        <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}" class="w-full h-full object-cover">
                    </div>
                    @endif
                    <h3 class="text-2xl font-serif gold-gradient">{{ $invitation->groom_name }}</h3>
                    @if($invitation->groom_father || $invitation->groom_mother)
                    <p class="text-xs text-gray-500 mt-3">Putra dari Bapak {{ $invitation->groom_father }} & Ibu {{ $invitation->groom_mother }}</p>
                    @endif
                    @if($invitation->groom_instagram)
                    <a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" target="_blank" class="inline-block mt-3 text-xs text-[var(--color-primary)] hover:text-[#E8D5A3] transition">{{ $invitation->groom_instagram }}</a>
                    @endif
                </div>
                <div class="text-center">
                    @if($invitation->bride_photo)
                    <div class="w-52 h-52 mx-auto mb-8 rounded-full overflow-hidden border-2 border-[var(--color-primary)]/30 glow">
                        <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}" class="w-full h-full object-cover">
                    </div>
                    @endif
                    <h3 class="text-2xl font-serif gold-gradient">{{ $invitation->bride_name }}</h3>
                    @if($invitation->bride_father || $invitation->bride_mother)
                    <p class="text-xs text-gray-500 mt-3">Putri dari Bapak {{ $invitation->bride_father }} & Ibu {{ $invitation->bride_mother }}</p>
                    @endif
                    @if($invitation->bride_instagram)
                    <a href="https://instagram.com/{{ ltrim($invitation->bride_instagram, '@') }}" target="_blank" class="inline-block mt-3 text-xs text-[var(--color-primary)] hover:text-[#E8D5A3] transition">{{ $invitation->bride_instagram }}</a>
                    @endif
                </div>
            </div>
        </section>

        <!-- Countdown -->
        <section class="py-20 px-6 bg-[var(--color-accent)]">
            <div class="max-w-3xl mx-auto text-center">
                <p class="text-[10px] uppercase tracking-[0.4em] text-[var(--color-primary)] mb-10">Counting The Days</p>
                <div class="grid grid-cols-4 gap-4" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">
                    <div class="bg-black/50 border border-[var(--color-primary)]/20 rounded-lg p-5">
                        <p class="text-3xl sm:text-4xl font-serif gold-gradient" x-text="days">0</p>
                        <p class="text-[9px] uppercase tracking-[0.2em] text-gray-500 mt-2">Hari</p>
                    </div>
                    <div class="bg-black/50 border border-[var(--color-primary)]/20 rounded-lg p-5">
                        <p class="text-3xl sm:text-4xl font-serif gold-gradient" x-text="hours">0</p>
                        <p class="text-[9px] uppercase tracking-[0.2em] text-gray-500 mt-2">Jam</p>
                    </div>
                    <div class="bg-black/50 border border-[var(--color-primary)]/20 rounded-lg p-5">
                        <p class="text-3xl sm:text-4xl font-serif gold-gradient" x-text="minutes">0</p>
                        <p class="text-[9px] uppercase tracking-[0.2em] text-gray-500 mt-2">Menit</p>
                    </div>
                    <div class="bg-black/50 border border-[var(--color-primary)]/20 rounded-lg p-5">
                        <p class="text-3xl sm:text-4xl font-serif gold-gradient" x-text="seconds">0</p>
                        <p class="text-[9px] uppercase tracking-[0.2em] text-gray-500 mt-2">Detik</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Event Details -->
        <section class="py-24 px-6 bg-[var(--color-secondary)] bg-pattern">
            <div class="max-w-2xl mx-auto text-center">
                <p class="text-[10px] uppercase tracking-[0.4em] text-[var(--color-primary)] mb-4">Save The Date</p>
                <h2 class="text-3xl font-serif gold-gradient mb-14">Detail Acara</h2>
                <div class="border border-[var(--color-primary)]/20 rounded-xl p-10 bg-[var(--color-accent)]/50 backdrop-blur">
                    <h4 class="text-xl font-serif text-[var(--color-primary)]">{{ $invitation->event_venue }}</h4>
                    <div class="w-12 h-px bg-[var(--color-primary)]/30 mx-auto my-6"></div>
                    <p class="text-sm text-gray-400">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                    <p class="text-sm text-gray-400 mt-1">Pukul {{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }} {{ $invitation->event_time_end ? '- ' . \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') : '' }} WIB</p>
                    @if($invitation->event_address)<p class="text-xs text-gray-500 mt-4">{{ $invitation->event_address }}</p>@endif
                    @if($invitation->event_maps_url)
                    <a href="{{ $invitation->event_maps_url }}" target="_blank" class="inline-flex items-center gap-2 mt-8 px-8 py-2.5 bg-gradient-to-r from-[#C9A96E] to-[#E8D5A3] text-black text-xs font-semibold uppercase tracking-wider hover:shadow-[0_0_20px_rgba(201,169,110,0.3)] transition-all duration-300">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Buka Maps
                    </a>
                    @endif
                </div>
                @if($invitation->dress_code)
                <div class="mt-8 p-4 border border-[var(--color-primary)]/10 rounded-lg"><p class="text-xs text-gray-400"><span class="text-[var(--color-primary)]">Dress Code:</span> {{ $invitation->dress_code }}</p></div>
                @endif
            </div>
        </section>

        <!-- Gallery -->
        @if($invitation->galleries->count() > 0)
        <section class="py-20 px-6 bg-[var(--color-accent)]">
            <div class="max-w-5xl mx-auto">
                <p class="text-[10px] uppercase tracking-[0.4em] text-[var(--color-primary)] text-center mb-4">Our Moments</p>
                <h2 class="text-3xl font-serif gold-gradient text-center mb-14">Galeri</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($invitation->galleries as $photo)
                    <div class="aspect-square overflow-hidden rounded-lg border border-[var(--color-primary)]/10">
                        <img src="{{ $photo->getImageUrl() }}" alt="{{ $photo->caption }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-700 opacity-90 hover:opacity-100">
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- RSVP -->
        <section class="py-24 px-6 bg-[var(--color-secondary)] bg-pattern">
            <div class="max-w-md mx-auto">
                <p class="text-[10px] uppercase tracking-[0.4em] text-[var(--color-primary)] text-center mb-4">Konfirmasi</p>
                <h2 class="text-3xl font-serif gold-gradient text-center mb-12">RSVP</h2>
                @if(session('success'))<div class="mb-6 p-4 border border-green-800 text-green-400 text-sm text-center rounded-lg">{{ session('success') }}</div>@endif
                <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" class="space-y-5">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Lengkap" required class="w-full px-4 py-3.5 bg-black/50 border border-[var(--color-primary)]/20 rounded-lg text-sm text-white focus:ring-1 focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] placeholder-gray-600">
                    <select name="rsvp_status" required class="w-full px-4 py-3.5 bg-black/50 border border-[var(--color-primary)]/20 rounded-lg text-sm text-gray-300 focus:ring-1 focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                        <option value="">Konfirmasi Kehadiran</option><option value="attending">Hadir</option><option value="not_attending">Tidak Hadir</option><option value="maybe">Masih Ragu</option>
                    </select>
                    <input type="number" name="number_of_guests" min="1" max="10" value="1" class="w-full px-4 py-3.5 bg-black/50 border border-[var(--color-primary)]/20 rounded-lg text-sm text-white focus:ring-1 focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                    <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-[#C9A96E] to-[#E8D5A3] text-black font-semibold text-xs uppercase tracking-[0.2em] rounded-lg hover:shadow-[0_0_20px_rgba(201,169,110,0.3)] transition-all duration-300">Kirim Konfirmasi</button>
                </form>
            </div>
        </section>

        <!-- Guestbook -->
        <section class="py-20 px-6 bg-[var(--color-accent)]">
            <div class="max-w-md mx-auto">
                <p class="text-[10px] uppercase tracking-[0.4em] text-[var(--color-primary)] text-center mb-4">Wishes</p>
                <h2 class="text-3xl font-serif gold-gradient text-center mb-12">Ucapan & Doa</h2>
                <form method="POST" action="{{ route('invitation.guestbook', $invitation->slug) }}" class="space-y-5 mb-12">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Anda" required class="w-full px-4 py-3.5 bg-black/50 border border-[var(--color-primary)]/20 rounded-lg text-sm text-white focus:ring-1 focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] placeholder-gray-600">
                    <textarea name="message" rows="3" placeholder="Tulis ucapan & doa..." required class="w-full px-4 py-3.5 bg-black/50 border border-[var(--color-primary)]/20 rounded-lg text-sm text-white focus:ring-1 focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] placeholder-gray-600 resize-none"></textarea>
                    <button type="submit" class="w-full py-3.5 border border-[var(--color-primary)] text-[var(--color-primary)] text-xs uppercase tracking-[0.2em] rounded-lg hover:bg-[var(--color-primary)] hover:text-black transition-all duration-300">Kirim Ucapan</button>
                </form>
                <div class="space-y-4 max-h-80 overflow-y-auto">
                    @foreach($invitation->guestbooks as $msg)
                    <div class="border border-[var(--color-primary)]/10 rounded-lg p-4 bg-black/30">
                        <p class="text-sm font-medium text-[var(--color-primary)]">{{ $msg->name }}</p>
                        <p class="text-sm text-gray-400 mt-1">{{ $msg->message }}</p>
                        <p class="text-[10px] text-gray-600 mt-2">{{ $msg->created_at->diffForHumans() }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Digital Envelope -->
        @if($invitation->bank_name || $invitation->qris_image)
        <section class="py-24 px-6 bg-[var(--color-secondary)] bg-pattern">
            <div class="max-w-md mx-auto text-center">
                <p class="text-[10px] uppercase tracking-[0.4em] text-[var(--color-primary)] mb-4">Wedding Gift</p>
                <h2 class="text-3xl font-serif gold-gradient mb-12">Amplop Digital</h2>
                @if($invitation->gift_info)<p class="text-sm text-gray-500 mb-8">{{ $invitation->gift_info }}</p>@endif
                @if($invitation->bank_name)
                <div class="border border-[var(--color-primary)]/20 rounded-xl p-8 bg-[var(--color-accent)]/50 mb-6">
                    <p class="text-[10px] uppercase tracking-wider text-gray-500 mb-2">{{ $invitation->bank_name }}</p>
                    <p class="text-xl font-serif text-[var(--color-primary)]">{{ $invitation->bank_account_number }}</p>
                    <p class="text-xs text-gray-500 mt-2">a.n. {{ $invitation->bank_account_name }}</p>
                </div>
                @endif
                @if($invitation->qris_image)
                <div class="inline-block p-5 border border-[var(--color-primary)]/20 rounded-xl bg-white"><img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS" class="w-44 h-44 object-contain"></div>
                @endif
            </div>
        </section>
        @endif

        <!-- Closing -->
        @if($invitation->closing_text)
        <section class="py-20 px-6 bg-[var(--color-accent)] shimmer">
            <div class="max-w-xl mx-auto text-center">
                <div class="w-16 h-px bg-gradient-to-r from-transparent via-[var(--color-primary)] to-transparent mx-auto mb-8"></div>
                <p class="text-gray-400 leading-loose italic text-base mb-8">{{ $invitation->closing_text }}</p>
                <h3 class="text-2xl font-serif gold-gradient">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</h3>
                <div class="w-16 h-px bg-gradient-to-r from-transparent via-[var(--color-primary)] to-transparent mx-auto mt-8"></div>
            </div>
        </section>
        @endif

        <!-- Footer -->
        <footer class="py-8 px-6 bg-black text-center">
            <p class="text-[10px] uppercase tracking-[0.2em] text-gray-600">Powered by <a href="{{ url('/') }}" class="text-[var(--color-primary)] hover:text-[#E8D5A3] transition">UndanganDigital</a></p>
        </footer>
    </div>

    <!-- Music Player -->
    @if($invitation->music_url)
    <div class="fixed bottom-6 right-6 z-40" x-show="opened">
        <button @click="toggleMusic()" class="w-12 h-12 bg-gradient-to-r from-[#C9A96E] to-[#E8D5A3] text-black rounded-full shadow-[0_0_20px_rgba(201,169,110,0.3)] flex items-center justify-center hover:shadow-[0_0_30px_rgba(201,169,110,0.5)] transition-all duration-300">
            <svg x-show="!playing" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/></svg>
            <svg x-show="playing" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z"/></svg>
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
