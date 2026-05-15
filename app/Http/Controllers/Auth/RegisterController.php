<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function __construct(protected OtpService $otpService) {}
    public function showRegistrationForm() { return view("auth.register"); }
    public function register(Request $request)
    {
        $request->validate(["name" => "required|string|max:255", "email" => "required|email|max:255|unique:users", "password" => ["required", "confirmed", Password::defaults()]]);
        $user = User::create(["name" => $request->name, "email" => $request->email, "password" => Hash::make($request->password), "role" => "customer"]);
        Auth::login($user);
        $this->otpService->generate($user);
        return redirect()->route("verification.otp");
    }
}