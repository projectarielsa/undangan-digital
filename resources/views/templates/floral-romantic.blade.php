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
        .floral-bg { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle cx='20' cy='20' r='2' fill='%23FFB6C1' opacity='0.3'/%3E%3Ccircle cx='80' cy='30' r='3' fill='%23DDA0DD' opacity='0.2'/%3E%3Ccircle cx='40' cy='70' r='2' fill='%23FFB6C1' opacity='0.3'/%3E%3Ccircle cx='90' cy='80' r='2' fill='%23DDA0DD' opacity='0.2'/%3E%3C/svg%3E"); }
        .rose-border { border-image: linear-gradient(135deg, #FFB6C1, #DDA0DD, #FFB6C1) 1; }
    </style>
</head>
<body class="font-sans bg-[var(--color-secondary)] text-gray-700 overflow-x-hidden" x-data="invitationApp()" x-cloak>


    <!-- Opening Cover -->
    <section x-show="!opened" class="fixed inset-0 z-50 flex items-center justify-center bg-[var(--color-secondary)] floral-bg" x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="absolute top-0 left-0 w-32 h-32 opacity-40">
            <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 80C20 80 30 50 50 50C70 50 80 80 80 80" stroke="#FFB6C1" stroke-width="2"/><circle cx="50" cy="40" r="15" fill="#FFB6C1" opacity="0.5"/><circle cx="35" cy="50" r="10" fill="#DDA0DD" opacity="0.5"/><circle cx="65" cy="50" r="10" fill="#DDA0DD" opacity="0.5"/></svg>
        </div>
        <div class="absolute bottom-0 right-0 w-32 h-32 opacity-40 rotate-180">
            <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 80C20 80 30 50 50 50C70 50 80 80 80 80" stroke="#FFB6C1" stroke-width="2"/><circle cx="50" cy="40" r="15" fill="#FFB6C1" opacity="0.5"/><circle cx="35" cy="50" r="10" fill="#DDA0DD" opacity="0.5"/><circle cx="65" cy="50" r="10" fill="#DDA0DD" opacity="0.5"/></svg>
        </div>
        <div class="text-center px-6 relative z-10">
            <p class="text-sm uppercase tracking-[0.3em] text-[var(--color-primary)]/70 mb-4">The Wedding of</p>
            <h1 class="text-6xl sm:text-7xl font-script text-[var(--color-primary)] mb-2">{{ $invitation->groom_name }}</h1>
            <p class="text-4xl font-script text-pink-400 my-2">&</p>
            <h1 class="text-6xl sm:text-7xl font-script text-[var(--color-primary)] mb-8">{{ $invitation->bride_name }}</h1>
            @if($guestName)
            <p class="text-xs uppercase tracking-[0.2em] text-gray-500 mb-2">Kepada Yth.</p>
            <p class="text-lg font-medium text-[var(--color-primary)] mb-8">{{ urldecode($guestName) }}</p>
            @endif
            <button @click="openInvitation()" class="px-10 py-3 bg-gradient-to-r from-pink-300 to-pink-400 text-white rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                💐 Buka Undangan
            </button>
        </div>
    </section>


    <!-- Main Content -->
    <div x-show="opened" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

        <!-- Hero -->
        <section class="min-h-screen flex items-center justify-center py-20 px-6 relative floral-bg">
            <div class="absolute top-10 left-10 w-24 h-24 opacity-30">
                <svg viewBox="0 0 100 100"><circle cx="50" cy="50" r="20" fill="#FFB6C1"/><circle cx="30" cy="40" r="12" fill="#DDA0DD"/><circle cx="70" cy="40" r="12" fill="#DDA0DD"/><circle cx="50" cy="30" r="10" fill="#FFB6C1"/></svg>
            </div>
            <div class="absolute bottom-10 right-10 w-24 h-24 opacity-30">
                <svg viewBox="0 0 100 100"><circle cx="50" cy="50" r="20" fill="#FFB6C1"/><circle cx="30" cy="40" r="12" fill="#DDA0DD"/><circle cx="70" cy="40" r="12" fill="#DDA0DD"/><circle cx="50" cy="30" r="10" fill="#FFB6C1"/></svg>
            </div>
            <div class="text-center relative z-10 max-w-2xl">
                <p class="text-sm uppercase tracking-[0.3em] text-pink-400 mb-8">We're Getting Married</p>
                <h2 class="text-7xl sm:text-8xl font-script text-[var(--color-primary)] mb-4">{{ $invitation->groom_name }}</h2>
                <p class="text-5xl font-script text-pink-400 my-4">&</p>
                <h2 class="text-7xl sm:text-8xl font-script text-[var(--color-primary)]">{{ $invitation->bride_name }}</h2>
                <div class="mt-10">
                    <p class="text-lg text-gray-500">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>
        </section>

        <!-- Opening Text -->
        @if($invitation->opening_text)
        <section class="py-20 px-6 bg-[var(--color-accent)]/50">
            <div class="max-w-xl mx-auto text-center">
                <div class="flex justify-center gap-2 mb-8">
                    <span class="text-3xl">🌸</span><span class="text-3xl">🌺</span><span class="text-3xl">🌸</span>
                </div>
                <p class="text-gray-600 leading-loose text-lg italic">{{ $invitation->opening_text }}</p>
            </div>
        </section>
        @endif


        <!-- Couple Profile -->
        <section class="py-20 px-6 floral-bg">
            <div class="max-w-4xl mx-auto">
                <div class="grid md:grid-cols-2 gap-16">
                    <div class="text-center">
                        @if($invitation->groom_photo)
                        <div class="w-56 h-56 mx-auto mb-6 rounded-full overflow-hidden border-4 border-pink-200 shadow-lg shadow-pink-100">
                            <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}" class="w-full h-full object-cover">
                        </div>
                        @endif
                        <h3 class="text-4xl font-script text-[var(--color-primary)]">{{ $invitation->groom_name }}</h3>
                        @if($invitation->groom_father || $invitation->groom_mother)
                        <p class="text-gray-500 mt-3 text-sm">Putra dari Bapak {{ $invitation->groom_father }} & Ibu {{ $invitation->groom_mother }}</p>
                        @endif
                        @if($invitation->groom_instagram)
                        <a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" target="_blank" class="inline-flex items-center gap-1 text-sm text-pink-400 mt-3 hover:underline">{{ $invitation->groom_instagram }}</a>
                        @endif
                    </div>
                    <div class="text-center">
                        @if($invitation->bride_photo)
                        <div class="w-56 h-56 mx-auto mb-6 rounded-full overflow-hidden border-4 border-pink-200 shadow-lg shadow-pink-100">
                            <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}" class="w-full h-full object-cover">
                        </div>
                        @endif
                        <h3 class="text-4xl font-script text-[var(--color-primary)]">{{ $invitation->bride_name }}</h3>
                        @if($invitation->bride_father || $invitation->bride_mother)
                        <p class="text-gray-500 mt-3 text-sm">Putri dari Bapak {{ $invitation->bride_father }} & Ibu {{ $invitation->bride_mother }}</p>
                        @endif
                        @if($invitation->bride_instagram)
                        <a href="https://instagram.com/{{ ltrim($invitation->bride_instagram, '@') }}" target="_blank" class="inline-flex items-center gap-1 text-sm text-pink-400 mt-3 hover:underline">{{ $invitation->bride_instagram }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Countdown -->
        <section class="py-20 px-6 bg-gradient-to-r from-pink-100 via-pink-50 to-pink-100">
            <div class="max-w-3xl mx-auto text-center">
                <p class="text-sm uppercase tracking-[0.3em] text-pink-400 mb-10">Menghitung Hari</p>
                <div class="grid grid-cols-4 gap-4" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">
                    <div class="bg-white rounded-3xl p-6 shadow-lg shadow-pink-100">
                        <p class="text-4xl sm:text-5xl font-script text-[var(--color-primary)]" x-text="days">0</p>
                        <p class="text-xs uppercase tracking-wider text-pink-400 mt-2">Hari</p>
                    </div>
                    <div class="bg-white rounded-3xl p-6 shadow-lg shadow-pink-100">
                        <p class="text-4xl sm:text-5xl font-script text-[var(--color-primary)]" x-text="hours">0</p>
                        <p class="text-xs uppercase tracking-wider text-pink-400 mt-2">Jam</p>
                    </div>
                    <div class="bg-white rounded-3xl p-6 shadow-lg shadow-pink-100">
                        <p class="text-4xl sm:text-5xl font-script text-[var(--color-primary)]" x-text="minutes">0</p>
                        <p class="text-xs uppercase tracking-wider text-pink-400 mt-2">Menit</p>
                    </div>
                    <div class="bg-white rounded-3xl p-6 shadow-lg shadow-pink-100">
                        <p class="text-4xl sm:text-5xl font-script text-[var(--color-primary)]" x-text="seconds">0</p>
                        <p class="text-xs uppercase tracking-wider text-pink-400 mt-2">Detik</p>
                    </div>
                </div>
            </div>
        </section>


        <!-- Event Details -->
        <section class="py-20 px-6 floral-bg">
            <div class="max-w-2xl mx-auto text-center">
                <p class="text-sm uppercase tracking-[0.3em] text-pink-400 mb-4">Save The Date</p>
                <h2 class="text-5xl font-script text-[var(--color-primary)] mb-12">Acara Pernikahan</h2>
                <div class="bg-white rounded-3xl p-10 shadow-xl shadow-pink-100 border border-pink-100">
                    <div class="flex justify-center gap-2 mb-6">
                        <span class="text-2xl">🌷</span><span class="text-2xl">💒</span><span class="text-2xl">🌷</span>
                    </div>
                    <h4 class="text-2xl font-script text-[var(--color-primary)] mb-4">{{ $invitation->event_venue }}</h4>
                    <p class="text-gray-500 mb-2">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                    <p class="text-gray-500 mb-6">Pukul {{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }} {{ $invitation->event_time_end ? '- ' . \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') : '' }} WIB</p>
                    @if($invitation->event_address)<p class="text-gray-400 text-sm mb-8">{{ $invitation->event_address }}</p>@endif
                    @if($invitation->event_maps_url)
                    <a href="{{ $invitation->event_maps_url }}" target="_blank" class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-pink-300 to-pink-400 text-white rounded-full hover:opacity-90 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Lihat Lokasi
                    </a>
                    @endif
                </div>
                @if($invitation->dress_code)
                <div class="mt-8 p-4 bg-pink-50 rounded-2xl border border-pink-200">
                    <p class="text-sm text-pink-600">🎀 <strong>Dress Code:</strong> {{ $invitation->dress_code }}</p>
                </div>
                @endif
            </div>
        </section>

        <!-- Gallery -->
        @if($invitation->galleries->count() > 0)
        <section class="py-20 px-6 bg-[var(--color-accent)]/50">
            <div class="max-w-4xl mx-auto">
                <p class="text-sm uppercase tracking-[0.3em] text-pink-400 text-center mb-4">Our Love Story</p>
                <h2 class="text-5xl font-script text-[var(--color-primary)] text-center mb-12">Galeri</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($invitation->galleries as $photo)
                    <div class="aspect-square rounded-3xl overflow-hidden shadow-lg shadow-pink-100 border-2 border-pink-100">
                        <img src="{{ $photo->getImageUrl() }}" alt="{{ $photo->caption }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif


        <!-- RSVP -->
        <section class="py-20 px-6 floral-bg">
            <div class="max-w-md mx-auto">
                <p class="text-sm uppercase tracking-[0.3em] text-pink-400 text-center mb-4">Konfirmasi Kehadiran</p>
                <h2 class="text-5xl font-script text-[var(--color-primary)] text-center mb-10">RSVP</h2>
                @if(session('success'))<div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-600 rounded-2xl text-center text-sm">{{ session('success') }}</div>@endif
                <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" class="space-y-5">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Anda" required class="w-full px-5 py-4 bg-white border border-pink-200 rounded-2xl focus:ring-2 focus:ring-pink-300 focus:border-transparent transition placeholder:text-gray-400">
                    <select name="rsvp_status" required class="w-full px-5 py-4 bg-white border border-pink-200 rounded-2xl focus:ring-2 focus:ring-pink-300 focus:border-transparent transition text-gray-500">
                        <option value="">Konfirmasi Kehadiran</option>
                        <option value="attending">Hadir</option>
                        <option value="not_attending">Tidak Hadir</option>
                        <option value="maybe">Masih Ragu</option>
                    </select>
                    <input type="number" name="number_of_guests" min="1" max="10" value="1" placeholder="Jumlah Tamu" class="w-full px-5 py-4 bg-white border border-pink-200 rounded-2xl focus:ring-2 focus:ring-pink-300 focus:border-transparent transition placeholder:text-gray-400">
                    <button type="submit" class="w-full py-4 bg-gradient-to-r from-pink-300 to-pink-400 text-white font-medium rounded-2xl hover:opacity-90 transition shadow-lg shadow-pink-200">Kirim Konfirmasi</button>
                </form>
            </div>
        </section>

        <!-- Guestbook -->
        <section class="py-20 px-6 bg-[var(--color-accent)]/50">
            <div class="max-w-md mx-auto">
                <p class="text-sm uppercase tracking-[0.3em] text-pink-400 text-center mb-4">Kirim Doa & Ucapan</p>
                <h2 class="text-5xl font-script text-[var(--color-primary)] text-center mb-10">Ucapan</h2>
                <form method="POST" action="{{ route('invitation.guestbook', $invitation->slug) }}" class="space-y-5 mb-10">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Anda" required class="w-full px-5 py-4 bg-white border border-pink-200 rounded-2xl focus:ring-2 focus:ring-pink-300 focus:border-transparent transition placeholder:text-gray-400">
                    <textarea name="message" rows="3" placeholder="Tulis ucapan dan doa..." required class="w-full px-5 py-4 bg-white border border-pink-200 rounded-2xl focus:ring-2 focus:ring-pink-300 focus:border-transparent transition placeholder:text-gray-400 resize-none"></textarea>
                    <button type="submit" class="w-full py-4 bg-[var(--color-primary)] text-white font-medium rounded-2xl hover:opacity-90 transition">💌 Kirim Ucapan</button>
                </form>
                <div class="space-y-4 max-h-80 overflow-y-auto">
                    @foreach($invitation->guestbooks as $msg)
                    <div class="bg-white rounded-2xl p-5 shadow-md shadow-pink-50 border border-pink-100">
                        <p class="font-medium text-[var(--color-primary)]">{{ $msg->name }}</p>
                        <p class="text-gray-500 text-sm mt-2">{{ $msg->message }}</p>
                        <p class="text-xs text-pink-300 mt-3">{{ $msg->created_at->diffForHumans() }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>


        <!-- Digital Envelope -->
        @if($invitation->bank_name || $invitation->qris_image)
        <section class="py-20 px-6 floral-bg">
            <div class="max-w-md mx-auto text-center">
                <p class="text-sm uppercase tracking-[0.3em] text-pink-400 mb-4">Wedding Gift</p>
                <h2 class="text-5xl font-script text-[var(--color-primary)] mb-10">Amplop Digital</h2>
                @if($invitation->gift_info)<p class="text-gray-500 mb-10">{{ $invitation->gift_info }}</p>@endif
                @if($invitation->bank_name)
                <div class="bg-white rounded-3xl p-8 shadow-lg shadow-pink-100 border border-pink-100 mb-6">
                    <p class="text-xs uppercase tracking-wider text-pink-400 mb-2">{{ $invitation->bank_name }}</p>
                    <p class="text-2xl font-semibold text-[var(--color-primary)] mb-1">{{ $invitation->bank_account_number }}</p>
                    <p class="text-sm text-gray-500">a.n. {{ $invitation->bank_account_name }}</p>
                </div>
                @endif
                @if($invitation->qris_image)
                <div class="inline-block bg-white rounded-3xl p-6 shadow-lg shadow-pink-100 border border-pink-100">
                    <img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS" class="w-48 h-48 object-contain">
                </div>
                @endif
            </div>
        </section>
        @endif

        <!-- Closing -->
        @if($invitation->closing_text)
        <section class="py-20 px-6 bg-gradient-to-r from-pink-100 via-pink-50 to-pink-100 text-center">
            <div class="max-w-xl mx-auto">
                <div class="flex justify-center gap-2 mb-8">
                    <span class="text-3xl">🌸</span><span class="text-3xl">💕</span><span class="text-3xl">🌸</span>
                </div>
                <p class="text-gray-600 leading-loose text-lg italic mb-10">{{ $invitation->closing_text }}</p>
                <h3 class="text-5xl font-script text-[var(--color-primary)]">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</h3>
            </div>
        </section>
        @endif

        <!-- Footer -->
        <footer class="py-10 px-6 bg-[var(--color-secondary)] text-center">
            <p class="text-xs text-gray-400">Powered by <a href="{{ url('/') }}" class="text-pink-400 hover:underline">UndanganDigital</a></p>
        </footer>
    </div>

    <!-- Music Player -->
    @if($invitation->music_url)
    <div class="fixed bottom-8 right-8 z-40" x-show="opened">
        <button @click="toggleMusic()" class="w-14 h-14 bg-gradient-to-r from-pink-300 to-pink-400 text-white rounded-full shadow-lg shadow-pink-200 flex items-center justify-center hover:opacity-90 transition">
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
