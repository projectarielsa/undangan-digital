@extends('layouts.dashboard')
@section('page-title', 'QR Scanner')
@section('sidebar-nav')<x-customer-nav />@endsection

@section('content')
<div class="max-w-2xl mx-auto" x-data="qrScanner()">
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('customer.invitations.qr-checkin', $invitation) }}" class="text-sm text-gray-500 hover:text-amber-600 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    <!-- Stats Bar -->
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl border p-4 text-center">
            <p class="text-2xl font-bold text-gray-900 dark:text-white" id="stat-total">{{ $stats['total_guests'] }}</p>
            <p class="text-xs text-gray-500">Total</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border p-4 text-center">
            <p class="text-2xl font-bold text-green-600" id="stat-checked">{{ $stats['checked_in'] }}</p>
            <p class="text-xs text-gray-500">Checked In</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border p-4 text-center">
            <p class="text-2xl font-bold text-amber-600" id="stat-remaining">{{ $stats['total_guests'] - $stats['checked_in'] }}</p>
            <p class="text-xs text-gray-500">Belum</p>
        </div>
    </div>

    <!-- Scanner Area -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border overflow-hidden">
        <div class="aspect-square relative bg-gray-900" id="scanner-container">
            <video id="video" class="w-full h-full object-cover" playsinline></video>
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                <div class="w-64 h-64 border-2 border-white/50 rounded-2xl relative">
                    <div class="absolute -top-1 -left-1 w-8 h-8 border-t-4 border-l-4 border-amber-500 rounded-tl-xl"></div>
                    <div class="absolute -top-1 -right-1 w-8 h-8 border-t-4 border-r-4 border-amber-500 rounded-tr-xl"></div>
                    <div class="absolute -bottom-1 -left-1 w-8 h-8 border-b-4 border-l-4 border-amber-500 rounded-bl-xl"></div>
                    <div class="absolute -bottom-1 -right-1 w-8 h-8 border-b-4 border-r-4 border-amber-500 rounded-br-xl"></div>
                </div>
            </div>
            
            <!-- Scanning indicator -->
            <div x-show="scanning" class="absolute bottom-4 left-4 right-4 bg-white/90 rounded-xl p-3 flex items-center gap-3">
                <div class="w-6 h-6 border-2 border-amber-500 border-t-transparent rounded-full animate-spin"></div>
                <span class="text-sm font-medium text-gray-700">Memindai...</span>
            </div>
        </div>

        <div class="p-6">
            <div x-show="!cameraActive" class="text-center">
                <button @click="startCamera()" class="px-6 py-3 bg-amber-600 text-white font-semibold rounded-xl hover:bg-amber-700 transition">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Aktifkan Kamera
                    </span>
                </button>
                <p class="text-sm text-gray-500 mt-3">Izinkan akses kamera untuk memindai QR Code</p>
            </div>

            <div x-show="cameraActive" class="text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">Arahkan kamera ke QR Code tamu untuk check-in</p>
                <button @click="stopCamera()" class="mt-4 text-sm text-red-600 hover:text-red-700">Matikan Kamera</button>
            </div>
        </div>
    </div>

    <!-- Result Modal -->
    <div x-show="result" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" @click.self="closeResult()">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 max-w-sm w-full shadow-2xl">
            <div x-show="result?.success" class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Check-in Berhasil!</h3>
                <p class="text-2xl font-bold text-amber-600 mb-1" x-text="result?.guest?.name"></p>
                <p class="text-gray-500" x-text="result?.guest?.number_of_guests + ' orang'"></p>
                <p class="text-sm text-gray-400 mt-2" x-text="'Jam ' + result?.guest?.checked_in_at"></p>
                <div x-show="result?.guest?.was_already_checked_in" class="mt-3 p-2 bg-yellow-50 rounded-lg">
                    <p class="text-sm text-yellow-700">Tamu ini sudah check-in sebelumnya</p>
                </div>
            </div>
            
            <div x-show="!result?.success" class="text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">QR Code Tidak Valid</h3>
                <p class="text-gray-500" x-text="result?.message"></p>
            </div>

            <button @click="closeResult()" class="w-full mt-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                Tutup
            </button>
        </div>
    </div>

    <!-- Recent Check-ins -->
    <div class="mt-6 bg-white dark:bg-gray-800 rounded-2xl border">
        <div class="p-4 border-b border-gray-100 dark:border-gray-700">
            <h3 class="font-semibold text-gray-900 dark:text-white">Check-in Terbaru</h3>
        </div>
        <div class="divide-y divide-gray-100 dark:divide-gray-700 max-h-64 overflow-y-auto" id="recent-checkins">
            <template x-for="checkin in recentCheckins" :key="checkin.id">
                <div class="p-4 flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white" x-text="checkin.name"></p>
                        <p class="text-sm text-gray-500" x-text="checkin.number_of_guests + ' orang'"></p>
                    </div>
                    <span class="text-sm text-green-600" x-text="checkin.checked_in_at"></span>
                </div>
            </template>
            <div x-show="recentCheckins.length === 0" class="p-8 text-center text-gray-500">
                Belum ada check-in
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/@nicecode/qrcode-reader@1.0.4/dist/qrcode-reader.umd.js"></script>
<script>
function qrScanner() {
    return {
        cameraActive: false,
        scanning: false,
        result: null,
        recentCheckins: [],
        video: null,
        stream: null,
        qrReader: null,
        scanInterval: null,

        async startCamera() {
            try {
                this.video = document.getElementById('video');
                this.stream = await navigator.mediaDevices.getUserMedia({
                    video: { facingMode: 'environment' }
                });
                this.video.srcObject = this.stream;
                await this.video.play();
                this.cameraActive = true;
                this.startScanning();
            } catch (error) {
                alert('Tidak dapat mengakses kamera: ' + error.message);
            }
        },

        stopCamera() {
            if (this.stream) {
                this.stream.getTracks().forEach(track => track.stop());
            }
            if (this.scanInterval) {
                clearInterval(this.scanInterval);
            }
            this.cameraActive = false;
        },

        startScanning() {
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            
            this.scanInterval = setInterval(async () => {
                if (!this.cameraActive || this.scanning) return;
                
                canvas.width = this.video.videoWidth;
                canvas.height = this.video.videoHeight;
                context.drawImage(this.video, 0, 0);
                
                const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                
                try {
                    const code = jsQR(imageData.data, imageData.width, imageData.height);
                    if (code) {
                        this.scanning = true;
                        await this.processQrCode(code.data);
                    }
                } catch (e) {
                    console.log('Scan error:', e);
                }
            }, 500);
        },

        async processQrCode(data) {
            // Extract code from URL
            const match = data.match(/checkin\/verify\/([a-zA-Z0-9-]+)/);
            const code = match ? match[1] : data;

            try {
                const response = await fetch('{{ route("api.checkin.verify") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ code })
                });

                const result = await response.json();
                this.result = result;

                if (result.success) {
                    // Update stats
                    const checkedEl = document.getElementById('stat-checked');
                    const remainingEl = document.getElementById('stat-remaining');
                    if (!result.guest.was_already_checked_in) {
                        checkedEl.textContent = parseInt(checkedEl.textContent) + 1;
                        remainingEl.textContent = parseInt(remainingEl.textContent) - 1;
                    }

                    // Add to recent checkins
                    this.recentCheckins.unshift(result.guest);
                    if (this.recentCheckins.length > 10) {
                        this.recentCheckins.pop();
                    }

                    // Play success sound
                    this.playSound('success');
                } else {
                    this.playSound('error');
                }
            } catch (error) {
                this.result = { success: false, message: 'Terjadi kesalahan. Silakan coba lagi.' };
                this.playSound('error');
            }
        },

        closeResult() {
            this.result = null;
            this.scanning = false;
        },

        playSound(type) {
            // Simple beep using Web Audio API
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();
            
            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);
            
            oscillator.frequency.value = type === 'success' ? 880 : 220;
            oscillator.type = 'sine';
            gainNode.gain.value = 0.3;
            
            oscillator.start();
            oscillator.stop(audioContext.currentTime + 0.2);
        }
    }
}
</script>
<script src="https://unpkg.com/jsqr@1.4.0/dist/jsQR.js"></script>
@endsection
