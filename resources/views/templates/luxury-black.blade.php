<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Raleway:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --color-primary: {{ $invitation->color_primary ?? '#C9A96E' }}; --color-secondary: {{ $invitation->color_secondary ?? '#0d0d0d' }}; }
        body { font-family: 'Raleway', sans-serif; }
        .font-serif { font-family: 'Cinzel', serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#0d0d0d] text-gray-200" x-data="invitationApp()" x-cloak>
    @include('templates.partials.invitation-content', ['theme' => 'luxury-black'])
</body>
</html>
