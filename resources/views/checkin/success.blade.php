<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check-in Berhasil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-100 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-xl p-8 max-w-md w-full text-center">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Check-in Berhasil!</h1>
        <p class="text-gray-500 mb-6">Selamat datang di acara pernikahan</p>
        
        <div class="bg-gray-50 rounded-2xl p-6 mb-6">
            <p class="text-3xl font-bold text-blue-600 mb-2">{{ $guest->name }}</p>
            <p class="text-gray-600">{{ $guest->number_of_guests }} Orang</p>
            <p class="text-sm text-gray-400 mt-2">Check-in: {{ $guest->checked_in_at->format('H:i') }}</p>
        </div>

        <div class="text-sm text-gray-500">
            <p class="font-medium text-gray-900">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</p>
            <p>{{ $invitation->event_venue }}</p>
        </div>
    </div>
</body>
</html>
