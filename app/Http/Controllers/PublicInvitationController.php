<?php
namespace App\Http\Controllers;
use App\Models\Invitation;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class PublicInvitationController extends Controller
{
    public function __construct(protected AnalyticsService $analytics) {}

    public function show(string $slug, Request $request)
    {
        $invitation = Invitation::where("slug", $slug)->with(["template","galleries","guestbooks" => fn($q) => $q->approved()->latest()->take(50)])->firstOrFail();
        if (!$invitation->isPublished()) abort(404);
        $invitation->incrementView();
        
        $guestName = $request->query("to");
        $guest = null;
        $guestId = null;
        if ($guestName) { 
            $guest = $invitation->guests()->where("name", urldecode($guestName))->first(); 
            $guest?->markAsOpened(); 
            $guestId = $guest?->id;
        }
        
        // Log visitor for analytics
        $this->analytics->logVisitor($invitation, $request, $guestId, 'main');
        
        $bladeView = $invitation->template ? $invitation->template->blade_view : "templates.elegant-gold";
        return view($bladeView, compact("invitation","guest","guestName"));
    }
    public function rsvp(Request $request, string $slug)
    {
        $invitation = Invitation::where("slug", $slug)->firstOrFail();
        $v = $request->validate(["name"=>"required|string|max:255","rsvp_status"=>"required|in:attending,not_attending,maybe","number_of_guests"=>"nullable|integer|min:1|max:10","message"=>"nullable|string|max:500"]);
        $guest = $invitation->guests()->where("name", $v["name"])->first();
        if ($guest) $guest->update(["rsvp_status"=>$v["rsvp_status"],"number_of_guests"=>$v["number_of_guests"]??1]);
        else $guest = $invitation->guests()->create($v);
        
        // Log RSVP action for analytics
        $this->analytics->logVisitor($invitation, $request, $guest->id, 'rsvp');
        
        return back()->with("success", "Terima kasih!");
    }
    public function guestbook(Request $request, string $slug)
    {
        $invitation = Invitation::where("slug", $slug)->firstOrFail();
        $key = "guestbook:" . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) return back()->withErrors(["message"=>"Terlalu banyak ucapan."]);
        $v = $request->validate(["name"=>"required|string|max:255","message"=>"required|string|max:1000"]);
        $invitation->guestbooks()->create(["name"=>$v["name"],"message"=>$v["message"],"is_approved"=>true,"ip_address"=>$request->ip()]);
        RateLimiter::hit($key, 60);
        
        // Log guestbook action for analytics
        $this->analytics->logVisitor($invitation, $request, null, 'guestbook');
        
        return back()->with("success", "Ucapan berhasil dikirim!");
    }
}