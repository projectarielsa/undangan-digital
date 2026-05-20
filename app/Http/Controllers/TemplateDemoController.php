<?php

namespace App\Http\Controllers;

use App\Models\InvitationTemplate;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TemplateDemoController extends Controller
{
    /**
     * Show demo preview of a template with sample data
     */
    public function show(string $slug)
    {
        $template = InvitationTemplate::where('slug', $slug)->where('is_active', true)->firstOrFail();

        // Create a fake invitation object with sample data
        $invitation = new \stdClass();
        $invitation->title = 'Putri & Andi';
        $invitation->groom_name = 'Andi Pratama';
        $invitation->bride_name = 'Putri Ayu';
        $invitation->groom_father = 'Budi Pratama';
        $invitation->groom_mother = 'Sari Wulandari';
        $invitation->bride_father = 'Hendra Wijaya';
        $invitation->bride_mother = 'Rina Kusuma';
        $invitation->groom_instagram = '@andipratama';
        $invitation->bride_instagram = '@putriayu';
        $invitation->groom_photo = null;
        $invitation->bride_photo = null;
        $invitation->event_date = Carbon::now()->addMonths(3);
        $invitation->event_time_start = '10:00';
        $invitation->event_time_end = '14:00';
        $invitation->event_venue = 'Grand Ballroom Hotel Mulia';
        $invitation->event_address = 'Jl. Asia Afrika No. 8, Senayan, Jakarta Selatan';
        $invitation->event_maps_url = 'https://maps.google.com';
        $invitation->dress_code = 'Sage Green & White';
        $invitation->opening_text = 'Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud menyelenggarakan resepsi pernikahan kami. Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir.';
        $invitation->closing_text = 'Merupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu kepada kedua mempelai. Atas kehadiran dan doa restunya, kami mengucapkan terima kasih.';
        $invitation->gift_info = 'Doa restu Anda adalah hadiah terindah. Namun jika Anda ingin memberikan hadiah, kami menyediakan amplop digital.';
        $invitation->cover_image = null;
        $invitation->music_url = null;
        $invitation->music_autoplay = false;
        $invitation->qris_image = null;
        $invitation->bank_name = 'BCA';
        $invitation->bank_account_number = '1234567890';
        $invitation->bank_account_name = 'Putri Ayu';
        $invitation->bank_accounts = [
            ['bank_name' => 'BCA', 'account_number' => '1234567890', 'account_name' => 'Putri Ayu'],
            ['bank_name' => 'Mandiri', 'account_number' => '0987654321', 'account_name' => 'Andi Pratama'],
        ];
        $invitation->love_story = [
            ['date' => 'Januari 2020', 'title' => 'Pertama Bertemu', 'description' => 'Kami pertama kali bertemu di sebuah acara kampus. Senyummu yang hangat langsung mencuri perhatianku.', 'image' => null],
            ['date' => 'Juni 2021', 'title' => 'Resmi Berpacaran', 'description' => 'Setelah setahun saling mengenal, akhirnya kami memutuskan untuk menjalin hubungan yang lebih serius.', 'image' => null],
            ['date' => 'Desember 2024', 'title' => 'Lamaran', 'description' => 'Di malam tahun baru, dengan gemetar aku berlutut dan mengucapkan kata-kata yang sudah lama ingin kusampaikan.', 'image' => null],
        ];
        $invitation->slug = 'demo-' . $slug;
        $invitation->status = 'published';
        $invitation->view_count = 1234;
        $invitation->color_primary = $template->color_primary;
        $invitation->color_secondary = $template->color_secondary;
        $invitation->color_accent = $template->color_accent;
        $invitation->template = $template;
        $invitation->settings = null;
        $invitation->reception_date = null;

        // Create empty collections for relationships
        $invitation->galleries = collect([]);
        $invitation->guestbooks = collect([
            (object)['name' => 'Budi Santoso', 'message' => 'Selamat menempuh hidup baru! Semoga menjadi keluarga yang sakinah mawaddah warahmah.', 'created_at' => Carbon::now()->subHours(2)],
            (object)['name' => 'Siti Nurhaliza', 'message' => 'Barakallah! Semoga cinta kalian abadi hingga Jannah. Happy Wedding!', 'created_at' => Carbon::now()->subHours(5)],
            (object)['name' => 'Ahmad Fauzi', 'message' => 'Akhirnya! Selamat ya bro dan mbak. Semoga langgeng sampai kakek nenek.', 'created_at' => Carbon::now()->subDay()],
        ]);

        // Helper methods as closures bound to object
        $invitation = (object) array_merge((array) $invitation, [
            'isPublished' => true,
            'hasDigitalEnvelope' => true,
        ]);

        // Create a wrapper class to make it work with blade templates
        $fakeInvitation = new DemoInvitation($invitation, $template);

        $guest = null;
        $guestName = 'Tamu Undangan';

        $bladeView = $template->blade_view ?? 'templates.elegant-gold';

        return view($bladeView, [
            'invitation' => $fakeInvitation,
            'guest' => $guest,
            'guestName' => $guestName,
        ]);
    }

    /**
     * List all templates available for demo
     */
    public function index()
    {
        $templates = InvitationTemplate::active()->orderBy('sort_order')->get();
        return view('demo.index', compact('templates'));
    }
}

/**
 * Fake Invitation class that mimics the real Invitation model for demo purposes
 */
class DemoInvitation
{
    private $data;
    private $template;

    public function __construct($data, $template)
    {
        $this->data = $data;
        $this->template = $template;
    }

    public function __get($name)
    {
        if ($name === 'template') return $this->template;
        if ($name === 'event_date') return $this->data->event_date;
        if ($name === 'galleries') return $this->data->galleries;
        if ($name === 'guestbooks') return $this->data->guestbooks;
        if ($name === 'bank_accounts_list') return $this->data->bank_accounts;
        return $this->data->$name ?? null;
    }

    public function __isset($name)
    {
        return isset($this->data->$name) || $name === 'template' || $name === 'bank_accounts_list';
    }

    public function isPublished(): bool { return true; }
    public function isDraft(): bool { return false; }
    public function hasDigitalEnvelope(): bool { return true; }
    public function hasLoveStoryFeature(): bool { return true; }
    public function hasAnalyticsFeature(): bool { return true; }
    public function hasQrCheckinFeature(): bool { return true; }
    public function hasCustomDomainFeature(): bool { return true; }
    public function getUrl(): string { return '#'; }
    public function getBankAccountsListAttribute(): array { return $this->data->bank_accounts; }

    public function getRsvpStats(): array
    {
        return ['total' => 50, 'attending' => 35, 'not_attending' => 5, 'maybe' => 10, 'pending' => 0, 'expected_guests' => 70];
    }
}
