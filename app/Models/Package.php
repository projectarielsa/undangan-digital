<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'slug', 'description', 'price', 'discount_price', 'duration_days',
        'max_photos', 'max_guests', 'max_templates', 'has_rsvp', 'has_music',
        'has_guestbook', 'has_gallery', 'has_countdown', 'has_love_story',
        'has_digital_envelope', 'has_qr_checkin', 'has_custom_domain', 'has_analytics',
        'is_active', 'is_featured', 'sort_order', 'features',
    ];
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2', 'discount_price' => 'decimal:2',
            'has_rsvp' => 'boolean', 'has_music' => 'boolean', 'has_guestbook' => 'boolean',
            'has_gallery' => 'boolean', 'has_countdown' => 'boolean', 'has_love_story' => 'boolean',
            'has_digital_envelope' => 'boolean', 'has_qr_checkin' => 'boolean',
            'has_custom_domain' => 'boolean', 'has_analytics' => 'boolean',
            'is_active' => 'boolean', 'is_featured' => 'boolean', 'features' => 'array',
        ];
    }
    public function getEffectivePrice(): float { return $this->discount_price ?? $this->price; }
    public function payments(): HasMany { return $this->hasMany(Payment::class); }
    public function subscriptions(): HasMany { return $this->hasMany(Subscription::class); }
    public function scopeActive($query) { return $query->where('is_active', true); }
    public function scopeOrdered($query) { return $query->orderBy('sort_order'); }
}