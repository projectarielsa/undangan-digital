<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Invitation;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function index(Request $request)
    {
        $query = Invitation::with(["user","template"]);
        if ($s = $request->input("status")) $query->where("status", $s);
        if ($q = $request->input("search")) $query->where(fn($qr) => $qr->where("title","like","%$q%")->orWhere("groom_name","like","%$q%"));
        return view("admin.invitations.index", ["invitations" => $query->latest()->paginate(20)]);
    }
    public function show(Invitation $invitation) { $invitation->load(["user","template","guests","guestbooks","galleries"]); return view("admin.invitations.show", compact("invitation")); }
    public function destroy(Invitation $invitation) { $invitation->delete(); return redirect()->route("admin.invitations.index")->with("success", "Dihapus."); }
}