<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --color-primary: {{ $invitation->color_primary ?? '#1B5E20' }}; --color-secondary: {{ $invitation->color_secondary ?? '#F5F5DC' }}; --color-accent: {{ $invitation->color_accent ?? '#E8F5E9' }}; }
        .font-arabic { font-family: 'Amiri', serif; }
        .font-sans { font-family: 'Poppins', sans-serif; }
        [x-cloak] { display: none !important; }
        .geometric-pattern { background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%231B5E20' fill-opacity='0.03'%3E%3Cpath d='M30 0l30 30-30 30L0 30z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); }
        .ornament-top { position: relative; }
        .ornament-top::before { content: ''; position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 120px; height: 40px; background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 120 40'%3E%3Cpath d='M60 5 C45 5 35 15 20 15 C10 15 5 10 0 8 L0 0 L120 0 L120 8 C115 10 110 15 100 15 C85 15 75 5 60 5Z' fill='%231B5E20' opacity='0.08'/%3E%3C/svg%3E") no-repeat center; }
        .islamic-border { border: 1px solid rgba(27,94,32,0.15); position: relative; }
        .islamic-border::before, .islamic-border::after { content: ''; position: absolute; width: 20px; height: 20px; border: 1px solid var(--color-primary); opacity: 0.3; }
        .islamic-border::before { top: -1px; left: -1px; border-right: none; border-bottom: none; }
        .islamic-border::after { bottom: -1px; right: -1px; border-left: none; border-top: none; }
    </style>
</head>
<body class="font-sans bg-[var(--color-secondary)] text-gray-700 overflow-x-hidden" x-data="invitationApp()" x-cloak>

    <!-- Opening Cover -->
    <section x-show="!opened" class="fixed inset-0 z-50 flex items-center justify-center bg-[var(--color-secondary)] geometric-pattern" x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="text-center px-6">
            <p class="font-arabic text-2xl text-[var(--color-primary)] mb-6">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ</p>
            <p class="text-xs text-gray-500 mb-8 tracking-wider">The Wedding of</p>
            <h1 class="text-4xl sm:text-6xl font-arabic font-bold text-[var(--color-primary)] mb-2">{{ $invitation->groom_name }}</h1>
            <p class="text-2xl font-arabic text-[var(--color-primary)] opacity-50 my-3">&</p>
            <h1 class="text-4xl sm:text-6xl font-arabic font-bold text-[var(--color-primary)] mb-8">{{ $invitation->bride_name }}</h1>
            @if($guestName)
            <p class="text-xs text-gray-500 mb-1">Kepada Yth.</p>
            <p class="text-sm font-medium text-gray-700 mb-8">{{ urldecode($guestName) }}</p>
            @endif
            <button @click="openInvitation()" class="px-10 py-3 bg-[var(--color-primary)] text-white text-sm rounded-lg hover:bg-[var(--color-primary)]/90 transition-all duration-300 shadow-lg shadow-[var(--color-primary)]/20">
                Buka Undangan
            </button>
        </div>
    </section>

    <!-- Main Content -->
    <div x-show="opened" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

        <!-- Bismillah & Hero -->
        <section class="min-h-screen flex items-center justify-center py-20 px-6 geometric-pattern">
            <div class="text-center max-w-lg">
                <p class="font-arabic text-xl text-[var(--color-primary)] mb-4">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ</p>
                <p class="text-xs text-gray-500 italic mb-10">Dengan menyebut nama Allah Yang Maha Pengasih lagi Maha Penyayang</p>
                <p class="text-xs text-gray-400 uppercase tracking-[0.3em] mb-8">The Wedding of</p>
                <h2 class="text-5xl sm:text-7xl font-arabic font-bold text-[var(--color-primary)] leading-tight">{{ $invitation->groom_name }}</h2>
                <p class="text-3xl font-arabic text-[var(--color-primary)] opacity-50 my-4">&</p>
                <h2 class="text-5xl sm:text-7xl font-arabic font-bold text-[var(--color-primary)] leading-tight">{{ $invitation->bride_name }}</h2>
                <div class="mt-10 flex items-center justify-center gap-3">
                    <div class="w-12 h-px bg-[var(--color-primary)] opacity-30"></div>
                    <div class="w-2 h-2 rotate-45 border border-[var(--color-primary)] opacity-30"></div>
                    <div class="w-12 h-px bg-[var(--color-primary)] opacity-30"></div>
                </div>
                <p class="text-sm text-gray-500 mt-4">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
            </div>
        </section>

        <!-- Opening Text / Ayat -->
        @if($invitation->opening_text)
        <section class="py-16 px-6 bg-[var(--color-accent)]">
            <div class="max-w-xl mx-auto text-center">
                <div class="flex items-center justify-center gap-3 mb-6">
                    <div class="w-8 h-px bg-[var(--color-primary)] opacity-30"></div>
                    <div class="w-2 h-2 rotate-45 border border-[var(--color-primary)] opacity-40"></div>
                    <div class="w-8 h-px bg-[var(--color-primary)] opacity-30"></div>
                </div>
                <p class="text-gray-600 leading-relaxed italic text-base font-arabic text-lg">{{ $invitation->opening_text }}</p>
                <div class="flex items-center justify-center gap-3 mt-6">
                    <div class="w-8 h-px bg-[var(--color-primary)] opacity-30"></div>
                    <div class="w-2 h-2 rotate-45 border border-[var(--color-primary)] opacity-40"></div>
                    <div class="w-8 h-px bg-[var(--color-primary)] opacity-30"></div>
                </div>
            </div>
        </section>
        @endif

        <!-- Couple -->
        <section class="py-20 px-6 bg-[var(--color-secondary)] geometric-pattern">
            <div class="max-w-4xl mx-auto grid md:grid-cols-2 gap-12">
                <div class="text-center">
                    @if($invitation->groom_photo)
                    <div class="w-48 h-48 mx-auto mb-6 overflow-hidden rounded-lg islamic-border p-1">
                        <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}" class="w-full h-full object-cover rounded-md">
                    </div>
                    @endif
                    <h3 class="text-2xl font-arabic font-bold text-[var(--color-primary)]">{{ $invitation->groom_name }}</h3>
                    @if($invitation->groom_father || $invitation->groom_mother)
                    <p class="text-sm text-gray-500 mt-3">Putra dari Bapak {{ $invitation->groom_father }} & Ibu {{ $invitation->groom_mother }}</p>
                    @endif
                    @if($invitation->groom_instagram)
                    <a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" target="_blank" class="inline-block mt-3 text-xs text-[var(--color-primary)] hover:underline">{{ $invitation->groom_instagram }}</a>
                    @endif
                </div>
                <div class="text-center">
                    @if($invitation->bride_photo)
                    <div class="w-48 h-48 mx-auto mb-6 overflow-hidden rounded-lg islamic-border p-1">
                        <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}" class="w-full h-full object-cover rounded-md">
                    </div>
                    @endif
                    <h3 class="text-2xl font-arabic font-bold text-[var(--color-primary)]">{{ $invitation->bride_name }}</h3>
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
        <section class="py-16 px-6 bg-[var(--color-primary)] text-white">
            <div class="max-w-2xl mx-auto text-center">
                <p class="text-xs uppercase tracking-[0.3em] text-white/60 mb-8">Menghitung Hari</p>
                <div class="grid grid-cols-4 gap-4" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">
                    <div class="bg-white/10 rounded-lg p-4 backdrop-blur">
                        <p class="text-3xl sm:text-4xl font-arabic font-bold" x-text="days">0</p>
                        <p class="text-[10px] uppercase tracking-wider text-white/60 mt-1">Hari</p>
                    </div>
                    <div class="bg-white/10 rounded-lg p-4 backdrop-blur">
                        <p class="text-3xl sm:text-4xl font-arabic font-bold" x-text="hours">0</p>
                        <p class="text-[10px] uppercase tracking-wider text-white/60 mt-1">Jam</p>
                    </div>
                    <div class="bg-white/10 rounded-lg p-4 backdrop-blur">
                        <p class="text-3xl sm:text-4xl font-arabic font-bold" x-text="minutes">0</p>
                        <p class="text-[10px] uppercase tracking-wider text-white/60 mt-1">Menit</p>
                    </div>
                    <div class="bg-white/10 rounded-lg p-4 backdrop-blur">
                        <p class="text-3xl sm:text-4xl font-arabic font-bold" x-text="seconds">0</p>
                        <p class="text-[10px] uppercase tracking-wider text-white/60 mt-1">Detik</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Event Details -->
        <section class="py-20 px-6 bg-[var(--color-secondary)] geometric-pattern">
            <div class="max-w-2xl mx-auto text-center">
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400 mb-2">Save The Date</p>
                <h2 class="text-3xl font-arabic font-bold text-[var(--color-primary)] mb-12">Waktu & Tempat</h2>
                <div class="bg-white rounded-xl p-10 islamic-border shadow-sm">
                    <p class="font-arabic text-lg text-[var(--color-primary)] mb-4">Akad Nikah</p>
                    <h4 class="text-lg font-semibold text-gray-800">{{ $invitation->event_venue }}</h4>
                    <div class="flex items-center justify-center gap-3 my-4">
                        <div class="w-6 h-px bg-[var(--color-primary)] opacity-30"></div>
                        <div class="w-1.5 h-1.5 rotate-45 bg-[var(--color-primary)] opacity-30"></div>
                        <div class="w-6 h-px bg-[var(--color-primary)] opacity-30"></div>
                    </div>
                    <p class="text-sm text-gray-600">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                    <p class="text-sm text-gray-600 mt-1">Pukul {{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }} {{ $invitation->event_time_end ? '- ' . \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') : '' }} WIB</p>
                    @if($invitation->event_address)<p class="text-xs text-gray-400 mt-4">{{ $invitation->event_address }}</p>@endif
                    @if($invitation->event_maps_url)
                    <a href="{{ $invitation->event_maps_url }}" target="_blank" class="inline-flex items-center gap-2 mt-6 px-6 py-2.5 bg-[var(--color-primary)] text-white rounded-lg text-xs hover:bg-[var(--color-primary)]/90 transition shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Buka Maps
                    </a>
                    @endif
                </div>
                @if($invitation->dress_code)
                <div class="mt-6 p-4 bg-[var(--color-accent)] rounded-lg"><p class="text-xs text-gray-600"><span class="font-medium text-[var(--color-primary)]">Dress Code:</span> {{ $invitation->dress_code }}</p></div>
                @endif
            </div>
        </section>


        <!-- Gallery -->
        @if($invitation->galleries->count() > 0)
        <section class="py-16 px-6 bg-[var(--color-accent)]">
            <div class="max-w-4xl mx-auto">
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400 text-center mb-2">Our Moments</p>
                <h2 class="text-3xl font-arabic font-bold text-[var(--color-primary)] text-center mb-12">Galeri</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($invitation->galleries as $photo)
                    <div class="aspect-square rounded-lg overflow-hidden islamic-border">
                        <img src="{{ $photo->getImageUrl() }}" alt="{{ $photo->caption }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- RSVP -->
        <section class="py-20 px-6 bg-[var(--color-secondary)] geometric-pattern">
            <div class="max-w-md mx-auto">
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400 text-center mb-2">Konfirmasi</p>
                <h2 class="text-3xl font-arabic font-bold text-[var(--color-primary)] text-center mb-10">RSVP</h2>
                @if(session('success'))<div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 text-sm text-center rounded-lg">{{ session('success') }}</div>@endif
                <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" class="space-y-4 bg-white rounded-xl p-8 islamic-border shadow-sm">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Lengkap" required class="w-full px-4 py-3 bg-[var(--color-accent)]/50 border border-[var(--color-primary)]/10 rounded-lg text-sm focus:ring-2 focus:ring-[var(--color-primary)]/20 focus:border-[var(--color-primary)] placeholder-gray-400">
                    <select name="rsvp_status" required class="w-full px-4 py-3 bg-[var(--color-accent)]/50 border border-[var(--color-primary)]/10 rounded-lg text-sm text-gray-600 focus:ring-2 focus:ring-[var(--color-primary)]/20 focus:border-[var(--color-primary)]">
                        <option value="">Konfirmasi Kehadiran</option><option value="attending">Hadir</option><option value="not_attending">Tidak Hadir</option><option value="maybe">Masih Ragu</option>
                    </select>
                    <input type="number" name="number_of_guests" min="1" max="10" value="1" class="w-full px-4 py-3 bg-[var(--color-accent)]/50 border border-[var(--color-primary)]/10 rounded-lg text-sm focus:ring-2 focus:ring-[var(--color-primary)]/20 focus:border-[var(--color-primary)]">
                    <button type="submit" class="w-full py-3 bg-[var(--color-primary)] text-white rounded-lg text-sm font-medium hover:bg-[var(--color-primary)]/90 transition shadow-sm">Kirim Konfirmasi</button>
                </form>
            </div>
        </section>

        <!-- Guestbook -->
        <section class="py-16 px-6 bg-[var(--color-accent)]">
            <div class="max-w-md mx-auto">
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400 text-center mb-2">Wishes</p>
                <h2 class="text-3xl font-arabic font-bold text-[var(--color-primary)] text-center mb-10">Ucapan & Doa</h2>
                <form method="POST" action="{{ route('invitation.guestbook', $invitation->slug) }}" class="space-y-4 bg-white rounded-xl p-8 islamic-border shadow-sm mb-8">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Anda" required class="w-full px-4 py-3 bg-[var(--color-accent)]/50 border border-[var(--color-primary)]/10 rounded-lg text-sm focus:ring-2 focus:ring-[var(--color-primary)]/20 focus:border-[var(--color-primary)] placeholder-gray-400">
                    <textarea name="message" rows="3" placeholder="Tulis ucapan & doa untuk kedua mempelai..." required class="w-full px-4 py-3 bg-[var(--color-accent)]/50 border border-[var(--color-primary)]/10 rounded-lg text-sm focus:ring-2 focus:ring-[var(--color-primary)]/20 focus:border-[var(--color-primary)] placeholder-gray-400 resize-none"></textarea>
                    <button type="submit" class="w-full py-3 border border-[var(--color-primary)] text-[var(--color-primary)] rounded-lg text-sm font-medium hover:bg-[var(--color-primary)] hover:text-white transition">Kirim Ucapan</button>
                </form>
                <div class="space-y-4 max-h-80 overflow-y-auto">
                    @foreach($invitation->guestbooks as $msg)
                    <div class="bg-white rounded-lg p-4 shadow-sm border border-[var(--color-primary)]/5">
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
        <section class="py-20 px-6 bg-[var(--color-secondary)] geometric-pattern">
            <div class="max-w-md mx-auto text-center">
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400 mb-2">Wedding Gift</p>
                <h2 class="text-3xl font-arabic font-bold text-[var(--color-primary)] mb-10">Amplop Digital</h2>
                @if($invitation->gift_info)<p class="text-sm text-gray-500 mb-8">{{ $invitation->gift_info }}</p>@endif
                @if($invitation->bank_name)
                <div class="bg-white rounded-xl p-8 islamic-border shadow-sm mb-6">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-2">{{ $invitation->bank_name }}</p>
                    <p class="text-xl font-bold text-[var(--color-primary)]">{{ $invitation->bank_account_number }}</p>
                    <p class="text-xs text-gray-500 mt-2">a.n. {{ $invitation->bank_account_name }}</p>
                </div>
                @endif
                @if($invitation->qris_image)
                <div class="inline-block bg-white p-5 rounded-xl shadow-sm border border-[var(--color-primary)]/10"><img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS" class="w-44 h-44 object-contain"></div>
                @endif
            </div>
        </section>
        @endif

        <!-- Closing -->
        @if($invitation->closing_text)
        <section class="py-16 px-6 bg-[var(--color-primary)] text-white text-center">
            <div class="max-w-xl mx-auto">
                <p class="text-white/80 leading-relaxed italic text-base mb-6">{{ $invitation->closing_text }}</p>
                <p class="font-arabic text-lg text-white/60 mb-6">وَمِنْ آيَاتِهِ أَنْ خَلَقَ لَكُمْ مِنْ أَنْفُسِكُمْ أَزْوَاجًا لِتَسْكُنُوا إِلَيْهَا</p>
                <p class="text-xs text-white/50 italic mb-8">Ar-Rum: 21</p>
                <h3 class="text-2xl font-arabic font-bold">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</h3>
            </div>
        </section>
        @endif

        <!-- Footer -->
        <footer class="py-8 px-6 bg-[var(--color-secondary)] text-center">
            <p class="text-[10px] text-gray-400">Powered by <a href="{{ url('/') }}" class="text-[var(--color-primary)] hover:underline">UndanganDigital</a></p>
        </footer>
    </div>

    <!-- Music Player -->
    @if($invitation->music_url)
    <div class="fixed bottom-6 right-6 z-40" x-show="opened">
        <button @click="toggleMusic()" class="w-12 h-12 bg-[var(--color-primary)] text-white rounded-full shadow-lg flex items-center justify-center hover:bg-[var(--color-primary)]/90 transition-all">
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
