<?php
namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\Invitation;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index(Invitation $invitation) { $this->authorize("view", $invitation); $guests = $invitation->guests()->latest()->paginate(20); return view("customer.guests.index", ["invitation"=>$invitation,"guests"=>$guests,"rsvpStats"=>$invitation->getRsvpStats()]); }
    public function store(Request $request, Invitation $invitation) { $this->authorize("update", $invitation); $v = $request->validate(["name"=>"required|string|max:255","phone"=>"nullable|string|max:20","email"=>"nullable|email"]); $invitation->guests()->create($v); return back()->with("success", "Tamu ditambahkan."); }
    public function destroy(Invitation $invitation, Guest $guest) { $this->authorize("update", $invitation); $guest->delete(); return back()->with("success", "Tamu dihapus."); }
    public function import(Request $request, Invitation $invitation)
    {
        $this->authorize("update", $invitation);
        $request->validate(["file" => "required|file|mimes:xlsx,xls,csv|max:5120"]);
        $file = $request->file("file"); $imported = 0;
        if (in_array($file->getClientOriginalExtension(), ["csv","txt"])) {
            $h = fopen($file->getPathname(), "r"); fgetcsv($h);
            while (($row = fgetcsv($h)) !== false) { if (!empty($row[0])) { $invitation->guests()->create(["name"=>$row[0],"phone"=>$row[1]??null,"email"=>$row[2]??null]); $imported++; } }
            fclose($h);
        }
        return back()->with("success", "Berhasil import $imported tamu.");
    }
}