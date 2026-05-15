<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --color-primary: {{ $invitation->color_primary ?? '#D4AF37' }}; --color-secondary: {{ $invitation->color_secondary ?? '#1a1a2e' }}; }
        .font-serif { font-family: 'Playfair Display', serif; }
        .font-sans { font-family: 'Lato', sans-serif; }
        [x-cloak] { display: none !important; }
        .animate-spin-slow { animation: spin 3s linear infinite; }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    </style>
</head>
<body class="font-sans bg-[#faf8f5] text-gray-800 overflow-x-hidden" x-data="invitationApp()" x-cloak>

    <!-- Opening Cover -->
    <section x-show="!opened" class="fixed inset-0 z-50 flex items-center justify-center bg-[var(--color-secondary)]" x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="text-center text-white px-6">
            <p class="text-sm uppercase tracking-[0.3em] text-[var(--color-primary)] mb-4">The Wedding of</p>
            <h1 class="text-4xl sm:text-5xl font-serif font-bold mb-2">{{ $invitation->groom_name }}</h1>
            <p class="text-2xl font-serif text-[var(--color-primary)] my-2">&</p>
            <h1 class="text-4xl sm:text-5xl font-serif font-bold mb-6">{{ $invitation->bride_name }}</h1>
            @if($guestName)
            <p class="text-sm text-gray-300 mb-4">Kepada Yth.</p>
            <p class="text-lg font-medium text-white mb-8">{{ urldecode($guestName) }}</p>
            @endif
            <button @click="openInvitation()" class="px-8 py-3 bg-[var(--color-primary)] text-[var(--color-secondary)] font-semibold rounded-full hover:opacity-90 transition-all transform hover:scale-105">
                Buka Undangan
            </button>
        </div>
    </section>

    <!-- Main Content -->
    <div x-show="opened" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

        <!-- Hero -->
        <section class="min-h-screen flex items-center justify-center relative py-20 px-6 bg-gradient-to-b from-[#faf8f5] to-white">
            <div class="absolute inset-0 opacity-5">
                <div class="absolute top-10 left-10 w-40 h-40 border border-[var(--color-primary)] rounded-full"></div>
                <div class="absolute bottom-10 right-10 w-60 h-60 border border-[var(--color-primary)] rounded-full"></div>
            </div>
            <div class="text-center relative z-10 max-w-lg">
                <p class="text-xs uppercase tracking-[0.3em] text-[var(--color-primary)] mb-6">We're Getting Married</p>
                <h2 class="text-5xl sm:text-6xl font-serif font-bold text-[var(--color-secondary)] mb-2">{{ $invitation->groom_name }}</h2>
                <p class="text-3xl font-serif text-[var(--color-primary)] my-4">&</p>
                <h2 class="text-5xl sm:text-6xl font-serif font-bold text-[var(--color-secondary)]">{{ $invitation->bride_name }}</h2>
                <div class="mt-8 text-gray-600"><p class="text-lg">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p></div>
            </div>
        </section>

        <!-- Opening Text -->
        @if($invitation->opening_text)
        <section class="py-16 px-6 bg-white">
            <div class="max-w-2xl mx-auto text-center">
                <div class="w-16 h-[1px] bg-[var(--color-primary)] mx-auto mb-8"></div>
                <p class="text-gray-600 leading-relaxed italic text-lg">{{ $invitation->opening_text }}</p>
                <div class="w-16 h-[1px] bg-[var(--color-primary)] mx-auto mt-8"></div>
            </div>
        </section>
        @endif

        <!-- Couple Profile -->
        <section class="py-16 px-6 bg-[#faf8f5]">
            <div class="max-w-4xl mx-auto grid md:grid-cols-2 gap-12">
                <div class="text-center">
                    @if($invitation->groom_photo)
                    <div class="w-48 h-48 mx-auto mb-6 rounded-full overflow-hidden border-4 border-[var(--color-primary)]/30">
                        <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}" class="w-full h-full object-cover">
                    </div>
                    @endif
                    <h3 class="text-2xl font-serif font-bold text-[var(--color-secondary)]">{{ $invitation->groom_name }}</h3>
                    @if($invitation->groom_father || $invitation->groom_mother)<p class="text-gray-500 mt-2">Putra dari {{ $invitation->groom_father }} & {{ $invitation->groom_mother }}</p>@endif
                    @if($invitation->groom_instagram)<a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" target="_blank" class="inline-flex items-center gap-1 text-sm text-[var(--color-primary)] mt-2 hover:underline">{{ $invitation->groom_instagram }}</a>@endif
                </div>
                <div class="text-center">
                    @if($invitation->bride_photo)
                    <div class="w-48 h-48 mx-auto mb-6 rounded-full overflow-hidden border-4 border-[var(--color-primary)]/30">
                        <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}" class="w-full h-full object-cover">
                    </div>
                    @endif
                    <h3 class="text-2xl font-serif font-bold text-[var(--color-secondary)]">{{ $invitation->bride_name }}</h3>
                    @if($invitation->bride_father || $invitation->bride_mother)<p class="text-gray-500 mt-2">Putri dari {{ $invitation->bride_father }} & {{ $invitation->bride_mother }}</p>@endif
                    @if($invitation->bride_instagram)<a href="https://instagram.com/{{ ltrim($invitation->bride_instagram, '@') }}" target="_blank" class="inline-flex items-center gap-1 text-sm text-[var(--color-primary)] mt-2 hover:underline">{{ $invitation->bride_instagram }}</a>@endif
                </div>
            </div>
        </section>

        <!-- Countdown -->
        <section class="py-16 px-6 bg-[var(--color-secondary)] text-white">
            <div class="max-w-3xl mx-auto text-center">
                <h3 class="text-sm uppercase tracking-[0.3em] text-[var(--color-primary)] mb-8">Menghitung Hari</h3>
                <div class="grid grid-cols-4 gap-4" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">
                    <div class="bg-white/5 rounded-2xl p-4"><p class="text-3xl sm:text-4xl font-bold text-[var(--color-primary)]" x-text="days">0</p><p class="text-xs uppercase tracking-wider text-gray-400 mt-1">Hari</p></div>
                    <div class="bg-white/5 rounded-2xl p-4"><p class="text-3xl sm:text-4xl font-bold text-[var(--color-primary)]" x-text="hours">0</p><p class="text-xs uppercase tracking-wider text-gray-400 mt-1">Jam</p></div>
                    <div class="bg-white/5 rounded-2xl p-4"><p class="text-3xl sm:text-4xl font-bold text-[var(--color-primary)]" x-text="minutes">0</p><p class="text-xs uppercase tracking-wider text-gray-400 mt-1">Menit</p></div>
                    <div class="bg-white/5 rounded-2xl p-4"><p class="text-3xl sm:text-4xl font-bold text-[var(--color-primary)]" x-text="seconds">0</p><p class="text-xs uppercase tracking-wider text-gray-400 mt-1">Detik</p></div>
                </div>
            </div>
        </section>

        <!-- Event Details -->
        <section class="py-16 px-6 bg-white">
            <div class="max-w-3xl mx-auto text-center">
                <h3 class="text-sm uppercase tracking-[0.3em] text-[var(--color-primary)] mb-2">Waktu & Tempat</h3>
                <h2 class="text-3xl font-serif font-bold text-[var(--color-secondary)] mb-12">Detail Acara</h2>
                <div class="bg-[#faf8f5] rounded-3xl p-8 border border-[var(--color-primary)]/10">
                    <h4 class="text-xl font-serif font-bold text-[var(--color-secondary)] mb-4">{{ $invitation->event_venue }}</h4>
                    <p class="text-gray-600 mb-2">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                    <p class="text-gray-600 mb-4">Pukul {{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }} {{ $invitation->event_time_end ? '- ' . \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') : '' }} WIB</p>
                    @if($invitation->event_address)<p class="text-gray-500 text-sm mb-6">{{ $invitation->event_address }}</p>@endif
                    @if($invitation->event_maps_url)
                    <a href="{{ $invitation->event_maps_url }}" target="_blank" class="inline-flex items-center gap-2 px-6 py-2.5 bg-[var(--color-primary)] text-[var(--color-secondary)] font-medium rounded-full text-sm hover:opacity-90 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>Buka Maps
                    </a>
                    @endif
                </div>
                @if($invitation->dress_code)
                <div class="mt-6 p-4 bg-amber-50 rounded-2xl border border-amber-200"><p class="text-sm text-amber-800"><strong>Dress Code:</strong> {{ $invitation->dress_code }}</p></div>
                @endif
            </div>
        </section>

        <!-- Gallery -->
        @if($invitation->galleries->count() > 0)
        <section class="py-16 px-6 bg-[#faf8f5]">
            <div class="max-w-4xl mx-auto">
                <h3 class="text-sm uppercase tracking-[0.3em] text-[var(--color-primary)] text-center mb-2">Our Moments</h3>
                <h2 class="text-3xl font-serif font-bold text-[var(--color-secondary)] text-center mb-12">Galeri</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($invitation->galleries as $photo)
                    <div class="aspect-square rounded-2xl overflow-hidden"><img src="{{ $photo->getImageUrl() }}" alt="{{ $photo->caption }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500"></div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- RSVP -->
        <section class="py-16 px-6 bg-white">
            <div class="max-w-lg mx-auto">
                <h3 class="text-sm uppercase tracking-[0.3em] text-[var(--color-primary)] text-center mb-2">Konfirmasi</h3>
                <h2 class="text-3xl font-serif font-bold text-[var(--color-secondary)] text-center mb-8">RSVP</h2>
                @if(session('success'))<div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl text-center text-sm">{{ session('success') }}</div>@endif
                <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" class="space-y-4">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Anda" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[var(--color-primary)] focus:border-transparent">
                    <select name="rsvp_status" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[var(--color-primary)] focus:border-transparent">
                        <option value="">Konfirmasi Kehadiran</option><option value="attending">Hadir</option><option value="not_attending">Tidak Hadir</option><option value="maybe">Masih Ragu</option>
                    </select>
                    <input type="number" name="number_of_guests" min="1" max="10" value="1" placeholder="Jumlah Tamu" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[var(--color-primary)] focus:border-transparent">
                    <button type="submit" class="w-full py-3 bg-[var(--color-primary)] text-[var(--color-secondary)] font-semibold rounded-xl hover:opacity-90 transition">Kirim Konfirmasi</button>
                </form>
            </div>
        </section>

        <!-- Guestbook -->
        <section class="py-16 px-6 bg-[#faf8f5]">
            <div class="max-w-lg mx-auto">
                <h3 class="text-sm uppercase tracking-[0.3em] text-[var(--color-primary)] text-center mb-2">Wishes</h3>
                <h2 class="text-3xl font-serif font-bold text-[var(--color-secondary)] text-center mb-8">Ucapan & Doa</h2>
                <form method="POST" action="{{ route('invitation.guestbook', $invitation->slug) }}" class="space-y-4 mb-8">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Anda" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[var(--color-primary)] focus:border-transparent">
                    <textarea name="message" rows="3" placeholder="Tulis ucapan dan doa untuk kedua mempelai..." required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[var(--color-primary)] focus:border-transparent"></textarea>
                    <button type="submit" class="w-full py-3 bg-[var(--color-secondary)] text-white font-semibold rounded-xl hover:opacity-90 transition">Kirim Ucapan</button>
                </form>
                <div class="space-y-4 max-h-96 overflow-y-auto">
                    @foreach($invitation->guestbooks as $msg)
                    <div class="bg-white rounded-2xl p-4 border border-gray-100">
                        <p class="font-medium text-[var(--color-secondary)] text-sm">{{ $msg->name }}</p>
                        <p class="text-gray-600 text-sm mt-1">{{ $msg->message }}</p>
                        <p class="text-xs text-gray-400 mt-2">{{ $msg->created_at->diffForHumans() }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Digital Envelope -->
        @if($invitation->bank_name || $invitation->qris_image)
        <section class="py-16 px-6 bg-white">
            <div class="max-w-lg mx-auto text-center">
                <h3 class="text-sm uppercase tracking-[0.3em] text-[var(--color-primary)] mb-2">Wedding Gift</h3>
                <h2 class="text-3xl font-serif font-bold text-[var(--color-secondary)] mb-8">Amplop Digital</h2>
                @if($invitation->gift_info)<p class="text-gray-600 mb-8">{{ $invitation->gift_info }}</p>@endif
                @if($invitation->bank_name)
                <div class="bg-[#faf8f5] rounded-2xl p-6 border border-[var(--color-primary)]/10 mb-4">
                    <p class="text-sm text-gray-500 mb-1">{{ $invitation->bank_name }}</p>
                    <p class="text-xl font-bold text-[var(--color-secondary)]">{{ $invitation->bank_account_number }}</p>
                    <p class="text-sm text-gray-500">a.n. {{ $invitation->bank_account_name }}</p>
                </div>
                @endif
                @if($invitation->qris_image)
                <div class="inline-block bg-white p-4 rounded-2xl border border-gray-200"><img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS" class="w-48 h-48 object-contain mx-auto"></div>
                @endif
            </div>
        </section>
        @endif

        <!-- Closing -->
        @if($invitation->closing_text)
        <section class="py-16 px-6 bg-[var(--color-secondary)] text-white text-center">
            <div class="max-w-2xl mx-auto">
                <p class="text-white/80 leading-relaxed italic text-lg mb-8">{{ $invitation->closing_text }}</p>
                <h3 class="text-2xl font-serif font-bold text-[var(--color-primary)]">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</h3>
            </div>
        </section>
        @endif

        <!-- Footer -->
        <footer class="py-8 px-6 bg-[#faf8f5] text-center">
            <p class="text-xs text-gray-400">Powered by <a href="{{ url('/') }}" class="text-[var(--color-primary)] hover:underline">UndanganDigital</a></p>
        </footer>
    </div>

    <!-- Music Player -->
    @if($invitation->music_url)
    <div class="fixed bottom-6 right-6 z-40" x-show="opened">
        <button @click="toggleMusic()" class="w-12 h-12 bg-[var(--color-primary)] text-[var(--color-secondary)] rounded-full shadow-lg flex items-center justify-center hover:opacity-90 transition" :class="{ 'animate-spin-slow': playing }">
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
