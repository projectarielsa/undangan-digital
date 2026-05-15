<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $guarded = ['id'];
    protected function casts(): array { return ['amount' => 'decimal:2', 'discount_amount' => 'decimal:2', 'total_amount' => 'decimal:2', 'midtrans_response' => 'array', 'paid_at' => 'datetime', 'expired_at' => 'datetime']; }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function invitation(): BelongsTo { return $this->belongsTo(Invitation::class); }
    public function package(): BelongsTo { return $this->belongsTo(Package::class); }
    public function isPaid(): bool { return $this->status === 'paid'; }
    public function isPending(): bool { return $this->status === 'pending'; }
    public function markAsPaid(string $tid, string $pt, array $r): void { $this->update(['status' => 'paid', 'transaction_id' => $tid, 'payment_type' => $pt, 'midtrans_response' => $r, 'paid_at' => now()]); }
}