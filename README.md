# 💒 Undangan Digital Premium

**Platform Undangan Pernikahan Digital SaaS** — Modern, Elegan, Production-Ready

[![Laravel](https://img.shields.io/badge/Laravel-13-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.4-blue.svg)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4-38B2AC.svg)](https://tailwindcss.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-3-8BC0D0.svg)](https://alpinejs.dev)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

---

## 🎯 Tentang Project

**Undangan Digital Premium** adalah platform SaaS untuk membuat undangan pernikahan digital yang elegan, modern, dan berkesan. Dibangun dengan arsitektur clean, scalable, dan siap dijadikan bisnis.

### ✨ Highlights

- 🎨 **Premium UI/UX** — Desain mewah, elegan, smooth animation, mobile-first
- 🔐 **Multi-Auth** — Email/Password + Google OAuth + OTP Verification
- 💳 **Payment Gateway** — Integrasi Midtrans (Snap)
- 📱 **Mobile Responsive** — Optimal di semua device
- 🌙 **Dark Mode** — Support light & dark theme
- 🚀 **Production Ready** — Rate limiting, anti-spam, queue email, file storage

---

## 🛠️ Tech Stack

| Technology | Version | Purpose |
|-----------|---------|---------|
| Laravel | 13.x | Backend Framework |
| PHP | 8.4+ | Server Language |
| MySQL | 8.x | Database |
| Tailwind CSS | 4.x | Styling |
| Alpine.js | 3.x | Frontend Interactivity |
| Vite | 8.x | Asset Bundling |
| Midtrans | - | Payment Gateway |
| Laravel Socialite | - | Google OAuth |

---

## 📦 Fitur Lengkap

### 🔐 Authentication & Security
- Login & Register dengan email/password
- Login dengan Google (OAuth 2.0)
- Verifikasi OTP via email (6 digit, expired 10 menit, max 5 percobaan)
- Forgot & Reset Password
- Remember Me & Session Protection
- Rate Limiter Login (5 percobaan)
- Role-based Access (Super Admin & Customer)
- Middleware proteksi halaman

### 💒 Undangan Digital
- Buat, Edit, Hapus, Preview undangan
- Publish, Pause, Duplicate undangan
- Auto-generate slug SEO-friendly (`domain.com/ariel-rina`)
- Personal link tamu (`domain.com/ariel-rina?to=Bapak+Ahmad`)
- Custom warna, font, musik
- Cover image upload
- Tracking view count

### 🎨 Template Premium
- **Elegant Gold** — Aksen emas mewah & timeless (fully functional)
- **Minimal White** — Minimalis modern (functional)
- **Luxury Black** — Tema gelap dengan aksen emas
- **Floral Romantic** — Ornamen bunga cantik
- **Islamic Elegant** — Ornamen geometris Islami

Setiap template memiliki:
- Hero Cover dengan opening animation
- Profil Mempelai
- Countdown Timer (real-time)
- Detail Acara + Google Maps
- Gallery Slider
- RSVP Form
- Buku Tamu / Ucapan
- Amplop Digital (Bank + QRIS)
- Music Player (floating, autoplay)
- Footer branding

### 👥 Manajemen Tamu & RSVP
- Tambah tamu manual
- Import tamu via CSV/Excel
- Link personal per tamu
- RSVP: Hadir / Tidak / Mungkin
- Dashboard statistik RSVP
- Tracking buka undangan per tamu

### 📝 Buku Tamu
- Kirim ucapan & doa
- Anti-spam (rate limiter)
- Auto-approve dengan moderasi admin

### 🖼️ Galeri Foto
- Multi upload
- Drag & sort
- Responsive grid/slider

### 🎵 Music Player
- Upload MP3
- Autoplay toggle
- Floating player elegant

### 💳 Pembayaran (Midtrans)

| Paket | Harga | Fitur |
|-------|-------|-------|
| **Basic** | Rp 99.000 | 5 foto, 100 tamu, 1 template, countdown, guestbook |
| **Premium** | ~~Rp 199.000~~ **Rp 149.000** | RSVP, musik, love story, amplop digital, analytics, 500 tamu |
| **Exclusive** | ~~Rp 399.000~~ **Rp 299.000** | Unlimited semua, QR check-in, custom domain, priority support |

- Snap payment (semua metode pembayaran)
- Webhook auto-activate subscription
- Feature-lock berdasarkan paket
- Riwayat pembayaran

### 🏠 Landing Page
- Hero section premium
- Preview template
- Pricing comparison
- Testimoni pelanggan
- FAQ accordion
- CTA sections
- Responsive navbar

### 👨‍💼 Admin Panel
- Dashboard analytics & revenue
- Kelola users (activate/deactivate)
- Kelola undangan
- CRUD template
- Monitor pembayaran
- Revenue report (total & bulanan)

---

## 🚀 Instalasi

### Prerequisites
- PHP >= 8.3
- Composer >= 2.x
- MySQL >= 8.x
- Node.js >= 18.x
- NPM >= 9.x

### Step-by-Step

```bash
# 1. Clone repository
git clone https://github.com/projectarielsa/undangan-digital.git
cd undangan-digital

# 2. Install PHP dependencies
composer install

# 3. Install NPM dependencies
npm install

# 4. Copy environment file
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Konfigurasi .env (lihat bagian Environment Setup)

# 7. Buat database MySQL
mysql -u root -e "CREATE DATABASE undangan_digital"

# 8. Jalankan migration & seeder
php artisan migrate
php artisan db:seed

# 9. Link storage
php artisan storage:link

# 10. Build assets
npm run build

# 11. Jalankan server
php artisan serve

# 12. (Optional) Jalankan queue worker
php artisan queue:work
```

Akses: `http://localhost:8000`

---

## ⚙️ Environment Setup

Edit file `.env` dengan konfigurasi berikut:

### Database
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=undangan_digital
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Mail (Gmail SMTP)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Google OAuth
```env
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"
```

> Buat credentials di [Google Cloud Console](https://console.cloud.google.com/apis/credentials)

### Midtrans
```env
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_SNAP_URL=https://app.sandbox.midtrans.com/snap/snap.js
```

> Daftar di [Midtrans Dashboard](https://dashboard.midtrans.com)

---

## 👤 Default Accounts

| Role | Email | Password |
|------|-------|----------|
| Super Admin | `admin@undangandigital.com` | `password` |

---

## 📁 Struktur Project

```
undangan-digital/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Admin panel controllers
│   │   │   ├── Auth/           # Authentication controllers
│   │   │   ├── Customer/       # Customer dashboard controllers
│   │   │   ├── LandingPageController.php
│   │   │   ├── PublicInvitationController.php
│   │   │   └── MidtransWebhookController.php
│   │   └── Middleware/         # Custom middleware
│   ├── Jobs/                   # Queue jobs (SendOtpEmail)
│   ├── Mail/                   # Mailable classes
│   ├── Models/                 # 11 Eloquent models
│   ├── Policies/               # Authorization policies
│   ├── Providers/              # Service providers
│   └── Services/               # Business logic services
├── database/
│   ├── migrations/             # 13 migration files
│   └── seeders/                # Admin, Package, Template, Testimonial
├── resources/
│   ├── css/app.css             # Tailwind CSS
│   ├── js/app.js               # Alpine.js
│   └── views/
│       ├── admin/              # Admin panel views
│       ├── auth/               # Auth pages (login, register, OTP, etc)
│       ├── components/         # Reusable Blade components
│       ├── customer/           # Customer dashboard views
│       ├── emails/             # Email templates
│       ├── layouts/            # Base layouts (app, auth, dashboard)
│       ├── templates/          # Invitation templates
│       └── landing.blade.php   # Landing page
├── routes/web.php              # 60 routes
└── config/services.php         # Third-party services config
```

---

## 🗄️ Database Schema

| Table | Deskripsi |
|-------|-----------|
| `users` | User accounts (admin & customer) |
| `email_otps` | OTP verification codes |
| `packages` | Subscription packages |
| `invitation_templates` | Template designs |
| `invitations` | Wedding invitations |
| `guests` | Guest list & RSVP |
| `guestbooks` | Guest messages/wishes |
| `galleries` | Photo galleries |
| `payments` | Payment transactions |
| `subscriptions` | Active subscriptions |
| `testimonials` | Landing page testimonials |
| `sessions` | User sessions |
| `cache` | Application cache |

---

## 🔮 Roadmap (Future Features)

- [ ] AI generate kata-kata undangan
- [ ] AI caption Instagram
- [ ] WhatsApp reminder H-7/H-3/H-1
- [ ] QR check-in tamu
- [ ] Guest analytics & tracking
- [ ] WhatsApp blast tamu
- [ ] Multi-bahasa (i18n)
- [ ] Custom domain per undangan
- [ ] Export data tamu ke PDF
- [ ] Video undangan

---

## 🤝 Contributing

1. Fork repository
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

---

## 📄 License

Distributed under the MIT License. See `LICENSE` for more information.

---

## 📞 Support

- Email: support@undangandigital.com
- Issues: [GitHub Issues](https://github.com/projectarielsa/undangan-digital/issues)

---

<p align="center">
  <b>Made with ❤️ for Indonesian Weddings</b><br>
  <sub>Built with Laravel 13 • Tailwind CSS 4 • Alpine.js 3</sub>
</p>
