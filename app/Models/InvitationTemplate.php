<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InvitationTemplate extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'slug', 'description', 'thumbnail', 'preview_url', 'category',
        'color_primary', 'color_secondary', 'color_accent', 'font_heading', 'font_body',
        'blade_view', 'is_premium', 'is_active', 'sort_order', 'settings',
    ];
    protected function casts(): array { return ['is_premium' => 'boolean', 'is_active' => 'boolean', 'settings' => 'array']; }
    public function invitations(): HasMany { return $this->hasMany(Invitation::class, 'template_id'); }
    public function scopeActive($query) { return $query->where('is_active', true); }
}