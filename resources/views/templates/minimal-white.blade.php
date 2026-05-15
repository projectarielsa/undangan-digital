<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --color-primary: {{ $invitation->color_primary ?? '#2d2d2d' }}; --color-secondary: {{ $invitation->color_secondary ?? '#ffffff' }}; }
        body { font-family: 'Montserrat', sans-serif; }
        .font-serif { font-family: 'Cormorant Garamond', serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-white text-gray-800" x-data="invitationApp()" x-cloak>
    @include('templates.partials.invitation-content', ['theme' => 'minimal-white'])
</body>
</html>
