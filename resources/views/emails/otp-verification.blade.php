<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; background: #f9fafb; }
        .card { background: #fff; border-radius: 16px; padding: 40px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { text-align: center; padding-bottom: 24px; border-bottom: 1px solid #f3f4f6; margin-bottom: 24px; }
        .code-box { background: #fffbeb; border: 2px solid #D4AF37; border-radius: 12px; padding: 24px; text-align: center; margin: 24px 0; }
        .code { font-size: 36px; font-weight: bold; letter-spacing: 8px; color: #1a1a2e; }
        .footer { text-align: center; font-size: 12px; color: #9ca3af; margin-top: 24px; padding-top: 24px; border-top: 1px solid #f3f4f6; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h1 style="color: #D4AF37; margin: 0; font-size: 24px;">Undangan Digital Premium</h1>
        </div>

        <p>Halo <strong>{{ $user->name }}</strong>,</p>
        <p>Terima kasih telah mendaftar. Gunakan kode verifikasi berikut untuk mengaktifkan akun Anda:</p>

        <div class="code-box">
            <p class="code">{{ $code }}</p>
        </div>

        <p>Kode ini berlaku selama <strong>10 menit</strong>. Jangan bagikan kode ini kepada siapapun.</p>
        <p>Jika Anda tidak merasa mendaftar, abaikan email ini.</p>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Undangan Digital Premium. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
