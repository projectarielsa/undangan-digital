<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class OtpVerificationController extends Controller
{
    public function __construct(protected OtpService $otpService) {}
    public function show(Request $request)
    {
        $user = $request->user();
        if ($user->isVerified()) return redirect()->route("customer.dashboard");
        return view("auth.verify-otp", ["email" => $user->email, "cooldown" => $this->otpService->getResendCooldown($user)]);
    }
    public function verify(Request $request)
    {
        $request->validate(["code" => "required|string|size:6"]);
        $result = $this->otpService->verify($request->user(), $request->code);
        if (!$result["success"]) return back()->withErrors(["code" => $result["message"]]);
        return $request->user()->isSuperAdmin() ? redirect()->route("admin.dashboard") : redirect()->route("customer.dashboard");
    }
    public function resend(Request $request)
    {
        $user = $request->user();
        $key = "otp-resend:" . $user->id;
        if (RateLimiter::tooManyAttempts($key, 1)) return back()->withErrors(["resend" => "Tunggu sebelum kirim ulang."]);
        $this->otpService->generate($user);
        RateLimiter::hit($key, 60);
        return back()->with("success", "Kode OTP baru telah dikirim.");
    }
}