<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Welcome Display - {{ $invitation->groom_name }} & {{ $invitation->bride_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .font-serif {
            font-family: 'Playfair Display', serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 50%, #fcd34d 100%);
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        
        .scale-in {
            animation: scaleIn 0.6s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes scaleIn {
            from { 
                opacity: 0; 
                transform: scale(0.9);
            }
            to { 
                opacity: 1; 
                transform: scale(1);
            }
        }
        
        .pulse-ring {
            animation: pulseRing 2s ease-out infinite;
        }
        
        @keyframes pulseRing {
            0% {
                transform: scale(0.8);
                opacity: 1;
            }
            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-8">
    <div id="app" class="w-full max-w-4xl">
        
        <!-- State 1: Welcome Guest (ada tamu baru check-in) -->
        <div id="guest-welcome" class="hidden">
            <div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-2xl p-12 text-center scale-in">
                <!-- Success Icon -->
                <div class="relative w-24 h-24 mx-auto mb-8">
                    <div class="absolute inset-0 bg-green-400 rounded-full pulse-ring"></div>
                    <div class="relative w-24 h-24 bg-green-500 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
                
                <!-- Check-in Success Text -->
                <p class="text-green-600 font-semibold text-xl mb-4">Check-in Berhasil!</p>
                
                <!-- Guest Name -->
                <h1 class="font-serif text-5xl md:text-6xl font-bold text-gray-800 mb-6">
                    Selamat Datang,
                </h1>
                <p id="guest-name" class="font-serif text-4xl md:text-5xl font-bold text-amber-600 mb-8"></p>
                
                <!-- Welcome Message -->
                <div class="border-t border-gray-200 pt-8 mt-8">
                    <p class="text-gray-600 text-xl mb-4">Terima kasih telah hadir di acara pernikahan kami</p>
                    <div class="flex items-center justify-center gap-4 text-3xl font-serif text-gray-800">
                        <span>{{ $invitation->groom_name }}</span>
                        <span class="text-amber-500">&</span>
                        <span>{{ $invitation->bride_name }}</span>
                    </div>
                </div>
                
                <!-- Quote -->
                <p class="text-gray-500 italic mt-8 text-lg">"Selamat menikmati perayaan cinta kami"</p>
            </div>
        </div>
        
        <!-- State 2: Idle (tidak ada check-in > 1 menit) -->
        <div id="idle-welcome" class="hidden">
            <div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-2xl p-12 text-center fade-in">
                <!-- Decorative Icon -->
                <div class="w-20 h-20 mx-auto mb-8 text-amber-500">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </div>
                
                <!-- Welcome Text -->
                <h1 class="font-serif text-5xl md:text-6xl font-bold text-gray-800 mb-6">
                    Selamat Datang
                </h1>
                
                <p class="text-gray-600 text-2xl mb-8">Di Acara Pernikahan</p>
                
                <!-- Couple Names -->
                <div class="flex items-center justify-center gap-6 mb-8">
                    <span class="font-serif text-4xl md:text-5xl font-bold text-gray-800">{{ $invitation->groom_name }}</span>
                    <span class="text-5xl text-amber-500">&</span>
                    <span class="font-serif text-4xl md:text-5xl font-bold text-gray-800">{{ $invitation->bride_name }}</span>
                </div>
                
                <!-- Event Details -->
                <div class="border-t border-gray-200 pt-8 mt-8 space-y-3">
                    @if($invitation->event_date)
                    <p class="text-gray-600 text-xl flex items-center justify-center gap-2">
                        <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $invitation->event_date->translatedFormat('l, d F Y') }}
                    </p>
                    @endif
                    
                    @if($invitation->venue_name)
                    <p class="text-gray-600 text-xl flex items-center justify-center gap-2">
                        <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $invitation->venue_name }}
                    </p>
                    @endif
                </div>
                
                <!-- Quote -->
                <p class="text-gray-500 italic mt-10 text-lg">"With love, we begin forever"</p>
            </div>
        </div>
        
    </div>

    <script>
        const apiUrl = '{{ route("customer.invitations.qr-checkin.latest", $invitation) }}';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        
        let currentGuestId = null;
        let lastCheckinTime = null;
        
        const guestWelcome = document.getElementById('guest-welcome');
        const idleWelcome = document.getElementById('idle-welcome');
        const guestNameEl = document.getElementById('guest-name');
        
        function showGuestWelcome(guest) {
            // Only animate if it's a new guest
            if (currentGuestId !== guest.id) {
                currentGuestId = guest.id;
                lastCheckinTime = Date.now();
                
                guestNameEl.textContent = guest.name;
                
                // Reset animation
                guestWelcome.classList.remove('hidden');
                guestWelcome.querySelector('div').classList.remove('scale-in');
                void guestWelcome.querySelector('div').offsetWidth; // Trigger reflow
                guestWelcome.querySelector('div').classList.add('scale-in');
                
                idleWelcome.classList.add('hidden');
            }
        }
        
        function showIdleWelcome() {
            if (!idleWelcome.classList.contains('hidden')) return;
            
            currentGuestId = null;
            
            idleWelcome.classList.remove('hidden');
            idleWelcome.querySelector('div').classList.remove('fade-in');
            void idleWelcome.querySelector('div').offsetWidth; // Trigger reflow
            idleWelcome.querySelector('div').classList.add('fade-in');
            
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
        
        // Initial check
        checkLatestCheckin();
        
        // Poll every 2 seconds
        setInterval(checkLatestCheckin, 2000);
        
        // Show idle welcome initially
        showIdleWelcome();
    </script>
</body>
</html>
