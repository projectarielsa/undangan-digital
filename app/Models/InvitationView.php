<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvitationView extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'invitation_id', 'ip_address', 'user_agent', 'device_type', 
        'browser', 'os', 'referrer', 'country', 'city', 'guest_id', 'viewed_at'
    ];

    protected function casts(): array
    {
        return ['viewed_at' => 'datetime'];
    }

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    public static function recordView(Invitation $invitation, $request, ?Guest $guest = null): self
    {
        $userAgent = $request->userAgent();
        $deviceType = self::detectDeviceType($userAgent);
        $browser = self::detectBrowser($userAgent);
        $os = self::detectOS($userAgent);

        return self::create([
            'invitation_id' => $invitation->id,
            'ip_address' => $request->ip(),
            'user_agent' => substr($userAgent, 0, 255),
            'device_type' => $deviceType,
            'browser' => $browser,
            'os' => $os,
            'referrer' => $request->header('referer') ? substr($request->header('referer'), 0, 255) : null,
            'guest_id' => $guest?->id,
            'viewed_at' => now(),
        ]);
    }

    private static function detectDeviceType(?string $ua): string
    {
        if (!$ua) return 'unknown';
        $ua = strtolower($ua);
        if (preg_match('/mobile|android.*mobile|iphone|ipod|blackberry|iemobile|opera mini/i', $ua)) return 'mobile';
        if (preg_match('/tablet|ipad|android(?!.*mobile)/i', $ua)) return 'tablet';
        return 'desktop';
    }

    private static function detectBrowser(?string $ua): string
    {
        if (!$ua) return 'unknown';
        if (strpos($ua, 'Firefox') !== false) return 'Firefox';
        if (strpos($ua, 'Edg') !== false) return 'Edge';
        if (strpos($ua, 'Chrome') !== false) return 'Chrome';
        if (strpos($ua, 'Safari') !== false) return 'Safari';
        if (strpos($ua, 'Opera') !== false || strpos($ua, 'OPR') !== false) return 'Opera';
        return 'Other';
    }

    private static function detectOS(?string $ua): string
    {
        if (!$ua) return 'unknown';
        if (strpos($ua, 'Windows') !== false) return 'Windows';
        if (strpos($ua, 'Mac') !== false) return 'macOS';
        if (strpos($ua, 'Linux') !== false) return 'Linux';
        if (strpos($ua, 'Android') !== false) return 'Android';
        if (strpos($ua, 'iOS') !== false || strpos($ua, 'iPhone') !== false || strpos($ua, 'iPad') !== false) return 'iOS';
        return 'Other';
    }
}
