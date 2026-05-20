<?php
namespace App\Services;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class InvitationService
{
    public function create(User $user, array $data): Invitation
    {
        $data['user_id'] = $user->id;
        // Ensure title is set
        if (empty($data['title'])) {
            $data['title'] = ($data['groom_name'] ?? '') . ' & ' . ($data['bride_name'] ?? '');
        }
        foreach (['cover_image', 'groom_photo', 'bride_photo', 'qris_image'] as $field) {
            if (isset($data[$field]) && $data[$field]) $data[$field] = $data[$field]->store('invitations', 'public');
        }
        if (isset($data['music_file']) && $data['music_file']) { $data['music_url'] = $data['music_file']->store('invitations/music', 'public'); unset($data['music_file']); }
        return Invitation::create($data);
    }
    public function update(Invitation $inv, array $data): Invitation
    {
        foreach (['cover_image', 'groom_photo', 'bride_photo', 'qris_image'] as $field) {
            if (isset($data[$field]) && $data[$field]) { if ($inv->$field) Storage::disk('public')->delete($inv->$field); $data[$field] = $data[$field]->store('invitations', 'public'); }
        }
        if (isset($data['music_file']) && $data['music_file']) { if ($inv->music_url) Storage::disk('public')->delete($inv->music_url); $data['music_url'] = $data['music_file']->store('invitations/music', 'public'); unset($data['music_file']); }
        $inv->update($data);
        return $inv->fresh();
    }
    public function duplicate(Invitation $inv): Invitation
    {
        $new = $inv->replicate(); $new->slug = null; $new->status = 'draft'; $new->published_at = null; $new->view_count = 0; $new->title = $inv->title . ' (Copy)'; $new->save();
        foreach ($inv->galleries as $g) $new->galleries()->create($g->only(['image_path', 'thumbnail_path', 'caption', 'sort_order']));
        return $new;
    }
    public function delete(Invitation $inv): void
    {
        foreach (['cover_image', 'groom_photo', 'bride_photo', 'music_url'] as $f) { if ($inv->$f) Storage::disk('public')->delete($inv->$f); }
        foreach ($inv->galleries as $g) { Storage::disk('public')->delete($g->image_path); }
        $inv->delete();
    }
    public function getFeatureLimits(Invitation $inv): array
    {
        $p = $inv->package;
        if (!$p) return ['max_photos' => 5, 'max_guests' => 50, 'has_rsvp' => false, 'has_music' => false, 'has_guestbook' => false, 'has_gallery' => true, 'has_countdown' => true, 'has_love_story' => false, 'has_digital_envelope' => false, 'has_qr_checkin' => false, 'has_analytics' => false];
        return ['max_photos' => $p->max_photos, 'max_guests' => $p->max_guests, 'has_rsvp' => $p->has_rsvp, 'has_music' => $p->has_music, 'has_guestbook' => $p->has_guestbook, 'has_gallery' => $p->has_gallery, 'has_countdown' => $p->has_countdown, 'has_love_story' => $p->has_love_story, 'has_digital_envelope' => $p->has_digital_envelope, 'has_qr_checkin' => $p->has_qr_checkin, 'has_analytics' => $p->has_analytics];
    }
}