<?php
namespace App\Policies;
use App\Models\Invitation;
use App\Models\User;

class InvitationPolicy
{
    public function view(User $user, Invitation $inv): bool { return $user->id === $inv->user_id || $user->isSuperAdmin(); }
    public function update(User $user, Invitation $inv): bool { return $user->id === $inv->user_id; }
    public function delete(User $user, Invitation $inv): bool { return $user->id === $inv->user_id || $user->isSuperAdmin(); }
}