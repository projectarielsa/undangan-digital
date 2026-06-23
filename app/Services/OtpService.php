<?php
namespace App\Services;
use App\Jobs\SendOtpEmail;
use App\Models\EmailOtp;
use App\Models\User;

class OtpService
{
    public function generate(User $user): EmailOtp
    {
        EmailOtp::where('user_id', $user->id)->whereNull('verified_at')->delete();
        $otp = EmailOtp::create(['user_id' => $user->id, 'email' => $user->email, 'code' => str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT), 'expires_at' => now()->addMinutes(10), 'attempt_count' => 0]);
        SendOtpEmail::dispatch($user, $otp->code);
        return $otp;
    }
    public function verify(User $user, string $code): array
    {
        $otp = EmailOtp::where('user_id', $user->id)->whereNull('verified_at')->latest()->first();
        if (!$otp) return ['success' => false, 'message' => 'Kode OTP tidak ditemukan.'];
        if ($otp->isExpired()) return ['success' => false, 'message' => 'Kode OTP sudah kedaluwarsa.'];
        if ($otp->hasExceededAttempts()) return ['success' => false, 'message' => 'Terlalu banyak percobaan.'];
        if ($otp->code !== $code) { $otp->incrementAttempt(); return ['success' => false, 'message' => 'Kode OTP salah. Sisa: ' . (5 - $otp->attempt_count)]; }
        $otp->markAsVerified();
        $user->update(['email_verified_at' => now()]);
        return ['success' => true, 'message' => 'Email berhasil diverifikasi.'];
    }
    public function canResend(User $user): bool
    {
        $last = EmailOtp::where('user_id', $user->id)->latest()->first();
        return !$last || $last->created_at->addSeconds(60)->isPast();
    }
    public function getResendCooldown(User $user): int
    {
        $last = EmailOtp::where('user_id', $user->id)->latest()->first();
        if (!$last) return 0;
        return (int) max(0, 60 - now()->diffInSeconds($last->created_at));
    }
}