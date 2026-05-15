<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --color-primary: {{ $invitation->color_primary ?? '#1B5E20' }}; --color-secondary: {{ $invitation->color_secondary ?? '#F5F5DC' }}; }
        body { font-family: 'Poppins', sans-serif; }
        .font-serif { font-family: 'Amiri', serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#F5F5DC] text-gray-800" x-data="invitationApp()" x-cloak>
    @include('templates.partials.invitation-content', ['theme' => 'islamic-elegant'])
</body>
</html>
