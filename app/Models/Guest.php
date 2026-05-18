<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Guest extends Model
{
    use HasFactory;
    protected $fillable = ['invitation_id', 'name', 'phone', 'email', 'slug', 'rsvp_status', 'number_of_guests', 'message', 'qr_code', 'is_checked_in', 'checked_in_at', 'opened_at', 'open_count'];
    protected function casts(): array { return ['is_checked_in' => 'boolean', 'checked_in_at' => 'datetime', 'opened_at' => 'datetime']; }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($g) {
            if (empty($g->slug)) {
                $base = Str::slug($g->name);
                $slug = $base;
                $counter = 1;
                while (static::where('invitation_id', $g->invitation_id)->where('slug', $slug)->exists()) {
                    $slug = $base . '-' . $counter++;
                }
                $g->slug = $slug;
            }
        });
    }
    public function invitation(): BelongsTo { return $this->belongsTo(Invitation::class); }
    public function markAsOpened(): void { $this->increment('open_count'); if (!$this->opened_at) $this->update(['opened_at' => now()]); }
}