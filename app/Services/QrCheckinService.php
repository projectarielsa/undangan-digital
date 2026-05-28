<?php

namespace App\Services;

use App\Models\Guest;
use App\Models\Invitation;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCheckinService
{
    /**
     * Generate QR code untuk guest
     */
    public function generateQrCode(Guest $guest): string
    {
        // Generate unique QR token jika belum ada
        if (!$guest->qr_code) {
            $guest->update(['qr_code' => Str::uuid()->toString()]);
        }

        return $guest->qr_code;
    }

    /**
     * Generate QR codes untuk semua guest di invitation
     */
    public function generateAllQrCodes(Invitation $invitation): int
    {
        $count = 0;
        
        foreach ($invitation->guests as $guest) {
            if (!$guest->qr_code) {
                $guest->update(['qr_code' => Str::uuid()->toString()]);
                $count++;
            }
        }
        
        return $count;
    }

    /**
     * Get URL untuk check-in guest
     */
    public function getCheckinUrl(Guest $guest): string
    {
        return secure_url('/checkin/verify/' . $guest->qr_code);
    }

    /**
     * Get QR code SVG untuk display
     */
    public function getQrCodeSvg(Guest $guest, int $size = 200): string
    {
        $url = $this->getCheckinUrl($guest);
        
        return QrCode::size($size)
            ->style('round')
            ->eye('circle')
            ->margin(1)
            ->generate($url);
    }

    /**
     * Verify dan check-in guest berdasarkan QR code
     */
    public function verifyAndCheckin(string $qrCode): ?Guest
    {
        $guest = Guest::where('qr_code', $qrCode)->first();
        
        if (!$guest) {
            return null;
        }

        // Mark as checked in
        if (!$guest->is_checked_in) {
            $guest->update([
                'is_checked_in' => true,
                'checked_in_at' => now(),
            ]);
        }

        return $guest;
    }

    /**
     * Get check-in stats untuk invitation
     */
    public function getCheckinStats(Invitation $invitation): array
    {
        $guests = $invitation->guests();
        $attending = (clone $guests)->where('rsvp_status', 'attending');
        
        return [
            'total_guests' => $guests->count(),
            'total_attending' => $attending->count(),
            'checked_in' => (clone $guests)->where('is_checked_in', true)->count(),
            'expected_count' => (clone $attending)->sum('number_of_guests'),
        ];
    }

    /**
     * Check apakah invitation memiliki fitur QR check-in
     */
    public function hasQrCheckinFeature(Invitation $invitation): bool
    {
        $subscription = $invitation->user->activeSubscription();
        if (!$subscription) {
            return false;
        }
        
        return $subscription->package->has_qr_checkin ?? false;
    }

    /**
     * Get recent check-ins
     */
    public function getRecentCheckins(Invitation $invitation, int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return $invitation->guests()
            ->where('is_checked_in', true)
            ->orderByDesc('checked_in_at')
            ->limit($limit)
            ->get();
    }
}
