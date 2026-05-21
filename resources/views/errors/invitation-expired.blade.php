<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan Tidak Aktif</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center px-4">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl border border-gray-100 p-8 text-center">
        <div class="w-16 h-16 mx-auto mb-6 rounded-full bg-red-100 flex items-center justify-center">
            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12A9 9 0 113 12a9 9 0 0118 0z"/>
            </svg>
        </div>

        <h1 class="text-2xl font-bold text-gray-900 mb-3">
            Undangan Tidak Aktif
        </h1>

        <p class="text-gray-600 mb-6 leading-relaxed">
            Masa aktif undangan gratis sudah habis. Silakan upgrade ke paket Basic untuk mengaktifkan kembali undangan ini.
        </p>

        <div class="rounded-2xl bg-gray-50 border border-gray-100 p-4 mb-6">
            <p class="text-sm text-gray-500 mb-1">Undangan</p>
            <p class="font-semibold text-gray-900">
                {{ $invitation->title ?? 'Undangan Digital' }}
            </p>
        </div>

        <a href="{{ url('/') }}" class="inline-flex items-center justify-center w-full px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition">
            Kembali
        </a>
    </div>
</body>
</html>