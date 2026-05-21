<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'avatar',
        'google_id', 'provider', 'role', 'is_active', 'email_verified_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function isSuperAdmin(): bool { return $this->role === 'super_admin'; }
    public function isCustomer(): bool { return $this->role === 'customer'; }
    public function isVerified(): bool { return $this->email_verified_at !== null; }
    public function invitations(): HasMany { return $this->hasMany(Invitation::class); }
    public function payments(): HasMany { return $this->hasMany(Payment::class); }
    public function subscriptions(): HasMany { return $this->hasMany(Subscription::class); }
    public function supportTickets(): HasMany { return $this->hasMany(SupportTicket::class); }
    public function activeSubscription()
    {
        return $this->subscriptions()->where('status', 'active')->where('expires_at', '>', now())->latest()->first();
    }
    public function emailOtps(): HasMany { return $this->hasMany(EmailOtp::class); }
    
    /**
     * Check if user has a specific feature based on their subscription
     */
    public function hasFeature(string $feature): bool
    {
        $subscription = $this->activeSubscription();
        if (!$subscription) {
            return false;
        }
        
        $featureField = 'has_' . $feature;
        return $subscription->package->$featureField ?? false;
    }
    
    /**
     * Check if user has priority support (Exclusive package only)
     */
    public function hasPrioritySupport(): bool
    {
        $subscription = $this->activeSubscription();
        return $subscription && $subscription->package->slug === 'exclusive';
    }
}