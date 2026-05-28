# 🚀 Quick Start: Invoice Email

## 1️⃣ Install Dependencies (Jika Belum)

```bash
composer install
npm install
```

## 2️⃣ Setup Environment

Pastikan `.env` sudah dikonfigurasi dengan benar:

```env
# Email Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@undangandigital.com"
MAIL_FROM_NAME="${APP_NAME}"

# Queue Configuration (untuk production gunakan redis/database)
QUEUE_CONNECTION=database
```

## 3️⃣ Run Migration (Jobs Table)

```bash
php artisan migrate
```

## 4️⃣ Testing Invoice Email

### Opsi A: Test dengan Payment Real

```bash
# Kirim invoice untuk payment terakhir yang paid
php artisan invoice:test

# Kirim invoice untuk order ID tertentu
php artisan invoice:test --order-id=ORDER-123456

# Kirim ke email berbeda (testing)
php artisan invoice:test --order-id=ORDER-123456 --email=test@example.com

# Kirim via queue (recommended)
php artisan invoice:test --queue
```

### Opsi B: Test Manual via Tinker

```bash
php artisan tinker
```

```php
// Ambil payment terakhir yang paid
$payment = App\Models\Payment::where('status', 'paid')->latest()->first();

// Kirim email langsung (sync)
Mail::to($payment->user->email)->send(new App\Mail\PaymentInvoiceMail($payment));

// Atau via queue (async)
App\Jobs\SendPaymentInvoiceJob::dispatch($payment);
```

## 5️⃣ Run Queue Worker

**Development:**
```bash
php artisan queue:work --verbose
```

**Production dengan Supervisor:**

Create file: `/etc/supervisor/conf.d/undangan-worker.conf`

```ini
[program:undangan-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/undangan-digital/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path/to/undangan-digital/storage/logs/worker.log
```

Reload supervisor:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start undangan-worker:*
```

## 6️⃣ Monitor Logs

```bash
# Real-time logs
tail -f storage/logs/laravel.log

# Filter invoice logs
grep "Payment invoice" storage/logs/laravel.log

# Check failed jobs
php artisan queue:failed
```

## 7️⃣ Troubleshooting

### Email tidak terkirim?

1. **Cek queue worker berjalan:**
   ```bash
   ps aux | grep "queue:work"
   ```

2. **Cek failed jobs:**
   ```bash
   php artisan queue:failed
   php artisan queue:retry all
   ```

3. **Test SMTP connection:**
   ```bash
   php artisan tinker
   Mail::raw('Test', fn($m) => $m->to('test@example.com')->subject('Test'));
   ```

4. **Clear config cache:**
   ```bash
   php artisan config:clear
   php artisan config:cache
   ```

### Email masuk spam?

Setup SPF, DKIM, dan DMARC di DNS domain Anda. Lihat `INVOICE_EMAIL_GUIDE.md` untuk detail.

## 8️⃣ Production Checklist

- [ ] Update `.env` dengan kredensial email production
- [ ] Setup queue worker dengan supervisor
- [ ] Setup SPF/DKIM/DMARC untuk domain
- [ ] Test kirim invoice ke email real
- [ ] Monitor failed jobs selama 24 jam pertama
- [ ] Setup error notification (Sentry/Slack)

---

## 📝 Files Modified/Created

- ✅ `app/Mail/PaymentInvoiceMail.php` - Mailable class
- ✅ `app/Jobs/SendPaymentInvoiceJob.php` - Queue job
- ✅ `resources/views/emails/payment-invoice.blade.php` - Email template
- ✅ `app/Http/Controllers/MidtransWebhookController.php` - Trigger di webhook
- ✅ `database/migrations/2026_01_01_000001_create_jobs_table.php` - Jobs table
- ✅ `tests/Feature/PaymentInvoiceEmailTest.php` - Automated tests
- ✅ `app/Console/Commands/TestInvoiceEmail.php` - Testing command

---

## 🎯 How It Works

```
Midtrans Webhook 
    ↓
MidtransWebhookController::handle()
    ↓
Payment status = "paid"
    ↓
SendPaymentInvoiceJob::dispatch($payment)
    ↓
Queue Worker picks up job
    ↓
SendPaymentInvoiceJob::handle()
    ↓
Mail::send(new PaymentInvoiceMail($payment))
    ↓
Email delivered to user ✓
```

---

**Need Help?** Baca dokumentasi lengkap di `INVOICE_EMAIL_GUIDE.md`

**Ready!** 🚀 Fitur invoice email sudah siap digunakan!
