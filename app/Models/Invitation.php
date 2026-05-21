<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Invitation extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected function casts(): array
    {
        return [
            'event_date' => 'date', 'reception_date' => 'date', 'music_autoplay' => 'boolean',
            'published_at' => 'datetime', 'expires_at' => 'datetime', 'settings' => 'array', 'love_story' => 'array',
            'bank_accounts' => 'array',
        ];
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($invitation) {
            if (empty($invitation->slug)) {
                $base = Str::slug($invitation->groom_name . '-' . $invitation->bride_name);
                $slug = $base; $counter = 1;
                while (static::where('slug', $slug)->exists()) { $slug = $base . '-' . $counter++; }
                $invitation->slug = $slug;
            }
        });
    }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function template(): BelongsTo { return $this->belongsTo(InvitationTemplate::class, 'template_id'); }
    public function package(): BelongsTo { return $this->belongsTo(Package::class); }
    public function guests(): HasMany { return $this->hasMany(Guest::class); }
    public function guestbooks(): HasMany { return $this->hasMany(Guestbook::class); }
    public function galleries(): HasMany { return $this->hasMany(Gallery::class)->orderBy('sort_order'); }
    public function payments(): HasMany { return $this->hasMany(Payment::class); }
    public function visitorLogs(): HasMany { return $this->hasMany(VisitorLog::class); }
    public function customDomain(): HasOne { return $this->hasOne(CustomDomain::class); }
    
    public function getUrl(): string 
    { 
        // Check if has active custom domain
        if ($this->customDomain && $this->customDomain->isActive()) {
            return 'https://' . $this->customDomain->domain;
        }
        return url('/' . $this->slug); 
    }
    
    public function isPublished(): bool { return $this->status === 'published'; }
    public function isDraft(): bool { return $this->status === 'draft'; }
    public function isPaused(): bool { return $this->status === 'paused'; }
    public function publish(): void { $this->update(['status' => 'published', 'published_at' => now()]); }
    public function pause(): void { $this->update(['status' => 'paused']); }
    public function incrementView(): void { $this->increment('view_count'); }
    
    public function getRsvpStats(): array
    {
        $g = $this->guests();
        return [
            'total' => $g->count(), 'attending' => (clone $g)->where('rsvp_status', 'attending')->count(),
            'not_attending' => (clone $g)->where('rsvp_status', 'not_attending')->count(),
            'maybe' => (clone $g)->where('rsvp_status', 'maybe')->count(),
            'pending' => (clone $g)->where('rsvp_status', 'pending')->count(),
            'expected_guests' => (clone $g)->where('rsvp_status', 'attending')->sum('number_of_guests'),
        ];
    }
    
    /**
     * Get the active subscription package for this invitation's owner
     */
    public function getActivePackage(): ?Package
    {
        $subscription = $this->user->activeSubscription();
        return $subscription?->package;
    }
    
    /**
     * Check if invitation has a specific feature based on subscription
     */
    public function hasFeature(string $feature): bool
    {
        $package = $this->getActivePackage();
        if (!$package) {
            return false;
        }
        
        $featureField = 'has_' . $feature;
        return $package->$featureField ?? false;
    }
    
    /**
     * Check specific features
     */
    public function hasLoveStoryFeature(): bool { return $this->hasFeature('love_story'); }
    public function hasAnalyticsFeature(): bool { return $this->hasFeature('analytics'); }
    public function hasQrCheckinFeature(): bool { return $this->hasFeature('qr_checkin'); }
    public function hasCustomDomainFeature(): bool { return $this->hasFeature('custom_domain'); }
    
    /**
     * Get check-in stats
     */
    public function getCheckinStats(): array
    {
        $guests = $this->guests();
        return [
            'total' => $guests->count(),
            'checked_in' => (clone $guests)->where('is_checked_in', true)->count(),
            'not_checked_in' => (clone $guests)->where('is_checked_in', false)->count(),
        ];
    }
    
    public function scopePublished($query) { return $query->where('status', 'published'); }

    /**
     * Get bank accounts (with backward compatibility for old single fields)
     */
    public function getBankAccountsListAttribute(): array
    {
        // Use new bank_accounts JSON if available
        if (!empty($this->bank_accounts)) {
            return $this->bank_accounts;
        }

        // Fallback to old single fields for backward compatibility
        if ($this->bank_name) {
            return [[
                'bank_name' => $this->bank_name,
                'account_number' => $this->bank_account_number,
                'account_name' => $this->bank_account_name,
            ]];
        }

        return [];
    }

    /**
     * Check if invitation has any bank accounts or QRIS
     */
    public function hasDigitalEnvelope(): bool
    {
        return !empty($this->bank_accounts_list) || !empty($this->qris_image);
    }
}