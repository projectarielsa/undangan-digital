<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --color-primary: {{ $invitation->color_primary ?? '#1B5E20' }}; --color-secondary: {{ $invitation->color_secondary ?? '#F5F5DC' }}; --color-accent: {{ $invitation->color_accent ?? '#E8F5E9' }}; }
        .font-arabic { font-family: 'Amiri', serif; }
        .font-sans { font-family: 'Poppins', sans-serif; }
        [x-cloak] { display: none !important; }
        .islamic-pattern { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 80 80'%3E%3Cpath d='M40 0L80 40L40 80L0 40Z' fill='none' stroke='%231B5E20' stroke-width='0.5' opacity='0.1'/%3E%3C/svg%3E"); background-size: 40px; }
        .geometric-border { border: 2px solid; border-image: repeating-linear-gradient(45deg, var(--color-primary), var(--color-primary) 10px, transparent 10px, transparent 20px) 1; }
    </style>
</head>
<body class="font-sans bg-[var(--color-secondary)] text-gray-700 overflow-x-hidden" x-data="invitationApp()" x-cloak>


    <!-- Opening Cover -->
    <section x-show="!opened" class="fixed inset-0 z-50 flex items-center justify-center bg-[var(--color-secondary)] islamic-pattern" x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 flex items-center justify-center opacity-5">
            <svg class="w-96 h-96" viewBox="0 0 200 200"><polygon points="100,10 190,100 100,190 10,100" fill="none" stroke="currentColor" stroke-width="2"/><polygon points="100,30 170,100 100,170 30,100" fill="none" stroke="currentColor" stroke-width="1"/><polygon points="100,50 150,100 100,150 50,100" fill="none" stroke="currentColor" stroke-width="0.5"/></svg>
        </div>
        <div class="text-center px-6 relative z-10">
            <p class="text-2xl font-arabic text-[var(--color-primary)] mb-6">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيم</p>
            <p class="text-xs uppercase tracking-[0.3em] text-[var(--color-primary)]/70 mb-6">The Wedding of</p>
            <h1 class="text-5xl sm:text-6xl font-arabic font-bold text-[var(--color-primary)] mb-2">{{ $invitation->groom_name }}</h1>
            <p class="text-3xl font-arabic text-[var(--color-primary)]/60 my-4">&</p>
            <h1 class="text-5xl sm:text-6xl font-arabic font-bold text-[var(--color-primary)] mb-8">{{ $invitation->bride_name }}</h1>
            @if($guestName)
            <p class="text-xs uppercase tracking-[0.2em] text-gray-500 mb-2">Kepada Yth.</p>
            <p class="text-lg font-medium text-[var(--color-primary)] mb-4">{{ urldecode($guestName) }}</p>
            @if($guest && $guest->invited_by)
            <p class="text-sm text-[var(--color-primary)]/80 mb-8">Turut Mengundang: {{ $guest->invited_by }}</p>
            @else
            <div class="mb-8"></div>
            @endif
            @endif
            <button @click="openInvitation()" class="px-10 py-3 bg-[var(--color-primary)] text-white rounded-lg hover:opacity-90 transition-all transform hover:scale-105 shadow-lg">
                Buka Undangan
            </button>
        </div>
    </section>


    <!-- Main Content -->
    <div x-show="opened" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

        <!-- Hero -->
        <section class="min-h-screen flex items-center justify-center py-20 px-6 relative islamic-pattern">
            <div class="absolute top-10 left-10 w-20 h-20 opacity-20">
                <svg viewBox="0 0 100 100"><polygon points="50,5 95,50 50,95 5,50" fill="none" stroke="currentColor" stroke-width="2"/></svg>
            </div>
            <div class="absolute bottom-10 right-10 w-20 h-20 opacity-20">
                <svg viewBox="0 0 100 100"><polygon points="50,5 95,50 50,95 5,50" fill="none" stroke="currentColor" stroke-width="2"/></svg>
            </div>
            <div class="text-center relative z-10 max-w-2xl">
                <p class="text-3xl font-arabic text-[var(--color-primary)] mb-8">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيم</p>
                <p class="text-sm uppercase tracking-[0.3em] text-[var(--color-primary)]/70 mb-8">Dengan Memohon Rahmat dan Ridho Allah SWT</p>
                <h2 class="text-6xl sm:text-7xl font-arabic font-bold text-[var(--color-primary)] mb-4">{{ $invitation->groom_name }}</h2>
                <p class="text-4xl font-arabic text-[var(--color-primary)]/60 my-4">&</p>
                <h2 class="text-6xl sm:text-7xl font-arabic font-bold text-[var(--color-primary)]">{{ $invitation->bride_name }}</h2>
                <div class="w-24 h-[2px] bg-[var(--color-primary)]/30 mx-auto my-10"></div>
                <p class="text-lg text-gray-600">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
            </div>
        </section>

        <!-- Opening Text -->
        @if($invitation->opening_text)
        <section class="py-20 px-6 bg-[var(--color-accent)]">
            <div class="max-w-xl mx-auto text-center">
                <p class="text-2xl font-arabic text-[var(--color-primary)] mb-6">اَلسَّلاَمُ عَلَيْكُمْ وَرَحْمَةُ اللهِ وَبَرَكَاتُهُ</p>
                <p class="text-gray-600 leading-loose">{{ $invitation->opening_text }}</p>
            </div>
        </section>
        @endif


        <!-- Couple Profile -->
        <section class="py-20 px-6 islamic-pattern">
            <div class="max-w-4xl mx-auto">
                <div class="grid md:grid-cols-2 gap-16">
                    <div class="text-center">
                        @if($invitation->groom_photo)
                        <div class="w-52 h-52 mx-auto mb-6 relative">
                            <div class="absolute inset-0 border-2 border-[var(--color-primary)]/30 rotate-45"></div>
                            <div class="absolute inset-2 rounded-full overflow-hidden">
                                <img src="{{ asset('storage/' . $invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}" class="w-full h-full object-cover">
                            </div>
                        </div>
                        @endif
                        <h3 class="text-3xl font-arabic font-bold text-[var(--color-primary)]">{{ $invitation->groom_name }}</h3>
                        @if($invitation->groom_father || $invitation->groom_mother)
                        <p class="text-gray-500 mt-3 text-sm">Putra dari<br/>Bapak {{ $invitation->groom_father }} & Ibu {{ $invitation->groom_mother }}</p>
                        @endif
                        @if($invitation->groom_instagram)
                        <a href="https://instagram.com/{{ ltrim($invitation->groom_instagram, '@') }}" target="_blank" class="inline-block text-sm text-[var(--color-primary)] mt-3 hover:underline">{{ $invitation->groom_instagram }}</a>
                        @endif
                    </div>
                    <div class="text-center">
                        @if($invitation->bride_photo)
                        <div class="w-52 h-52 mx-auto mb-6 relative">
                            <div class="absolute inset-0 border-2 border-[var(--color-primary)]/30 rotate-45"></div>
                            <div class="absolute inset-2 rounded-full overflow-hidden">
                                <img src="{{ asset('storage/' . $invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}" class="w-full h-full object-cover">
                            </div>
                        </div>
                        @endif
                        <h3 class="text-3xl font-arabic font-bold text-[var(--color-primary)]">{{ $invitation->bride_name }}</h3>
                        @if($invitation->bride_father || $invitation->bride_mother)
                        <p class="text-gray-500 mt-3 text-sm">Putri dari<br/>Bapak {{ $invitation->bride_father }} & Ibu {{ $invitation->bride_mother }}</p>
                        @endif
                        @if($invitation->bride_instagram)
                        <a href="https://instagram.com/{{ ltrim($invitation->bride_instagram, '@') }}" target="_blank" class="inline-block text-sm text-[var(--color-primary)] mt-3 hover:underline">{{ $invitation->bride_instagram }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Quran Verse -->
        <section class="py-16 px-6 bg-[var(--color-primary)] text-white">
            <div class="max-w-2xl mx-auto text-center">
                <p class="text-2xl font-arabic leading-loose mb-6">وَمِنْ آيَاتِهِ أَنْ خَلَقَ لَكُم مِّنْ أَنفُسِكُمْ أَزْوَاجًا لِّتَسْكُنُوا إِلَيْهَا وَجَعَلَ بَيْنَكُم مَّوَدَّةً وَرَحْمَةً</p>
                <p class="text-sm text-white/80 italic">"Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu isteri-isteri dari jenismu sendiri, supaya kamu cenderung dan merasa tenteram kepadanya, dan dijadikan-Nya diantaramu rasa kasih dan sayang."</p>
                <p class="text-xs text-white/60 mt-4">— QS. Ar-Rum: 21</p>
            </div>
        </section>


        <!-- Countdown -->
        <section class="py-20 px-6 bg-[var(--color-accent)]">
            <div class="max-w-3xl mx-auto text-center">
                <p class="text-sm uppercase tracking-[0.3em] text-[var(--color-primary)] mb-10">Menghitung Hari</p>
                <div class="grid grid-cols-4 gap-4" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">
                    <div class="bg-white p-6 shadow-md border-t-4 border-[var(--color-primary)]">
                        <p class="text-4xl sm:text-5xl font-arabic font-bold text-[var(--color-primary)]" x-text="days">0</p>
                        <p class="text-xs uppercase tracking-wider text-gray-500 mt-2">Hari</p>
                    </div>
                    <div class="bg-white p-6 shadow-md border-t-4 border-[var(--color-primary)]">
                        <p class="text-4xl sm:text-5xl font-arabic font-bold text-[var(--color-primary)]" x-text="hours">0</p>
                        <p class="text-xs uppercase tracking-wider text-gray-500 mt-2">Jam</p>
                    </div>
                    <div class="bg-white p-6 shadow-md border-t-4 border-[var(--color-primary)]">
                        <p class="text-4xl sm:text-5xl font-arabic font-bold text-[var(--color-primary)]" x-text="minutes">0</p>
                        <p class="text-xs uppercase tracking-wider text-gray-500 mt-2">Menit</p>
                    </div>
                    <div class="bg-white p-6 shadow-md border-t-4 border-[var(--color-primary)]">
                        <p class="text-4xl sm:text-5xl font-arabic font-bold text-[var(--color-primary)]" x-text="seconds">0</p>
                        <p class="text-xs uppercase tracking-wider text-gray-500 mt-2">Detik</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Event Details -->
        <section class="py-20 px-6 islamic-pattern">
            <div class="max-w-2xl mx-auto text-center">
                <p class="text-sm uppercase tracking-[0.3em] text-[var(--color-primary)] mb-4">Waktu & Tempat</p>
                <h2 class="text-4xl font-arabic font-bold text-[var(--color-primary)] mb-12">Akad & Resepsi</h2>
                <div class="bg-white p-10 shadow-lg border-t-4 border-[var(--color-primary)]">
                    <svg class="w-12 h-12 mx-auto mb-6 text-[var(--color-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <h4 class="text-2xl font-arabic font-bold text-[var(--color-primary)] mb-4">{{ $invitation->event_venue }}</h4>
                    <p class="text-gray-600 mb-2">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                    <p class="text-gray-600 mb-6">Pukul {{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }} {{ $invitation->event_time_end ? '- ' . \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') : '' }} WIB</p>
                    @if($invitation->event_address)<p class="text-gray-500 text-sm mb-8">{{ $invitation->event_address }}</p>@endif
                    @if($invitation->event_maps_url)
                    <a href="{{ $invitation->event_maps_url }}" target="_blank" class="inline-flex items-center gap-2 px-8 py-3 bg-[var(--color-primary)] text-white rounded-lg hover:opacity-90 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Lihat Peta
                    </a>
                    @endif
                </div>
                @if($invitation->dress_code)
                <div class="mt-8 p-4 bg-white shadow border-l-4 border-[var(--color-primary)]">
                    <p class="text-sm text-gray-600"><strong>Dress Code:</strong> {{ $invitation->dress_code }}</p>
                </div>
                @endif
            </div>
        </section>


        <!-- Love Story Timeline -->
        @if($invitation->love_story && count($invitation->love_story) > 0)
        <section class="py-20 px-6 islamic-pattern">
            <div class="max-w-3xl mx-auto">
                <p class="text-sm uppercase tracking-[0.3em] text-[var(--color-primary)] text-center mb-4">Perjalanan Cinta</p>
                <h2 class="text-4xl font-arabic font-bold text-[var(--color-primary)] text-center mb-12">Love Story</h2>
                <div class="relative">
                    <!-- Timeline line -->
                    <div class="absolute left-4 md:left-1/2 top-0 bottom-0 w-0.5 bg-[var(--color-primary)]/20 transform md:-translate-x-1/2"></div>
                    
                    @foreach($invitation->love_story as $index => $story)
                    <div class="relative mb-12 last:mb-0 {{ $index % 2 == 0 ? 'md:pr-1/2' : 'md:pl-1/2 md:ml-auto' }}">
                        <!-- Timeline dot -->
                        <div class="absolute left-4 md:left-1/2 w-4 h-4 bg-[var(--color-primary)] rounded-full transform -translate-x-1/2 md:-translate-x-1/2 border-4 border-[var(--color-secondary)] shadow"></div>
                        
                        <div class="ml-12 md:ml-0 {{ $index % 2 == 0 ? 'md:mr-8' : 'md:ml-8' }}">
                            <div class="bg-white p-6 shadow-lg border-t-4 border-[var(--color-primary)]">
                                @if(!empty($story['date']))
                                <p class="text-sm text-[var(--color-primary)] font-medium mb-2">{{ $story['date'] }}</p>
                                @endif
                                <h4 class="text-xl font-arabic font-bold text-[var(--color-primary)] mb-2">{{ $story['title'] }}</h4>
                                <p class="text-gray-600 text-sm leading-relaxed">{{ $story['description'] }}</p>
                                @if(!empty($story['image']))
                                <div class="mt-4 overflow-hidden">
                                    <img src="{{ asset('storage/' . $story['image']) }}" alt="{{ $story['title'] }}" class="w-full h-48 object-cover">
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
            <div class="max-w-4xl mx-auto">
                <p class="text-sm uppercase tracking-[0.3em] text-[var(--color-primary)] text-center mb-4">Moment Bahagia</p>
                <h2 class="text-4xl font-arabic font-bold text-[var(--color-primary)] text-center mb-12">Galeri</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($invitation->galleries as $photo)
                    <div class="aspect-square overflow-hidden shadow-md">
                        <img src="{{ $photo->getImageUrl() }}" alt="{{ $photo->caption }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- RSVP -->
        <section class="py-20 px-6 islamic-pattern">
            <div class="max-w-md mx-auto">
                <p class="text-sm uppercase tracking-[0.3em] text-[var(--color-primary)] text-center mb-4">Konfirmasi Kehadiran</p>
                <h2 class="text-4xl font-arabic font-bold text-[var(--color-primary)] text-center mb-10">RSVP</h2>
                @if(session('success'))<div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-600 text-center text-sm">{{ session('success') }}</div>@endif
                <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" class="space-y-5 bg-white p-8 shadow-lg">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Anda" required class="w-full px-4 py-3 border border-gray-200 focus:ring-2 focus:ring-[var(--color-primary)] focus:border-transparent transition">
                    <select name="rsvp_status" required class="w-full px-4 py-3 border border-gray-200 focus:ring-2 focus:ring-[var(--color-primary)] focus:border-transparent transition text-gray-500">
                        <option value="">Konfirmasi Kehadiran</option>
                        <option value="attending">Insya Allah Hadir</option>
                        <option value="not_attending">Maaf, Tidak Bisa Hadir</option>
                        <option value="maybe">Masih Belum Pasti</option>
                    </select>
                    <input type="number" name="number_of_guests" min="1" max="10" value="1" placeholder="Jumlah Tamu" class="w-full px-4 py-3 border border-gray-200 focus:ring-2 focus:ring-[var(--color-primary)] focus:border-transparent transition">
                    <button type="submit" class="w-full py-4 bg-[var(--color-primary)] text-white font-medium hover:opacity-90 transition">Kirim Konfirmasi</button>
                </form>
            </div>
        </section>


        <!-- Guestbook -->
        <section class="py-20 px-6 bg-[var(--color-accent)]">
            <div class="max-w-md mx-auto">
                <p class="text-sm uppercase tracking-[0.3em] text-[var(--color-primary)] text-center mb-4">Doa & Ucapan</p>
                <h2 class="text-4xl font-arabic font-bold text-[var(--color-primary)] text-center mb-10">Ucapan</h2>
                <form method="POST" action="{{ route('invitation.guestbook', $invitation->slug) }}" class="space-y-5 bg-white p-8 shadow-lg mb-10">
                    @csrf
                    <input type="text" name="name" value="{{ $guestName ? urldecode($guestName) : '' }}" placeholder="Nama Anda" required class="w-full px-4 py-3 border border-gray-200 focus:ring-2 focus:ring-[var(--color-primary)] focus:border-transparent transition">
                    <textarea name="message" rows="3" placeholder="Tulis doa dan ucapan untuk kedua mempelai..." required class="w-full px-4 py-3 border border-gray-200 focus:ring-2 focus:ring-[var(--color-primary)] focus:border-transparent transition resize-none"></textarea>
                    <button type="submit" class="w-full py-4 border-2 border-[var(--color-primary)] text-[var(--color-primary)] font-medium hover:bg-[var(--color-primary)] hover:text-white transition">Kirim Ucapan</button>
                </form>
                <div class="space-y-4 max-h-80 overflow-y-auto">
                    @foreach($invitation->guestbooks as $msg)
                    <div class="bg-white p-5 shadow border-l-4 border-[var(--color-primary)]">
                        <p class="font-medium text-[var(--color-primary)]">{{ $msg->name }}</p>
                        <p class="text-gray-500 text-sm mt-2">{{ $msg->message }}</p>
                        <p class="text-xs text-gray-400 mt-3">{{ $msg->created_at->diffForHumans() }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Digital Envelope -->
        @if($invitation->hasDigitalEnvelope())
        <section class="py-20 px-6 islamic-pattern">
            <div class="max-w-md mx-auto text-center">
                <p class="text-sm uppercase tracking-[0.3em] text-[var(--color-primary)] mb-4">Hadiah Pernikahan</p>
                <h2 class="text-4xl font-arabic font-bold text-[var(--color-primary)] mb-10">Amplop Digital</h2>
                @if($invitation->gift_info)<p class="text-gray-500 mb-10">{{ $invitation->gift_info }}</p>@endif
                @foreach($invitation->bank_accounts_list as $account)
                <div class="bg-white p-8 shadow-lg border-t-4 border-[var(--color-primary)] mb-6">
                    <p class="text-xs uppercase tracking-wider text-gray-500 mb-2">{{ $account['bank_name'] }}</p>
                    <p class="text-2xl font-semibold text-[var(--color-primary)] mb-1">{{ $account['account_number'] }}</p>
                    <p class="text-sm text-gray-500">a.n. {{ $account['account_name'] }}</p>
                </div>
                @endforeach
                @if($invitation->qris_image)
                <div class="inline-block bg-white p-6 shadow-lg cursor-pointer" @click="$dispatch('open-qris')">
                    <p class="text-xs text-gray-400 mb-2">Tap untuk perbesar</p>
                    <img src="{{ asset('storage/' . $invitation->qris_image) }}" alt="QRIS" class="w-48 h-48 object-contain">
                </div>
                @endif
            </div>
        </section>
        @endif


        <!-- Closing -->
        @if($invitation->closing_text)
        <section class="py-20 px-6 bg-[var(--color-primary)] text-white text-center">
            <div class="max-w-xl mx-auto">
                <p class="text-white/90 leading-loose text-lg mb-8">{{ $invitation->closing_text }}</p>
                <p class="text-2xl font-arabic mb-8">وَاللَّهُ يَرْزُقُ مَن يَشَاءُ بِغَيْرِ حِسَابٍ</p>
                <div class="w-24 h-[1px] bg-white/30 mx-auto mb-8"></div>
                <h3 class="text-3xl font-arabic font-bold">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</h3>
            </div>
        </section>
        @endif

        <!-- Footer -->
        <footer class="py-10 px-6 bg-[var(--color-secondary)] text-center">
            <p class="text-xs text-gray-500">Powered by <a href="{{ url('/') }}" class="text-[var(--color-primary)] hover:underline">Ellori</a></p>
        </footer>
    </div>

    <!-- Music Player -->
    @if($invitation->music_url)
    <div class="fixed bottom-8 right-8 z-40" x-show="opened">
        <button @click="toggleMusic()" class="w-14 h-14 bg-[var(--color-primary)] text-white rounded-lg shadow-lg flex items-center justify-center hover:opacity-90 transition">
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
    @include('templates.partials.qris-modal')
</body>
</html>
