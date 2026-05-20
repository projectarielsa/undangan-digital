<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Welcome Display - {{ $invitation->groom_name }} & {{ $invitation->bride_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Great+Vibes&family=Inter:wght@300;400;500;600&family=Cormorant+Garamond:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @php
        $template = $invitation->template;
        $primaryColor = $template->color_primary ?? '#d97706';
        $secondaryColor = $template->color_secondary ?? '#fef3c7';
        $accentColor = $template->color_accent ?? '#92400e';
    @endphp
    
    <style>
        :root {
            --color-primary: {{ $primaryColor }};
            --color-secondary: {{ $secondaryColor }};
            --color-accent: {{ $accentColor }};
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--color-secondary) 0%, white 50%, var(--color-secondary) 100%);
            min-height: 100vh;
            overflow: hidden;
        }
        
        .font-script {
            font-family: 'Great Vibes', cursive;
        }
        
        .font-serif {
            font-family: 'Cormorant Garamond', 'Playfair Display', serif;
        }
        
        /* Floating Flowers Animation */
        .flower {
            position: fixed;
            top: -50px;
            animation: fall linear infinite;
            pointer-events: none;
            z-index: 10;
            opacity: 0.8;
        }
        
        @keyframes fall {
            0% {
                transform: translateY(-50px) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.8;
            }
            90% {
                opacity: 0.8;
            }
            100% {
                transform: translateY(100vh) rotate(360deg);
                opacity: 0;
            }
        }
        
        /* Confetti for check-in celebration */
        .confetti {
            position: fixed;
            top: -10px;
            animation: confetti-fall linear forwards;
            pointer-events: none;
            z-index: 50;
        }
        
        @keyframes confetti-fall {
            0% {
                transform: translateY(-10px) rotate(0deg) scale(1);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(720deg) scale(0.5);
                opacity: 0;
            }
        }
        
        /* Sparkle effect */
        .sparkle {
            position: absolute;
            width: 10px;
            height: 10px;
            background: var(--color-primary);
            border-radius: 50%;
            animation: sparkle 1.5s ease-in-out infinite;
        }
        
        @keyframes sparkle {
            0%, 100% { transform: scale(0); opacity: 0; }
            50% { transform: scale(1); opacity: 1; }
        }
        
        /* Photo slideshow */
        .photo-container {
            position: relative;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            overflow: hidden;
            border: 6px solid var(--color-primary);
            box-shadow: 0 20px 60px rgba(0,0,0,0.2), 0 0 0 12px var(--color-secondary);
        }
        
        .photo-slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }
        
        .photo-slide.active {
            opacity: 1;
        }
        
        .photo-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        /* Guest welcome animation */
        .guest-enter {
            animation: guestEnter 0.8s ease-out forwards;
        }
        
        @keyframes guestEnter {
            0% {
                opacity: 0;
                transform: scale(0.8) translateY(30px);
            }
            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
        
        /* Pulse ring for check-in success */
        .pulse-ring {
            position: absolute;
            inset: -20px;
            border: 3px solid var(--color-primary);
            border-radius: 50%;
            animation: pulseRing 2s ease-out infinite;
        }
        
        @keyframes pulseRing {
            0% { transform: scale(0.8); opacity: 1; }
            100% { transform: scale(1.3); opacity: 0; }
        }
        
        /* Decorative corners */
        .corner-decoration {
            position: fixed;
            width: 150px;
            height: 150px;
            background: var(--color-primary);
            opacity: 0.1;
        }
        
        .corner-tl { top: -75px; left: -75px; border-radius: 50%; }
        .corner-tr { top: -75px; right: -75px; border-radius: 50%; }
        .corner-bl { bottom: -75px; left: -75px; border-radius: 50%; }
        .corner-br { bottom: -75px; right: -75px; border-radius: 50%; }
        
        /* Floating hearts */
        .floating-heart {
            position: fixed;
            color: var(--color-primary);
            opacity: 0.3;
            animation: floatHeart 6s ease-in-out infinite;
        }
        
        @keyframes floatHeart {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-20px) scale(1.1); }
        }
    </style>
