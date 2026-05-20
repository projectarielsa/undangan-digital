<?php
namespace Database\Seeders;
use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Basic', 'slug' => 'basic',
                'description' => 'Cocok untuk undangan sederhana dan elegan',
                'price' => 50000, 'discount_price' => null, 'duration_days' => 365,
                'max_photos' => 5, 'max_guests' => 100, 'max_templates' => 1,
                'has_rsvp' => false, 'has_music' => false, 'has_guestbook' => true,
                'has_gallery' => true, 'has_countdown' => true, 'has_love_story' => false,
                'has_digital_envelope' => false, 'has_qr_checkin' => false,
                'has_custom_domain' => false, 'has_analytics' => false,
                'is_featured' => false, 'sort_order' => 1,
                'features' => ['1 Template Pilihan', 'Maksimal 5 Foto', '100 Tamu', 'Buku Tamu', 'Countdown Timer', 'Galeri Foto', 'Berlaku 1 Tahun'],
            ],
            [
                'name' => 'Premium', 'slug' => 'premium',
                'description' => 'Paket terlaris dengan fitur lengkap',
                'price' => 100000, 'discount_price' => null, 'duration_days' => 365,
                'max_photos' => 30, 'max_guests' => 500, 'max_templates' => 5,
                'has_rsvp' => true, 'has_music' => true, 'has_guestbook' => true,
                'has_gallery' => true, 'has_countdown' => true, 'has_love_story' => true,
                'has_digital_envelope' => true, 'has_qr_checkin' => false,
                'has_custom_domain' => false, 'has_analytics' => true,
                'is_featured' => true, 'sort_order' => 2,
                'features' => ['5 Template Premium', 'Unlimited Foto', '500 Tamu', 'RSVP Online', 'Background Music', 'Love Story Timeline', 'Amplop Digital', 'Analytics Pengunjung', 'Berlaku 1 Tahun'],
            ],
            [
                'name' => 'Exclusive', 'slug' => 'exclusive',
                'description' => 'Semua fitur tanpa batas untuk pernikahan impian',
                'price' => 150000, 'discount_price' => null, 'duration_days' => 365,
                'max_photos' => 999, 'max_guests' => 9999, 'max_templates' => 999,
                'has_rsvp' => true, 'has_music' => true, 'has_guestbook' => true,
                'has_gallery' => true, 'has_countdown' => true, 'has_love_story' => true,
                'has_digital_envelope' => true, 'has_qr_checkin' => true,
                'has_custom_domain' => true, 'has_analytics' => true,
                'is_featured' => false, 'sort_order' => 3,
                'features' => ['Semua Template Premium', 'Unlimited Foto & Tamu', 'RSVP + QR Check-in', 'Background Music', 'Love Story Timeline', 'Amplop Digital + QRIS', 'Custom Domain', 'Full Analytics', 'Priority Support', 'Berlaku 1 Tahun'],
            ],
        ];
        foreach ($packages as $p) Package::create($p);
    }
}
