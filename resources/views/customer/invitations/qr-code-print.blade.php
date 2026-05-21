<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code - {{ $guest->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: system-ui, sans-serif; padding: 2rem; }
        .card { max-width: 400px; margin: 0 auto; border: 2px solid #d4af37; border-radius: 16px; padding: 2rem; text-align: center; }
        .title { font-size: 0.875rem; color: #888; margin-bottom: 0.5rem; }
        .event { font-size: 1.25rem; font-weight: bold; color: #333; margin-bottom: 1.5rem; }
        .qr-code { margin: 1.5rem 0; }
        .qr-code svg { max-width: 250px; height: auto; }
        .guest-name { font-size: 1.5rem; font-weight: bold; color: #d4af37; margin-bottom: 0.5rem; }
        .guest-info { color: #666; font-size: 0.875rem; }
        .footer { margin-top: 1.5rem; font-size: 0.75rem; color: #999; }
        @media print { .no-print { display: none; } body { padding: 0; } }
    </style>
</head>
<body>
    <div class="card">
        <p class="title">Undangan Pernikahan</p>
        <p class="event">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</p>
        <div class="qr-code">{!! $qrSvg !!}</div>
        <p class="guest-name">{{ $guest->name }}</p>
        <p class="guest-info">{{ $guest->number_of_guests }} Orang</p>
        <p class="footer">Scan QR code ini untuk check-in di acara</p>
    </div>
    <div class="no-print" style="text-align: center; margin-top: 2rem;">
        <button onclick="window.print()" style="padding: 0.75rem 2rem; background: #d4af37; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold;">Print QR Code</button>
    </div>
</body>
</html>
