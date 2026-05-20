@extends('layouts.dashboard')
@section('page-title', 'Scanner QR')
@section('sidebar-nav')<x-customer-nav />@endsection

@section('content')
<div class="max-w-lg mx-auto">
    <div class="mb-6">
        <a href="{{ route('customer.qr-checkin.index', $invitation) }}" class="text-sm text-gray-500 hover:text-amber-600 flex items-center gap-1 mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Scan QR Check-in</h1>
        <p class="text-gray-500">{{ $invitation->title }}</p>
    </div>

    <!-- Scanner Area -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6 mb-6">
        <div id="reader" class="rounded-xl overflow-hidden"></div>
        <p class="text-sm text-gray-500 text-center mt-4">Arahkan kamera ke QR code tamu</p>
    </div>

    <!-- Result Area -->
    <div id="result" class="hidden">
        <div id="result-success" class="hidden bg-green-50 border border-green-200 rounded-2xl p-6 text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h3 class="text-lg font-bold text-green-800 mb-2">Check-in Berhasil!</h3>
            <p id="guest-name" class="text-green-700 font-medium text-xl mb-1"></p>
            <p id="guest-info" class="text-green-600 text-sm"></p>
        </div>
        <div id="result-error" class="hidden bg-red-50 border border-red-200 rounded-2xl p-6 text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </div>
            <h3 class="text-lg font-bold text-red-800 mb-2">Gagal!</h3>
            <p id="error-message" class="text-red-700"></p>
        </div>
        <button onclick="resetScanner()" class="w-full mt-4 px-4 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-xl hover:bg-gray-200 transition">
            Scan Lagi
        </button>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
let html5QrcodeScanner;

function onScanSuccess(decodedText, decodedResult) {
    html5QrcodeScanner.pause();
    
    // Extract QR code from URL or use directly
    let qrCode = decodedText;
    if (decodedText.includes('/')) {
        const parts = decodedText.split('/');
        qrCode = parts[parts.length - 1].split('?')[0];
    }
    
    fetch('{{ route("checkin.process") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ qr_code: qrCode })
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('result').classList.remove('hidden');
        if (data.success) {
            document.getElementById('result-success').classList.remove('hidden');
            document.getElementById('result-error').classList.add('hidden');
            document.getElementById('guest-name').textContent = data.guest.name;
            document.getElementById('guest-info').textContent = data.guest.number_of_guests + ' orang • ' + data.guest.checked_in_at;
        } else {
            document.getElementById('result-error').classList.remove('hidden');
            document.getElementById('result-success').classList.add('hidden');
            document.getElementById('error-message').textContent = data.message;
            if (data.guest) {
                document.getElementById('error-message').textContent += ' (' + data.guest.name + ' - ' + data.guest.checked_in_at + ')';
            }
        }
    })
    .catch(err => {
        document.getElementById('result').classList.remove('hidden');
        document.getElementById('result-error').classList.remove('hidden');
        document.getElementById('result-success').classList.add('hidden');
        document.getElementById('error-message').textContent = 'Terjadi kesalahan. Silakan coba lagi.';
    });
}

function resetScanner() {
    document.getElementById('result').classList.add('hidden');
    document.getElementById('result-success').classList.add('hidden');
    document.getElementById('result-error').classList.add('hidden');
    html5QrcodeScanner.resume();
}

document.addEventListener('DOMContentLoaded', function() {
    html5QrcodeScanner = new Html5Qrcode("reader");
    html5QrcodeScanner.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: { width: 250, height: 250 } },
        onScanSuccess
    );
});
</script>
@endsection
