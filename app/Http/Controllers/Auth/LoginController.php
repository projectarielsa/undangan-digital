<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm() { return view("auth.login"); }
    public function login(Request $request)
    {
        $request->validate(["email" => "required|email", "password" => "required|string"]);
        $key = Str::transliterate(Str::lower($request->string("email")) . "|". $request->ip());
        if (RateLimiter::tooManyAttempts($key, 5)) throw ValidationException::withMessages(["email" => "Terlalu banyak percobaan."]);
        if (!Auth::attempt($request->only("email","password"), $request->boolean("remember"))) { RateLimiter::hit($key); throw ValidationException::withMessages(["email" => "Email atau password salah."]); }
        RateLimiter::clear($key);
        $request->session()->regenerate();
        $user = Auth::user();
        if (!$user->is_active) { Auth::logout(); throw ValidationException::withMessages(["email" => "Akun dinonaktifkan."]); }
        if (!$user->isVerified()) return redirect()->route("verification.otp");
        return $user->isSuperAdmin() ? redirect()->route("admin.dashboard") : redirect()->route("customer.dashboard");
    }
    public function logout(Request $request) { Auth::logout(); $request->session()->invalidate(); $request->session()->regenerateToken(); return redirect("/"); }
}