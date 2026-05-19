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
        .gold-gradient { background: linear-gradient(135deg, #C9A96E 0%, #E8D5A3 50%, #C9A96E 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .border-gold { border-image: linear-gradient(135deg, #C9A96E, #E8D5A3, #C9A96E) 1; }
        .glow { box-shadow: 0 0 30px rgba(201, 169, 110, 0.3); }
    </style>
</head>
<body class="font-sans bg-[var(--color-secondary)] text-gray-300 overflow-x-hidden" x-data="invitationApp()" x-cloak>


    <!-- Opening Cover -->
    <section x-show="!opened" class="fixed inset-0 z-50 flex items-center justify-center bg-[var(--color-secondary)]" x-transition:leave="transition ease-in duration-700" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-full h-full" style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><circle cx=%2250%22 cy=%2250%22 r=%2240%22 fill=%22none%22 stroke=%22%23C9A96E%22 stroke-width=%220.5%22/></svg>'); background-size: 200px;"></div>
        </div>
        <div class="text-center px-6 relative z-10">
            <div class="w-24 h-[1px] bg-gradient-to-r from-transparent via-[var(--color-primary)] to-transparent mx-auto mb-8"></div>
            <p class="text-xs uppercase tracking-[0.5em] text-[var(--color-primary)] mb-6">The Wedding Celebration of</p>
            <h1 class="text-5xl sm:text-7xl font-serif font-semibold gold-gradient mb-4">{{ $invitation->groom_name }}</h1>
            <p class="text-4xl font-serif text-[var(--color-primary)] my-4">&</p>
            <h1 class="text-5xl sm:text-7xl font-serif font-semibold gold-gradient mb-8">{{ $invitation->bride_name }}</h1>
            @if($guestName)
            <p class="text-xs uppercase tracking-[0.3em] text-gray-500 mb-2">Honorable Guest</p>
            <p class="text-xl text-[var(--color-primary)] mb-8">{{ urldecode($guestName) }}</p>
            @endif
            <div class="w-24 h-[1px] bg-gradient-to-r from-transparent via-[var(--color-primary)] to-transparent mx-auto mb-10"></div>
            <button @click="openInvitation()" class="px-12 py-4 bg-transparent border-2 border-[var(--color-primary)] text-[var(--color-primary)] text-sm uppercase tracking-[0.3em] hover:bg-[var(--color-primary)] hover:text-[var(--color-secondary)] transition-all duration-500 glow">
                Open Invitation
            </button>
        </div>
    </section>


    <!-- Main Content -->
    <div x-show="opened" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

        <!-- Hero -->
        <section class="min-h-screen flex items-center justify-center py-20 px-6 relative">
            <div class="absolute inset-0 opacity-5">
                <div class="absolute top-20 left-20 w-72 h-72 border border-[var(--color-primary)] rounded-full"></div>
                <div class="absolute bottom-20 right-20 w-96 h-96 border border-[var(--color-primary)] rounded-full"></div>
            </div>
            <div class="text-center relative z-10 max-w-3xl">
                <p class="text-xs uppercase tracking-[0.5em] text-[var(--color-primary)] mb-10">We Are Getting Married</p>
                <h2 class="text-6xl sm:text-8xl font-serif font-semibold gold-gradient mb-4">{{ $invitation->groom_name }}</h2>
                <p class="text-5xl font-serif text-[var(--color-primary)] my-6">&</p>
                <h2 class="text-6xl sm:text-8xl font-serif font-semibold gold-gradient">{{ $invitation->bride_name }}</h2>
                <div class="w-32 h-[1px] bg-gradient-to-r from-transparent via-[var(--color-primary)] to-transparent mx-auto my-12"></div>
                <p class="text-xl text-gray-400 tracking-widest">{{ $invitation->event_date->translatedFormat('d • m • Y') }}</p>
            </div>
        </section>

        <!-- Opening Text -->
        @if($invitation->opening_text)
        <section class="py-24 px-6 bg-[var(--color-accent)]">
            <div class="max-w-2xl mx-auto text-center">
                <div class="w-16 h-16 border border-[var(--color-primary)]/30 rotate-45 mx-auto mb-10 flex items-center justify-center">
                    <div class="w-8 h-8 border border-[var(--color-primary)] rotate-0"></div>
                </div>
                <p class="text-gray-400 leading-loose text-lg italic">{{ $invitation->opening_text }}</p>
            </div>
        </section>
        @endif


        <!-- Couple Profile -->
        <section class="py-24 px-6">
            <div class="max-w-5xl mx-auto">
                <div class="grid md:grid-cols-2 gap-20">
                    <div class="text-center">
                        @if($invitation->groom_photo)
                        <div class="w-72 h-72 mx-auto mb-8 relative">
                            <div class="absolute inset-0 border-2 border-[var(--color-primary)]/30 rotate-45"></div>
                            <div class="absolute inset-4 overflow-hidden">
                                <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}" class="w-full h-full object-cover">
                            </div>
                        </div>
                        @endif
                        <h3 class="text-3xl font-serif gold-gradient">{{ $invitation->groom_name }}</h3>
                        @if($invitation->groom_father || $invitation->groom_mother)
                        <p class="text-gray-500 mt-4 text-sm">Putra dari Bapak {{ $invitation->groom_father }} & Ibu {{ $invitation->groom_mother }}</p>
                        @endif
                        @if($invitation->groom_instagram)
                        <a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" target="_blank" class="inline-block text-sm text-[var(--color-primary)] mt-4 hover:underline">{{ $invitation->groom_instagram }}</a>
                        @endif
                    </div>
                    <div class="text-center">
                        @if($invitation->bride_photo)
                        <div class="w-72 h-72 mx-auto mb-8 relative">
                            <div class="absolute inset-0 border-2 border-[var(--color-primary)]/30 rotate-45"></div>
                            <div class="absolute inset-4 overflow-hidden">
                                <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}" class="w-full h-full object-cover">
                            </div>
                        </div>
                        @endif
                        <h3 class="text-3xl font-serif gold-gradient">{{ $invitation->bride_name }}</h3>
                        @if($invitation->bride_father || $invitation->bride_mother)
                        <p class="text-gray-500 mt-4 text-sm">Putri dari Bapak {{ $invitation->bride_father }} & Ibu {{ $invitation->bride_mother }}</p>
                        @endif
                        @if($invitation->bride_instagram)
                        <a href="https://instagram.com/{{ ltrim($invitation->bride_instagram, '@') }}" target="_blank" class="inline-block text-sm text-[var(--color-primary)] mt-4 hover:underline">{{ $invitation->bride_instagram }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </section>


        <!-- Countdown -->
        <section class="py-24 px-6 bg-[var(--color-accent)]">
            <div class="max-w-4xl mx-auto text-center">
                <p class="text-xs uppercase tracking-[0.5em] text-[var(--color-primary)] mb-12">Counting Down To The Big Day</p>
                <div class="grid grid-cols-4 gap-6" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">
                    <div class="border border-[var(--color-primary)]/30 p-6 glow">
                        <p class="text-5xl sm:text-6xl font-serif gold-gradient" x-text="days">0</p>
                        <p class="text-xs uppercase tracking-[0.3em] text-gray-500 mt-4">Days</p>
                    </div>
                    <div class="border border-[var(--color-primary)]/30 p-6 glow">
                        <p class="text-5xl sm:text-6xl font-serif gold-gradient" x-text="hours">0</p>
                        <p class="text-xs uppercase tracking-[0.3em] text-gray-500 mt-4">Hours</p>
                    </div>
                    <div class="border border-[var(--color-primary)]/30 p-6 glow">
                        <p class="text-5xl sm:text-6xl font-serif gold-gradient" x-text="minutes">0</p>
                        <p class="text-xs uppercase tracking-[0.3em] text-gray-500 mt-4">Minutes</p>
                    </div>
                    <div class="border border-[var(--color-primary)]/30 p-6 glow">
                        <p class="text-5xl sm:text-6xl font-serif gold-gradient" x-text="seconds">0</p>
                        <p class="text-xs uppercase tracking-[0.3em] text-gray-500 mt-4">Seconds</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Event Details -->
        <section class="py-24 px-6">
            <div class="max-w-3xl mx-auto text-center">
                <p class="text-xs uppercase tracking-[0.5em] text-[var(--color-primary)] mb-4">Save The Date</p>
                <h2 class="text-4xl font-serif gold-gradient mb-16">Event Details</h2>
                <div class="border border-[var(--color-primary)]/20 p-12 relative glow">
                    <div class="absolute top-0 left-0 w-8 h-8 border-t-2 border-l-2 border-[var(--color-primary)]"></div>
                    <div class="absolute top-0 right-0 w-8 h-8 border-t-2 border-r-2 border-[var(--color-primary)]"></div>
                    <div class="absolute bottom-0 left-0 w-8 h-8 border-b-2 border-l-2 border-[var(--color-primary)]"></div>
                    <div class="absolute bottom-0 right-0 w-8 h-8 border-b-2 border-r-2 border-[var(--color-primary)]"></div>
                    <h4 class="text-2xl font-serif text-[var(--color-primary)] mb-6">{{ $invitation->event_venue }}</h4>
                    <p class="text-gray-400 mb-2">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                    <p class="text-gray-400 mb-6">{{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }} {{ $invitation->event_time_end ? '- ' . \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') : '' }} WIB</p>
                    @if($invitation->event_address)<p class="text-gray-500 text-sm mb-8">{{ $invitation->event_address }}</p>@endif
                    @if($invitation->event_maps_url)
                    <a href="{{ $invitation->event_maps_url }}" target="_blank" class="inline-flex items-center gap-3 px-8 py-3 bg-[var(--color-primary)] text-[var(--color-secondary)] text-sm uppercase tracking-[0.2em] hover:opacity-90 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        View Maps
                    </a>
                    @endif
                </div>
                @if($invitation->dress_code)
                <div class="mt-8 p-4 border border-[var(--color-primary)]/20"><p class="text-sm text-gray-400"><span class="text-[var(--color-primary)]">Dress Code:</span> {{ $invitation->dress_code }}</p></div>
                @endif
            </div>
        </section>


        <!-- Gallery -->
        @if($invitation->galleries->count() > 0)
        <section class="py-24 px-6 bg-[var(--color-accent)]">
            <div class="max-w-5xl mx-auto">
                <p class="text-xs uppercase tracking-[0.5em] text-[var(--color-primary)] text-center mb-4">Our Precious Moments</p>
                <h2 class="text-4xl font-serif gold-gradient text-center mb-16">Gallery</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($invitation->galleries as $photo)
                    <div class="aspect-square overflow-hidden border border-[var(--color-primary)]/20 p-2">
                        <img src="{{ $photo->getImageUrl() }}" alt="{{ $photo->caption }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-700">
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- RSVP -->
        <section class="py-24 px-6">
            <div class="max-w-lg mx-auto">
                <p class="text-xs uppercase tracking-[0.5em] text-[var(--color-primary)] text-center mb-4">Confirmation</p>
                <h2 class="text-4xl font-serif gold-gradient text-center mb-12">RSVP</h2>
                @if(session('success'))<div class="mb-8 p-4 border border-green-500/30 text-green-400 text-center text-sm">{{ session('success') }}</div>@endif
                <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" class="space-y-6">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Your Name" required class="w-full px-6 py-4 bg-[var(--color-accent)] border border-[var(--color-primary)]/30 text-white focus:ring-2 focus:ring-[var(--color-primary)] focus:border-transparent transition placeholder:text-gray-600">
                    <select name="rsvp_status" required class="w-full px-6 py-4 bg-[var(--color-accent)] border border-[var(--color-primary)]/30 text-gray-400 focus:ring-2 focus:ring-[var(--color-primary)] focus:border-transparent transition">
                        <option value="">Confirm Attendance</option>
                        <option value="attending">Attending</option>
                        <option value="not_attending">Not Attending</option>
                        <option value="maybe">Maybe</option>
                    </select>
                    <input type="number" name="number_of_guests" min="1" max="10" value="1" placeholder="Number of Guests" class="w-full px-6 py-4 bg-[var(--color-accent)] border border-[var(--color-primary)]/30 text-white focus:ring-2 focus:ring-[var(--color-primary)] focus:border-transparent transition placeholder:text-gray-600">
                    <button type="submit" class="w-full py-4 bg-[var(--color-primary)] text-[var(--color-secondary)] font-semibold uppercase tracking-[0.2em] hover:opacity-90 transition">Submit</button>
                </form>
            </div>
        </section>


        <!-- Guestbook -->
        <section class="py-24 px-6 bg-[var(--color-accent)]">
            <div class="max-w-lg mx-auto">
                <p class="text-xs uppercase tracking-[0.5em] text-[var(--color-primary)] text-center mb-4">Send Your Wishes</p>
                <h2 class="text-4xl font-serif gold-gradient text-center mb-12">Wishes</h2>
                <form method="POST" action="{{ route('invitation.guestbook', $invitation->slug) }}" class="space-y-6 mb-12">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Your Name" required class="w-full px-6 py-4 bg-[var(--color-secondary)] border border-[var(--color-primary)]/30 text-white focus:ring-2 focus:ring-[var(--color-primary)] focus:border-transparent transition placeholder:text-gray-600">
                    <textarea name="message" rows="4" placeholder="Write your wishes..." required class="w-full px-6 py-4 bg-[var(--color-secondary)] border border-[var(--color-primary)]/30 text-white focus:ring-2 focus:ring-[var(--color-primary)] focus:border-transparent transition placeholder:text-gray-600 resize-none"></textarea>
                    <button type="submit" class="w-full py-4 border-2 border-[var(--color-primary)] text-[var(--color-primary)] font-semibold uppercase tracking-[0.2em] hover:bg-[var(--color-primary)] hover:text-[var(--color-secondary)] transition">Send Wishes</button>
                </form>
                <div class="space-y-6 max-h-96 overflow-y-auto">
                    @foreach($invitation->guestbooks as $msg)
                    <div class="border-l-2 border-[var(--color-primary)] pl-6 py-2">
                        <p class="font-medium text-[var(--color-primary)]">{{ $msg->name }}</p>
                        <p class="text-gray-400 text-sm mt-2">{{ $msg->message }}</p>
                        <p class="text-xs text-gray-600 mt-3">{{ $msg->created_at->diffForHumans() }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Digital Envelope -->
        @if($invitation->bank_name || $invitation->qris_image)
        <section class="py-24 px-6">
            <div class="max-w-lg mx-auto text-center">
                <p class="text-xs uppercase tracking-[0.5em] text-[var(--color-primary)] mb-4">Wedding Gift</p>
                <h2 class="text-4xl font-serif gold-gradient mb-12">Gift</h2>
                @if($invitation->gift_info)<p class="text-gray-400 mb-12">{{ $invitation->gift_info }}</p>@endif
                @if($invitation->bank_name)
                <div class="border border-[var(--color-primary)]/30 p-8 mb-6 glow">
                    <p class="text-xs uppercase tracking-wider text-gray-500 mb-2">{{ $invitation->bank_name }}</p>
                    <p class="text-3xl font-light text-[var(--color-primary)] mb-2">{{ $invitation->bank_account_number }}</p>
                    <p class="text-sm text-gray-500">a.n. {{ $invitation->bank_account_name }}</p>
                </div>
                @endif
                @if($invitation->qris_image)
                <div class="inline-block border border-[var(--color-primary)]/30 p-4">
                    <img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS" class="w-48 h-48 object-contain">
                </div>
                @endif
            </div>
        </section>
        @endif


        <!-- Closing -->
        @if($invitation->closing_text)
        <section class="py-24 px-6 bg-[var(--color-accent)] text-center">
            <div class="max-w-2xl mx-auto">
                <p class="text-gray-400 leading-loose text-lg italic mb-12">{{ $invitation->closing_text }}</p>
                <div class="w-24 h-[1px] bg-gradient-to-r from-transparent via-[var(--color-primary)] to-transparent mx-auto mb-8"></div>
                <h3 class="text-3xl font-serif gold-gradient">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</h3>
            </div>
        </section>
        @endif

        <!-- Footer -->
        <footer class="py-12 px-6 text-center">
            <p class="text-xs text-gray-600 uppercase tracking-[0.3em]">Powered by <a href="{{ url('/') }}" class="text-[var(--color-primary)] hover:underline">UndanganDigital</a></p>
        </footer>
    </div>

    <!-- Music Player -->
    @if($invitation->music_url)
    <div class="fixed bottom-8 right-8 z-40" x-show="opened">
        <button @click="toggleMusic()" class="w-14 h-14 bg-[var(--color-primary)] text-[var(--color-secondary)] flex items-center justify-center hover:opacity-90 transition glow">
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