</head>
<body class="flex items-center justify-center p-8">
    <!-- Decorative corners -->
    <div class="corner-decoration corner-tl"></div>
    <div class="corner-decoration corner-tr"></div>
    <div class="corner-decoration corner-bl"></div>
    <div class="corner-decoration corner-br"></div>
    
    <!-- Floating flowers container -->
    <div id="flowers-container"></div>
    
    <!-- Confetti container -->
    <div id="confetti-container"></div>
    
    <!-- Floating hearts -->
    <div class="floating-heart text-4xl" style="top: 20%; left: 10%; animation-delay: 0s;">❤</div>
    <div class="floating-heart text-2xl" style="top: 60%; left: 5%; animation-delay: 1s;">💕</div>
    <div class="floating-heart text-3xl" style="top: 30%; right: 8%; animation-delay: 2s;">❤</div>
    <div class="floating-heart text-2xl" style="top: 70%; right: 12%; animation-delay: 0.5s;">💕</div>
    <div class="floating-heart text-4xl" style="bottom: 15%; left: 15%; animation-delay: 1.5s;">❤</div>
    <div class="floating-heart text-3xl" style="bottom: 25%; right: 10%; animation-delay: 2.5s;">💕</div>
    
    <!-- Main Content -->
    <div id="app" class="relative z-20 w-full max-w-4xl">
        
        <!-- State 1: Welcome Guest (ada tamu baru check-in) -->
        <div id="guest-welcome" class="hidden">
            <div class="text-center guest-enter">
                <!-- Photo with pulse ring -->
                <div class="relative inline-block mb-8">
                    <div class="pulse-ring"></div>
                    <div class="pulse-ring" style="animation-delay: 0.5s;"></div>
                    <div class="photo-container mx-auto">
                        @if(count($galleryImages) > 0)
                            @foreach($galleryImages as $index => $imageUrl)
                                <div class="photo-slide {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                                    <img src="{{ $imageUrl }}" alt="Gallery {{ $index + 1 }}">
                                </div>
                            @endforeach
                        @else
                            <div class="w-full h-full flex items-center justify-center" style="background: var(--color-secondary);">
                                <span class="text-6xl">💒</span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Success badge -->
                    <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 bg-green-500 text-white px-6 py-2 rounded-full shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="font-semibold">Check-in Berhasil!</span>
                    </div>
                </div>
                
                <!-- Welcome text -->
                <p class="font-script text-5xl md:text-6xl mb-4" style="color: var(--color-primary);">Selamat Datang</p>
                
                <!-- Guest Name -->
                <h1 id="guest-name" class="font-serif text-5xl md:text-7xl font-bold text-gray-800 mb-6"></h1>
                
                <!-- Message -->
                <div class="mt-8 space-y-4">
                    <p class="text-gray-600 text-xl">Terima kasih telah hadir di acara pernikahan kami</p>
                    <div class="flex items-center justify-center gap-4">
                        <span class="font-serif text-3xl font-semibold text-gray-800">{{ $invitation->groom_name }}</span>
                        <span class="font-script text-4xl" style="color: var(--color-primary);">&</span>
                        <span class="font-serif text-3xl font-semibold text-gray-800">{{ $invitation->bride_name }}</span>
                    </div>
                </div>
                
                <!-- Quote -->
                <p class="mt-8 text-gray-500 italic text-lg">"Selamat menikmati perayaan cinta kami"</p>
            </div>
        </div>
        
        <!-- State 2: Idle (tidak ada check-in > 15 detik) -->
        <div id="idle-welcome" class="hidden">
            <div class="text-center">
                <!-- Photo slideshow -->
                <div class="relative inline-block mb-10">
                    <div class="photo-container mx-auto" style="width: 320px; height: 320px;">
                        @if(count($galleryImages) > 0)
                            @foreach($galleryImages as $index => $imageUrl)
                                <div class="photo-slide {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                                    <img src="{{ $imageUrl }}" alt="Gallery {{ $index + 1 }}">
                                </div>
                            @endforeach
                        @else
                            <div class="w-full h-full flex items-center justify-center" style="background: var(--color-secondary);">
                                <span class="text-8xl">💒</span>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Welcome text -->
                <p class="font-script text-5xl md:text-7xl mb-6" style="color: var(--color-primary);">Selamat Datang</p>
                
                <p class="text-gray-600 text-2xl mb-8">Di Acara Pernikahan</p>
                
                <!-- Couple Names -->
                <div class="flex items-center justify-center gap-6 mb-10">
                    <span class="font-serif text-4xl md:text-6xl font-bold text-gray-800">{{ $invitation->groom_name }}</span>
                    <span class="font-script text-6xl md:text-7xl" style="color: var(--color-primary);">&</span>
                    <span class="font-serif text-4xl md:text-6xl font-bold text-gray-800">{{ $invitation->bride_name }}</span>
                </div>
                
                <!-- Event Details -->
                <div class="space-y-3 mb-8">
                    @if($invitation->event_date)
                    <p class="text-gray-600 text-xl flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" style="color: var(--color-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $invitation->event_date->translatedFormat('l, d F Y') }}
                    </p>
                    @endif
                    
                    @if($invitation->venue_name)
                    <p class="text-gray-600 text-xl flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" style="color: var(--color-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $invitation->venue_name }}
                    </p>
                    @endif
                </div>
                
                <!-- Quote -->
                <p class="text-gray-500 italic text-xl font-serif">"Two souls, one heart, forever together"</p>
            </div>
        </div>
        
    </div>

    <script>
        const apiUrl = '{{ route("customer.invitations.qr-checkin.latest", $invitation) }}';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const galleryImages = @json($galleryImages);
        
        let currentGuestId = null;
        let slideIndex = 0;
        let slideInterval = null;
        
        const guestWelcome = document.getElementById('guest-welcome');
        const idleWelcome = document.getElementById('idle-welcome');
        const guestNameEl = document.getElementById('guest-name');
        const flowersContainer = document.getElementById('flowers-container');
        const confettiContainer = document.getElementById('confetti-container');
        
        // Flower emojis for falling animation
        const flowerEmojis = ['🌸', '🌺', '🌷', '💮', '🏵️', '🌹', '🌻', '✿', '❀', '❁'];
        const confettiColors = ['#f472b6', '#fbbf24', '#a78bfa', '#34d399', '#f87171', '#60a5fa'];
        
        // Create falling flowers
        function createFlower() {
            const flower = document.createElement('div');
            flower.className = 'flower';
            flower.textContent = flowerEmojis[Math.floor(Math.random() * flowerEmojis.length)];
            flower.style.left = Math.random() * 100 + 'vw';
            flower.style.fontSize = (Math.random() * 20 + 15) + 'px';
            flower.style.animationDuration = (Math.random() * 5 + 8) + 's';
            flower.style.animationDelay = Math.random() * 2 + 's';
            flowersContainer.appendChild(flower);
            
            setTimeout(() => flower.remove(), 15000);
        }
        
        // Create confetti burst
        function createConfetti() {
            for (let i = 0; i < 50; i++) {
                setTimeout(() => {
                    const confetti = document.createElement('div');
                    confetti.className = 'confetti';
                    confetti.style.left = (Math.random() * 100) + 'vw';
                    confetti.style.backgroundColor = confettiColors[Math.floor(Math.random() * confettiColors.length)];
                    confetti.style.width = (Math.random() * 10 + 5) + 'px';
                    confetti.style.height = (Math.random() * 10 + 5) + 'px';
                    confetti.style.borderRadius = Math.random() > 0.5 ? '50%' : '0';
                    confetti.style.animationDuration = (Math.random() * 2 + 2) + 's';
                    confettiContainer.appendChild(confetti);
                    
                    setTimeout(() => confetti.remove(), 4000);
                }, i * 30);
            }
        }
        
        // Photo slideshow
        function startSlideshow() {
            if (galleryImages.length <= 1) return;
            
            slideInterval = setInterval(() => {
                const slides = document.querySelectorAll('.photo-slide');
                slides.forEach(slide => slide.classList.remove('active'));
                slideIndex = (slideIndex + 1) % galleryImages.length;
                slides.forEach(slide => {
                    if (parseInt(slide.dataset.index) === slideIndex) {
                        slide.classList.add('active');
                    }
                });
            }, 5000);
        }
        
        function showGuestWelcome(guest) {
            if (currentGuestId !== guest.id) {
                currentGuestId = guest.id;
                
                guestNameEl.textContent = guest.name;
                
                // Reset animation
                guestWelcome.classList.remove('hidden');
                const animDiv = guestWelcome.querySelector('.guest-enter');
                animDiv.style.animation = 'none';
                animDiv.offsetHeight; // Trigger reflow
                animDiv.style.animation = null;
                
                idleWelcome.classList.add('hidden');
                
                // Celebration effects
                createConfetti();
            }
        }
        
        function showIdleWelcome() {
            if (!idleWelcome.classList.contains('hidden')) return;
            
            currentGuestId = null;
            
            idleWelcome.classList.remove('hidden');
            guestWelcome.classList.add('hidden');
        }
        
        async function checkLatestCheckin() {
            try {
                const response = await fetch(apiUrl, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                
                const data = await response.json();
                
                if (data.has_recent && data.guest) {
                    showGuestWelcome(data.guest);
                } else {
                    showIdleWelcome();
                }
            } catch (error) {
                console.error('Error fetching latest check-in:', error);
            }
        }
        
        // Initialize
        function init() {
            // Start slideshow
            startSlideshow();
            
            // Create flowers periodically
            setInterval(createFlower, 2000);
            
            // Initial flowers
            for (let i = 0; i < 5; i++) {
                setTimeout(createFlower, i * 400);
            }
            
            // Initial check
            checkLatestCheckin();
            
            // Poll every 2 seconds
            setInterval(checkLatestCheckin, 2000);
            
            // Show idle welcome initially
            showIdleWelcome();
        }
        
        init();
    </script>
</body>
</html>
