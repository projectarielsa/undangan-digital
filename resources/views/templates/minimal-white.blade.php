<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --color-primary: {{ $invitation->color_primary ?? '#2d2d2d' }}; --color-secondary: {{ $invitation->color_secondary ?? '#ffffff' }}; --color-accent: {{ $invitation->color_accent ?? '#f5f5f5' }}; }
        .font-serif { font-family: 'Cormorant Garamond', serif; }
        .font-sans { font-family: 'Montserrat', sans-serif; }
        [x-cloak] { display: none !important; }
        .line-decoration { width: 60px; height: 1px; background: var(--color-primary); }
    </style>
</head>
<body class="font-sans bg-white text-gray-800 overflow-x-hidden" x-data="invitationApp()" x-cloak>

    <!-- Opening Cover -->
    <section x-show="!opened" class="fixed inset-0 z-50 flex items-center justify-center bg-white" x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="text-center px-6">
            <div class="line-decoration mx-auto mb-8"></div>
            <p class="text-xs uppercase tracking-[0.4em] text-gray-400 mb-6">Wedding Invitation</p>
            <h1 class="text-5xl sm:text-6xl font-serif font-semibold text-[var(--color-primary)] mb-2">{{ $invitation->groom_name }}</h1>
            <p class="text-3xl font-serif text-gray-300 my-4">&</p>
            <h1 class="text-5xl sm:text-6xl font-serif font-semibold text-[var(--color-primary)] mb-8">{{ $invitation->bride_name }}</h1>
            @if($guestName)
            <p class="text-xs uppercase tracking-[0.2em] text-gray-400 mb-2">Dear</p>
            <p class="text-lg font-medium text-[var(--color-primary)] mb-4">{{ urldecode($guestName) }}</p>
            @if($guest && $guest->invited_by)
            <p class="text-sm text-gray-400 mb-8">Invited by: {{ $guest->invited_by }}</p>
            @else
            <div class="mb-8"></div>
            @endif
            @endif
            <div class="line-decoration mx-auto mb-8"></div>
            <button @click="openInvitation()" class="px-10 py-3 border border-[var(--color-primary)] text-[var(--color-primary)] text-sm uppercase tracking-[0.2em] hover:bg-[var(--color-primary)] hover:text-white transition-all duration-300">
                Open
            </button>
        </div>
    </section>

    <!-- Main Content -->
    <div x-show="opened" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

        <!-- Hero -->
        <section class="min-h-screen flex items-center justify-center py-20 px-6">
            <div class="text-center max-w-2xl">
                <p class="text-xs uppercase tracking-[0.4em] text-gray-400 mb-8">The Wedding of</p>
                <h2 class="text-6xl sm:text-7xl font-serif font-semibold text-[var(--color-primary)] mb-2">{{ $invitation->groom_name }}</h2>
                <p class="text-4xl font-serif text-gray-300 my-6">&</p>
                <h2 class="text-6xl sm:text-7xl font-serif font-semibold text-[var(--color-primary)]">{{ $invitation->bride_name }}</h2>
                <div class="line-decoration mx-auto my-10"></div>
                <p class="text-lg text-gray-500 tracking-wide">{{ $invitation->event_date->translatedFormat('d.m.Y') }}</p>
            </div>
        </section>

        <!-- Opening Text -->
        @if($invitation->opening_text)
        <section class="py-20 px-6 bg-[var(--color-accent)]">
            <div class="max-w-xl mx-auto text-center">
                <p class="text-gray-600 leading-loose text-lg font-light">{{ $invitation->opening_text }}</p>
            </div>
        </section>
        @endif

        <!-- Couple Profile -->
        <section class="py-20 px-6">
            <div class="max-w-4xl mx-auto">
                <div class="grid md:grid-cols-2 gap-16">
                    <div class="text-center">
                        @if($invitation->groom_photo)
                        <div class="w-64 h-80 mx-auto mb-8 overflow-hidden">
                            <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-500">
                        </div>
                        @endif
                        <h3 class="text-3xl font-serif font-semibold text-[var(--color-primary)]">{{ $invitation->groom_name }}</h3>
                        @if($invitation->groom_father || $invitation->groom_mother)
                        <p class="text-gray-400 mt-3 text-sm">Son of {{ $invitation->groom_father }} & {{ $invitation->groom_mother }}</p>
                        @endif
                        @if($invitation->groom_instagram)
                        <a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" target="_blank" class="inline-block text-sm text-gray-400 mt-3 hover:text-[var(--color-primary)] transition">{{ $invitation->groom_instagram }}</a>
                        @endif
                    </div>
                    <div class="text-center">
                        @if($invitation->bride_photo)
                        <div class="w-64 h-80 mx-auto mb-8 overflow-hidden">
                            <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-500">
                        </div>
                        @endif
                        <h3 class="text-3xl font-serif font-semibold text-[var(--color-primary)]">{{ $invitation->bride_name }}</h3>
                        @if($invitation->bride_father || $invitation->bride_mother)
                        <p class="text-gray-400 mt-3 text-sm">Daughter of {{ $invitation->bride_father }} & {{ $invitation->bride_mother }}</p>
                        @endif
                        @if($invitation->bride_instagram)
                        <a href="https://instagram.com/{{ ltrim($invitation->bride_instagram, '@') }}" target="_blank" class="inline-block text-sm text-gray-400 mt-3 hover:text-[var(--color-primary)] transition">{{ $invitation->bride_instagram }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Countdown -->
        <section class="py-20 px-6 bg-[var(--color-accent)]">
            <div class="max-w-3xl mx-auto text-center">
                <p class="text-xs uppercase tracking-[0.4em] text-gray-400 mb-10">Counting Down</p>
                <div class="grid grid-cols-4 gap-6" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">
                    <div>
                        <p class="text-5xl sm:text-6xl font-serif font-light text-[var(--color-primary)]" x-text="days">0</p>
                        <p class="text-xs uppercase tracking-[0.2em] text-gray-400 mt-3">Days</p>
                    </div>
                    <div>
                        <p class="text-5xl sm:text-6xl font-serif font-light text-[var(--color-primary)]" x-text="hours">0</p>
                        <p class="text-xs uppercase tracking-[0.2em] text-gray-400 mt-3">Hours</p>
                    </div>
                    <div>
                        <p class="text-5xl sm:text-6xl font-serif font-light text-[var(--color-primary)]" x-text="minutes">0</p>
                        <p class="text-xs uppercase tracking-[0.2em] text-gray-400 mt-3">Minutes</p>
                    </div>
                    <div>
                        <p class="text-5xl sm:text-6xl font-serif font-light text-[var(--color-primary)]" x-text="seconds">0</p>
                        <p class="text-xs uppercase tracking-[0.2em] text-gray-400 mt-3">Seconds</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Event Details -->
        <section class="py-20 px-6">
            <div class="max-w-2xl mx-auto text-center">
                <p class="text-xs uppercase tracking-[0.4em] text-gray-400 mb-4">Save The Date</p>
                <h2 class="text-4xl font-serif font-semibold text-[var(--color-primary)] mb-12">Event Details</h2>
                
                <div class="space-y-2 mb-8">
                    <h4 class="text-2xl font-serif text-[var(--color-primary)]">{{ $invitation->event_venue }}</h4>
                    <p class="text-gray-500">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                    <p class="text-gray-500">{{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }} {{ $invitation->event_time_end ? '- ' . \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') : '' }} WIB</p>
                    @if($invitation->event_address)
                    <p class="text-gray-400 text-sm mt-4">{{ $invitation->event_address }}</p>
                    @endif
                </div>
                
                @if($invitation->event_maps_url)
                <a href="{{ $invitation->event_maps_url }}" target="_blank" class="inline-flex items-center gap-2 px-8 py-3 border border-[var(--color-primary)] text-[var(--color-primary)] text-sm uppercase tracking-[0.15em] hover:bg-[var(--color-primary)] hover:text-white transition-all duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    View Location
                </a>
                @endif
                
                @if($invitation->dress_code)
                <div class="mt-10 py-4 border-t border-b border-gray-100">
                    <p class="text-sm text-gray-400"><span class="uppercase tracking-wider">Dress Code</span> — {{ $invitation->dress_code }}</p>
                </div>
                @endif
            </div>
        </section>

        <!-- Love Story Timeline -->
        @if($invitation->love_story && count($invitation->love_story) > 0)
        <section class="py-20 px-6">
            <div class="max-w-3xl mx-auto">
                <p class="text-xs uppercase tracking-[0.4em] text-gray-400 text-center mb-4">Our Journey</p>
                <h2 class="text-4xl font-serif font-semibold text-[var(--color-primary)] text-center mb-12">Love Story</h2>
                <div class="relative">
                    <!-- Timeline line -->
                    <div class="absolute left-4 md:left-1/2 top-0 bottom-0 w-px bg-gray-200 transform md:-translate-x-1/2"></div>
                    
                    @foreach($invitation->love_story as $index => $story)
                    <div class="relative mb-12 last:mb-0 {{ $index % 2 == 0 ? 'md:pr-1/2' : 'md:pl-1/2 md:ml-auto' }}">
                        <!-- Timeline dot -->
                        <div class="absolute left-4 md:left-1/2 w-3 h-3 bg-[var(--color-primary)] rounded-full transform -translate-x-1/2 md:-translate-x-1/2 border-2 border-white"></div>
                        
                        <div class="ml-12 md:ml-0 {{ $index % 2 == 0 ? 'md:mr-8' : 'md:ml-8' }}">
                            <div class="border border-gray-100 p-6">
                                @if(!empty($story['date']))
                                <p class="text-xs uppercase tracking-wider text-gray-400 mb-2">{{ $story['date'] }}</p>
                                @endif
                                <h4 class="text-xl font-serif font-semibold text-[var(--color-primary)] mb-2">{{ $story['title'] }}</h4>
                                <p class="text-gray-500 text-sm leading-relaxed">{{ $story['description'] }}</p>
                                @if(!empty($story['image']))
                                <div class="mt-4 overflow-hidden">
                                    <img src="{{ asset('storage/' . $story['image']) }}" alt="{{ $story['title'] }}" class="w-full h-48 object-cover grayscale hover:grayscale-0 transition-all duration-500">
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Gallery -->
        @if($invitation->galleries->count() > 0)
        <section class="py-20 px-6 bg-[var(--color-accent)]">
            <div class="max-w-5xl mx-auto">
                <p class="text-xs uppercase tracking-[0.4em] text-gray-400 text-center mb-4">Our Story</p>
                <h2 class="text-4xl font-serif font-semibold text-[var(--color-primary)] text-center mb-12">Gallery</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($invitation->galleries as $photo)
                    <div class="aspect-square overflow-hidden">
                        <img src="{{ $photo->getImageUrl() }}" alt="{{ $photo->caption }}" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-500 hover:scale-105">
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- RSVP -->
        <section class="py-20 px-6">
            <div class="max-w-md mx-auto">
                <p class="text-xs uppercase tracking-[0.4em] text-gray-400 text-center mb-4">Attendance</p>
                <h2 class="text-4xl font-serif font-semibold text-[var(--color-primary)] text-center mb-10">RSVP</h2>
                @if(session('success'))
                <div class="mb-6 p-4 bg-gray-50 text-gray-600 text-center text-sm">{{ session('success') }}</div>
                @endif
                <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" class="space-y-5">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Your Name" required class="w-full px-0 py-3 bg-transparent border-0 border-b border-gray-200 focus:ring-0 focus:border-[var(--color-primary)] transition placeholder:text-gray-300">
                    <select name="rsvp_status" required class="w-full px-0 py-3 bg-transparent border-0 border-b border-gray-200 focus:ring-0 focus:border-[var(--color-primary)] transition text-gray-400">
                        <option value="">Confirm Attendance</option>
                        <option value="attending">Attending</option>
                        <option value="not_attending">Not Attending</option>
                        <option value="maybe">Maybe</option>
                    </select>
                    <input type="number" name="number_of_guests" min="1" max="10" value="1" placeholder="Number of Guests" class="w-full px-0 py-3 bg-transparent border-0 border-b border-gray-200 focus:ring-0 focus:border-[var(--color-primary)] transition placeholder:text-gray-300">
                    <button type="submit" class="w-full py-4 mt-4 border border-[var(--color-primary)] text-[var(--color-primary)] text-sm uppercase tracking-[0.2em] hover:bg-[var(--color-primary)] hover:text-white transition-all duration-300">Submit</button>
                </form>
            </div>
        </section>

        <!-- Guestbook -->
        <section class="py-20 px-6 bg-[var(--color-accent)]">
            <div class="max-w-md mx-auto">
                <p class="text-xs uppercase tracking-[0.4em] text-gray-400 text-center mb-4">Leave a Message</p>
                <h2 class="text-4xl font-serif font-semibold text-[var(--color-primary)] text-center mb-10">Wishes</h2>
                <form method="POST" action="{{ route('invitation.guestbook', $invitation->slug) }}" class="space-y-5 mb-12">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Your Name" required class="w-full px-0 py-3 bg-transparent border-0 border-b border-gray-300 focus:ring-0 focus:border-[var(--color-primary)] transition placeholder:text-gray-400">
                    <textarea name="message" rows="3" placeholder="Write your wishes..." required class="w-full px-0 py-3 bg-transparent border-0 border-b border-gray-300 focus:ring-0 focus:border-[var(--color-primary)] transition placeholder:text-gray-400 resize-none"></textarea>
                    <button type="submit" class="w-full py-4 bg-[var(--color-primary)] text-white text-sm uppercase tracking-[0.2em] hover:opacity-90 transition-all duration-300">Send Wishes</button>
                </form>
                <div class="space-y-6 max-h-80 overflow-y-auto">
                    @foreach($invitation->guestbooks as $msg)
                    <div class="border-b border-gray-200 pb-6">
                        <p class="font-medium text-[var(--color-primary)]">{{ $msg->name }}</p>
                        <p class="text-gray-500 text-sm mt-2 leading-relaxed">{{ $msg->message }}</p>
                        <p class="text-xs text-gray-300 mt-3">{{ $msg->created_at->diffForHumans() }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Digital Envelope -->
        @if($invitation->hasDigitalEnvelope())
        <section class="py-20 px-6">
            <div class="max-w-md mx-auto text-center">
                <p class="text-xs uppercase tracking-[0.4em] text-gray-400 mb-4">Wedding Gift</p>
                <h2 class="text-4xl font-serif font-semibold text-[var(--color-primary)] mb-10">Gift</h2>
                @if($invitation->gift_info)<p class="text-gray-500 mb-10">{{ $invitation->gift_info }}</p>@endif
                @foreach($invitation->bank_accounts_list as $account)
                <div class="border border-gray-200 p-8 mb-6">
                    <p class="text-xs uppercase tracking-wider text-gray-400 mb-2">{{ $account['bank_name'] }}</p>
                    <p class="text-2xl font-light text-[var(--color-primary)] mb-1">{{ $account['account_number'] }}</p>
                    <p class="text-sm text-gray-400">a.n. {{ $account['account_name'] }}</p>
                </div>
                @endforeach
                @if($invitation->qris_image)
                <div class="inline-block border border-gray-200 p-6 cursor-pointer" @click="$dispatch('open-qris')">
                    <p class="text-xs text-gray-400 mb-2">Tap untuk perbesar</p>
                    <img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS" class="w-48 h-48 object-contain">
                </div>
                @endif
            </div>
        </section>
        @endif

        <!-- Closing -->
        @if($invitation->closing_text)
        <section class="py-20 px-6 bg-[var(--color-accent)] text-center">
            <div class="max-w-xl mx-auto">
                <p class="text-gray-600 leading-loose text-lg font-light mb-10">{{ $invitation->closing_text }}</p>
                <div class="line-decoration mx-auto mb-6"></div>
                <h3 class="text-3xl font-serif font-semibold text-[var(--color-primary)]">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</h3>
            </div>
        </section>
        @endif

        <!-- Footer -->
        <footer class="py-10 px-6 text-center">
            <p class="text-xs text-gray-300 uppercase tracking-[0.2em]">Powered by <a href="{{ url('/') }}" class="hover:text-[var(--color-primary)] transition">Ellori</a></p>
        </footer>
    </div>

    <!-- Music Player -->
    @if($invitation->music_url)
    <div class="fixed bottom-8 right-8 z-40" x-show="opened">
        <button @click="toggleMusic()" class="w-12 h-12 border border-[var(--color-primary)] text-[var(--color-primary)] bg-white flex items-center justify-center hover:bg-[var(--color-primary)] hover:text-white transition-all duration-300">
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
    @include('templates.partials.qris-modal')
</body>
</html>
