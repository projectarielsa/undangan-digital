<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Card - {{ $guest->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { margin: 0; padding: 20px; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-8">
    <div class="no-print fixed top-4 right-4 flex gap-2">
        <button onclick="window.print()" class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700">
            Print / Download
        </button>
        <a href="{{ route('customer.qr-checkin.index', $invitation) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-xl p-8 max-w-sm w-full text-center">
        <!-- Header -->
        <div class="mb-6">
            <p class="text-sm text-amber-600 uppercase tracking-widest mb-2">The Wedding of</p>
            <h1 class="text-2xl font-bold text-gray-900">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</h1>
        </div>

        <!-- QR Code -->
        <div class="bg-gray-50 rounded-2xl p-6 mb-6">
            @php
                $checkinUrl = route('checkin.scan', ['code' => $guest->qr_code ?? 'pending']);
                $qrUrl = 'https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=' . urlencode($checkinUrl) . '&choe=UTF-8';
            @endphp
            <img src="{{ $qrUrl }}" alt="QR Code" class="w-48 h-48 mx-auto">
        </div>

        <!-- Guest Info -->
        <div class="mb-6">
            <p class="text-sm text-gray-500 mb-1">Kepada Yth.</p>
            <h2 class="text-xl font-bold text-gray-900">{{ $guest->name }}</h2>
            @if($guest->number_of_guests > 1)
            <p class="text-sm text-gray-500 mt-1">+{{ $guest->number_of_guests - 1 }} tamu</p>
            @endif
        </div>

        <!-- Event Info -->
        <div class="border-t border-gray-100 pt-6">
            <p class="text-gray-600 font-medium">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
            <p class="text-gray-500 text-sm">{{ $invitation->event_venue }}</p>
        </div>

        <!-- Footer -->
        <div class="mt-6 pt-6 border-t border-gray-100">
            <p class="text-xs text-gray-400">Tunjukkan QR code ini saat registrasi</p>
        </div>
    </div>
</body>
</html>
