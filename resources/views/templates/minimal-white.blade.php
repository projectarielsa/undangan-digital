<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --color-primary: {{ $invitation->color_primary ?? '#2d2d2d' }}; --color-secondary: {{ $invitation->color_secondary ?? '#ffffff' }}; --color-accent: {{ $invitation->color_accent ?? '#f5f5f5' }}; }
        .font-serif { font-family: 'Cormorant Garamond', serif; }
        .font-sans { font-family: 'Montserrat', sans-serif; }
        [x-cloak] { display: none !important; }
        .line-decoration::before, .line-decoration::after { content: ''; display: inline-block; width: 60px; height: 1px; background: var(--color-primary); vertical-align: middle; margin: 0 15px; opacity: 0.3; }
    </style>
</head>
<body class="font-sans bg-white text-gray-800 overflow-x-hidden" x-data="invitationApp()" x-cloak>

    <!-- Opening Cover -->
    <section x-show="!opened" class="fixed inset-0 z-50 flex items-center justify-center bg-white" x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="text-center px-6">
            <p class="text-xs uppercase tracking-[0.4em] text-gray-400 mb-8 font-sans">The Wedding of</p>
            <h1 class="text-5xl sm:text-7xl font-serif font-light text-[var(--color-primary)] mb-2">{{ $invitation->groom_name }}</h1>
            <p class="text-3xl font-serif italic text-gray-300 my-4">&</p>
            <h1 class="text-5xl sm:text-7xl font-serif font-light text-[var(--color-primary)] mb-10">{{ $invitation->bride_name }}</h1>
            @if($guestName)
            <p class="text-xs uppercase tracking-[0.2em] text-gray-400 mb-2">Kepada Yth.</p>
            <p class="text-base font-medium text-gray-700 mb-10">{{ urldecode($guestName) }}</p>
            @endif
            <button @click="openInvitation()" class="px-10 py-3 border border-[var(--color-primary)] text-[var(--color-primary)] text-xs uppercase tracking-[0.2em] hover:bg-[var(--color-primary)] hover:text-white transition-all duration-300">
                Buka Undangan
            </button>
        </div>
    </section>

    <!-- Main Content -->
    <div x-show="opened" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">

        <!-- Hero -->
        <section class="min-h-screen flex items-center justify-center py-20 px-6">
            <div class="text-center max-w-xl">
                <p class="text-xs uppercase tracking-[0.4em] text-gray-400 mb-8">We Are Getting Married</p>
                <h2 class="text-6xl sm:text-8xl font-serif font-light text-[var(--color-primary)] leading-tight">{{ $invitation->groom_name }}</h2>
                <p class="text-4xl font-serif italic text-gray-300 my-6">&</p>
                <h2 class="text-6xl sm:text-8xl font-serif font-light text-[var(--color-primary)] leading-tight">{{ $invitation->bride_name }}</h2>
                <div class="mt-12">
                    <div class="w-px h-16 bg-gray-200 mx-auto mb-6"></div>
                    <p class="text-sm text-gray-500 tracking-wide">{{ $invitation->event_date->translatedFormat('d . m . Y') }}</p>
                </div>
            </div>
        </section>

        <!-- Opening Text -->
        @if($invitation->opening_text)
        <section class="py-20 px-6 bg-[var(--color-accent)]">
            <div class="max-w-xl mx-auto text-center">
                <p class="text-gray-500 leading-loose text-base font-light italic font-serif text-lg">{{ $invitation->opening_text }}</p>
            </div>
        </section>
        @endif

        <!-- Couple -->
        <section class="py-24 px-6">
            <div class="max-w-4xl mx-auto grid md:grid-cols-2 gap-16">
                <div class="text-center">
                    @if($invitation->groom_photo)
                    <div class="w-56 h-56 mx-auto mb-8 overflow-hidden">
                        <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700">
                    </div>
                    @endif
                    <h3 class="text-3xl font-serif text-[var(--color-primary)]">{{ $invitation->groom_name }}</h3>
                    @if($invitation->groom_father || $invitation->groom_mother)
                    <p class="text-sm text-gray-400 mt-3">Putra dari Bapak {{ $invitation->groom_father }} & Ibu {{ $invitation->groom_mother }}</p>
                    @endif
                    @if($invitation->groom_instagram)
                    <a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" target="_blank" class="inline-block mt-3 text-xs text-gray-400 hover:text-[var(--color-primary)] transition">{{ $invitation->groom_instagram }}</a>
                    @endif
                </div>
                <div class="text-center">
                    @if($invitation->bride_photo)
                    <div class="w-56 h-56 mx-auto mb-8 overflow-hidden">
                        <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700">
                    </div>
                    @endif
                    <h3 class="text-3xl font-serif text-[var(--color-primary)]">{{ $invitation->bride_name }}</h3>
                    @if($invitation->bride_father || $invitation->bride_mother)
                    <p class="text-sm text-gray-400 mt-3">Putri dari Bapak {{ $invitation->bride_father }} & Ibu {{ $invitation->bride_mother }}</p>
                    @endif
                    @if($invitation->bride_instagram)
                    <a href="https://instagram.com/{{ ltrim($invitation->bride_instagram, '@') }}" target="_blank" class="inline-block mt-3 text-xs text-gray-400 hover:text-[var(--color-primary)] transition">{{ $invitation->bride_instagram }}</a>
                    @endif
                </div>
            </div>
        </section>

        <!-- Countdown -->
        <section class="py-20 px-6 bg-[var(--color-accent)]">
            <div class="max-w-2xl mx-auto text-center">
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400 mb-10">Counting Down</p>
                <div class="grid grid-cols-4 gap-6" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">
                    <div><p class="text-4xl sm:text-5xl font-serif font-light text-[var(--color-primary)]" x-text="days">0</p><p class="text-[10px] uppercase tracking-[0.2em] text-gray-400 mt-2">Hari</p></div>
                    <div><p class="text-4xl sm:text-5xl font-serif font-light text-[var(--color-primary)]" x-text="hours">0</p><p class="text-[10px] uppercase tracking-[0.2em] text-gray-400 mt-2">Jam</p></div>
                    <div><p class="text-4xl sm:text-5xl font-serif font-light text-[var(--color-primary)]" x-text="minutes">0</p><p class="text-[10px] uppercase tracking-[0.2em] text-gray-400 mt-2">Menit</p></div>
                    <div><p class="text-4xl sm:text-5xl font-serif font-light text-[var(--color-primary)]" x-text="seconds">0</p><p class="text-[10px] uppercase tracking-[0.2em] text-gray-400 mt-2">Detik</p></div>
                </div>
            </div>
        </section>

        <!-- Event Details -->
        <section class="py-24 px-6">
            <div class="max-w-2xl mx-auto text-center">
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400 mb-4">Save The Date</p>
                <h2 class="text-4xl font-serif font-light text-[var(--color-primary)] mb-16">Waktu & Tempat</h2>
                <div class="space-y-3">
                    <h4 class="text-xl font-serif text-[var(--color-primary)]">{{ $invitation->event_venue }}</h4>
                    <p class="text-sm text-gray-500">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                    <p class="text-sm text-gray-500">Pukul {{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }} {{ $invitation->event_time_end ? '- ' . \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') : '' }} WIB</p>
                    @if($invitation->event_address)<p class="text-sm text-gray-400 mt-4">{{ $invitation->event_address }}</p>@endif
                </div>
                @if($invitation->event_maps_url)
                <a href="{{ $invitation->event_maps_url }}" target="_blank" class="inline-block mt-8 px-8 py-2.5 border border-gray-300 text-xs uppercase tracking-[0.15em] text-gray-500 hover:border-[var(--color-primary)] hover:text-[var(--color-primary)] transition-all">
                    Buka Maps
                </a>
                @endif
                @if($invitation->dress_code)
                <div class="mt-10 py-4 border-t border-b border-gray-100"><p class="text-xs text-gray-400"><span class="uppercase tracking-wider">Dress Code:</span> {{ $invitation->dress_code }}</p></div>
                @endif
            </div>
        </section>

        <!-- Gallery -->
        @if($invitation->galleries->count() > 0)
        <section class="py-20 px-6 bg-[var(--color-accent)]">
            <div class="max-w-5xl mx-auto">
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400 text-center mb-4">Our Moments</p>
                <h2 class="text-4xl font-serif font-light text-[var(--color-primary)] text-center mb-14">Galeri</h2>
                <div class="columns-2 md:columns-3 gap-4 space-y-4">
                    @foreach($invitation->galleries as $photo)
                    <div class="break-inside-avoid overflow-hidden">
                        <img src="{{ $photo->getImageUrl() }}" alt="{{ $photo->caption }}" class="w-full object-cover hover:scale-105 transition-transform duration-700">
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- RSVP -->
        <section class="py-24 px-6">
            <div class="max-w-md mx-auto">
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400 text-center mb-4">Konfirmasi</p>
                <h2 class="text-4xl font-serif font-light text-[var(--color-primary)] text-center mb-12">RSVP</h2>
                @if(session('success'))<div class="mb-6 p-4 bg-green-50 text-green-700 text-sm text-center">{{ session('success') }}</div>@endif
                <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" class="space-y-5">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Lengkap" required class="w-full px-0 py-3 bg-transparent border-0 border-b border-gray-200 text-sm focus:ring-0 focus:border-[var(--color-primary)] placeholder-gray-300">
                    <select name="rsvp_status" required class="w-full px-0 py-3 bg-transparent border-0 border-b border-gray-200 text-sm focus:ring-0 focus:border-[var(--color-primary)] text-gray-500">
                        <option value="">Konfirmasi Kehadiran</option><option value="attending">Hadir</option><option value="not_attending">Tidak Hadir</option><option value="maybe">Masih Ragu</option>
                    </select>
                    <input type="number" name="number_of_guests" min="1" max="10" value="1" class="w-full px-0 py-3 bg-transparent border-0 border-b border-gray-200 text-sm focus:ring-0 focus:border-[var(--color-primary)]">
                    <button type="submit" class="w-full py-3 mt-4 border border-[var(--color-primary)] text-[var(--color-primary)] text-xs uppercase tracking-[0.2em] hover:bg-[var(--color-primary)] hover:text-white transition-all duration-300">Kirim</button>
                </form>
            </div>
        </section>

        <!-- Guestbook -->
        <section class="py-20 px-6 bg-[var(--color-accent)]">
            <div class="max-w-md mx-auto">
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400 text-center mb-4">Wishes</p>
                <h2 class="text-4xl font-serif font-light text-[var(--color-primary)] text-center mb-12">Ucapan</h2>
                <form method="POST" action="{{ route('invitation.guestbook', $invitation->slug) }}" class="space-y-5 mb-12">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Anda" required class="w-full px-0 py-3 bg-transparent border-0 border-b border-gray-200 text-sm focus:ring-0 focus:border-[var(--color-primary)] placeholder-gray-300">
                    <textarea name="message" rows="3" placeholder="Tulis ucapan & doa..." required class="w-full px-0 py-3 bg-transparent border-0 border-b border-gray-200 text-sm focus:ring-0 focus:border-[var(--color-primary)] placeholder-gray-300 resize-none"></textarea>
                    <button type="submit" class="w-full py-3 bg-[var(--color-primary)] text-white text-xs uppercase tracking-[0.2em] hover:opacity-80 transition">Kirim Ucapan</button>
                </form>
                <div class="space-y-6 max-h-80 overflow-y-auto">
                    @foreach($invitation->guestbooks as $msg)
                    <div class="border-b border-gray-100 pb-4">
                        <p class="text-sm font-medium text-[var(--color-primary)]">{{ $msg->name }}</p>
                        <p class="text-sm text-gray-500 mt-1 leading-relaxed">{{ $msg->message }}</p>
                        <p class="text-[10px] text-gray-300 mt-2">{{ $msg->created_at->diffForHumans() }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Digital Envelope -->
        @if($invitation->bank_name || $invitation->qris_image)
        <section class="py-24 px-6">
            <div class="max-w-md mx-auto text-center">
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400 mb-4">Wedding Gift</p>
                <h2 class="text-4xl font-serif font-light text-[var(--color-primary)] mb-12">Amplop Digital</h2>
                @if($invitation->gift_info)<p class="text-sm text-gray-400 mb-8">{{ $invitation->gift_info }}</p>@endif
                @if($invitation->bank_name)
                <div class="border border-gray-100 p-8 mb-6">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-2">{{ $invitation->bank_name }}</p>
                    <p class="text-2xl font-serif text-[var(--color-primary)]">{{ $invitation->bank_account_number }}</p>
                    <p class="text-xs text-gray-400 mt-2">a.n. {{ $invitation->bank_account_name }}</p>
                </div>
                @endif
                @if($invitation->qris_image)
                <div class="inline-block border border-gray-100 p-6"><img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS" class="w-44 h-44 object-contain"></div>
                @endif
            </div>
        </section>
        @endif

        <!-- Closing -->
        @if($invitation->closing_text)
        <section class="py-20 px-6 bg-[var(--color-accent)]">
            <div class="max-w-xl mx-auto text-center">
                <p class="text-gray-500 leading-loose font-light italic font-serif text-lg mb-8">{{ $invitation->closing_text }}</p>
                <h3 class="text-2xl font-serif text-[var(--color-primary)]">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</h3>
            </div>
        </section>
        @endif

        <!-- Footer -->
        <footer class="py-8 px-6 text-center border-t border-gray-50">
            <p class="text-[10px] uppercase tracking-[0.2em] text-gray-300">Powered by <a href="{{ url('/') }}" class="hover:text-[var(--color-primary)] transition">UndanganDigital</a></p>
        </footer>
    </div>

    <!-- Music Player -->
    @if($invitation->music_url)
    <div class="fixed bottom-6 right-6 z-40" x-show="opened">
        <button @click="toggleMusic()" class="w-10 h-10 border border-[var(--color-primary)] text-[var(--color-primary)] rounded-full flex items-center justify-center hover:bg-[var(--color-primary)] hover:text-white transition-all duration-300">
            <svg x-show="!playing" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/></svg>
            <svg x-show="playing" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z"/></svg>
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
