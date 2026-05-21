<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomDomain extends Model
{
    protected $fillable = [
        'invitation_id',
        'domain',
        'status',
        'dns_instructions',
        'verified_at',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    public function markAsActive(): void
    {
        $this->update([
            'status' => 'active',
            'verified_at' => now(),
        ]);
    }

    public function markAsFailed(): void
    {
        $this->update(['status' => 'failed']);
    }

    /**
     * Generate DNS instructions for domain verification
     */
    public function generateDnsInstructions(): string
    {
        $appDomain = parse_url(config('app.url'), PHP_URL_HOST);
        
        return "Untuk mengaktifkan domain kustom Anda, tambahkan DNS record berikut:\n\n" .
               "Tipe: CNAME\n" .
               "Host/Name: " . $this->getSubdomainOrRoot() . "\n" .
               "Value/Target: {$appDomain}\n" .
               "TTL: 3600 (atau Auto)\n\n" .
               "Catatan: Perubahan DNS dapat memakan waktu 24-48 jam untuk propagasi.";
    }

    private function getSubdomainOrRoot(): string
    {
        $parts = explode('.', $this->domain);
        return count($parts) > 2 ? $parts[0] : '@';
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
