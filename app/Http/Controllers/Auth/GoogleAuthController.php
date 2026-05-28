<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function __construct(
        protected OtpService $otpService
    ) {}

    public function loginRedirect()
    {
        return Socialite::driver('google')
            ->redirectUrl(config('services.google.login_redirect'))
            ->redirect();
    }

    public function loginCallback()
    {
        try {
            $gu = Socialite::driver('google')
                ->redirectUrl(config('services.google.login_redirect'))
                ->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['google' => 'Gagal login dengan Google.']);
        }

        $user = User::where('google_id', $gu->getId())
            ->orWhere('email', $gu->getEmail())
            ->first();

        if (!$user) {
            return redirect()->route('login')
                ->withErrors(['google' => 'Akun Google ini belum terdaftar. Silakan daftar terlebih dahulu.']);
        }

        $user->update([
            'google_id' => $user->google_id ?: $gu->getId(),
            'provider' => 'google',
            'avatar' => $gu->getAvatar(),
        ]);

        if (!$user->is_active) {
            return redirect()->route('login')
                ->withErrors(['google' => 'Akun dinonaktifkan.']);
        }

        Auth::login($user, true);

        if (!$user->email_verified_at) {
            return redirect()->route('verification.otp');
        }

        return $user->isSuperAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('customer.dashboard');
    }

    public function registerRedirect()
    {
        return Socialite::driver('google')
            ->redirectUrl(config('services.google.register_redirect'))
            ->redirect();
    }

    public function registerCallback()
    {
        try {
            $gu = Socialite::driver('google')
                ->redirectUrl(config('services.google.register_redirect'))
                ->user();
        } catch (\Exception $e) {
            return redirect()->route('register')
                ->withErrors(['google' => 'Gagal daftar dengan Google.']);
        }

        $user = User::where('google_id', $gu->getId())
            ->orWhere('email', $gu->getEmail())
            ->first();

        if ($user && $user->email_verified_at) {
            return redirect()->route('login')
                ->withErrors(['google' => 'Akun Google ini sudah terdaftar. Silakan masuk.']);
        }

        if (!$user) {
            $user = User::create([
                'name' => $gu->getName() ?: 'Google User',
                'email' => $gu->getEmail(),
                'password' => Hash::make(Str::random(40)),
                'google_id' => $gu->getId(),
                'provider' => 'google',
                'avatar' => $gu->getAvatar(),
                'role' => 'customer',
                'is_active' => true,
                'email_verified_at' => null,
            ]);
        } else {
            $user->update([
                'google_id' => $user->google_id ?: $gu->getId(),
                'provider' => 'google',
                'avatar' => $gu->getAvatar(),
                'is_active' => true,
                'email_verified_at' => null,
            ]);
        }

        Auth::login($user);

        // Ini disamakan persis seperti RegisterController manual
        $this->otpService->generate($user);

        return redirect()->route('verification.otp');
    }
}