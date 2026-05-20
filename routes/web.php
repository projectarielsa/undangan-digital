<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\InvitationController as AdminInvitation;
use App\Http\Controllers\Admin\PaymentController as AdminPayment;
use App\Http\Controllers\Admin\SupportTicketController as AdminSupportController;
use App\Http\Controllers\Admin\TemplateController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OtpVerificationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Customer\AnalyticsController;
use App\Http\Controllers\Customer\CustomDomainController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\GalleryController;
use App\Http\Controllers\Customer\GuestController;
use App\Http\Controllers\Customer\InvitationController;
use App\Http\Controllers\Customer\LoveStoryController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Customer\QrCheckinController;
use App\Http\Controllers\Customer\SupportTicketController;
use App\Http\Controllers\HealthCheckController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\PublicInvitationController;
use App\Http\Controllers\QrVerifyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Health Check Routes
|--------------------------------------------------------------------------
*/
Route::get('/health', [HealthCheckController::class, 'status'])->name('health');
Route::get('/ping', [HealthCheckController::class, 'ping'])->name('ping');

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get("/", [LandingPageController::class, "index"])->name("home");
Route::middleware("guest")->group(function () {
    Route::get("/login", [LoginController::class, "showLoginForm"])->name("login");
    Route::post("/login", [LoginController::class, "login"]);
    Route::get("/register", [RegisterController::class, "showRegistrationForm"])->name("register");
    Route::post("/register", [RegisterController::class, "register"]);
    Route::get("/forgot-password", [ForgotPasswordController::class, "showLinkRequestForm"])->name("password.request");
    Route::post("/forgot-password", [ForgotPasswordController::class, "sendResetLinkEmail"])->name("password.email");
    Route::get("/reset-password/{token}", [ForgotPasswordController::class, "showResetForm"])->name("password.reset");
    Route::post("/reset-password", [ForgotPasswordController::class, "reset"])->name("password.update");
    Route::get("/auth/google/redirect", [GoogleAuthController::class, "redirect"])->name("auth.google");
    Route::get("/auth/google/callback", [GoogleAuthController::class, "callback"]);
});
Route::middleware("auth")->group(function () {
    Route::post("/logout", [LoginController::class, "logout"])->name("logout");
    Route::get("/verify-otp", [OtpVerificationController::class, "show"])->name("verification.otp");
    Route::post("/verify-otp", [OtpVerificationController::class, "verify"])->name("verification.otp.verify");
    Route::post("/resend-otp", [OtpVerificationController::class, "resend"])->name("verification.otp.resend");
    Route::middleware(["verified.email","role:customer"])->prefix("customer")->name("customer.")->group(function () {
        Route::get("/dashboard", [DashboardController::class, "index"])->name("dashboard");
        Route::resource("invitations", InvitationController::class);
        Route::post("/invitations/{invitation}/publish", [InvitationController::class, "publish"])->name("invitations.publish");
        Route::post("/invitations/{invitation}/pause", [InvitationController::class, "pause"])->name("invitations.pause");
        Route::post("/invitations/{invitation}/duplicate", [InvitationController::class, "duplicate"])->name("invitations.duplicate");
        Route::get("/invitations/{invitation}/guests", [GuestController::class, "index"])->name("guests.index");
        Route::post("/invitations/{invitation}/guests", [GuestController::class, "store"])->name("guests.store");
        Route::delete("/invitations/{invitation}/guests/{guest}", [GuestController::class, "destroy"])->name("guests.destroy");
        Route::post("/invitations/{invitation}/guests/import", [GuestController::class, "import"])->name("guests.import");
        Route::post("/invitations/{invitation}/gallery", [GalleryController::class, "store"])->name("gallery.store");
        Route::put("/invitations/{invitation}/gallery/order", [GalleryController::class, "updateOrder"])->name("gallery.order");
        Route::delete("/invitations/{invitation}/gallery/{gallery}", [GalleryController::class, "destroy"])->name("gallery.destroy");
        Route::get("/packages", [PaymentController::class, "packages"])->name("packages");
        Route::post("/checkout/{package}", [PaymentController::class, "checkout"])->name("checkout");
        Route::get("/payments/finish", [PaymentController::class, "finish"])->name("payments.finish");
        Route::get("/payments/history", [PaymentController::class, "history"])->name("payments.history");
        
        // Love Story
        Route::get("/invitations/{invitation}/love-story", [LoveStoryController::class, "edit"])->name("invitations.love-story");
        Route::put("/invitations/{invitation}/love-story", [LoveStoryController::class, "update"])->name("invitations.love-story.update");
        Route::delete("/invitations/{invitation}/love-story/{index}", [LoveStoryController::class, "deleteEntry"])->name("invitations.love-story.delete");
        
        // Analytics
        Route::get("/invitations/{invitation}/analytics", [AnalyticsController::class, "show"])->name("invitations.analytics");
        Route::get("/invitations/{invitation}/analytics/api", [AnalyticsController::class, "apiStats"])->name("invitations.analytics.api");
        
        // QR Check-in
        Route::get("/invitations/{invitation}/qr-checkin", [QrCheckinController::class, "index"])->name("invitations.qr-checkin");
        Route::post("/invitations/{invitation}/qr-checkin/generate-all", [QrCheckinController::class, "generateAll"])->name("invitations.qr-checkin.generate-all");
        Route::post("/invitations/{invitation}/qr-checkin/{guest}/generate", [QrCheckinController::class, "generateSingle"])->name("invitations.qr-checkin.generate");
        Route::get("/invitations/{invitation}/qr-checkin/{guest}/print", [QrCheckinController::class, "showQrCode"])->name("invitations.qr-checkin.print");
        Route::get("/invitations/{invitation}/qr-checkin/scanner", [QrCheckinController::class, "scanner"])->name("invitations.qr-checkin.scanner");
        Route::post("/invitations/{invitation}/qr-checkin/{guest}/manual", [QrCheckinController::class, "manualCheckin"])->name("invitations.qr-checkin.manual");
        Route::post("/invitations/{invitation}/qr-checkin/{guest}/undo", [QrCheckinController::class, "undoCheckin"])->name("invitations.qr-checkin.undo");
        
        // Custom Domain
        Route::get("/invitations/{invitation}/custom-domain", [CustomDomainController::class, "show"])->name("invitations.custom-domain");
        Route::post("/invitations/{invitation}/custom-domain", [CustomDomainController::class, "store"])->name("invitations.custom-domain.store");
        Route::post("/invitations/{invitation}/custom-domain/verify", [CustomDomainController::class, "verify"])->name("invitations.custom-domain.verify");
        Route::delete("/invitations/{invitation}/custom-domain", [CustomDomainController::class, "destroy"])->name("invitations.custom-domain.destroy");
        
        // Support Tickets (Priority Support)
        Route::get("/support", [SupportTicketController::class, "index"])->name("support.index");
        Route::get("/support/create", [SupportTicketController::class, "create"])->name("support.create");
        Route::post("/support", [SupportTicketController::class, "store"])->name("support.store");
        Route::get("/support/{ticket}", [SupportTicketController::class, "show"])->name("support.show");
        Route::post("/support/{ticket}/reply", [SupportTicketController::class, "reply"])->name("support.reply");
        Route::post("/support/{ticket}/close", [SupportTicketController::class, "close"])->name("support.close");
        Route::post("/support/{ticket}/reopen", [SupportTicketController::class, "reopen"])->name("support.reopen");
    });
    Route::middleware(["verified.email","role:super_admin"])->prefix("admin")->name("admin.")->group(function () {
        Route::get("/dashboard", [AdminDashboard::class, "index"])->name("dashboard");
        Route::get("/users", [UserController::class, "index"])->name("users.index");
        Route::get("/users/{user}", [UserController::class, "show"])->name("users.show");
        Route::post("/users/{user}/toggle-active", [UserController::class, "toggleActive"])->name("users.toggle");
        Route::post("/users/{user}/subscription", [UserController::class, "addSubscription"])->name("users.subscription.add");
        Route::post("/subscriptions/{subscription}/cancel", [UserController::class, "cancelSubscription"])->name("subscriptions.cancel");
        Route::post("/subscriptions/{subscription}/extend", [UserController::class, "extendSubscription"])->name("subscriptions.extend");
        Route::get("/invitations", [AdminInvitation::class, "index"])->name("invitations.index");
        Route::get("/invitations/{invitation}", [AdminInvitation::class, "show"])->name("invitations.show");
        Route::delete("/invitations/{invitation}", [AdminInvitation::class, "destroy"])->name("invitations.destroy");
        Route::resource("templates", TemplateController::class);
        Route::get("/payments", [AdminPayment::class, "index"])->name("payments.index");
        Route::get("/payments/{payment}", [AdminPayment::class, "show"])->name("payments.show");
        
        // Admin Support Tickets
        Route::get("/support", [AdminSupportController::class, "index"])->name("support.index");
        Route::get("/support/{ticket}", [AdminSupportController::class, "show"])->name("support.show");
        Route::post("/support/{ticket}/reply", [AdminSupportController::class, "reply"])->name("support.reply");
        Route::put("/support/{ticket}/status", [AdminSupportController::class, "updateStatus"])->name("support.status");
        Route::put("/support/{ticket}/priority", [AdminSupportController::class, "updatePriority"])->name("support.priority");
    });
});
Route::post("/webhook/midtrans", [MidtransWebhookController::class, "handle"])
    ->middleware('throttle:webhook')
    ->name("midtrans.webhook");

// QR Check-in verification (public)
Route::get("/checkin/verify/{code}", [QrVerifyController::class, "verify"])->name("checkin.verify");
Route::post("/api/checkin/verify", [QrVerifyController::class, "apiVerify"])->name("api.checkin.verify");

Route::get("/{slug}", [PublicInvitationController::class, "show"])
    ->middleware('throttle:invitation-view')
    ->name("invitation.show");
Route::post("/{slug}/rsvp", [PublicInvitationController::class, "rsvp"])
    ->middleware('throttle:rsvp')
    ->name("invitation.rsvp");
Route::post("/{slug}/guestbook", [PublicInvitationController::class, "guestbook"])
    ->middleware('throttle:rsvp')
    ->name("invitation.guestbook");
