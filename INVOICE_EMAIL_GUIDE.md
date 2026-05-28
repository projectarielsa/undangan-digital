# 📧 Invoice Email Implementation Guide

## Overview

Fitur ini mengirimkan **email invoice otomatis** kepada user setelah pembayaran berhasil melalui Midtrans. Email dikirim secara **asynchronous** menggunakan Laravel Queue untuk performa optimal.

---

## 🎯 Fitur yang Diimplementasikan

### ✅ Yang Sudah Dibuat:

1. **Mailable Class** (`PaymentInvoiceMail.php`)
   - Mengirim invoice dengan detail lengkap pembayaran
   - Auto-load relationships (user, package, invitation)

2. **Email Template** (`payment-invoice.blade.php`)
   - Design profesional & responsive
   - Menampilkan:
     - Order ID & Transaction ID
     - Customer info
     - Package details & features
     - Price breakdown (amount, discount, total)
     - Payment method & date
     - Subscription duration
     - CTA button ke dashboard

3. **Queue Job** (`SendPaymentInvoiceJob.php`)
   - Asynchronous email sending
   - Auto-retry 3x dengan backoff 60 detik
   - Comprehensive error logging
   - Failed job handler

4. **Webhook Integration**
   - Auto-trigger setelah payment berhasil
   - Tidak menghambat webhook response

---

## 📁 File yang Dibuat

```
app/
├── Mail/
│   └── PaymentInvoiceMail.php               # Mailable class
├── Jobs/
│   └── SendPaymentInvoiceJob.php            # Queue job
└── Http/Controllers/
    └── MidtransWebhookController.php        # Updated dengan trigger job

resources/views/emails/
└── payment-invoice.blade.php                # Email template HTML
```

---

## 🚀 Cara Penggunaan

### 1. Setup Queue Worker (Production)

Jalankan queue worker untuk memproses job:

```bash
php artisan queue:work --queue=default --tries=3 --timeout=60
```

Atau menggunakan **supervisor** (recommended untuk production):

```bash
sudo nano /etc/supervisor/conf.d/undangan-digital-worker.conf
```

Isi dengan:

```ini
[program:undangan-digital-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/undangan-digital/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path/to/undangan-digital/storage/logs/worker.log
stopwaitsecs=3600
```

Reload supervisor:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start undangan-digital-worker:*
```

### 2. Testing (Development)

#### Opsi 1: Sync Queue (Tidak Recommended)

Update `.env`:

```env
QUEUE_CONNECTION=sync
```

Email akan dikirim langsung tanpa queue.

#### Opsi 2: Database Queue (Recommended untuk Testing)

Update `.env`:

```env
QUEUE_CONNECTION=database
```

Jalankan migration untuk tabel jobs:

```bash
php artisan queue:table
php artisan migrate
```

Jalankan worker di terminal terpisah:

```bash
php artisan queue:work
```

#### Testing Manual:

```bash
php artisan tinker
```

```php
$payment = App\Models\Payment::where('status', 'paid')->first();
App\Jobs\SendPaymentInvoiceJob::dispatch($payment);
```

Cek log:

```bash
tail -f storage/logs/laravel.log
```

---

## 🔧 Konfigurasi Email

### Gmail SMTP Setup

1. Enable **2-Step Verification** di Google Account
2. Generate **App Password**: https://myaccount.google.com/apppasswords
3. Update `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_16_digit_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@undangandigital.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Testing Email Configuration

```bash
php artisan tinker
```

```php
Mail::raw('Test email', function($message) {
    $message->to('test@example.com')->subject('Test');
});
```

---

## 📊 Monitoring & Debugging

### 1. Cek Failed Jobs

```bash
php artisan queue:failed
```

### 2. Retry Failed Job

```bash
php artisan queue:retry {job_id}
```

Atau retry semua:

```bash
php artisan queue:retry all
```

### 3. Clear Failed Jobs

```bash
php artisan queue:flush
```

### 4. Monitor Real-time

```bash
php artisan queue:listen --verbose
```

### 5. Logs

Semua logs tersimpan di:
- `storage/logs/laravel.log` - General logs
- `storage/logs/worker.log` - Queue worker logs (jika pakai supervisor)

Cari logs terkait invoice:

