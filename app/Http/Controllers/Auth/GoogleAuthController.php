<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect() { return Socialite::driver("google")->redirect(); }
    public function callback()
    {
        try { $gu = Socialite::driver("google")->user(); } catch (\Exception $e) { return redirect()->route("login")->withErrors(["google" => "Gagal login dengan Google."]); }
        $user = User::where("google_id", $gu->getId())->orWhere("email", $gu->getEmail())->first();
        if ($user) { if (!$user->google_id) $user->update(["google_id" => $gu->getId(), "provider" => "google", "avatar" => $gu->getAvatar(), "email_verified_at" => $user->email_verified_at ?? now()]); }
        else { $user = User::create(["name" => $gu->getName(), "email" => $gu->getEmail(), "google_id" => $gu->getId(), "provider" => "google", "avatar" => $gu->getAvatar(), "email_verified_at" => now(), "role" => "customer"]); }
        if (!$user->is_active) return redirect()->route("login")->withErrors(["google" => "Akun dinonaktifkan."]);
        Auth::login($user, true);
        return $user->isSuperAdmin() ? redirect()->route("admin.dashboard") : redirect()->route("customer.dashboard");
    }
}