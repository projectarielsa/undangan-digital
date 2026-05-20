<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    public function views(): HasMany { return $this->hasMany(\App\Models\InvitationView::class); }
    public function getUrl(): string { return url('/' . $this->slug); }
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
        ];
    }
    public function scopePublished($query) { return $query->where('status', 'published'); }
}