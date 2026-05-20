<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'name',
        'phone',
        'email',
        'invited_by', // Nama orang yang turut mengundang (misal: "Bapak Ahmad")
        'slug',
        'rsvp_status',
        'number_of_guests',
        'message',
        'qr_code',
        'is_checked_in',
        'checked_in_at',
        'opened_at',
        'open_count',
    ];

    protected function casts(): array
    {
        return [
            'is_checked_in' => 'boolean',
            'checked_in_at' => 'datetime',
            'opened_at' => 'datetime',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($guest) {
            if (empty($guest->slug)) {
                $guest->slug = Str::slug($guest->name);
            }
        });
    }

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function markAsOpened(): void
    {
        $this->increment('open_count');
        if (!$this->opened_at) {
            $this->update(['opened_at' => now()]);
        }
    }

    /**
     * Check if this guest has an inviter (turut mengundang).
     */
    public function hasInviter(): bool
    {
        return !empty($this->invited_by);
    }

    /**
     * Get the formatted inviter text.
     */
    public function getInviterText(): ?string
    {
        return $this->invited_by;
    }
}