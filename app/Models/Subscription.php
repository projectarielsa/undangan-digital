<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    protected $fillable = ['user_id', 'package_id', 'payment_id', 'invitation_id', 'status', 'starts_at', 'expires_at'];
    protected function casts(): array { return ['starts_at' => 'datetime', 'expires_at' => 'datetime']; }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function package(): BelongsTo { return $this->belongsTo(Package::class); }
    public function payment(): BelongsTo { return $this->belongsTo(Payment::class); }
    public function invitation(): BelongsTo { return $this->belongsTo(Invitation::class); }
    public function isActive(): bool { return $this->status === 'active' && $this->expires_at->isFuture(); }
    public function scopeActive($query) { return $query->where('status', 'active')->where('expires_at', '>', now()); }
}