<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --color-primary: {{ $invitation->color_primary ?? '#8B4513' }}; --color-secondary: {{ $invitation->color_secondary ?? '#FFF8F0' }}; }
        body { font-family: 'Open Sans', sans-serif; }
        .font-serif { font-family: 'Great Vibes', cursive; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#FFF8F0] text-gray-800" x-data="invitationApp()" x-cloak>
    @include('templates.partials.invitation-content', ['theme' => 'floral-romantic'])
</body>
</html>
