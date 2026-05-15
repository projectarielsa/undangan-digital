<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gallery extends Model
{
    protected $fillable = ['invitation_id', 'image_path', 'thumbnail_path', 'caption', 'sort_order'];
    public function invitation(): BelongsTo { return $this->belongsTo(Invitation::class); }
    public function getImageUrl(): string { return asset('storage/' . $this->image_path); }
    public function getThumbnailUrl(): string { return $this->thumbnail_path ? asset('storage/' . $this->thumbnail_path) : $this->getImageUrl(); }
}