```bash
grep "Payment invoice" storage/logs/laravel.log
```

---

## 🎨 Customization

### Mengubah Email Template

Edit file: `resources/views/emails/payment-invoice.blade.php`

Variabel yang tersedia:
- `$payment` - Model Payment
- `$user` - Model User
- `$package` - Model Package
- `$invitation` - Model Invitation (nullable)

### Mengubah Subject Email

Edit file: `app/Mail/PaymentInvoiceMail.php`

```php
public function envelope(): Envelope
{
    return new Envelope(
        subject: 'Custom Subject - ' . $this->payment->order_id,
    );
}
```

### Menambah Attachment (PDF Invoice)

Install DomPDF jika belum:

```bash
composer require barryvdh/laravel-dompdf
```

Update `PaymentInvoiceMail.php`:

```php
use Illuminate\Mail\Mailables\Attachment;
use Barryvdh\DomPDF\Facade\Pdf;

public function attachments(): array
{
    $pdf = Pdf::loadView('invoices.pdf', [
        'payment' => $this->payment,
        'user' => $this->payment->user,
        'package' => $this->payment->package,
    ]);

    return [
        Attachment::fromData(fn () => $pdf->output(), 'invoice-' . $this->payment->order_id . '.pdf')
            ->withMime('application/pdf'),
    ];
}
```

---

## ⚡ Performance Tips

### 1. Gunakan Redis Queue (Recommended untuk Production)

Install Redis:

```bash
sudo apt-get install redis-server
composer require predis/predis
```

Update `.env`:

```env
QUEUE_CONNECTION=redis
REDIS_CLIENT=predis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### 2. Batch Processing

Jika ada banyak email pending:

```bash
php artisan queue:work --once
```

Atau dengan rate limiting:

```php
// app/Jobs/SendPaymentInvoiceJob.php
use Illuminate\Queue\Middleware\RateLimited;

public function middleware(): array
{
    return [new RateLimited('emails')];
}
```

Register rate limiter di `app/Providers/AppServiceProvider.php`:

```php
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

RateLimiter::for('emails', function (object $job) {
    return Limit::perMinute(60); // Max 60 email per menit
});
```

---

## 🧪 Testing Checklist

- [ ] Email dikirim setelah payment berhasil
- [ ] Email berisi data yang benar (order ID, amount, package)
- [ ] Email template tampil dengan baik di:
  - [ ] Gmail
  - [ ] Outlook
  - [ ] Yahoo Mail
  - [ ] Mobile devices
- [ ] CTA button berfungsi (link ke dashboard)
- [ ] Failed job di-retry dengan benar
- [ ] Logs tercatat dengan lengkap
- [ ] Queue worker berjalan stabil

---

## 🐛 Troubleshooting

### Email Tidak Terkirim

1. Cek queue worker running:
   ```bash
   ps aux | grep "queue:work"
   ```

2. Cek failed jobs:
   ```bash
   php artisan queue:failed
   ```

3. Cek email config:
   ```bash
   php artisan config:clear
   php artisan config:cache
   ```

4. Test SMTP connection manual:
   ```bash
   telnet smtp.gmail.com 587
   ```

### Email Masuk Spam

1. Setup **SPF record** di DNS:
   ```
   v=spf1 include:_spf.google.com ~all
   ```

2. Setup **DKIM** di Google Workspace

3. Setup **DMARC record**:
   ```
   v=DMARC1; p=none; rua=mailto:dmarc@yourdomain.com
   ```

### Worker Mati Terus

1. Increase memory limit:
   ```bash
   php artisan queue:work --memory=512
   ```

2. Restart worker setiap 1 jam:
   ```bash
   php artisan queue:work --max-time=3600
   ```

3. Gunakan supervisor (recommended)

---

## 📈 Future Enhancements

- [ ] PDF invoice attachment
- [ ] Multi-language email templates
- [ ] Email tracking (open rate, click rate)
- [ ] WhatsApp notification integration
- [ ] Monthly usage summary email
- [ ] Subscription expiry reminder (H-7, H-3, H-1)
- [ ] Payment failure notification
- [ ] Refund notification email

---

## 📞 Support

Jika ada masalah atau pertanyaan, silakan buat issue di repository atau hubungi tim development.

---

**Made with ❤️ for Undangan Digital Premium**
