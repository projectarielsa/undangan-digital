<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --color-primary: {{ $invitation->color_primary ?? '#8B4513' }}; --color-secondary: {{ $invitation->color_secondary ?? '#FFF8F0' }}; --color-accent: {{ $invitation->color_accent ?? '#FFE4E1' }}; }
        .font-script { font-family: 'Great Vibes', cursive; }
        .font-sans { font-family: 'Open Sans', sans-serif; }
        [x-cloak] { display: none !important; }
        .floral-border { position: relative; }
        .floral-border::before { content: ''; position: absolute; top: -2px; left: 50%; transform: translateX(-50%); width: 200px; height: 60px; background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 60'%3E%3Cpath d='M100 5 C80 5 60 20 40 15 C20 10 10 20 5 30 C10 40 20 50 40 45 C60 40 80 55 100 55 C120 55 140 40 160 45 C180 50 190 40 195 30 C190 20 180 10 160 15 C140 20 120 5 100 5Z' fill='none' stroke='%238B4513' stroke-width='0.5' opacity='0.3'/%3E%3C/svg%3E") no-repeat center; }
        .floral-corner-tl { position: relative; }
        .floral-corner-tl::before { content: ''; position: absolute; top: 0; left: 0; width: 80px; height: 80px; border-top: 1px solid var(--color-primary); border-left: 1px solid var(--color-primary); opacity: 0.3; border-radius: 0; }
        .floral-corner-br { position: relative; }
        .floral-corner-br::after { content: ''; position: absolute; bottom: 0; right: 0; width: 80px; height: 80px; border-bottom: 1px solid var(--color-primary); border-right: 1px solid var(--color-primary); opacity: 0.3; }
        .petal-bg { background-image: radial-gradient(ellipse at 20% 20%, rgba(255,228,225,0.4) 0%, transparent 50%), radial-gradient(ellipse at 80% 80%, rgba(255,228,225,0.4) 0%, transparent 50%), radial-gradient(ellipse at 50% 50%, rgba(255,248,240,0.8) 0%, transparent 70%); }
        .rose-shadow { box-shadow: 0 10px 40px rgba(139,69,19,0.08); }
    </style>
</head>
<body class="font-sans bg-[var(--color-secondary)] text-gray-700 overflow-x-hidden" x-data="invitationApp()" x-cloak>

    <!-- Opening Cover -->
    <section x-show="!opened" class="fixed inset-0 z-50 flex items-center justify-center petal-bg" x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="text-center px-6">
            <p class="text-sm text-[var(--color-primary)] opacity-70 mb-4 tracking-wider">The Wedding of</p>
            <h1 class="text-5xl sm:text-7xl font-script text-[var(--color-primary)] mb-2">{{ $invitation->groom_name }}</h1>
            <p class="text-3xl font-script text-[var(--color-primary)] opacity-60 my-3">&</p>
            <h1 class="text-5xl sm:text-7xl font-script text-[var(--color-primary)] mb-8">{{ $invitation->bride_name }}</h1>
            @if($guestName)
            <p class="text-xs text-gray-500 mb-1">Kepada Yth.</p>
            <p class="text-sm font-medium text-gray-700 mb-8">{{ urldecode($guestName) }}</p>
            @endif
            <button @click="openInvitation()" class="px-10 py-3 bg-[var(--color-primary)] text-white rounded-full text-sm hover:shadow-lg hover:shadow-[var(--color-primary)]/20 transition-all duration-300 transform hover:scale-105">
                Buka Undangan
            </button>
        </div>
    </section>

    <!-- Main Content -->
    <div x-show="opened" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

        <!-- Hero -->
        <section class="min-h-screen flex items-center justify-center py-20 px-6 petal-bg relative floral-corner-tl floral-corner-br">
            <div class="text-center max-w-lg relative z-10">
                <p class="text-xs text-[var(--color-primary)] opacity-70 tracking-[0.3em] uppercase mb-6">We're Getting Married</p>
                <h2 class="text-6xl sm:text-8xl font-script text-[var(--color-primary)] leading-tight">{{ $invitation->groom_name }}</h2>
                <p class="text-4xl font-script text-[var(--color-primary)] opacity-50 my-4">&</p>
                <h2 class="text-6xl sm:text-8xl font-script text-[var(--color-primary)] leading-tight">{{ $invitation->bride_name }}</h2>
                <div class="mt-10">
                    <div class="flex items-center justify-center gap-4">
                        <div class="w-12 h-px bg-[var(--color-primary)] opacity-30"></div>
                        <svg class="w-5 h-5 text-[var(--color-primary)] opacity-50" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                        <div class="w-12 h-px bg-[var(--color-primary)] opacity-30"></div>
                    </div>
                    <p class="text-sm text-gray-500 mt-4">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>
        </section>

        <!-- Opening Text -->
        @if($invitation->opening_text)
        <section class="py-16 px-6 bg-[var(--color-accent)]/30">
            <div class="max-w-xl mx-auto text-center">
                <svg class="w-8 h-8 text-[var(--color-primary)] opacity-40 mx-auto mb-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                <p class="text-gray-600 leading-relaxed italic text-base">{{ $invitation->opening_text }}</p>
            </div>
        </section>
        @endif

        <!-- Couple -->
        <section class="py-20 px-6 bg-[var(--color-secondary)]">
            <div class="max-w-4xl mx-auto grid md:grid-cols-2 gap-12">
                <div class="text-center">
                    @if($invitation->groom_photo)
                    <div class="w-52 h-52 mx-auto mb-6 rounded-full overflow-hidden border-4 border-[var(--color-accent)] rose-shadow">
                        <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}" class="w-full h-full object-cover">
                    </div>
                    @endif
                    <h3 class="text-3xl font-script text-[var(--color-primary)]">{{ $invitation->groom_name }}</h3>
                    @if($invitation->groom_father || $invitation->groom_mother)
                    <p class="text-sm text-gray-500 mt-3">Putra dari Bapak {{ $invitation->groom_father }} & Ibu {{ $invitation->groom_mother }}</p>
                    @endif
                    @if($invitation->groom_instagram)
                    <a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" target="_blank" class="inline-block mt-3 text-xs text-[var(--color-primary)] hover:underline">{{ $invitation->groom_instagram }}</a>
                    @endif
                </div>
                <div class="text-center">
                    @if($invitation->bride_photo)
                    <div class="w-52 h-52 mx-auto mb-6 rounded-full overflow-hidden border-4 border-[var(--color-accent)] rose-shadow">
                        <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}" class="w-full h-full object-cover">
                    </div>
                    @endif
                    <h3 class="text-3xl font-script text-[var(--color-primary)]">{{ $invitation->bride_name }}</h3>
                    @if($invitation->bride_father || $invitation->bride_mother)
                    <p class="text-sm text-gray-500 mt-3">Putri dari Bapak {{ $invitation->bride_father }} & Ibu {{ $invitation->bride_mother }}</p>
                    @endif
                    @if($invitation->bride_instagram)
                    <a href="https://instagram.com/{{ ltrim($invitation->bride_instagram, '@') }}" target="_blank" class="inline-block mt-3 text-xs text-[var(--color-primary)] hover:underline">{{ $invitation->bride_instagram }}</a>
                    @endif
                </div>
            </div>
        </section>

        <!-- Countdown -->
        <section class="py-16 px-6 bg-[var(--color-accent)]/40">
            <div class="max-w-2xl mx-auto text-center">
                <h3 class="text-3xl font-script text-[var(--color-primary)] mb-10">Menghitung Hari</h3>
                <div class="grid grid-cols-4 gap-4" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">
                    <div class="bg-white rounded-2xl p-5 rose-shadow">
                        <p class="text-3xl sm:text-4xl font-script text-[var(--color-primary)]" x-text="days">0</p>
                        <p class="text-[10px] uppercase tracking-wider text-gray-400 mt-1">Hari</p>
                    </div>
                    <div class="bg-white rounded-2xl p-5 rose-shadow">
                        <p class="text-3xl sm:text-4xl font-script text-[var(--color-primary)]" x-text="hours">0</p>
                        <p class="text-[10px] uppercase tracking-wider text-gray-400 mt-1">Jam</p>
                    </div>
                    <div class="bg-white rounded-2xl p-5 rose-shadow">
                        <p class="text-3xl sm:text-4xl font-script text-[var(--color-primary)]" x-text="minutes">0</p>
                        <p class="text-[10px] uppercase tracking-wider text-gray-400 mt-1">Menit</p>
                    </div>
                    <div class="bg-white rounded-2xl p-5 rose-shadow">
                        <p class="text-3xl sm:text-4xl font-script text-[var(--color-primary)]" x-text="seconds">0</p>
                        <p class="text-[10px] uppercase tracking-wider text-gray-400 mt-1">Detik</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Event Details -->
        <section class="py-20 px-6 bg-[var(--color-secondary)]">
            <div class="max-w-2xl mx-auto text-center">
                <h3 class="text-3xl font-script text-[var(--color-primary)] mb-2">Waktu & Tempat</h3>
                <p class="text-xs text-gray-400 uppercase tracking-[0.2em] mb-12">Save The Date</p>
                <div class="bg-white rounded-3xl p-10 rose-shadow floral-corner-tl floral-corner-br">
                    <h4 class="text-lg font-semibold text-[var(--color-primary)]">{{ $invitation->event_venue }}</h4>
                    <div class="flex items-center justify-center gap-3 my-4">
                        <div class="w-8 h-px bg-[var(--color-primary)] opacity-30"></div>
                        <svg class="w-3 h-3 text-[var(--color-primary)] opacity-50" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                        <div class="w-8 h-px bg-[var(--color-primary)] opacity-30"></div>
                    </div>
                    <p class="text-sm text-gray-600">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                    <p class="text-sm text-gray-600 mt-1">Pukul {{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }} {{ $invitation->event_time_end ? '- ' . \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') : '' }} WIB</p>
                    @if($invitation->event_address)<p class="text-xs text-gray-400 mt-4">{{ $invitation->event_address }}</p>@endif
                    @if($invitation->event_maps_url)
                    <a href="{{ $invitation->event_maps_url }}" target="_blank" class="inline-flex items-center gap-2 mt-6 px-6 py-2.5 bg-[var(--color-primary)] text-white rounded-full text-xs hover:shadow-lg transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Buka Maps
                    </a>
                    @endif
                </div>
                @if($invitation->dress_code)
                <div class="mt-6 bg-[var(--color-accent)]/50 rounded-2xl p-4"><p class="text-xs text-gray-600"><span class="font-medium text-[var(--color-primary)]">Dress Code:</span> {{ $invitation->dress_code }}</p></div>
                @endif
            </div>
        </section>

        <!-- Gallery -->
        @if($invitation->galleries->count() > 0)
        <section class="py-16 px-6 bg-[var(--color-accent)]/30">
            <div class="max-w-4xl mx-auto">
                <h3 class="text-3xl font-script text-[var(--color-primary)] text-center mb-2">Galeri Kami</h3>
                <p class="text-xs text-gray-400 uppercase tracking-[0.2em] text-center mb-12">Our Moments</p>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($invitation->galleries as $photo)
                    <div class="aspect-square rounded-2xl overflow-hidden rose-shadow">
                        <img src="{{ $photo->getImageUrl() }}" alt="{{ $photo->caption }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- RSVP -->
        <section class="py-20 px-6 bg-[var(--color-secondary)]">
            <div class="max-w-md mx-auto">
                <h3 class="text-3xl font-script text-[var(--color-primary)] text-center mb-2">Konfirmasi Kehadiran</h3>
                <p class="text-xs text-gray-400 uppercase tracking-[0.2em] text-center mb-10">RSVP</p>
                @if(session('success'))<div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 text-sm text-center rounded-2xl">{{ session('success') }}</div>@endif
                <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" class="space-y-4 bg-white rounded-3xl p-8 rose-shadow">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Lengkap" required class="w-full px-4 py-3 bg-[var(--color-secondary)] border border-[var(--color-accent)] rounded-xl text-sm focus:ring-2 focus:ring-[var(--color-primary)]/30 focus:border-[var(--color-primary)] placeholder-gray-400">
                    <select name="rsvp_status" required class="w-full px-4 py-3 bg-[var(--color-secondary)] border border-[var(--color-accent)] rounded-xl text-sm text-gray-600 focus:ring-2 focus:ring-[var(--color-primary)]/30 focus:border-[var(--color-primary)]">
                        <option value="">Konfirmasi Kehadiran</option><option value="attending">Hadir</option><option value="not_attending">Tidak Hadir</option><option value="maybe">Masih Ragu</option>
                    </select>
                    <input type="number" name="number_of_guests" min="1" max="10" value="1" class="w-full px-4 py-3 bg-[var(--color-secondary)] border border-[var(--color-accent)] rounded-xl text-sm focus:ring-2 focus:ring-[var(--color-primary)]/30 focus:border-[var(--color-primary)]">
                    <button type="submit" class="w-full py-3 bg-[var(--color-primary)] text-white rounded-xl text-sm font-medium hover:shadow-lg transition-all">Kirim Konfirmasi</button>
                </form>
            </div>
        </section>

        <!-- Guestbook -->
        <section class="py-16 px-6 bg-[var(--color-accent)]/30">
            <div class="max-w-md mx-auto">
                <h3 class="text-3xl font-script text-[var(--color-primary)] text-center mb-2">Ucapan & Doa</h3>
                <p class="text-xs text-gray-400 uppercase tracking-[0.2em] text-center mb-10">Wishes</p>
                <form method="POST" action="{{ route('invitation.guestbook', $invitation->slug) }}" class="space-y-4 bg-white rounded-3xl p-8 rose-shadow mb-8">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Anda" required class="w-full px-4 py-3 bg-[var(--color-secondary)] border border-[var(--color-accent)] rounded-xl text-sm focus:ring-2 focus:ring-[var(--color-primary)]/30 focus:border-[var(--color-primary)] placeholder-gray-400">
                    <textarea name="message" rows="3" placeholder="Tulis ucapan & doa untuk kedua mempelai..." required class="w-full px-4 py-3 bg-[var(--color-secondary)] border border-[var(--color-accent)] rounded-xl text-sm focus:ring-2 focus:ring-[var(--color-primary)]/30 focus:border-[var(--color-primary)] placeholder-gray-400 resize-none"></textarea>
                    <button type="submit" class="w-full py-3 bg-[var(--color-primary)] text-white rounded-xl text-sm font-medium hover:shadow-lg transition-all">Kirim Ucapan</button>
                </form>
                <div class="space-y-4 max-h-80 overflow-y-auto">
                    @foreach($invitation->guestbooks as $msg)
                    <div class="bg-white rounded-2xl p-4 rose-shadow">
                        <p class="text-sm font-medium text-[var(--color-primary)]">{{ $msg->name }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $msg->message }}</p>
                        <p class="text-[10px] text-gray-400 mt-2">{{ $msg->created_at->diffForHumans() }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Digital Envelope -->
        @if($invitation->bank_name || $invitation->qris_image)
        <section class="py-20 px-6 bg-[var(--color-secondary)]">
            <div class="max-w-md mx-auto text-center">
                <h3 class="text-3xl font-script text-[var(--color-primary)] mb-2">Amplop Digital</h3>
                <p class="text-xs text-gray-400 uppercase tracking-[0.2em] mb-10">Wedding Gift</p>
                @if($invitation->gift_info)<p class="text-sm text-gray-500 mb-8">{{ $invitation->gift_info }}</p>@endif
                @if($invitation->bank_name)
                <div class="bg-white rounded-2xl p-8 rose-shadow mb-6">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-2">{{ $invitation->bank_name }}</p>
                    <p class="text-xl font-semibold text-[var(--color-primary)]">{{ $invitation->bank_account_number }}</p>
                    <p class="text-xs text-gray-500 mt-2">a.n. {{ $invitation->bank_account_name }}</p>
                </div>
                @endif
                @if($invitation->qris_image)
                <div class="inline-block bg-white p-5 rounded-2xl rose-shadow"><img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS" class="w-44 h-44 object-contain"></div>
                @endif
            </div>
        </section>
        @endif

        <!-- Closing -->
        @if($invitation->closing_text)
        <section class="py-16 px-6 bg-[var(--color-accent)]/30 petal-bg">
            <div class="max-w-xl mx-auto text-center">
                <svg class="w-8 h-8 text-[var(--color-primary)] opacity-30 mx-auto mb-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                <p class="text-gray-600 leading-relaxed italic text-base mb-8">{{ $invitation->closing_text }}</p>
                <h3 class="text-2xl font-script text-[var(--color-primary)]">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</h3>
            </div>
        </section>
        @endif

        <!-- Footer -->
        <footer class="py-8 px-6 bg-[var(--color-secondary)] text-center border-t border-[var(--color-accent)]">
            <p class="text-[10px] text-gray-400">Powered by <a href="{{ url('/') }}" class="text-[var(--color-primary)] hover:underline">UndanganDigital</a></p>
        </footer>
    </div>

    <!-- Music Player -->
    @if($invitation->music_url)
    <div class="fixed bottom-6 right-6 z-40" x-show="opened">
        <button @click="toggleMusic()" class="w-12 h-12 bg-[var(--color-primary)] text-white rounded-full shadow-lg flex items-center justify-center hover:shadow-xl transition-all duration-300">
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
