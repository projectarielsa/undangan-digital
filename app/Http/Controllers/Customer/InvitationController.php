<?php
namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\InvitationTemplate;
use App\Services\InvitationService;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function __construct(protected InvitationService $service) {}
    public function index(Request $request) { $invitations = $request->user()->invitations()->with("template")->latest()->paginate(10); return view("customer.invitations.index", compact("invitations")); }
    public function create() { $templates = InvitationTemplate::active()->orderBy("sort_order")->get(); return view("customer.invitations.create", compact("templates")); }
    public function store(Request $request)
    {
        $v = $request->validate([
            "template_id"=>"required|exists:invitation_templates,id",
            "groom_name"=>"required|string|max:255","bride_name"=>"required|string|max:255",
            "groom_father"=>"nullable|string","groom_mother"=>"nullable|string",
            "bride_father"=>"nullable|string","bride_mother"=>"nullable|string",
            "groom_instagram"=>"nullable|string","bride_instagram"=>"nullable|string",
            "event_date"=>"required|date|after:today","event_time_start"=>"required","event_time_end"=>"nullable",
            "event_venue"=>"required|string|max:255","event_address"=>"nullable|string","event_maps_url"=>"nullable|url",
            "opening_text"=>"nullable|string","closing_text"=>"nullable|string","dress_code"=>"nullable|string",
            "cover_image"=>"nullable|image|max:5120","groom_photo"=>"nullable|image|max:2048","bride_photo"=>"nullable|image|max:2048",
            "music_file"=>"nullable|file|mimes:mp3,wav|max:10240","music_autoplay"=>"nullable",
            "gift_info"=>"nullable|string","bank_name"=>"nullable|string|max:100",
            "bank_account_number"=>"nullable|string|max:50","bank_account_name"=>"nullable|string|max:100",
            "qris_image"=>"nullable|image|max:2048",
        ]);

        // Validate premium template access
        $template = InvitationTemplate::findOrFail($v['template_id']);
        if ($template->is_premium) {
            $activePackage = $request->user()->activeSubscription()?->package;
            if (!$activePackage || $activePackage->max_templates < 2) {
                return back()->withErrors(['template_id' => 'Template premium memerlukan paket Premium atau Exclusive. Silakan upgrade paket Anda.'])->withInput();
            }
        }

        $v["title"] = $v["groom_name"] . " & " . $v["bride_name"];
        $v["music_autoplay"] = $request->has("music_autoplay");

        // Auto-assign package from active subscription
        $activeSub = $request->user()->activeSubscription();
        if ($activeSub) {
            $v['package_id'] = $activeSub->package_id;
        }

        $inv = $this->service->create($request->user(), $v);
        return redirect()->route("customer.invitations.edit", $inv)->with("success", "Undangan berhasil dibuat!");
    }
    public function show(Invitation $invitation) { $this->authorize("view", $invitation); $invitation->load(["template","galleries","guests","guestbooks"]); return view("customer.invitations.show", ["invitation"=>$invitation,"rsvpStats"=>$invitation->getRsvpStats(),"limits"=>$this->service->getFeatureLimits($invitation)]); }
    public function edit(Invitation $invitation) { $this->authorize("update", $invitation); $templates = InvitationTemplate::active()->orderBy("sort_order")->get(); return view("customer.invitations.edit", compact("invitation","templates")); }
    public function update(Request $request, Invitation $invitation)
    {
        $this->authorize("update", $invitation);
        $v = $request->validate([
            "template_id"=>"sometimes|exists:invitation_templates,id",
            "groom_name"=>"sometimes|string|max:255","bride_name"=>"sometimes|string|max:255",
            "groom_father"=>"nullable|string","groom_mother"=>"nullable|string",
            "bride_father"=>"nullable|string","bride_mother"=>"nullable|string",
            "groom_instagram"=>"nullable|string","bride_instagram"=>"nullable|string",
            "event_date"=>"sometimes|date","event_time_start"=>"sometimes","event_time_end"=>"nullable",
            "event_venue"=>"sometimes|string|max:255","event_address"=>"nullable|string","event_maps_url"=>"nullable|url",
            "opening_text"=>"nullable|string","closing_text"=>"nullable|string","dress_code"=>"nullable|string",
            "slug"=>"nullable|string|max:255|unique:invitations,slug,".$invitation->id,
            "cover_image"=>"nullable|image|max:5120","groom_photo"=>"nullable|image|max:2048","bride_photo"=>"nullable|image|max:2048",
            "music_file"=>"nullable|file|mimes:mp3,wav|max:10240","music_autoplay"=>"nullable",
            "gift_info"=>"nullable|string","bank_name"=>"nullable|string|max:100",
            "bank_account_number"=>"nullable|string|max:50","bank_account_name"=>"nullable|string|max:100",
            "qris_image"=>"nullable|image|max:2048",
        ]);
        if (isset($v["groom_name"]) && isset($v["bride_name"])) $v["title"] = $v["groom_name"] . " & " . $v["bride_name"];
        $v["music_autoplay"] = $request->has("music_autoplay");
        $this->service->update($invitation, $v);
        return redirect()->route("customer.invitations.edit", $invitation)->with("success", "Undangan diperbarui!");
    }
    public function destroy(Invitation $invitation) { $this->authorize("delete", $invitation); $this->service->delete($invitation); return redirect()->route("customer.invitations.index")->with("success", "Undangan dihapus."); }
    public function publish(Invitation $invitation) { $this->authorize("update", $invitation); $invitation->publish(); return back()->with("success", "Dipublikasikan!"); }
    public function pause(Invitation $invitation) { $this->authorize("update", $invitation); $invitation->pause(); return back()->with("success", "Dijeda."); }
    public function duplicate(Invitation $invitation) { $this->authorize("view", $invitation); $new = $this->service->duplicate($invitation); return redirect()->route("customer.invitations.edit", $new)->with("success", "Diduplikasi!"); }
}