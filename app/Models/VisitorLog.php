<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitorLog extends Model
{
    protected $fillable = [
        'invitation_id',
        'guest_id',
        'ip_address',
        'user_agent',
        'device_type',
        'browser',
        'platform',
        'referrer',
        'country',
        'city',
        'page_visited',
    ];

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    /**
     * Parse user agent to extract device info
     */
    public static function parseUserAgent(string $userAgent): array
    {
        $deviceType = 'desktop';
        $browser = 'Unknown';
        $platform = 'Unknown';

        // Detect device type
        if (preg_match('/(tablet|ipad|playbook|silk)|(android(?!.*mobile))/i', $userAgent)) {
            $deviceType = 'tablet';
        } elseif (preg_match('/(mobile|iphone|ipod|android.*mobile|webos|blackberry|opera mini|iemobile)/i', $userAgent)) {
            $deviceType = 'mobile';
        }

        // Detect browser
        if (preg_match('/MSIE|Trident/i', $userAgent)) {
            $browser = 'Internet Explorer';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/Chrome/i', $userAgent)) {
            if (preg_match('/Edg/i', $userAgent)) {
                $browser = 'Edge';
            } elseif (preg_match('/OPR|Opera/i', $userAgent)) {
                $browser = 'Opera';
            } else {
                $browser = 'Chrome';
            }
        } elseif (preg_match('/Safari/i', $userAgent)) {
            $browser = 'Safari';
        }

        // Detect platform/OS
        if (preg_match('/Windows/i', $userAgent)) {
            $platform = 'Windows';
        } elseif (preg_match('/Macintosh|Mac OS/i', $userAgent)) {
            $platform = 'macOS';
        } elseif (preg_match('/Linux/i', $userAgent)) {
            $platform = 'Linux';
        } elseif (preg_match('/Android/i', $userAgent)) {
            $platform = 'Android';
        } elseif (preg_match('/iPhone|iPad|iPod/i', $userAgent)) {
            $platform = 'iOS';
        }

        return [
            'device_type' => $deviceType,
            'browser' => $browser,
            'platform' => $platform,
        ];
    }

    public function scopeForInvitation($query, int $invitationId)
    {
        return $query->where('invitation_id', $invitationId);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                     ->whereYear('created_at', now()->year);
    }
}
